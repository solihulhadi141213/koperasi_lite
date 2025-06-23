<?php
    // Koneksi
    include "../../_Config/Connection.php";
    include "../../_Config/GlobalFunction.php";
    include "../../_Config/Session.php";

    // Time Zone
    date_default_timezone_set('Asia/Jakarta');

    // Time Now Tmp
    $now = date('Y-m-d H:i:s');

    // Inisialisasi respons default
    $response = [
        "status" => "Error",
        "message" => "Belum ada proses yang dilakukan pada sistem."
    ];

    //Validasi Akses
    if(empty($SessionIdAkses)){
        $response = [
            "status" => "Error",
            "message" => "Sesi Akses Sudah Berakhir! Silahkan Login Ulang!"
        ];
    }else{
        // Validasi Data Tidak Boleh Kosong
        $requiredFields = [
            'id_transaksi_jual_beli'    => "ID Transaksi Penjualan Tidak Boleh Kosong!",
            'tanggal'                   => "Tanggal Pembayaran Tidak Boleh Kosong!",
            'jam'                       => "Jam Pembayaran Tidak Boleh Kosong!",
            'kategori'                  => "Kategori Transaksi Tidak Boleh Kosong!",
            'jumlah'                    => "Jumlah/Nominal Pembayaran Tidak Boleh Kosong!",
        ];

        foreach ($requiredFields as $field => $errorMessage) {
            if (empty($_POST[$field])) {
                echo json_encode([
                    "status" => "Error",
                    "message" => $errorMessage
                ]);
                exit;
            }
        }

        // Buat Variabel
        $id_transaksi_jual_beli = validateAndSanitizeInput($_POST['id_transaksi_jual_beli']);
        $tanggal = validateAndSanitizeInput($_POST['tanggal']);
        $jam = validateAndSanitizeInput($_POST['jam']);
        $kategori = validateAndSanitizeInput($_POST['kategori']);
        $jumlah = validateAndSanitizeInput($_POST['jumlah']);

        // Format nominal
        $jumlah = str_replace('.', '', $jumlah);
        $tanggal_jam="$tanggal $jam";

        // Optional input
        $id_anggota = empty($_POST['id_anggota']) ? 0 : validateAndSanitizeInput($_POST['id_anggota']);

        $status=GetDetailData($Conn, 'transaksi_jual_beli', 'id_transaksi_jual_beli', $id_transaksi_jual_beli, 'status');
        if(empty($status)){
            $response["message"] = "ID Transaksi Tidak Ditemukan Pada Database!";
        }elseif($status=="Lunas"){
            $response["message"] = "Transaksi Tersebut Sudah Lunas! Anda tidak perlu melakukan pembayaran untuk transaksi tersebut";
        }else{
            $validasi_id_transaksi_jual_beli=GetDetailData($Conn, 'transaksi_jual_beli', 'id_transaksi_jual_beli', $id_transaksi_jual_beli, 'id_transaksi_jual_beli');
            if(empty($validasi_id_transaksi_jual_beli)){
                $response["message"] = "ID Transaksi Tidak Ditemukan Pada Database";
            }else{
                // Ambil data tagihan
                $total_tagihan=GetDetailData($Conn, 'transaksi_jual_beli', 'id_transaksi_jual_beli', $id_transaksi_jual_beli, 'total');
                $cash=GetDetailData($Conn, 'transaksi_jual_beli', 'id_transaksi_jual_beli', $id_transaksi_jual_beli, 'cash');
                $sql_angsuran = "SELECT SUM(jumlah) as total_jumlah FROM transaksi_pembayaran WHERE id_transaksi_jual_beli='$id_transaksi_jual_beli'";
                $result_angsuran = $Conn->query($sql_angsuran);
                $total_angsuran = ($result_angsuran && $result_angsuran->num_rows > 0) ? $result_angsuran->fetch_assoc()["total_jumlah"] : 0;
                $sisa_tunggakan = $total_tagihan - ($cash + $total_angsuran);

                if($sisa_tunggakan < $jumlah){
                    $response["message"] = "Nominal pembayaran tidak boleh lebih dari sisa piutang : $sisa_tunggakan";
                }else{
                    $kategori_pembayaran = ($kategori == "Penjualan") ? "Pembayaran Piutang Penjualan" : (($kategori == "Pembelian") ? "Pembayaran Piutang Pembelian" : $kategori);

                    // === MULAI TRANSAKSI ===
                    $Conn->begin_transaction();

                    try {
                        // 1. INSERT transaksi_pembayaran
                        $id_transaksi_pembayaran=generateRandomString(36);
                        $entry_pembayaran = "INSERT INTO transaksi_pembayaran (
                            id_transaksi_pembayaran,
                            id_transaksi_jual_beli,
                            kategori,
                            tanggal,
                            jumlah,
                            datetime_creat
                        ) VALUES (
                            '$id_transaksi_pembayaran',
                            '$id_transaksi_jual_beli',
                            '$kategori',
                            '$tanggal_jam',
                            '$jumlah',
                            '$now'
                        )";
                        if (!mysqli_query($Conn, $entry_pembayaran)) {
                            throw new Exception("Gagal insert transaksi pembayaran");
                        }

                        // 2. UPDATE status transaksi jika lunas
                        if ($sisa_tunggakan <= $jumlah) {
                            $update = mysqli_query($Conn, "UPDATE transaksi_jual_beli SET status='Lunas' WHERE id_transaksi_jual_beli='$id_transaksi_jual_beli'");
                            if (!$update) {
                                throw new Exception("Gagal update status transaksi ke Lunas");
                            }
                        }

                        // 3. Insert jurnal debet
                        $akun_debet = GetDetailData($Conn, 'setting_autojurnal_jual_beli', 'kategori', $kategori, 'debet');
                        $akun_utang_piutang = GetDetailData($Conn, 'setting_autojurnal_jual_beli', 'kategori', $kategori, 'utang_piutang');
                        $d_k = "D";
                        $index_colum = "id_transaksi_jual_beli";
                        $insert_jurnal_debet = InsertParsialJournalPembayaran($Conn, $kategori, $id_transaksi_jual_beli, $id_transaksi_pembayaran, $tanggal, $akun_debet, $d_k, $jumlah);
                        if ($insert_jurnal_debet != "Success") {
                            throw new Exception("Gagal insert jurnal debet");
                        }

                        // 4. Insert jurnal kredit
                        $d_k = "K";
                        $insert_jurnal_kredit = InsertParsialJournalPembayaran($Conn, $kategori, $id_transaksi_jual_beli, $id_transaksi_pembayaran, $tanggal, $akun_utang_piutang, $d_k, $jumlah);
                        if ($insert_jurnal_kredit != "Success") {
                            throw new Exception("Gagal insert jurnal kredit");
                        }

                        // 5. Simpan log
                        $kategori_log = "Utang Piutang";
                        $deskripsi_log = "Pembayaran Utang Piutang";
                        $InputLog = addLog($Conn, $SessionIdAkses, $now, $kategori_log, $deskripsi_log);
                        if ($InputLog != "Success") {
                            throw new Exception("Gagal simpan log");
                        }

                        // Semua berhasil
                        $Conn->commit();
                        $response = [
                            "status" => "Success",
                            "message" => "Pembayaran Utang Piutang Berhasil"
                        ];

                    } catch (Exception $e) {
                        // Rollback jika error
                        $Conn->rollback();
                        $response = [
                            "status" => "Error",
                            "message" => "Transaksi dibatalkan: " . $e->getMessage()
                        ];
                    }
                }
            }
        }
    }

    // Output response
    echo json_encode($response);
?>

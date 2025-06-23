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
            'id_transaksi_pembayaran'    => "ID Transaksi Pembayaran Tidak Boleh Kosong!",
            'tanggal'                   => "Tanggal Pembayaran Tidak Boleh Kosong!",
            'jam'                       => "Jam Pembayaran Tidak Boleh Kosong!",
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
        $id_transaksi_pembayaran = validateAndSanitizeInput($_POST['id_transaksi_pembayaran']);
        $tanggal = validateAndSanitizeInput($_POST['tanggal']);
        $jam = validateAndSanitizeInput($_POST['jam']);
        $jumlah = validateAndSanitizeInput($_POST['jumlah']);

        // Hapus Tanda Titik pada variabel jumlah
        $jumlah = str_replace('.', '', $jumlah);

        //Format tanggal dan jam
        $tanggal_jam="$tanggal $jam";

        // Buka id_transaksi_jual_beli
        $id_transaksi_jual_beli =GetDetailData($Conn, 'transaksi_pembayaran', 'id_transaksi_pembayaran', $id_transaksi_pembayaran, 'id_transaksi_jual_beli');

        //Buka Tanggal Lama
        $tanggal_lama= GetDetailData($Conn, 'transaksi_pembayaran', 'id_transaksi_pembayaran', $id_transaksi_pembayaran, 'tanggal');

        //Buka Jumlah Lmaa
        $jumlah_lama= GetDetailData($Conn, 'transaksi_pembayaran', 'id_transaksi_pembayaran', $id_transaksi_pembayaran, 'jumlah');

        //Buka Kategori transaksi
        $kategori= GetDetailData($Conn, 'transaksi_jual_beli', 'id_transaksi_jual_beli', $id_transaksi_jual_beli, 'kategori');

        //Validasi ID Transaksi
        if(empty($id_transaksi_jual_beli)){
            $response["message"] = "ID Transaksi Tidak Ditemukan Pada Database!";
        }else{
            
            //Validasi Pembayaran
            $total_tagihan=GetDetailData($Conn, 'transaksi_jual_beli', 'id_transaksi_jual_beli', $id_transaksi_jual_beli, 'total');
            $cash=GetDetailData($Conn, 'transaksi_jual_beli', 'id_transaksi_jual_beli', $id_transaksi_jual_beli, 'cash');
            $sql_angsuran = "SELECT SUM(jumlah) as total_jumlah FROM transaksi_pembayaran WHERE id_transaksi_jual_beli='$id_transaksi_jual_beli'";
            $result_angsuran = $Conn->query($sql_angsuran);
            $total_angsuran = ($result_angsuran && $result_angsuran->num_rows > 0) ? $result_angsuran->fetch_assoc()["total_jumlah"] : 0;
            $total_angsuran_baru=$total_angsuran-$jumlah_lama;
            $sisa_tunggakan = $total_tagihan - ($cash + $total_angsuran_baru);

            //Apabila pembayaran sekarang Lebih
            if($sisa_tunggakan < $jumlah){
                $response["message"] = "Nominal pembayaran tidak boleh lebih dari sisa utang/piutang : $sisa_tunggakan";
            }else{
                //Update Transaksi Pembayaran
                $stmt = mysqli_prepare($Conn, "UPDATE transaksi_pembayaran SET 
                    tanggal=?, 
                    jumlah=?
                WHERE id_transaksi_pembayaran=?");
                mysqli_stmt_bind_param($stmt, "sss", 
                    $tanggal_jam, 
                    $jumlah, 
                    $id_transaksi_pembayaran
                );
                $update_pembayaran = mysqli_stmt_execute($stmt);
                if ($update_pembayaran) {
                    
                    //Update Jurnal
                    $stmt_jurnal = mysqli_prepare($Conn, "UPDATE jurnal SET 
                        tanggal=?, 
                        nilai=?
                    WHERE id_transaksi_pembayaran=?");
                    mysqli_stmt_bind_param($stmt_jurnal, "sss", 
                        $tanggal, 
                        $jumlah, 
                        $id_transaksi_pembayaran
                    );
                    $update_jurnal = mysqli_stmt_execute($stmt_jurnal);
                    if ($update_jurnal) {

                        //Hitung Ulang Selisih Pembayaran Dan Utang/piutang
                        $total_tagihan=GetDetailData($Conn, 'transaksi_jual_beli', 'id_transaksi_jual_beli', $id_transaksi_jual_beli, 'total');
                        $cash=GetDetailData($Conn, 'transaksi_jual_beli', 'id_transaksi_jual_beli', $id_transaksi_jual_beli, 'cash');
                        $sql_angsuran = "SELECT SUM(jumlah) as total_jumlah FROM transaksi_pembayaran WHERE id_transaksi_jual_beli='$id_transaksi_jual_beli'";
                        $result_angsuran = $Conn->query($sql_angsuran);
                        $total_angsuran = ($result_angsuran && $result_angsuran->num_rows > 0) ? $result_angsuran->fetch_assoc()["total_jumlah"] : 0;
                        $sisa_tunggakan = $total_tagihan - ($cash + $total_angsuran);
                        //Apabila sisa tunggakan tidak sama dengan nol
                        if($sisa_tunggakan!=0){
                            $status = "Kredit";
                        }else{
                            $status="Lunas";
                        }
                        //Update Transaksi
                        $stmt_transaksi = mysqli_prepare($Conn, "UPDATE transaksi_jual_beli  SET 
                            status=?
                        WHERE id_transaksi_jual_beli=?");
                        mysqli_stmt_bind_param($stmt_transaksi, "ss", 
                            $status,
                            $id_transaksi_jual_beli
                        );
                        $update_transaksi = mysqli_stmt_execute($stmt_transaksi);
                        if ($update_transaksi) {

                            // 5. Simpan log
                            $kategori_log = "Utang Piutang";
                            $deskripsi_log = "Edit Pembayaran Utang Piutang";
                            $InputLog = addLog($Conn, $SessionIdAkses, $now, $kategori_log, $deskripsi_log);
                            if ($InputLog != "Success") {
                                 $response = [
                                    "status" => "Error",
                                    "message" => "Terjadi Kesalahan Pada Saat Menyimpan Log"
                                ];
                            }else{
                                $response = [
                                    "status" => "Success",
                                    "message" => "Pembayaran Utang Piutang Berhasil"
                                ];
                            }
                           
                        }else{
                             echo json_encode([
                                "status" => "Error",
                                "message" => "Terjadi kesalahan pada saat update transaksi jual beli"
                            ]);
                            exit; 
                        }
                    }else{
                    echo json_encode([
                            "status" => "Error",
                            "message" => "Terjadi kesalahan pada saat update jurnal pembayaran"
                        ]);
                        exit; 
                    }
                }else{
                    echo json_encode([
                        "status" => "Error",
                        "message" => "Terjadi kesalahan pada saat update transaksi pembayaran"
                    ]);
                    exit;
                }
            }
        }
    }

    // Output response
    echo json_encode($response);
?>

<?php
     // Koneksi
    include "../../_Config/Connection.php";
    include "../../_Config/GlobalFunction.php";
    include "../../_Config/Session.php";

    // Time Zone
    date_default_timezone_set('Asia/Jakarta');

    // Time Now Tmp
    $now = date('Y-m-d H:i:s');
    $jumlah_total=0;
    
    //Validasi Akses
    if(empty($SessionIdAkses)){
        echo '
            <tr>
                <td colspan="6" class="text-center">
                    <small class="text-danger">Sesi Akses Sudah Berakhir! Silahkan login ulang.</small>
                </td>
            </tr>
        ';
    }else{
        if(empty($_POST['id_transaksi_jual_beli'])){
            echo '
                <tr>
                    <td colspan="6" class="text-center">
                        <small class="text-danger">Tidak ada data yang dipilih!</small>
                    </td>
                </tr>
            ';
        }else{
            if(empty($_POST['tanggal'])){
                echo '
                    <tr>
                        <td colspan="6" class="text-center">
                            <small class="text-danger">Tanggal Pembayaran Tidak Boleh Kosong!</small>
                        </td>
                    </tr>
                ';
            }else{
                if(empty($_POST['jam'])){
                    echo '
                        <tr>
                            <td colspan="6" class="text-center">
                                <small class="text-danger">Jam Pembayaran Tidak Boleh Kosong!</small>
                            </td>
                        </tr>
                    ';
                }else{
                    //Buat Variabel
                    $id_transaksi_jual_beli=$_POST['id_transaksi_jual_beli'];
                    $tanggal_bayar=$_POST['tanggal'];
                    $jam_bayar=$_POST['jam'];
                    $tanggal_jam_bayar="$tanggal_bayar $jam_bayar";
                    //Tampilkan Dengan Looping
                    $no=1;
                    foreach ($id_transaksi_jual_beli as $id_transaksi_jual_beli_list) {
                        //Buka Detail Transaksi Berdasarkan id_transaksi_jual_beli_list
                        $Qry = $Conn->prepare("SELECT * FROM transaksi_jual_beli WHERE id_transaksi_jual_beli = ?");
                        $Qry->bind_param("s", $id_transaksi_jual_beli_list);
                        if (!$Qry->execute()) {
                            echo '
                                <tr>
                                    <td colspan="6" class="text-left">
                                        <small class="text-danger">Terjadi kesalahan pada saat membuka data transaksi. Error: '.$Conn->error.'</small>
                                    </td>
                                </tr>
                            ';
                        } else {
                            $Result = $Qry->get_result();
                            $Data = $Result->fetch_assoc();
                            $Qry->close();

                            if (!$Data) {
                                echo '
                                    <tr>
                                        <td colspan="6" class="text-left">
                                            <small class="text-danger">ID Transaksi <b>'.$id_transaksi_jual_beli_list.'</b> Tidak Ditemukan</small>
                                        </td>
                                    </tr>
                                ';
                            } else {
                                // Ambil Data Transaksi
                                $id_transaksi_jual_beli = $Data['id_transaksi_jual_beli'];
                                $id_anggota = $Data['id_anggota'];
                                $kategori = $Data['kategori'];
                                $tanggal = $Data['tanggal'];
                                $total = pembulatan_nilai($Data['total']);
                                $cash = pembulatan_nilai($Data['cash']);

                                //Hitung Jumlah Pembayaran
                                $sql_angsuran = "SELECT SUM(jumlah) as total_jumlah FROM  transaksi_pembayaran  WHERE id_transaksi_jual_beli='$id_transaksi_jual_beli'";
                                $result_angsuran = $Conn->query($sql_angsuran);
                                if ($result_angsuran->num_rows > 0) {
                                    // Ambil hasil
                                    $row_angsuran = $result_angsuran->fetch_assoc();
                                    $total_angsuran = $row_angsuran["total_jumlah"];
                                } else {
                                    $total_angsuran=0;
                                }
                                $total_angsuran_rp = "Rp " . number_format($total_angsuran,0,',','.');

                                //Hitung Sisa/Selisish
                                $sisa_pembayaran=$total-$cash-$total_angsuran;
                                $sisa_pembayaran_rp = "Rp " . number_format($sisa_pembayaran,0,',','.');
                                
                                //Buka Data Anggota
                                if(empty($id_anggota)){
                                    $nama_anggota='<i class="text-danger">-</i>';
                                }else{
                                    $nama_anggota=GetDetailData($Conn, 'anggota', 'id_anggota', $id_anggota, 'nama');
                                    $nama_anggota='<i class="text-dark">'.$nama_anggota.'</i>';
                                }
                                $jumlah_total=$jumlah_total+$sisa_pembayaran;

                                //Format Nominal
                                $jumlah_rp = "Rp " . number_format($sisa_pembayaran,0,',','.');

                                //Melakukan Proses Pembayaran
                                $validasi_id_transaksi_jual_beli=GetDetailData($Conn, 'transaksi_jual_beli', 'id_transaksi_jual_beli', $id_transaksi_jual_beli, 'id_transaksi_jual_beli');
                                if(empty($validasi_id_transaksi_jual_beli)){
                                    $staus_proses='<code class="text-danger">ID Transaksi Tidak Ada</code>';
                                }else{
                                    //Buat id_transaksi_pembayaran
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
                                        '$tanggal_jam_bayar',
                                        '$sisa_pembayaran',
                                        '$now'
                                    )";
                                    if (!mysqli_query($Conn, $entry_pembayaran)) {
                                        $staus_proses='<code class="text-danger">Gagal Menyimpan Pembayaran</code>';
                                    }else{
                                        $updateTransaksi = mysqli_query($Conn, "UPDATE transaksi_jual_beli SET status='Lunas' WHERE id_transaksi_jual_beli='$id_transaksi_jual_beli'");
                                        if (!$updateTransaksi) {
                                            $staus_proses='<code class="text-danger">Gagal Update Status Transaksi</code>';
                                        }else{
                                            // Pengaturan Auto Jurnal
                                            $akun_debet = GetDetailData($Conn, 'setting_autojurnal_jual_beli', 'kategori', $kategori, 'debet');
                                            $akun_utang_piutang = GetDetailData($Conn, 'setting_autojurnal_jual_beli', 'kategori', $kategori, 'utang_piutang');

                                            //Insert Jurnal Debet
                                            $d_k = "D";
                                            $index_colum = "id_transaksi_jual_beli";
                                            $insert_jurnal_debet = InsertParsialJournalPembayaran($Conn, $kategori, $id_transaksi_jual_beli, $id_transaksi_pembayaran, $tanggal_jam_bayar, $akun_debet, $d_k, $sisa_pembayaran);
                                            if ($insert_jurnal_debet != "Success") {
                                                $staus_proses='<code class="text-danger">Gagal insert jurnal debet</code>';
                                            }else{

                                                //Insert Jurnal Kredit
                                                $d_k = "K";
                                                $insert_jurnal_kredit = InsertParsialJournalPembayaran($Conn, $kategori, $id_transaksi_jual_beli, $id_transaksi_pembayaran, $tanggal_jam_bayar, $akun_utang_piutang, $d_k, $sisa_pembayaran);
                                                if ($insert_jurnal_kredit != "Success") {
                                                    $staus_proses='<code class="text-danger">Gagal insert jurnal kredit</code>';
                                                }else{
                                                    $staus_proses='<code class="text-success">Berhasil</code>';
                                                }
                                            }
                                        }
                                    }
                                }
                                echo '
                                    <tr>
                                        <td>
                                            <small class="text-muted">'.$no.'</small>
                                            <input type="hidden" name="id_transaksi_jual_beli[]" value="'.$id_transaksi_jual_beli.'">
                                        </td>
                                        <td><small class="text-muted">'.$tanggal.'</small></td>
                                        <td><small class="text-muted">'.$kategori.'</small></td>
                                        <td><small class="text-muted">'.$nama_anggota.'</small></td>
                                        <td><small class="text-muted">'.$jumlah_rp.'</small></td>
                                        <td><small class="text-muted">'.$staus_proses.'</small></td>
                                    </tr>
                                ';
                            }
                        }
                        $no++;
                    }
                    //Format Jumlah Total
                    $jumlah_total_format="Rp " . number_format($jumlah_total,0,',','.');
                    echo '
                        <tr>
                            <td><small class="text-muted"></small></td>
                            <td colspan="3"><b class="text-muted">JUMLAH TOTAL PEMBAYARAN</b></td>
                            <td><b class="text-muted">'.$jumlah_total_format.'</b></td>
                            <td></td>
                        </tr>
                    ';
                    echo '
                        <tr>
                            <td colspan="6">
                                <div class="alert alert-info">
                                    <small class="text-muted">Proses Selesai Dilakukan!</small>
                                </div>
                            </td>
                        </tr>
                    ';
                }
            }
        }
    }
?>

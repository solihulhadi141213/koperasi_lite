<?php
    //Koneksi
    date_default_timezone_set('Asia/Jakarta');
    include "../../_Config/Connection.php";
    include "../../_Config/GlobalFunction.php";
    include "../../_Config/SettingGeneral.php";
    include "../../_Config/Session.php";

    //Validasi Sesi
    if(empty($SessionIdAkses)){
        echo '<div class="row">';
        echo '  <div class="col-md-12 mb-3 text-center">';
        echo '      <small class="text-danger">Sesi Akses Sudah Berakhir, Silahkan Login Ulang</small>';
        echo '  </div>';
        echo '</div>';
    }else{

        //Validasi keberadaan id shu
        if(empty($_POST['id_shu_session'])){
            echo '<div class="row">';
            echo '  <div class="col-md-12 mb-3 text-center">';
            echo '      <small class="text-danger">ID Sesi SHU Tidak Boleh Kosong!</small>';
            echo '  </div>';
            echo '</div>';
        }else{

            //Buat variabel
            $id_shu_session=validateAndSanitizeInput($_POST['id_shu_session']);

            //Buka data dengan prepared statment
            $Qry = $Conn->prepare("SELECT * FROM shu_session WHERE id_shu_session = ?");
            $Qry->bind_param("i", $id_shu_session);
            if (!$Qry->execute()) {
                $error=$Conn->error;
                echo '
                    <div class="alert alert-danger">
                        <small>Terjadi kesalahan pada saat menampilkan data sesi SHU <br> Keterangan : '.$error.'</small>
                    </div>
                ';
            }else{
                $Result = $Qry->get_result();
                $Data = $Result->fetch_assoc();

                //Apabila Data Tidak Ditemukan
                if(empty($Data['id_shu_session'])){
                    echo '
                        <div class="alert alert-danger">
                            <small>Data Sesi SHU tidak ditemukan!</small>
                        </div>
                    ';
                }else{

                    //Buat Variabel
                    $periode_hitung1=$Data['periode_hitung1'];
                    $periode_hitung2=$Data['periode_hitung2'];
                    $total_penjualan=$Data['total_penjualan'];
                    $total_simpanan=$Data['total_simpanan'];
                    $total_pinjaman=$Data['total_pinjaman'];
                    $persen_penjualan=$Data['persen_penjualan'];
                    $persen_simpanan=$Data['persen_simpanan'];
                    $persen_pinjaman=$Data['persen_pinjaman'];
                    $shu=$Data['shu'];
                    $status=$Data['status'];
                    
                    //Format Rp
                    $shu_rp = "Rp " . number_format($shu,0,',','.');

                    //Format tanggal
                    $periode_hitung1=date('d/m/Y',strtotime($periode_hitung1));
                    $periode_hitung2=date('d/m/Y',strtotime($periode_hitung2));

                    //Hitung Jumlah Anggota
                    $jumlah_anggota_aktif=mysqli_num_rows(mysqli_query($Conn, "SELECT id_anggota FROM anggota WHERE status='Aktif'"));

                    //Apakah sudah ada data rincian sebelumnya
                    $jumlah_rincian=mysqli_num_rows(mysqli_query($Conn, "SELECT id_shu_rincian FROM shu_rincian WHERE id_shu_session='$id_shu_session'"));
                    if(!empty($jumlah_rincian)){
                        $notifikasi_tambahan="<li>Sebelumnya sudah ada $jumlah_rincian data rincian pada SHU tersebut. Sistem akan menghapusnya dan menggantinya dengan perhitungan baru!</li>";
                    }else{
                        $notifikasi_tambahan="";
                    }
                    //Apabila ststuas sesi sudah bukan pending
                    if($status!=="Pending"){
                        echo '
                            <div class="alert alert-danger">
                                <small>Sesi Pembagian SHu Sudah Selesai! Anda tidak bisa melakukan perubahan data rincian pada sesi ini!</small>
                            </div>
                        ';
                    }else{
                        echo '<input type="hidden" name="id_shu_session" class="form-control" value="'.$id_shu_session.'">';
                        echo '<input type="hidden" name="batas" id="batas_perhitungan" class="form-control" value="1">';
                        echo '<input type="hidden" name="page" id="page_perhitungan" class="form-control" value="1">';
                        echo '
                            <div class="row mb-3">
                                <div class="col-4"><small>Periode Perhitungan</small></div>
                                <div class="col-8">
                                    <small class="text text-muted">'.$periode_hitung1.' s/d '.$periode_hitung2.'</small>
                                </div>
                            </div>
                            <div class="row mb-3">
                                <div class="col-4"><small>Anggota Aktif</small></div>
                                <div class="col-8">
                                    <small class="text text-muted">'.$jumlah_anggota_aktif.' Orang</small>
                                </div>
                            </div>
                            <div class="row mb-3">
                                <div class="col-4"><small>Alokasi SHU</small></div>
                                <div class="col-8">
                                    <small class="text text-muted">'.$shu_rp.'</small>
                                </div>
                            </div>
                            <div class="row mb-3">
                                <div class="col-12">
                                    <div class="alert alert-info">
                                        <small>
                                            <b>Penting Dipahami :</b><br>
                                            <ul>
                                                <li>
                                                    Sistem akan menghitung pembagian SHU setiap anggota aktif yang terdaftar sesuai jumlah transaksi, simpanan dan pinjaman anggota.
                                                </li>
                                                <li>
                                                    Nominal pembagian SHU memiliki nilai pembulatan.
                                                </li>
                                                <li>
                                                    Nlai acuan SHU yang dibagikan berdasarkan nilaii alokasi dana SHU.
                                                </li>
                                                <li>
                                                    Untuk memulai proses klik pada tombol <i>Mulai Hitung</i> pada bagian bawah <i>Popup</i> ini.
                                                </li>
                                                '.$notifikasi_tambahan.'
                                            </ul>
                                        </small>
                                    </div>
                                </div>
                            </div>
                        ';
                    }
                }
            }
        }
    }
?>
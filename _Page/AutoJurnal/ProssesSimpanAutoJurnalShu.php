<?php
    //Koneksi
    include "../../_Config/Connection.php";
    include "../../_Config/GlobalFunction.php";
    include "../../_Config/Session.php";
    date_default_timezone_set('Asia/Jakarta');
    //Time Now Tmp
    $now=date('Y-m-d H:i:s');
    if(empty($SessionIdAkses)){
        echo '<div class="alert alert-danger">Sesi Akses Sudah Berakhir, Silahkan Login Ulang</div>';
    }else{
        //Validasi debet_pembagian tidak boleh kosong
        if(empty($_POST['debet_pembagian'])){
            echo '<div class="alert alert-danger">Debet Penjualan Tidak Boleh Kosong</div>';
        }else{
            //Validasi kredit_pembagian tidak boleh kosong
            if(empty($_POST['kredit_pembagian'])){
                echo '<div class="alert alert-danger">Kredit Penjualan Tidak Boleh Kosong</div>';
            }else{
                //Validasi debet_pembayaran tidak boleh kosong
                if(empty($_POST['debet_pembayaran'])){
                    echo '<div class="alert alert-danger">Debet Pembelian Tidak Boleh Kosong</div>';
                }else{
                    //Validasi kredit_pembayaran tidak boleh kosong
                    if(empty($_POST['kredit_pembayaran'])){
                        echo '<div class="alert alert-danger">Kredit Pembelian Tidak Boleh Kosong</div>';
                    }else{
                        //Buat Variabel
                        $debet_pembagian=$_POST['debet_pembagian'];
                        $kredit_pembagian=$_POST['kredit_pembagian'];
                        $debet_pembayaran=$_POST['debet_pembayaran'];
                        $kredit_pembayaran=$_POST['kredit_pembayaran'];

                        //Berssihkan Variabel
                        $debet_pembagian = validateAndSanitizeInput($_POST['debet_pembagian']);
                        $kredit_pembagian = validateAndSanitizeInput($_POST['kredit_pembagian']);
                        $debet_pembayaran = validateAndSanitizeInput($_POST['debet_pembayaran']);
                        $kredit_pembayaran = validateAndSanitizeInput($_POST['kredit_pembayaran']);

                        // Mendapatkan data Pembagian SHU
                        $pembagianShu = getAutoJurnalSHU($Conn, 'Pembagian');
                        $id_setting_autojurnal_shu_pembagian = $pembagianShu['id_setting_autojurnal_shu'];
                        $id_perkiraan_debet_pembagian = $pembagianShu['id_perkiraan_debet'];
                        $id_perkiraan_kredit_pembagian = $pembagianShu['id_perkiraan_kredit'];

                        // Mendapatkan data Pembayaran SHU
                        $pembayaranShu = getAutoJurnalSHU($Conn, 'Pembayaran');
                        $id_setting_autojurnal_shu_pembayaran = $pembayaranShu['id_setting_autojurnal_shu'];
                        $id_perkiraan_debet_pembayaran = $pembayaranShu['id_perkiraan_debet'];
                        $id_perkiraan_kredit_pembayaran = $pembayaranShu['id_perkiraan_kredit'];

                        //Apabila Autojurnal Pembagian Belum Ada maka insert
                        if(empty($id_setting_autojurnal_shu_pembagian)){
                            $EntryAutoJurnalPembagian="INSERT INTO setting_autojurnal_shu (
                                komponen,
                                id_perkiraan_debet,
                                id_perkiraan_kredit
                            ) VALUES (
                                'Pembagian',
                                '$debet_pembagian',
                                '$kredit_pembagian'
                            )";
                            $InputAutoJurnalPembagian=mysqli_query($Conn, $EntryAutoJurnalPembagian);
                            if($InputAutoJurnalPembagian){
                                $validasi_proses_simpen_pembagian="Berhasil";
                            }else{
                                $validasi_proses_simpen_pembagian="Terjadi Kesalahan Pada Saat Insert Setting Auto Jurnal Pembagian SHU!";
                            }
                        }else{
                            $UpdatePembagian = mysqli_query($Conn,"UPDATE setting_autojurnal_shu SET 
                                id_perkiraan_debet='$debet_pembagian',
                                id_perkiraan_kredit='$kredit_pembagian'
                            WHERE id_setting_autojurnal_shu='$id_setting_autojurnal_shu_pembagian'") or die(mysqli_error($Conn)); 
                            if($UpdatePembagian){
                                $validasi_proses_simpen_pembagian="Berhasil";
                            }else{
                                $validasi_proses_simpen_pembagian="Terjadi Kesalahan Pada Saat Update Setting Auto Jurnal Penjualan!";
                            }
                        }

                        //Validasi Prosess Setting Autojurnal Penjualan
                        if($validasi_proses_simpen_pembagian!=="Berhasil"){
                            echo '<div class="alert alert-danger">'.$validasi_proses_simpen_pembagian.'</div>';
                        }else{

                            //Lanjutkan Setting Auto Jurnal pembayaran
                            if(empty($id_setting_autojurnal_shu_pembayaran)){
                                $EntryAutoJurnalPembayaran="INSERT INTO setting_autojurnal_shu (
                                    komponen,
                                    id_perkiraan_debet,
                                    id_perkiraan_kredit
                                ) VALUES (
                                    'Pembayaran',
                                    '$debet_pembayaran',
                                    '$kredit_pembayaran'
                                )";
                                $InputAutoJurnalPembayaran=mysqli_query($Conn, $EntryAutoJurnalPembayaran);
                                if($InputAutoJurnalPembayaran){
                                    $validasi_proses_simpen_pembayaran="Berhasil";
                                }else{
                                    $validasi_proses_simpen_pembayaran="Terjadi Kesalahan Pada Saat Insert Setting Auto Jurnal Pembayaran!";
                                }
                            }else{
                                $UpdateUpdatePembayaran = mysqli_query($Conn,"UPDATE setting_autojurnal_shu SET 
                                    id_perkiraan_debet='$debet_pembayaran',
                                    id_perkiraan_kredit='$kredit_pembayaran'
                                WHERE id_setting_autojurnal_shu='$id_setting_autojurnal_shu_pembayaran'") or die(mysqli_error($Conn)); 
                                if($UpdateUpdatePembayaran){
                                    $validasi_proses_simpen_pembayaran="Berhasil";
                                }else{
                                    $validasi_proses_simpen_pembayaran="Terjadi Kesalahan Pada Saat Update Setting Auto Jurnal Pembayaran!";
                                }
                            }
                            if($validasi_proses_simpen_pembayaran!=="Berhasil"){
                                echo '<div class="alert alert-danger">'.$validasi_proses_simpen_pembelian.'</div>';
                            }else{

                                //Apabila Semua Prosses Berhasil
                                echo '
                                    <div class="alert alert-success">
                                        <small id="NotifikasiSimpanAutoJurnalShuBerhasil">Berhasil</small>
                                    </div>
                                ';
                            }
                        }
                    }
                }
            }
        }
    }
?>
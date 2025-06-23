<?php
    //Connection
    include "../../_Config/Connection.php";
    include "../../_Config/GlobalFunction.php";
    include "../../_Config/Session.php";

    //Time Zone
    date_default_timezone_set('Asia/Jakarta');

    //Time Now
    $now=date('Y-m-d H:i:s');

    //Validasi Session
    if(empty($SessionIdAkses)){
        echo '
            <div class="alert alert-danger">
                <small>Sesi Akses Sudah Berakhir! Silahkan Login Ulang!</small>
            </div>
        ';
    }else{

        //Validasi 'id_shu_rincian' tidak boleh kosong
        if(empty($_POST['id_shu_rincian'])){
            echo '
                <div class="alert alert-danger">
                    <small>ID Rincian Tidak Boleh Kosong!</small>
                </div>
            ';
        }else{
            $id_shu_rincian=validateAndSanitizeInput($_POST['id_shu_rincian']);
            $penjualan = !empty($_POST['penjualan']) ? str_replace(".", "", $_POST['penjualan']) : 0;
            $simpanan = !empty($_POST['simpanan']) ? str_replace(".", "", $_POST['simpanan']) : 0;
            $pinjaman = !empty($_POST['pinjaman']) ? str_replace(".", "", $_POST['pinjaman']) : 0;
            $jasa_penjualan = !empty($_POST['jasa_penjualan']) ? str_replace(".", "", $_POST['jasa_penjualan']) : 0;
            $jasa_simpanan = !empty($_POST['jasa_simpanan']) ? str_replace(".", "", $_POST['jasa_simpanan']) : 0;
            $jasa_pinjaman = !empty($_POST['jasa_pinjaman']) ? str_replace(".", "", $_POST['jasa_pinjaman']) : 0;
            $shu=$jasa_penjualan+$jasa_simpanan+$jasa_pinjaman;
            
            //Validasi Hanya Boleh Karakter Angka
            if(!preg_match("/^[0-9]*$/", $simpanan)){
                $validasi_angka="Simpanan Hanya Boleh Diisi Oleh Angka";
            }else{
                if(!preg_match("/^[0-9]*$/", $jasa_simpanan)){
                    $validasi_angka="Jasa Simpanan Hanya Boleh Diisi Oleh Angka";
                }else{
                    if(!preg_match("/^[0-9]*$/", $pinjaman)){
                        $validasi_angka="Pinjaman Hanya Boleh Diisi Oleh Angka";
                    }else{
                        if(!preg_match("/^[0-9]*$/", $jasa_pinjaman)){
                            $validasi_angka="Jasa Pinjaman Hanya Boleh Diisi Oleh Angka";
                        }else{
                            if(!preg_match("/^[0-9]*$/", $penjualan)){
                                $validasi_angka="Penjualan Hanya Boleh Diisi Oleh Angka";
                            }else{
                                if(!preg_match("/^[0-9]*$/", $jasa_penjualan)){
                                    $validasi_angka="Jasa Penjualan Hanya Boleh Diisi Oleh Angka";
                                }else{
                                    if(!preg_match("/^[0-9]*$/", $shu)){
                                        $validasi_angka="Nominal SHU Hanya Boleh Diisi Oleh Angka";
                                    }else{
                                        $validasi_angka="Valid";
                                    }
                                }
                            }
                        }
                    }
                }
            }
            if($validasi_angka!=="Valid"){
                echo '
                    <div class="alert alert-danger">
                        <small>'.$validasi_angka.'</small>
                    </div>
                ';
            }else{
                //Update Rincian Bagi Hasil
                $UpdateRincian = mysqli_query($Conn,"UPDATE shu_rincian SET 
                    simpanan='$simpanan',
                    pinjaman='$pinjaman',
                    penjualan='$penjualan',
                    jasa_simpanan='$jasa_simpanan',
                    jasa_pinjaman='$jasa_pinjaman',
                    jasa_penjualan='$jasa_penjualan',
                    shu='$shu'
                WHERE id_shu_rincian='$id_shu_rincian'") or die(mysqli_error($Conn)); 
                if($UpdateRincian){
                    //Simpan Log
                    $kategori_log="SHU";
                    $deskripsi_log="Edit Rincian SHU manual";
                    $InputLog=addLog($Conn,$SessionIdAkses,$now,$kategori_log,$deskripsi_log);
                    if($InputLog=="Success"){
                        echo '
                            <div class="alert alert-success">
                                <small id="NotifikasiEditRincianBerhasil">Success</small>
                            </div>
                        '; 
                    }else{
                        echo '
                            <div class="alert alert-danger">
                                <small>Terjadi kesalahan pada saat menyimpan Log!</small>
                            </div>
                        ';
                    }
                }else{
                    echo '
                        <div class="alert alert-danger">
                            <small>Terjadi kesalahan pada saat melakukan update rincian SHU</small>
                        </div>
                    ';
                }
            }
        }
    }
?>
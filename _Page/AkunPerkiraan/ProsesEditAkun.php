<?php
    //Koneksi
    include "../../_Config/Connection.php";
    include "../../_Config/GlobalFunction.php";
    include "../../_Config/Session.php";
    date_default_timezone_set('Asia/Jakarta');
    //Tangkap Variabel
    if(empty($_POST['id_perkiraan'])){
        echo '<i class="text-danger">Mohon Maaf!! ID Akun Perkiraan Keuangan Tidak Dapat Ditangkap.</i>';
    }else{
        if(empty($_POST['kode'])){
            echo '<i class="text-danger">Kode Perkiraan Tidak Boleh Kosong.</i>';
        }else{
            if(empty($_POST['nama'])){
                echo '<i class="text-danger">Nama Perkiraan Tidak Boleh Kosong.</i>';
            }else{
                if(empty($_POST['saldo_normal'])){
                    echo '<i class="text-danger">Saldo Normal Akun Perkiraan Tidak Boleh Kosong.</i>';
                }else{
                    $id_perkiraan=$_POST['id_perkiraan'];
                    if(empty($_POST['kode_induk'])){
                        $kode_induk="";
                    }else{
                        $kode_induk=$_POST['kode_induk'];
                    }
                    $kode=$_POST['kode'];
                    $nama=$_POST['nama'];
                    $saldo_normal=$_POST['saldo_normal'];
                    //Bersihkan Variabel
                    $id_perkiraan=validateAndSanitizeInput($id_perkiraan);
                    $kode_induk=validateAndSanitizeInput($kode_induk);
                    $kode=validateAndSanitizeInput($kode);
                    $nama=validateAndSanitizeInput($nama);
                    $saldo_normal=validateAndSanitizeInput($saldo_normal);
                    //Buka kd data
                    $level=GetDetailData($Conn,'akun_perkiraan','id_perkiraan',$id_perkiraan,'level');
                    $KodeLama=GetDetailData($Conn,'akun_perkiraan','id_perkiraan',$id_perkiraan,'kode');
                    $kd=GetDetailData($Conn,'akun_perkiraan','id_perkiraan',$id_perkiraan,'kd1');
                    //Gabungkan Kode
                    $kode="$kode_induk$kode";
                    //Validasi Kode Duplikat
                    if($KodeLama==$kode){
                        $ValidasiDuplikat="0";
                    }else{
                        $ValidasiDuplikat=GetDetailData($Conn,'akun_perkiraan','kode',$kode,'id_perkiraan');
                    }
                    if(!empty($ValidasiDuplikat)){
                        echo '<i class="text-danger">Kode tersebut sudah ada, gunakan kode lain!</i>';
                    }else{
                        //Proses Update
                        $UpdateAkunPerkiraan = mysqli_query($Conn, "UPDATE akun_perkiraan SET 
                            kode='$kode',
                            nama='$nama',
                            saldo_normal='$saldo_normal'
                        WHERE id_perkiraan='$id_perkiraan'") or die(mysqli_error($Conn)); 
                        //Apabila proses update berhasil maka lakukan update saldo normal untuk anak akunnya level 1
                        if($UpdateAkunPerkiraan){
                            //Apabila akun adalah level 1
                            if($level=="1"){
                                //Update Saldo Normal
                                $UpdateSaldoNormal = mysqli_query($Conn, "UPDATE akun_perkiraan SET 
                                    saldo_normal='$saldo_normal'
                                WHERE kd1='$kode'") or die(mysqli_error($Conn));
                                if($UpdateSaldoNormal){
                                    $ValidasiUpdateSaldoNormal="Berhasil";
                                }else{
                                    $ValidasiUpdateSaldoNormal="Update Saldo Normal Gagal";
                                }
                            }else{
                                $ValidasiUpdateSaldoNormal="Berhasil";
                            }
                            //Validasi Update Saldo Normal
                            if($ValidasiUpdateSaldoNormal!=="Berhasil"){
                                echo '<i class="text-danger">'.$ValidasiUpdateSaldoNormal.'</i>';
                            }else{
                                //Update Jurnal Yang Sesuai Kode Lama
                                $UpdateJurnal = mysqli_query($Conn, "UPDATE jurnal SET 
                                    kode_perkiraan='$kode',
                                    nama_perkiraan='$nama'
                                WHERE kode_perkiraan='$KodeLama'") or die(mysqli_error($Conn)); 
                                if($UpdateJurnal){
                                    //Update Auto Jurnal Debet
                                    $UpdateAutoJurnalDebet = mysqli_query($Conn, "UPDATE auto_jurnal SET 
                                        debet_name='$nama'
                                    WHERE debet_id='$id_perkiraan'") or die(mysqli_error($Conn)); 
                                    if($UpdateAutoJurnalDebet){
                                        //Update Auto Jurnal Kredit
                                        $UpdateAutoJurnalKredit = mysqli_query($Conn, "UPDATE auto_jurnal SET 
                                            kredit_name='$nama'
                                        WHERE kredit_id='$id_perkiraan'") or die(mysqli_error($Conn)); 
                                        if($UpdateAutoJurnalKredit){
                                            //Update Auto Jurnal Angsuran
                                            $UpdateAutoJurnalAngsuran = mysqli_query($Conn, "UPDATE auto_jurnal_angsuran SET 
                                                kode='$kode',
                                                nama='$nama'
                                            WHERE id_perkiraan='$id_perkiraan'") or die(mysqli_error($Conn)); 
                                            if($UpdateAutoJurnalAngsuran){
                                                //Update Auto Jurnal Angsuran
                                                $KategoriLog="Akun Perkiraan";
                                                $KeteranganLog="Edit Akun Perkiraan";
                                                include "../../_Config/InputLog.php";
                                                echo '<small class="text-success" id="NotifikasiEditAkunBerhasil">Success</small>';
                                            }else{
                                                echo '<i class="text-danger">Terjadi kesalahan pada saat update auto jurnal angsuran</i>';
                                            }
                                        }else{
                                            echo '<i class="text-danger">Terjadi kesalahan pada saat update auto jurnal Kredit</i>';
                                        }
                                    }else{
                                        echo '<i class="text-danger">Terjadi kesalahan pada saat update auto jurnal Debet</i>';
                                    }
                                }else{
                                    echo '<i class="text-danger">Terjadi kesalahan pada saat update jurnal</i>';
                                }
                            }
                        //Apabila proses update gagal
                        }else{
                            echo '<i class="text-danger">Terjadi kesalahan pada saat update akun perkiraan</i>';
                        }
                    }
                }
            }
        }
    }
?>


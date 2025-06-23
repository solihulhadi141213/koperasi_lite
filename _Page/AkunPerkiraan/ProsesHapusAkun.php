<?php
    //Koneksi
    include "../../_Config/Connection.php";
    include "../../_Config/GlobalFunction.php";
    include "../../_Config/Session.php";
    date_default_timezone_set('Asia/Jakarta');
    //Validasi Variebl yang ditangkap
    //Cek Akses
    if(empty($SessionIdAkses)){
        echo '<code>Sesi Akses Sudah Berakhir. Silahkan Login Ulang!</code>';
    }else{
        if(empty($_POST['id_perkiraan'])){
            echo '<code>ID Perkiraan Tidak Boleh Kosong!</code>';
        }else{
            $id_perkiraan=$_POST['id_perkiraan'];
            $id_perkiraan=validateAndSanitizeInput($id_perkiraan);
            //Buka Data
            $level=GetDetailData($Conn,'akun_perkiraan','id_perkiraan',$id_perkiraan,'level');
            $kode=GetDetailData($Conn,'akun_perkiraan','id_perkiraan',$id_perkiraan,'kode');
            $nama=GetDetailData($Conn,'akun_perkiraan','id_perkiraan',$id_perkiraan,'nama');
            //Hapus Akun
            $HapusAkun = mysqli_query($Conn, "DELETE FROM akun_perkiraan WHERE id_perkiraan='$id_perkiraan'") or die(mysqli_error($Conn));
            if($HapusAkun){
                //Hapus Jurnal
                $HapusJurnal = mysqli_query($Conn, "DELETE FROM jurnal WHERE kode_perkiraan='$kode'") or die(mysqli_error($Conn));
                if($HapusJurnal){
                    //Update Auto Jurnal Debet
                    $UpdateAutoJurnalDebet = mysqli_query($Conn, "UPDATE auto_jurnal SET 
                        debet_id='0',
                        debet_name=''
                    WHERE debet_id='$id_perkiraan'") or die(mysqli_error($Conn)); 
                    if($UpdateAutoJurnalDebet){
                        //Update Auto Jurnal Kredit
                        $UpdateAutoJurnalKredit = mysqli_query($Conn, "UPDATE auto_jurnal SET 
                            kredit_id='0',
                            kredit_name=''
                        WHERE kredit_id='$id_perkiraan'") or die(mysqli_error($Conn)); 
                        if($UpdateAutoJurnalKredit){
                            //Update Auto Jurnal Angsuran
                            $UpdateAutoJurnalAngsuran = mysqli_query($Conn, "UPDATE auto_jurnal_angsuran SET 
                                id_perkiraan='0',
                                kode='',
                                nama=''
                            WHERE id_perkiraan='$id_perkiraan'") or die(mysqli_error($Conn)); 
                            if($UpdateAutoJurnalAngsuran){
                                //Update Auto Jurnal Angsuran
                                $KategoriLog="Akun Perkiraan";
                                $KeteranganLog="Hapus Akun Perkiraan";
                                include "../../_Config/InputLog.php";
                                echo '<small class="text-success" id="NotifikasiHapusAkunBerhasil">Success</small>';
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
                    echo '<code>Tejadi kesalahan pada saat menghapus jurnal</code>';
                }
            }else{
                echo '<code>Tejadi kesalahan pada saat menghapus akun perkiraan</code>';
            }
        }
    }
?>
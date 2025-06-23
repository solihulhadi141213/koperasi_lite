<?php
    //Koneksi
    include "../../_Config/Connection.php";
    include "../../_Config/GlobalFunction.php";
    include "../../_Config/Session.php";
    //Menangkap Data
    if(empty($SessionIdAkses)){
        echo '<code class="text-danger">Sesi Akses Sudah Berakhir, Silahkan Login Ulang</code>';
    }else{
        if(empty($_POST['debet_id'])){
            echo '<code class="text-danger">Debet ID Transaksi Pinjaman Tidak Boleh Kosong!!</code>';
        }else{
            if(empty($_POST['kredit_id'])){
                echo '<code class="text-danger">Kredit ID Transaksi Pinjaman Tidak Boleh Kosong!!</code>';
            }else{
                if(empty($_POST['debet_id2'])){
                    echo '<code class="text-danger">Debet ID Transaksi Angsuran Tidak Boleh Kosong!!</code>';
                }else{
                    if(empty($_POST['kredit_id2'])){
                        echo '<code class="text-danger">Kredit ID Transaksi Angsuran Tidak Boleh Kosong!!</code>';
                    }else{
                        if(empty($_POST['id_perkiraan_jasa'])){
                            echo '<code class="text-danger">ID Perkiraan Transaksi Jasa Tidak Boleh Kosong!!</code>';
                        }else{
                            if(empty($_POST['id_perkiraan_denda'])){
                                echo '<code class="text-danger">ID Perkiraan Transaksi denda Tidak Boleh Kosong!!</code>';
                            }else{
                                $debet_id=$_POST['debet_id'];
                                $kredit_id=$_POST['kredit_id'];
                                $debet_id2=$_POST['debet_id2'];
                                $kredit_id2=$_POST['kredit_id2'];
                                $id_perkiraan_jasa=$_POST['id_perkiraan_jasa'];
                                $id_perkiraan_denda=$_POST['id_perkiraan_denda'];
                                //Membersihkan Variabel
                                $debet_id=validateAndSanitizeInput($debet_id);
                                $kredit_id=validateAndSanitizeInput($kredit_id);
                                $debet_id2=validateAndSanitizeInput($debet_id2);
                                $kredit_id2=validateAndSanitizeInput($kredit_id2);
                                $id_perkiraan_jasa=validateAndSanitizeInput($id_perkiraan_jasa);
                                $id_perkiraan_denda=validateAndSanitizeInput($id_perkiraan_denda);
                                //Buka Akun Pinjaman
                                $NamaAkunPinjamanDebet =GetDetailData($Conn,'akun_perkiraan','id_perkiraan',$debet_id,'nama');
                                $NamaAkunPinjamanKredit =GetDetailData($Conn,'akun_perkiraan','id_perkiraan',$kredit_id,'nama');
                                //Buka Akun Angsuran
                                $NamaAkunAngsuranDebet =GetDetailData($Conn,'akun_perkiraan','id_perkiraan',$debet_id2,'nama');
                                $NamaAkunAngsuranKredit =GetDetailData($Conn,'akun_perkiraan','id_perkiraan',$kredit_id2,'nama');
                                //Buka Kode dan Nama Jasa
                                $KodeJasa =GetDetailData($Conn,'akun_perkiraan','id_perkiraan',$id_perkiraan_jasa,'kode');
                                $NamaJasa =GetDetailData($Conn,'akun_perkiraan','id_perkiraan',$id_perkiraan_jasa,'nama');
                                //Buka Kode dan Nama Denda
                                $KodeDenda =GetDetailData($Conn,'akun_perkiraan','id_perkiraan',$id_perkiraan_denda,'kode');
                                $NamaDenda =GetDetailData($Conn,'akun_perkiraan','id_perkiraan',$id_perkiraan_denda,'nama');
                                //Update Auto Jurnal Pinjaman
                                $UpdatePinjaman = mysqli_query($Conn,"UPDATE auto_jurnal SET 
                                    debet_id='$debet_id',
                                    debet_name='$NamaAkunPinjamanDebet',
                                    kredit_id='$kredit_id',
                                    kredit_name='$NamaAkunPinjamanKredit '
                                WHERE kategori_transaksi='Pinjaman'") or die(mysqli_error($Conn)); 
                                if($UpdatePinjaman){
                                    //Update Auto Jurnal Angsuran
                                    $UpdateAngsuran = mysqli_query($Conn,"UPDATE auto_jurnal SET 
                                        debet_id='$debet_id2',
                                        debet_name='$NamaAkunAngsuranDebet',
                                        kredit_id='$kredit_id2',
                                        kredit_name='$NamaAkunAngsuranKredit '
                                    WHERE kategori_transaksi='Angsuran'") or die(mysqli_error($Conn)); 
                                    if($UpdateAngsuran){
                                        //Update Auto Jurnal Jasa
                                        $UpdateJasa = mysqli_query($Conn,"UPDATE auto_jurnal_angsuran SET 
                                            id_perkiraan='$id_perkiraan_jasa',
                                            kode='$KodeJasa',
                                            nama='$NamaJasa '
                                        WHERE komponen='Jasa'") or die(mysqli_error($Conn)); 
                                        if($UpdateJasa){
                                            //Update Auto Jurnal Denda
                                            $UpdateDenda = mysqli_query($Conn,"UPDATE auto_jurnal_angsuran SET 
                                                id_perkiraan='$id_perkiraan_denda',
                                                kode='$KodeDenda',
                                                nama='$NamaDenda '
                                            WHERE komponen='Denda'") or die(mysqli_error($Conn)); 
                                            if($UpdateDenda){
                                                echo '<small class="text-success" id="NotifikasiSimpanAutoJurnalBerhasil">Success</small>';
                                            }else{
                                                echo '<code class="text-danger">Terjadi kesalahan pada saat update akun denda!</code>';
                                            }
                                        }else{
                                            echo '<code class="text-danger">Terjadi kesalahan pada saat update akun jasa!</code>';
                                        }
                                    }else{
                                        echo '<code class="text-danger">Terjadi kesalahan pada saat update akun angsuran!</code>';
                                    }
                                }else{
                                    echo '<code class="text-danger">Terjadi kesalahan pada saat update akun pinjaman!</code>';
                                }
                            }
                        }
                    }
                }
            }
        }
    }
?>
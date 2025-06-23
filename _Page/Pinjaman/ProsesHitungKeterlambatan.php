<?php
    //Koneksi
    date_default_timezone_set('Asia/Jakarta');
    include "../../_Config/Connection.php";
    include "../../_Config/GlobalFunction.php";
    if(empty($_POST['id_pinjaman'])){
        echo 'Error 1';
    }else{
        if(empty($_POST['tanggal_angsuran'])){
            echo 'Error 2';
        }else{
            if(empty($_POST['tanggal_bayar'])){
                echo 'Error 3';
            }else{
                $id_pinjaman=$_POST['id_pinjaman'];
                $tanggal_angsuran=$_POST['tanggal_angsuran'];
                $tanggal_bayar=$_POST['tanggal_bayar'];
                //Bersihkan Variabel
                $id_pinjaman=validateAndSanitizeInput($id_pinjaman);
                $tanggal_angsuran=validateAndSanitizeInput($tanggal_angsuran);
                $tanggal_bayar=validateAndSanitizeInput($tanggal_bayar);
                //Buka Data Pinjaman
                $id_anggota=GetDetailData($Conn,'pinjaman','id_pinjaman',$id_pinjaman,'id_anggota');
                $sistem_denda=GetDetailData($Conn,'pinjaman','id_pinjaman',$id_pinjaman,'sistem_denda');
                if(empty($id_anggota)){
                    echo 'Error 4-'.$id_pinjaman.'';
                }else{
                    if($tanggal_bayar<=$tanggal_angsuran){
                        $JumlahDenda=0;
                        $keterlambatan=0;
                    }else{
                        try {
                            // Create DateTime objects
                            $date1 = new DateTime($tanggal_angsuran);
                            $date2 = new DateTime($tanggal_bayar);
                            // Calculate the difference
                            $interval = $date1->diff($date2);
                            // Get the difference in days and months
                            if($sistem_denda=="Harian"){
                                $keterlambatan = $interval->days;
                            }else{
                                $keterlambatan = $interval->m;
                                if ($tanggal_bayar > $tanggal_angsuran) {
                                    // Set selisih_bulan to 1 if the payment is made after the due date
                                    $keterlambatan = $keterlambatan+1;
                                }
                            }
                        } catch (Exception $e) {
                            $keterlambatan=$e->getMessage();
                        }
                    }
                    echo $keterlambatan;
                }
            }
        }
    } 
?>
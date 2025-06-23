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

        //Validasi 'id_shu_session' tidak boleh kosong
        if(empty($_POST['id_shu_session'])){
            echo '
                <div class="alert alert-danger">
                    <small>ID SHU Tidak Boleh Kosong!</small>
                </div>
            ';
        }else{

            //Tangkap ID Rincian
            $id_shu_session=validateAndSanitizeInput($_POST['id_shu_session']);

            //Status
            $status=GetDetailData($Conn, 'shu_session', 'id_shu_session', $id_shu_session, 'status');
            if($status!=="Pending"){
                echo '
                    <div class="alert alert-danger">
                        <small>Sesi SHu Sudah Teralokasikan! Anda Tidak Bisa Mengubah Data Ini!</small>
                    </div>
                ';
            }else{
                //Proses hapus Rincian
                $HapusRincian= mysqli_query($Conn, "DELETE FROM shu_rincian WHERE id_shu_session='$id_shu_session'") or die(mysqli_error($Conn));
                if($HapusRincian) {
                    
                    //Apabila Berhasil Simpan Log
                    $kategori_log="SHU";
                    $deskripsi_log="Hapus Semua Rincian SHU";
                    $InputLog=addLog($Conn,$SessionIdAkses,$now,$kategori_log,$deskripsi_log);
                    if($InputLog=="Success"){
                        echo '
                            <div class="alert alert-success">
                                <small id="NotifikasiHapusSemuaRincianBerhasil">Success</small>
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
                    echo '<span class="text-danger">Terjadi kesalahan pada proses hapus rincian SHU</span>';
                }
            }
        }
    }
?>
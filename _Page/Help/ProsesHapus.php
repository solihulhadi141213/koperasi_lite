<?php
    //Koneksi
    date_default_timezone_set('Asia/Jakarta');
    include "../../_Config/Connection.php";
    include "../../_Config/SettingGeneral.php";
    include "../../_Config/GlobalFunction.php";
    include "../../_Config/Session.php";
    $now=date('Y-m-d H:i:s');

    //Validasi Session Akses
    if(empty($SessionIdAkses)){
        echo json_encode(['status' => 'Error', 'message' => 'Sesi Akses Sudah Berakhir, Silahkan Login Ulang!']);
    }else{

        //Validasi Tangkap Data 'id_help'
        if(empty($_POST['id_help'])){
            echo json_encode(['status' => 'Error', 'message' => 'ID Dokumentasi Tidak Boleh Kosong!']);
        }else{
            $id_help=$_POST['id_help'];

            //Bersihkan Variabel
            $id_help=validateAndSanitizeInput($id_help);

            //Validasi Keberadaan Data
            $id_help=GetDetailData($Conn,'help','id_help',$id_help,'id_help');

            if(empty($id_help)){
                echo json_encode(['status' => 'Error', 'message' => 'ID Dokumentasi Tidak Valid!']);
            }else{

                //Proses hapus dokumentasi berdasarkan 'id_help'
                $query = mysqli_query($Conn, "DELETE FROM help WHERE id_help='$id_help'") or die(mysqli_error($Conn));
                if ($query) {

                    //Apabila Berhasil, Simpan Log
                    $kategori_log="Dokumentasi";
                    $deskripsi_log="Hapus Dokumentasi";
                    $InputLog=addLog($Conn,$SessionIdAkses,$now,$kategori_log,$deskripsi_log);
                    if($InputLog=="Success"){
                        echo json_encode(['status' => 'Success']);
                    }else{
                        echo json_encode(['status' => 'Error', 'message' => 'Terjadi Kesalahan Pada Saat Menyimpan Log!']);
                    }
                    
                }else{
                    echo '<small class="credit text-danger">Hapus Data Dokumentasi Gagal!</small>';
                }
            }
        }
    }
?>
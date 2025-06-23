<?php
    //Koneksi
    include "../../_Config/Connection.php";
    include "../../_Config/GlobalFunction.php";
    include "../../_Config/Session.php";
    date_default_timezone_set('Asia/Jakarta');
    //Time Now Tmp
    $now=date('Y-m-d H:i:s');
    if(empty($SessionIdAkses)){
        echo '<small class="text-danger">Sesi Akses Sudah Berakhir, Silahkan Login Ulang</small>';
    }else{
        //Validasi id_anggota tidak boleh kosong
        if(empty($_POST['id_anggota'])){
            echo '<code class="text-danger">ID Anggota Tidak Boleh Kosong</code>';
        }else{
            $id_anggota=$_POST['id_anggota'];
            //Bersihkan Variabel
            $id_anggota=validateAndSanitizeInput($id_anggota);
            //Validasi ID Anggota
            $id_anggota=GetDetailData($Conn,'anggota','id_anggota',$id_anggota,'id_anggota');
            if(empty($id_anggota)){
                echo '<code class="text-danger">ID Anggota Tidak Tidak Valid Atau Tidak Ditemukan Pada Database</code>';
            }else{
                //Hapud Data Anggota
                $HapusAnggota = mysqli_query($Conn, "DELETE FROM anggota WHERE id_anggota='$id_anggota'") or die(mysqli_error($Conn));
                if($HapusAnggota) {

                    //Apabila Berhasil
                    $KategoriLog="Angggota";
                    $KeteranganLog="Hapus Anggota";
                    include "../../_Config/InputLog.php";
                    echo '<small class="text-success" id="NotifikasiHapusAnggotaBerhasil">Success</small>';
                }else{
                    $ValidasiHapusRelasi="Terjadi Kesalahan Pada Saat Menghapus Data Anggota Pada Tabel Anggota";
                }
            }
        }
    }
?>
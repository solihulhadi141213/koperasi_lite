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
            //Validasi hapus_relasi_anggota tidak boleh kosong
            if(empty($_POST['hapus_relasi_anggota'])){
                $hapus_relasi_anggota="Tidak";
            }else{
                $hapus_relasi_anggota=$_POST['hapus_relasi_anggota'];
            }
            $id_anggota=$_POST['id_anggota'];
            //Bersihkan Variabel
            $hapus_relasi_anggota=validateAndSanitizeInput($hapus_relasi_anggota);
            $id_anggota=validateAndSanitizeInput($id_anggota);
            //Validasi ID Anggota
            $id_anggota=GetDetailData($Conn,'anggota','id_anggota',$id_anggota,'id_anggota');
            if(empty($id_anggota)){
                echo '<code class="text-danger">ID Anggota Tidak Tidak Valid Atau Tidak Ditemukan Pada Database</code>';
            }else{
                $FotoLama=GetDetailData($Conn,'anggota','id_anggota',$id_anggota,'foto');
                $LokasiFotoLama = "../../assets/img/Anggota/".$FotoLama;
                //Hapud Data Anggota
                $HapusAnggota = mysqli_query($Conn, "DELETE FROM anggota WHERE id_anggota='$id_anggota'") or die(mysqli_error($Conn));
                if($HapusAnggota) {
                    //Apabila Ada File Foto Maka Di Hapus
                    if(!empty($FotoLama)){
                        if (file_exists($LokasiFotoLama)) {
                            if (unlink($LokasiFotoLama)) {
                                $ValidasiGambar="Valid";
                            } else {
                                $ValidasiGambar="Terjadi Kesalahan Pada Saat Menghapus File Foto Sebelumnya";
                            }
                        }else{
                            $ValidasiGambar="Valid";
                        }
                    }else{
                        $ValidasiGambar="Valid";
                    }
                    if($hapus_relasi_anggota=="Ya"){
                        $HapusSimpanan = mysqli_query($Conn, "DELETE FROM simpanan WHERE id_anggota='$id_anggota'") or die(mysqli_error($Conn));
                        if($HapusSimpanan) {
                            $HapusPinjaman = mysqli_query($Conn, "DELETE FROM pinjaman WHERE id_anggota='$id_anggota'") or die(mysqli_error($Conn));
                            if($HapusPinjaman) {
                                $HapusAngsuran = mysqli_query($Conn, "DELETE FROM pinjaman_angsuran WHERE id_anggota='$id_anggota'") or die(mysqli_error($Conn));
                                if($HapusAngsuran) {
                                    $ValidasiHapusRelasi="Valid";
                                }else{
                                    $ValidasiHapusRelasi="Terjadi Kesalahan Pada Saat Menghapus Data Anggota Pada Tabel Pinjaman";
                                }
                            }else{
                                $ValidasiHapusRelasi="Terjadi Kesalahan Pada Saat Menghapus Data Anggota Pada Tabel Pinjaman";
                            }
                        }else{
                            $ValidasiHapusRelasi="Terjadi Kesalahan Pada Saat Menghapus Data Anggota Pada Tabel Simpanan";
                        }
                    }else{
                        $ValidasiHapusRelasi="Valid";
                    }
                    if($ValidasiGambar=="Valid"){
                        if($ValidasiHapusRelasi=="Valid"){
                            $KategoriLog="Angggota";
                            $KeteranganLog="Hapus Anggota";
                            include "../../_Config/InputLog.php";
                            echo '<small class="text-success" id="NotifikasiHapusAnggotaBerhasil">Success</small>';
                        }else{
                            echo '<code class="text-danger">'.$ValidasiHapusRelasi.'</code>';
                        }
                    }else{
                        echo '<code class="text-danger">'.$ValidasiGambar.'</code>';
                    }
                }else{
                    $ValidasiHapusRelasi="Terjadi Kesalahan Pada Saat Menghapus Data Anggota Pada Tabel Anggota";
                }
            }
        }
    }
?>
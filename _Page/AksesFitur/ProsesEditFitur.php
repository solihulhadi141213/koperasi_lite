<?php
    //Koneksi
    include "../../_Config/Connection.php";
    include "../../_Config/GlobalFunction.php";
    include "../../_Config/Session.php";
    //Time Zone
    date_default_timezone_set('Asia/Jakarta');
    //Time Now Tmp
    $now=date('Y-m-d H:i:s');
    //Validasi nama tidak boleh kosong
    if(empty($_POST['nama'])){
        echo '<code class="text-danger">Nama fitur tidak boleh kosong</code>';
    }else{
        //Validasi kategori tidak boleh kosong
        if(empty($_POST['kategori'])){
            echo '<code class="text-danger">Kategori tidak boleh kosong</code>';
        }else{
            //Validasi kode tidak boleh kosong
            if(empty($_POST['kode'])){
                echo '<code class="text-danger">Kode tidak boleh kosong</code>';
            }else{
                //Validasi keterangan tidak boleh kosong
                if(empty($_POST['keterangan'])){
                    echo '<code class="text-danger">Setidaknya anda harus memberikan keterangan untuk fitur tersebut</code>';
                }else{
                    //Validasi id_akses_fitur tidak boleh kosong
                    if(empty($_POST['id_akses_fitur'])){
                        echo '<code class="text-danger">ID Fitur Tidak Boleh Kosong/small>';
                    }else{
                        //Validasi kode tidak boleh lebih dari 20 karakter
                        $JumlahKarakterKode=strlen($_POST['kode']);
                        if($JumlahKarakterKode>20||$JumlahKarakterKode<6){
                            echo '<code class="text-danger">Kode terdiri dari 6-20 karakter</code>';
                        }else{
                            //Validasi kode tidak boleh duplikat
                            $id_akses_fitur=$_POST['id_akses_fitur'];
                            $nama=$_POST['nama'];
                            $kategori=$_POST['kategori'];
                            $kode=$_POST['kode'];
                            $keterangan=$_POST['keterangan'];
                            //Buka Data Lama
                            $NamaFitur=GetDetailData($Conn,'akses_fitur','id_akses_fitur',$id_akses_fitur,'nama');
                            $KodeFitur=GetDetailData($Conn,'akses_fitur','id_akses_fitur',$id_akses_fitur,'kode');
                            if($nama==$NamaFitur){
                                $ValidasiNamaDuplikat=0;
                            }else{
                                $ValidasiNamaDuplikat=mysqli_num_rows(mysqli_query($Conn, "SELECT*FROM akses_fitur WHERE nama='$nama'"));
                            }
                            if($kode==$KodeFitur){
                                $ValidasiKodeDuplikat=0;
                            }else{
                                $ValidasiKodeDuplikat=mysqli_num_rows(mysqli_query($Conn, "SELECT*FROM akses_fitur WHERE kode='$kode'"));
                            }
                            if(!empty($ValidasiKodeDuplikat)){
                                echo '<code class="text-danger">Kode tersebut sudah terdaftar</code>';
                            }else{
                                if(!empty($ValidasiNamaDuplikat)){
                                    echo '<code class="text-danger">Nama Fitur tersebut sudah terdaftar</code>';
                                }else{
                                    $UpdateFiturAkses = mysqli_query($Conn,"UPDATE akses_fitur SET 
                                        kategori='$kategori',
                                        nama='$nama',
                                        kode='$kode',
                                        keterangan='$keterangan'
                                    WHERE id_akses_fitur='$id_akses_fitur'") or die(mysqli_error($Conn)); 
                                    if($UpdateFiturAkses){
                                        $JumlahPengguna =mysqli_num_rows(mysqli_query($Conn, "SELECT id_akses FROM akses_ijin WHERE id_akses_fitur='$id_akses_fitur'"));
                                        if(!empty($JumlahPengguna)){
                                            $UpdateAksesIjin = mysqli_query($Conn,"UPDATE akses_ijin SET 
                                                kode='$kode',
                                                nama='$nama',
                                                kategori='$kategori'
                                            WHERE id_akses_fitur='$id_akses_fitur'") or die(mysqli_error($Conn)); 
                                            if($UpdateAksesIjin){
                                                $ValidasiProsesUpdateAksesIjin="Valid";
                                            }else{
                                                $ValidasiProsesUpdateAksesIjin="Terjadi kesalahan pada saat update Akses ijin";
                                            }
                                        }else{
                                            $ValidasiProsesUpdateAksesIjin="Valid";
                                        }
                                        if($ValidasiProsesUpdateAksesIjin=="Valid"){
                                            $kategori_log="Fitur Akses";
                                            $deskripsi_log="Edit Fitur Akses";
                                            $InputLog=addLog($Conn,$SessionIdAkses,$now,$kategori_log,$deskripsi_log);
                                            if($InputLog=="Success"){
                                                echo '<code class="text-success" id="NotifikasiEditFiturBerhasil">Success</code>';
                                            }else{
                                                echo '<code class="text-danger">Terjadi kesalahan pada saat menyimpan Log</code>';
                                            }
                                        }else{
                                            echo '<code class="text-danger">'.$ValidasiProsesUpdateAksesIjin.'</code>';
                                        }
                                    }else{
                                        echo '<code class="text-danger">Terjadi kesalahan pada saat update fitur</code>';
                                    }
                                }
                            }
                        }
                    }
                }
            }
        }
    }
?>
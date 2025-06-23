<?php
    //Koneksi
    include "../../_Config/Connection.php";
    include "../../_Config/GlobalFunction.php";
    include "../../_Config/Session.php";
    //Time Zone
    date_default_timezone_set('Asia/Jakarta');
    //Time Now Tmp
    $now=date('Y-m-d H:i:s');
    
    // Validasi nama tidak boleh kosong dan tidak lebih dari 100 karakter
    if(empty($_POST['nama']) || strlen($_POST['nama']) > 100){
        echo '<code class="text-danger">Nama fitur tidak boleh kosong dan harus kurang dari 100 karakter</code>';
    }else{
        // Validasi kategori tidak boleh kosong dan tidak lebih dari 50 karakter
        if(empty($_POST['kategori']) || strlen($_POST['kategori']) > 50){
            echo '<code class="text-danger">Kategori tidak boleh kosong dan harus kurang dari 50 karakter</code>';
        }else{
            // Validasi kode tidak boleh kosong dan tidak lebih dari 32 karakter
            if(empty($_POST['kode']) || strlen($_POST['kode']) > 32 || strlen($_POST['kode']) < 6){
                echo '<code class="text-danger">Kode harus terdiri dari 6-32 karakter</code>';
            }else{
                // Validasi keterangan tidak boleh kosong dan tidak lebih dari 500 karakter
                if(empty($_POST['keterangan']) || strlen($_POST['keterangan']) > 500){
                    echo '<code class="text-danger">Keterangan tidak boleh kosong dan harus kurang dari 500 karakter</code>';
                }else{
                    // Validasi kode tidak boleh duplikat
                    $nama=validateAndSanitizeInput($_POST['nama']);
                    $kategori=validateAndSanitizeInput($_POST['kategori']);
                    $kode=validateAndSanitizeInput($_POST['kode']);
                    $keterangan=validateAndSanitizeInput($_POST['keterangan']);
                    
                    $ValidasiNamaDuplikat=mysqli_num_rows(mysqli_query($Conn, "SELECT * FROM akses_fitur WHERE nama=?"));
                    $ValidasiKodeDuplikat=mysqli_num_rows(mysqli_query($Conn, "SELECT * FROM akses_fitur WHERE kode=?"));
                    
                    if(!empty($ValidasiKodeDuplikat)){
                        echo '<code class="text-danger">Kode tersebut sudah terdaftar</code>';
                    }else{
                        if(!empty($ValidasiNamaDuplikat)){
                            echo '<code class="text-danger">Nama Fitur tersebut sudah terdaftar</code>';
                        }else{
                            // Menggunakan Prepared Statement
                            $stmt = $Conn->prepare("INSERT INTO akses_fitur (kategori, nama, kode, keterangan) VALUES (?, ?, ?, ?)");
                            $stmt->bind_param("ssss", $kategori, $nama, $kode, $keterangan);
                            $Input = $stmt->execute();
                            $stmt->close();

                            if($Input){
                                $kategori_log="Akses";
                                $deskripsi_log="Input Fitur Akses";
                                $InputLog=addLog($Conn, $SessionIdAkses, $now, $kategori_log, $deskripsi_log);
                                if($InputLog=="Success"){
                                    echo '<code class="text-success" id="NotifikasiTambahAksesFiturBerhasil">Success</code>';
                                }else{
                                    echo '<code class="text-danger">Terjadi kesalahan pada saat menyimpan Log</code>';
                                }
                            }else{
                                echo '<code class="text-danger">Terjadi kesalahan pada saat menyimpan data</code>';
                            }
                        }
                    }
                }
            }
        }
    }
?>

<?php
    //Koneksi
    include "../../_Config/Connection.php";
    include "../../_Config/GlobalFunction.php";
    include "../../_Config/Session.php";
    date_default_timezone_set('Asia/Jakarta');
    //Time Now Tmp
    $now=date('Y-m-d H:i:s');
    if(empty($SessionIdAkses)){
        echo '<div class="alert alert-danger">Sessi Akses Sudah Berakhir, Silahkan Login Ulang!</div>';
    }else{
        //Validasi tanggal tidak boleh kosong
        if(empty($_POST['tanggal'])){
            echo '<div class="alert alert-danger">Tanggal Simpanan Tidak Boleh Kosong!</div>';
        }else{
            //Validasi kategori_simpanan_penarikan tidak boleh kosong
            if(empty($_POST['kategori_simpanan_penarikan'])){
                echo '<div class="alert alert-danger">Kategori Simpanan Tidak Boleh Kosong!</div>';
            }else{
                //Validasi nominal tidak boleh kosong
                if(empty($_POST['nominal'])){
                    echo '<div class="alert alert-danger">Nominal Simpanan Tidak Boleh Kosong!</div>';
                }else{
                    //Validasi id_anggota tidak boleh kosong
                    if(empty($_POST['id_anggota'])){
                        echo '<div class="alert alert-danger">ID Anggota Tidak Boleh Kosong!</div>';
                    }else{
                        
                        $tanggal_simpanan=validateAndSanitizeInput($_POST['tanggal']);
                        $kategori_simpanan_penarikan =validateAndSanitizeInput($_POST['kategori_simpanan_penarikan']);
                        $nominal=validateAndSanitizeInput($_POST['nominal']);
                        $id_anggota=validateAndSanitizeInput($_POST['id_anggota']);
                        $id_simpanan_jenis =validateAndSanitizeInput($_POST['id_simpanan_jenis']) ?? 0;
                        $nominal = str_replace('.', '', $nominal);
                        if(empty($_POST['keterangan'])){
                            $keterangan="";
                        }else{
                            $keterangan=validateAndSanitizeInput($_POST['keterangan']);
                        }
                        //Buka Anggota
                        $nip=GetDetailData($Conn,'anggota','id_anggota',$id_anggota,'nip');
                        $nama=GetDetailData($Conn,'anggota','id_anggota',$id_anggota,'nama');
                        
                        //Buka nama Simpanan
                        if($kategori_simpanan_penarikan=="Penarikan"){
                            $nama_simpanan="Penarikan";
                        }else{
                            $nama_simpanan=GetDetailData($Conn,'simpanan_jenis','id_simpanan_jenis',$id_simpanan_jenis,'nama_simpanan');
                        }
                        

                        //Buat UUID Simpanan
                        $uuid_simpanan=generateUuidV1();
                                
                        // Query SQL dengan prepared statement
                        $query = "INSERT INTO simpanan (
                            uuid_simpanan,
                            id_anggota,
                            id_akses,
                            id_simpanan_jenis,
                            rutin,
                            nip,
                            nama,
                            tanggal,
                            kategori,
                            keterangan,
                            jumlah
                        ) VALUES (
                            ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?
                        )";

                        // Persiapkan statement
                        $stmt = $Conn->prepare($query);
                        if (!$stmt) {
                            $notifikasi_error[]=[
                                "no"=>$id_simpanan_jenis_list,
                                "Error"=>$Conn->error,
                            ];
                            echo '
                                <div class="alert alert-danger"><small>Terjadi kesalahan pada saat menyimpan log!<br>Error : '.$Conn->error.'</small></div>
                            ';
                        }else{
                            // Bind parameter ke query
                            $stmt->bind_param(
                                "siiiisssssd", // Jenis data: s = string, i = integer, d = double
                                $uuid_simpanan,
                                $id_anggota,
                                $SessionIdAkses,
                                $id_simpanan_jenis,
                                $rutin,
                                $nip,
                                $nama,
                                $tanggal_simpanan,
                                $nama_simpanan,
                                $keterangan,
                                $nominal
                            );

                            // Eksekusi query

                            if ($stmt->execute()) {
                                // Tutup statement
                                $stmt->close();
                                
                                $kategori_log="Log Simpanan";
                                $deskripsi_log="Tambah Simpanan";
                                $InputLog=addLog($Conn,$SessionIdAkses,$now,$kategori_log,$deskripsi_log);
                                if($InputLog=="Success"){
                                   echo '<small class="text-success" id="NotifikkasiTambahSimpananBerhasil">Success</small>';
                                }else{
                                    echo '
                                        <div class="alert alert-danger"><small>Terjadi kesalahan pada saat menyimpan log!<br>Error : '.$InputLog.'</small></div>
                                    ';
                                }
                            }else{
                               echo '
                                    <div class="alert alert-danger"><small>Terjadi kesalahan pada saat menyimpan simpanan! <br>Error : '.$Conn->error.'</small></div>
                                ';
                            }
                        }
                    }
                }
            }
        }
    }
?>
<?php
    //Koneksi
    include "../../_Config/Connection.php";
    include "../../_Config/GlobalFunction.php";
    include "../../_Config/Session.php";
    date_default_timezone_set('Asia/Jakarta');
    //Time Now Tmp
    $now=date('Y-m-d H:i:s');
    if(empty($SessionIdAkses)){
        echo '<small class="text-danger">Sessi Akses Sudah Berakhir, Silahkan Login Ulang!</small>';
    }else{
        //Validasi tanggal tidak boleh kosong
        if(empty($_POST['tanggal'])){
            echo '<small class="text-danger">Tanggal Simpanan Tidak Boleh Kosong!</small>';
        }else{
            //Validasi id_simpanan_jenis tidak boleh kosong
            if(empty($_POST['id_simpanan_jenis'])){
                echo '<small class="text-danger">Jenis Simpanan Tidak Boleh Kosong!</small>';
            }else{
                //Validasi nominal tidak boleh kosong
                if(empty($_POST['nominal'])){
                    echo '<small class="text-danger">Nominal Simpanan Tidak Boleh Kosong!</small>';
                }else{
                    //Validasi id_anggota tidak boleh kosong
                    if(empty($_POST['id_anggota'])){
                        echo '<small class="text-danger">ID Anggota Tidak Boleh Kosong!</small>';
                    }else{
                        //Validasi id_simpanan tidak boleh kosong
                        if(empty($_POST['id_simpanan'])){
                            echo '<small class="text-danger">ID Anggota Tidak Boleh Kosong!</small>';
                        }else{
                            //Membuat Variabel
                            if(empty($_POST['keterangan'])){
                                $keterangan="";
                            }else{
                                $keterangan=$_POST['keterangan'];
                            }
                            $id_simpanan=$_POST['id_simpanan'];
                            $id_anggota=$_POST['id_anggota'];
                            $tanggal_simpanan=$_POST['tanggal'];
                            $id_simpanan_jenis=$_POST['id_simpanan_jenis'];
                            $nominal=$_POST['nominal'];
                            //Bersihkan Variabel
                            $id_simpanan=validateAndSanitizeInput($id_simpanan);
                            $id_anggota=validateAndSanitizeInput($id_anggota);
                            $tanggal_simpanan=validateAndSanitizeInput($tanggal_simpanan);
                            $id_simpanan_jenis=validateAndSanitizeInput($id_simpanan_jenis);
                            $nominal=validateAndSanitizeInput($nominal);
                            $keterangan=validateAndSanitizeInput($keterangan);
                            //Buka UIID Simpanan
                            $uuid_simpanan=GetDetailData($Conn,'simpanan','id_simpanan',$id_simpanan,'uuid_simpanan');
                            //Buka Anggota
                            $nip=GetDetailData($Conn,'anggota','id_anggota',$id_anggota,'nip');
                            $nama=GetDetailData($Conn,'anggota','id_anggota',$id_anggota,'nama');
                            $lembaga=GetDetailData($Conn,'anggota','id_anggota',$id_anggota,'lembaga');
                            $ranking=GetDetailData($Conn,'anggota','id_anggota',$id_anggota,'ranking');
                            //Buka jenis simpanan
                            if($id_simpanan_jenis=="Penarikan"){
                                $id_simpanan_jenis=0;
                                $nama_simpanan="Penarikan";
                                $rutin=0;
                                $id_perkiraan_debet=GetDetailData($Conn,'auto_jurnal','kategori_transaksi','Penarikan','debet_id');
                                $id_perkiraan_kredit=GetDetailData($Conn,'auto_jurnal','kategori_transaksi','Penarikan','kredit_id');
                            }else{
                                $nama_simpanan=GetDetailData($Conn,'simpanan_jenis','id_simpanan_jenis',$id_simpanan_jenis,'nama_simpanan');
                                $rutin=GetDetailData($Conn,'simpanan_jenis','id_simpanan_jenis',$id_simpanan_jenis,'rutin');
                                $id_perkiraan_debet=GetDetailData($Conn,'simpanan_jenis','id_simpanan_jenis',$id_simpanan_jenis,'id_perkiraan_debet');
                                $id_perkiraan_kredit=GetDetailData($Conn,'simpanan_jenis','id_simpanan_jenis',$id_simpanan_jenis,'id_perkiraan_kredit');
                            }
                            //Cek Apakah ID Perkiraan Ada Pada Data Akun Perkiraan
                            $id_perkiraan_debet=GetDetailData($Conn,'akun_perkiraan','id_perkiraan',$id_perkiraan_debet,'id_perkiraan');
                            $id_perkiraan_kredit=GetDetailData($Conn,'akun_perkiraan','id_perkiraan',$id_perkiraan_kredit,'id_perkiraan');
                            if(empty($id_perkiraan_debet)){
                                echo '<small class="text-danger">Periksa pengaturan akun debet pada jenis simpanan yang anda gunakkkan!</small>';
                            }else{
                                if(empty($id_perkiraan_kredit)){
                                    echo '<small class="text-danger">Periksa pengaturan akun kredit pada jenis simpanan yang anda gunakkkan!</small>';
                                }else{
                                    //Insert
                                    $query = "UPDATE simpanan SET 
                                        id_simpanan_jenis=?, 
                                        rutin=?, 
                                        tanggal=?, 
                                        nama=?, 
                                        kategori=?, 
                                        keterangan=?, 
                                        jumlah=? 
                                    WHERE id_simpanan=?";

                                    $stmt = $Conn->prepare($query);
                                    if ($stmt === false) {
                                        die("Error: " . $Conn->error); // Cek jika terjadi kesalahan pada query
                                    }

                                    $stmt->bind_param("sisssssi", 
                                        $id_simpanan_jenis, 
                                        $rutin, 
                                        $tanggal_simpanan, 
                                        $nama, 
                                        $nama_simpanan, 
                                        $keterangan, 
                                        $nominal, 
                                        $id_simpanan
                                    );

                                    if ($stmt->execute()) {
                                        //Hapus Jurnal Yang Lama
                                        $HapusJurnal = mysqli_query($Conn, "DELETE FROM jurnal WHERE kategori='Simpanan' AND uuid='$uuid_simpanan'") or die(mysqli_error($Conn));
                                        if ($HapusJurnal) {
                                            //Membuat Jurnal
                                            //Buka Akun Debet
                                            $NamaAkunDebet=GetDetailData($Conn,'akun_perkiraan','id_perkiraan',$id_perkiraan_debet,'nama');
                                            $KodeAkunDebet=GetDetailData($Conn,'akun_perkiraan','id_perkiraan',$id_perkiraan_debet,'kode');
                                            //Buka Akun Kredit
                                            $NamaAkunKredit=GetDetailData($Conn,'akun_perkiraan','id_perkiraan',$id_perkiraan_kredit,'nama');
                                            $KodeAkunKredit=GetDetailData($Conn,'akun_perkiraan','id_perkiraan',$id_perkiraan_kredit,'kode');
                                            //Simpan Jurnal Debet
                                            $EntryJurnalDebet="INSERT INTO jurnal (
                                                kategori,
                                                uuid,
                                                id_simpanan,
                                                tanggal,
                                                kode_perkiraan,
                                                nama_perkiraan,
                                                d_k,
                                                nilai
                                            ) VALUES (
                                                'Simpanan',
                                                '$uuid_simpanan',
                                                '$id_simpanan',
                                                '$tanggal_simpanan',
                                                '$KodeAkunDebet',
                                                '$NamaAkunDebet',
                                                'D',
                                                '$nominal'
                                            )";
                                            $InputJurnalDebet=mysqli_query($Conn, $EntryJurnalDebet);
                                            if($InputJurnalDebet){
                                            //Simpan Jurnal Kredit
                                                $EntryJurnalKredit="INSERT INTO jurnal (
                                                    kategori,
                                                    uuid,
                                                    id_simpanan,
                                                    tanggal,
                                                    kode_perkiraan,
                                                    nama_perkiraan,
                                                    d_k,
                                                    nilai
                                                ) VALUES (
                                                    'Simpanan',
                                                    '$uuid_simpanan',
                                                    '$id_simpanan',
                                                    '$tanggal_simpanan',
                                                    '$KodeAkunKredit',
                                                    '$NamaAkunKredit',
                                                    'K',
                                                    '$nominal'
                                                )";
                                                $InputJurnalKredit=mysqli_query($Conn, $EntryJurnalKredit);
                                                if($InputJurnalKredit){
                                                    $KategoriLog="Log Simpanan";
                                                    $KeteranganLog="Edit Simpanan";
                                                    include "../../_Config/InputLog.php";
                                                    echo '<small class="text-success" id="NotifikasiEditSimpananBerhasil">Success</small>';
                                                }else{
                                                    echo '<small class="text-danger">Terjadi kesalahan pada saat menyimpan data pada jurnal kredit</small>';
                                                }
                                            }else{
                                                echo '<small class="text-danger">Terjadi kesalahan pada saat menyimpan data pada jurnal debet</small>';
                                            }
                                        }else{
                                            echo '<small class="text-danger">Terjadi kesalahan pada saat menghapus jurnal lama.</small>';
                                        }
                                    }else{
                                        echo '<small class="text-danger">Terjadi kesalahan pada saat menyimpan data.</small>';
                                    }
                                    $stmt->close();
                                }
                            }
                        }
                    }
                }
            }
        }
    }
?>
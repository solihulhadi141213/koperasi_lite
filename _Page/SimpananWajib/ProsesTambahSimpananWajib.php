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
                    //Validasi tahun tidak boleh kosong
                    if(empty($_POST['tahun'])){
                        echo '<small class="text-danger">Tahun Simpanan Tidak Boleh Kosong!</small>';
                    }else{
                        //Validasi bulan tidak boleh kosong
                        if(empty($_POST['bulan'])){
                            echo '<small class="text-danger">Bulan Simpanan Tidak Boleh Kosong!</small>';
                        }else{
                            $tahun=$_POST['tahun'];
                            $bulan=$_POST['bulan'];
                            $tanggal_simpanan=$_POST['tanggal'];
                            $id_simpanan_jenis=$_POST['id_simpanan_jenis'];
                            $nominal=$_POST['nominal'];
                            //Bersihkan Variabel
                            $tahun=validateAndSanitizeInput($tahun);
                            $bulan=validateAndSanitizeInput($bulan);
                            $tanggal_simpanan=validateAndSanitizeInput($tanggal_simpanan);
                            $id_simpanan_jenis=validateAndSanitizeInput($id_simpanan_jenis);
                            $nominal=validateAndSanitizeInput($nominal);
                            $nama_simpanan=GetDetailData($Conn,'simpanan_jenis','id_simpanan_jenis',$id_simpanan_jenis,'nama_simpanan');
                            $rutin=GetDetailData($Conn,'simpanan_jenis','id_simpanan_jenis',$id_simpanan_jenis,'rutin');
                            $id_perkiraan_debet=GetDetailData($Conn,'simpanan_jenis','id_simpanan_jenis',$id_simpanan_jenis,'id_perkiraan_debet');
                            $id_perkiraan_kredit=GetDetailData($Conn,'simpanan_jenis','id_simpanan_jenis',$id_simpanan_jenis,'id_perkiraan_kredit');
                            //Cek Apakah ID Perkiraan Ada Pada Data Akun Perkiraan
                            $id_perkiraan_debet=GetDetailData($Conn,'akun_perkiraan','id_perkiraan',$id_perkiraan_debet,'id_perkiraan');
                            $id_perkiraan_kredit=GetDetailData($Conn,'akun_perkiraan','id_perkiraan',$id_perkiraan_kredit,'id_perkiraan');
                            //Tahun Bulan 
                            $TahunBulan="$tahun-$bulan";
                            //Jumlah Anggota Aktif
                            $JumlahAnggotaAktif=mysqli_num_rows(mysqli_query($Conn, "SELECT id_anggota FROM anggota WHERE status='Aktif'"));
                            //Looping Anggota
                            $JumlahBerhasil=0;
                            echo '<ol>';
                            $query = mysqli_query($Conn, "SELECT*FROM anggota WHERE status='Aktif'");
                            while ($data = mysqli_fetch_array($query)) {
                                $id_anggota= $data['id_anggota'];
                                $nip= $data['nip'];
                                $nama= $data['nama'];
                                $lembaga= $data['lembaga'];
                                $ranking= $data['ranking'];
                                $QryDuplikat = mysqli_query($Conn,"SELECT * FROM simpanan WHERE (id_anggota='$id_anggota' AND id_simpanan_jenis='$id_simpanan_jenis') AND (tanggal like '%$TahunBulan%')")or die(mysqli_error($Conn));
                                $DataDuplikat = mysqli_fetch_array($QryDuplikat);
                                if(!empty($DataDuplikat['id_simpanan'])){
                                    $id_simpanan=$DataDuplikat['id_simpanan'];
                                    $uuid_simpanan=$DataDuplikat['uuid_simpanan'];
                                    //Update
                                    $UpdateSimpananWajib = mysqli_query($Conn,"UPDATE simpanan SET 
                                        tanggal='$tanggal_simpanan',
                                        jumlah='$nominal'
                                    WHERE id_simpanan='$id_simpanan'") or die(mysqli_error($Conn)); 
                                    if($UpdateSimpananWajib){
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
                                                tanggal,
                                                kode_perkiraan,
                                                nama_perkiraan,
                                                d_k,
                                                nilai
                                            ) VALUES (
                                                'Simpanan',
                                                '$uuid_simpanan',
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
                                                    tanggal,
                                                    kode_perkiraan,
                                                    nama_perkiraan,
                                                    d_k,
                                                    nilai
                                                ) VALUES (
                                                    'Simpanan',
                                                    '$uuid_simpanan',
                                                    '$tanggal_simpanan',
                                                    '$KodeAkunKredit',
                                                    '$NamaAkunKredit',
                                                    'K',
                                                    '$nominal'
                                                )";
                                                $InputJurnalKredit=mysqli_query($Conn, $EntryJurnalKredit);
                                                if($InputJurnalKredit){
                                                    $JumlahBerhasil=$JumlahBerhasil+1;
                                                    echo '<li><code class="text-warning">Simpanan atas nama <b>'.$nama.'</b> Berhasil Diperbaharui</code></li>';
                                                }else{
                                                    $JumlahBerhasil=$JumlahBerhasil+0;
                                                    echo '<li><code class="text-danger">Simpanan atas nama <b>'.$nama.'</b> Terjadi kesalahan pada saat menyimpan data pada jurnal kredit</code></li>';
                                                }
                                            }else{
                                                $JumlahBerhasil=$JumlahBerhasil+0;
                                                echo '<li><code class="text-danger">Simpanan atas nama <b>'.$nama.'</b> Terjadi kesalahan pada saat menyimpan data pada jurnal debet</code></li>';
                                            }
                                        }else{
                                            $JumlahBerhasil=$JumlahBerhasil+0;
                                            echo '<li><code class="text-danger">Simpanan atas nama <b>'.$nama.'</b> Terjadi kesalahan pada saat menghapus jurnal lama</code></li>';
                                        }
                                    }else{
                                        $JumlahBerhasil=$JumlahBerhasil+0;
                                        echo '<li><code class="text-danger">Simpanan atas nama <b>'.$nama.'</b> Gagal Diperbaharui</code></li>';
                                    }
                                }else{
                                    //Membuat UUID
                                    $uuid_simpanan=generateUuidV1();
                                    //Insert Simpanan
                                    $EntrySimpanan="INSERT INTO simpanan (
                                        uuid_simpanan,
                                        id_anggota,
                                        id_akses,
                                        id_simpanan_jenis,
                                        rutin,
                                        nip,
                                        nama,
                                        lembaga,
                                        ranking,
                                        tanggal,
                                        kategori,
                                        keterangan,
                                        jumlah
                                    ) VALUES (
                                        '$uuid_simpanan',
                                        '$id_anggota',
                                        '$SessionIdAkses',
                                        '$id_simpanan_jenis',
                                        '$rutin',
                                        '$nip',
                                        '$nama',
                                        '$lembaga',
                                        '$ranking',
                                        '$tanggal_simpanan',
                                        '$nama_simpanan',
                                        '',
                                        '$nominal'
                                    )";
                                    $InputSimpananWajib=mysqli_query($Conn, $EntrySimpanan);
                                    if($InputSimpananWajib){
                                        //Cari id_simpanan
                                        $id_simpanan=GetDetailData($Conn,'simpanan','uuid_simpanan',$uuid_simpanan,'id_simpanan');
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
                                                $JumlahBerhasil=$JumlahBerhasil+1;
                                                echo '<li><code class="text-success">Simpanan atas nama <b>'.$nama.'</b> Berhasil Disimpan</code></li>';
                                            }else{
                                                $JumlahBerhasil=$JumlahBerhasil+0;
                                                echo '<li><code class="text-danger">Simpanan atas nama <b>'.$nama.'</b> Terjadi kesalahan pada saat menyimpan data pada jurnal kredit</code></li>';
                                            }
                                        }else{
                                            $JumlahBerhasil=$JumlahBerhasil+0;
                                            echo '<li><code class="text-danger">Simpanan atas nama <b>'.$nama.'</b> Terjadi kesalahan pada saat menyimpan data pada jurnal debet</code></li>';
                                        }
                                    }else{
                                        $JumlahBerhasil=$JumlahBerhasil+0;
                                        echo '<li><code class="text-danger">Simpanan atas nama <b>'.$nama.'</b> Gagal Disimpan</code></li>';
                                    }
                                }
                            }
                            echo '</ol>';
                            if($JumlahBerhasil==$JumlahAnggotaAktif){
                                $kategori_log="Simpanan Wajib";
                                $deskripsi_log="Tambah Simpanan Wajib";
                                $InputLog=addLog($Conn,$SessionIdAkses,$now,$kategori_log,$deskripsi_log);
                                if($InputLog=="Success"){
                                    echo '<small class="text-success">Semua Data Simpanan Berhasil Disimpan. Silahkan tutup form ini.</small>';
                                }else{
                                    echo '<small class="text-danger">Terjadi kesalahan pada saat menyimpan log.</small>';
                                }
                            }else{
                                echo '<small class="text-danger">Terjadi kesalahan pada saat menyimpan data.</small>';
                            }
                        }
                    }
                }
            }
        }
    }
?>
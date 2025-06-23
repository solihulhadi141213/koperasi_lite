<?php
    //koneksi dan session
    include "../../_Config/Connection.php";
    include "../../_Config/GlobalFunction.php";
    include "../../_Config/Session.php";
    date_default_timezone_set("Asia/Jakarta");
    //Time Now Tmp
    $now=date('Y-m-d H:i:s');
    $tanggal=date('Y-m-d');

    //Validasi Akses
    if(empty($SessionIdAkses)){
        echo '<div class="alert alert-danger">Sesi Akses Sudah Berakhir, Silahkan Login Ulang</div>';
    }else{
        //Validasi id_shu_session tidak boleh kosong
        if(empty($_POST['id_shu_session'])){
            echo '<div class="alert alert-danger">ID SHU Tidak Boleh Kosong!</div>';
        }else{

            //Buat Variabel
            $id_shu_session=validateAndSanitizeInput($_POST['id_shu_session']);
            $status="Realisasi";

            //Buka UUID
            $uuid_shu_session=GetDetailData($Conn,'shu_session','id_shu_session',$id_shu_session,'uuid_shu_session');

            //Update Status Dengan Query menggunakan Prepared Statement
            $query = "UPDATE shu_session SET 
                status = ?
            WHERE id_shu_session = ?";

            // Persiapkan query
            $stmt = mysqli_prepare($Conn, $query);

            if (!$stmt) {
                $error=mysqli_error($Conn);
                echo '<div class="alert alert-danger">Gagal menyiapkan statement!.<br> Keterangan : '.$error.'</div>'; 
            }else{

                // Bind parameter (s: string, d: double/float, i: integer)
                mysqli_stmt_bind_param($stmt, "si", 
                    $status, 
                    $id_shu_session
                );

                // Eksekusi query
                if (mysqli_stmt_execute($stmt)) {

                    //Apabila Berhasil Hitung Jumlah Rincian SHU
                    $sum_alokasi= mysqli_fetch_array(mysqli_query($Conn, "SELECT SUM(shu) AS jumlah FROM shu_rincian WHERE id_shu_session='$id_shu_session'"));
                    if(!empty($sum_alokasi['jumlah'])){
                        $jumlah_alokasi = $sum_alokasi['jumlah'];
                    }else{
                        $jumlah_alokasi =0;
                    }

                    //Buka Auto Jurnal

                    // Mendapatkan data Pembagian SHU
                    $pembagianShu = getAutoJurnalSHU($Conn, 'Pembagian');
                    $id_perkiraan_debet_pembagian = $pembagianShu['id_perkiraan_debet'];
                    $id_perkiraan_kredit_pembagian = $pembagianShu['id_perkiraan_kredit'];

                    //Tambah Jurnal Pembagian Debet
                    if(!empty($id_perkiraan_debet_pembagian)){
                        $nama_perkiraan=GetDetailData($Conn, 'akun_perkiraan', 'id_perkiraan', $id_perkiraan_debet_pembagian, 'nama');
                        $kode_perkiraan=GetDetailData($Conn, 'akun_perkiraan', 'id_perkiraan', $id_perkiraan_debet_pembagian, 'kode');
                        //Tambahkan Jurnal
                        $EntryData="INSERT INTO jurnal (
                            kategori,
                            uuid,
                            id_shu_session ,
                            tanggal,
                            kode_perkiraan,
                            nama_perkiraan,
                            d_k,
                            nilai
                        ) VALUES (
                            'SHU',
                            '$uuid_shu_session',
                            '$id_shu_session',
                            '$tanggal',
                            '$kode_perkiraan',
                            '$nama_perkiraan',
                            'D',
                            '$jumlah_alokasi'
                        )";
                        $InputData=mysqli_query($Conn, $EntryData);
                        if($InputData){
                            $proses_pembagian_debet="Berhasil";
                        }else{
                            $proses_pembagian_debet="Terjadi Kesalahan Pada Saat Menyimpan Jurnal Pembagian Debet";
                        }
                    }else{
                        $proses_pembagian_debet="Berhasil";
                    }

                    //Jika Terjadi Kesalahan
                    if($proses_pembagian_debet!=="Berhasil"){
                        echo '
                            <div class="alert alert-danger">
                                '.$proses_pembagian_debet.'
                            </div>
                        '; 
                    }else{

                        //Tambahkan Jurnal Pembagian Kredit
                        if(!empty($id_perkiraan_kredit_pembagian)){
                            $nama_perkiraan=GetDetailData($Conn, 'akun_perkiraan', 'id_perkiraan', $id_perkiraan_kredit_pembagian, 'nama');
                            $kode_perkiraan=GetDetailData($Conn, 'akun_perkiraan', 'id_perkiraan', $id_perkiraan_kredit_pembagian, 'kode');

                            //Tambahkan Jurnal
                            $EntryData="INSERT INTO jurnal (
                                kategori,
                                uuid,
                                id_shu_session ,
                                tanggal,
                                kode_perkiraan,
                                nama_perkiraan,
                                d_k,
                                nilai
                            ) VALUES (
                                'SHU',
                                '$uuid_shu_session',
                                '$id_shu_session',
                                '$tanggal',
                                '$kode_perkiraan',
                                '$nama_perkiraan',
                                'K',
                                '$jumlah_alokasi'
                            )";
                            $InputData=mysqli_query($Conn, $EntryData);
                            if($InputData){
                                $proses_pembagian_kredit="Berhasil";
                            }else{
                                $proses_pembagian_kredit="Terjadi Kesalahan Pada Saat Menyimpan Jurnal Pembagian Kredit";
                            }
                        }else{
                            $proses_pembagian_kredit="Berhasil";
                        }

                        //Jika Terjadi Kesalahan
                        if($proses_pembagian_kredit!=="Berhasil"){
                            echo '
                                <div class="alert alert-danger">
                                    '.$proses_pembagian_kredit.'
                                </div>
                            '; 
                        }else{

                            // Mendapatkan data Pembayaran SHU
                            $pembayaranShu = getAutoJurnalSHU($Conn, 'Pembayaran');
                            $id_perkiraan_debet_pembayaran = $pembayaranShu['id_perkiraan_debet'];
                            $id_perkiraan_kredit_pembayaran = $pembayaranShu['id_perkiraan_kredit'];

                            //Tambahkan Jurnal Pembayaran Debet
                            if(!empty($id_perkiraan_debet_pembayaran)){
                                $nama_perkiraan=GetDetailData($Conn, 'akun_perkiraan', 'id_perkiraan', $id_perkiraan_debet_pembayaran, 'nama');
                                $kode_perkiraan=GetDetailData($Conn, 'akun_perkiraan', 'id_perkiraan', $id_perkiraan_debet_pembayaran, 'kode');
                                
                                //Tambahkan Jurnal
                                $EntryData="INSERT INTO jurnal (
                                    kategori,
                                    uuid,
                                    id_shu_session ,
                                    tanggal,
                                    kode_perkiraan,
                                    nama_perkiraan,
                                    d_k,
                                    nilai
                                ) VALUES (
                                    'SHU',
                                    '$uuid_shu_session',
                                    '$id_shu_session',
                                    '$tanggal',
                                    '$kode_perkiraan',
                                    '$nama_perkiraan',
                                    'D',
                                    '$jumlah_alokasi'
                                )";
                                $InputData=mysqli_query($Conn, $EntryData);
                                if($InputData){
                                    $proses_pembayaran_debet="Berhasil";
                                }else{
                                    $proses_pembayaran_debet="Terjadi Kesalahan Pada Saat Menyimpan Jurnal Pembayaran Debet";
                                }
                            }else{
                                $proses_pembayaran_debet="Berhasil";
                            }

                            //Jika Terjadi Kesalahan
                            if($proses_pembayaran_debet!=="Berhasil"){
                                echo '
                                    <div class="alert alert-danger">
                                        '.$proses_pembayaran_debet.'
                                    </div>
                                '; 
                            }else{

                                //Tambahkan Jurnal Pembayaran Kredit
                                if(!empty($id_perkiraan_kredit_pembayaran)){
                                    $nama_perkiraan=GetDetailData($Conn, 'akun_perkiraan', 'id_perkiraan', $id_perkiraan_kredit_pembayaran, 'nama');
                                    $kode_perkiraan=GetDetailData($Conn, 'akun_perkiraan', 'id_perkiraan', $id_perkiraan_kredit_pembayaran, 'kode');

                                    //Tambahkan Jurnal
                                    $EntryData="INSERT INTO jurnal (
                                        kategori,
                                        uuid,
                                        id_shu_session ,
                                        tanggal,
                                        kode_perkiraan,
                                        nama_perkiraan,
                                        d_k,
                                        nilai
                                    ) VALUES (
                                        'SHU',
                                        '$uuid_shu_session',
                                        '$id_shu_session',
                                        '$tanggal',
                                        '$kode_perkiraan',
                                        '$nama_perkiraan',
                                        'K',
                                        '$jumlah_alokasi'
                                    )";
                                    $InputData=mysqli_query($Conn, $EntryData);
                                    if($InputData){
                                        $proses_pembayaran_kredit="Berhasil";
                                    }else{
                                        $proses_pembayaran_kredit="Terjadi Kesalahan Pada Saat Menyimpan Jurnal Pembayaran Kredit";
                                    }
                                }else{
                                    $proses_pembayaran_kredit="Berhasil";
                                }

                                //Jika Terjadi Kesalahan
                                if($proses_pembayaran_kredit!=="Berhasil"){
                                    echo '
                                        <div class="alert alert-danger">
                                            '.$proses_pembayaran_kredit.'
                                        </div>
                                    '; 
                                }else{
                                    //Simpan Log
                                    $kategori_log="SHU";
                                    $deskripsi_log="Update Status SHU";
                                    $InputLog=addLog($Conn,$SessionIdAkses,$now,$kategori_log,$deskripsi_log);
                                    if($InputLog=="Success"){
                                        echo '<div class="alert alert-success"><small id="NotifikasiUpdateStatusShuBerhasil">Success</small></div>'; 
                                    }else{
                                        echo '<div class="alert alert-danger">Terjadi kesalahan pada saat menyimpan log aktivitas!</div>'; 
                                    }
                                }
                            }
                        }
                    }
                } else {
                    $error=mysqli_stmt_error($stmt);
                    echo '<div class="alert alert-danger">Terjadi kesalahan pada saat memperbaharui data.<br> Keterangan : '.$error.'</div>'; 
                }
            }
            // Tutup statement
            mysqli_stmt_close($stmt);
        }
    }
?>
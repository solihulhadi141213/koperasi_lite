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

                        //BERIKUT INI ADALAH SCRIPT KHUSUS UNTUK PENARIKAN SEMUA DANA SIMPANAN
                        if($kategori_simpanan_penarikan=="Penarikan" && $id_simpanan_jenis=="Semua"){
                            //Cek auto jurnal
                            
                            //Buka Setting Auto Jurnal Penarikan
                            $debet_id=GetDetailData($Conn,'auto_jurnal','kategori_transaksi','Penarikan','debet_id');
                            $kredit_id=GetDetailData($Conn,'auto_jurnal','kategori_transaksi','Penarikan','kredit_id');
                            
                            //Buka Kode Akun dan nama Debet Penarikan
                            $KodeAkunDebet=GetDetailData($Conn,'akun_perkiraan','id_perkiraan',$debet_id,'kode');
                            $NamaAkunDebet=GetDetailData($Conn,'akun_perkiraan','id_perkiraan',$debet_id,'nama');
                            
                            //Buka Kode Akun dan nama Kredit Penarikan
                            $KodeAkunKredit=GetDetailData($Conn,'akun_perkiraan','id_perkiraan',$kredit_id,'kode');
                            $NamaAkunKredit=GetDetailData($Conn,'akun_perkiraan','id_perkiraan',$kredit_id,'nama');
                            
                            //Apabila Autojurnal Belum Ada
                            if(empty($KodeAkunDebet)||empty($KodeAkunKredit)){
                                echo '<div class="alert alert-danger">Pengaturan Auto Jurnal Trransaksi Penarikan Tidak Boleh Kosong</div>';
                            }else{
                                
                                 //Buka Anggota
                                $nip=GetDetailData($Conn,'anggota','id_anggota',$id_anggota,'nip');
                                $nama=GetDetailData($Conn,'anggota','id_anggota',$id_anggota,'nama');
                                $lembaga=GetDetailData($Conn,'anggota','id_anggota',$id_anggota,'lembaga');
                                $ranking=GetDetailData($Conn,'anggota','id_anggota',$id_anggota,'ranking');

                                //Looping Jenis Simpanan
                                $jumlah_data_yang_diproses=0;
                                $no=1;
                                $notifikasi_error=[];
                                $query_jenis_simpanan = mysqli_query($Conn, "SELECT*FROM simpanan_jenis");
                                while ($data_jenis_simpanan = mysqli_fetch_array($query_jenis_simpanan)) {
                                    $id_simpanan_jenis_list= $data_jenis_simpanan['id_simpanan_jenis'];
                                    
                                    //Hitung Jumlah Simpanan Bersih Masing-Masing Jenis
                                    $SumSimpananKotor = mysqli_fetch_array(mysqli_query($Conn, "SELECT SUM(jumlah) AS jumlah FROM simpanan WHERE id_simpanan_jenis='$id_simpanan_jenis_list' AND id_anggota='$id_anggota' AND kategori!='Penarikan'"));
                                    $JumlahSimpananKotor = $SumSimpananKotor['jumlah'];
                                    
                                    //Hitung Jumlah Penarikan
                                    $SumPenarikan = mysqli_fetch_array(mysqli_query($Conn, "SELECT SUM(jumlah) AS jumlah FROM simpanan WHERE id_simpanan_jenis='$id_simpanan_jenis_list' AND id_anggota='$id_anggota' AND kategori='Penarikan'"));
                                    $JumlahPenarikan = $SumPenarikan['jumlah'];
                                    
                                    //Hitung Jumlah Simpanan Bersih
                                    $simpanan_bersih=$JumlahSimpananKotor-$JumlahPenarikan;

                                    //Apabila $simpanan_bersih tidak kosong maka simpan data
                                    if(!empty($simpanan_bersih)){
                                        $jumlah_data_yang_diproses=$jumlah_data_yang_diproses+1;
                                        $rutin=0;
                                        $nama_simpanan="Penarikan";
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
                                            lembaga,
                                            ranking,
                                            tanggal,
                                            kategori,
                                            keterangan,
                                            jumlah
                                        ) VALUES (
                                            ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?
                                        )";

                                        // Persiapkan statement
                                        $stmt = $Conn->prepare($query);
                                        if (!$stmt) {
                                            $notifikasi_error[]=[
                                                "no"=>$id_simpanan_jenis_list,
                                                "Error"=>$Conn->error,
                                            ];
                                        }else{
                                            // Bind parameter ke query
                                            $stmt->bind_param(
                                                "ssisssssisssd", // Jenis data: s = string, i = integer, d = double
                                                $uuid_simpanan,
                                                $id_anggota,
                                                $SessionIdAkses,
                                                $id_simpanan_jenis_list,
                                                $rutin,
                                                $nip,
                                                $nama,
                                                $lembaga,
                                                $ranking,
                                                $tanggal_simpanan,
                                                $nama_simpanan,
                                                $keterangan,
                                                $simpanan_bersih
                                            );

                                            // Eksekusi query

                                            if ($stmt->execute()) {
                                                // Tutup statement
                                                $stmt->close();
                                                //Cari id_simpanan
                                                $id_simpanan=GetDetailData($Conn,'simpanan','uuid_simpanan',$uuid_simpanan,'id_simpanan');
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
                                                    '$simpanan_bersih'
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
                                                        '$simpanan_bersih'
                                                    )";
                                                    $InputJurnalKredit=mysqli_query($Conn, $EntryJurnalKredit);
                                                    if($InputJurnalKredit){
                                                        $kategori_log="Log Simpanan";
                                                        $deskripsi_log="Tambah Penarikan";
                                                        $InputLog=addLog($Conn,$SessionIdAkses,$now,$kategori_log,$deskripsi_log);
                                                        if($InputLog=="Success"){
                                                            $notifikasi_error=[];
                                                        }else{
                                                            $error="Terjadi kesalahan pada saat menyimpan log";
                                                            $notifikasi_error[]=[
                                                                "no"=>$id_simpanan_jenis_list,
                                                                "Error"=>$error,
                                                            ];
                                                        }
                                                    }else{
                                                        $error="Terjadi kesalahan pada saat menyimpan data pada jurnal kredit";
                                                        $notifikasi_error[]=[
                                                            "no"=>$id_simpanan_jenis_list,
                                                            "Error"=>$error,
                                                        ];
                                                    }
                                                }else{
                                                    $error="Terjadi kesalahan pada saat menyimpan data pada jurnal debet";
                                                    $notifikasi_error[]=[
                                                        "no"=>$id_simpanan_jenis_list,
                                                        "Error"=>$error,
                                                    ];
                                                }
                                            }else{
                                                $notifikasi_error[]=[
                                                    "no"=>$id_simpanan_jenis_list,
                                                    "Error"=>$stmt->error,
                                                ];
                                            }
                                        }
                                    }else{
                                        $jumlah_data_yang_diproses=$jumlah_data_yang_diproses+1;
                                    }
                                    $no++;
                                }
                                //Apabila Tiidak Ada Data Yang Diproses
                                if(empty($jumlah_data_yang_diproses)){
                                    echo '
                                        <div class="alert alert-danger"><small>Tidak Ada Data Yang Diproses!</small></div>
                                    ';
                                }else{
                                    //Validasi Proses Yang dilakukan melalui apakah ada error
                                    if (!empty($notifikasi_error)){
                                        echo '<div class="alert alert-danger">';
                                        echo '  <small class="text-muted">';
                                        echo '      <ul>';
                                        foreach ($notifikasi_error as $error){
                                            echo '
                                                <li>
                                                    <b>ID : '.$error['no'].'</b> <ii>'.$error['Error'].'</ii>
                                                </li>
                                            ';
                                        }
                                        echo '      </ul>';
                                        echo '  </small>';
                                        echo '</div>';
                                    }else{
                                        echo '<small class="text-success" id="NotifikkasiTambahSimpananBerhasil">Success</small>';
                                    }
                                }
                            }
                        }else{
                        
                            //BERIKUT INI ADALAH SCRIPT KHUSUS UNTUK PENARIKAN (TIDAK SEMUA)
                            if ($kategori_simpanan_penarikan == "Simpanan" && empty($id_simpanan_jenis)) {
                                $id_simpanan_jenis =NULL;
                                $validasi_nilai ="Tidak Valid";
                            } elseif (empty($id_simpanan_jenis)) {
                                $id_simpanan_jenis =NULL;
                                $validasi_nilai ="Valid";
                            }

                            // Tampilkan pesan error hanya jika $id_simpanan_jenis adalah "Tidak Valid"
                            if (empty($id_simpanan_jenis)) {
                                echo '
                                    <div class="alert alert-danger">
                                        <small>Sumber Dana Penarikan Tidak Boleh Kosong</small>
                                    </div>
                                ';
                            } else {
                                
                                //Buka Anggota
                                $nip=GetDetailData($Conn,'anggota','id_anggota',$id_anggota,'nip');
                                $nama=GetDetailData($Conn,'anggota','id_anggota',$id_anggota,'nama');
                                $lembaga=GetDetailData($Conn,'anggota','id_anggota',$id_anggota,'lembaga');
                                $ranking=GetDetailData($Conn,'anggota','id_anggota',$id_anggota,'ranking');
                                //Ciptakan UUID
                                $uuid_simpanan=generateUuidV1();
                                //Antara Penarikan dan Simpanan
                                if($kategori_simpanan_penarikan=="Penarikan"){
                                    
                                    //Validasi Jumlah Penarikan Tidak Boleh Lebih Besar Dari Nominal Simpanan
                                    //Menghitung jumlah simpanan
                                    $SumSimpananKotor = mysqli_fetch_array(mysqli_query($Conn, "SELECT SUM(jumlah) AS jumlah FROM simpanan WHERE id_simpanan_jenis='$id_simpanan_jenis' AND id_anggota='$id_anggota' AND kategori!='Penarikan'"));
                                    $JumlahSimpananKotor = $SumSimpananKotor['jumlah'];
                                    //Hitung Jumlah Penarikan
                                    $SumPenarikan = mysqli_fetch_array(mysqli_query($Conn, "SELECT SUM(jumlah) AS jumlah FROM simpanan WHERE id_simpanan_jenis='$id_simpanan_jenis' AND id_anggota='$id_anggota' AND kategori='Penarikan'"));
                                    $JumlahPenarikan = $SumPenarikan['jumlah'];
                                    //Hitung Jumlah Simpanan Bersih
                                    $simpanan_bersih=$JumlahSimpananKotor-$JumlahPenarikan;

                                    if($simpanan_bersih<$nominal){
                                        echo '<small class="text-danger">Jumlah Penarikan Tidak Boleh Lebih Besar Dari Simpanan Yang Anda Pilih! Simpanan : '.$simpanan_bersih.' Nominal : '.$nominal.'</small>';
                                    }else{
                                        //Buka Setting Auto Jurnal Penarikan
                                        $debet_id=GetDetailData($Conn,'auto_jurnal','kategori_transaksi','Penarikan','debet_id');
                                        $kredit_id=GetDetailData($Conn,'auto_jurnal','kategori_transaksi','Penarikan','kredit_id');
                                        //Buka Kode Akun dan nama Debet Penarikan
                                        $KodeAkunDebet=GetDetailData($Conn,'akun_perkiraan','id_perkiraan',$debet_id,'kode');
                                        $NamaAkunDebet=GetDetailData($Conn,'akun_perkiraan','id_perkiraan',$debet_id,'nama');
                                        //Buka Kode Akun dan nama Kredit Penarikan
                                        $KodeAkunKredit=GetDetailData($Conn,'akun_perkiraan','id_perkiraan',$kredit_id,'kode');
                                        $NamaAkunKredit=GetDetailData($Conn,'akun_perkiraan','id_perkiraan',$kredit_id,'nama');
                                        if(empty($KodeAkunDebet)||empty($KodeAkunKredit)){
                                            echo '<small class="text-danger">Pengaturan Auto Jurnal Trransaksi Penarikan Tidak Boleh Kosong</small>';
                                        }else{
                                            $rutin=0;
                                            $nama_simpanan="Penarikan";

                                            // Query SQL dengan prepared statement
                                            $query = "INSERT INTO simpanan (
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
                                                ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?
                                            )";

                                            // Persiapkan statement
                                            $stmt = $Conn->prepare($query);
                                            if (!$stmt) {
                                                die("Error preparing statement: " . $Conn->error);
                                            }

                                            // Bind parameter ke query
                                            $stmt->bind_param(
                                                "ssisssssisssd", // Jenis data: s = string, i = integer, d = double
                                                $uuid_simpanan,
                                                $id_anggota,
                                                $SessionIdAkses,
                                                $id_simpanan_jenis,
                                                $rutin,
                                                $nip,
                                                $nama,
                                                $lembaga,
                                                $ranking,
                                                $tanggal_simpanan,
                                                $nama_simpanan,
                                                $keterangan,
                                                $nominal
                                            );

                                            // Eksekusi query

                                            if ($stmt->execute()) {
                                                // Tutup statement
                                                $stmt->close();
                                                //Cari id_simpanan
                                                $id_simpanan=GetDetailData($Conn,'simpanan','uuid_simpanan',$uuid_simpanan,'id_simpanan');
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
                                                        $kategori_log="Log Simpanan";
                                                        $deskripsi_log="Tambah Penarikan";
                                                        $InputLog=addLog($Conn,$SessionIdAkses,$now,$kategori_log,$deskripsi_log);
                                                        if($InputLog=="Success"){
                                                            echo '<small class="text-success" id="NotifikkasiTambahSimpananBerhasil">Success</small>';
                                                        }else{
                                                            echo '<small class="text-danger">Terjadi kesalahan pada saat menyimpan log</small>';
                                                        }
                                                    }else{
                                                        echo '<small class="text-danger">Terjadi kesalahan pada saat menyimpan data pada jurnal kredit</small>';
                                                    }
                                                }else{
                                                    echo '<small class="text-danger">Terjadi kesalahan pada saat menyimpan data pada jurnal debet</small>';
                                                }
                                            }else{
                                                echo '<small class="text-danger">Terjadi kesalahan pada saat menyimpan data pada database Penarikan.</small>';
                                                echo "Error: " . $stmt->error;
                                            }
                                        }
                                    }
                                }else{
                                    //Buka jenis simpanan
                                    $nama_simpanan=GetDetailData($Conn,'simpanan_jenis','id_simpanan_jenis',$id_simpanan_jenis,'nama_simpanan');
                                    $rutin=GetDetailData($Conn,'simpanan_jenis','id_simpanan_jenis',$id_simpanan_jenis,'rutin');
                                    $id_perkiraan_debet=GetDetailData($Conn,'simpanan_jenis','id_simpanan_jenis',$id_simpanan_jenis,'id_perkiraan_debet');
                                    $id_perkiraan_kredit=GetDetailData($Conn,'simpanan_jenis','id_simpanan_jenis',$id_simpanan_jenis,'id_perkiraan_kredit');
                                    //Cek Apakah ID Perkiraan Ada Pada Data Akun Perkiraan
                                    $id_perkiraan_debet=GetDetailData($Conn,'akun_perkiraan','id_perkiraan',$id_perkiraan_debet,'id_perkiraan');
                                    $id_perkiraan_kredit=GetDetailData($Conn,'akun_perkiraan','id_perkiraan',$id_perkiraan_kredit,'id_perkiraan');
                                    if(empty($id_perkiraan_debet)){
                                        echo '<small class="text-danger">Periksa pengaturan akun debet pada jenis simpanan yang anda gunakkkan!</small>';
                                    }else{
                                        if(empty($id_perkiraan_kredit)){
                                            echo '<small class="text-danger">Periksa pengaturan akun kredit pada jenis simpanan yang anda gunakkkan!</small>';
                                        }else{
                                            if($rutin==1){
                                                $rutin=1;
                                            }else{
                                                $rutin=0;
                                            }
                                            //Insert
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
                                                '$keterangan',
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
                                                        $kategori_log="Log Simpanan";
                                                        $deskripsi_log="Tambah Penarikan";
                                                        $InputLog=addLog($Conn,$SessionIdAkses,$now,$kategori_log,$deskripsi_log);
                                                        if($InputLog=="Success"){
                                                            echo '<small class="text-success" id="NotifikkasiTambahSimpananBerhasil">Success</small>';
                                                        }else{
                                                            echo '<small class="text-danger">Terjadi kesalahan pada saat menyimpan log</small>';
                                                        }
                                                    }else{
                                                        echo '<small class="text-danger">Terjadi kesalahan pada saat menyimpan data pada jurnal kredit</small>';
                                                    }
                                                }else{
                                                    echo '<small class="text-danger">Terjadi kesalahan pada saat menyimpan data pada jurnal debet</small>';
                                                }
                                            }else{
                                                echo '<small class="text-danger">Terjadi kesalahan pada saat menyimpan data pada database simpanan.</small>';
                                            }
                                        }
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
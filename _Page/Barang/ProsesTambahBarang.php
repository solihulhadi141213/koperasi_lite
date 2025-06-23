<?php
    // Koneksi
    include "../../_Config/Connection.php";
    include "../../_Config/GlobalFunction.php";
    include "../../_Config/Session.php";

    // Time Zone
    date_default_timezone_set('Asia/Jakarta');

    // Time Now Tmp
    $now = date('Y-m-d H:i:s');

    // Inisialisasi respons default
    $response = [
        "status" => "Error",
        "message" => "Belum ada proses yang dilakukan pada sistem."
    ];

    // Validasi sesi login
    if (empty($SessionIdAkses)) {
        $response = [
            "status" => "Error",
            "message" => "Sesi Akses Sudah Berakhir, Silahkan Login Ulang"
        ];
    } else {
        // Validasi Data Tidak Boleh Kosong
        $requiredFields = [
            'nama' => "Nama Barang Tidak Boleh Kosong!",
            'kategori' => "Kategori Barang Tidak Boleh Kosong!",
            'satuan' => "Satuan Barang Tidak Boleh Kosong!",
            'isi' => "Nilai satuan Isi Tidak Boleh Kosong!",
            'harga' => "Harga Beli Awal Tidak Boleh Kosong!"
        ];

        foreach ($requiredFields as $field => $errorMessage) {
            if (empty($_POST[$field])) {
                $response = [
                    "status" => "Error",
                    "message" => $errorMessage
                ];
                echo json_encode($response);
                exit;
            }
        }
        // Buat Variabel
        $nama = validateAndSanitizeInput($_POST['nama']);
        $kategori = validateAndSanitizeInput($_POST['kategori']);
        $satuan = validateAndSanitizeInput($_POST['satuan']);
        $isi = validateAndSanitizeInput($_POST['isi']);
        $harga = validateAndSanitizeInput($_POST['harga']);
        //Menghapus titik Pada setiap Form Rupiah
        $harga = str_replace('.', '', $harga);
        if(empty($_POST['stok'])){
            $stok="0";
        }else{
            $stok = validateAndSanitizeInput($_POST['stok']);
        }
        if(empty($_POST['stok_min'])){
            $stok_min="0";
        }else{
            $stok_min = validateAndSanitizeInput($_POST['stok_min']);
        }
        // Validasi jumlah karakter
        if (strlen($nama) > 100) {
            $response = [
                "status" => "Error",
                "message" => "Nama Barang Tidak Boleh Lebih Dari 100 Karakter"
            ];
        } elseif (strlen($kategori) > 30) {
            $response = [
                "status" => "Error",
                "message" => "Kategori Barang Tidak Boleh Lebih Dari 30 Karakter"
            ];
        } elseif (strlen($satuan) > 20) {
            $response = [
                "status" => "Error",
                "message" => "Satuan Barang Tidak Boleh Lebih Dari 30 Karakter"
            ];
        } elseif (strlen($isi) > 10) {
            $response = [
                "status" => "Error",
                "message" => "Nominal Satuan Isi Tidak Boleh Lebih Dari 10 Karakter Numerik"
            ];
        } elseif (strlen($harga) > 10) {
            $response = [
                "status" => "Error",
                "message" => "Nominal Harga Tidak Boleh Lebih Dari 10 Karakter Numerik"
            ];
        } elseif (strlen($stok) > 10) {
            $response = [
                "status" => "Error",
                "message" => "Nominal Stok Isi Tidak Boleh Lebih Dari 10 Karakter Numerik"
            ];
        } elseif (strlen($stok_min) > 10) {
            $response = [
                "status" => "Error",
                "message" => "Nominal Stok Minimum Tidak Boleh Lebih Dari 10 Karakter Numerik"
            ];
        } else {
            //Buat Kode Barang
            if(empty($_POST['kode'])){
                $kode=GenerateKodeBarang(10);
            }else{
                $kode = validateAndSanitizeInput($_POST['kode']);
            }
            //Validasi Kode Duplikat
            $ValidasiKode = mysqli_num_rows(mysqli_query($Conn, "SELECT id_barang FROM barang WHERE kode_barang='$kode'"));
            if(!empty($ValidasiKode)){
                $response = [
                    "status" => "Error",
                    "message" => "Kode Barang Yang Digunakan Sudah Ada!"
                ];
            }else{
                // Input ke database
                $query = "INSERT INTO barang (
                    kode_barang, 
                    nama_barang, 
                    kategori_barang, 
                    satuan_barang, 
                    konversi, 
                    harga_beli, 
                    stok_barang, 
                    stok_minimum
                ) VALUES (?, ?, ?, ?, ?, ?, ?, ?)";
                $stmt = $Conn->prepare($query);
                if ($stmt) {
                    $stmt->bind_param(
                        "ssssssss",
                        $kode,
                        $nama,
                        $kategori,
                        $satuan,
                        $isi,
                        $harga,
                        $stok,
                        $stok_min
                    );
                    if ($stmt->execute()) {
                        //Jika Berhasil Lanjutkan Input Multi Harga
                        $id_barang=GetDetailData($Conn,'barang','kode_barang',$kode,'id_barang');
                        if(empty($_POST['harga_multi'])){
                            $jumlah_data_multi=0;
                        }else{
                            $jumlah_data_multi=count($_POST['harga_multi']);
                        }
                        $jumlah_berhasil=0;

                        //Buka Kategori Harga
                        $stmt = $Conn->prepare("SELECT * FROM barang_kategori_harga");
                        $stmt->execute();
                        $result = $stmt->get_result();
                        if ($result->num_rows > 0) {
                            $form_ke=0;
                            $jumlah_berhasil=0;
                            while ($data = $result->fetch_assoc()) {
                                if(!empty($data['id_barang_kategori_harga'])){
                                    $id_barang_kategori_harga = $data['id_barang_kategori_harga'];
                                    $kategori_harga = $data['kategori_harga'];
                                    $keterangan = $data['keterangan'];
                                    //Tangkap Dari Form
                                    if(!empty($_POST['harga_multi'][$form_ke])){
                                        $harga_multi=$_POST['harga_multi'][$form_ke];
                                        $harga_multi = str_replace('.', '', $harga_multi);
                                        $entry="INSERT INTO barang_harga (
                                            id_barang,
                                            id_barang_kategori_harga,
                                            harga
                                        ) VALUES (
                                            '$id_barang',
                                            '$id_barang_kategori_harga',
                                            '$harga_multi'
                                        )";
                                        $Input=mysqli_query($Conn, $entry);
                                        if($Input){
                                            $jumlah_berhasil=$jumlah_berhasil+1;
                                        }
                                    }else{
                                        $jumlah_berhasil=$jumlah_berhasil+1;
                                    }
                                }
                                $form_ke++;
                            }
                        }
                        if($jumlah_berhasil==$jumlah_data_multi){
                            $kategori_log="Barang";
                            $deskripsi_log="Tambah Barang";
                            $InputLog=addLog($Conn,$SessionIdAkses,$now,$kategori_log,$deskripsi_log);
                            if($InputLog=="Success"){
                                $response = [
                                    "status" => "Success",
                                    "message" => "Tambah Barang Baru Berhasil!"
                                ];
                            }else{
                                $response = [
                                    "status" => "Error",
                                    "message" => "Terjadi kesalahan pada saat menyimpan log aktivitas"
                                ];
                            }
                        }else{
                            $response = [
                                "status" => "Error",
                                "message" => "Terjadi kesalahan pada saat input data multi harga"
                            ];
                        }
                    } else {
                        $response = [
                            "status" => "Error",
                            "message" => "Terjadi kesalahan pada saat input ke database"
                        ];
                    }
                } else {
                    $response = [
                        "status" => "Error",
                        "message" => "Terjadi kesalahan pada saat mempersiapkan statement database"
                    ];
                }
            }
        }
    }

    // Output response
    echo json_encode($response);
?>

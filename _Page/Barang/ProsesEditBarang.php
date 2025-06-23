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
            'id_barang' => "ID Barang Tidak Boleh Kosong!",
            'kode' => "Kode Barang Tidak Boleh Kosong!",
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
        $id_barang = validateAndSanitizeInput($_POST['id_barang']);
        $kode = validateAndSanitizeInput($_POST['kode']);
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
        } elseif (strlen($kode) > 20) {
            $response = [
                "status" => "Error",
                "message" => "Kode Barang Tidak Boleh Lebih Dari 20 Karakter"
            ];
        } else {
            //Buka Kode Lama
            $kode_lama=GetDetailData($Conn, 'barang', 'id_barang', $id_barang, 'kode_barang');
            //Validasi Kode Duplikat
            if($kode_lama==$kode){
                $ValidasiKode = 0;
            }else{
                $ValidasiKode = mysqli_num_rows(mysqli_query($Conn, "SELECT id_barang FROM barang WHERE kode_barang='$kode'"));
            }
            if(!empty($ValidasiKode)){
                $response = [
                    "status" => "Error",
                    "message" => "Kode Barang Yang Digunakan Sudah Ada!"
                ];
            }else{
                // Update ke database
                $stmt = mysqli_prepare($Conn, "UPDATE barang SET 
                    kode_barang=?, 
                    nama_barang=?, 
                    kategori_barang=?, 
                    satuan_barang=?, 
                    konversi=?, 
                    harga_beli=?, 
                    stok_barang=?, 
                    stok_minimum=?
                WHERE id_barang=?");
                mysqli_stmt_bind_param($stmt, "ssssssssi", 
                    $kode, 
                    $nama, 
                    $kategori, 
                    $satuan, 
                    $isi, 
                    $harga, 
                    $stok, 
                    $stok_min, 
                    $id_barang
                );
                $update_result = mysqli_stmt_execute($stmt);
                if ($update_result) {
                
                    //Jika Berhasil Lanjutkan Input Multi Harga
                    if(empty($_POST['harga_multi'])){
                        $jumlah_data_multi=0;
                    }else{
                        $jumlah_data_multi=count($_POST['harga_multi']);
                    }
                    $jumlah_berhasil=0;

                    //Hapus Data Multi Harga Lama
                    $hapus_harga_multi = mysqli_query($Conn, "DELETE FROM barang_harga WHERE id_barang='$id_barang'") or die(mysqli_error($Conn));
                    if ($hapus_harga_multi) {
                        //Buka Kategori Harga
                        $stmt = $Conn->prepare("SELECT * FROM barang_kategori_harga");
                        $stmt->execute();
                        $result = $stmt->get_result();
                        if ($result->num_rows > 0) {
                            $form_ke=0;
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
                            $deskripsi_log="Edit Barang";
                            $InputLog=addLog($Conn,$SessionIdAkses,$now,$kategori_log,$deskripsi_log);
                            if($InputLog=="Success"){
                                $response = [
                                    "status" => "Success",
                                    "message" => "Edit Barang Baru Berhasil!"
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
                    }else{
                        $response = [
                            "status" => "Error",
                            "message" => "Terjadi kesalahan pada saat menghapus multi harga yang lama"
                        ];
                    }
                    
                } else {
                    $response = [
                        "status" => "Error",
                        "message" => "Terjadi kesalahan pada saat update ke database barang"
                    ];
                }
            }
        }
    }

    // Output response
    echo json_encode($response);
?>

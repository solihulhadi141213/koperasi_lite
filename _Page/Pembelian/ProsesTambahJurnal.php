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
            'id_transaksi_jual_beli'    => "ID Transaksi Penjualan Tidak Boleh Kosong!",
            'id_perkiraan'              => "Akun Perkiraan Tidak Boleh Kosong!",
            'd_k'                       => "Posisi Debet/Kredit Tidak Boleh Kosong!",
            'nominal'                   => "Nominal Jurnal Tidak Boleh Kosong!"
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
        $id_transaksi_jual_beli = validateAndSanitizeInput($_POST['id_transaksi_jual_beli']);
        $id_perkiraan = validateAndSanitizeInput($_POST['id_perkiraan']);
        $d_k = validateAndSanitizeInput($_POST['d_k']);
        $nominal = validateAndSanitizeInput($_POST['nominal']);
        
        //Hapus Format Rupiah pada Nominal
        $nominal = (int) str_replace(".", "", $nominal);

        //Buka kode dan nama perkiraan
        $kode_perkiraan=GetDetailData($Conn, 'akun_perkiraan', 'id_perkiraan', $id_perkiraan, 'kode');
        $nama_perkiraan=GetDetailData($Conn, 'akun_perkiraan', 'id_perkiraan', $id_perkiraan, 'nama');
        
        //Buka Kategori Transaksi dan Tanggal
        $Qry = $Conn->prepare("SELECT * FROM transaksi_jual_beli WHERE id_transaksi_jual_beli = ?");
        $Qry->bind_param("s", $id_transaksi_jual_beli);
        
        if (!$Qry->execute()) {
            $response = [
                "status" => "Error",
                "message" => $Conn->error
            ];
        } else {
            $Result = $Qry->get_result();
            $Data = $Result->fetch_assoc();
            $Qry->close();

            if (!$Data) {
                $response = [
                    "status" => "Error",
                    "message" => "Data transaksi tidak ditemukan"
                ];
            } else {
                // Ambil Data Transaksi
                $kategori = $Data['kategori'];
                $tanggal = $Data['tanggal'];
                $uuid=$id_transaksi_jual_beli;
                //Proses Insert Jurnal
                $query = "INSERT INTO jurnal (
                    kategori, 
                    uuid,
                    id_transaksi_jual_beli,
                    tanggal,
                    kode_perkiraan,
                    nama_perkiraan,
                    d_k,
                    nilai
                ) VALUES (
                    ?, ?, ?, ?, ?, ?, ?, ?
                )";
                // Persiapkan statement
                $stmt = mysqli_prepare($Conn, $query);
                if (!$stmt) {
                    $ValidasiProssesUpdateRincian='Error dalam persiapan statement: '.mysqli_error($Conn).'';
                    $response = [
                        "status" => "Error",
                        "message" =>  $ValidasiProssesUpdateRincian
                    ];
                }else{
                    // Bind parameter ke statement
                    mysqli_stmt_bind_param($stmt, "ssssssss", 
                        $kategori, 
                        $uuid, 
                        $id_transaksi_jual_beli, 
                        $tanggal, 
                        $kode_perkiraan, 
                        $nama_perkiraan, 
                        $d_k,
                        $nominal
                    );

                    // Eksekusi statement
                    $Input = mysqli_stmt_execute($stmt);

                    // Cek apakah query berhasil dijalankan
                    if ($Input) {

                        //Apabila Berhasil Simpan Log
                        $kategori_log="Transaksi Penjualan";
                        $deskripsi_log="Tambah Jurnal Manual";
                        $InputLog=addLog($Conn,$SessionIdAkses,$now,$kategori_log,$deskripsi_log);
                        if($InputLog=="Success"){
                            $response = [
                                "status" => "Success",
                                "message" => "Tambah Jurnal manual Berhasil!",
                                "id_transaksi_jual_beli" => $id_transaksi_jual_beli
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
                            "message" => "Terjadi kesalahan pada saat insert data ke database jurnal"
                        ];
                    }
                }
            }
        }
    }

    // Output response
    echo json_encode($response);
?>

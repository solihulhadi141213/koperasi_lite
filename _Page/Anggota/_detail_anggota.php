<?php
    // Koneksi
    include "../../_Config/Connection.php";
    include "../../_Config/GlobalFunction.php";
    include "../../_Config/Session.php";
    include "../../_Config/SettingGeneral.php";

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
            'id_anggota' => "ID Anggota Tidak Boleh Kosong!"
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
        $id_anggota = validateAndSanitizeInput($_POST['id_anggota']);
        //Buka Data
        $Qry = $Conn->prepare("SELECT * FROM anggota WHERE id_anggota = ?");
        $Qry->bind_param("i", $id_anggota);
        if (!$Qry->execute()) {
            $error=$Conn->error;
            $response = [
                "status" => "Error",
                "message" => $error
            ];
        }else{
            $Result = $Qry->get_result();
            $Data = $Result->fetch_assoc();
            $Qry->close();

            //Buat Variabel
            $tanggal_masuk=$Data['tanggal_masuk'];
            $tanggal_keluar=$Data['tanggal_keluar'];
            $nip=$Data['nip'];
            $nama=$Data['nama'];
            $email=$Data['email'];
            $password=$Data['password'];
            $kontak=$Data['kontak'];
            $lembaga=$Data['lembaga'];
            $ranking=$Data['ranking'];
            $foto=$Data['foto'];
            $akses_anggota=$Data['akses_anggota'];
            $status=$Data['status'];
            $alasan_keluar=$Data['alasan_keluar'];
            //Routing Foto
            if(empty($foto)){
                $foto="No-Image.PNG";
            }
            $dataset = [
                "id_anggota" => $id_anggota,
                "tanggal_masuk" => $tanggal_masuk,
                "tanggal_keluar" => $tanggal_keluar,
                "nip" => $nip,
                "nama" => $nama,
                "email" => $email,
                "password" => $password,
                "kontak" => $kontak,
                "lembaga" => $lembaga,
                "ranking" => $ranking,
                "foto" => $foto,
                "base_url" => $base_url,
                "akses_anggota" => $akses_anggota,
                "status" => $status,
                "alasan_keluar" => $alasan_keluar
            ];

            //Buat Arry Response
            $response = [
                "status" => "Success",
                "message" => "Data Ditemukan",
                "dataset" => $dataset
            ];
        }
    }

    // Output response
    echo json_encode($response);
?>

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
            'id_help' => "ID Dokumentasi Tidak Boleh Kosong!"
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
        $id_help = validateAndSanitizeInput($_POST['id_help']);
        //Buka Data
        $Qry = $Conn->prepare("SELECT * FROM help WHERE id_help = ?");
        $Qry->bind_param("s", $id_help);
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
            $deskripsi=htmlspecialchars_decode($Data['deskripsi']);
            $deskripsi = str_replace(["\r\n", "\r", "\n"], ' ', $deskripsi);
            $kategori=$Data['kategori'];
            //Menampilkan List Artikel Lain Yang Berhubungan
            $artikel_lainnya=[];
            $query_artikel_lain = mysqli_query($Conn, "SELECT id_help, judul FROM help WHERE kategori='$kategori' ORDER BY judul ASC");
            while ($data_artikel_lain = mysqli_fetch_array($query_artikel_lain)) {
                $id_help= $data_artikel_lain['id_help'];
                $judul= $data_artikel_lain['judul'];
                $artikel_lainnya[] = [
                    "id_help" => $data_artikel_lain['id_help'],
                    "judul" => $data_artikel_lain['judul'],
                ];
            }
            //Buat Variabel
            $dataset = [
                "id_help" => $Data['id_help'],
                "author" => $Data['author'],
                "judul" => $Data['judul'],
                "kategori" => $Data['kategori'],
                "deskripsi_script" =>$Data['deskripsi'],
                "deskripsi" =>$deskripsi,
                "datetime_creat" => $Data['datetime_creat'],
                "artikel_lainnya" => $artikel_lainnya,
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

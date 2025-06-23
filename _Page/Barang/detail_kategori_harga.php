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
            'id_barang_kategori_harga' => "ID Kategori Harga Tidak Boleh Kosong!"
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
        $id_barang_kategori_harga = validateAndSanitizeInput($_POST['id_barang_kategori_harga']);
        //Buka Data
        $Qry = $Conn->prepare("SELECT * FROM barang_kategori_harga WHERE id_barang_kategori_harga = ?");
        $Qry->bind_param("s", $id_barang_kategori_harga);
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
            $id_barang_kategori_harga=$Data['id_barang_kategori_harga'];
            $kategori_harga=$Data['kategori_harga'];
            $keterangan=$Data['keterangan'];
            //Hitung Jumlah Item
            $jumlah_item = mysqli_num_rows(mysqli_query($Conn, "SELECT id_barang_harga FROM barang_harga WHERE id_barang_kategori_harga='$id_barang_kategori_harga'"));
            $dataset = [
                "id_barang_kategori_harga" => $id_barang_kategori_harga,
                "kategori_harga" => $kategori_harga,
                "keterangan" => $keterangan,
                "jumlah_item" => $jumlah_item,
            ];
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

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
            'id_pinjaman_jenis' => "ID Jenis Pinjaman Tidak Boleh Kosong!"
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
        $id_pinjaman_jenis = validateAndSanitizeInput($_POST['id_pinjaman_jenis']);
        //Buka Data
        $Qry = $Conn->prepare("SELECT * FROM pinjaman_jenis WHERE id_pinjaman_jenis = ?");
        $Qry->bind_param("i", $id_pinjaman_jenis);
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
            $nama_pinjaman=$Data['nama_pinjaman'];
            $periode_angsuran=$Data['periode_angsuran'];
            $persen_jasa=$Data['persen_jasa'];

            //Hitung Jumlah Sesi Pinjaman
            $jumlah_sesi_pinjaman = mysqli_num_rows(mysqli_query($Conn, "SELECT id_pinjaman FROM pinjaman WHERE id_pinjaman_jenis='$id_pinjaman_jenis'"));
            $dataset = [
                "id_pinjaman_jenis" => $id_pinjaman_jenis,
                "nama_pinjaman" => $nama_pinjaman,
                "periode_angsuran" => $periode_angsuran,
                "persen_jasa" => $persen_jasa,
                "jumlah_sesi_pinjaman" => $jumlah_sesi_pinjaman
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

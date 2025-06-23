<?php
    date_default_timezone_set('Asia/Jakarta');
    include "../../_Config/Connection.php";
    include "../../_Config/SettingGeneral.php";
    if (isset($_FILES['file'])) {
        $targetDir = "../../assets/img/Help/"; // Sesuaikan dengan struktur folder
        
        // Ambil ekstensi file
        $fileExtension = pathinfo($_FILES['file']['name'], PATHINFO_EXTENSION);

        // Buat nama file baru dengan random string
        $randomString = bin2hex(random_bytes(8)); // Random 16 karakter (8 bytes)
        $fileName = $randomString . '.' . $fileExtension;
        $targetFile = $targetDir . $fileName;
        
        // Cek dan buat folder jika belum ada
        if (!file_exists($targetDir)) {
            mkdir($targetDir, 0777, true);
        }

        // Debugging: Cek apakah file diterima
        if ($_FILES['file']['error'] !== UPLOAD_ERR_OK) {
            echo json_encode(['error' => 'Upload Error: ' . $_FILES['file']['error']]);
            exit;
        }

        // Debugging: Cek jenis file
        $allowedTypes = ['image/jpeg', 'image/png', 'image/gif'];
        if (!in_array($_FILES['file']['type'], $allowedTypes)) {
            echo json_encode(['error' => 'Format file tidak diizinkan']);
            exit;
        }

        // Pindahkan file ke folder tujuan
        if (move_uploaded_file($_FILES['file']['tmp_name'], $targetFile)) {
            echo json_encode(['location' => "$base_url/assets/img/Help/" . $fileName]); // URL publik
        } else {
            echo json_encode(['error' => 'Gagal menyimpan file']);
        }
    } else {
        echo json_encode(['error' => 'Tidak ada file yang diunggah']);
    }
?>

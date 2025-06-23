<?php
    use PhpOffice\PhpSpreadsheet\IOFactory;
    use PhpOffice\PhpSpreadsheet\Spreadsheet;

    require "../../_Config/Connection.php";
    require "../../vendor/autoload.php"; // Pastikan autoload composer dimuat

    if ($_SERVER['REQUEST_METHOD'] == 'POST') {
        if (!isset($_FILES['file_supplier'])) {
            echo '<div class="alert alert-danger">File tidak ditemukan.</div>';
            exit;
        }

        $file = $_FILES['file_supplier'];
        $allowedTypes = ['application/vnd.openxmlformats-officedocument.spreadsheetml.sheet', 'application/vnd.ms-excel'];
        $maxSize = 10 * 1024 * 1024; // 10 MB

        // Validasi tipe file
        $ext = pathinfo($file['name'], PATHINFO_EXTENSION);
        if (!in_array($ext, ['xls', 'xlsx'])) {
            echo '<div class="alert alert-danger">Format file tidak valid. Hanya diperbolehkan file Excel (.xls, .xlsx).</div>';
            exit;
        }

        // Validasi ukuran file
        if ($file['size'] > $maxSize) {
            echo '<div class="alert alert-danger">Ukuran file terlalu besar. Maksimal 10 MB.</div>';
            exit;
        }

        $filePath = $file['tmp_name'];
        $spreadsheet = IOFactory::load($filePath);
        $sheet = $spreadsheet->getActiveSheet();
        $rows = $sheet->toArray();

        if (count($rows) <= 1) {
            echo '<div class="alert alert-danger">File Excel kosong atau tidak sesuai format.</div>';
            exit;
        }
        echo '<div class="table table-responsive">';
        echo '<table class="table table-bordered">';
        echo '<thead><tr><th>No</th><th>Nama Supplier</th><th>Alamat</th><th>Email</th><th>Kontak</th><th>Status</th></tr></thead>';
        echo '<tbody>';

        foreach ($rows as $index => $row) {
            if ($index == 0) continue; // Lewati baris pertama (judul kolom)

            $nama_supplier = trim($row[1] ?? '');
            $alamat_supplier = trim($row[2] ?? '');
            $email_supplier = trim($row[3] ?? '');
            $kontak_supplier = trim($row[4] ?? '');

            if (empty($nama_supplier)) {
                echo '<tr class="table-danger"><td colspan="6">Data pada baris '.($index+1).' tidak valid: Nama Supplier wajib diisi.</td></tr>';
                continue;
            }

            $stmt = $Conn->prepare("SELECT COUNT(*) FROM supplier WHERE nama_supplier = ? AND alamat_supplier = ? AND email_supplier = ? AND kontak_supplier = ?");
            $stmt->bind_param("ssss", $nama_supplier, $alamat_supplier, $email_supplier, $kontak_supplier);
            $stmt->execute();
            $stmt->bind_result($count);
            $stmt->fetch();
            $stmt->close();

            if ($count > 0) {
                echo '<tr class="table-danger">';
                echo "<td>{$row[0]}</td><td>{$nama_supplier}</td><td>{$alamat_supplier}</td><td>{$email_supplier}</td><td>{$kontak_supplier}</td><td>Data sudah ada</td>";
                echo '</tr>';
            } else {
                $stmt = $Conn->prepare("INSERT INTO supplier (nama_supplier, alamat_supplier, email_supplier, kontak_supplier) VALUES (?, ?, ?, ?)");
                $stmt->bind_param("ssss", $nama_supplier, $alamat_supplier, $email_supplier, $kontak_supplier);
                if ($stmt->execute()) {
                    echo '<tr class="table-success">';
                    echo "<td>{$row[0]}</td><td>{$nama_supplier}</td><td>{$alamat_supplier}</td><td>{$email_supplier}</td><td>{$kontak_supplier}</td><td>Berhasil diimport</td>";
                    echo '</tr>';
                } else {
                    echo '<tr class="table-danger"><td colspan="6">Gagal mengimport data pada baris '.($index+1).'</td></tr>';
                }
                $stmt->close();
            }
        }

        echo '</tbody></table>';
        echo '</div>';
    } else {
        echo '<div class="alert alert-danger">Metode request tidak valid.</div>';
    }
?>
<?php
    // Include PhpSpreadsheet Library
    require '../../vendor/autoload.php';

    use PhpOffice\PhpSpreadsheet\Spreadsheet;
    use PhpOffice\PhpSpreadsheet\Writer\Xlsx;

    // Include koneksi dan session
    include "../../_Config/Connection.php";
    include "../../_Config/GlobalFunction.php";
    include "../../_Config/SettingGeneral.php";
    include "../../_Config/Session.php";

    if (empty($SessionIdAkses)) {
        echo '<div class="alert alert-danger text-center" role="alert">';
        echo ' <b>Maaf!!</b><br>';
        echo '  Sesi Akses Sudah Berakhir, Silahkan Login Ulang';
        echo '</div>';
        exit;
    }

    // Mendapatkan data periode
    $periode1 = $_GET['periode1'] ?? '';
    $periode2 = $_GET['periode2'] ?? '';

    if (empty($periode1) || empty($periode2)) {
        echo '<div class="alert alert-danger text-center" role="alert">';
        echo ' <b>Maaf!!</b><br>';
        echo '  Periode Awal dan Akhir Laporan Tidak Boleh Kosong!';
        echo '</div>';
        exit;
    }

    // Membuat objek spreadsheet baru
    $spreadsheet = new Spreadsheet();
    $sheet = $spreadsheet->getActiveSheet();

    // Set header kolom
    $sheet->setCellValue('A1', 'No');
    $sheet->setCellValue('B1', 'Kode');
    $sheet->setCellValue('C1', 'Nama Akun');
    $sheet->setCellValue('D1', 'Saldo Normal');
    $sheet->setCellValue('E1', 'Debet');
    $sheet->setCellValue('F1', 'Kredit');
    $sheet->setCellValue('G1', 'Saldo');

    // Query untuk akun level 1
    $jml_data = mysqli_num_rows(mysqli_query($Conn, "SELECT * FROM akun_perkiraan"));
    if (empty($jml_data)) {
        echo '<div class="alert alert-danger text-center" role="alert">';
        echo ' <b>Maaf!!</b><br>';
        echo '  Tidak ada akun perkiraan yang terdaftar pada database!';
        echo '</div>';
        exit;
    }

    // Inisialisasi no baris
    $rowNumber = 2; // Mulai dari baris kedua setelah header

    // Query akun level 1
    $NoUtama = 1;
    $QryGroupUtama = mysqli_query($Conn, "SELECT * FROM akun_perkiraan WHERE level='1' ORDER BY nama");
    while ($GroupUtama = mysqli_fetch_array($QryGroupUtama)) {
        $kode_utama = $GroupUtama['kode'];
        $nama_utama = $GroupUtama['nama'];
        $saldo_normal_utama = $GroupUtama['saldo_normal'];

        // Set data untuk group utama
        $sheet->setCellValue('A' . $rowNumber, $NoUtama);
        $sheet->setCellValue('B' . $rowNumber, $kode_utama);
        $sheet->setCellValue('C' . $rowNumber, $nama_utama);
        $sheet->setCellValue('D' . $rowNumber, $saldo_normal_utama);
        
        $rowNumber++;
        $NoAnak = 1;

        // Query untuk mengambil anak group dari group utama
        $QryAnakGroup = mysqli_query($Conn, "SELECT * FROM akun_perkiraan WHERE kode LIKE '$kode_utama%' AND level != '1' ORDER BY nama");
        while ($AnakGroup = mysqli_fetch_array($QryAnakGroup)) {
            $kode_anak = $AnakGroup['kode'];
            $nama_anak = $AnakGroup['nama'];
            $saldo_normal_anak = $AnakGroup['saldo_normal'];

            // Hitung Debet dan Kredit
            $SumDebet = mysqli_fetch_array(mysqli_query($Conn, "SELECT SUM(nilai) AS nilai FROM jurnal WHERE kode_perkiraan='$kode_anak' AND d_k='D' AND tanggal>='$periode1' AND tanggal<='$periode2'"));
            $JumlahDebet = $SumDebet['nilai'] ?? 0;

            $SumKredit = mysqli_fetch_array(mysqli_query($Conn, "SELECT SUM(nilai) AS nilai FROM jurnal WHERE kode_perkiraan='$kode_anak' AND d_k='K' AND tanggal>='$periode1' AND tanggal<='$periode2'"));
            $JumlahKredit = $SumKredit['nilai'] ?? 0;

            // Hitung Saldo Berdasarkan Saldo Normal
            $JumlahSaldo = ($saldo_normal_anak == "Debet") ? ($JumlahDebet - $JumlahKredit) : ($JumlahKredit - $JumlahDebet);

            // Set data anak group ke dalam sheet
            $sheet->setCellValue('A' . $rowNumber, $NoAnak);
            $sheet->setCellValue('B' . $rowNumber, $kode_anak);
            $sheet->setCellValue('C' . $rowNumber, $nama_anak);
            $sheet->setCellValue('D' . $rowNumber, $saldo_normal_anak);
            $sheet->setCellValue('E' . $rowNumber, "Rp " . number_format($JumlahDebet, 0, ',', '.'));
            $sheet->setCellValue('F' . $rowNumber, "Rp " . number_format($JumlahKredit, 0, ',', '.'));
            $sheet->setCellValue('G' . $rowNumber, "Rp " . number_format($JumlahSaldo, 0, ',', '.'));

            $rowNumber++;
            $NoAnak++;
        }

        $NoUtama++;
    }

    // Buat file Excel
    $filename = 'Neraca_Saldo_' . date('Ymd') . '.xlsx';
    $writer = new Xlsx($spreadsheet);
    header('Content-Type: application/vnd.ms-excel');
    header('Content-Disposition: attachment;filename="' . $filename . '"');
    header('Cache-Control: max-age=0');
    $writer->save('php://output');
    exit;
?>

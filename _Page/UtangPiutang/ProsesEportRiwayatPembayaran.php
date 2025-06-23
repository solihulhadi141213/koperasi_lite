<?php
    include '../../vendor/autoload.php';

    use PhpOffice\PhpSpreadsheet\Spreadsheet;
    use PhpOffice\PhpSpreadsheet\Writer\Xlsx;
    use PhpOffice\PhpSpreadsheet\Style\Alignment;

    // Validasi autoload
    if (!class_exists('PhpOffice\PhpSpreadsheet\Spreadsheet')) {
        die('Autoloader tidak berfungsi dengan benar. Kelas Spreadsheet tidak ditemukan.');
    }

    // Koneksi dan global
    include "../../_Config/Connection.php";
    include "../../_Config/GlobalFunction.php";
    include "../../_Config/Session.php";

    date_default_timezone_set('Asia/Jakarta');

    // Cek sesi login
    if (empty($SessionIdAkses)) {
        exit('<h3>Sesi Akses Sudah Berakhir!</h3>');
    }

    // Validasi parameter mode_data
    $mode_data = $_GET['mode_data'] ?? '';
    $validasi = "Valid";

    switch ($mode_data) {
        case "Periode":
            $periode_1 = $_GET['periode_1'] ?? '';
            $periode_2 = $_GET['periode_2'] ?? '';
            if (empty($periode_1)) $validasi = "Periode Awal Tidak Boleh Kosong!";
            elseif (empty($periode_2)) $validasi = "Periode Akhir Tidak Boleh Kosong!";
            break;
        case "Bulanan":
            $tahun = $_GET['periode_tahun'] ?? '';
            $bulan = $_GET['periode_bulan'] ?? '';
            if (empty($tahun)) $validasi = "Periode Tahun Tidak Boleh Kosong!";
            elseif (empty($bulan)) $validasi = "Periode Bulan Tidak Boleh Kosong!";
            break;
        case "Harian":
            $tanggal = $_GET['periode_tanggal'] ?? '';
            if (empty($tanggal)) $validasi = "Periode Tanggal Tidak Boleh Kosong!";
            break;
        default:
            $validasi = "Mode Data Tidak Diketahui!";
            break;
    }

    if ($validasi !== "Valid") {
        exit("<h3 class='text-danger'>$validasi</h3>");
    }

    // Buat query berdasarkan mode_data
    $query = "SELECT * FROM transaksi_pembayaran";
    switch ($mode_data) {
        case "Periode":
            $query .= " WHERE tanggal >= '$periode_1' AND tanggal <= '$periode_2'";
            break;
        case "Bulanan":
            $keyword = "$tahun-$bulan";
            $query .= " WHERE tanggal LIKE '%$keyword%'";
            break;
        case "Harian":
            $query .= " WHERE tanggal LIKE '%$tanggal%'";
            break;
    }
    $query .= " ORDER BY tanggal ASC";

    // Cek data
    $result = mysqli_query($Conn, $query);
    $jml_data = mysqli_num_rows($result);

    if ($jml_data <= 0) {
        exit('<h3 class="text-danger">Tidak Ada Data Yang Ditemukan</h3>');
    }

    // Siapkan spreadsheet
    $spreadsheet = new Spreadsheet();
    $sheet = $spreadsheet->getActiveSheet();

    // Judul
    $sheet->mergeCells('A1:F1');
    $sheet->setCellValue('A1', 'RIWAYAT PEMBAYARAN');
    $sheet->getStyle('A1')->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);
    $sheet->getStyle('A1')->getFont()->setBold(true);

    // Header kolom
    $headers = ['No', 'Tanggal Transaksi', 'Tanggal Bayar', 'Kategori', 'Anggota', 'Jumlah'];
    $col = 'A';
    foreach ($headers as $header) {
        $sheet->setCellValue($col . '2', $header);
        $sheet->getStyle($col . '2')->getFont()->setBold(true);
        $col++;
    }

    // Tulis data
    $row = 3;
    $no = 1;
    while ($data = mysqli_fetch_assoc($result)) {
        $id_transaksi_jual_beli = $data['id_transaksi_jual_beli'];
        $kategori = $data['kategori'];
        $tanggal_bayar = date('d/m/Y H:i', strtotime($data['tanggal']));
        $jumlah = $data['jumlah'];
        $id_anggota = '';
        $nama_anggota = 'None';
        $tanggal_transaksi_format = 'None';

        // Ambil data transaksi jual beli
        $stmt = $Conn->prepare("SELECT * FROM transaksi_jual_beli WHERE id_transaksi_jual_beli = ?");
        $stmt->bind_param("s", $id_transaksi_jual_beli);
        if ($stmt->execute()) {
            $res = $stmt->get_result();
            if ($rowData = $res->fetch_assoc()) {
                $id_anggota = $rowData['id_anggota'];
                $tanggal_transaksi_format = date('d/m/Y H:i', strtotime($rowData['tanggal']));
                $nama_anggota = !empty($id_anggota) ? GetDetailData($Conn, 'anggota', 'id_anggota', $id_anggota, 'nama') : 'None';
            }
        }
        $stmt->close();

        $sheet->setCellValue('A' . $row, (string)$no);
        $sheet->setCellValue('B' . $row, $tanggal_transaksi_format);
        $sheet->setCellValue('C' . $row, $tanggal_bayar);
        $sheet->setCellValue('D' . $row, $kategori);
        $sheet->setCellValue('E' . $row, $nama_anggota);
        $sheet->setCellValue('F' . $row, $jumlah);
        $no++;
        $row++;
    }

    // Auto size kolom
    foreach (range('A', 'F') as $columnID) {
        $sheet->getColumnDimension($columnID)->setAutoSize(true);
    }

    // Output ke browser
    $writer = new Xlsx($spreadsheet);
    $filename = "Riwayat_pembayaran.xlsx";

    header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
    header("Content-Disposition: attachment; filename=\"$filename\"");
    header('Cache-Control: max-age=0');
    $writer->save('php://output');
    exit;
?>

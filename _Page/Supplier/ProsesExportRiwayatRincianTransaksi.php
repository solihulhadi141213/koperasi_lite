<?php
    // Bersihkan output buffer sebelum memulai
    ob_start();

    // Load PhpSpreadsheet
    require '../../vendor/autoload.php';
    use PhpOffice\PhpSpreadsheet\Spreadsheet;
    use PhpOffice\PhpSpreadsheet\Writer\Xlsx;
    use PhpOffice\PhpSpreadsheet\Style\Alignment;

    // Koneksi database
    include "../../_Config/Connection.php";
    include "../../_Config/GlobalFunction.php";
    include "../../_Config/Session.php";

    if (empty($SessionIdAkses)) {
        die(json_encode(['success' => false, 'message' => 'Sesi telah berakhir! Silakan login ulang.']));
    }

    // Ambil data dari POST
    $id_supplier = $_POST['id_supplier'] ?? '';
    $periode_transaksi_1 = $_POST['periode_transaksi_1'] ?? '';
    $periode_transaksi_2 = $_POST['periode_transaksi_2'] ?? '';

    // Validasi input
    $id_supplier = mysqli_real_escape_string($Conn, $id_supplier);
    $periode_transaksi_1 = mysqli_real_escape_string($Conn, $periode_transaksi_1);
    $periode_transaksi_2 = mysqli_real_escape_string($Conn, $periode_transaksi_2);

    if (empty($id_supplier)) {
        die(json_encode(['success' => false, 'message' => 'ID Supplier tidak boleh kosong']));
    }

    // Buat klausa WHERE berdasarkan periode
    $where_clause = "WHERE tjb.id_supplier='$id_supplier'";
    if (!empty($periode_transaksi_1) && !empty($periode_transaksi_2)) {
        $where_clause .= " AND tjb.tanggal BETWEEN '$periode_transaksi_1' AND '$periode_transaksi_2'";
    }

    // Query data transaksi
    $query = "SELECT tjb.tanggal, tjbr.nama_barang, tjbr.harga, tjbr.qty, tjbr.satuan, tjbr.subtotal, tjbr.ppn, tjbr.diskon, tjb.total 
            FROM transaksi_jual_beli tjb 
            JOIN transaksi_jual_beli_rincian tjbr ON tjb.id_transaksi_jual_beli = tjbr.id_transaksi_jual_beli
            $where_clause 
            ORDER BY tjb.tanggal DESC";

    $result = mysqli_query($Conn, $query);
    if (!$result) {
        die(json_encode(['success' => false, 'message' => 'Error: ' . mysqli_error($Conn)]));
    }

    // Buat Spreadsheet baru
    $spreadsheet = new Spreadsheet();
    $sheet = $spreadsheet->getActiveSheet();

    // Judul laporan
    $sheet->setCellValue('A1', 'Laporan Rincian Transaksi Supplier');
    $sheet->mergeCells('A1:J1');
    $sheet->getStyle('A1')->getFont()->setBold(true)->setSize(14);
    $sheet->getStyle('A1')->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);

    // Header Kolom
    $headers = ['No', 'Tanggal', 'Nama Barang', 'Harga', 'Qty', 'Satuan', 'Subtotal', 'PPN', 'Diskon', 'Total'];
    $sheet->fromArray($headers, NULL, 'A3');
    $sheet->getStyle('A3:J3')->getFont()->setBold(true);
    $sheet->getStyle('A3:J3')->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);

    // Isi Data
    $row = 4;
    $no = 1;
    while ($data = mysqli_fetch_assoc($result)) {
        $sheet->fromArray([
            $no,
            date('d/m/Y', strtotime($data['tanggal'])),
            htmlspecialchars($data['nama_barang']),
            $data['harga'],
            $data['qty'],
            htmlspecialchars($data['satuan']),
            $data['subtotal'],
            $data['ppn'],
            $data['diskon'],
            $data['total'],
        ], NULL, "A$row");
        $row++;
        $no++;
    }

    // Auto-size kolom
    foreach (range('A', 'J') as $col) {
        $sheet->getColumnDimension($col)->setAutoSize(true);
    }

    // Bersihkan output sebelum mengirim file
    ob_end_clean();

    $filename = 'Rincian_Transaksi_Supplier.xlsx';
    header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
    header("Content-Disposition: attachment; filename=$filename");
    header('Cache-Control: max-age=0');

    // Simpan ke output
    $writer = new Xlsx($spreadsheet);
    $writer->save('php://output');
    exit;
?>

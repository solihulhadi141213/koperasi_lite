<?php 
require '../../vendor/autoload.php';
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;
use PhpOffice\PhpSpreadsheet\Style\Fill;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;
use PhpOffice\PhpSpreadsheet\Style\NumberFormat;

// Koneksi
include "../../_Config/Connection.php";
include "../../_Config/GlobalFunction.php";
include "../../_Config/Session.php";

if(empty($SessionIdAkses)){
    echo "Sesi Akses Sudah Berakhir, Silahkan Login Ulang";
    exit;
}

if(empty($_POST['id_pinjaman'])){
    echo "ID Pinjaman Tidak Boleh Kosong!";
    exit;
} else {
    $id_pinjaman = $_POST['id_pinjaman'];
    $id_pinjaman = validateAndSanitizeInput($id_pinjaman);
    $JumlahData = mysqli_num_rows(mysqli_query($Conn, "SELECT * FROM pinjaman_angsuran WHERE id_pinjaman='$id_pinjaman'"));

    if(empty($JumlahData)){
        echo "Belum Ada Data Angsuran Untuk Pinjaman Tersebut";
        exit;
    } else {
        // Membuat objek Spreadsheet baru
        $spreadsheet = new Spreadsheet();
        $sheet = $spreadsheet->getActiveSheet();

        // Menulis judul
        $headers = [
            'A1' => 'No',
            'B1' => 'NIP',
            'C1' => 'Nama Anggota',
            'D1' => 'Divisi/Unit',
            'E1' => 'Ranking',
            'F1' => 'Tanggal Tempo',
            'G1' => 'Tanggal Bayar',
            'H1' => 'Keterlambatan',
            'I1' => 'Satuan',
            'J1' => 'Pokok',
            'K1' => 'Jasa',
            'L1' => 'Denda',
            'M1' => 'Jumlah Angsuran'
        ];

        foreach ($headers as $cell => $value) {
            $sheet->setCellValue($cell, $value);
        }

        // Mengatur gaya baris judul
        $sheet->getStyle('A1:M1')->getFont()->setBold(true);
        $sheet->getStyle('A1:M1')->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER);

        // Membuat objek Writer untuk menulis Spreadsheet ke dalam file XLSX
        $writer = new Xlsx($spreadsheet);

        $no = 1;
        $row = 2;
        $query = mysqli_query($Conn, "SELECT * FROM pinjaman_angsuran WHERE id_pinjaman='$id_pinjaman' ORDER BY tanggal_angsuran ASC");
        
        while ($data = mysqli_fetch_array($query)) {
            $id_pinjaman_angsuran = $data['id_pinjaman_angsuran'];
            $uuid_angsuran = $data['uuid_angsuran'];
            $id_pinjaman = $data['id_pinjaman'];
            $id_anggota = $data['id_anggota'];
            $tanggal_angsuran = $data['tanggal_angsuran'];
            $tanggal_bayar = $data['tanggal_bayar'];
            $keterlambatan = $data['keterlambatan'];
            $pokok = $data['pokok'];
            $jasa = $data['jasa'];
            $denda = $data['denda'];
            $jumlah = $data['jumlah'];

            // Format tanggal
            $tanggal_angsuran_format = \PhpOffice\PhpSpreadsheet\Shared\Date::PHPToExcel(new DateTime($tanggal_angsuran));
            $tanggal_bayar_format = \PhpOffice\PhpSpreadsheet\Shared\Date::PHPToExcel(new DateTime($tanggal_bayar));

            // Detail Pinjaman
            $nip = GetDetailData($Conn,'pinjaman','id_pinjaman',$id_pinjaman,'nip');
            $nama = GetDetailData($Conn,'pinjaman','id_pinjaman',$id_pinjaman,'nama');
            $lembaga = GetDetailData($Conn,'pinjaman','id_pinjaman',$id_pinjaman,'lembaga');
            $ranking = GetDetailData($Conn,'pinjaman','id_pinjaman',$id_pinjaman,'ranking');
            $sistem_denda = GetDetailData($Conn,'pinjaman','id_pinjaman',$id_pinjaman,'sistem_denda');

            // Menampilkan Data
            $sheet->setCellValue('A'.$row, $no);
            $sheet->setCellValue('B'.$row, $nip);
            $sheet->setCellValue('C'.$row, $nama);
            $sheet->setCellValue('D'.$row, $lembaga);
            $sheet->setCellValue('E'.$row, $ranking);
            
            // Format tanggal di Excel
            $sheet->setCellValue('F'.$row, $tanggal_angsuran_format);
            $sheet->getStyle('F'.$row)->getNumberFormat()->setFormatCode(NumberFormat::FORMAT_DATE_DDMMYYYY);
            
            $sheet->setCellValue('G'.$row, $tanggal_bayar_format);
            $sheet->getStyle('G'.$row)->getNumberFormat()->setFormatCode(NumberFormat::FORMAT_DATE_DDMMYYYY);

            $sheet->setCellValue('H'.$row, $keterlambatan);
            $sheet->setCellValue('I'.$row, $sistem_denda);
            
            // Format angka di Excel
            $sheet->setCellValue('J'.$row, $pokok);
            $sheet->getStyle('J'.$row)->getNumberFormat()->setFormatCode(NumberFormat::FORMAT_NUMBER_COMMA_SEPARATED1);
            
            $sheet->setCellValue('K'.$row, $jasa);
            $sheet->getStyle('K'.$row)->getNumberFormat()->setFormatCode(NumberFormat::FORMAT_NUMBER_COMMA_SEPARATED1);
            
            $sheet->setCellValue('L'.$row, $denda);
            $sheet->getStyle('L'.$row)->getNumberFormat()->setFormatCode(NumberFormat::FORMAT_NUMBER_COMMA_SEPARATED1);
            
            $sheet->setCellValue('M'.$row, $jumlah);
            $sheet->getStyle('M'.$row)->getNumberFormat()->setFormatCode(NumberFormat::FORMAT_NUMBER_COMMA_SEPARATED1);

            $row++; // Pindah ke baris berikutnya
            $no++;
        }

        // Menyesuaikan lebar kolom dengan karakter terpanjang
        foreach(range('A', 'M') as $columnID) {
            $sheet->getColumnDimension($columnID)->setAutoSize(true);
        }

        $filename = "Angsuran-$id_pinjaman.xlsx";
        
        header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
        header('Content-Disposition: attachment;filename="'. $filename .'"');
        header('Cache-Control: max-age=0');
        
        // Menulis Spreadsheet ke dalam output PHP
        $writer->save('php://output');
    }
}
?>

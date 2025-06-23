<?php
    // Koneksi dan library
    include "../../_Config/Connection.php";
    include "../../_Config/GlobalFunction.php";
    include "../../_Config/SettingGeneral.php";
    include "../../_Config/Session.php";
    require '../../vendor/autoload.php'; // Pastikan path ke PhpOffice sesuai

    use PhpOffice\PhpSpreadsheet\Spreadsheet;
    use PhpOffice\PhpSpreadsheet\Writer\Xlsx;

    // Time Zone
    date_default_timezone_set('Asia/Jakarta');

    // Cek akses
    if(empty($SessionIdAkses)){
        echo '<div class="alert alert-danger text-center" role="alert">';
        echo ' <b>Maaf!!</b><br>';
        echo '  Sesi Akses Sudah Berakhir, Silahkan Login Ulang';
        echo '</div>';
        exit;
    }

    // Cek data yang dikirim dari form
    if(empty($_GET['id_perkiraan'])){
        echo '<div class="alert alert-danger text-center" role="alert">';
        echo ' <b>Maaf!!</b><br>';
        echo '  ID Akun Perkiraan Tidak Boleh Kosong!';
        echo '</div>';
        exit;
    }
    if(empty($_GET['periode1'])){
        echo '<div class="alert alert-danger text-center" role="alert">';
        echo ' <b>Maaf!!</b><br>';
        echo '  Periode Awal Laporan Tidak Boleh Kosong!';
        echo '</div>';
        exit;
    }
    if(empty($_GET['periode2'])){
        echo '<div class="alert alert-danger text-center" role="alert">';
        echo ' <b>Maaf!!</b><br>';
        echo '  Periode Akhir Laporan Tidak Boleh Kosong!';
        echo '</div>';
        exit;
    }

    $id_perkiraan = $_GET['id_perkiraan'];
    $periode1 = $_GET['periode1'];
    $periode2 = $_GET['periode2'];

    // Cari Kode Perkiraan
    $kode = GetDetailData($Conn, 'akun_perkiraan', 'id_perkiraan', $id_perkiraan, 'kode');
    $nama = GetDetailData($Conn, 'akun_perkiraan', 'id_perkiraan', $id_perkiraan, 'nama');
    $saldo_normal=GetDetailData($Conn,'akun_perkiraan','id_perkiraan',$id_perkiraan,'saldo_normal');
    if($saldo_normal=="Debet"){
        $SaldoNormal="D";
    }else{
        $SaldoNormal="K";
    }
    if(empty($kode)){
        echo '<div class="alert alert-danger text-center" role="alert">';
        echo ' <b>Maaf!!</b><br>';
        echo '  Kode Akun Perkiraan Yang Anda Pilih Tidak Ada pada Database!';
        echo '</div>';
        exit;
    }

    // Membuat Spreadsheet
    $spreadsheet = new Spreadsheet();
    $sheet = $spreadsheet->getActiveSheet();

    // Header
    $sheet->setCellValue('A1', 'No');
    $sheet->setCellValue('B1', 'Tanggal');
    $sheet->setCellValue('C1', 'Referensi');
    $sheet->setCellValue('D1', 'Kategori');
    $sheet->setCellValue('E1', 'Debet');
    $sheet->setCellValue('F1', 'Kredit');
    $sheet->setCellValue('G1', 'Saldo');

    // Mengambil Data dari Database
    $jml_data = mysqli_num_rows(mysqli_query($Conn, "SELECT * FROM jurnal WHERE kode_perkiraan='$kode' AND tanggal>='$periode1' AND tanggal<='$periode2'"));
    if(empty($jml_data)){
        echo '<div class="alert alert-warning text-center" role="alert">';
        echo '  Tidak Ada Data Buku Besar Yang Dapat Ditampilkan';
        echo '</div>';
        exit;
    }

    $no = 1;
    $JumlahSaldo = 0;
    $query = mysqli_query($Conn, "SELECT * FROM jurnal WHERE kode_perkiraan='$kode' AND tanggal>='$periode1' AND tanggal<='$periode2' ORDER BY id_jurnal ASC");
    $row = 2; // Start row for data
    while ($data = mysqli_fetch_array($query)) {
        $uuid = $data['uuid'];
        $tanggal = date('d/m/y', strtotime($data['tanggal']));
        $kategori = $data['kategori'];
        $d_k = $data['d_k'];
        $nilai = $data['nilai'];
        
        if($d_k == "D"){
            $NilaiDebet = $nilai;
            $NilaiKredit = 0;
            
        } else {
            $NilaiDebet = 0;
            $NilaiKredit = $nilai;
        }
        if($d_k==$SaldoNormal){
            $JumlahSaldo += $nilai;
        }else{
            $JumlahSaldo -= $nilai;
        }
        // Mengisi Data ke Spreadsheet
        $sheet->setCellValue('A' . $row, $no);
        $sheet->setCellValue('B' . $row, $tanggal);
        $sheet->setCellValue('C' . $row, $uuid);
        $sheet->setCellValue('D' . $row, $kategori);
        $sheet->setCellValue('E' . $row, $NilaiDebet);
        $sheet->setCellValue('F' . $row, $NilaiKredit);
        $sheet->setCellValue('G' . $row, $JumlahSaldo);

        $row++;
        $no++;
    }

    // Mengatur format untuk kolom nominal
    $sheet->getStyle('E2:F' . ($row - 1))
        ->getNumberFormat()
        ->setFormatCode('#,##0');

    // Simpan file Excel
    $filename = 'Laporan_BukuBesar_' . date('Y-m-d') . '.xlsx';

    header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
    header('Content-Disposition: attachment; filename="' . $filename . '"');
    header('Cache-Control: max-age=0');

    $writer = new Xlsx($spreadsheet);
    $writer->save('php://output');
    exit;
?>

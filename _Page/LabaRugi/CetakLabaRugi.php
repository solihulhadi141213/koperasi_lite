<?php
    // Koneksi dan library
    include "../../_Config/Connection.php";
    include "../../_Config/GlobalFunction.php";
    include "../../_Config/Session.php";
    require '../../vendor/autoload.php'; // Pastikan path ke PhpOffice sesuai

    use PhpOffice\PhpSpreadsheet\Spreadsheet;
    use PhpOffice\PhpSpreadsheet\Writer\Xlsx;

    // Time Zone
    date_default_timezone_set('Asia/Jakarta');

    // Cek Akses
    if(empty($SessionIdAkses)){
        die('Sesi Akses Sudah Berakhir. Silahkan Login Ulang!');
    }

    // Tangkap input
    $periode1 = $_GET['periode1'] ?? null;
    $periode2 = $_GET['periode2'] ?? null;
    $akun_pemasukan = $_GET['akun_pemasukan'] ?? null;
    $akun_pengeluaran = $_GET['akun_pengeluaran'] ?? null;

    if (!$periode1 || !$periode2 || !$akun_pemasukan || !$akun_pengeluaran) {
        die('Periode dan Akun Tidak Boleh Kosong');
    }

    // Inisiasi spreadsheet
    $spreadsheet = new Spreadsheet();
    $sheet = $spreadsheet->getActiveSheet();
    $sheet->setCellValue('A1', 'No');
    $sheet->setCellValue('B1', 'Tanggal');
    $sheet->setCellValue('C1', 'Kategori');
    $sheet->setCellValue('D1', 'Akun Perkiraan');
    $sheet->setCellValue('E1', 'Debet/Kredit');
    $sheet->setCellValue('F1', 'Nominal');
    $sheet->setCellValue('G1', 'Saldo');

    // Data pemasukan
    $row = 2;
    $saldoPemasukan = 0;
    $sheet->setCellValue('A'.$row, 'A');
    $sheet->setCellValue('B'.$row, 'Transaksi Pemasukan');
    $row++;

    $noPemasukan = 1;
    $qryPemasukan = mysqli_query($Conn, "SELECT * FROM akun_perkiraan WHERE kd1='$akun_pemasukan' ORDER BY kode ASC");

    while ($dataPemasukan = mysqli_fetch_array($qryPemasukan)) {
        $kodeAkunPemasukan = $dataPemasukan['kode'];
        $saldoNormal = $dataPemasukan['saldo_normal'];

        $qryJurnalPemasukan = mysqli_query($Conn, "SELECT * FROM jurnal WHERE kode_perkiraan='$kodeAkunPemasukan' AND (tanggal>='$periode1') AND (tanggal<='$periode2') ORDER BY id_jurnal DESC");
        while ($jurnalPemasukan = mysqli_fetch_array($qryJurnalPemasukan)) {
            $tanggal = $jurnalPemasukan['tanggal'];
            $kategori = $jurnalPemasukan['kategori'];
            $namaAkun = $jurnalPemasukan['nama_perkiraan'];
            $debetKredit = $jurnalPemasukan['d_k'];
            $nilai = $jurnalPemasukan['nilai'];

            if ($debetKredit == "D") {
                $debetKreditReal = 'Debet';
            } else {
                $debetKreditReal = 'Kredit';
            }

            if ($debetKreditReal == $saldoNormal) {
                $saldoPemasukan += $nilai;
            } else {
                $saldoPemasukan -= $nilai;
            }

            $sheet->setCellValue('A'.$row, 'A.'.$noPemasukan);
            $sheet->setCellValue('B'.$row, $tanggal);
            $sheet->setCellValue('C'.$row, $kategori);
            $sheet->setCellValue('D'.$row, $kodeAkunPemasukan.' '.$namaAkun);
            $sheet->setCellValue('E'.$row, $debetKreditReal);
            $sheet->setCellValue('F'.$row, $nilai);
            $sheet->setCellValue('G'.$row, $saldoPemasukan);

            $row++;
            $noPemasukan++;
        }
    }

    // Data pengeluaran
    $saldoPengeluaran = 0;
    $sheet->setCellValue('A'.$row, 'B');
    $sheet->setCellValue('B'.$row, 'Transaksi Pengeluaran');
    $row++;

    $noPengeluaran = 1;
    $qryPengeluaran = mysqli_query($Conn, "SELECT * FROM akun_perkiraan WHERE kd1='$akun_pengeluaran' ORDER BY kode ASC");

    while ($dataPengeluaran = mysqli_fetch_array($qryPengeluaran)) {
        $kodeAkunPengeluaran = $dataPengeluaran['kode'];
        $saldoNormal = $dataPengeluaran['saldo_normal'];

        $qryJurnalPengeluaran = mysqli_query($Conn, "SELECT * FROM jurnal WHERE kode_perkiraan='$kodeAkunPengeluaran' AND (tanggal>='$periode1') AND (tanggal<='$periode2') ORDER BY id_jurnal DESC");
        while ($jurnalPengeluaran = mysqli_fetch_array($qryJurnalPengeluaran)) {
            $tanggal = $jurnalPengeluaran['tanggal'];
            $kategori = $jurnalPengeluaran['kategori'];
            $namaAkun = $jurnalPengeluaran['nama_perkiraan'];
            $debetKredit = $jurnalPengeluaran['d_k'];
            $nilai = $jurnalPengeluaran['nilai'];

            if ($debetKredit == "D") {
                $debetKreditReal = 'Debet';
            } else {
                $debetKreditReal = 'Kredit';
            }

            if ($debetKreditReal == $saldoNormal) {
                $saldoPengeluaran += $nilai;
            } else {
                $saldoPengeluaran -= $nilai;
            }

            $sheet->setCellValue('A'.$row, 'B.'.$noPengeluaran);
            $sheet->setCellValue('B'.$row, $tanggal);
            $sheet->setCellValue('C'.$row, $kategori);
            $sheet->setCellValue('D'.$row, $kodeAkunPengeluaran.' '.$namaAkun);
            $sheet->setCellValue('E'.$row, $debetKreditReal);
            $sheet->setCellValue('F'.$row, $nilai);
            $sheet->setCellValue('G'.$row, $saldoPengeluaran);

            $row++;
            $noPengeluaran++;
        }
    }

    // Estimasi Laba/Rugi
    $labaRugi = $saldoPemasukan - $saldoPengeluaran;
    $sheet->setCellValue('A'.$row, '');
    $sheet->setCellValue('B'.$row, 'Estimasi Laba/Rugi');
    $sheet->setCellValue('G'.$row, $labaRugi);

    // Simpan file Excel
    $writer = new Xlsx($spreadsheet);
    $filename = 'Laporan_Laba_Rugi_'.date('Y-m-d').'.xlsx';

    header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
    header('Content-Disposition: attachment; filename="'.$filename.'"');
    header('Cache-Control: max-age=0');

    $writer->save('php://output');
?>

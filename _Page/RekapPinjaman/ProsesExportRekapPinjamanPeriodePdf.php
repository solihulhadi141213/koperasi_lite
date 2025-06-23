<?php
    require '../../vendor/autoload.php'; // Pastikan composer sudah menginstal mPDF
    include "../../_Config/Connection.php";
    include "../../_Config/GlobalFunction.php";

    date_default_timezone_set("Asia/Jakarta");

    use Mpdf\Mpdf;

    if (empty($_GET['tahun'])) {
        die("<script>alert('Pilih Tahun Terlebih Dahulu'); window.close();</script>");
    }

    $tahun = $_GET['tahun'];
    $mpdf = new Mpdf();

    $html = '<h3 style="text-align:center;">REKAPITULASI JUMLAH PINJAMAN DAN ANGSURAN</h3>';
    $html .= '<h4 style="text-align:center;">PERIODE TAHUN ' . $tahun . '</h4>';
    $html .= '<table border="1" width="100%" cellpadding="5" cellspacing="0">
                <thead>
                    <tr>
                        <th>No</th>
                        <th>Bulan</th>
                        <th>Jumlah Anggota</th>
                        <th>Pinjaman (Rp)</th>
                        <th>Angsuran Masuk (Rp)</th>
                    </tr>
                </thead>
                <tbody>';

    $namaBulan = ['Januari', 'Februari', 'Maret', 'April', 'Mei', 'Juni',
        'Juli', 'Agustus', 'September', 'Oktober', 'November', 'Desember'];

    $JumlahTotalAnggota = 0;
    $JumlahTotalPinjaman = 0;
    $JumlahTotalAngsuran = 0;

    for ($i = 1; $i <= 12; $i++) {
        $angkaBulan = str_pad($i, 2, '0', STR_PAD_LEFT);
        $namaBulanIni = $namaBulan[$i - 1];
        $keyword = "$tahun-$angkaBulan";
        
        $JumlahAnggota = mysqli_num_rows(mysqli_query($Conn, "SELECT DISTINCT id_anggota FROM pinjaman WHERE tanggal LIKE '%$keyword%'"));
        $SumPinjaman = mysqli_fetch_array(mysqli_query($Conn, "SELECT SUM(jumlah_pinjaman) AS jumlah FROM pinjaman WHERE tanggal LIKE '%$keyword%'"));
        $JumlahPinjaman = $SumPinjaman['jumlah'] ?? 0;
        $SumAngsuran = mysqli_fetch_array(mysqli_query($Conn, "SELECT SUM(jumlah) AS total FROM pinjaman_angsuran WHERE tanggal_bayar LIKE '%$keyword%'"));
        $JumlahAngsuran = $SumAngsuran['total'] ?? 0;
        
        $JumlahTotalAnggota += $JumlahAnggota;
        $JumlahTotalPinjaman += $JumlahPinjaman;
        $JumlahTotalAngsuran += $JumlahAngsuran;
        
        $html .= '<tr>
                    <td align="center">' . $i . '</td>
                    <td>' . $namaBulanIni . '</td>
                    <td>' . $JumlahAnggota . ' Anggota</td>
                    <td align="right">Rp ' . number_format($JumlahPinjaman, 0, ',', '.') . '</td>
                    <td align="right">Rp ' . number_format($JumlahAngsuran, 0, ',', '.') . '</td>
                </tr>';
    }

    $html .= '<tr>
                <td colspan="2" align="center"><b>JUMLAH</b></td>
                <td><b>' . $JumlahTotalAnggota . ' Anggota</b></td>
                <td align="right"><b>Rp ' . number_format($JumlahTotalPinjaman, 0, ',', '.') . '</b></td>
                <td align="right"><b>Rp ' . number_format($JumlahTotalAngsuran, 0, ',', '.') . '</b></td>
            </tr>';
    $html .= '</tbody></table>';

    $mpdf->WriteHTML($html);
    $mpdf->Output("Rekap_Pinjaman_$tahun.pdf", "D");
    exit();

?>
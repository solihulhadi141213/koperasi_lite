<?php
    require '../../vendor/autoload.php';
    require '../../_Config/Connection.php';
    require '../../_Config/GlobalFunction.php';

    date_default_timezone_set("Asia/Jakarta");

    $mpdf = new \Mpdf\Mpdf();

    $tahun = isset($_GET['tahun']) ? $_GET['tahun'] : '';
    $html = '<h3 style="text-align:center;">REKAPITULASI PINJAMAN UNIT/DIVISI</h3>';
    $html .= '<p style="text-align:center;">' . ($tahun ? 'PERIODE TAHUN ' . $tahun : 'SEMUA PERIODE') . '</p>';

    $html .= '<table border="1" cellpadding="5" cellspacing="0" width="100%">
    <thead>
    <tr>
        <th>No</th>
        <th>Unit/Divisi</th>
        <th>Anggota</th>
        <th>Rp Pinjaman</th>
        <th>Rp Angsuran Masuk</th>
    </tr>
    </thead>
    <tbody>';

    $no = 1;
    $JumlahTotalAnggota = 0;
    $JumlahTotalPinjaman = 0;
    $JumlahTotalAngsuran = 0;
    $query = mysqli_query($Conn, "SELECT DISTINCT lembaga FROM pinjaman ORDER BY lembaga ASC");
    while ($data = mysqli_fetch_array($query)) {
        $lembaga = $data['lembaga'];
        $JumlahAnggota = mysqli_num_rows(mysqli_query($Conn, "SELECT DISTINCT id_anggota FROM pinjaman WHERE lembaga='$lembaga' AND tanggal LIKE '%$tahun%'"));
        $SumPinjaman = mysqli_fetch_array(mysqli_query($Conn, "SELECT SUM(jumlah_pinjaman) AS jumlah FROM pinjaman WHERE lembaga='$lembaga' AND tanggal LIKE '%$tahun%'"));
        $JumlahPinjaman = $SumPinjaman['jumlah'] ?? 0;
        
        $JumlahAngsuran = 0;
        $QryPinjaman = mysqli_query($Conn, "SELECT id_pinjaman FROM pinjaman WHERE lembaga='$lembaga' AND tanggal LIKE '%$tahun%'");
        while ($DataPinjaman = mysqli_fetch_array($QryPinjaman)) {
            $id_pinjaman = $DataPinjaman['id_pinjaman'];
            $SumAngsuran = mysqli_fetch_array(mysqli_query($Conn, "SELECT SUM(jumlah) AS total FROM pinjaman_angsuran WHERE id_pinjaman='$id_pinjaman' AND tanggal_bayar LIKE '%$tahun%'"));
            $JumlahAngsuran += $SumAngsuran['total'] ?? 0;
        }
        
        $JumlahTotalAnggota += $JumlahAnggota;
        $JumlahTotalPinjaman += $JumlahPinjaman;
        $JumlahTotalAngsuran += $JumlahAngsuran;
        
        $html .= '<tr>
            <td align="center">' . $no++ . '</td>
            <td>' . $lembaga . '</td>
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
    $mpdf->Output('Rekap_Pinjaman.pdf', 'D');
    exit;

?>
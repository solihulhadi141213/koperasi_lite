<?php
// Koneksi dan konfigurasi
date_default_timezone_set('Asia/Jakarta');
require_once "../../_Config/Connection.php";
require_once "../../_Config/GlobalFunction.php";
require_once "../../_Config/SettingGeneral.php";
require_once "../../vendor/autoload.php";

use Mpdf\Mpdf;

// Periksa apakah ada parameter tahun
$tahun = isset($_GET['tahun']) ? $_GET['tahun'] : "";
if($tahun=="Semua"){
    $tahun="";
}
// Inisialisasi mPDF dengan orientasi landscape
$mpdf = new Mpdf(['orientation' => 'L']);

// Header PDF
$html = '
    <h3 style="text-align: center;">LAPORAN POTONGAN ANGSURAN ANGGOTA KOPERASI</h3>
    <p style="text-align: center;">PERIODE: '.($tahun ? $tahun : 'SEMUA PERIODE').'</p>
    <table border="1" width="100%" cellspacing="0" cellpadding="5">
        <thead>
            <tr style="background-color: #f2f2f2;">
                <th>No</th>
                <th>Tanggal</th>
                <th>Anggota</th>
                <th>Jenis Pinjaman</th>
                <th>Pinjaman</th>
                <th>Pinjaman + Jasa</th>
                <th>Angsuran</th>
                <th>Lama Angsuran</th>
                <th>Sudah Bayar</th>
                <th>Jumlah Bayar (Rp)</th>
                <th>Sisa Pinjaman</th>
                <th>Sisa Pinjaman (Rp)</th>
                <th>Status</th>
            </tr>
        </thead>
        <tbody>';

// Query data pinjaman berdasarkan tahun
$query = mysqli_query($Conn, "SELECT * FROM pinjaman WHERE tanggal LIKE '%$tahun%' ORDER BY id_pinjaman ASC");

if (mysqli_num_rows($query) == 0) {
    $html .= '<tr><td colspan="11" align="center"><i>Belum Ada Data Pinjaman</i></td></tr>';
} else {
    $no = 1;
    while ($data = mysqli_fetch_array($query)) {
        $tanggal = date('d/m/Y', strtotime($data['tanggal']));
        $jumlah_pinjaman = number_format($data['jumlah_pinjaman'], 0, ',', '.');
        $jumlah_pinjaman_jasa = number_format($data['jumlah_pinjaman'] + ($data['rp_jasa'] * $data['periode_angsuran']), 0, ',', '.');
        
        // Sum Data Angsuran
        $sum = mysqli_fetch_array(mysqli_query($Conn, "SELECT SUM(jumlah) AS total FROM pinjaman_angsuran WHERE id_pinjaman='{$data['id_pinjaman']}'"));
        $jumlah_angsuran = number_format($sum['total'], 0, ',', '.');

        // Row Data Angsuran
        $jumlah_data_angsuran = mysqli_num_rows(mysqli_query($Conn, "SELECT id_pinjaman_angsuran FROM pinjaman_angsuran WHERE id_pinjaman='{$data['id_pinjaman']}'"));

        // Hitung Sisa Periode Angsuran
        $sisa_pinjaman = $data['periode_angsuran'] - $jumlah_data_angsuran;

        // Hitung Sisa Pinjaman
        $sisa_pinjaman_rp = number_format(($data['jumlah_pinjaman'] + ($data['rp_jasa'] * $data['periode_angsuran'])) - $sum['total'], 0, ',', '.');
        if(empty($data['id_pinjaman_jenis'])){
            $nama_jenis_pinjaman='<span class="text text-muted">NONE</span>';
        }else{
            $id_pinjaman_jenis=$data['id_pinjaman_jenis'];
            $nama_jenis_pinjaman=GetDetailData($Conn, 'pinjaman_jenis', 'id_pinjaman_jenis', $id_pinjaman_jenis, 'nama_pinjaman');
        }
        //Angsuran Total
        $angsuran_total= $data['angsuran_total'];
        $angsuran_total = "" . number_format($angsuran_total,0,',','.');
        $html .= '
            <tr>
                <td align="center">'.$no.'</td>
                <td>'.$tanggal.'</td>
                <td>'.$data['nama'].'</td>
                <td>'.$nama_jenis_pinjaman.'</td>
                <td align="right">'.$jumlah_pinjaman.'</td>
                <td align="right">'.$jumlah_pinjaman_jasa.'</td>
                <td align="right">'.$angsuran_total.'</td>
                <td align="center">'.$data['periode_angsuran'].'</td>
                <td align="center">'.$jumlah_data_angsuran.'</td>
                <td align="right">'.$jumlah_angsuran.'</td>
                <td align="center">'.$sisa_pinjaman.'</td>
                <td align="right">'.$sisa_pinjaman_rp.'</td>
                <td>'.$data['status'].'</td>
            </tr>';
        $no++;
    }
}

$html .= '
        </tbody>
    </table>';

// Menambahkan HTML ke PDF dan mengatur properti
$mpdf->WriteHTML($html);
$mpdf->SetTitle('Rekapitulasi Pinjaman Anggota');
$mpdf->Output('Rekap_Pinjaman_Anggota.pdf', 'I'); // 'I' untuk membuka di browser

exit;
?>

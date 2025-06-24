<?php
// Koneksi dan setting
include "../../_Config/Connection.php";
include "../../_Config/GlobalFunction.php";
include "../../_Config/SettingGeneral.php";
require_once '../../vendor/autoload.php';
date_default_timezone_set("Asia/Jakarta");

// Validasi periode
if (empty($_GET['periode_1']) || empty($_GET['periode_2'])) {
    die("Parameter periode tidak lengkap!");
}

// Ambil parameter
$periode_1 = $_GET['periode_1'];
$periode_2 = $_GET['periode_2'];

$periode_1_format = date('d/m/Y', strtotime($periode_1));
$periode_2_format = date('d/m/Y', strtotime($periode_2));

// Judul
$judul_laporan = "LAPORAN PINJAMAN ANGGOTA";
$periode_laporan = "Periode: $periode_1_format s/d $periode_2_format";

// mPDF
$mpdf = new \Mpdf\Mpdf([
    'mode' => 'utf-8',
    'format' => 'A4',
    'margin_left' => 15,
    'margin_right' => 15,
    'margin_top' => 25,
    'margin_bottom' => 15,
    'margin_header' => 5,
    'margin_footer' => 5,
    'default_font' => 'arial'
]);

// Header
$header = '
<div style="text-align: center;">
    <table width="100%" cellpadding="0" cellspacing="0" style="margin-bottom: 5px;">
        <tr>
            <td width="20%" style="text-align: center; vertical-align: top;">
                <img src="../../assets/img/'.$favicon.'" style="height: 70px;">
            </td>
            <td width="80%" style="text-align: center;">
                <h2 style="margin: 0; padding: 0; line-height: 1.2;">'.$title_page.'</h2>
                <p style="margin: 2px 0; font-size: 11px; line-height: 1.3;">'.$alamat_bisnis.'</p>
                <p style="margin: 2px 0; font-size: 11px; line-height: 1.3;">
                    Email: '.$email_bisnis.' | Telp: '.$telepon_bisnis.'
                </p>
            </td>
        </tr>
    </table>
    <hr style="border: 0.5px solid #000; margin: 5px 0 10px 0;">
</div>';
$mpdf->SetHTMLHeader($header);

// Footer
$mpdf->SetHTMLFooter('
<table width="100%" style="font-size:9px;">
    <tr>
        <td width="33%">{DATE j-m-Y}</td>
        <td width="33%" align="center">{PAGENO}/{nbpg}</td>
        <td width="33%" align="right">'.$title_page.'</td>
    </tr>
</table>
');

// Konten
$html = '
<style>
    body { font-family: Arial; font-size: 10pt; }
    .table { width: 100%; border-collapse: collapse; margin-top: 5px; }
    .table th { background-color: #f2f2f2; font-weight: bold; font-size: 9pt; padding: 5px; border: 1px solid #ddd; }
    .table td { padding: 5px; border: 1px solid #ddd; font-size: 9pt; }
    .text-center { text-align: center; }
    .text-left { text-align: left; }
    .text-right { text-align: right; }
    .text-danger { color: red; }
    .bg-success { background-color: #d4edda; }
    .bg-warning { background-color: #fff3cd; }
</style>
<br><br>
<div style="text-align: center; margin-bottom: 10px;">
    <h3 style="margin: 5px 0 2px 0; font-size: 14px;">'.$judul_laporan.'</h3>
    <p style="margin: 0 0 10px 0; font-size: 12px;">'.$periode_laporan.'</p>
</div>

<table class="table">
    <thead>
        <tr>
            <th width="5%">No</th>
            <th width="10%">Tanggal</th>
            <th width="20%">Nama</th>
            <th width="15%">NIP</th>
            <th width="15%">Pinjaman</th>
            <th width="15%">Angsuran</th>
            <th width="10%">Sisa</th>
            <th width="10%">Status</th>
        </tr>
    </thead>
    <tbody>';

// Query data pinjaman
$query = mysqli_query($Conn, "SELECT * FROM pinjaman 
        WHERE tanggal >= '$periode_1' AND tanggal <= '$periode_2' 
        ORDER BY tanggal ASC");

if (mysqli_num_rows($query) == 0) {
    $html .= '
        <tr>
            <td colspan="8" class="text-center">
                <span class="text-danger">Data Pinjaman Tidak Ditemukan!</span>
            </td>
        </tr>
    ';
} else {
    $no = 1;
    $total_pinjaman = 0;
    $total_angsuran = 0;
    
    while ($data = mysqli_fetch_array($query)) {
        $id_pinjaman = $data['id_pinjaman'];
        $tanggal = date('d/m/Y', strtotime($data['tanggal']));
        $nama = $data['nama'];
        $nip = $data['nip'];
        $jumlah_pinjaman = $data['jumlah_pinjaman'];
        $status = $data['status'];
        
        // Hitung total angsuran
        $query_angsuran = mysqli_query($Conn, "SELECT SUM(jumlah) as total FROM pinjaman_angsuran WHERE id_pinjaman='$id_pinjaman'");
        $data_angsuran = mysqli_fetch_array($query_angsuran);
        $total_angsuran = $data_angsuran['total'] ? $data_angsuran['total'] : 0;
        $sisa_pinjaman = $jumlah_pinjaman - $total_angsuran;
        
        // Format angka
        $jumlah_pinjaman_format = number_format($jumlah_pinjaman, 0, ',', '.');
        $total_angsuran_format = number_format($total_angsuran, 0, ',', '.');
        $sisa_pinjaman_format = number_format($sisa_pinjaman, 0, ',', '.');
        
        // Warna status
        $status_class = '';
        if ($status == 'Lunas') {
            $status_class = 'bg-success';
        } elseif ($status == 'Belum Lunas') {
            $status_class = 'bg-warning';
        }
        
        $html .= '
        <tr>
            <td class="text-center">'.$no.'</td>
            <td class="text-left">'.$tanggal.'</td>
            <td class="text-left">'.$nama.'</td>
            <td class="text-left">'.$nip.'</td>
            <td class="text-right">Rp '.$jumlah_pinjaman_format.'</td>
            <td class="text-right">Rp '.$total_angsuran_format.'</td>
            <td class="text-right">Rp '.$sisa_pinjaman_format.'</td>
            <td class="text-center '.$status_class.'">'.$status.'</td>
        </tr>';
        
        $no++;
        $total_pinjaman += $jumlah_pinjaman;
        $total_angsuran += $total_angsuran;
    }
    
    // Total keseluruhan
    $html .= '
    <tr style="font-weight:bold;">
        <td colspan="4" class="text-right">TOTAL</td>
        <td class="text-right">Rp '.number_format($total_pinjaman, 0, ',', '.').'</td>
        <td class="text-right">Rp '.number_format($total_angsuran, 0, ',', '.').'</td>
        <td class="text-right">Rp '.number_format(($total_pinjaman - $total_angsuran), 0, ',', '.').'</td>
        <td></td>
    </tr>';
}

$html .= '
    </tbody>
</table>';

// Total data
$total_data = mysqli_num_rows($query);
$html .= '<p style="margin-top:10px; font-size:10pt;"><strong>Total Data: '.$total_data.'</strong></p>';

// Output
$mpdf->WriteHTML($html);
$nama_file = 'Laporan_Pinjaman_'.$periode_1.'_sd_'.$periode_2.'.pdf';
$mpdf->Output($nama_file, 'I');
?>
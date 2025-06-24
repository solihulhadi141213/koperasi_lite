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
$judul_laporan = "LAPORAN ANGSURAN PINJAMAN";
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
            <th width="10%">Tgl Angsuran</th>
            <th width="10%">Tgl Bayar</th>
            <th width="20%">Nama</th>
            <th width="10%">NIP</th>
            <th width="10%">Pokok</th>
            <th width="10%">Jasa</th>
            <th width="10%">Denda</th>
            <th width="15%">Total</th>
        </tr>
    </thead>
    <tbody>';

// Query data angsuran
$query = mysqli_query($Conn, "SELECT * FROM pinjaman_angsuran 
        WHERE tanggal_angsuran >= '$periode_1' AND tanggal_angsuran <= '$periode_2' 
        ORDER BY tanggal_angsuran ASC");

if (mysqli_num_rows($query) == 0) {
    $html .= '
        <tr>
            <td colspan="9" class="text-center">
                <span class="text-danger">Data Angsuran Tidak Ditemukan!</span>
            </td>
        </tr>
    ';
} else {
    $no = 1;
    $total_pokok = 0;
    $total_jasa = 0;
    $total_denda = 0;
    $total_jumlah = 0;
    
    while ($data = mysqli_fetch_array($query)) {
        $id_anggota = $data['id_anggota'];
        $tanggal_angsuran = date('d/m/Y', strtotime($data['tanggal_angsuran']));
        $tanggal_bayar = date('d/m/Y', strtotime($data['tanggal_bayar']));
        $pokok = $data['pokok'];
        $jasa = $data['jasa'];
        $denda = $data['denda'];
        $jumlah = $data['jumlah'];
        
        // Ambil data anggota
        $nip = GetDetailData($Conn, 'anggota', 'id_anggota', $id_anggota, 'nip');
        $nama = GetDetailData($Conn, 'anggota', 'id_anggota', $id_anggota, 'nama');
        
        // Format rupiah
        $pokok_format = number_format($pokok, 0, ',', '.');
        $jasa_format = number_format($jasa, 0, ',', '.');
        $denda_format = number_format($denda, 0, ',', '.');
        $jumlah_format = number_format($jumlah, 0, ',', '.');
        
        $html .= '
        <tr>
            <td class="text-center">'.$no.'</td>
            <td class="text-left">'.$tanggal_angsuran.'</td>
            <td class="text-left">'.$tanggal_bayar.'</td>
            <td class="text-left">'.$nama.'</td>
            <td class="text-left">'.$nip.'</td>
            <td class="text-right">Rp '.$pokok_format.'</td>
            <td class="text-right">Rp '.$jasa_format.'</td>
            <td class="text-right">Rp '.$denda_format.'</td>
            <td class="text-right">Rp '.$jumlah_format.'</td>
        </tr>';
        
        $no++;
        $total_pokok += $pokok;
        $total_jasa += $jasa;
        $total_denda += $denda;
        $total_jumlah += $jumlah;
    }
    
    // Total keseluruhan
    $html .= '
    <tr style="font-weight:bold;">
        <td colspan="5" class="text-right">TOTAL</td>
        <td class="text-right">Rp '.number_format($total_pokok, 0, ',', '.').'</td>
        <td class="text-right">Rp '.number_format($total_jasa, 0, ',', '.').'</td>
        <td class="text-right">Rp '.number_format($total_denda, 0, ',', '.').'</td>
        <td class="text-right">Rp '.number_format($total_jumlah, 0, ',', '.').'</td>
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
$nama_file = 'Laporan_Angsuran_'.$periode_1.'_sd_'.$periode_2.'.pdf';
$mpdf->Output($nama_file, 'I');
?>
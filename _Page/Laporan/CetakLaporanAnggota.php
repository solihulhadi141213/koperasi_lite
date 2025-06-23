<?php
// Koneksi dan fungsi
include "../../_Config/Connection.php";
include "../../_Config/GlobalFunction.php";
include "../../_Config/SettingGeneral.php";
date_default_timezone_set("Asia/Jakarta");

// Include library mPDF
require_once '../../vendor/autoload.php';

// Validasi parameter GET
if (empty($_GET['periode_1']) || empty($_GET['periode_2'])) {
    die("Parameter periode tidak lengkap!");
}

// Ambil parameter
$periode_1 = $_GET['periode_1'];
$periode_2 = $_GET['periode_2'];

// Format tanggal untuk judul
$periode_1_format = date('d/m/Y', strtotime($periode_1));
$periode_2_format = date('d/m/Y', strtotime($periode_2));

// Buat judul laporan
$judul_laporan = "LAPORAN DATA ANGGOTA";
$periode_laporan = "Periode: $periode_1_format s/d $periode_2_format";

// Inisialisasi mPDF
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

// KOP SURAT (Header)
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
</div><br><br>';
$mpdf->SetHTMLHeader($header);

// Footer
$mpdf->SetHTMLFooter('
<table width="100%" style="font-size: 9px;">
    <tr>
        <td width="33%">{DATE j-m-Y}</td>
        <td width="33%" align="center">{PAGENO}/{nbpg}</td>
        <td width="33%" style="text-align: right;">'.$title_page.'</td>
    </tr>
</table>
');

// Konten HTML
$html = '
<style>
    body { 
        font-family: Arial; 
        font-size: 10pt;
        margin: 0;
        padding: 0;
    }
    .table { 
        width: 100%; 
        border-collapse: collapse;
        margin-top: 5px;
    }
    .table th { 
        background-color: #f2f2f2; 
        font-weight: bold; 
        font-size: 9pt;
        padding: 5px;
        border: 1px solid #ddd;
    }
    .table td { 
        padding: 5px;
        border: 1px solid #ddd;
        font-size: 9pt;
    }
    .text-center { text-align: center; }
    .text-left { text-align: left; }
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
            <th width="15%">Tgl Masuk</th>
            <th width="20%">Nama</th>
            <th width="15%">No.Induk</th>
            <th width="20%">Email</th>
            <th width="15%">Kontak</th>
            <th width="10%">Status</th>
        </tr>
    </thead>
    <tbody>';

// Query data
$query = mysqli_query($Conn, "SELECT * FROM anggota 
        WHERE tanggal_masuk >= '$periode_1' 
        AND tanggal_masuk <= '$periode_2' 
        ORDER BY tanggal_masuk ASC");

if (mysqli_num_rows($query) == 0) {
    $html .= '
        <tr>
            <td colspan="7" class="text-center">
                <span class="text-danger">
                    Data Anggota Tidak Ditemukan!
                </span>
            </td>
        </tr>
    ';
} else {
    $no = 1;
    while ($data = mysqli_fetch_array($query)) {
        $tanggal_masuk = date('d/m/Y', strtotime($data['tanggal_masuk']));
        $nama = $data['nama'];
        $nip = $data['nip'];
        $email = $data['email'];
        $kontak = $data['kontak'];
        $status = $data['status'];

        $html .= '
            <tr>
                <td class="text-center">'.$no.'</td>
                <td class="text-left">'.$tanggal_masuk.'</td>
                <td class="text-left">'.$nama.'</td>
                <td class="text-left">'.$nip.'</td>
                <td class="text-left">'.$email.'</td>
                <td class="text-left">'.$kontak.'</td>
                <td class="text-left">'.$status.'</td>
            </tr>
        ';
        $no++;
    }
}

$html .= '
    </tbody>
</table>';

$total_anggota = mysqli_num_rows($query);
$html .= '<p style="margin-top: 10px; font-size: 10pt;"><strong>Total Anggota: '.$total_anggota.'</strong></p>';

$mpdf->WriteHTML($html);
$nama_file = 'Laporan_Anggota_'.$periode_1.'_sd_'.$periode_2.'.pdf';
$mpdf->Output($nama_file, 'I');
?>

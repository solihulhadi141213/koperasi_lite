<?php
    // Koneksi dan session
    include "../../_Config/Connection.php";
    include "../../_Config/GlobalFunction.php";
    include "../../_Config/Session.php";
    include "../../_Config/SettingGeneral.php";
    date_default_timezone_set("Asia/Jakarta");

    // Include library mPDF
    require_once '../../vendor/autoload.php';
    
    // Validasi Akses
    if(empty($SessionIdAkses)){
        echo '<div class="row">';
        echo '  <div class="col-md-12 text-center">';
        echo '      <small class="text-danger">Sesi Akses Sudah Berakhir, Silahkan Login Ulang</small>';
        echo '  </div>';
        echo '</div>';
        exit();
    }

    // Validasi id_anggota
    if(empty($_POST['id_anggota'])){
        echo '<div class="row">';
        echo '  <div class="col-md-12 text-center">';
        echo '      <small class="text-danger">ID Anggota Tidak Boleh Kosong!</small>';
        echo '  </div>';
        echo '</div>';
        exit();
    }

    // Validasi periode_1
    if(empty($_POST['periode_1'])){
        echo '<div class="row">';
        echo '  <div class="col-md-12 text-center">';
        echo '      <small class="text-danger">Periode Awal Data Tidak Boleh Kosong!</small>';
        echo '  </div>';
        echo '</div>';
        exit();
    }

    // Validasi periode_2
    if(empty($_POST['periode_2'])){
        echo '<div class="row">';
        echo '  <div class="col-md-12 text-center">';
        echo '      <small class="text-danger">Periode Akhir Data Tidak Boleh Kosong!</small>';
        echo '  </div>';
        echo '</div>';
        exit();
    }

    // Buat Variabel
    $id_anggota = validateAndSanitizeInput($_POST['id_anggota']);
    $periode_1 = validateAndSanitizeInput($_POST['periode_1']);
    $periode_2 = validateAndSanitizeInput($_POST['periode_2']);

    // Cek data simpanan
    $jumlah_data_simpanan = mysqli_num_rows(mysqli_query($Conn, "SELECT id_simpanan FROM simpanan WHERE id_anggota='$id_anggota' AND tanggal>='$periode_1' AND tanggal<='$periode_2'"));
    if(empty($jumlah_data_simpanan)){
        echo '<div class="row">';
        echo '  <div class="col-md-12 text-center">';
        echo '      <small class="text-danger">Data tidak bisa ditampilkan karena data simpanan anggota tidak ada</small>';
        echo '  </div>';
        echo '</div>';
        exit();
    }

    // Dapatkan data anggota untuk nama file
    $query_anggota = mysqli_query($Conn, "SELECT nama FROM anggota WHERE id_anggota='$id_anggota'");
    $data_anggota = mysqli_fetch_array($query_anggota);
    $nama_anggota = $data_anggota['nama'];
    $nama_file = 'Laporan_Simpanan_' . str_replace(' ', '_', $nama_anggota) . '_' . $periode_1 . '_sd_' . $periode_2 . '.pdf';

    // Buat konten HTML untuk PDF
    $html = '
    <html>
        <head>
            <style type="text/css">
                @page {
                    margin-top: 1cm;
                    margin-bottom: 1cm;
                    margin-left: 1cm;
                    margin-right: 1cm;
                }
                body {
                    background-color: #FFF;
                    font-family: arial;
                }
                table{
                    border-collapse: collapse;
                    margin-top:10px;
                    width: 100%;
                }
                table.data tr td {
                    border: 1px solid #666;
                    font-size:11px;
                    color:#333;
                    border-spacing: 0px;
                    padding: 4px;
                }
                .text-right {
                    text-align: right;
                }
                .text-center {
                    text-align: center;
                }
                .text-bold {
                    font-weight: bold;
                }
            </style>
        </head>
        <body>';

    //Membuat Kop Surat
    $html .= '
        <table>
            <tr>
                <td width="20%">
                    <img src="../../assets/img/'.$favicon.'" width="80px">
                </td>
                <td width="80%">
                    <h3>'.$title_page.'</h3>
                    <small>'.$alamat_bisnis.'</small><br>
                    <small>Email : '.$email_bisnis.' | Kontak : '.$telepon_bisnis.'</small>
                </td>
            </tr>
        </table>
        <h4 class="text-center">Laporan Simpanan Anggota</h4>
        <p class="text-center">Periode: '.TanggalIndo($periode_1).' s/d '.TanggalIndo($periode_2).'</p>
        <p>Nama Anggota: '.$nama_anggota.'</p>
    ';

    $html .= '<table class="data">';
    $html .= '  <thead>';
    $html .= '      <tr>';
    $html .= '          <td width="5%"><b>NO</b></td>';
    $html .= '          <td width="20%"><b>TANGGAL</b></td>';
    $html .= '          <td width="45%"><b>KATEGORI</b></td>';
    $html .= '          <td width="30%" class="text-right"><b>NOMINAL</b></td>';
    $html .= '      </tr>';
    $html .= '  </thead>';
    $html .= '  <tbody>';

    $no = 1;
    $jumlah_simpanan = 0;
    $jumlah_penarikan = 0;
    $query = mysqli_query($Conn, "SELECT*FROM simpanan WHERE id_anggota='$id_anggota' AND tanggal>='$periode_1' AND tanggal<='$periode_2' ORDER BY tanggal ASC");
    while ($data = mysqli_fetch_array($query)) {
        $id_simpanan_jenis = $data['id_simpanan_jenis'];
        $tanggal = TanggalIndo($data['tanggal']);
        $nip = $data['nip'];
        $nama = $data['nama'];
        $kategori = $data['kategori'];
        $jumlah = $data['jumlah'];
        
        $nama_jenis_simpanan = GetDetailData($Conn, 'simpanan_jenis', 'id_simpanan_jenis', $id_simpanan_jenis, 'nama_simpanan');
        if($kategori == "Penarikan"){
            $label_kategori = 'Penarikan (' . $nama_jenis_simpanan . ')';
            $jumlah_penarikan += $data['jumlah'];
        }else{
            $label_kategori = $kategori . ' (' . $nama_jenis_simpanan . ')';
            $jumlah_simpanan += $data['jumlah'];
        }
        
        $html .= '
            <tr>
                <td>'.$no.'</td>
                <td>'.$tanggal.'</td>
                <td>'.$label_kategori.'</td>
                <td class="text-right">'.$jumlah.'</td>
            </tr>
        ';
        $no++;
    }

    $sisa_simpanan = $jumlah_simpanan - $jumlah_penarikan;

    $html .= '
        <tr class="text-bold">
            <td colspan="3" class="text-right">JUMLAH SIMPANAN</td>
            <td class="text-right">'.$jumlah_simpanan.'</td>
        </tr>
        <tr class="text-bold">
            <td colspan="3" class="text-right">JUMLAH PENARIKAN</td>
            <td class="text-right">'.$jumlah_penarikan.'</td>
        </tr>
        <tr class="text-bold">
            <td colspan="3" class="text-right">SISA SIMPANAN</td>
            <td class="text-right">'.$sisa_simpanan.'</td>
        </tr>
    ';

    $html .= '  </tbody>';
    $html .= '</table>';

    // Tambahkan tanggal cetak
    $html .= '<p style="margin-top: 20px;">Dicetak pada: '.TanggalIndo(date('Y-m-d')).' '.date('H:i:s').'</p>';

    $html .= '
        </body>
    </html>
    ';

    // Buat PDF
    $mpdf = new \Mpdf\Mpdf([
        'mode' => 'utf-8',
        'format' => 'A4',
        'margin_top' => 20,
        'margin_bottom' => 20,
        'margin_left' => 10,
        'margin_right' => 10,
        'default_font_size' => 10,
        'default_font' => 'arial'
    ]);

    $mpdf->SetTitle('Laporan Simpanan Anggota');
    $mpdf->SetAuthor($title_page);
    $mpdf->SetCreator('Sistem '.$title_page);
    $mpdf->WriteHTML($html);

    // Output PDF
    $mpdf->Output($nama_file, 'D'); // 'D' untuk download langsung
    exit();
?>
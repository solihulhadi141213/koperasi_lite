<?php 
    //Koneksi
    include "../../_Config/Connection.php";
    include "../../_Config/GlobalFunction.php";
    include "../../_Config/Session.php";
    include '../../vendor/autoload.php';
    date_default_timezone_set('Asia/Jakarta');
    if(empty($_POST['bulan'])){
        echo "Periode Bulan Tidak Boleh Kosong!";
    }else{
        if(empty($_POST['tahun'])){
            echo "Periode Tahun Tidak Boleh Kosong!";
        }else{
            if(empty($_POST['type_file'])){
                echo "Tipe File Tidak Boleh Kosong!";
            }else{
                $bulan=$_POST['bulan'];
                $tahun=$_POST['tahun'];
                $type_file=$_POST['type_file'];
                //Gabungkan Periode
                $periode="$tahun-$bulan";
                if($type_file=="CSV"){
                    header("Content-type: application/vnd-ms-excel");
                    header("Content-Disposition: attachment; filename=Transaksi.xls");
                }else{
                    if($type_file=="PDF"){
                        //Cetak PDF
                        $mpdf = new \Mpdf\Mpdf();
                        $nama_dokumen= "Transaksi";
                        $mpdf = new \Mpdf\Mpdf(['format' => 'A5']);
                        $mpdf->SetMargins(2, 2, 2, 2);
                        $html='<style>@page *{margin-top: 0px;}</style>'; 
                        ob_start();
                    }else{
                        
                    }
                }
                //Menghitung Jumlah Data
                $jml_data = mysqli_num_rows(mysqli_query($Conn, "SELECT*FROM transaksi WHERE tanggal like '%$periode%'"));
?> 
<html>
    <head>
            <style type="text/css">
                table{
                    border-collapse: collapse;
                    margin-top:10px;
                }
                table tr td {
                    border: 1px solid #666;
                    font-size:11px;
                    color:#333;
                    border-spacing: 0px;
                    padding: 4px;
                    border-spacing: 0px;
                }
            </style>
    </head>
    <body>
        <table width="100%">
            <tr>
                <td align="center"><b>No</b></td>
                <td align="center"><b>ID Transaksi</b></td>
                <td align="center"><b>Tanggal</b></td>
                <td align="center"><b>Transaksi</b></td>
                <td align="center"><b>Kategori</b></td>
                <?php
                    echo '<td align="center"><b>Jumlah</b></td>';
                    echo '<td align="center"><b>Pembayaran</b></td>';
                    echo '<td align="center"><b>Status</b></td>';
                ?>
            </tr>
            <?php
                if(empty($jml_data)){
                    echo '<tr>';
                    echo '  <td colspan="8" align="center">';
                    echo '      Tidak Ada Data Transaksi Yang Ditemukan Pada Periode '.$periode.'';
                    echo '  </td>';
                    echo '</tr>';
                }else{
                    $no = 1;
                    //KONDISI PENGATURAN MASING FILTER
                    $query = mysqli_query($Conn, "SELECT * FROM transaksi WHERE tanggal like '%$periode%'");
                    while ($data = mysqli_fetch_array($query)) {
                        $id_transaksi= $data['id_transaksi'];
                        $uuid_transaksi= $data['uuid_transaksi'];
                        $nama_transaksi= $data['nama_transaksi'];
                        $kategori= $data['kategori'];
                        $tanggal= $data['tanggal'];
                        $jumlah= $data['jumlah'];
                        $pembayaran= $data['pembayaran'];
                        $status= $data['status'];
                        $PembayaranFormat = "" . number_format($pembayaran,0,',','.');
                        $JumlahFormat = "Rp " . number_format($jumlah,0,',','.');
                        //Format Tanggal
                        $strtotime=strtotime($tanggal);
                        $TanggalFormat=date('d/m/Y H:i:s T', $strtotime);
                        echo '<tr>';
                        echo '  <td align="center">'.$no.'</td>';
                        echo '  <td align="left">'.$uuid_transaksi.'</td>';
                        echo '  <td align="left">'.$TanggalFormat.'</td>';
                        echo '  <td align="left">'.$nama_transaksi.'</td>';
                        echo '  <td align="left">'.$kategori.'</td>';
                        echo '  <td align="right">'.$JumlahFormat.'</td>';
                        echo '  <td align="right">'.$PembayaranFormat.'</td>';
                        echo '  <td align="center">'.$status.'</td>';
                        echo '</tr>';
                        $no++;
                    }
                }
            ?>
        </table>
    </body>
</html>
<?php
                if($type_file=="PDF"){
                    $html = ob_get_contents();
                    ob_end_clean();
                    $mpdf->WriteHTML(utf8_encode($html));
                    $mpdf->Output($nama_dokumen.".pdf" ,'I');
                    exit;
                }
            }
        }
    }
?>
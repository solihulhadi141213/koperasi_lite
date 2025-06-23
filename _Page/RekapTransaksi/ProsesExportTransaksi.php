<?php 
    //Koneksi
    include "../../_Config/Connection.php";
    include "../../_Config/GlobalFunction.php";
    include "../../_Config/Session.php";
    include '../../vendor/autoload.php';
    date_default_timezone_set('Asia/Jakarta');
    if(empty($_POST['jenis_transaksi'])){
        echo "Jenis Transaksi Tidak Boleh Kosong!";
    }else{
        if(empty($_POST['tahun'])){
            echo "Periode Tahun Tidak Boleh Kosong!";
        }else{
            if(empty($_POST['file_type'])){
                echo "Tipe File Tidak Boleh Kosong!";
            }else{
                $jenis_transaksi=$_POST['jenis_transaksi'];
                $periode=$_POST['tahun'];
                $type_file=$_POST['file_type'];
                if($type_file=="CSV"){
                    header("Content-type: application/vnd-ms-excel");
                    header("Content-Disposition: attachment; filename=Transaksi.xls");
                }else{
                    if($type_file=="PDF"){
                        //Cetak PDF
                        $mpdf = new \Mpdf\Mpdf();
                        $nama_dokumen= "Transaksi";
                        $mpdf = new \Mpdf\Mpdf(['format' => 'A4']);
                        $mpdf->SetMargins(2, 2, 2, 2);
                        $html='<style>@page *{margin-top: 0px;}</style>'; 
                        ob_start();
                    }else{
                        
                    }
                }
                //Menghitung Jumlah Data
                if($jenis_transaksi=="Semua Jenis"){
                    $jml_data = mysqli_num_rows(mysqli_query($Conn, "SELECT*FROM transaksi WHERE tanggal like '%$periode%'"));
                }else{
                    $jml_data = mysqli_num_rows(mysqli_query($Conn, "SELECT*FROM transaksi WHERE tanggal like '%$periode%'"));
                }
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
                <td align="center"><b>Periode</b></td>
                <td align="center"><b>Record</b></td>
                <td align="center"><b>Transaksi</b></td>
            </tr>
                <?php
                    $JumlahTotalRp=0;
                    $JumlahTotalData=0;
                    if(empty($jenis_transaksi)){
                        // Array dengan nama-nama bulan
                        $namaBulan = [
                            'Januari', 'Februari', 'Maret', 'April', 'Mei', 'Juni',
                            'Juli', 'Agustus', 'September', 'Oktober', 'November', 'Desember'
                        ];
                        // Looping dari 1 hingga 12
                        for ($i = 1; $i <= 12; $i++) {
                            // Mengubah angka menjadi format dua digit
                            $angkaBulan = str_pad($i, 2, '0', STR_PAD_LEFT);
                            // Mengambil nama bulan dari array
                            $namaBulanIni = $namaBulan[$i - 1];
                            ///Membentuk Tahun Bulan
                            $periode="$tahun-$angkaBulan";
                            //Menghitung Jumlah Transaksi
                            $Sum = mysqli_fetch_array(mysqli_query($Conn, "SELECT SUM(jumlah) AS jumlah_total FROM transaksi WHERE tanggal like '%$periode%'"));
                            $jumlah_transaksi = $Sum['jumlah_total'];
                            if(empty($jumlah_transaksi)){
                                $jumlah_transaksi=0;
                            }
                            $JumlahTransaksiFormat = "Rp " . number_format($jumlah_transaksi,0,',','.');
                            //Menghitung Jumlah Record
                            $jml_data = mysqli_num_rows(mysqli_query($Conn, "SELECT id_transaksi FROM transaksi WHERE tanggal like '%$periode%'"));
                            $JumlahTotalRp=$JumlahTotalRp+$jumlah_transaksi;
                            $JumlahTotalData=$JumlahTotalData+$jml_data;
                            echo '<tr>';
                            echo '  <td align="center">'.$i.'</td>';
                            echo '  <td align="left">'.$namaBulanIni.' '.$tahun.'</td>';
                            echo '  <td align="right">'.$jml_data.' Record</td>';
                            echo '  <td align="right">'.$JumlahTransaksiFormat.'</td>';
                            echo '</tr>';
                        }
                    }else{
                        // Array dengan nama-nama bulan
                        $namaBulan = [
                            'Januari', 'Februari', 'Maret', 'April', 'Mei', 'Juni',
                            'Juli', 'Agustus', 'September', 'Oktober', 'November', 'Desember'
                        ];
                        // Looping dari 1 hingga 12
                        for ($i = 1; $i <= 12; $i++) {
                            // Mengubah angka menjadi format dua digit
                            $angkaBulan = str_pad($i, 2, '0', STR_PAD_LEFT);
                            // Mengambil nama bulan dari array
                            $namaBulanIni = $namaBulan[$i - 1];
                            //Menghitung Jumlah Transaksi
                            $Sum = mysqli_fetch_array(mysqli_query($Conn, "SELECT SUM(jumlah) AS jumlah_total FROM transaksi WHERE id_transaksi_jenis='$jenis_transaksi' AND tanggal like '%$periode%'"));
                            $jumlah_transaksi = $Sum['jumlah_total'];
                            if(empty($jumlah_transaksi)){
                                $jumlah_transaksi=0;
                            }
                            $JumlahTransaksiFormat = "Rp " . number_format($jumlah_transaksi,0,',','.');
                            //Menghitung Jumlah Record
                            $jml_data = mysqli_num_rows(mysqli_query($Conn, "SELECT id_transaksi FROM transaksi WHERE id_transaksi_jenis='$jenis_transaksi' AND tanggal like '%$periode%'"));
                            $JumlahTotalRp=$JumlahTotalRp+$jumlah_transaksi;
                            $JumlahTotalData=$JumlahTotalData+$jml_data;
                            echo '<tr>';
                            echo '  <td align="center">'.$i.'</td>';
                            echo '  <td align="left">'.$namaBulanIni.' '.$periode.'</td>';
                            echo '  <td align="right">'.$jml_data.' Record</td>';
                            echo '  <td align="right">'.$JumlahTransaksiFormat.'</td>';
                            echo '</tr>';
                        }
                    }
                    $JumlahTotalRpFormat = "Rp " . number_format($JumlahTotalRp,0,',','.');
                ?>
                <tr>
                    <td colspan="2" align="center">
                        <b>JUMLAH/TOTAL</b>
                    </td>
                    <td align="right"><b><?php echo "$JumlahTotalData"; ?> Record</b></td>
                    <td align="right"><b><?php echo "$JumlahTotalRpFormat"; ?></b></td>
                </tr>
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
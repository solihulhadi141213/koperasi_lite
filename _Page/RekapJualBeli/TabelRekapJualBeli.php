<?php
    //Koneksi
    date_default_timezone_set('Asia/Jakarta');
    include "../../_Config/Connection.php";
    include "../../_Config/GlobalFunction.php";
    include "../../_Config/Session.php";
    if(empty($SessionIdAkses)){
        echo '
            <tr>
                <td colspan="8" class="text-center text-danger">
                    <small>Sesi Akses Sudah Berakhir! Silahkan Login Ulang!</small>
                </td>
            </tr>
        ';
    }else{
        if(empty($_POST['tahun'])){
            $tahun=date('Y');
        }else{
            $tahun=$_POST['tahun'];
        }
        $JumlahTotalPenjualan=0;
        $JumlahTotalReturPenjualan=0;
        $JumlahTotalPenjualanBersih=0;
        $JumlahTotalPembelian=0;
        $JumlahTotalReturPembelian=0;
        $JumlahTotalPembelianBersih=0;
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

            //Menghitung Jumlah Transaksi Penjualan
            $SumPenjualan = mysqli_fetch_array(mysqli_query($Conn, "SELECT SUM(total) AS total FROM transaksi_jual_beli WHERE kategori='Penjualan' AND tanggal like '%$periode%'"));
            if(empty($SumPenjualan['total'])){
                $JumlahPenjualan=0;
            }else{
                $JumlahPenjualan = $SumPenjualan['total'];
            }
            
            //Menghitung Jumlah Transaksi Retur Penjualan
            $SumReturPenjualan = mysqli_fetch_array(mysqli_query($Conn, "SELECT SUM(total) AS total FROM transaksi_jual_beli WHERE kategori='Retur Penjualan' AND tanggal like '%$periode%'"));
            if(empty($SumReturPenjualan['total'])){
                $JumlahReturPenjualan=0;
            }else{
                $JumlahReturPenjualan = $SumReturPenjualan['total'];
            }

            //Menghitung Jumlah Penjualan Bersih
            $JumlahPenjualanBersih = $JumlahPenjualan-$JumlahReturPenjualan;

            //Menghitung Jumlah Transaksi Pembelian
            $SumPembelian = mysqli_fetch_array(mysqli_query($Conn, "SELECT SUM(total) AS total FROM transaksi_jual_beli WHERE kategori='Pembelian' AND tanggal like '%$periode%'"));
            if(empty($SumPembelian['total'])){
                $JumlahPembelian=0;
            }else{
                $JumlahPembelian = $SumPembelian['total'];
            }

            //Menghitung Jumlah Transaksi Retur Pembelian
            $SumReturPembelian = mysqli_fetch_array(mysqli_query($Conn, "SELECT SUM(total) AS total FROM transaksi_jual_beli WHERE kategori='Retur Pembelian' AND tanggal like '%$periode%'"));
            if(empty($SumReturPembelian['total'])){
                $JumlahReturPembelian=0;
            }else{
                $JumlahReturPembelian = $SumReturPembelian['total'];
            }
            //Menghitung Jumlah Penjualan Bersih
            $JumlahPembelianBersih = $JumlahPembelian-$JumlahReturPembelian;

            //Ubah Format Penjualan, Retur Penjualan, Penjualan Bersih, Pembelian, Retur Pembelian, Pembelian Bersih
            $JumlahPenjualanRp = "Rp " . number_format($JumlahPenjualan,0,',','.');
            $JumlahReturPenjualanRp = "Rp " . number_format($JumlahReturPenjualan,0,',','.');
            $JumlahPenjualanBersihRp = "Rp " . number_format($JumlahPenjualanBersih,0,',','.');
            $JumlahPembelianhRp = "Rp " . number_format($JumlahPembelian,0,',','.');
            $JumlahReturPembelianRp = "Rp " . number_format($JumlahReturPembelian,0,',','.');
            $JumlahPembelianBersihRp = "Rp " . number_format($JumlahPembelianBersih,0,',','.');
            echo '<tr>';
            echo '  <td align="center"><small>'.$i.'</small></td>';
            echo '  <td align="left"><small>'.$namaBulanIni.'</small></td>';
            echo '  <td align="right" class="text-success"><small>'.$JumlahPenjualanRp.'</small></td>';
            echo '  <td align="right" class="text-success"><small>'.$JumlahReturPenjualanRp.'</small></td>';
            echo '  <td align="right" class="text-success"><small>'.$JumlahPenjualanBersihRp.'</small></td>';
            echo '  <td align="right" class="text-warning"><small>'.$JumlahPembelianhRp.'</small></td>';
            echo '  <td align="right" class="text-warning"><small>'.$JumlahReturPembelianRp.'</small></td>';
            echo '  <td align="right" class="text-warning"><small>'.$JumlahPembelianBersihRp.'</small></td>';
            echo '</tr>';

            //Hitung Jumlah Total
            $JumlahTotalPenjualan=$JumlahTotalPenjualan+$JumlahPenjualan;
            $JumlahTotalReturPenjualan=$JumlahTotalReturPenjualan+$JumlahReturPenjualan;
            $JumlahTotalPenjualanBersih=$JumlahTotalPenjualanBersih+$JumlahPenjualanBersih;
            $JumlahTotalPembelian=$JumlahTotalPembelian+$JumlahPembelian;
            $JumlahTotalReturPembelian=$JumlahTotalReturPembelian+$JumlahReturPembelian;
            $JumlahTotalPembelianBersih=$JumlahTotalPembelianBersih+$JumlahPembelianBersih;
        }

        //Ubah Format Jumlah Total Menjadi Rp
        $JumlahTotalPenjualan = "Rp " . number_format($JumlahTotalPenjualan,0,',','.');
        $JumlahTotalReturPenjualan = "Rp " . number_format($JumlahTotalReturPenjualan,0,',','.');
        $JumlahTotalPenjualanBersih = "Rp " . number_format($JumlahTotalPenjualanBersih,0,',','.');
        $JumlahTotalPembelian = "Rp " . number_format($JumlahTotalPembelian,0,',','.');
        $JumlahTotalReturPembelian = "Rp " . number_format($JumlahTotalReturPembelian,0,',','.');
        $JumlahTotalPembelianBersih = "Rp " . number_format($JumlahTotalPembelianBersih,0,',','.');
        echo '
            <tr>
                <td colspan="2" class="bg-dark text-light"><b>JUMLAH/TOTAL</b></td>
                <td align="right" class="bg-success text-light"><b>'.$JumlahTotalPenjualan.'</b></td>
                <td align="right" class="bg-success text-light"><b>'.$JumlahTotalReturPenjualan.'</b></td>
                <td align="right" class="bg-success text-light"><b>'.$JumlahTotalPenjualanBersih.'</b></td>
                <td align="right" class="bg-warning text-light"><b>'.$JumlahTotalPembelian.'</b></td>
                <td align="right" class="bg-warning text-light"><b>'.$JumlahTotalReturPembelian.'</b></td>
                <td align="right" class="bg-warning text-light"><b>'.$JumlahTotalPembelianBersih.'</b></td>
            </tr>
        ';
    }
?>
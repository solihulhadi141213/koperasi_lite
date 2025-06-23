<?php
    //Koneksi
    date_default_timezone_set('Asia/Jakarta');
    include "../../_Config/Connection.php";
    include "../../_Config/GlobalFunction.php";
    include "../../_Config/SettingGeneral.php";
    include "../../_Config/Session.php";
    include '../../vendor/autoload.php';
    //Time Zone
    date_default_timezone_set('Asia/Jakarta');
    if(empty($_POST['jenis_transaksi'])){
        $jenis_transaksi="";
    }else{
        $jenis_transaksi=$_POST['jenis_transaksi'];
    }
    if(empty($_POST['tahun'])){
        $tahun=date('Y');
    }else{
        $tahun=$_POST['tahun'];
    }
    //Format Judul Grapik
    if(empty($jenis_transaksi)){
        $nilai_x = [];
        $nilai_y = [];
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
            $nilai_x[] =$namaBulanIni;
            $nilai_y[] =$jumlah_transaksi;
        }
        $Conn->close();
    }else{
        $nilai_x = [];
        $nilai_y = [];
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
            $Sum = mysqli_fetch_array(mysqli_query($Conn, "SELECT SUM(jumlah) AS jumlah_total FROM transaksi WHERE id_transaksi_jenis='$jenis_transaksi' AND tanggal like '%$periode%'"));
            $jumlah_transaksi = $Sum['jumlah_total'];

            $nilai_x[] =$namaBulanIni;
            $nilai_y[] =$jumlah_transaksi;
        }
        $Conn->close();
    }
    // Kirim data dalam format JSON
    echo json_encode(['months' => $nilai_x, 'amounts' => $nilai_y]);
?>

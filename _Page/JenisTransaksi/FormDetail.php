<?php
    //Koneksi
    date_default_timezone_set('Asia/Jakarta');
    include "../../_Config/Connection.php";
    include "../../_Config/GlobalFunction.php";
    include "../../_Config/SettingGeneral.php";
    include "../../_Config/Session.php";
    if(empty($SessionIdAkses)){
        echo '<div class="row">';
        echo '  <div class="col-md-12 mb-3 text-center">';
        echo '      <small class="text-danger">Sesi Akses Sudah Berakhir, Silahkan Login Ulang</small>';
        echo '  </div>';
        echo '</div>';
    }else{
        //Tangkap id_transaksi_jenis
        if(empty($_POST['id_transaksi_jenis'])){
            echo '<div class="row">';
            echo '  <div class="col-md-12 mb-3 text-center">';
            echo '      <small class="text-danger">ID Jenis Transaksi Tidak Boleh Kosong!</small>';
            echo '  </div>';
            echo '</div>';
        }else{
            $id_transaksi_jenis=$_POST['id_transaksi_jenis'];
            //Bersihkan Variabel
            $id_transaksi_jenis=validateAndSanitizeInput($id_transaksi_jenis);
            //Buka Informasi
            $nama=GetDetailData($Conn,'transaksi_jenis','id_transaksi_jenis',$id_transaksi_jenis,'nama');
            $kategori=GetDetailData($Conn,'transaksi_jenis','id_transaksi_jenis',$id_transaksi_jenis,'kategori');
            $deskripsi=GetDetailData($Conn,'transaksi_jenis','id_transaksi_jenis',$id_transaksi_jenis,'deskripsi');
            $id_akun_debet=GetDetailData($Conn,'transaksi_jenis','id_transaksi_jenis',$id_transaksi_jenis,'id_akun_debet');
            $id_akun_kredit=GetDetailData($Conn,'transaksi_jenis','id_transaksi_jenis',$id_transaksi_jenis,'id_akun_kredit');
            //Buka Data Perkiraan
            $nama_perkiraan_debet=GetDetailData($Conn,'akun_perkiraan','id_perkiraan',$id_akun_debet,'nama');
            $nama_perkiraan_kredit=GetDetailData($Conn,'akun_perkiraan','id_perkiraan',$id_akun_kredit,'nama');
            //Menghitung Jumlah Record
            $JumlahTransaksi = mysqli_num_rows(mysqli_query($Conn, "SELECT*FROM transaksi WHERE id_transaksi_jenis='$id_transaksi_jenis'"));
            //Menghitung Jumlah Total (SUM) Transaksi
            $Sum = mysqli_fetch_array(mysqli_query($Conn, "SELECT SUM(jumlah) AS total FROM transaksi WHERE id_transaksi_jenis='$id_transaksi_jenis'"));
            $TotalTransaksi = $Sum['total'];
            //Format Angka
            $JumlahTransaksiFormat = "" . number_format($JumlahTransaksi,0,',','.');
            $TotalTransaksiFormat = "Rp " . number_format($TotalTransaksi,0,',','.');
?>
    <div class="col-md-12 mb-4">
        <div class="row mb-3">
            <div class="col col-md-4">ID Jenis Transaksi</div>
            <div class="col col-md-8">
                <code class="text text-grayish"><?php echo $id_transaksi_jenis; ?></code>
            </div>
        </div>
        <div class="row mb-3">
            <div class="col col-md-4">Nama Transaksi</div>
            <div class="col col-md-8">
                <code class="text text-grayish"><?php echo $nama; ?></code>
            </div>
        </div>
        <div class="row mb-3">
            <div class="col col-md-4">Kategori</div>
            <div class="col col-md-8">
                <code class="text text-grayish"><?php echo $kategori; ?></code>
            </div>
        </div>
        <div class="row mb-3">
            <div class="col col-md-4">Deskripsi</div>
            <div class="col col-md-8">
                <code class="text text-grayish"><?php echo $deskripsi; ?></code>
            </div>
        </div>
        <div class="row mb-3">
            <div class="col col-md-4">Akun Debet</div>
            <div class="col col-md-8">
                <code class="text text-grayish"><?php echo $nama_perkiraan_debet; ?></code>
            </div>
        </div>
        <div class="row mb-3">
            <div class="col col-md-4">Akun Kredit</div>
            <div class="col col-md-8">
                <code class="text text-grayish"><?php echo $nama_perkiraan_kredit; ?></code>
            </div>
        </div>
        <div class="row mb-3">
            <div class="col col-md-4">Jumlah Record</div>
            <div class="col col-md-8">
                <code class="text text-grayish"><?php echo "$JumlahTransaksiFormat Record"; ?></code>
            </div>
        </div>
        <div class="row mb-3">
            <div class="col col-md-4">Total (Rp)</div>
            <div class="col col-md-8">
                <code class="text text-grayish"><?php echo $TotalTransaksiFormat; ?></code>
            </div>
        </div>
    </div>
<?php 
        }
    }
?>
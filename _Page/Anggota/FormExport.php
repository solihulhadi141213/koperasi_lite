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
        //Menghitung Jumlah Data
        $JumlahTotal=mysqli_num_rows(mysqli_query($Conn, "SELECT id_anggota FROM anggota"));
        $JumlahAnggtoaAktif=mysqli_num_rows(mysqli_query($Conn, "SELECT id_anggota FROM anggota WHERE status='Aktif'"));
        $JumlahAnggtoaKeluar=mysqli_num_rows(mysqli_query($Conn, "SELECT id_anggota FROM anggota WHERE status='Keluar'"));
?>
    <div class="row mb-3">
        <div class="col col-md-4">Jumlah Data</div>
        <div class="col col-md-8">
            <code class="text text-grayish"><?php echo "$JumlahTotal Record"; ?></code>
        </div>
    </div>
    <div class="row mb-3">
        <div class="col col-md-4">Anggota Aktif</div>
        <div class="col col-md-8">
            <code class="text text-grayish"><?php echo "$JumlahAnggtoaAktif Record"; ?></code>
        </div>
    </div>
    <div class="row mb-3">
        <div class="col col-md-4">Anggota Keluar</div>
        <div class="col col-md-8">
            <code class="text text-grayish"><?php echo "$JumlahAnggtoaKeluar Record"; ?></code>
        </div>
    </div>
<?php 
    }
?>
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
        if(empty($_POST['id_jurnal'])){
            echo '<div class="row">';
            echo '  <div class="col-md-12 mb-3 text-center">';
            echo '      <small class="text-danger">Tidak ada data yang ditangkap oleh sistem</small>';
            echo '  </div>';
            echo '</div>';
        }else{
            $id_jurnal=$_POST['id_jurnal'];
            //Bersihkan Variabe;
            $id_jurnal=validateAndSanitizeInput($id_jurnal);
            //Buka Detail Simpanan
            $kategori=GetDetailData($Conn,'jurnal','id_jurnal',$id_jurnal,'kategori');
            $uuid=GetDetailData($Conn,'jurnal','id_jurnal',$id_jurnal,'uuid');
            $tanggal=GetDetailData($Conn,'jurnal','id_jurnal',$id_jurnal,'tanggal');
            $kode_perkiraan=GetDetailData($Conn,'jurnal','id_jurnal',$id_jurnal,'kode_perkiraan');
            $nama_perkiraan=GetDetailData($Conn,'jurnal','id_jurnal',$id_jurnal,'nama_perkiraan');
            $d_k=GetDetailData($Conn,'jurnal','id_jurnal',$id_jurnal,'d_k');
            $nilai=GetDetailData($Conn,'jurnal','id_jurnal',$id_jurnal,'nilai');
            //Format tanggal
            $strtotime=strtotime($tanggal);
            $TanggalFormat=date('d/m/Y',$strtotime);
            //Format Rupiah
            $nilai = "Rp " . number_format($nilai,0,',','.');
?>
            <div class="row mb-3">
                <div class="col-md-6">Kode Referensi</div>
                <div class="col-md-6">
                    <code class="text text-grayish"><?php echo $uuid; ?></code>
                </div>
            </div>
            <div class="row mb-3">
                <div class="col-md-6">Kategori</div>
                <div class="col-md-6">
                    <code class="text text-grayish"><?php echo $kategori; ?></code>
                </div>
            </div>
            <div class="row mb-3">
                <div class="col-md-6">Tanggal</div>
                <div class="col-md-6">
                    <code class="text text-grayish"><?php echo $TanggalFormat; ?></code>
                </div>
            </div>
            <div class="row mb-3">
                <div class="col-md-6">Kode Akun</div>
                <div class="col-md-6">
                    <code class="text text-grayish"><?php echo $kode_perkiraan; ?></code>
                </div>
            </div>
            <div class="row mb-3">
                <div class="col-md-6">Nama Akun</div>
                <div class="col-md-6">
                    <code class="text text-grayish"><?php echo $nama_perkiraan; ?></code>
                </div>
            </div>
            <div class="row mb-3">
                <div class="col-md-6">Debet/Kredit</div>
                <div class="col-md-6">
                    <code class="text text-grayish"><?php echo $d_k; ?></code>
                </div>
            </div>
            <div class="row mb-3">
                <div class="col-md-6">Nilai (Rp)</div>
                <div class="col-md-6">
                    <code class="text text-grayish"><?php echo $nilai; ?></code>
                </div>
            </div>
<?php
        }
    }
?>
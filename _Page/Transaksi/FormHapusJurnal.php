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
        //Tangkap id_jurnal
        if(empty($_POST['id_jurnal'])){
            echo '<div class="row">';
            echo '  <div class="col-md-12 mb-3 text-center">';
            echo '      <small class="text-danger">ID Jurnal Tidak Boleh Kosong!</small>';
            echo '  </div>';
            echo '</div>';
        }else{
            $id_jurnal=$_POST['id_jurnal'];
            //Bersihkan Variabel
            $id_jurnal=validateAndSanitizeInput($id_jurnal);
            //Buka Informasi
            $kategori=GetDetailData($Conn,'jurnal','id_jurnal',$id_jurnal,'kategori');
            $uuid=GetDetailData($Conn,'jurnal','id_jurnal',$id_jurnal,'uuid');
            $tanggal=GetDetailData($Conn,'jurnal','id_jurnal',$id_jurnal,'tanggal');
            $kode_perkiraan=GetDetailData($Conn,'jurnal','id_jurnal',$id_jurnal,'kode_perkiraan');
            $nama_perkiraan=GetDetailData($Conn,'jurnal','id_jurnal',$id_jurnal,'nama_perkiraan');
            $d_k=GetDetailData($Conn,'jurnal','id_jurnal',$id_jurnal,'d_k');
            $nilai=GetDetailData($Conn,'jurnal','id_jurnal',$id_jurnal,'nilai');
            //Format Angka
            $NilaiFormat = "" . number_format($nilai,0,',','.');
            //Format Tanggal
            $strtotime=strtotime($tanggal);
            $TanggalFormat=date('d/m/Y', $strtotime);
?>
    <input type="hidden" name="id_jurnal" value="<?php echo $id_jurnal; ?>">
    <div class="col-md-12 mb-4">
        <div class="row mb-3">
            <div class="col col-md-4">Kategori</div>
            <div class="col col-md-8">
                <code class="text text-grayish"><?php echo $kategori; ?></code>
            </div>
        </div>
        <div class="row mb-3">
            <div class="col col-md-4">UUID</div>
            <div class="col col-md-8">
                <code class="text text-grayish"><?php echo $uuid; ?></code>
            </div>
        </div>
        <div class="row mb-3">
            <div class="col col-md-4">Tanggal</div>
            <div class="col col-md-8">
                <code class="text text-grayish"><?php echo $TanggalFormat; ?></code>
            </div>
        </div>
        <div class="row mb-3">
            <div class="col col-md-4">Kode</div>
            <div class="col col-md-8">
                <code class="text text-grayish"><?php echo $kode_perkiraan; ?></code>
            </div>
        </div>
        <div class="row mb-3">
            <div class="col col-md-4">Akun Perkiraan</div>
            <div class="col col-md-8">
                <code class="text text-grayish"><?php echo $nama_perkiraan; ?></code>
            </div>
        </div>
        <div class="row mb-3">
            <div class="col col-md-4">Nilai (Rp)</div>
            <div class="col col-md-8">
                <code class="text text-grayish"><?php echo $NilaiFormat; ?></code>
            </div>
        </div>
        <div class="row mb-3">
            <div class="col col-md-4">Posisi (D/K)</div>
            <div class="col col-md-8">
                <code class="text text-grayish"><?php echo "$d_k"; ?></code>
            </div>
        </div>
        <div class="row mb-3">
            <div class="col col-md-12 text-center">
                <code class="text text-primary">
                    Apakah anda yakin akan menghapus data jurnal ini?
                </code>
            </div>
        </div>
    </div>
<?php 
        }
    }
?>
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
        //Tangkap id_simpanan_jenis
        if(empty($_POST['id_simpanan_jenis'])){
            echo '<div class="row">';
            echo '  <div class="col-md-12 mb-3 text-center">';
            echo '      <small class="text-danger">ID Jenis Simpanan Tidak Boleh Kosong!</small>';
            echo '  </div>';
            echo '</div>';
        }else{
            $id_simpanan_jenis=$_POST['id_simpanan_jenis'];
            $id_simpanan_jenis=validateAndSanitizeInput($id_simpanan_jenis);
            //Buka Informasi
            $nama_simpanan=GetDetailData($Conn,'simpanan_jenis','id_simpanan_jenis',$id_simpanan_jenis,'nama_simpanan');
            $keterangan=GetDetailData($Conn,'simpanan_jenis','id_simpanan_jenis',$id_simpanan_jenis,'keterangan');
            $rutin=GetDetailData($Conn,'simpanan_jenis','id_simpanan_jenis',$id_simpanan_jenis,'rutin');
            $id_perkiraan_debet=GetDetailData($Conn,'simpanan_jenis','id_simpanan_jenis',$id_simpanan_jenis,'id_perkiraan_debet');
            $id_perkiraan_kredit=GetDetailData($Conn,'simpanan_jenis','id_simpanan_jenis',$id_simpanan_jenis,'id_perkiraan_kredit');
            //Buka Data Perkiraan
            $nama_perkiraan_debet=GetDetailData($Conn,'akun_perkiraan','id_perkiraan',$id_perkiraan_debet,'nama');
            $nama_perkiraan_kredit=GetDetailData($Conn,'akun_perkiraan','id_perkiraan',$id_perkiraan_kredit,'nama');
            //Label Rutin
            if(empty($rutin)){
                $LabelRutin='<span class="text text-danger">Tidak</span>';
            }else{
                $LabelRutin='<span class="text text-success">Ya</span>';
            }
            if(empty($keterangan)){
                $LabelKeterangan='<span class="text text-danger">-</span>';
            }else{
                $LabelKeterangan=$keterangan;
            }
?>
    <div class="col-md-12 mb-4">
        <div class="row mb-3">
            <div class="col col-md-4">ID Jenis Simpanan</div>
            <div class="col col-md-8">
                <code class="text text-grayish"><?php echo $id_simpanan_jenis; ?></code>
            </div>
        </div>
        <div class="row mb-3">
            <div class="col col-md-4">Nama Simpanan</div>
            <div class="col col-md-8">
                <code class="text text-grayish"><?php echo $nama_simpanan; ?></code>
            </div>
        </div>
        <div class="row mb-3">
            <div class="col col-md-4">Keterangan</div>
            <div class="col col-md-8">
                <code class="text text-grayish"><?php echo $LabelKeterangan; ?></code>
            </div>
        </div>
        <div class="row mb-3">
            <div class="col col-md-4">Simpanan Wajib?</div>
            <div class="col col-md-8">
                <code class="text text-grayish"><?php echo $LabelRutin; ?></code>
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
    </div>
<?php 
        }
    }
?>
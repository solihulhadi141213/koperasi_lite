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
        //Tangkap id_anggota
        if(empty($_POST['id_anggota'])){
            echo '<div class="row">';
            echo '  <div class="col-md-12 mb-3 text-center">';
            echo '      <small class="text-danger">ID Anggota Tidak Boleh Kosong!</small>';
            echo '  </div>';
            echo '</div>';
        }else{
            $id_anggota=$_POST['id_anggota'];
            $id_anggota=validateAndSanitizeInput($id_anggota);
            //Buka Informasi
            $tanggal_masuk=GetDetailData($Conn,'anggota','id_anggota',$id_anggota,'tanggal_masuk');
            $tanggal_keluar=GetDetailData($Conn,'anggota','id_anggota',$id_anggota,'tanggal_keluar');
            $email=GetDetailData($Conn,'anggota','id_anggota',$id_anggota,'email');
            $nip=GetDetailData($Conn,'anggota','id_anggota',$id_anggota,'nip');
            $nama=GetDetailData($Conn,'anggota','id_anggota',$id_anggota,'nama');
            $password=GetDetailData($Conn,'anggota','id_anggota',$id_anggota,'password');
            $kontak=GetDetailData($Conn,'anggota','id_anggota',$id_anggota,'kontak');
            $lembaga=GetDetailData($Conn,'anggota','id_anggota',$id_anggota,'lembaga');
            $ranking=GetDetailData($Conn,'anggota','id_anggota',$id_anggota,'ranking');
            $foto=GetDetailData($Conn,'anggota','id_anggota',$id_anggota,'foto');
            $akses_anggota=GetDetailData($Conn,'anggota','id_anggota',$id_anggota,'akses_anggota');
            $status=GetDetailData($Conn,'anggota','id_anggota',$id_anggota,'status');
?>
    <input type="hidden" name="id_anggota" value="<?php echo "$id_anggota"; ?>">
    <div class="row mb-3">
        <div class="col col-md-4">Nomor Induk</div>
        <div class="col col-md-8">
            <code class="text text-grayish"><?php echo $nip; ?></code>
        </div>
    </div>
    <div class="row mb-3">
        <div class="col col-md-4">Nama Lengkap</div>
        <div class="col col-md-8">
            <code class="text text-grayish"><?php echo $nama; ?></code>
        </div>
    </div>
    <div class="row mb-3">
        <div class="col col-md-4">Lembaga</div>
        <div class="col col-md-8">
            <code class="text text-grayish"><?php echo $lembaga; ?></code>
        </div>
    </div>
    <div class="row mb-3">
        <div class="col col-md-4">Ranking</div>
        <div class="col col-md-8">
            <code class="text text-grayish"><?php echo $ranking; ?></code>
        </div>
    </div>
    <div class="row mb-3">
        <div class="col col-md-4">Kontak</div>
        <div class="col col-md-8">
            <code class="text text-grayish"><?php echo $kontak; ?></code>
        </div>
    </div>
    <div class="row mb-3">
        <div class="col col-md-4">Email</div>
        <div class="col col-md-8">
            <code class="text text-grayish"><?php echo $email; ?></code>
        </div>
    </div>
    <div class="row mb-3">
        <div class="col col-md-4">
            <label for="foto_edit">Pas Foto</label>
        </div>
        <div class="col-md-8">
            <input type="file" name="foto" id="foto_edit" class="form-control">
            <small class="credit">
                <code class="text text-grayish">
                    File foto maksimal 2 Mb (JPG, JPEG, PNG dan GIF)
                </code>
            </small>
        </div>
    </div>
    <div class="row mb-3">
        <div class="col col-md-4"></div>
        <div class="col-md-8">
            <code class="text-primary">Pastikan data anggota yang anda input sudah benar</code>
        </div>
    </div>
<?php 
        }
    }
?>
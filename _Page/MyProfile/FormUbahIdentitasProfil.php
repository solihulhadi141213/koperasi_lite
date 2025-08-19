<?php
    //Koneksi
    date_default_timezone_set('Asia/Jakarta');
    include "../../_Config/Connection.php";
    include "../../_Config/SettingGeneral.php";
    include "../../_Config/GlobalFunction.php";
    include "../../_Config/Session.php";
    //Harus Login Terlebih Dulu
    if(empty($SessionIdAkses)){
        echo '<div class="row">';
        echo '  <div class="col-md-12 mb-3 text-center">';
        echo '      <code>Sesi Login Sudah Berakhir, Silahkan Login Ulang!</code>';
        echo '  </div>';
        echo '</div>';
    }else{
        
        //Buka data askes
        if($SessionModeAkses=="Anggota"){
            $nama=GetDetailData($Conn,'anggota','id_anggota',$SessionIdAkses,'nama');
            $kontak=GetDetailData($Conn,'anggota','id_anggota',$SessionIdAkses,'kontak');
            $email=GetDetailData($Conn,'anggota','id_anggota',$SessionIdAkses,'email');
        }else{
            $nama=GetDetailData($Conn,'akses','id_akses',$SessionIdAkses,'nama_akses');
            $kontak=GetDetailData($Conn,'akses','id_akses',$SessionIdAkses,'kontak_akses');
            $email=GetDetailData($Conn,'akses','id_akses',$SessionIdAkses,'email_akses');
        }
?>
        <div class="row mb-3">
            <div class="col col-md-4">
                <label for="nama">Nama Lengkap</label>
            </div>
            <div class="col col-md-8">
                <input type="text" name="nama" id="nama" class="form-control" value="<?php echo "$nama"; ?>">
            </div>
        </div>
        <div class="row mb-3">
            <div class="col col-md-4">
                <label for="kontak">Nomor Kontak</label>
            </div>
            <div class="col col-md-8">
                <input type="text" name="kontak" id="kontak" class="form-control" value="<?php echo "$kontak"; ?>">
            </div>
        </div>
        <div class="row mb-3">
            <div class="col col-md-4">
                <label for="email">Alamat Email</label>
            </div>
            <div class="col col-md-8">
                <input type="email" name="email" id="email" class="form-control" value="<?php echo "$email"; ?>">
            </div>
        </div>
<?php } ?>
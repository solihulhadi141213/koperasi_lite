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
        $id_akses=$SessionIdAkses;
?>
        <input type="hidden" name="id_akses" id="id_akses_edit" value="<?php echo "$SessionIdAkses"; ?>">
        <div class="row mb-3">
            <div class="col col-md-12">
                <label for="image_akses_edit">Upload Foto</label>
                <input type="file" name="image_akses" id="image_akses_edit" class="form-control">
                <small class="credit">
                    <code class="text text-grayish">
                        Maximum File 2 Mb (PNG, JPG, JPEG, GIF)
                    </code>
                </small>
            </div>
        </div>
<?php } ?>
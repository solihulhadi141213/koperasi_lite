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
?>
        <div class="row mb-3">
            <div class="col col-md-4">Tahun</div>
            <div class="col col-md-8">
                <input type="number" name="tahun" class="form-control" value="<?php echo date('Y'); ?>">
            </div>
        </div>
        <div class="row mb-3">
            <div class="col col-md-4">Jenis Simpanan</div>
            <div class="col col-md-8">
                <select name="id_simpanan_jenis" class="form-control">
                    <option value="">Semua/Akumulasi</option>
                    <?php
                        $query = mysqli_query($Conn, "SELECT*FROM simpanan_jenis WHERE rutin='1' ORDER BY nama_simpanan ASC");
                        while ($data = mysqli_fetch_array($query)) {
                            $id_simpanan_jenis= $data['id_simpanan_jenis'];
                            $nama_simpanan= $data['nama_simpanan'];
                            echo '<option value="'.$id_simpanan_jenis.'">'.$nama_simpanan.'</option>';
                        }
                    ?>
                </select>
            </div>
        </div>
        <div class="row mb-3">
            <div class="col col-md-12">
                <code class="text text-grayish">
                    Data akan di export dalam format 'Excel' dengan mode periode bulanan.
                </code>
            </div>
        </div>
<?php
    }
?>
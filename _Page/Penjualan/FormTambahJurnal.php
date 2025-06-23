<?php
    //Koneksi
    include "../../_Config/Connection.php";
    include "../../_Config/GlobalFunction.php";
    include "../../_Config/Session.php";

    // Time Zone
    date_default_timezone_set('Asia/Jakarta');

    // Time Now Tmp
    $now = date('Y-m-d H:i:s');

    // Validasi sesi login
    if (empty($SessionIdAkses)) {
        echo '
            <div class="alert alert-danger">
                Sesi Akses Sudah Berakhir! Silahkan Login Ulang.
            </div>
        ';
    } else {
        if(empty($_POST['id_transaksi_jual_beli'])){
            echo '
                <div class="alert alert-danger">
                    ID Transaksi Tidak Boleh Kosong!
                </div>
            ';
        }else{
            $id_transaksi_jual_beli=$_POST['id_transaksi_jual_beli'];


?>
        <input type="hidden" name="id_transaksi_jual_beli" value="<?php echo $id_transaksi_jual_beli; ?>">
        <div class="row mb-3">
            <div class="col-md-4">
                <label for="id_perkiraan">Akun Perkiraan</label>
            </div>
            <div class="col-md-8">
                <select name="id_perkiraan" id="id_perkiraan" class="form-control" required>
                    <?php
                        echo '<option value="">Pilih</option>';
                        
                        // Query untuk mengambil akun level 1 (group utama)
                        $QryGroupUtama = mysqli_query($Conn, "SELECT * FROM akun_perkiraan WHERE level='1' ORDER BY nama");
                        
                        while ($GroupUtama = mysqli_fetch_array($QryGroupUtama)) {
                            $id_perkiraan_utama = $GroupUtama['id_perkiraan'];
                            $kode_utama = $GroupUtama['kode'];
                            $nama_utama = $GroupUtama['nama'];
                            $saldo_normal_utama = $GroupUtama['saldo_normal'];
                            
                            // Tampilkan group utama
                            echo '<optgroup label="'.$nama_utama.' ('.$saldo_normal_utama.')">';

                            // Query untuk mengambil anak group dari group utama berdasarkan kode
                            $QryAnakGroup = mysqli_query($Conn, "SELECT * FROM akun_perkiraan WHERE kode LIKE '$kode_utama%' AND level != '1' ORDER BY nama");
                            while ($AnakGroup = mysqli_fetch_array($QryAnakGroup)) {
                                $id_perkiraan_anak = $AnakGroup['id_perkiraan'];
                                $nama_anak = $AnakGroup['nama'];
                                $saldo_normal_anak = $AnakGroup['saldo_normal'];
                                $kode = $AnakGroup['kode'];
                                $level = $AnakGroup['level'];
                                $LevelTerbawah = mysqli_num_rows(mysqli_query($Conn, "SELECT id_perkiraan FROM akun_perkiraan WHERE kd$level='$kode'"));
                                
                                // Tampilkan anak group
                                if($LevelTerbawah=="1"){
                                    echo '<option value="'.$id_perkiraan_anak.'">-- '.$nama_anak.' ('.$saldo_normal_anak.')</option>';
                                }
                            }
                            echo '</optgroup>';
                        }
                    ?>
                </select>
            </div>
        </div>
        <div class="row mb-3">
            <div class="col-md-4">
                <label for="d_k">Debet/Kredit</label>
            </div>
            <div class="col-md-8">
                <select name="d_k" id="d_k" class="form-control" required>
                    <option value="">Pilih</option>
                    <option value="D">Debet</option>
                    <option value="K">Kredit</option>
                </select>
            </div>
        </div>
        <div class="row mb-3">
            <div class="col-md-4">
                <label for="nominal_jurnal">Nominal</label>
            </div>
            <div class="col-8">
                <div class="input-group">
                    <span class="input-group-text">Rp</span>
                    <input type="text" required class="form-control form-money" name="nominal" id="nominal_jurnal" oninput="this.value = this.value.replace(/[^0-9]/g, '');">
                </div>
            </div>
        </div>
<?php
        }
    }
?>
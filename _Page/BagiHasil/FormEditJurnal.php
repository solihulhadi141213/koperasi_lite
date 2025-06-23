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
            //Bersihkan Variabel
            $id_jurnal=validateAndSanitizeInput($id_jurnal);
            //Buka Data Jurnal
            $uuid=GetDetailData($Conn,'jurnal','id_jurnal',$id_jurnal,'uuid');
            if(empty($uuid)){
                echo '<div class="row">';
                echo '  <div class="col-md-12 mb-3 text-center">';
                echo '      <small class="text-danger">Data Jurnal Tidak Ditemukan Pada Database</small>';
                echo '  </div>';
                echo '</div>';
            }else{
                $kode_perkiraan=GetDetailData($Conn,'jurnal','id_jurnal',$id_jurnal,'kode_perkiraan');
                $nama_perkiraan=GetDetailData($Conn,'jurnal','id_jurnal',$id_jurnal,'nama_perkiraan');
                $d_k=GetDetailData($Conn,'jurnal','id_jurnal',$id_jurnal,'d_k');
                $nilai=GetDetailData($Conn,'jurnal','id_jurnal',$id_jurnal,'nilai');
                //Buat Format Uang Dengan Koma Sebagai Pemisah
                $nilai = "" . number_format($nilai,0,',',',');
?>
    <input type="hidden" name="id_jurnal" value="<?php echo $id_jurnal; ?>">
    <div class="row  mb-3">
        <div class="col col-md-4">
            <label for="id_perkiraan">
                <small>Akun Perkiraan</small>
            </label>
        </div>
        <div class="col col-md-8">
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
                            $LevelTerbawah = mysqli_num_rows(mysqli_query($Conn, "SELECT*FROM akun_perkiraan WHERE kd$level='$kode'"));
                            // Tampilkan anak group
                            if($LevelTerbawah=="1"){
                                if($kode_perkiraan==$kode){
                                    echo '<option selected value="'.$id_perkiraan_anak.'">-- '.$nama_anak.' ('.$saldo_normal_anak.')</option>';
                                }else{
                                    echo '<option value="'.$id_perkiraan_anak.'">-- '.$nama_anak.' ('.$saldo_normal_anak.')</option>';
                                }
                            }
                        }
                        echo '</optgroup>';
                    }
                ?>
            </select>
        </div>
    </div>
    <div class="row mb-3">
        <div class="col col-md-4">
            <label for="nominal_pinjaman_edit">
                <small>Nominal (Rp)</small>
            </label>
        </div>
        <div class="col col-md-8">
            <input type="text" required class="form-control format_uang" name="nominal_pinjaman" id="nominal_pinjaman_edit" value="<?php echo $nilai; ?>">
        </div>
    </div>
    <div class="row mb-3">
        <div class="col col-md-4">
            <label for="d_k">
                <small>Debet/Kredit</small>
            </label>
        </div>
        <div class="col col-md-8">
            <select name="d_k" id="d_k" class="form-control" required>
                <option <?php if($d_k==""){echo "selected";} ?> value="">Pilih</option>
                <option <?php if($d_k=="D"){echo "selected";} ?> value="D">Debet</option>
                <option <?php if($d_k=="K"){echo "selected";} ?> value="K">Kredit</option>
            </select>
        </div>
    </div>
    <script>
        $('#nominal_pinjaman_edit').keypress(function(event) {
            // Hanya mengizinkan angka (0-9) dan tombol kontrol seperti backspace
            var charCode = (event.which) ? event.which : event.keyCode;
            if (charCode > 31 && (charCode < 48 || charCode > 57)) {
                return false;
            }
            return true;
        });
        // Memformat input menjadi format uang dengan pemisah ribuan
        $('.format_uang').on('input', function() {
            var input = $(this).val();
            // Hapus semua karakter non-digit
            input = input.replace(/[\D\s\._\-]+/g, "");
            if (input) {
                // Format dengan pemisah ribuan
                var formattedInput = parseInt(input, 10).toLocaleString('en-US');
                $(this).val(formattedInput);
            } else {
                $(this).val('');
            }
        });
    </script>
<?php
            } 
        } 
    } 
?>
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
        if(empty($_POST['id_simpanan'])){
            echo '<div class="row">';
            echo '  <div class="col col-md-12 text-danger text-center">';
            echo '      ID Simpanan Tidak Boleh Kosong!';
            echo '  </div>';
            echo '</div>';
        }else{
            $id_simpanan=$_POST['id_simpanan'];
            //Bersihkan Variabel
            $id_simpanan=validateAndSanitizeInput($id_simpanan);
?>
    <input type="hidden" name="id_simpanan" value="<?php echo $id_simpanan; ?>">
    <div class="row  mb-3">
        <div class="col col-md-4">
            <label for="id_perkiraan">Akun Perkiraan</label>
        </div>
        <div class="col col-md-8">
            <select name="id_perkiraan" id="id_perkiraan" class="form-control" required>
                <?php
                    echo '<option value="">Pilih</option>';
                    $QryAkun= mysqli_query($Conn, "SELECT*FROM akun_perkiraan ORDER BY nama");
                    while ($DataAkun=mysqli_fetch_array($QryAkun)) {
                        $id_perkiraan = $DataAkun['id_perkiraan'];
                        $kode= $DataAkun['kode'];
                        $nama_perkiraan = $DataAkun['nama'];
                        $level= $DataAkun['level'];
                        $saldo_normal= $DataAkun['saldo_normal'];
                        //Cek apakah di levelnya ada lagi?
                        $LevelTerbawah = mysqli_num_rows(mysqli_query($Conn, "SELECT*FROM akun_perkiraan WHERE kd$level='$kode'"));
                        if($LevelTerbawah=="1"){
                            echo '<option value="'.$id_perkiraan.'">'.$nama_perkiraan.' ('.$saldo_normal.')</option>';
                        }
                    }
                ?>
            </select>
        </div>
    </div>
    <div class="row mb-3">
        <div class="col col-md-4">
            <label for="nominal_jurnal_simpanan">Nominal (Rp)</label>
        </div>
        <div class="col col-md-8">
            <input type="text" required class="form-control format_uang" name="nominal_jurnal_simpanan" id="nominal_jurnal_simpanan">
        </div>
    </div>
    <div class="row mb-3">
        <div class="col col-md-4">
            <label for="d_k">Debet/Kredit</label>
        </div>
        <div class="col col-md-8">
            <select name="d_k" id="d_k" class="form-control" required>
                <option value="">Pilih</option>
                <option value="D">Debet</option>
                <option value="K">Kredit</option>
            </select>
        </div>
    </div>
    <script>
        $('#nominal_jurnal_simpanan').keypress(function(event) {
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
?>
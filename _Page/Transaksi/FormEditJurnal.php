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
            //Buka Informasi Jurnal
            $kode_perkiraan=GetDetailData($Conn,'jurnal','id_jurnal',$id_jurnal,'kode_perkiraan');
            $nama_perkiraan=GetDetailData($Conn,'jurnal','id_jurnal',$id_jurnal,'nama_perkiraan');
            $d_k=GetDetailData($Conn,'jurnal','id_jurnal',$id_jurnal,'d_k');
            $nilai=GetDetailData($Conn,'jurnal','id_jurnal',$id_jurnal,'nilai');
?>
    <input type="hidden" name="id_jurnal" value="<?php echo "$id_jurnal"; ?>">
    <div class="row mb-3">
        <div class="col col-md-4">
            <label for="kode_perkiraan_edit">Akun Perkiraan</label>
        </div>
        <div class="col-md-8">
            <select name="kode_perkiraan" id="kode_perkiraan_edit" class="form-control">
                <option value="">Pilih</option>
                <?php
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
                            if($kode_perkiraan==$kode){
                                echo '<option selected value="'.$kode.'">'.$nama_perkiraan.' ('.$saldo_normal.')</option>';
                            }else{
                                echo '<option value="'.$kode.'">'.$nama_perkiraan.' ('.$saldo_normal.')</option>';
                            }
                        }
                    }
                ?>
            </select>
        </div>
    </div>
    <div class="row mb-3">
        <div class="col col-md-4">
            <label for="d_k_edit">Posisi (D/K)</label>
        </div>
        <div class="col-md-8">
            <select name="d_k" id="d_k_edit" class="form-control">
                <option <?php if($d_k==""){echo "selected";} ?> value="">Pilih</option>
                <option <?php if($d_k=="D"){echo "selected";} ?> value="D">Debet</option>
                <option <?php if($d_k=="K"){echo "selected";} ?> value="K">Kredit</option>
            </select>
        </div>
    </div>
    <div class="row mb-3">
        <div class="col col-md-4">
            <label for="nilai_edit">Nilai</label>
        </div>
        <div class="col-md-8">
            <input type="text" class="form-control" id="nilai_edit" name="nilai" value="<?php echo $nilai; ?>">
        </div>
    </div>
    <div class="row mb-3">
        <div class="col-md-12 text-center">
            <code class="text-primary">Pastikan data yang anda input sudah benar</code>
        </div>
    </div>
    <script>
        $('#nilai_edit').on('keypress', function(e) {
            // Hanya mengizinkan angka (0-9)
            if (e.which < 48 || e.which > 57) {
                e.preventDefault();
            }
        });
    </script>
<?php 
        }
    }
?>
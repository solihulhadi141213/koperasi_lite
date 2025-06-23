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
        //Tangkap id_transaksi
        if(empty($_POST['id_transaksi'])){
            echo '<div class="row">';
            echo '  <div class="col-md-12 mb-3 text-center">';
            echo '      <small class="text-danger">ID Transaksi Tidak Boleh Kosong!</small>';
            echo '  </div>';
            echo '</div>';
        }else{
            $id_transaksi=$_POST['id_transaksi'];
            //Bersihkan Variabel
            $id_transaksi=validateAndSanitizeInput($id_transaksi);
            //Buka Informasi Transaksi
            $uuid_transaksi=GetDetailData($Conn,'transaksi','id_transaksi',$id_transaksi,'uuid_transaksi');
            $tanggal=GetDetailData($Conn,'transaksi','id_transaksi',$id_transaksi,'tanggal');
            $strtotime=strtotime($tanggal);
            $TanggalFormat=date('Y-m-d', $strtotime);
?>
    <input type="hidden" name="uuid" value="<?php echo "$uuid_transaksi"; ?>">
    <div class="row mb-3">
        <div class="col col-md-4">
            <label for="kode_perkiraan">Akun Perkiraan</label>
        </div>
        <div class="col-md-8">
            <select name="kode_perkiraan" id="kode_perkiraan" class="form-control">
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
                            echo '<option value="'.$kode.'">'.$nama_perkiraan.' ('.$saldo_normal.')</option>';
                        }
                    }
                ?>
            </select>
        </div>
    </div>
    <div class="row mb-3">
        <div class="col col-md-4">
            <label for="d_k">Posisi (D/K)</label>
        </div>
        <div class="col-md-8">
            <select name="d_k" id="d_k" class="form-control">
                <option value="">Pilih</option>
                <option value="D">Debet</option>
                <option value="K">Kredit</option>
            </select>
        </div>
    </div>
    <div class="row mb-3">
        <div class="col col-md-4">
            <label for="nilai">Nilai</label>
        </div>
        <div class="col-md-8">
            <input type="text" class="form-control" id="nilai" name="nilai" >
        </div>
    </div>
    <div class="row mb-3">
        <div class="col-md-12 text-center">
            <code class="text-primary">Pastikan data yang anda input sudah benar</code>
        </div>
    </div>
    <script>
        $('#nilai').on('keypress', function(e) {
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
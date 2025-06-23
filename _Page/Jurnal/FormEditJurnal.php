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
            //Bersihkan Variabe;
            $id_jurnal=validateAndSanitizeInput($id_jurnal);
            //Buka Detail Simpanan
            $kategori=GetDetailData($Conn,'jurnal','id_jurnal',$id_jurnal,'kategori');
            $uuid=GetDetailData($Conn,'jurnal','id_jurnal',$id_jurnal,'uuid');
            $tanggal=GetDetailData($Conn,'jurnal','id_jurnal',$id_jurnal,'tanggal');
            $kode_perkiraan=GetDetailData($Conn,'jurnal','id_jurnal',$id_jurnal,'kode_perkiraan');
            $nama_perkiraan=GetDetailData($Conn,'jurnal','id_jurnal',$id_jurnal,'nama_perkiraan');
            $d_k=GetDetailData($Conn,'jurnal','id_jurnal',$id_jurnal,'d_k');
            $nilai=GetDetailData($Conn,'jurnal','id_jurnal',$id_jurnal,'nilai');
            $nilai = "" . number_format($nilai,0,',','.');
?>
            <input type="hidden" name="id_jurnal" value="<?php echo $id_jurnal; ?>">
            <div class="row mb-3">
                <div class="col-md-4">
                    <label for="kategori_edit">Kategori</label>
                </div>
                <div class="col-md-8">
                    <select name="kategori" id="kategori_edit" class="form-control">
                        <option <?php if($kategori==""){echo "selected";} ?> value="">Pilih</option>
                        <option <?php if($kategori=="Simpanan"){echo "selected";} ?> value="Simpanan">Simpanan Anggota</option>
                        <option <?php if($kategori=="Penarikan"){echo "selected";} ?> value="Penarikan">Penarikan Dana</option>
                        <option <?php if($kategori=="Pinjaman"){echo "selected";} ?> value="Pinjaman">Pinjaman</option>
                        <option <?php if($kategori=="Angsuran"){echo "selected";} ?> value="Angsuran">Angsuran</option>
                        <option <?php if($kategori=="Bagi Hasil"){echo "selected";} ?> value="Bagi Hasil">Bagi Hasil (SHU)</option>
                        <option <?php if($kategori=="Transaksi"){echo "selected";} ?> value="Transaksi">Transaksi Lainnya</option>
                        <option <?php if($kategori=="Penjualan"){echo "selected";} ?> value="Penjualan">Penjualan</option>
                        <option <?php if($kategori=="Retur Penjualan"){echo "selected";} ?> value="Retur Penjualan">Retur Penjualan</option>
                        <option <?php if($kategori=="Pembelian"){echo "selected";} ?> value="Pembelian">Pembelian</option>
                        <option <?php if($kategori=="Retur Pembelian"){echo "selected";} ?> value="Retur Pembelian">Retur Pembelian</option>
                    </select>
                </div>
            </div>
            <div class="row mb-3">
                <div class="col-md-4">
                    <label for="uuid_edit">Referensi (UUID)</label>
                </div>
                <div class="col-md-8">
                    <input type="text" name="uuid" id="uuid_edit" class="form-control" value="<?php echo $uuid; ?>">
                    <small>
                        <code class="text text-grayish">
                            *Isi dengan kode UUID Transaksi 
                        </code>
                    </small>
                </div>
            </div>
            <div class="row mb-3">
                <div class="col-md-4">
                    <label for="tanggal_edit">Tanggal</label>
                </div>
                <div class="col-md-8">
                    <input type="date" name="tanggal" id="tanggal_edit" class="form-control" value="<?php echo $tanggal; ?>">
                </div>
            </div>
            <div class="row mb-3">
                <div class="col-md-4">
                    <label for="id_perkiraan_edit">Akun Perkiraan</label>
                </div>
                <div class="col-md-8">
                    <select name="id_perkiraan" id="id_perkiraan_edit" class="form-control" required>
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
                <div class="col-md-4">
                    <label for="d_k_edit">Debet/Kredit</label>
                </div>
                <div class="col-md-8">
                    <select name="d_k" id="d_k_edit" class="form-control" required>
                        <option <?php if($d_k==""){echo "selected";} ?> value="">Pilih</option>
                        <option <?php if($d_k=="D"){echo "selected";} ?> value="D">Debet</option>
                        <option <?php if($d_k=="K"){echo "selected";} ?> value="K">Kredit</option>
                    </select>
                </div>
            </div>
            <div class="row mb-3">
                <div class="col-md-4">
                    <label for="nominal_edit">Nominal</label>
                </div>
                <div class="col-md-8">
                    <input type="text" required class="form-control format_uang" name="nominal" id="nominal_edit" value="<?php echo $nilai; ?>">
                </div>
            </div>
            <script>
                // Fungsi untuk memformat angka menjadi format uang dengan titik
                function formatRibuan(angka) {
                    return angka.replace(/\D/g, '') // Hapus semua karakter yang bukan angka
                                .replace(/\B(?=(\d{3})+(?!\d))/g, '.'); // Tambah titik sebagai pemisah ribuan
                }

                // Event handler untuk memformat input saat diketik
                $(document).on('input', '#nominal_edit', function() {
                    let nilai = $(this).val();
                    $(this).val(formatRibuan(nilai)); // Set nilai input menjadi format uang
                });

                // Batasi input hanya menerima angka
                $(document).on('keydown', '#nominal_edit', function(e) {
                    // Mengizinkan tombol backspace, delete, panah kiri/kanan, dan angka
                    if (e.key.match(/[0-9]|\./) || e.key === "Backspace" || e.key === "ArrowLeft" || e.key === "ArrowRight" || e.key === "Delete") {
                        return true;
                    }
                    e.preventDefault(); // Mencegah input lain yang bukan angka
                });
            </script>
<?php
        }
    }
?>
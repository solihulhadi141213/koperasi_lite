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
        if(empty($_POST['id_pinjaman'])){
            echo '<div class="row">';
            echo '  <div class="col-md-12 mb-3 text-center">';
            echo '      <small class="text-danger">Tidak ada data yang ditangkap oleh sistem</small>';
            echo '  </div>';
            echo '</div>';
        }else{
            $id_pinjaman=$_POST['id_pinjaman'];

            //Buka Detail Pinjaman
            $sql = "SELECT * FROM pinjaman WHERE id_pinjaman = ?";
            $stmt = $Conn->prepare($sql);
            $id = 1;
            $stmt->bind_param("i", $id_pinjaman);
            
            // Eksekusi statement
            $stmt->execute();
            
            // Ambil hasil query
            $result = $stmt->get_result();
            $DataPinjaman = $result->fetch_assoc();
            
            // Simpan hasil ke variabel
            $id_anggota = $DataPinjaman['id_setting_general'] ?? 0;
            $uuid_pinjaman = $DataPinjaman['uuid_pinjaman'] ?? null;
            $nip = $DataPinjaman['nip'] ?? null;
            $nama = $DataPinjaman['nama'] ?? null;
            $lembaga = $DataPinjaman['lembaga'] ?? null;
            $ranking = $DataPinjaman['ranking'] ?? 0;
            $tanggal = $DataPinjaman['tanggal'] ?? null;
            $jatuh_tempo = $DataPinjaman['jatuh_tempo'] ?? null;
            $denda = $DataPinjaman['denda'] ?? 0;
            $sistem_denda = $DataPinjaman['sistem_denda'] ?? null;
            $jumlah_pinjaman = $DataPinjaman['jumlah_pinjaman'] ?? 0;
            $persen_jasa = $DataPinjaman['persen_jasa'] ?? 0;
            $persen_jasa = $DataPinjaman['persen_jasa'] ?? 0;
            $rp_jasa = $DataPinjaman['rp_jasa'] ?? 0;
            $angsuran_pokok = $DataPinjaman['angsuran_pokok'] ?? 0;
            $angsuran_total = $DataPinjaman['angsuran_total'] ?? 0;
            $periode_angsuran = $DataPinjaman['periode_angsuran'] ?? 0;
            $status = $DataPinjaman['status'] ?? null;

            // Tutup statement
            $stmt->close();

            //Format tanggal
            $strtotime=strtotime($tanggal);
            $TanggalFormat=date('d/m/Y',$strtotime);
            $denda_format = "" . number_format($denda,0,',',',');
            $jumlah_pinjaman_format = "" . number_format($jumlah_pinjaman,0,',',',');
            $rp_jasa_format = "" . number_format($rp_jasa,0,',',',');
            $angsuran_pokok_format = "" . number_format($angsuran_pokok,0,',',',');
            $angsuran_total_format = "" . number_format($angsuran_total,0,',',',');
            //Cek Apakah Sudah Ada Angsuran
            $JumlahDataAngsuran = mysqli_num_rows(mysqli_query($Conn, "SELECT*FROM pinjaman_angsuran WHERE id_pinjaman='$id_pinjaman'"));
            if(!empty($JumlahDataAngsuran)){
                echo '<div class="row">';
                echo '  <div class="col-md-12 mb-3 text-center">';
                echo '      <small class="text-danger">Data sesi pinjaman sudah memiliki angsuran. Anda tidak bisa melakukan perubahan pada data tersebut.</small>';
                echo '  </div>';
                echo '</div>';
            }else{
?>
            <input type="hidden" name="id_pinjaman" class="form-control" value="<?php echo $id_pinjaman; ?>">
            <div class="row mb-3">
                <div class="col-md-4">Nama Anggota</div>
                <div class="col-md-8">
                    <code class="text text-grayish"><?php echo "$nama"; ?></code>
                </div>
            </div>
            <div class="row mb-3">
                <div class="col-md-4">NIP</div>
                <div class="col-md-8">
                    <code class="text text-grayish"><?php echo "$nip"; ?></code>
                </div>
            </div>
            <div class="row mb-3">
                <div class="col-md-4">Divisi/Unit</div>
                <div class="col-md-8">
                    <code class="text text-grayish"><?php echo "$lembaga"; ?></code>
                </div>
            </div>
            <div class="row mb-3">
                <div class="col-md-4">Ranking</div>
                <div class="col-md-8">
                    <code class="text text-grayish"><?php echo "$ranking"; ?></code>
                </div>
            </div>
            <div class="row mb-3">
                <div class="col-md-4">
                    <label for="tanggal">Tanggal Pinjaman</label>
                </div>
                <div class="col-md-8">
                    <input type="date" id="tanggal" name="tanggal" class="form-control" value="<?php echo $tanggal; ?>">
                </div>
            </div>
            <div class="row mb-3">
                <div class="col-md-4">
                    <label for="jatuh_tempo">Tanggal Tempo</label>
                </div>
                <div class="col-md-8">
                    <input type="text" id="jatuh_tempo" name="jatuh_tempo" class="form-control" value="<?php echo $jatuh_tempo; ?>">
                    <small class="credit">
                        <code class="text text-grayish">
                            Diisi dengan tanggal jatuh tempo. Apabila pembayaran angsuran melebihi tanggal tersebut maka akan berlaku denda.
                        </code>
                    </small>
                </div>
            </div>
            <div class="row mb-3">
                <div class="col-md-4">
                    <label for="jumlah_pinjaman">Jumlah Pinjaman</label>
                </div>
                <div class="col-md-8">
                    <input type="text" id="jumlah_pinjaman" name="jumlah_pinjaman" class="form-control format_uang akumulasi_pinjaman" placeholder="Rp" value="<?php echo $jumlah_pinjaman_format; ?>">
                </div>
            </div>
            <div class="row mb-3">
                <div class="col-md-4">
                    <label for="periode_angsuran">Periode Angsuran</label>
                </div>
                <div class="col-md-8">
                    <input type="text" id="periode_angsuran" name="periode_angsuran" class="form-control akumulasi_pinjaman" placeholder="Bulan" value="<?php echo $periode_angsuran; ?>">
                    <small class="credit">
                        <code class="text text-grayish">
                            Diisi dengan banyaknya periode angsuran (Bulan).
                        </code>
                    </small>
                </div>
            </div>
            <div class="row mb-3">
                <div class="col-md-4">
                    <label for="persen_jasa">Margin (%)</label>
                </div>
                <div class="col-md-8">
                    <input type="text" id="persen_jasa" name="persen_jasa" class="form-control number-decimal-only akumulasi_pinjaman" placeholder="%" value="<?php echo $persen_jasa; ?>">
                    <small class="credit">
                        <code class="text text-grayish">
                            Untuk penulisan desimal menggunakan tanda 'titik' sebagai 'koma' pada bilangan desimal. 
                            Contoh: 10.99
                        </code>
                    </small>
                </div>
            </div>
            <div class="row mb-3">
                <div class="col-md-4">
                    <label for="rp_jasa">Margin (Rp)</label>
                </div>
                <div class="col-md-8">
                    <input type="text" readonly id="rp_jasa" name="rp_jasa" class="form-control format_uang" placeholder="Rp" value="<?php echo $rp_jasa_format; ?>">
                    <small class="credit">
                        <code class="text text-grayish">
                            Nilai Rp jasa dalam setiap angsuran.
                        </code>
                    </small>
                </div>
            </div>
            <div class="row mb-3">
                <div class="col-md-4">
                    <label for="angsuran_pokok">Angsuran Pokok</label>
                </div>
                <div class="col-md-8">
                    <input type="text" readonly id="angsuran_pokok" name="angsuran_pokok" class="form-control format_uang" placeholder="Rp" value="<?php echo $angsuran_pokok_format; ?>">
                    <small class="credit">
                        <code class="text text-grayish">
                            Nilai angsuran tanpa perhitungan jasa.
                        </code>
                    </small>
                </div>
            </div>
            <div class="row mb-3">
                <div class="col-md-4">
                    <label for="angsuran_total">Angsuran + Jasa</label>
                </div>
                <div class="col-md-8">
                    <input type="text" readonly id="angsuran_total" name="angsuran_total" class="form-control format_uang" placeholder="Rp" value="<?php echo $angsuran_total_format; ?>">
                    <small class="credit">
                        <code class="text text-grayish">
                            Nilai angsuran ditambah dengan perhitungan jasa.
                        </code>
                    </small>
                </div>
            </div>
            <div class="row mb-3">
                <div class="col-md-4">
                    <label for="denda">Denda</label>
                </div>
                <div class="col-md-8">
                    <input type="text" id="denda" name="denda" class="form-control format_uang" placeholder="Rp" value="<?php echo $denda_format; ?>">
                    <small class="credit">
                        <code class="text text-grayish">
                            Diisi dengan nominal denda 
                        </code>
                    </small>
                </div>
            </div>
            <div class="row mb-3">
                <div class="col-md-4">
                    <label for="denda">Sistem Denda</label>
                </div>
                <div class="col-md-8">
                    <select name="sistem_denda" id="sistem_denda" class="form-control">
                        <option <?php if($sistem_denda==""){echo "selected";} ?> value="">Pilih</option>
                        <option <?php if($sistem_denda=="Harian"){echo "selected";} ?> value="Harian">Harian</option>
                        <option <?php if($sistem_denda=="Bulanan"){echo "selected";} ?> value="Bulanan">Bulanan</option>
                    </select>
                </div>
            </div>
            <script>
                $('#jatuh_tempo').keypress(function(event) {
                    // Hanya mengizinkan angka (0-9) dan tombol kontrol seperti backspace
                    var charCode = (event.which) ? event.which : event.keyCode;
                    if (charCode > 31 && (charCode < 48 || charCode > 57)) {
                        return false;
                    }
                    return true;
                });
                $('#jumlah_pinjaman').keypress(function(event) {
                    // Hanya mengizinkan angka (0-9) dan tombol kontrol seperti backspace
                    var charCode = (event.which) ? event.which : event.keyCode;
                    if (charCode > 31 && (charCode < 48 || charCode > 57)) {
                        return false;
                    }
                    return true;
                });
                $('#denda').keypress(function(event) {
                    // Hanya mengizinkan angka (0-9) dan tombol kontrol seperti backspace
                    var charCode = (event.which) ? event.which : event.keyCode;
                    if (charCode > 31 && (charCode < 48 || charCode > 57)) {
                        return false;
                    }
                    return true;
                });
                $('#periode_angsuran').keypress(function(event) {
                    // Hanya mengizinkan angka (0-9) dan tombol kontrol seperti backspace
                    var charCode = (event.which) ? event.which : event.keyCode;
                    if (charCode > 31 && (charCode < 48 || charCode > 57)) {
                        return false;
                    }
                    return true;
                });
                $('#persen_jasa').on('keypress', function(event) {
                    var charCode = (event.which) ? event.which : event.keyCode;
                    var inputVal = $(this).val();
                    // Mengizinkan angka (0-9) dan satu titik (.)
                    if ((charCode < 48 || charCode > 57) && charCode !== 46) {
                        event.preventDefault();
                    }
                    // Mencegah lebih dari satu titik (.)
                    if (charCode === 46 && inputVal.indexOf('.') !== -1) {
                        event.preventDefault();
                    }
                });
                // Pastikan hanya satu titik dalam input
                $('#persen_jasa').on('input', function() {
                    var val = $(this).val();
                    if ((val.match(/\./g) || []).length > 1) {
                        $(this).val(val.slice(0, val.lastIndexOf('.')));
                    }
                });
                // Optional: Mengizinkan tombol kontrol seperti backspace, delete, arrow keys
                $('#persen_jasa').on('keydown', function(event) {
                    var key = event.which || event.keyCode;
                    if (
                        key === 8 ||    // backspace
                        key === 46 ||   // delete
                        key === 37 ||   // left arrow
                        key === 39 ||   // right arrow
                        key === 9  ||   // tab
                        key === 27 ||   // escape
                        key === 13      // enter
                    ) {
                        return true;
                    }
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
                //Ketika class akumulasi_pinjaman Diisi Sistem Menghitung Rp Jasa
                $('.akumulasi_pinjaman').on('input', function() {
                    var persen_jasa=$('#persen_jasa').val();
                    var rawValue=$('#jumlah_pinjaman').val();
                    var periode_angsuran=$('#periode_angsuran').val();
                    //Mengisi RP Jasa
                    if(persen_jasa!==0&&persen_jasa!==""&&jumlah_pinjaman!==0&&jumlah_pinjaman!==""){
                        var jumlah_pinjaman = rawValue.replace(/,/g, '');
                        var rp_jasa=jumlah_pinjaman*(persen_jasa/100);
                        var rp_jasaBulat = Math.round(rp_jasa);
                        var rp_jasaBulat_uang = parseInt(rp_jasaBulat, 10).toLocaleString('en-US');
                        $('#rp_jasa').val(rp_jasaBulat_uang);
                    }else{
                        $('#rp_jasa').val('0');
                    }
                    //Mengisi Angsuran Pokok
                    if(periode_angsuran!==0&&periode_angsuran!==""&&jumlah_pinjaman!==0&&jumlah_pinjaman!==""){
                        var jumlah_pinjaman = rawValue.replace(/,/g, '');
                        var angsuran_pokok=jumlah_pinjaman/periode_angsuran;
                        var angsuran_pokokBulat = Math.round(angsuran_pokok);
                        var angsuran_pokokBulat_uang = parseInt(angsuran_pokokBulat, 10).toLocaleString('en-US');
                        $('#angsuran_pokok').val(angsuran_pokokBulat_uang);
                    }else{
                        var jumlah_pinjaman = rawValue.replace(/,/g, '');
                        var jumlah_pinjaman_uang = parseInt(jumlah_pinjaman, 10).toLocaleString('en-US');
                        $('#angsuran_pokok').val(jumlah_pinjaman_uang);
                    }
                    //Mengisi angsuran_total 
                    if(periode_angsuran!==0&&periode_angsuran!==""&&jumlah_pinjaman!==0&&jumlah_pinjaman!==""){
                        var jumlah_pinjaman = rawValue.replace(/,/g, '');
                        var rp_jasa=jumlah_pinjaman*(persen_jasa/100);
                        var rp_jasaBulat = Math.round(rp_jasa);
                        var angsuran_pokok=jumlah_pinjaman/periode_angsuran;
                        var angsuran_pokokBulat = Math.round(angsuran_pokok);
                        var angsuran_total=rp_jasaBulat+angsuran_pokokBulat;
                        var angsuran_total_uang = parseInt(angsuran_total, 10).toLocaleString('en-US');
                        $('#angsuran_total').val(angsuran_total_uang);
                    }else{
                        var jumlah_pinjaman = rawValue.replace(/,/g, '');
                        var jumlah_pinjaman_uang = parseInt(jumlah_pinjaman, 10).toLocaleString('en-US');
                        $('#angsuran_total').val(jumlah_pinjaman_uang);
                    }
                });
            </script>
<?php
            }
        }
    }
?>
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
        if(empty($_POST['id_anggota'])){
            echo '<div class="row">';
            echo '  <div class="col-md-12 mb-3 text-center">';
            echo '      <small class="text-danger">ID Anggtoa Tidak Boleh Kosong!</small>';
            echo '  </div>';
            echo '</div>';
        }else{
            $id_anggota=$_POST['id_anggota'];
            $id_anggota=validateAndSanitizeInput($id_anggota);
            $id_anggota=GetDetailData($Conn,'anggota','id_anggota',$id_anggota,'id_anggota');
            if(empty($id_anggota)){
                echo '<div class="row">';
                echo '  <div class="col-md-12 mb-3 text-center">';
                echo '      <small class="text-danger">Anggota yang anda pilih tidak valid, atau tidak ada pada database!</small>';
                echo '  </div>';
                echo '</div>';
            }else{
                $nama=GetDetailData($Conn,'anggota','id_anggota',$id_anggota,'nama');
                $nip=GetDetailData($Conn,'anggota','id_anggota',$id_anggota,'nip');
                $lembaga=GetDetailData($Conn,'anggota','id_anggota',$id_anggota,'lembaga');
                $ranking=GetDetailData($Conn,'anggota','id_anggota',$id_anggota,'ranking');
?>
        <input type="hidden" name="id_anggota" class="form-control" value="<?php echo $id_anggota; ?>">
        <input type="hidden" name="persen_jasa_pinjaman_jenis" id="persen_jasa_pinjaman_jenis" class="form-control" value="">
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
                <input type="date" id="tanggal" name="tanggal" class="form-control">
            </div>
        </div>
        <div class="row mb-3">
            <div class="col-md-4">
                <label for="jatuh_tempo">Tanggal Tempo</label>
            </div>
            <div class="col-md-8">
                <input type="text" id="jatuh_tempo" name="jatuh_tempo" class="form-control">
                <small class="credit">
                    <code class="text text-grayish">
                        Diisi dengan tanggal jatuh tempo. Apabila pembayaran angsuran melebihi tanggal tersebut maka akan berlaku denda.
                    </code>
                </small>
            </div>
        </div>
        <div class="row mb-3">
            <div class="col-md-4">
                <label for="id_pinjaman_jenis">Jenis Pinjaman</label>
            </div>
            <div class="col-md-8">
                <select name="id_pinjaman_jenis" id="id_pinjaman_jenis" class="form-control">
                    <option value="">Pilih</option>
                    <?php
                        $query_jenis_pinjaman = mysqli_query($Conn, "SELECT*FROM pinjaman_jenis");
                        while ($data_jenis_pinjaman = mysqli_fetch_array($query_jenis_pinjaman)) {
                            $id_pinjaman_jenis= $data_jenis_pinjaman['id_pinjaman_jenis'];
                            $nama_pinjaman= $data_jenis_pinjaman['nama_pinjaman'];
                            $periode_angsuran= $data_jenis_pinjaman['periode_angsuran'];
                            $persen_jasa= $data_jenis_pinjaman['persen_jasa'];
                            echo '
                                <option value="'.$id_pinjaman_jenis.'">'.$nama_pinjaman.' ('.$persen_jasa.' % / '.$periode_angsuran.' Bulan)</option>
                            ';
                        }
                    ?>
                </select>
                <small id="NotifikasiiPilihJenisPinjaman"></small>
            </div>
        </div>
        <div class="row mb-3">
            <div class="col-md-4">
                <label for="jumlah_pinjaman">Jumlah Pinjaman</label>
            </div>
            <div class="col-md-8">
                <input type="text" id="jumlah_pinjaman" name="jumlah_pinjaman" class="form-control format_uang akumulasi_pinjaman" placeholder="Rp">
            </div>
        </div>
        <div class="row mb-3">
            <div class="col-md-4">
                <label for="periode_angsuran">Periode Angsuran</label>
            </div>
            <div class="col-md-8">
                <input type="text" id="periode_angsuran" name="periode_angsuran" class="form-control" placeholder="Bulan">
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
                <input type="text" id="persen_jasa" name="persen_jasa" class="form-control number-decimal-only akumulasi_pinjaman" placeholder="%">
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
                <input type="text" readonly id="rp_jasa" name="rp_jasa" class="form-control format_uang" placeholder="Rp">
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
                <input type="text" readonly id="angsuran_pokok" name="angsuran_pokok" class="form-control format_uang" placeholder="Rp">
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
                <input type="text" readonly id="angsuran_total" name="angsuran_total" class="form-control format_uang" placeholder="Rp">
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
                <input type="text" id="denda" name="denda" class="form-control format_uang" placeholder="Rp">
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
                    <option value="">Pilih</option>
                    <option value="Harian">Harian</option>
                    <option value="Bulanan">Bulanan</option>
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

            // Fungsi untuk menghitung Rp Jasa, Rp Angsuran Pokok, dan Rp Angsuran + Jasa
            function hitungAngsuran() {
                var persen_jasa = $('#persen_jasa').val();
                var rawValue = $('#jumlah_pinjaman').val();
                var periode_angsuran = $('#periode_angsuran').val();

                // Mengisi RP Jasa
                if (persen_jasa !== 0 && persen_jasa !== "" && rawValue !== 0 && rawValue !== "") {
                    var jumlah_pinjaman = rawValue.replace(/,/g, '');
                    var rp_jasa = jumlah_pinjaman * (persen_jasa / 100);
                    var rp_jasaBulat = Math.round(rp_jasa);
                    var rp_jasaBulat_uang = parseInt(rp_jasaBulat, 10).toLocaleString('en-US');
                    $('#rp_jasa').val(rp_jasaBulat_uang);
                } else {
                    $('#rp_jasa').val('0');
                }

                // Mengisi Angsuran Pokok
                if (periode_angsuran !== 0 && periode_angsuran !== "" && rawValue !== 0 && rawValue !== "") {
                    var jumlah_pinjaman = rawValue.replace(/,/g, '');
                    var angsuran_pokok = jumlah_pinjaman / periode_angsuran;
                    var angsuran_pokokBulat = Math.round(angsuran_pokok);
                    var angsuran_pokokBulat_uang = parseInt(angsuran_pokokBulat, 10).toLocaleString('en-US');
                    $('#angsuran_pokok').val(angsuran_pokokBulat_uang);
                } else {
                    var jumlah_pinjaman = rawValue.replace(/,/g, '');
                    var jumlah_pinjaman_uang = parseInt(jumlah_pinjaman, 10).toLocaleString('en-US');
                    $('#angsuran_pokok').val(jumlah_pinjaman_uang);
                }

                // Mengisi angsuran_total 
                if (periode_angsuran !== 0 && periode_angsuran !== "" && rawValue !== 0 && rawValue !== "") {
                    var jumlah_pinjaman = rawValue.replace(/,/g, '');
                    var rp_jasa = jumlah_pinjaman * (persen_jasa / 100);
                    var rp_jasaBulat = Math.round(rp_jasa);
                    var angsuran_pokok = jumlah_pinjaman / periode_angsuran;
                    var angsuran_pokokBulat = Math.round(angsuran_pokok);
                    var angsuran_total = rp_jasaBulat + angsuran_pokokBulat;
                    var angsuran_total_uang = parseInt(angsuran_total, 10).toLocaleString('en-US');
                    $('#angsuran_total').val(angsuran_total_uang);
                } else {
                    var jumlah_pinjaman = rawValue.replace(/,/g, '');
                    var jumlah_pinjaman_uang = parseInt(jumlah_pinjaman, 10).toLocaleString('en-US');
                    $('#angsuran_total').val(jumlah_pinjaman_uang);
                }
            }

            // Ketika class akumulasi_pinjaman Diisi Sistem Menghitung Rp Jasa
            $('.akumulasi_pinjaman').on('input', function() {
                hitungAngsuran();
            });

            // Ketika Jenis pinjaman diubah
            $('#id_pinjaman_jenis').on('change', function() {
                var id_pinjaman_jenis = $('#id_pinjaman_jenis').val();
                // Membuka Detail Jenis Pinjaman Dengan AJAX
                $.ajax({
                    type: 'POST',
                    url: '_Page/JenisPinjaman/_detail_jenis_pinjaman.php',
                    dataType: "json",
                    data: { id_pinjaman_jenis: id_pinjaman_jenis },
                    success: function(response) {
                        if (response.status == "Success") {
                            var dataset = response.dataset;
                            var periode_angsuran = dataset.periode_angsuran;
                            var persen_jasa = dataset.persen_jasa;
                            var persen_perbulan = (persen_jasa / periode_angsuran).toFixed(2);

                            // Tempelkan ke form
                            $('#periode_angsuran').val(periode_angsuran);
                            $('#persen_jasa').val(persen_perbulan);
                            $('#persen_jasa_pinjaman_jenis').val(persen_jasa);

                            // Hitung ulang angsuran setelah mengubah nilai
                            hitungAngsuran();

                            //Menangkap jumlah pinjaman
                            var jumlah_pinjaman=$('#jumlah_pinjaman').val();
                            var jumlah_pinjaman = jumlah_pinjaman.replace(/,/g, '');
                            //Menghitung Angsuran Pokok
                            var angsuran_pokok=jumlah_pinjaman/periode_angsuran;
                            //Bulatkan hasilnya
                            var angsuran_pokok_bulat = Math.round(angsuran_pokok);
                            var angsuran_pokok_bulat = parseInt(angsuran_pokok_bulat, 10).toLocaleString('en-US');
                            //Tempelkan hasilnya
                            $('#angsuran_pokok').val(angsuran_pokok_bulat);
                        }else{
                            $('#persen_jasa_pinjaman_jenis').val(0);
                        }
                    },
                    error: function() {
                        // Tempelkan Notifikasi
                        $('#NotifikasiiPilihJenisPinjaman').html(
                            '<div class="alert alert-danger mt-3" role="alert"><small>Terjadi kesalahan pada saat membuka detail jenis pinjaman</small></div>'
                        );

                        $('#persen_jasa_pinjaman_jenis').val(0);
                    },
                });
            });
            // Ketika PERIODE ANGSURAN diubah
            $('#periode_angsuran').on('input', function() {
                var periode_angsuran = $('#periode_angsuran').val();
                var persen_jasa_pinjaman_jenis = $('#persen_jasa_pinjaman_jenis').val();
                if (persen_jasa_pinjaman_jenis !== ""&& persen_jasa_pinjaman_jenis !== 0) {
                    // Menghitung persen_jasa
                    var persen_jasa = 0; // default nilai persen_jasa
                    if (periode_angsuran !== "" && persen_jasa_pinjaman_jenis !== "") {
                        persen_jasa = parseFloat(persen_jasa_pinjaman_jenis) / parseFloat(periode_angsuran);
                    }
                    persen_jasa = persen_jasa.toFixed(2);
                    $('#persen_jasa').val(persen_jasa);
                    
                    // Menghitung Rp Jasa
                    var rawValue = $('#jumlah_pinjaman').val();
                    var jumlah_pinjaman = rawValue.replace(/,/g, '');
                    var rp_jasa = 0; // default nilai rp_jasa
                    if (jumlah_pinjaman !== "" && !isNaN(jumlah_pinjaman) && persen_jasa !== 0) {
                        jumlah_pinjaman = parseFloat(jumlah_pinjaman);
                        rp_jasa = jumlah_pinjaman * (persen_jasa / 100);
                    }
                    //Ubah Format
                    var rp_jasa_format = parseInt(rp_jasa, 10).toLocaleString('en-US');
                    $('#rp_jasa').val(rp_jasa_format);

                    var angsuran_pokok=parseFloat(jumlah_pinjaman/periode_angsuran);
                    var angsuran_pokok_format = parseInt(angsuran_pokok, 10).toLocaleString('en-US');
                    //Bersihkan
                    var angsuran_total = parseInt(angsuran_pokok) + parseInt(rp_jasa);
                    var formatted_angsuran_total = parseInt(angsuran_total, 10).toLocaleString('en-US');
                    //Tempelkan Angsuran Pokok dan angsuran total
                    $('#angsuran_pokok').val(angsuran_pokok_format);
                    $('#angsuran_total').val(formatted_angsuran_total);
                }
                if(persen_jasa_pinjaman_jenis=="" || persen_jasa_pinjaman_jenis==0){
                    var persen_jasa = 0;
                    var jumlah_pinjaman = $('#jumlah_pinjaman').val();
                    var jumlah_pinjaman = jumlah_pinjaman.replace(/,/g, '');
                    var periode_angsuran = $('#periode_angsuran').val();
                    var periode_angsuran = periode_angsuran.replace(/,/g, '');
                    var angsuran_pokok = parseFloat(jumlah_pinjaman) / parseFloat(periode_angsuran);

                    //Format data
                    var angsuran_pokok_format = parseInt(angsuran_pokok, 10).toLocaleString('en-US');
                    //Tempelkan
                    $('#angsuran_pokok').val(angsuran_pokok_format);
                    $('#angsuran_total').val(angsuran_pokok_format);
                }
            });
        </script>
<?php
            }
        }
    }
?>
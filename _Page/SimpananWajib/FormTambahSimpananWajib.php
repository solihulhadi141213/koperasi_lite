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
        //Hitung Jumlah Anggota Yang Aktif
        $JumlahAnggotaAktif=mysqli_num_rows(mysqli_query($Conn, "SELECT id_anggota FROM anggota WHERE status='Aktif'"));
?>
    <script>
        function formatRupiah(angka) {
            var numberString = angka.toString();
            var sisa = numberString.length % 3;
            var rupiah = numberString.substr(0, sisa);
            var ribuan = numberString.substr(sisa).match(/\d{3}/g);
            
            if (ribuan) {
                var separator = sisa ? '.' : '';
                rupiah += separator + ribuan.join('.');
            }
            return 'Rp' + rupiah;
        }
        $(document).ready(function(){
            function updateDateRange() {
                var year = $('#tahun_simpanan').val();
                var month = $('#bulan_simpanan').val();
                if (year && month) {
                    var lastDay = new Date(year, month, 0).getDate();
                    var minDate = year + '-' + month + '-01';
                    var maxDate = year + '-' + month + '-' + lastDay;
                    $('#tanggal_simpanan').attr('min', minDate);
                    $('#tanggal_simpanan').attr('max', maxDate);
                    $('#tanggal_simpanan').val(minDate); // Set default date to the first day of the selected month
                } else {
                    $('#tanggal_simpanan').removeAttr('min');
                    $('#tanggal_simpanan').removeAttr('max');
                    $('#tanggal_simpanan').val(''); // Clear the date if no year or month is selected
                }
            }

            $('#bulan_simpanan').on('change', updateDateRange);
            $('#tahun_simpanan').on('keyup', updateDateRange);

            // Initialize with current values
            updateDateRange();
        });
        $('#nominal_simpanan').on('keypress', function(e) {
            // Hanya mengizinkan angka (0-9)
            if (e.which < 48 || e.which > 57) {
                e.preventDefault();
            }
        });
        $('#id_simpanan_jenis2').on('change', function() {
            var NominalSimpanan = $(this).find(':selected').data('id');
            $('#nominal_simpanan').val(NominalSimpanan);
            var JumlahAnggotaAktif =$('#JumlahAnggotaAktif').val();
            //Hitung
            var JumlahEstimasi=NominalSimpanan*JumlahAnggotaAktif;
            var formattedEstimasi = formatRupiah(JumlahEstimasi);
            $('#FormEstimasiSimpanan').html(formattedEstimasi);
        });
    </script>
    <input type="hidden" id="JumlahAnggotaAktif" value="<?php echo $JumlahAnggotaAktif; ?>">
    <div class="row mb-3">
        <div class="col-md-12">
            <?php
                echo '<div class="alert alert-danger alert-dismissible fade show" role="alert">';
                echo '  <code class="text-dark">';
                echo '      Berikut ini adalah form untuk menambahkan data simpanan wajib semua anggota secara simultan.';
                echo '      Form ini hanya berlaku untuk anggota yang masih Aktif';
                echo '      Pastikan juga bahwa anda telah mengisi parameter simpanan wajib dengan benar.';
                echo '  </code>';
                echo '  <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>';
                echo '</div>';
            ?>
        </div>
    </div>
    <div class="row mb-3">
        <div class="col-md-4">Anggota Aktif</div>
        <div class="col-md-8">
            <code class="text text-grayish"><?php echo "$JumlahAnggotaAktif Orang"; ?></code>
        </div>
    </div>
    <div class="row mb-3">
        <div class="col-md-4">
            <label for="tahun_simpanan">Periode Tahun</label>
        </div>
        <div class="col-md-8">
            <input type="number" id="tahun_simpanan" name="tahun" class="form-control" value="<?php echo date('Y'); ?>">
        </div>
    </div>
    <div class="row mb-3">
        <div class="col-md-4">
            <label for="bulan_simpanan">Periode Bulan</label>
        </div>
        <div class="col-md-8">
            <select name="bulan" id="bulan_simpanan" class="form-control">
                <option value="">Pilih</option>
                <?php
                    $months = [
                        "01" => "Januari",
                        "02" => "Februari",
                        "03" => "Maret",
                        "04" => "April",
                        "05" => "Mei",
                        "06" => "Juni",
                        "07" => "Juli",
                        "08" => "Agustus",
                        "09" => "September",
                        "10" => "Oktober",
                        "11" => "November",
                        "12" => "Desember"
                    ];
                    foreach ($months as $number => $name) {
                        echo '<option value="'.$number.'">'.$name.'</option>';
                    }
                ?>
            </select>
        </div>
    </div>
    <div class="row mb-3">
        <div class="col-md-4">
            <label for="tanggal_simpanan">Tanggal Pembayaran</label>
        </div>
        <div class="col-md-8">
            <input type="date" id="tanggal_simpanan" name="tanggal" class="form-control">
        </div>
    </div>
    <div class="row mb-3">
        <div class="col-md-4">
            <label for="id_simpanan_jenis2">Jenis Simpanan</label>
        </div>
        <div class="col-md-8">
            <select name="id_simpanan_jenis" id="id_simpanan_jenis2" class="form-control">
                <option value="">Pilih</option>
                <?php
                    //Menampilkan Simpanan Wajib
                    $query = mysqli_query($Conn, "SELECT*FROM simpanan_jenis WHERE rutin=1 ORDER BY nama_simpanan ASC");
                    while ($data = mysqli_fetch_array($query)) {
                        $id_simpanan_jenis= $data['id_simpanan_jenis'];
                        $nama_simpanan= $data['nama_simpanan'];
                        $rutin= $data['rutin'];
                        $nominal= $data['nominal'];
                        echo '<option value="'.$id_simpanan_jenis.'" data-id="'.$nominal.'">'.$nama_simpanan.'</option>';
                    }
                ?>
            </select>
        </div>
    </div>
    <div class="row mb-3">
        <div class="col-md-4">
            <label for="nominal_simpanan">Nominal (RP)</label>
        </div>
        <div class="col-md-8">
            <input type="text" id="nominal_simpanan" name="nominal" class="form-control">
        </div>
    </div>
    <div class="row mb-3">
        <div class="col-md-4">
            Jumlah Total
        </div>
        <div class="col-md-8">
            <b class="text text-grayish" id="FormEstimasiSimpanan">Rp 0</b>
        </div>
    </div>
    <div class="row mb-3">
        <div class="col-md-4"></div>
        <div class="col-md-8 text-primary">
            Pastikan parameter yang anda masukan sudah sesuai
        </div>
    </div>
<?php
    }
?>
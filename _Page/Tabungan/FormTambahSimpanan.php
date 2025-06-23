<?php
    //Koneksi
    date_default_timezone_set('Asia/Jakarta');
    include "../../_Config/Connection.php";
    include "../../_Config/GlobalFunction.php";
    include "../../_Config/SettingGeneral.php";
    include "../../_Config/Session.php";
    $now=date('Y-m-d');
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
            $nama=GetDetailData($Conn,'anggota','id_anggota',$id_anggota,'nama');
            $nip=GetDetailData($Conn,'anggota','id_anggota',$id_anggota,'nip');
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
            $('#id_simpanan_jenis').on('change', function() {
                var NominalSimpanan = $(this).find(':selected').data('id');
                $('#nominal_simpanan').val(NominalSimpanan);
                var JumlahAnggotaAktif =$('#JumlahAnggotaAktif').val();
                //Hitung
                var JumlahEstimasi=NominalSimpanan*JumlahAnggotaAktif;
                var formattedEstimasi = formatRupiah(JumlahEstimasi);
                $('#FormEstimasiSimpanan').html(formattedEstimasi);
            });
        </script>
        <div class="row mb-3">
            <div class="col-md-12">
                <?php
                    echo '<div class="alert alert-warning alert-dismissible fade show" role="alert">';
                    echo '  Berikut ini adalah form untuk menambahkan data simpanan secara parsial.';
                    echo '  Pastikan anda telah mengisi jumlah simpanan dengan benar.';
                    echo '  <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>';
                    echo '</div>';
                ?>
            </div>
        </div>
        <input type="hidden" name="id_anggota" id="put_id_anggota_for_tambah_simpanan" class="form-control" value="<?php echo $id_anggota; ?>">
        <div class="row mb-3">
            <div class="col-md-4">Nama Anggota</div>
            <div class="col-md-8">
                <code class="text text-grayish"><?php echo "$nama"; ?></code>
            </div>
        </div>
        <div class="row mb-3">
            <div class="col-md-4">No.Induk</div>
            <div class="col-md-8">
                <code class="text text-grayish"><?php echo "$nip"; ?></code>
            </div>
        </div>
        <div class="row mb-3">
            <div class="col-md-4">
                <label for="kategori_simpanan_penarikan">Kategori</label>
            </div>
            <div class="col-md-8">
                <select name="kategori_simpanan_penarikan" id="kategori_simpanan_penarikan" class="form-control">
                    <option value="Simpanan">Simpanan</option>
                    <option value="Penarikan">Penarikan</option>
                </select>
            </div>
        </div>
        <div class="row mb-3">
            <div class="col-md-4">
                <label for="tanggal_simpanan">Tanggal</label>
            </div>
            <div class="col-md-8">
                <input type="date" id="tanggal_simpanan" name="tanggal" class="form-control" value="<?php echo $now; ?>">
            </div>
        </div>
        <div class="row mb-3" id="FormJenisSimpanan">
            <!-- Form Jenis Simpanan Ditampilkan Disini -->
        </div>
        <div class="row mb-3">
            <div class="col-md-4">
                <label for="nominal_simpanan">Nominal (RP)</label>
            </div>
            <div class="col-md-8">
                <input type="text" id="nominal_simpanan" name="nominal" class="form-control form-money">
            </div>
        </div>
        <div class="row mb-3">
            <div class="col-md-4">
                <label for="keterangan">Keterangan</label>
            </div>
            <div class="col-md-8">
                <textarea name="keterangan" id="keterangan" class="form-control"></textarea>
                <small class="credit">
                    <code class="text text-grayish">
                        Informasi lain terkait simpanan anggtoa jika dibutuhkan
                    </code>
                </small>
            </div>
        </div>
<?php
        }
    }
?>
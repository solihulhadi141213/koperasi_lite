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
        if(empty($_POST['GetData'])){
            echo '<div class="row">';
            echo '  <div class="col-md-12 mb-3 text-center">';
            echo '      <small class="text-danger">Tidak ada data yang ditangkap oleh sistem</small>';
            echo '  </div>';
            echo '</div>';
        }else{
            $GetData=$_POST['GetData'];
            //Explode
            $explode=explode(',',$GetData);
            $id_anggota=$explode[0];
            $mode_periode=$explode[1];
            $PeriodeKey=$explode[2];
            $id_simpanan_jenis=$explode[3];
            //Pecahkan Periode Key
            if($mode_periode=="Bulanan"){
                $explode2=explode('-',$PeriodeKey);
                $tahun=$explode2[0];
                $bulan=$explode2[1];
            }else{
                $explode2=explode('-',$PeriodeKey);
                $tahun=$explode2[0];
                $bulan=date('m');
            }
            //Buka Detail Anggota
            $tanggal_masuk=GetDetailData($Conn,'anggota','id_anggota',$id_anggota,'tanggal_masuk');
            $tanggal_keluar=GetDetailData($Conn,'anggota','id_anggota',$id_anggota,'tanggal_keluar');
            $email=GetDetailData($Conn,'anggota','id_anggota',$id_anggota,'email');
            $nip=GetDetailData($Conn,'anggota','id_anggota',$id_anggota,'nip');
            $nama=GetDetailData($Conn,'anggota','id_anggota',$id_anggota,'nama');
            $kontak=GetDetailData($Conn,'anggota','id_anggota',$id_anggota,'kontak');
            $lembaga=GetDetailData($Conn,'anggota','id_anggota',$id_anggota,'lembaga');
            $ranking=GetDetailData($Conn,'anggota','id_anggota',$id_anggota,'ranking');
            $status=GetDetailData($Conn,'anggota','id_anggota',$id_anggota,'status');
            if($status=="Keluar"){
                $strtotime2=strtotime($tanggal_keluar);
                $TanggalKeluar=date('d/m/Y', $strtotime2);
                $LabelStatus='<span class="text-danger">Keluar</span>';
            }else{
                $TanggalKeluar="-";
                $LabelStatus='<span class="text-success">Aktif</span>';
            }
            //Format Tanggal
            $strtotime1=strtotime($tanggal_masuk);
            //Menampilkan Tanggal
            $TanggalMasuk=date('d/m/Y', $strtotime1);
            //Mencari Nominal Jenis Simpanan
            $NominalJenisSimpanan=GetDetailData($Conn,'simpanan_jenis','id_simpanan_jenis',$id_simpanan_jenis,'nominal');
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
                        var year = $('#tahun_simpanan_parsial').val();
                        var month = $('#bulan_simpanan_parsial').val();
                        if (year && month) {
                            var lastDay = new Date(year, month, 0).getDate();
                            var minDate = year + '-' + month + '-01';
                            var maxDate = year + '-' + month + '-' + lastDay;
                            $('#tanggal_simpanan_parsial').attr('min', minDate);
                            $('#tanggal_simpanan_parsial').attr('max', maxDate);
                            $('#tanggal_simpanan_parsial').val(minDate); // Set default date to the first day of the selected month
                        } else {
                            $('#tanggal_simpanan_parsial').removeAttr('min');
                            $('#tanggal_simpanan_parsial').removeAttr('max');
                            $('#tanggal_simpanan_parsial').val(''); // Clear the date if no year or month is selected
                        }
                    }

                    $('#bulan_simpanan_parsial').on('change', updateDateRange);
                    $('#tahun_simpanan_parsial').on('keyup', updateDateRange);

                    // Initialize with current values
                    updateDateRange();
                });
                $('#nominal_simpanan_parsial').on('keypress', function(e) {
                    // Hanya mengizinkan angka (0-9)
                    if (e.which < 48 || e.which > 57) {
                        e.preventDefault();
                    }
                });
                $('#id_simpanan_jenis_parsial').on('change', function() {
                    var NominalSimpanan = $(this).find(':selected').data('id');
                    $('#nominal_simpanan_parsial').val(NominalSimpanan);
                });
            </script>
            <input type="hidden" name="id_anggota" value="<?php echo $id_anggota; ?>">
            <div class="row mb-3">
                <div class="col col-md-4">Nomor Induk</div>
                <div class="col col-md-8">
                    <code class="text text-grayish"><?php echo $nip; ?></code>
                </div>
            </div>
            <div class="row mb-3">
                <div class="col col-md-4">Nama Lengkap</div>
                <div class="col col-md-8">
                    <code class="text text-grayish"><?php echo $nama; ?></code>
                </div>
            </div>
            <div class="row mb-3">
                <div class="col col-md-4">Divisi/Unit</div>
                <div class="col col-md-8">
                    <code class="text text-grayish"><?php echo $lembaga; ?></code>
                </div>
            </div>
            <div class="row mb-3">
                <div class="col col-md-4">Ranking</div>
                <div class="col col-md-8">
                    <code class="text text-grayish"><?php echo $ranking; ?></code>
                </div>
            </div>
            <div class="row mb-3">
                <div class="col col-md-4">Status</div>
                <div class="col col-md-8">
                    <code class="text text-grayish"><?php echo $LabelStatus; ?></code>
                </div>
            </div>
            <div class="row mb-3">
                <div class="col-md-4">
                    <label for="tahun_simpanan_parsial">Periode Tahun</label>
                </div>
                <div class="col-md-8">
                    <input type="number" id="tahun_simpanan_parsial" name="tahun" class="form-control" value="<?php echo $tahun; ?>">
                </div>
            </div>
            <div class="row mb-3">
                <div class="col-md-4">
                    <label for="bulan_simpanan_parsial">Periode Bulan</label>
                </div>
                <div class="col-md-8">
                    <select name="bulan" id="bulan_simpanan_parsial" class="form-control">
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
                                if($number==$bulan){
                                    echo '<option selected value="'.$number.'">'.$name.'</option>';
                                }else{
                                    echo '<option value="'.$number.'">'.$name.'</option>';
                                }
                            }
                        ?>
                    </select>
                </div>
            </div>
            <div class="row mb-3">
                <div class="col-md-4">
                    <label for="tanggal_simpanan_parsial">Tanggal Pembayaran</label>
                </div>
                <div class="col-md-8">
                    <input type="date" id="tanggal_simpanan_parsial" name="tanggal" class="form-control">
                </div>
            </div>
            <div class="row mb-3">
                <div class="col-md-4">
                    <label for="id_simpanan_jenis_parsial">Jenis Simpanan</label>
                </div>
                <div class="col-md-8">
                    <select name="id_simpanan_jenis" id="id_simpanan_jenis_parsial" class="form-control">
                        <option value="">Pilih</option>
                        <?php
                            //Menampilkan Simpanan Wajib
                            $query = mysqli_query($Conn, "SELECT*FROM simpanan_jenis WHERE rutin=1 ORDER BY nama_simpanan ASC");
                            while ($data = mysqli_fetch_array($query)) {
                                $id_simpanan_jenis_list= $data['id_simpanan_jenis'];
                                $nama_simpanan= $data['nama_simpanan'];
                                $rutin= $data['rutin'];
                                $nominal= $data['nominal'];
                                if($id_simpanan_jenis_list==$id_simpanan_jenis){
                                    echo '<option selected value="'.$id_simpanan_jenis_list.'" data-id="'.$nominal.'">'.$nama_simpanan.'</option>';
                                }else{
                                    echo '<option value="'.$id_simpanan_jenis_list.'" data-id="'.$nominal.'">'.$nama_simpanan.'</option>';
                                }
                            }
                        ?>
                    </select>
                </div>
            </div>
            <div class="row mb-3">
                <div class="col-md-4">
                    <label for="nominal_simpanan_parsial">Nominal (RP)</label>
                </div>
                <div class="col-md-8">
                    <input type="text" id="nominal_simpanan_parsial" name="nominal" class="form-control" value="<?php echo $NominalJenisSimpanan; ?>">
                </div>
            </div>
<?php
        }
    }
?>
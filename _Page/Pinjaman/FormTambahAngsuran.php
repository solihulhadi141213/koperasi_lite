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
            //Explode Data
            $explode=explode(',',$GetData);
            $id_pinjaman=$explode['0'];
            $tanggal_angsuran=$explode['1'];
            //Bersihkan Variabel
            $id_pinjaman=validateAndSanitizeInput($id_pinjaman);
            $tanggal_angsuran=validateAndSanitizeInput($tanggal_angsuran);
            //Buka Data Pinjaman
            $id_anggota=GetDetailData($Conn,'pinjaman','id_pinjaman',$id_pinjaman,'id_anggota');
            if(empty($id_anggota)){
                echo '<div class="row">';
                echo '  <div class="col-md-12 mb-3 text-center">';
                echo '      <small class="text-danger">Data Pinjaman Tidak Valid atau Data Tidak Ditemukan Pada Database</small>';
                echo '  </div>';
                echo '</div>';
            }else{
                $rp_jasa=GetDetailData($Conn,'pinjaman','id_pinjaman',$id_pinjaman,'rp_jasa');
                $angsuran_pokok=GetDetailData($Conn,'pinjaman','id_pinjaman',$id_pinjaman,'angsuran_pokok');
                $angsuran_total=GetDetailData($Conn,'pinjaman','id_pinjaman',$id_pinjaman,'angsuran_total');
                $denda=GetDetailData($Conn,'pinjaman','id_pinjaman',$id_pinjaman,'denda');
                if(empty($angsuran_pokok)){
                    $angsuran_pokok=0;
                }
                if(empty($angsuran_total)){
                    $angsuran_total=0;
                }
                if(empty($rp_jasa)){
                    $rp_jasa=0;
                }
                if(empty($denda)){
                    $denda=0;
                }
                $sistem_denda=GetDetailData($Conn,'pinjaman','id_pinjaman',$id_pinjaman,'sistem_denda');
                $tanggal_bayar=date('Y-m-d');
                $JumlahDenda=0;
                if($tanggal_bayar<=$tanggal_angsuran){
                    $JumlahDenda=0;
                    $keterlambatan=0;
                }else{
                    $keterlambatan=0;
                    try {
                        // Create DateTime objects
                        $date1 = new DateTime($tanggal_angsuran);
                        $date2 = new DateTime($tanggal_bayar);
                        // Calculate the difference
                        $interval = $date1->diff($date2);
                        // Get the difference in days and months
                        if($sistem_denda=="Harian"){
                            $keterlambatan = $interval->days;
                        }else{
                            $keterlambatan = $interval->m;
                            if ($tanggal_bayar > $tanggal_angsuran) {
                                // Set selisih_bulan to 1 if the payment is made after the due date
                                $keterlambatan = $keterlambatan+1;
                            }
                        }
                    } catch (Exception $e) {
                        $keterlambatan=0;
                    }
                    //Menghitung Jumlah Denda
                    $JumlahDenda=$denda*$keterlambatan;
                }
                
                //Format Rupiah
                $angsuran_pokok_format = "" . number_format($angsuran_pokok,0,',',',');
                $rp_jasa_format = "" . number_format($rp_jasa,0,',',',');
                $denda_format = "" . number_format($denda,0,',',',');
                $JumlahDendaFormat = "" . number_format($JumlahDenda,0,',',',');
                $angsuran_total=$angsuran_total+$JumlahDenda;
                $angsuran_total_format = "" . number_format($angsuran_total,0,',',',');

?>
    <input type="hidden" name="id_anggota" value="<?php echo "$id_anggota"; ?>">
    <input type="hidden" name="id_pinjaman" id="GetIdPinjamanAngsuran" value="<?php echo "$id_pinjaman"; ?>">
    <div class="row mb-3">
        <div class="col-md-4">
            <label for="tanggal_angsuran">Tangal Angsuran</label>
        </div>
        <div class="col-md-8">
            <input type="date" readonly name="tanggal_angsuran" id="tanggal_angsuran" class="form-control" value="<?php echo $tanggal_angsuran; ?>">
        </div>
    </div>
    <div class="row mb-3">
        <div class="col-md-4">
            <label for="tanggal_bayar">Tangal Bayar</label>
        </div>
        <div class="col-md-8">
            <input type="date" name="tanggal_bayar" id="tanggal_bayar" class="form-control" value="<?php echo $tanggal_bayar; ?>">
        </div>
    </div>
    <div class="row mb-3">
        <div class="col-md-4">
            <label for="pokok">Pokok</label>
        </div>
        <div class="col-md-8">
            <input type="text" readonly name="pokok" id="pokok" class="form-control" value="<?php echo $angsuran_pokok_format; ?>">
        </div>
    </div>
    <div class="row mb-3">
        <div class="col-md-4">
            <label for="jasa">Jasa</label>
        </div>
        <div class="col-md-8">
            <input type="text" readonly name="jasa" id="jasa" class="form-control" value="<?php echo $rp_jasa_format; ?>">
        </div>
    </div>
    <div class="row mb-3">
        <div class="col-md-4">
            <label for="keterlambatan">Keterlambatan</label>
        </div>
        <div class="col-md-8">
            <input type="text" readonly name="keterlambatan" id="keterlambatan" class="form-control" value="<?php echo $keterlambatan; ?>">
            <small class="credit">
                <code class="text text-grayish">
                    <?php
                        if($sistem_denda=="Harian"){
                            echo "Satuan Hari";
                        }else{
                            echo "Satuan Bulan";
                        }
                    ?>
                </code>
            </small>
        </div>
    </div>
    <div class="row mb-3">
        <div class="col-md-4">
            <label for="rp_denda">Rp Denda</label>
        </div>
        <div class="col-md-8">
            <input type="text" readonly name="rp_denda" id="rp_denda" class="form-control" value="<?php echo $denda_format; ?>">
            <small class="credit">
                <code class="text text-grayish">
                    <?php
                        if($sistem_denda=="Harian"){
                            echo "Nilai denda per hari";
                        }else{
                            echo "Nilai denda per bulan";
                        }
                    ?>
                </code>
            </small>
        </div>
    </div>
    <div class="row mb-3">
        <div class="col-md-4">
            <label for="denda">Jumlah Denda</label>
        </div>
        <div class="col-md-8">
            <input type="text" readonly name="denda" id="denda" class="form-control" value="<?php echo $JumlahDendaFormat; ?>">
            <small class="credit">
                <code class="text text-grayish">
                    <?php
                        echo 'Jumlah Denda = Keteralmbatan x Rp Denda';
                    ?>
                </code>
            </small>
        </div>
    </div>
    <div class="row mb-3">
        <div class="col-md-4">
            <label for="jumlah">Angsuran</label>
        </div>
        <div class="col-md-8">
            <input type="text" readonly name="jumlah" id="jumlah" class="form-control" value="<?php echo $angsuran_total_format; ?>">
            <small class="credit">
                <code class="text text-grayish">
                    Jumlah Angsuran = Pokok + Jasa + Jumlah Denda
                </code>
            </small>
        </div>
    </div>
    <script>
        $('#tanggal_bayar').on('change', function() {
            var id_pinjaman = $('#GetIdPinjamanAngsuran').val();
            var tanggal_angsuran = $('#tanggal_angsuran').val();
            var tanggal_bayar = $('#tanggal_bayar').val();
            var pokok = $('#pokok').val();
            var jasa = $('#jasa').val();
            var rp_denda = $('#rp_denda').val();
            //Hitung Keterlambatan Sesuai Sistem Denda
            $.ajax({
                type 	    : 'POST',
                url 	    : '_Page/Pinjaman/ProsesHitungKeterlambatan.php',
                data        : {id_pinjaman: id_pinjaman, tanggal_angsuran: tanggal_angsuran, tanggal_bayar: tanggal_bayar},
                success     : function(data){
                    $('#keterlambatan').val(data);
                    var dendaNoComma = rp_denda.replace(/,/g, '');
                    var denda=dendaNoComma*data;
                    var dendaFormatted = parseFloat(denda).toLocaleString('en-US');
                    $('#denda').val(dendaFormatted);
                    //Menghitung Jumlah Angsuran
                    var pokokNoComma = pokok.replace(/,/g, '');
                    var jasaNoComma = jasa.replace(/,/g, '');
                    var jumlah_angsuran = parseFloat(pokokNoComma) + parseFloat(jasaNoComma) + parseFloat(denda);
                    // Format the total with commas
                    var jumlah_angsuranFormatted = jumlah_angsuran.toLocaleString('en-US');
                    // Set the formatted value to the input field
                    $('#jumlah').val(jumlah_angsuranFormatted);
                }
            });
        });
    </script>
<?php 
            }
        }
    } 
?>
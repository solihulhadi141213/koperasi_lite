<?php
    //Koneksi
    date_default_timezone_set('Asia/Jakarta');
    include "../../_Config/Connection.php";
    include "../../_Config/GlobalFunction.php";
    include "../../_Config/SettingGeneral.php";
    if(!empty($_POST['kategori_simpanan_penarikan'])){
        if(!empty($_POST['id_anggota'])){
            $kategori_simpanan_penarikan=$_POST['kategori_simpanan_penarikan'];
            $id_anggota=$_POST['id_anggota'];
            if($kategori_simpanan_penarikan=="Penarikan"){
                echo '
                    <div class="col-md-4">
                        <label for="id_simpanan_jenis">Sumber Dana</label>
                    </div>
                ';
                echo '<div class="col-md-8">';
                echo '  <select name="id_simpanan_jenis" id="id_simpanan_jenis" class="form-control">';
                echo '      <option value="">Pilih</option>';
                echo '      <optgroup label="Penarikan Dari Simpanan Wajib/Rutin">';
                //Menampilkan Simpanan Wajib
                $jumlah_simpanan_wajib=0;
                $query = mysqli_query($Conn, "SELECT*FROM simpanan_jenis WHERE rutin='1' ORDER BY nama_simpanan ASC");
                while ($data = mysqli_fetch_array($query)) {
                    $id_simpanan_jenis= $data['id_simpanan_jenis'];
                    $nama_simpanan= $data['nama_simpanan'];
                    $rutin= $data['rutin'];
                    $nominal= $data['nominal'];
                    
                    //Menghitung jumlah simpanan
                    $SumSimpananKotor = mysqli_fetch_array(mysqli_query($Conn, "SELECT SUM(jumlah) AS jumlah FROM simpanan WHERE id_simpanan_jenis='$id_simpanan_jenis' AND id_anggota='$id_anggota' AND kategori!='Penarikan'"));
                    $JumlahSimpananKotor = $SumSimpananKotor['jumlah'];
                    //Hitung Jumlah Penarikan
                    $SumPenarikan = mysqli_fetch_array(mysqli_query($Conn, "SELECT SUM(jumlah) AS jumlah FROM simpanan WHERE id_simpanan_jenis='$id_simpanan_jenis' AND id_anggota='$id_anggota' AND kategori='Penarikan'"));
                    $JumlahPenarikan = $SumPenarikan['jumlah'];
                    //Hitung Jumlah Simpanan Bersih
                    $simpanan_bersih=$JumlahSimpananKotor-$JumlahPenarikan;
                    $jumlah_simpanan_wajib=$jumlah_simpanan_wajib+$simpanan_bersih;
                    $simpanan_bersih_format = "Rp " . number_format($simpanan_bersih,0,',','.');
                    $simpanan_bersih_format2 = "" . number_format($simpanan_bersih,0,',','.');
                    
                    echo '<option value="'.$id_simpanan_jenis.'" data-id="'.$simpanan_bersih_format2.'">'.$nama_simpanan.' ('.$simpanan_bersih_format.')</option>';
                }
                echo '      </optgroup>';
                echo '      <optgroup label="Penarikan Dari Simpanan Sukarela">';
                //Menampilkan Simpanan tidak Wajib
                $jumlah_simpanan_tidak_wajib=0;
                $query = mysqli_query($Conn, "SELECT*FROM simpanan_jenis WHERE rutin='0' ORDER BY nama_simpanan ASC");
                while ($data = mysqli_fetch_array($query)) {
                    $id_simpanan_jenis= $data['id_simpanan_jenis'];
                    $nama_simpanan= $data['nama_simpanan'];
                    $rutin= $data['rutin'];
                    $nominal= $data['nominal'];
                    //Menghitung jumlah simpanan
                    $SumSimpananKotor = mysqli_fetch_array(mysqli_query($Conn, "SELECT SUM(jumlah) AS jumlah FROM simpanan WHERE id_simpanan_jenis='$id_simpanan_jenis' AND id_anggota='$id_anggota' AND kategori!='Penarikan'"));
                    $JumlahSimpananKotor = $SumSimpananKotor['jumlah'];
                    //Hitung Jumlah Penarikan
                    $SumPenarikan = mysqli_fetch_array(mysqli_query($Conn, "SELECT SUM(jumlah) AS jumlah FROM simpanan WHERE id_simpanan_jenis='$id_simpanan_jenis' AND id_anggota='$id_anggota' AND kategori='Penarikan'"));
                    $JumlahPenarikan = $SumPenarikan['jumlah'];
                    //Hitung Jumlah Simpanan Bersih
                    $simpanan_bersih=$JumlahSimpananKotor-$JumlahPenarikan;
                    $jumlah_simpanan_tidak_wajib=$jumlah_simpanan_tidak_wajib+$simpanan_bersih;
                    $simpanan_bersih_format = "Rp " . number_format($simpanan_bersih,0,',','.');

                    echo '<option value="'.$id_simpanan_jenis.'" data-id="'.$simpanan_bersih.'">'.$nama_simpanan.' ('.$simpanan_bersih_format.')</option>';
                }
                $jumlah_total_simpanan =$jumlah_simpanan_tidak_wajib+$jumlah_simpanan_wajib;
                $jumlah_total_simpanan = "" . number_format($jumlah_total_simpanan,0,',','.');
                echo '      </optgroup>';
                echo '      <option value="Semua" data-id="'.$jumlah_total_simpanan.'">Semua Simpanan ('.$jumlah_total_simpanan.')</option>';
                echo '  </select>';
                echo '</div>';
            }else{
                echo '
                    <div class="col-md-4">
                        <label for="id_simpanan_jenis">Jenis Simpanan</label>
                    </div>
                ';
                echo '<div class="col-md-8">';
                echo '  <select name="id_simpanan_jenis" id="id_simpanan_jenis" class="form-control">';
                echo '      <option value="">Pilih</option>';
                echo '      <optgroup label="Simpanan Wajib/Rutin">';
                //Menampilkan Simpanan Wajib
                $query = mysqli_query($Conn, "SELECT*FROM simpanan_jenis WHERE rutin='1' ORDER BY nama_simpanan ASC");
                while ($data = mysqli_fetch_array($query)) {
                    $id_simpanan_jenis= $data['id_simpanan_jenis'];
                    $nama_simpanan= $data['nama_simpanan'];
                    $rutin= $data['rutin'];
                    $nominal= $data['nominal'];
                    $nominal_format = "" . number_format($nominal,0,',','.');
                    echo '<option value="'.$id_simpanan_jenis.'" data-id="'.$nominal_format.'">'.$nama_simpanan.' ('.$nominal_format.')</option>';
                }
                echo '      </optgroup>';
                echo '      <optgroup label="Simpanan Sukarela">';
                //Menampilkan Simpanan Wajib
                $query = mysqli_query($Conn, "SELECT*FROM simpanan_jenis WHERE rutin='0' ORDER BY nama_simpanan ASC");
                while ($data = mysqli_fetch_array($query)) {
                    $id_simpanan_jenis= $data['id_simpanan_jenis'];
                    $nama_simpanan= $data['nama_simpanan'];
                    $rutin= $data['rutin'];
                    $nominal= $data['nominal'];
                    $nominal_format = "" . number_format($nominal,0,',','.');
                    echo '<option value="'.$id_simpanan_jenis.'" data-id="'.$nominal_format.'">'.$nama_simpanan.' ('.$nominal_format.')</option>';
                }
                echo '      </optgroup>';
                echo '  </select>';
                echo '</div>';
            }
?>
<script>
    //Ketika id_simpanan_jenis change
    $('#id_simpanan_jenis').change(function(){
        var nominal =  $('#id_simpanan_jenis option:selected').data('id');
        var id_simpanan_jenis =  $('#id_simpanan_jenis').val();
        //Terapkan pada nominal
        if (id_simpanan_jenis == "Semua") {
            $('#nominal_simpanan').val(nominal).attr('readonly', 'readonly');
        } else {
            $('#nominal_simpanan').val(nominal).removeAttr('readonly');
        }
        
    });
</script>

<?php
        }
    }
?>
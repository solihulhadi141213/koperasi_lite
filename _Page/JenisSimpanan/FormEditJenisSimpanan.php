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
        //Tangkap id_simpanan_jenis
        if(empty($_POST['id_simpanan_jenis'])){
            echo '<div class="row">';
            echo '  <div class="col-md-12 mb-3 text-center">';
            echo '      <small class="text-danger">ID Jenis Simpanan Tidak Boleh Kosong!</small>';
            echo '  </div>';
            echo '</div>';
        }else{
            $id_simpanan_jenis=$_POST['id_simpanan_jenis'];
            $id_simpanan_jenis=validateAndSanitizeInput($id_simpanan_jenis);
            //Buka Informasi
            $nama_simpanan=GetDetailData($Conn,'simpanan_jenis','id_simpanan_jenis',$id_simpanan_jenis,'nama_simpanan');
            $keterangan=GetDetailData($Conn,'simpanan_jenis','id_simpanan_jenis',$id_simpanan_jenis,'keterangan');
            $kategori=GetDetailData($Conn,'simpanan_jenis','id_simpanan_jenis',$id_simpanan_jenis,'kategori');
            $nominal=GetDetailData($Conn,'simpanan_jenis','id_simpanan_jenis',$id_simpanan_jenis,'nominal');
?>
    <input type="hidden" name="id_simpanan_jenis" value="<?php echo $id_simpanan_jenis; ?>">
    <div class="row mb-3">
        <div class="col col-md-4">
            <label for="nama_simpanan_edit">Nama Jenis Simpanan</label>
        </div>
        <div class="col-md-8">
            <input type="text" name="nama_simpanan" id="nama_simpanan_edit" class="form-control" value="<?php echo $nama_simpanan; ?>">
        </div>
    </div>
    <div class="row mb-3">
        <div class="col col-md-4">
            <label for="keterangan_edit">Deskripsi</label>
        </div>
        <div class="col-md-8">
            <textarea name="keterangan" id="keterangan_edit" class="form-control"><?php echo $keterangan; ?></textarea>
        </div>
    </div>
    <div class="row mb-3">
        <div class="col col-md-4">
            <label for="kategori_edit">Kategori Simpanan</label>
        </div>
        <div class="col-md-8">
            <select name="kategori" id="kategori_edit" class="form-control">
                <option <?php if($kategori==""){echo "selected";} ?> value="">Pilih</option>
                <option <?php if($kategori=="Simpanan Wajib"){echo "selected";} ?> value="Simpanan Wajib">Simpanan Wajib</option>
                <option <?php if($kategori=="Simpanan Pokok"){echo "selected";} ?> value="Simpanan Pokok">Simpanan Pokok</option>
                <option <?php if($kategori=="Simpanan Sukarela"){echo "selected";} ?> value="Simpanan Sukarela">Simpanan Sukarela</option>
            </select>
        </div>
    </div>
    <div class="row mb-3">
        <div class="col col-md-4">
            <label for="nominal_edit">Nominal</label>
        </div>
        <div class="col-md-8">
            <input type="text" name="nominal" id="nominal_edit" class="form-control form-money" value="<?php echo $nominal; ?>">
            <small class="text-muted">
                Apabila nominal simpanan bersifat relatif (Tidak ditentukan besarnya) maka anda bisa mengosongkan nilai nominal ini
            </small>
        </div>
    </div>
    <div class="row mb-3">
        <div class="col col-md-4"></div>
        <div class="col-md-8">
            <code class="text-primary">Pastikan jenis simpanan yang anda input sudah benar</code>
        </div>
    </div>
    <script>
        $(document).ready(function() {
            var rutin = $('#rutin_edit').val();
            if(rutin==1){
                $('#form_nominal_edit').show();
            }else{
                $('#form_nominal_edit').hide();
            }
        });
        //Ketika form rutin di ubah
        $('#rutin_edit').change(function(){
            var rutin = $('#rutin_edit').val();
            if(rutin==1){
                $('#form_nominal_edit').show();
            }else{
                $('#form_nominal_edit').hide();
            }
        });
        $('#nominal_edit').on('keypress', function(e) {
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
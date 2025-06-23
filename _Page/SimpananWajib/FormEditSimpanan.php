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
            $explode=explode('/',$GetData);
            $AtributData=$explode[0];
            $id_simpanan=$explode[1];
            $id_simpanan_jenis=GetDetailData($Conn,'simpanan','id_simpanan',$id_simpanan,'id_simpanan_jenis');
            $tanggal=GetDetailData($Conn,'simpanan','id_simpanan',$id_simpanan,'tanggal');
            $kategori=GetDetailData($Conn,'simpanan','id_simpanan',$id_simpanan,'kategori');
            $keterangan=GetDetailData($Conn,'simpanan','id_simpanan',$id_simpanan,'keterangan');
            $jumlah=GetDetailData($Conn,'simpanan','id_simpanan',$id_simpanan,'jumlah');
?>
            <input type="hidden" name="id_simpanan" value="<?php echo $id_simpanan; ?>">
            <div class="row mb-3">
                <div class="col col-md-4">ID Jenis Simpanan</div>
                <div class="col col-md-8">
                    <code class="text text-grayish"><?php echo $id_simpanan_jenis; ?></code>
                </div>
            </div>
            <div class="row mb-3">
                <div class="col col-md-4">Jenis Simpanan</div>
                <div class="col col-md-8">
                    <code class="text text-grayish"><?php echo $kategori; ?></code>
                </div>
            </div>
            <div class="row mb-3">
                <div class="col col-md-4">
                    <label for="tanggal_simpanan_edit">Tanggal</label>
                </div>
                <div class="col col-md-8">
                    <input type="date" name="tanggal" id="tanggal_simpanan_edit" class="form-control" value="<?php echo $tanggal; ?>">
                </div>
            </div>
            <div class="row mb-3 border-1 border-bottom">
                <div class="col col-md-4 mb-3">
                    <label for="jumlah_edit">Nominal</label>
                </div>
                <div class="col col-md-8 mb-3">
                    <input type="text" name="jumlah" id="jumlah_edit" class="form-control" value="<?php echo $jumlah; ?>">
                </div>
            </div>
            <div class="row mb-3">
                <div class="col-md-12 text-center">
                    <code class="text-primary">Pastikan data simpanan yang anda ubah sudah sesuai</code>
                </div>
            </div>
            <div class="row mb-3">
                <div class="col col-md-4 mb-3">
                    <button type="submit" class="btn btn-md btn-success btn-rounded btn-block">
                        <i class="bi bi-save"></i> Simpan
                    </button>
                </div>
                <div class="col col-md-4 mb-3">
                    <button type="button" class="btn btn-md btn-outline-dark btn-block btn-rounded" data-bs-toggle="modal" data-bs-target="#ModalDetailSimpananWajib" data-id="<?php echo $AtributData; ?>">
                        <i class="bi bi-chevron-left"></i> Kembali
                    </button>
                </div>
                <div class="col col-md-4 mb-3">
                    <button type="button" class="btn btn-dark btn-rounded btn-block" data-bs-dismiss="modal">
                        <i class="bi bi-x-circle"></i> Tutup
                    </button>
                </div>
            </div>
            <script>
                $('#jumlah_edit').on('keypress', function(e) {
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
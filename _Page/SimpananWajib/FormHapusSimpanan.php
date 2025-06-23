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
            $JumlahFormat = "" . number_format($jumlah,0,',','.');
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
                    <code class="text text-grayish"><?php echo $tanggal; ?></code>
                </div>
            </div>
            <div class="row mb-3 border-1 border-bottom">
                <div class="col col-md-4 mb-3">
                    <label for="jumlah_edit">Nominal</label>
                </div>
                <div class="col col-md-8 mb-3">
                    <code class="text text-grayish"><?php echo $JumlahFormat; ?></code>
                </div>
            </div>
            <div class="row mb-3">
                <div class="col-md-12 text-center">
                    <code class="text-primary">Apakah anda yakin akan menghapus data simpanan ini?</code>
                </div>
            </div>
            <div class="row mb-3">
                <div class="col col-md-12 text-center mb-3">
                    <button type="submit" class="btn btn-md btn-success btn-rounded">
                        <i class="bi bi-check"></i> Ya, Hapus
                    </button>
                    <button type="button" class="btn btn-dark btn-rounded" data-bs-dismiss="modal">
                        <i class="bi bi-x-circle"></i> Tutup
                    </button>
                </div>
            </div>
<?php
        }
    }
?>
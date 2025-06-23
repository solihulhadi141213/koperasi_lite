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
        //Tangkap id_transaksi
        if(empty($_POST['id_transaksi'])){
            echo '<div class="row">';
            echo '  <div class="col-md-12 mb-3 text-center">';
            echo '      <small class="text-danger">ID Transaksi Tidak Boleh Kosong!</small>';
            echo '  </div>';
            echo '</div>';
        }else{
            $id_transaksi=$_POST['id_transaksi'];
            //Bersihkan Variabel
            $id_transaksi=validateAndSanitizeInput($id_transaksi);
            //Buka Informasi
            $uuid_transaksi=GetDetailData($Conn,'transaksi','id_transaksi',$id_transaksi,'uuid_transaksi');
            $id_transaksi_jenis=GetDetailData($Conn,'transaksi','id_transaksi',$id_transaksi,'id_transaksi_jenis');
            $nama_transaksi=GetDetailData($Conn,'transaksi','id_transaksi',$id_transaksi,'nama_transaksi');
            $kategori=GetDetailData($Conn,'transaksi','id_transaksi',$id_transaksi,'kategori');
            $tanggal=GetDetailData($Conn,'transaksi','id_transaksi',$id_transaksi,'tanggal');
            $jumlah=GetDetailData($Conn,'transaksi','id_transaksi',$id_transaksi,'jumlah');
            $pembayaran=GetDetailData($Conn,'transaksi','id_transaksi',$id_transaksi,'pembayaran');
            $status=GetDetailData($Conn,'transaksi','id_transaksi',$id_transaksi,'status');
            if(empty($pembayaran)){
                $pembayaran=0;
            }
            //Menghitung Jumlah Rincian
            $JumlahRincian = mysqli_num_rows(mysqli_query($Conn, "SELECT*FROM transaksi_rincian WHERE id_transaksi='$id_transaksi'"));
            //Jumlah Jurnal
            $JumlahJurnal = mysqli_num_rows(mysqli_query($Conn, "SELECT*FROM jurnal WHERE uuid='$uuid_transaksi'"));
            //Format Angka
            $JumlahFormat = "" . number_format($jumlah,0,',','.');
            $PembayaranFormat = "Rp " . number_format($pembayaran,0,',','.');
            //Format Tanggal
            $strtotime=strtotime($tanggal);
            $TanggalFormat=date('d/m/Y H:i:s T', $strtotime);
?>
    <input type="hidden" name="id_transaksi" value="<?php echo $id_transaksi; ?>">
    <div class="col-md-12 mb-4">
        <div class="row mb-3">
            <div class="col col-md-4">UUID Transaksi</div>
            <div class="col col-md-8">
                <code class="text text-grayish"><?php echo $uuid_transaksi; ?></code>
            </div>
        </div>
        <div class="row mb-3">
            <div class="col col-md-4">Tanggal</div>
            <div class="col col-md-8">
                <code class="text text-grayish"><?php echo $TanggalFormat; ?></code>
            </div>
        </div>
        <div class="row mb-3">
            <div class="col col-md-4">Nama Transaksi</div>
            <div class="col col-md-8">
                <code class="text text-grayish"><?php echo $nama_transaksi; ?></code>
            </div>
        </div>
        <div class="row mb-3">
            <div class="col col-md-4">Kategori</div>
            <div class="col col-md-8">
                <code class="text text-grayish"><?php echo $kategori; ?></code>
            </div>
        </div>
        <div class="row mb-3">
            <div class="col col-md-4">Jumlah (Rp)</div>
            <div class="col col-md-8">
                <code class="text text-grayish"><?php echo $JumlahFormat; ?></code>
            </div>
        </div>
        <div class="row mb-3">
            <div class="col col-md-4">Pembayaran (Rp)</div>
            <div class="col col-md-8">
                <code class="text text-grayish"><?php echo $PembayaranFormat; ?></code>
            </div>
        </div>
        <div class="row mb-3">
            <div class="col col-md-4">Status</div>
            <div class="col col-md-8">
                <code class="text text-grayish"><?php echo "$status"; ?></code>
            </div>
        </div>
        <div class="row mb-3">
            <div class="col col-md-4">Rincian</div>
            <div class="col col-md-8">
                <code class="text text-grayish"><?php echo "$JumlahRincian Record"; ?></code>
            </div>
        </div>
        <div class="row mb-3">
            <div class="col col-md-4">Jurnal</div>
            <div class="col col-md-8">
                <code class="text text-grayish"><?php echo "$JumlahJurnal Record"; ?></code>
            </div>
        </div>
        <div class="row mb-3">
            <div class="col col-md-12 text-center">
                <code class="text text-primary">
                    Apakah anda yakin akan menghapus transaksi ini?
                </code>
            </div>
        </div>
    </div>
<?php 
        }
    }
?>
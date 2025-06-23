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
        if(empty($_POST['id_pinjaman_angsuran'])){
            echo '<div class="row">';
            echo '  <div class="col-md-12 mb-3 text-center">';
            echo '      <small class="text-danger">Tidak ada data yang ditangkap oleh sistem</small>';
            echo '  </div>';
            echo '</div>';
        }else{
            $id_pinjaman_angsuran=$_POST['id_pinjaman_angsuran'];
            //Buka Detail Pinjaman Angsuran
            $uuid_angsuran=GetDetailData($Conn,'pinjaman_angsuran','id_pinjaman_angsuran',$id_pinjaman_angsuran,'uuid_angsuran');
            $id_pinjaman=GetDetailData($Conn,'pinjaman_angsuran','id_pinjaman_angsuran',$id_pinjaman_angsuran,'id_pinjaman');
            $id_anggota=GetDetailData($Conn,'pinjaman_angsuran','id_pinjaman_angsuran',$id_pinjaman_angsuran,'id_anggota');
            $tanggal_angsuran=GetDetailData($Conn,'pinjaman_angsuran','id_pinjaman_angsuran',$id_pinjaman_angsuran,'tanggal_angsuran');
            $tanggal_bayar=GetDetailData($Conn,'pinjaman_angsuran','id_pinjaman_angsuran',$id_pinjaman_angsuran,'tanggal_bayar');
            $keterlambatan=GetDetailData($Conn,'pinjaman_angsuran','id_pinjaman_angsuran',$id_pinjaman_angsuran,'keterlambatan');
            $pokok=GetDetailData($Conn,'pinjaman_angsuran','id_pinjaman_angsuran',$id_pinjaman_angsuran,'pokok');
            $jasa=GetDetailData($Conn,'pinjaman_angsuran','id_pinjaman_angsuran',$id_pinjaman_angsuran,'jasa');
            $denda=GetDetailData($Conn,'pinjaman_angsuran','id_pinjaman_angsuran',$id_pinjaman_angsuran,'denda');
            $jumlah=GetDetailData($Conn,'pinjaman_angsuran','id_pinjaman_angsuran',$id_pinjaman_angsuran,'jumlah');
            //Buka Data Pinjaman
            $jumlah_pinjaman=GetDetailData($Conn,'pinjaman','id_pinjaman',$id_pinjaman,'jumlah_pinjaman');
            //Format Rupiah
            if(empty($jumlah_pinjaman)){
                $jumlah_pinjaman=0;
            }
            if(empty($pokok)){
                $pokok=0;
            }
            if(empty($jasa)){
                $jasa=0;
            }
            if(empty($denda)){
                $denda=0;
            }
            if(empty($jumlah)){
                $jumlah=0;
            }
            if(empty($keterlambatan)){
                $keterlambatan=0;
            }
            $jumlah_pinjaman_rp = "Rp " . number_format($jumlah_pinjaman,0,',','.');
            $pokok_rp = "Rp " . number_format($pokok,0,',','.');
            $jasa_rp = "Rp " . number_format($jasa,0,',','.');
            $denda_rp = "Rp " . number_format($denda,0,',','.');
            $jumlah_rp = "Rp " . number_format($jumlah,0,',','.');
            //Format tanggal
            $strtotime1=strtotime($tanggal_angsuran);
            $strtotime2=strtotime($tanggal_bayar);
            $tanggal_angsuran_format=date('d/m/Y',$strtotime1);
            $tanggal_bayar_format=date('d/m/Y',$strtotime2);
            //Buka Sistem Denda
            $sistem_denda=GetDetailData($Conn,'pinjaman','id_pinjaman',$id_pinjaman,'sistem_denda');
            if($sistem_denda=="Harian"){
                $SatuanTerlambat="Hari";
            }else{
                $SatuanTerlambat="Bulan";
            }
?>
            <input type="hidden" name="id_pinjaman_angsuran" value="<?php echo $id_pinjaman_angsuran; ?>">
            <div class="row mb-3">
                <div class="col col-md-4">Tanggal Angsuran</div>
                <div class="col col-md-8">
                    <code class="text text-grayish"><?php echo $tanggal_angsuran_format; ?></code>
                </div>
            </div>
            <div class="row mb-3">
                <div class="col col-md-4">Tanggal Bayar</div>
                <div class="col col-md-8">
                    <code class="text text-grayish"><?php echo $tanggal_bayar_format; ?></code>
                </div>
            </div>
            <div class="row mb-3">
                <div class="col col-md-4">Keterlambatan</div>
                <div class="col col-md-8">
                    <code class="text text-grayish"><?php echo "$keterlambatan $SatuanTerlambat"; ?></code>
                </div>
            </div>
            <div class="row mb-3">
                <div class="col col-md-4">Jumlah Pinjaman</div>
                <div class="col col-md-8">
                    <code class="text text-grayish"><?php echo $jumlah_pinjaman_rp; ?></code>
                </div>
            </div>
            <div class="row mb-3">
                <div class="col col-md-4">Pokok</div>
                <div class="col col-md-8">
                    <code class="text text-grayish"><?php echo $pokok_rp; ?></code>
                </div>
            </div>
            <div class="row mb-3">
                <div class="col col-md-4">Jasa</div>
                <div class="col col-md-8">
                    <code class="text text-grayish"><?php echo $jasa_rp; ?></code>
                </div>
            </div>
            <div class="row mb-3">
                <div class="col col-md-4">Denda</div>
                <div class="col col-md-8">
                    <code class="text text-grayish"><?php echo $denda_rp; ?></code>
                </div>
            </div>
            <div class="row mb-3">
                <div class="col col-md-4">Jumlah Angsuran</div>
                <div class="col col-md-8">
                    <code class="text text-grayish"><?php echo $jumlah_rp; ?></code>
                </div>
            </div>
            <div class="row mb-3">
                <div class="col col-md-4">Format</div>
                <div class="col col-md-8">
                    <select name="format" id="format" class="form-control">
                        <option value="PDF">PDF</option>
                        <option value="HTML">HTML</option>
                    </select>
                </div>
            </div>
            <div class="row mb-3">
                <div class="col col-md-12 text-center">
                    <code class="text-primary">
                        Apakah anda yakin akan mencetak lembar bukti pembayaran angsuran ini?
                    </code>
                </div>
            </div>
<?php
        }
    }
?>
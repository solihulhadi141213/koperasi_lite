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
        if(empty($_POST['id_simpanan'])){
            echo '<div class="row">';
            echo '  <div class="col-md-12 mb-3 text-center">';
            echo '      <small class="text-danger">Tidak ada data yang ditangkap oleh sistem</small>';
            echo '  </div>';
            echo '</div>';
        }else{
            $id_simpanan=$_POST['id_simpanan'];
            //Buka Detail Simpanan
            $id_anggota=GetDetailData($Conn,'simpanan','id_simpanan',$id_simpanan,'id_anggota');
            $id_akses=GetDetailData($Conn,'simpanan','id_simpanan',$id_simpanan,'id_akses');
            $id_simpanan_jenis=GetDetailData($Conn,'simpanan','id_simpanan',$id_simpanan,'id_simpanan_jenis');
            $rutin=GetDetailData($Conn,'simpanan','id_simpanan',$id_simpanan,'rutin');
            $nip=GetDetailData($Conn,'simpanan','id_simpanan',$id_simpanan,'nip');
            $nama=GetDetailData($Conn,'simpanan','id_simpanan',$id_simpanan,'nama');
            $lembaga=GetDetailData($Conn,'simpanan','id_simpanan',$id_simpanan,'lembaga');
            $ranking=GetDetailData($Conn,'simpanan','id_simpanan',$id_simpanan,'ranking');
            $tanggal=GetDetailData($Conn,'simpanan','id_simpanan',$id_simpanan,'tanggal');
            $kategori=GetDetailData($Conn,'simpanan','id_simpanan',$id_simpanan,'kategori');
            $keterangan=GetDetailData($Conn,'simpanan','id_simpanan',$id_simpanan,'keterangan');
            $jumlah=GetDetailData($Conn,'simpanan','id_simpanan',$id_simpanan,'jumlah');
            if($kategori=="Penarikan"){
                $LabelKategori='<code class="text text-danger">Penarikan dana simpanan</code>';
            }else{
                $LabelKategori='<code class="text text-success">'.$kategori.'</code>';
            }
            //Format tanggal
            $strtotime=strtotime($tanggal);
            $TanggalFormat=date('d/m/Y',$strtotime);
            //Format Rupiah
            $jumlah_format = "Rp " . number_format($jumlah,0,',','.');
            if(empty($keterangan)){
                $keterangan="-";
            }
?>
            <input type="hidden" name="id_simpanan" class="form-control" value="<?php echo $id_simpanan; ?>">
            <div class="row mb-3">
                <div class="col col-md-4">Tanggal</div>
                <div class="col col-md-8">
                    <code class="text text-grayish"><?php echo $TanggalFormat; ?></code>
                </div>
            </div>
            <div class="row mb-3">
                <div class="col col-md-4">NIP</div>
                <div class="col col-md-8">
                    <code class="text text-grayish"><?php echo $nip; ?></code>
                </div>
            </div>
            <div class="row mb-3">
                <div class="col col-md-4">Nama</div>
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
                <div class="col col-md-4">Jenis Simpanan</div>
                <div class="col col-md-8">
                    <code class="text text-grayish"><?php echo $LabelKategori; ?></code>
                </div>
            </div>
            <div class="row mb-3">
                <div class="col col-md-4">Keterangan</div>
                <div class="col col-md-8">
                    <code class="text text-grayish"><?php echo $keterangan; ?></code>
                </div>
            </div>
            <div class="row mb-3">
                <div class="col col-md-4">Nominal</div>
                <div class="col col-md-8">
                    <code class="text text-grayish"><?php echo $jumlah_format; ?></code>
                </div>
            </div>
<?php
        }
    }
?>
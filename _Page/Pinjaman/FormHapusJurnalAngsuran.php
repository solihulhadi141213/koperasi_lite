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
        if(empty($_POST['id_jurnal'])){
            echo '<div class="row">';
            echo '  <div class="col-md-12 mb-3 text-center">';
            echo '      <small class="text-danger">Tidak ada data yang ditangkap oleh sistem</small>';
            echo '  </div>';
            echo '</div>';
        }else{
            $id_jurnal=$_POST['id_jurnal'];
            //Buka Detail Pinjaman
            $id_jurnal=GetDetailData($Conn,'jurnal','id_jurnal',$id_jurnal,'id_jurnal');
            if(empty($id_jurnal)){
                echo '<div class="row">';
                echo '  <div class="col-md-12 mb-3 text-center">';
                echo '      <small class="text-danger">ID Jurnal Tidak Valid Atau Tidak Ditemukan Pada Database</small>';
                echo '  </div>';
                echo '</div>';
            }else{
                $tanggal=GetDetailData($Conn,'jurnal','id_jurnal',$id_jurnal,'tanggal');
                $kode_perkiraan=GetDetailData($Conn,'jurnal','id_jurnal',$id_jurnal,'kode_perkiraan');
                $nama_perkiraan=GetDetailData($Conn,'jurnal','id_jurnal',$id_jurnal,'nama_perkiraan');
                $d_k=GetDetailData($Conn,'jurnal','id_jurnal',$id_jurnal,'d_k');
                $nilai=GetDetailData($Conn,'jurnal','id_jurnal',$id_jurnal,'nilai');
                //Format tanggal
                $strtotime=strtotime($tanggal);
                $TanggalFormat=date('d/m/Y',$strtotime);
                //Format Rupiah
                $nilai = "Rp " . number_format($nilai,0,',','.');
?>
                <input type="hidden" name="id_jurnal" value="<?php echo $id_jurnal; ?>">
                <div class="row mb-3">
                    <div class="col col-md-4">Tanggal</div>
                    <div class="col col-md-8">
                        <code class="text text-grayish"><?php echo $TanggalFormat; ?></code>
                    </div>
                </div>
                <div class="row mb-3">
                    <div class="col col-md-4">Kode Perkiraan</div>
                    <div class="col col-md-8">
                        <code class="text text-grayish"><?php echo $kode_perkiraan; ?></code>
                    </div>
                </div>
                <div class="row mb-3">
                    <div class="col col-md-4">Nama Akun</div>
                    <div class="col col-md-8">
                        <code class="text text-grayish"><?php echo $nama_perkiraan; ?></code>
                    </div>
                </div>
                <div class="row mb-3">
                    <div class="col col-md-4">Nominal</div>
                    <div class="col col-md-8">
                        <code class="text text-grayish"><?php echo $nilai; ?></code>
                    </div>
                </div>
                <div class="row mb-3">
                    <div class="col col-md-4">Posisi</div>
                    <div class="col col-md-8">
                        <code class="text text-grayish"><?php echo $d_k; ?></code>
                    </div>
                </div>
                <div class="row mb-3">
                    <div class="col col-md-12 text-center">
                        <code class="text text-primary">
                            Apakah anda yakin akan menghapus data jurnal pinjaman ini?
                        </code>
                    </div>
                </div>
<?php
            }
        }
    }
?>
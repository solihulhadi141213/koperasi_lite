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
        if(empty($_POST['id_pinjaman'])){
            echo '<div class="row">';
            echo '  <div class="col-md-12 mb-3 text-center">';
            echo '      <small class="text-danger">Tidak ada data yang ditangkap oleh sistem</small>';
            echo '  </div>';
            echo '</div>';
        }else{
            $id_pinjaman=$_POST['id_pinjaman'];
            //Buka Detail Pinjaman
            $id_anggota=GetDetailData($Conn,'pinjaman','id_pinjaman',$id_pinjaman,'id_anggota');
            $uuid_pinjaman=GetDetailData($Conn,'pinjaman','id_pinjaman',$id_pinjaman,'uuid_pinjaman');
            $nip=GetDetailData($Conn,'pinjaman','id_pinjaman',$id_pinjaman,'nip');
            $nama=GetDetailData($Conn,'pinjaman','id_pinjaman',$id_pinjaman,'nama');
            $lembaga=GetDetailData($Conn,'pinjaman','id_pinjaman',$id_pinjaman,'lembaga');
            $ranking=GetDetailData($Conn,'pinjaman','id_pinjaman',$id_pinjaman,'ranking');
            $tanggal=GetDetailData($Conn,'pinjaman','id_pinjaman',$id_pinjaman,'tanggal');
            $jatuh_tempo=GetDetailData($Conn,'pinjaman','id_pinjaman',$id_pinjaman,'jatuh_tempo');
            $denda=GetDetailData($Conn,'pinjaman','id_pinjaman',$id_pinjaman,'denda');
            $sistem_denda=GetDetailData($Conn,'pinjaman','id_pinjaman',$id_pinjaman,'sistem_denda');
            $jumlah_pinjaman=GetDetailData($Conn,'pinjaman','id_pinjaman',$id_pinjaman,'jumlah_pinjaman');
            $persen_jasa=GetDetailData($Conn,'pinjaman','id_pinjaman',$id_pinjaman,'persen_jasa');
            $rp_jasa=GetDetailData($Conn,'pinjaman','id_pinjaman',$id_pinjaman,'rp_jasa');
            $angsuran_pokok=GetDetailData($Conn,'pinjaman','id_pinjaman',$id_pinjaman,'angsuran_pokok');
            $angsuran_total=GetDetailData($Conn,'pinjaman','id_pinjaman',$id_pinjaman,'angsuran_total');
            $periode_angsuran=GetDetailData($Conn,'pinjaman','id_pinjaman',$id_pinjaman,'periode_angsuran');
            $status=GetDetailData($Conn,'pinjaman','id_pinjaman',$id_pinjaman,'status');
            //Format tanggal
            $strtotime=strtotime($tanggal);
            $TanggalFormat=date('d/m/Y',$strtotime);
            //Format Rupiah
            if(empty($denda)){
                $denda=0;
            }
            if(empty($jumlah_pinjaman)){
                $jumlah_pinjaman=0;
            }
            if(empty($rp_jasa)){
                $rp_jasa=0;
            }
            if(empty($angsuran_pokok)){
                $angsuran_pokok=0;
            }
            if(empty($angsuran_total)){
                $angsuran_total=0;
            }
            $denda_format = "Rp " . number_format($denda,0,',','.');
            $jumlah_pinjaman_format = "Rp " . number_format($jumlah_pinjaman,0,',','.');
            $rp_jasa_format = "Rp " . number_format($rp_jasa,0,',','.');
            $angsuran_pokok_format = "Rp " . number_format($angsuran_pokok,0,',','.');
            $angsuran_total_format = "Rp " . number_format($angsuran_total,0,',','.');
            //Jumlah Data Angsuran
            $JumlahAngsuran = mysqli_num_rows(mysqli_query($Conn, "SELECT*FROM pinjaman_angsuran WHERE id_pinjaman='$id_pinjaman'"));
?>
            <input type="hidden" name="id_pinjaman" value="<?php echo $id_pinjaman; ?>">
            <div class="row mb-3">
                <div class="col col-md-4">Tanggal Pinjaman</div>
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
                <div class="col col-md-4">Jumlah Pinjaman</div>
                <div class="col col-md-8">
                    <code class="text text-grayish"><?php echo $jumlah_pinjaman_format; ?></code>
                </div>
            </div>
            <div class="row mb-3">
                <div class="col col-md-4">Periode Angsuran</div>
                <div class="col col-md-8">
                    <code class="text text-grayish"><?php echo "$periode_angsuran Kali"; ?></code>
                </div>
            </div>
            <div class="row mb-3">
                <div class="col col-md-4">Record Angsuran</div>
                <div class="col col-md-8">
                    <code class="text text-grayish"><?php echo "$JumlahAngsuran Record"; ?></code>
                </div>
            </div>
            <div class="row mb-3">
                <div class="col col-md-12 text-center">
                    <code class="text text-primary">
                        Apakah anda yakin akan melakukan export data angsuran pinjaman ini?
                    </code>
                </div>
            </div>
<?php
        }
    }
?>
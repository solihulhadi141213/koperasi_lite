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
        if(empty($_POST['id_pinjaman_jenis'])){
            echo '<div class="row">';
            echo '  <div class="col-md-12 mb-3 text-center">';
            echo '      <small class="text-danger">Jenis Pinjaman Tidak Boleh Kosong!</small>';
            echo '  </div>';
            echo '</div>';
        }else{
            $id_pinjaman_jenis=$_POST['id_pinjaman_jenis'];
            $id_pinjaman_jenis=validateAndSanitizeInput($id_pinjaman_jenis);
            $nama_pinjaman=GetDetailData($Conn,'pinjaman_jenis','id_pinjaman_jenis',$id_pinjaman_jenis,'nama_pinjaman');
            if(empty($nama_pinjaman)){
                echo '<div class="row">';
                echo '  <div class="col-md-12 mb-3 text-center">';
                echo '      <small class="text-danger">Pinjaman yang anda pilih tidak valid, atau tidak ada pada database!</small>';
                echo '  </div>';
                echo '</div>';
            }else{
                $periode_angsuran=GetDetailData($Conn,'pinjaman_jenis','id_pinjaman_jenis',$id_pinjaman_jenis,'periode_angsuran');
                $persen_jasa=GetDetailData($Conn,'pinjaman_jenis','id_pinjaman_jenis',$id_pinjaman_jenis,'persen_jasa');
                echo '
                    <div class="row mb-2">
                        <div class="col-5"><small>Jumlah Pinjaman</small></div>
                        <div class="col-1"><small>:</small></div>
                        <div class="col-6"><code class="text text-grayish">'.$nama_pinjaman.'</code></div>
                    </div>
                    <div class="row mb-2">
                        <div class="col-5"><small>Periode</small></div>
                        <div class="col-1"><small>:</small></div>
                        <div class="col-6"><code class="text text-grayish">'.$periode_angsuran.' Bulan</code></div>
                    </div>
                    <div class="row mb-2">
                        <div class="col-5"><small>Persen Jasa</small></div>
                        <div class="col-1"><small>:</small></div>
                        <div class="col-6"><code class="text text-grayish">'.$persen_jasa.' %</code></div>
                    </div>
                ';
            }
        }
    }
?>
<script>
    
</script>
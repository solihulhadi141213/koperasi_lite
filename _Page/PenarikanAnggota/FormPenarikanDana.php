<?php
    //Koneksi
    date_default_timezone_set('Asia/Jakarta');
    include "../../_Config/Connection.php";
    include "../../_Config/GlobalFunction.php";
    include "../../_Config/SettingGeneral.php";
    include "../../_Config/Session.php";

    //Validasi Sesi Akses
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

            //Hitung Saldo Kotor
            $SumSimpananKotor = mysqli_fetch_array(mysqli_query($Conn, "SELECT SUM(jumlah) AS jumlah FROM simpanan WHERE id_simpanan_jenis='$id_simpanan_jenis' AND id_anggota='$SessionIdAkses' AND status='Lunas'"));
            $JumlahSimpananKotor = $SumSimpananKotor['jumlah'];

            //Saldo Penarikan Lunas
            $SumPenarikanLunas = mysqli_fetch_array(mysqli_query($Conn, "SELECT SUM(nominal) AS nominal FROM simpanan_penarikan  WHERE id_simpanan_jenis='$id_simpanan_jenis' AND id_anggota='$SessionIdAkses' AND status='Lunas'"));
            $JumlahPenarikanLunas = $SumPenarikanLunas['nominal'];

            //Hitung Jumlah Simpanan Bersih
            $JumlahSimpananBersih=$JumlahSimpananKotor-$JumlahPenarikanLunas;
            $JumlahSimpananBersihFormat = "" . number_format($JumlahSimpananBersih,0,',','.');
            echo '
                <input type="hidden" name="id_simpanan_jenis" value="'.$id_simpanan_jenis.'">
                <div class="row mb-3">
                    <div class="col-3"><small>Sumber Dana</small></div>
                    <div class="col-1"><small>:</small></div>
                    <div class="col col-md-8">
                        <code class="text text-grayish">'.$nama_simpanan.'</code>
                    </div>
                </div>
                <div class="row mb-3">
                    <div class="col-3"><small>Saldo</small></div>
                    <div class="col-1"><small>:</small></div>
                    <div class="col col-md-8">
                        <code class="text text-grayish">'.$JumlahSimpananBersihFormat.'</code>
                    </div>
                </div>
                <div class="row mb-3">
                    <div class="col-3"><small>Nominal</small></div>
                    <div class="col-1"><small>:</small></div>
                    <div class="col col-md-8">
                        <input type="text" name="nominal" id="nominal_penarikan" class="form-control form-money">
                    </div>
                </div>
                <div class="row mb-3">
                    <div class="col-3"><small>Nama Bank</small></div>
                    <div class="col-1"><small>:</small></div>
                    <div class="col col-md-8">
                        <input type="text" name="bank" id="bank" class="form-control">
                    </div>
                </div>
                <div class="row mb-3">
                    <div class="col-3"><small>No.Rekening</small></div>
                    <div class="col-1"><small>:</small></div>
                    <div class="col col-md-8">
                        <input type="text" name="norek" id="norek" class="form-control">
                    </div>
                </div>
            ';
        }
    }
?>

<script>
    initializeMoneyInputs();
</script>
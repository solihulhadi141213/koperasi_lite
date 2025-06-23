<?php
    //Koneksi
    date_default_timezone_set('Asia/Jakarta');
    include "../../_Config/Connection.php";
    include "../../_Config/GlobalFunction.php";
    include "../../_Config/SettingGeneral.php";
    include "../../_Config/Session.php";
    //Membukka Data Auto Jurnal Pinjaman
    $debet_id=GetDetailData($Conn,'auto_jurnal','kategori_transaksi','Pinjaman','debet_id');
    $debet_name=GetDetailData($Conn,'auto_jurnal','kategori_transaksi','Pinjaman','debet_name');
    $kredit_id=GetDetailData($Conn,'auto_jurnal','kategori_transaksi','Pinjaman','kredit_id');
    $kredit_name=GetDetailData($Conn,'auto_jurnal','kategori_transaksi','Pinjaman','kredit_name');
    //Buka Auto Jurnal Angsuran
    $debet_id2=GetDetailData($Conn,'auto_jurnal','kategori_transaksi','Angsuran','debet_id');
    $debet_name2=GetDetailData($Conn,'auto_jurnal','kategori_transaksi','Angsuran','debet_name');
    $kredit_id2=GetDetailData($Conn,'auto_jurnal','kategori_transaksi','Angsuran','kredit_id');
    $kredit_name2=GetDetailData($Conn,'auto_jurnal','kategori_transaksi','Angsuran','kredit_name');
    //Buka Auto Jurnal Jasa dan Denda
    $id_perkiraan_jasa=GetDetailData($Conn,'auto_jurnal_angsuran','komponen','Jasa','id_perkiraan');
    $id_perkiraan_denda=GetDetailData($Conn,'auto_jurnal_angsuran','komponen','Denda','id_perkiraan');
?>
<div class="row mb-3">
    <div class="col-md-12">
        <b>Auto Jurnal Transaksi Pinjaman</b><br>
        <small class="credit text-grayish">
            Pengaturan akun perkiraan auto-jurnal ketika transaksi pinjaman berlangsung.
        </small>
    </div>
</div>
<div class="row mb-3">
    <div class="col col-md-4">
        <label for="debet_id">Akun Debet</label>
    </div>
    <div class="col col-md-8">
        <select name="debet_id" id="debet_id" class="form-control">
            <?php
                echo '<option value="">Pilih</option>';
                $QryAkun= mysqli_query($Conn, "SELECT*FROM akun_perkiraan ORDER BY nama");
                while ($DataAkun=mysqli_fetch_array($QryAkun)) {
                    $id_perkiraan = $DataAkun['id_perkiraan'];
                    $kode= $DataAkun['kode'];
                    $nama_perkiraan = $DataAkun['nama'];
                    $level= $DataAkun['level'];
                    $saldo_normal= $DataAkun['saldo_normal'];
                    //Cek apakah di levelnya ada lagi?
                    $LevelTerbawah = mysqli_num_rows(mysqli_query($Conn, "SELECT*FROM akun_perkiraan WHERE kd$level='$kode'"));
                    if($LevelTerbawah=="1"){
                        if($debet_id==$id_perkiraan){
                            echo '<option selected value="'.$id_perkiraan.'">'.$nama_perkiraan.' ('.$saldo_normal.')</option>';
                        }else{
                            echo '<option value="'.$id_perkiraan.'">'.$nama_perkiraan.' ('.$saldo_normal.')</option>';
                        }
                    }
                }
            ?>
        </select>
    </div>
</div>
<div class="row mb-3">
    <div class="col col-md-4">
        <label for="kredit_id">Akun Kredit</label>
    </div>
    <div class="col col-md-8">
        <select name="kredit_id" id="kredit_id" class="form-control">
            <?php
                echo '<option value="">Pilih</option>';
                $QryAkun= mysqli_query($Conn, "SELECT*FROM akun_perkiraan ORDER BY nama");
                while ($DataAkun=mysqli_fetch_array($QryAkun)) {
                    $id_perkiraan = $DataAkun['id_perkiraan'];
                    $kode= $DataAkun['kode'];
                    $nama_perkiraan = $DataAkun['nama'];
                    $level= $DataAkun['level'];
                    $saldo_normal= $DataAkun['saldo_normal'];
                    //Cek apakah di levelnya ada lagi?
                    $LevelTerbawah = mysqli_num_rows(mysqli_query($Conn, "SELECT*FROM akun_perkiraan WHERE kd$level='$kode'"));
                    if($LevelTerbawah=="1"){
                        if($kredit_id==$id_perkiraan){
                            echo '<option selected value="'.$id_perkiraan.'">'.$nama_perkiraan.' ('.$saldo_normal.')</option>';
                        }else{
                            echo '<option value="'.$id_perkiraan.'">'.$nama_perkiraan.' ('.$saldo_normal.')</option>';
                        }
                    }
                }
            ?>
        </select>
    </div>
</div>
<div class="row mb-3">
    <div class="col-md-12">
        <b>Auto Jurnal Transaksi Angsuran</b><br>
        <small class="credit text-grayish">
            Pengaturan akun perkiraan auto-jurnal ketika transaksi angsuran berlangsung.
        </small>
    </div>
</div>
<div class="row mb-3">
    <div class="col col-md-4">
        <label for="debet_id2">Akun Debet</label>
    </div>
    <div class="col col-md-8">
        <select name="debet_id2" id="debet_id2" class="form-control">
            <?php
                echo '<option value="">Pilih</option>';
                $QryAkun= mysqli_query($Conn, "SELECT*FROM akun_perkiraan ORDER BY nama");
                while ($DataAkun=mysqli_fetch_array($QryAkun)) {
                    $id_perkiraan = $DataAkun['id_perkiraan'];
                    $kode= $DataAkun['kode'];
                    $nama_perkiraan = $DataAkun['nama'];
                    $level= $DataAkun['level'];
                    $saldo_normal= $DataAkun['saldo_normal'];
                    //Cek apakah di levelnya ada lagi?
                    $LevelTerbawah = mysqli_num_rows(mysqli_query($Conn, "SELECT*FROM akun_perkiraan WHERE kd$level='$kode'"));
                    if($LevelTerbawah=="1"){
                        if($debet_id2==$id_perkiraan){
                            echo '<option selected value="'.$id_perkiraan.'">'.$nama_perkiraan.' ('.$saldo_normal.')</option>';
                        }else{
                            echo '<option value="'.$id_perkiraan.'">'.$nama_perkiraan.' ('.$saldo_normal.')</option>';
                        }
                    }
                }
            ?>
        </select>
    </div>
</div>
<div class="row mb-3">
    <div class="col col-md-4">
        <label for="kredit_id2">Akun Kredit</label>
    </div>
    <div class="col col-md-8">
        <select name="kredit_id2" id="kredit_id2" class="form-control">
            <?php
                echo '<option value="">Pilih</option>';
                $QryAkun= mysqli_query($Conn, "SELECT*FROM akun_perkiraan ORDER BY nama");
                while ($DataAkun=mysqli_fetch_array($QryAkun)) {
                    $id_perkiraan = $DataAkun['id_perkiraan'];
                    $kode= $DataAkun['kode'];
                    $nama_perkiraan = $DataAkun['nama'];
                    $level= $DataAkun['level'];
                    $saldo_normal= $DataAkun['saldo_normal'];
                    //Cek apakah di levelnya ada lagi?
                    $LevelTerbawah = mysqli_num_rows(mysqli_query($Conn, "SELECT*FROM akun_perkiraan WHERE kd$level='$kode'"));
                    if($LevelTerbawah=="1"){
                        if($kredit_id2==$id_perkiraan){
                            echo '<option selected value="'.$id_perkiraan.'">'.$nama_perkiraan.' ('.$saldo_normal.')</option>';
                        }else{
                            echo '<option value="'.$id_perkiraan.'">'.$nama_perkiraan.' ('.$saldo_normal.')</option>';
                        }
                    }
                }
            ?>
        </select>
    </div>
</div>
<div class="row mb-3">
    <div class="col-md-12">
        <b>Auto Jurnal Jasa Dan Denda</b><br>
        <small class="credit text-grayish">
            Pengaturan akun perkiraan auto-jurnal ketika transaksi angsuran yang mengisyaratkan jasa dan denda.
        </small>
    </div>
</div>
<div class="row mb-3">
    <div class="col col-md-4">
        <label for="id_perkiraan_jasa">Jasa</label>
    </div>
    <div class="col col-md-8">
        <select name="id_perkiraan_jasa" id="id_perkiraan_jasa" class="form-control">
            <?php
                echo '<option value="">Pilih</option>';
                $QryAkunDenda= mysqli_query($Conn, "SELECT*FROM akun_perkiraan ORDER BY nama");
                while ($DataAkunDenda=mysqli_fetch_array($QryAkunDenda)) {
                    $ListIdPerkiraanDenda = $DataAkunDenda['id_perkiraan'];
                    $ListKodeDenda= $DataAkunDenda['kode'];
                    $ListNamaDenda = $DataAkunDenda['nama'];
                    $ListLevelDenda= $DataAkunDenda['level'];
                    $ListSaldoNormalDenda= $DataAkunDenda['saldo_normal'];
                    //Cek apakah di levelnya ada lagi?
                    $LevelTerbawahDenda = mysqli_num_rows(mysqli_query($Conn, "SELECT*FROM akun_perkiraan WHERE kd$ListLevelDenda='$ListKodeDenda'"));
                    if($LevelTerbawahDenda<="1"){
                        if($id_perkiraan_jasa==$ListIdPerkiraanDenda){
                            echo '<option selected value="'.$ListIdPerkiraanDenda.'">'.$ListNamaDenda.' ('.$ListSaldoNormalDenda.')</option>';
                        }else{
                            echo '<option value="'.$ListIdPerkiraanDenda.'">'.$ListNamaDenda.' ('.$ListSaldoNormalDenda.')</option>';
                        }
                    }
                }
            ?>
        </select>
    </div>
</div>
<div class="row mb-3">
    <div class="col col-md-4">
        <label for="id_perkiraan_denda">Denda</label>
    </div>
    <div class="col col-md-8">
        <select name="id_perkiraan_denda" id="id_perkiraan_denda" class="form-control">
            <?php
                echo '<option value="">Pilih</option>';
                $QryAkunDenda= mysqli_query($Conn, "SELECT*FROM akun_perkiraan ORDER BY nama");
                while ($DataAkunDenda=mysqli_fetch_array($QryAkunDenda)) {
                    $ListIdPerkiraanDenda = $DataAkunDenda['id_perkiraan'];
                    $ListKodeDenda= $DataAkunDenda['kode'];
                    $ListNamaDenda = $DataAkunDenda['nama'];
                    $ListLevelDenda= $DataAkunDenda['level'];
                    $ListSaldoNormalDenda= $DataAkunDenda['saldo_normal'];
                    //Cek apakah di levelnya ada lagi?
                    $LevelTerbawahDenda = mysqli_num_rows(mysqli_query($Conn, "SELECT*FROM akun_perkiraan WHERE kd$ListLevelDenda='$ListKodeDenda'"));
                    if($LevelTerbawahDenda<="1"){
                        if($id_perkiraan_denda==$ListIdPerkiraanDenda){
                            echo '<option selected value="'.$ListIdPerkiraanDenda.'">'.$ListNamaDenda.' ('.$ListSaldoNormalDenda.')</option>';
                        }else{
                            echo '<option value="'.$ListIdPerkiraanDenda.'">'.$ListNamaDenda.' ('.$ListSaldoNormalDenda.')</option>';
                        }
                    }
                }
            ?>
        </select>
    </div>
</div>
<div class="row mb-3">
    <div class="col-md-12 text-center">
        <code class="text-primary">
            Pastikan pengaturan autoi jurnal yang anda masukan sudah sesuai!
        </code>
    </div>
</div>
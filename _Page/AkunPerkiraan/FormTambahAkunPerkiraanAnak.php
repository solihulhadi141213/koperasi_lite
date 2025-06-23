<?php
    //Koneksi
    include "../../_Config/Connection.php";
    include "../../_Config/GlobalFunction.php";
    include "../../_Config/Session.php";
    date_default_timezone_set('Asia/Jakarta');
    if(empty($SessionIdAkses)){
        echo '<div class="row mb-3">';
        echo '  <div class="col col-md-12 text-center">';
        echo '      <code>Sesi Akses Sudah Berakhir. Silahkan Login Ulang!</code>';
        echo '  </div>';
        echo '</div>';
    }else{
        //Tangkap id_kelas
        if(empty($_POST['id_perkiraan'])){
            echo '<div class="row">';
            echo '  <div class="col-md-12 mb-3 text-danger text-center">';
            echo '      Mohon Maaf!! ID Akun Perkiraan Tidak Dapat didefinisikan.<br>';
            echo '      Hubungi admin aplikasi untuk permasalahn berikut ini.<br>';
            echo '  </div>';
            echo '</div>';
        }else{
            $id_perkiraan=$_POST['id_perkiraan'];
            $id_perkiraan=validateAndSanitizeInput($id_perkiraan);
            $id_perkiraan=GetDetailData($Conn,'akun_perkiraan','id_perkiraan',$id_perkiraan,'id_perkiraan');
            if(empty($id_perkiraan)){
                echo '<div class="row mb-3">';
                echo '  <div class="col col-md-12 text-center">';
                echo '      <code>ID Akun Perkiraan Tidak Ditemukan Pada Database!</code>';
                echo '  </div>';
                echo '</div>';
            }else{
                $kode=GetDetailData($Conn,'akun_perkiraan','id_perkiraan',$id_perkiraan,'kode');
                $nama=GetDetailData($Conn,'akun_perkiraan','id_perkiraan',$id_perkiraan,'nama');
                $level=GetDetailData($Conn,'akun_perkiraan','id_perkiraan',$id_perkiraan,'level');
                $saldo_normal=GetDetailData($Conn,'akun_perkiraan','id_perkiraan',$id_perkiraan,'saldo_normal');
?>
                <input type="hidden" name="id_perkiraan" value="<?php echo "$id_perkiraan"; ?>">
                <div class="row mb-3">
                    <div class="col-md-4">
                        <label for="kode">Kode Akun</label>
                    </div>
                    <div class="col-md-8">
                        <div class="input-group">
                            <input type="text" readonly name="kode_induk" id="kode_induk" class="form-control" value="<?php echo "$kode."; ?>" required>
                            <input type="text" name="kode" id="kode" class="form-control" required>
                        </div>
                    </div>
                </div>
                <div class="row mb-3">
                    <div class="col-md-4">
                        <label for="nama">Nama Akun</label>
                    </div>
                    <div class="col-md-8">
                        <input type="text" name="nama" id="nama" class="form-control" required>
                    </div>
                </div>
                <div class="row mb-3">
                    <div class="col-md-4">
                        <label for="saldo_normal">Saldo Normal</label>
                    </div>
                    <div class="col-md-8">
                        <input type="text" readonly name="saldo_normal" id="saldo_normal" class="form-control" value="<?php echo "$saldo_normal."; ?>">
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-12">
                        <small class="text-primary">Pastikan anda mengisi form akun perkiraan dengan benar!</small>
                    </div>
                </div>
<?php 
            } 
        } 
    } 
?>
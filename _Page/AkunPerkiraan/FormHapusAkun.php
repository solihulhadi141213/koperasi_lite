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
                //Akun Di Bawahnya
                $KodeBawah = mysqli_num_rows(mysqli_query($Conn, "SELECT*FROM akun_perkiraan WHERE kd$level='$kode'"));
                if($KodeBawah>1){
                    echo '<div class="row mb-3">';
                    echo '  <div class="col col-md-12 text-center">';
                    echo '      <code>Akun tersebut memiliki level di bawahnya. Silahkan hapus terlebih dulu akun yang ada di level akun ini!</code>';
                    echo '  </div>';
                    echo '</div>';
                }else{
?>
                <input type="hidden" name="id_perkiraan" value="<?php echo "$id_perkiraan"; ?>">
                <div class="row mb-3">
                    <div class="col-md-4">Kode Akun</div>
                    <div class="col-md-8">
                        <small class="credit text-grayish"><?php echo $kode; ?></small>
                    </div>
                </div>
                <div class="row mb-3">
                    <div class="col-md-4">Nama Akun</div>
                    <div class="col-md-8">
                        <small class="credit text-grayish"><?php echo $nama; ?></small>
                    </div>
                </div>
                <div class="row mb-3">
                    <div class="col-md-4">Level</div>
                    <div class="col-md-8">
                        <small class="credit text-grayish"><?php echo $level; ?></small>
                    </div>
                </div>
                <div class="row mb-4">
                    <div class="col-md-4">Saldo Normal</div>
                    <div class="col-md-8">
                        <small class="credit text-grayish"><?php echo $saldo_normal; ?></small>
                    </div>
                </div>
                <div class="row mb-3">
                    <div class="col-md-12 text-center">
                        <code class="text-primary">Apakah anda yakin akan menghapus akun perkiraan ini?</code>
                    </div>
                </div>
                <div class="row mb-3">
                    <div class="col-md-12 text-center">
                        <button type="submit" class="btn btn-md btn-success btn-rounded">
                            Ya, Hapus
                        </button>
                    </div>
                </div>
<?php 
                } 
            } 
        } 
    } 
?>
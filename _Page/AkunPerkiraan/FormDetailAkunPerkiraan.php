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
                <div class="row mb-3">
                    <div class="col-md-4">Saldo Normal</div>
                    <div class="col-md-8">
                        <small class="credit text-grayish"><?php echo $saldo_normal; ?></small>
                    </div>
                </div>
                <div class="row mb-3">
                    <div class="col-md-4">Akun Di Atasnya</div>
                    <div class="col-md-8">
                        <small class="credit text-grayish">
                            <?php 
                                if($level=="1"){
                                    echo '-';
                                }else{
                                    $level_di_atas=$level-1;
                                    //Looping Berdasarkan Jumlah Level Di Atasnya
                                    for ( $i="1"; $i<="$level_di_atas"; $i++ ){
                                        $KolomSaya="kd$i";
                                        $kode_atasan=GetDetailData($Conn,'akun_perkiraan','id_perkiraan',$id_perkiraan,$KolomSaya);
                                        $nama_atasan=GetDetailData($Conn,'akun_perkiraan','kode',$kode_atasan,'nama');
                                        echo ''.$kode_atasan.'. '.$nama_atasan.'<br>';
                                    }
                                    echo '<span class="text-dark">'.$kode.'. '.$nama.'</span>';
                                }
                            ?>
                        </small>
                    </div>
                </div>
<?php 
            } 
        } 
    } 
?>
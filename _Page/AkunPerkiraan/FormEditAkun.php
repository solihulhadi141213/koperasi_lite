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
                //Mencari Kode Akun Di Atasnya
                if($level=="1"){
                    $KodeAtas="$kode";
                    $lastPart =""; 
                }else{
                    $LevelAtas=$level-1;
                    $KodeAtas=GetDetailData($Conn,'akun_perkiraan','id_perkiraan',$id_perkiraan,'kd'.$LevelAtas.'');
                    $parts = explode('.', $kode); // Memisahkan string menjadi array
                    if(!empty(end($parts))){
                        $lastPart = end($parts); 
                    }else{
                        $lastPart =""; 
                    }
                    
                }
                //Cek Punya Anak Akun Atau Tidak
                $JumlahAnakAkun=mysqli_num_rows(mysqli_query($Conn, "SELECT * FROM akun_perkiraan WHERE level>'$level' AND kd$level='$kode'"));
?>
                <input type="hidden" name="id_perkiraan" value="<?php echo "$id_perkiraan"; ?>">
                <div class="row">
                    <div class="col-4">
                        Level
                    </div>
                    <div class="col-8">
                        <?php echo $level;?>
                    </div>
                </div>
                <div class="row mb-3">
                    <div class="col-md-4">
                        <label for="kode">Kode Akun</label>
                    </div>
                    <div class="col-md-8">
                        <div class="input-group">
                            <?php
                                if($level!==1){
                            ?>
                                <input type="text" readonly name="kode_induk" id="kode_induk" class="form-control" value="<?php echo "$KodeAtas."; ?>" required>
                                <input type="text" <?php if(!empty($JumlahAnakAkun)){echo "readonly";} ?> name="kode" id="kode" class="form-control" value="<?php echo "$lastPart"; ?>" required>
                            <?php }else{ ?>
                                <input type="text" <?php if(!empty($JumlahAnakAkun)){echo "readonly";} ?> name="kode" id="kode" class="form-control" value="<?php echo "$kode"; ?>" required>
                            <?php } ?>
                        </div>
                        <?php if(!empty($JumlahAnakAkun)){echo '<code class="text text-grayish">Kode Akun Tidak Bisa Diubah Karena Memilikki Sub Akkun Dibawahnya</code>';} ?>
                    </div>
                </div>
                <div class="row mb-3">
                    <div class="col-md-4">
                        <label for="nama">Nama Akun</label>
                    </div>
                    <div class="col-md-8">
                        <input type="text" name="nama" id="nama" class="form-control" value="<?php echo "$nama"; ?>"  required>
                    </div>
                </div>
                <div class="row mb-3">
                    <div class="col-md-4">
                        <label for="saldo_normal">Saldo Normal</label>
                    </div>
                    <div class="col-md-8">
                        <?php
                            if($level!=="1"){
                        ?>
                            <input type="text" readonly name="saldo_normal" id="saldo_normal" class="form-control" value="<?php echo "$saldo_normal"; ?>">
                            <code class="text text-grayish">Saldo normal mengikuti tingkatan akun paling tinggi</code>
                        <?php }else{ ?>
                            <select name="saldo_normal" id="saldo_normal" class="form-control">
                                <option <?php if($saldo_normal==""){echo "selected";} ?> value="">Pilih</option>
                                <option <?php if($saldo_normal=="Debet"){echo "selected";} ?> value="Debet">Debet</option>
                                <option <?php if($saldo_normal=="Kredit"){echo "selected";} ?> value="Kredit">Kredit</option>
                            </select>
                        <?php } ?>
                        
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
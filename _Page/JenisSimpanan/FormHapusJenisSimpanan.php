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
            $keterangan=GetDetailData($Conn,'simpanan_jenis','id_simpanan_jenis',$id_simpanan_jenis,'keterangan');
            $rutin=GetDetailData($Conn,'simpanan_jenis','id_simpanan_jenis',$id_simpanan_jenis,'rutin');
            //Label Rutin
            if(empty($rutin)){
                $LabelRutin='<span class="text text-danger">Tidak</span>';
            }else{
                $LabelRutin='<span class="text text-success">Rutin</span>';
            }
            if(empty($keterangan)){
                $LabelKeterangan='<span class="text text-danger">-</span>';
            }else{
                $LabelKeterangan=$keterangan;
            }
            //Hitung record simpanan untuk jenis ini
            $jumlah_simpanan=mysqli_num_rows(mysqli_query($Conn, "SELECT*FROM simpanan WHERE id_simpanan_jenis='$id_simpanan_jenis'"));
?>
    <input type="hidden" name="id_simpanan_jenis" value="<?php echo $id_simpanan_jenis; ?>">
    <div class="col-md-12 mb-4">
        <div class="row mb-3">
            <div class="col col-md-4">ID Jenis Simpanan</div>
            <div class="col col-md-8">
                <code class="text text-grayish"><?php echo $id_simpanan_jenis; ?></code>
            </div>
        </div>
        <div class="row mb-3">
            <div class="col col-md-4">Nama Simpanan</div>
            <div class="col col-md-8">
                <code class="text text-grayish"><?php echo $nama_simpanan; ?></code>
            </div>
        </div>
        <div class="row mb-3">
            <div class="col col-md-4">Keterangan</div>
            <div class="col col-md-8">
                <code class="text text-grayish"><?php echo $LabelKeterangan; ?></code>
            </div>
        </div>
        <div class="row">
            <div class="col-md-12">
                <?php
                    if(!empty($jumlah_simpanan)){
                        echo '
                            <div class="alert alert-danger text-center">
                                <h3>Penting!</h3>
                                <p>
                                    <small>
                                        Jenis simpanan ini sudah memiliki record sebanyak '.$jumlah_simpanan.'. 
                                        Apabila anda menghapus jenis simpanan ini maka record simpanan anggota tersebut akan terhapus.
                                    </small>
                                </p>
                            </div>
                        ';
                    }
                ?>
            </div>
        </div>
        <div class="row mb-3">
            <div class="col col-md-12 text-center">
                <code class="text-primary">Apakah Anda Yakin Ingin Menghapus Data Jenis Simpanan Ini?</code>
            </div>
        </div>
    </div>
<?php 
        }
    }
?>
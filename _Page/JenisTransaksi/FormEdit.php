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
        //Tangkap id_transaksi_jenis
        if(empty($_POST['id_transaksi_jenis'])){
            echo '<div class="row">';
            echo '  <div class="col-md-12 mb-3 text-center">';
            echo '      <small class="text-danger">ID Jenis Transaksi Tidak Boleh Kosong!</small>';
            echo '  </div>';
            echo '</div>';
        }else{
            $id_transaksi_jenis=$_POST['id_transaksi_jenis'];
            //Bersihkan Variabel
            $id_transaksi_jenis=validateAndSanitizeInput($id_transaksi_jenis);
            //Buka Informasi
            $nama=GetDetailData($Conn,'transaksi_jenis','id_transaksi_jenis',$id_transaksi_jenis,'nama');
            $kategori=GetDetailData($Conn,'transaksi_jenis','id_transaksi_jenis',$id_transaksi_jenis,'kategori');
            $deskripsi=GetDetailData($Conn,'transaksi_jenis','id_transaksi_jenis',$id_transaksi_jenis,'deskripsi');
            $id_akun_debet=GetDetailData($Conn,'transaksi_jenis','id_transaksi_jenis',$id_transaksi_jenis,'id_akun_debet');
            $id_akun_kredit=GetDetailData($Conn,'transaksi_jenis','id_transaksi_jenis',$id_transaksi_jenis,'id_akun_kredit');
?>
    <input type="hidden" name="id_transaksi_jenis" value="<?php echo "$id_transaksi_jenis"; ?>">
    <div class="row mb-3">
        <div class="col col-md-4">
            <label for="nama_edit">Jenis Transaksi</label>
        </div>
        <div class="col-md-8">
            <input type="text" name="nama" id="nama_edit" class="form-control" value="<?php echo "$nama"; ?>">
            <small class="credit">
                <code class="text text-grayish">
                    Nama jenis transaksi (Ex: Iuran Air dan listrik, Gaji Staf, ATK, Dll)
                </code>
            </small>
        </div>
    </div>
    <div class="row mb-3">
        <div class="col col-md-4">
            <label for="kategori_edit">Kategori</label>
        </div>
        <div class="col-md-8">
            <input type="text" name="kategori" id="kategori_edit" id="list_kategori_edit" class="form-control" value="<?php echo "$kategori"; ?>">
            <datalist id="list_kategori_edit">
                <?php
                    $QryKategori = mysqli_query($Conn, "SELECT DISTINCT kategori FROM transaksi_jenis ORDER BY kategori ASC");
                    while ($DataKategori = mysqli_fetch_array($QryKategori)) {
                        $ListKategori= $DataKategori['kategori'];
                        echo '<option value="'.$ListKategori.'">';
                    }
                ?>
            </datalist>
            <small class="credit">
                <code class="text text-grayish">
                    Kelompok/Group transaksi (Ex: Biaya Operasional, Gaji, Perlengkapan )
                </code>
            </small>
        </div>
    </div>
    <div class="row mb-3">
        <div class="col col-md-4">
            <label for="deskripsi_edit">Deskripsi</label>
        </div>
        <div class="col-md-8">
            <textarea name="deskripsi" id="deskripsi_edit" class="form-control"><?php echo "$deskripsi"; ?></textarea>
            <small class="credit">
                <code class="text text-grayish">
                    Gambaran singkat mengenai transaksi tersebut.
                </code>
            </small>
        </div>
    </div>
    <div class="row mb-3">
        <div class="col col-md-4">
            <label for="id_akun_debet_edit">Akun Perkiraan (Debet)</label>
        </div>
        <div class="col-md-8">
            <select name="id_akun_debet" id="id_akun_debet_edit" class="form-control">
                <option value="">Pilih</option>
                <?php
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
                            if($id_akun_debet==$id_perkiraan){
                                echo '<option selected value="'.$id_perkiraan.'">'.$nama_perkiraan.' ('.$saldo_normal.')</option>';
                            }else{
                                echo '<option value="'.$id_perkiraan.'">'.$nama_perkiraan.' ('.$saldo_normal.')</option>';
                            }
                        }
                    }
                ?>
            </select>
            <small class="credit">
                <code class="text text-grayish">
                    Pengaturan akun perkiraan yang akan digunakan pada lajur debet
                </code>
            </small>
        </div>
    </div>
    <div class="row mb-3">
        <div class="col col-md-4">
            <label for="id_akun_kredit_edit">Akun Perkiraan (Kredit)</label>
        </div>
        <div class="col-md-8">
            <select name="id_akun_kredit" id="id_akun_kredit_edit" class="form-control">
                <option value="">Pilih</option>
                <?php
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
                            if($id_akun_kredit==$id_perkiraan){
                                echo '<option selected value="'.$id_perkiraan.'">'.$nama_perkiraan.' ('.$saldo_normal.')</option>';
                            }else{
                                echo '<option value="'.$id_perkiraan.'">'.$nama_perkiraan.' ('.$saldo_normal.')</option>';
                            }
                        }
                    }
                ?>
            </select>
            <small class="credit">
                <code class="text text-grayish">
                    Pengaturan akun perkiraan yang akan digunakan pada lajur kredit
                </code>
            </small>
        </div>
    </div>
    <div class="row mb-3">
        <div class="col col-md-4"></div>
        <div class="col-md-8">
            <code class="text-primary">Pastikan data yang anda input sudah benar</code>
        </div>
    </div>
<?php 
        }
    }
?>
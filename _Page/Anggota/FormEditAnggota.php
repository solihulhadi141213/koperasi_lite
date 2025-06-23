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
        //Tangkap id_anggota
        if(empty($_POST['id_anggota'])){
            echo '<div class="row">';
            echo '  <div class="col-md-12 mb-3 text-center">';
            echo '      <small class="text-danger">ID Anggota Tidak Boleh Kosong!</small>';
            echo '  </div>';
            echo '</div>';
        }else{
            $id_anggota=$_POST['id_anggota'];
            $id_anggota=validateAndSanitizeInput($id_anggota);
            //Buka Informasi
            $tanggal_masuk=GetDetailData($Conn,'anggota','id_anggota',$id_anggota,'tanggal_masuk');
            $tanggal_keluar=GetDetailData($Conn,'anggota','id_anggota',$id_anggota,'tanggal_keluar');
            $email=GetDetailData($Conn,'anggota','id_anggota',$id_anggota,'email');
            $nip=GetDetailData($Conn,'anggota','id_anggota',$id_anggota,'nip');
            $nama=GetDetailData($Conn,'anggota','id_anggota',$id_anggota,'nama');
            $password=GetDetailData($Conn,'anggota','id_anggota',$id_anggota,'password');
            $kontak=GetDetailData($Conn,'anggota','id_anggota',$id_anggota,'kontak');
            $lembaga=GetDetailData($Conn,'anggota','id_anggota',$id_anggota,'lembaga');
            $ranking=GetDetailData($Conn,'anggota','id_anggota',$id_anggota,'ranking');
            $foto=GetDetailData($Conn,'anggota','id_anggota',$id_anggota,'foto');
            $akses_anggota=GetDetailData($Conn,'anggota','id_anggota',$id_anggota,'akses_anggota');
            $status=GetDetailData($Conn,'anggota','id_anggota',$id_anggota,'status');
            $alasan_keluar=GetDetailData($Conn,'anggota','id_anggota',$id_anggota,'alasan_keluar');
?>
    <input type="hidden" name="id_anggota" value="<?php echo "$id_anggota"; ?>">
    <div class="row mb-3">
        <div class="col col-md-4">
            <label for="nip_edit">Nomor Induk Anggota</label>
        </div>
        <div class="col-md-8">
            <input type="text" name="nip" id="nip_edit" class="form-control" value="<?php echo "$nip"; ?>">
            <small class="credit">
                <code class="text text-grayish">
                    Masukan nomor induk yang unik untuk mewakili data anggota.
                </code>
            </small>
        </div>
    </div>
    <div class="row mb-3">
        <div class="col col-md-4">
            <label for="nama_edit">Nama Lengkap</label>
        </div>
        <div class="col-md-8">
            <input type="text" name="nama" id="nama_edit" class="form-control" value="<?php echo "$nama"; ?>">
        </div>
    </div>
    <div class="row mb-3">
        <div class="col col-md-4">
            <label for="tanggal_masuk_edit">Tanggal Masuk</label>
        </div>
        <div class="col-md-8">
            <input type="date" name="tanggal_masuk" id="tanggal_masuk_edit" class="form-control" value="<?php echo "$tanggal_masuk"; ?>">
        </div>
    </div>
    <div class="row mb-3">
        <div class="col col-md-4">
            <label for="lembaga_edit">Divisi/Unit Kerja</label>
        </div>
        <div class="col-md-8">
            <input type="text" name="lembaga" id="lembaga_edit" class="form-control" list="list_lembaga_edit" value="<?php echo "$lembaga"; ?>">
            <datalist id="list_lembaga_edit">
                <?php
                    $QryLembaga = mysqli_query($Conn, "SELECT DISTINCT lembaga FROM anggota ORDER BY lembaga ASC");
                    while ($DataLembaga = mysqli_fetch_array($QryLembaga)) {
                        $list_lembaga= $DataLembaga['lembaga'];
                        echo '<option value="'.$list_lembaga.'">';
                    }
                ?>
            </datalist>
        </div>
    </div>
    <div class="row mb-3">
        <div class="col col-md-4">
            <label for="ranking_edit">Ranking/Group</label>
        </div>
        <div class="col-md-8">
            <input type="text" name="ranking" id="ranking_edit" class="form-control" placeholder="[0-9]" value="<?php echo "$ranking"; ?>">
        </div>
    </div>
    <div class="row mb-3">
        <div class="col col-md-4">
            <label for="kontak_edit">No.Kontak</label>
        </div>
        <div class="col-md-8">
            <input type="text" name="kontak" id="kontak_edit" class="form-control" placeholder="62" value="<?php echo "$kontak"; ?>">
        </div>
    </div>
    <div class="row mb-3">
        <div class="col col-md-4">
            <label for="email_edit">Email</label>
        </div>
        <div class="col-md-8">
            <input type="email" name="email" id="email_edit" class="form-control" placeholder="email@domain.com" value="<?php echo "$email"; ?>">
            <div class="form-check">
                <input class="form-check-input" <?php if($akses_anggota==1){echo "checked";} ?> type="checkbox" value="Ya" id="akses_anggota_edit" name="akses_anggota">
                <label class="form-check-label" for="akses_anggota_edit">
                    <small>
                        <code class="text-dark">Sertakan akses untuk anggota tersebut</code>
                    </small>
                </label>
            </div>
        </div>
    </div>
    <div class="row mb-3" id="form_password_edit">
        <div class="col col-md-4">
            <label for="password_edit">Password</label>
        </div>
        <div class="col-md-8">
            <input type="password" name="password" id="password_edit" class="form-control" value="<?php echo "$password"; ?>">
            <div class="form-check">
                <input class="form-check-input" type="checkbox" value="Ya" id="tampilkan_password_anggota_edit" name="tampilkan_password_anggota">
                <label class="form-check-label" for="tampilkan_password_anggota_edit">
                    <small>
                        <code class="text-dark">Tampilkan Password</code>
                    </small>
                </label>
            </div>
        </div>
    </div>
    <div class="row mb-3">
        <div class="col col-md-4">
            <label for="status_edit">Status Keanggotaan</label>
        </div>
        <div class="col-md-8">
            <select name="status" id="status_edit" class="form-control">
                <option <?php if($status==""){echo "selected";} ?> value="">Pilih</option>
                <option <?php if($status=="Aktif"){echo "selected";} ?> value="Aktif">Aktif</option>
                <option <?php if($status=="Keluar"){echo "selected";} ?> value="Keluar">Keluar</option>
            </select>
        </div>
    </div>
    <div class="row mb-3" id="form_tanggal_keluar_edit">
        <div class="col col-md-4">
            <label for="tanggal_keluar_edit">Tanggal Keluar</label>
        </div>
        <div class="col-md-8">
            <input type="date" name="tanggal_keluar" id="tanggal_keluar_edit" class="form-control" value="<?php echo "$tanggal_keluar"; ?>">
            <small class="credit">
                <code class="text text-grayish">
                    Diisi hanya apabila anggota sudah keluar
                </code>
            </small>
        </div>
    </div>
    <div class="row mb-3" id="form_alasan_keluar_edit">
        <div class="col col-md-4">
            <label for="alasan_keluar_edit">Alasan Keluar</label>
        </div>
        <div class="col-md-8">
            <textarea name="alasan_keluar" id="alasan_keluar_edit" class="form-control"><?php echo "$alasan_keluar"; ?></textarea>
        </div>
    </div>
    <div class="row mb-3">
        <div class="col col-md-4"></div>
        <div class="col-md-8">
            <code class="text-primary">Pastikan data anggota yang anda input sudah benar</code>
        </div>
    </div>
    <script>
        //Kondisi Pertama Kali
        if($('#akses_anggota_edit').is(':checked')){
            $('#form_password_edit').show();
        }else{
            $('#form_password_edit').hide();
        }
        var status_edit = $('#status_edit').val();
        if(status_edit=="Keluar"){
            $('#form_tanggal_keluar_edit').show();
            $('#form_alasan_keluar_edit').show();
        }else{
            $('#form_tanggal_keluar_edit').hide();
            $('#form_alasan_keluar_edit').hide();
        }
        //Validasi kontak_edit Hanya Boleh Angka
        $('#kontak_edit').keypress(function(event) {
            // Hanya mengizinkan angka (0-9) dan tombol kontrol seperti backspace
            var charCode = (event.which) ? event.which : event.keyCode;
            if (charCode > 31 && (charCode < 48 || charCode > 57)) {
                return false;
            }
            return true;
        });
        //Menampilkan password_edit
        $('#tampilkan_password_anggota_edit').click(function(){
            if($(this).is(':checked')){
                $('#password_edit').attr('type','text');
            }else{
                $('#password_edit').attr('type','password');
            }
        });
        //Menampilkan Form Password Saat form_password_edit bernilai Ya
        $('#akses_anggota_edit').click(function(){
            if($(this).is(':checked')){
                $('#form_password_edit').show();
            }else{
                $('#form_password_edit').hide();
            }
        });
        //Kondisi Ketika Dipilih Status Anggota
        $('#status_edit').change(function(){
            var status_edit = $('#status_edit').val();
            if(status_edit=="Keluar"){
                $('#form_tanggal_keluar_edit').show();
                $('#form_alasan_keluar_edit').show();
            }else{
                $('#form_tanggal_keluar_edit').hide();
                $('#form_alasan_keluar_edit').hide();
            }
        });
    </script>
<?php 
        }
    }
?>
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
            if(empty($foto)){
                $foto="No-Image.PNG";
            }else{
                $foto=GetDetailData($Conn,'anggota','id_anggota',$id_anggota,'foto');
            }
            if($akses_anggota==1){
                $password=GetDetailData($Conn,'anggota','id_anggota',$id_anggota,'password');
            }else{
                $password="-";
            }
            if($status=="Keluar"){
                $strtotime2=strtotime($tanggal_keluar);
                $TanggalKeluar=date('d/m/Y', $strtotime2);
            }else{
                $TanggalKeluar="-";
            }
            //Format Tanggal
            $strtotime1=strtotime($tanggal_masuk);
            //Menampilkan Tanggal
            $TanggalMasuk=date('d/m/Y', $strtotime1);
?>
    <input type="hidden" name="id_anggota" value="<?php echo "$id_anggota"; ?>">
    <div class="row mb-3">
        <div class="col col-md-4">Nomor Induk</div>
        <div class="col col-md-8">
            <code class="text text-grayish"><?php echo $nip; ?></code>
        </div>
    </div>
    <div class="row mb-3">
        <div class="col col-md-4">Nama Lengkap</div>
        <div class="col col-md-8">
            <code class="text text-grayish"><?php echo $nama; ?></code>
        </div>
    </div>
    <div class="row mb-3">
        <div class="col col-md-4">Lembaga</div>
        <div class="col col-md-8">
            <code class="text text-grayish"><?php echo $lembaga; ?></code>
        </div>
    </div>
    <div class="row mb-3">
        <div class="col col-md-4">Ranking</div>
        <div class="col col-md-8">
            <code class="text text-grayish"><?php echo $ranking; ?></code>
        </div>
    </div>
    <div class="row mb-3">
        <div class="col col-md-4">Kontak</div>
        <div class="col col-md-8">
            <code class="text text-grayish"><?php echo $kontak; ?></code>
        </div>
    </div>
    <div class="row mb-3">
        <div class="col col-md-4">Email</div>
        <div class="col col-md-8">
            <code class="text text-grayish"><?php echo $email; ?></code>
        </div>
    </div>
    <div class="row mb-3">
        <div class="col col-md-4">Password</div>
        <div class="col col-md-8">
            <code class="text text-grayish"><?php echo $password; ?></code>
        </div>
    </div>
    <div class="row mb-3">
        <div class="col col-md-4">Status</div>
        <div class="col col-md-8">
            <code class="text text-grayish"><?php echo $status; ?></code>
        </div>
    </div>
    <div class="row mb-3">
        <div class="col col-md-4">Tanggal Masuk</div>
        <div class="col col-md-8">
            <code class="text text-grayish"><?php echo $TanggalMasuk; ?></code>
        </div>
    </div>
    <div class="row mb-3">
        <div class="col col-md-4">Tanggal Keluar</div>
        <div class="col col-md-8">
            <code class="text text-grayish"><?php echo $TanggalKeluar; ?></code>
        </div>
    </div>
    <div class="row mb-3">
        <div class="col col-md-12 text-primary">
            <div class="form-check">
                <input class="form-check-input" type="checkbox" value="Ya" id="hapus_relasi_anggota" name="hapus_relasi_anggota">
                <label class="form-check-label" for="hapus_relasi_anggota">
                    <small>
                        <code class="text-dark">Hapus juga data transaksi anggota bersangkutan</code>
                    </small>
                </label>
            </div>
        </div>
    </div>
    <div class="row mb-3">
        <div class="col col-md-12" id="show_hapus_relasi_anggota">
            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                <small class="credit">
                    Dengan memilih ini maka semua transaksi yang berhubungan dengan anggota bersangkutan akan dihapus dari database.
                </small>
            </div>
        </div>
    </div>
    <div class="row mb-3">
        <div class="col col-md-12 text-primary">
            Apakah anda yakin akan menghapus anggota ini?
        </div>
    </div>
    <script>
        //Kondisi Pertama Kali
        if($('#hapus_relasi_anggota').is(':checked')){
            $('#show_hapus_relasi_anggota').show();
        }else{
            $('#show_hapus_relasi_anggota').hide();
        }
        //Menampilkan show_hapus_relasi_anggota
        $('#hapus_relasi_anggota').click(function(){
            if($('#hapus_relasi_anggota').is(':checked')){
                $('#show_hapus_relasi_anggota').show();
            }else{
                $('#show_hapus_relasi_anggota').hide();
            }
        });
    </script>
<?php 
        }
    }
?>
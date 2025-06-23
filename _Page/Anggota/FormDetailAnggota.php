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
            if(empty($foto)){
                $foto="No-Image.PNG";
            }else{
                $foto=GetDetailData($Conn,'anggota','id_anggota',$id_anggota,'foto');
            }
            if($akses_anggota==1){
                $password=GetDetailData($Conn,'anggota','id_anggota',$id_anggota,'password');
                $password="*****";
            }else{
                $password="-";
            }
            if($status=="Keluar"){
                $strtotime2=strtotime($tanggal_keluar);
                $TanggalKeluar=date('d/m/Y', $strtotime2);
                $LabelStatus='<span class="text-danger">Keluar</span>';
            }else{
                $TanggalKeluar="-";
                $LabelStatus='<span class="text-success">Aktif</span>';
            }
            //Format Tanggal
            $strtotime1=strtotime($tanggal_masuk);
            //Menampilkan Tanggal
            $TanggalMasuk=date('d/m/Y', $strtotime1);
?>
    <input type="hidden" name="Page" value="Anggota">
    <input type="hidden" name="Sub" value="DetailAnggota">
    <input type="hidden" name="id" value="<?php echo $id_anggota; ?>">
    <div class="row mb-3">
        <div class="col-md-12 text-center mb-4">
            <img src="<?php echo $base_url; ?>/assets/img/Anggota/<?php echo $foto; ?>" alt="" width="50%" class="rounded-circle">
        </div>
        <div class="col-md-12 mb-4">
            <div class="row mb-3">
                <div class="col col-4"><small>Nomor Induk</small></div>
                <div class="col col-1"><small>:</small></div>
                <div class="col col-7">
                    <code class="text text-muted"><?php echo $nip; ?></code>
                </div>
            </div>
            <div class="row mb-3">
                <div class="col col-4"><small>Nama Lengkap</small></div>
                <div class="col col-1"><small>:</small></div>
                <div class="col col-7">
                    <code class="text text-muted"><?php echo $nama; ?></code>
                </div>
            </div>
            <div class="row mb-3">
                <div class="col col-4"><small>Tanggal Masuk</small></div>
                <div class="col col-1"><small>:</small></div>
                <div class="col col-7">
                    <code class="text text-muted"><?php echo $TanggalMasuk; ?></code>
                </div>
            </div>
            <div class="row mb-3">
                <div class="col col-4"><small>Divisi/Unit Kerja</small></div>
                <div class="col col-1"><small>:</small></div>
                <div class="col col-7">
                    <code class="text text-muted"><?php echo $lembaga; ?></code>
                </div>
            </div>
            <div class="row mb-3">
                <div class="col col-4"><small>Ranking</small></div>
                <div class="col col-1"><small>:</small></div>
                <div class="col col-7">
                    <code class="text text-muted"><?php echo $ranking; ?></code>
                </div>
            </div>
            <div class="row mb-3">
                <div class="col col-4"><small>Kontak</small></div>
                <div class="col col-1"><small>:</small></div>
                <div class="col col-7">
                    <code class="text text-muted"><?php echo $kontak; ?></code>
                </div>
            </div>
            <div class="row mb-3">
                <div class="col col-4"><small>Email</small></div>
                <div class="col col-1"><small>:</small></div>
                <div class="col col-7">
                    <code class="text text-muted"><?php echo $email; ?></code>
                </div>
            </div>
            <div class="row mb-3">
                <div class="col col-4"><small>Password</small></div>
                <div class="col col-1"><small>:</small></div>
                <div class="col col-7">
                    <code class="text text-muted"><?php echo $password; ?></code>
                </div>
            </div>
            <div class="row mb-3">
                <div class="col col-4"><small>Status</small></div>
                <div class="col col-1"><small>:</small></div>
                <div class="col col-7">
                    <code class="text text-muted"><?php echo $LabelStatus; ?></code>
                </div>
            </div>
            <?php if($status=="Keluar"){ ?>
                <div class="row mb-3 border-1 border-top">
                    <div class="col col-4 mt-3"><small>Tanggal Keluar</small></div>
                    <div class="col col-1"><small>:</small></div>
                    <div class="col col-7 mt-3">
                        <code class="text text-muted"><?php echo $TanggalKeluar; ?></code>
                    </div>
                </div>
                <div class="row mb-3">
                    <div class="col col-4"><small>Alasan Keluar</small></div>
                    <div class="col col-1"><small>:</small></div>
                    <div class="col col-7">
                        <code class="text text-muted"><?php echo $alasan_keluar; ?></code>
                    </div>
                </div>
            <?php } ?>
        </div>
    </div>
<?php 
        }
    }
?>
<?php
    //Koneksi
    date_default_timezone_set('Asia/Jakarta');
    include "../../_Config/Connection.php";
    include "../../_Config/GlobalFunction.php";
    include "../../_Config/SettingGeneral.php";
    include "../../_Config/Session.php";

    //Validasi Sesi Akses
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

            //Buat Variabel
            $id_simpanan_jenis=$_POST['id_simpanan_jenis'];
            $id_simpanan_jenis=validateAndSanitizeInput($id_simpanan_jenis);

            //Buka Informasi
            $nama_simpanan=GetDetailData($Conn,'simpanan_jenis','id_simpanan_jenis',$id_simpanan_jenis,'nama_simpanan');
            $keterangan=GetDetailData($Conn,'simpanan_jenis','id_simpanan_jenis',$id_simpanan_jenis,'keterangan');
            $kategori=GetDetailData($Conn,'simpanan_jenis','id_simpanan_jenis',$id_simpanan_jenis,'kategori');
            $nominal=GetDetailData($Conn,'simpanan_jenis','id_simpanan_jenis',$id_simpanan_jenis,'nominal');
            
            //Label Kategori Simpanan
            if($kategori=="Simpanan Wajib"){
                $LabelKategori='<div class="badge badge-danger">Simpanan Wajib</div>';
            }else{
                if($kategori=="Simpanan Pokok"){
                    $LabelKategori='<div class="badge badge-warning">Simpanan Pokok</div>';
                }else{
                    $LabelKategori='<div class="badge badge-primary">Simpanan Sukarela</div>';
                }
            }
            //Label Nominal
            if(empty($nominal)){
                $LabelNominal='<small class="text-muted">Tidak Ditentukan</small>';
            }else{
                $NominalRp = "Rp " . number_format($nominal,0,',','.');
                $LabelNominal='<small class="text-info">'.$NominalRp.'</small>';
            }
            
            //Hitung Jumlah Total Simpanan Berdasarkan id_simpanan_jenis
            $SumSimpanan = mysqli_fetch_array(mysqli_query($Conn, "SELECT SUM(jumlah) AS total FROM simpanan WHERE id_simpanan_jenis='$id_simpanan_jenis' AND kategori!='Penarikan'"));
            $jumlah_simpanan = $SumSimpanan['total'];
            $jumlah_simpanan_format = "" . number_format($jumlah_simpanan,0,',','.');

            //Menghitung Jumlah Penarikan
            $SumPenarikan = mysqli_fetch_array(mysqli_query($Conn, "SELECT SUM(jumlah) AS total FROM simpanan WHERE id_simpanan_jenis='$id_simpanan_jenis' AND kategori='Penarikan'"));
            $jumlah_penarikan = $SumPenarikan['total'];
            $jumlah_penarikan_format = "" . number_format($jumlah_penarikan,0,',','.');

            //Jumlah Netto Simpanan
            $jumlah_simpanan_netto=$jumlah_simpanan-$jumlah_penarikan;
            $jumlah_simpanan_netto_format = "Rp " . number_format($jumlah_simpanan_netto,0,',','.');

            //Tampilkan
            echo '
                <div class="row mb-3">
                    <div class="col-3"><small>ID Simpanan</small></div>
                    <div class="col-1"><small>:</small></div>
                    <div class="col col-md-8">
                        <code class="text text-grayish">'.$id_simpanan_jenis.'</code>
                    </div>
                </div>
                <div class="row mb-3">
                    <div class="col-3"><small>Kode/Nama</small></div>
                    <div class="col-1"><small>:</small></div>
                    <div class="col col-md-8">
                        <code class="text text-grayish">'.$nama_simpanan.'</code>
                    </div>
                </div>
                <div class="row mb-3">
                    <div class="col-3"><small>Kategori</small></div>
                    <div class="col-1"><small>:</small></div>
                    <div class="col col-md-8">
                        <code class="text text-grayish">'.$LabelKategori.'</code>
                    </div>
                </div>
                <div class="row mb-3">
                    <div class="col-3"><small>Keterangan</small></div>
                    <div class="col-1"><small>:</small></div>
                    <div class="col col-md-8">
                        <code class="text text-grayish">'.$keterangan.'</code>
                    </div>
                </div>
                <div class="row mb-3">
                    <div class="col-3"><small>Netto</small></div>
                    <div class="col-1"><small>:</small></div>
                    <div class="col col-md-8">
                        <code class="text text-grayish">'.$LabelNominal.'</code>
                    </div>
                </div>
            ';
        }
    }
?>
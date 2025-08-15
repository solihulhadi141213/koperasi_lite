<?php
    //Karena Ini Di running Dengan JS maka Panggil Ulang Koneksi
    include "../_Config/Connection.php";
    include "../_Config/GlobalFunction.php";
    include "../_Config/Session.php";
    
    //Notifikasi Untuk Pengurus
    if($SessionModeAkses=="Pengurus"){
        //Menghitung Jumlah Pinjaman Yang Menunggak
        $JumlahNotifikasi=0;

        //Jumlah Pinjaman Tunggakan
        $JumlahPeriodeTagihan=0;
        $query_pinjaman_berjalan = mysqli_query($Conn, "SELECT id_pinjaman, tanggal, periode_angsuran FROM pinjaman WHERE status='Berjalan'");
        while ($data = mysqli_fetch_array($query_pinjaman_berjalan)) {
            $id_pinjaman= $data['id_pinjaman'];
            $tanggal= $data['tanggal'];
            $periode_angsuran= $data['periode_angsuran'];
            
            //Tanggal Sekarang
            $TanggalSekarang=date('Y-m-d');
            for ( $i=1; $i<=$periode_angsuran; $i++ ){
                $GetPeriodePinjaman=date('d/m/Y', strtotime('+'.$i.' month', strtotime($tanggal))); 
                //Ubah Format Tangga
                $GetPeriodePinjaman2=date('Y-m-d', strtotime('+'.$i.' month', strtotime($tanggal))); 
                if($TanggalSekarang>$GetPeriodePinjaman2){
                    //Cek Apakah Sudah Ada Angsuran
                    $QryAngsuran = mysqli_query($Conn,"SELECT id_pinjaman_angsuran FROM pinjaman_angsuran WHERE id_pinjaman='$id_pinjaman' AND tanggal_angsuran='$GetPeriodePinjaman2'")or die(mysqli_error($Conn));
                    $DataAngsuran = mysqli_fetch_array($QryAngsuran);
                    if(empty($DataAngsuran['id_pinjaman_angsuran'])){
                        $JumlahPeriodeTagihan=$JumlahPeriodeTagihan+1;
                    }else{
                        $JumlahPeriodeTagihan=$JumlahPeriodeTagihan+0;
                    }
                }else{
                    $JumlahPeriodeTagihan=$JumlahPeriodeTagihan+0;
                }
            }
        }
        if(!empty($JumlahPeriodeTagihan)){
            $JumlahNotifikasi=1;
        }

        //Hitung Anggota Pending
        $JumlahAnggotaPendding = mysqli_num_rows(mysqli_query($Conn, "SELECT id_anggota FROM anggota WHERE status='Pending'"));
        if(!empty($JumlahAnggotaPendding)){
            $JumlahNotifikasi=$JumlahNotifikasi+1;
        }

        //Hitung Pengajuan Penarikan Dana
        $JumlahPermohonanPenarikan = mysqli_num_rows(mysqli_query($Conn, "SELECT id_simpanan_penarikan FROM simpanan_penarikan WHERE status='Pending'"));
        if(!empty($JumlahPermohonanPenarikan)){
            $JumlahNotifikasi=$JumlahNotifikasi+1;
        }
        
        //Apabila Tidak ada notifgikasi
        if(empty($JumlahNotifikasi)){
            echo '<li class="dropdown-header">';
            echo '  Tidak Ada Data Piinjaman Yang Belum Dibayar';
            echo '</li>';
        }else{
            //Apabila Ada
            echo '<li class="dropdown-header">';
            echo '  Ada '.$JumlahNotifikasi.' pinjaman yang belum dibayar';
            echo '</li>';
            if(!empty($JumlahPeriodeTagihan)){
                echo '<li><hr class="dropdown-divider"></li>';
                echo '<li class="notification-item">';
                echo '  <i class="bi bi-exclamation-circle text-danger"></i>';
                echo '  <div>';
                echo '      <h4><a href="index.php?Page=Tagihan">Tagihan Pinjaman Belum Dibayar</a></h4>';
                echo '      <p>Ada '.$JumlahPeriodeTagihan.' tagihan pinjaman belum dibayar</p>';
                echo '  </div>';
                echo '</li>';
            }

            //Notifikasi Permohonana Pengajuan Anggota
            if(!empty($JumlahAnggotaPendding)){
                echo '<li><hr class="dropdown-divider"></li>';
                echo '<li class="notification-item">';
                echo '  <i class="bi bi-exclamation-circle text-danger"></i>';
                echo '  <div>';
                echo '      <h4><a href="index.php?Page=Anggota">Pengajuan Anggota</a></h4>';
                echo '      <p>Ada '.$JumlahAnggotaPendding.' pengajuan anggota perlu verifikasi</p>';
                echo '  </div>';
                echo '</li>';
            }

            //Notifikasi Pengajuan Penarikan Dana
            if(!empty($JumlahPermohonanPenarikan)){
                echo '<li><hr class="dropdown-divider"></li>';
                echo '<li class="notification-item">';
                echo '  <i class="bi bi-exclamation-circle text-danger"></i>';
                echo '  <div>';
                echo '      <h4><a href="index.php?Page=PenarikanSimpanan">Pengajuan Penarikan Simpanan</a></h4>';
                echo '      <p>Ada '.$JumlahPermohonanPenarikan.' pengajuan penarikan dana simpanan</p>';
                echo '  </div>';
                echo '</li>';
            }
        }
    }else{
        //Menghitung Jumlah Pinjaman Yang Menunggak
        $JumlahNotifikasi=0;
        
        //Jumlah Pinjaman Tunggakan
        $JumlahPeriodeTagihan=0;
        $query_pinjaman_berjalan = mysqli_query($Conn, "SELECT id_pinjaman, id_anggota, tanggal, periode_angsuran FROM pinjaman WHERE status='Berjalan' AND id_anggota='$SessionIdAkses'");
        while ($data = mysqli_fetch_array($query_pinjaman_berjalan)) {
            $id_pinjaman= $data['id_pinjaman'];
            $tanggal= $data['tanggal'];
            $periode_angsuran= $data['periode_angsuran'];
            
            //Tanggal Sekarang
            $TanggalSekarang=date('Y-m-d');
            for ( $i=1; $i<=$periode_angsuran; $i++ ){
                $GetPeriodePinjaman=date('d/m/Y', strtotime('+'.$i.' month', strtotime($tanggal))); 
                //Ubah Format Tangga
                $GetPeriodePinjaman2=date('Y-m-d', strtotime('+'.$i.' month', strtotime($tanggal))); 
                if($TanggalSekarang>$GetPeriodePinjaman2){
                    //Cek Apakah Sudah Ada Angsuran
                    $QryAngsuran = mysqli_query($Conn,"SELECT id_pinjaman_angsuran FROM pinjaman_angsuran WHERE id_pinjaman='$id_pinjaman' AND tanggal_angsuran='$GetPeriodePinjaman2'")or die(mysqli_error($Conn));
                    $DataAngsuran = mysqli_fetch_array($QryAngsuran);
                    if(empty($DataAngsuran['id_pinjaman_angsuran'])){
                        $JumlahPeriodeTagihan=$JumlahPeriodeTagihan+1;
                    }else{
                        $JumlahPeriodeTagihan=$JumlahPeriodeTagihan+0;
                    }
                }else{
                    $JumlahPeriodeTagihan=$JumlahPeriodeTagihan+0;
                }
            }
        }
        if(!empty($JumlahPeriodeTagihan)){
            $JumlahNotifikasi=1;
        }
        //Apabila Tidak ada notifgikasi
        if(empty($JumlahNotifikasi)){
            echo '<li class="dropdown-header">';
            echo '  Tidak Ada Data Piinjaman Yang Belum Dibayar';
            echo '</li>';
        }else{
            //Apabila Ada
            echo '<li class="dropdown-header">';
            echo '  Ada '.$JumlahNotifikasi.' pinjaman yang belum dibayar';
            echo '</li>';
            if(!empty($JumlahPeriodeTagihan)){
                echo '<li><hr class="dropdown-divider"></li>';
                echo '<li class="notification-item">';
                echo '  <i class="bi bi-exclamation-circle text-danger"></i>';
                echo '  <div>';
                echo '      <h4><a href="index.php?Page=Tagihan">Tagihan Pinjaman Belum Dibayar</a></h4>';
                echo '      <p>Ada '.$JumlahPeriodeTagihan.' tagihan pinjaman belum dibayar</p>';
                echo '  </div>';
                echo '</li>';
            }
            
        }
    }
?>
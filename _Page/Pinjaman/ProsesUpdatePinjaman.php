<?php
    //Zona Waktu
    date_default_timezone_set('Asia/Jakarta');

    //Koneksi
    include "../../_Config/Connection.php";
    include "../../_Config/GlobalFunction.php";
    include "../../_Config/SettingGeneral.php";

    //Session AKses
    include "../../_Config/Session.php";

    //Validasi Sesi Akses
    if(empty($SessionIdAkses)){
        echo '
            <div class="alert alert-danger">
                <small>Sesi Akses Sudah Berakhir. Silahkan Login Ulang!</small>
            </div>
        ';
    }else{

        //Validasi id Pinjaman tidak boleh kosong!
        if(empty($_POST['id_pinjaman'])){
            echo '
                <div class="alert alert-danger">
                    <small>ID Pinjaman Tidak Boleh Kosong!</small>
                </div>
            ';
        }else{

            //Validasi status tidak boleh kosong!
             if(empty($_POST['status'])){
                echo '
                    <div class="alert alert-danger">
                        <small>Status Pinjaman Tidak Boleh Kosong!</small>
                    </div>
                ';
            }else{
                
                //Buat Variabel
                $id_pinjaman=$_POST['id_pinjaman'];
                $status=$_POST['status'];

                //Apabila Status Diterima
                if($status=="Diterima"){

                    //Buat Status
                    $status="Berjalan";

                    //Buka Rincian Pinjaman
                    $id_pinjaman_jenis=GetDetailData($Conn, 'pinjaman', 'id_pinjaman', $id_pinjaman, 'id_pinjaman_jenis');
                    $id_anggota=GetDetailData($Conn, 'pinjaman', 'id_pinjaman', $id_pinjaman, 'id_anggota');
                    $jumlah_pinjaman=GetDetailData($Conn, 'pinjaman', 'id_pinjaman', $id_pinjaman, 'jumlah_pinjaman');
                    $angsuran_pokok=GetDetailData($Conn, 'pinjaman', 'id_pinjaman', $id_pinjaman, 'angsuran_pokok');
                    $rp_jasa=GetDetailData($Conn, 'pinjaman', 'id_pinjaman', $id_pinjaman, 'rp_jasa');
                    $angsuran_total=GetDetailData($Conn, 'pinjaman', 'id_pinjaman', $id_pinjaman, 'angsuran_total');
                    $periode_angsuran=GetDetailData($Conn, 'pinjaman', 'id_pinjaman', $id_pinjaman, 'periode_angsuran');

                    //Variabel Lain yang dibutuhkan
                    $tanggal_sekarang=date('Y-m-d');
                    $tanggal_bayar="";
                    $keterlambatan=0;
                    $denda=0;

                    // Looping Dengan Membuat objek DateTime dari tanggal sekarang
                    $tanggal = new DateTime($tanggal_sekarang);
                    $cek_angsuran=0;
                    for ($i = 1; $i <= $periode_angsuran; $i++) {
                        
                        // Tambahkan 1 bulan ke tanggal
                        $tanggal->modify('+1 month');
                        $tanggal_format = $tanggal->format('Y-m-d');

                        //Simpan Data Angsuran
                        $status_angsuran="None";
                        $EntriAngsuran="INSERT INTO pinjaman_angsuran (
                            id_pinjaman,
                            id_anggota,
                            tanggal_angsuran,
                            tanggal_bayar,
                            keterlambatan,
                            pokok,
                            jasa,
                            denda,
                            jumlah,
                            status
                        ) VALUES (
                            '$id_pinjaman',
                            '$id_anggota',
                            '$tanggal_format',
                            '$tanggal_bayar',
                            '$keterlambatan',
                            '$angsuran_pokok',
                            '$rp_jasa',
                            '$denda',
                            '$angsuran_total',
                            '$status_angsuran'
                        )";
                        $InputAngsuran=mysqli_query($Conn, $EntriAngsuran);
                        if($InputAngsuran){
                           $cek_angsuran=$cek_angsuran+1;
                        }else{
                            $cek_angsuran=$cek_angsuran+0;
                        }
                    }

                    //Routing Cek Angsuran
                    if($cek_angsuran==$periode_angsuran){
                        $validasi_proses="Valid";
                    }else{
                        $validasi_proses="Terjadi Kesalahan Ketika Input Angsuran";
                    }
                }else{
                    $validasi_proses="Valid";
                }

                if($validasi_proses=="Valid"){
                    
                    //Jika cek angsuran sama dengan periode lakukan update status
                    $Update = mysqli_query($Conn,"UPDATE pinjaman SET status='$status' WHERE id_pinjaman='$id_pinjaman'") or die(mysqli_error($Conn)); 
                    if($Update){
                        echo '
                            <div class="alert alert-success">
                                <small id="NotifikasiUpdatePinjamanBerhasil">Success</small>
                            </div>
                        ';
                    }else{
                        echo '
                            <div class="alert alert-danger">
                                <small>Terjadi kesalahan pada saat update pinjaman</small>
                            </div>
                        ';
                    }
                }else{
                    echo '
                        <div class="alert alert-danger">
                            <small>'.$validasi_proses.'</small>
                        </div>
                    ';
                }
            }
        }
    }
?>
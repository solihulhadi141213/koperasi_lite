<?php
    //koneksi dan session
    include "../../_Config/Connection.php";
    include "../../_Config/GlobalFunction.php";
    include "../../_Config/Session.php";
    date_default_timezone_set("Asia/Jakarta");
    //Time Now Tmp
    $now=date('Y-m-d H:i:s');

    //Validasi Akses
    if(empty($SessionIdAkses)){
        echo '<div class="alert alert-danger">Sesi Akses Sudah Berakhir, Silahkan Login Ulang</div>';
    }else{
        //Validasi periode_hitung1 tidak boleh kosong
        if(empty($_POST['periode_hitung1'])){
            echo '<div class="alert alert-danger">Periode Hitung Awal Tidak Boleh Kosong!</div>';
        }else{
            //Validasi periode_hitung2 tidak boleh kosong
            if(empty($_POST['periode_hitung2'])){
                echo '<div class="alert alert-danger">Periode Hitung Akhir Tidak Boleh Kosong!</div>';
            }else{
                //Validasi shu tidak boleh kosong
                if(empty($_POST['shu'])){
                    echo '<div class="alert alert-danger">Nilai SHU Tidak Boleh Kosong!</div>';
                }else{

                    //Buat Variabel
                    $shu=validateAndSanitizeInput($_POST['shu']);
                    $periode_hitung1=validateAndSanitizeInput($_POST['periode_hitung1']);
                    $periode_hitung2=validateAndSanitizeInput($_POST['periode_hitung2']);

                    //Validasi Periode Awal dan Akhiir
                    if($periode_hitung1>=$periode_hitung2){
                        echo '<div class="alert alert-danger">Periode awal tidak boleh kurang/sama dengan periode akhir!</div>';
                    }else{
                        if(empty($_POST['persen_penjualan'])){
                            $persen_penjualan=0;
                        }else{
                            $persen_penjualan=validateAndSanitizeInput($_POST['persen_penjualan']);
                        }
                        if(empty($_POST['persen_simpanan'])){
                            $persen_simpanan=0;
                        }else{
                            $persen_simpanan=$_POST['persen_simpanan'];
                            $persen_simpanan=validateAndSanitizeInput($_POST['persen_simpanan']);
                        }
                        if(empty($_POST['persen_pinjaman'])){
                            $persen_pinjaman=0;
                        }else{
                            $persen_pinjaman=validateAndSanitizeInput($_POST['persen_pinjaman']);
                        }
                        //Ubah Format SHU
                        $shu= str_replace(".", "", $shu);
                        $status="Pending";

                        //Validasi Format Nominal
                        if(!preg_match("/^[0-9]*$/", $shu)){
                            echo '<div class="alert alert-danger">Jumlah SHU Hanya Boleh Angka!</div>'; 
                        }else{

                            // Menghitung Total Simpanan Anggota dengan status 'Aktif'
                            $SumTotalSimpanan = mysqli_fetch_array(mysqli_query($Conn, 
                            "SELECT SUM(s.jumlah) AS jumlah FROM simpanan s JOIN anggota a ON s.id_anggota = a.id_anggota WHERE s.tanggal >= '$periode_hitung1' AND s.tanggal <= '$periode_hitung2' 
                            AND s.kategori != 'Penarikan' 
                            AND a.status = 'Aktif'"
                            ));
                            $SimpananTotalBruto = $SumTotalSimpanan['jumlah'] ?? 0;

                            // Menghitung Total Penarikan Anggota dengan status 'Aktif'
                            $SumTotalPenarikan = mysqli_fetch_array(mysqli_query($Conn, 
                            "SELECT SUM(s.jumlah) AS jumlah FROM simpanan s JOIN anggota a ON s.id_anggota = a.id_anggota WHERE s.tanggal >= '$periode_hitung1' AND s.tanggal <= '$periode_hitung2'
                            AND s.kategori = 'Penarikan' 
                            AND a.status = 'Aktif'"
                            ));
                            $JumlahTotalPenarikan = $SumTotalPenarikan['jumlah'] ?? 0;
                            
                            //Simpanan Netto TOTAL
                            $total_simpanan=$SimpananTotalBruto-$JumlahTotalPenarikan;
                            
                            // Jumlah Transaksi 'Penjualan' hanya untuk anggota dengan status 'Aktif'
                            $SumTransaksiPenjualan = mysqli_fetch_array(mysqli_query($Conn, 
                            "SELECT SUM(t.total) AS jumlah 
                            FROM transaksi_jual_beli t
                            JOIN anggota a ON t.id_anggota = a.id_anggota
                            WHERE t.kategori = 'Penjualan' 
                            AND t.tanggal >= '$periode_hitung1' 
                            AND t.tanggal <= '$periode_hitung2' 
                            AND a.status = 'Aktif'"
                            ));
                            $JumlahPenjualan = $SumTransaksiPenjualan['jumlah'] ?? 0;

                            // Jumlah Transaksi 'Retur Penjualan' hanya untuk anggota dengan status 'Aktif'
                            $SumTransaksiReturPenjualan = mysqli_fetch_array(mysqli_query($Conn, 
                            "SELECT SUM(t.total) AS jumlah 
                            FROM transaksi_jual_beli t
                            JOIN anggota a ON t.id_anggota = a.id_anggota
                            WHERE t.kategori = 'Retur Penjualan' 
                            AND t.tanggal >= '$periode_hitung1' 
                            AND t.tanggal <= '$periode_hitung2' 
                            AND a.status = 'Aktif'"
                            ));
                            $JumlahReturPenjualan = $SumTransaksiReturPenjualan['jumlah'] ?? 0;

                            // Total Penjualan (Penjualan - Retur)
                            $total_penjualan = $JumlahPenjualan - $JumlahReturPenjualan;

                            // Menghitung total pinjaman hanya untuk anggota dengan status 'Aktif'
                            $sum_pinjaman = mysqli_fetch_array(mysqli_query($Conn, 
                            "SELECT SUM(p.jumlah_pinjaman) AS jumlah 
                            FROM pinjaman p
                            JOIN anggota a ON p.id_anggota = a.id_anggota
                            WHERE p.tanggal >= '$periode_hitung1' 
                            AND p.tanggal <= '$periode_hitung2' 
                            AND a.status = 'Aktif'"
                            ));

                            $total_pinjaman = $sum_pinjaman['jumlah'] ?? 0;

                            //Buat UUID
                            $uuid_shu_session=generateRandomString(36);
                            
                            //Input Data Session SHU
                            $EntrySession="INSERT INTO shu_session (
                                uuid_shu_session,
                                periode_hitung1,
                                periode_hitung2,
                                total_penjualan,
                                total_simpanan,
                                total_pinjaman,
                                persen_penjualan,
                                persen_simpanan,
                                persen_pinjaman,
                                shu,
                                status
                            ) VALUES (
                                '$uuid_shu_session',
                                '$periode_hitung1',
                                '$periode_hitung2',
                                '$total_penjualan',
                                '$total_simpanan',
                                '$total_pinjaman',
                                '$persen_penjualan',
                                '$persen_simpanan',
                                '$persen_pinjaman',
                                '$shu',
                                '$status'
                            )";
                            $InputSession=mysqli_query($Conn, $EntrySession);
                            if($InputSession){
                                //Simpan Log
                                $kategori_log="SHU";
                                $deskripsi_log="Tambah SHU";
                                $InputLog=addLog($Conn,$SessionIdAkses,$now,$kategori_log,$deskripsi_log);
                                if($InputLog=="Success"){
                                    echo '<div class="alert alert-success"><small id="NotifikasiTambahBagiHasilBerhasil">Success</small></div>'; 
                                }else{
                                    echo '<div class="alert alert-danger">Terjadi kesalahan pada saat menyimpan log aktivitas!</div>'; 
                                }
                            }
                        }
                    }
                }
            }
        }
    }
?>
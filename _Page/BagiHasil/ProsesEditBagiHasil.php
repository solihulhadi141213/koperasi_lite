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
                    //Validasi id_shu_session tidak boleh kosong
                    if(empty($_POST['id_shu_session'])){
                        echo '<div class="alert alert-danger">ID SHU Tidak Boleh Kosong!</div>';
                    }else{

                        //Buat Variabel
                        $id_shu_session=validateAndSanitizeInput($_POST['id_shu_session']);
                        $shu=validateAndSanitizeInput($_POST['shu']);
                        $periode_hitung1=validateAndSanitizeInput($_POST['periode_hitung1']);
                        $periode_hitung2=validateAndSanitizeInput($_POST['periode_hitung2']);

                        //validasi periode SHU
                        if($periode_hitung1>=$periode_hitung2){
                            echo '<div class="alert alert-danger">Periode Awal Tidak Boleh Lebih Besar/Sama Dengan Periode Akhir</div>';
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

                                //Menghitung Simpanan Anggota
                                $SumTotalSimpanan = mysqli_fetch_array(mysqli_query($Conn, "SELECT SUM(jumlah) AS jumlah FROM simpanan WHERE tanggal<='$periode_hitung2' AND kategori!='Penarikan'"));
                                $SimpananTotalBruto = $SumTotalSimpanan['jumlah'];
                                
                                //Hitung Total Penarikan Anggota
                                $SumTotalPenarikan = mysqli_fetch_array(mysqli_query($Conn, "SELECT SUM(jumlah) AS jumlah FROM simpanan WHERE tanggal<='$periode_hitung2' AND kategori='Penarikan'"));
                                $JumlahTotalPenarikan = $SumTotalPenarikan['jumlah'];
                                
                                //Simpanan Netto TOTAL
                                $total_simpanan=$SimpananTotalBruto-$JumlahTotalPenarikan;
                                
                                //Jumlah Transaksi 'Penjualan'
                                $SumTransaksiPenjualan= mysqli_fetch_array(mysqli_query($Conn, "SELECT SUM(total) AS jumlah FROM transaksi_jual_beli WHERE kategori='Penjualan' AND tanggal>='$periode_hitung1' AND tanggal<='$periode_hitung2' AND id_anggota!=''"));
                                if(!empty($SumTransaksiPenjualan['jumlah'])){
                                    $JumlahPenjualan = $SumTransaksiPenjualan['jumlah'];
                                }else{
                                    $JumlahPenjualan =0;
                                }

                                //Jumlah Transaksi Retur Penjualan
                                $SumTransaksiReturPenjualan= mysqli_fetch_array(mysqli_query($Conn, "SELECT SUM(total) AS jumlah FROM transaksi_jual_beli WHERE kategori='Retur Penjualan' AND tanggal>='$periode_hitung1' AND tanggal<='$periode_hitung2' AND id_anggota!=''"));
                                if(!empty($SumTransaksiReturPenjualan['jumlah'])){
                                    $JumlahReturPenjualan = $SumTransaksiReturPenjualan['jumlah'];
                                }else{
                                    $JumlahReturPenjualan =0;
                                }

                                $total_penjualan=$JumlahPenjualan-$JumlahReturPenjualan;

                                //Pinjaman
                                $sum_pinjaman= mysqli_fetch_array(mysqli_query($Conn, "SELECT SUM(jumlah_pinjaman) AS jumlah FROM pinjaman WHERE tanggal>='$periode_hitung1' AND tanggal<='$periode_hitung2'"));
                                if(!empty($sum_pinjaman['jumlah'])){
                                    $total_pinjaman = $sum_pinjaman['jumlah'];
                                }else{
                                    $total_pinjaman =0;
                                }
                                
                                // Query menggunakan Prepared Statement
                                $query = "UPDATE shu_session SET 
                                    periode_hitung1 = ?, 
                                    periode_hitung2 = ?, 
                                    total_penjualan = ?, 
                                    total_simpanan = ?, 
                                    total_pinjaman = ?, 
                                    persen_penjualan = ?, 
                                    persen_simpanan = ?, 
                                    persen_pinjaman = ?, 
                                    shu = ?
                                WHERE id_shu_session = ?";

                                // Persiapkan query
                                $stmt = mysqli_prepare($Conn, $query);

                                if (!$stmt) {
                                    $error=mysqli_error($Conn);
                                    echo '<div class="alert alert-danger">Gagal menyiapkan statement!.<br> Keterangan : '.$error.'</div>'; 
                                }else{

                                    // Bind parameter (s: string, d: double/float, i: integer)
                                    mysqli_stmt_bind_param($stmt, "ssdddddddi", 
                                        $periode_hitung1, 
                                        $periode_hitung2, 
                                        $total_penjualan, 
                                        $total_simpanan, 
                                        $total_pinjaman, 
                                        $persen_penjualan, 
                                        $persen_simpanan, 
                                        $persen_pinjaman, 
                                        $shu, 
                                        $id_shu_session
                                    );

                                    // Eksekusi query
                                    if (mysqli_stmt_execute($stmt)) {
                                        //Simpan Log
                                        $kategori_log="SHU";
                                        $deskripsi_log="Edit SHU";
                                        $InputLog=addLog($Conn,$SessionIdAkses,$now,$kategori_log,$deskripsi_log);
                                        if($InputLog=="Success"){
                                            echo '<div class="alert alert-success"><small id="NotifikasiEditBagiHasilBerhasil">Success</small></div>'; 
                                        }else{
                                            echo '<div class="alert alert-danger">Terjadi kesalahan pada saat menyimpan log aktivitas!</div>'; 
                                        }
                                    } else {
                                        $error=mysqli_stmt_error($stmt);
                                        echo '<div class="alert alert-danger">Terjadi kesalahan pada saat memperbaharui data.<br> Keterangan : '.$error.'</div>'; 
                                    }
                                }
                                // Tutup statement
                                mysqli_stmt_close($stmt);
                            }
                        }
                    }
                }
            }
        }
    }
?>
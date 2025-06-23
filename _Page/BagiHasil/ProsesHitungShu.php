<?php
    //Koneksi
    date_default_timezone_set('Asia/Jakarta');
    include "../../_Config/Connection.php";
    include "../../_Config/GlobalFunction.php";
    include "../../_Config/SettingGeneral.php";
    include "../../_Config/Session.php";

    // Default Response
    $response = [
        "status" => "Error",
        "message" => "Belum ada proses yang dilakukan pada sistem."
    ];
    //Validasi Sesi
    if(empty($SessionIdAkses)){
        $response = [
            "status" => "Error",
            "message" => "Sesi akses sudah berakhir. Silahkan Login Ulang!"
        ];
    }else{
        if(empty($_POST['id_shu_session'])){
            $response = [
                "status" => "Error",
                "message" => "ID SHU tidak boleh kosong!"
            ];
        }else{
            if(empty($_POST['batas'])){
                $response = [
                    "status" => "Error",
                    "message" => "Batas/Limit data perhitungan tidak boleh kosong!"
                ];
            }else{
                if(empty($_POST['page'])){
                    $response = [
                        "status" => "Error",
                        "message" => "Halaman/page data perhitungan tidak boleh kosong!"
                    ];
                }else{
                    $id_shu_session=$_POST['id_shu_session'];
                    $batas=$_POST['batas'];
                    $page=$_POST['page'];

                    //Menghitung jumlah anggota aktif
                    $jumlah_anggota_aktif=mysqli_num_rows(mysqli_query($Conn, "SELECT id_anggota FROM anggota WHERE status='Aktif'"));
                    if(empty($jumlah_anggota_aktif)){
                        $response = [
                            "status" => "Error",
                            "message" => "Tidak ditemukan data anggota yang aktif!"
                        ];
                    }else{
                        //Mencari posisi
                        $posisi = ( $page - 1 ) * $batas;

                        //Menghitung jumlah halaman
                        $jumlah_halaman=ceil($jumlah_anggota_aktif/$batas); 

                        //Apabila Jumlah Halaman sama dengan halaman (page) maka selesai
                        if($jumlah_halaman<$page){
                            $response = [
                                "status" => "Selesai",
                                "message" => "Data Selesai"
                            ];
                        }else{
                            //Buka periode perhitungan SHU
                            $QryShu = $Conn->prepare("SELECT * FROM shu_session WHERE id_shu_session = ?");
                            $QryShu->bind_param("i", $id_shu_session);
                            if (!$QryShu->execute()) {
                                $error=$Conn->error;
                                $response = [
                                    "status" => "Error",
                                    "message" => "Terjadi kesalahan pada saat menampilkan data sesi SHU <br> Keterangan : '.$error.'"
                                ];
                            }else{
                                $Result = $QryShu->get_result();
                                $Data = $Result->fetch_assoc();

                                //Apabila Data Tidak Ditemukan
                                if(empty($Data['id_shu_session'])){
                                    $response = [
                                        "status" => "Error",
                                        "message" => "Data Sesi SHU tidak ditemukan!"
                                    ];
                                }else{

                                    //Buat Variabel SHU Session
                                    $periode_hitung1=$Data['periode_hitung1'];
                                    $periode_hitung2=$Data['periode_hitung2'];
                                    $total_penjualan=$Data['total_penjualan'];
                                    $total_simpanan=$Data['total_simpanan'];
                                    $total_pinjaman=$Data['total_pinjaman'];
                                    $persen_penjualan=$Data['persen_penjualan'];
                                    $persen_simpanan=$Data['persen_simpanan'];
                                    $persen_pinjaman=$Data['persen_pinjaman'];
                                    $shu=$Data['shu'];
                                    $status=$Data['status'];
                            
                                    //Hapus Data rincian sebelumnya Apabila halaman 1 (Baru dimulai)
                                    if($page=="1"){
                                        $HapusRincian= mysqli_query($Conn, "DELETE FROM shu_rincian WHERE id_shu_session='$id_shu_session'") or die(mysqli_error($Conn));
                                    }

                                    //Tampilkan data anggota
                                    $query = mysqli_query($Conn, "SELECT*FROM anggota WHERE status='Aktif' LIMIT $posisi, $batas");
                                    while ($data = mysqli_fetch_array($query)) {
                                        $id_anggota= $data['id_anggota'];
                                        $nip= $data['nip'];
                                        $nama_anggota= $data['nama'];
                                        
                                        //Hitung Penjualan, Pinjaman, dan Simpanan
                                        
                                        //Penjualan = Penjualan-Retur Penjualan
                                        $SumPenjualanAnggotaLunas = mysqli_fetch_array(mysqli_query($Conn, "SELECT SUM(total) AS jumlah FROM transaksi_jual_beli WHERE id_anggota='$id_anggota' AND kategori='Penjualan' AND tanggal>='$periode_hitung1' AND tanggal<='$periode_hitung2'"));
                                        $JumlahPenjualanAnggotaLunas = isset($SumPenjualanAnggotaLunas['jumlah']) ? $SumPenjualanAnggotaLunas['jumlah'] : 0;

                                        $SumPenjualanAnggotaRetur = mysqli_fetch_array(mysqli_query($Conn, "SELECT SUM(total) AS jumlah FROM transaksi_jual_beli WHERE id_anggota='$id_anggota' AND kategori='Retur Penjualan' AND tanggal>='$periode_hitung1' AND tanggal<='$periode_hitung2'"));
                                        $JumlahPenjualanAnggotaRetur = $SumPenjualanAnggotaRetur['jumlah'];

                                        $penjualan=$JumlahPenjualanAnggotaLunas-$JumlahPenjualanAnggotaRetur;

                                        //Simpanan= Simpanan-Penarikan
                                        $SumSimpanan = mysqli_fetch_array(mysqli_query($Conn, "SELECT SUM(jumlah) AS jumlah FROM simpanan WHERE id_anggota='$id_anggota' AND kategori!='Penarikan' AND tanggal>='$periode_hitung1' AND tanggal<='$periode_hitung2'"));
                                        $JumlahSimpanan = isset($SumSimpanan['jumlah']) ? $SumSimpanan['jumlah'] : 0;

                                        $SumPenarikan = mysqli_fetch_array(mysqli_query($Conn, "SELECT SUM(jumlah) AS jumlah FROM simpanan WHERE id_anggota='$id_anggota' AND kategori='Penarikan' AND tanggal>='$periode_hitung1' AND tanggal<='$periode_hitung2'"));
                                        $JumlahPenarikan = isset($SumPenarikan['jumlah']) ? $SumPenarikan['jumlah'] : 0;

                                        $simpanan=$JumlahSimpanan-$JumlahPenarikan;

                                        //Pinjaman (Tidak Dihitung Angsurannya)
                                        $SumPinjaman = mysqli_fetch_array(mysqli_query($Conn, "SELECT SUM(jumlah_pinjaman) AS jumlah FROM pinjaman WHERE id_anggota='$id_anggota' AND tanggal>='$periode_hitung1' AND tanggal<='$periode_hitung2'"));
                                        $pinjaman = isset($SumPinjaman['jumlah']) ? $SumPinjaman['jumlah'] : 0;

                                        $jasa_simpanan = ($total_simpanan > 0) ? ($simpanan / $total_simpanan) * (($persen_simpanan / 100) * $shu) : 0;
                                        $jasa_pinjaman = ($total_pinjaman > 0) ? ($pinjaman / $total_pinjaman) * (($persen_pinjaman / 100) * $shu) : 0;
                                        $jasa_penjualan = ($total_penjualan > 0) ? ($penjualan / $total_penjualan) * (($persen_penjualan / 100) * $shu) : 0;
                                        $total_shu=$jasa_simpanan+$jasa_pinjaman+$jasa_penjualan;
                                        
                                        // Gunakan prepared statement untuk menghindari SQL Injection
                                        $EntryData = "INSERT INTO shu_rincian (
                                            id_shu_session,
                                            id_anggota,
                                            nama_anggota,
                                            nip,
                                            simpanan,
                                            pinjaman,
                                            penjualan,
                                            jasa_simpanan,
                                            jasa_pinjaman,
                                            jasa_penjualan,
                                            shu
                                        ) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";

                                        if ($stmt = mysqli_prepare($Conn, $EntryData)) {
                                            // Bind parameter sesuai dengan tipe datanya
                                            mysqli_stmt_bind_param($stmt, "iisssssssss", 
                                                $id_shu_session,
                                                $id_anggota,
                                                $nama_anggota,
                                                $nip,
                                                $simpanan,
                                                $pinjaman,
                                                $penjualan,
                                                $jasa_simpanan,
                                                $jasa_pinjaman,
                                                $jasa_penjualan,
                                                $total_shu
                                            );

                                            // Eksekusi statement
                                            if (mysqli_stmt_execute($stmt)) {
                                                $row_data_now=$page+1;
                                                $response = [
                                                    "status" => "Success",
                                                    "page_now" => $page,
                                                    "row_data_now" => $row_data_now,
                                                    "count_data" => $jumlah_anggota_aktif
                                                ];
                                            } else {
                                                $error=mysqli_error($Conn);
                                                $response = [
                                                    "status" => "Error",
                                                    "message" => "Proses Dihentikan Karena Terjadii Kesalahan Pada Saat Input Data Rincian<br>Keterangan : $error"
                                                ];
                                            }

                                        } else {
                                            $error=mysqli_error($Conn);
                                            $response = [
                                                "status" => "Error",
                                                "message" => "Proses Dihentikan Karena Terjadii Kesalahan Pada Saat Input Data Rincian<br>Keterangan : $error"
                                            ];
                                        }
                                        mysqli_stmt_close($stmt);
                                        mysqli_close($Conn);
                                    }
                                }
                            }
                        }
                    }
                }
            }
        }
    }

    // Output JSON Response
    echo json_encode($response);
?>
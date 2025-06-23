<?php
    //Koneksi
    include "../../_Config/Connection.php";
    include "../../_Config/GlobalFunction.php";
    include "../../_Config/Session.php";
    //Menangkap Data
    if(empty($SessionIdAkses)){
        echo '<code class="text-danger">Sesi Akses Sudah Berakhir, Silahkan Login Ulang</code>';
    }else{
        if(empty($_POST['id_anggota'])){
            echo '<code class="text-danger">ID Anggota Tidak Boleh Kosong!!</code>';
        }else{
            if(empty($_POST['id_pinjaman'])){
                echo '<code class="text-danger">ID Pinjaman Tidak Boleh Kosong!!</code>';
            }else{
                if(empty($_POST['tanggal_angsuran'])){
                    echo '<code class="text-danger">Tanggal Angsuran Tidak Boleh Kosong!!</code>';
                }else{
                    if(empty($_POST['tanggal_bayar'])){
                        echo '<code class="text-danger">Tanggal Bayar Tidak Boleh Kosong!!</code>';
                    }else{
                        if(empty($_POST['pokok'])){
                            echo '<code class="text-danger">Angsuran Pokok Tidak Boleh Kosong</code>';
                        }else{
                            if(empty($_POST['jumlah'])){
                                echo '<code class="text-danger">Jumlah Angsuran Tidak Boleh Kosong!!</code>';
                            }else{
                                $id_anggota=$_POST['id_anggota'];
                                $id_pinjaman=$_POST['id_pinjaman'];
                                $tanggal_angsuran=$_POST['tanggal_angsuran'];
                                $tanggal_bayar=$_POST['tanggal_bayar'];
                                $pokok=$_POST['pokok'];
                                $jumlah=$_POST['jumlah'];
                                //Tangkap Data Lain Yang Tidak Wajib
                                if(empty($_POST['jasa'])){
                                    $jasa=0;
                                }else{
                                    $jasa=$_POST['jasa'];
                                }
                                if(empty($_POST['keterlambatan'])){
                                    $keterlambatan=0;
                                }else{
                                    $keterlambatan=$_POST['keterlambatan'];
                                }
                                if(empty($_POST['rp_denda'])){
                                    $rp_denda=0;
                                }else{
                                    $rp_denda=$_POST['rp_denda'];
                                }
                                if(empty($_POST['denda'])){
                                    $denda=0;
                                }else{
                                    $denda=$_POST['denda'];
                                }
                                $pokok= str_replace(",", "", $pokok);
                                $jasa= str_replace(",", "", $jasa);
                                $jumlah= str_replace(",", "", $jumlah);
                                $rp_denda= str_replace(",", "", $rp_denda);
                                $denda= str_replace(",", "", $denda);
                                //Bersihkan Variabel
                                $id_anggota=validateAndSanitizeInput($id_anggota);
                                $id_pinjaman=validateAndSanitizeInput($id_pinjaman);
                                $tanggal_angsuran=validateAndSanitizeInput($tanggal_angsuran);
                                $tanggal_bayar=validateAndSanitizeInput($tanggal_bayar);
                                $pokok=validateAndSanitizeInput($pokok);
                                $jasa=validateAndSanitizeInput($jasa);
                                $jumlah=validateAndSanitizeInput($jumlah);
                                $keterlambatan=validateAndSanitizeInput($keterlambatan);
                                $rp_denda=validateAndSanitizeInput($rp_denda);
                                $denda=validateAndSanitizeInput($denda);
                                //Validasi Hanya Boleh Angka
                                if(!preg_match("/^[0-9]*$/", $id_anggota)){
                                    echo '<code class="text-danger">ID Anggota Hanya Boleh Angka</code>';
                                }else{
                                    if(!preg_match("/^[0-9]*$/", $id_pinjaman)){
                                        echo '<code class="text-danger">ID Pinjaman Hanya Boleh Angka</code>';
                                    }else{
                                        if(!preg_match("/^[0-9]*$/", $pokok)){
                                            echo '<code class="text-danger">Angsuran Pokok Hanya Boleh Angka</code>';
                                        }else{
                                            if(!preg_match("/^[0-9]*$/", $jumlah)){
                                                echo '<code class="text-danger">Jumlah Angsuran Hanya Boleh Angka</code>';
                                            }else{
                                                if(!preg_match("/^[0-9]*$/", $keterlambatan)){
                                                    echo '<code class="text-danger">Jumlah Keterlambatan Hanya Boleh Angka</code>';
                                                }else{
                                                    if(!preg_match("/^[0-9]*$/", $rp_denda)){
                                                        echo '<code class="text-danger">Nilai Denda Hanya Boleh Angka</code>';
                                                    }else{
                                                        if(!preg_match("/^[0-9]*$/", $denda)){
                                                            echo '<code class="text-danger">Jumlah Denda Hanya Boleh Angka</code>';
                                                        }else{
                                                            if(!preg_match("/^[0-9]*$/", $jasa)){
                                                                echo '<code class="text-danger">Jumlah Jasa Hanya Boleh Angka</code>';
                                                            }else{
                                                                //Validasi Duplikasi Data
                                                                $ValidasiDataDuplikat= mysqli_num_rows(mysqli_query($Conn, "SELECT*FROM pinjaman_angsuran WHERE id_pinjaman='$id_pinjaman' AND tanggal_angsuran='$tanggal_angsuran'"));
                                                                if(!empty($ValidasiDataDuplikat)){
                                                                    echo '<code class="text-danger">Data Angsuran Untuk Periode Tersebut Saudah Ada</code>';
                                                                }else{

                                                                    //Buat UUID
                                                                    $uuid_angsuran=generateUuidV1();
                                                                    //Melakukan input data
                                                                    $EntryAngsuran="INSERT INTO pinjaman_angsuran (
                                                                        uuid_angsuran,
                                                                        id_pinjaman,
                                                                        id_anggota,
                                                                        tanggal_angsuran,
                                                                        tanggal_bayar,
                                                                        keterlambatan,
                                                                        pokok,
                                                                        jasa,
                                                                        denda,
                                                                        jumlah
                                                                    ) VALUES (
                                                                        '$uuid_angsuran',
                                                                        '$id_pinjaman',
                                                                        '$id_anggota',
                                                                        '$tanggal_angsuran',
                                                                        '$tanggal_bayar',
                                                                        '$keterlambatan',
                                                                        '$pokok',
                                                                        '$jasa',
                                                                        '$denda',
                                                                        '$jumlah'
                                                                    )";
                                                                    $InputAngsuran=mysqli_query($Conn, $EntryAngsuran);
                                                                    if($InputAngsuran){
                                                                       //Hitung Jumlah Periode Angsuran
                                                                        $periode_angsuran=GetDetailData($Conn,'pinjaman','id_pinjaman',$id_pinjaman,'periode_angsuran');
                                                                        //Hitung Angsuran Yang Sudah Masuk
                                                                        $JumlahAngsuranMasuk = mysqli_num_rows(mysqli_query($Conn, "SELECT * FROM pinjaman_angsuran WHERE id_pinjaman='$id_pinjaman'"));
                                                                        //Apabila periode_angsuran sama dengan jumlah angsuran masuk maka update pinjaman menjadi Lunas
                                                                        if($periode_angsuran==$JumlahAngsuranMasuk){
                                                                            //Update Pinjaman
                                                                            $UpdatePinjaman = mysqli_query($Conn,"UPDATE pinjaman SET 
                                                                                status='Lunas'
                                                                            WHERE id_pinjaman='$id_pinjaman'") or die(mysqli_error($Conn)); 
                                                                            if($UpdatePinjaman){
                                                                                echo '<div class="text-success" id="NotifikasiTambahAngsuranBerhasil">Success</div>';
                                                                            }else{
                                                                                echo '<div class="text-danger">Terjadi kesalahan pada saat menyimpan data angsuran!!</div>';
                                                                            }
                                                                        }else{
                                                                            echo '<div class="text-success" id="NotifikasiTambahAngsuranBerhasil">Success</div>';
                                                                        }
                                                                    }else{
                                                                        echo '<div class="text-danger">Terjadi kesalahan pada saat menyimpan data angsuran!!</div>';
                                                                    }
                                                                }
                                                            }
                                                        }
                                                    }
                                                }
                                            }
                                        }
                                    }
                                }
                            }
                        }
                    }
                }
            }
        }
    }
?>
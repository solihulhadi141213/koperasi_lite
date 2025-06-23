<?php
    //Koneksi
    include "../../_Config/Connection.php";
    include "../../_Config/GlobalFunction.php";
    include "../../_Config/Session.php";
    date_default_timezone_set('Asia/Jakarta');
    //Time Now Tmp
    $now=date('Y-m-d H:i:s');
    if(empty($SessionIdAkses)){
        echo '<div class="alert alert-danger">Sesi Akses Sudah Berakhir, Silahkan Login Ulang</div>';
    }else{
        //Validasi debet_penjualan tidak boleh kosong
        if(empty($_POST['debet_penjualan'])){
            echo '<div class="alert alert-danger">Debet Penjualan Tidak Boleh Kosong</div>';
        }else{
            //Validasi kredit_penjualan tidak boleh kosong
            if(empty($_POST['kredit_penjualan'])){
                echo '<div class="alert alert-danger">Kredit Penjualan Tidak Boleh Kosong</div>';
            }else{
                //Validasi hpp_penjualan tidak boleh kosong
                if(empty($_POST['hpp_penjualan'])){
                    echo '<div class="alert alert-danger">HPP Penjualan Tidak Boleh Kosong</div>';
                }else{
                     //Validasi persediaan_penjualan tidak boleh kosong
                    if(empty($_POST['persediaan_penjualan'])){
                        echo '<div class="alert alert-danger">Persediaan Barang Tidak Boleh Kosong</div>';
                    }else{
                        //Validasi debet_pembelian tidak boleh kosong
                        if(empty($_POST['debet_pembelian'])){
                            echo '<div class="alert alert-danger">Debet Pembelian Tidak Boleh Kosong</div>';
                        }else{
                            //Validasi kredit_pembelian tidak boleh kosong
                            if(empty($_POST['kredit_pembelian'])){
                                echo '<div class="alert alert-danger">Kredit Pembelian Tidak Boleh Kosong</div>';
                            }else{
                                //Validasi utang_piutang_penjualan tidak boleh kosong
                                if(empty($_POST['utang_piutang_penjualan'])){
                                    echo '<div class="alert alert-danger">Piutang Penjualan Tidak Boleh Kosong</div>';
                                }else{
                                    //Validasi utang_piutang_pembelian tidak boleh kosong
                                    if(empty($_POST['utang_piutang_pembelian'])){
                                        echo '<div class="alert alert-danger">Utang Pembelian Tidak Boleh Kosong</div>';
                                    }else{
                                        //Buat Variabel
                                        $debet_penjualan=$_POST['debet_penjualan'];
                                        $kredit_penjualan=$_POST['kredit_penjualan'];
                                        $hpp_penjualan=$_POST['hpp_penjualan'];
                                        $persediaan_penjualan=$_POST['persediaan_penjualan'];
                                        $debet_pembelian=$_POST['debet_pembelian'];
                                        $kredit_pembelian=$_POST['kredit_pembelian'];
                                        $utang_piutang_penjualan=$_POST['utang_piutang_penjualan'];
                                        $utang_piutang_pembelian=$_POST['utang_piutang_pembelian'];

                                        //Berssihkan Variabel
                                        $debet_penjualan = validateAndSanitizeInput($_POST['debet_penjualan']);
                                        $kredit_penjualan = validateAndSanitizeInput($_POST['kredit_penjualan']);
                                        $hpp_penjualan = validateAndSanitizeInput($_POST['hpp_penjualan']);
                                        $persediaan_penjualan = validateAndSanitizeInput($_POST['persediaan_penjualan']);
                                        $debet_pembelian = validateAndSanitizeInput($_POST['debet_pembelian']);
                                        $kredit_pembelian = validateAndSanitizeInput($_POST['kredit_pembelian']);
                                        $utang_piutang_penjualan = validateAndSanitizeInput($_POST['utang_piutang_penjualan']);
                                        $utang_piutang_pembelian = validateAndSanitizeInput($_POST['utang_piutang_pembelian']);

                                        //Cek Keberadaan Data
                                        $id_autojurnal_penjualan=GetDetailData($Conn,'setting_autojurnal_jual_beli','kategori','Penjualan','id_autojurnal_jual_beli');
                                        $id_autojurnal_pembelian=GetDetailData($Conn,'setting_autojurnal_jual_beli','kategori','Pembelian','id_autojurnal_jual_beli');

                                        //Apabila Autojurnal Penjualan Belum Ada maka insert
                                        if(empty($id_autojurnal_penjualan)){
                                            $EntryAutoJurnalPenjualan="INSERT INTO setting_autojurnal_jual_beli (
                                                kategori,
                                                debet,
                                                kredit,
                                                hpp,
                                                persediaan,
                                                utang_piutang
                                            ) VALUES (
                                                'Penjualan',
                                                '$debet_penjualan',
                                                '$kredit_penjualan',
                                                '$hpp_penjualan',
                                                '$persediaan_penjualan',
                                                '$utang_piutang_penjualan'
                                            )";
                                            $InputAutoJurnalPenjualan=mysqli_query($Conn, $EntryAutoJurnalPenjualan);
                                            if($InputAutoJurnalPenjualan){
                                                $validasi_proses_simpen_penjualan="Berhasil";
                                            }else{
                                                $validasi_proses_simpen_penjualan="Terjadi Kesalahan Pada Saat Insert Setting Auto Jurnal Penjualan!";
                                            }
                                        }else{
                                            $UpdatePenjualan = mysqli_query($Conn,"UPDATE setting_autojurnal_jual_beli SET 
                                                kategori='Penjualan',
                                                debet='$debet_penjualan',
                                                kredit='$kredit_penjualan',
                                                hpp='$hpp_penjualan',
                                                persediaan='$persediaan_penjualan',
                                                utang_piutang='$utang_piutang_penjualan'
                                            WHERE id_autojurnal_jual_beli='$id_autojurnal_penjualan'") or die(mysqli_error($Conn)); 
                                            if($UpdatePenjualan){
                                                $validasi_proses_simpen_penjualan="Berhasil";
                                            }else{
                                                $validasi_proses_simpen_penjualan="Terjadi Kesalahan Pada Saat Update Setting Auto Jurnal Penjualan!";
                                            }
                                        }

                                        //Validasi Prosess Setting Autojurnal Penjualan
                                        if($validasi_proses_simpen_penjualan!=="Berhasil"){
                                            echo '<div class="alert alert-danger">'.$validasi_proses_simpen_penjualan.'</div>';
                                        }else{

                                            //Lanjutkan Setting Auto Jurnal Pembelian
                                            if(empty($id_autojurnal_pembelian)){
                                                $EntryAutoJurnalPembelian="INSERT INTO setting_autojurnal_jual_beli (
                                                    kategori,
                                                    debet,
                                                    kredit,
                                                    utang_piutang
                                                ) VALUES (
                                                    'Pembelian',
                                                    '$debet_pembelian',
                                                    '$kredit_pembelian',
                                                    '$utang_piutang_pembelian'
                                                )";
                                                $InputAutoJurnalPembelian=mysqli_query($Conn, $EntryAutoJurnalPembelian);
                                                if($InputAutoJurnalPembelian){
                                                    $validasi_proses_simpen_pembelian="Berhasil";
                                                }else{
                                                    $validasi_proses_simpen_pembelian="Terjadi Kesalahan Pada Saat Insert Setting Auto Jurnal Pembelian!";
                                                }
                                            }else{
                                                $UpdateUpdatePembelian = mysqli_query($Conn,"UPDATE setting_autojurnal_jual_beli SET 
                                                    kategori='Pembelian',
                                                    debet='$debet_pembelian',
                                                    kredit='$kredit_pembelian',
                                                    utang_piutang='$utang_piutang_pembelian'
                                                WHERE id_autojurnal_jual_beli='$id_autojurnal_pembelian'") or die(mysqli_error($Conn)); 
                                                if($UpdateUpdatePembelian){
                                                    $validasi_proses_simpen_pembelian="Berhasil";
                                                }else{
                                                    $validasi_proses_simpen_pembelian="Terjadi Kesalahan Pada Saat Update Setting Auto Jurnal Pembelian!";
                                                }
                                            }
                                            if($validasi_proses_simpen_pembelian!=="Berhasil"){
                                                echo '<div class="alert alert-danger">'.$validasi_proses_simpen_pembelian.'</div>';
                                            }else{

                                                //Apabila Semua Prosses Berhasil
                                                echo '
                                                    <div class="alert alert-success">
                                                        <small id="NotifikasiSimpanAutoJurnalJualBeliBerhasil">Berhasil</small>
                                                    </div>
                                                ';
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
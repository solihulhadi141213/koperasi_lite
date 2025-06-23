<?php
    //Koneksi
    include "../../_Config/Connection.php";
    include "../../_Config/GlobalFunction.php";
    include "../../_Config/Session.php";
    date_default_timezone_set('Asia/Jakarta');
    //Time Now Tmp
    $now=date('Y-m-d H:i:s');
    if(empty($SessionIdAkses)){
        echo '<small class="text-danger">Sessi Akses Sudah Berakhir, Silahkan Login Ulang!</small>';
    }else{
        if(empty($_POST['tanggal'])){
            echo '<small class="text-danger">Tanggal Tidak Boleh Kosong</small>';
        }else{
            if(empty($_POST['jam'])){
                echo '<small class="text-danger">Jam Transaksi Tidak Boleh Kosong</small>';
            }else{
                if(empty($_POST['id_transaksi_jenis'])){
                    echo '<small class="text-danger">Jenis Transaksi Tidak Boleh Kosong</small>';
                }else{
                    if(empty($_POST['status'])){
                        echo '<small class="text-danger">Status Transaksi Tidak Boleh Kosong</small>';
                    }else{
                        if(empty($_POST['JumlahTotal'])){
                            echo '<small class="text-danger">Jumlah Transaksi Tidak Boleh Kosong</small>';
                        }else{
                            //Buat Variabel
                            $tanggal=$_POST['tanggal'];
                            $jam=$_POST['jam'];
                            $tanggal_format="$tanggal $jam";
                            $id_transaksi_jenis=$_POST['id_transaksi_jenis'];
                            $status=$_POST['status'];
                            $jumlah=$_POST['JumlahTotal'];
                            if(empty($_POST['JumlahPembayaran'])){
                                $pembayaran="0";
                            }else{
                                $pembayaran=$_POST['JumlahPembayaran'];
                            }
                            //Bersihkan Variabel
                            $tanggal_format=validateAndSanitizeInput($tanggal_format);
                            $id_transaksi_jenis=validateAndSanitizeInput($id_transaksi_jenis);
                            $status=validateAndSanitizeInput($status);
                            $jumlah=validateAndSanitizeInput($jumlah);
                            $pembayaran=validateAndSanitizeInput($pembayaran);
                            //Validasi Karakter
                            if(!preg_match("/^[0-9]*$/", $jumlah)){
                                echo '<small class="text-danger">Jumlah Tagihan Hanya Boleh Angka</small>';
                            }else{
                                if(!preg_match("/^[0-9]*$/", $pembayaran)){
                                    echo '<small class="text-danger">Jumlah Pembayaran Hanya Boleh Angka</small>';
                                }else{
                                    //Bukka Data Jenis Transaksi
                                    $nama=GetDetailData($Conn,'transaksi_jenis','id_transaksi_jenis',$id_transaksi_jenis,'nama');
                                    $kategori=GetDetailData($Conn,'transaksi_jenis','id_transaksi_jenis',$id_transaksi_jenis,'kategori');
                                    $id_akun_debet=GetDetailData($Conn,'transaksi_jenis','id_transaksi_jenis',$id_transaksi_jenis,'id_akun_debet');
                                    $id_akun_kredit=GetDetailData($Conn,'transaksi_jenis','id_transaksi_jenis',$id_transaksi_jenis,'id_akun_kredit');
                                    //Buka Nama-Nama Akun
                                    $AkunDebet=GetDetailData($Conn,'akun_perkiraan','id_perkiraan',$id_akun_debet,'nama');
                                    $AkunKredit=GetDetailData($Conn,'akun_perkiraan','id_perkiraan',$id_akun_kredit,'nama');
                                    //Buka Kode Akun
                                    $KodeAkunDebet=GetDetailData($Conn,'akun_perkiraan','id_perkiraan',$id_akun_debet,'kode');
                                    $KodeAkunKredit=GetDetailData($Conn,'akun_perkiraan','id_perkiraan',$id_akun_kredit,'kode');
                                    if(empty($AkunDebet)){
                                        echo '<small class="text-danger">Akun Debet Pada Pengaturan Jenis Transaksi Tidak Valid</small>';
                                    }else{
                                        if(empty($AkunKredit)){
                                            echo '<small class="text-danger">Akun Debet Pada Pengaturan Jenis Transaksi Tidak Valid</small>';
                                        }else{
                                            //Ciptakan uuid
                                            $uuid_transaksi=generateRandomNumber(32);
                                            //Simpan data
                                            $EntryData="INSERT INTO transaksi (
                                                uuid_transaksi,
                                                id_transaksi_jenis,
                                                nama_transaksi,
                                                kategori,
                                                tanggal,
                                                jumlah,
                                                pembayaran,
                                                status
                                            ) VALUES (
                                                '$uuid_transaksi',
                                                '$id_transaksi_jenis',
                                                '$nama',
                                                '$kategori',
                                                '$tanggal_format',
                                                '$jumlah',
                                                '$pembayaran',
                                                '$status'
                                            )";
                                            $InputData=mysqli_query($Conn, $EntryData);
                                            if($InputData){
                                                //Apabila Berhasil Di Inser, Cari id_transaksi
                                                $id_transaksi=GetDetailData($Conn,'transaksi','uuid_transaksi',$uuid_transaksi,'id_transaksi');
                                                if(empty($id_transaksi)){
                                                    $HapusTransaksi = mysqli_query($Conn, "DELETE FROM transaksi WHERE uuid_transaksi='$uuid_transaksi'") or die(mysqli_error($Conn));
                                                    echo '<small class="text-danger">ID transaksi tidak ditemukan pada saat menambahkan data</small>';
                                                }else{
                                                    //Apabila ada rincian maka tambahkan
                                                    if(!empty($_POST['uraian'])){
                                                        $CoutnUraian=count($_POST['uraian']);
                                                        $JumlahBerhasil=0;
                                                        for ($i = 0; $i < $CoutnUraian; $i++) {
                                                            if(!empty($_POST['uraian'][$i])){
                                                                $uraian = $_POST['uraian'][$i];
                                                            }else{
                                                                $uraian ="";
                                                            }
                                                            if(!empty($_POST['harga'][$i])){
                                                                $harga = $_POST['harga'][$i];
                                                            }else{
                                                                $harga =0;
                                                            }
                                                            if(!empty($_POST['qty'][$i])){
                                                                $qty = $_POST['qty'][$i];
                                                            }else{
                                                                $qty =0;
                                                            }
                                                            if(!empty($_POST['satuan'][$i])){
                                                                $satuan = $_POST['satuan'][$i];
                                                            }else{
                                                                $satuan ="";
                                                            }
                                                            if(!empty($_POST['jumlah'][$i])){
                                                                $jumlah_list = $_POST['jumlah'][$i];
                                                            }else{
                                                                $jumlah_list=0;
                                                            }
                                                            //Insert Ke Uraian
                                                            $EntryDataRincian="INSERT INTO transaksi_rincian (
                                                                id_transaksi,
                                                                uuid_transaksi,
                                                                rincian_transaksi,
                                                                harga,
                                                                qty,
                                                                satuan,
                                                                jumlah
                                                            ) VALUES (
                                                                '$id_transaksi',
                                                                '$uuid_transaksi',
                                                                '$uraian',
                                                                '$harga',
                                                                '$qty',
                                                                '$satuan',
                                                                '$jumlah_list'
                                                            )";
                                                            $InputDataRincian=mysqli_query($Conn, $EntryDataRincian);
                                                            if($InputDataRincian){
                                                                $JumlahBerhasil=$JumlahBerhasil+1;
                                                            }else{
                                                                $JumlahBerhasil=$JumlahBerhasil+0;
                                                                echo "$id_transaksi-$uuid_transaksi-$uraian-$harga<br>";
                                                            }
                                                        }
                                                    }else{
                                                        $CoutnUraian=0;
                                                        $JumlahBerhasil=0;
                                                    }
                                                    //Apabila Terdapat Kesalahan Dalam Penginputan Rincian
                                                    if($CoutnUraian!==$JumlahBerhasil){
                                                        $HapusTransaksi = mysqli_query($Conn, "DELETE FROM transaksi WHERE id_transaksi='$id_transaksi'") or die(mysqli_error($Conn));
                                                        $HapusRincianTransaksi = mysqli_query($Conn, "DELETE FROM transaksi_rincian WHERE id_transaksi='$id_transaksi'") or die(mysqli_error($Conn));
                                                        echo '<small class="text-danger">Terjadi kesalahan pada saat melakukan penginputan rincian transaksi Record : '.$CoutnUraian.'/'.$JumlahBerhasil.'</small>';
                                                    }else{
                                                        //Simpan Jurnal Transaksi Debet
                                                        $EntryJurnalDebet="INSERT INTO jurnal (
                                                            kategori,
                                                            uuid,
                                                            id_transaksi,
                                                            tanggal,
                                                            kode_perkiraan,
                                                            nama_perkiraan,
                                                            d_k,
                                                            nilai
                                                        ) VALUES (
                                                            'Transaksi',
                                                            '$uuid_transaksi',
                                                            '$id_transaksi',
                                                            '$tanggal',
                                                            '$KodeAkunDebet',
                                                            '$AkunDebet',
                                                            'D',
                                                            '$jumlah'
                                                        )";
                                                        $InputJurnalDebet=mysqli_query($Conn, $EntryJurnalDebet);
                                                        if($InputJurnalDebet){
                                                            //Simpan Jurnal Transaksi Debet
                                                            $EntryJurnalKredit="INSERT INTO jurnal (
                                                                kategori,
                                                                uuid,
                                                                id_transaksi,
                                                                tanggal,
                                                                kode_perkiraan,
                                                                nama_perkiraan,
                                                                d_k,
                                                                nilai
                                                            ) VALUES (
                                                                'Transaksi',
                                                                '$uuid_transaksi',
                                                                '$id_transaksi',
                                                                '$tanggal',
                                                                '$KodeAkunKredit',
                                                                '$AkunKredit',
                                                                'K',
                                                                '$jumlah'
                                                            )";
                                                            $InputJurnalKredit=mysqli_query($Conn, $EntryJurnalKredit);
                                                            if($InputJurnalKredit){
                                                                $_SESSION ["NotifikasiSwal"]="Tambah Transaksi Berhasil";
                                                                echo '<small class="text-success" id="NotifikasiTambahTransaksiBerhasil">Success</small>';
                                                            }else{
                                                                $HapusTransaksi = mysqli_query($Conn, "DELETE FROM transaksi WHERE id_transaksi='$id_transaksi'") or die(mysqli_error($Conn));
                                                                $HapusRincianTransaksi = mysqli_query($Conn, "DELETE FROM transaksi_rincian WHERE id_transaksi='$id_transaksi'") or die(mysqli_error($Conn));
                                                                echo '<small class="text-danger">Terjadi kesalahan pada saat menyimpan jurnal kredit</small>';
                                                            }
                                                        }else{
                                                            $HapusTransaksi = mysqli_query($Conn, "DELETE FROM transaksi WHERE id_transaksi='$id_transaksi'") or die(mysqli_error($Conn));
                                                            $HapusRincianTransaksi = mysqli_query($Conn, "DELETE FROM transaksi_rincian WHERE id_transaksi='$id_transaksi'") or die(mysqli_error($Conn));
                                                            echo '<small class="text-danger">Terjadi kesalahan pada saat menyimpan jurnal debet</small>';
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
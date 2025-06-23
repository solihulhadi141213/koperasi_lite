<?php
    //Connection
    include "../../_Config/Connection.php";
    include "../../_Config/GlobalFunction.php";
    include "../../_Config/Session.php";

    //Time Zone
    date_default_timezone_set('Asia/Jakarta');

    //Time Now
    $now=date('Y-m-d H:i:s');

    //Validasi Session
    if(empty($SessionIdAkses)){
        echo '
            <div class="alert alert-danger">
                <small>Sesi Akses Sudah Berakhir! Silahkan Login Ulang!</small>
            </div>
        ';
    }else{
        if(empty($_POST['id_shu_session'])){
            echo '
                <div class="alert alert-danger">
                    <small>ID Sesi SHU Tidak Boleh Kosong!</small>
                </div>
            ';
        }else{
            if(empty($_POST['id_anggota'])){
                echo '
                    <div class="alert alert-danger">
                        <small>ID Anggota Tidak Boleh Kosong!</small>
                    </div>
                ';
            }else{
                $id_shu_session=validateAndSanitizeInput($_POST['id_shu_session']);
                $id_anggota=validateAndSanitizeInput($_POST['id_anggota']);
                $penjualan = !empty($_POST['penjualan']) ? str_replace(".", "", $_POST['penjualan']) : 0;
                $simpanan = !empty($_POST['simpanan']) ? str_replace(".", "", $_POST['simpanan']) : 0;
                $pinjaman = !empty($_POST['pinjaman']) ? str_replace(".", "", $_POST['pinjaman']) : 0;
                $jasa_penjualan = !empty($_POST['jasa_penjualan']) ? str_replace(".", "", $_POST['jasa_penjualan']) : 0;
                $jasa_simpanan = !empty($_POST['jasa_simpanan']) ? str_replace(".", "", $_POST['jasa_simpanan']) : 0;
                $jasa_pinjaman = !empty($_POST['jasa_pinjaman']) ? str_replace(".", "", $_POST['jasa_pinjaman']) : 0;
                
                //Buka NIP anggota
                $nip=GetDetailData($Conn, 'anggota', 'id_anggota', $id_anggota, 'nip');

                //Validasi Data anggota
                if(empty($nip)){
                    echo '
                        <div class="alert alert-danger">
                            <small>NIP Anggota Tidak Ditemukan!</small>
                        </div>
                    ';
                }else{
                    //Validasi Duplikasi Data
                    $ValidasiDuplikatData = mysqli_num_rows(mysqli_query($Conn, "SELECT*FROM shu_rincian WHERE id_anggota='$id_anggota' AND id_shu_session='$id_shu_session'"));
                    if(!empty($ValidasiDuplikatData)){
                        echo '
                            <div class="alert alert-danger">
                                <small>Data Yang Anda Masukan Sudah Ada</small>
                            </div>
                        ';
                    }else{
                        //Hitung Jumlah SHU
                        $shu=$jasa_penjualan+$jasa_simpanan+$jasa_pinjaman;
                        //Simpan Data Rincian
                        $EntryData="INSERT INTO shu_rincian (
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
                        ) VALUES (
                            '$id_shu_session',
                            '$id_anggota',
                            '$nama_anggota',
                            '$nip',
                            '$simpanan',
                            '$pinjaman',
                            '$penjualan',
                            '$jasa_simpanan',
                            '$jasa_pinjaman',
                            '$jasa_penjualan',
                            '$shu'
                        )";
                        $InputData=mysqli_query($Conn, $EntryData);
                        if($InputData){
                            //Simpan Log
                            $kategori_log="SHU";
                            $deskripsi_log="Tambah Rincian SHU manual";
                            $InputLog=addLog($Conn,$SessionIdAkses,$now,$kategori_log,$deskripsi_log);
                            if($InputLog=="Success"){
                                echo '
                                    <div class="alert alert-success">
                                        <small id="NotifikasiTambahRincianManualBerhasil">Success</small>
                                    </div>
                                '; 
                            }else{
                                echo '
                                    <div class="alert alert-danger">
                                        <small>Terjadi kesalahan pada saat menyimpan Log!</small>
                                    </div>
                                ';
                            }
                            
                        }else{
                            echo '
                                <div class="alert alert-danger">
                                    <small>Terjadi kesalahan pada saat menyimpan data rincian!</small>
                                </div>
                            ';
                        }
                    }
                }
            }
        }
    }
?>
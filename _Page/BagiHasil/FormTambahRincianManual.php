<?php
    //Koneksi
    date_default_timezone_set('Asia/Jakarta');
    include "../../_Config/Connection.php";
    include "../../_Config/GlobalFunction.php";
    include "../../_Config/Session.php";

    //Tangkap id_anggota
    if(empty($_POST['id_anggota'])){
        echo '
            <div class="alert alert-danger">
                <small>ID Anggota Tidak Boleh Kosong!</small>
            </div>
        ';
    }else{
        //Tangkap id_shu_session
        if(empty($_POST['id_shu_session'])){
            echo '
                <div class="alert alert-danger">
                    <small>ID Sesi SHU Tidak Boleh Kosong!</small>
                </div>
            ';
        }else{
            $id_anggota=$_POST['id_anggota'];
            $id_shu_session=$_POST['id_shu_session'];
            //Buka data Anggota
            $QryAnggota = mysqli_query($Conn,"SELECT * FROM anggota WHERE id_anggota='$id_anggota'")or die(mysqli_error($Conn));
            $DataAnggota = mysqli_fetch_array($QryAnggota);
            $id_anggota= $DataAnggota['id_anggota'];
            $tanggal_masuk= $DataAnggota['tanggal_masuk'];
            $nama= $DataAnggota['nama'];
            $nip= $DataAnggota['nip'];

            //Buka Status
            $status=GetDetailData($Conn, 'shu_session', 'id_shu_session', $id_shu_session, 'status');
            if($status!=="Pending"){
                echo '
                    <div class="alert alert-danger">
                        Sesi SHU Sudah Dialokasikan! Anda Tidak Bisa Mengubah Data SHU ini!
                    </div>
                ';
            }else{
                echo '
                    <input type="hidden" name="id_shu_session" value="'.$id_shu_session.'">
                    <input type="hidden" name="id_anggota" value="'.$id_anggota.'">
                ';
                echo '
                    <div class="row mb-3">
                        <div class="col-4">
                            <small>Nama Anggota</small>
                        </div>
                        <div class="col-8"><small class="text text-muted">'.$nama.'</small></div>
                    </div>
                    <div class="row mb-3">
                        <div class="col-4">
                            <small>Nomor Induk</small>
                        </div>
                        <div class="col-8"><small class="text text-muted">'.$nip.'</small></div>
                    </div>
                    <div class="row mb-3">
                        <div class="col-4">
                            <label for="penjualan_manual">
                                <small>Jumlah Penjualan</small>
                            </label>
                        </div>
                        <div class="col-8">
                            <input type="text" name="penjualan" id="penjualan_manual" class="form-control form-money">
                        </div>
                    </div>
                    <div class="row mb-3">
                        <div class="col-4">
                            <label for="simpanan_manual">
                                <small>Jumlah Simpanan</small>
                            </label>
                        </div>
                        <div class="col-8">
                            <input type="text" name="simpanan" id="simpanan_manual" class="form-control form-money">
                        </div>
                    </div>
                    <div class="row mb-3">
                        <div class="col-4">
                            <label for="pinjaman_manual">
                                <small>Jumlah Pinjaman</small>
                            </label>
                        </div>
                        <div class="col-8">
                            <input type="text" name="pinjaman" id="pinjaman_manual" class="form-control form-money">
                        </div>
                    </div>
                    <div class="row mb-3">
                        <div class="col-4">
                            <label for="jasa_penjualan_manual">
                                <small>Jasa Penjualan</small>
                            </label>
                        </div>
                        <div class="col-8">
                            <input type="text" name="jasa_penjualan" id="jasa_penjualan_manual" class="form-control form-money">
                        </div>
                    </div>
                    <div class="row mb-3">
                        <div class="col-4">
                            <label for="jasa_simpanan_manual">
                                <small>Jasa Siimpanan</small>
                            </label>
                        </div>
                        <div class="col-8">
                            <input type="text" name="simpanan_manual" id="jasa_simpanan_manual" class="form-control form-money">
                        </div>
                    </div>
                    <div class="row mb-3">
                        <div class="col-4">
                            <label for="jasa_pinjaman_manual">
                                <small>Jasa Pinjaman</small>
                            </label>
                        </div>
                        <div class="col-8">
                            <input type="text" name="jasa_pinjaman" id="jasa_pinjaman_manual" class="form-control form-money">
                        </div>
                    </div>
                    <div class="row mb-3">
                        <div class="col-4">
                            <label for="shu_manual">
                                <small>Jumlah SHU</small>
                            </label>
                        </div>
                        <div class="col-8">
                            <input type="text" readonly name="shu" id="shu_manual" class="form-control form-money">
                        </div>
                    </div>
                ';
            }
        }
    }
?>
<?php
    //koneksi dan session
    include "../../_Config/Connection.php";
    include "../../_Config/GlobalFunction.php";

    //Validasi id_simpanan_jenis tidak boleh kosong
    if(empty($_POST['id_simpanan_jenis'])){
        echo '
            <div class="alert alert-danger">
                Jenis Simpanan Tidak Boleh Kosong!
            </div>
        ';
    }else{
        if(empty($_POST['id_anggota'])){
            echo '
                <div class="alert alert-danger">
                    ID Anggota Tidak Boleh Kosong!
                </div>
            ';
        }else{
            if(empty($_POST['periode'])){
                echo '
                    <div class="alert alert-danger">
                        Periode Tidak Boleh Kosong!
                    </div>
                ';
            }else{
                $id_simpanan_jenis=$_POST['id_simpanan_jenis'];
                $id_anggota=$_POST['id_anggota'];
                $periode=$_POST['periode'];
                
                //Buka Jenis Simpanan
                $nama_simpanan=GetDetailData($Conn,'simpanan_jenis','id_simpanan_jenis',$id_simpanan_jenis,'nama_simpanan');
                $keterangan=GetDetailData($Conn,'simpanan_jenis','id_simpanan_jenis',$id_simpanan_jenis,'keterangan');
                $kategori=GetDetailData($Conn,'simpanan_jenis','id_simpanan_jenis',$id_simpanan_jenis,'kategori');
                $nominal=GetDetailData($Conn,'simpanan_jenis','id_simpanan_jenis',$id_simpanan_jenis,'nominal');
                $nominal_Format = "Rp " . number_format($nominal,0,',','.');

                //Nama Anggota
                $nama_anggota=GetDetailData($Conn,'anggota','id_anggota',$id_anggota,'nama');
                echo '
                    <input type="hidden" name="id_simpanan_jenis" value="'.$id_simpanan_jenis.'">
                    <input type="hidden" name="id_anggota" value="'.$id_anggota.'">
                    <input type="hidden" name="periode" value="'.$periode.'">
                    <div class="row mb-2">
                        <div class="col-3"><small>Nama/Kode</small></div>
                        <div class="col-1"><small>:</small></div>
                        <div class="col-8"><small><code class="text text-grayish">'.$nama_simpanan.'</code></small></div>
                    </div>
                    <div class="row mb-2">
                        <div class="col-3"><small>Kategori</small></div>
                        <div class="col-1"><small>:</small></div>
                        <div class="col-8"><small><code class="text text-grayish">'.$kategori.'</code></small></div>
                    </div>
                    <div class="row mb-2">
                        <div class="col-3"><small>Periode</small></div>
                        <div class="col-1"><small>:</small></div>
                        <div class="col-8"><small><code class="text text-grayish">'.$periode.'</code></small></div>
                    </div>
                    <div class="row mb-2">
                        <div class="col-3"><small>Nominal</small></div>
                        <div class="col-1"><small>:</small></div>
                        <div class="col-8"><small><code class="text text-grayish">'.$nominal_Format.'</code></small></div>
                    </div>
                    <div class="row mb-2">
                        <div class="col-3"><small>Nama Anggota</small></div>
                        <div class="col-1"><small>:</small></div>
                        <div class="col-8"><small><code class="text text-grayish">'.$nama_anggota.'</code></small></div>
                    </div>
                    <div class="row mb-2 mt-3">
                        <div class="col-12 mt-3">
                            <small>
                                <b>Pilih Metode Pembayaran</b>
                            </small>
                            <select class="form-control" name="metode_pembayaran">
                                <option value="">Pilih</option>
                                <option value="BRI-Virtual Account">BRI-Virtual Account</option>
                                <option value="BNI-Virtual Account">BNI-Virtual Account</option>
                                <option value="Mandiri-Virtual Account">Mandiri-Virtual Account</option>
                                <option value="BCA-Virtual Account">BCA-Virtual Account</option>
                                <option value="Retail-Indomart/Alfamart">Retail-Indomart/Alfamart</option>
                            </select>
                        </div>
                    </div>
                ';
            }
        }
    }
?>
<?php
    //koneksi dan session
    include "../../_Config/Connection.php";
    include "../../_Config/GlobalFunction.php";

    //Validasi mode_pembayaran tidak boleh kosong
    if(empty($_POST['mode_pembayaran'])){
        echo '
            <div class="alert alert-danger">
                Mode Pembayaran Tidak Boleh Kosong!
            </div>
        ';
    }else{
        if(empty($_POST['kode_pembayaran'])){
            echo '
                <div class="alert alert-danger">
                    Kode Pembayaran Tidak Boleh Kosong!
                </div>
            ';
        }else{
            //Buat Variabel
            $mode_pembayaran=$_POST['mode_pembayaran'];
            $kode_pembayaran=$_POST['kode_pembayaran'];

            //Cari Data Berdasarkan Database
            if($mode_pembayaran=="simpanan"){

                //Buka Data Simpanan
                $QrySimpanan = $Conn->prepare("SELECT * FROM simpanan WHERE uuid_simpanan = ?");
                if ($QrySimpanan === false) {
                    die("Query preparation failed: " . $Conn->error);
                }

                // Bind parameter dan eksekusi
                $QrySimpanan->bind_param("s", $kode_pembayaran);
                if (!$QrySimpanan->execute()) {
                    die("Query execution failed: " . $QrySimpanan->error);
                }

                $ResultSimpanan = $QrySimpanan->get_result();
                $DataSimpanan = $ResultSimpanan->fetch_assoc();
                
                if ($ResultSimpanan->num_rows > 0) {
                    //Menampilkan Informasi Simpanan
                    $id_simpanan = $DataSimpanan['id_simpanan'];
                    $kategori = $DataSimpanan['kategori'];
                    $nama = $DataSimpanan['nama'];
                    $jumlah = $DataSimpanan['jumlah'];
                    $status = $DataSimpanan['status'];
                    $jumlah_format = "Rp " . number_format($jumlah,0,',','.');
                    if($status=="Lunas"){
                        echo '
                            <div class="alert alert-danger">
                                Kode Pembayaran Tersebut Sudah Lunas!
                            </div>
                        ';
                    }else{
                        echo '
                            <div class="row mb-2">
                                <div class="col-6"><small>Nama</small></div>
                                <div class="col-6 text-end"><small class="text text-grayish">'.$nama.'</small></div>
                            </div>
                            <div class="row mb-2">
                                <div class="col-6"><small>Kategori</small></div>
                                <div class="col-6 text-end"><small class="text text-grayish">'.$kategori.'</small></div>
                            </div>
                            <div class="row mb-2">
                                <div class="col-6"><small>Nominal</small></div>
                                <div class="col-6 text-end"><small class="text text-grayish">'.$jumlah_format.'</small></div>
                            </div>
                            <input type="hidden" id="InformasiPembayaranBerhasil" value="Success">
                        ';
                    }
                }else{
                    echo '
                        <div class="alert alert-danger">
                            Kode Pembayaran Tidak Ditemukan!
                        </div>
                    ';
                }
            }else{
                $table_name="pinjaman_angsuran";
            }

            //Buka Data\

        }
    }
?>
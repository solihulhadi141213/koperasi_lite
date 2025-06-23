<?php
    // Koneksi & Konfigurasi
    include "../../_Config/Connection.php";
    include "../../_Config/GlobalFunction.php";
    include "../../_Config/Session.php";

    // Time Zone
    date_default_timezone_set('Asia/Jakarta');
    $now = date('Y-m-d H:i:s');

    // Validasi Sesi Login
    if (empty($SessionIdAkses)) {
        echo '
            <div class="alert alert-danger">
                <small>Sesi Akses Sudah Berakhir. Silahkan Login Ulang!</small>
            </div>
        ';
    } elseif (!isset($_POST['id_transaksi_jual_beli']) || empty($_POST['id_transaksi_jual_beli'])) {
        echo '
            <div class="alert alert-danger">
                <small>ID Transaksi Jual Beli Tidak Boleh Kosong!</small>
            </div>
        ';
    } else {
        if(empty($_POST['id_transaksi_jual_beli_rincian'])){
            echo '
                <div class="alert alert-danger">
                    <small>ID Rincian Transaksi Jual Beli Tidak Boleh Kosong!</small>
                </div>
            ';
        }else{
            // Ambil Data Transaksi
            $id_transaksi_jual_beli = validateAndSanitizeInput($_POST['id_transaksi_jual_beli']);
            $id_transaksi_jual_beli_rincian = validateAndSanitizeInput($_POST['id_transaksi_jual_beli_rincian']);
            
            $Qry = $Conn->prepare("SELECT * FROM transaksi_jual_beli WHERE id_transaksi_jual_beli = ?");
            $Qry->bind_param("s", $id_transaksi_jual_beli);
            
            if (!$Qry->execute()) {
                echo '
                    <div class="alert alert-danger">
                        <small>Error : '.$Conn->error.'</small>
                    </div>
                ';
            } else {
                $Result = $Qry->get_result();
                $Data = $Result->fetch_assoc();
                $Qry->close();

                if (!$Data) {
                    echo '
                        <div class="alert alert-danger">
                            <small>Data Transaksi Yang Anda Pilih Tidak Ditemukan</small>
                        </div>
                    ';
                } else {
                    // Ambil Data Transaksi
                    $id_supplier = $Data['id_supplier'];
                    $id_anggota = $Data['id_anggota'];
                    $kategori = $Data['kategori'];
                    $tanggal = $Data['tanggal'];
                    $subtotal = pembulatan_nilai($Data['subtotal']);
                    $ppn = pembulatan_nilai($Data['ppn']);
                    $diskon = pembulatan_nilai($Data['diskon']);
                    $total = pembulatan_nilai($Data['total']);
                    $cash = pembulatan_nilai($Data['cash']);
                    $kembalian = pembulatan_nilai($Data['kembalian']);
                    $status = $Data['status'];

                    // Format Rupiah
                    $subtotal_rp = "Rp " . number_format($subtotal, 0, ',', '.');
                    $ppn_rp = "Rp " . number_format($ppn, 0, ',', '.');
                    $diskon_rp = "Rp " . number_format($diskon, 0, ',', '.');
                    $total_rp = "Rp " . number_format($total, 0, ',', '.');
                    $cash_rp = "Rp " . number_format($cash, 0, ',', '.');
                    $kembalian_rp = "Rp " . number_format($kembalian, 0, ',', '.');

                    // Ambil Nama Anggota Dan Supplier
                    $nama_anggota = (!empty($id_anggota)) ? GetDetailData($Conn, 'anggota', 'id_anggota', $id_anggota, 'nama') : "-";
                    $nama_supplier = (!empty($id_supplier)) ? GetDetailData($Conn, 'supplier', 'id_supplier', $id_supplier, 'nama_supplier') : "-";

                    //Tampilkan Data
                    echo '
                        <div class="row mb-2">
                            <div class="col-12">
                                <small>
                                    <b># Informasi Transaksi</b>
                                </small>
                            </div>
                        </div>
                        <div class="row mb-2">
                            <div class="col-4">
                                <small>Kategori</small>
                            </div>
                            <div class="col-8">
                                <small class="text-muted">'.$kategori.'</small>
                            </div>
                        </div>
                        <div class="row mb-2">
                            <div class="col-4">
                                <small>Tanggal</small>
                            </div>
                            <div class="col-8">
                                <small class="text-muted">'.$tanggal.'</small>
                            </div>
                        </div>
                        <div class="row mb-2">
                            <div class="col-4">
                                <small>Anggota</small>
                            </div>
                            <div class="col-8">
                                <small class="text-muted">'.$nama_anggota.'</small>
                            </div>
                        </div>
                        <div class="row mb-2">
                            <div class="col-4">
                                <small>Supplier</small>
                            </div>
                            <div class="col-8">
                                <small class="text-muted">'.$nama_supplier.'</small>
                            </div>
                        </div>
                        <div class="row mb-2">
                            <div class="col-4">
                                <small>Subtotal</small>
                            </div>
                            <div class="col-8">
                                <small class="text-muted">'.$subtotal_rp.'</small>
                            </div>
                        </div>
                        <div class="row mb-2">
                            <div class="col-4">
                                <small>PPN</small>
                            </div>
                            <div class="col-8">
                                <small class="text-muted">'.$ppn_rp.'</small>
                            </div>
                        </div>
                        <div class="row mb-2">
                            <div class="col-4">
                                <small>Diskon</small>
                            </div>
                            <div class="col-8">
                                <small class="text-muted">'.$diskon_rp.'</small>
                            </div>
                        </div>
                        <div class="row mb-2">
                            <div class="col-4">
                                <small>Total</small>
                            </div>
                            <div class="col-8">
                                <small class="text-muted">'.$total_rp.'</small>
                            </div>
                        </div>
                        <div class="row mb-2">
                            <div class="col-4">
                                <small>Status</small>
                            </div>
                            <div class="col-8">
                                <small class="text-muted">'.$status.'</small>
                            </div>
                        </div>
                        <div class="row mb-2 mt-3">
                            <div class="col-12">
                                <small>
                                    <b># Uraian Transaksi</b>
                                </small>
                            </div>
                        </div>
                    ';
                    //Membuka Detail Rincian
                    $QryRincian = $Conn->prepare("SELECT * FROM transaksi_jual_beli_rincian WHERE id_transaksi_jual_beli_rincian = ?");
                    $QryRincian->bind_param("s", $id_transaksi_jual_beli_rincian);
                    
                    if (!$QryRincian->execute()) {
                        echo '
                            <div class="alert alert-danger">
                                <small>Error : '.$Conn->error.'</small>
                            </div>
                        ';
                    } else {
                        $ResultRincian = $QryRincian->get_result();
                        $DataRincian = $ResultRincian->fetch_assoc();
                        $QryRincian->close();

                        if (!$DataRincian) {
                            echo '
                                <div class="alert alert-danger">
                                    <small>Data Rincian Transaksi Tidak Ditemukan</small>
                                </div>
                            ';
                        } else {
                            // Buat Variabel Rincian
                            $satuan = $DataRincian['satuan'];
                            $qty = $DataRincian['qty'];
                            $harga = $DataRincian['harga'];
                            $ppn = $DataRincian['ppn'];
                            $diskon = $DataRincian['diskon'];
                            $subtotal_rincian = $DataRincian['subtotal'];
                            $jumlah = $qty * $harga;
                            $jumlah_format = "Rp " .number_format($jumlah, 0, ',', '.');
                            $harga_format = "Rp " .number_format($harga, 0, ',', '.');
                            $diskon_format = "Rp " .number_format($diskon, 0, ',', '.');
                            $ppn_format = "Rp " .number_format($ppn, 0, ',', '.');
                            $subtotal_rincian_format = "Rp " .number_format($subtotal_rincian, 0, ',', '.');

                            //Tampilkan
                            echo '
                                <div class="row mb-2">
                                    <div class="col-4">
                                        <small>Harga</small>
                                    </div>
                                    <div class="col-8">
                                        <small class="text-muted">'.$harga_format.'</small>
                                    </div>
                                </div>
                                <div class="row mb-2">
                                    <div class="col-4">
                                        <small>QTY</small>
                                    </div>
                                    <div class="col-8">
                                        <small class="text-muted">'.$qty.' '.$satuan.'</small>
                                    </div>
                                </div>
                                <div class="row mb-2">
                                    <div class="col-4">
                                        <small>Subtotal</small>
                                    </div>
                                    <div class="col-8">
                                        <small class="text-muted">'.$jumlah_format.'</small>
                                    </div>
                                </div>
                                <div class="row mb-2">
                                    <div class="col-4">
                                        <small>PPN</small>
                                    </div>
                                    <div class="col-8">
                                        <small class="text-muted">'.$ppn_format.'</small>
                                    </div>
                                </div>
                                <div class="row mb-2">
                                    <div class="col-4">
                                        <small>Diskon</small>
                                    </div>
                                    <div class="col-8">
                                        <small class="text-muted">'.$diskon_format.'</small>
                                    </div>
                                </div>
                                <div class="row mb-2">
                                    <div class="col-4">
                                        <small>Jumlah</small>
                                    </div>
                                    <div class="col-8">
                                        <small class="text-muted">'.$subtotal_rincian_format.'</small>
                                    </div>
                                </div>
                            ';

                            //Routing Halaman Detail
                            if($kategori=="Penjualan"||$kategori=="Retur Penjualan"){
                                echo '
                                    <input type="hidden" name="Page" value="Penjualan">
                                    <input type="hidden" name="Sub" value="DetailPenjualan">
                                    <input type="hidden" name="id" value="'.$id_transaksi_jual_beli.'">
                                ';
                            }else{
                                echo '
                                    <input type="hidden" name="Page" value="Pembelian">
                                    <input type="hidden" name="Sub" value="DetailPembelian">
                                    <input type="hidden" name="id" value="'.$id_transaksi_jual_beli.'">
                                ';
                            }
                        }
                    }
                }
            }
        }
    }
?>

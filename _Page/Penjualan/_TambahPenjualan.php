<?php
    //Cek Aksesibilitas ke halaman ini
    $IjinAksesSaya=IjinAksesSaya($Conn,$SessionIdAkses,'hE3ordTLe9KBwSRO3t5');
    if($IjinAksesSaya!=="Ada"){
        include "_Page/Error/NoAccess.php";
    }else{
        if(empty($_GET['retur'])){
            include "_Page/Error/PageNotFound.php";
        }else{
            $retur=$_GET['retur'];
            if($retur=="Ya"){
                $kategori_transaksi="Retur Penjualan";
            }else{
                $kategori_transaksi="Penjualan";
            }
?>
            <div class="pagetitle">
                <h1>
                    <a href="">
                        <i class="bi bi-cart-plus"></i> Transaksi Penjualan</a>
                    </a>
                </h1>
                <nav>
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="index.php">Dashboard</a></li>
                        <li class="breadcrumb-item"><a href="index.php?Page=Penjualan">Penjualan</a></li>
                        <li class="breadcrumb-item active">Tambah Penjualan</li>
                    </ol>
                </nav>
            </div>
            <div class="row mb-3">
                <div class="col-md-12">
                    <div class="alert alert-warning alert-dismissible fade show" role="alert">
                        <small>
                            Berikut ini adalah halaman untuk menambahkan data transaksi penjualan.
                            Tambahkan data barang pada kolom rincian penjualan berikut ini dengan menambahkan langsung melalui pencarian manual atau kode barang.
                            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                        </small>
                    </div>
                </div>
            </div>
            <div class="row mb-3">
                <div class="col-md-12">
                    <div class="card">
                        <form action="javascript:void(0);" id="ProsesSimpanTransaksiPenjualan">
                            <input type="hidden" name="kategori_transaksi" value="<?php echo "$kategori_transaksi"; ?>">
                            <div class="card-header">
                                <div class="row">
                                    <div class="col-8 mb-2 mt-2">
                                        # <b class="card-title" id="get_kategori_transaksi"><?php echo "$kategori_transaksi"; ?></b>
                                    </div>
                                    <div class="col-4 mb-2 mt-2 text-end">
                                        <button type="button" class="btn btn-md btn-floating btn-dark button_kembali" title="Kembali">
                                            <i class="bi bi-chevron-left"></i>
                                        </button>
                                        <button type="button" class="btn btn-md btn-floating btn-info" data-bs-toggle="modal" data-bs-target="#ModalScanBarang" title="Scan Code">
                                            <i class="bi bi-qr-code-scan"></i>
                                        </button>
                                        <button type="button" class="btn btn-md btn-floating btn-primary" data-bs-toggle="modal" data-bs-target="#ModalCariBarang" title="Cari Barang">
                                            <i class="bi bi-search"></i>
                                        </button>
                                    </div>
                                </div>
                            </div>
                            <div class="card-body">
                                <div class="row mb-3">
                                    <div class="col-md-12">
                                        <div class="table table-responsive">
                                            <table class="table table-hover table-striped">
                                                <thead>
                                                    <tr>
                                                        <th><b>No</b></th>
                                                        <th><b>Kode</b></th>
                                                        <th><b>Nama Barang</b></th>
                                                        <th><b>QTY</b></th>
                                                        <th><b>Harga</b></th>
                                                        <th><b>PPN</b></th>
                                                        <th><b>Diskon</b></th>
                                                        <th><b>Subtotal</b></th>
                                                        <th><b>Opsi</b></th>
                                                    </tr>
                                                </thead>
                                                <tbody id="TabelPenjualanBulk">
                                                    <tr>
                                                        <td class="text-center" colspan="9">
                                                            <span class="text-danger">Tidak Ada Rincian Transaksi Yang Ditampilkan</span>
                                                        </td>
                                                    </tr>
                                                </tbody>
                                            </table>
                                        </div>
                                    </div>
                                </div>
                                <div class="row mb-3">
                                    <div class="col-md-6">
                                        <div class="row mb-3">
                                            <div class="col-4">
                                                <label for="tanggal"><small>Tanggal</small></label>
                                            </div>
                                            <div class="col-8">
                                                <input type="date" name="tanggal" id="tanggal" class="form-control form-control-lg" value="<?php echo date('Y-m-d'); ?>">
                                            </div>
                                        </div>
                                        <div class="row mb-3">
                                            <div class="col-4">
                                                <label for="tanggal"><small>Waktu/Jam</small></label>
                                            </div>
                                            <div class="col-8">
                                                <input type="time" name="jam" class="form-control form-control-lg" value="<?php echo date('H:i'); ?>">
                                            </div>
                                        </div>
                                        <div class="row mb-3">
                                            <div class="col-4">
                                                <label for="put_status_transaksi_penjualan"><small>Status Transaksi</small></label>
                                            </div>
                                            <div class="col-8">
                                                <input type="text" readonly name="status" id="put_status_transaksi_penjualan" class="form-control form-control-lg">
                                            </div>
                                        </div>
                                        <div class="row mb-3">
                                            <div class="col-4">
                                                <label for="put_id_anggota_for_add_penjualan"><small>Anggota</small></label>
                                            </div>
                                            <div class="col-8">
                                                <select id="put_id_anggota_for_add_penjualan" name="put_id_anggota_for_add_penjualan" class="form-control form-control-lg" data-bs-toggle="modal" data-bs-target="#ModalPilihAnggota">
                                                    <option value="">Pilih</option>
                                                </select>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="row mb-3">
                                            <div class="col-4">
                                                <label for="put_total_penjualan"><small>Total</small></label>
                                            </div>
                                            <div class="col-8">
                                                <input type="text" readonly name="total" id="put_total_penjualan" class="form-control form-control-lg form-money" oninput="this.value = this.value.replace(/[^0-9]/g, '');" value="0">
                                            </div>
                                        </div>
                                        <div class="row mb-3">
                                            <div class="col-4">
                                                <label for="put_cash_penjualan"><small>Cash (Pembayaran)</small></label>
                                            </div>
                                            <div class="col-8">
                                                <input type="text" name="cash" id="put_cash_penjualan" class="form-control form-control-lg form-money" oninput="this.value = this.value.replace(/[^0-9]/g, '');" value="0">
                                            </div>
                                        </div>
                                        <div class="row mb-3">
                                            <div class="col-4">
                                                <label for="put_kembalian_penjualan"><small>Kembalian</small></label>
                                            </div>
                                            <div class="col-8">
                                                <input type="text" readonly name="kembalian" id="put_kembalian_penjualan" class="form-control form-control-lg form-money" oninput="this.value = this.value.replace(/[^0-9]/g, '');" value="0">
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="row mb-3">
                                    <div class="col-md-12" id="NotifikasiSimpanTransaksiPenjualan">
                                        <!-- Notifikasi Simpan Transaksi Penjualan -->
                                    </div>
                                </div>
                            </div>
                            <div class="card-footer text-center">
                                <button type="submit" class="btn btn-md btn-primary m-2" id="ButtonSimpanTransaksiPenjualan">
                                    <i class="bi bi-save"></i> Simpan Transaksi
                                </button>
                                <button type="button" class="btn btn-md btn-warning m-2" data-bs-toggle="modal" data-bs-target="#ModalResetTransaksi">
                                    <i class="bi bi-repeat"></i> Reset Transaksi
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
<?php
        }
    }
?>
<?php
    //Koneksi
    date_default_timezone_set('Asia/Jakarta');
    //Tangkap id_mitra
    if(empty($_GET['id'])){
        echo '<div class="card">';
        echo '  <div class="card-header">';
        echo '      <h4 class="card-title">Detail Supplier</h4>';
        echo '  </div>';
        echo '  <div class="card-body">';
        echo '      <div class="row">';
        echo '          <div class="col-md-12 mb-3 text-danger text-center">';
        echo '              ID Supplier Tidak Boleh Kosong.';
        echo '          </div>';
        echo '      </div>';
        echo '  </div>';
        echo '  <div class="card-footer">';
        echo '      Detail Supplier';
        echo '  </div>';
        echo '</div>';
    }else{
        //Bersihkan Variabel
        $id_supplier=validateAndSanitizeInput($_GET['id']);

        echo '<input type="hidden" name="id_supplier" id="put_id_supplier_on_detail" value="'.$id_supplier.'">';
?>
<div class="pagetitle">
    <h1>
        <a href="">
            <i class="bi bi-truck"></i> Supplier</a>
        </a>
    </h1>
    <nav>
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="index.php">Dashboard</a></li>
            <li class="breadcrumb-item"><a href="index.php?Page=Supplier">Supplier</a></li>
            <li class="breadcrumb-item active">Detail Supplier</li>
        </ol>
    </nav>
</div>
<section class="section dashboard">
    <div class="row mb-3">
        <div class="col-12">
            <div class="alert alert-warning alert-dismissible fade show" role="alert">
                <small>
                    Berikut ini adalah halaman yang menampilkan detail informasi supplier. 
                    Anda dapat melihat riwayat transaksi yang berlangsung pada supplier tersebut secara spesifik.
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </small>
            </div>
        </div>
    </div>
    <div class="row mb-3">
        <div class="col-lg-12">
            <div class="card">
                <div class="card-header">
                    <div class="row">
                        <div class="col-10">
                            <b class="card-title">
                                <i class="bi bi-info-circle"></i> Detail Supplier
                            </b>
                        </div>
                        <div class="col-2 text-end">
                            <a href="index.php?Page=Supplier" class="btn btn-md btn-dark btn-floating" title="Kembali Ke Data Supplier">
                                <i class="bi bi-chevron-left"></i>
                            </a>
                        </div>
                    </div>
                </div>
                <div class="card-body" id="detail_supplier">
                    <!-- Menampilkan Detail Supplier Disini -->
                </div>
                <div class="card-footer text-end">
                    <button type="button" class="btn btn-floating btn-md btn-secondary" data-bs-toggle="modal" data-bs-target="#ModalEditSupplier" data-id="<?php echo "$id_supplier"; ?>" mode="Detail" title="Edit Supplier">
                        <i class="bi bi-pencil"></i>
                    </button>
                    <button type="button" class="btn btn-floating btn-md btn-outline-danger" data-bs-toggle="modal" data-bs-target="#ModalHapusSupplier" data-id="<?php echo "$id_supplier"; ?>" mode="Detail" title="Hapus Supplier">
                        <i class="bi bi-trash"></i>
                    </button>
                </div>
            </div>
        </div>
    </div>
    <div class="row mb-3">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">
                    <div class="row">
                        <div class="col-9">
                            <b class="card-title"># Riwayat Transaksi</b>
                        </div>
                        <div class="col-3 text-end">
                            <a href="javascript:void(0);" class="btn btn-md btn-outline-secondary btn-floating" data-bs-toggle="modal" data-bs-target="#ModalExportTransaksi" title="Download/Export Data Riwayat Transaksi" data-id="<?php echo $id_supplier; ?>">
                                <i class="bi bi-download"></i>
                            </a>
                            <a href="javascript:void(0);" class="btn btn-md btn-secondary btn-floating" data-bs-toggle="modal" data-bs-target="#ModalFilterriwayatTransaksi" title="Filter Data / Cari Data">
                                <i class="bi bi-search"></i>
                            </a>
                        </div>
                    </div>
                </div>
                <div class="card-body">
                    <div class="table table-responsive">
                        <table class="table table-hover">
                            <thead>
                                <tr>
                                    <th><b>No</b></th>
                                    <th><b>Tanggal</b></th>
                                    <th><b>Kategori</b></th>
                                    <th><b>Subtotal</b></th>
                                    <th><b>PPN (Rp)</b></th>
                                    <th><b>Diskon (Rp)</b></th>
                                    <th><b>Total (Rp)</b></th>
                                    <th><b>Status</b></th>
                                </tr>
                            </thead>
                            <tbody id="TabelTransaksiSupplier">
                                <tr>
                                    <td colspan="8" class="text-center">
                                        <small class="text-danger">Tidak Ada Data Transaksi Yang Ditemukan</small>
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
                <div class="card-footer">
                    <div class="row">
                        <div class="col-6">
                            <small id="page_info_transaksi">
                                Page 1 Of 100
                            </small>
                        </div>
                        <div class="col-6 text-end">
                            <button type="button" class="btn btn-sm btn-outline-info btn-floating" id="prev_button_transaksi">
                                <i class="bi bi-chevron-left"></i>
                            </button>
                            <button type="button" class="btn btn-sm btn-outline-info btn-floating" id="next_button_transaksi">
                                <i class="bi bi-chevron-right"></i>
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="row mb-3">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">
                    <div class="row">
                        <div class="col-9">
                            <b class="card-title"># Riwayat Rincian Transaksi</b>
                        </div>
                        <div class="col-3 text-end">
                            <a href="javascript:void(0);" class="btn btn-md btn-outline-secondary btn-floating" data-bs-toggle="modal" data-bs-target="#ModalExportRincian" data-id="<?php echo $id_supplier; ?>" title="Download/Export Data Rincian Transaksi">
                                <i class="bi bi-download"></i>
                            </a>
                            <a href="javascript:void(0);" class="btn btn-md btn-secondary btn-floating" data-bs-toggle="modal" data-bs-target="#ModalFilterRincian" title="Filter Data / Cari Data">
                                <i class="bi bi-search"></i>
                            </a>
                        </div>
                    </div>
                </div>
                <div class="card-body">
                    <div class="table table-responsive">
                        <table class="table table-hover">
                            <thead>
                                <tr>
                                    <th><b>No</b></th>
                                    <th><b>Tanggal</b></th>
                                    <th><b>Nama Barang</b></th>
                                    <th><b>Harga</b></th>
                                    <th><b>QTY</b></th>
                                    <th><b>Satuan</b></th>
                                    <th><b>Subtotal</b></th>
                                    <th><b>PPN</b></th>
                                    <th><b>Diskon</b></th>
                                    <th><b>Jumlah</b></th>
                                </tr>
                            </thead>
                            <tbody id="TabelRincianTransaksiSupplier">
                                <tr>
                                    <td colspan="10" class="text-center">
                                        <small class="text-danger">Tidak Ada Data Transaksi Yang Ditemukan</small>
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
                <div class="card-footer">
                    <div class="row">
                        <div class="col-6">
                            <small id="page_info_rincian_transaksi">
                                Page 1 Of 100
                            </small>
                        </div>
                        <div class="col-6 text-end">
                            <button type="button" class="btn btn-sm btn-outline-info btn-floating" id="prev_button_rincian_transaksi">
                                <i class="bi bi-chevron-left"></i>
                            </button>
                            <button type="button" class="btn btn-sm btn-outline-info btn-floating" id="next_button_rincian_transaksi">
                                <i class="bi bi-chevron-right"></i>
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<?php } ?>
<div class="modal fade" id="ModalFilter" tabindex="-1">
    <div class="modal-dialog modal-md">
        <div class="modal-content">
            <form action="javascript:void(0);" id="ProsesFilter">
                <input type="hidden" name="page" id="page" value="1">
                <div class="modal-header">
                    <h5 class="modal-title text-dark"><i class="bi bi-funnel"></i> Filter Data</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="row mb-3">
                        <div class="col-4">
                            <label for="batas">
                                <small>Data/Limit</small>
                            </label>
                        </div>
                        <div class="col-8">
                            <select name="batas" id="batas" class="form-control">
                                <option value="5">5</option>
                                <option selected value="10">10</option>
                                <option value="25">25</option>
                                <option value="50">50</option>
                                <option value="100">100</option>
                                <option value="250">250</option>
                                <option value="500">500</option>
                            </select>
                        </div>
                    </div>
                    <div class="row mb-3">
                        <div class="col-4">
                            <label for="OrderBy">
                                <small>Mode Urutan</small>
                            </label>
                        </div>
                        <div class="col-8">
                            <select name="OrderBy" id="OrderBy" class="form-control">
                                <option value="">Pilih</option>
                                <option value="kategori">Kategori</option>
                                <option value="tanggal">Tanggal</option>
                                <option value="id_supplier">Supplier</option>
                                <option value="status">Status</option>
                            </select>
                        </div>
                    </div>
                    <div class="row mb-3">
                        <div class="col-4">
                            <label for="ShortBy">
                                <small>Tipe Urutan</small>
                            </label>
                        </div>
                        <div class="col-8">
                            <select name="ShortBy" id="ShortBy" class="form-control">
                                <option value="ASC">A To Z</option>
                                <option selected value="DESC">Z To A</option>
                            </select>
                        </div>
                    </div>
                    <div class="row mb-3">
                        <div class="col-4">
                            <label for="keyword_by">
                                <small>Pencarian</small>
                            </label>
                        </div>
                        <div class="col-8">
                            <select name="keyword_by" id="keyword_by" class="form-control">
                                <option value="">Pilih</option>
                                <option value="kategori">Kategori</option>
                                <option value="tanggal">Tanggal</option>
                                <option value="id_supplier">Supplier</option>
                                <option value="status">Status</option>
                            </select>
                        </div>
                    </div>
                    <div class="row mb-3">
                        <div class="col-4">
                            <label for="keyword">
                                <small>Kata Kunci</small>
                            </label>
                        </div>
                        <div class="col-8" id="FormFilterKeyword">
                            <input type="text" name="keyword" id="keyword" class="form-control">
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="submit" class="btn btn-success btn-rounded">
                        <i class="bi bi-save"></i> Filter
                    </button>
                    <button type="button" class="btn btn-dark btn-rounded" data-bs-dismiss="modal">
                        <i class="bi bi-x-circle"></i> Tutup
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
<div class="modal fade" id="ModalExportTransaksi" tabindex="-1">
    <div class="modal-dialog modal-md">
        <div class="modal-content">
            <form action="javascript:void(0);" id="ProsesExportTransaksi">
                <div class="modal-header">
                    <h5 class="modal-title text-dark"><i class="bi bi-download"></i> Export Transaksi</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="row mb-3">
                        <div class="col-12">
                            <small>
                                Pilih mode data transaksi atau rincian sesuai yang anda inginkan.
                            </small>
                        </div>
                    </div>
                    <div class="row mb-3">
                        <div class="col-4">
                            <label for="periode_1">
                                <small>Periode Awal</small>
                            </label>
                        </div>
                        <div class="col-8">
                            <input type="date" name="periode_1" id="periode_1" class="form-control">
                        </div>
                    </div>
                    <div class="row mb-3">
                        <div class="col-4">
                            <label for="periode_2">
                                <small>Periode Akhir</small>
                            </label>
                        </div>
                        <div class="col-8">
                            <input type="date" name="periode_2" id="periode_2" class="form-control">
                        </div>
                    </div>
                    <div class="row mb-3">
                        <div class="col-4">
                            <label for="mode_data">
                                <small>Mode Data</small>
                            </label>
                        </div>
                        <div class="col-8">
                            <select name="mode_data" id="mode_data" class="form-control">
                                <option value="Transaksi">Transaksi</option>
                                <option value="Rincian Transaksi">Rincian</option>
                            </select>
                        </div>
                    </div>
                    <div class="row mb-3">
                        <div class="col-md-12" id="NotifikasiExportTransaksi">
                            <div class="alert alert-warning">
                                <small>Semakin banyak data transaksi yang akan diexport, maka proses sistem membutuhkan waktu lebih lama.</small>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="submit" class="btn btn-success btn-rounded" id="ButtonExportTransaksi">
                        <i class="bi bi-download"></i> Export
                    </button>
                    <button type="button" class="btn btn-dark btn-rounded" data-bs-dismiss="modal">
                        <i class="bi bi-x-circle"></i> Tutup
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
<div class="modal fade" id="ModalTambahTransaksiPembelian" tabindex="-1">
    <div class="modal-dialog modal-md">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title text-dark"><i class="bi bi-plus"></i> Tambah Transaksi Pembelian</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div class="row mb-3">
                    <div class="col-md-12">
                        <div class="alert alert-success">
                            <small>
                                <h3>
                                    <a href="index.php?Page=Pembelian&Sub=TambahPembelian&retur=Tidak" class="text-success">
                                        <i class="bi bi-cart-check"></i> Pembelian
                                    </a>
                                </h3>
                                Buat transaksi Pembelian baru. Hubungkan Pembelian dengan data Supplier dan cetak nota transaksi.
                            </small>
                        </div>
                    </div>
                </div>
                <div class="row mb-3">
                    <div class="col-md-12">
                        <div class="alert alert-warning">
                            <small>
                                <h3>
                                    <a href="index.php?Page=Pembelian&Sub=TambahPembelian&retur=Ya" class="text-warning">
                                        <i class="bi bi-arrow-left-right"></i> Retur Pembelian
                                    </a>
                                </h3>
                                Buat faktur transaksi retur Pembelian (pengembalian Pembelian barang) dari transaksi sebelumnya.
                            </small>
                        </div>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-dark btn-rounded" data-bs-dismiss="modal">
                    <i class="bi bi-x-circle"></i> Tutup
                </button>
            </div>
        </div>
    </div>
</div>
<div class="modal fade" id="ModalCariBarang" tabindex="-1">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title text-dark"><i class="bi bi-search"></i> Cari Barang</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div class="row mb-3">
                    <div class="col-12">
                        <form action="javascript:void(0);" id="ProsesCariBarang">
                            <input type="hidden" name="page" id="put_page_cari_barang" value="1">
                            <div class="input-group">
                                <input type="text" class="form-control" name="keyword" id="keyword_barang" placeholder="Nama Barang / Kode">
                                <button type="submit" class="btn btn-md btn-primary">
                                    <i class="bi bi-search"></i> Cari
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
                <div class="row mb-3">
                    <div class="col-md-12">
                        <div class="table table-responsive">
                            <table class="table table-hover table-striped">
                                <thead>
                                    <tr>
                                        <th><b>No</b></th>
                                        <th><b>Kode</b></th>
                                        <th><b>Nama Barang</b></th>
                                        <th><b>Stok</b></th>
                                        <th><b>Opsi</b></th>
                                    </tr>
                                </thead>
                                <tbody id="TabelBarang">
                                    <tr>
                                        <td colspan="5" class="text-center">
                                            <small class="text-danger">Tidak Ada Data Yang Ditampilkan</small>
                                        </td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
                <div class="row mb-3">
                    <div class="col-6">
                        <small id="page_info_barang">
                            Page 1 Of 100
                        </small>
                    </div>
                    <div class="col-6 text-end">
                        <button type="button" class="btn btn-sm btn-outline-info btn-floating" id="prev_button_barang">
                            <i class="bi bi-chevron-left"></i>
                        </button>
                        <button type="button" class="btn btn-sm btn-outline-info btn-floating" id="next_button_barang">
                            <i class="bi bi-chevron-right"></i>
                        </button>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-dark btn-rounded" data-bs-dismiss="modal">
                    <i class="bi bi-x-circle"></i> Tutup
                </button>
            </div>
        </div>
    </div>
</div>
<div class="modal fade" id="ModalScanBarang" tabindex="-1">
    <div class="modal-dialog modal-md">
        <div class="modal-content">
            <form action="javascript:void(0);" id="ProsesScanCode">
                <input type="hidden" name="kategori_transaksi" id="put_kategori_transaksi_scan">
                <div class="modal-header">
                    <h5 class="modal-title text-dark"><i class="bi bi-qr-code-scan"></i> Scan Code</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="row mb-3">
                        <div class="col-12">
                            <label for="keyword_code">Kode Barang</label>
                            <input type="text" class="form-control form-control-lg" name="keyword_code" id="keyword_code" placeholder="Kode Barang">
                        </div>
                    </div>
                    <div class="row mb-3">
                        <div class="col-6">
                            <label for="qty_scan_code">QTY</label>
                            <input type="number" min="1" class="form-control" name="qty_scan_code" id="qty_scan_code" value="1">
                        </div>
                        <div class="col-6">
                            <label for="id_barang_kategori_harga_scan">Kategori Harga</label>
                            <select name="id_barang_kategori_harga" id="id_barang_kategori_harga_scan" class="form-control">
                                <option value="">Harga Beli</option>
                            </select>
                        </div>
                    </div>
                    <div class="row mb-3 mt-3">
                        <div class="col-md-12" id="preview_hasil_sacan">
                            <div class="alert alert-danger">
                                <small>Silahkan Scan Kode Barang Terlebih Dulu</small>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-12" id="NotifikasiScanCode">
                            <!-- Notifikasi Scan Code -->
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="submit" class="btn btn-md btn-primary btn-rounded">
                        <i class="bi bi-plus"></i> Tambahkan
                    </button>
                    <button type="button" class="btn btn-dark btn-rounded" data-bs-dismiss="modal">
                        <i class="bi bi-x-circle"></i> Tutup
                    </button>
                </div>
            </div>
        </form>
    </div>
</div>
<div class="modal fade" id="ModalTambahBarang" tabindex="-1">
    <div class="modal-dialog modal-md">
        <div class="modal-content">
            <form action="javascript:void(0);" id="ProsesTambahBarang">
                <div class="modal-header">
                    <h5 class="modal-title text-dark"><i class="bi bi-plus"></i> Tambah Rincian</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="row mb-3">
                        <div class="col-12" id="FormTambahBarang">
                            <!-- Form Tambah Bulk -->
                        </div>
                    </div>
                    <div class="row mb-3">
                        <div class="col-12" id="SimulasiRincian">
                            <!-- Menampilkan Simulasi Rincian Disini -->
                        </div>
                    </div>
                    <div class="row mb-3">
                        <div class="col-12" id="NotifikasiTambahBarang">
                            <!-- Notifikasi Tambah Bulk Disini -->
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="submit" class="btn btn-md btn-primary btn-rounded">
                        <i class="bi bi-plus"></i> Tambahkan
                    </button>
                    <button type="button" class="btn btn-dark btn-rounded" data-bs-toggle="modal" data-bs-target="#ModalCariBarang">
                        <i class="bi bi-chevron-left"></i> Kembali
                    </button>
                </div>
            </div>
        </form>
    </div>
</div>
<div class="modal fade" id="ModalEditBulk" tabindex="-1">
    <div class="modal-dialog modal-md">
        <div class="modal-content">
            <form action="javascript:void(0);" id="ProsesEditBulk">
                <div class="modal-header">
                    <h5 class="modal-title text-dark"><i class="bi bi-pencil"></i> Edit Rincian</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="row mb-3">
                        <div class="col-12" id="FormEditBulk">
                            <!-- Form Edit Rincian Bulk -->
                        </div>
                    </div>
                    <div class="row mb-3">
                        <div class="col-12" id="NotifikasiEditBulk">
                            <!-- Notifikasi Edit Bulk Barang Disini -->
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="submit" class="btn btn-md btn-primary btn-rounded">
                        <i class="bi bi-save"></i> Simpan
                    </button>
                    <button type="button" class="btn btn-dark btn-rounded" data-bs-dismiss="modal">
                        <i class="bi bi-x-circle"></i> Tutup
                    </button>
                </div>
            </div>
        </form>
    </div>
</div>
<div class="modal fade" id="ModalHapusBulk" tabindex="-1">
    <div class="modal-dialog modal-md">
        <div class="modal-content">
            <form action="javascript:void(0);" id="ProsesHapusBulk">
                <div class="modal-header">
                    <h5 class="modal-title text-dark"><i class="bi bi-trash"></i> Hapus Rincian</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="row mb-3">
                        <div class="col-12" id="FormHapusBulk">
                            <!-- Form Hapus Rincian Bulk -->
                        </div>
                    </div>
                    <div class="row mb-3">
                        <div class="col-12" id="NotifikasiHapusBulk">
                            <!-- Notifikasi Hapus Bulk Disini -->
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="submit" class="btn btn-md btn-success btn-rounded" id="ButtonHapusBulk">
                        <i class="bi bi-check"></i> Ya, Hapus
                    </button>
                    <button type="button" class="btn btn-dark btn-rounded" data-bs-dismiss="modal">
                        <i class="bi bi-x-circle"></i> Tidak
                    </button>
                </div>
            </div>
        </form>
    </div>
</div>
<div class="modal fade" id="ModalPilihSupplier" tabindex="-1">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title text-dark">
                    <i class="bi bi-person"></i> Pilih Supplier
                </h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div class="row mb-3">
                    <div class="col col-12 col-md-4 text-end">
                        <label for="keyword_Supplier">
                            <small>Cari Supplier</small>
                        </label>
                    </div>
                    <div class="col col-12 col-md-8">
                        <form action="javascript:void(0);" id="ProsesCariSupplier">
                            <input type="hidden" name="page" id="page_supplier" value="1">
                            <div class="input-group">
                                <input type="text" class="form-control" name="keyword" id="keyword_supplier">
                                <button type="submit" class="btn btn-md btn-primary">
                                    <i class="bi bi-search"></i> Cari
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
                <div class="row mb-3 border-1 border-top border-bottom">
                    <div class="col-12 mt-3 mb-3">
                        <div class="table table-responsive">
                            <table class="table table-hover table-striped">
                                <thead>
                                    <tr>
                                        <th><b>No</b></th>
                                        <th><b>Supplier</b></th>
                                        <th><b>Kontak</b></th>
                                        <th><b>Opsi</b></th>
                                    </tr>
                                </thead>
                                <tbody id="TabelSupplier">
                                    <tr>
                                        <td colspan="4" class="text-center">
                                            <span>Tidak Ada Data Supplier Yang Ditampilkan</span>
                                        </td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
                <div class="row mb-3">
                    <div class="col-6">
                        <small id="page_info_supplier">
                            Page 1 Of 100
                        </small>
                    </div>
                    <div class="col-6 text-end">
                        <button type="button" class="btn btn-sm btn-outline-info btn-floating" id="prev_button_supplier">
                            <i class="bi bi-chevron-left"></i>
                        </button>
                        <button type="button" class="btn btn-sm btn-outline-info btn-floating" id="next_button_supplier">
                            <i class="bi bi-chevron-right"></i>
                        </button>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-dark btn-rounded" data-bs-dismiss="modal">
                    <i class="bi bi-x-circle"></i> tutup
                </button>
            </div>
        </div>
    </div>
</div>
<div class="modal fade" id="ModalResetTransaksi" tabindex="-1">
    <div class="modal-dialog modal-md">
        <div class="modal-content">
            <form action="javascript:void(0);" id="ProsesResetTransaksi">
                <input type="hidden" name="kategori_transaksi" id="put_kategori_transaksi_for_reset">
                <div class="modal-header">
                    <h5 class="modal-title text-dark"><i class="bi bi-repeat"></i> Reset Transaksi</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="row mb-3">
                        <div class="col-12">
                            <div class="alert alert-warning">
                                <b>Keterangan</b>
                                <p>
                                    Dengan melakukan reset maka sistem akan menghapus semua rincian barang pada transaksi ini. 
                                    Pilih tombol reset untuk mulai melakukan reset transaksi.
                                </p>
                                
                            </div>
                        </div>
                    </div>
                    <div class="row mb-3">
                        <div class="col-12" id="NotifikasiResetTransaksi">
                            <!-- Notifikasi Reset Transaksi Disini -->
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="submit" class="btn btn-md btn-success btn-rounded" id="ButtonResetTransaksi">
                        <i class="bi bi-check"></i> Reset
                    </button>
                    <button type="button" class="btn btn-dark btn-rounded" data-bs-dismiss="modal">
                        <i class="bi bi-x-circle"></i> Tutup
                    </button>
                </div>
            </div>
        </form>
    </div>
</div>
<div class="modal fade" id="ModalDetail" tabindex="-1">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <form action="index.php" method="GET">
                <input type="hidden" name="Page" value="Pembelian">
                <input type="hidden" name="Sub" value="DetailPembelian">
                <div class="modal-header">
                    <h5 class="modal-title text-dark"><i class="bi bi-info-circle"></i> Detail Transaksi</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="row mb-3">
                        <div class="col-12" id="FormDetail">
                            <!-- Form Detail Transaksi Disini -->
                        </div>
                    </div>
                    <div class="row mb-3">
                        <div class="col-12">
                            <div class="table table-responsive">
                                <table class="table table-hover table-striped">
                                    <thead>
                                        <tr>
                                            <th><b>No</b></th>
                                            <th><b>Barang</b></th>
                                            <th><b>QTY</b></th>
                                            <th><b>Harga</b></th>
                                            <th><b>PPN</b></th>
                                            <th><b>Diskon</b></th>
                                            <th><b>Subtotal</b></th>
                                        </tr>
                                    </thead>
                                    <tbody id="ListDetail">
                                        <!-- List Detail Transaksi Disini -->
                                    </tbody>
                                </table>
                            </div>
                            
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="submit" class="btn btn-md btn-outline-info btn-rounded" id="ButtonSelengkapnya">
                        <i class="bi bi-three-dots"></i> Selengkapnya
                    </button>
                    <button type="button" class="btn btn-dark btn-rounded" data-bs-dismiss="modal">
                        <i class="bi bi-x-circle"></i> Tutup
                    </button>
                </div>
            </div>
        </form>
    </div>
</div>
<div class="modal fade" id="ModalCetak" tabindex="-1">
    <div class="modal-dialog modal-md">
        <div class="modal-content">
            <form action="javascript:void(0);" id="ProsesCetak">
                <div class="modal-header">
                    <h5 class="modal-title text-dark"><i class="bi bi-printer"></i> Cetak Transaksi</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="row mb-3">
                        <div class="col-12" id="FormDetailCetak">
                            
                        </div>
                    </div>
                    <div class="row mb-3">
                        <div class="col-12">
                            <small>
                                Pilih Mode Percetakan Yang Anda Inginkan
                            </small>
                            <div class="form-check">
                                <input class="form-check-input" type="radio" name="tipe_cetak" id="tipe_cetak_1" value="PDF">
                                <label class="form-check-label" for="tipe_cetak_1">
                                    <small>Format PDF</small>
                                </label>
                            </div>
                            <div class="form-check">
                                <input class="form-check-input" type="radio" name="tipe_cetak" id="tipe_cetak_2" value="Image">
                                <label class="form-check-label" for="tipe_cetak_2">
                                    <small>Format Image</small>
                                </label>
                            </div>
                            <div class="form-check">
                                <input class="form-check-input" type="radio" name="tipe_cetak" id="tipe_cetak_3" value="Direct">
                                <label class="form-check-label" for="tipe_cetak_3">
                                    <small>Direct Print</small>
                                </label>
                            </div>
                        </div>
                    </div>
                    <div class="row mb-3">
                        <div class="col-12" id="NotifikasiCetak">
                            <!-- Notifikasi Cetak Transaksi Disini -->
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="submit" class="btn btn-md btn-success btn-rounded" id="ButtonCetak">
                        <i class="bi bi-printer"></i> Cetak
                    </button>
                    <button type="button" class="btn btn-dark btn-rounded" data-bs-dismiss="modal">
                        <i class="bi bi-x-circle"></i> Tutup
                    </button>
                </div>
            </div>
        </form>
    </div>
</div>
<div class="modal fade" id="ModalEdit" tabindex="-1">
    <div class="modal-dialog modal-md">
        <div class="modal-content">
            <form action="javascript:void(0);" id="ProsesEdit">
                <div class="modal-header">
                    <h5 class="modal-title text-dark"><i class="bi bi-pencil"></i> Edit Transaksi</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="row mb-3">
                        <div class="col-12" id="FormEdit">
                            <!-- Form Edit Transaksi Disini -->
                        </div>
                    </div>
                    <div class="row mb-3">
                        <div class="col-12" id="NotifikasiEdit">
                            <!-- Notifikasi Edit Transaksi Disini -->
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="submit" class="btn btn-md btn-success btn-rounded" id="ButtonEdit">
                        <i class="bi bi-save"></i> Simpan
                    </button>
                    <button type="button" class="btn btn-dark btn-rounded" data-bs-dismiss="modal">
                        <i class="bi bi-x-circle"></i> Tutup
                    </button>
                </div>
            </div>
        </form>
    </div>
</div>
<div class="modal fade" id="ModalHapus" tabindex="-1">
    <div class="modal-dialog modal-md">
        <div class="modal-content">
            <form action="javascript:void(0);" id="ProsesHapus">
                <div class="modal-header">
                    <h5 class="modal-title text-dark"><i class="bi bi-trash"></i> Hapus Transaksi</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="row mb-3">
                        <div class="col-12" id="FormHapus">
                            
                        </div>
                    </div>
                    <div class="row mb-3">
                        <div class="col-12" id="NotifikasiHapus">
                            <!-- Notifikasi Reset Transaksi Disini -->
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="submit" class="btn btn-md btn-success btn-rounded" id="ButtonHapus">
                        <i class="bi bi-check"></i> Ya, Hapus
                    </button>
                    <button type="button" class="btn btn-dark btn-rounded" data-bs-dismiss="modal">
                        <i class="bi bi-x-circle"></i> Tutup
                    </button>
                </div>
            </div>
        </form>
    </div>
</div>

<div class="modal fade" id="ModalListSupplierEdit" tabindex="-1">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title text-dark">
                    <i class="bi bi-person"></i> Pilih Supplier
                </h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div class="row mb-3">
                    <div class="col col-12 col-md-4 text-end">
                        <label for="keyword_Supplier">
                            <small>Cari Supplier</small>
                        </label>
                    </div>
                    <div class="col col-12 col-md-8">
                        <form action="javascript:void(0);" id="ProsesCariSupplierEdit">
                            <input type="hidden" name="page" id="page_supplier_edit" value="1">
                            <input type="hidden" name="id_transaksi_jual_beli" id="put_id_transaksi_jual_beli_supplier_edit">
                            <input type="hidden" name="mode" id="put_mode_edit_supplier">
                            <div class="input-group">
                                <input type="text" class="form-control" name="keyword" id="keyword_supplier_edit">
                                <button type="submit" class="btn btn-md btn-primary">
                                    <i class="bi bi-search"></i> Cari
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
                <div class="row mb-3 border-1 border-top border-bottom">
                    <div class="col-12 mt-3 mb-3">
                        <div class="table table-responsive">
                            <table class="table table-hover table-striped">
                                <thead>
                                    <tr>
                                        <th><b>No</b></th>
                                        <th><b>Supplier</b></th>
                                        <th><b>Kontak</b></th>
                                        <th><b>Opsi</b></th>
                                    </tr>
                                </thead>
                                <tbody id="TabelSupplierEdit">
                                    <tr>
                                        <td colspan="4" class="text-center">
                                            <span>Tidak Ada Data Supplier Yang Ditampilkan</span>
                                        </td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
                <div class="row mb-3">
                    <div class="col-6">
                        <small id="page_info_supplier_edit">
                            Page 1 Of 100
                        </small>
                    </div>
                    <div class="col-6 text-end">
                        <button type="button" class="btn btn-sm btn-outline-info btn-floating" id="prev_button_supplier_edit">
                            <i class="bi bi-chevron-left"></i>
                        </button>
                        <button type="button" class="btn btn-sm btn-outline-info btn-floating" id="next_button_supplier_edit">
                            <i class="bi bi-chevron-right"></i>
                        </button>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-dark btn-rounded" data-bs-dismiss="modal">
                    <i class="bi bi-x-circle"></i> tutup
                </button>
            </div>
        </div>
    </div>
</div>
<div class="modal fade" id="ModalEditSupplier" tabindex="-1">
    <div class="modal-dialog modal-md">
        <div class="modal-content">
            <form action="javascript:void(0);" id="ProsesEditSupplier">
                <div class="modal-header">
                    <h5 class="modal-title text-dark"><i class="bi bi-person"></i> Ganti Informasi Supplier</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="row mb-3">
                        <div class="col-12" id="FormEditSupplier">
                            <!-- Form Edit Transaksi Disini -->
                        </div>
                    </div>
                    <div class="row mb-3">
                        <div class="col-12" id="NotifikasiEditSupplier">
                            <!-- Notifikasi Edit Transaksi Disini -->
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="submit" class="btn btn-md btn-success btn-rounded" id="ButtonEditSupplier">
                        <i class="bi bi-save"></i> Simpan
                    </button>
                    <button type="button" class="btn btn-dark btn-rounded" data-bs-dismiss="modal">
                        <i class="bi bi-x-circle"></i> Tutup
                    </button>
                </div>
            </div>
        </form>
    </div>
</div>
<div class="modal fade" id="ModalListBarangEdit" tabindex="-1">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title text-dark"><i class="bi bi-search"></i> Cari Barang</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div class="row mb-3">
                    <div class="col-12">
                        <form action="javascript:void(0);" id="ProsesCariBarangEdit">
                            <input type="hidden" name="page" id="put_page_cari_barang_edit" value="1">
                            <div class="input-group">
                                <input type="text" class="form-control" name="keyword" id="keyword_barang_edit" placeholder="Nama Barang / Kode">
                                <button type="submit" class="btn btn-md btn-primary">
                                    <i class="bi bi-search"></i> Cari
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
                <div class="row mb-3">
                    <div class="col-md-12">
                        <div class="table table-responsive">
                            <table class="table table-hover table-striped">
                                <thead>
                                    <tr>
                                        <th><b>No</b></th>
                                        <th><b>Kode</b></th>
                                        <th><b>Nama Barang</b></th>
                                        <th><b>Stok</b></th>
                                        <th><b>Opsi</b></th>
                                    </tr>
                                </thead>
                                <tbody id="TabelBarangEdit">
                                    <tr>
                                        <td colspan="5" class="text-center">
                                            <small class="text-danger">Tidak Ada Data Yang Ditampilkan</small>
                                        </td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
                <div class="row mb-3">
                    <div class="col-6">
                        <small id="page_info_barang_edit">
                            Page 1 Of 100
                        </small>
                    </div>
                    <div class="col-6 text-end">
                        <button type="button" class="btn btn-sm btn-outline-info btn-floating" id="prev_button_barang_edit">
                            <i class="bi bi-chevron-left"></i>
                        </button>
                        <button type="button" class="btn btn-sm btn-outline-info btn-floating" id="next_button_barang_edit">
                            <i class="bi bi-chevron-right"></i>
                        </button>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-dark btn-rounded" data-bs-dismiss="modal">
                    <i class="bi bi-x-circle"></i> Tutup
                </button>
            </div>
        </div>
    </div>
</div>
<div class="modal fade" id="ModalTambahBarangEdit" tabindex="-1">
    <div class="modal-dialog modal-md">
        <div class="modal-content">
            <form action="javascript:void(0);" id="ProsesTambahBarangEdit">
                <div class="modal-header">
                    <h5 class="modal-title text-dark"><i class="bi bi-plus"></i> Tambah Rincian</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="row mb-3">
                        <div class="col-12" id="FormTambahBarangEdit">
                            <!-- Form Tambah Bulk -->
                        </div>
                    </div>
                    <div class="row mb-3">
                        <div class="col-12" id="SimulasiRincianEdit">
                            <!-- Menampilkan Simulasi Rincian Disini -->
                        </div>
                    </div>
                    <div class="row mb-3">
                        <div class="col-12" id="NotifikasiTambahBarangEdit">
                            <!-- Notifikasi Tambah Bulk Disini -->
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="submit" class="btn btn-md btn-primary btn-rounded">
                        <i class="bi bi-plus"></i> Tambahkan
                    </button>
                    <button type="button" class="btn btn-dark btn-rounded" data-bs-toggle="modal" data-bs-target="#ModalListBarangEdit">
                        <i class="bi bi-chevron-left"></i> Kembali
                    </button>
                </div>
            </div>
        </form>
    </div>
</div>

<div class="modal fade" id="ModalEditRincian" tabindex="-1">
    <div class="modal-dialog modal-md">
        <div class="modal-content">
            <form action="javascript:void(0);" id="ProsesEditRincian">
                <div class="modal-header">
                    <h5 class="modal-title text-dark"><i class="bi bi-plus"></i> Edit Rincian Transaksi</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="row mb-3">
                        <div class="col-12">
                            <input type="hidden" name="id_transaksi_jual_beli_rincian" id="put_id_transaksi_jual_beli_rincian_edit">
                            <div class="row mb-3">
                                <div class="col-4">
                                    <small>Nama Barang</small>
                                </div>
                                <div class="col-8">
                                    <small class="text text-grayish" id="put_nama_barang_edit_rincian"></small>
                                </div>
                            </div>
                            <div class="row mb-3">
                                <div class="col-4">
                                    <label for="qty_edit_rincian">
                                        <small>QTY/Satuan</small>
                                    </label>
                                </div>
                                <div class="col-8">
                                    <div class="input-group">
                                        <span class="input-group-text">.00</span>
                                        <input type="text" name="qty" id="qty_edit_rincian" class="form-control" oninput="this.value = this.value.replace(/[^0-9.]/g, '').replace(/(\..*?)\..*/g, '$1');">
                                        <span class="input-group-text" id="put_satuan_edit_rincian">

                                        </span>
                                    </div>
                                </div>
                            </div>
                            <div class="row mb-3">
                                <div class="col-4">
                                    <label for="harga_edit_rincian">
                                        <small>Harga</small>
                                    </label>
                                </div>
                                <div class="col-8">
                                    <div class="input-group">
                                        <span class="input-group-text">Rp</span>
                                        <input type="text" name="harga" id="harga_edit_rincian" class="form-control form-money" oninput="this.value = this.value.replace(/[^0-9]/g, '');">
                                    </div>
                                </div>
                            </div>
                            <div class="row mb-3">
                                <div class="col-4">
                                    <label for="ppn_edit_rincian">
                                        <small>PPN</small>
                                    </label>
                                </div>
                                <div class="col-8">
                                    <div class="input-group">
                                        <span class="input-group-text">Rp</span>
                                        <input type="text" name="ppn" id="ppn_edit_rincian" class="form-control form-money" oninput="this.value = this.value.replace(/[^0-9]/g, '');">
                                    </div>
                                </div>
                            </div>
                            <div class="row mb-3">
                                <div class="col-4">
                                    <label for="diskon_edit_rincian"><small>Diskon</small></label>
                                </div>
                                <div class="col-8">
                                    <div class="input-group">
                                        <span class="input-group-text">Rp</span>
                                        <input type="text" name="diskon" id="diskon_edit_rincian" class="form-control form-money" oninput="this.value = this.value.replace(/[^0-9]/g, '');">
                                    </div>
                                </div>
                            </div>
                            <div class="row mb-3">
                                <div class="col-4">
                                    <label for="jumlah_edit_rincian"><small>Jumlah</small></label>
                                </div>
                                <div class="col-8">
                                    <div class="input-group">
                                        <span class="input-group-text">Rp</span>
                                        <input type="text" readonly name="jumlah" id="jumlah_edit_rincian" class="form-control form-money" oninput="this.value = this.value.replace(/[^0-9]/g, '');">
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="row mb-3">
                        <div class="col-12" id="NotifikasiEditRincian">
                            <!-- Notifikasi Tambah Bulk Disini -->
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="submit" class="btn btn-md btn-primary btn-rounded" id="ButtonEditRincian">
                        <i class="bi bi-save"></i> Simpan
                    </button>
                    <button type="button" class="btn btn-dark btn-rounded" data-bs-dismiss="modal">
                        <i class="bi bi-x"></i> Tutup
                    </button>
                </div>
            </div>
        </form>
    </div>
</div>
<div class="modal fade" id="ModalHapusRincian" tabindex="-1">
    <div class="modal-dialog modal-md">
        <div class="modal-content">
            <form action="javascript:void(0);" id="ProssesHapusRincian">
                <input type="hidden" name="id_transaksi_jual_beli_rincian" id="put_id_transaksi_jual_beli_rincian_hapus">
                <div class="modal-header">
                    <h5 class="modal-title text-dark"><i class="bi bi-trash"></i> Hapus Rincian</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="row mb-3">
                        <div class="col-12" id="FormHapusRincian">
                            <!-- Form Tambah Bulk -->
                        </div>
                    </div>
                    <div class="row mb-3">
                        <div class="col-12" id="NotifikasiHapusRincian">
                            <!-- Notifikasi Tambah Bulk Disini -->
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="submit" class="btn btn-md btn-primary btn-rounded" id="ButtonHapusRincian">
                        <i class="bi bi-check"></i> Ya, Hapus
                    </button>
                    <button type="button" class="btn btn-dark btn-rounded" data-bs-dismiss="modal">
                        <i class="bi bi-x"></i> Tutup
                    </button>
                </div>
            </div>
        </form>
    </div>
</div>
<div class="modal fade" id="ModalTambahJurnal" tabindex="-1">
    <div class="modal-dialog modal-md">
        <div class="modal-content">
            <form action="javascript:void(0);" id="ProsesTambahJurnal">
                <div class="modal-header">
                    <h5 class="modal-title text-dark"><i class="bi bi-plus"></i> Tambah Jurnal Pembelian</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="row mb-3">
                        <div class="col-12" id="FormiTambahJurnal">
                            <!-- Form Tambah Jurnal Pembelian Disini -->
                        </div>
                    </div>
                    <div class="row mb-3">
                        <div class="col-12" id="NotifikasiTambahJurnal">
                            <!-- Notifikasi Jurnal Pembelian Disini -->
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="submit" class="btn btn-md btn-primary btn-rounded" id="ButtonTambahJurnal">
                        <i class="bi bi-save"></i> Simpan
                    </button>
                    <button type="button" class="btn btn-dark btn-rounded" data-bs-dismiss="modal">
                        <i class="bi bi-x"></i> Tutup
                    </button>
                </div>
            </div>
        </form>
    </div>
</div>
<div class="modal fade" id="ModalEditJurnal" tabindex="-1">
    <div class="modal-dialog modal-md">
        <div class="modal-content">
            <form action="javascript:void(0);" id="ProsesEditJurnal">
                <div class="modal-header">
                    <h5 class="modal-title text-dark"><i class="bi bi-pencil"></i> Edit Jurnal Pembelian</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="row mb-3">
                        <div class="col-12" id="FormEditJurnal">
                            <!-- Form Tambah Jurnal Pembelian -->
                        </div>
                    </div>
                    <div class="row mb-3">
                        <div class="col-12" id="NotifikasiEditJurnal">
                            <!-- Notifikasi Jurnal Pembelian Disini -->
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="submit" class="btn btn-md btn-primary btn-rounded" id="ButtonEditJurnal">
                        <i class="bi bi-save"></i> Simpan
                    </button>
                    <button type="button" class="btn btn-dark btn-rounded" data-bs-dismiss="modal">
                        <i class="bi bi-x"></i> Tutup
                    </button>
                </div>
            </div>
        </form>
    </div>
</div>
<div class="modal fade" id="ModalHapusJurnal" tabindex="-1">
    <div class="modal-dialog modal-md">
        <div class="modal-content">
            <form action="javascript:void(0);" id="ProsesHapusJurnal">
                <div class="modal-header">
                    <h5 class="modal-title text-dark"><i class="bi bi-trash"></i> Hapus Jurnal Pembelian</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="row mb-3">
                        <div class="col-12" id="FormHapusJurnal">
                            <!-- Form Tambah Jurnal Pembelian -->
                        </div>
                    </div>
                    <div class="row mb-3">
                        <div class="col-12" id="NotifikasiHapusJurnal">
                            <!-- Notifikasi Jurnal Pembelian Disini -->
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="submit" class="btn btn-md btn-primary btn-rounded" id="ButtonHapusJurnal">
                        <i class="bi bi-check"></i> Ya, Hapus
                    </button>
                    <button type="button" class="btn btn-dark btn-rounded" data-bs-dismiss="modal">
                        <i class="bi bi-x"></i> Tutup
                    </button>
                </div>
            </div>
        </form>
    </div>
</div>
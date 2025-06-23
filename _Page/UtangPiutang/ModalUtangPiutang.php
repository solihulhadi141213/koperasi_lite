<div class="modal fade" id="ModalFilterPenjualan" tabindex="-1">
    <div class="modal-dialog modal-md">
        <div class="modal-content">
            <form action="javascript:void(0);" id="ProsesFilterPenjualan">
                <input type="hidden" name="page" id="page_penjualan" value="1">
                <div class="modal-header">
                    <h5 class="modal-title text-dark"><i class="bi bi-funnel"></i> Filter Penjualan</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="row mb-3">
                        <div class="col col-md-4"><label for="batas_penjualan">Limit Data</label></div>
                        <div class="col col-md-8">
                            <select name="batas" id="batas_penjualan" class="form-control">
                                <option value="5">5</option>
                                <option selected value="10">10</option>
                                <option value="25">25</option>
                                <option value="50">50</option>
                                <option value="100">100</option>
                                <option value="250">250</option>
                                <option value="500">500</option>
                            </select>
                            <small class="credit">
                                <code class="text text-grayish">Jumlah baris data dalam satu halaman</code>
                            </small>
                        </div>
                    </div>
                    <div class="row mb-3">
                        <div class="col col-md-4"><label for="OrderByPenjualan">Mode Urutan</label></div>
                        <div class="col col-md-8">
                            <select name="OrderBy" id="OrderByPenjualan" class="form-control">
                                <option value="">Pilih</option>
                                <option value="kategori">Kategori</option>
                                <option value="tanggal">Tanggal</option>
                                <option value="nama">Anggota</option>
                            </select>
                        </div>
                    </div>
                    <div class="row mb-3">
                        <div class="col col-md-4"><label for="ShortByPenjualan">Tipe urutan</label></div>
                        <div class="col col-md-8">
                            <select name="ShortBy" id="ShortByPenjualan" class="form-control">
                                <option value="DESC">Z To A</option>
                                <option value="ASC">A To Z</option>
                            </select>
                        </div>
                    </div>
                    <div class="row mb-3">
                        <div class="col col-md-4"><label for="keyword_by_penjualan">Pencarian</label></div>
                        <div class="col col-md-8">
                            <select name="keyword_by" id="keyword_by_penjualan" class="form-control">
                                <option value="">Pilih</option>
                                <<option value="kategori">Kategori</option>
                                <option value="tanggal">Tanggal</option>
                                <option value="nama">Anggota</option>
                            </select>
                        </div>
                    </div>
                    <div class="row mb-3">
                        <div class="col col-md-4"><label for="keyword_penjualan">Kata Kunci</label></div>
                        <div class="col col-md-8" id="FormFilterPenjualan">
                            <input type="text" name="keyword" id="keyword_penjualan" class="form-control">
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="submit" class="btn btn-success btn-rounded">
                        <i class="bi bi-filter"></i> Filter
                    </button>
                    <button type="button" class="btn btn-dark btn-rounded" data-bs-dismiss="modal">
                        <i class="bi bi-x-circle"></i> Tutup
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
<div class="modal fade" id="ModalDetailPenjualan" tabindex="-1">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <form action="index.php" method="GET">
                <input type="hidden" name="Page" value="Penjualan">
                <input type="hidden" name="Sub" value="DetailPenjualan">
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
<div class="modal fade" id="ModalPembayaranPenjualanMultiple" tabindex="-1">
    <div class="modal-dialog modal-xl">
        <div class="modal-content">
            <form action="javascript:void(0);" id="ProsesPembayaranPenjualanMultiple">
                <div class="modal-header">
                    <h5 class="modal-title text-dark">
                        <i class="bi bi-plus"></i> Pembayaran Utang/Piutang
                    </h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="row">
                        <div class="col-12">
                            <div class="table table-responsive">
                                <table class="table table-bordered table-hover table-striped">
                                    <thead>
                                        <tr>
                                            <th><b>#</b></th>
                                            <th><b>Tgl.Transaksi</b></th>
                                            <th><b>Kategori</b></th>
                                            <th><b>Anggota</b></th>
                                            <th><b>Nominal</b></th>
                                            <th><b>Status</b></th>
                                        </tr>
                                    </thead>
                                    <tbody id="ListPembayaranPenjualanMultiple">
                                        <tr>
                                            <td colspan="6" class="text-center">
                                                <small>Tidak Ada Data Yang Ditampilkan</small>
                                            </td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                    <div class="row mb-3">
                        <div class="col-12">
                            <label for="tanggal_pembayaran_piutang_multi">
                                <small class="text-muted">Tangga/Jam Pembayaran</small>
                            </label>
                        </div>
                        <div class="col-4">
                            <input type="date" class="form-control" id="tanggal_pembayaran_piutang_multi" name="tanggal" value="<?php echo date('Y-m-d'); ?>">
                        </div>
                        <div class="col-2">
                            <input type="time" class="form-control" id="tanggal_pembayaran_piutang_multi2" name="jam" value="<?php echo date('H:i'); ?>">
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="submit" disabled class="btn btn-md btn-success btn-rounded" id="ButtonPembayaranPenjualanMultiple">
                        <i class="bi bi-save"></i> Simpan Pembayaran
                    </button>
                    <button type="button" class="btn btn-dark btn-rounded" data-bs-dismiss="modal">
                        <i class="bi bi-x-circle"></i> Tutup
                    </button>
                </div>
            </div>
        </form>
    </div>
</div>
<div class="modal fade" id="ModalPembayaranPiutangPenjualan" tabindex="-1">
    <div class="modal-dialog modal-md">
        <div class="modal-content">
            <form action="javascript:void(0);" id="ProsesPembayaranPiutangPenjualan">
                <div class="modal-header">
                    <h5 class="modal-title text-dark">
                        <i class="bi bi-plus"></i> Pembayaran Utang/Piutang Penjualan
                    </h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <input type="hidden" id="id_transaksi_penjualan" name="id_transaksi_jual_beli">
                    <div class="row mb-3">
                        <div class="col-4">
                            <label for="tanggal_pembayaran_piutang_penjualan">
                                <small>Tanggal</small>
                            </label>
                        </div>
                        <div class="col-8">
                            <input type="date" class="form-control" id="tanggal_pembayaran_piutang_penjualan" name="tanggal" value="<?php echo date('Y-m-d'); ?>">
                        </div>
                    </div>
                    <div class="row mb-3">
                        <div class="col-4">
                            <label for="jam_pembayaran_piutang_penjualan">
                                <small>Jam</small>
                            </label>
                        </div>
                        <div class="col-8">
                            <input type="time" class="form-control" id="jam_pembayaran_piutang_penjualan" name="jam" value="<?php echo date('H:i:s'); ?>">
                        </div>
                    </div>
                    <div class="row mb-3">
                        <div class="col-4">
                            <label for="kategori_transaksi_pembayaran_piutang_penjualan">
                                <small>Kategori</small>
                            </label>
                        </div>
                        <div class="col-8">
                            <input type="text" readonly class="form-control" id="kategori_transaksi_pembayaran_piutang_penjualan" name="kategori">
                        </div>
                    </div>
                    <div class="row mb-3">
                        <div class="col-4">
                            <label for="anggota_pembayaran_piutang_penjualan">
                                <small>Anggota</small>
                            </label>
                        </div>
                        <div class="col-8">
                            <select name="id_anggota" id="anggota_pembayaran_piutang_penjualan" class="form-control">
                                <option value="">Pilih</option>
                            </select>
                        </div>
                    </div>
                    <div class="row mb-3">
                        <div class="col-4">
                            <label for="nominal_pembayaran_piutang_penjualan">
                                <small>Jumlah (Nominal)</small>
                            </label>
                        </div>
                        <div class="col-8">
                            <div class="input-group">
                                <span class="input-group-text">Rp</span>
                                <input type="text" name="jumlah" id="nominal_pembayaran_piutang_penjualan" class="form-control form-money"  oninput="this.value = this.value.replace(/[^0-9]/g, '');" value="0">
                            </div>
                        </div>
                    </div>
                    <div class="row mb-3">
                        <div class="col-12" id="NotifikasiPembayaranPiutangPenjualan">
                            <!-- Form Pembayaran Utang Piutang Penjualan Disini -->
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="submit" class="btn btn-md btn-success btn-rounded" id="ButtonPembayaranPiutangPenjualan">
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

<div class="modal fade" id="ModalRiwayatPembayaran" tabindex="-1">
    <div class="modal-dialog modal-md">
        <div class="modal-content">
            <form action="index.php" method="GET">
                <input type="hidden" name="Page" value="UtangPiutang">
                <input type="hidden" name="Sub" value="RiwayatPembayaran">
                <input type="hidden" name="kategori" id="kategori_riwayat" value="">
                <div class="modal-header">
                    <h5 class="modal-title text-dark"><i class="bi bi-clock-history"></i> Riwayat Pembayaran Utang/Piutang</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="row mb-3">
                        <div class="col-12 text-center">
                            <div class="alert alert-info">
                                <small class="text-muted">
                                    Untuk melihat riwayat pembayaran, anda akan diarahkan pada halaman mandiri riwayat pembayaran transaksi.
                                </small>
                                <p>Apakah anda yakin akan masuk ke halaman tersebut?</p>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="submit" class="btn btn-md btn-outline-info btn-rounded">
                        Ya, Lanjutkan <i class="bi bi-arrow-right"></i>
                    </button>
                    <button type="button" class="btn btn-dark btn-rounded" data-bs-dismiss="modal">
                        <i class="bi bi-x-circle"></i> Tutup
                    </button>
                </div>
            </div>
        </form>
    </div>
</div>

<div class="modal fade" id="ModalFilterRiwayatPembayaran" tabindex="-1">
    <div class="modal-dialog modal-md">
        <div class="modal-content">
            <form action="javascript:void(0);" id="ProsesFilterRiwayatPembayaran">
                <input type="hidden" name="page" id="page_riwayat_pembayaran" value="1">
                <div class="modal-header">
                    <h5 class="modal-title text-dark"><i class="bi bi-funnel"></i> Filter Riwayat Pembayaran</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="row mb-3">
                        <div class="col col-md-4"><label for="batas_penjualan">Limit Data</label></div>
                        <div class="col col-md-8">
                            <select name="batas" id="batas_penjualan" class="form-control">
                                <!-- <option value="5">5</option> -->
                                <option selected value="10">10</option>
                                <option value="25">25</option>
                                <option value="50">50</option>
                                <option value="100">100</option>
                                <option value="250">250</option>
                                <option value="500">500</option>
                            </select>
                            <small class="credit">
                                <code class="text text-grayish">Jumlah baris data dalam satu halaman</code>
                            </small>
                        </div>
                    </div>
                    <div class="row mb-3">
                        <div class="col col-md-4"><label for="OrderByPenjualan">Mode Urutan</label></div>
                        <div class="col col-md-8">
                            <select name="OrderBy" id="OrderByPenjualan" class="form-control">
                                <option value="">Pilih</option>
                                <option value="kategori">Kategori</option>
                                <option value="tanggal">Tanggal Bayar</option>
                            </select>
                        </div>
                    </div>
                    <div class="row mb-3">
                        <div class="col col-md-4"><label for="ShortByPenjualan">Tipe urutan</label></div>
                        <div class="col col-md-8">
                            <select name="ShortBy" id="ShortByPenjualan" class="form-control">
                                <option value="DESC">Z To A</option>
                                <option value="ASC">A To Z</option>
                            </select>
                        </div>
                    </div>
                    <div class="row mb-3">
                        <div class="col col-md-4"><label for="keyword_by_riwayat_pembayaran">Pencarian</label></div>
                        <div class="col col-md-8">
                            <select name="keyword_by" id="keyword_by_riwayat_pembayaran" class="form-control">
                                <option value="">Pilih</option>
                                <option value="kategori">Kategori</option>
                                <option value="tanggal">Tanggal Bayar</option>
                            </select>
                        </div>
                    </div>
                    <div class="row mb-3">
                        <div class="col col-md-4"><label for="keyword_riwayat_pembayaran">Kata Kunci</label></div>
                        <div class="col col-md-8" id="FormFilterRiwayatPembayaran">
                            <input type="text" name="keyword" id="keyword_riwayat_pembayaran" class="form-control">
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="submit" class="btn btn-success btn-rounded">
                        <i class="bi bi-filter"></i> Filter
                    </button>
                    <button type="button" class="btn btn-dark btn-rounded" data-bs-dismiss="modal">
                        <i class="bi bi-x-circle"></i> Tutup
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
<div class="modal fade" id="ModalDetailAnggota" tabindex="-1">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title text-dark"><i class="bi bi-person"></i> Detail Anggota</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div class="row">
                    <div class="col-12" id="FormDetailAnggota">
                        <!-- Form Detail Anggota Disini -->
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
<div class="modal fade" id="ModalDetailPembayaran" tabindex="-1">
    <div class="modal-dialog modal-md">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title text-dark">
                    <i class="bi bi-cash-coin"></i> Detail Pembayaran
                </h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div class="row">
                    <div class="col-12" id="FormDetailPembayaran">
                        <!-- Form Detail Pembayaran Disini -->
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
<div class="modal fade" id="ModalExportRiwayatPembayaran" tabindex="-1">
    <div class="modal-dialog modal-md">
        <div class="modal-content">
            <form action="_Page/UtangPiutang/ProsesEportRiwayatPembayaran.php" target="_blank">
                <div class="modal-header">
                    <h5 class="modal-title text-dark">
                        <i class="bi bi-download"></i> Export Riwayat Pembayaran
                    </h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="row mb-3">
                        <div class="col-3">
                            <label for="mode_data">
                                <small>Mode Data</small>
                            </label>
                        </div>
                        <div class="col-1"><small>:</small></div>
                        <div class="col-8">
                            <select name="mode_data" id="mode_data" class="form-control">
                                <option value="">Pilih</option>
                                <option value="Periode">Periode</option>
                                <option value="Bulanan">Bulanan</option>
                                <option value="Harian">Harian</option>
                            </select>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-12" id="ShortPeriode">
                           <!-- Form Periode Data Akan Muncul Disini -->
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="submit" class="btn btn-success btn-rounded">
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
<div class="modal fade" id="ModalEditPembayaran" tabindex="-1">
    <div class="modal-dialog modal-md">
        <div class="modal-content">
            <form action="javascript:void(0);" id="ProsesEditPembayaran">
                <div class="modal-header">
                    <h5 class="modal-title text-dark">
                        <i class="bi bi-pencil"></i> Edit Pembayaran
                    </h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="row mb-3">
                        <div class="col-12" id="FormEditPembayaran">
                            <!-- Form Edit Pembayaran Disini -->
                        </div>
                    </div>
                    <div class="row mb-3">
                        <div class="col-12" id="NotifikasiEditPembayaran">
                            <!-- Notifikasi Pembayaran Disini -->
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="submit" class="btn btn-success btn-rounded" id="ButtonEditPembayaran">
                        <i class="bi bi-save"></i> Simpan
                    </button>
                    <button type="button" class="btn btn-dark btn-rounded" data-bs-dismiss="modal">
                        <i class="bi bi-x-circle"></i> Tutup
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
<div class="modal fade" id="ModalHapusPembayaran" tabindex="-1">
    <div class="modal-dialog modal-md">
        <div class="modal-content">
            <form action="javascript:void(0);" id="ProsesHapusPembayaran">
                <div class="modal-header">
                    <h5 class="modal-title text-dark">
                        <i class="bi bi-trash"></i> Hapus Pembayaran
                    </h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="row mb-3">
                        <div class="col-12" id="FormHapusPembayaran">
                            <!-- Form Hapus Pembayaran Disini -->
                        </div>
                    </div>
                    <div class="row mb-3">
                        <div class="col-12" id="NotifikasiHapusPembayaran">
                            <!-- Notifikasi Hapus Pembayaran Disini -->
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="submit" class="btn btn-success btn-rounded" id="ButtonHapusPembayaran">
                        <i class="bi bi-check"></i> Ya, Hapus
                    </button>
                    <button type="button" class="btn btn-dark btn-rounded" data-bs-dismiss="modal">
                        <i class="bi bi-x-circle"></i> Tutup
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
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
                    <div class="row">
                        <div class="col-md-6 mt-3">
                            <label for="batas">Data/Limit</label>
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
                        <div class="col-md-6 mt-3">
                            <label for="OrderBy">Mode Urutan</label>
                            <select name="OrderBy" id="OrderBy" class="form-control">
                                <option value="">Pilih</option>
                                <option value="kode_barang">Kode</option>
                                <option value="nama_barang">Barang</option>
                                <option value="kategori_barang">Kategori</option>
                                <option value="satuan_barang">Satuan</option>
                                <option value="harga_beli">Harga</option>
                                <option value="stok_barang">Stok</option>
                            </select>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6 mt-3">
                            <label for="ShortBy">Tipe Urutan</label>
                            <select name="ShortBy" id="ShortBy" class="form-control">
                                <option value="ASC">A To Z</option>
                                <option selected value="DESC">Z To A</option>
                            </select>
                        </div>
                        <div class="col-md-6 mt-3">
                            <label for="keyword_by">Pencarian</label>
                            <select name="keyword_by" id="keyword_by" class="form-control">
                                <option value="">Pilih</option>
                                <option value="kode_barang">Kode</option>
                                <option value="nama_barang">Barang</option>
                                <option value="kategori_barang">Kategori</option>
                                <option value="satuan_barang">Satuan</option>
                                <option value="harga_beli">Harga</option>
                                <option value="stok_barang">Stok</option>
                            </select>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-12 mt-3" id="FormFilterKeyword">
                            <label for="keyword">Kata Kunci</label>
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

<div class="modal fade" id="ModalKategoriHarga" tabindex="-1">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title text-dark">
                    <i class="bi bi-tag"></i> Kategori Multi Harga
                </h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div class="row">
                    <div class="col-12 text-end">
                        <button type="submit" class="btn btn-md btn-outline-primary" title="Tambah Kategori Multi Harga" data-bs-toggle="modal" data-bs-target="#ModalTambahKategoriHarga">
                            <i class="bi bi-plus"></i> Tambah Kategori Harga
                        </button>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-12 mt-3">
                        <div class="table table-responsive">
                            <table class="table table-hover table-striped">
                                <thead>
                                    <tr>
                                        <th><b>No</b></th>
                                        <th><b>Kategori Harga</b></th>
                                        <th><b>Item Barang</b></th>
                                        <th><b>Opsi</b></th>
                                    </tr>
                                </thead>
                                <tbody id="TabelKategoriHarga">
                                    <tr>
                                        <td colspan="4" class="text-center text-danger">Tidak Ada Data Kategori Multi Harga Yang Ditampilkan</td>
                                    </tr>
                                </tbody>
                            </table>
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
<div class="modal fade" id="ModalTambahKategoriHarga" tabindex="-1">
    <div class="modal-dialog modal-md">
        <div class="modal-content">
            <form action="javascript:void(0);" id="ProsesTambahKategoriHarga">
                <div class="modal-header">
                    <h5 class="modal-title text-dark"><i class="bi bi-plus"></i> Tambah Kategori Harga</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="row mb-2">
                        <div class="col-md-12">
                            <label for="nama_kategori_harga">Kategori Harga</label>
                            <input type="text" name="kategori_harga" id="nama_kategori_harga" class="form-control">
                        </div>
                    </div>
                    <div class="row mb-2">
                        <div class="col-md-12">
                            <label for="keterangan_kategori_harga">Keterangan</label>
                            <textarea name="keterangan" id="keterangan_kategori_harga" class="form-control"></textarea>
                        </div>
                    </div>
                    <div class="row mb-2">
                        <div class="col-md-12" id="NotifikasiTambahKategoriHarga">
                            <!-- Notifikasi Tambah Kategori Harga Akan Muncul Disini -->
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="submit" class="btn btn-primary btn-rounded" id="ButtonTambahKategoriHarga">
                        <i class="bi bi-save"></i> Simpan
                    </button>
                    <button type="button" class="btn btn-dark btn-rounded" data-bs-toggle="modal" data-bs-target="#ModalKategoriHarga">
                        <i class="bi bi-chevron-left"></i> Kembali
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
<div class="modal fade" id="ModalEditKategoriHarga" tabindex="-1">
    <div class="modal-dialog modal-md">
        <div class="modal-content">
            <form action="javascript:void(0);" id="ProsesEditKategoriHarga">
                <input type="hidden" name="id_barang_kategori_harga" id="put_id_barang_kategori_harga_edit">
                <div class="modal-header">
                    <h5 class="modal-title text-dark"><i class="bi bi-plus"></i> Edit Kategori Harga</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div id="FormEditKategoriHarga">
                        <div class="row mb-2">
                            <div class="col-md-12">
                                <label for="nama_kategori_harga_edit">Kategori Harga</label>
                                <input type="text" name="kategori_harga" id="nama_kategori_harga_edit" class="form-control">
                            </div>
                        </div>
                        <div class="row mb-2">
                            <div class="col-md-12">
                                <label for="keterangan_kategori_harga_edit">Keterangan</label>
                                <textarea name="keterangan" id="keterangan_kategori_harga_edit" class="form-control"></textarea>
                            </div>
                        </div>
                    </div>
                    <div class="row mb-2">
                        <div class="col-md-12" id="NotifikasiEditKategoriHarga">
                            <!-- Notifikasi Edit Kategori Harga Akan Muncul Disini -->
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="submit" class="btn btn-primary btn-rounded" id="ButtonEditKategoriHarga">
                        <i class="bi bi-save"></i> Simpan
                    </button>
                    <button type="button" class="btn btn-dark btn-rounded" data-bs-toggle="modal" data-bs-target="#ModalKategoriHarga">
                        <i class="bi bi-chevron-left"></i> Kembali
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
<div class="modal fade" id="ModalHapusKategoriHarga" tabindex="-1">
    <div class="modal-dialog modal-md">
        <div class="modal-content">
            <form action="javascript:void(0);" id="ProsesHapusKategoriHarga">
                <input type="hidden" name="id_barang_kategori_harga" id="put_id_barang_kategori_harga_hapus">
                <div class="modal-header">
                    <h5 class="modal-title text-dark"><i class="bi bi-trash"></i> Hapus Kategori Harga</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div id="FormHapusKategoriHarga">
                        <div class="row mb-2">
                            <div class="col-4">
                                <small>Kategori Harga</small>
                            </div>
                            <div class="col-8">
                                <small><code class="text text-grayish" id="put_kategori_harga"></code></small>
                            </div>
                        </div>
                        <div class="row mb-2">
                            <div class="col-4">
                                <small>Keterangan</small>
                            </div>
                            <div class="col-8">
                                <small><code class="text text-grayish" id="put_keterangan"></code></small>
                            </div>
                        </div>
                        <div class="row mb-2">
                            <div class="col-4">
                                <small>Jumlah Item</small>
                            </div>
                            <div class="col-8">
                                <small><code class="text text-grayish" id="put_jumlah_item"></code></small>
                            </div>
                        </div>
                        <div class="row mb-2 mt-4">
                            <div class="col-12 text-center">
                                <small>Apakah anda yakin akan menghapus data tersebut?</small>
                            </div>
                        </div>
                    </div>
                    <div class="row mb-2">
                        <div class="col-md-12" id="NotifikasiHapusKategoriHarga">
                            <!-- Notifikasi Edit Kategori Harga Akan Muncul Disini -->
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="submit" class="btn btn-primary btn-rounded" id="ButtonHapusKategoriHarga">
                        <i class="bi bi-check"></i> Ya, Hapus
                    </button>
                    <button type="button" class="btn btn-dark btn-rounded" data-bs-toggle="modal" data-bs-target="#ModalKategoriHarga">
                        <i class="bi bi-chevron-left"></i> Kembali
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
<div class="modal fade" id="ModalTambahBarang" tabindex="-1">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <form action="javascript:void(0);" id="ProsesTambahBarang" autocomplete="off">
                <div class="modal-header">
                    <h5 class="modal-title text-dark">
                        <i class="bi bi-plus"></i> Tambah Barang
                    </h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="row mb-3">
                        <div class="col-4">
                            <label for="kode">
                                Kode Barang
                                <a href="javascript:void(0);" data-bs-toggle="tooltip" data-bs-placement="top" data-bs-custom-class="custom-tooltip" data-bs-title="Apabila anda mengosongkan form ini maka sistem akan membuatkan 10 digit kode unik secara otomatis">
                                    <i class="bi bi-question-circle"></i>
                                </a>
                            </label>
                        </div>
                        <div class="col-8">
                            <input type="text" class="form-control" name="kode" id="kode" maxlength="36">
                            <small class="text-muted">
                                *Diisi jika barang tersebut memiliki kode standar yang ditetapkan.
                            </small>
                        </div>
                    </div>
                    <div class="row mb-3">
                        <div class="col-4">
                            <label for="nama">Nama/Merek Barang</label>
                        </div>
                        <div class="col-8">
                            <input type="text" class="form-control" name="nama" id="nama" maxlength="100">
                        </div>
                    </div>
                    <div class="row mb-3">
                        <div class="col-4">
                            <label for="kategori">Kategori</label>
                        </div>
                        <div class="col-8">
                            <input type="text" class="form-control" name="kategori" id="kategori" list="list_kategori" maxlength="30">
                            <datalist id="list_kategori">
                                <!-- List Kategori -->
                            </datalist>
                        </div>
                    </div>
                    <div class="row mb-3">
                        <div class="col-4">
                            <label for="satuan">Satuan</label>
                        </div>
                        <div class="col-8">
                            <input type="text" class="form-control" name="satuan" id="satuan" list="list_satuan" maxlength="30">
                            <datalist id="list_satuan">
                                <!-- List Satuan -->
                            </datalist>
                        </div>
                    </div>
                    <div class="row mb-3">
                        <div class="col-4">
                            <label for="isi">Isi/Kemasan</label>
                        </div>
                        <div class="col-8">
                            <div class="input-group">
                                <span class="input-group-text">
                                    <small>.00</small>
                                </span>
                                <input type="text" class="form-control" name="isi" id="isi" maxlength="15" inputmode="numeric" oninput="this.value = this.value.replace(/[^0-9.]/g, '').replace(/(\..*?)\..*/g, '$1');" value="1.00">
                            </div>
                        </div>
                    </div>
                    <div class="row mb-3">
                        <div class="col-4">
                            <label for="stok">Stok Awal</label>
                        </div>
                        <div class="col-8">
                            <div class="input-group">
                                <span class="input-group-text">
                                    <small>.00</small>
                                </span>
                                <input type="text" class="form-control" name="stok" id="stok" maxlength="15" inputmode="numeric" oninput="this.value = this.value.replace(/[^0-9.]/g, '').replace(/(\..*?)\..*/g, '$1');">
                            </div>
                        </div>
                    </div>
                    <div class="row mb-3">
                        <div class="col-4">
                            <label for="stok_min">Stok Minimum</label>
                        </div>
                        <div class="col-8">
                            <div class="input-group">
                                <span class="input-group-text">
                                    <small>.00</small>
                                </span>
                                <input type="text" class="form-control" name="stok_min" id="stok_min" maxlength="15" inputmode="numeric" oninput="this.value = this.value.replace(/[^0-9.]/g, '').replace(/(\..*?)\..*/g, '$1');">
                            </div>
                            <small class="text-muted">
                                *Stok minimum untuk pemberitahuan
                            </small>
                        </div>
                    </div>
                    <div class="row mb-3">
                        <div class="col-4">
                            <label for="harga">Harga Beli</label>
                        </div>
                        <div class="col-8">
                            <div class="input-group">
                                <span class="input-group-text">
                                    <small>Rp</small>
                                </span>
                                <input type="text" class="form-control form-money" name="harga" id="harga" maxlength="15" inputmode="numeric" oninput="this.value = this.value.replace(/[^0-9]/g, '');">
                            </div>
                        </div>
                    </div>
                    <div class="row border-1 border-top mb-3">
                        <div class="col-12 mt-3">
                            <b>Kategori Multi Harga</b>
                        </div>
                    </div>
                    <div class="row mb-3">
                        <div class="col-md-12" id="form_multi_harga">
                            <!-- Form Multi Harga Akan Muncul Disini -->
                        </div>
                    </div>
                    <div class="row mb-3">
                        <div class="col-md-12" id="NotifikasiTambahBarang">
                            <!-- Notifikasi Tambah Obat Akan Muncul Disini -->
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="submit" class="btn btn-primary btn-rounded" id="ButtonTambahBarang">
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
<div class="modal fade" id="ModalDetailKode" tabindex="-1">
    <div class="modal-dialog modal-md">
        <div class="modal-content">
            <form action="javascript:void(0);" id="ProsesCetakCodeBarang">
                <div class="modal-header">
                    <h5 class="modal-title text-dark"><i class="bi bi-upc-scan"></i> Kode Barang</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="row mb-3">
                        <div class="col-12" id="PreviewBarcodeKode">
                            <!-- Preview Barcode Kode akan tampil disini -->
                        </div>
                    </div>
                    <div class="row mb-3 border-1 border-top">
                        <div class="col-12 mb-2 mt-2"></div>
                    </div>
                    <div class="row mb-3">
                        <div class="col-4">
                            <label for="type_code"><small>Tipe Code</small></label>
                        </div>
                        <div class="col-1"><small>:</small></div>
                        <div class="col-7">
                            <select name="type_code" id="type_code" class="form-control">
                                <option value="code128">Barcode (code128)</option>
                                <option value="code39">Barcode (code39)</option>
                                <option value="code25">Barcode (code25)</option>
                                <option value="qrcode">Qrcode</option>
                            </select>
                        </div>
                    </div>
                    <div class="row mb-3">
                        <div class="col-4">
                            <label for="tampilkan_nama_barang_for_code"><small>Nama Barang</small></label>
                        </div>
                        <div class="col-1"><small>:</small></div>
                        <div class="col-7">
                            <select name="tampilkan_nama_barang_for_code" id="tampilkan_nama_barang_for_code" class="form-control">
                                <option value="Tampilkan">Tampilkan</option>
                                <option value="Tidak">Tidak</option>
                            </select>
                        </div>
                    </div>
                    <div class="row mb-3">
                        <div class="col-4">
                            <label for="kategori_harga_kode"><small>Kategori Harga</small></label>
                        </div>
                        <div class="col-1"><small>:</small></div>
                        <div class="col-7">
                            <select name="kategori_harga_kode" id="kategori_harga_kode" class="form-control">
                                <?php
                                    $query = mysqli_query($Conn, "SELECT*FROM barang_kategori_harga ORDER BY id_barang_kategori_harga DESC");
                                    while ($data = mysqli_fetch_array($query)) {
                                        $id_barang_kategori_harga= $data['id_barang_kategori_harga'];
                                        $kategori_harga= $data['kategori_harga'];
                                        echo '<option value="'.$id_barang_kategori_harga.'">'.$kategori_harga.'</option>';
                                    }
                                ?>
                                <option value="">Jangan Tampilkan</option>
                            </select>
                        </div>
                    </div>
                    <div class="row mb-3">
                        <div class="col-4">
                            <label for="type_file_code"><small>Tipe Cetak</small></label>
                        </div>
                        <div class="col-1"><small>:</small></div>
                        <div class="col-7">
                            <select name="type_file_code" id="type_file_code" class="form-control">
                                <option value="Direct">Direct</option>
                                <option value="Image">Image</option>
                                <option value="PDF">PDF</option>
                            </select>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-12" id="NotifikasiCetakKode">
                            <!-- Notifikasi Cetak Code Disni -->
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="submit" class="btn btn-success btn-rounded" id="ButtonCetakKode">
                        <i class="bi bi-printer"></i> Cetak Code
                    </button>
                    <button type="button" class="btn btn-dark btn-rounded" data-bs-dismiss="modal">
                        <i class="bi bi-x-circle"></i> Tutup
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
<div class="modal fade" id="ModalDetailBarang" tabindex="-1">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <form action="index.php" method="GET">
                <input type="hidden" name="id" id="put_id_barang_detail">
                <input type="hidden" name="Page" value="Barang">
                <input type="hidden" name="Sub" value="DetailBarang">
                <div class="modal-header">
                    <h5 class="modal-title text-dark"><i class="bi bi-info-circle"></i> Detail Barang</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div  id="form_detail_barang">
                        <div class="row mb-2">
                            <div class="col-12">
                                <b># Informasi Barang</b>
                            </div>
                        </div>
                        <div class="row mb-2">
                            <div class="col-4">
                                <small>Kode Barang</small>
                            </div>
                            <div class="col-8">
                                <small class="kode_barang"></small>
                            </div>
                        </div>
                        <div class="row mb-2">
                            <div class="col-4">
                                <small>Nama/Merek</small>
                            </div>
                            <div class="col-8">
                                <small class="nama_barang"></small>
                            </div>
                        </div>
                        <div class="row mb-2">
                            <div class="col-4">
                                <small>Kategori</small>
                            </div>
                            <div class="col-8">
                                <small class="kategori_barang"></small>
                            </div>
                        </div>
                        <div class="row mb-2">
                            <div class="col-4">
                                <small>Isi/Satuan</small>
                            </div>
                            <div class="col-8">
                                <small class="satuan_barang"></small>
                            </div>
                        </div>
                        <div class="row mb-2">
                            <div class="col-4">
                                <small>Stok Aktual</small>
                            </div>
                            <div class="col-8">
                                <small class="stok_barang"></small>
                            </div>
                        </div>
                        <div class="row mb-2">
                            <div class="col-4">
                                <small>Stok Minimum</small>
                            </div>
                            <div class="col-8">
                                <small class="stok_minimum"></small>
                            </div>
                        </div>
                        <div class="row mb-2">
                            <div class="col-4">
                                <small>Harga Beli</small>
                            </div>
                            <div class="col-8">
                                <small class="harga_beli"></small>
                            </div>
                        </div>
                        <div class="row mb-2 mt-2 border-1 border-top">
                            <div class="col-12 mt-3">
                                <b># Informasi Multi Harga</b>
                            </div>
                        </div>
                        <div class="row mb-2">
                            <div class="col-12" id="informasi_multi_harga">
                                <!-- Informasi Multi Harga Disini -->
                            </div>
                        </div>
                        <div class="row mb-4 mt-2 border-1 border-top">
                            <div class="col-10 mt-3">
                                <b># Informasi Multi Satuan</b>
                            </div>
                            <div class="col-2 mt-3 text-center">
                                <button type="button" class="btn btn-sm btn-floating btn-outline-primary" data-bs-toggle="modal" data-bs-target="#ModalTambahSatuan"  title="Tambah Multi satuan">
                                    <i class="bi bi-plus"></i>
                                </button>
                            </div>
                        </div>
                        <div class="row mb-3 mt-4">
                            <div class="col-12" id="informasi_multi_satuan">
                                <!-- Informasi Multi Harga Disini -->
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-12" id="NotifikasiDetailBarang">

                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="submit" class="btn btn-info btn-rounded">
                        <i class="bi bi-three-dots"></i> Selengkapnya
                    </button>
                    <button type="button" class="btn btn-dark btn-rounded" data-bs-dismiss="modal">
                        <i class="bi bi-x-circle"></i> Tutup
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

<div class="modal fade" id="ModalEditBarang" tabindex="-1">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <form action="javascript:void(0);" id="ProsesEditBarang" autocomplete="off">
                <input type="hidden" name="id_barang" id="put_id_barang_edit">
                <div class="modal-header">
                    <h5 class="modal-title text-dark">
                        <i class="bi bi-pencil"></i> Edit Barang
                    </h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div id="form_edit_barang">
                        <div class="row mb-3">
                            <div class="col-4">
                                <label for="kode_edit">Kode Barang</label>
                            </div>
                            <div class="col-8">
                                <input type="text" class="form-control" name="kode" id="kode_edit" maxlength="36">
                                <small class="text-muted">
                                    *Diisi jika barang tersebut memiliki kode standar yang ditetapkan.
                                </small>
                            </div>
                        </div>
                        <div class="row mb-3">
                            <div class="col-4">
                                <label for="nama_edit">Nama/Merek Barang</label>
                            </div>
                            <div class="col-8">
                                <input type="text" class="form-control" name="nama" id="nama_edit" maxlength="100">
                            </div>
                        </div>
                        <div class="row mb-3">
                            <div class="col-4">
                                <label for="kategori_edit">Kategori</label>
                            </div>
                            <div class="col-8">
                                <input type="text" class="form-control" name="kategori" id="kategori_edit" list="list_kategori_edit" maxlength="30">
                                <datalist id="list_kategori_edit">
                                    <!-- List Kategori -->
                                </datalist>
                            </div>
                        </div>
                        <div class="row mb-3">
                            <div class="col-4">
                                <label for="satuan_edit">Satuan</label>
                            </div>
                            <div class="col-8">
                                <input type="text" class="form-control" name="satuan" id="satuan_edit" list="list_satuan_edit" maxlength="30">
                                <datalist id="list_satuan_edit">
                                    <!-- List Satuan -->
                                </datalist>
                            </div>
                        </div>
                        <div class="row mb-3">
                            <div class="col-4">
                                <label for="isi_edit">Isi/Kemasan</label>
                            </div>
                            <div class="col-8">
                                <div class="input-group">
                                    <span class="input-group-text">
                                        <small>.00</small>
                                    </span>
                                    <input type="text" class="form-control" name="isi" id="isi_edit" maxlength="15" inputmode="numeric" oninput="this.value = this.value.replace(/[^0-9.]/g, '').replace(/(\..*?)\..*/g, '$1');" value="1.00">
                                </div>
                            </div>
                        </div>
                        <div class="row mb-3">
                            <div class="col-4">
                                <label for="stok_edit">Stok Awal</label>
                            </div>
                            <div class="col-8">
                                <div class="input-group">
                                    <span class="input-group-text">
                                        <small>.00</small>
                                    </span>
                                    <input type="text" class="form-control" name="stok" id="stok_edit" maxlength="15" inputmode="numeric" oninput="this.value = this.value.replace(/[^0-9.]/g, '').replace(/(\..*?)\..*/g, '$1');">
                                </div>
                            </div>
                        </div>
                        <div class="row mb-3">
                            <div class="col-4">
                                <label for="stok_min_edit">Stok Minimum</label>
                            </div>
                            <div class="col-8">
                                <div class="input-group">
                                    <span class="input-group-text">
                                        <small>.00</small>
                                    </span>
                                    <input type="text" class="form-control" name="stok_min" id="stok_min_edit" maxlength="15" inputmode="numeric" oninput="this.value = this.value.replace(/[^0-9.]/g, '').replace(/(\..*?)\..*/g, '$1');">
                                </div>
                                <small class="text-muted">
                                    *Stok minimum untuk pemberitahuan
                                </small>
                            </div>
                        </div>
                        <div class="row mb-3">
                            <div class="col-4">
                                <label for="harga_edit">Harga Beli</label>
                            </div>
                            <div class="col-8">
                                <div class="input-group">
                                    <span class="input-group-text">
                                        <small>Rp</small>
                                    </span>
                                    <input type="text" class="form-control form-money" name="harga" id="harga_edit" maxlength="15" inputmode="numeric" oninput="this.value = this.value.replace(/[^0-9]/g, '');">
                                </div>
                            </div>
                        </div>
                        <div class="row border-1 border-top mb-3">
                            <div class="col-12 mt-3">
                                <b>Kategori Multi Harga</b>
                            </div>
                        </div>
                        <div class="row mb-3">
                            <div class="col-md-12" id="form_multi_harga_edit">
                                <!-- Form Multi Harga Akan Muncul Disini -->
                            </div>
                        </div>
                    </div>
                    <div class="row mb-3">
                        <div class="col-md-12" id="NotifikasiEditBarang">
                            <!-- Notifikasi Tambah Obat Akan Muncul Disini -->
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="submit" class="btn btn-primary btn-rounded" id="ButtonEditBarang">
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
<div class="modal fade" id="ModalHapusBarang" tabindex="-1">
    <div class="modal-dialog modal-md">
        <div class="modal-content">
            <form action="javascript:void(0);" id="ProsesHapusBarang">
                <div class="modal-header">
                    <h5 class="modal-title text-dark"><i class="bi bi-trash"></i> Hapus Barang</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="row">
                        <div class="col-12"  id="FormHapusBarang">
                            <!-- Form Hapus Barang Disini -->
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-12"  id="NotifikasiHapusBarang">
                            <!-- Notifikasi Hapus Barang Disini -->
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="submit" class="btn btn-success btn-rounded" id="ButtonHapusBarang">
                        <i class="bi bi-check"></i> Ya, Hapus
                    </button>
                    <button type="button" class="btn btn-dark btn-rounded" data-bs-dismiss="modal">
                        <i class="bi bi-x-circle"></i> Tidak
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

<div class="modal fade" id="ModalTambahSatuan" tabindex="-1">
    <div class="modal-dialog modal-md">
        <div class="modal-content">
            <form action="javascript:void(0);" id="ProsesTambahSatuan">
                <input type="hidden" name="id_barang" id="put_id_barang_tambah_satuan">
                <div class="modal-header">
                    <h5 class="modal-title text-dark"><i class="bi bi-plus"></i> Tambah Multi Satuan</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div id="FormDetailBarangSatuan">
                        <!-- Detail Barang Ditampilkan Disini -->
                    </div>
                    <div class="row mb-3 border-1 border-top">
                        <div class="col-md-12 mt-3">
                            <label for="satuan_multi">Nama Satuan</label>
                            <input type="text" name="satuan_multi" id="satuan_multi" class="form-control" list="ListSatuanMulti">
                            <datalist id="ListSatuanMulti">
                                <!-- List Satuan Multi Disini -->
                            </datalist>
                        </div>
                    </div>
                    <div class="row-3">
                        <div class="col-md-12">
                            <label for="konversi_satuan_multi">Isi/Satuan</label>
                            <input type="number" name="konversi" id="konversi_satuan_multi" class="form-control">
                        </div>
                    </div>
                    <div class="row-3">
                        <div class="col-md-12" id="NotifikasiTambahSatuan">
                            <!-- Notifikasi Tambah Satuan Multi -->
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="submit" class="btn btn-primary btn-rounded" id="ButtonTambahSatuan">
                        <i class="bi bi-save"></i> Simpan
                    </button>
                    <button type="button" class="btn btn-dark btn-rounded kembali_ke_detail_barang" data-bs-toggle="modal" data-bs-target="#ModalDetailBarang" data-id="">
                        <i class="bi bi-chevron-left"></i> Kembali
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
<div class="modal fade" id="ModalEditSatuan" tabindex="-1">
    <div class="modal-dialog modal-md">
        <div class="modal-content">
            <form action="javascript:void(0);" id="ProsesEditSatuan">
                <input type="hidden" name="id_barang_satuan" id="put_id_barang_satuan_edit">
                <div class="modal-header">
                    <h5 class="modal-title text-dark"><i class="bi bi-pencil-square"></i> Edit Multi Satuan</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="row mb-3">
                        <div class="col-md-12">
                            <label for="satuan_multi_edit">Nama Satuan</label>
                            <input type="text" name="satuan_multi" id="satuan_multi_edit" class="form-control">
                        </div>
                    </div>
                    <div class="row mb-3">
                        <div class="col-md-12">
                            <label for="konversi_satuan_multi_edit">Isi/Satuan</label>
                            <input type="number" name="konversi" id="konversi_satuan_multi_edit" class="form-control">
                        </div>
                    </div>
                    <div class="row mb-3">
                        <div class="col-md-12" id="NotifikasiEditSatuan">
                            <!-- Notifikasi Tambah Satuan Multi -->
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="submit" class="btn btn-primary btn-rounded" id="ButtonEditSatuan">
                        <i class="bi bi-save"></i> Simpan
                    </button>
                    <button type="button" class="btn btn-dark btn-rounded kembali_ke_detail_barang" data-bs-toggle="modal" data-bs-target="#ModalDetailBarang" data-id="">
                        <i class="bi bi-chevron-left"></i> Kembali
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
<div class="modal fade" id="ModalHapusSatuanMulti" tabindex="-1">
    <div class="modal-dialog modal-md">
        <div class="modal-content">
            <form action="javascript:void(0);" id="ProsesHapusSatuanMulti">
                <div class="modal-header">
                    <h5 class="modal-title text-dark"><i class="bi bi-trash"></i> Hapus Multi Satuan</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="row mb-2">
                        <div class="col-md-12"  id="FormHapusSatuanMulti">
                            <!-- Form Hapus Satuan -->
                        </div>
                    </div>
                    <div class="row mb-2">
                        <div class="col-md-12"  id="NotifikasiHapusSatuanMulti">
                            <!-- Form Hapus Satuan -->
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="submit" class="btn btn-success btn-rounded" id="ButtonHapusSatuanMulti">
                        <i class="bi bi-check"></i> Ya, Hapus
                    </button>
                    <button type="button" class="btn btn-dark btn-rounded kembali_ke_detail_barang" data-bs-toggle="modal" data-bs-target="#ModalDetailBarang" data-id="">
                        <i class="bi bi-x-circle"></i> Tidak
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

<div class="modal fade" id="ModalEditKategoriHarga" tabindex="-1">
    <div class="modal-dialog modal-md">
        <div class="modal-content">
            <form action="javascript:void(0);" id="ProsesEditKategoriHarga">
                <div class="modal-header bg-primary">
                    <h5 class="modal-title text-light"><i class="bi bi-pencil-square"></i> Edit Kategori Harga</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body" id="FormEditKategoriHarga">
                    
                </div>
                <div class="modal-footer bg-primary">
                    <button type="submit" class="btn btn-success btn-rounded">
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
<div class="modal fade" id="ModalDeleteKategoriHarga" tabindex="-1">
    <div class="modal-dialog modal-sm">
        <div class="modal-content">
            <div class="modal-header bg-danger">
                <h5 class="modal-title text-light"><i class="bi bi-trash"></i> Hapus Kategori Harga</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body" id="FormHapusKategoriHarga">
                
            </div>
            <div class="modal-footer bg-danger">
                <button type="button" class="btn btn-success btn-rounded" id="KonfirmasiHapusKaegoriHarga">
                    <i class="bi bi-check"></i> Ya
                </button>
                <button type="button" class="btn btn-dark btn-rounded" data-bs-dismiss="modal">
                    <i class="bi bi-x-circle"></i> Tidak
                </button>
            </div>
        </div>
    </div>
</div>
<div class="modal fade" id="ModalTambahExpiredDate" tabindex="-1">
    <div class="modal-dialog modal-md">
        <div class="modal-content">
            <form action="javascript:void(0);" id="ProsesTambahExpiredDate">
                <div class="modal-header bg-primary">
                    <h5 class="modal-title text-light"><i class="bi bi-person-plus"></i> Tambah Batch & Expired</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body" id="FormTambahExpiredDate">
                    
                </div>
                <div class="modal-footer bg-primary">
                    <button type="submit" class="btn btn-success btn-rounded">
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
<div class="modal fade" id="ModalEditExpiredDate" tabindex="-1">
    <div class="modal-dialog modal-md">
        <div class="modal-content">
            <form action="javascript:void(0);" id="ProsesEditExpiredDate">
                <div class="modal-header bg-primary">
                    <h5 class="modal-title text-light"><i class="bi bi-pencil-square"></i> Edit Batch & Expired</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body" id="FormEditExpiredDate">
                    
                </div>
                <div class="modal-footer bg-primary">
                    <button type="submit" class="btn btn-success btn-rounded">
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
<div class="modal fade" id="ModalDeleteExpiredDate" tabindex="-1">
    <div class="modal-dialog modal-sm">
        <div class="modal-content">
            <div class="modal-header bg-danger">
                <h5 class="modal-title text-light"><i class="bi bi-trash"></i> Hapus Batch & Expired</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body" id="FormHapusExpiredDate">
                
            </div>
            <div class="modal-footer bg-danger">
                <button type="button" class="btn btn-success btn-rounded" id="KonfirmasiHapusExpiredDate">
                    <i class="bi bi-check"></i> Ya
                </button>
                <button type="button" class="btn btn-dark btn-rounded" data-bs-dismiss="modal">
                    <i class="bi bi-x-circle"></i> Tidak
                </button>
            </div>
        </div>
    </div>
</div>
<div class="modal fade" id="ModalExportBarang" tabindex="-1">
    <div class="modal-dialog modal-md">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title text-dark">
                    <i class="bi bi-download"></i> Export Data Barang
                </h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div class="row">
                    <div class="col-md-12">
                        <ul>
                            <li>
                                Data barang akan dibuat dalam format <i>Excel</i>.
                            </li>
                            <li>
                                Semakin banyak data maka proses membutuhkan waktu lebih lama.
                            </li>
                            <li>
                                Gunakan tombol <i>Export</i> berikut ini untuk melanjutkan proses.
                            </li>
                        </ul>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <a href="_Page/Barang/ProsesExport.php" class="btn btn-primary btn-rounded">
                    <i class="bi bi-download"></i> Export
                </a>
                <button type="button" class="btn btn-dark btn-rounded" data-bs-dismiss="modal">
                    <i class="bi bi-x-circle"></i> Tutup
                </button>
            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="ModalImportBarang" tabindex="-1">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <form action="javascript:void(0);" id="ProsesImportBarang">
                <div class="modal-header">
                    <h5 class="modal-title text-dark">
                        <i class="bi bi-upload"></i> Import Data Barang
                    </h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="row">
                        <div class="col-md-12">
                            <small class="credit">
                                Sebelum melakukan import data, perhatikan hal berikut ini.
                                <ol>
                                    <li>
                                        Pastikan anda sudah mempunyai template file untuk melakukan import dengan cara melakukan export data barang terlebih dulu.
                                    </li>
                                    <li>
                                        Export data barang bisa anda lakukan dengan cara klik pada tombol <b>Opsi Lanjutan</b>, kemudian pilih <b>Export</b>
                                    </li>
                                    <li>
                                        Isi kolom <b>No, Kode Barang, Nama Barang, Kategori, Stok, Satuan Dan Harga Beli</b> sesuai data yang anda miliki.
                                    </li>
                                    <li>
                                        Setelah Kolom <b>Harga Beli</b> diisi dengan muti harga penjualan sesuai kategori harga barang yang anda tetapkan.
                                    </li>
                                    <li>
                                        Kolom <b>No, Kode Barang, Nama Barang, Kategori, Satuan</b> wajib diisi.
                                    </li>
                                    <li>
                                        Jika anda mengosongkan kolom <b>Stok dan Harga Beli</b> maka sistem akan membacanya sebagai 0.
                                    </li>
                                    <li>
                                        Sistem akan menolak duplikasi data berdasarkan <b>Kode Barang</b> jika ditemukan sama identik.
                                    </li>
                                </ol>
                            </small>
                        </div>
                    </div>
                    <div class="row mb-3">
                        <div class="col-12">
                            <label for="file_barang">File Excel</label>
                            <input type="file" name="file_barang" id="file_barang" class="form-control">
                            <small class="text text-muted">File type excel dan maksimal 10 mb</small>
                        </div>
                    </div>
                    <div class="row mb-3">
                        <div class="col-12">
                            <div class="table table-responsive" id="NotifikasiImportBarang">
                                <!-- Notifikasi Import Akan Muncul Disini -->
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="submit" class="btn btn-primary btn-rounded">
                        <i class="bi bi-upload"></i> Import
                    </button>
                    <button type="button" class="btn btn-dark btn-rounded" data-bs-dismiss="modal">
                        <i class="bi bi-x-circle"></i> Tutup
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

<div class="modal fade" id="ModalFilterRiwayatTransaksi" tabindex="-1">
    <div class="modal-dialog modal-md">
        <div class="modal-content">
            <form action="javascript:void(0);" id="ProsesFilterRiwayatTransaksi">
                <input type="hidden" name="id_barang" id="put_id_barang_for_filter_riwayat_transaksi">
                <input type="hidden" name="page" id="page_riwayat_transaksi" value="1">
                <div class="modal-header">
                    <h5 class="modal-title text-dark"><i class="bi bi-funnel"></i> Filter Riwayat Transaksi</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="row mb-3">
                        <div class="col-4">
                            <label for="batas_riwayat_transaksi">
                                <small>Data/Limit</small>
                            </label>
                        </div>
                        <div class="col-8">
                            <select name="batas" id="batas_riwayat_transaksi" class="form-control">
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
                            <label for="OrderByRiwayatTransaksi">
                                <small>Mode Urutan</small>
                            </label>
                        </div>
                        <div class="col-8">
                            <select name="OrderBy" id="OrderByRiwayatTransaksi" class="form-control">
                                <option value="">Pilih</option>
                                <option value="kategori">kategori</option>
                                <option value="tanggal">Tanggal</option>
                                <option value="status">Status</option>
                                <option value="satuan">Satuan</option>
                            </select>
                        </div>
                    </div>
                    <div class="row mb-3">
                        <div class="col-4">
                            <label for="ShortByRiwayatTransaksi">
                                <small>Tipe Urutan</small>
                            </label>
                        </div>
                        <div class="col-8">
                            <select name="ShortBy" id="ShortByRiwayatTransaksi" class="form-control">
                                <option value="ASC">A To Z</option>
                                <option selected value="DESC">Z To A</option>
                            </select>
                        </div>
                    </div>
                    <div class="row mb-3">
                        <div class="col-4">
                            <label for="keyword_by_riwayat_transaksi">
                                <small>Dasar Pencarian</small>
                            </label>
                        </div>
                        <div class="col-8">
                            <select name="keyword_by" id="keyword_by_riwayat_transaksi" class="form-control">
                                <option value="">Pilih</option>
                                <option value="kategori">kategori</option>
                                <option value="tanggal">Tanggal</option>
                                <option value="status">Status</option>
                                <option value="satuan">Satuan</option>
                            </select>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-4">
                            <label for="keyword_riwayat_transaksi"><small>Kata Kunci</small></label>
                        </div>
                        <div class="col-md-8" id="FormFilterKeywordRiwayatTransaksi">
                            <input type="text" name="keyword" id="keyword_riwayat_transaksi" class="form-control">
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

<div class="modal fade" id="ModalDetailTransaksi" tabindex="-1">
    <div class="modal-dialog modal-md">
        <div class="modal-content">
            <form action="index.php" method="GET">
                <div class="modal-header">
                    <h5 class="modal-title text-dark"><i class="bi bi-info-circle"></i> Detail Transaksi</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="row mb-3">
                        <div class="col-12" id="FormDetailTransaksi">
                            <!-- Form Detail Transaksi Disini -->
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="submit" class="btn btn-md btn-outline-info btn-rounded">
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

<div class="modal fade" id="ModalExportRiwayatTransaksi" tabindex="-1">
    <div class="modal-dialog modal-md">
        <div class="modal-content">
            <form action="_Page/Barang/ProsesExportRiwayatTransaksi.php" method="POST">
                <div class="modal-header">
                    <h5 class="modal-title text-dark"><i class="bi bi-download"></i> Export Riwayat Transaksi</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="row mb-3">
                        <div class="col-12" id="FormExportRiwayatTransaksi">
                            <!-- Form Export Riwayat Transaksi Disini -->
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="submit" class="btn btn-md btn-success btn-rounded">
                        <i class="bi bi-download"></i> Export
                    </button>
                    <button type="button" class="btn btn-dark btn-rounded" data-bs-dismiss="modal">
                        <i class="bi bi-x-circle"></i> Tutup
                    </button>
                </div>
            </div>
        </form>
    </div>
</div>

<div class="modal fade" id="ModalScanBarang" tabindex="-1">
    <div class="modal-dialog modal-md">
        <div class="modal-content">
            <form action="javascript:void(0);" id="ProsesScanBarang">
                <div class="modal-header">
                    <h5 class="modal-title text-dark">
                        <i class="bi bi-qr-code-scan"></i> Scan Barang
                    </h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="row mb-3">
                        <div class="col-12">
                            <!-- Form Export Riwayat Transaksi Disini -->
                            <video id="qr-video" width="100%" height="auto" playsinline></video>
                        </div>
                    </div>
                    <div class="row mb-3">
                        <div class="col-4">
                            <label for="get_resume_kode_barang">
                                <small>Kode Barang</small>
                            </label>
                        </div>
                        <div class="col-1"><small>:</small></div>
                        <div class="col-7">
                            <input type="text" name="get_resume_kode_barang" id="get_resume_kode_barang" class="form-control">
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-dark btn-rounded" data-bs-dismiss="modal">
                        <i class="bi bi-x-circle"></i> Tutup
                    </button>
                </div>
            </div>
        </form>
    </div>
</div>
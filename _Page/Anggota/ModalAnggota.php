<div class="modal fade" id="ModalFilter" tabindex="-1">
    <div class="modal-dialog modal-md">
        <div class="modal-content">
            <form action="javascript:void(0);" id="ProsesFilter">
                <input type="hidden" name="page" id="page">
                <div class="modal-header">
                    <h5 class="modal-title text-dark"><i class="bi bi-funnel"></i> Filter Anggota</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="row mb-2">
                        <div class="col-4">
                            <label for="batas">
                                <small>Batas/Limit</small>
                            </label>
                        </div>
                        <div class="col-1">
                            <small>:</small>
                        </div>
                        <div class="col-7">
                            <select name="batas" id="batas" class="form-control">
                                <option value="10">10</option>
                                <option value="25">25</option>
                                <option value="50">50</option>
                                <option value="100">100</option>
                                <option value="250">250</option>
                                <option value="500">500</option>
                            </select>
                        </div>
                    </div>
                    <div class="row mb-2">
                        <div class="col-4">
                            <label for="OrderBy">
                                <small>Mode Urutan</small>
                            </label>
                        </div>
                        <div class="col-1">
                            <small>:</small>
                        </div>
                        <div class="col-7">
                            <select name="OrderBy" id="OrderBy" class="form-control">
                                <option value="">Pilih</option>
                                <option value="tanggal_masuk">Tanggal Masuk</option>
                                <option value="tanggal_keluar">Tanggal Keluar</option>
                                <option value="nip">NIP</option>
                                <option value="nama">Nama Anggota</option>
                                <option value="email">Email</option>
                                <option value="kontak">Kontak</option>
                                <option value="lembaga">Divisi/Unit</option>
                                <option value="ranking">Ranking</option>
                                <option value="status">Status</option>
                            </select>
                        </div>
                    </div>
                    <div class="row mb-2">
                        <div class="col-4">
                            <label for="ShortBy">
                                <small>Tipe Urutan</small>
                            </label>
                        </div>
                        <div class="col-1">
                            <small>:</small>
                        </div>
                        <div class="col-7">
                            <select name="ShortBy" id="ShortBy" class="form-control">
                                <option value="DESC">Z To A</option>
                                <option value="ASC">A To Z</option>
                            </select>
                        </div>
                    </div>
                    <div class="row mb-2">
                        <div class="col-4">
                            <label for="keyword_by">
                                <small>Dasar Pencarian</small>
                            </label>
                        </div>
                        <div class="col-1">
                            <small>:</small>
                        </div>
                        <div class="col-7">
                            <select name="keyword_by" id="keyword_by" class="form-control">
                                <option value="">Pilih</option>
                                <option value="tanggal_masuk">Tanggal Masuk</option>
                                <option value="tanggal_keluar">Tanggal Keluar</option>
                                <option value="nip">NIP</option>
                                <option value="nama">Nama Anggota</option>
                                <option value="email">Email</option>
                                <option value="kontak">Kontak</option>
                                <option value="lembaga">Divisi/Unit</option>
                                <option value="ranking">Ranking</option>
                                <option value="status">Status</option>
                            </select>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-4">
                            <label for="keyword_by">
                                <small>Kata Kunci</small>
                            </label>
                        </div>
                        <div class="col-1">
                            <small>:</small>
                        </div>
                        <div class="col-7" id="FormFilter">
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
<div class="modal fade" id="ModalFilterRiwayatSimpanan" tabindex="-1">
    <div class="modal-dialog modal-md">
        <div class="modal-content">
            <form action="javascript:void(0);" id="ProsesFilterRiwayatSimpanan">
                <input type="hidden" name="id_anggota" id="put_id_anggota_riwayat_simpanan">
                <input type="hidden" name="page" id="put_page_riwayat_simpanan" value="1">
                <div class="modal-header">
                    <h5 class="modal-title text-dark"><i class="bi bi-funnel"></i> Filter Riwayat Simpanan</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="row mb-2">
                        <div class="col-4">
                            <label for="batas_riwayat_simpanan">
                                <small>Batas/Limit</small>
                            </label>
                        </div>
                        <div class="col-1">
                            <small>:</small>
                        </div>
                        <div class="col-7">
                            <select name="batas" id="batas_riwayat_simpanan" class="form-control">
                                <option value="10">10</option>
                                <option value="25">25</option>
                                <option value="50">50</option>
                                <option value="100">100</option>
                                <option value="250">250</option>
                                <option value="500">500</option>
                            </select>
                        </div>
                    </div>
                    <div class="row mb-2">
                        <div class="col-4">
                            <label for="OrderByRiwayatSimpanan">
                                <small>Mode Urutan</small>
                            </label>
                        </div>
                        <div class="col-1">
                            <small>:</small>
                        </div>
                        <div class="col-7">
                            <select name="OrderBy" id="OrderByRiwayatSimpanan" class="form-control">
                                <option value="">Pilih</option>
                                <option value="tanggal">Tanggal Simpanan</option>
                                <option value="kategori">Kategori Simpanan</option>
                                <option value="jumlah">Jumlah Simpanan</option>
                            </select>
                        </div>
                    </div>
                    <div class="row mb-2">
                        <div class="col-4">
                            <label for="ShortByRiwayatSimpanan">
                                <small>Tipe Urutan</small>
                            </label>
                        </div>
                        <div class="col-1">
                            <small>:</small>
                        </div>
                        <div class="col-7">
                            <select name="ShortBy" id="ShortByRiwayatSimpanan" class="form-control">
                                <option value="DESC">Z To A</option>
                                <option value="ASC">A To Z</option>
                            </select>
                        </div>
                    </div>
                    <div class="row mb-2">
                        <div class="col-4">
                            <label for="keyword_by_riwayat_simpanan">
                                <small>Dasar Pencarian</small>
                            </label>
                        </div>
                        <div class="col-1">
                            <small>:</small>
                        </div>
                        <div class="col-7">
                            <select name="keyword_by" id="keyword_by_riwayat_simpanan" class="form-control">
                                <option value="">Pilih</option>
                                <option value="tanggal">Tanggal Simpanan</option>
                                <option value="kategori">Kategori Simpanan</option>
                                <option value="jumlah">Jumlah Simpanan</option>
                            </select>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-4">
                            <label for="keyword_by_riwayat_simpanan">
                                <small>Kata Kunci</small>
                            </label>
                        </div>
                        <div class="col-1">
                            <small>:</small>
                        </div>
                        <div class="col-7" id="FormFilterRiwayatSimpanan">
                            <input type="text" name="keyword" id="keyword_riwayat_simpanan" class="form-control">
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
<div class="modal fade" id="ModalFilterRiwayatPinjaman" tabindex="-1">
    <div class="modal-dialog modal-md">
        <div class="modal-content">
            <form action="javascript:void(0);" id="ProsesFilterRiwayatPinjaman">
                <input type="hidden" name="id_anggota" id="put_id_anggota_riwayat_pinjaman">
                <input type="hidden" name="page" id="put_page_riwayat_pinjaman" value="1">
                <div class="modal-header">
                    <h5 class="modal-title text-dark"><i class="bi bi-funnel"></i> Filter Riwayat Pinjaman</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="row mb-2">
                        <div class="col-4">
                            <label for="batas_riwayat_pinjaman">
                                <small>Batas/Limit</small>
                            </label>
                        </div>
                        <div class="col-1">
                            <small>:</small>
                        </div>
                        <div class="col-7">
                            <select name="batas" id="batas_riwayat_pinjaman" class="form-control">
                                <option value="10">10</option>
                                <option value="25">25</option>
                                <option value="50">50</option>
                                <option value="100">100</option>
                                <option value="250">250</option>
                                <option value="500">500</option>
                            </select>
                        </div>
                    </div>
                    <div class="row mb-2">
                        <div class="col-4">
                            <label for="OrderByRiwayatPinjaman">
                                <small>Mode Urutan</small>
                            </label>
                        </div>
                        <div class="col-1">
                            <small>:</small>
                        </div>
                        <div class="col-7">
                            <select name="OrderBy" id="OrderByRiwayatPinjaman" class="form-control">
                                <option value="">Pilih</option>
                                <option value="tanggal">Tanggal Pinjaman</option>
                                <option value="jumlah_pinjaman">Jumlah Pinjaman</option>
                                <option value="status">Status Pinjaman</option>
                            </select>
                        </div>
                    </div>
                    <div class="row mb-2">
                        <div class="col-4">
                            <label for="ShortByRiwayatPinjaman">
                                <small>Tipe Urutan</small>
                            </label>
                        </div>
                        <div class="col-1">
                            <small>:</small>
                        </div>
                        <div class="col-7">
                            <select name="ShortBy" id="ShortByRiwayatPinjaman" class="form-control">
                                <option value="DESC">Z To A</option>
                                <option value="ASC">A To Z</option>
                            </select>
                        </div>
                    </div>
                    <div class="row mb-2">
                        <div class="col-4">
                            <label for="keyword_by_riwayat_pinjaman">
                                <small>Dasar Pencarian</small>
                            </label>
                        </div>
                        <div class="col-1">
                            <small>:</small>
                        </div>
                        <div class="col-7">
                            <select name="keyword_by" id="keyword_by_riwayat_pinjaman" class="form-control">
                                <option value="">Pilih</option>
                                <option value="tanggal">Tanggal Pinjaman</option>
                                <option value="jumlah_pinjaman">Jumlah Pinjaman</option>
                                <option value="status">Status Pinjaman</option>
                            </select>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-4">
                            <label for="keyword_riwayat_pinjaman">
                                <small>Kata Kunci</small>
                            </label>
                        </div>
                        <div class="col-1">
                            <small>:</small>
                        </div>
                        <div class="col-7" id="FormFilterRiwayatPinjaman">
                            <input type="text" name="keyword" id="keyword_riwayat_pinjaman" class="form-control">
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
<div class="modal fade" id="ModalFilterRiwayatPenjualan" tabindex="-1">
    <div class="modal-dialog modal-md">
        <div class="modal-content">
            <form action="javascript:void(0);" id="ProsesFilterRiwayatPenjualan">
                <input type="hidden" name="id_anggota" id="put_id_anggota_riwayat_penjualan">
                <input type="hidden" name="page" id="put_page_riwayat_penjualan" value="1">
                <div class="modal-header">
                    <h5 class="modal-title text-dark"><i class="bi bi-funnel"></i> Filter Riwayat Penjualan</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="row mb-2">
                        <div class="col-4">
                            <label for="batas_riwayat_pinjaman">
                                <small>Batas/Limit</small>
                            </label>
                        </div>
                        <div class="col-1">
                            <small>:</small>
                        </div>
                        <div class="col-7">
                            <select name="batas" id="batas_riwayat_pinjaman" class="form-control">
                                <!-- <option value="2">2</option> -->
                                <option value="10">10</option>
                                <option value="25">25</option>
                                <option value="50">50</option>
                                <option value="100">100</option>
                                <option value="250">250</option>
                                <option value="500">500</option>
                            </select>
                        </div>
                    </div>
                    <div class="row mb-2">
                        <div class="col-4">
                            <label for="OrderByRiwayatPPenjualan">
                                <small>Mode Urutan</small>
                            </label>
                        </div>
                        <div class="col-1">
                            <small>:</small>
                        </div>
                        <div class="col-7">
                            <select name="OrderBy" id="OrderByRiwayatPPenjualan" class="form-control">
                                <option value="">Pilih</option>
                                <option value="tanggal">Tanggal</option>
                                <option value="total">Jumlah Transaksi</option>
                                <option value="status">Status</option>
                            </select>
                        </div>
                    </div>
                    <div class="row mb-2">
                        <div class="col-4">
                            <label for="ShortByRiwayatPenjualan">
                                <small>Tipe Urutan</small>
                            </label>
                        </div>
                        <div class="col-1">
                            <small>:</small>
                        </div>
                        <div class="col-7">
                            <select name="ShortBy" id="ShortByRiwayatPenjualan" class="form-control">
                                <option value="DESC">Z To A</option>
                                <option value="ASC">A To Z</option>
                            </select>
                        </div>
                    </div>
                    <div class="row mb-2">
                        <div class="col-4">
                            <label for="keyword_by_riwayat_penjualan">
                                <small>Dasar Pencarian</small>
                            </label>
                        </div>
                        <div class="col-1">
                            <small>:</small>
                        </div>
                        <div class="col-7">
                            <select name="keyword_by" id="keyword_by_riwayat_penjualan" class="form-control">
                                <option value="">Pilih</option>
                                <option value="tanggal">Tanggal</option>
                                <option value="total">Jumlah Transaksi</option>
                                <option value="status">Status</option>
                            </select>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-4">
                            <label for="keyword_riwayat_penjualan">
                                <small>Kata Kunci</small>
                            </label>
                        </div>
                        <div class="col-1">
                            <small>:</small>
                        </div>
                        <div class="col-7" id="FormFilterRiwayatPenjualan">
                            <input type="text" name="keyword" id="keyword_riwayat_penjualan" class="form-control">
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
<div class="modal fade" id="ModalTambahAnggota" tabindex="-1">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <form action="javascript:void(0);" id="ProsesTambahAnggota" autocomplete="off">
                <div class="modal-header">
                    <h5 class="modal-title text-dark"><i class="bi bi-plus"></i> Tambah Anggota</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="row mb-3">
                        <div class="col col-md-4">
                            <label for="nip">Nomor Induk Anggota</label>
                        </div>
                        <div class="col-md-8">
                            <input type="text" name="nip" id="nip" class="form-control">
                            <small class="credit">
                                <code class="text text-grayish">
                                    Masukan nomor induk yang unik untuk mewakili data anggota.
                                </code>
                            </small>
                        </div>
                    </div>
                    <div class="row mb-3">
                        <div class="col col-md-4">
                            <label for="nama">Nama Lengkap</label>
                        </div>
                        <div class="col-md-8">
                            <input type="text" name="nama" id="nama" class="form-control">
                        </div>
                    </div>
                    <div class="row mb-3">
                        <div class="col col-md-4">
                            <label for="tanggal_masuk">Tanggal Masuk</label>
                        </div>
                        <div class="col-md-8">
                            <input type="date" name="tanggal_masuk" id="tanggal_masuk" class="form-control">
                        </div>
                    </div>
                    <div class="row mb-3">
                        <div class="col col-md-4">
                            <label for="lembaga">Divisi/Unit Kerja</label>
                        </div>
                        <div class="col-md-8">
                            <input type="text" name="lembaga" id="lembaga" class="form-control" list="list_lembaga">
                            <datalist id="list_lembaga">
                                <?php
                                    $QryLembaga = mysqli_query($Conn, "SELECT DISTINCT lembaga FROM anggota ORDER BY lembaga ASC");
                                    while ($DataLembaga = mysqli_fetch_array($QryLembaga)) {
                                        $list_lembaga= $DataLembaga['lembaga'];
                                        echo '<option value="'.$list_lembaga.'">';
                                    }
                                ?>
                            </datalist>
                        </div>
                    </div>
                    <div class="row mb-3">
                        <div class="col col-md-4">
                            <label for="ranking">Ranking/Group</label>
                        </div>
                        <div class="col-md-8">
                            <input type="text" name="ranking" id="ranking" class="form-control" placeholder="[0-9]">
                        </div>
                    </div>
                    <div class="row mb-3">
                        <div class="col col-md-4">
                            <label for="kontak">No.Kontak</label>
                        </div>
                        <div class="col-md-8">
                            <input type="text" name="kontak" id="kontak" class="form-control" placeholder="62">
                        </div>
                    </div>
                    <div class="row mb-3">
                        <div class="col col-md-4">
                            <label for="email">Email</label>
                        </div>
                        <div class="col-md-8">
                            <input type="email" name="email" id="email" class="form-control" placeholder="email@domain.com">
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" value="Ya" id="akses_anggota" name="akses_anggota">
                                <label class="form-check-label" for="akses_anggota">
                                    <small>
                                        <code class="text-dark">Sertakan akses untuk anggota tersebut</code>
                                    </small>
                                </label>
                            </div>
                        </div>
                    </div>
                    <div class="row mb-3" id="form_password">
                        <div class="col col-md-4">
                            <label for="password">Password</label>
                        </div>
                        <div class="col-md-8">
                            <input type="password" name="password" id="password" class="form-control">
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" value="Ya" id="tampilkan_password_anggota" name="tampilkan_password_anggota">
                                <label class="form-check-label" for="tampilkan_password_anggota">
                                    <small>
                                        <code class="text-dark">Tampilkan Password</code>
                                    </small>
                                </label>
                            </div>
                        </div>
                    </div>
                    <div class="row mb-3">
                        <div class="col col-md-4">
                            <label for="status">Status Keanggotaan</label>
                        </div>
                        <div class="col-md-8">
                            <select name="status" id="status" class="form-control">
                                <option value="">Pilih</option>
                                <option value="Aktif">Aktif</option>
                                <option value="Keluar">Keluar</option>
                            </select>
                        </div>
                    </div>
                    <div class="row mb-3" id="form_tanggal_keluar">
                        <div class="col col-md-4">
                            <label for="tanggal_keluar">Tanggal Keluar</label>
                        </div>
                        <div class="col-md-8">
                            <input type="date" name="tanggal_keluar" id="tanggal_keluar" class="form-control">
                            <small class="credit">
                                <code class="text text-grayish">
                                    Diisi hanya apabila anggota sudah keluar
                                </code>
                            </small>
                        </div>
                    </div>
                    <div class="row mb-3" id="form_alasan_keluar">
                        <div class="col col-md-4">
                            <label for="alasan_keluar">Alasan Keluar</label>
                        </div>
                        <div class="col-md-8">
                            <textarea name="alasan_keluar" id="alasan_keluar" class="form-control"></textarea>
                        </div>
                    </div>
                    <div class="row mb-3">
                        <div class="col col-md-4">
                            <label for="foto">Pas Foto</label>
                        </div>
                        <div class="col-md-8">
                            <input type="file" name="foto" id="foto" class="form-control">
                            <small class="credit">
                                <code class="text text-grayish">
                                    File foto maksimal 2 Mb (JPG, JPEG, PNG dan GIF)
                                </code>
                            </small>
                        </div>
                    </div>
                    <div class="row mb-3">
                        <div class="col col-md-4"></div>
                        <div class="col-md-8">
                            <code class="text-primary">Pastikan data anggota yang anda input sudah benar</code>
                        </div>
                    </div>
                    <div class="row mb-3">
                        <div class="col col-md-4"></div>
                        <div class="col-md-8" id="NotifikasiTambahAnggota">
                            <!-- Notifikasi Tambah Anggota Muncul Disini -->
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
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
<div class="modal fade" id="ModalDetailAnggota" tabindex="-1">
    <div class="modal-dialog modal-md">
        <div class="modal-content">
            <form action="index.php" method="GET">
                <div class="modal-header">
                    <h5 class="modal-title text-dark">
                        <i class="bi bi-info-circle"></i> Detail Anggota
                    </h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body" id="FormDetailAnggota">
                    
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
<div class="modal fade" id="ModalEditAnggota" tabindex="-1">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <form action="javascript:void(0);" id="ProsesEditAnggota">
                <div class="modal-header">
                    <h5 class="modal-title text-dark"><i class="bi bi-pencil"></i> Edit Anggota</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="row">
                        <div class="col-md-12" id="FormEditAnggota">

                        </div>
                    </div>
                    <div class="row mb-3">
                        <div class="col col-md-4"></div>
                        <div class="col-md-8" id="NotifikasiEditAnggota">
                            <!-- Notifikasi Edit Anggota Muncul Disini -->
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="submit" class="btn btn-primary btn-rounded">
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
<div class="modal fade" id="ModalUbahFotoAnggota" tabindex="-1">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <form action="javascript:void(0);" id="ProsesUbahFotoAnggota">
                <div class="modal-header">
                    <h5 class="modal-title text-dark"><i class="bi bi-image"></i> Ubah Foto Anggota</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="row">
                        <div class="col-md-12" id="FormUbahFotoAnggota">

                        </div>
                    </div>
                    <div class="row mb-3">
                        <div class="col col-md-4"></div>
                        <div class="col-md-8" id="NotifikasiUbahFotoAnggota">
                            <!-- Notifikasi Edit Anggota Muncul Disini -->
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="submit" class="btn btn-primary btn-rounded">
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
<div class="modal fade" id="ModalHapusAnggota" tabindex="-1">
    <div class="modal-dialog modal-md">
        <div class="modal-content">
            <form action="javascript:void(0);" id="ProsesHapusAnggota">
                <div class="modal-header">
                    <h5 class="modal-title text-dark"><i class="bi bi-trash"></i> Hapus Data Anggota</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="row">
                        <div class="col-md-12" id="FormHapusAnggota">

                        </div>
                    </div>
                    <div class="row mb-3">
                        <div class="col-md-12 text-center" id="NotifikasiHapusAnggota">
                            <!-- Notifikasi Edit Anggota Muncul Disini -->
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="submit" class="btn btn-primary btn-rounded">
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
<div class="modal fade" id="ModalExport" tabindex="-1">
    <div class="modal-dialog modal-md">
        <div class="modal-content">
            <form action="_Page/Anggota/ProsesExportAnggota.php" method="POST" target="_blank">
                <div class="modal-header">
                    <h5 class="modal-title text-dark"><i class="bi bi-cloud-arrow-down"></i> Export Data Anggota</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="row">
                        <div class="col-md-12" id="FormExport">

                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="submit" class="btn btn-primary btn-rounded">
                        <i class="bi bi-check"></i> Mulai Export
                    </button>
                    <button type="button" class="btn btn-dark btn-rounded" data-bs-dismiss="modal">
                        <i class="bi bi-x-circle"></i> Tutup
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
<div class="modal fade" id="ModalImport" tabindex="-1">
    <div class="modal-dialog modal-md">
        <div class="modal-content">
            <form action="javascript:void(0);" id="ProsesImport">
                <div class="modal-header">
                    <h5 class="modal-title text-dark"><i class="bi bi-cloud-arrow-down"></i> Import Data Anggota</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="row mb-3">
                        <div class="col-md-12">
                            <small class="credit">
                                <code class="text-dark">
                                    Sebelum melakukan import data, perhatikan hal berikut ini.
                                    <ol>
                                        <li>
                                            Pastikan anda menggunakan template file untuk melakukan import 
                                            pada link <a href="_Page/Anggota/Template-Anggota.xlsx">berikut ini</a>.
                                        </li>
                                        <li>
                                            Pada kolom <b>No</b> bisa diisi dengan nomor urutan data.
                                        </li>
                                        <li>
                                            Kolom <b>NIP, Nama, Lembaga, Ranking, Status, Tanggal Masuk</b> wajib untuk diisi.
                                        </li>
                                        <li>
                                            Sistem akan melakukan validasi duplikasi data berdasarkan <b>NIP</b>.
                                        </li>
                                    </ol>
                                </code>
                            </small>
                        </div>
                    </div>
                    <div class="row mb-3">
                        <div class="col col-md-12">
                            <label for="file_excel">File Excel</label>
                            <input type="file" name="file_excel" id="file_excel" class="form-control">
                            <small class="credit">
                                <code class="text text-grayish">
                                    File yang akan diimport hanya boleh berformat excel
                                </code>
                            </small>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-12" id="NotifikasiImport">

                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="submit" class="btn btn-primary btn-rounded">
                        <i class="bi bi-check"></i> Mulai Import
                    </button>
                    <button type="button" class="btn btn-dark btn-rounded" data-bs-dismiss="modal">
                        <i class="bi bi-x-circle"></i> Tutup
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
<div class="modal fade" id="ModalExportImportAnggota" tabindex="-1">
    <div class="modal-dialog modal-md">
        <div class="modal-content">
            <div class="modal-header bg-warning">
                <h5 class="modal-title text-light"><i class="bi bi-server"></i> Database</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div class="row">
                    <div class="col-md-12">
                        <ul>
                            <li>
                                Silahkan download terlebih dulu <i>backup</i> data anggota yang sudah ada pada tautan 
                                <a href="_Page/Anggota/BackupDataAnggota.php">berikut ini <i class="bi bi-file-earmark-ruled-fill"></i> .</a>
                                <ul>
                                    <li>
                                        Pada kolom ID Anggota, anda bisa mengisi ID baru berformat angka untuk anggota baru.
                                    </li>
                                    <li>
                                        Untuk ID lama, secara otomatis sistem akan melakukan update/replace pada data id yang sama.
                                    </li>
                                    <li>
                                        Tanggal daftar harus berformat YYYY-mm-dd misalnya "2023-01-29"
                                    </li>
                                    <li>
                                        NIP, Email dan kontak boleh di kosongkan. Selebihnya wajib diisi.
                                    </li>
                                </ul>
                            </li>
                            <li>
                                Persiapkan data anggota format excel anda sesuai pada tamplate yang sudah anda download tadi.
                            </li>
                            <li>Lanjutkan proses <i>import</i> dengan memilih tombol lanjutkan berikut ini.</li>
                        </ul>
                    </div>
                </div>
            </div>
            <div class="modal-footer bg-warning">
                <a href="index.php?Page=Anggota&Sub=Import" class="btn btn-primary btn-rounded">
                    <i class="bi bi-arrow-right"></i> Lanjutkan
                </a>
                <button type="button" class="btn btn-dark btn-rounded" data-bs-dismiss="modal">
                    <i class="bi bi-x-circle"></i> Tutup
                </button>
            </div>
        </div>
    </div>
</div>
<div class="modal fade" id="ModalExportPembelian" tabindex="-1">
    <div class="modal-dialog modal-md">
        <div class="modal-content">
            <form action="_Page/Anggota/ProsesExportTransaksi.php" method="POST" target="_blank">
                <div class="modal-header bg-info">
                    <h5 class="modal-title text-light"><i class="bi bi-download"></i> Export Transaksi</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body" id="FormExportTransaksi">
                </div>
                <div class="modal-footer bg-info">
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
<div class="modal fade" id="ModalDetailTransaksi" tabindex="-1">
    <div class="modal-dialog modal-md">
        <div class="modal-content">
            <div class="modal-header bg-info">
                <h5 class="modal-title text-light"><i class="bi bi-box"></i> Detail Transaksi</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div id="FormDetailTransaksi">
                
            </div>
        </div>
    </div>
</div>
<div class="modal fade" id="ModalExportRincian" tabindex="-1">
    <div class="modal-dialog modal-md">
        <div class="modal-content">
            <form action="_Page/Anggota/ProsesExportRincian.php" method="POST" target="_blank">
                <div class="modal-header bg-info">
                    <h5 class="modal-title text-light"><i class="bi bi-download"></i> Export Rincian</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body" id="FormExportRincian">
                </div>
                <div class="modal-footer bg-info">
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
<div class="modal fade" id="ModalExportSimpanan" tabindex="-1">
    <div class="modal-dialog modal-md">
        <div class="modal-content">
            <form action="_Page/Anggota/ProsesExportSimpanan.php" method="POST" target="_blank">
                <div class="modal-header bg-info">
                    <h5 class="modal-title text-light"><i class="bi bi-download"></i> Export Simpanan</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body" id="FormExportSimpanan">
                </div>
                <div class="modal-footer bg-info">
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
<div class="modal fade" id="ModalTambahAksesAnggota" tabindex="-1">
    <div class="modal-dialog modal-md">
        <div class="modal-content">
            <form action="javascript:void(0);" id="ProsesTambahAksesAnggota">
                <div class="modal-header bg-primary">
                    <h5 class="modal-title text-light"><i class="bi bi-key"></i> Tambah Akses Anggota</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body" id="FormTambahAksesAnggota">
                    
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
<div class="modal fade" id="ModalStatusAksesAnggota" tabindex="-1">
    <div class="modal-dialog modal-md">
        <div class="modal-content">
            <div class="modal-header bg-warning">
                <h5 class="modal-title text-light"><i class="bi bi-key"></i> Atur Akses Anggota</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body" id="FormStatusAksesAnggota">
                
            </div>
            <div class="modal-footer bg-warning">
                <button type="button" class="btn btn-dark btn-rounded" data-bs-dismiss="modal">
                    <i class="bi bi-x-circle"></i> Tutup
                </button>
            </div>
        </div>
    </div>
</div>
<div class="modal fade" id="ModalHubungkanAnggota" tabindex="-1">
    <div class="modal-dialog modal-sm">
        <div class="modal-content">
            <div class="modal-header bg-primary">
                <h5 class="modal-title text-light"><i class="bi bi-info-circle"></i> Akses Anggota</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body" id="FormHubungkanAnggota">
                
            </div>
            <div class="modal-footer bg-primary">
                <button type="button" class="btn btn-success btn-rounded" id="KonfirmasiHubungkanAnggota">
                    <i class="bi bi-check"></i> Ya
                </button>
                <button type="button" class="btn btn-dark btn-rounded" data-bs-dismiss="modal">
                    <i class="bi bi-x-circle"></i> Tidak
                </button>
            </div>
        </div>
    </div>
</div>
<div class="modal fade" id="ModalDeletePermintaanAksesAnggota" tabindex="-1">
    <div class="modal-dialog modal-md">
        <div class="modal-content">
            <div class="modal-header bg-danger">
                <h5 class="modal-title text-light"><i class="bi bi-trash"></i> Hapus Permintaan Akses</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body" id="FormDeletePermintaanAksesAnggota">
                
            </div>
            <div class="modal-footer bg-danger">
                <button type="button" class="btn btn-success btn-rounded" id="KonfirmasiDeletePermintaanAksesAnggota">
                    <i class="bi bi-check"></i> Ya
                </button>
                <button type="button" class="btn btn-dark btn-rounded" data-bs-dismiss="modal">
                    <i class="bi bi-x-circle"></i> Tidak
                </button>
            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="ModalRekapSiimpananAnggota" tabindex="-1">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title text-dark">
                    <i class="bi bi-bar-chart-line"></i> Rekapitulasi Riwayat Simpanan
                </h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body" id="FormRekapSiimpananAnggota">
                <!-- Informasi Rekapitulasi Simpanan Anggota Akan Ditampilkan Disini -->
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-dark btn-rounded" data-bs-dismiss="modal">
                    <i class="bi bi-x-circle"></i> Tutup
                </button>
            </div>
        </div>
    </div>
</div>
<div class="modal fade" id="ModalExportRiwayatSimpanan" tabindex="-1">
    <div class="modal-dialog modal-md">
        <div class="modal-content">
            <form action="_Page/Anggota/ProsesExportRiwayatSimpanan.php" method="POST" id="ProsesExportRiwayatSimpanan" target="_blank">
                <div class="modal-header">
                    <h5 class="modal-title text-dark">
                        <i class="bi bi-download"></i> Download/Export Riwayat Simpanan
                    </h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body" id="form_export_riwayat_simpanan">
                    
                </div>
                <div class="modal-footer">
                    <button type="submit" class="btn btn-success btn-rounded" id="ButtonExportRiwayatSimpanan">
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
<div class="modal fade" id="ModalDetailPinjamanAnggota" tabindex="-1">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <form action="_Page/Pinjaman/ProsesExportAngsuran.php" method="POST" id="ProsesExportDetailPinjaman" target="_blank">
                <div class="modal-header">
                    <h5 class="modal-title text-dark">
                        <i class="bi bi-download"></i> Download/Export Detail Pinjaman
                    </h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="row mb-3">
                        <div class="col-md-12" id="form_detail_riwayat_pinjaman">

                        </div>
                    </div>
                    <div class="row mb-3">
                        <div class="col-md-12">
                            <diiv class="table table-responsive">
                                <table class="table table-striped table-hover">
                                    <thead>
                                        <tr>
                                            <th><b>No</b></th>
                                            <th><b>Tanggal</b></th>
                                            <th><b>Pokok</b></th>
                                            <th><b>Jasa</b></th>
                                            <th><b>Denda</b></th>
                                            <th><b>Jumlah</b></th>
                                        </tr>
                                    </thead>
                                    <tbody id="table_riwayat_angsuran">
                                        <tr>
                                            <td colspan="6" class="text-center">
                                                <small class="text-danger">Tidak Ada Data Riwayat Angsuran Yang Ditampilkan</small>
                                            </td>
                                        </tr>
                                    </tbody>
                                </table>
                            </diiv>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="submit" class="btn btn-success btn-rounded" id="ButtonExportRiwayatPinjaman">
                        <i class="bi bi-download"></i> Download / Export
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
                        <div class="col-12" id="FormDetailPenjualan">
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
                                    <tbody id="ListDetailPenjualan">
                                        <!-- List Detail Transaksi Disini -->
                                    </tbody>
                                </table>
                            </div>
                            
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="submit" class="btn btn-md btn-outline-info btn-rounded" id="ButtonDetailPenjualanSelengkapnya">
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

<div class="modal fade" id="ModalExportRiwayatPenjualan" tabindex="-1">
    <div class="modal-dialog modal-md">
        <div class="modal-content">
            <form action="javascript:void(0);" id="ProsesExportRiwayatPenjualan">
                <div class="modal-header">
                    <h5 class="modal-title text-dark">
                        <i class="bi bi-download"></i> Download/Export Riwayat Penjualan
                    </h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="row mb-3">
                        <div class="col-12" id="FormExportPenjualanAnggota">
                            <!-- Form Export Penjualan Anggota Disini -->
                        </div>
                    </div>
                    <div class="row mb-3">
                        <div class="col-12" id="NotifikasiExportPenjualanAnggota">
                            <!-- Notifikasi Export Penjualan Anggota Disini -->
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="submit" class="btn btn-md btn-outline-info btn-rounded" id="ButtonExportPenjualanAnggota">
                        <i class="bi bi-download"></i> Export / Download
                    </button>
                    <button type="button" class="btn btn-dark btn-rounded" data-bs-dismiss="modal">
                        <i class="bi bi-x-circle"></i> Tutup
                    </button>
                </div>
            </div>
        </form>
    </div>
</div>
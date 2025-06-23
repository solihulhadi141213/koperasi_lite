<div class="modal fade" id="ModalFilter" tabindex="-1">
    <div class="modal-dialog modal-md">
        <div class="modal-content">
            <form action="javascript:void(0);" id="ProsesFilter">
                <input type="hidden" name="page" id="page">
                <div class="modal-header">
                    <h5 class="modal-title text-dark"><i class="bi bi-funnel"></i> Filter Simpanan Wajib</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="row mb-3">
                        <div class="col col-md-4"><label for="batas">Limit Data</label></div>
                        <div class="col col-md-8">
                            <select name="batas" id="batas" class="form-control">
                                <option value="10">10</option>
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
                        <div class="col col-md-4"><label for="OrderBy">Mode Urutan</label></div>
                        <div class="col col-md-8">
                            <select name="OrderBy" id="OrderBy" class="form-control">
                                <option value="">Pilih</option>
                                <option value="nip">NIP</option>
                                <option value="nama">Nama Anggota</option>
                                <option value="lembaga">Divisi/Unit</option>
                                <option value="ranking">Ranking</option>
                                <option value="status">Status</option>
                            </select>
                        </div>
                    </div>
                    <div class="row mb-3">
                        <div class="col col-md-4"><label for="ShortBy">Tipe urutan</label></div>
                        <div class="col col-md-8">
                            <select name="ShortBy" id="ShortBy" class="form-control">
                                <option value="DESC">Z To A</option>
                                <option value="ASC">A To Z</option>
                            </select>
                        </div>
                    </div>
                    <div class="row mb-3">
                        <div class="col col-md-4"><label for="keyword_by">Pencarian</label></div>
                        <div class="col col-md-8">
                            <select name="keyword_by" id="keyword_by" class="form-control">
                                <option value="">Pilih</option>
                                <option value="nip">NIP</option>
                                <option value="nama">Nama Anggota</option>
                                <option value="lembaga">Divisi/Unit</option>
                                <option value="ranking">Ranking</option>
                                <option value="status">Status</option>
                            </select>
                        </div>
                    </div>
                    <div id="FormFilter">
                        <div class="row mb-3">
                            <div class="col col-md-4"><label for="keyword">Kata Kunci</label></div>
                            <div class="col col-md-8">
                                <input type="text" name="keyword" id="keyword" class="form-control">
                            </div>
                        </div>
                    </div>
                    <div class="row mb-3">
                        <div class="col col-md-4"><label for="mode_periode">Periode</label></div>
                        <div class="col col-md-8">
                            <select name="mode_periode" id="mode_periode" class="form-control">
                                <option value="">Pilih</option>
                                <option value="Tahunan">Tahunan</option>
                                <option selected value="Bulanan">Bulanan</option>
                            </select>
                        </div>
                    </div>
                    <div id="FormTahun">
                        <div class="row mb-3">
                            <div class="col col-md-4"><label for="tahun">Tahun</label></div>
                            <div class="col col-md-8">
                                <input type="number" min="2000" max="<?php echo date('Y'); ?>" name="tahun" id="tahun" class="form-control" value="<?php echo date('Y'); ?>">
                            </div>
                        </div>
                        <div class="row mb-3">
                            <div class="col col-md-4"><label for="semester">Semester</label></div>
                            <div class="col col-md-8">
                                <select name="semester" id="semester" class="form-control">
                                    <option value="1">Semester 1</option>
                                    <option value="2">Semester 2</option>
                                </select>
                            </div>
                        </div>
                    </div>
                    <div class="row mb-3">
                        <div class="col col-md-4"><label for="id_simpanan_jenis">Jenis Simpanan</label></div>
                        <div class="col col-md-8">
                            <select name="id_simpanan_jenis" id="id_simpanan_jenis" class="form-control">
                                <option value="">Semua/Akumulasi</option>
                                <?php
                                    $query = mysqli_query($Conn, "SELECT*FROM simpanan_jenis WHERE rutin='1' ORDER BY nama_simpanan ASC");
                                    while ($data = mysqli_fetch_array($query)) {
                                        $id_simpanan_jenis= $data['id_simpanan_jenis'];
                                        $nama_simpanan= $data['nama_simpanan'];
                                        echo '<option value="'.$id_simpanan_jenis.'">'.$nama_simpanan.'</option>';
                                    }
                                ?>
                            </select>
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
<div class="modal fade" id="ModalTambahSimpananWajib" tabindex="-1">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <form action="javascript:void(0);" id="ProsesTambahSimpananWajib">
                <div class="modal-header">
                    <h5 class="modal-title text-dark"><i class="bi bi-plus"></i> Simpanan Wajib</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="row mb-3">
                        <div class="col-md-12" id="FormTambahSimpananWajib">

                        </div>
                    </div>
                    <div class="row mb-3">
                        <div class="col-md-12" id="NotifikasiTambahSimpananWajib">

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
            <div class="modal-header">
                <h5 class="modal-title text-dark">
                    <i class="bi bi-info-circle"></i> Detail Anggota
                </h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body" id="FormDetailAnggota">
                
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-dark btn-rounded" data-bs-dismiss="modal">
                    <i class="bi bi-x-circle"></i> Tutup
                </button>
            </div>
        </div>
    </div>
</div>
<div class="modal fade" id="ModalDetailSimpananWajib" tabindex="-1">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title text-dark">
                    <i class="bi bi-info-circle"></i> Detail Simpanan Wajib
                </h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body" id="FormDetailSimpananWajib">
                
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-dark btn-rounded" data-bs-dismiss="modal">
                    <i class="bi bi-x-circle"></i> Tutup
                </button>
            </div>
        </div>
    </div>
</div>
<div class="modal fade" id="ModalEditSimpanan" tabindex="-1">
    <div class="modal-dialog modal-md">
        <div class="modal-content">
            <form action="javascript:void(0);" id="ProsesEditSimpanan">
                <div class="modal-header">
                    <h5 class="modal-title text-dark"><i class="bi bi-pencil"></i> Edit Simpanan</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div id="FormEditSimpanan">
                        <!-- Form Edit Simpanan Disini -->
                    </div>
                    <div class="row mb-3">
                        <div class="col-md-12 text-center" id="NotifikasiEditSimpanan">
                            <!-- Notifikasi Edit Simpanan Disini -->
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>
<div class="modal fade" id="ModalHapusSimpanan" tabindex="-1">
    <div class="modal-dialog modal-md">
        <div class="modal-content">
            <form action="javascript:void(0);" id="ProsesHapusSimpanan">
                <div class="modal-header">
                    <h5 class="modal-title text-dark">
                        <i class="bi bi-trash"></i> Hapus Simpanan
                    </h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div id="FormHapusSimpanan">
                        <!-- Form Hapus Simpanan Disini -->
                    </div>
                    <div class="row mb-3">
                        <div class="col-md-12 text-center" id="NotifikasiHapusSimpanan">
                            <!-- Notifikasi Hapus Simpanan Disini -->
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>
<div class="modal fade" id="ModalExport" tabindex="-1">
    <div class="modal-dialog modal-md">
        <div class="modal-content">
            <form action="_Page/SimpananWajib/ProsesExportSimpanan.php" method="POST" target="_blank">
                <div class="modal-header">
                    <h5 class="modal-title text-dark">
                        <i class="bi bi-download"></i> Export Simpanan Wajib
                    </h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div id="FormExport">
                        <!-- Form Hapus Simpanan Disini -->
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
<div class="modal fade" id="ModalTambahSimpananWajibParsial" tabindex="-1">
    <div class="modal-dialog modal-md">
        <div class="modal-content">
            <form action="javascript:void(0);" id="ProsesTambahSimpananWajibParsial">
                <div class="modal-header">
                    <h5 class="modal-title text-dark"><i class="bi bi-plus"></i> Simpanan Wajib (Parsial)</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div id="FormTambahSimpananWajibParsial">
                        <!-- Form Edit Simpanan Disini -->
                    </div>
                    <div class="row mb-3">
                        <div class="col-md-12 text-center" id="NotifikasiTambahSimpananWajibParsial">
                            <!-- Notifikasi Edit Simpanan Disini -->
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
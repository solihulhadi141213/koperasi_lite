<div class="modal fade" id="ModalFilter" tabindex="-1">
    <div class="modal-dialog modal-md">
        <div class="modal-content">
            <form action="javascript:void(0);" id="ProsesFilter">
                <input type="hidden" name="page" id="page">
                <div class="modal-header">
                    <h5 class="modal-title text-dark"><i class="bi bi-filter"></i> Filter Jurnal</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="row mb-3">
                        <div class="col-md-4"><label for="batas">Batas</label></div>
                        <div class="col-md-8">
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
                        <div class="col-md-4"><label for="OrderBy">Mode Urutan</label></div>
                        <div class="col-md-8">
                            <select name="OrderBy" id="OrderBy" class="form-control">
                                <option value="">Pilih</option>
                                <option value="tanggal">Tanggal</option>
                                <option value="kategori">Kategori</option>
                                <option value="kode_perkiraan">Kode Perkiraan</option>
                                <option value="nama_perkiraan">Nama Perkiraan</option>
                            </select>
                        </div>
                    </div>
                    <div class="row mb-3">
                        <div class="col-md-4"><label for="ShortBy">Tipe Urutan</label></div>
                        <div class="col-md-8">
                            <select name="ShortBy" id="ShortBy" class="form-control">
                                <option value="ASC">A To Z</option>
                                <option selected value="DESC">Z To A</option>
                            </select>
                        </div>
                    </div>
                    <div class="row mb-3">
                        <div class="col-md-4"><label for="KeywordBy">Dasar Pencarian</label></div>
                        <div class="col-md-8">
                            <select name="KeywordBy" id="KeywordBy" class="form-control">
                                <option value="">Pilih</option>
                                <option value="tanggal">Tanggal</option>
                                <option value="kategori">Kategori</option>
                                <option value="kode_perkiraan">Kode Perkiraan</option>
                                <option value="nama_perkiraan">Nama Perkiraan</option>
                            </select>
                        </div>
                    </div>
                    <div class="row mb-3">
                        <div class="col-md-4"><label for="keyword">Kata Kunci</label></div>
                        <div class="col-md-8" id="FormFilter">
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
<div class="modal fade" id="ModalExport" tabindex="-1">
    <div class="modal-dialog modal-md">
        <div class="modal-content">
            <form action="_Page/Jurnal/ProsesExport.php" method="POST" target="_blank">
                <div class="modal-header">
                    <h5 class="modal-title text-dark">
                        <i class="bi bi-download"></i> Export Jurnal
                    </h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="row mb-3">
                        <div class="col-md-12">
                            Tentukan periode data jurnal yang ingin anda tampilkan.
                        </div>
                    </div>
                    <div class="row mb-3">
                        <div class="col-md-4">
                            <label for="periode_1">Periode Awal</label>
                        </div>
                        <div class="col-md-8">
                            <input type="date" name="periode_1" id="periode_1" class="form-control">
                        </div>
                    </div>
                    <div class="row mb-3">
                        <div class="col-md-4">
                            <label for="periode_2">Periode Akhir</label>
                        </div>
                        <div class="col-md-8">
                            <input type="date" name="periode_2" id="periode_2" class="form-control">
                            <small id="NotifikasiFormExport"></small>
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
<div class="modal fade" id="ModalTambahJurnalKeuangan" tabindex="-1">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <form action="javascript:void(0);" id="ProsesTambahJurnal">
                <div class="modal-header">
                    <h5 class="modal-title text-dark"><i class="bi bi-plus"></i> Tambah Jurnal</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="row mb-3">
                        <div class="col-md-4">
                            <label for="kategori">Kategori</label>
                        </div>
                        <div class="col-md-8">
                            <select name="kategori" id="kategori" class="form-control">
                                <option value="">Pilih</option>
                                <option value="Simpanan">Simpanan Anggota</option>
                                <option value="Penarikan">Penarikan Dana</option>
                                <option value="Pinjaman">Pinjaman</option>
                                <option value="Angsuran">Angsuran</option>
                                <option value="Bagi Hasil">Bagi Hasil (SHU)</option>
                                <option value="Transaksi">Transaksi Lainnya</option>
                            </select>
                        </div>
                    </div>
                    <div class="row mb-3">
                        <div class="col-md-4">
                            <label for="uuid">Referensi (UUID)</label>
                        </div>
                        <div class="col-md-8">
                            <input type="text" name="uuid" id="uuid" class="form-control">
                            <small>
                                <code class="text text-grayish">
                                    *Isi dengan kode UUID Transaksi 
                                </code>
                            </small>
                        </div>
                    </div>
                    <div class="row mb-3">
                        <div class="col-md-4">
                            <label for="tanggal">Tanggal</label>
                        </div>
                        <div class="col-md-8">
                            <input type="date" name="tanggal" id="tanggal" class="form-control">
                        </div>
                    </div>
                    <div class="row mb-3">
                        <div class="col-md-4">
                            <label for="id_perkiraan">Akun Perkiraan</label>
                        </div>
                        <div class="col-md-8">
                            <select name="id_perkiraan" id="id_perkiraan" class="form-control" required>
                                <?php
                                    echo '<option value="">Pilih</option>';
                                    
                                    // Query untuk mengambil akun level 1 (group utama)
                                    $QryGroupUtama = mysqli_query($Conn, "SELECT * FROM akun_perkiraan WHERE level='1' ORDER BY nama");
                                    
                                    while ($GroupUtama = mysqli_fetch_array($QryGroupUtama)) {
                                        $id_perkiraan_utama = $GroupUtama['id_perkiraan'];
                                        $kode_utama = $GroupUtama['kode'];
                                        $nama_utama = $GroupUtama['nama'];
                                        $saldo_normal_utama = $GroupUtama['saldo_normal'];
                                        // Tampilkan group utama
                                        echo '<optgroup label="'.$nama_utama.' ('.$saldo_normal_utama.')">';
                                        // Query untuk mengambil anak group dari group utama berdasarkan kode
                                        $QryAnakGroup = mysqli_query($Conn, "SELECT * FROM akun_perkiraan WHERE kode LIKE '$kode_utama%' AND level != '1' ORDER BY nama");
                                        while ($AnakGroup = mysqli_fetch_array($QryAnakGroup)) {
                                            $id_perkiraan_anak = $AnakGroup['id_perkiraan'];
                                            $nama_anak = $AnakGroup['nama'];
                                            $saldo_normal_anak = $AnakGroup['saldo_normal'];
                                            $kode = $AnakGroup['kode'];
                                            $level = $AnakGroup['level'];
                                            $LevelTerbawah = mysqli_num_rows(mysqli_query($Conn, "SELECT*FROM akun_perkiraan WHERE kd$level='$kode'"));
                                            // Tampilkan anak group
                                            if($LevelTerbawah=="1"){
                                                echo '<option value="'.$id_perkiraan_anak.'">-- '.$nama_anak.' ('.$saldo_normal_anak.')</option>';
                                            }
                                        }
                                        echo '</optgroup>';
                                    }
                                ?>
                            </select>
                        </div>
                    </div>
                    <div class="row mb-3">
                        <div class="col-md-4">
                            <label for="d_k">Debet/Kredit</label>
                        </div>
                        <div class="col-md-8">
                            <select name="d_k" id="d_k" class="form-control" required>
                                <option value="">Pilih</option>
                                <option value="D">Debet</option>
                                <option value="K">Kredit</option>
                            </select>
                        </div>
                    </div>
                    <div class="row mb-3">
                        <div class="col-md-4">
                            <label for="nominal">Nominal</label>
                        </div>
                        <div class="col-md-8">
                            <input type="text" required class="form-control format_uang" name="nominal" id="nominal">
                        </div>
                    </div>
                    <div class="row mb-3">
                        <div class="col-md-4"></div>
                        <div class="col-md-8" id="NotifikasiTambahJurnal">
                            <small>Pastikan data jurnal sudah sesuai</small>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="submit" class="btn btn-md btn-success btn-rounded">
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
<div class="modal fade" id="ModalDetailJurnal" tabindex="-1">
    <div class="modal-dialog modal-md">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title text-dark">
                    <i class="bi bi-info-circle"></i> Detail Jurnal
                </h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body" id="FormDetailJurnal">
                <!-- Informasi Detail Jurnal Akan Muncul Disini -->
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-dark btn-rounded" data-bs-dismiss="modal">
                    <i class="bi bi-x-circle"></i> Tutup
                </button>
            </div>
        </div>
    </div>
</div>
<div class="modal fade" id="ModalEditJurnal" tabindex="-1">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <form action="javascript:void(0);" id="ProsesEditJurnal">
                <div class="modal-header">
                    <h5 class="modal-title text-dark">
                        <i class="bi bi-pencil"></i> Edit Jurnal
                    </h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="row mb-3">
                        <div class="col-md-12" id="FormEditJurnal">
                            <!-- Form Edit Jurnal Akan Muncul Disini -->
                        </div>
                    </div>
                    <div class="row mb-3">
                        <div class="col-md-4"></div>
                        <div class="col-md-8" id="NotifikasiEditJurnal">
                            <small>Pastikan data jurnal sudah sesuai</small>
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
<div class="modal fade" id="ModalHapusJurnal" tabindex="-1">
    <div class="modal-dialog modal-md">
        <div class="modal-content">
            <form action="javascript:void(0);" id="ProsesHapusJurnal">
                <div class="modal-header">
                    <h5 class="modal-title text-dark">
                        <i class="bi bi-trash"></i> Hapus Jurnal
                    </h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="row mb-3">
                        <div class="col-md-12" id="FormHapusJurnal">
                            <!-- Form Hapus Jurnal Akan Muncul Disini -->
                        </div>
                    </div>
                    <div class="row mb-3">
                        <div class="col-md-12 text-center" id="NotifikasiHapusJurnal">
                            
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="submit" class="btn btn-success btn-rounded">
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
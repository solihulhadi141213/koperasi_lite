<div class="modal fade" id="ModalFilter" tabindex="-1">
    <div class="modal-dialog modal-md">
        <div class="modal-content">
            <form action="javascript:void(0);" id="ProsesFilter">
                <input type="hidden" name="page" id="page">
                <div class="modal-header">
                    <h5 class="modal-title text-dark"><i class="bi bi-funnel"></i> Filter Jenis Transaksi</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="row">
                        <div class="col-md-6 mt-3">
                            <label for="batas">Data</label>
                            <select name="batas" id="batas" class="form-control">
                                <option value="10">10</option>
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
                                <option value="nama">Nama Transaksi</option>
                                <option value="kategori">Kategori</option>
                                <option value="deskripsi">Deskripsi</option>
                                <option value="id_akun_debet">Akun Debet</option>
                                <option value="id_akun_kredit">Akun Kredit</option>
                            </select>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6 mt-3">
                            <label for="ShortBy">Tipe urutan</label>
                            <select name="ShortBy" id="ShortBy" class="form-control">
                                <option value="DESC">Z To A</option>
                                <option value="ASC">A To Z</option>
                            </select>
                        </div>
                        <div class="col-md-6 mt-3">
                            <label for="keyword_by">Pencarian</label>
                            <select name="keyword_by" id="keyword_by" class="form-control">
                                <option value="">Pilih</option>
                                <option value="nama">Nama Transaksi</option>
                                <option value="kategori">Kategori</option>
                                <option value="deskripsi">Deskripsi</option>
                                <option value="id_akun_debet">Akun Debet</option>
                                <option value="id_akun_kredit">Akun Kredit</option>
                            </select>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-12 mt-3" id="FormFilter">
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
<div class="modal fade" id="ModalTambahJenisTransaksi" tabindex="-1">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <form action="javascript:void(0);" id="ProsesTambahJenisTransaksi" autocomplete="off">
                <div class="modal-header">
                    <h5 class="modal-title text-dark">
                        <i class="bi bi-plus"></i> Tambah Jenis Transaksi
                    </h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="row mb-3">
                        <div class="col col-md-4">
                            <label for="nama">Jenis Transaksi</label>
                        </div>
                        <div class="col-md-8">
                            <input type="text" name="nama" id="nama" class="form-control">
                            <small class="credit">
                                <code class="text text-grayish">
                                    Nama jenis transaksi (Ex: Iuran Air dan listrik, Gaji Staf, ATK, Dll)
                                </code>
                            </small>
                        </div>
                    </div>
                    <div class="row mb-3">
                        <div class="col col-md-4">
                            <label for="kategori">Kategori</label>
                        </div>
                        <div class="col-md-8">
                            <input type="text" name="kategori" id="kategori" id="list_kategori" class="form-control">
                            <datalist id="list_kategori">
                                <?php
                                    $QryKategori = mysqli_query($Conn, "SELECT DISTINCT kategori FROM transaksi_jenis ORDER BY kategori ASC");
                                    while ($DataKategori = mysqli_fetch_array($QryKategori)) {
                                        $ListKategori= $DataKategori['kategori'];
                                        echo '<option value="'.$ListKategori.'">';
                                    }
                                ?>
                            </datalist>
                            <small class="credit">
                                <code class="text text-grayish">
                                    Kelompok/Group transaksi (Ex: Biaya Operasional, Gaji, Perlengkapan )
                                </code>
                            </small>
                        </div>
                    </div>
                    <div class="row mb-3">
                        <div class="col col-md-4">
                            <label for="deskripsi">Deskripsi</label>
                        </div>
                        <div class="col-md-8">
                            <textarea name="deskripsi" id="deskripsi" class="form-control"></textarea>
                            <small class="credit">
                                <code class="text text-grayish">
                                    Gambaran singkat mengenai transaksi tersebut.
                                </code>
                            </small>
                        </div>
                    </div>
                    <div class="row mb-3">
                        <div class="col col-md-4">
                            <label for="id_akun_debet">Akun Perkiraan (Debet)</label>
                        </div>
                        <div class="col-md-8">
                            <select name="id_akun_debet" id="id_akun_debet" class="form-control">
                                <option value="">Pilih</option>
                                <?php
                                    $QryAkun= mysqli_query($Conn, "SELECT*FROM akun_perkiraan ORDER BY nama");
                                    while ($DataAkun=mysqli_fetch_array($QryAkun)) {
                                        $id_perkiraan = $DataAkun['id_perkiraan'];
                                        $kode= $DataAkun['kode'];
                                        $nama_perkiraan = $DataAkun['nama'];
                                        $level= $DataAkun['level'];
                                        $saldo_normal= $DataAkun['saldo_normal'];
                                        //Cek apakah di levelnya ada lagi?
                                        $LevelTerbawah = mysqli_num_rows(mysqli_query($Conn, "SELECT*FROM akun_perkiraan WHERE kd$level='$kode'"));
                                        if($LevelTerbawah=="1"){
                                            echo '<option value="'.$id_perkiraan.'">'.$nama_perkiraan.' ('.$saldo_normal.')</option>';
                                        }
                                    }
                                ?>
                            </select>
                            <small class="credit">
                                <code class="text text-grayish">
                                    Pengaturan akun perkiraan yang akan digunakan pada lajur debet
                                </code>
                            </small>
                        </div>
                    </div>
                    <div class="row mb-3">
                        <div class="col col-md-4">
                            <label for="id_akun_kredit">Akun Perkiraan (Kredit)</label>
                        </div>
                        <div class="col-md-8">
                            <select name="id_akun_kredit" id="id_akun_kredit" class="form-control">
                                <option value="">Pilih</option>
                                <?php
                                    $QryAkun= mysqli_query($Conn, "SELECT*FROM akun_perkiraan ORDER BY nama");
                                    while ($DataAkun=mysqli_fetch_array($QryAkun)) {
                                        $id_perkiraan = $DataAkun['id_perkiraan'];
                                        $kode= $DataAkun['kode'];
                                        $nama_perkiraan = $DataAkun['nama'];
                                        $level= $DataAkun['level'];
                                        $saldo_normal= $DataAkun['saldo_normal'];
                                        //Cek apakah di levelnya ada lagi?
                                        $LevelTerbawah = mysqli_num_rows(mysqli_query($Conn, "SELECT*FROM akun_perkiraan WHERE kd$level='$kode'"));
                                        if($LevelTerbawah=="1"){
                                            echo '<option value="'.$id_perkiraan.'">'.$nama_perkiraan.' ('.$saldo_normal.')</option>';
                                        }
                                    }
                                ?>
                            </select>
                            <small class="credit">
                                <code class="text text-grayish">
                                    Pengaturan akun perkiraan yang akan digunakan pada lajur kredit
                                </code>
                            </small>
                        </div>
                    </div>
                    <div class="row mb-3">
                        <div class="col col-md-4"></div>
                        <div class="col-md-8">
                            <code class="text-primary">Pastikan data yang anda input sudah benar</code>
                        </div>
                    </div>
                    <div class="row mb-3">
                        <div class="col col-md-4"></div>
                        <div class="col-md-8" id="NotifikasiTambahJenisTransaksi">
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
<div class="modal fade" id="ModalDetail" tabindex="-1">
    <div class="modal-dialog modal-md">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title text-dark">
                    <i class="bi bi-info-circle"></i> Detail Jenis Transaksi
                </h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body" id="FormDetail">
                <!-- Uraian Detail Jenis Transaksi Akan Muncul Disini -->
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-dark btn-rounded" data-bs-dismiss="modal">
                    <i class="bi bi-x-circle"></i> Tutup
                </button>
            </div>
        </div>
    </div>
</div>
<div class="modal fade" id="ModalEdit" tabindex="-1">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <form action="javascript:void(0);" id="ProsesEdit">
                <div class="modal-header">
                    <h5 class="modal-title text-dark"><i class="bi bi-pencil"></i> Edit Jenis Transaksi</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="row">
                        <div class="col-md-12" id="FormEdit">

                        </div>
                    </div>
                    <div class="row mb-3">
                        <div class="col col-md-4"></div>
                        <div class="col-md-8" id="NotifiasiEdit">
                            <!-- Notifikasi Edit Muncul Disini -->
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
<div class="modal fade" id="ModalHapus" tabindex="-1">
    <div class="modal-dialog modal-md">
        <div class="modal-content">
            <form action="javascript:void(0);" id="ProsesHapus">
                <div class="modal-header">
                    <h5 class="modal-title text-dark"><i class="bi bi-trash"></i> Hapus Jenis Transaksi</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="row">
                        <div class="col-md-12" id="FormHapus">

                        </div>
                    </div>
                    <div class="row mb-3">
                        <div class="col-md-12 text-center" id="NotifikasiHapus">
                            <!-- Notifikasi Hapus Muncul Disini -->
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
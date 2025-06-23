<div class="modal fade" id="ModalTambahJenisSimpanan" tabindex="-1">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <form action="javascript:void(0);" id="ProsesTambahJenisSimpanan" autocomplete="off">
                <div class="modal-header">
                    <h5 class="modal-title text-dark"><i class="bi bi-plus"></i> Tambah Jenis Simpanan</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="row mb-3">
                        <div class="col col-md-4">
                            <label for="nama_simpanan">Nama Jenis Simpanan</label>
                        </div>
                        <div class="col-md-8">
                            <input type="text" name="nama_simpanan" id="nama_simpanan" class="form-control">
                        </div>
                    </div>
                    <div class="row mb-3">
                        <div class="col col-md-4">
                            <label for="keterangan">Deskripsi</label>
                        </div>
                        <div class="col-md-8">
                            <textarea name="keterangan" id="keterangan" class="form-control"></textarea>
                        </div>
                    </div>
                    <div class="row mb-3">
                        <div class="col col-md-4">
                            <label for="rutin">Simapanan Wajib</label>
                        </div>
                        <div class="col-md-8">
                            <select name="rutin" id="rutin" class="form-control">
                                <option value="">Pilih</option>
                                <option value="1">Ya</option>
                                <option value="0">Tidak</option>
                            </select>
                            <small class="credit">
                                <code class="text text-dark">
                                    Simpanan wajib diatur agar proses debet dapat dilakukan secara simultan.
                                </code>
                            </small>
                        </div>
                    </div>
                    <div class="row mb-3" id="form_nominal">
                        <div class="col col-md-4">
                            <label for="nominal">Nominal</label>
                        </div>
                        <div class="col-md-8">
                            <input type="text" name="nominal" id="nominal" class="form-control form-money">
                        </div>
                    </div>
                    <div class="row mb-3">
                        <div class="col col-md-4">
                            <label for="id_perkiraan_debet">Auto Jurnal Debet</label>
                        </div>
                        <div class="col-md-8">
                            <select name="id_perkiraan_debet" id="id_perkiraan_debet" class="form-control">
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
                        </div>
                    </div>
                    <div class="row mb-3">
                        <div class="col col-md-4">
                            <label for="id_perkiraan_kredit">Auto Jurnal Kredit</label>
                        </div>
                        <div class="col-md-8">
                            <select name="id_perkiraan_kredit" id="id_perkiraan_kredit" class="form-control">
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
                        </div>
                    </div>
                    <div class="row mb-3">
                        <div class="col col-md-4"></div>
                        <div class="col-md-8">
                            <code class="text-primary">Pastikan jenis simpanan yang anda input sudah benar</code>
                        </div>
                    </div>
                    <div class="row mb-3">
                        <div class="col col-md-4"></div>
                        <div class="col-md-8" id="NotifikasiTambahJenisSimpanan">
                            <!-- Notifikasi Tambah Jenis Simpanan Muncul Disini -->
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
<div class="modal fade" id="ModalDetailJenisSimpanan" tabindex="-1">
    <div class="modal-dialog modal-md">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title text-dark">
                    <i class="bi bi-info-circle"></i> Detail Jenis Simpanan
                </h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body" id="FormDetailJenisSimpanan">
                
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-dark btn-rounded" data-bs-dismiss="modal">
                    <i class="bi bi-x-circle"></i> Tutup
                </button>
            </div>
        </div>
    </div>
</div>
<div class="modal fade" id="ModalEditJenisSimpanan" tabindex="-1">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <form action="javascript:void(0);" id="ProsesEditJenisSimpanan">
                <div class="modal-header">
                    <h5 class="modal-title text-dark"><i class="bi bi-pencil"></i> Edit Jenis Simpanan</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="row">
                        <div class="col-md-12" id="FormEditJenisSimpanan">

                        </div>
                    </div>
                    <div class="row mb-3">
                        <div class="col col-md-4"></div>
                        <div class="col-md-8" id="NotifikasiEditJenisSimpanan">
                            <!-- Notifikasi Edit Jenis Simpanan Muncul Disini -->
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
<div class="modal fade" id="ModalHapusJenisSimpanan" tabindex="-1">
    <div class="modal-dialog modal-md">
        <div class="modal-content">
            <form action="javascript:void(0);" id="ProsesHapusJenisSimpanan">
                <div class="modal-header">
                    <h5 class="modal-title text-dark"><i class="bi bi-trash"></i> Hapus Jenis Simpanan</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="row">
                        <div class="col-md-12" id="FormHapusJenisSimpanan">

                        </div>
                    </div>
                    <div class="row mb-3">
                        <div class="col-md-12 text-center" id="NotifikasiHapusJenisSimpanan">
                            <!-- Notifikasi Hapus Jenis Simpanan Muncul Disini -->
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
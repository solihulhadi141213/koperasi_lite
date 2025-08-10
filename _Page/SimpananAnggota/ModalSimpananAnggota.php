<div class="modal fade" id="ModalBayarSimpanan" tabindex="-1">
    <div class="modal-dialog modal-md">
        <div class="modal-content">
            <form action="javascript:void(0);" id="ProsesBayarSimpanan">
                <div class="modal-header">
                    <h5 class="modal-title text-dark"><i class="bi bi-coin"></i> Pembayaran Simpanan</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="row">
                        <div class="col-md-12" id="FormBayarSimpanan">

                        </div>
                    </div>
                    <div class="row mb-3">
                        <div class="col-md-12 mb-3" id="PetunjukBayarSimpanan">
                            <!-- Petunjuk Muncul Disini -->
                        </div>
                    </div>
                    <div class="row mb-3">
                        <div class="col-md-12 mb-3" id="NotifikasiBayarSimpanan">
                            <!-- Notifikasi Muncul Disini -->
                        </div>
                    </div>
                    <div class="row mb-3">
                        <div class="col-md-12 mb-3">
                            <button type="submit" class="btn btn-lg btn-primary btn-rounded btn-block">
                                <i class="bi bi-chevron-right"></i> Bayar Sekarang
                            </button>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>

<div class="modal fade" id="ModalBayarSimpananWajib" tabindex="-1">
    <div class="modal-dialog modal-md">
        <div class="modal-content">
            <form action="javascript:void(0);" id="ProsesBayarSimpananWajib">
                <div class="modal-header">
                    <h5 class="modal-title text-dark"><i class="bi bi-coin"></i> Pembayaran Simpanan</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="row">
                        <div class="col-md-12" id="FormBayarSimpananWajib">

                        </div>
                    </div>
                    <div class="row mb-3">
                        <div class="col-md-12 mb-3" id="NotifikasiBayarSimpananWajib">
                            <!-- Notifikasi Muncul Disini -->
                        </div>
                    </div>
                    <div class="row mb-3">
                        <div class="col-md-12 mb-3">
                            <button type="submit" class="btn btn-lg btn-primary btn-rounded btn-block">
                                <i class="bi bi-chevron-right"></i> Bayar Sekarang
                            </button>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>

<div class="modal fade" id="ModalPembatalan" tabindex="-1">
    <div class="modal-dialog modal-md">
        <div class="modal-content">
            <form action="javascript:void(0);" id="ProsesPembatalan">
                <input type="hidden" name="uuid_simpanan" id="put_uuid_simpanan">
                <div class="modal-header">
                    <h5 class="modal-title text-dark"><i class="bi bi-repeat"></i> Pembatalan Pembayaran</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="row mb-2">
                        <div class="col-md-12 text-center" id="FormPembatalan">
                            <img src="assets/img/question.gif" width="70%">
                        </div>
                    </div>
                    <div class="row mb-2">
                        <div class="col-md-12 text-center" id="FormPembatalan">
                            Apakah anda yakin akan membatalkan pembayaran ini?
                        </div>
                    </div>
                    <div class="row mb-3">
                        <div class="col-md-12 mb-3" id="NotifikasiPembatalan">
                            <!-- Notifikasi Muncul Disini -->
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="submit" class="btn btn-success btn-rounded">
                        <i class="bi bi-check"></i> Batalkan
                    </button>
                    <button type="button" class="btn btn-dark btn-rounded" data-bs-dismiss="modal">
                        <i class="bi bi-x-circle"></i> Tutup
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

<div class="modal fade" id="ModalFilterSimpananSukarela" tabindex="-1">
    <div class="modal-dialog modal-md">
        <div class="modal-content">
            <form action="javascript:void(0);" id="FilterSimpananSukarela">
                <input type="hidden" name="page" id="put_page_simpanan_sukarela" value="1">
                <div class="modal-header">
                    <h5 class="modal-title text-dark"><i class="bi bi-filter"></i> Filter Simpanan Sukarela</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    
                </div>
                <div class="modal-footer">
                    <button type="submit" class="btn btn-success btn-rounded">
                        <i class="bi bi-check"></i> Tampilkan
                    </button>
                    <button type="button" class="btn btn-dark btn-rounded" data-bs-dismiss="modal">
                        <i class="bi bi-x-circle"></i> Tutup
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

<div class="modal fade" id="ModalTambahSimpananSukarela" tabindex="-1">
    <div class="modal-dialog modal-md">
        <div class="modal-content">
            <form action="javascript:void(0);" id="ProsesTambahSimpananSukarela">
                <div class="modal-header">
                    <h5 class="modal-title text-dark"><i class="bi bi-coin"></i> Tambah Simpanan Sukarela</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="row mb-2">
                        <div class="col-12 mt-3">
                            <small>
                                <b>Pilih Simpanan</b>
                            </small>
                            <select class="form-control" name="id_simpanan_jenis" id="id_simpanan_jenis_sukarela">
                                <option value="">Pilih</option>
                                <?php
                                     $query = mysqli_query($Conn, "SELECT*FROM simpanan_jenis WHERE kategori='Simpanan Sukarela'");
                                    while ($data = mysqli_fetch_array($query)) {
                                        $id_simpanan_jenis= $data['id_simpanan_jenis'];
                                        $nama_simpanan= $data['nama_simpanan'];
                                        echo '<option value="'.$id_simpanan_jenis.'">'.$nama_simpanan.'</option>';
                                    }
                                ?>
                            </select>
                        </div>
                    </div>
                    <div class="row mb-2">
                        <div class="col-12 mt-3" id="form_nominal_simpanan_sukarela">
                            <small>
                                <b>Nominal Simpanan</b>
                            </small>
                            <input type="text" name="nominal_simpanan_sukarela" id="nominal_simpanan_sukarela" class="form-control">
                        </div>
                    </div>
                    <div class="row mb-2">
                        <div class="col-12 mt-3">
                            <small>
                                <b>Pilih Metode Pembayaran</b>
                            </small>
                            <select class="form-control" name="metode_pembayaran">
                                <option value="">Pilih</option>
                                <option value="BRI-Virtual Account">BRI-Virtual Account</option>
                                <option value="BNI-Virtual Account">BNI-Virtual Account</option>
                                <option value="Mandiri-Virtual Account">Mandiri-Virtual Account</option>
                                <option value="BCA-Virtual Account">BCA-Virtual Account</option>
                                <option value="Retail-Indomart/Alfamart">Retail-Indomart/Alfamart</option>
                            </select>
                        </div>
                    </div>
                    <div class="row mb-3">
                        <div class="col-md-12 mb-3" id="NotifikasiTambahSimpananSukarela">
                            <!-- Notifikasi Muncul Disini -->
                        </div>
                    </div>
                    <div class="row mb-3">
                        <div class="col-md-12 mb-3">
                            <button type="submit" class="btn btn-lg btn-primary btn-rounded btn-block">
                                <i class="bi bi-chevron-right"></i> Bayar Sekarang
                            </button>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>
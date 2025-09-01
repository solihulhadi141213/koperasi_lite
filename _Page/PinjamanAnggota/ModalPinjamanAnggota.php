<div class="modal fade" id="ModalPilihPinjaman" tabindex="-1">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title text-dark">
                    <i class="bi bi-check"></i> Pilih Pinjaman
                </h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div class="row mb-3">
                    <div class="col-md-12">
                        <div class="table table-responsive">
                            <table class="table table-hover">
                                <thead>
                                    <tr>
                                        <th><b>No</b></th>
                                        <th><b>Pinjaman</b></th>
                                        <th class="text-end"><b>Opsi</b></th>
                                    </tr>     
                                </thead>
                                <tbody id="TabelJenisPinjaman">
                                    
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
<div class="modal fade" id="ModalTambahPinjaman" tabindex="-1">
    <div class="modal-dialog modal-md">
        <div class="modal-content">
            <form action="javascript:void(0);" id="ProsesTambahPinjaman">
                <input type="hidden" name="id_pinjaman_jenis" id="put_id_pinjaman_jenis" >
                <div class="modal-header">
                    <h5 class="modal-title text-dark">
                        <i class="bi bi-send"></i> Kirim Pengajuan Pinjaman
                    </h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body" >
                    <div class="row mb-3">
                        <div class="col-md-12" id="FormTambahPinjaman">
                            <!-- Uraian Jenis Pinjaman Akan Muncul Disini -->
                        </div>
                    </div>
                    <div class="row mb-3">
                        <div class="col-12">
                            <small>Nominal Pinjaman</small>
                            <input type="text" id="jumlah_pinjaman" name="jumlah_pinjaman" class="form-control form-money" placeholder="Rp">
                            <small>
                                <code class="text-dark">Minimal pinjaman Rp 500.000</code>
                            </small>
                        </div>
                    </div>
                    <div class="row mb-3">
                        <div class="col-12" id="NotifikasiTambahPinjaman">
                            <!-- Notifikasi Validasi Nominal Pinjaman AKan Muncul Disini -->
                        </div>
                    </div>
                    <div class="row mt-3">
                        <div class="col-6 mt-3">
                            <button type="button" class="btn btn-dark btn-rounded btn-block" data-bs-toggle="modal" data-bs-target="#ModalPilihPinjaman">
                                <i class="bi bi-chevron-left"></i> Sebelumnya
                            </button>
                        </div>
                        <div class="col-6 mt-3">
                            <button type="submit" class="btn btn-success btn-rounded btn-block">
                                Selanjutnya <i class="bi bi-chevron-right"></i>
                            </button>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>
<div class="modal fade" id="ModalKirimPengajuanPinjaman" tabindex="-1">
    <div class="modal-dialog modal-md">
        <div class="modal-content">
            <form action="javascript:void(0);" id="ProsesKirimPengajuanPinjaman">
                <div class="modal-header">
                    <h5 class="modal-title text-dark">
                        <i class="bi bi-send"></i> Kirim Pengajuan Pinjaman
                    </h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body" >
                    <div class="row mb-3">
                        <div class="col-md-12" id="FormKirimPengajuanPinjaman">
                            <!-- Uraian Jenis Pinjaman Akan Muncul Disini -->
                        </div>
                    </div>
                    <div class="row mb-3">
                        <div class="col-md-12" id="NotifikasiirimPengajuanPinjaman">
                            <!-- Uraian Jenis Pinjaman Akan Muncul Disini -->
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>

<div class="modal fade" id="ModalDetailPinjaman" tabindex="-1">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title text-dark">
                    <i class="bi bi-info-circle"></i> Detail Pinjaman
                </h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div class="row mb-3">
                    <div class="col-md-12" id="FormDetailPinjaman">
                        <!-- Form Detail Pinjaman -->
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <a href="index.php?Page=AngsuranAnggota" class="btn btn-info btn-rounded">
                    <i class="bi bi-three-dots"></i> Lihat Angsuran
                </a>
                <button type="button" class="btn btn-dark btn-rounded" data-bs-dismiss="modal">
                    <i class="bi bi-x-circle"></i> Tutup
                </button>
            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="ModalPembatalanPengajuan" tabindex="-1">
    <div class="modal-dialog modal-md">
        <div class="modal-content">
            <form action="javascript:void(0);" id="ProsesPembatalanPengajuan">
                <div class="modal-header">
                    <h5 class="modal-title text-dark">
                        <i class="bi bi-info-circle"></i> Pembatalan Pengajuan Pinjaman
                    </h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="row">
                        <div class="col-md-12" id="FormPembatalanPengajuan">
                            <!-- Form Pembatalan Pinjaman -->
                        </div>
                    </div>
                    <div class="row mb-2">
                        <div class="col-md-12 mb-2" id="NotifikasiPembatalanPengajuan">
                            <!-- Notifikasi Pembatalan Pinjaman -->
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="submit" class="btn btn-success btn-rounded">
                        <i class="bi bi-check"></i> Ya, Batalkan
                    </button>
                    <button type="button" class="btn btn-dark btn-rounded" data-bs-dismiss="modal">
                        <i class="bi bi-x-circle"></i> Tutup
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
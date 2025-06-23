<div class="modal fade" id="ModalFilter" tabindex="-1">
    <div class="modal-dialog modal-md">
        <div class="modal-content">
            <form action="javascript:void(0);" method="POST" id="ProsesFilterGrafik">
                <div class="modal-header">
                    <h5 class="modal-title text-dark">
                        <i class="bi bi-funnel"></i> Mode Data
                    </h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="row mb-3" id="FormTahun">
                        <div class="col col-md-4"><label for="tahun">Tahun Data</label></div>
                        <div class="col col-md-8">
                            <select name="tahun" id="get_tahun"  class="form-control">
                                <?php
                                    // Tentukan tahun awal dan akhir
                                    $tahunAwal = 2010;
                                    $TahunSekarang=date('Y');
                                    for ($tahun_list = $tahunAwal; $tahun_list <= $TahunSekarang; $tahun_list++) {
                                        if($tahun_list==$tahun){
                                            echo '<option selected value="'.$tahun_list.'">'.$tahun_list.'</option>';
                                        }else{
                                            echo '<option value="'.$tahun_list.'">'.$tahun_list.'</option>';
                                        }
                                    }
                                ?>
                            </select>
                            <small class="credit">
                                <code class="text text-grayish">Periode Tahun Yang Ditampilkan</code>
                            </small>
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
<div class="modal fade" id="ModalCetak" tabindex="-1">
    <div class="modal-dialog modal-md">
        <div class="modal-content">
            <form action="javascript:void(0);" id="ProsesCetak">
                <div class="modal-header">
                    <h5 class="modal-title text-dark">
                        <i class="bi bi-download"></i> Cetak Rekap Jual Beli
                    </h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="row mb-3">
                        <div class="col col-md-4"><label for="put_tahun_cetak">Tahun Data</label></div>
                        <div class="col col-md-8">
                            <input type="text" readonly name="tahun" id="put_tahun_cetak" class="form-control" value="">
                        </div>
                    </div>
                    <div class="row mb-3">
                        <div class="col col-md-4"><label for="file_type">Type File</label></div>
                        <div class="col col-md-8">
                            <select name="file_type" id="file_type" class="form-control">
                                <option value="PDF">PDF</option>
                                <option value="Excel">Excel</option>
                            </select>
                        </div>
                    </div>
                    <div class="row mb-3">
                        <div class="col-md-12">
                            <div class="alert alert-warning">
                                <small>Pastikan periode tahun yang anda pilih sudah sesuai. Type file menentukan data keluaran yang akan dibuat.</small>
                            </div>
                        </div>
                    </div>
                    <div class="row mb-3">
                        <div class="col-md-12" id="NotifikasiCetak">
                            <!-- Notifikasi Prosses Cetak Akan Tampil Disini -->
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
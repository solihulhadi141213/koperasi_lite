<div class="pagetitle">
    <h1>
        <a href="">
            <i class="bi bi-cash-coin"></i> Penarikan Simpanan</a>
        </a>
    </h1>
    <nav>
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="index.php">Dashboard</a></li>
            <li class="breadcrumb-item active"> Penarikan Simpanan</li>
        </ol>
    </nav>
</div>
<section class="section dashboard">
    <div class="row">
        <div class="col-md-12" id="NotifikasiPengajuanPenarikan">
            <!-- Notifikasi Pengajuan Penarikan Dana Simpanan Akan Ditampilkan Disini -->
        </div>
    </div>
    <div class="row">
        <div class="col-lg-12">
            <div class="card">
                <div class="card-header">
                    <div class="row">
                        <div class="col-12 text-end">
                            <button type="button" class="btn btn-md btn-primary btn-floating" data-bs-toggle="modal" data-bs-target="#ModalFilter">
                                <i class="bi bi-funnel"></i>
                            </button>
                        </div>
                    </div>
                </div>
                <div class="card-body">
                    <div class="table table-responsive">
                        <table class="table table-hover table-striped">
                            <thead>
                                <tr>
                                    <th><b>No</b></th>
                                    <th><b>Anggota</b></th>
                                    <th><b>NIK</b></th>
                                    <th><b>Tanggal</b></th>
                                    <th><b>Sumber</b></th>
                                    <th><b>Nominal</b></th>
                                    <th><b>Status</b></th>
                                    <th><b>Opsi</b></th>
                                </tr>
                            </thead>
                            <tbody id="TabelPenarikan">
                                <tr>
                                    <td colspan="8" class="text-center">
                                        <small class="text-danger">Data Penarikan Dana Simpanan Tidak Ditemukan</small>
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
                <div class="card-footer">
                    <div class="row">
                        <div class="col-6">
                            <small id="page_info">
                                Page 1 Of 100
                            </small>
                        </div>
                        <div class="col-6 text-end">
                            <button type="button" class="btn btn-sm btn-outline-info btn-floating" id="prev_button">
                                <i class="bi bi-chevron-left"></i>
                            </button>
                            <button type="button" class="btn btn-sm btn-outline-info btn-floating" id="next_button">
                                <i class="bi bi-chevron-right"></i>
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
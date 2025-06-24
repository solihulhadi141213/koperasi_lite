<div class="pagetitle">
    <h1>
        <a href="">
            <i class="bi bi-file-pdf"></i> Laporan</a>
        </a>
    </h1>
    <nav>
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="index.php">Dashboard</a></li>
            <li class="breadcrumb-item active">Laporan Pinjaman</li>
        </ol>
    </nav>
</div>
<section class="section dashboard">
    <div class="row">
        <div class="col-lg-12 mb-4">
            <div class="card">
                <div class="card-header">
                    <form action="javascript:void(0);" id="ProsesLaporanPinjaman">
                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <b class="card-title">
                                    <i class="bi bi-tag"></i> Laporan Pinjaman
                                </b>
                            </div>
                            <div class="col-md-2 mb-3">
                                <input type="date" class="form-control" name="periode_1">
                                <small class="text-muted">Periode Awal</small>
                            </div>
                            <div class="col-md-2 mb-3">
                                <input type="date" class="form-control" name="periode_2">
                                <small class="text-muted">Periode Akhir</small>
                            </div>
                            <div class="col-md-1 mb-3">
                                <button type="submit" class="btn btn-md btn-primary btn-block">
                                    <i class="bi bi-arrow-down"></i> View
                                </button>
                            </div>
                            <div class="col-md-1 mb-3">
                                <button type="button" class="btn btn-md btn-secondary btn-block" id="CetakLaporanPinjaman">
                                    <i class="bi bi-file-pdf"></i> Cetak
                                </button>
                            </div>
                        </div>
                    </form>
                </div>
                <div class="card-body">
                    <div class="table table-responsive mb-3">
                        <table class="table table-striped table-hover">
                            <thead>
                                <tr>
                                    <td align="center"><b>No</b></td>
                                     <td align="left"><b>Tanggal</b></td>
                                    <td align="left"><b>Nama Anggota</b></td>
                                    <td align="left"><b>No.Induk</b></td>
                                    <td align="left"><b>Jumlah Pinjaman</b></td>
                                    <td align="left"><b>Angsuran Masuk</b></td>
                                    <td align="center"><b>Status</b></td>
                                </tr>
                            </thead>
                            <tbody id="TabelLaporanPinjaman">
                                <tr>
                                    <td colspan="7" class="text-center">
                                        <small class="text-danger">
                                            Belum Ada Data Laporan Yang Dapat Ditampilkan
                                        </small>
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
                <div class="card-footer">
                    <small>
                        Periode : <span class="text-muted" id="periode_data_laporan_pinjaman">Belum Diatur</span>
                    </small>
                </div>
            </div>
        </div>
    </div>
</section>

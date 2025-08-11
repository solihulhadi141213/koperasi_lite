<div class="pagetitle">
    <h1>
        <a href="">
            <i class="bi bi-send-arrow-down"></i> Pinjaman Anggota</a>
        </a>
    </h1>
    <nav>
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="index.php">Dashboard</a></li>
            <li class="breadcrumb-item active"> Pinjaman Anggota</li>
        </ol>
    </nav>
</div>
<div class="row">
    <div class="col-md-12">
        <div class="alert alert-warning alert-dismissible fade show" role="alert">
            <small>
                Berikut ini adalah halaman pengajuan pinjaman anggota. 
                Anda bisa mengajukan pinjaman dana sesuai platform pinjaman yang tersedia.
                Pengurus akan melakukan verifikasi pengajuan anda dan melakukan peninjauan kelayakan pinjaman.
            </small>
        </div>
    </div>
</div>
<section class="section dashboard">
    <div class="card">
        <div class="card-header">
            <div class="row">
                <div class="col-8">
                    <b>Daftar Pengajuan Pinjaman</b>
                </div>
                <div class="col-4 text-end">
                    <button type="button" class="btn btn-md btn-floating btn-primary" data-bs-toggle="modal" data-bs-target="#ModalPilihPinjaman">
                        <i class="bi bi-plus"></i>
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
                            <th><b>Nama Pinjaman</b></th>
                            <th><b>Tanggal</b></th>
                            <th><b>Jumlah</b></th>
                            <th><b>Status</b></th>
                            <th><b>Opsi</b></th>
                        </tr>
                    </thead>
                    <tbody id="TabelPinjamanAnggota">
                        <tr>
                            <td colspan="6" class="text-center">
                                <small class="text-danger">Belum Ada Data Pinjaman Yang Ditampilkan</small>
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</section>
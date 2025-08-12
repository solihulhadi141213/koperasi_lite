<div class="pagetitle">
    <h1>
        <a href="">
            <i class="bi bi-bank"></i> Pinjaman</a>
        </a>
    </h1>
    <nav>
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="index.php">Dashboard</a></li>
            <li class="breadcrumb-item active"> Pinjaman</li>
        </ol>
    </nav>
</div>
<section class="section dashboard">
    <div class="row">
        <div class="col-md-12">
            <div class="alert alert-warning alert-dismissible fade show" role="alert">
                <small>
                    Berikut ini adalah data pengajuan pinjaman anggota. Silahkan lakukan verifikasi pengajuan pinjaman tersebut
                </small>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-lg-12">
            <div class="card">
                <div class="card-header">
                    <form action="javascript:void(0);" id="ProsesBatas">
                        <div class="row">
                            <div class="col-12 col-md-12 mb-3 text-end">
                                <button type="button" class="btn btn-md btn-secondary btn-floating" data-bs-toggle="modal" data-bs-target="#ModalFilter" title="Filter/Pencarian">
                                    <i class="bi bi-search"></i>
                                </button>
                                <!-- <button type="button" class="btn btn-md btn-primary btn-floating" data-bs-toggle="modal" data-bs-target="#ModalPilihAnggota" title="Tambah Data Pinjaman Baru">
                                    <i class="bi bi-plus-lg"></i>
                                </button> -->
                            </div>
                        </div>
                    </form>
                </div>
                <div class="card-body" id="MenampilkanTabelPinjaman">
                    <!-- Menampilkan Tabel Pinjaman -->
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
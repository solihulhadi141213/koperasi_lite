<div class="pagetitle">
    <h1>
        <a href="">
            <i class="bi bi-box"></i> Stock Opename</a>
        </a>
    </h1>
    <nav>
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="index.php">Dashboard</a></li>
            <li class="breadcrumb-item active"> Stock Opename</li>
        </ol>
    </nav>
</div>
<section class="section dashboard">
    <div class="row">
        <div class="col-md-12">
            <?php
                echo '<div class="alert alert-warning alert-dismissible fade show" role="alert">';
                echo '  <small>';
                echo '      Berikut ini adalah halaman stock opename.';
                echo '      Anda bisa mengelola perubahan stock barang dengan melakukan pemeriksaan stok secara rutin.';
                echo '      Ketika anda menambahkan record stock opename maka sistem akan melakukan update pada data stock barang.';
                echo '      <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>';
                echo '  </small>';
                echo '</div>';
            ?>
        </div>
    </div>
    <div class="row">
        <div class="col-lg-12">
            <div class="card">
                <div class="card-header">
                    <div class="row">
                        <div class="col-12 col-md-8"></div>
                        <div class="col-6 col-md-2 mb-2">
                            <button class="btn btn-md btn-outline-dark btn-rounded btn-block" type="button" data-bs-toggle="modal" data-bs-target="#ModalFilterSesi">
                                <i class="bi bi-funnel"></i> Filter
                            </button>
                        </div>
                        <div class="col-6 col-md-2 mb-2">
                            <button type="button" class="btn btn-md btn-primary btn-block btn-rounded" data-bs-toggle="modal" data-bs-target="#ModalTambahSesi" title="Tambah Sesi Stock Opename">
                                <i class="bi bi-plus"></i> Tambah Sesi
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
                                    <th><b>Tanggal</b></th>
                                    <th><b>Jumlah Item</b></th>
                                    <th><b>Rp Selisih (+)</b></th>
                                    <th><b>Rp Selisih (-)</b></th>
                                    <th><b>Status</b></th>
                                    <th><b>Opsi</b></th>
                                </tr>
                            </thead>
                            <tbody id="TabelSesi">
                                <tr>
                                    <td colspan="7" class="text-center text-danger">Tidak Ada Data Yang Ditampilkan</td>
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
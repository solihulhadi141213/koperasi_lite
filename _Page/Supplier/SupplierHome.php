<div class="pagetitle">
    <h1>
        <a href="">
            <i class="bi bi-truck"></i> Supplier</a>
        </a>
    </h1>
    <nav>
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="index.php">Dashboard</a></li>
            <li class="breadcrumb-item active">Supplier</li>
        </ol>
    </nav>
</div>
<section class="section dashboard">
    <div class="row">
        <div class="col-md-12">
            <?php
                echo '<div class="alert alert-warning alert-dismissible fade show" role="alert">';
                echo '  <small>';
                echo '      Berikut ini adalah halaman pengelolaan data supplier. Catat informasi supplier langganan anda disini.';
                echo '      Anda juga bisa melihat riwayat transaksi masing-masing supplier, item barang yang pernah dibeli dari supplier bersangkutan dan rekapitulasi jumlah pembelanjaan yang pernah dilakukan.';
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
                        <div class="col-md-8"></div>
                        <div class="col-6 col-md-2 mb-2">
                            <a class="btn btn-md btn-outline-dark btn-rounded btn-block" href="javascript:void(0);" data-bs-toggle="dropdown" aria-expanded="false">
                                <i class="bi bi-three-dots"></i> Opsi Lanjutan
                            </a>
                            <ul class="dropdown-menu dropdown-menu-end dropdown-menu-arrow" style="">
                                <li class="dropdown-header text-start">
                                    <h6>Option</h6>
                                </li>
                                <li>
                                    <a class="dropdown-item" href="javascript:void(0)" data-bs-toggle="modal" data-bs-target="#ModalFilter">
                                        <i class="bi bi-funnel"></i> Filter
                                    </a>
                                </li>
                                <li>
                                    <a class="dropdown-item" href="javascript:void(0)" data-bs-toggle="modal" data-bs-target="#ModalExportSupplier">
                                        <i class="bi bi-download"></i> Export
                                    </a>
                                </li>
                                <li>
                                    <a class="dropdown-item" href="javascript:void(0)" data-bs-toggle="modal" data-bs-target="#ModalImportSupplier">
                                        <i class="bi bi-upload"></i> Import
                                    </a>
                                </li>
                            </ul>
                        </div>
                        <div class="col-6 col-md-2 mb-2">
                            <button type="button" class="btn btn-md btn-primary btn-block btn-rounded" data-bs-toggle="modal" data-bs-target="#ModalTambahSupplier">
                                <i class="bi bi-plus-lg"></i> Tambah
                            </button>
                        </div>
                    </div>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-12">
                            <div class="table table-responsive">
                                <table class="table table-hover table-striped">
                                    <thead>
                                        <tr>
                                            <th><b>No</b></th>
                                            <th><b>Supplier</b></th>
                                            <th><b>Email</b></th>
                                            <th><b>Kontak</b></th>
                                            <th><b>Volume</b></th>
                                            <th><b>Opsi</b></th>
                                        </tr>
                                    </thead>
                                    <tbody id="TabelSupplier">
                                        <tr>
                                            <td colspan="6" class="text-center text-danger"></td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                        </div>
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
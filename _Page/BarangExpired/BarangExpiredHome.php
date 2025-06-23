<?php
    if(!empty($_GET['short_expired'])){
        $short_expired=$_GET['short_expired'];
    }else{
        $short_expired="";
    }
?>
<div class="pagetitle">
    <h1>
        <a href="">
            <i class="bi bi-calendar"></i> Batch & Expired</a>
        </a>
    </h1>
    <nav>
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="index.php">Dashboard</a></li>
            <li class="breadcrumb-item active">Batch & Expired</li>
        </ol>
    </nav>
</div>
<section class="section dashboard">
    <div class="row">
        <div class="col-md-12">
            <?php
                echo '<div class="alert alert-warning alert-dismissible fade show" role="alert">';
                echo '  <small>';
                echo '      Berikut ini adalah halaman untuk mengelola data batch dan tanggal expired barang.';
                echo '      Anda bisa menambahkan data batch berikut dengan tanggal expired.';
                echo '      Isi tanggal notifikasi agar sistem memberikan peringatan sebelum barang expired.';
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
                                    <a class="dropdown-item" href="_Page/BarangExpired/ProsesExport.php">
                                        <i class="bi bi-download"></i> Export
                                    </a>
                                </li>
                                <li>
                                    <a class="dropdown-item" href="javascript:void(0)" data-bs-toggle="modal" data-bs-target="#ModalImport">
                                        <i class="bi bi-upload"></i> Import
                                    </a>
                                </li>
                            </ul>
                        </div>
                        <div class="col-6 col-md-2 mb-2">
                            <button type="button" class="btn btn-md btn-primary btn-block btn-rounded" data-bs-toggle="modal" data-bs-target="#ModalPilihBarang" title="Tambah Data Expired Barang">
                                <i class="bi bi-plus"></i> Tambah
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
                                    <th><b>Batch</b></th>
                                    <th><b>Nama/Merek</b></th>
                                    <th><b>Expire</b></th>
                                    <th><b>Reminder</b></th>
                                    <th><b>QTY</b></th>
                                    <th><b>Status</b></th>
                                    <th><b>Opsi</b></th>
                                </tr>
                            </thead>
                            <tbody id="TabelBarangExpired">
                                <tr>
                                    <td colspan="8" class="text-center text-danger">Tidak Ada Data Yang Ditampilkan</td>
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
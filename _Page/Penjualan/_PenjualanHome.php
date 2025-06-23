<?php
    //Cek Aksesibilitas ke halaman ini
    $IjinAksesSaya=IjinAksesSaya($Conn,$SessionIdAkses,'AQKs9kSv0Bph4ycGNUj');
    if($IjinAksesSaya!=="Ada"){
        include "_Page/Error/NoAccess.php";
    }else{
?>
    <div class="pagetitle">
        <h1>
            <a href="">
                <i class="bi bi-cart-plus"></i> Transaksi Penjualan</a>
            </a>
        </h1>
        <nav>
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="index.php">Dashboard</a></li>
                <li class="breadcrumb-item active">Penjualan</li>
            </ol>
        </nav>
    </div>
    <section class="section dashboard">
        <div class="row">
            <div class="col-md-12">
                <?php
                    echo '
                        <div class="alert alert-warning alert-dismissible fade show" role="alert">
                            <small>
                                Berikut ini adalah halaman untuk mengelola transaksi penjualan. Setiap aktivitas penjualan dicatat pada halaman ini. 
                                Untuk penjualan terhadap anggota harus dicatat informasi anggotanya sehingga data penjualan terhubung dengan riwayat belanja anggota.
                                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                            </small>
                        </div>
                    ';
                ?>
            </div>
        </div>
        <div class="row">
            <div class="col-lg-12">
                <div class="card">
                    <div class="card-header">
                        <div class="row">
                            <div class="col-md-8 mb-2">
                                <b class="card-title"> 
                                    <i class="bi bi-table"></i> Transaksi Penjualan
                                </b>
                            </div>
                            <div class="col-6 col-sm-6 col-md-2 mb-2">
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
                                        <a class="dropdown-item" href="javascript:void(0)" data-bs-toggle="modal" data-bs-target="#ModalExportTransaksi">
                                            <i class="bi bi-cloud-arrow-down"></i> Export
                                        </a>
                                    </li>
                                </ul>
                            </div>
                            <div class="col-6 col-sm-6 col-md-2 mb-2">
                                <button type="button" class="btn btn-md btn-primary btn-block btn-rounded" data-bs-toggle="modal" data-bs-target="#ModalTambahTransaksiPenjualan" title="Tambah Transaksi Penjualan">
                                    <i class="bi bi-plus-lg"></i> Tambah
                                </button>
                            </div>
                        </div>
                    </div>
                    <div class="card-body">
                        <div class="tabel table-responsive">
                            <table class="table table-hover table-striped">
                                <thead>
                                    <tr>
                                        <th><b>No</b></th>
                                        <th><b>Tanggal</b></th>
                                        <th>
                                            <b>Kategori</b> 
                                            <a href="javascript:void(0);" 
                                                data-bs-toggle="tooltip" 
                                                data-bs-placement="top" 
                                                data-bs-custom-class="custom-tooltip" 
                                                data-bs-title="Transaksi Penjualan / Retur Penjualan"
                                            >
                                                <i class="bi bi-question-circle"></i>
                                            </a>
                                        </th>
                                        <th><b>Anggota</b></th>
                                        <th><b>Jumlah</b></th>
                                        <th>
                                            <b>Status</b> 
                                            <a href="javascript:void(0);" 
                                                data-bs-toggle="tooltip" 
                                                data-bs-placement="top" 
                                                data-bs-custom-class="custom-tooltip" 
                                                data-bs-title="Lunas, Utang, Piutang"
                                            >
                                                <i class="bi bi-question-circle"></i>
                                            </a>
                                        </th>
                                        <th><b>Jurnal</b></th>
                                        <th><b>Opsi</b></th>
                                    </tr>
                                </thead>
                                <tbody id="TabelPenjualan">
                                    <!-- Data Barang Akan Ditampilkan Disini -->
                                    <tr>
                                        <td colspan="8" class="text-center text-danger">
                                            Tidak Ada Data yang Ditampilkan
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
        <!-- Tabel Untuk Menampilkan Laba -->
        <div class="row">
            <div class="col-lg-12">
                <div class="card">
                    <div class="card-header">
                        <div class="row">
                            <div class="col-md-10 mb-2">
                                <b class="card-title"> 
                                    <i class="bi bi-table"></i> Estimasi Laba Penjualan
                                </b>
                            </div>
                            <div class="col-12 col-sm-12 col-md-2 mb-2">
                                <a class="btn btn-md btn-outline-dark btn-rounded btn-block" href="javascript:void(0);" data-bs-toggle="dropdown" aria-expanded="false">
                                    <i class="bi bi-three-dots"></i> Opsi Lanjutan
                                </a>
                                <ul class="dropdown-menu dropdown-menu-end dropdown-menu-arrow" style="">
                                    <li class="dropdown-header text-start">
                                        <h6>Option</h6>
                                    </li>
                                    <li>
                                        <a class="dropdown-item" href="javascript:void(0)" data-bs-toggle="modal" data-bs-target="#ModalFilterLaba">
                                            <i class="bi bi-funnel"></i> Filter
                                        </a>
                                    </li>
                                    <li>
                                        <a class="dropdown-item" href="javascript:void(0)" data-bs-toggle="modal" data-bs-target="#ModalExportLaba">
                                            <i class="bi bi-cloud-arrow-down"></i> Export
                                        </a>
                                    </li>
                                </ul>
                            </div>
                        </div>
                    </div>
                    <div class="card-body">
                        <div class="tabel table-responsive">
                            <table class="table table-hover table-striped">
                                <thead>
                                    <tr>
                                        <th><b>No</b></th>
                                        <th><b>Tgl</b></th>
                                        <th><b>Kategori</b></th>
                                        <th><b>Uraian</b></th>
                                        <th><b>H.Beli</b></th>
                                        <th><b>H.Jual</b></th>
                                        <th><b>QTY</b></th>
                                        <th><b>PPN</b></th>
                                        <th><b>DSC</b></th>
                                        <th><b>Subtotal</b></th>
                                        <th><b>HPP</b></th>
                                        <th><b>Margin</b></th>
                                    </tr>
                                </thead>
                                <tbody id="TabelLabaPenjualan">
                                    <!-- Data Barang Akan Ditampilkan Disini -->
                                    <tr>
                                        <td colspan="12" class="text-center text-danger">
                                            Tidak Ada Data yang Ditampilkan
                                        </td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                    <div class="card-footer">
                        <div class="row">
                            <div class="col-6">
                                <small id="page_info_laba">
                                    Page 1 Of 100
                                </small>
                            </div>
                            <div class="col-6 text-end">
                                <button type="button" class="btn btn-sm btn-outline-info btn-floating" id="prev_button_laba">
                                    <i class="bi bi-chevron-left"></i>
                                </button>
                                <button type="button" class="btn btn-sm btn-outline-info btn-floating" id="next_button_laba">
                                    <i class="bi bi-chevron-right"></i>
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
<?php } ?>
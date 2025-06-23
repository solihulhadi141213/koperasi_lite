<?php
    //Cek Aksesibilitas ke halaman ini
    $IjinAksesSaya=IjinAksesSaya($Conn,$SessionIdAkses,'sPkDxRYJPn1A8K24ki2');
    if($IjinAksesSaya!=="Ada"){
        include "_Page/Error/NoAccess.php";
    }else{
?>
    <div class="pagetitle">
        <h1>
            <a href="">
                <i class="bi bi-box"></i> Barang</a>
            </a>
        </h1>
        <nav>
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="index.php">Dashboard</a></li>
                <li class="breadcrumb-item active">Barang</li>
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
                                Berikut ini adalah halaman kelola data barang. Anda bisa menambahkan data barang baru, kelola stok, 
                                kelola informasi satuan, multi harga dan multi stok. Anda juga bisa memanfaatkan fitur database untuk 
                                melakukan import data dari excel. 
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
                            <div class="col-8">
                                <b class="card-title"># Daftar Barang</b>
                            </div>
                            <div class="col-4 text-end">
                                <button 
                                type="button" 
                                class="btn btn-md btn-outline-secondary btn-floating modal_scan_barang" 
                                data-bs-toggle="tooltip" 
                                data-bs-placement="top" 
                                data-bs-custom-class="custom-tooltip" 
                                data-bs-title="Scan Kode Barang">
                                    <i class="bi bi-qr-code-scan"></i>
                                </button>
                                <a class="btn btn-md btn-outline-dark btn-floating" href="javascript:void(0);" data-bs-toggle="dropdown" aria-expanded="false" title="Opsi Lanjutan">
                                    <i class="bi bi-three-dots"></i>
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
                                        <a class="dropdown-item" href="javascript:void(0)" data-bs-toggle="modal" data-bs-target="#ModalExportBarang">
                                            <i class="bi bi-download"></i> Export
                                        </a>
                                    </li>
                                    <li>
                                        <a class="dropdown-item" href="javascript:void(0)" data-bs-toggle="modal" data-bs-target="#ModalImportBarang">
                                            <i class="bi bi-upload"></i> Import
                                        </a>
                                    </li>
                                    <li>
                                        <a class="dropdown-item" href="javascript:void(0)" data-bs-toggle="modal" data-bs-target="#ModalKategoriHarga">
                                            <i class="bi bi-cash-coin"></i> Multi Harga
                                        </a>
                                    </li>
                                </ul>
                                <button type="button" class="btn btn-md btn-primary btn-floating" data-bs-toggle="modal" data-bs-target="#ModalTambahBarang" title="Tambah Data Barang">
                                    <i class="bi bi-plus-lg"></i>
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
                                        <th><b>Kode</b></th>
                                        <th><b>Barang</b></th>
                                        <th><b>Kategori</b></th>
                                        <th><b>QTY</b></th>
                                        <th><b>Harga Beli</b></th>
                                        <th><b>Opsi</b></th>
                                    </tr>
                                </thead>
                                <tbody id="TabelBarang">
                                    <tr>
                                        <td colspan="7" class="text-center text-danger">
                                            Tidak Ada Data yang Ditampilkan
                                        </td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                        <!-- Data Barang Akan Ditampilkan Disini -->
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
<?php } ?>
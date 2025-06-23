<div class="pagetitle">
    <h1>
        <a href="">
            <i class="bi bi-box"></i> Stock Opename</a>
        </a>
    </h1>
    <nav>
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="index.php">Dashboard</a></li>
            <li class="breadcrumb-item"><a href="index.php?Page=StockOpename">Stock Opename</a></li>
            <li class="breadcrumb-item active"> Detail Stock Opename</li>
        </ol>
    </nav>
</div>
<section class="section dashboard">
    <div class="row">
        <div class="col-md-12">
            <?php
                echo '<div class="alert alert-warning alert-dismissible fade show" role="alert">';
                echo '  <small>';
                echo '      Berikut ini adalah halaman detail stock opename.';
                echo '      Pada halaman ini anda bisa menambahkan informasi hasil pemeriksaan stock barang dan menghitung selisih yang mungkin terjadi.';
                echo '      <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>';
                echo '  </small>';
                echo '</div>';
            ?>
        </div>
    </div>
    <div class="row">
        <div class="col-lg-12">
            <?php
                if(empty($_GET['id'])){
                    echo '<div class="alert alert-danger alert-dismissible fade show" role="alert">';
                    echo '  <small>';
                    echo '      ID Sesi Tidak Boleh Kosong!';
                    echo '  </small>';
                    echo '</div>';
                }else{
                    $id_stok_opename=$_GET['id'];
                    echo '
                        <input type="hidden" id="put_id_stok_opename" value="'.$id_stok_opename.'">
                        <div class="card">
                            <div class="card-header">
                                <div class="row">
                                    <div class="col-12 mb-2 col-md-10 text-md-start text-center">
                                        <b class="card-title"><i class="bi bi-info-circle"></i> Informasi Sesi Stock Opename</b>
                                    </div>
                                    <div class="col-12 mb-2 col-md-2">
                                        <a href="index.php?Page=StockOpename" class="btn btn-dark btn-rounded w-100">
                                            <i class="bi bi-chevron-left"></i> Kembali
                                        </a>
                                    </div>
                                </div>
                            </div>
                            <div class="card-body" id="put_detail_sesi"></div>
                        </div>
                    ';
                }
            ?>
        </div>
    </div>
    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">
                    <div class="row">
                        <div class="col-12 mb-2 col-md-8 text-md-start text-center">
                            <b class="card-title"><i class="bi bi-pencil"></i> Uraian Barang</b>
                        </div>
                        <div class="col-6 mb-2 col-md-2">
                            <button type="button" class="btn btn-md btn-outline-grayish btn-block btn-rounded" data-bs-toggle="modal" data-bs-target="#ModalExportStockOpenameBarang" data-id="<?php echo $id_stok_opename; ?>">
                                <i class="bi bi-download"></i> Export
                            </button>
                        </div>
                        <div class="col-6 mb-2 col-md-2">
                            <button type="button" class="btn btn-md btn-outline-dark btn-block btn-rounded" data-bs-toggle="modal" data-bs-target="#ModalFilterBarang">
                                <i class="bi bi-funnel"></i> Filter
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
                                    <th><b>Kode</b></th>
                                    <th><b>Barang</b></th>
                                    <th><b>Harga (Rp)</b></th>
                                    <th><b>Stok Awal</b></th>
                                    <th><b>Stok Akhir</b></th>
                                    <th><b>Selisih</b></th>
                                    <th><b>Jumlah (Rp)</b></th>
                                    <th><b>Opsi</b></th>
                                </tr>
                            </thead>
                            <tbody id="TabelBarang">
                                <tr>
                                    <td colspan="9" class="text-center text-danger">Tidak Ada Data Yang Ditampilkan</td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
                <div class="card-footer">
                    <div class="row">
                        <div class="col-6">
                            <small id="page_info_barang">
                                Page 1 Of 100
                            </small>
                        </div>
                        <div class="col-6 text-end">
                            <button type="button" class="btn btn-sm btn-outline-info btn-floating" id="prev_button_barang">
                                <i class="bi bi-chevron-left"></i>
                            </button>
                            <button type="button" class="btn btn-sm btn-outline-info btn-floating" id="next_button_barang">
                                <i class="bi bi-chevron-right"></i>
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

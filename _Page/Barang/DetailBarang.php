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
                <li class="breadcrumb-item"><a href="index.php?Page=Barang">Barang</a></li>
                <li class="breadcrumb-item active">Detail Barang</li>
            </ol>
        </nav>
    </div>
    <section class="section dashboard">
        <div class="row">
            <div class="col-md-12">
                <?php
                    $id_barang="";
                    if(empty($_GET['id'])){
                        echo '
                            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                                <small>
                                    ID Barang Tidak Boleh Kosong! Tidak Ada Data Barang Dapat Ditampilkan Pada Halaman Ini.
                                </small>
                            </div>
                        ';
                    }else{
                        $id_barang=$_GET['id'];
                        echo '
                            <div class="alert alert-warning alert-dismissible fade show" role="alert">
                                <small>
                                    Berikut ini adalah halaman detail barang.
                                    Pada halaman ini dapat mengelola data batch dan expire date barang secara spesifik. 
                                    Selain itu juga terdapat riwayat transaksi barang yang menampilkan daftar riwayat penjualan dan pembelian barang sepanjang waktu.
                                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                                </small>
                            </div>
                        ';
                    }
                    echo '<input type="hidden" id="put_id_barang_in_line_page" value="'.$id_barang.'">';
                ?>
            </div>
        </div>
        
        <div class="row">
            <div class="col-lg-12">
                <div class="card">
                    <div class="card-header">
                        <div class="row">
                            <div class="col-10">
                                <b class="card-title">
                                    <i class="bi bi-info-circle"></i> Detail Barang
                                </b>
                            </div>
                            <div class="col-2 text-end">
                                <a href="index.php?Page=Barang" class="btn btn-md btn-floating btn-dark" title="Kembali Ke Data Barang">
                                    <i class="bi bi-chevron-left"></i>
                                </a>
                            </div>
                        </div>
                    </div>
                    <div class="card-body" id="DetailBarangOnPage">

                    </div>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-lg-12">
                <div class="card">
                    <div class="card-header">
                        <div class="row">
                            <div class="col-8">
                                <b class="card-title">
                                    <i class="bi bi-cart-check"></i> Riwayat Transaksi
                                </b>
                            </div>
                            <div class="col-4 text-end">
                                <button type="button" class="btn btn-floating btn-secondary" data-bs-toggle="modal" data-bs-target="#ModalExportRiwayatTransaksi" data-id="<?php echo "$id_barang"; ?>">
                                    <i class="bi bi-download"></i>
                                </button>
                                <button type="button" class="btn btn-floating btn-secondary" data-bs-toggle="modal" data-bs-target="#ModalFilterRiwayatTransaksi">
                                    <i class="bi bi-search"></i>
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
                                                <th><b>Tanggal</b></th>
                                                <th><b>Kategori</b></th>
                                                <th><b>Harga</b></th>
                                                <th><b>QTY</b></th>
                                                <th><b>Satuan</b></th>
                                                <th><b>Subtotal</b></th>
                                                <th><b>PPN</b></th>
                                                <th><b>Diskon</b></th>
                                                <th><b>Jumlah</b></th>
                                                <th><b>Status</b></th>
                                            </tr>
                                        </thead>
                                        <tbody id="TabelRiwayatTransaksi">
                                            <tr>
                                                <td class="text-center" colspan="10">
                                                    <small class="text-danger">Tidak Ada Data Transaksi Yang Ditampilkan</small>
                                                </td>
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
                                <small id="page_info_riwayat_transaksi">
                                    Page 1 Of 100
                                </small>
                            </div>
                            <div class="col-6 text-end">
                                <button type="button" class="btn btn-sm btn-outline-info btn-floating" id="prev_button_riwayat_transaksi">
                                    <i class="bi bi-chevron-left"></i>
                                </button>
                                <button type="button" class="btn btn-sm btn-outline-info btn-floating" id="next_button_riwayat_transaksi">
                                    <i class="bi bi-chevron-right"></i>
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-lg-12">
                <div class="card">
                    <div class="card-header">
                        <div class="row">
                            <div class="col-12">
                                <b class="card-title">
                                    <i class="bi bi-gift"></i> Promo Diskon
                                </b>
                            </div>
                        </div>
                    </div>
                    <div class="card-body" id="TabelDiskon">

                    </div>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-lg-12">
                <div class="card">
                    <div class="card-header">
                        <div class="row">
                            <div class="col-12">
                                <b class="card-title">
                                    <i class="bi bi-calendar-check"></i> Batch & Expired
                                </b>
                            </div>
                        </div>
                    </div>
                    <div class="card-body" id="TabelExpiredDate">

                    </div>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-lg-12">
                <div class="card">
                    <div class="card-header">
                        <div class="row">
                            <div class="col-12">
                                <b class="card-title">
                                    <i class="bi bi-box"></i> Riwayat Stock Opename
                                </b>
                            </div>
                        </div>
                    </div>
                    <div class="card-body" id="TabelStockopename">

                    </div>
                </div>
            </div>
        </div>
    </section>
<?php } ?>
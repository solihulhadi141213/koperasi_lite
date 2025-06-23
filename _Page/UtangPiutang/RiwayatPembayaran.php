<?php
    //Tangkap Kategori
    if(empty($_GET['kategori'])){
        echo "Error Kategori";
    }else{
        $kategori=validateAndSanitizeInput($_GET['kategori']);
?>
    <div class="pagetitle">
        <h1>
            <a href="">
                <i class="bi bi-arrow-left-right"></i> Utang/Piutang</a>
            </a>
        </h1>
        <nav>
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="index.php">Dashboard</a></li>
                <li class="breadcrumb-item"><a href="index.php?Page=UtangPiutang">Utang/Piutang</a></li>
                <li class="breadcrumb-item active">Riwayat Pembayaran</li>
            </ol>
        </nav>
    </div>
    <section class="section dashboard">
        <div class="row">
            <div class="col-md-12">
                <div class="alert alert-warning alert-dismissible fade show" role="alert">
                    <small>
                        Berikut ini adalah halaman untuk menampilkan data riwayat pembayaran utang/piutang. 
                    </small>
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-lg-12">
                <div class="card">
                    <div class="card-header">
                        <div class="row">
                            <div class="col-8 mb-3">
                                <b class="card-title"># Riwayat Pembayaran</b>
                            </div>
                            <div class="col-4 mb-3 text-end">
                                <a href="index.php?Page=UtangPiutang" class="btn btn-md btn-outline-dark btn-floating mr-1"  title="Kembali Ke Halaman Utama">
                                    <i class="bi bi-chevron-left"></i>
                                </a>
                                <button type="button" class="btn btn-md btn-outline-success btn-floating" title="Export Riwayat Pembayaran" data-bs-toggle="modal" data-bs-target="#ModalExportRiwayatPembayaran">
                                    <i class="bi bi-download"></i>
                                </button>
                                <button type="button" class="btn btn-md btn-secondary btn-floating" data-bs-toggle="modal" data-bs-target="#ModalFilterRiwayatPembayaran">
                                    <i class="bi bi-filter"></i>
                                </button>
                            </div>
                        </div>
                    </div>
                    <div class="card-body">
                        <div class="table table-responsive mb-3">
                            <table class="table table-striped table-hover">
                                <thead>
                                    <tr>
                                        <th><b>#</b></th>
                                        <th><b>Tgl.Transaksi</b></th>
                                        <th><b>Tgl.Bayar</b></th>
                                        <th><b>Kategori</b></th>
                                        <th><b>Anggota</b></th>
                                        <th><b>Jumlah</b></th>
                                        <th><b>Opsi</b></th>
                                    </tr>
                                </thead>
                                <tbody id="TabelRiwayatPembayaran">
                                    <tr>
                                        <td colspan="7" class="text text-center">
                                            <small class="text-danger">Tidak Ada Data Riwayat Pembayaran Yang Ditampilkan</small>
                                        </td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                    <div class="card-footer">
                        <div class="row">
                            <div class="col-6">
                                <small id="page_info_riwayat">
                                    Page 1 Of 100
                                </small>
                            </div>
                            <div class="col-6 text-end">
                                <button type="button" class="btn btn-sm btn-outline-info btn-floating" id="prev_button_riwayat">
                                    <i class="bi bi-chevron-left"></i>
                                </button>
                                <button type="button" class="btn btn-sm btn-outline-info btn-floating" id="next_button_riwayat">
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
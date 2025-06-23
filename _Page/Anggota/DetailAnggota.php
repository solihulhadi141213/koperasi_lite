<?php
    //Cek Aksesibilitas ke halaman ini
    $IjinAksesSaya=IjinAksesSaya($Conn,$SessionIdAkses,'WeXKEzh9uvvyJRCwJGX');
    if($IjinAksesSaya!=="Ada"){
        include "_Page/Error/NoAccess.php";
    }else{
        //Judul Halaman
        echo '
            <div class="pagetitle">
                <h1>
                    <a href="">
                        <i class="bi bi-people"></i> Anggota Koperasi</a>
                    </a>
                </h1>
                <nav>
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="index.php">Dashboard</a></li>
                        <li class="breadcrumb-item active">Anggota Koperasi</li>
                    </ol>
                </nav>
            </div>
        ';

        //Alert Content
        echo '
            <div class="row">
                <div class="col-md-12">
                    <div class="alert alert-warning alert-dismissible fade show" role="alert">
                        <small>
                            Berikut ini adalah halaman untuk menampilkan detail informassi anggota. Halaman ini menampilkan informasi identitas anggota, 
                            riwayat simpanan, pinjaman, angssuran dan pembelian anggota.
                            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                        </small>
                    </div>
                </div>
            </div>
        ';

        //Tangkap id_anggota
        if(empty($_GET['id'])){
            echo '
                <div class="row">
                    <div class="col-md-12">
                        <div class="alert alert-danger">
                            <small>
                                ID Anggota Tidak Boleh Kosong!
                            </small>
                        </div>
                    </div>
                </div>
            ';
        }else{
            $id_anggota=validateAndSanitizeInput($_GET['id']);
            echo '
                <div class="row mb-2">
                    <div class="col-12">
                        <div class="card">
                            <div class="card-header">
                                <div class="row">
                                    <div class="col-8">
                                        <b class="card-title"># Detail Informasi Anggota</b>
                                    </div>
                                    <div class="col-4 text-end">
                                        <button type="button" class="btn btn-md btn-outline-dark btn-floating" data-bs-toggle="dropdown" aria-expanded="false">
                                            <i class="bi bi-three-dots-vertical"></i>
                                        </button>
                                        <ul class="dropdown-menu dropdown-menu-end dropdown-menu-arrow" style="">
                                            <li class="dropdown-header text-start">
                                                <h6>Option</h6>
                                            </li>
                                            <li>
                                                <a class="dropdown-item" href="javascript:void(0)" data-bs-toggle="modal" data-bs-target="#ModalEditAnggota" data-id="'.$id_anggota.'">
                                                    <i class="bi bi-pencil"></i> Ubah Anggota
                                                </a>
                                            </li>
                                            <li>
                                                <a class="dropdown-item" href="javascript:void(0)" data-bs-toggle="modal" data-bs-target="#ModalUbahFotoAnggota" data-id="'.$id_anggota.'">
                                                    <i class="bi bi-image"></i> Ubah Foto
                                                </a>
                                            </li>
                                            <li>
                                                <a class="dropdown-item" href="javascript:void(0)" data-bs-toggle="modal" data-bs-target="#ModalHapusAnggota" data-id="'.$id_anggota.'">
                                                    <i class="bi bi-x"></i> Hapus
                                                </a>
                                            </li>
                                        </ul>
                                        <a href="index.php?Page=Anggota" class="btn btn-md btn-dark btn-floating">
                                            <i class="bi bi-chevron-left"></i>
                                        </a>
                                    </div>
                                </div>
                            </div>
                            <div class="card-body">
                                <div class="row">
                                    <div class="col-12" id="put_detail_anggota"></div>
                                </div>
                            </div>
                            <div class="card-footer">
                                <small>
                                    ID Anggota : <span class="text-muted" id="GetIdAnggota">'.$id_anggota.'</span>
                                </small>
                            </div>
                        </div>
                    </div>
                </div>
            ';
            echo '
                <div class="row">
                    <div class="col-12">
                        <div class="card">
                            <div class="card-body">
                                <ul class="nav nav-tabs nav-tabs-bordered" id="borderedTab" role="tablist">
                                    <li class="nav-item" role="presentation">
                                        <button class="nav-link active" id="home-tab" data-bs-toggle="tab" data-bs-target="#bordered-home" type="button" role="tab" aria-controls="home" aria-selected="true">
                                            1. Simpanan
                                        </button>
                                    </li>
                                    <li class="nav-item" role="presentation">
                                        <button class="nav-link" id="profile-tab" data-bs-toggle="tab" data-bs-target="#bordered-profile" type="button" role="tab" aria-controls="profile" aria-selected="false" tabindex="-1">
                                            2. Pinjaman
                                        </button>
                                    </li>
                                    <li class="nav-item" role="presentation">
                                        <button class="nav-link" id="contact-tab" data-bs-toggle="tab" data-bs-target="#bordered-contact" type="button" role="tab" aria-controls="contact" aria-selected="false" tabindex="-1">
                                            3. Pembelian
                                        </button>
                                    </li>
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>
            ';
            echo '
                <div class="row">
                    <div class="col-12">
                        <div class="tab-content pt-2" id="borderedTabContent">
                            <div class="tab-pane fade active show" id="bordered-home" role="tabpanel" aria-labelledby="home-tab">
                                <div class="card">
                                    <div class="card-header">
                                        <div class="row">
                                            <div class="col-9">
                                                <b class="card-title">1. Riwayat Simpanan</b>
                                            </div>
                                            <div class="col-3 text-end">
                                                <button type="button" class="btn btn-md btn-outline-warning btn-floating" title="Download / Export Riwayat Simpanan" data-bs-toggle="modal" data-bs-target="#ModalExportRiwayatSimpanan" data-id="'.$id_anggota.'">
                                                    <i class="bii bi-download"></i>
                                                </button>
                                                <button type="button" class="btn btn-md btn-outline-secondary btn-floating" btn-floating" data-bs-toggle="modal" data-bs-target="#ModalRekapSiimpananAnggota" data-id="'.$id_anggota.'" title="Rekapitulasi Simpanan Anggota">
                                                    <i class="bi bi-bar-chart"></i>
                                                </button>
                                                <button type="button" class="btn btn-md btn-secondary btn-floating" data-bs-toggle="modal" data-bs-target="#ModalFilterRiwayatSimpanan" title="Filter Riwayat Simpanan">
                                                    <i class="bii bi-filter"></i>
                                                </button>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="card-body">
                                        <div class="table table table-responsive">
                                            <table class="table table-hover table-striped">
                                                <thead>
                                                    <tr>
                                                        <th><b>No</b></th>
                                                        <th><b>Tanggal</b></th>
                                                        <th><b>Kategori Simpanan</b></th>
                                                        <th><b>Nominal</b></th>
                                                        <th><b>Jurnal</b></th>
                                                    </tr>
                                                </thead>
                                                <tbody id="put_tabel_riwayat_simpanan">
                                                    <tr>
                                                        <td colspan="5" class="text-center">
                                                            <small class="text-danger">Tidak Ada Data Simpanan Yang Ditampilkan</small>
                                                        </td>
                                                    </tr>
                                                </tbody>
                                            </table>
                                        </div>
                                    </div>
                                    <div class="card-footer">
                                        <div class="row">
                                            <div class="col-6">
                                                <small id="page_info_riwayat_simpanan">
                                                    Page 1 Of 100
                                                </small>
                                            </div>
                                            <div class="col-6 text-end">
                                                <button type="button" class="btn btn-sm btn-outline-info btn-floating" id="prev_button_riwayat_simpanan">
                                                    <i class="bi bi-chevron-left"></i>
                                                </button>
                                                <button type="button" class="btn btn-sm btn-outline-info btn-floating" id="next_button_riwayat_simpanan">
                                                    <i class="bi bi-chevron-right"></i>
                                                </button>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="tab-pane fade" id="bordered-profile" role="tabpanel" aria-labelledby="profile-tab">
                                <div class="card">
                                    <div class="card-header">
                                        <div class="row">
                                            <div class="col-10">
                                                <b class="card-title">1. Riwayat Pinjaman</b>
                                            </div>
                                            <div class="col-2 text-end">
                                                <button type="button" class="btn btn-md btn-secondary btn-floating" title="Filter Riwayat Pinjaman" data-bs-toggle="modal" data-bs-target="#ModalFilterRiwayatPinjaman">
                                                    <i class="bii bi-filter"></i>
                                                </button>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="card-body">
                                        <div class="table table table-responsive">
                                            <table class="table table-hover table-striped">
                                                <thead>
                                                    <tr>
                                                        <th><b>No</b></th>
                                                        <th><b>Tanggal</b></th>
                                                        <th><b>Pinjaman</b></th>
                                                        <th><b>Angsuran (Rp)</b></th>
                                                        <th><b>Angsuran (Periode)</b></th>
                                                        <th><b>Angsuran Masuk</b></th>
                                                        <th><b>Sisa Pinjaman</b></th>
                                                        <th><b>Jurnal</b></th>
                                                        <th><b>Status</b></th>
                                                    </tr>
                                                </thead>
                                                <tbody id="put_tabel_riwayat_pinjaman">
                                                    <tr>
                                                        <td colspan="9" class="text-center">
                                                            <small class="text-danger">Tidak Ada Data Pinjaman Yang Ditampilkan</small>
                                                        </td>
                                                    </tr>
                                                </tbody>
                                            </table>
                                        </div>
                                    </div>
                                    <div class="card-footer">
                                        <div class="row">
                                            <div class="col-6">
                                                <small id="page_info_riwayat_pinjaman">
                                                    Page 1 Of 100
                                                </small>
                                            </div>
                                            <div class="col-6 text-end">
                                                <button type="button" class="btn btn-sm btn-outline-info btn-floating" id="prev_button_riwayat_pinjaman">
                                                    <i class="bi bi-chevron-left"></i>
                                                </button>
                                                <button type="button" class="btn btn-sm btn-outline-info btn-floating" id="next_button_riwayat_pinjaman">
                                                    <i class="bi bi-chevron-right"></i>
                                                </button>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="tab-pane fade" id="bordered-contact" role="tabpanel" aria-labelledby="contact-tab">
                                <div class="card">
                                    <div class="card-header">
                                        <div class="row">
                                            <div class="col-10">
                                                <b class="card-title">3. Riwayat Pembelian</b>
                                            </div>
                                            <div class="col-2 text-end">
                                                <button type="button" class="btn btn-md btn-outline-secondary btn-floating" title="Download / Export Riwayat Penjualan" data-bs-toggle="modal" data-bs-target="#ModalExportRiwayatPenjualan" data-id="'.$id_anggota.'">
                                                    <i class="bii bi-download"></i>
                                                </button>
                                                <button type="button" class="btn btn-md btn-secondary btn-floating" title="Filter Riwayat Penjualan" data-bs-toggle="modal" data-bs-target="#ModalFilterRiwayatPenjualan">
                                                    <i class="bii bi-filter"></i>
                                                </button>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="card-body">
                                        <table class="table table-hover table-striped">
                                            <thead>
                                                <tr>
                                                    <th><b>No</b></th>
                                                    <th><b>Tanggal</b></th>
                                                    <th><b>Subtotal</b></th>
                                                    <th><b>Diskon</b></th>
                                                    <th><b>PPN</b></th>
                                                    <th><b>Total</b></th>
                                                    <th><b>Cash</b></th>
                                                    <th><b>Kembalian</b></th>
                                                    <th><b>Status</b></th>
                                                    <th><b>Jurnal</b></th>
                                                </tr>
                                            </thead>
                                            <tbody id="put_tabel_riwayat_penjualan">
                                                <tr>
                                                    <td colspan="10" class="text-center">
                                                        <small class="text-danger">Tidak Ada Data Transaksi Yang Ditampilkan</small>
                                                    </td>
                                                </tr>
                                            </tbody>
                                        </table>
                                    </div>
                                    <div class="card-footer">
                                        <div class="row">
                                            <div class="col-6">
                                                <small id="page_info_riwayat_penjualan">
                                                    Page 1 Of 100
                                                </small>
                                            </div>
                                            <div class="col-6 text-end">
                                                <button type="button" class="btn btn-sm btn-outline-info btn-floating" id="prev_button_riwayat_penjualan">
                                                    <i class="bi bi-chevron-left"></i>
                                                </button>
                                                <button type="button" class="btn btn-sm btn-outline-info btn-floating" id="next_button_riwayat_penjualan">
                                                    <i class="bi bi-chevron-right"></i>
                                                </button>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            ';
        }
    }
?>
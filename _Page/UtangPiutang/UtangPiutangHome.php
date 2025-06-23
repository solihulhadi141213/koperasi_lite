<?php
    //Data Penjualan
    $jumlah_data_penjualan=mysqli_num_rows(mysqli_query($Conn, "SELECT id_transaksi_jual_beli FROM transaksi_jual_beli WHERE kategori='Penjualan'"));
    $jumlah_data_penjualan_format = "" . number_format($jumlah_data_penjualan,0,',','.');

    $data_penjualan=mysqli_fetch_array(mysqli_query($Conn, "SELECT SUM(total) AS total FROM transaksi_jual_beli WHERE kategori='Penjualan'"));
    $jumlah_penjualan = $data_penjualan['total'];
    $jumlah_penjualan_format = "Rp " . number_format($jumlah_penjualan,0,',','.');

    $jumlah_data_retur_penjualan=mysqli_num_rows(mysqli_query($Conn, "SELECT id_transaksi_jual_beli FROM transaksi_jual_beli WHERE kategori='Retur Penjualan'"));
    $jumlah_data_retur_penjualan_format = "" . number_format($jumlah_data_retur_penjualan,0,',','.');

    $data_retur_penjualan=mysqli_fetch_array(mysqli_query($Conn, "SELECT SUM(total) AS total FROM transaksi_jual_beli WHERE kategori='Retur Penjualan'"));
    $jumlah_retur_penjualan = $data_retur_penjualan['total'];
    $jumlah_retur_penjualan_format = "Rp " . number_format($jumlah_retur_penjualan,0,',','.');

    $jumlah_penjualan_bersih=$jumlah_penjualan-$jumlah_retur_penjualan;
    $jumlah_penjualan_bersih_format = "Rp " . number_format($jumlah_penjualan_bersih,0,',','.');

    $jumlah_data_penjualan_lunas=mysqli_num_rows(mysqli_query($Conn, "SELECT id_transaksi_jual_beli FROM transaksi_jual_beli WHERE kategori='Penjualan' AND status='Lunas'"));
    $jumlah_data_penjualan_lunas_format = "" . number_format($jumlah_data_penjualan_lunas,0,',','.');

    $data_penjualan_lunas=mysqli_fetch_array(mysqli_query($Conn, "SELECT SUM(total) AS total FROM transaksi_jual_beli WHERE kategori='Penjualan' AND status='Lunas'"));
    $jumlah_penjualan_lunas = $data_penjualan_lunas['total'];
    $jumlah_penjualan_lunas_format = "Rp " . number_format($jumlah_penjualan_lunas,0,',','.');

    $jumlah_data_piutang_penjualan=mysqli_num_rows(mysqli_query($Conn, "SELECT id_transaksi_jual_beli FROM transaksi_jual_beli WHERE kategori='Penjualan' AND status='Kredit'"));
    $jumlah_data_piutang_penjualan_format = "" . number_format($jumlah_data_piutang_penjualan,0,',','.');

    $data_piutang_penjualan=mysqli_fetch_array(mysqli_query($Conn, "SELECT SUM(total) AS total FROM transaksi_jual_beli WHERE kategori='Penjualan' AND status='Kredit'"));
    $jumlah_piutang_penjualan = $data_piutang_penjualan['total'];
    $jumlah_piutang_penjualan_format = "Rp " . number_format($jumlah_piutang_penjualan,0,',','.');

    $jumlah_data_utang_penjualan=mysqli_num_rows(mysqli_query($Conn, "SELECT id_transaksi_jual_beli FROM transaksi_jual_beli WHERE kategori='Retur Penjualan' AND status='Kredit'"));
    $jumlah_data_utang_penjualan_format = "Rp " . number_format($jumlah_data_utang_penjualan,0,',','.');

    $data_utang_penjualan=mysqli_fetch_array(mysqli_query($Conn, "SELECT SUM(total) AS total FROM transaksi_jual_beli WHERE kategori='Retur Penjualan' AND status='Kredit'"));
    $jumlah_utang_penjualan = $data_utang_penjualan['total'];
    $jumlah_utang_penjualan_format = "Rp " . number_format($jumlah_utang_penjualan,0,',','.');
    //Data Pembelian
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
            <li class="breadcrumb-item active">Utang/Piutang</li>
        </ol>
    </nav>
</div>
<section class="section dashboard">
    <div class="row">
        <div class="col-md-12">
            <div class="alert alert-warning alert-dismissible fade show" role="alert">
                <small>
                    Berikut ini adalah halaman untuk menampilkan data utang/piutang transaksi penjualan dan pembelian. 
                    Pada halaman ini, anda bisa membuat faktur transaksi pembayaran utang/piutang usaha baik secara parsial mapun multiple.
                </small>
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        </div>
    </div>
    <div class="row mb-3">
        <div class="col-md-12 text-end">
            <a href="Javascript:void(0);" class="btn btn-md btn-outline-info" data-bs-toggle="modal" data-bs-target="#ModalRiwayatPembayaran" data-id="Penjualan">
                Lihat Riwayat Pembayaran
            </a>
        </div>
    </div>
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-body">
                    <div class="row">
                        <div class="col-6 col-md-3 mb-3 border-end">
                            <b>
                                <a href="javascript:void(0);" 
                                    class="text-dark"
                                    data-bs-toggle="tooltip" 
                                    data-bs-placement="top" 
                                    data-bs-original-title="Jumlah penjualan setelah dikurangi retur penjualan">
                                    <i class="bi bi-question-circle"></i>
                                </a>
                                Penjualan Netto <span class="badge rounded-pill bg-primary"><?php echo $jumlah_data_penjualan_format; ?></span>
                            </b><br>
                            <small class="text text-muted"><?php echo $jumlah_penjualan_bersih_format; ?></small>
                        </div>
                        <div class="col-6 col-md-3 mb-3 border-end">
                            <b>
                                <a href="javascript:void(0);" 
                                    class="text-dark"
                                    data-bs-toggle="tooltip" 
                                    data-bs-placement="top" 
                                    data-bs-original-title="Jumlah penjualan dengan pembayaran lunas">
                                    <i class="bi bi-question-circle"></i>
                                </a>
                                Penjualan (Lunas) <span class="badge rounded-pill bg-success"><?php echo $jumlah_data_penjualan_lunas_format; ?></span>
                            </b><br>
                            <small class="text text-muted"><?php echo $jumlah_penjualan_lunas_format; ?></small>
                        </div>
                        <div class="col-6 col-md-3 mb-3 border-end">
                            <b>
                                <a href="javascript:void(0);" 
                                    class="text-dark"
                                    data-bs-toggle="tooltip" 
                                    data-bs-placement="top" 
                                    data-bs-original-title="Jumlah Transaksi Retur Penjualan Yang Belum Dibayar (Kredit)">
                                    <i class="bi bi-question-circle"></i>
                                </a>
                                Utang Penjualan <span class="badge rounded-pill bg-warning"><?php echo $jumlah_data_utang_penjualan_format; ?></span>
                            </b><br>
                            <small class="text text-muted"><?php echo $jumlah_utang_penjualan_format; ?></small>
                        </div>
                        <div class="col-6 col-md-3 mb-3">
                            <b>
                                <a href="javascript:void(0);" 
                                    class="text-dark"
                                    data-bs-toggle="tooltip" 
                                    data-bs-placement="top" 
                                    data-bs-original-title="Jumlah Transaksi Penjualan Yang Belum Dibayar (Kredit)">
                                    <i class="bi bi-question-circle"></i>
                                </a>
                                Piutang Penjualan <span class="badge rounded-pill bg-danger"><?php echo $jumlah_data_piutang_penjualan_format; ?></span>
                            </b><br>
                            <small class="text text-muted"><?php echo $jumlah_piutang_penjualan_format; ?></small>
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
                        <div class="col-10 mb-3">
                            <b class="card-title"># Utang/Piutang Transaksi</b><br>

                        </div>
                        <div class="col-2 mb-3 text-end">
                            <button type="button" class="btn btn-md btn-secondary btn-floating" data-bs-toggle="modal" data-bs-target="#ModalFilterPenjualan">
                                <i class="bi bi-filter"></i>
                            </button>
                        </div>
                    </div>
                </div>
                <div class="card-body">
                    <div class="row mb-2 border-1 border-bottom">
                        
                    </div>
                    <form action="javascript:void(0);" id="ProsesDetailMulti">
                        <div class="table table-responsive mb-3">
                            <table class="table table-striped table-hover">
                                <thead>
                                    <tr>
                                        <th>
                                            <div class="form-check form-switch">
                                                <input class="form-check-input" type="checkbox" id="check_all_penjualan" name="check_all_penjualan" value="pilih">
                                            </div>
                                        </th>
                                        <th><b>Tgl</b></th>
                                        <th><b>Anggota</b></th>
                                        <th><b>Transaksi</b></th>
                                        <th><b>Jumlah</b></th>
                                        <th><b>Cash</b></th>
                                        <th><b>Pembayaran</b></th>
                                        <th><b>Tagihan</b></th>
                                        <th><b>Utang/Piutang</b></th>
                                        <th><b>Opsi</b></th>
                                    </tr>
                                </thead>
                                <tbody id="TabelUtangPiutangPenjualan">
                                    <tr>
                                        <td colspan="7" class="text text-center">
                                            <small class="text-danger">Tidak Ada Data Utang/Piutang Penjualan Yang Ditampilkan</small>
                                        </td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                        <div class="row">
                            <div class="col-12">
                                <button type="submit" class="btn btn-sm btn-outline-success" id="ButtonTambahPembayaranPenjualan" data-bs-toggle="modal" data-bs-target="#ModalPembayaranPenjualanMultiple">
                                    <i class="bi bi-plus"></i> Bayar
                                </button>
                            </div>
                        </div>
                    </form>
                </div>
                <div class="card-footer">
                    <div class="row">
                        <div class="col-6">
                            <small id="page_info_penjualan">
                                Page 1 Of 100
                            </small>
                        </div>
                        <div class="col-6 text-end">
                            <button type="button" class="btn btn-sm btn-outline-info btn-floating" id="prev_button_penjualan">
                                <i class="bi bi-chevron-left"></i>
                            </button>
                            <button type="button" class="btn btn-sm btn-outline-info btn-floating" id="next_button_penjualan">
                                <i class="bi bi-chevron-right"></i>
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<?php
    //Cek Aksesibilitas ke halaman ini
    $IjinAksesSaya=IjinAksesSaya($Conn,$SessionIdAkses,'ungKMcHQ0OvFgMhS1y8');
    if($IjinAksesSaya!=="Ada"){
        include "_Page/Error/NoAccess.php";
    }else{
?>
    <div class="pagetitle">
        <h1>
            <a href="">
                <i class="bi bi-table"></i> Rekapitulasi Jual-Beli</a>
            </a>
        </h1>
        <nav>
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="index.php">Dashboard</a></li>
                <li class="breadcrumb-item active"> Rekapitulasi Jual-Beli</li>
            </ol>
        </nav>
    </div>
    <section class="section dashboard">
        <div class="row">
            <div class="col-md-12">
                <?php
                    echo '<div class="alert alert-warning alert-dismissible fade show" role="alert">';
                    echo '  <small>';
                    echo '      Berikut ini halaman rekapitulasi data transaksi jual-beli berdasarkan periode waktu dan jenis transaksi yang sudah berlangsung.';
                    echo '      Gunakan tombol "Filter" untuk menentukan dasar pengelompokan data.';
                    echo '      <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>';
                    echo '  </small>';
                    echo '</div>';
                ?>
            </div>
        </div>
        <?php
            if(empty($_POST['tahun'])){
                $tahun=date('Y');
            }else{
                $tahun=$_POST['tahun'];
            }
        ?>
        <div class="row">
            <div class="col-lg-12">
                <div class="card">
                    <div class="card-header">
                        <div class="row">
                            <div class="col-md-10">
                                <b class="card-title">
                                    <i class="bi bi-graph-up"></i> Rekapitulasi Transaksi Jual - Beli
                                </b>
                            </div>
                            <div class="col-md-2 mb-3">
                                <a class="btn btn-md btn-outline-dark btn-rounded btn-block" href="javascript:void(0);" data-bs-toggle="modal" data-bs-target="#ModalFilter">
                                    <i class="bi bi-filter"></i> Mode Data
                                </a>
                            </div>
                        </div>
                    </div>
                    <div class="card-body">
                        <div class="row mb-3">
                            <div class="col-md-12 text-center" id="MenampilkanJudulGrafikJualBeli">
                                
                            </div>
                        </div>
                        <div class="row mb-3 border-1 border-bottom">
                            <div class="col-md-12 mb-3 text-center" id="MenampilkanGrafikJualBeli">
                                
                            </div>
                        </div>
                        <div class="row mb-3">
                            <div class="col-md-12 text-center">
                                <b>
                                    TABEL REKAPITULASI TRANSAKSI PENJUALAN & PEMBELIAN <br>
                                    PERIODE TAHUN <?php echo "$tahun"; ?>
                                </b>
                            </div>
                        </div>
                        <div class="row mb-3">
                            <div class="col-md-12 text-center">
                                <button type="button" class="btn btn-outline-secondary btn-rounded" data-bs-toggle="modal" data-bs-target="#ModalCetak">
                                    <i class="bi bi-printer"></i> Cetak
                                </button>
                            </div>
                        </div>
                        <div class="row mb-3">
                            <div class="col-md-12">
                                <div class="table table-responsive">
                                    <table class="table table-striped table-bordered table-hover">
                                        <thead>
                                            <tr>
                                                <td align="center" rowspan="2" class="bg-dark text-light" valign="top"><b>NO</b></td>
                                                <td align="center" rowspan="2" class="bg-dark text-light" valign="top"><b>PERIODE</b></td>
                                                <td align="center" colspan="3" class="bg-success text-light"><b>TRANSAKSI PENJUALAN</b></td>
                                                <td align="center" colspan="3" class="bg-warning text-light"><b>TRANSAKSI PEMBELIAN</b></td>
                                            </tr>
                                            <tr>
                                                <td align="center" class="bg-success text-light"><b>PENJUALAN</b></td>
                                                <td align="center" class="bg-success text-light"><b>RETUR</b></td>
                                                <td align="center" class="bg-success text-light"><b>JUMLAH</b></td>
                                                <td align="center" class="bg-warning text-light"><b>PEMBELIAN</b></td>
                                                <td align="center" class="bg-warning text-light"><b>RETUR</b></td>
                                                <td align="center" class="bg-warning text-light"><b>JUMLAH</b></td>
                                            </tr>
                                        </thead>
                                        <tbody id="tabel_rekapitulasi_transaksi_jual_beli">
                                            <?php
                                                
                                            ?>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
<?php } ?>
<div class="modal fade" id="ModalFilterGrafik" tabindex="-1">
    <div class="modal-dialog modal-md">
        <div class="modal-content">
            <form action="index.php?Page=RekapTransaksi" method="POST">
                <div class="modal-header">
                    <h5 class="modal-title text-dark">
                        <i class="bi bi-funnel"></i> Mode Grafik
                    </h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="row mb-3">
                        <div class="col col-md-4"><label for="jenis_transaksi">Jenis Transaksi</label></div>
                        <div class="col col-md-8">
                            <select name="jenis_transaksi" class="form-control">
                                <option value="">Semua</option>
                                <?php
                                    //Menampilkan Jenis Transaksi
                                    $query_jenis_transaksi = mysqli_query($Conn, "SELECT * FROM transaksi_jenis ORDER BY nama ASC");
                                    while ($DataJenisTransaksi = mysqli_fetch_array($query_jenis_transaksi)) {
                                        $IdJenisTransaksi=$DataJenisTransaksi['id_transaksi_jenis'];
                                        $JenisTransaksiList=$DataJenisTransaksi['nama'];
                                        echo '<option value="'.$IdJenisTransaksi.'">'.$JenisTransaksiList.'</option>';
                                    }
                                ?>
                            </select>
                            <small class="credit">
                                <code class="text text-grayish">Pilih jenis transaksi yang ingin ditampilkan</code>
                            </small>
                        </div>
                    </div>
                    <div class="row mb-3" id="FormTahun">
                        <div class="col col-md-4"><label for="tahun">Tahun Data</label></div>
                        <div class="col col-md-8">
                            <select name="tahun"  class="form-control">
                                <?php
                                    // Tentukan tahun awal dan akhir
                                    $tahunAwal = 2010;
                                    $tahunSekarang = date('Y');
                                    for ($tahun = $tahunAwal; $tahun <= $tahunSekarang; $tahun++) {
                                        if($tahun==$tahunSekarang){
                                            echo '<option selected value="'.$tahun.'">'.$tahun.'</option>';
                                        }else{
                                            echo '<option value="'.$tahun.'">'.$tahun.'</option>';
                                        }
                                    }
                                ?>
                            </select>
                            <small class="credit">
                                <code class="text text-grayish">Periode Tahun Yang Ditampilkan</code>
                            </small>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="submit" class="btn btn-success btn-rounded">
                        <i class="bi bi-filter"></i> Filter
                    </button>
                    <button type="button" class="btn btn-dark btn-rounded" data-bs-dismiss="modal">
                        <i class="bi bi-x-circle"></i> Tutup
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
<div class="modal fade" id="ModalExportTabelTransaksi" tabindex="-1">
    <div class="modal-dialog modal-md">
        <div class="modal-content">
            <form action="_Page/RekapTransaksi/ProsesExportTransaksi.php" method="POST" target="_blank">
                <div class="modal-header">
                    <h5 class="modal-title text-dark">
                        <i class="bi bi-download"></i> Export Rekap Transaksi
                    </h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="row mb-3">
                        <div class="col col-md-4"><label for="jenis_transaksi">Jenis Transaksi</label></div>
                        <div class="col col-md-8">
                            <input type="text" readonly name="jenis_transaksi" class="form-control" value="<?php echo "$NameJenisTransaksi"; ?>">
                        </div>
                    </div>
                    <div class="row mb-3">
                        <div class="col col-md-4"><label for="tahun">Tahun Data</label></div>
                        <div class="col col-md-8">
                            <input type="text" readonly name="tahun" class="form-control" value="<?php echo "$tahun"; ?>">
                        </div>
                    </div>
                    <div class="row mb-3">
                        <div class="col col-md-4"><label for="file_type">Type File</label></div>
                        <div class="col col-md-8">
                            <select name="file_type" id="file_type" class="form-control">
                                <option value="HTML">HTML</option>
                                <option value="PDF">PDF</option>
                                <option value="CSV">CSV/Excel</option>
                            </select>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-12 text-center">
                            <small>Silahkan pilih type file hasil export yang diinginkan.</small>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="submit" class="btn btn-success btn-rounded">
                        <i class="bi bi-download"></i> Export
                    </button>
                    <button type="button" class="btn btn-dark btn-rounded" data-bs-dismiss="modal">
                        <i class="bi bi-x-circle"></i> Tutup
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
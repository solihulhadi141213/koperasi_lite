<div class="modal fade" id="ModalFilter" tabindex="-1">
    <div class="modal-dialog modal-md">
        <div class="modal-content">
            <form action="javascript:void(0);" id="ProsesFilter">
                <div class="modal-header">
                    <h5 class="modal-title text-dark"><i class="bi bi-funnel"></i> Filter Keluar Masuk Anggota</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="row mb-3">
                        <div class="col col-md-4">
                            <label for="mode">Mode</label>
                        </div>
                        <div class="col col-md-8">
                            <select name="mode" id="mode" class="form-control">
                                <option selected value="Harian">Harian</option>
                                <option value="Bulanan">Bulanan</option>
                            </select>
                        </div>
                    </div>
                    <div class="row mb-3">
                        <div class="col col-md-4">
                            <label for="tahun">Tahun</label>
                        </div>
                        <div class="col col-md-8">
                            <select name="tahun" id="tahun" class="form-control">
                                <?php
                                    $current_year = date("Y");
                                    for ($year = $current_year; $year >= $current_year - 5; $year--) {
                                        if($year==$current_year){
                                            echo '<option selected value="'.$year.'">'.$year.'</option>';
                                        }else{
                                            echo '<option value="'.$year.'">'.$year.'</option>';
                                        }
                                    }
                                ?>
                            </select>
                        </div>
                    </div>
                    <div class="row mb-3" id="FormBulan">
                        <div class="col col-md-4">
                            <label for="bulan">Bulan</label>
                        </div>
                        <div class="col col-md-8">
                            <select name="bulan" id="bulan" class="form-control">
                                <?php
                                    $bulan_sekarang=date('m');
                                    // Array nama-nama bulan
                                    $months = [
                                        "01" => "Januari",
                                        "02" => "Februari",
                                        "03" => "Maret",
                                        "04" => "April",
                                        "05" => "Mei",
                                        "06" => "Juni",
                                        "07" => "Juli",
                                        "08" => "Agustus",
                                        "09" => "September",
                                        "10" => "Oktober",
                                        "11" => "November",
                                        "12" => "Desember"
                                    ];

                                    // Melakukan looping dari bulan 01 hingga 12
                                    foreach ($months as $number => $name) {
                                        if($bulan_sekarang==$number){
                                            echo '<option selected value="'.$number.'">'.$name.'</option>';
                                        }else{
                                            echo '<option value="'.$number.'">'.$name.'</option>';
                                        }
                                    }
                                ?>
                            </select>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="submit" class="btn btn-success btn-rounded">
                        <i class="bi bi-save"></i> Filter
                    </button>
                    <button type="button" class="btn btn-dark btn-rounded" data-bs-dismiss="modal">
                        <i class="bi bi-x-circle"></i> Tutup
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
<div class="modal fade" id="ModalExport" tabindex="-1">
    <div class="modal-dialog modal-md">
        <div class="modal-content">
            <form action="_Page/AnggotaKeluarMasuk/ProsesExport.php" method="POST" target="_blank">
                <div class="modal-header">
                    <h5 class="modal-title text-dark">
                        <i class="bi bi-download"></i> Export Keluar Masuk Anggota
                    </h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="row">
                        <div class="col col-md-12" id="FormExport"></div>
                    </div>
                    <div class="row mb-3">
                        <div class="col col-md-12">
                            <code class="text-primary">
                                Apakah anda yakin akan melakukan export data tersebut ke format EXCEL?
                            </code>
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
<div class="modal fade" id="ModalListAnggotaMasuk" tabindex="-1">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title text-dark">
                    <i class="bi bi-table"></i> List Anggota Masuk
                </h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div class="row">
                    <div class="col col-md-12" id="FormListAnggotaMasuk"></div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-dark btn-rounded" data-bs-dismiss="modal">
                    <i class="bi bi-x-circle"></i> Tutup
                </button>
            </div>
        </div>
    </div>
</div>
<div class="modal fade" id="ModalListAnggotaKeluar" tabindex="-1">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title text-dark">
                    <i class="bi bi-table"></i> List Anggota Keluar
                </h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div class="row">
                    <div class="col col-md-12" id="FormListAnggotaKeluar"></div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-dark btn-rounded" data-bs-dismiss="modal">
                    <i class="bi bi-x-circle"></i> Tutup
                </button>
            </div>
        </div>
    </div>
</div>
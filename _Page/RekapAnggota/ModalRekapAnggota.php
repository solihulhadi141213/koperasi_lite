<div class="modal fade" id="ModalFilter" tabindex="-1">
    <div class="modal-dialog modal-md">
        <div class="modal-content">
            <form action="javascript:void(0);" id="ProsesFilter">
                <div class="modal-header">
                    <h5 class="modal-title text-dark">
                        <i class="bi bi-funnel"></i> Filter Rekapitulasi Simpanan
                    </h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="row mb-3">
                        <div class="col col-md-4"><label for="periode">Periode Data</label></div>
                        <div class="col col-md-8">
                            <select name="periode" id="periode" class="form-control">
                                <option value="Semua">Semua</option>
                                <option value="Tahunan">Tahunan</option>
                                <option selected value="Bulanan">Bulanan</option>
                            </select>
                            <small class="credit">
                                <code class="text text-grayish">Mode rekapitulasi yang akan ditampilkan</code>
                            </small>
                        </div>
                    </div>
                    <div class="row mb-3" id="FormTahun">
                        <div class="col col-md-4"><label for="tahun">Pilih Tahun</label></div>
                        <div class="col col-md-8">
                            <select name="tahun" id="tahun" class="form-control">
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
                    <div class="row mb-3" id="FormBulan">
                        <div class="col col-md-4"><label for="bulan">Pilih Bulan</label></div>
                        <div class="col col-md-8">
                            <select name="bulan" id="bulan" class="form-control">
                                <?php
                                    $bulan_sekarang=date('m');
                                    // Array dengan nama-nama bulan
                                    $namaBulan = [
                                        'Januari', 'Februari', 'Maret', 'April', 'Mei', 'Juni',
                                        'Juli', 'Agustus', 'September', 'Oktober', 'November', 'Desember'
                                    ];
                                    // Looping dari 1 hingga 12
                                    for ($i = 1; $i <= 12; $i++) {
                                        // Mengubah angka menjadi format dua digit
                                        $angkaBulan = str_pad($i, 2, '0', STR_PAD_LEFT);
                                        // Mengambil nama bulan dari array
                                        $namaBulanIni = $namaBulan[$i - 1];
                                        // Menampilkan angka bulan dan nama bulan
                                        if($bulan_sekarang==$angkaBulan){
                                            echo '<option selected value="'.$angkaBulan.'">'.$namaBulanIni.'</option>';
                                        }else{
                                            echo '<option value="'.$angkaBulan.'">'.$namaBulanIni.'</option>';
                                        }
                                    }
                                ?>
                            </select>
                            <small class="credit">
                                <code class="text text-grayish">Periode Bulan Yang Akan Ditampilkan</code>
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
<div class="modal fade" id="ModalCetak" tabindex="-1">
    <div class="modal-dialog modal-md">
        <div class="modal-content">
            <form action="_Page/RekapAnggota/ProsesCetakDataRekap.php" method="POST" target="_blank">
                <div class="modal-header">
                    <h5 class="modal-title text-dark">
                        <i class="bi bi-printer"></i> Cetak Rekapitulasi
                    </h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="row mb-3">
                        <div class="col-md-12" id="FormCetakDataRekap">

                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="submit" class="btn btn-success btn-rounded">
                        <i class="bi bi-printer"></i> Cetak
                    </button>
                    <button type="button" class="btn btn-dark btn-rounded" data-bs-dismiss="modal">
                        <i class="bi bi-x-circle"></i> Tutup
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
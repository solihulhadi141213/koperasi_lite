<div class="modal fade" id="ModalFilter" tabindex="-1">
    <div class="modal-dialog modal-md">
        <div class="modal-content">
            <form action="javascript:void(0);" id="ProsesFilter">
                <div class="modal-header">
                    <h5 class="modal-title text-dark">
                        <i class="bi bi-funnel"></i> Filter Simpanan Lembaga
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

<div class="modal fade" id="ModalFilterRank" tabindex="-1">
    <div class="modal-dialog modal-md">
        <div class="modal-content">
            <form action="javascript:void(0);" id="ProsesFilterRank">
                <div class="modal-header">
                    <h5 class="modal-title text-dark">
                        <i class="bi bi-funnel"></i> Filter Simpanan Rank
                    </h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="row mb-3">
                        <div class="col col-md-4"><label for="periode_rank">Periode Data</label></div>
                        <div class="col col-md-8">
                            <select name="periode" id="periode_rank" class="form-control">
                                <option value="Semua">Semua</option>
                                <option value="Tahunan">Tahunan</option>
                                <option selected value="Bulanan">Bulanan</option>
                            </select>
                            <small class="credit">
                                <code class="text text-grayish">Mode rekapitulasi yang akan ditampilkan</code>
                            </small>
                        </div>
                    </div>
                    <div class="row mb-3" id="FormTahunRank">
                        <div class="col col-md-4"><label for="tahun_rank">Pilih Tahun</label></div>
                        <div class="col col-md-8">
                            <select name="tahun" id="tahun_rank" class="form-control">
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
                    <div class="row mb-3" id="FormBulanRank">
                        <div class="col col-md-4"><label for="bulan_rank">Pilih Bulan</label></div>
                        <div class="col col-md-8">
                            <select name="bulan" id="bulan_rank" class="form-control">
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
<div class="modal fade" id="ModalFilterAnggota" tabindex="-1">
    <div class="modal-dialog modal-md">
        <div class="modal-content">
            <form action="javascript:void(0);" id="ProsesFilterAnggota">
                <div class="modal-header">
                    <h5 class="modal-title text-dark">
                        <i class="bi bi-funnel"></i> Filter Simpanan Anggota
                    </h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="row mb-3">
                        <div class="col col-md-4"><label for="periode_anggota">Periode Data</label></div>
                        <div class="col col-md-8">
                            <select name="periode" id="periode_anggota" class="form-control">
                                <option value="Semua">Semua</option>
                                <option value="Tahunan">Tahunan</option>
                                <option selected value="Bulanan">Bulanan</option>
                            </select>
                            <small class="credit">
                                <code class="text text-grayish">Mode rekapitulasi yang akan ditampilkan</code>
                            </small>
                        </div>
                    </div>
                    <div class="row mb-3" id="FormTahunAnggota">
                        <div class="col col-md-4"><label for="tahun_anggota">Pilih Tahun</label></div>
                        <div class="col col-md-8">
                            <select name="tahun" id="tahun_anggota" class="form-control">
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
                    <div class="row mb-3" id="FormBulanAnggota">
                        <div class="col col-md-4"><label for="bulan_anggota">Pilih Bulan</label></div>
                        <div class="col col-md-8">
                            <select name="bulan" id="bulan_anggota" class="form-control">
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
<div class="modal fade" id="ModadlFilterSimpananNetto" tabindex="-1">
    <div class="modal-dialog modal-md">
        <div class="modal-content">
            <form action="javascript:void(0);" id="ProsesFilterSimpananNetto">
                <input type="hidden" name="page" id="put_page_simpanan_netto">
                <div class="modal-header">
                    <h5 class="modal-title text-dark">
                        <i class="bi bi-funnel"></i> Filter Simpanan Netto (Anggota)
                    </h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="row mb-3">
                        <div class="col col-md-4"><label for="periode_simpanan_netto">Periode Data</label></div>
                        <div class="col col-md-8">
                            <select name="periode" id="periode_simpanan_netto" class="form-control">
                                <option value="Semua">Semua</option>
                                <option value="Tahunan">Tahunan</option>
                                <option selected value="Bulanan">Bulanan</option>
                            </select>
                            <small class="credit">
                                <code class="text text-grayish">Mode rekapitulasi yang akan ditampilkan</code>
                            </small>
                        </div>
                    </div>
                    <div class="row mb-3" id="FormTahunSimpananNetto">
                        <div class="col col-md-4"><label for="tahun_simpanan_netto">Pilih Tahun</label></div>
                        <div class="col col-md-8">
                            <select name="tahun" id="tahun_simpanan_netto" class="form-control">
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
                    <div class="row mb-3" id="FormBulanSimpananNetto">
                        <div class="col col-md-4"><label for="bulan_simpanan_netto">Pilih Bulan</label></div>
                        <div class="col col-md-8">
                            <select name="bulan" id="bulan_simpanan_netto" class="form-control">
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
            <form action="_Page/RekapSimpanan/ProsesCetakDataRekap.php" method="POST" target="_blank">
                <div class="modal-header">
                    <h5 class="modal-title text-dark">
                        <i class="bi bi-printer"></i> Cetak Rekapitulasi Simpanan
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

<div class="modal fade" id="ModalCetak2" tabindex="-1">
    <div class="modal-dialog modal-md">
        <div class="modal-content">
            <form action="_Page/RekapSimpanan/ProsesCetakDataRekap2.php" method="POST" target="_blank">
                <div class="modal-header">
                    <h5 class="modal-title text-dark">
                        <i class="bi bi-printer"></i> Cetak Rekapitulasi Simpanan
                    </h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="row mb-3">
                        <div class="col-md-12" id="FormCetakDataRekap2">

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

<div class="modal fade" id="ModalCetak3" tabindex="-1">
    <div class="modal-dialog modal-md">
        <div class="modal-content">
            <form action="_Page/RekapSimpanan/ProsesCetakDataRekap3.php" method="POST" target="_blank">
                <div class="modal-header">
                    <h5 class="modal-title text-dark">
                        <i class="bi bi-printer"></i> Cetak Rekapitulasi Simpanan
                    </h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="row mb-3">
                        <div class="col-md-12" id="FormCetakDataRekap3">

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
<div class="modal fade" id="ModalCetak4" tabindex="-1">
    <div class="modal-dialog modal-md">
        <div class="modal-content">
            <form action="_Page/RekapSimpanan/ProsesCetakDataRekap4.php" method="POST" target="_blank">
                <div class="modal-header">
                    <h5 class="modal-title text-dark">
                        <i class="bi bi-printer"></i> Export Simpanan Anggota (NETTO)
                    </h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="row mb-3">
                        <div class="col-md-12" id="FormCetakDataRekap4">

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
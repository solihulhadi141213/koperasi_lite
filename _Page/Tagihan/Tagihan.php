<div class="pagetitle">
    <h1>
        <a href="">
            <i class="bi bi-exclamation-diamond"></i> Angsuran</a>
        </a>
    </h1>
    <nav>
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="index.php">Dashboard</a></li>
            <li class="breadcrumb-item active"> Angsuran</li>
        </ol>
    </nav>
</div>
<section class="section dashboard">
    <div class="row">
        <div class="col-md-12">
            <div class="alert alert-warning alert-dismissible fade show" role="alert">
                <small>
                    Berikut ini adalah halaman yang menampilkan data rekapitulasi angsuran berdasarkan anggota. 
                    Pada halaman ini anda bisa memantau pembayaran angsuran pinjaman anggota.
                </small>
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
                                # Rekapitulasi Angsuran Anggota</b>
                            </b>
                        </div>
                        <div class="col-4 text-end">
                            <button type="button" class="btn btn-md btn-secondary btn-floating" data-bs-toggle="modal" data-bs-target="#ModalFilter" title="Filter/Pencarian">
                                <i class="bi bi-filter"></i>
                            </button>
                        </div>
                    </div>
                </div>
                <div class="card-body">
                    <div class="table table-responsive">
                        <table class="table table-striped table-hover">
                            <thead>
                                <tr>
                                    <th rowspan="2" valign="middle"><b>No</b></th>
                                    <th rowspan="2" valign="middle"><b>Anggota</b></th>
                                    <th colspan="12" class="text-center"><b>Periode Tahun <b id="year_info"><?php echo date('Y'); ?></b></th>
                                </tr>
                                <tr>
                                    <?php
                                        // Array nama bulan singkatan
                                        $bulan_singkat = ['Jan', 'Feb', 'Mar', 'Apr', 'Mei', 'Jun', 'Jul', 'Ags', 'Sep', 'Okt', 'Nov', 'Des'];
                                        
                                        // Loop untuk menampilkan header bulan
                                        foreach ($bulan_singkat as $bulan) {
                                            echo '<th><b>'.$bulan.'</b></th>';
                                        }
                                    ?>
                                </tr>
                            </thead>
                            <tbody id="TabelTagihan">
                                <!-- Menampilkan Data Angsuran Per Periode Disini -->
                            </tbody>
                        </table>
                    </div>
                </div>
                <div class="card-footer">
                    <div class="row">
                        <div class="col-6">
                            <small id="page_info">
                                Page 1 Of 100
                            </small>
                        </div>
                        <div class="col-6 text-end">
                            <button type="button" class="btn btn-md btn-outline-info btn-floating" id="prev_button">
                                <i class="bi bi-chevron-left"></i>
                            </button>
                            <button type="button" class="btn btn-md btn-outline-info btn-floating" id="next_button">
                                <i class="bi bi-chevron-right"></i>
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

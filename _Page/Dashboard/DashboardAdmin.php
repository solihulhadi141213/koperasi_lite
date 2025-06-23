<div class="pagetitle">
    <h1>
        <a href="">
            <i class="bi bi-grid"></i> Dashboard
        </a>
    </h1>
    <nav>
        <ol class="breadcrumb">
            <li class="breadcrumb-item active">Dashboard</li>
        </ol>
    </nav>
</div>
<section class="section dashboard">
    <div class="row">
        <div class="col-md-12" id="notifikasi_proses">
            <!-- Kejadian Kegagalan Menampilkan Data Akan Ditampilkan Disini -->
        </div>
    </div>
    <div class="row">
        <div class="col-lg-12">
            <div class="row">
                <div class="col-md-12">
                    <div class="card" id="card_jam_menarik">
                        <div class="card-body">
                            <div id="tanggal_menarik">Hari, 01 Januari 1900</div>
                            <div id="jam_menarik">00:00:00</div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-md-12">
                    <div class="row">
                        <div class="col-xxl-3 col-md-12 col-12">
                            <div class="card info-card sales-card">
                                <div class="card-body">
                                    <h5 class="card-title">Anggota</h5>
                                    <div class="d-flex align-items-center gap-3">
                                        <!-- Icon -->
                                        <div class="card-icon rounded-circle d-flex align-items-center justify-content-center">
                                            <i class="bi bi-people"></i>
                                        </div>
                                        <!-- Data Info -->
                                        <div>
                                            <div class="d-flex">
                                                <span class="text-success small pt-2" style="width: 60px;">Aktif</span>
                                                <span class="text-muted small pt-2" id="put_anggota_aktif">0.000</span>
                                            </div>
                                            <div class="d-flex">
                                                <span class="text-danger small pt-2" style="width: 60px;">Keluar</span>
                                                <span class="text-muted small pt-2" id="put_anggota_keluar">0.000</span>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-xxl-3 col-md-12 col-12">
                            <div class="card info-card revenue-card">
                                <div class="card-body">
                                    <h5 class="card-title">Simpanan</h5>
                                    <div class="d-flex align-items-center gap-3">
                                        <div class="card-icon rounded-circle d-flex align-items-center justify-content-center">
                                            <i class="bi bi-cash-coin"></i>
                                        </div>
                                        <div class="ps-3">
                                            <span class="text-info small pt-2 ps-1" 
                                                data-bs-toggle="tooltip" 
                                                data-bs-placement="top" 
                                                data-bs-custom-class="custom-tooltip" 
                                                data-bs-title="Jumlah Simpanan Anggota Setelah Dikurangi Penarikan" 
                                                id="put_simpanan_anggota">
                                                <!-- Menampilkan Simpanan Anggota -->
                                            </span><br>
                                            <span class="text-warning small pt-2 ps-1" 
                                                data-bs-toggle="tooltip" 
                                                data-bs-placement="top" 
                                                data-bs-custom-class="custom-tooltip" 
                                                data-bs-title="Jumlah Total Penarikan Dana Simpanan" 
                                                id="put_penarikan_dana">
                                                <!-- Menampilkan Penarikan Dana Anggota -->
                                            </span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-xxl-3 col-md-12 col-12">
                            <div class="card info-card customers-card">
                                <div class="card-body">
                                    <h5 class="card-title">Pinjaman</h5>
                                    <div class="d-flex align-items-center">
                                        <div class="card-icon rounded-circle d-flex align-items-center justify-content-center">
                                            <i class="bi bi-bank"></i>
                                        </div>

                                        <div class="ps-3">
                                            <span class="text-dark small pt-2 ps-1"  
                                                data-bs-toggle="tooltip" 
                                                data-bs-placement="top" 
                                                data-bs-custom-class="custom-tooltip" 
                                                data-bs-title="Jumlah Total Pinjaman Anggota Yang Belum Lunas"  
                                                id="put_pinjaman_anggota">
                                            </span><br>
                                            <span class="text-muted small pt-2 ps-1" 
                                                data-bs-toggle="tooltip" 
                                                data-bs-placement="top" 
                                                data-bs-custom-class="custom-tooltip" 
                                                data-bs-title="Jumlah Sesi Pinjaman Belum Lunas" 
                                                id="put_sesi_pinjaman">
                                            </span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-xxl-3 col-md-12 col-12">
                            <div class="card info-card blue-card">
                                <div class="card-body">
                                    <h5 class="card-title">Angsuran</h5>
                                    <div class="d-flex align-items-center">
                                        <div class="card-icon rounded-circle d-flex align-items-center justify-content-center">
                                            <i class="bi bi-bank"></i>
                                        </div>
                                        <div class="ps-3">
                                            <span class="text-muted small pt-2 ps-1"  
                                                data-bs-toggle="tooltip" 
                                                data-bs-placement="top" 
                                                data-bs-custom-class="custom-tooltip" 
                                                data-bs-title="Jumlah Nominal Angsuran Masuk" 
                                                id="put_nominal_angsuran">
                                            </span><br>
                                            <span class="text-muted small pt-2 ps-1"  
                                                data-bs-toggle="tooltip" 
                                                data-bs-placement="top" 
                                                data-bs-custom-class="custom-tooltip" 
                                                data-bs-title="Jumlah Record Angsuran Masuk" 
                                                id="put_record_angsuran">
                                            </span><br>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            
            <div class="row">
                <!-- Reports -->
                <div class="col-md-8">
                    <div class="card">
                        <div class="card-header">
                            <b class="card-title">
                                Simpanan & Pinjaman Anggota Thn <?php echo date ('Y'); ?>
                            </b>
                        </div>
                        <div class="card-body">
                            <h5 class="card-title" id="NamaTitleData"></h5>
                            <div id="chart"></div>
                        </div>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="card">
                        <div class="card-header">
                            <b class="card-title"># Pemberitahuan Sistem</b> 
                        </div>
                        <div class="card-body" id="ShowPemberitahuanSistem">
                            <!-- Menampilkan Pemberitahuan Sistem -->
                        </div>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-md-4">
                    <div class="card">
                        <div class="card-header">
                            <b class="card-title">
                                Anggota / <small class="text text-muted">5 Record terbaru</small>
                            </b>
                        </div>
                        <div class="card-body">
                            <div class="activity" id="ShowAnggotaTerbaru">
                                <!-- Menampilkan "ShowAnggotaTerbaru" -->
                            </div>
                        </div>
                        <div class="card-footer text-end">
                            <a href="index.php?Page=Anggota" 
                                class="btn btn-secondary btn-sm btn-floating" 
                                data-bs-toggle="tooltip" 
                                data-bs-placement="top" 
                                data-bs-custom-class="custom-tooltip" 
                                data-bs-title="Lihat Selengkapnya Di Halaman Anggota" >
                                <i class="bi bi-chevron-right"></i>
                            </a>
                        </div>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="card">
                        <div class="card-header">
                            <b class="card-title">
                                Simpanan / <small class="text text-muted">5 Record terbaru</small>
                            </b>
                        </div>
                        <div class="card-body">
                            <div class="activity" id="ShowSimpananTerbaru">
                                <!-- Menampilkan "ShowSimpananTerbaru"  -->
                            </div>
                        </div>
                        <div class="card-footer text-end">
                            <a href="index.php?Page=Tabungan" 
                                class="btn btn-secondary btn-sm btn-floating" 
                                data-bs-toggle="tooltip" 
                                data-bs-placement="top" 
                                data-bs-custom-class="custom-tooltip" 
                                data-bs-title="Lihat Selengkapnya Di Halaman Simpanan" >
                                <i class="bi bi-chevron-right"></i>
                            </a>
                        </div>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="card">
                        <div class="card-header">
                            <b class="card-title">
                                Pinjaman / <small class="text text-muted">5 Record terbaru</small>
                            </b>
                        </div>
                        <div class="card-body">
                            <div class="activity" id="ShowPinjamanTerbaru">
                                <!-- Menampilkan Pinjaman Terbaru -->
                            </div>
                        </div>
                        <div class="card-footer text-end">
                            <a href="index.php?Page=Pinjaman" 
                                class="btn btn-secondary btn-sm btn-floating" 
                                data-bs-toggle="tooltip" 
                                data-bs-placement="top" 
                                data-bs-custom-class="custom-tooltip" 
                                data-bs-title="Lihat Selengkapnya Di Halaman Pinjaman" >
                                <i class="bi bi-chevron-right"></i>
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

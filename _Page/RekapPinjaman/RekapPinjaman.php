<?php
    //Cek Aksesibilitas ke halaman ini
    $IjinAksesSaya=IjinAksesSaya($Conn,$SessionIdAkses,'hAhdWGrGGtjeMqhAAtD');
    if($IjinAksesSaya!=="Ada"){
        include "_Page/Error/NoAccess.php";
    }else{
?>
    <div class="pagetitle">
        <h1>
            <a href="">
                <i class="bi bi-table"></i> Rekap Pinjaman</a>
            </a>
        </h1>
        <nav>
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="index.php">Dashboard</a></li>
                <li class="breadcrumb-item active"> Rekap Pinjaman</li>
            </ol>
        </nav>
    </div>
    <section class="section dashboard">
        <div class="row">
            <div class="col-md-12">
                <?php
                    echo '<div class="alert alert-warning alert-dismissible fade show" role="alert">';
                    echo '  Berikut ini halaman rekapitulasi pinjaman anggota.';
                    echo '  Gunakan "Filter" untuk menentukan periode tahun data.';
                    echo '  <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>';
                    echo '</div>';
                ?>
            </div>
        </div>
        <div class="row">
            <div class="col-lg-12">
                <div class="card">
                    <div class="card-header">
                        <div class="row">
                            <div class="col-md-10">
                                <b class="card-title"># Rekap Pinjaman</b>
                            </div>
                            <div class="col-md-2 mb-3">
                                <a class="btn btn-md btn-outline-dark btn-rounded btn-block" href="javascript:void(0);" data-bs-toggle="modal" data-bs-target="#ModalRekapTahunan">
                                    <i class="bi bi-filter"></i> Periode Data
                                </a>
                            </div>
                        </div>
                    </div>
                    <div class="card-body" id="MenampilkanTabelPinjamanPeriode">
                        <div class="row">
                            <div class="col-md-12">
                                <div class="alert alert-primary text-center">
                                    <small>
                                        Silahkan Gunakan tombol 'Periode Data' di atas untuk mulai menampilkan rekapitulasi data.
                                    </small>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="card-footer">
                        <button type="button" disabled class="btn btn-sm btn-outline-secondary btn-floating" id="ShowRekapTahunan">
                            <i class="bi bi-chevron-down"></i>
                        </button>
                    </div>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-lg-12">
                <div class="card">
                    <div class="card-header">
                        <div class="row">
                            <div class="col-md-10">
                                <b class="card-title"># Rekap Pinjaman Unit/Divisi</b>
                            </div>
                            <div class="col-md-2 mb-3">
                                <a class="btn btn-md btn-outline-dark btn-rounded btn-block" href="javascript:void(0);" data-bs-toggle="modal" data-bs-target="#ModalRekapUnitDivisi">
                                    <i class="bi bi-calendar"></i> Periode Data
                                </a>
                            </div>
                        </div>
                    </div>
                    <div class="card-body" id="MenampilkanTabelPinjamanUnitDivisi">
                        <div class="row">
                            <div class="col-md-12">
                                <div class="alert alert-primary text-center">
                                    <small>
                                        Silahkan Gunakan tombol 'Periode Data' di atas untuk mulai menampilkan rekapitulasi data.
                                    </small>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="card-footer">
                        <button type="button" disabled class="btn btn-sm btn-outline-secondary btn-floating" id="ShowRekapUnitDivisi">
                            <i class="bi bi-chevron-down"></i>
                        </button>
                    </div>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-lg-12">
                <div class="card">
                    <div class="card-header">
                        <div class="row">
                            <div class="col-md-10 text-center text-md-center text-lg-start mb-2 mt-2">
                                <b class="card-title"># Rekap Pinjaman Anggota</b>
                            </div>
                            <div class="col-md-2 text-center text-md-center text-lg-start mb-2 mt-2">
                                <a class="btn btn-md btn-outline-dark btn-rounded btn-block" href="javascript:void(0);" data-bs-toggle="modal" data-bs-target="#ModalRekapPinjamanAnggota">
                                    <i class="bi bi-calendar"></i> Periode Data
                                </a>
                            </div>
                        </div>
                    </div>
                    <div class="card-body" id="MenampilkanRekapPinjamanAnggota">
                        <!-- Menampilkan Rekap Pinjaman Anggota -->
                        <div class="alert alert-primary text-center">
                            <small>
                                Silahkan pilih periode data pada tombol di atas untukmulai  menampilkan data rekapitulasi pinjaman anggota.
                            </small>
                        </div>
                    </div>
                    <div class="card-footer">
                        <button type="button" disabled class="btn btn-sm btn-outline-secondary btn-floating" id="ShowRekapPinjamanAnggota">
                            <i class="bi bi-chevron-down"></i>
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </section>
<?php } ?>
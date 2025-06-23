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
            <?php
                echo '<div class="alert alert-warning alert-dismissible fade show" role="alert">';
                echo '  <small>';
                echo '      Berikut ini halaman data tagihan pinjaman anggota.';
                echo '      Data yang ditampilkan adalah data pinjaman yang masih berjalan.';
                echo '      Sistem akan melakukan filter dan perhitungan jumlah angsuran yang belum dibayar.';
                echo '      Lihat masing-masing detail data untukk mengetahui rincian tunggakan.';
                echo '      <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>';
                echo '  </small>';
                echo '</div>';
            ?>
        </div>
    </div>
    <div class="row">
        <div class="col-lg-12">
            <div class="card">
                <div class="card-header">
                    <form action="javascript:void(0);" id="ProsesBatas">
                        <div class="row">
                            <div class="col-md-12 mb-3 text-end">
                                <a class="btn btn-md btn-secondary btn-floating" href="javascript:void(0);" data-bs-toggle="modal" data-bs-target="#ModalFilter">
                                    <i class="bi bi-search"></i>
                                </a>
                                <!-- <a class="btn btn-md btn-info btn-floating" href="javascript:void(0);" data-bs-toggle="modal" data-bs-target="#ModalExportTagihan">
                                    <i class="bi bi-cloud-arrow-down"></i> 
                                </a> -->
                                <a class="btn btn-md btn-primary btn-floating" href="javascript:void(0);" data-bs-toggle="modal" data-bs-target="#ModalBayarTagihanAngsuran">
                                    <i class="bi bi-plus"></i>
                                </a>
                            </div>
                        </div>
                    </form>
                </div>
                <div class="card-body" id="MenampilkanTabelTagihan">

                </div>
            </div>
        </div>
    </div>
</section>

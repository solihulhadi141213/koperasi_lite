<div class="pagetitle">
    <h1>
        <a href="">
            <i class="bi bi-wallet"></i> Simpanan & Penarikan</a>
        </a>
    </h1>
    <nav>
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="index.php">Dashboard</a></li>
            <li class="breadcrumb-item active"> Simpanan & Penarikan</li>
        </ol>
    </nav>
</div>
<section class="section dashboard">
    <div class="row">
        <div class="col-md-12">
            <?php
                echo '<div class="alert alert-warning alert-dismissible fade show" role="alert">';
                echo '  <small>';
                echo '      Berikut ini adalah halaman simpanan anggota yang menampilkan semua jenis simpanan secara parsial. ';
                echo '      Halaman ini menampilkan semua riwayat simpanan anggota secara spesifik dan anda bisa menambahkan data simpanan dan penarikan dana pada halaman ini.';
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
                    <div class="row">
                        <div class="col-md-12 mb-3 text-end">
                            <button type="button" class="btn btn-md btn-info btn-floating" data-bs-toggle="modal" data-bs-target="#ModalFilter" title="Filter">
                                <i class="bi bi-search"></i>
                            </button>
                            <button type="button" class="btn btn-md btn-primary btn-floating" data-bs-toggle="modal" data-bs-target="#ModalPilihAnggota" title="Tambah Data Simpanan">
                                <i class="bi bi-plus-lg"></i>
                            </button>
                        </div>
                    </div>
                </div>
                <div class="card-body" id="MenampilkanTabelTabungan">

                </div>
            </div>
        </div>
    </div>
</section>

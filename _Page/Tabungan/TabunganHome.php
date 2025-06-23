<?php
    //Cek Aksesibilitas ke halaman ini
    $IjinAksesSaya=IjinAksesSaya($Conn,$SessionIdAkses,'n77olEDwon5RO3RYQPD');
    if($IjinAksesSaya!=="Ada"){
        include "_Page/Error/NoAccess.php";
    }else{
?>
    <div class="pagetitle">
        <h1>
            <a href="">
                <i class="bi bi-wallet"></i> Log Simpanan & Penarikan</a>
            </a>
        </h1>
        <nav>
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="index.php">Dashboard</a></li>
                <li class="breadcrumb-item active"> Log Simpanan & Penarikan</li>
            </ol>
        </nav>
    </div>
    <section class="section dashboard">
        <div class="row">
            <div class="col-md-12">
                <?php
                    echo '<div class="alert alert-warning alert-dismissible fade show" role="alert">';
                    echo '  <small>';
                    echo '      Berikut ini adalah halaman log simpanan anggota yang menampilkan semua jenis simpanan secara parsial. ';
                    echo '      Halaman ini menampilkan semua riwayat simpanan anggota secara spesifik dan anda bisa menambahkan data simpanan non rutin pada halaman ini.';
                    echo '      Gunakan tombol <b>Filter</b> untuk mempermudah melakukan pencarian data.';
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
                            <div class="col-md-8 mb-3"></div>
                            <div class="col-md-2 mb-3">
                                <a class="btn btn-md btn-outline-dark btn-rounded btn-block" href="javascript:void(0);" data-bs-toggle="dropdown" aria-expanded="false">
                                    <i class="bi bi-three-dots"></i> Opsi Lanjutan
                                </a>
                                <ul class="dropdown-menu dropdown-menu-end dropdown-menu-arrow" style="">
                                    <li class="dropdown-header text-start">
                                        <h6>Option</h6>
                                    </li>
                                    <li>
                                        <a class="dropdown-item" href="javascript:void(0)" data-bs-toggle="modal" data-bs-target="#ModalFilter">
                                            <i class="bi bi-funnel"></i> Filter
                                        </a>
                                    </li>
                                    <li>
                                        <a class="dropdown-item" href="javascript:void(0)" data-bs-toggle="modal" data-bs-target="#ModalExport">
                                            <i class="bi bi-cloud-arrow-down"></i> Export
                                        </a>
                                    </li>
                                </ul>
                            </div>
                            <div class="col-md-2 mb-3">
                                <button type="button" class="btn btn-md btn-primary btn-block btn-rounded" data-bs-toggle="modal" data-bs-target="#ModalPilihAnggota" title="Tambah Data Simpanan">
                                    <i class="bi bi-plus-lg"></i> Tambah
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
<?php } ?>
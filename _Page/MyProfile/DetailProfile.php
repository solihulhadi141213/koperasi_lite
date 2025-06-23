<?php
    $strtotime1=strtotime($SessionDatetimeDaftar);
    $strtotime2=strtotime($SessionDatetimeUpdate);
    $SessionWaktuDaftarDatetime=date('d/m/Y H:i T',$strtotime1);
    $SessionWaktuUpdateDatetime=date('d/m/Y H:i T',$strtotime2);
?>
<div class="pagetitle">
    <h1>
        <a href="">
            <i class="bi bi-person-circle"></i> Profil Saya</a>
        </a>
    </h1>
    <nav>
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="index.php">Dashboard</a></li>
            <li class="breadcrumb-item active"> Profil Saya</li>
        </ol>
    </nav>
</div>
<section class="section dashboard">
    <div class="row mb-3">
        <div class="col-md-12">
            <?php
                echo '<div class="alert alert-warning alert-dismissible fade show" role="alert">';
                echo '  <small>';
                echo '      Berikut ini adalah halaman profil yang digunakan untuk mengelola informasi akses anda.';
                echo '      Pada halaman ini anda bisa melakukan perubahan data akses (Nama, Email, Password dan Foto Profile).';
                echo '      Pada bagian kolom izin akses menunjukan informasi fitur apa saja yang bisa anda gunakan pada aplikasi ini. ';
                echo '      <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>';
                echo '  </small>';
                echo '</div>';
            ?>
        </div>
    </div>
    <div class="row">
        <div class="col-md-4">
            <div class="card">
                <div class="card-header text-center">
                    <b class="card-title">
                        <i class="bi bi-info-circle"></i> Informasi Pengguna
                    </b>
                </div>
                <div class="card-body">
                    <div class="row mb-3 border-1 border-bottom">
                        <div class="col col-md-12 text-center mb-4">
                            <img src="assets/img/User/<?php echo "$SessionGambar"; ?>" alt="" width="70%" class="rounded-circle">
                        </div>
                    </div>
                    <div class="row mb-3">
                        <div class="col col-md-12">
                            <ul class="list-group">
                                <li class="list-group-item">
                                    <a href="javascript:void(0);" class="text-dark"  data-bs-toggle="modal" data-bs-target="#ModalUbahIdentitasProfil">
                                        <i class="bi bi-pencil me-1 text-primary"></i> 
                                        <small class="credit">Ubah Identitias</small>
                                    </a>
                                </li>
                                <li class="list-group-item">
                                    <a href="javascript:void(0);" class="text-dark" data-bs-toggle="modal" data-bs-target="#ModalUbahFotoProfil">
                                        <i class="bi bi-image me-1 text-primary"></i> 
                                        <small class="credit">Ubah Foto Profil</small>
                                    </a>
                                </li>
                                <li class="list-group-item">
                                    <a href="javascript:void(0);" class="text-dark" data-bs-toggle="modal" data-bs-target="#ModalUbahPasswordProfil">
                                        <i class="bi bi-key me-1 text-primary"></i> 
                                        <small class="credit">Ubah Password</small>
                                    </a>
                                </li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">
                    <b class="card-title">
                        <i class="bi bi-info-circle"></i> Informasi Pengguna
                    </b>
                </div>
                <div class="card-body">
                    <div class="row mb-3">
                        <div class="col col-md-6">
                            Nama
                        </div>
                        <div class="col col-md-6">
                            <small class="credit">
                                <code class="text text-grayish"><?php echo "$SessionNama"; ?></code>
                            </small>
                        </div>
                    </div>
                    <div class="row mb-3">
                        <div class="col col-md-6">Kontak</div>
                        <div class="col col-md-6">
                            <small class="credit">
                                <code class="text text-grayish"><?php echo "$SessionKontakAkses"; ?></code>
                            </small>
                        </div>
                    </div>
                    <div class="row mb-3">
                        <div class="col col-md-6">Email</div>
                        <div class="col col-md-6">
                            <small class="credit">
                                <code class="text text-grayish"><?php echo "$SessionEmailAkses"; ?></code>
                            </small>
                        </div>
                    </div>
                    <div class="row mb-3">
                        <div class="col col-md-6">Level</div>
                        <div class="col col-md-6">
                            <small class="credit">
                                <code class="text text-grayish"><?php echo "$SessionLevelAkses"; ?></code>
                            </small>
                        </div>
                    </div>
                    <div class="row mb-3">
                        <div class="col col-md-6">Daftar</div>
                        <div class="col col-md-6">
                            <small class="credit">
                                <code class="text text-grayish"><?php echo "$SessionWaktuDaftarDatetime"; ?></code>
                            </small>
                        </div>
                    </div>
                    <div class="row mb-3">
                        <div class="col col-md-6 mb-3">Update</div>
                        <div class="col col-md-6 mb-3">
                            <small class="credit">
                                <code class="text text-grayish"><?php echo "$SessionWaktuUpdateDatetime"; ?></code>
                            </small>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

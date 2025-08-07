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
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">
                    <div class="row">
                        <div class="col-8">
                            <b class="card-title">
                                <i class="bi bi-info-circle"></i> Informasi Pengguna
                            </b>
                        </div>
                        <div class="col-4 text-end">
                            <button type="button" class="btn btn-sm btn-outline-dark btn-floating"  data-bs-toggle="dropdown" aria-expanded="false">
                                <i class="bi bi-three-dots"></i>
                            </button>
                            <ul class="dropdown-menu dropdown-menu-end dropdown-menu-arrow" style="">
                                <li class="dropdown-header text-start">
                                    <h6>Option</h6>
                                </li>
                                <li>
                                    <a class="dropdown-item" href="javascript:void(0)" data-bs-toggle="modal" data-bs-target="#ModalUbahIdentitasProfil">
                                        <i class="bi bi-pencil"></i> Edit Profile
                                    </a>
                                </li>
                                <li>
                                    <a class="dropdown-item" href="javascript:void(0)" data-bs-toggle="modal" data-bs-target="#ModalUbahFotoProfil">
                                        <i class="bi bi-image-alt"></i> Ubah Foto Profil
                                    </a>
                                </li>
                                <li>
                                    <a class="dropdown-item" href="javascript:void(0)" data-bs-toggle="modal" data-bs-target="#ModalUbahPasswordProfil">
                                        <i class="bi bi-key"></i> Ubah Password
                                    </a>
                                </li>
                            </ul>
                        </div>
                    </div>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-3 mb-3 text-center">
                            <img src="<?php echo 'image_proxy.php?dir=User&filename='.$SessionGambar.''; ?>" alt="" width="70%" class="rounded-circle">
                        </div>
                        <div class="col-md-9 mb-3">
                            <div class="row mb-2">
                                <div class="col-5 mb-2">
                                    <small class="credit">Nama Lengkap</small>
                                </div>
                                <div class="col-1 mb-2">
                                    <small class="credit">:</small>
                                </div>
                                <div class="col-6 mb-2">
                                    <small class="text-grayish">
                                        <?php echo "$SessionNama"; ?>
                                    </small>
                                </div>
                            </div>
                            <div class="row mb-2">
                                <div class="col-5 mb-2">
                                    <small class="credit">Nomor Kontak</small>
                                </div>
                                <div class="col-1 mb-2">
                                    <small class="credit">:</small>
                                </div>
                                <div class="col-6 mb-2">
                                    <small class="text-grayish">
                                        <?php echo "$SessionKontakAkses"; ?>
                                    </small>
                                </div>
                            </div>
                            <div class="row mb-2">
                                <div class="col-5 mb-2">
                                    <small class="credit">Alamat Email</small>
                                </div>
                                <div class="col-1 mb-2">
                                    <small class="credit">:</small>
                                </div>
                                <div class="col-6 mb-2">
                                    <small class="text-grayish">
                                        <?php echo "$SessionEmailAkses"; ?>
                                    </small>
                                </div>
                            </div>
                            <?php
                                if($SessionModeAkses=="Pengurus"){
                                    echo '
                                        <div class="row mb-2">
                                            <div class="col-5 mb-2">
                                                <small class="credit">Level Akses</small>
                                            </div>
                                            <div class="col-1 mb-2">
                                                <small class="credit">:</small>
                                            </div>
                                            <div class="col-6 mb-2">
                                                <small class="text-grayish">'.$SessionLevelAkses.'</small>
                                            </div>
                                        </div>
                                        <div class="row mb-2">
                                            <div class="col-5 mb-2">
                                                <small class="credit">Tanggal Daftar</small>
                                            </div>
                                            <div class="col-1 mb-2">
                                                <small class="credit">:</small>
                                            </div>
                                            <div class="col-6 mb-2">
                                                <small class="text-grayish">'.$SessionDatetimeDaftar.'</small>
                                            </div>
                                        </div>
                                        <div class="row mb-2">
                                            <div class="col-5 mb-2">
                                                <small class="credit">Update Terakhir</small>
                                            </div>
                                            <div class="col-1 mb-2">
                                                <small class="credit">:</small>
                                            </div>
                                            <div class="col-6 mb-2">
                                                <small class="text-grayish">'.$SessionDatetimeUpdate.'</small>
                                            </div>
                                        </div>
                                    ';
                                }else{
                                    echo '
                                        <div class="row mb-2">
                                            <div class="col-5 mb-2">
                                                <small class="credit">Level Akses</small>
                                            </div>
                                            <div class="col-1 mb-2">
                                                <small class="credit">:</small>
                                            </div>
                                            <div class="col-6 mb-2">
                                                <small class="text-grayish">'.$SessionModeAkses.'</small>
                                            </div>
                                        </div>
                                        <div class="row mb-2">
                                            <div class="col-5 mb-2">
                                                <small class="credit">Tanggal Daftar</small>
                                            </div>
                                            <div class="col-1 mb-2">
                                                <small class="credit">:</small>
                                            </div>
                                            <div class="col-6 mb-2">
                                                <small class="text-grayish">'.$SessionDatetimeDaftar.'</small>
                                            </div>
                                        </div>
                                    ';
                                    if($SessionStatusAnggota=="Keluar"){
                                        echo '
                                            <div class="row mb-2">
                                                <div class="col-5 mb-2">
                                                    <small class="credit">Tanggal Keluar</small>
                                                </div>
                                                <div class="col-1 mb-2">
                                                    <small class="credit">:</small>
                                                </div>
                                                <div class="col-6 mb-2">
                                                    <small class="text-grayish">'.$SessionDatetimeUpdate.'</small>
                                                </div>
                                            </div>
                                            <div class="row mb-2">
                                                <div class="col-5 mb-2">
                                                    <small class="credit">Alasan Keluar</small>
                                                </div>
                                                <div class="col-1 mb-2">
                                                    <small class="credit">:</small>
                                                </div>
                                                <div class="col-6 mb-2">
                                                    <small class="text-grayish">'.$SessionAlasanKeluar.'</small>
                                                </div>
                                            </div>
                                        ';
                                    }
                                }
                            ?>
                            
                            
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

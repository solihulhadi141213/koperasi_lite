<div class="pagetitle">
        <h1>
            <a href="">
                <i class="bi bi-bank"></i> Pinjaman</a>
            </a>
        </h1>
        <nav>
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="index.php">Dashboard</a></li>
                <li class="breadcrumb-item active"> Pinjaman</li>
            </ol>
        </nav>
    </div>
<section class="section dashboard">
    <?php
        if(empty($SessionIdAkses)){
            echo '<div class="row mb-3">';
            echo '  <div class="col-md-12">';
            echo '      <div class="alert alert-danger alert-dismissible fade show" role="alert">';
            echo '          Sesi Akses Sudah Berakhir, Silahkan Login Ulang Terlebih Dulu.';
            echo '          <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>';
            echo '      </div>';
            echo '  </div>';
            echo '</div>';
        }else{
            //Tangkap id_pinjaman
            if(empty($_GET['id'])){
                echo '<div class="row mb-3">';
                echo '  <div class="col-md-12">';
                echo '      <div class="alert alert-danger alert-dismissible fade show" role="alert">';
                echo '          ID Pinjaman Tidak Boleh Kosong.';
                echo '          <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>';
                echo '      </div>';
                echo '  </div>';
                echo '</div>';
            }else{
                $id_pinjaman=$_GET['id'];
                //Bersihkan Variabel
                $id_pinjaman=validateAndSanitizeInput($id_pinjaman);
                $id_anggota=GetDetailData($Conn,'pinjaman','id_pinjaman',$id_pinjaman,'id_anggota');
                if(empty($id_anggota)){
                    echo '<div class="row mb-3">';
                    echo '  <div class="col-md-12">';
                    echo '      <div class="alert alert-danger alert-dismissible fade show" role="alert">';
                    echo '          ID Pinjaman Tidak Valid Atau Tidak Ditemukan Pada Database.';
                    echo '          <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>';
                    echo '      </div>';
                    echo '  </div>';
                    echo '</div>';
                }else{
    ?>
        <input type="hidden" id="GetIdPinjaman" value="<?php echo $id_pinjaman; ?>">
        <div class="row mb-3">
            <div class="col-md-12">
                <?php
                    echo '<div class="alert alert-warning alert-dismissible fade show" role="alert">';
                    echo '  <small>';
                    echo '      Berikut adalah halaman detail pinjaman. Gunakan navigasi pada Tab Card yang ada pada halaman untuk berganti tampilan.';
                    echo '      Pada halaman ini anda bisa mengelola data angsuran dan pembukuan jurnal transaksi yang terhubung.';
                    echo '      <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>';
                    echo '  </small>';
                    echo '</div>';
                ?>
            </div>
        </div>
        <div class="row mb-3">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header">
                        <div class="row">
                            <div class="col-md-10 mb-3">
                                <b class="card-title">
                                    <i class="bi bi-info-circle"></i> Detail Pinjaman
                                </b>
                            </div>
                            <div class="col-md-2 mb-3">
                                <a href="index.php?Page=Pinjaman" class="btn btn-md btn-block btn-dark btn-rounded">
                                    <i class="bi bi-chevron-left"></i> Kembali
                                </a>
                            </div>
                        </div>
                    </div>
                    <div class="card-body" id="MenampilkanDetailPinjaman">
                        
                    </div>
                </div>
            </div>
        </div>
        <div class="row mb-3">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-12 mb-3">
                                <ul class="nav nav-tabs nav-tabs-bordered d-flex" id="borderedTabJustified" role="tablist">
                                    <li class="nav-item flex-fill" role="presentation">
                                        <button class="nav-link w-100 active" id="home-tab" data-bs-toggle="tab" data-bs-target="#bordered-justified-home" type="button" role="tab" aria-controls="home" aria-selected="true">
                                            Angsuran
                                        </button>
                                    </li>
                                    <li class="nav-item flex-fill" role="presentation">
                                        <button class="nav-link w-100" id="profile-tab" data-bs-toggle="tab" data-bs-target="#bordered-justified-profile" type="button" role="tab" aria-controls="profile" aria-selected="false" tabindex="-1">
                                            Jurnal
                                        </button>
                                    </li>
                                </ul>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-12 mb-3">
                                <div class="tab-content pt-2" id="borderedTabJustifiedContent">
                                    <div class="tab-pane fade active show" id="bordered-justified-home" role="tabpanel" aria-labelledby="home-tab">
                                        <div class="row">
                                            <div class="col-md-12" id="MenampilkanAngsuranPinjaman">
                                                <!-- Menampilkan Angsuran Disini -->
                                            </div>
                                        </div>
                                    </div>
                                    <div class="tab-pane fade" id="bordered-justified-profile" role="tabpanel" aria-labelledby="profile-tab">
                                        <div class="row">
                                            <div class="col-md-12" id="MenampilkanJurnalPinjaman">
                                                <!-- Menampilkan Jurnal Disini -->
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    <?php
                }
            }
        }
    ?>
</section>
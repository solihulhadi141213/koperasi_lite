<div class="pagetitle">
    <h1>
        <a href="">
            <i class="bi bi-wallet"></i> Log Simpanan</a>
        </a>
    </h1>
    <nav>
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="index.php">Dashboard</a></li>
            <li class="breadcrumb-item active"> Log Simpanan</li>
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
            //Tangkap id_simpanan
            if(empty($_GET['id'])){
                echo '<div class="row mb-3">';
                echo '  <div class="col-md-12">';
                echo '      <div class="alert alert-danger alert-dismissible fade show" role="alert">';
                echo '          ID Simpanan Tidak Boleh Kosong.';
                echo '          <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>';
                echo '      </div>';
                echo '  </div>';
                echo '</div>';
            }else{
                $id_simpanan=$_GET['id'];
                //Bersihkan Variabel
                $id_simpanan=validateAndSanitizeInput($id_simpanan);
                $id_anggota=GetDetailData($Conn,'simpanan','id_simpanan',$id_simpanan,'id_anggota');
                if(empty($id_anggota)){
                    echo '<div class="row mb-3">';
                    echo '  <div class="col-md-12">';
                    echo '      <div class="alert alert-danger alert-dismissible fade show" role="alert">';
                    echo '          ID Simpanan Tidak Valid Atau Tidak Ditemukan Pada Database.';
                    echo '          <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>';
                    echo '      </div>';
                    echo '  </div>';
                    echo '</div>';
                }else{
    ?>
        <input type="hidden" id="GetIdSimpanan" value="<?php echo $id_simpanan; ?>">
        <div class="row mb-3">
            <div class="col-md-12">
                <?php
                    echo '<div class="alert alert-warning alert-dismissible fade show" role="alert">';
                    echo '  <small>';
                    echo '      Berikut adalah halaman detail simpanan. Gunakan navigasi pada Tab Card yang ada pada halaman untuk berganti tampilan.';
                    echo '      Pada halaman ini anda bisa mengelola data uraian simpanan dan jurnal keuangan yang terhubung.';
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
                            <div class="col-md-8 mb-3">
                                <b class="card-title">
                                    <i class="bi bi-info-circle"></i> Detail Simpanan
                                </b>
                            </div>
                            <div class="col-md-2 mb-3">
                                <a href="index.php?Page=Tabungan" class="btn btn-md btn-block btn-dark btn-rounded">
                                    <i class="bi bi-chevron-left"></i> Kembali
                                </a>
                            </div>
                            <div class="col-md-2 mb-3">
                                <a href="javascript:void(0);" class="btn btn-md btn-block btn-outline-dark btn-rounded" data-bs-toggle="modal" data-bs-target="#ModalEditSimpanan" data-id="<?php echo "$id_simpanan"; ?>">
                                    <i class="bi bi-pencil"></i> Edit
                                </a>
                            </div>
                        </div>
                    </div>
                    <div class="card-body" id="MenampilkanDetailSimpanan">
                        
                    </div>
                </div>
            </div>
        </div>
        <div class="row mb-3">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header">
                        <div class="row">
                            <div class="col-md-10 mb-3">
                                <b class="card-title">
                                    <i class="bi bi-bookmark"></i>
                                    Jurnal Keuangan Simpanan Anggota
                                </b>
                            </div>
                            <div class="col-md-2 mb-3">
                                <a href="javascript:void(0);" class="btn btn-md btn-block btn-primary btn-rounded" data-bs-toggle="modal" data-bs-target="#ModalTambahJurnalSimpanan" data-id="<?php echo "$id_simpanan"; ?>">
                                    <i class="bi bi-plus"></i> Tambah
                                </a>
                            </div>
                        </div>
                    </div>
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-12 mb-3" id="MenampilkanJurnalSimpanan">
                                <!-- Jurnal Simpanan Akan Tampil Disini -->
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
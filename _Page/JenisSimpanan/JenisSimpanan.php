<?php
    //Cek Aksesibilitas ke halaman ini
    $IjinAksesSaya=IjinAksesSaya($Conn,$SessionIdAkses,'TruxAyhHOhvTrVYs6No');
    if($IjinAksesSaya!=="Ada"){
        include "_Page/Error/NoAccess.php";
    }else{
?>
    <div class="pagetitle">
        <h1>
            <a href="">
                <i class="bi bi-list-nested"></i> Jenis Simpanan</a>
            </a>
        </h1>
        <nav>
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="index.php">Dashboard</a></li>
                <li class="breadcrumb-item active"> Jenis Simpanan</li>
            </ol>
        </nav>
    </div>
    <section class="section dashboard">
        <div class="row">
            <div class="col-md-12">
                <?php
                    echo '<div class="alert alert-warning alert-dismissible fade show" role="alert">';
                    echo '  <small>';
                    echo '      Berikut ini adalah halaman untuk mengelola jenis simpanan.';
                    echo '      Anda bisa menambahkan data jenis simpanan secara dinamis, mengatur auto jurnal pada masing-masing jenis simpanan ';
                    echo '      dan menentukan apakah simapanan tersebut bersifat wajib atau sukarela.';
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
                            <div class="col-md-10 mb-3"></div>
                            <div class="col-md-2 mb-3">
                                <button type="button" class="btn btn-md btn-primary btn-block btn-rounded" data-bs-toggle="modal" data-bs-target="#ModalTambahJenisSimpanan" title="Tambah Jenis Simpanan">
                                    <i class="bi bi-plus-lg"></i> Tambah
                                </button>
                            </div>
                        </div>
                    </div>
                    <div class="card-body">
                        <div class="table table-responsive">
                            <table class="table table-hover table-striped">
                                <thead>
                                    <tr>
                                        <th><b>No</b></th>
                                        <th><b>Nama Simpanan</b></th>
                                        <th><b>Kategori</b></th>
                                        <th><b>Akun Debet</b></th>
                                        <th><b>Akun Kredit</b></th>
                                        <th><b>Nominal</b></th>
                                        <th><b>Opsi</b></th>
                                    </tr>
                                </thead>
                                <tbody  id="MenampilkanTabelJenisSimpanan">
                                    <!-- Data Jenis Simpanan Akan Ditampilkan Disini -->
                                </tbody>
                            </table>
                        </div>
                    </div>
                    <div class="card-footer">
                        <small>
                            * Keterangan : <small class="text text-muted">Menghapus data jenis simpanan akan menghapus data simpanan anggtoa. Gunakan fitur ini secara bijak.</small>
                        </small>
                    </div>
                </div>
            </div>
        </div>
    </section>
<?php } ?>
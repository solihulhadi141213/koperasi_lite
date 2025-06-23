<?php
    //Cek Aksesibilitas ke halaman ini
    $IjinAksesSaya=IjinAksesSaya($Conn,$SessionIdAkses,'0uITsO9Ci4O394dsIyu');
    if($IjinAksesSaya!=="Ada"){
        include "_Page/Error/NoAccess.php";
    }else{
        $queryJenisSimpanan = mysqli_query($Conn, "SELECT * FROM simpanan_jenis ORDER BY id_simpanan_jenis ASC");
        $JumlahSimpanan = mysqli_num_rows($queryJenisSimpanan);
?>
    <div class="pagetitle">
        <h1>
            <a href="">
                <i class="bi bi-table"></i> Rekap Simpanan</a>
            </a>
        </h1>
        <nav>
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="index.php">Dashboard</a></li>
                <li class="breadcrumb-item active"> Rekap Simpanan</li>
            </ol>
        </nav>
    </div>
    <section class="section dashboard">
        <div class="row">
            <div class="col-md-12">
                <?php
                    echo '<div class="alert alert-warning alert-dismissible fade show" role="alert">';
                    echo '  <small>';
                    echo '      Berikut ini adalah halaman untuk menampilkan data rekapitulasi simpanan anggota berdasarkan group lembaga dan rank.';
                    echo '      Gunakan tombol "Filter" untuk menentukan periode waktu dan mulai menampilkan data.';
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
                            <div class="col-md-10">
                                <b class="card-title"># Rekap Berdasarkan Unit/Divisi</b>
                            </div>
                            <div class="col-md-2 mb-3">
                                <a class="btn btn-md btn-outline-dark btn-rounded btn-block" href="javascript:void(0);" data-bs-toggle="modal" data-bs-target="#ModalFilter">
                                    <i class="bi bi-filter"></i> Filter
                                </a>
                            </div>
                        </div>
                    </div>
                    <div class="card-body" id="MenampilkanTabelRekapSimpanan">
                        <div class="row">
                            <div class="col-md-12 text-center">
                                <code>Silahkan Gunakan Tombol Filter Untuk Memulai Menampilkan Data Rekapitulasi</code>
                            </div>
                        </div>
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
                                <b class="card-title"># Rekap Berdasarkan Rank</b>
                            </div>
                            <div class="col-md-2 mb-3">
                                <a class="btn btn-md btn-outline-dark btn-rounded btn-block" href="javascript:void(0);" data-bs-toggle="modal" data-bs-target="#ModalFilterRank">
                                    <i class="bi bi-filter"></i> Filter
                                </a>
                            </div>
                        </div>
                    </div>
                    <div class="card-body" id="MenampilkanTabelRekapSimpananRank">
                        <div class="row">
                            <div class="col-md-12 text-center">
                                <code>Silahkan Gunakan Tombol Filter Untuk Memulai Menampilkan Data Rekapitulasi</code>
                            </div>
                        </div>
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
                                <b class="card-title"># Simpanan Bruto Berdasarkan Anggota</b>
                            </div>
                            <div class="col-md-2 mb-3">
                                <a class="btn btn-md btn-outline-dark btn-rounded btn-block" href="javascript:void(0);" data-bs-toggle="modal" data-bs-target="#ModalFilterAnggota">
                                    <i class="bi bi-filter"></i> Filter
                                </a>
                            </div>
                        </div>
                    </div>
                    <div class="card-body" id="MenampilkanTabelRekapSimpananAnggota">
                        <div class="row">
                            <div class="col-md-12 text-center">
                                <code>Silahkan Gunakan Tombol Filter Untuk Memulai Menampilkan Data Rekapitulasi</code>
                            </div>
                        </div>
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
                                <b class="card-title"># Simpanan Netto Anggota</b>
                            </div>
                            <div class="col-md-2 mb-3">
                                <a class="btn btn-md btn-outline-dark btn-rounded btn-block" href="javascript:void(0);" data-bs-toggle="modal" data-bs-target="#ModadlFilterSimpananNetto">
                                    <i class="bi bi-filter"></i> Filter
                                </a>
                            </div>
                        </div>
                    </div>
                    <div class="card-body">
                        <div class="row mb-3">
                            <div class="col-12" id="TitleRekapSimpananNetto">
                                <div class="alert alert-info">
                                    <small>
                                        <b>Keterangan :</b>
                                        Informasi jumlah nominal yang ditampilkan pada masing-masing jenis simpanan berikut
                                        merupakan jumlah simpanan yang sudah dikurangi dengan nominal penarikan.
                                    </small>
                                </div>
                            </div>
                        </div>
                        <div class="row mb-3">
                            <div class="col-md-12">
                                <div class="table table-responsive">
                                    <table class="table table-bordered table-striped table-hover">
                                        <thead>
                                            <tr>
                                                <td align="center" rowspan="2" valign="middle"><b>No</b></td>
                                                <td align="center" rowspan="2" valign="middle"><b>Anggota</b></td>
                                                <td align="center" colspan="<?php echo $JumlahSimpanan; ?>"><b>Simpanan</b></td>
                                                <td align="center" rowspan="2" valign="middle"><b>Saldo</b></td>
                                            </tr>
                                            <tr>
                                                <?php
                                                while ($dataJenis = mysqli_fetch_assoc($queryJenisSimpanan)) {
                                                    echo '<td align="center"><small class="credit"><b>' . $dataJenis['nama_simpanan'] . '</b></small></td>';
                                                }
                                                ?>
                                            </tr>
                                        </thead>
                                        <tbody id="TabelSimpananNetto">
                                            <tr>
                                                <td class="text-center" colspan="<?php echo $JumlahSimpanan+3;  ?>">
                                                    <small class="text-danger">
                                                        Belum Ada Data Yang Ditampilkan! Silahkan Gunakan Tombol Filter Untuk Mulai Menampilkan Data.
                                                    </small>
                                                </td>
                                            </tr>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="card-footer">
                        <div class="row">
                            <div class="col-6">
                                <small id="page_info_simpanan_netto">
                                    Page 1 Of 100
                                </small>
                            </div>
                            <div class="col-6 text-end">
                                <button type="button" class="btn btn-sm btn-outline-info btn-floating" id="prev_button_simpanan_netto">
                                    <i class="bi bi-chevron-left"></i>
                                </button>
                                <button type="button" class="btn btn-sm btn-outline-info btn-floating" id="next_button_simpanan_netto">
                                    <i class="bi bi-chevron-right"></i>
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
<?php } ?>
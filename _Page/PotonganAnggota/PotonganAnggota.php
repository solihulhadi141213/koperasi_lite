<?php
    //Cek Aksesibilitas ke halaman ini
    $IjinAksesSaya=IjinAksesSaya($Conn,$SessionIdAkses,'kCyHHVWW9k8DFPVshNm');
    if($IjinAksesSaya!=="Ada"){
        include "_Page/Error/NoAccess.php";
    }else{
        //Hitung Jumlah Jenis Simpanan
        $jumlah_jenis_pinjaman=mysqli_num_rows(mysqli_query($Conn, "SELECT*FROM pinjaman_jenis"));
        $colspan=$jumlah_jenis_pinjaman+5;
?>
    <div class="pagetitle">
        <h1>
            <a href="">
                <i class="bi bi-people"></i> Potongan Anggota</a>
            </a>
        </h1>
        <nav>
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="index.php">Dashboard</a></li>
                <li class="breadcrumb-item active">Potongan Anggota</li>
            </ol>
        </nav>
    </div>
    <section class="section dashboard">
        <div class="row">
            <div class="col-md-12">
                <?php
                    echo '<div class="alert alert-warning alert-dismissible fade show" role="alert">';
                    echo '  <small>';
                    echo '      Berikut ini adalah halaman untuk menampilkan potongan anggota yang berasal dari potongan/angsuran pinjaman. ';
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
                                <div class="col-9 mb-3">
                                    <b class="card-title"># Daftar Potongan Anggota</b><br>
                                    <small>Periode : <span id="put_periode_data" class="text text-muted"></span></small>
                                </div>
                                <div class="col-3 mb-3 text-end">
                                    <button type="button" class="btn btn-md btn-outline-secondary btn-floating" data-bs-toggle="modal" data-bs-target="#ModalDownload">
                                        <i class="bi bi-download"></i>
                                    </button>
                                    <button type="button" class="btn btn-md btn-secondary btn-floating" data-bs-toggle="modal" data-bs-target="#ModalFilter">
                                        <i class="bi bi-filter"></i>
                                    </button>
                                </div>
                            </div>
                        </form>
                    </div>
                    <div class="card-body">
                        <form action="javascript:void(0);" id="ProsesDetailMulti">
                            <input type="hidden" name="periode" id="put_periode" value="">
                            <div class="table table-responsive mb-3">
                                <table class="table table-bordered table-striped table-hover">
                                    <thead>
                                        <tr>
                                            <th valign="middle" rowspan="2">
                                                <input class="form-check-input" type="checkbox" id="check_all" name="check_all" value="pilih">
                                            </th>
                                            <th valign="middle" rowspan="2"><b>Nama Anggota</b></th>
                                            <th valign="middle" rowspan="2"><b>No.Induk</b></th>
                                            <th class="text-center" colspan="<?php echo "$jumlah_jenis_pinjaman"; ?>"><b>Potongan/Jenis Pinjaman</b></th>
                                            <th valign="middle" rowspan="2"><b>Pembelian</b></th>
                                            <th valign="middle" rowspan="2"><b>Jumlah Potongan</b></th>
                                        </tr>
                                        <tr>
                                            <?php
                                                $query = mysqli_query($Conn, "SELECT*FROM pinjaman_jenis ORDER BY id_pinjaman_jenis ASC");
                                                while ($data = mysqli_fetch_array($query)) {
                                                    $id_pinjaman_jenis= $data['id_pinjaman_jenis'];
                                                    $nama_pinjaman= $data['nama_pinjaman'];
                                                    echo '<td class="text-center"><b><small>'.$nama_pinjaman.'</small></b></td>';
                                                }
                                            ?>
                                        </tr>
                                    </thead>
                                    <tbody id="TabelPotonganAnggota">
                                        <tr>
                                            <td colspan="<?php echo $colspan; ?>" class="text text-center">
                                                <small class="text-danger">Tidak Ada Data Potongan Anggota Yang Ditampilkan</small>
                                            </td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                            <div class="row">
                                <div class="col-12">
                                    <button type="submit" class="btn btn-sm btn-outline-info" id="ButtonCetakMulti">
                                        <i class="bi bi-printer"></i> Preview
                                    </button>
                                </div>
                            </div>
                        </form>
                    </div>
                    <div class="card-footer">
                        <div class="row">
                            <div class="col-6">
                                <small id="page_info">
                                    Page 1 Of 100
                                </small>
                            </div>
                            <div class="col-6 text-end">
                                <button type="button" class="btn btn-sm btn-outline-info btn-floating" id="prev_button">
                                    <i class="bi bi-chevron-left"></i>
                                </button>
                                <button type="button" class="btn btn-sm btn-outline-info btn-floating" id="next_button">
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
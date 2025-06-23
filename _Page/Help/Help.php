<?php
    //Cek Aksesibilitas ke halaman ini
    $IjinAksesSaya=IjinAksesSaya($Conn,$SessionIdAkses,'5MH1cfu7LzOpalmhbT2');
    $IjinTambahDokumentasi=IjinAksesSaya($Conn,$SessionIdAkses,'QbQ4qF57AzCEp5qG0KG');
    if($IjinAksesSaya!=="Ada"){
        include "_Page/Error/NoAccess.php";
    }else{
?>
    <div class="pagetitle">
        <h1>
            <a href="">
                <i class="bi bi-question-circle"></i> Dokumentasi</a>
            </a>
        </h1>
        <nav>
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="index.php">Dashboard</a></li>
                <li class="breadcrumb-item active">Dokumentasi</li>
            </ol>
        </nav>
    </div>
    <section class="section dashboard">
        <div class="row">
            <div class="col-md-12">
                <?php
                    echo '<div class="alert alert-warning alert-dismissible fade show" role="alert">';
                    echo '  <small>';
                    echo '      Berikut ini adalah halaman untuk mencatat dokumentasi aplikasi.';
                    echo '      Halaman ini membantu pengembang dalam menyampaikan petunjuk penggunaan dan berbagai kendala yang mungkkin saja terjadi.';
                    echo '      Buat berbagai artikel yang berkaitan dengan cara penggunaan aplikasi sehingga membantu pengguna dalam memahami aplikasi lebih cepat.';
                    echo '      <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>';
                    echo '  </small>';
                    echo '</div>';
                ?>
            </div>
        </div>
        <div class="row" id="ShowData">
            <div class="col-lg-12">
                <div class="card mb-3">
                    <div class="card-header">
                        <div class="row mb-3">
                            <div class="col-9 mb-3 mt-3">
                                <b class="card-title">
                                    <i class="bi bi-file-earmark-text"></i> Daftar Dokumentasi
                                </b>
                            </div>
                            <div class="col-3 mb-3 mt-3 text-end">
                                <a href="javascript:void(0);" data-bs-toggle="modal" data-bs-target="#ModalFilter" class="btn btn-md btn-outline-secondary btn-floating">
                                    <i class="bi bi-search"></i>
                                </a>
                                <?php 
                                    //Apabila Memiliki Izin Untuk Tambah Dokumentasi
                                    if($IjinTambahDokumentasi=="Ada"){
                                        echo '
                                            <a href="javascript:void(0);" id="tambah_data_dokumentasi" class="btn btn-md btn-primary btn-floating">
                                                <i class="bi bi-plus"></i>
                                            </a>
                                        ';
                                    }
                                ?>
                            </div>
                        </div>
                    </div>
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-12">
                                <div class="table table-responsive">
                                    <table class="table table-hover table-striped">
                                        <thead>
                                            <tr>
                                                <th><b>No</b></th>
                                                <th><b>Judul Dokumentasi</b></th>
                                                <th><b>Kategori</b></th>
                                                <th><b>Update</b></th>
                                                <th><b>Author</b></th>
                                                <th><b>Opsi</b></th>
                                            </tr>
                                        </thead>
                                        <tbody id="TabelDokumentasi">
                                            <tr>
                                                <td colspan="6" class="text-center">
                                                    <small class="text-danger">Belum Ada Data Bantuan Yang Ditampilkan</small>
                                                </td>
                                            </tr>
                                            <!-- Menampilkan Tabel Help -->
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
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
                <div class="card">
                    <div class="card-header">
                        <b class="card-title"># Dokumentasi (Readme.md)</b>
                    </div>
                    <div class="card-body">
                        <div class="row mb-3">
                            <div class="col-12 text-center">
                                <button type="button" id="show_hide_documentation" class="btn btn-lg btn-rounded btn-outline-info">
                                    <i class="bi bi-eye"></i> Tampilkan Konten
                                </button>
                            </div>
                        </div>
                        <div class="row mb-3">
                            <div class="col-12" id="show_hide_readme">
                                <!-- Konten Readme Disini -->
                            </div>
                        </div>
                    </div>
                    <div class="card-footer">
                        <small class="text-muted">
                            Open By Readme.md
                        </small>
                    </div>
                </div>
            </div>
        </div>
        <div class="row" id="ShowDetail">
            <div class="col-lg-12">
                <div class="card mb-3">
                    <div class="card-header">
                        <div class="row mb-3">
                            <div class="col-9 mb-3 mt-3">
                                <b class="card-title" id="put_judul_dokumentasi">
                                    Judul Dokumentasi Disini
                                </b><br>
                                <small class="text text-muted">
                                    <i class="bi bi-tag"></i> <span id="put_kategori_dokumentasi">Kategori Dokumentasi</span>
                                </small>
                            </div>
                            <div class="col-3 mb-3 mt-3 text-end">
                                <a href="javascript:void(0);" class="btn btn-md btn-outline-dark btn-floating edit_dokumentasi" id="button_edit_dokumentasi" title="Edit Dokumentasi" data-id="">
                                    <i class="bi bi-pencil"></i>
                                </a>
                                <a href="javascript:void(0);" class="btn btn-md btn-dark btn-floating back_to_data" title="Kembali Ke Daftar Dokumentasi">
                                    <i class="bi bi-chevron-left"></i>
                                </a>
                            </div>
                        </div>
                    </div>
                    <div class="card-body" id="put_dokumentasi">
                        Isi Dokumentasi Ditampilkan disini
                    </div>
                    <div class="card-footer">
                        <div class="row">
                            <div class="col-6">
                                <small class="text text-muted" id="tanggal_dokumentasi">
                                    <i class="bi bi-calendar-check"></i> 02/02/2024
                                </small>
                            </div>
                            <div class="col-6 text-end">
                                <small class="text text-muted" id="author_dokumentasi">
                                    <i class="bi bi-person"></i> Solihul Hadi
                                </small>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="card">
                    <div class="card-header">
                        <b class="card-title">
                            <i class="bi bi-tags"></i>Artikel Lainnya
                        </b>
                    </div>
                    <div class="card-body" id="list_artikel_lainnya">
                        <!-- Menampilkan List Artikel Lainnya Yang Berkaitan -->
                         <ol>
                            <li>
                                <a href="javascript:void(0);" class="detail_dokumentasi" data-id="[id_help disini]">Judul Artikel 1</a>
                            </li>
                         </ol>
                    </div>
                </div>
            </div>
        </div>
        <div class="row" id="ShowTambahDokumentasi">
            <div class="col-lg-12">
                <form action="javascript:void(0);" id="ProsesTambahDokumentasi" autocomplete="off">
                    <div class="card">
                        <div class="card-header">
                            <div class="row mb-3">
                                <div class="col-10 mb-3 mt-3">
                                    <b class="card-title">
                                        <i class="bi bi-plus"></i> Tambah Dokumentasi
                                    </b>
                                </div>
                                <div class="col-2 mb-3 mt-3 text-end">
                                    <a href="javascript:void(0);" class="btn btn-md btn-dark btn-floating back_to_data" title="Kembali Ke Daftar Dokumentasi">
                                        <i class="bi bi-chevron-left"></i>
                                    </a>
                                </div>
                            </div>
                        </div>
                        <div class="card-body">
                            <div class="row mb-3">
                                <div class="col-md-12">
                                    <label for="judul">Judul</label>
                                    <input type="text" name="judul" id="judul" class="form-control" placeholder="Contoh : Cara Menambahkan Data Pengguna">
                                </div>
                            </div>
                            <div class="row mb-3">
                                <div class="col-md-12">
                                    <label for="kategori">Kategori</label>
                                    <input type="text" name="kategori" id="kategori" list="ListCategori" class="form-control">
                                    <datalist id="ListCategori">
                                        <?php
                                            //Tampilkan list categori help
                                            $QryKategori = mysqli_query($Conn, "SELECT DISTINCT kategori FROM help ORDER BY kategori ASC");
                                            while ($DataKategori = mysqli_fetch_array($QryKategori)) {
                                                $kategori_list=$DataKategori['kategori'];
                                                echo '<option value="'.$kategori_list.'">';
                                            }
                                        ?>
                                    </datalist>
                                </div>
                            </div>
                            <div class="row mb-3">
                                <div class="col-md-6 mb-3">
                                    <label for="author">Author</label>
                                    <input type="text" name="author" id="author" class="form-control" value="<?php echo "$SessionNama"; ?>">
                                </div>
                                <div class="col-md-6 mb-3">
                                    <label for="tanggal">Tanggal</label>
                                    <input type="date" name="tanggal" id="tanggal" class="form-control" value="<?php echo date('Y-m-d'); ?>">
                                </div>
                            </div>
                            <div class="row mb-3">
                                <div class="col-md-12">
                                    <label for="deskripsi">Isi Konten</label>
                                    <textarea name="deskripsi" id="deskripsi" cols="30" rows="3" class="form-control"></textarea>
                                </div>
                            </div>
                            
                            <div class="row mb-3">
                                <div class="col-md-12" id="NotifikasiTambahDokumentasi"></div>
                            </div>
                        </div>
                        <div class="card-footer">
                            <div class="row">
                                <div class="col-12">
                                    <button type="submit" class="btn btn-md btn-primary btn-rounded" id="ButtonTambahDokumentasi">
                                        <i class="bi bi-save"></i> Simpan Dokumentasi
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </div>
        <div class="row" id="ShowEditDokumentasi">
            <div class="col-lg-12">
                <form action="javascript:void(0);" id="ProsesEditDokumentasi">
                    <input type="hidden" name="id_help" id="put_id_help_edit">
                    <div class="card">
                        <div class="card-header">
                            <div class="row mb-3">
                                <div class="col-10 mb-3 mt-3">
                                    <b class="card-title">
                                        <i class="bi bi-pencil"></i> Edit Dokumentasi
                                    </b>
                                </div>
                                <div class="col-2 mb-3 mt-3 text-end">
                                    <a href="javascript:void(0);" class="btn btn-md btn-dark btn-floating back_to_data" title="Kembali Ke Daftar Dokumentasi">
                                        <i class="bi bi-chevron-left"></i>
                                    </a>
                                </div>
                            </div>
                        </div>
                        <div class="card-body">
                            <div class="row mb-3">
                                <div class="col-md-12">
                                    <label for="judul_edit">Judul</label>
                                    <input type="text" name="judul" id="judul_edit" class="form-control" placeholder="Contoh : Cara Menambahkan Data Pengguna">
                                </div>
                            </div>
                            <div class="row mb-3">
                                <div class="col-md-12">
                                    <label for="kategori_edit">Kategori</label>
                                    <input type="text" name="kategori" id="kategori_edit" list="ListCategori" class="form-control">
                                    <datalist id="ListCategori">
                                        <?php
                                            //Tampilkan list categori help
                                            $QryKategori = mysqli_query($Conn, "SELECT DISTINCT kategori FROM help ORDER BY kategori ASC");
                                            while ($DataKategori = mysqli_fetch_array($QryKategori)) {
                                                $kategori_list=$DataKategori['kategori'];
                                                echo '<option value="'.$kategori_list.'">';
                                            }
                                        ?>
                                    </datalist>
                                </div>
                            </div>
                            <div class="row mb-3">
                                <div class="col-md-6 mb-3">
                                    <label for="author_edit">Author</label>
                                    <input type="text" name="author" id="author_edit" class="form-control" value="<?php echo "$SessionNama"; ?>">
                                </div>
                                <div class="col-md-6 mb-3">
                                    <label for="tanggal_edit">Tanggal</label>
                                    <input type="date" name="tanggal" id="tanggal_edit" class="form-control" value="<?php echo date('Y-m-d'); ?>">
                                </div>
                            </div>
                            <div class="row mb-3">
                                <div class="col-md-12">
                                    <label for="deskripsi_edit">Isi Konten</label>
                                    <textarea name="deskripsi_edit" id="deskripsi_edit" cols="30" rows="3" class="form-control"></textarea>
                                </div>
                            </div>
                            
                            <div class="row mb-3">
                                <div class="col-md-12" id="NotifikasiEditDokumentasi"></div>
                            </div>
                        </div>
                        <div class="card-footer">
                            <div class="row">
                                <div class="col-12">
                                    <button type="submit" class="btn btn-md btn-primary btn-rounded" id="ButtonEditDokumentasi">
                                        <i class="bi bi-save"></i> Simpan Dokumentasi
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </section>
<?php } ?>
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
            <div class="alert alert-warning alert-dismissible fade show" role="alert">
                <small>
                    Berikut ini adalah halaman untuk mengelola jenis simpanan.
                    Anda bisa menambahkan data jenis simpanan secara dinamis dan menentukan apakah simapanan tersebut termasuk simpanan wajib, pokok atau sukarela.<br>
                    <ul>
                        <li>
                            <b>Simpanan Pokok : </b>
                            Simpanan wajib yang dibayarkan sekali oleh anggota saat pertama kali bergabung dengan koperasi.
                        </li>
                        <li>
                            <b>Simpanan Wajib : </b>
                            Simpanan yang harus dibayarkan secara rutin (misalnya bulanan) oleh anggota selama menjadi bagian dari koperasi.
                        </li>
                        <li>
                            <b>Simpanan Sukarela : </b> 
                            Simpanan yang disetor secara sukarela oleh anggota, mirip dengan tabungan di bank.
                        </li>
                    </ul>
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </small>
            </div>
        </div>
    </div>
    <div class="row mb-2">
        <div class="col-md-12">
            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                <small>
                    <b><i class="bi bi-exclamation-triangle"></i> Penting!</b> Menghapus data jenis simpanan akan menghapus data simpanan anggtoa. Gunakan fitur ini secara bijak.
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </small>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-lg-12">
            <div class="card">
                <div class="card-header">
                    <div class="row">
                        <div class="col-9">
                            <b class="card-title">Daftar Jenis Simpanan</b>
                        </div>
                        <div class="col-3 text-end">
                            <button type="button" class="btn btn-md btn-primary btn-floating" data-bs-toggle="modal" data-bs-target="#ModalTambahJenisSimpanan" title="Tambah Jenis Simpanan">
                                <i class="bi bi-plus-lg"></i>
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
                                    <th><b>Nama/Kode</b></th>
                                    <th><b>Kategori</b></th>
                                    <th><b>Nominal</b></th>
                                    <th><b>Netto</b></th>
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
                    
                </div>
            </div>
        </div>
    </div>
</section>
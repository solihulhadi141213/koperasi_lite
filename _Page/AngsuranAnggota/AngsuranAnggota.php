<div class="pagetitle">
    <h1>
        <a href="">
            <i class="bi bi-send-arrow-down"></i> Angsuran Anggota</a>
        </a>
    </h1>
    <nav>
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="index.php">Dashboard</a></li>
            <li class="breadcrumb-item active"> Angsuran Anggota</li>
        </ol>
    </nav>
</div>
<div class="row">
    <div class="col-md-12">
        <div class="alert alert-warning alert-dismissible fade show" role="alert">
            <small>
                Berikut ini adalah halaman angsuran anggota. 
                Anda bisa melakukan pembayaran angsuran sesuai pinjaman pada daftar yang tersedia.
                Pengurus akan melakukan verifikasi angsuran pinjaman anda.
            </small>
        </div>
    </div>
</div>
<section class="section dashboard">
    <div class="card">
        <div class="card-header">
            <div class="row">
                <div class="col-12">
                    <b class="card-title"># Angsuran Berjalan</b>
                </div>
            </div>
        </div>
        <div class="card-body">
            <?php
                //Periksa Apakah Anggota Memiliki Pinjaman Yang Berjalan
                $jumlah_pinjaman=mysqli_num_rows(mysqli_query($Conn, "SELECT id_pinjaman FROM pinjaman WHERE id_anggota='$SessionIdAkses' AND status='Berjalan'"));
                if(empty($jumlah_pinjaman)){
                    echo '
                        <div class="alert alert-danger">
                            <small>
                                Anda belum memiliki pinjaman yang berjalan pada saat ini. Silahkan ajukan pinjaman terlebih dulu.
                            </td>
                        </div>
                    ';
                }else{
                    //Cari Data Pinjaman Yang Lunas
                    $query_pinjaman = mysqli_query($Conn, "SELECT*FROM pinjaman WHERE id_anggota='$SessionIdAkses' AND status='Berjalan' LIMIT 1");
                    while ($data_pinjaman = mysqli_fetch_array($query_pinjaman)) {
                        $id_pinjaman=$data_pinjaman['id_pinjaman'];
                        $id_pinjaman_jenis=$data_pinjaman['id_pinjaman_jenis'];
                        $id_anggota=$data_pinjaman['id_anggota'];
                        $tanggal_pengajuan=$data_pinjaman['tanggal_pengajuan'];
                        $tanggal_pencairan=$data_pinjaman['tanggal_pencairan'];
                        $tanggal=$data_pinjaman['tanggal'];
                        $jumlah_pinjaman=$data_pinjaman['jumlah_pinjaman'];
                        $rp_jasa=$data_pinjaman['rp_jasa'];
                        $rp_denda=$data_pinjaman['rp_denda'];
                        $angsuran_pokok=$data_pinjaman['angsuran_pokok'];
                        $angsuran_total=$data_pinjaman['angsuran_total'];
                        $periode_angsuran=$data_pinjaman['periode_angsuran'];
                        $status=$data_pinjaman['status'];
                        
                        //Format Rupiah
                        $jumlah_pinjaman_format = "" . number_format($jumlah_pinjaman,0,',',',');

                        //Buka Data Jenis Pinjaman
                        $nama_pinjaman=GetDetailData($Conn,'pinjaman_jenis','id_pinjaman_jenis',$id_pinjaman_jenis,'nama_pinjaman');
                        $persen_jasa=GetDetailData($Conn,'pinjaman_jenis','id_pinjaman_jenis',$id_pinjaman_jenis,'persen_jasa');
                        $persen_denda=GetDetailData($Conn,'pinjaman_jenis','id_pinjaman_jenis',$id_pinjaman_jenis,'persen_denda');
                        echo '
                            <div class="row mb-3 border-1 border-bottom">
                                <div class="col-md-6 mb-3">
                                    <div class="row mb-2">
                                        <div class="col-4"><small>Nama Pinjaman</small></div>
                                        <div class="col-1"><small>:</small></div>
                                        <div class="col-7"><small><code class="text text-grayish">'.$nama_pinjaman.'</code></small></div>
                                    </div>
                                    <div class="row mb-2">
                                        <div class="col-4"><small>Tanggal Pinjaman</small></div>
                                        <div class="col-1"><small>:</small></div>
                                        <div class="col-7"><small><code class="text text-grayish">'.$tanggal.'</code></small></div>
                                    </div>
                                    <div class="row mb-2">
                                        <div class="col-4"><small>Jumlah Pinjaman</small></div>
                                        <div class="col-1"><small>:</small></div>
                                        <div class="col-7"><small><code class="text text-grayish">'.$jumlah_pinjaman_format.'</code></small></div>
                                    </div>
                                </div>
                                <div class="col-md-6 mb-3">
                                    <div class="row mb-2">
                                        <div class="col-4"><small>Jasa Pinjaman</small></div>
                                        <div class="col-1"><small>:</small></div>
                                        <div class="col-7"><small><code class="text text-grayish">'.$persen_jasa.' %</code></small></div>
                                    </div>
                                    <div class="row mb-2">
                                        <div class="col-4"><small>Denda</small></div>
                                        <div class="col-1"><small>:</small></div>
                                        <div class="col-7"><small><code class="text text-grayish">'.$persen_denda.' % / Hari</code></small></div>
                                    </div>
                                </div>
                            </div>
                        ';
                    }
                    echo '
                        <input type="hidden" id="get_id_pinjaman" value="'.$id_pinjaman.'">
                        <div class="table table-responsive">
                            <table class="table table-hover">
                                <thead>
                                    <tr>
                                        <th><b>No</b></th>
                                        <th><b>Periode</b></th>
                                        <th><b>Tgl.Bayar</b></th>
                                        <th><b>Terlambat</b></th>
                                        <th><b>Pokok</b></th>
                                        <th><b>Jasa</b></th>
                                        <th><b>Denda</b></th>
                                        <th><b>Angsuran</b></th>
                                        <th><b>Status</b></th>
                                        <th><b>Opsi</b></th>
                                    </tr>
                                </thead>
                                <tbody id="TabelPinjamanAnggota">
                                    <tr>
                                        <td colspan="10" class="text-center">
                                            <small class="text-danger">Belum Ada Data Pinjaman Yang Ditampilkan</small>
                                        </td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    ';
                }
            ?>
        </div>
    </div>
</section>
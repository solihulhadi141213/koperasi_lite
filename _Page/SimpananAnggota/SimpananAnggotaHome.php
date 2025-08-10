<div class="pagetitle">
    <h1>
        <a href="">
            <i class="bi bi-bank"></i> Simpanan Anggota</a>
        </a>
    </h1>
    <nav>
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="index.php">Dashboard</a></li>
            <li class="breadcrumb-item active"> Simpanan Anggota</li>
        </ol>
    </nav>
</div>
<div class="row">
    <div class="col-md-12">
        <div class="alert alert-warning alert-dismissible fade show" role="alert">
            <small>
                Berikut ini adalah halaman simpanan anggota. Berikut ini adalah jenis/kategori simpanan yang perlu anda ketahui.
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
            </small>
        </div>
    </div>
</div>
<section class="section dashboard">
    
    <!-- Simpanan Pokok -->
    <div class="row">
        <div class="col-md-12">
            <?php
                //Apakah Ada Simpanan Pokok
                $JumlahSimpananPokok = mysqli_num_rows(mysqli_query($Conn, "SELECT id_simpanan_jenis FROM simpanan_jenis WHERE kategori='Simpanan Pokok'"));
                if(!empty($JumlahSimpananPokok)){
            ?>
                <div class="card">
                    <div class="card-header">
                        <h3 class="card-title">Simpanan Pokok</h3>
                    </div>
                    <div class="card-body">
                        <?php
                            // Jika Ada Tampilkan Jenis Simpanan Pokok
                            $query_simpanan_pokok = mysqli_query($Conn, "SELECT * FROM simpanan_jenis WHERE kategori = 'Simpanan Pokok'");
                            if (!$query_simpanan_pokok) {
                                die("Error fetching simpanan pokok: " . mysqli_error($Conn));
                            }

                            while ($data_simpanan_pokok = mysqli_fetch_assoc($query_simpanan_pokok)) {
                                $id_simpanan_jenis = $data_simpanan_pokok['id_simpanan_jenis'];
                                $nama_simpanan = $data_simpanan_pokok['nama_simpanan'];
                                $nominal = $data_simpanan_pokok['nominal'];
                                $NominalRp = "Rp " . number_format($nominal,0,',','.');
                                $id_simpanan = null; // Inisialisasi variabel

                                // Periksa apakah anggota sudah membayar simpanan pokok
                                $status_lunas="Lunas";
                                $QrySimpananPokok = $Conn->prepare("SELECT id_simpanan, status FROM simpanan WHERE id_simpanan_jenis = ? AND id_anggota = ?");
                                if ($QrySimpananPokok === false) {
                                    die("Query preparation failed: " . $Conn->error);
                                }

                                // Bind parameter dan eksekusi
                                $QrySimpananPokok->bind_param("is", $id_simpanan_jenis, $SessionIdAkses);
                                if (!$QrySimpananPokok->execute()) {
                                    die("Query execution failed: " . $QrySimpananPokok->error);
                                }

                                $ResultSimpananPokok = $QrySimpananPokok->get_result();
                                $DataSimpananPokok = $ResultSimpananPokok->fetch_assoc();
                                
                                if ($ResultSimpananPokok->num_rows > 0) {
                                    $id_simpanan = $DataSimpananPokok['id_simpanan'];
                                    $status_simpanan = $DataSimpananPokok['status'];
                                    
                                    //Buka Detail Simpanan
                                    $uuid_simpanan=GetDetailData($Conn,'simpanan','id_simpanan',$id_simpanan,'uuid_simpanan');
                                    $jumlah=GetDetailData($Conn,'simpanan','id_simpanan',$id_simpanan,'jumlah');
                                    $metode_pembayaran=GetDetailData($Conn,'simpanan','id_simpanan',$id_simpanan,'metode_pembayaran');
                                    $jumlah_format = "Rp " . number_format($jumlah,0,',','.');

                                    //Label Status Bayar
                                    if($status_simpanan=="Pending"){
                                        $label_status='<span class="badge badge-danger">Pending</span>';
                                    }else{
                                        $label_status='<span class="badge badge-success">Lunas</span>';
                                    }

                                    //Tampilkan List
                                    echo '
                                        <div class="row mb-3 border-1 border-bottom">
                                            <div class="col-md-5 mb-2">
                                                <div class="row mb-2">
                                                    <div class="col-3"><small>ID Simpanan</small></div>
                                                    <div class="col-1"><small>:</small></div>
                                                    <div class="col-8"><small><code class="text text-grayish">'.$id_simpanan.'</code></small></div>
                                                </div>
                                                <div class="row mb-2">
                                                    <div class="col-3"><small>Kode/Nama</small></div>
                                                    <div class="col-1"><small>:</small></div>
                                                    <div class="col-8"><small><code class="text text-grayish">'.$nama_simpanan.'</code></small></div>
                                                </div>
                                                <div class="row mb-2">
                                                    <div class="col-3"><small>Nominal</small></div>
                                                    <div class="col-1"><small>:</small></div>
                                                    <div class="col-8"><small><code class="text text-grayish text-decoration-underline">'.$jumlah_format.'</code></small></div>
                                                </div>
                                            </div>
                                            <div class="col-md-5 mb-2">
                                                <div class="row mb-2">
                                                    <div class="col-3"><small>Metode Pembayaran</small></div>
                                                    <div class="col-1"><small>:</small></div>
                                                    <div class="col-8"><small><code class="text text-grayish">'.$metode_pembayaran.'</code></small></div>
                                                </div>
                                                <div class="row mb-2">
                                                    <div class="col-3"><small>Kode Pembayaran</small></div>
                                                    <div class="col-1"><small>:</small></div>
                                                    <div class="col-8"><small><code class="text text-grayish">'.$uuid_simpanan.'</code></small></div>
                                                </div>
                                                <div class="row mb-2">
                                                    <div class="col-3"><small>Status</small></div>
                                                    <div class="col-1"><small>:</small></div>
                                                    <div class="col-8"><small><code class="text text-grayish">'.$label_status.'</code></small></div>
                                                </div>
                                            </div>
                                            <div class="col-md-2 mb-2">
                                                <a href="index.php?Page=SimpananAnggota&Sub=DetailSimpananAnggota&uuid='.$uuid_simpanan.'" class="btn btn-md btn-secondary btn-block btn-rounded">
                                                    Lihat Detail
                                                </a>
                                            </div>
                                        </div>
                                    ';
                                }else{
                                    //Kondisi Simpanan Pokok Belum Dibayar
                                    echo '
                                        <div class="alert alert-danger">
                                            Anda belum membayar <b>'.$nama_simpanan.'</b> dengan jumlah nominal sebesar <b>'.$NominalRp.'</b>
                                            Silahkan lakukan pembayaran simpanan tersebut melalui tautan 
                                            <a href="javascript:void(0);" class="text text-decoration-underline" data-bs-toggle="modal" data-bs-target="#ModalBayarSimpanan" data-id_simpanan_jenis="'.$id_simpanan_jenis.'" data-id_anggota="'.$SessionIdAkses.'">
                                                <b>berikut ini</b>
                                            </a>.
                                        </div>
                                    ';
                                }

                                $QrySimpananPokok->close();
                            }
                        ?>
                    </div>
                </div>
            <?php } ?>
        </div>
    </div>

    <!-- Simpanan Wajib -->
    <div class="row">
        <div class="col-md-12">
            <?php
                //Apakah Ada Simpanan wajib
                $JumlahSimpananWajib = mysqli_num_rows(mysqli_query($Conn, "SELECT id_simpanan_jenis FROM simpanan_jenis WHERE kategori='Simpanan Wajib'"));
                if(!empty($JumlahSimpananWajib)){
            ?>
                <div class="card">
                    <div class="card-header">
                        <h3 class="card-title">Simpanan Wajib</h3>
                    </div>
                    <div class="card-body">
                        <?php
                            // Jika Ada Tampilkan Jenis Simpanan Wajib
                            $query_simpanan_wajib = mysqli_query($Conn, "SELECT * FROM simpanan_jenis WHERE kategori = 'Simpanan Wajib'");
                            if (!$query_simpanan_wajib) {
                                die("Error fetching simpanan wajib: " . mysqli_error($Conn));
                            }

                            while ($data_simpanan_wajib = mysqli_fetch_assoc($query_simpanan_wajib)) {
                                $id_simpanan_jenis = $data_simpanan_wajib['id_simpanan_jenis'];
                                $nama_simpanan = $data_simpanan_wajib['nama_simpanan'];
                                $nominal = $data_simpanan_wajib['nominal'];
                                $NominalRp = "Rp " . number_format($nominal,0,',','.');
                                echo '
                                    <div class="row mb-3 border-1 border-bottom">
                                        <div class="row mb-2">
                                            <div class="col-3"><small>ID Simpanan</small></div>
                                            <div class="col-1"><small>:</small></div>
                                            <div class="col-8"><small><code class="text text-grayish">'.$id_simpanan_jenis.'</code></small></div>
                                        </div>
                                        <div class="row mb-2">
                                            <div class="col-3"><small>Kode/Nama</small></div>
                                            <div class="col-1"><small>:</small></div>
                                            <div class="col-8"><small><code class="text text-grayish">'.$nama_simpanan.'</code></small></div>
                                        </div>
                                        <div class="row mb-2">
                                            <div class="col-3"><small>Nominal</small></div>
                                            <div class="col-1"><small>:</small></div>
                                            <div class="col-8"><small><code class="text text-grayish text-decoration-underline">'.$NominalRp.'</code></small></div>
                                        </div>
                                    </div>
                                    <form action="javascript:void(0);" id="FilterSimpananWajib">
                                        <input type="hidden" name="id_anggota" value="'.$SessionIdAkses.'">
                                        <input type="hidden" name="id_simpanan_jenis" value="'.$id_simpanan_jenis.'">
                                        <div class="row mb-3">
                                            <div class="col-9 mb-2">
                                                Berikut ini adalah daftar pembayaran simpanan wajib berdasarkan periode tahun
                                            </div>
                                            <div class="col-3 mb-2 text-center">
                                                <div class="input-group">
                                                    <button type="button" class="btn btn-md btn-primary" id="PeriodePrev">
                                                        <i class="bi bi-chevron-left"></i>
                                                    </button>
                                                    <input type="text" name="tahun" id="tahun_simpanan_wajib" class="form-control" value="'.date('Y').'">
                                                    <button type="button" class="btn btn-md btn-primary" id="PeriodeNext">
                                                        <i class="bi bi-chevron-right"></i>
                                                    </button>
                                                </div>
                                            </div>
                                        </div>
                                    </form>
                                    <div class="row mb-3">
                                        <div class="col-12 mb-2">
                                            <div class="table table-responsive">
                                                <table class="table table-striped table-hover">
                                                    <thead>
                                                        <tr>
                                                            <th><b>No</b></th>
                                                            <th><b>Periode</b></th>
                                                            <th><b>Tgl.Bayar</b></th>
                                                            <th><b>Metode</b></th>
                                                            <th><b>Nominal</b></th>
                                                            <th><b>Status</b></th>
                                                            <th><b>Opsi</b></th>
                                                        </tr>
                                                    </thead>
                                                    <tbody id="TabelSimpananWajib">
                                                        <tr>
                                                            <td colspan="7" class="text-center">
                                                                Tidak Ada Data Yang Ditampilkan
                                                            </td>
                                                        </tr>
                                                    </tbody>
                                                </table>
                                            </div>
                                        </div>
                                    </div>
                                ';
                            }
                        ?>
                    </div>
                </div>
            <?php } ?>
        </div>
    </div>

    <!-- Simpanan Suka Rela -->
    <div class="row">
        <div class="col-md-12">
            <?php
                //Apakah Ada Simpanan Suka Rela
                $JumlahSimpananSukaRela = mysqli_num_rows(mysqli_query($Conn, "SELECT id_simpanan_jenis FROM simpanan_jenis WHERE kategori='Simpanan Sukarela'"));
                if(!empty($JumlahSimpananSukaRela)){
            ?>
                <div class="card">
                    <div class="card-header">
                        <div class="row">
                            <div class="col-10">
                                <h3 class="card-title">Simpanan Sukarela</h3>
                            </div>
                             <div class="col-2">
                                <button type="button" class="btn btn-md btn-block btn-primary" data-bs-toggle="modal" data-bs-target="#ModalTambahSimpananSukarela">
                                    <i class="bi bi-plus"></i>Simpanan
                                </button>
                            </div>
                        </div>
                    </div>
                    <div class="card-body">
                        <div class="table table-responsive">
                            <table class="table table-striped table-hover">
                                <thead>
                                    <tr>
                                        <th><b>No</b></th>
                                        <th><b>Tanggal</b></th>
                                        <th><b>Simpanan</b></th>
                                        <th><b>Nominal</b></th>
                                        <th><b>Metode</b></th>
                                        <th><b>Status</b></th>
                                        <th><b>Opsi</b></th>
                                    </tr>
                                </thead>
                                <tbody id="TabelSimpananSukarela">
                                    <tr>
                                        <td colspan="7" class="text-center">
                                            Belum Ada Data Simpanan Yang Ditampilkan
                                        </td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            <?php } ?>
        </div>
    </div>
</section>
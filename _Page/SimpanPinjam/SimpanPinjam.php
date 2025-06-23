<?php
    //Cek Aksesibilitas ke halaman ini
    $IjinAksesSaya=IjinAksesSaya($Conn,$SessionIdAkses,'bKPVUZqfF6PCQk3ydzY');
    if($IjinAksesSaya!=="Ada"){
        include "_Page/Error/NoAccess.php";
    }else{
?>
    <div class="pagetitle">
        <h1>
            <a href="">
                <i class="bi bi-graph-down-arrow"></i> Simpanan Pinjam</a>
            </a>
        </h1>
        <nav>
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="index.php">Dashboard</a></li>
                <li class="breadcrumb-item active"> Simpanan Pinjam</li>
            </ol>
        </nav>
    </div>
    <section class="section dashboard">
        <div class="row">
            <div class="col-md-12">
                <?php
                    echo '<div class="alert alert-warning alert-dismissible fade show" role="alert">';
                    echo '  <small>';
                    echo '      Berikut ini adalah halaman laporan simpan pinjam.';
                    echo '      Laporan ini menampilkan akumulasi simpanan dan pinjaman anggota berdasarkan periode waktu.';
                    echo '      Untuk menampilkan laporan, silahkan isi filter lembaga dan periode waktu.';
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
                        <form action="javascript:void(0);" id="ProsesSimpanPinjam">
                            <div class="row">
                                <div class="col-md-3 mt-3">
                                    <select name="lembaga" id="lembaga" class="form-control">
                                            <?php
                                                echo '<option value="">Pilih</option>';
                                                // Query untuk mengambil lembaga
                                                $QryLembaga = mysqli_query($Conn, "SELECT DISTINCT lembaga FROM anggota");
                                                while ($DataLembaga = mysqli_fetch_array($QryLembaga)) {
                                                    $lembaga = $DataLembaga['lembaga'];
                                                    echo '<option value="'.$lembaga.'">'.$lembaga.'</option>';
                                                }
                                            ?>
                                    </select>
                                    <small>Divisi/Unit</small>
                                </div>
                                <div class="col-md-3 mt-3">
                                    <select name="periode" id="periode_form" class="form-control">
                                        <option value="">Pilih</option>
                                        <option value="Bulan">Bulan</option>
                                        <option value="Tahun">Tahun</option>
                                    </select>
                                    <small>Periode</small>
                                </div>
                                <div class="col-md-2 mt-3">
                                    <input type="text" name="tahun" id="tahun" class="form-control" value="<?php echo date('Y'); ?>" onkeypress="return hanyaAngka(event)" maxlength="4">
                                    <small>Periode Tahun</small>
                                </div>
                                <div class="col-md-2 mt-3">
                                    <select name="bulan" id="bulan" class="form-control">
                                        <option value="">Pilih</option>
                                        <?php
                                            // Array nama bulan
                                            $namaBulan = [
                                                '01' => 'Januari', '02' => 'Februari', '03' => 'Maret', '04' => 'April',
                                                '05' => 'Mei', '06' => 'Juni', '07' => 'Juli', '08' => 'Agustus',
                                                '09' => 'September', '10' => 'Oktober', '11' => 'November', '12' => 'Desember'
                                            ];
                                            // Loop untuk menampilkan opsi bulan
                                            foreach ($namaBulan as $value => $nama) {
                                                if($value==date('m')){
                                                    echo "<option selected value='$value'>$nama</option>";
                                                }else{
                                                    echo "<option value='$value'>$nama</option>";
                                                }
                                            }
                                        ?>
                                    </select>
                                    <small>Periode Bulan</small>
                                </div>
                                <div class="col-md-2 mt-3">
                                    <button type="submit" class="btn btn-md btn-dark btn-block btn-rounded" title="Taapilkan Data Buku Besar">
                                        <i class="bi bi-search"></i> Tampilkan
                                    </button>
                                </div>
                            </div>
                        </form>
                    </div>
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-12" id="MenampilkanTabelSimpanPinjam">
                                <?php
                                    echo '<div class="alert alert-danger text-center" role="alert">';
                                    echo ' <b>Keterangan :</b><br>';
                                    echo ' Untuk menampilkan laporan, anda harus mengisi form filter nama lembaga dan periode data terlebih dulu.<br>';
                                    echo '</div>';
                                ?>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
<?php } ?>
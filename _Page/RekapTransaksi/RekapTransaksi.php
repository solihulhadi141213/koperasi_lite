<?php
    //Cek Aksesibilitas ke halaman ini
    $IjinAksesSaya=IjinAksesSaya($Conn,$SessionIdAkses,'w8xdO79t7kdEeyBSxLJ');
    if($IjinAksesSaya!=="Ada"){
        include "_Page/Error/NoAccess.php";
    }else{
?>
    <div class="pagetitle">
        <h1>
            <a href="">
                <i class="bi bi-table"></i> Rekapitulasi Transaksi</a>
            </a>
        </h1>
        <nav>
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="index.php">Dashboard</a></li>
                <li class="breadcrumb-item active"> Rekapitulasi Transaksi</li>
            </ol>
        </nav>
    </div>
    <section class="section dashboard">
        <div class="row">
            <div class="col-md-12">
                <?php
                    echo '<div class="alert alert-warning alert-dismissible fade show" role="alert">';
                    echo '  <small>';
                    echo '      Berikut ini halaman rekapitulasi data transaksi berdasarkan periode waktu dan jenis transaksi yang sudah berlangsung.';
                    echo '      Gunakan tombol "Filter" untuk menentukan dasar pengelompokan data.';
                    echo '      <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>';
                    echo '  </small>';
                    echo '</div>';
                ?>
            </div>
        </div>
        <?php
            if(empty($_POST['jenis_transaksi'])){
                $jenis_transaksi="";
                $NameJenisTransaksi="Semua Jenis";
            }else{
                $jenis_transaksi=$_POST['jenis_transaksi'];
                $NamTransaksi=GetDetailData($Conn,'transaksi_jenis','id_transaksi_jenis',$jenis_transaksi,'nama');
                $NameJenisTransaksi="Transaksi $NamTransaksi";
            }
            if(empty($_POST['tahun'])){
                $tahun=date('Y');
            }else{
                $tahun=$_POST['tahun'];
            }
        ?>
        <form action="javascript:void(0);" id="ProsesFilterGrafik">
            <input type="hidden" name="jenis_transaksi" value="<?php echo "$jenis_transaksi"; ?>">
            <input type="hidden" name="tahun" value="<?php echo "$tahun"; ?>">
        </form>
        <div class="row">
            <div class="col-lg-12">
                <div class="card">
                    <div class="card-header">
                        <div class="row">
                            <div class="col-md-10">
                                <b class="card-title">
                                    <i class="bi bi-graph-up"></i> Grafik Rekapitulasi Transaksi
                                </b>
                            </div>
                            <div class="col-md-2 mb-3">
                                <a class="btn btn-md btn-outline-dark btn-rounded btn-block" href="javascript:void(0);" data-bs-toggle="modal" data-bs-target="#ModalFilterGrafik">
                                    <i class="bi bi-filter"></i> Mode Grafik
                                </a>
                            </div>
                        </div>
                    </div>
                    <div class="card-body">
                        <div class="row mb-3">
                            <div class="col-md-12 text-center" id="MenampilkanJudulGrafik">
                                
                            </div>
                        </div>
                        <div class="row mb-3">
                            <div class="col-md-12 text-center" id="MenampilkanGambarGrafik">
                                
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header">
                        <div class="row">
                            <div class="col-md-10">
                                <b class="card-title">
                                    <i class="bi bi-table"></i> Tabel Jumlah Transaksi / <span class="text text-grayish"><?php echo $NameJenisTransaksi; ?></span>
                                </b>
                            </div>
                            <div class="col-md-2 mb-3">
                                <a class="btn btn-md btn-outline-dark btn-rounded btn-block" href="javascript:void(0);" data-bs-toggle="modal" data-bs-target="#ModalExportTabelTransaksi">
                                    <i class="bi bi-download"></i> Export
                                </a>
                            </div>
                        </div>
                    </div>
                    <div class="card-body">
                        <div class="row mb-3">
                            <div class="col-md-12 table table-responsive">
                                <table class="table table-bordered table-hover">
                                    <thead>
                                        <tr>
                                            <td align="center"><b>No</b></td>
                                            <td align="center"><b>Periode</b></td>
                                            <td align="center"><b>Record</b></td>
                                            <td align="center"><b>Jumlah Transaksi</b></td>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php
                                            $JumlahTotalRp=0;
                                            $JumlahTotalData=0;
                                            if(empty($jenis_transaksi)){
                                                // Array dengan nama-nama bulan
                                                $namaBulan = [
                                                    'Januari', 'Februari', 'Maret', 'April', 'Mei', 'Juni',
                                                    'Juli', 'Agustus', 'September', 'Oktober', 'November', 'Desember'
                                                ];
                                                // Looping dari 1 hingga 12
                                                for ($i = 1; $i <= 12; $i++) {
                                                    // Mengubah angka menjadi format dua digit
                                                    $angkaBulan = str_pad($i, 2, '0', STR_PAD_LEFT);
                                                    // Mengambil nama bulan dari array
                                                    $namaBulanIni = $namaBulan[$i - 1];
                                                    ///Membentuk Tahun Bulan
                                                    $periode="$tahun-$angkaBulan";
                                                    //Menghitung Jumlah Transaksi
                                                    $Sum = mysqli_fetch_array(mysqli_query($Conn, "SELECT SUM(jumlah) AS jumlah_total FROM transaksi WHERE tanggal like '%$periode%'"));
                                                    $jumlah_transaksi = $Sum['jumlah_total'];
                                                    if(empty($jumlah_transaksi)){
                                                        $jumlah_transaksi=0;
                                                    }
                                                    $JumlahTransaksiFormat = "Rp " . number_format($jumlah_transaksi,0,',','.');
                                                    //Menghitung Jumlah Record
                                                    $jml_data = mysqli_num_rows(mysqli_query($Conn, "SELECT id_transaksi FROM transaksi WHERE tanggal like '%$periode%'"));
                                                    $JumlahTotalRp=$JumlahTotalRp+$jumlah_transaksi;
                                                    $JumlahTotalData=$JumlahTotalData+$jml_data;
                                                    echo '<tr>';
                                                    echo '  <td align="center">'.$i.'</td>';
                                                    echo '  <td align="left">'.$namaBulanIni.' '.$tahun.'</td>';
                                                    echo '  <td align="right">'.$jml_data.' Record</td>';
                                                    echo '  <td align="right">'.$JumlahTransaksiFormat.'</td>';
                                                    echo '</tr>';
                                                }
                                            }else{
                                                // Array dengan nama-nama bulan
                                                $namaBulan = [
                                                    'Januari', 'Februari', 'Maret', 'April', 'Mei', 'Juni',
                                                    'Juli', 'Agustus', 'September', 'Oktober', 'November', 'Desember'
                                                ];
                                                // Looping dari 1 hingga 12
                                                for ($i = 1; $i <= 12; $i++) {
                                                    // Mengubah angka menjadi format dua digit
                                                    $angkaBulan = str_pad($i, 2, '0', STR_PAD_LEFT);
                                                    // Mengambil nama bulan dari array
                                                    $namaBulanIni = $namaBulan[$i - 1];
                                                    ///Membentuk Tahun Bulan
                                                    $periode="$tahun-$angkaBulan";
                                                    //Menghitung Jumlah Transaksi
                                                    $Sum = mysqli_fetch_array(mysqli_query($Conn, "SELECT SUM(jumlah) AS jumlah_total FROM transaksi WHERE id_transaksi_jenis='$jenis_transaksi' AND tanggal like '%$periode%'"));
                                                    $jumlah_transaksi = $Sum['jumlah_total'];
                                                    if(empty($jumlah_transaksi)){
                                                        $jumlah_transaksi=0;
                                                    }
                                                    $JumlahTransaksiFormat = "Rp " . number_format($jumlah_transaksi,0,',','.');
                                                    //Menghitung Jumlah Record
                                                    $jml_data = mysqli_num_rows(mysqli_query($Conn, "SELECT id_transaksi FROM transaksi WHERE id_transaksi_jenis='$jenis_transaksi' AND tanggal like '%$periode%'"));
                                                    $JumlahTotalRp=$JumlahTotalRp+$jumlah_transaksi;
                                                    $JumlahTotalData=$JumlahTotalData+$jml_data;
                                                    echo '<tr>';
                                                    echo '  <td align="center">'.$i.'</td>';
                                                    echo '  <td align="left">'.$namaBulanIni.' '.$tahun.'</td>';
                                                    echo '  <td align="right">'.$jml_data.' Record</td>';
                                                    echo '  <td align="right">'.$JumlahTransaksiFormat.'</td>';
                                                    echo '</tr>';
                                                }
                                            }
                                            $JumlahTotalRpFormat = "Rp " . number_format($JumlahTotalRp,0,',','.');
                                        ?>
                                        <tr>
                                            <td colspan="2" align="center">
                                                <b>JUMLAH/TOTAL</b>
                                            </td>
                                            <td align="right"><b><?php echo "$JumlahTotalData"; ?> Record</b></td>
                                            <td align="right"><b><?php echo "$JumlahTotalRpFormat"; ?></b></td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
<?php } ?>
<?php
    //Cek Aksesibilitas ke halaman ini
    $IjinAksesSaya=IjinAksesSaya($Conn,$SessionIdAkses,'N6O5Qc64hOEhPQukZSh');
    if($IjinAksesSaya!=="Ada"){
        include "_Page/Error/NoAccess.php";
    }else{
?>
    <div class="pagetitle">
        <h1>
            <a href="">
                <i class="bi bi-graph-down-arrow"></i> Laba Rugi</a>
            </a>
        </h1>
        <nav>
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="index.php">Dashboard</a></li>
                <li class="breadcrumb-item active"> Laba Rugi</li>
            </ol>
        </nav>
    </div>
    <section class="section dashboard">
        <div class="row">
            <div class="col-md-12">
                <?php
                    echo '<div class="alert alert-warning alert-dismissible fade show" role="alert">';
                    echo '  <small>';
                    echo '      Berikut ini adalah halaman laporan laba-rugi.';
                    echo '      Laporan ini menampilkan akumulasi dari selisih saldo transaksi pendapatan (benefit) dan biaya (cost).';
                    echo '      Untuk menampilkan laporan pilih periode transaksi dan komponen akun pendapatan dan beban sesuai akun perkiraan.';
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
                        <form action="javascript:void(0);" id="ProsesLaporanLabaRugi">
                            <div class="row">
                                <div class="col-md-2 mt-2">
                                    <input type="date" name="periode1" id="periode1" class="form-control">
                                    <small>Periode Awal</small>
                                </div>
                                <div class="col-md-2 mt-2">
                                    <input type="date" name="periode2" id="periode2" class="form-control">
                                    <small>Periode Akhir</small>
                                </div>
                                <div class="col-md-3 mt-2">
                                    <select name="akun_pemasukan" id="akun_pemasukan" class="form-control">
                                        <option value="">Pilih</option>
                                        <?php
                                            $QueryAkun1 = mysqli_query($Conn, "SELECT*FROM akun_perkiraan WHERE level='1' ORDER BY kode ASC");
                                            while ($DataAkun1 = mysqli_fetch_array($QueryAkun1)) {
                                                $IdPerkiraan = $DataAkun1['id_perkiraan '];
                                                $KodeAkun= $DataAkun1['kode'];
                                                $NamaAkun= $DataAkun1['nama'];
                                                $saldo_normal= $DataAkun1['saldo_normal'];
                                                echo '<option value="'.$KodeAkun.'">'.$KodeAkun.' '.$NamaAkun.' ('.$saldo_normal.')</option>';
                                            }
                                        ?>
                                    </select>
                                    <small>Akun Pemasukan</small>
                                </div>
                                <div class="col-md-3 mt-2">
                                    <select name="akun_pengeluaran" id="akun_pengeluaran" class="form-control">
                                        <option value="">Pilih</option>
                                        <?php
                                            $QueryAkun2 = mysqli_query($Conn, "SELECT*FROM akun_perkiraan WHERE level='1' ORDER BY kode ASC");
                                            while ($DataAkun2 = mysqli_fetch_array($QueryAkun2)) {
                                                $IdPerkiraan = $DataAkun2['id_perkiraan '];
                                                $KodeAkun= $DataAkun2['kode'];
                                                $NamaAkun= $DataAkun2['nama'];
                                                $saldo_normal= $DataAkun2['saldo_normal'];
                                                echo '<option value="'.$KodeAkun.'">'.$KodeAkun.' '.$NamaAkun.' ('.$saldo_normal.')</option>';
                                            }
                                        ?>
                                    </select>
                                    <small>Akun Pengeluaran</small>
                                </div>
                                <div class="col-md-2 mt-2">
                                    <button type="submit" class="btn btn-md btn-dark btn-block btn-rounded" title="Tampilkan Laporaa Laba Rugi">
                                        <i class="bi bi-search"></i> Tampilkan
                                    </button>
                                </div>
                            </div>
                        </form>
                    </div>
                    <div id="MenampilkanTabelLabaRugi">
                        <div class="card-body">
                            <div class="row">
                                <div class="col-md-12 text-center">
                                    <div class="alert alert-danger" role="alert">
                                        Silahkan Isi Form Periode, Akun Laba-Rugi dan Nama Mitra
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
<?php } ?>
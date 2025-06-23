<?php
    //Cek Aksesibilitas ke halaman ini
    $IjinAksesSaya=IjinAksesSaya($Conn,$SessionIdAkses,'n6quFiiDojCgimfkCT7');
    if($IjinAksesSaya!=="Ada"){
        include "_Page/Error/NoAccess.php";
    }else{
?>
    <div class="pagetitle">
        <h1>
            <a href="">
                <i class="bi bi-graph-down-arrow"></i> Buku Besar</a>
            </a>
        </h1>
        <nav>
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="index.php">Dashboard</a></li>
                <li class="breadcrumb-item active"> Buku Besar</li>
            </ol>
        </nav>
    </div>
    <section class="section dashboard">
        <div class="row">
            <div class="col-md-12">
                <?php
                    echo '<div class="alert alert-warning alert-dismissible fade show" role="alert">';
                    echo '  <small>';
                    echo '      Berikut ini adalah halaman laporan buku besar.';
                    echo '      Laporan ini menampilkan akumulasi transaksi saldo berdasarkan jurnal pada masing-masing akun.';
                    echo '      Untuk menampilkan laporan, pilih akun keuangan dan periode transaksi yang diinginkan.';
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
                        <form action="javascript:void(0);" id="ProsesBukuBesar">
                            <div class="row">
                                <div class="col-md-4 mt-3">
                                    <select name="id_perkiraan" id="id_perkiraan" class="form-control">
                                        <?php
                                            echo '<option value="">Pilih</option>';
                                            // Query untuk mengambil akun level 1 (group utama)
                                            $QryGroupUtama = mysqli_query($Conn, "SELECT * FROM akun_perkiraan WHERE level='1' ORDER BY nama");
                                            while ($GroupUtama = mysqli_fetch_array($QryGroupUtama)) {
                                                $id_perkiraan_utama = $GroupUtama['id_perkiraan'];
                                                $kode_utama = $GroupUtama['kode'];
                                                $nama_utama = $GroupUtama['nama'];
                                                $saldo_normal_utama = $GroupUtama['saldo_normal'];
                                                // Tampilkan group utama
                                                echo '<optgroup label="'.$nama_utama.' ('.$saldo_normal_utama.')">';
                                                // Query untuk mengambil anak group dari group utama berdasarkan kode
                                                $QryAnakGroup = mysqli_query($Conn, "SELECT * FROM akun_perkiraan WHERE kode LIKE '$kode_utama%' AND level != '1' ORDER BY nama");
                                                while ($AnakGroup = mysqli_fetch_array($QryAnakGroup)) {
                                                    $id_perkiraan_anak = $AnakGroup['id_perkiraan'];
                                                    $nama_anak = $AnakGroup['nama'];
                                                    $saldo_normal_anak = $AnakGroup['saldo_normal'];
                                                    $kode = $AnakGroup['kode'];
                                                    $level = $AnakGroup['level'];
                                                    $LevelTerbawah = mysqli_num_rows(mysqli_query($Conn, "SELECT*FROM akun_perkiraan WHERE kd$level='$kode'"));
                                                    // Tampilkan anak group
                                                    if($LevelTerbawah=="1"){
                                                        echo '<option value="'.$id_perkiraan_anak.'">'.$nama_anak.' ('.$saldo_normal_anak.')</option>';
                                                    }
                                                }
                                                echo '</optgroup>';
                                            }
                                        ?>
                                    </select>
                                    <small>Akun Perkiraan</small>
                                </div>
                                <div class="col-md-3 mt-3">
                                    <input type="date" name="periode1" id="periode1" class="form-control">
                                    <small>Periode Awal</small>
                                </div>
                                <div class="col-md-3 mt-3">
                                    <input type="date" name="periode2" id="periode2" class="form-control">
                                    <small>Periode Akhir</small>
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
                            <div class="col-md-12" id="MenampilkanTabelBukuBesar">
                                <?php
                                    echo '<div class="alert alert-danger text-center" role="alert">';
                                    echo ' <b>Keterangan :</b><br>';
                                    echo ' Untuk menampilkan laporan, anda harus mengisi nama akun perkiraan buku besar, periode awal dan periode akhir.<br>';
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
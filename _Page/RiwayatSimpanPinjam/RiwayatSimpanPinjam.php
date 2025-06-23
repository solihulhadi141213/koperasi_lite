<?php
    //Cek Aksesibilitas ke halaman ini
    $IjinAksesSaya=IjinAksesSaya($Conn,$SessionIdAkses,'PXbSX4aNtpkqrcEBmyG');
    if($IjinAksesSaya!=="Ada"){
        include "_Page/Error/NoAccess.php";
    }else{
?>
    <div class="pagetitle">
        <h1>
            <a href="">
                <i class="bi bi-graph-down-arrow"></i> Riwayat Anggota</a>
            </a>
        </h1>
        <nav>
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="index.php">Dashboard</a></li>
                <li class="breadcrumb-item active"> Riwayat Anggota</li>
            </ol>
        </nav>
    </div>
    <section class="section dashboard">
        <div class="row">
            <div class="col-md-12">
                <?php
                    echo '<div class="alert alert-warning alert-dismissible fade show" role="alert">';
                    echo '  Berikut ini adalah halaman yang menampilkan riwayat data anggota yang sudah melakukan simpanan dan pinjaman.';
                    echo '  <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>';
                    echo '</div>';
                ?>
            </div>
        </div>
        <div class="row">
            <div class="col-lg-12">
                <div class="card">
                <div class="card-body">
                    <!-- Bordered Tabs Justified -->
                    <ul class="nav nav-tabs nav-tabs-bordered d-flex" id="borderedTabJustified" role="tablist">
                        <li class="nav-item flex-fill" role="presentation">
                            <button class="nav-link w-100 active" id="home-tab" data-bs-toggle="tab" data-bs-target="#bordered-justified-home" type="button" role="tab" aria-controls="home" aria-selected="true">
                                Simpanan
                            </button>
                        </li>
                        <li class="nav-item flex-fill" role="presentation">
                            <button class="nav-link w-100" id="profile-tab" data-bs-toggle="tab" data-bs-target="#bordered-justified-profile" type="button" role="tab" aria-controls="profile" aria-selected="false" tabindex="-1">
                                Pinjaman
                            </button>
                        </li>
                    </ul>
                    <div class="tab-content pt-2" id="borderedTabJustifiedContent">
                        <div class="tab-pane fade show active" id="bordered-justified-home" role="tabpanel" aria-labelledby="home-tab">
                            <div class="row">
                                <div class="col-md-12 mt-4 mb-3">
                                    <?php
                                        $JumlahDataSimpanan = mysqli_num_rows(mysqli_query($Conn, "SELECT DISTINCT id_anggota FROM simpanan"));
                                        if(empty($JumlahDataSimpanan)){
                                            echo '<div class="alert alert-info alert-dismissible fade show" role="alert">';
                                            echo '  Belum ada data anggota yang melakukan simpanan.';
                                            echo '  <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>';
                                            echo '</div>';
                                        }else{
                                            echo '
                                                <div class="row mb-2">
                                                    <div class="col-md-12 text-end">
                                                        <a href="_Page/RiwayatSimpanPinjam/ProsesExportSimpanan.php" class="btn btn-outline-grayish">
                                                            <i class="bi bi-printer"></i> Export Excel
                                                        </a>
                                                    </div>
                                                </div>
                                            ';
                                            echo '<div class="table table-responsive">';
                                            echo '  <table class="table table-bordered table-hover">';
                                            echo '      <thead>';
                                            echo '          <tr>';
                                            echo '              <td align="center"><b>No</b></td>';
                                            echo '              <td align="center"><b>Nama Anggota</b></td>';
                                            echo '              <td align="center"><b>NIP</b></td>';
                                            echo '              <td align="center"><b>Jumlah Simpanan</b></td>';
                                            echo '          </tr>';
                                            echo '      </thead>';
                                            echo '      <tbody>';
                                            //Menampilkan Kolom Jenis Simpanan
                                            $no=1;
                                            $JumllahTotal=0;
                                            $QrySimpanan = mysqli_query($Conn, "SELECT DISTINCT id_anggota FROM simpanan");
                                            while ($DataSimpanan = mysqli_fetch_array($QrySimpanan)) {
                                                $id_anggota= $DataSimpanan['id_anggota'];
                                                $nip=GetDetailData($Conn,'anggota','id_anggota',$id_anggota,'nip');
                                                $nama=GetDetailData($Conn,'anggota','id_anggota',$id_anggota,'nama');
                                                //Jumlah Simpanan
                                                $SumSimpanan = mysqli_fetch_array(mysqli_query($Conn, "SELECT SUM(jumlah) AS jumlah FROM simpanan WHERE id_anggota='$id_anggota' AND kategori!='Penarikan'"));
                                                if(empty($SumSimpanan['jumlah'])){
                                                    $JumlahSimpanan =0;
                                                }else{
                                                    $JumlahSimpanan = $SumSimpanan['jumlah'];
                                                }
                                                $JumllahTotal=$JumllahTotal+$JumlahSimpanan;
                                                $JumlahSimpananFormat="Rp " . number_format($JumlahSimpanan,0,',','.');
                                                echo '<tr>';
                                                echo '  <td align="center">'.$no.'</td>';
                                                echo '  <td align="left">'.$nama.'</td>';
                                                echo '  <td align="left">'.$nip.'</td>';
                                                echo '  <td align="right">'.$JumlahSimpananFormat.'</td>';
                                                echo '</tr>';
                                                $no++;
                                            }
                                            $JumlahTotalSimpanan="Rp " . number_format($JumllahTotal,0,',','.');
                                            echo '<tr>';
                                            echo '  <td align="left"></td>';
                                            echo '  <td align="left" colspan="2"><b>JUMLAH TOTAL</b></td>';
                                            echo '  <td align="right">'.$JumlahTotalSimpanan.'</td>';
                                            echo '</tr>';
                                            echo '      </tbody>';
                                            echo '  </table>';
                                            echo '</div>';
                                        }
                                    ?>
                                </div>
                            </div>
                        </div>
                        <div class="tab-pane fade" id="bordered-justified-profile" role="tabpanel" aria-labelledby="profile-tab">
                            <div class="row">
                                <div class="col-md-12 mt-4 mb-3">
                                    <?php
                                        $JumlahPinjaman = mysqli_num_rows(mysqli_query($Conn, "SELECT DISTINCT id_anggota FROM pinjaman WHERE status='Berjalan'"));
                                        if(empty($JumlahPinjaman)){
                                            echo '<div class="alert alert-info alert-dismissible fade show" role="alert">';
                                            echo '  Belum ada data anggota yang mempunyai pinjaman.';
                                            echo '  <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>';
                                            echo '</div>';
                                        }else{
                                            echo '
                                                <div class="row mb-2">
                                                    <div class="col-md-12 text-end">
                                                        <a href="_Page/RiwayatSimpanPinjam/ProsesExportPinjaman.php" class="btn btn-outline-grayish">
                                                            <i class="bi bi-printer"></i> Export Excel
                                                        </a>
                                                    </div>
                                                </div>
                                            ';
                                            echo '<div class="table table-responsive">';
                                            echo '  <table class="table table-bordered table-hover">';
                                            echo '      <thead>';
                                            echo '          <tr>';
                                            echo '              <td align="center"><b>No</b></td>';
                                            echo '              <td align="center"><b>Nama Anggota</b></td>';
                                            echo '              <td align="center"><b>NIP</b></td>';
                                            echo '              <td align="center"><b>Jumlah Pinjaman</b></td>';
                                            echo '          </tr>';
                                            echo '      </thead>';
                                            echo '      <tbody>';
                                            //Menampilkan Kolom Jenis Simpanan
                                            $no=1;
                                            $JumllahTotal=0;
                                            $Qry = mysqli_query($Conn, "SELECT DISTINCT id_anggota FROM pinjaman WHERE status='Berjalan'");
                                            while ($DataPinjaman = mysqli_fetch_array($Qry)) {
                                                $id_anggota= $DataPinjaman['id_anggota'];
                                                $nip=GetDetailData($Conn,'anggota','id_anggota',$id_anggota,'nip');
                                                $nama=GetDetailData($Conn,'anggota','id_anggota',$id_anggota,'nama');
                                                //Jumlah Pinjaman
                                                $SumPinjaman = mysqli_fetch_array(mysqli_query($Conn, "SELECT SUM(jumlah_pinjaman) AS jumlah FROM pinjaman WHERE id_anggota='$id_anggota'"));
                                                if(empty($SumPinjaman['jumlah'])){
                                                    $JumlahPinjaman =0;
                                                }else{
                                                    $JumlahPinjaman = $SumPinjaman['jumlah'];
                                                }
                                                $JumllahTotal=$JumllahTotal+$JumlahPinjaman;
                                                $JumlahPinjamanFormat="Rp " . number_format($JumlahPinjaman,0,',','.');
                                                echo '<tr>';
                                                echo '  <td align="center">'.$no.'</td>';
                                                echo '  <td align="left">'.$nama.'</td>';
                                                echo '  <td align="left">'.$nip.'</td>';
                                                echo '  <td align="right">'.$JumlahPinjamanFormat.'</td>';
                                                echo '</tr>';
                                                $no++;
                                            }
                                            $JumlahTotalPinjamanFormat="Rp " . number_format($JumllahTotal,0,',','.');
                                            echo '<tr>';
                                            echo '  <td align="left"></td>';
                                            echo '  <td align="left" colspan="2"><b>JUMLAH TOTAL</b></td>';
                                            echo '  <td align="right">'.$JumlahTotalPinjamanFormat.'</td>';
                                            echo '</tr>';
                                            echo '      </tbody>';
                                            echo '  </table>';
                                            echo '</div>';
                                        }
                                    ?>
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
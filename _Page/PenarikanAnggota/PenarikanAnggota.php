<div class="pagetitle">
    <h1>
        <a href="">
            <i class="bi bi-coin"></i> Penarikan Dana</a>
        </a>
    </h1>
    <nav>
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="index.php">Dashboard</a></li>
            <li class="breadcrumb-item active"> Penarikan Dana</li>
        </ol>
    </nav>
</div>
<div class="row">
    <div class="col-md-12">
        <div class="alert alert-warning alert-dismissible fade show" role="alert">
            <small>
                Berikut ini adalah halaman penarikan dana simpanan anggota. 
                Anda bisa mengajukan penarikan dana simpanan berdasarkan sumber simpanan.
                Proses pencairan memerlukan verifikasi pengurus koperasi.
            </small>
        </div>
    </div>
</div>
<section class="section dashboard">
    <div class="card">
        <div class="card-header">
            <div class="row">
                <div class="col-8">
                    <b>Sumber Dana Penarikan</b>
                </div>
                <div class="col-4"></div>
            </div>
        </div>
        <div class="card-body">
            <div class="table table-responsive">
                <table class="table table-bordered table-hover table-striped">
                    <thead>
                        <tr>
                            <th colspan="3"><b>Kategori/Simpanan</b></th>
                            <th><b>Penarikan</b></th>
                            <th><b>Saldo</b></th>
                            <th><b>Status</b></th>
                            <th class="text-center"><b>Opsi</b></th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                            //Looping Kategori Simpanan
                            $no_kategori=1;
                            $QryKategoriSimpanan = mysqli_query($Conn, "SELECT DISTINCT kategori FROM simpanan_jenis ORDER BY kategori ASC");
                            while ($DataKategoriSimpanan = mysqli_fetch_array($QryKategoriSimpanan)) {
                                $kategori= $DataKategoriSimpanan['kategori'];
                                echo '
                                    <tr>
                                        <td colspan="7">'.$no_kategori.'. '.$kategori.'</td>
                                    </tr>
                                ';

                                //Looping Jenis Simpanan
                                $no_simpanan_jenis=1;
                                $jumlah_simpanan=0;
                                $QryJenisSimpanan = mysqli_query($Conn, "SELECT * FROM simpanan_jenis WHERE kategori='$kategori' ORDER BY nama_simpanan ASC");
                                while ($DataJenisSimpanan = mysqli_fetch_array($QryJenisSimpanan)) {
                                    $id_simpanan_jenis= $DataJenisSimpanan['id_simpanan_jenis'];
                                    $nama_simpanan= $DataJenisSimpanan['nama_simpanan'];
                                    //Hitung Saldo Simpanan
                                    $SumSimpananKotor = mysqli_fetch_array(mysqli_query($Conn, "SELECT SUM(jumlah) AS jumlah FROM simpanan WHERE id_simpanan_jenis='$id_simpanan_jenis' AND id_anggota='$SessionIdAkses' AND status='Lunas'"));
                                    $JumlahSimpananKotor = $SumSimpananKotor['jumlah'];
                                    $JumlahSimpananKotorFormat = "" . number_format($JumlahSimpananKotor,0,',','.');
                                    $jumlah_simpanan=$jumlah_simpanan+$JumlahSimpananKotor;
                                    echo '
                                        <tr>
                                            <td></td>
                                            <td colspan="2"><small class="text text-grayish">'.$no_kategori.'.'.$no_simpanan_jenis.'. '.$nama_simpanan.'</small></td>
                                            <td><small></small></td>
                                            <td class="text-end"><small class="text text-grayish">'.$JumlahSimpananKotorFormat.'</small></td>
                                            <td><small></small></td>
                                            <td class="text-center">
                                                <button type="button" class="btn btn-sm btn-outline-dark btn-rounded" data-bs-toggle="modal" data-bs-target="#ModalPenarikanDana" data-id="'.$id_simpanan_jenis.'">
                                                    Tarik
                                                </button>
                                            </td>
                                        </tr>
                                    ';

                                    //Looping Penarikan Dana
                                    $no_penarikan=1;
                                    $jumlah_penarikan=0;
                                    $QryPenarikan = mysqli_query($Conn, "SELECT * FROM simpanan_penarikan  WHERE id_simpanan_jenis='$id_simpanan_jenis' AND id_anggota='$SessionIdAkses' ORDER BY tanggal ASC");
                                    while ($DataPenarikan = mysqli_fetch_array($QryPenarikan)) {
                                        $id_simpanan_penarikan= $DataPenarikan['id_simpanan_penarikan'];
                                        $tanggal= $DataPenarikan['tanggal'];
                                        $nominal= $DataPenarikan['nominal'];
                                        $status= $DataPenarikan['status'];
                                        if($status=="Lunas"){
                                            $jumlah_penarikan=$jumlah_penarikan+$nominal;
                                            $LabelStatus='<span class="badge badge-success">Lunas</span>';
                                        }else{
                                            $jumlah_penarikan=$jumlah_penarikan+0;
                                            $LabelStatus='<span class="badge badge-warning">Pending</span>';
                                        }
                                        $NominalPenarikanFormat = "" . number_format($nominal,0,',','.');
                                        echo '
                                            <tr>
                                                <td></td>
                                                <td></td>
                                                <td><code class="text text-grayish">'.$no_kategori.'.'.$no_simpanan_jenis.'.'.$no_penarikan.'. '.$tanggal.'</code></td>
                                                <td class="text-end"><small class="text text-grayish">'.$NominalPenarikanFormat.'</small></td>
                                                <td><small></small></td>
                                                <td class="text-center">'.$LabelStatus.'</td>
                                                <td class="text-center">
                                                    <button type="button" class="btn btn-sm btn-outline-info btn-rounded" data-bs-toggle="modal" data-bs-target="#ModalDetailPenarikan" data-id="'.$id_simpanan_penarikan.'">
                                                        Detail
                                                    </button>
                                                </td>
                                            </tr>
                                        ';
                                        $no_penarikan++; 
                                    }

                                    //Saldo
                                    $jumlah_penarikan_format = "" . number_format($jumlah_penarikan,0,',','.');
                                    $jumlah_simpanan_format = "" . number_format($jumlah_simpanan,0,',','.');
                                    echo '
                                        <tr>
                                            <td></td>
                                            <td></td>
                                            <td class="text-end">Saldo</td>
                                            <td class="text-end"><span class="text text-decoration-underline">'.$jumlah_penarikan_format.'</span></td>
                                            <td class="text-end"><span class="text text-decoration-underline">'.$jumlah_simpanan_format.'</span></td>
                                            <td class="text-center"></td>
                                            <td class="text-center"></td>
                                        </tr>
                                    ';
                                    $no_simpanan_jenis++;
                                }
                                $no_kategori++;
                            }
                        ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</section>
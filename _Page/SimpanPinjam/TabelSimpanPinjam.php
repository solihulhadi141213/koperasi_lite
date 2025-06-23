<?php
    //Koneksi
    date_default_timezone_set('Asia/Jakarta');
    include "../../_Config/Connection.php";
    include "../../_Config/GlobalFunction.php";
    include "../../_Config/SettingGeneral.php";
    include "../../_Config/Session.php";
    //Menangkap Data
    if(empty($SessionIdAkses)){
        echo '<div class="alert alert-danger text-center" role="alert">';
        echo ' <b>Maaf!!</b><br>';
        echo '  Sesi Akses Sudah Berakhir, Silahkan Login Ulang';
        echo '</div>';
    }else{
        if(empty($_POST['lembaga'])){
            echo '<div class="alert alert-danger text-center" role="alert">';
            echo ' <b>Maaf!!</b><br>';
            echo '  Nama Lembaga Tidak Boleh Kosong!';
            echo '</div>';
        }else{
            if(empty($_POST['tahun'])){
                echo '<div class="alert alert-danger text-center" role="alert">';
                echo ' <b>Maaf!!</b><br>';
                echo '  Periode Tahun Laporan Tidak Boleh Kosong!';
                echo '</div>';
            }else{
                if(empty($_POST['periode'])){
                    echo '<div class="alert alert-danger text-center" role="alert">';
                    echo ' <b>Maaf!!</b><br>';
                    echo '  Tipe Periode Laporan Tidak Boleh Kosong!';
                    echo '</div>';
                }else{

                    $lembaga=$_POST['lembaga'];
                    $tahun=$_POST['tahun'];
                    $periode=$_POST['periode'];
                    $bulan=0;
                    //Apabila Periode Bulan Maka Data Bulan tidak boleh kosong
                    if($periode=="Bulan"){
                        if(empty($_POST['bulan'])){
                            $validasi_kelengkapan="Periode Bulan Tidak Boleh Kosong!";
                        }else{
                            $bulan=$_POST['bulan'];
                            $NamaBulan=getNamaBulan($bulan);
                            $validasi_kelengkapan="Valid";
                        }
                    }else{
                        $validasi_kelengkapan="Valid";
                    }
                    if($validasi_kelengkapan!=="Valid"){
                        echo '<div class="alert alert-danger text-center" role="alert">';
                        echo ' <b>Maaf!!</b><br>';
                        echo "$validasi_kelengkapan";
                        echo '</div>';
                    }else{
                        //Bersihkan Variabel
                        $lembaga=validateAndSanitizeInput($lembaga);
                        $tahun=validateAndSanitizeInput($tahun);

                        //Buat Keyword Berdasarkan Periode
                        if($periode=="Tahun"){
                            $keyword="$tahun";
                        }else{
                            $keyword="$tahun-$bulan";
                        }
                        
                        //Hitung Jumlah Simpanan
                        $JumlahJenisSimpanan = mysqli_num_rows(mysqli_query($Conn, "SELECT id_simpanan_jenis FROM simpanan_jenis"));
                        $TotalJumlahKolom=2+$JumlahJenisSimpanan+3;
?>
                    <div class="row mb-4">
                        <div class="col-md-12 text-center">
                            <?php
                                if($periode=="Tahun"){
                                    echo '<b>LAPORAN SIMPAN PINJAM</b><br>';
                                    echo '<b>Unit/Divisi : '.$lembaga.'</b><br>';
                                    echo '<span>Periode Tahun '.$tahun.'</span><br>';
                                }else{
                                    echo '<b>LAPORAN SIMPAN PINJAM</b><br>';
                                    echo '<b>Unit/Divisi : '.$lembaga.'</b><br>';
                                    echo '<span>Periode Bulan '.$NamaBulan.' '.$tahun.'</span><br>';
                                }
                                
                            ?>
                        </div>
                    </div>
                    <div class="row mb-4">
                        <div class="col-md-12 text-center">
                            <a href="_Page/SimpanPinjam/ProsesCetakSimpanPinjam.php?lembaga=<?php echo $lembaga; ?>&periode=<?php echo $periode; ?>&bulan=<?php echo $bulan; ?>&tahun=<?php echo $tahun; ?>" target="_blank" class="btn btn-sm btn-outline-grayish btn-rounded">
                                <i class="bi bi-printer"></i> Cetak Simpan-Pinjam
                            </a>
                        </div>
                    </div>
                    <div class="row mb-3">
                        <div class="col-md-12 table table-responsive">
                            <table class="table table-hover table-bordered">
                                <thead>
                                    <tr>
                                        <td align="center" rowspan="2"><b>NO</b></td>
                                        <td align="center" rowspan="2"><b>ANGGOTA</b></td>
                                        <td align="center" colspan="<?php echo $JumlahJenisSimpanan; ?>"><b>SIMPANAN</b></td>
                                        <td align="center" colspan="3"><b>PINJAMAN</b></td>
                                        <td align="center" rowspan="2"><b>JUMLAH</b></td>
                                    </tr>
                                    <tr>
                                        <?php
                                            //Menampilkan Kolom Jenis Simpanan
                                            $QrySimpanan = mysqli_query($Conn, "SELECT*FROM simpanan_jenis ORDER BY id_simpanan_jenis ASC");
                                            while ($DataSimpanan = mysqli_fetch_array($QrySimpanan)) {
                                                $id_simpanan_jenis= $DataSimpanan['id_simpanan_jenis'];
                                                $nama_simpanan= $DataSimpanan['nama_simpanan'];
                                                echo '<td align="center"><b>'.$nama_simpanan.'</b></td>';
                                            }
                                        ?>
                                        <td align="center"><b>ANGSURAN</b></td>
                                        <td align="center"><b>PER</b></td>
                                        <td align="center"><b>JASA</b></td>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php
                                        $jml_data = mysqli_num_rows(mysqli_query($Conn, "SELECT * FROM anggota WHERE lembaga='$lembaga'"));
                                        if(empty($jml_data)){
                                            echo '<tr>';
                                            echo '  <td colspan="'.$TotalJumlahKolom.'" class="text-center">';
                                            echo '      <code class="text-danger">';
                                            echo '          Tidak Ada Data Anggota Untuk Lembaga Ini Yang Dapat Ditampilkan';
                                            echo '      </code>';
                                            echo '  </td>';
                                            echo '</tr>';
                                        }else{
                                            $no = 1;
                                            $QrySimpanan = mysqli_query($Conn, "SELECT*FROM simpanan_jenis ORDER BY id_simpanan_jenis ASC");
                                            while ($DataSimpanan = mysqli_fetch_array($QrySimpanan)) {
                                                $id_simpanan_jenis= $DataSimpanan['id_simpanan_jenis'];
                                                $JumlahTotalSimpanan[$id_simpanan_jenis]=0;
                                            }
                                            $JumlahTotalAngsuran=0;
                                            $JumlahTotalJasa=0;
                                            $JumlahTotalGrand=0;
                                            $query = mysqli_query($Conn, "SELECT*FROM anggota WHERE lembaga='$lembaga' ORDER BY nama ASC");
                                            while ($data = mysqli_fetch_array($query)) {
                                                $id_anggota= $data['id_anggota'];
                                                $nama= $data['nama'];
                                                $nip= $data['nip'];
                                                echo '<tr>';
                                                echo '  <td align="center">'.$no.'</td>';
                                                echo '  <td align="left">'.$nama.'</td>';
                                               //Menampilkan Kolom Jenis Simpanan
                                                $JumlahSimpananAnggota=0;
                                                $QrySimpanan = mysqli_query($Conn, "SELECT*FROM simpanan_jenis ORDER BY id_simpanan_jenis ASC");
                                                while ($DataSimpanan = mysqli_fetch_array($QrySimpanan)) {
                                                    $id_simpanan_jenis= $DataSimpanan['id_simpanan_jenis'];
                                                    $nama_simpanan= $DataSimpanan['nama_simpanan'];
                                                    //Hitung Sum Jumlah Simpanan
                                                    $SumSimpanan = mysqli_fetch_array(mysqli_query($Conn, "SELECT SUM(jumlah) AS jumlah FROM simpanan WHERE id_anggota='$id_anggota' AND id_simpanan_jenis='$id_simpanan_jenis' AND tanggal like '%$keyword%'"));
                                                    if(empty($SumSimpanan['jumlah'])){
                                                        $JumlahSimpanan =0;
                                                    }else{
                                                        $JumlahSimpanan = $SumSimpanan['jumlah'];
                                                    }
                                                    $JumlahTotalSimpanan[$id_simpanan_jenis]=$JumlahTotalSimpanan[$id_simpanan_jenis]+$JumlahSimpanan;
                                                    $JumlahSimpananAnggota=$JumlahSimpananAnggota+$JumlahSimpanan;
                                                    $JumlahSimpananFormat="Rp " . number_format($JumlahSimpanan,0,',','.');
                                                    echo '<td align="right"><small class="credit"><code class="text text-grayish">'.$JumlahSimpananFormat.'</code></small></td>';
                                                }
                                                //Cek Ada Pinjaman Atau Tidak
                                                $QryPinjaman = mysqli_query($Conn,"SELECT * FROM pinjaman WHERE id_anggota='$id_anggota' AND status='Berjalan'")or die(mysqli_error($Conn));
                                                $DataPinjaman = mysqli_fetch_array($QryPinjaman);
                                                if(empty($DataPinjaman['jumlah_pinjaman'])){
                                                    $jumlah_pinjaman="";
                                                    $periode_angsuran="0";
                                                    $angsuran_masuk="0";
                                                }else{
                                                    $id_pinjaman=$DataPinjaman['id_pinjaman'];
                                                    $jumlah_pinjaman=$DataPinjaman['jumlah_pinjaman'];
                                                    $periode_angsuran=$DataPinjaman['periode_angsuran'];
                                                    $angsuran_masuk=mysqli_num_rows(mysqli_query($Conn, "SELECT*FROM pinjaman_angsuran WHERE id_pinjaman='$id_pinjaman'"));
                                                }
                                                //Sum Angsuran
                                                $SumAngsuran = mysqli_fetch_array(mysqli_query($Conn, "SELECT SUM(pokok) AS pokok FROM pinjaman_angsuran WHERE id_anggota='$id_anggota' AND tanggal_bayar like '%$keyword%'"));
                                                if(empty($SumAngsuran['pokok'])){
                                                    $JumlahPokok =0;
                                                }else{
                                                    $JumlahPokok = $SumAngsuran['pokok'];
                                                }
                                                $JumlahTotalAngsuran=$JumlahTotalAngsuran+$JumlahPokok;
                                                $JumlahPokokFormat="Rp " . number_format($JumlahPokok,0,',','.');
                                                //Sum Jasa
                                                $SumJasa = mysqli_fetch_array(mysqli_query($Conn, "SELECT SUM(jasa) AS jasa FROM pinjaman_angsuran WHERE id_anggota='$id_anggota' AND tanggal_bayar like '%$keyword%'"));
                                                if(empty($SumJasa['jasa'])){
                                                    $JumlahJasa =0;
                                                }else{
                                                    $JumlahJasa = $SumJasa['jasa'];
                                                }
                                                $JumlahJasaFormat="Rp " . number_format($JumlahJasa,0,',','.');
                                                $JumlahPemasukan=$JumlahSimpananAnggota+$JumlahPokok+$JumlahJasa;
                                                $JumlahPemasukanFormat="Rp " . number_format($JumlahPemasukan,0,',','.');
                                                $JumlahTotalJasa=$JumlahTotalJasa+$JumlahJasa;
                                                $JumlahTotalGrand=$JumlahTotalGrand+$JumlahPemasukan;
                                                echo '  <td align="right"><small class="credit"><code class="text text-grayish">'.$JumlahPokokFormat.'</code></small></td>';
                                                echo '  <td align="center"><small class="credit"><code class="text text-grayish">'.$angsuran_masuk.'/'.$periode_angsuran.'</code></small></td>';
                                                echo '  <td align="right"><small class="credit"><code class="text text-grayish">'.$JumlahJasaFormat.'</code></small></td>';
                                                echo '  <td align="right"><small class="credit"><code class="text text-dark">'.$JumlahPemasukanFormat.'</code></small></td>';
                                                echo '</tr>';
                                                $no++;
                                            }
                                            echo '<tr>';
                                            echo '  <td align="center" colspan="2"><b>JUMLAH</b></td>';
                                            $QrySimpanan = mysqli_query($Conn, "SELECT*FROM simpanan_jenis ORDER BY id_simpanan_jenis ASC");
                                            while ($DataSimpanan = mysqli_fetch_array($QrySimpanan)) {
                                                $id_simpanan_jenis= $DataSimpanan['id_simpanan_jenis'];
                                                $JumlahTotalSimpananFormat="Rp " . number_format($JumlahTotalSimpanan[$id_simpanan_jenis],0,',','.');
                                                echo '<td align="right"><small class="credit"><code class="text text-dark">'.$JumlahTotalSimpananFormat.'</code></small></td>';
                                            }
                                            $JumlahTotalAngsuranFormat="Rp " . number_format($JumlahTotalAngsuran,0,',','.');
                                            $JumlahTotalJasaFormat="Rp " . number_format($JumlahTotalJasa,0,',','.');
                                            $JumlahTotalGrandFormat="Rp " . number_format($JumlahTotalGrand,0,',','.');
                                            echo '<td align="right"><small class="credit"><code class="text text-dark">'.$JumlahTotalAngsuranFormat.'</code></small></td>';
                                            echo '<td align="right"><small class="credit"><code class="text text-dark"></code></small></td>';
                                            echo '<td align="right"><small class="credit"><code class="text text-dark">'.$JumlahTotalJasaFormat.'</code></small></td>';
                                            echo '<td align="right"><small class="credit"><code class="text text-dark">'.$JumlahTotalGrandFormat.'</code></small></td>';
                                            echo '</tr>';
                                        }
                                    ?>
                                </tbody>
                            </table>
                        </div>
                    </div>
<?php 
                    }
                }
            } 
        } 
    } 
?>
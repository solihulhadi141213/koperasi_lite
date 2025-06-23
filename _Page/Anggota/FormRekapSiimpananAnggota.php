<?php
    //Koneksi
    date_default_timezone_set('Asia/Jakarta');
    include "../../_Config/Connection.php";
    include "../../_Config/GlobalFunction.php";
    include "../../_Config/SettingGeneral.php";
    include "../../_Config/Session.php";
    if(empty($SessionIdAkses)){
        echo '<div class="row">';
        echo '  <div class="col-md-12 mb-3 text-center">';
        echo '      <small class="text-danger">Sesi Akses Sudah Berakhir, Silahkan Login Ulang</small>';
        echo '  </div>';
        echo '</div>';
    }else{
        //Tangkap id_anggota
        if(empty($_POST['id_anggota'])){
            echo '<div class="row">';
            echo '  <div class="col-md-12 mb-3 text-center">';
            echo '      <small class="text-danger">ID Anggota Tidak Boleh Kosong!</small>';
            echo '  </div>';
            echo '</div>';
        }else{
            $id_anggota=$_POST['id_anggota'];
            $id_anggota=validateAndSanitizeInput($id_anggota);
?>
    <div class="row">
        <div class="col-12">
            <div class="table table-responsive">
                <table class="table table-hover table-striped">
                    <thead>
                        <tr>
                            <th><b>No</b></th>
                            <th><b>Uraian Simpanan</b></th>
                            <th><b>Nominal</b></th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                            // echo '
                            //     <tr>
                            //         <td colspan="4">
                            //             Jumlah Simpanan Anggota
                            //         </td>
                            //     </tr>
                            // ';
                            //Loop Jenis Simpanan
                            $no=1;
                            $total_simpanan=0;
                            $query_jenis_simpanan = mysqli_query($Conn, "SELECT*FROM simpanan_jenis ORDER BY nama_simpanan");
                            while ($data_jenis_simpanan = mysqli_fetch_array($query_jenis_simpanan)) {
                                $id_simpanan_jenis= $data_jenis_simpanan['id_simpanan_jenis'];
                                $nama_simpanan= $data_jenis_simpanan['nama_simpanan'];
                                
                                //Menghitung Jumlah Simpanan Anggota Berdasarkan Jenisnya
                                $SumSimpanan = mysqli_fetch_array(mysqli_query($Conn, "SELECT SUM(jumlah) AS jumlah FROM simpanan WHERE id_anggota='$id_anggota' AND id_simpanan_jenis='$id_simpanan_jenis' AND kategori!='Penarikan'"));
                                $JumlahSimpanan = $SumSimpanan['jumlah'];
                                $JumlahSimpanan_rp = "Rp " . number_format($JumlahSimpanan,0,',','.');

                                //Akumulasikan
                                $total_simpanan=$total_simpanan+$JumlahSimpanan;
                                echo '
                                    <tr>
                                        <td><small>'.$no.'</small></td>
                                        <td><small>'.$nama_simpanan.'</small></td>
                                        <td><small>'.$JumlahSimpanan_rp.'</small></td>
                                    </tr>
                                ';
                                $no++;
                            }
                            //Ubah Total Simpanan Menjadi Format Rupiah
                            $total_simpanan_rp = "Rp " . number_format($total_simpanan,0,',','.');
                            echo '
                                <tr>
                                    <td colspan="2"><small>JUMLAH SIMPANAN</small></td>
                                    <td><small class="text-decoration-underline">'.$total_simpanan_rp.'</small></td>
                                </tr>
                            ';
                            $no_2=1;
                            $total_penarikan=0;
                            $query_jenis_simpanan = mysqli_query($Conn, "SELECT*FROM simpanan_jenis ORDER BY nama_simpanan");
                            while ($data_jenis_simpanan = mysqli_fetch_array($query_jenis_simpanan)) {
                                $id_simpanan_jenis= $data_jenis_simpanan['id_simpanan_jenis'];
                                $nama_simpanan= $data_jenis_simpanan['nama_simpanan'];
                                
                                //Menghitung Jumlah Penarikan Simpanan Anggota Berdasarkan Jenisnya
                                $SumPenarikan = mysqli_fetch_array(mysqli_query($Conn, "SELECT SUM(jumlah) AS jumlah FROM simpanan WHERE id_anggota='$id_anggota' AND id_simpanan_jenis='$id_simpanan_jenis' AND kategori='Penarikan'"));
                                $JumlahPenarikan = $SumPenarikan['jumlah'];
                                $JumlahPenarikan_rp = "Rp " . number_format($JumlahPenarikan,0,',','.');

                                //Akumulasikan
                                $total_penarikan=$total_penarikan+$JumlahPenarikan;
                                echo '
                                    <tr>
                                        <td><small>'.$no_2.'</small></td>
                                        <td><small>Penarikan '.$nama_simpanan.'</small></td>
                                        <td><small>'.$JumlahPenarikan_rp.'</small></td>
                                    </tr>
                                ';
                                $no_2++;
                            }
                            //Ubah Total Simpanan Menjadi Format Rupiah
                            $total_penarikan_rp = "Rp " . number_format($total_penarikan,0,',','.');
                            echo '
                                <tr>
                                    <td colspan="2"><small>JUMLAH PENARIKAN</small></td>
                                    <td><small class="text-decoration-underline">'.$total_penarikan_rp.'</small></td>
                                </tr>
                            ';
                            //Menghitung Total Sisa Simpanan
                            $sisa_simpanan=$total_simpanan-$total_penarikan;
                            $sisa_simpanan_rp = "Rp " . number_format($sisa_simpanan,0,',','.');
                            echo '
                                <tr>
                                    <td colspan="2"><small>TOTAL SISA SIMPANAN</small></td>
                                    <td><small class="text text-decoration-underline">'.$sisa_simpanan_rp.'</small></td>
                                </tr>
                            ';
                        ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>

<?php
        }
    }
?>
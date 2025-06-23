<section class="section dashboard">
    <div class="row">
        <div class="col-lg-12">
            <div class="card">
                <div class="card-header">
                    <div class="row">
                        <div class="col-md-12 text-center">
                            <b class="card-title">RIWAYAT PINJAMAN ANGGOTA</b>
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
                                        <td align="center"><b>Tanggal</b></td>
                                        <td align="center"><b>Pinjaman</b></td>
                                        <td align="center"><b>Angsuran Pokok</b></td>
                                        <td align="center"><b>Jasa</b></td>
                                        <td align="center"><b>Jumlah</b></td>
                                        <td align="center"><b>Periode</b></td>
                                        <td align="center"><b>Status</b></td>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php
                                        $jml_data = mysqli_num_rows(mysqli_query($Conn, "SELECT*FROM pinjaman WHERE id_anggota='$SessionIdAkses'"));
                                        if(empty($jml_data)){
                                            echo '<tr>';
                                            echo '  <td colspan="8" class="text-center">';
                                            echo '      <code class="text-danger">';
                                            echo '          Tidak Ada Data Pinjaman Yang Dapat Ditampilkan';
                                            echo '      </code>';
                                            echo '  </td>';
                                            echo '</tr>';
                                        }else{
                                            $no = 1;
                                            $total = 0;
                                            //KONDISI PENGATURAN MASING FILTER
                                            $query = mysqli_query($Conn, "SELECT*FROM pinjaman WHERE id_anggota='$SessionIdAkses' ORDER BY id_pinjaman ASC");
                                            while ($data = mysqli_fetch_array($query)) {
                                                $id_pinjaman= $data['id_pinjaman'];
                                                $uuid_pinjaman= $data['uuid_pinjaman'];
                                                $id_anggota= $data['id_anggota'];
                                                $nama= $data['nama'];
                                                $nip= $data['nip'];
                                                $lembaga= $data['lembaga'];
                                                $ranking= $data['ranking'];
                                                $tanggal= $data['tanggal'];
                                                $jatuh_tempo= $data['jatuh_tempo'];
                                                $jumlah_pinjaman= $data['jumlah_pinjaman'];
                                                $rp_jasa= $data['rp_jasa'];
                                                $angsuran_pokok= $data['angsuran_pokok'];
                                                $angsuran_total= $data['angsuran_total'];
                                                $periode_angsuran= $data['periode_angsuran'];
                                                $status= $data['status'];
                                                //Format tanggal
                                                $strtotime=strtotime($tanggal);
                                                $TanggalFormat=date('d/m/Y',$strtotime);
                                                //Format Rupiah
                                                $jumlah_pinjaman_format = "Rp " . number_format($jumlah_pinjaman,0,',','.');
                                                $angsuran_pokok_format = "Rp " . number_format($angsuran_pokok,0,',','.');
                                                $rp_jasa_format = "Rp " . number_format($rp_jasa,0,',','.');
                                                $angsuran_total_format = "Rp " . number_format($angsuran_total,0,',','.');
                                    ?>
                                                <tr>
                                                    <td align="center"><?php echo $no; ?></td>
                                                    <td align="left"><?php echo $TanggalFormat; ?></td>
                                                    <td align="left"><?php echo $jumlah_pinjaman_format; ?></td>
                                                    <td align="left"><?php echo $angsuran_pokok_format; ?></td>
                                                    <td align="left"><?php echo $rp_jasa_format; ?></td>
                                                    <td align="right"><?php echo $angsuran_total_format; ?></td>
                                                    <td align="right"><?php echo "$periode_angsuran Kali"; ?></td>
                                                    <td align="right"><?php echo "$status"; ?></td>
                                                </tr>
                                        <?php
                                                    $no++; 
                                                }
                                            }
                                        ?>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
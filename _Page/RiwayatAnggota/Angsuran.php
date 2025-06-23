<section class="section dashboard">
    <div class="row">
        <div class="col-lg-12">
            <div class="card">
                <div class="card-header">
                    <div class="row">
                        <div class="col-md-12 text-center">
                            <b class="card-title">RIWAYAT ANGSURAN ANGGOTA</b>
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
                                        <td align="center"><b>Periode Angsuran</b></td>
                                        <td align="center"><b>Tanggal Bayar</b></td>
                                        <td align="center"><b>Keterlambatan (Hari)</b></td>
                                        <td align="center"><b>Anguran Pokok</b></td>
                                        <td align="center"><b>Jasa</b></td>
                                        <td align="center"><b>Denda</b></td>
                                        <td align="center"><b>Jumlah</b></td>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php
                                        $jml_data = mysqli_num_rows(mysqli_query($Conn, "SELECT*FROM pinjaman_angsuran WHERE id_anggota='$SessionIdAkses'"));
                                        if(empty($jml_data)){
                                            echo '<tr>';
                                            echo '  <td colspan="8" class="text-center">';
                                            echo '      <code class="text-danger">';
                                            echo '          Tidak Ada Data Angsuran Yang Dapat Ditampilkan';
                                            echo '      </code>';
                                            echo '  </td>';
                                            echo '</tr>';
                                        }else{
                                            $no = 1;
                                            $total = 0;
                                            //KONDISI PENGATURAN MASING FILTER
                                            $query = mysqli_query($Conn, "SELECT*FROM pinjaman_angsuran WHERE id_anggota='$SessionIdAkses' ORDER BY id_pinjaman_angsuran ASC");
                                            while ($data = mysqli_fetch_array($query)) {
                                                $id_pinjaman_angsuran= $data['id_pinjaman_angsuran'];
                                                $tanggal_angsuran= $data['tanggal_angsuran'];
                                                $tanggal_bayar= $data['tanggal_bayar'];
                                                $keterlambatan= $data['keterlambatan'];
                                                $pokok= $data['pokok'];
                                                $jasa= $data['jasa'];
                                                $denda= $data['denda'];
                                                $jumlah= $data['jumlah'];
                                                //Format tanggal
                                                $strtotime1=strtotime($tanggal_angsuran);
                                                $strtotime2=strtotime($tanggal_bayar);
                                                $TanggalAngsuranFormat=date('d/m/Y',$strtotime1);
                                                $TanggalBayarFormat=date('d/m/Y',$strtotime2);
                                                //Format Rupiah
                                                $PokokFormat = "Rp " . number_format($pokok,0,',','.');
                                                $JasaFormat = "Rp " . number_format($jasa,0,',','.');
                                                $DendaFormat = "Rp " . number_format($denda,0,',','.');
                                                $JumlahFormat = "Rp " . number_format($jumlah,0,',','.');
                                    ?>
                                                <tr>
                                                    <td align="center"><?php echo $no; ?></td>
                                                    <td align="left"><?php echo $TanggalAngsuranFormat; ?></td>
                                                    <td align="left"><?php echo $TanggalBayarFormat; ?></td>
                                                    <td align="left"><?php echo "$keterlambatan"; ?></td>
                                                    <td align="right"><?php echo "$PokokFormat"; ?></td>
                                                    <td align="right"><?php echo "$JasaFormat"; ?></td>
                                                    <td align="right"><?php echo "$DendaFormat"; ?></td>
                                                    <td align="right"><?php echo "$JumlahFormat"; ?></td>
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
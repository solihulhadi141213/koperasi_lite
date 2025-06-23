<section class="section dashboard">
    <div class="row">
        <div class="col-lg-12">
            <div class="card">
                <div class="card-header">
                    <div class="row">
                        <div class="col-md-12 text-center">
                            <b class="card-title">RIWAYAT SIMPANAN ANGGOTA</b>
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
                                        <td align="center"><b>Kategori</b></td>
                                        <td align="center"><b>Keterangan</b></td>
                                        <td align="center"><b>Nominal</b></td>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php
                                        $jml_data = mysqli_num_rows(mysqli_query($Conn, "SELECT*FROM simpanan WHERE id_anggota='$SessionIdAkses' AND kategori!='Penarikan'"));
                                        if(empty($jml_data)){
                                            echo '<tr>';
                                            echo '  <td colspan="5" class="text-center">';
                                            echo '      <code class="text-danger">';
                                            echo '          Tidak Ada Data Simpanan Yang Dapat Ditampilkan';
                                            echo '      </code>';
                                            echo '  </td>';
                                            echo '</tr>';
                                        }else{
                                            $no = 1;
                                            $total = 0;
                                            //KONDISI PENGATURAN MASING FILTER
                                            $query = mysqli_query($Conn, "SELECT*FROM simpanan WHERE id_anggota='$SessionIdAkses' AND kategori!='Penarikan' ORDER BY id_simpanan ASC");
                                            while ($data = mysqli_fetch_array($query)) {
                                                $id_simpanan= $data['id_simpanan'];
                                                $uuid_simpanan= $data['uuid_simpanan'];
                                                $id_anggota= $data['id_anggota'];
                                                $id_akses= $data['id_akses'];
                                                $id_simpanan_jenis= $data['id_simpanan_jenis'];
                                                $rutin= $data['rutin'];
                                                $nip= $data['nip'];
                                                $nama= $data['nama'];
                                                $lembaga= $data['lembaga'];
                                                $ranking= $data['ranking'];
                                                $tanggal= $data['tanggal'];
                                                $kategori= $data['kategori'];
                                                $keterangan= $data['keterangan'];
                                                if($kategori=="Penarikan"){
                                                    $LabelKategori='<code class="text text-danger">Penarikan dana simpanan</code>';
                                                }else{
                                                    $LabelKategori='<code class="text text-success">'.$kategori.'</code>';
                                                }
                                                $jumlah= $data['jumlah'];
                                                //Format tanggal
                                                $strtotime=strtotime($tanggal);
                                                $TanggalFormat=date('d/m/Y',$strtotime);
                                                //Format Rupiah
                                                $jumlah_format = "Rp " . number_format($jumlah,0,',','.');
                                                $total = $total+$jumlah;
                                    ?>
                                                <tr>
                                                    <td align="center"><?php echo $no; ?></td>
                                                    <td align="left"><?php echo $TanggalFormat; ?></td>
                                                    <td align="left"><?php echo $LabelKategori; ?></td>
                                                    <td align="left"><?php echo $keterangan; ?></td>
                                                    <td align="right"><?php echo $jumlah_format; ?></td>
                                                </tr>
                                        <?php
                                                $no++; 
                                            }
                                            $total_format = "Rp " . number_format($total,0,',','.');
                                        ?>
                                            <tr>
                                                <td align="center"></td>
                                                <td align="left" colspan="3"><b>JUMLAH</b></td>
                                                <td align="right"><b><?php echo $total_format; ?></b></td>
                                            </tr>
                                        <?php } ?>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
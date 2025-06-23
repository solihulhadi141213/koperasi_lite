<section class="section dashboard">
    <?php
        if(empty($SessionIdAkses)){
            echo '<div class="row mb-3">';
            echo '  <div class="col-md-12">';
            echo '      <div class="alert alert-danger alert-dismissible fade show" role="alert">';
            echo '          Sesi Akses Sudah Berakhir, Silahkan Login Ulang Terlebih Dulu.';
            echo '          <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>';
            echo '      </div>';
            echo '  </div>';
            echo '</div>';
        }else{
            //Tangkap id_pinjaman
            if(empty($_GET['id'])){
                echo '<div class="row mb-3">';
                echo '  <div class="col-md-12">';
                echo '      <div class="alert alert-danger alert-dismissible fade show" role="alert">';
                echo '          ID Pinjaman Tidak Boleh Kosong.';
                echo '          <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>';
                echo '      </div>';
                echo '  </div>';
                echo '</div>';
            }else{
                $id_pinjaman_angsuran=$_GET['id'];
                //Bersihkan Variabel
                $id_pinjaman_angsuran=validateAndSanitizeInput($id_pinjaman_angsuran);
                $id_pinjaman_angsuran=GetDetailData($Conn,'pinjaman_angsuran','id_pinjaman_angsuran',$id_pinjaman_angsuran,'id_pinjaman_angsuran');
                if(empty($id_pinjaman_angsuran)){
                    echo '<div class="row mb-3">';
                    echo '  <div class="col-md-12">';
                    echo '      <div class="alert alert-danger alert-dismissible fade show" role="alert">';
                    echo '          ID Angsuran Tidak Valid Atau Tidak Ditemukan Pada Database.';
                    echo '          <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>';
                    echo '      </div>';
                    echo '  </div>';
                    echo '</div>';
                }else{
                    //Buka Detail Pinjaman Angsuran
                    $uuid_angsuran=GetDetailData($Conn,'pinjaman_angsuran','id_pinjaman_angsuran',$id_pinjaman_angsuran,'uuid_angsuran');
                    $id_pinjaman=GetDetailData($Conn,'pinjaman_angsuran','id_pinjaman_angsuran',$id_pinjaman_angsuran,'id_pinjaman');
                    $id_anggota=GetDetailData($Conn,'pinjaman_angsuran','id_pinjaman_angsuran',$id_pinjaman_angsuran,'id_anggota');
                    $tanggal_angsuran=GetDetailData($Conn,'pinjaman_angsuran','id_pinjaman_angsuran',$id_pinjaman_angsuran,'tanggal_angsuran');
                    $tanggal_bayar=GetDetailData($Conn,'pinjaman_angsuran','id_pinjaman_angsuran',$id_pinjaman_angsuran,'tanggal_bayar');
                    $keterlambatan=GetDetailData($Conn,'pinjaman_angsuran','id_pinjaman_angsuran',$id_pinjaman_angsuran,'keterlambatan');
                    $pokok=GetDetailData($Conn,'pinjaman_angsuran','id_pinjaman_angsuran',$id_pinjaman_angsuran,'pokok');
                    $jasa=GetDetailData($Conn,'pinjaman_angsuran','id_pinjaman_angsuran',$id_pinjaman_angsuran,'jasa');
                    $denda=GetDetailData($Conn,'pinjaman_angsuran','id_pinjaman_angsuran',$id_pinjaman_angsuran,'denda');
                    $jumlah=GetDetailData($Conn,'pinjaman_angsuran','id_pinjaman_angsuran',$id_pinjaman_angsuran,'jumlah');
                    //Buka Data Pinjaman
                    $jumlah_pinjaman=GetDetailData($Conn,'pinjaman','id_pinjaman',$id_pinjaman,'jumlah_pinjaman');
                    //Format Rupiah
                    if(empty($jumlah_pinjaman)){
                        $jumlah_pinjaman=0;
                    }
                    if(empty($pokok)){
                        $pokok=0;
                    }
                    if(empty($jasa)){
                        $jasa=0;
                    }
                    if(empty($denda)){
                        $denda=0;
                    }
                    if(empty($jumlah)){
                        $jumlah=0;
                    }
                    if(empty($keterlambatan)){
                        $keterlambatan=0;
                    }
                    $jumlah_pinjaman_rp = "Rp " . number_format($jumlah_pinjaman,0,',','.');
                    $pokok_rp = "Rp " . number_format($pokok,0,',','.');
                    $jasa_rp = "Rp " . number_format($jasa,0,',','.');
                    $denda_rp = "Rp " . number_format($denda,0,',','.');
                    $jumlah_rp = "Rp " . number_format($jumlah,0,',','.');
                    //Format tanggal
                    $strtotime1=strtotime($tanggal_angsuran);
                    $strtotime2=strtotime($tanggal_bayar);
                    $tanggal_angsuran_format=date('d/m/Y',$strtotime1);
                    $tanggal_bayar_format=date('d/m/Y',$strtotime2);
                    //Buka Sistem Denda
                    $sistem_denda=GetDetailData($Conn,'pinjaman','id_pinjaman',$id_pinjaman,'sistem_denda');
                    if($sistem_denda=="Harian"){
                        $SatuanTerlambat="Hari";
                    }else{
                        $SatuanTerlambat="Bulan";
                    }
    ?>
        <input type="hidden" id="GetIdAngsuran" value="<?php echo $id_pinjaman_angsuran; ?>">
        <div class="row mb-3">
            <div class="col-md-12">
                <?php
                    echo '<div class="alert alert-info alert-dismissible fade show" role="alert">';
                    echo '  Berikut adalah halaman detail angsuran. ';
                    echo '  Pada halaman ini anda bisa mengelola data pembukuan jurnal transaksi yang terhubung.';
                    echo '  <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>';
                    echo '</div>';
                ?>
            </div>
        </div>
        <div class="row mb-3">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header">
                        <div class="row">
                            <div class="col-md-10 mb-3">
                                <b class="card-title">
                                    <i class="bi bi-info-circle"></i> Detail Angsuran
                                </b>
                            </div>
                            <div class="col-md-2 mb-3">
                                <a href="index.php?Page=Pinjaman&Sub=DetailPinjaman&id=<?php echo $id_pinjaman; ?>" class="btn btn-md btn-block btn-dark btn-rounded">
                                    <i class="bi bi-chevron-left"></i> Kembali
                                </a>
                            </div>
                        </div>
                    </div>
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-6">
                                <div class="row mb-3">
                                    <div class="col col-md-4">Tanggal Angsuran</div>
                                    <div class="col col-md-8">
                                        <code class="text text-grayish"><?php echo $tanggal_angsuran_format; ?></code>
                                    </div>
                                </div>
                                <div class="row mb-3">
                                    <div class="col col-md-4">Tanggal Bayar</div>
                                    <div class="col col-md-8">
                                        <code class="text text-grayish"><?php echo $tanggal_bayar_format; ?></code>
                                    </div>
                                </div>
                                <div class="row mb-3">
                                    <div class="col col-md-4">Keterlambatan</div>
                                    <div class="col col-md-8">
                                        <code class="text text-grayish"><?php echo "$keterlambatan $SatuanTerlambat"; ?></code>
                                    </div>
                                </div>
                                <div class="row mb-3">
                                    <div class="col col-md-4">Jumlah Pinjaman</div>
                                    <div class="col col-md-8">
                                        <code class="text text-grayish"><?php echo $jumlah_pinjaman_rp; ?></code>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="row mb-3">
                                    <div class="col col-md-4">Pokok</div>
                                    <div class="col col-md-8">
                                        <code class="text text-grayish"><?php echo $pokok_rp; ?></code>
                                    </div>
                                </div>
                                <div class="row mb-3">
                                    <div class="col col-md-4">Jasa</div>
                                    <div class="col col-md-8">
                                        <code class="text text-grayish"><?php echo $jasa_rp; ?></code>
                                    </div>
                                </div>
                                <div class="row mb-3">
                                    <div class="col col-md-4">Denda</div>
                                    <div class="col col-md-8">
                                        <code class="text text-grayish"><?php echo $denda_rp; ?></code>
                                    </div>
                                </div>
                                <div class="row mb-3">
                                    <div class="col col-md-4">Jumlah Angsuran</div>
                                    <div class="col col-md-8">
                                        <code class="text text-grayish"><?php echo $jumlah_rp; ?></code>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="row mb-3">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-12 mb-3" id="MenampilkanTabelJurnalAngsuran">
                                
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    <?php
                }
            }
        }
    ?>
</section>
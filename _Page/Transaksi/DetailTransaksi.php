<section class="section dashboard">
    <?php
        if(empty($_GET['id'])){
            echo '<div class="row">';
            echo '  <div class="col-md-12">';
            echo '      <div class="alert alert-danger alert-dismissible fade show" role="alert">';
            echo '          ID Transaksi Tidak Boleh Kosong!';
            echo '      </div>';
            echo '  </div>';
            echo '</div>';
        }else{
            $id_transaksi=$_GET['id'];
            //Bersihkan Variabel
            $id_transaksi=validateAndSanitizeInput($id_transaksi);
            //Buka Informasi
            $uuid_transaksi=GetDetailData($Conn,'transaksi','id_transaksi',$id_transaksi,'uuid_transaksi');
            $id_transaksi_jenis=GetDetailData($Conn,'transaksi','id_transaksi',$id_transaksi,'id_transaksi_jenis');
            $nama_transaksi=GetDetailData($Conn,'transaksi','id_transaksi',$id_transaksi,'nama_transaksi');
            $kategori=GetDetailData($Conn,'transaksi','id_transaksi',$id_transaksi,'kategori');
            $tanggal=GetDetailData($Conn,'transaksi','id_transaksi',$id_transaksi,'tanggal');
            $jumlah=GetDetailData($Conn,'transaksi','id_transaksi',$id_transaksi,'jumlah');
            $pembayaran=GetDetailData($Conn,'transaksi','id_transaksi',$id_transaksi,'pembayaran');
            $status=GetDetailData($Conn,'transaksi','id_transaksi',$id_transaksi,'status');
            if(empty($pembayaran)){
                $pembayaran=0;
            }
            $JumlahFormat = "Rp " . number_format($jumlah,0,',','.');
            $PembayaranFormat = "Rp " . number_format($pembayaran,0,',','.');
            //Format Tanggal
            $strtotime=strtotime($tanggal);
            $TanggalFormat=date('d/m/Y H:i:s T', $strtotime);
            $TanggalKode=date('d/m/Y', $strtotime);
            $JumlahRincian = mysqli_num_rows(mysqli_query($Conn, "SELECT*FROM transaksi_rincian WHERE id_transaksi='$id_transaksi'"));
            $JumlahJurnal = mysqli_num_rows(mysqli_query($Conn, "SELECT*FROM jurnal WHERE kategori='Transaksi' AND uuid='$uuid_transaksi'"));
            echo '<input type="hidden" name="id_transaksi" id="get_id_transaksi" value="'.$id_transaksi.'">';
    ?>
        <div class="pagetitle">
            <h1>
                <a href="">
                    <i class="bi bi-cart-check"></i> Data Transaksi</a>
                </a>
            </h1>
            <nav>
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="index.php">Dashboard</a></li>
                    <li class="breadcrumb-item active"> Data Transaksi</li>
                </ol>
            </nav>
        </div>
        <div class="row">
            <div class="col-md-12">
                <?php
                    echo '<div class="alert alert-warning alert-dismissible fade show" role="alert">';
                    echo '  <small>';
                    echo '      Berikut ini halaman detail informasi transaksi.';
                    echo '      Halaman ini berfungsi untuk menampilkan uraian/rincian transaksi dan jurnal keuangan yang terhubung dengan transaksi tersebut';
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
                        <div class="row">
                            <div class="col-md-10 mt-3">
                                <b class="card-title">
                                    <i class="bi bi-info-circle"></i> Detail Transaksi
                                </b>
                            </div>
                            <div class="col-md-2 mt-3">
                                <a href="index.php?Page=Transaksi" class="btn btn-md btn-dark btn-rounded btn-block">
                                    <i class="bi bi-chevron-left"></i> Kembali
                                </a>
                            </div>
                        </div>
                    </div>
                    <div class="card-body">
                        <div class="row mb-3">
                            <div class="col-md-12 mb-3">
                                <b>Informasi Transaksi</b>
                            </div>
                            <div class="col-md-12 mb-3">
                                <div class="row mb-3">
                                    <div class="col col-md-3">
                                        <label for="id_transaksi_jenis">ID Transaksi</label>
                                    </div>
                                    <div class="col col-md-9">
                                        <small class="credit">
                                            <code class="text text-grayish"><?php echo $uuid_transaksi; ?></code>
                                        </small>
                                    </div>
                                </div>
                                <div class="row mb-3">
                                    <div class="col col-md-3">
                                        <label for="id_transaksi_jenis">Jenis Transaksi</label>
                                    </div>
                                    <div class="col col-md-9">
                                        <small class="credit">
                                            <code class="text text-grayish"><?php echo $nama_transaksi; ?></code>
                                        </small>
                                    </div>
                                </div>
                                <div class="row mb-3">
                                    <div class="col col-md-3">
                                        <label for="kategori">Kategori Transaksi</label>
                                    </div>
                                    <div class="col col-md-9">
                                        <small class="credit">
                                            <code class="text text-grayish"><?php echo $kategori; ?></code>
                                        </small>
                                    </div>
                                </div>
                                <div class="row mb-3">
                                    <div class="col col-md-3">
                                        <label for="tanggal">Tanggal & Jam</label>
                                    </div>
                                    <div class="col col-md-9">
                                        <small class="credit">
                                            <code class="text text-grayish"><?php echo $TanggalFormat; ?></code>
                                        </small>
                                    </div>
                                </div>
                                <div class="row mb-3">
                                    <div class="col col-md-3">
                                        <label for="JumlahTotal">Jumlah (Rp)</label>
                                    </div>
                                    <div class="col col-md-9">
                                        <small class="credit">
                                            <code class="text text-grayish"><?php echo $JumlahFormat; ?></code>
                                        </small>
                                    </div>
                                </div>
                                <div class="row mb-3">
                                    <div class="col col-md-3">
                                        <label for="JumlahPembayaran">Pembayaran (Rp)</label>
                                    </div>
                                    <div class="col col-md-9">
                                        <small class="credit">
                                            <code class="text text-grayish"><?php echo $PembayaranFormat; ?></code>
                                        </small>
                                    </div>
                                </div>
                                <div class="row mb-3">
                                    <div class="col col-md-3">
                                        <label for="status">Status Transaksi</label>
                                    </div>
                                    <div class="col col-md-9">
                                        <?php
                                            if($status=="Lunas"){
                                                echo '<badge class="badge bg-success">Lunas</badge>';
                                            }else{
                                                if($status=="Utang"){
                                                    echo '<badge class="badge bg-danger">Utang</badge>';
                                                }else{
                                                    if($status=="Piutang"){
                                                        echo '<badge class="badge bg-warning">Piutang</badge>';
                                                    }else{
                                                        echo '<badge class="badge bg-dark">None</badge>';
                                                    }
                                                }
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
        <div class="row mb-3">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-hheader">
                        <div class="row">
                            <div class="col-md-12 mb-3">
                                <ul class="nav nav-tabs nav-tabs-bordered d-flex" id="borderedTabJustified" role="tablist">
                                    <li class="nav-item flex-fill" role="presentation">
                                        <button class="card-title nav-link w-100 active" id="home-tab" data-bs-toggle="tab" data-bs-target="#bordered-justified-home" type="button" role="tab" aria-controls="home" aria-selected="true">
                                            Rincian/Uraian Transaksi
                                        </button>
                                    </li>
                                    <li class="nav-item flex-fill" role="presentation">
                                        <button class="card-title nav-link w-100" id="profile-tab" data-bs-toggle="tab" data-bs-target="#bordered-justified-profile" type="button" role="tab" aria-controls="profile" aria-selected="false" tabindex="-1">
                                            Jurnal Keuangan
                                        </button>
                                    </li>
                                </ul>
                            </div>
                        </div>
                    </div>
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-12 mb-3">
                                <div class="tab-content pt-2" id="borderedTabJustifiedContent">
                                    <div class="tab-pane fade active show" id="bordered-justified-home" role="tabpanel" aria-labelledby="home-tab">
                                        <div class="row mb-3">
                                            <div class="col-md-12">
                                                <b>Rincian Transaksi</b>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-md-12 table table-responsive">
                                                <table class="table table-bordered table-hover">
                                                    <thead>
                                                        <tr>
                                                            <td align="center"><b>No</b></td>
                                                            <td align="center"><b>Uraian/Keterangan</b></td>
                                                            <td align="center"><b>Harga</b></td>
                                                            <td align="center"><b>QTY</b></td>
                                                            <td align="center"><b>Satuan</b></td>
                                                            <td align="center"><b>Jumlah</b></td>
                                                        </tr>
                                                    </thead>
                                                    <tbody>
                                                        <?php
                                                            //Menampilkan Rincian
                                                            if(!empty($JumlahRincian)){
                                                                $no=1;
                                                                $query = mysqli_query($Conn, "SELECT*FROM transaksi_rincian WHERE id_transaksi='$id_transaksi' ORDER BY id_transaksi_rincian ASC");
                                                                while ($data = mysqli_fetch_array($query)) {
                                                                    $rincian_transaksi= $data['rincian_transaksi'];
                                                                    $harga= $data['harga'];
                                                                    $qty= $data['qty'];
                                                                    $satuan= $data['satuan'];
                                                                    $jumlah_list= $data['jumlah'];
                                                                    $HargaFormat = "Rp " . number_format($harga,0,',','.');
                                                                    $JumlahListFormat = "Rp " . number_format($jumlah_list,0,',','.');
                                                                    echo '<tr>';
                                                                    echo '  <td align="center">'.$no.'</td>';
                                                                    echo '  <td align="left">'.$rincian_transaksi.'</td>';
                                                                    echo '  <td align="right">'.$HargaFormat.'</td>';
                                                                    echo '  <td align="center">'.$qty.'</td>';
                                                                    echo '  <td align="center">'.$satuan.'</td>';
                                                                    echo '  <td align="right">'.$JumlahListFormat.'</td>';
                                                                    echo '</tr>';
                                                                    $no++;
                                                                }
                                                            }
                                                        ?>
                                                        <tr>
                                                            <td align="right" colspan="5">
                                                                <b>SUBTOTAL</b>
                                                            </td>
                                                            <td align="right" id="JumlahTotal2"><?php echo $JumlahFormat; ?></td>
                                                        </tr>
                                                    </tbody>
                                                </table>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="tab-pane fade" id="bordered-justified-profile" role="tabpanel" aria-labelledby="profile-tab">
                                        <div class="row mb-3">
                                            <div class="col-md-10">
                                                <b>Jurnal Transaksi</b>
                                            </div>
                                            <div class="col-md-2">
                                                <button type="button" class="btn btn-md btn-block btn-primary btn-rounded"  data-bs-toggle="modal" data-bs-target="#ModalTambahJurnal" data-id="<?php echo "$id_transaksi"; ?>">
                                                    <i class="bi bi-plus"></i> Tambah Jurnal
                                                </button>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-md-12 table table-responsive" id="MenampilkanJurnalTransaksi">
                                                <!-- Menampilkan Jurnal Disini -->
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    <?php } ?>
</section>
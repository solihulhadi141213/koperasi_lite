<?php
    //Cek Aksesibilitas ke halaman ini
    $IjinAksesSaya=IjinAksesSaya($Conn,$SessionIdAkses,'RZufXfHVLW9f0EsjYSB');
    if($IjinAksesSaya!=="Ada"){
        include "_Page/Error/NoAccess.php";
    }else{
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
    <form action="javascript:void(0);" id="ProsesEditTransaksi" autocomplete="off">
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
                    $JumlahFormat = "" . number_format($jumlah,0,',','.');
                    //Format Tanggal
                    $strtotime=strtotime($tanggal);
                    $TanggalFormat=date('Y-m-d', $strtotime);
                    $JamFormat=date('H:i:s', $strtotime);
                    $JumlahRincian = mysqli_num_rows(mysqli_query($Conn, "SELECT*FROM transaksi_rincian WHERE id_transaksi='$id_transaksi'"));
                    echo '<input type="hidden" name="id_transaksi" value="'.$id_transaksi.'">';
            ?>
                
                <div class="row">
                    <div class="col-md-12">
                        <?php
                            echo '<div class="alert alert-warning alert-dismissible fade show" role="alert">';
                            echo '  Berikut ini adalah halaman untuk edit/mengubah data transaksi.';
                            echo '  Semua perubahan yang terjadi pada halaman ini akan memperbaharui komponen transaksi seperti jurnal dan rincian.';
                            echo '  Pastikan juga bahwa semua perubahan sudah sesuai.';
                            echo '  <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>';
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
                                        <b class="card-title">Form Edit/Ubah Data Transaksi</b>
                                    </div>
                                    <div class="col-md-2 mt-3">
                                        <a href="index.php?Page=Transaksi" class="btn btn-md btn-dark btn-rounded btn-block">
                                            <i class="bi bi-chevron-left"></i> Kembali
                                        </a>
                                    </div>
                                </div>
                            </div>
                            <div class="card-body">
                                <div class="row border-1 border-bottom mb-3">
                                    <div class="col-md-12 mb-3">
                                        <b>Informasi Transaksi</b>
                                    </div>
                                    <div class="col-md-12 mb-3">
                                        <div class="row mb-3">
                                            <div class="col col-md-3">
                                                <label for="id_transaksi_jenis">Jenis Transaksi</label>
                                            </div>
                                            <div class="col col-md-9">
                                                <select name="id_transaksi_jenis" id="id_transaksi_jenis" class="form-control" data-bs-toggle="modal" data-bs-target="#ModalPilihJenisTransaksi">
                                                    <option value="<?php echo $id_transaksi_jenis; ?>"><?php echo $nama_transaksi; ?></option>
                                                </select>
                                            </div>
                                        </div>
                                        <div class="row mb-3">
                                            <div class="col col-md-3">
                                                <label for="kategori">Kategori Transaksi</label>
                                            </div>
                                            <div class="col col-md-9">
                                                <input type="text" readonly name="kategori" id="kategori" class="form-control" value="<?php echo $kategori; ?>">
                                            </div>
                                        </div>
                                        <div class="row mb-3">
                                            <div class="col col-md-3">
                                                <label for="tanggal">Tanggal & Jam</label>
                                            </div>
                                            <div class="col col-md-5">
                                                <input type="date" name="tanggal" id="tanggal" class="form-control" value="<?php echo $TanggalFormat; ?>">
                                            </div>
                                            <div class="col col-md-4">
                                                <input type="time" name="jam" id="jam" class="form-control" value="<?php echo $JamFormat; ?>">
                                            </div>
                                        </div>
                                        <div class="row mb-3">
                                            <div class="col col-md-3">
                                                <label for="JumlahTotal">Jumlah (Rp)</label>
                                            </div>
                                            <div class="col col-md-9">
                                                <input type="text" name="JumlahTotal" id="JumlahTotal" class="form-control nominal_angka" value="<?php echo $jumlah; ?>">
                                            </div>
                                        </div>
                                        <div class="row mb-3">
                                            <div class="col col-md-3">
                                                <label for="JumlahPembayaran">Pembayaran (Rp)</label>
                                            </div>
                                            <div class="col col-md-9">
                                                <input type="text" name="JumlahPembayaran" id="JumlahPembayaran" class="form-control nominal_angka" value="<?php echo $pembayaran; ?>">
                                            </div>
                                        </div>
                                        <div class="row mb-3">
                                            <div class="col col-md-3">
                                                <label for="status">Status Transaksi</label>
                                            </div>
                                            <div class="col col-md-9">
                                                <select name="status" id="status" class="form-control">
                                                    <option <?php if($status==""){echo "selected";} ?> value="">Pilih</option>
                                                    <option <?php if($status=="Lunas"){echo "selected";} ?> value="Lunas">Lunas</option>
                                                    <option <?php if($status=="Utang"){echo "selected";} ?> value="Utang">Utang</option>
                                                    <option <?php if($status=="Piutang"){echo "selected";} ?> value="Piutang">Piutang</option>
                                                </select>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="row border-1 border-bottom mb-3">
                                    <div class="col-md-12 mb-3">
                                        <b>Uraian/Rincian Transaksi</b>
                                    </div>
                                    <div class="col-md-12 mb-3">
                                        <div class="row mb-3">
                                            <div class="col col-md-3">
                                                <button type="button" class="btn btn-md btn-outline-grayish" id="TambahUraian">
                                                    <i class="bi bi-plus"></i> Tambah Uraian
                                                </button>
                                            </div>
                                            <div class="col col-md-9">

                                            </div>
                                        </div>
                                        <div class="row mb-3">
                                            <div class="col-md-12 table table-responsive">
                                                <table class="table table-bordered table-hover">
                                                    <thead>
                                                        <tr>
                                                            <td align="center"><b>Uraian/Keterangan</b></td>
                                                            <td align="center"><b>Harga</b></td>
                                                            <td align="center"><b>QTY</b></td>
                                                            <td align="center"><b>Satuan</b></td>
                                                            <td align="center"><b>Jumlah</b></td>
                                                            <td align="center"><b>Opsi</b></td>
                                                        </tr>
                                                    </thead>
                                                    <tbody id="UraianTransaksi">
                                                        <tr>
                                                            <td align="right" colspan="4">
                                                                <b>SUBTOTAL</b>
                                                            </td>
                                                            <td align="right" id="JumlahTotal2"><?php echo $jumlah; ?></td>
                                                            <td></td>
                                                        </tr>
                                                        <?php
                                                            //Menampilkan Rincian
                                                            if(!empty($JumlahRincian)){
                                                                $query = mysqli_query($Conn, "SELECT*FROM transaksi_rincian WHERE id_transaksi='$id_transaksi' ORDER BY id_transaksi_rincian ASC");
                                                                while ($data = mysqli_fetch_array($query)) {
                                                                    $rincian_transaksi= $data['rincian_transaksi'];
                                                                    $harga= $data['harga'];
                                                                    $qty= $data['qty'];
                                                                    $satuan= $data['satuan'];
                                                                    $jumlah_list= $data['jumlah'];
                                                                    echo '<tr>';
                                                                    echo '  <td align="center"><input type="text" name="uraian[]" class="form-control" placeholder="Uraian/Keterangan" value="'.$rincian_transaksi.'"></td>';
                                                                    echo '  <td align="center"><input type="text" name="harga[]" class="form-control nominal2 harga" placeholder="Harga" value="'.$harga.'"></td>';
                                                                    echo '  <td align="center"><input type="text" name="qty[]" class="form-control nominal2 qty" placeholder="QTY" value="'.$qty.'"></td>';
                                                                    echo '  <td align="center"><input type="text" name="satuan[]" class="form-control" placeholder="Satuan" value="'.$satuan.'"></td>';
                                                                    echo '  <td align="center"><input type="text" name="jumlah[]" class="form-control nominal2 jumlah" placeholder="Jumlah" value="'.$jumlah_list.'" readonly></td>';
                                                                    echo '  <td align="center">';
                                                                    echo '      <button type="button" class="btn btn-danger btn-sm remove-row"><i class="bi bi-x"></i></button>';
                                                                    echo '  </td>';
                                                                    echo '</tr>';
                                                                }
                                                            }
                                                        ?>
                                                    </tbody>
                                                </table>
                                                <small class="credit">
                                                    <b>Keterangan :</b> Apabila anda keluar/memuat ulang halaman maka uraian yang sudah anda buat di tabel atas akan hilang.
                                                </small>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-12 mb-3">
                                        <div class="alert alert-info text-center" role="alert">
                                            Pastikan bahwa data transaksi sudah terisi dengan benar!
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-12 mb-3" id="NotifikasiEditTransaksi">
                                        <!-- Notifikasi Tambah Transaksi Akan Muncul Disini -->
                                    </div>
                                </div>
                            </div>
                            <div class="card-footer">
                                <div class="row">
                                    <div class="col-md-3 mt-3">
                                        <button type="submit" class="btn btn-md btn-block btn-rounded btn-primary">
                                            <i class="bi bi-save"></i> Simpan Transaksi
                                        </button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            <?php } ?>
        </section>
    </form>
<?php } ?>
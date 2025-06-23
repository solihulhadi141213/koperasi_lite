<?php
    //Cek Aksesibilitas ke halaman ini
    $IjinAksesSaya=IjinAksesSaya($Conn,$SessionIdAkses,'a1nsbsSzX2L1LYHuVop');
    if($IjinAksesSaya!=="Ada"){
        include "_Page/Error/NoAccess.php";
    }else{
?>
    <section class="section dashboard">
        <div class="row">
            <div class="col-md-12">
                <?php
                    echo '<div class="alert alert-info alert-dismissible fade show" role="alert">';
                    echo '  Berikut ini adalah halaman untuk menambah data jurnal secara manual.';
                    echo '  Disarankan anda sudah mengetahui kode referensi transaksi yang akan diinput.';
                    echo '  Pilih jenis transaksi kemudian cari referensi transaksi yang akan dibuatkan jurnalnya.';
                    echo '  <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>';
                    echo '</div>';
                ?>
            </div>
        </div>
        <div class="row">
            <div class="col-lg-12">
                <form action="javascript:void(0);" id="ProsesTambahJurnal">
                    <div class="card">
                        <div class="card-header">
                            <div class="row">
                                <div class="col-md-10 mb-3">
                                    <b class="card-title">
                                        <i class="bi bi-plus"></i> Form Tambah Jurnal Keuangan
                                    </b>
                                </div>
                                <div class="col-md-2 mb-3">
                                    <a href="index.php?Page=Jurnal" class="btn btn-md btn-dark btn-block btn-rounded">
                                        <i class="bi bi-chevron-left"></i> Kembali
                                    </a>
                                </div>
                            </div>
                        </div>
                        <div class="card-body">
                            <div class="row mb-3">
                                <div class="col col-md-3">
                                    <label for="kategori">Kategori Jurnal Transaksi</label>
                                </div>
                                <div class="col col-md-9">
                                    <select name="kategori" id="kategori" class="form-control">
                                        <option value="">Pilih</option>
                                        <option value="Simpanan">Simpanan</option>
                                        <option value="Penarikan">Penarikan</option>
                                        <option value="Pinjaman">Pinjaman</option>
                                        <option value="Angsuran">Angsuran</option>
                                        <option value="Transaksi">Transaksi</option>
                                        <option value="Bagi Hasil">Bagi Hasil</option>
                                    </select>
                                </div>
                            </div>
                            <div class="row mb-3">
                                <div class="col col-md-3">
                                    <label for="uuid">Referensi Transaksi</label>
                                </div>
                                <div class="col col-md-9">
                                    <div class="input-group">
                                        <input type="text" name="uuid" class="form-control">
                                        <button type="button" class="btn btn-sm btn-outline-grayish">
                                            <i class="bi bi-search"></i>
                                        </button>
                                    </div>
                                </div>
                            </div>
                            <div class="row mb-3">
                                <div class="col col-md-3">
                                    <label for="tanggal">Tanggal Transaksi</label>
                                </div>
                                <div class="col col-md-9">
                                    <input type="date" name="tanggal" id="tanggal" class="form-control">
                                </div>
                            </div>
                            <div class="row mb-3">
                                <div class="col col-md-12 text-center">
                                    <b>URAIAN JURNAL KEUANGAN</b><br>
                                    <small>
                                        Tambahkan uraian jurnal keuangan pada tabel berikut ini.
                                    </small>
                                </div>
                            </div>
                            <div class="row mb-3">
                                <div class="col col-md-12 table table-responsive">
                                    <table class="table table-bordered table-hover">
                                        <thead>
                                            <tr>
                                                <td align="center" valign="middle"><b>No</b></td>
                                                <td align="center" valign="middle">
                                                    <b>Akun Perkiraan</b>
                                                    <select id="GetIdPerkiraan" class="form-control SelectOptionPerkiraan"></select>
                                                </td>
                                                <td align="center" valign="middle">
                                                    <b>Posisi (D/K)</b>
                                                    <select id="GetPosisi" class="form-control">
                                                        <option value="D">Debet</option>
                                                        <option value="K">Kredit</option>
                                                    </select>
                                                </td>
                                                <td align="center" valign="middle">
                                                    <b>Nominal (Rp)</b>
                                                    <input type="text" id="GetNominal" class="form-control">
                                                </td>
                                                <td align="center">
                                                    <button type="button" class="btn btn-md btn-outline-primary" id="TambahUraianJurnal">
                                                        Add
                                                    </button>
                                                </td>
                                            </tr>
                                        </thead>
                                        <tbody id="RowUraianJurnal">
                                            
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                        <div class="card-footer">
                            <button type="submit" class="btn btn-md btn-primary btn-rounded">
                                <i class="bi bi-save"></i> Simpan Jurnal
                            </button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </section>
<?php } ?>
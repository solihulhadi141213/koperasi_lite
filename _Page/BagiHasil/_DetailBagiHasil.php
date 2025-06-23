<div class="pagetitle">
    <h1>
        <a href="">
            <i class="bi bi-calculator"></i> Bagi Hasil</a>
        </a>
    </h1>
    <nav>
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="index.php">Dashboard</a></li>
            <li class="breadcrumb-item"><a href="index.php?Page=BagiHasil">Bagi Hasil</a></li>
            <li class="breadcrumb-item active"> Detail Bagi Hasil</li>
        </ol>
    </nav>
</div>
<?php
    if(empty($_GET['id'])){
        echo '<div class="alert alert-danger alert-dismissible fade show" role="alert">';
        echo '  Tidak ada ID Sesi Bagi Hasil Yang Ditampilkan.';
        echo '</div>';
    }else{
        echo '<div class="alert alert-warning alert-dismissible fade show" role="alert">';
        echo '  <small>';
        echo '      Berikut ini adalah detail informasi bagi hasil (SHU) yang sudah anda buat.';
        echo '      Pada halaman ini anda bisa melihat uraian lengkap pembagian hasil (SHU) untuk masing-masing anggota.';
        echo '      Jangan lupa juga untuk melengkapi informasi jurnal keuangan untuk mencatat transaksi pada neraca saldo.';
        echo '      <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>';
        echo '  </small>';
        echo '</div>';
        $id_shu_session=$_GET['id'];
        //Buka data dengan prepared statment
        $Qry = $Conn->prepare("SELECT * FROM shu_session WHERE id_shu_session = ?");
        $Qry->bind_param("i", $id_shu_session);
        if (!$Qry->execute()) {
            $error=$Conn->error;
            echo '
                <div class="alert alert-danger">
                    <small>Terjadi kesalahan pada saat menampilkan data sesi SHU <br> Keterangan : '.$error.'</small>
                </div>
            ';
        }else{
            $Result = $Qry->get_result();
            $Data = $Result->fetch_assoc();

            //Apabila Data Tidak Ditemukan
            if(empty($Data['id_shu_session'])){
                echo '
                    <div class="alert alert-danger">
                        <small>Data Sesi SHU tidak ditemukan!</small>
                    </div>
                ';
            }else{
                //Buat Variabel
                $periode_hitung1=$Data['periode_hitung1'];
                $periode_hitung2=$Data['periode_hitung2'];
                $total_penjualan=$Data['total_penjualan'];
                $total_simpanan=$Data['total_simpanan'];
                $total_pinjaman=$Data['total_pinjaman'];
                $persen_penjualan=$Data['persen_penjualan'];
                $persen_simpanan=$Data['persen_simpanan'];
                $persen_pinjaman=$Data['persen_pinjaman'];
                $shu=$Data['shu'];
                $status=$Data['status'];

                //Format tanggal
                $periode_hitung1=date('d/m/Y',strtotime($periode_hitung1));
                $periode_hitung2=date('d/m/Y',strtotime($periode_hitung2));

                //Format Rupiah
                $shu_rp = "Rp " . number_format($shu,0,',','.');
                $total_penjualan_rp = "Rp " . number_format($total_penjualan,0,',','.');
                $total_simpanan_rp = "Rp " . number_format($total_simpanan,0,',','.');
                $total_pinjaman_rp = "Rp " . number_format($total_pinjaman,0,',','.');

                //Label Status
                if($status=="Pending"){
                    $LabelStatus='<span class="badge badge-warning">Pending</span>';
                }else{
                    $LabelStatus='<span class="badge badge-success">'.$status.'</span>';
                }

                 //Jumlah Anggota
                $JumlahRincian = mysqli_num_rows(mysqli_query($Conn, "SELECT*FROM shu_rincian WHERE id_shu_session='$id_shu_session'"));
                $JumlahRincian = "" . number_format($JumlahRincian,0,',','.');

                //Jumlah Rincian SHU
                $sum_alokasi= mysqli_fetch_array(mysqli_query($Conn, "SELECT SUM(shu) AS jumlah FROM shu_rincian WHERE id_shu_session='$id_shu_session'"));
                if(!empty($sum_alokasi['jumlah'])){
                    $jumlah_alokasi = $sum_alokasi['jumlah'];
                }else{
                    $jumlah_alokasi =0;
                }
                $jumlah_alokasi_rp = "Rp " . number_format($jumlah_alokasi,0,',','.');
?>
    <input type="hidden" name="id_shu_session" id="GetIdShuSession" value="<?php echo "$id_shu_session"; ?>">
    <div class="card">
        <div class="card-header">
            <div class="row">
                <div class="col-8">
                    <b class="card-title">
                        <i class="bi bi-info-circle"></i> Detail Sesi Bagi Hasil (SHU)
                    </b>
                </div>
                <div class="col-4 text-end">
                    <a href="index.php?Page=BagiHasil" class="btn btn-md btn-dark btn-floating" title="Kembali Ke Daftar Sesi SHU">
                        <i class="bi bi-chevron-left"></i>
                    </a>
                </div>
            </div>
        </div>
        <div class="card-body">
            <div class="modal-body" id="detail_shu_inline">
                <!-- Menampilkan Detail SHU -->
            </div>
        </div>
        <div class="card-footer text-end">
            <button type="button" class="btn btn-md btn-secondary btn-floating" data-bs-toggle="modal" data-bs-target="#ModalEditBagiHasil" data-id="<?php echo $id_shu_session; ?>" title="Edit Sesi SHU">
                <i class="bi bi-pencil"></i>
            </button>
            <button type="button" class="btn btn-md btn-secondary btn-floating" data-bs-toggle="modal" data-bs-target="#ModalHapusBagiHasil" data-id="<?php echo $id_shu_session; ?>" title="Hapus Sesi SHU">
                <i class="bi bi-trash"></i>
            </button>
        </div>
    </div>
    <div class="card">
        <div class="card-body">
            <ul class="nav nav-tabs nav-tabs-bordered d-flex" id="borderedTabJustified" role="tablist">
                <li class="nav-item flex-fill" role="presentation">
                    <button class="nav-link w-100 active" id="home-tab" data-bs-toggle="tab" data-bs-target="#bordered-justified-home" type="button" role="tab" aria-controls="home" aria-selected="true">
                        1. Rincian
                    </button>
                </li>
                <li class="nav-item flex-fill" role="presentation">
                    <button class="nav-link w-100" id="pembayaran-tab" data-bs-toggle="tab" data-bs-target="#bordered-justified-pembayaran" type="button" role="tab" aria-controls="pembayaran" aria-selected="false" tabindex="-1">
                        2. Pembayaran
                    </button>
                </li>
                <li class="nav-item flex-fill" role="presentation">
                    <button class="nav-link w-100" id="profile-tab" data-bs-toggle="tab" data-bs-target="#bordered-justified-profile" type="button" role="tab" aria-controls="profile" aria-selected="false" tabindex="-1">
                        3. Jurnal
                    </button>
                </li>
            </ul>
        </div>
    </div>
    <div class="tab-content pt-2" id="borderedTabJustifiedContent">
        <div class="tab-pane fade active show" id="bordered-justified-home" role="tabpanel" aria-labelledby="home-tab">
            <div class="row">
                <div class="col-md-12">
                    <div class="card">
                        <div class="card-header">
                            <div class="row">
                                <div class="col-8">
                                    <b class="card-title">
                                        # Rincian Bagi Hasil (SHU)
                                    </b>
                                </div>
                                <div class="col-4 text-end">
                                    <button type="button" class="btn btn-sm btn-outline-dark btn-floating" data-bs-toggle="dropdown" aria-expanded="false">
                                        <i class="bi bi-three-dots"></i>
                                    </button>
                                    <ul class="dropdown-menu dropdown-menu-end dropdown-menu-arrow" style="">
                                        <li class="dropdown-header text-start">
                                            <h6>Option</h6>
                                        </li>
                                        <li>
                                            <a class="dropdown-item" href="javascript:void(0)" data-bs-toggle="modal" data-bs-target="#ModalFilterRincianShu" data-id="<?php echo $id_shu_session; ?>">
                                                <i class="bi bi-filter"></i> Filter
                                            </a>
                                        </li>
                                        <li>
                                            <a class="dropdown-item" href="javascript:void(0)" data-bs-toggle="modal" data-bs-target="#ModalPilihAnggota" data-id="<?php echo $id_shu_session; ?>">
                                                <i class="bi bi-plus-circle"></i> Tambah Manual
                                            </a>
                                        </li>
                                        <li>
                                            <a class="dropdown-item" href="javascript:void(0)" data-bs-toggle="modal" data-bs-target="#ModalImportRincian" data-id="<?php echo $id_shu_session; ?>">
                                                <i class="bi bi-upload"></i> Import Dari Excel
                                            </a>
                                        </li>
                                        <li>
                                            <a class="dropdown-item" href="javascript:void(0)" data-bs-toggle="modal" data-bs-target="#ModalHitungShu" data-id="<?php echo $id_shu_session; ?>">
                                                <i class="bi bi-repeat"></i> Hitung Otomatis
                                            </a>
                                        </li>
                                        <li>
                                            <a class="dropdown-item" href="javascript:void(0)" data-bs-toggle="modal" data-bs-target="#ModalExportRincianShu" data-id="<?php echo $id_shu_session; ?>">
                                                <i class="bi bi-download"></i> Export/Download
                                            </a>
                                        </li>
                                        <li>
                                            <a class="dropdown-item" href="javascript:void(0)" data-bs-toggle="modal" data-bs-target="#ModalHapusSemuaRincian" data-id="<?php echo $id_shu_session; ?>">
                                                <i class="bi bi-trash"></i> Hapus Semua Rincian
                                            </a>
                                        </li>
                                    </ul>
                                </div>
                            </div>
                        </div>
                        <div class="card-body">
                            <div class="table table-responsive">
                                <table class="table table-hover table-striped">
                                    <thead>
                                        <tr>
                                            <th><b>No</b></th>
                                            <th><b>Anggota</b></th>
                                            <th><b>NIP</b></th>
                                            <th><b>SHU Penjualan</b></th>
                                            <th><b>SHU Simpanan</b></th>
                                            <th><b>SHU Pinjaman</b></th>
                                            <th><b>SHU Anggota</b></th>
                                            <th><b>Opsi</b></th>
                                        </tr>
                                    </thead>
                                    <tbody id="MenampilkanRincianBagiHasil">
                                        <!-- Menampilkan Rincian Bagi Hasil Disini -->
                                        <tr>
                                            <td class="text-center" colspan="8">
                                                <small class="text-danger">Tidak Ada Data Yang Ditampilkan</small>
                                            </td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                        <div class="card-footer">
                            <div class="row">
                                <div class="col-6">
                                    <small id="page_info_rincian">
                                        Page 1 Of 100
                                    </small>
                                </div>
                                <div class="col-6 text-end">
                                    <button type="button" class="btn btn-sm btn-outline-info btn-floating" id="prev_button_rincian">
                                        <i class="bi bi-chevron-left"></i>
                                    </button>
                                    <button type="button" class="btn btn-sm btn-outline-info btn-floating" id="next_button_rincian">
                                        <i class="bi bi-chevron-right"></i>
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="tab-pane fade" id="bordered-justified-profile" role="tabpanel" aria-labelledby="profile-tab">
            <div class="row">
                <div class="col-md-12">
                    <div class="card">
                        <div class="card-header">
                            <div class="row">
                                <div class="col-10">
                                    <b class="card-title"># Jurnal SHU</b>
                                </div>
                                <div class="col-2 text-end">
                                    <button type="button" class="btn btn-md btn-primary btn-block" data-bs-toggle="modal" data-bs-target="#ModalTambahJurnal" data-id="<?php echo "$id_shu_session"; ?>" title="Tambah Jurnal">
                                        <i class="bi bi-plus-lg"></i> Buat Jurnal
                                    </button>
                                </div>
                            </div>
                        </div>
                        <div class="card-body">
                            <div class="table table-responsive">
                                <table class="table table-hover table-striped">
                                    <thead>
                                        <tr>
                                            <th><b>No</b></th>
                                            <th><b>Kode</b></th>
                                            <th><b>Akun</b></th>
                                            <th><b>Debet</b></th>
                                            <th><b>Kredit</b></th>
                                            <th class="text-center"><b>Opsi</b></th>
                                        </tr>
                                    </thead>
                                    <tbody id="TabelJurnalShu">
                                        <tr>
                                            <td colspan="6" class="text-center">
                                                <small class="text-danger">Tidak Ada Jurnal SHU Yang Ditampilkan</small>
                                            </td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="tab-pane fade" id="bordered-justified-pembayaran" role="tabpanel" aria-labelledby="pembayaran-tab">
            <div class="row">
                <div class="col-md-12">
                    <div class="card">
                        <div class="card-header">
                            <b class="card-title">
                                # Informasi Pembayaran Pembagian SHU
                            </b>
                        </div>
                        <div class="card-body">
                            <div class="row">
                                <div class="col-md-12" id="MenampilkanInformasiPembayaran">
                                    <!-- Menampilkan Informasi Pembayaran Disini -->
                                </div>
                            </div>
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
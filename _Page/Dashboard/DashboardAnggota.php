<?php
    //Jumlah Pinjaman
    $SumPinjaman = mysqli_fetch_array(mysqli_query($Conn, "SELECT SUM(jumlah_pinjaman) AS jumlah_pinjaman FROM pinjaman WHERE id_anggota='$SessionIdAkses'"));
    $JumlahPinjaman = $SumPinjaman['jumlah_pinjaman'];
    if(empty($JumlahPinjaman)){
        $JumlahPinjaman=0;
    }
    $JumlahPinjamanFormat = "" . number_format($JumlahPinjaman,0,',','.');
    //Jumlah Angsuran
    $SumAngsuran = mysqli_fetch_array(mysqli_query($Conn, "SELECT SUM(jumlah) AS jumlah FROM pinjaman_angsuran WHERE id_anggota='$SessionIdAkses'"));
    $JumlahAngsuran = $SumAngsuran['jumlah'];
    if(empty($JumlahAngsuran)){
        $JumlahAngsuran=0;
    }
    $JumlahAngsuranFormat = "" . number_format($JumlahAngsuran,0,',','.');
    //Simpanan Kotor
    $SumSimpananKotor = mysqli_fetch_array(mysqli_query($Conn, "SELECT SUM(jumlah) AS jumlah FROM simpanan WHERE kategori!='Penarikan' AND id_anggota='$SessionIdAkses'"));
    $JumlahSimpananKotor = $SumSimpananKotor['jumlah'];
    if(empty($JumlahSimpananKotor)){
        $JumlahSimpananKotor=0;
    }
    $JumlahSimpananKotorFormat = "" . number_format($JumlahSimpananKotor,0,',','.');
    //Penarikan Simpanan
    $SumPenarikan = mysqli_fetch_array(mysqli_query($Conn, "SELECT SUM(jumlah) AS jumlah FROM simpanan WHERE kategori='Penarikan' AND id_anggota='$SessionIdAkses'"));
    $JumlahPenarikan = $SumPenarikan['jumlah'];
    if(empty($JumlahPenarikan)){
        $JumlahPenarikan=0;
    }
    $JumlahPenarikanFormat = "" . number_format($JumlahPenarikan,0,',','.');
    //Jumlah Simpanan Bersih
    $JumlahSimpananBersih=$JumlahSimpananKotor-$JumlahPenarikan;
    $JumlahSimpananBersihFormat = "" . number_format($JumlahSimpananBersih,0,',','.');
?>
<div class="pagetitle">
    <h1>
        <a href="">
            <i class="bi bi-grid"></i> Dashboard
        </a>
    </h1>
    <nav>
        <ol class="breadcrumb">
            <li class="breadcrumb-item active">Dashboard</li>
        </ol>
    </nav>
</div>
<section class="section dashboard">
    <div class="row">
        <div class="col-md-12">
            <?php
                if($SessionStatusAnggota=="Pending"){
                    echo '
                        <div class="alert alert-warning alert-dismissible fade show" role="alert">
                            <small>
                                Akun anda masih dalam proses <b>Verifikasi</b> oleh tim kami. Update perubahan status verifikasi akan diproses paling lama 3 X 24 Jam.
                                Kami akan mengirimkan perubahan status pada email anda.
                            </small>
                            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                        </div>
                    ';
                }else{
                    if($SessionStatusAnggota=="Keluar"){
                        echo '
                            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                                <small>
                                    Anda telah memutuskan untuk keluar dari keanggotaan. Silahkan ajukan aktivasi akun untuk kembali mendapatkan layanan kami.
                                </small>
                                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                            </div>
                        ';
                    }else{
                         echo '
                            <div class="alert alert-success alert-dismissible fade show" role="alert">
                                <small>
                                    Akun anda sudah <b>Aktif</b>. Anda sekarang bisa menikmati berbagai layanan kami.
                                </small>
                                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                            </div>
                        ';
                    }
                }
            ?>
        </div>
    </div>
    <div class="row">
        <div class="col-lg-12">
            <div class="row">
                <div class="col-md-12">
                    <div class="card" id="card_jam_menarik">
                        <div class="card-body">
                            <div id="tanggal_menarik">Hari, 01 Januari 1900</div>
                            <div id="jam_menarik">00:00:00</div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-md-6">
                    <div class="card info-card sales-card">
                        <div class="card-body">
                            <h5 class="card-title">Simpanan Anggota</h5>
                            <div class="d-flex align-items-center">
                                <div class="card-icon rounded-circle d-flex align-items-center justify-content-center">
                                    <i class="bi bi-cash-coin"></i>
                                </div>
                                <div class="ps-3">
                                    <?php
                                        echo '  <span class="text-muted small pt-1 fw-bold">'.$JumlahSimpananBersihFormat.'</span><br>';
                                        echo '  <span class="text-muted small pt-2 ps-1">Rp/IDR</span>';
                                    ?>
                                </div>
                            </div>
                        </div>
                        <div class="card-footer">
                            <small>
                                <a href="index.php?Page=RiwayatAnggota&Sub=Simpanan" class="btn btn-sm btn-secondary btn-rounded">
                                    Lihat Selengkapnya
                                </a>
                            </small>
                        </div>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="card info-card sales-card">
                        <div class="card-body">
                            <h5 class="card-title">Penarikan Dana</h5>
                            <div class="d-flex align-items-center">
                                <div class="card-icon rounded-circle d-flex align-items-center justify-content-center">
                                    <i class="bi bi-cash-coin"></i>
                                </div>
                                <div class="ps-3">
                                    <?php
                                        echo '  <span class="text-muted small pt-1 fw-bold">'.$JumlahPenarikanFormat.'</span><br>';
                                        echo '  <span class="text-muted small pt-2 ps-1">Rp/IDR</span>';
                                    ?>
                                </div>
                            </div>
                        </div>
                        <div class="card-footer">
                            <small>
                                <a href="index.php?Page=RiwayatAnggota&Sub=Penarikan" class="btn btn-sm btn-secondary btn-rounded">Lihat Selengkapnya</a>
                            </small>
                        </div>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="card info-card sales-card">
                        <div class="card-body">
                            <h5 class="card-title">Pinjaman Anggota</h5>
                            <div class="d-flex align-items-center">
                                <div class="card-icon rounded-circle d-flex align-items-center justify-content-center">
                                    <i class="bi bi-bank"></i>
                                </div>
                                <div class="ps-3">
                                    <?php
                                        echo '  <span class="text-muted small pt-1 fw-bold">'.$JumlahPinjamanFormat.'</span><br>';
                                        echo '  <span class="text-muted small pt-2 ps-1">Rp/IDR</span>';
                                    ?>
                                </div>
                            </div>
                        </div>
                        <div class="card-footer">
                            <small>
                                <a href="index.php?Page=RiwayatAnggota&Sub=Pinjaman" class="btn btn-sm btn-secondary btn-rounded">Lihat Selengkapnya</a>
                            </small>
                        </div>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="card info-card sales-card">
                        <div class="card-body">
                            <h5 class="card-title">Angsuran Pinjaman</h5>
                            <div class="d-flex align-items-center">
                                <div class="card-icon rounded-circle d-flex align-items-center justify-content-center">
                                    <i class="bi bi-bank"></i>
                                </div>
                                <div class="ps-3">
                                    <?php
                                        echo '  <span class="text-muted small pt-1 fw-bold">'.$JumlahAngsuranFormat.'</span><br>';
                                        echo '  <span class="text-muted small pt-2 ps-1">Rp/IDR</span>';
                                    ?>
                                </div>
                            </div>
                        </div>
                        <div class="card-footer">
                            <small>
                                <a href="index.php?Page=RiwayatAnggota&Sub=Angsuran" class="btn btn-sm btn-secondary btn-rounded">Lihat Selengkapnya</a>
                            </small>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
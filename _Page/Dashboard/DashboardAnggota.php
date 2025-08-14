<?php
    
    //Jumlah Angsuran Yang Belum Dibayar
    $SumAngsuran = mysqli_fetch_array(mysqli_query($Conn, "SELECT SUM(jumlah) AS jumlah FROM pinjaman_angsuran WHERE id_anggota='$SessionIdAkses' AND status='None'"));
    $JumlahAngsuran = $SumAngsuran['jumlah'];
    if(empty($JumlahAngsuran)){
        $JumlahAngsuran=0;
    }
    $JumlahAngsuranFormat = "Rp " . number_format($JumlahAngsuran,0,',','.');
    
    //Simpanan Kotor
    $SumSimpananKotor = mysqli_fetch_array(mysqli_query($Conn, "SELECT SUM(jumlah) AS jumlah FROM simpanan WHERE kategori!='Penarikan' AND id_anggota='$SessionIdAkses' AND status='Lunas'"));
    $JumlahSimpananKotor = $SumSimpananKotor['jumlah'];
    if(empty($JumlahSimpananKotor)){
        $JumlahSimpananKotor=0;
    }
    $JumlahSimpananKotorFormat = "" . number_format($JumlahSimpananKotor,0,',','.');
    
    //Penarikan Simpanan
    $SumPenarikan = mysqli_fetch_array(mysqli_query($Conn, "SELECT SUM(nominal) AS nominal FROM simpanan_penarikan WHERE id_anggota='$SessionIdAkses' AND status='Lunas'"));
    $JumlahPenarikan = $SumPenarikan['nominal'];
    if(empty($JumlahPenarikan)){
        $JumlahPenarikan=0;
    }
    $JumlahPenarikanFormat = "" . number_format($JumlahPenarikan,0,',','.');

    //Jumlah Simpanan Bersih
    $JumlahSimpananBersih=$JumlahSimpananKotor-$JumlahPenarikan;
    $JumlahSimpananBersihFormat = "Rp " . number_format($JumlahSimpananBersih,0,',','.');
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
                <div class="col-md-8">
                    <div class="row">
                        <div class="col-md-6 mb-2">
                            <div class="card info-card revenue-card">
                                <div class="card-body">
                                    <h5 class="card-title">Simpanan <span>| Netto</span></h5>
                                    <div class="d-flex align-items-center">
                                        <div class="card-icon rounded-circle d-flex align-items-center justify-content-center">
                                            <i class="bi bi-currency-dollar"></i>
                                        </div>
                                        <div class="ps-3">
                                            <h6><?php echo $JumlahSimpananBersihFormat; ?></h6>
                                            <span class="text-muted small pt-2 ps-1">
                                                Total Simpanan Anda
                                            </span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6 mb-2">
                            <div class="card info-card sales-card">
                                <div class="card-body">
                                    <h5 class="card-title">Pinjaman <span>| Kredit</span></h5>
                                    <div class="d-flex align-items-center">
                                        <div class="card-icon rounded-circle d-flex align-items-center justify-content-center">
                                            <i class="bi bi-cart"></i>
                                        </div>
                                        <div class="ps-3">
                                            <h6><?php echo $JumlahAngsuranFormat; ?></h6>
                                            <span class="text-muted small pt-2 ps-1">
                                                Sisa Angsuran
                                            </span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-12 mb-2">
                            <div class="card">
                                <div class="card-header">
                                    <b class="card-title"># Ringkasan Simpanan Anggota</b>
                                </div>
                                <div class="card-body">
                                    <div class="table table-responsive">
                                        <table class="table table-striped table-hover">
                                            <thead>
                                                <tr>
                                                    <th><b>No</b></th>
                                                    <th><b>Simpanan</b></th>
                                                    <th class="text-end"><b>Simpanan</b></th>
                                                    <th class="text-end"><b>Penarikan</b></th>
                                                    <th class="text-end"><b>Saldo</b></th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <?php
                                                    //Menampilkan Kategori Simpanan
                                                    $no=1;
                                                    $Saldo=0;
                                                    $QryKategoriSimpanan = mysqli_query($Conn, "SELECT * FROM simpanan_jenis ORDER BY kategori ASC");
                                                    if (!$QryKategoriSimpanan) {
                                                        die("Error fetching simpanan pokok: " . mysqli_error($Conn));
                                                    }
                                                    while ($DataKategoriSimpanan = mysqli_fetch_assoc($QryKategoriSimpanan)) {
                                                        $id_simpanan_jenis = $DataKategoriSimpanan['id_simpanan_jenis'];
                                                        $nama_simpanan = $DataKategoriSimpanan['nama_simpanan'];
                                                        $kategori = $DataKategoriSimpanan['kategori'];

                                                        //Menghitung Simpanan Berdasarkan Kategori
                                                        $SumSimpanan = mysqli_fetch_array(mysqli_query($Conn, "SELECT SUM(jumlah) AS jumlah FROM simpanan WHERE id_simpanan_jenis='$id_simpanan_jenis' AND id_anggota='$SessionIdAkses' AND status='Lunas'"));
                                                        $JumlahSimpanan = $SumSimpanan['jumlah'];
                                                        if(empty($JumlahSimpanan)){
                                                            $JumlahSimpanan=0;
                                                        }
                                                        $JumlahSimpananFormat = "Rp " . number_format($JumlahSimpanan,0,',','.');

                                                        //Menghitung Penarikan
                                                        $SumPenarikanJenis = mysqli_fetch_array(mysqli_query($Conn, "SELECT SUM(nominal) AS nominal FROM simpanan_penarikan WHERE id_simpanan_jenis='$id_simpanan_jenis' AND id_anggota='$SessionIdAkses' AND status='Lunas'"));
                                                        $JumlahPenarikanJenis = $SumPenarikanJenis['nominal'];
                                                        if(empty($JumlahPenarikanJenis)){
                                                            $JumlahPenarikanJenis=0;
                                                        }
                                                        $JumlahPenarikanJenisFormat = "Rp " . number_format($JumlahPenarikanJenis,0,',','.');

                                                        //Menghitung Saldo
                                                        $JumlahSaldo=$JumlahSimpanan-$JumlahPenarikanJenis;
                                                        $JumlahSaldoFormat = "Rp " . number_format($JumlahSaldo,0,',','.');

                                                        //Hitung Saldo Total
                                                        $Saldo=$Saldo+$JumlahSaldo;
                                                        
                                                        echo '
                                                            <tr>
                                                                <td><small>'.$no.'</small></td>
                                                                <td><small>'.$nama_simpanan.'</small></td>
                                                                <td class="text-end"><small class="text-success">'.$JumlahSimpananFormat.'</small></td>
                                                                <td class="text-end"><small class="text-danger">'.$JumlahPenarikanJenisFormat.'</small></td>
                                                                <td class="text-end"><small>'.$JumlahSaldoFormat.'</small></td>
                                                            </tr>
                                                        ';
                                                        $no++;
                                                    }
                                                    $SaldoFormat = "Rp " . number_format($Saldo,0,',','.');
                                                    echo '
                                                        <tr>
                                                            <td><small></small></td>
                                                            <td><small>TOTAL SALDO</small></td>
                                                            <td class="text-end"><small></small></td>
                                                            <td class="text-end"><small></small></td>
                                                            <td class="text-end"><small class="text text-decoration-underline">'.$SaldoFormat.'</small></td>
                                                        </tr>
                                                    ';
                                                ?>
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="card">
                        <div class="card-header">
                            <b class="card-title">Informasi Umum</b>
                        </div>
                        <div class="card-body">
                            <!-- Default Accordion -->
                            <div class="accordion" id="accordionExample">
                                <div class="accordion-item">
                                    <h2 class="accordion-header" id="headingOne">
                                        <button class="accordion-button" type="button" data-bs-toggle="collapse" data-bs-target="#collapseOne" aria-expanded="true" aria-controls="collapseOne">
                                            Syarat Umum Keanggotaan
                                        </button>
                                    </h2>
                                    <div id="collapseOne" class="accordion-collapse collapse show" aria-labelledby="headingOne" data-bs-parent="#accordionExample">
                                        <div class="accordion-body">
                                            Syarat umum keanggotaan koperasi di Indonesia biasanya diatur berdasarkan 
                                            <b>Undang-Undang No. 25 Tahun 1992</b> tentang Perkoperasian dan anggaran dasar (AD/ART) koperasi yang bersangkutan. 
                                            Berikut adalah persyaratan umumnya:
                                            <ul>
                                                <li>Warga Negara Indonesia (WNI)</li>
                                                <li>Usia minimal 17 tahun</li>
                                                <li>Menyetujui AD/ART Koperasi</li>
                                                <li>Membayar Simpanan Pokok & Wajib</li>
                                                <li>Aktif berpartisipasi dalam kegiatan koperasi.</li>
                                                <li>Membayar simpanan dan iuran sesuai ketentuan.</li>
                                                <li>Mematuhi keputusan Rapat Anggota.</li>
                                                <li>Menjaga nama baik koperasi.</li>
                                            </ul>
                                        </div>
                                    </div>
                                </div>
                                <div class="accordion-item">
                                    <h2 class="accordion-header" id="headingTwo">
                                        <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapseTwo" aria-expanded="false" aria-controls="collapseTwo">
                                            Tentang Simpanan Anggota
                                        </button>
                                    </h2>
                                    <div id="collapseTwo" class="accordion-collapse collapse" aria-labelledby="headingTwo" data-bs-parent="#accordionExample">
                                        <div class="accordion-body">
                                            Berikut adalah jenis-jenis simpanan anggota koperasi beserta pengertiannya, 
                                            sesuai praktik umum di Indonesia berdasarkan UU No. 25 Tahun 1992 tentang Perkoperasian dan standar AD/ART koperasi:
                                            <ul class="mt-2">
                                                <li>
                                                    <b>Simpanan Pokok</b><br>
                                                    Simpanan wajib yang dibayarkan sekali oleh anggota saat pertama kali bergabung.
                                                    Simpanan ini tidak dapat ditarik selama masih menjadi anggota.
                                                    Tujuannya adalah sebagai bukti kepemilikan dan partisipasi dalam koperasi.
                                                </li>
                                                <li>
                                                    <b>Simpanan Wajib</b><br>
                                                    Simpanan rutin yang harus dibayar anggota secara berkala (bulanan/triwulanan).
                                                    Simpanan ini bersifat wajib dan biasanya jumlahnya ditetapkan oleh koperasi.
                                                    Tujuannya adalah menjadi sumber modal kerja koperasi.
                                                </li>
                                                <li>
                                                    <b>Simpanan Sukarela</b><br>
                                                    Simpanan yang disetor anggota secara sukarela (tidak wajib) di luar simpanan pokok dan wajib.
                                                    Simpanan ini dapat ditarik sesuai ketentuan koperasi (biasanya dengan pemberitahuan).
                                                    Tujuannya adalah memperkuat modal koperasi dan anggota bisa mendapatkan bunga/imbal hasil.
                                                </li>
                                            </ul>
                                        </div>
                                    </div>
                                </div>
                                <div class="accordion-item">
                                    <h2 class="accordion-header" id="heading3">
                                        <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapse3" aria-expanded="false" aria-controls="collapse3">
                                            Tentang Pinjaman Anggota
                                        </button>
                                    </h2>
                                    <div id="collapse3" class="accordion-collapse collapse" aria-labelledby="heading3" data-bs-parent="#accordionExample">
                                        <div class="accordion-body">
                                            Berikut penjelasan lengkap tentang pinjaman anggota koperasi, mencakup jenis, syarat, mekanisme, 
                                            dan ketentuannya sesuai regulasi koperasi di Indonesia:
                                            <ul class="mt-2">
                                                <li>
                                                    <b>Pinjaman Konsumtif</b><br>
                                                    Kebutuhan pribadi (seperti biaya pendidikan, pernikahan, atau renovasi rumah).
                                                </li>
                                                <li>
                                                    <b>Pinjaman Produktif</b><br>
                                                    Modal usaha atau kegiatan penghasil pendapatan (misal: beli alat pertanian, tambah stok dagangan).
                                                </li>
                                                <li>
                                                    <b>Pinjaman Lunak</b><br>
                                                    Program khusus (contoh: pinjaman darurat atau subsidi pemerintah).
                                                </li>
                                            </ul>
                                        </div>
                                    </div>
                                </div>
                                <div class="accordion-item">
                                    <h2 class="accordion-header" id="heading4">
                                        <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapse4" aria-expanded="false" aria-controls="collapse4">
                                            Penarikan Dana Simpanan
                                        </button>
                                    </h2>
                                    <div id="collapse4" class="accordion-collapse collapse" aria-labelledby="heading4" data-bs-parent="#accordionExample">
                                        <div class="accordion-body">
                                            Selama anda menjadi anggota koperasi, anda hanya bisa menarik dana simpanan sukarela. 
                                            Simpanan pokok dan simpanan wajib hanya bisa ditarik pada saat anda keluar dari keanggotaan. 
                                            Berikut ini adalah tahapan penarikan dana simpanan tersebut :
                                            <ul class="mt-2">
                                                <li>
                                                    Pilih menu <b>Penarikan</b> dan anda akan diarahkan ke halaman penarikan dana simpanan.
                                                </li>
                                                <li>
                                                    Pada bagian baris tabel simpanan sukarela, pilih salah satu jenis simpanan kemudian <i>click</i> pada tombol <b>Tarik</b>
                                                </li>
                                                <li>
                                                    Pastikan saldo dana simpanan anda memenuhi dengan status lunas.
                                                </li>
                                                <li>
                                                    Sistem akan menampilkan formulir isian, diantaranya adalah form nominal penarikan, nama bank tujuan penarikan, dan nomor rekening.
                                                </li>
                                                <li>
                                                    Setelah mengisi form tersebut, kemudian <i>click</i> tombol kirim.
                                                </li>
                                                <li>
                                                   Pengurus koperasi akan melakukan verifikasi data permohonan penarikan dana tersebut.
                                                </li>
                                            </ul>
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
</section>
<div class="pagetitle">
    <h1>
        <a href="">
            <i class="bi bi-bank"></i> Detail Simpanan</a>
        </a>
    </h1>
    <nav>
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="index.php">Dashboard</a></li>
            <li class="breadcrumb-item"><a href="index.php?Page=SimpananAnggota">Simpanan Anggota</a></li>
            <li class="breadcrumb-item active"> Detail Simpanan</li>
        </ol>
    </nav>
</div>
<section class="section dashboard">
    <?php
        //Tangkap Data UUID
        if(empty($_GET['uuid'])){
            echo '
                <div class="row">
                    <div class="col-12">
                        <div class="alert-danger">
                            UUID Tidak Boleh Kosong!
                        </div>
                    </div>
                </div>
            ';
        }else{
            $uuid=$_GET['uuid'];
            $id_anggota=GetDetailData($Conn,'simpanan','uuid_simpanan',$uuid,'id_anggota');
            $id_simpanan=GetDetailData($Conn,'simpanan','uuid_simpanan',$uuid,'id_simpanan');
            $id_simpanan_jenis=GetDetailData($Conn,'simpanan','uuid_simpanan',$uuid,'id_simpanan_jenis');
            $tanggal_simpanan=GetDetailData($Conn,'simpanan','uuid_simpanan',$uuid,'tanggal_simpanan');
            $tanggal_bayar=GetDetailData($Conn,'simpanan','uuid_simpanan',$uuid,'tanggal_bayar');
            $kategori=GetDetailData($Conn,'simpanan','uuid_simpanan',$uuid,'kategori');
            $jumlah=GetDetailData($Conn,'simpanan','uuid_simpanan',$uuid,'jumlah');
            $metode_pembayaran=GetDetailData($Conn,'simpanan','uuid_simpanan',$uuid,'metode_pembayaran');
            $status=GetDetailData($Conn,'simpanan','uuid_simpanan',$uuid,'status');

            //Informasi Jenis Simpanan
            $nama_simpanan=GetDetailData($Conn,'simpanan_jenis','id_simpanan_jenis',$id_simpanan_jenis,'nama_simpanan');

            //Informasi Anggota
            $nama_anggota=GetDetailData($Conn,'anggota','id_anggota',$id_anggota,'nama');
            $nip=GetDetailData($Conn,'anggota','id_anggota',$id_anggota,'nip');
            $email=GetDetailData($Conn,'anggota','id_anggota',$id_anggota,'email');
            $kontak=GetDetailData($Conn,'anggota','id_anggota',$id_anggota,'kontak');

            //Format
            $jumlah_format = "Rp " . number_format($jumlah,0,',','.');

            //Label Status Bayar
            if($status=="Pending"){
                $label_status='<span class="badge badge-danger">Pending</span>';
            }else{
                $label_status='<span class="badge badge-success">Lunas</span>';
            }

            //Menghitung Expired time
            $tanggal_bayar = "10-08-2025 10:25:05";
            $date = new DateTime($tanggal_bayar);
            $date->add(new DateInterval('PT24H'));

            echo '
                <div class="card">
                    <div class="card-header">
                        <div class="row">
                            <div class="col-8">
                                <b class="card-title">
                                    <i class="bi bi-info-circle"></i> Informasi Simpanan
                                </b>
                            </div>
                            <div class="col-4 text-end">
                                <a href="index.php?Page=SimpananAnggota" class="btn btn-md btn-secondary btn-floating" title="Kembali Ke Riwayat Simpanan">
                                    <i class="bi bi-chevron-left"></i>
                                </a>
                                <a href="" class="btn btn-md btn-outline-dark btn-floating" title="Reload Halaman">
                                    <i class="bi bi-repeat"></i>
                                </a>
                            </div>
                        </div>
                    </div>
                    <div class="card-body">
                        <div class="row mb-2">
                            <div class="col-md-6 mb-2">
                                <div class="row mb-2">
                                    <div class="col-3"><small>ID</small></div>
                                    <div class="col-1"><small>:</small></div>
                                    <div class="col-8"><small><code class="text text-grayish">'.$id_simpanan.'</code></small></div>
                                </div>
                                <div class="row mb-2">
                                    <div class="col-3"><small>Kode/Nama</small></div>
                                    <div class="col-1"><small>:</small></div>
                                    <div class="col-8"><small><code class="text text-grayish">'.$nama_simpanan.'</code></small></div>
                                </div>
                                <div class="row mb-2">
                                    <div class="col-3"><small>Kategori</small></div>
                                    <div class="col-1"><small>:</small></div>
                                    <div class="col-8"><small><code class="text text-grayish">'.$kategori.'</code></small></div>
                                </div>
                                <div class="row mb-2">
                                    <div class="col-3"><small>Periode</small></div>
                                    <div class="col-1"><small>:</small></div>
                                    <div class="col-8"><small><code class="text text-grayish">'.$tanggal_simpanan.'</code></small></div>
                                </div>
                                <div class="row mb-2">
                                    <div class="col-3"><small>Tanggal</small></div>
                                    <div class="col-1"><small>:</small></div>
                                    <div class="col-8"><small><code class="text text-grayish" id="get_tanggal_bayar">'.$tanggal_bayar.'</code></small></div>
                                </div>
                                <div class="row mb-2">
                                    <div class="col-3"><small>Nominal</small></div>
                                    <div class="col-1"><small>:</small></div>
                                    <div class="col-8"><small><code class="text text-grayish">'.$jumlah_format.'</code></small></div>
                                </div>
                                <div class="row mb-2">
                                    <div class="col-3"><small>Metode</small></div>
                                    <div class="col-1"><small>:</small></div>
                                    <div class="col-8"><small><code class="text text-grayish">'.$metode_pembayaran.'</code></small></div>
                                </div>
                                <div class="row mb-2">
                                    <div class="col-3"><small>Status</small></div>
                                    <div class="col-1"><small>:</small></div>
                                    <div class="col-8"><small>'.$label_status.'</small></div>
                                </div>
                            </div>
                            <div class="col-md-6 mb-2">
                                <div class="row mb-2">
                                    <div class="col-3"><small>ID Anggota</small></div>
                                    <div class="col-1"><small>:</small></div>
                                    <div class="col-8"><small><code class="text text-grayish">'.$id_anggota.'</code></small></div>
                                </div>
                                <div class="row mb-2">
                                    <div class="col-3"><small>Nama</small></div>
                                    <div class="col-1"><small>:</small></div>
                                    <div class="col-8"><small><code class="text text-grayish">'.$nama_anggota.'</code></small></div>
                                </div>
                                <div class="row mb-2">
                                    <div class="col-3"><small>NIK</small></div>
                                    <div class="col-1"><small>:</small></div>
                                    <div class="col-8"><small><code class="text text-grayish">'.$nip.'</code></small></div>
                                </div>
                                <div class="row mb-2">
                                    <div class="col-3"><small>Email</small></div>
                                    <div class="col-1"><small>:</small></div>
                                    <div class="col-8"><small><code class="text text-grayish">'.$email.'</code></small></div>
                                </div>
                                <div class="row mb-2">
                                    <div class="col-3"><small>Kontak</small></div>
                                    <div class="col-1"><small>:</small></div>
                                    <div class="col-8"><small><code class="text text-grayish">'.$kontak.'</code></small></div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            ';
            if($status=="Pending"){
                echo '
                    <div class="alert alert-light text-center">
                        <h4><b>Lakukan Pembayaran Sebelum</b></h4>
                        <h2>'.$date->format('d F Y H:i:s').'</h2>
                    </div>
                ';
                if($metode_pembayaran=="Retail-Indomart/Alfamart"){
                    echo '
                        <div class="alert alert-warning">
                            <h4><b>Petunjuk Pembayaran</b></h4>
                            <ol>
                                <li><small>Kunjungi retail Alfamart/Indomart terdekat</small></li>
                                <li><small>Informasikan tujuan kunjungan anda untuk melakukan pembayaran</small></li>
                                <li><small>Tunjukan kode pembayaran berikut ini <b>'.$uuid.'</b> dan petugas akan melakukan verifikasi</small></li>
                                <li><small>Lakukan pembayaran sesuai nominal yang tertera</small></li>
                                <li><small>Simpan bukti pembayaran dari retail tersebut</small></li>
                            </ol>
                        </div>
                    ';
                }else{
                    echo '
                        <div class="alert alert-warning">
                            <h4><b>Petunjuk Pembayaran</b></h4>
                            <ol>
                                <li class="mb-3">
                                    Pengguna Mobile Banking
                                    <ul>
                                        <li><small>Login ke akun mobile banking anda pada perangkat smartphone</small></li>
                                        <li><small>Pilih menu virtual account sesuai aplikasi mobile banking yang anda pilih</small></li>
                                        <li><small>Pilih tombol pembayaran baru dan sistem akan mengarahkan anda pada form kode pembayaran</small></li>
                                        <li><small>Masukan kode pembayaran <b>'.$uuid.'</b> (copy kode tersebut)</small></li>
                                        <li><small>Periksa kembali detail pembayaran anda dan jumlah nominal yang tertulis</small></li>
                                        <li><small>Pilih tombol lanjutkan kemudian masukan PIN anda</small></li>
                                        <li><small>Tunggu beberapa saat hingga pembayaran success</small></li>
                                    </ul>
                                </li>
                                <li>
                                    Pengguna ATM
                                    <ul>
                                        <li><small>Masukan kartu ATM anda dan masukan PIN</small></li>
                                        <li><small>Pilih menu pembayaran</small></li>
                                        <li><small>Masukan kode pembayaran <b>'.$uuid.'</b></small></li>
                                        <li><small>Periksa kembali detail pembayaran anda dan jumlah nominal yang tertulis</small></li>
                                        <li><small>Pilih tombol lanjutkan kemudian masukan PIN anda</small></li>
                                        <li><small>Tunggu beberapa saat hingga pembayaran success</small></li>
                                    </ul>
                                </li>
                            </ol>
                        </div>
                    ';
                }
                echo '
                    <div class="row mb-3">
                        <div class="col-12">
                            <button type="button" class="btn btn-lg btn-danger btn-rounded btn-block" data-bs-toggle="modal" data-bs-target="#ModalPembatalan" data-id="'.$uuid.'">
                                Ganti / Batalkan Pembayaran
                            </button>
                        </div>
                    </div>
                ';
            }else{
                //Jika Lunas
                echo '
                    <div class="row mb-3">
                        <div class="col-12">
                            <div class="alert alert-success">
                                <h4><b><i class="bi bi-check-circle"></i> Pembayaran Lunas</b></h4>
                                <small><b>Keterangan :</b> Pembayaran yang sudah lunas tidak bisa dibatalkan</small>
                            </div>
                        </div>
                    </div>
                ';
            }
        }
    ?>
</section>
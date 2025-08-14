<?php
    //Koneksi
    date_default_timezone_set('Asia/Jakarta');
    include "../../_Config/Connection.php";
    include "../../_Config/GlobalFunction.php";
    include "../../_Config/SettingGeneral.php";
    include "../../_Config/Session.php";
    if(empty($SessionIdAkses)){
        echo '<div class="alert alert-danger">';
        echo '  <small>';
        echo '      Sesi Akses Sudah Berakhir, Silahkan Login Ulang';
        echo '  </small>';
        echo '</div>';
    }else{
        if(empty($_POST['kode_pembayaran'])){
             echo '<div class="alert alert-danger">';
            echo '  <small>';
            echo '      Kode Pembayaran Tidak Boleh Kosong!';
            echo '  </small>';
            echo '</div>';
        }else{
            $kode_pembayaran=$_POST['kode_pembayaran'];
            $kode_pembayaran=validateAndSanitizeInput($kode_pembayaran);
            
            //Buka Detail Angsuran
            $sql = "SELECT * FROM pinjaman_angsuran WHERE kode_pembayaran = ?";
            $stmt = $Conn->prepare($sql);
            $id = 1;
            $stmt->bind_param("s", $kode_pembayaran);
            
            // Eksekusi statement
            $stmt->execute();
            
            // Ambil hasil query
            $result = $stmt->get_result();
            $DataPinjaman = $result->fetch_assoc();
            
            // Simpan hasil ke variabel
            $id_pinjaman= $DataPinjaman['id_pinjaman'] ?? null;
            $id_anggota = $DataPinjaman['id_anggota'] ?? null;
            $kode_pembayaran = $DataPinjaman['kode_pembayaran'] ?? null;
            $tanggal_angsuran = $DataPinjaman['tanggal_angsuran'] ?? null;
            $tanggal_bayar = $DataPinjaman['tanggal_bayar'] ?? null;
            $keterlambatan = $DataPinjaman['keterlambatan'] ?? null;
            $pokok = $DataPinjaman['pokok'] ?? null;
            $jasa = $DataPinjaman['jasa'] ?? null;
            $denda = $DataPinjaman['denda'] ?? null;
            $jumlah = $DataPinjaman['jumlah'] ?? null;
            $status = $DataPinjaman['status'] ?? null;
            $metode_pembayaran = $DataPinjaman['metode_pembayaran'] ?? null;
            
            // Tutup statement
            $stmt->close();
            
            if($status=="None"){
                $LabelStatus='<span class="badge badge-dark">None</span>';
            }else{
                if($status=="Lunas"){
                    $LabelStatus='<span class="badge badge-success">Lunas</span>';
                }else{
                    if($status=="Pending"){
                        $LabelStatus='<span class="badge badge-warning">Pending</span>';
                    }else{
                        $LabelStatus='<span class="badge badge-dark">NULL</span>';
                    }
                }
            }

            //Buka Data Anggota
            $tanggal_masuk=GetDetailData($Conn,'anggota','id_anggota',$id_anggota,'tanggal_masuk');
            $tanggal_keluar=GetDetailData($Conn,'anggota','id_anggota',$id_anggota,'tanggal_keluar');
            $email=GetDetailData($Conn,'anggota','id_anggota',$id_anggota,'email');
            $nip=GetDetailData($Conn,'anggota','id_anggota',$id_anggota,'nip');
            $NamaAnggota=GetDetailData($Conn,'anggota','id_anggota',$id_anggota,'nama');
            $kontak=GetDetailData($Conn,'anggota','id_anggota',$id_anggota,'kontak');

            //Informasi Pinjaman
            $tanggal_pengajuan=GetDetailData($Conn,'pinjaman','id_pinjaman',$id_pinjaman,'tanggal_pengajuan');
            $id_pinjaman_jenis=GetDetailData($Conn,'pinjaman','id_pinjaman',$id_pinjaman,'id_pinjaman_jenis');
            $jumlah_pinjaman=GetDetailData($Conn,'pinjaman','id_pinjaman',$id_pinjaman,'jumlah_pinjaman');
            $NamaPinjaman=GetDetailData($Conn, 'pinjaman_jenis', 'id_pinjaman_jenis', $id_pinjaman_jenis, 'nama_pinjaman');
            
            //Format Tanggal
            $tanggal_angsuran_format=date('d/m/Y H:i:s',strtotime($tanggal_angsuran));
            $TanggalMasuk=date('d/m/Y', strtotime($tanggal_masuk));
            $tanggal_pengajuan_format=date('d/m/Y', strtotime($tanggal_pengajuan));

            //Format Rupiah
            $pokok_format = "Rp " . number_format($pokok,0,',','.');
            $jasa_format = "Rp " . number_format($jasa,0,',','.');
            $denda_format = "Rp " . number_format($denda,0,',','.');
            $jumlah_format = "Rp " . number_format($jumlah,0,',','.');
            $jumlah_pinjaman_format = "Rp " . number_format($jumlah_pinjaman,0,',','.');

            //Tampilkan Data
            echo '
                <div class="row mb-2">
                    <div class="col-12">
                        <b># Informasi Angsuran</b>
                    </div>
                </div>
                <div class="row mb-2">
                    <div class="col-5"><small>Tanggal Angsuran</small></div>
                    <div class="col-1"><small>:</small></div>
                    <div class="col-6"><small><code class="text text-grayish">'.$tanggal_angsuran_format.'</code></small></div>
                </div>
                <div class="row mb-2">
                    <div class="col-5"><small>Angsuran Pokok</small></div>
                    <div class="col-1"><small>:</small></div>
                    <div class="col-6"><small><code class="text text-grayish">'.$pokok_format.'</code></small></div>
                </div>
                <div class="row mb-2">
                    <div class="col-5"><small>Jasa</small></div>
                    <div class="col-1"><small>:</small></div>
                    <div class="col-6"><small><code class="text text-grayish">'.$jasa_format.'</code></small></div>
                </div>
                <div class="row mb-2">
                    <div class="col-5"><small>Jumlah Angsuran</small></div>
                    <div class="col-1"><small>:</small></div>
                    <div class="col-6"><small><code class="text text-grayish">'.$jumlah_format.'</code></small></div>
                </div>
                <div class="row mb-3">
                    <div class="col-5 mb-3"><small>Status</small></div>
                    <div class="col-1 mb-3"><small>:</small></div>
                    <div class="col-6 mb-3">'.$LabelStatus.'</div>
                </div>
            ';
            echo '
                <div class="row mb-2">
                    <div class="col-12">
                        <b># Informasi Anggota</b>
                    </div>
                </div>
                <div class="row mb-2">
                    <div class="col-5"><small>Nama Anggota</small></div>
                    <div class="col-1"><small>:</small></div>
                    <div class="col-6"><small><code class="text text-grayish">'.$NamaAnggota.'</code></small></div>
                </div>
                <div class="row mb-2">
                    <div class="col-5"><small>Nomor Identitas</small></div>
                    <div class="col-1"><small>:</small></div>
                    <div class="col-6"><small><code class="text text-grayish">'.$nip.'</code></small></div>
                </div>
                <div class="row mb-2">
                    <div class="col-5"><small>Kontak</small></div>
                    <div class="col-1"><small>:</small></div>
                    <div class="col-6"><small><code class="text text-grayish">'.$kontak.'</code></small></div>
                </div>
                <div class="row mb-3">
                    <div class="col-5 mb-3"><small>Tanggal Masuk</small></div>
                    <div class="col-1 mb-3"><small>:</small></div>
                    <div class="col-6 mb-3"><small><code class="text text-grayish">'.$TanggalMasuk.'</code></small></div>
                </div>
            ';
            if($status=="Lunas"){
               echo '
                <div class="row mb-2">
                    <div class="col-12">
                        <button type="button" class="btn btn-dark btn-rounded btn-block" data-bs-dismiss="modal">
                            <i class="bi bi-x-circle"></i> Tutup
                        </button>
                    </div>
                </div>
               ';
            }else{
                if($status=="Pending"){
                    echo '
                        <div class="rowm mb-2">
                            <div class="col-12 text-center">
                                <div class="alert alert-warning">
                                    Silahkan lakukan pembayaran dengan kode pembayaran berikut ini :<br>
                                    <h3>'.$kode_pembayaran.'</h3>
                                    <small>'.$metode_pembayaran.'</small>
                                </div>
                            </div>
                        </div>
                        <div class="row mb-2">
                            <div class="col-6">
                                <button type="button" class="btn btn-danger btn-rounded btn-block" data-bs-toggle="modal" data-bs-target="#ModalPembatalanPembayaran" data-id="'.$kode_pembayaran.'">
                                    <i class="bi bi-repeat"></i> Batalkan Pembayaran
                                </button>
                            </div>
                            <div class="col-6">
                                <button type="button" class="btn btn-dark btn-rounded btn-block" data-bs-dismiss="modal">
                                    <i class="bi bi-x-circle"></i> Tutup
                                </button>
                            </div>
                        </div>
                    ';
                }
            }
        }
    }
?>
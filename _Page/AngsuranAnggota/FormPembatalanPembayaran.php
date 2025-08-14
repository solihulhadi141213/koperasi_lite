<?php
    //Koneksi
    date_default_timezone_set('Asia/Jakarta');
    include "../../_Config/Connection.php";
    include "../../_Config/GlobalFunction.php";
    include "../../_Config/SettingGeneral.php";
    include "../../_Config/Session.php";
    if(empty($SessionIdAkses)){
        echo '
            <div class="rowm mb-2">
                <div class="col-12 text-center">
                    <div class="alert alert-danger">
                        Sesi Akses Sudah Berakhir, Silahkan Login Ulang!
                    </div>
                </div>
            </div>
            <div class="row mb-2">
                <div class="col-12">
                    <button type="button" class="btn btn-dark btn-rounded btn-block" data-bs-dismiss="modal">
                        <i class="bi bi-x-circle"></i> Tutup
                    </button>
                </div>
            </div>
        ';
    }else{
        if(empty($_POST['kode_pembayaran'])){
             echo '
                <div class="rowm mb-2">
                    <div class="col-12 text-center">
                        <div class="alert alert-danger">
                            Kode Pembayaran Tidak Boleh Kosong!!
                        </div>
                    </div>
                </div>
                <div class="row mb-2">
                    <div class="col-12">
                        <button type="button" class="btn btn-dark btn-rounded btn-block" data-bs-dismiss="modal">
                            <i class="bi bi-x-circle"></i> Tutup
                        </button>
                    </div>
                </div>
            ';
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
            $id_pinjaman_angsuran= $DataPinjaman['id_pinjaman_angsuran'] ?? null;
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
            ';
            echo '
                <input type="hidden" name="id_pinjaman_angsuran" value="'.$id_pinjaman_angsuran.'">
                <div class="rowm mb-2">
                    <div class="col-12 text-center">
                        <div class="alert alert-danger">
                            <b><i class="bi bi-exclamation-triangle"></i> PENTING!</b><br>
                            <small>
                                Menghapus pembayaran angsuran ini berarti anda telah membatalkan verifikasi yang mungkin perlu dilakukan oleh pengurus.<br>
                                <b>Apakah anda yakin akan membatalkan pembayaran ini?</b>
                            </small>
                        </div>
                    </div>
                </div>
                <div class="row mb-2">
                    <div class="col-6">
                        <button type="button" class="btn btn-secondary btn-rounded btn-block show_detail_pembayaran" data-id="'.$kode_pembayaran.'" data-bs-dismiss="modal">
                            <i class="bi bi-chevron-left"></i> Kembali
                        </button>
                    </div>
                    <div class="col-6">
                        <button type="submit" class="btn btn-success btn-rounded btn-block">
                            <i class="bi bi-check"></i> Batalkan
                        </button>
                    </div>
                </div>
            ';
        }
    }
?>
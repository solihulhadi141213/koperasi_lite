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
        if(empty($_POST['id_pinjaman'])){
            echo '<div class="alert alert-danger">';
            echo '  <small>';
            echo '      ID Pinjaman Tidak Boleh Kosong!';
            echo '  </small>';
            echo '</div>';
        }else{
            $id_pinjaman=$_POST['id_pinjaman'];
            
            //Buka Detail Pinjaman
            $sql = "SELECT * FROM pinjaman WHERE id_pinjaman = ?";
            $stmt = $Conn->prepare($sql);
            $id = 1;
            $stmt->bind_param("i", $id_pinjaman);
            
            // Eksekusi statement
            $stmt->execute();
            
            // Ambil hasil query
            $result = $stmt->get_result();
            $DataPinjaman = $result->fetch_assoc();
            
            // Simpan hasil ke variabel
            $id_pinjaman_jenis = $DataPinjaman['id_pinjaman_jenis'] ?? null;
            $id_anggota = $DataPinjaman['id_anggota'] ?? null;
            $tanggal_pengajuan = $DataPinjaman['tanggal_pengajuan'] ?? null;
            $tanggal_pencairan = $DataPinjaman['tanggal_pencairan'] ?? null;
            $tanggal = $DataPinjaman['tanggal'] ?? null;
            $jumlah_pinjaman = $DataPinjaman['jumlah_pinjaman'] ?? 0;
            $rp_jasa = $DataPinjaman['rp_jasa'] ?? 0;
            $angsuran_pokok = $DataPinjaman['angsuran_pokok'] ?? 0;
            $angsuran_total = $DataPinjaman['angsuran_total'] ?? 0;
            $periode_angsuran = $DataPinjaman['periode_angsuran'] ?? 0;
            $status = $DataPinjaman['status'] ?? null;

            // Tutup statement
            $stmt->close();

            //Format tanggal
            $tanggal_pengajuan_format=date('d/m/Y',strtotime($tanggal_pengajuan));

            //Format Rupiah
            $jumlah_pinjaman_format = "Rp " . number_format($jumlah_pinjaman,0,',','.');
            $rp_jasa_format = "Rp " . number_format($rp_jasa,0,',','.');
            $angsuran_pokok_format = "Rp " . number_format($angsuran_pokok,0,',','.');
            $angsuran_total_format = "Rp " . number_format($angsuran_total,0,',','.');
            //Routing Status
            if($status=="Berjalan"){
                $LabelStatus='<span class="badge badge-info">Berjalan</span>';
            }else{
                if($status=="Lunas"){
                    $LabelStatus='<span class="badge badge-success">Lunas</span>';
                }else{
                    if($status=="Macet"){
                        $LabelStatus='<span class="badge badge-danger">Macet</span>';
                    }else{
                        if($status=="Pending"){
                            $LabelStatus='<span class="badge badge-danger">Pending</span>';
                        }else{
                            if($status=="Ditolak"){
                                $LabelStatus='<span class="badge badge-danger">Ditolak</span>';
                            }else{
                                $LabelStatus='<span class="badge badge-dark">None</span>';
                            }
                        }
                    }
                }
            }
            //Nama Jenis Pinjaman
            $NamaPinjaman=GetDetailData($Conn, 'pinjaman_jenis', 'id_pinjaman_jenis', $id_pinjaman_jenis, 'nama_pinjaman');

            //Nama Anggota
            $NamaAnggota=GetDetailData($Conn, 'anggota', 'id_anggota', $id_anggota, 'nama');
            $nip=GetDetailData($Conn, 'anggota', 'id_anggota', $id_anggota, 'nip');

            //Tampilkan Data
            echo '
                <input type="hidden" name="id_pinjaman" value="'.$id_pinjaman.'">
                <div class="row mb-2">
                    <div class="col-12">
                        <b># Informasi Anggota</b><br>
                        <small>
                            Dengan ini kami sampaikan pengajuan pinjaman dari anggota sebagaimana uraian berikut :
                        </small>
                    </div>
                </div>
                <div class="row mb-2">
                    <div class="col-5"><small>Nama Anggota</small></div>
                    <div class="col-1"><small>:</small></div>
                    <div class="col-6"><small><code class="text text-grayish">'.$NamaAnggota.'</code></small></div>
                </div>
                <div class="row mb-3">
                    <div class="col-5"><small>Nomor Identitas</small></div>
                    <div class="col-1"><small>:</small></div>
                    <div class="col-6"><small><code class="text text-grayish">'.$nip.'</code></small></div>
                </div>
            ';
            echo '
                <div class="row mb-2 mt-3">
                    <div class="col-12">
                        <b># Informasi Pinjaman</b><br>
                        <small>
                            Mengajukan pinjaman sesuai pengajuan yang telah dikirmkan sebagai berikut :
                        </small>
                    </div>
                </div>
                <div class="row mb-2">
                    <div class="col-5"><small>Tanggal Pengajuan</small></div>
                    <div class="col-1"><small>:</small></div>
                    <div class="col-6"><small><code class="text text-grayish">'.$tanggal_pengajuan_format.'</code></small></div>
                </div>
                <div class="row mb-2">
                    <div class="col-5"><small>Nama Pinjaman</small></div>
                    <div class="col-1"><small>:</small></div>
                    <div class="col-6"><small><code class="text text-grayish">'.$NamaPinjaman.'</code></small></div>
                </div>
                <div class="row mb-2">
                    <div class="col-5"><small>Jumlah Pinjaman</small></div>
                    <div class="col-1"><small>:</small></div>
                    <div class="col-6"><small><code class="text text-grayish">'.$jumlah_pinjaman_format.'</code></small></div>
                </div>
            ';
             echo '
                <div class="row mb-2 mt-3">
                    <div class="col-12">
                        <b># Informasi Verifikasi</b><br>
                        <small>
                            Telah dilakukan verifikasi data pengajuan dengan hasil sebagai berikut :
                        </small>
                    </div>
                </div>
                <div class="row mb-2">
                    <div class="col-sm-10">
                        <div class="form-check">
                            <input class="form-check-input" type="radio" name="status" id="status_diterima" value="Diterima">
                            <label class="form-check-label" for="status_diterima">
                                Pengajuan Pinjaman Diterima
                            </label>
                        </div>
                        <div class="form-check">
                            <input class="form-check-input" type="radio" name="status" id="status_ditolak" value="Ditolak">
                            <label class="form-check-label" for="status_ditolak">
                                Pengajuan Pinjaman Ditolak
                            </label>
                        </div>
                    </div>
                </div>
            ';
        }
    }
?>

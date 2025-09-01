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

            //Tampilkan Data
            echo '
                <div class="row mb-2">
                    <div class="col-12"><b># Informasi Pinjaman</b></div>
                </div>
                <div class="row mb-2">
                    <div class="col-5"><small>Nama Pinjaman</small></div>
                    <div class="col-1"><small>:</small></div>
                    <div class="col-6"><small><code class="text text-grayish">'.$NamaPinjaman.'</code></small></div>
                </div>
                <div class="row mb-2">
                    <div class="col-5"><small>Tanggal Pengajuan</small></div>
                    <div class="col-1"><small>:</small></div>
                    <div class="col-6"><small><code class="text text-grayish">'.$tanggal_pengajuan_format.'</code></small></div>
                </div>
                <div class="row mb-2">
                    <div class="col-5"><small>Nama Anggota</small></div>
                    <div class="col-1"><small>:</small></div>
                    <div class="col-6"><small><code class="text text-grayish">'.$NamaAnggota.'</code></small></div>
                </div>
                <div class="row mb-2">
                    <div class="col-5"><small>Jumlah Pinjaman</small></div>
                    <div class="col-1"><small>:</small></div>
                    <div class="col-6"><small><code class="text text-grayish">'.$jumlah_pinjaman_format.'</code></small></div>
                </div>
                <div class="row mb-2">
                    <div class="col-5"><small>Periode Angsuran</small></div>
                    <div class="col-1"><small>:</small></div>
                    <div class="col-6"><small><code class="text text-grayish">'.$periode_angsuran.' Bulan</code></small></div>
                </div>
                <div class="row mb-2">
                    <div class="col-5"><small>Angsuran Pokok</small></div>
                    <div class="col-1"><small>:</small></div>
                    <div class="col-6"><small><code class="text text-grayish">'.$angsuran_pokok_format.'</code></small></div>
                </div>
                <div class="row mb-2">
                    <div class="col-5"><small>Jasa Angsuran</small></div>
                    <div class="col-1"><small>:</small></div>
                    <div class="col-6"><small><code class="text text-grayish">'.$rp_jasa_format.'</code></small></div>
                </div>
                <div class="row mb-2">
                    <div class="col-5"><small>Angsuran Total</small></div>
                    <div class="col-1"><small>:</small></div>
                    <div class="col-6"><small><code class="text text-grayish">'.$angsuran_total_format.'</code></small></div>
                </div>
                <div class="row mb-3">
                    <div class="col-5"><small>Status Pinjaman</small></div>
                    <div class="col-1"><small>:</small></div>
                    <div class="col-6">'.$LabelStatus.'</div>
                </div>
            ';
            //Routing Berdasdarkan Status
            if($status=="Pending"){
                echo '
                    <div class="row mb-2 mt-3">
                        <div class="col-12">
                            <div class="alert alert-warning">
                                Pengajuan pinjaman tersebut memerlukan verifikasi anda. 
                                Silahkan lakukan verifikasi pengajuan pinjaman dengan memilih update pinjaman pada tombol opsi.
                            </div>
                        </div>
                    </div>
                ';
            }
            if($status=="Berjalan"||$status=="Lunas"){
                echo '
                    <div class="row mb-2 mt-3">
                        <div class="col-12">
                            <b># Angsuran Pinjaman</b>
                        </div>
                    </div>
                ';
                echo '<div class="row mb-2 mt-3">';
                echo '  <div class="col-12">';
                echo '      <div class="table table-responsive">';
                echo '          <table class="table table-striped table-hover">';
                echo '
                                    <thead>
                                        <tr>
                                            <th><b>No</b></th>
                                            <th><b>Periode</b></th>
                                            <th><b>Pokok</b></th>
                                            <th><b>Jasa</b></th>
                                            <th><b>Denda</b></th>
                                            <th><b>Jumlah</b></th>
                                            <th><b>Status</b></th>
                                        </tr>
                                    </thead>
                ';
                echo '              <tbody>';
                //Buka Data Angsuran
                $no=1;
                $query = mysqli_query($Conn, "SELECT*FROM pinjaman_angsuran WHERE id_pinjaman='$id_pinjaman' ORDER BY id_pinjaman_angsuran ASC");
                while ($data = mysqli_fetch_array($query)) {
                    $id_pinjaman_angsuran= $data['id_pinjaman_angsuran'];
                    $tanggal_angsuran= $data['tanggal_angsuran'];
                    $pokok= $data['pokok'];
                    $jasa= $data['jasa'];
                    $denda= $data['denda'];
                    $jumlah= $data['jumlah'];
                    $status_angsuran= $data['status'];

                    //Format RP
                    $pokok_format = "Rp " . number_format($pokok,0,',','.');
                    $jasa_format = "Rp " . number_format($jasa,0,',','.');
                    $denda_format = "Rp " . number_format($denda,0,',','.');
                    $jumlah_format = "Rp " . number_format($jumlah,0,',','.');

                    //Format status
                    if($status_angsuran=="None"){
                        $label_status_angsuran='<span class="badge badge-dark">None</span>';
                    }else{
                        if($status_angsuran=="Pending"){
                            $label_status_angsuran='<span class="badge badge-warning">Pending</span>';
                        }else{
                            if($status_angsuran=="Lunas"){
                                $label_status_angsuran='<span class="badge badge-success">Lunas</span>';
                            }else{
                                $label_status_angsuran='<span class="badge badge-danger">Null</span>';
                            }
                        }
                    }
                    echo '
                                        <tr>
                                            <td class="text-center"><small>'.$no.'</b></td>
                                            <td class="text-center"><small>'.$tanggal_angsuran.'</b></td>
                                            <td class="text-center"><small>'.$pokok_format.'</b></td>
                                            <td class="text-center"><small>'.$jasa_format.'</b></td>
                                            <td class="text-center"><small>'.$denda_format.'</b></td>
                                            <td class="text-center"><small>'.$jumlah_format.'</b></td>
                                            <td class="text-center"><small>'.$label_status_angsuran.'</b></td>
                                        </tr>
                    ';
                    $no++;
                }
                echo '              </tbody>';
                echo '          </table>';
                echo '      </div>';
                echo '  </div>';
                echo '</div>';
            }
        }
    }
?>

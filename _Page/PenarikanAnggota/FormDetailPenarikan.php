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
        if(empty($_POST['id_simpanan_penarikan'])){
            echo '<div class="alert alert-danger">';
            echo '  <small>';
            echo '      ID Pengajuan Penarikan Tidak Boleh Kosong!';
            echo '  </small>';
            echo '</div>';
        }else{
            $id_simpanan_penarikan=$_POST['id_simpanan_penarikan'];
            
            //Buka Detail Penarikan
            $sql = "SELECT * FROM simpanan_penarikan WHERE id_simpanan_penarikan = ?";
            $stmt = $Conn->prepare($sql);
            $id = 1;
            $stmt->bind_param("i", $id_simpanan_penarikan);
            
            // Eksekusi statement
            $stmt->execute();
            
            // Ambil hasil query
            $result = $stmt->get_result();
            $DataPenarikan = $result->fetch_assoc();
            
            // Simpan hasil ke variabel
            $id_simpanan_jenis = $DataPenarikan['id_simpanan_jenis'] ?? null;
            $id_anggota = $DataPenarikan['id_anggota'] ?? null;
            $tanggal = $DataPenarikan['tanggal'] ?? null;
            $bank = $DataPenarikan['bank'] ?? null;
            $rekening = $DataPenarikan['rekening'] ?? null;
            $nominal = $DataPenarikan['nominal'] ?? null;
            $status = $DataPenarikan['status'] ?? null;

            // Tutup statement
            $stmt->close();

            //Routing Status
            if($status=="Pending"){
                $LabelStatus='<span class="badge badge-warning">Pending</span>';
            }else{
                if($status=="Lunas"){
                    $LabelStatus='<span class="badge badge-success">Lunas</span>';
                }else{
                    if($status=="Ditolak"){
                        $LabelStatus='<span class="badge badge-danger">Ditolak</span>';
                    }else{
                        $LabelStatus='<span class="badge badge-dark">None</span>';
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

            //BUka Data Simpanan
            $nama_simpanan=GetDetailData($Conn,'simpanan_jenis','id_simpanan_jenis',$id_simpanan_jenis,'nama_simpanan');
            $kategori_simpanan=GetDetailData($Conn,'simpanan_jenis','id_simpanan_jenis',$id_simpanan_jenis,'kategori');
            
            //Format tanggal
            $tanggal_format=date('d/m/Y',strtotime($tanggal));

            //Format Rupiah
            $nominal_format = "Rp " . number_format($nominal,0,',','.');

            //Tampilkan Data
            echo '
                <div class="row mb-2">
                    <div class="col-5"><small>Nama Anggota</small></div>
                    <div class="col-1"><small>:</small></div>
                    <div class="col-6"><small><code class="text text-grayish">'.$NamaAnggota.'</code></small></div>
                </div>
                <div class="row mb-2">
                    <div class="col-5"><small>No.Identitas</small></div>
                    <div class="col-1"><small>:</small></div>
                    <div class="col-6"><small><code class="text text-grayish">'.$nip.'</code></small></div>
                </div>
                <div class="row mb-2">
                    <div class="col-5"><small>Kategori</small></div>
                    <div class="col-1"><small>:</small></div>
                    <div class="col-6"><small><code class="text text-grayish">'.$kategori_simpanan.' Bulan</code></small></div>
                </div>
                <div class="row mb-2">
                    <div class="col-5"><small>Tanggal Pengajuan</small></div>
                    <div class="col-1"><small>:</small></div>
                    <div class="col-6"><small><code class="text text-grayish">'.$tanggal_format.'</code></small></div>
                </div>
                <div class="row mb-2">
                    <div class="col-5"><small>Bank</small></div>
                    <div class="col-1"><small>:</small></div>
                    <div class="col-6"><small><code class="text text-grayish">'.$bank.'</code></small></div>
                </div>
                <div class="row mb-2">
                    <div class="col-5"><small>No.Rekening</small></div>
                    <div class="col-1"><small>:</small></div>
                    <div class="col-6"><small><code class="text text-grayish">'.$rekening.'</code></small></div>
                </div>
                <div class="row mb-2">
                    <div class="col-5"><small>Nominal Penarikan</small></div>
                    <div class="col-1"><small>:</small></div>
                    <div class="col-6"><small><code class="text text-grayish">'.$nominal_format.'</code></small></div>
                </div>
                <div class="row mb-2">
                    <div class="col-5"><small>Status</small></div>
                    <div class="col-1"><small>:</small></div>
                    <div class="col-6">'.$LabelStatus.'</div>
                </div>
            ';
            if($status=="Pending"){
                echo '
                    <div class="row">
                        <div class="col-12 text-center">
                            <div class="alert alert-warning">
                                Pengajuan penarikan dana simpanan anda masih dalam proses verifikasi pengurus. 
                                Jika data permohonan sudah valid, kami akan mengirimkan dana tersebut sesuai informasi rekening yang anda berikan.
                            </div>
                        </div>
                    </div>
                ';
            }else{
                if($status=="Lunas"){
                    echo '
                        <div class="row">
                            <div class="col-12 text-center">
                                <div class="alert alert-success">
                                    Pengajuan penarikan dana simpanan anda sudah melalui proses verifikasi. 
                                    Dana penarikan simpanan sudah dikirimkan ke rekening anda.
                                </div>
                            </div>
                        </div>
                    ';
                }else{
                    echo '
                        <div class="row">
                            <div class="col-12 text-center">
                                <div class="alert alert-danger">
                                    Pengajuan penarikan dana simpanan anda ditolak. 
                                    Periksa kembali nominal penarikan dan informasi rekening anda.
                                </div>
                            </div>
                        </div>
                    ';
                }
            }
        }
    }
?>

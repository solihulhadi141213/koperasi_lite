<?php
    //Koneksi
    date_default_timezone_set('Asia/Jakarta');
    include "../../_Config/Connection.php";
    include "../../_Config/GlobalFunction.php";
    include "../../_Config/SettingGeneral.php";

    //Validasi id_pinjaman
    if(empty($_POST['id_pinjaman'])){
        echo '<div class="row">';
        echo '  <div class="col-md-12 mb-3 text-center">';
        echo '      <small class="text-danger">Tidak Ada Data Pinjaman Yang Dipilih</small>';
        echo '  </div>';
        echo '</div>';
    }else{

        //Buat Variabel
        $id_pinjaman=$_POST['id_pinjaman'];

        //Buka Data Pinjaman
        $Qry = $Conn->prepare("SELECT * FROM pinjaman WHERE id_pinjaman = ?");
        $Qry->bind_param("i", $id_pinjaman);
        if (!$Qry->execute()) {
            $error=$Conn->error;
            echo '
                <div class="alert alert-danger">
                    <small>Terjadi kesalahan pada saat membuka data dari database!<br>Keterangan : '.$error.'</small>
                </div>
            ';
        }else{
            $Result = $Qry->get_result();
            $Data = $Result->fetch_assoc();
            $Qry->close();

            //Buat Variabel
            $id_pinjaman_jenis=$Data['id_pinjaman_jenis'];
            $id_anggota=$Data['id_anggota'];
            $tanggal_pengajuan=$Data['tanggal_pengajuan'];
            $tanggal_pencairan=$Data['tanggal_pencairan'];
            $tanggal=$Data['tanggal'];
            $jumlah_pinjaman=$Data['jumlah_pinjaman'];
            $rp_jasa=$Data['rp_jasa'];
            $angsuran_pokok=$Data['angsuran_pokok'];
            $angsuran_total=$Data['angsuran_total'];
            $periode_angsuran=$Data['periode_angsuran'];
            $status=$Data['status'];

            //Nama Paket Pinjaman
            $nama_pinjaman=GetDetailData($Conn, 'pinjaman_jenis', 'id_pinjaman_jenis', $id_pinjaman_jenis, 'nama_pinjaman');

            //Format Rupiah
            $jumlah_pinjaman_format = "Rp " . number_format($jumlah_pinjaman,0,',',',');
            $rp_jasa_format = "Rp " . number_format($rp_jasa,0,',',',');
            $angsuran_pokok_format = "Rp " . number_format($angsuran_pokok,0,',',',');
            $angsuran_total_format = "Rp " . number_format($angsuran_total,0,',',',');
            
            //Label Status
            if($status=="Pending"){
                $label_status='<span class="badge badge-warning">Pending</span>';
            }else{
                if($status=="Berjalan"){
                    $label_status='<span class="badge badge-info">Berjalan</span>';
                }else{
                    if($status=="Lunas"){
                        $label_status='<span class="badge badge-success">Lunas</span>';
                    }else{
                        if($status=="Macet"){
                            $label_status='<span class="badge badge-danger">Macet</span>';
                        }else{
                            if($status=="Ditolak"){
                                $label_status='<span class="badge badge-danger">Ditolak</span>';
                            }else{
                                $label_status='<span class="badge badge-primary">'.$status.'</span>';
                            }
                        }
                    }
                }
            }

            //Tampilkan Data Pinjaman
            echo '
                <div class="row mb-2">
                    <div class="col-5"><small>Paket Pinjaman</small></div>
                    <div class="col-1"><small>:</small></div>
                    <div class="col-6"><code class="text text-grayish">'.$nama_pinjaman.'</code></div>
                </div>
                <div class="row mb-2">
                    <div class="col-5"><small>Tanggal Pengajuan</small></div>
                    <div class="col-1"><small>:</small></div>
                    <div class="col-6"><code class="text text-grayish">'.$tanggal_pengajuan.'</code></div>
                </div>
                <div class="row mb-2">
                    <div class="col-5"><small>Jumlah Pinjaman</small></div>
                    <div class="col-1"><small>:</small></div>
                    <div class="col-6"><code class="text text-grayish">'.$jumlah_pinjaman_format.'</code></div>
                </div>
                <div class="row mb-2">
                    <div class="col-5"><small>Angsuran Pokok</small></div>
                    <div class="col-1"><small>:</small></div>
                    <div class="col-6"><code class="text text-grayish">'.$angsuran_pokok_format.'</code></div>
                </div>
                <div class="row mb-2">
                    <div class="col-5"><small>Rp Jasa</small></div>
                    <div class="col-1"><small>:</small></div>
                    <div class="col-6"><code class="text text-grayish">'.$rp_jasa_format.'</code></div>
                </div>
                <div class="row mb-2">
                    <div class="col-5"><small>Angsuran Total</small></div>
                    <div class="col-1"><small>:</small></div>
                    <div class="col-6"><code class="text text-grayish">'.$angsuran_total_format.'</code></div>
                </div>
                <div class="row mb-2">
                    <div class="col-5"><small>Periode Angsuran</small></div>
                    <div class="col-1"><small>:</small></div>
                    <div class="col-6"><code class="text text-grayish">'.$periode_angsuran.' Bulan</code></div>
                </div>
                <div class="row mb-2 mb-3">
                    <div class="col-5"><small>Status</small></div>
                    <div class="col-1"><small>:</small></div>
                    <div class="col-6"><code class="text text-grayish">'.$label_status.'</code></div>
                </div>
            ';
            if($status=="Pending"){
                echo '
                    <div class="row mb-2 mt-3">
                        <div class="col-12 mt-3">
                            <div class="alert alert-warning">
                                <small>
                                    Pinjaman anda dalam proses peninjauan oleh pengurus koperasi. Umumnya proses tersebut membutuhkan waktu paling lama 2 X 24 jam. 
                                    Jika pengajuan anda diterima, pengurus akan menghubungi anda untuk proses pencairan.
                                </small>
                            </div>
                        </div>
                    </div>
                    <div class="row mb-2 mt-3">
                        <div class="col-12 mt-3 text-center">
                            Pada proses ini anda masih bisa membatalkan pengajuan pinjaman.<br>
                            <a href="javascript:void(0);" class="text-danger text-decoration-underline"  data-bs-toggle="modal" data-bs-target="#ModalPembatalanPengajuan" data-id="'.$id_pinjaman.'">
                                Batalkan Pengajuan
                            </button>
                        </div>
                    </div>
                ';
            }
        }
    }
?>
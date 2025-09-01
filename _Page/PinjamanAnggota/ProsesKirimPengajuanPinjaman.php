<?php
    //koneksi
    include "../../_Config/Connection.php";
    include "../../_Config/GlobalFunction.php";

    //Session
    include "../../_Config/Session.php";

    //Validasi id_simpanan_jenis tidak boleh kosong
    if(empty($SessionIdAkses)){
        echo '
            <div class="alert alert-danger">
                Sesi Akses Sudah Berakhir, Silahkan Login Ulang!
            </div>
        ';
    }else{
        //Validasi id_pinjaman_jenis tidak boleh kosong
        if(empty($_POST['id_pinjaman_jenis'])){
            echo '
                <div class="alert alert-danger">
                    Jenis Pinjaman Tidak Boleh Kosong!
                </div>
            ';
        }else{
            if(empty($_POST['jumlah_pinjaman'])){
                echo '
                    <div class="alert alert-danger">
                        Jumlah Linjaman Tidak Boleh Kosong!
                    </div>
                ';
            }else{
                if(empty($_POST['FormSetuju'])){
                    echo '
                        <div class="alert alert-danger">
                            Anda harus setuju dengan syarat dan ketentuan pengajuan pinjaman terlebih dulu.
                        </div>
                    ';
                }else{
                    //Buat Variabel
                    $id_pinjaman_jenis=$_POST['id_pinjaman_jenis'];
                    $jumlah_pinjaman=$_POST['jumlah_pinjaman'];
                    $status="Pending";

                    //Buat Variabel Yang Tidak Wajib
                    $rp_jasa = !empty($_POST['rp_jasa']) ? $_POST['rp_jasa'] : 0;
                    $rp_denda = !empty($_POST['rp_denda']) ? $_POST['rp_denda'] : 0;
                    $angsuran_pokok = !empty($_POST['angsuran_pokok']) ? $_POST['angsuran_pokok'] : 0;
                    $angsuran_total = !empty($_POST['angsuran_total']) ? $_POST['angsuran_total'] : 0;
                    $periode_angsuran = !empty($_POST['periode_angsuran']) ? $_POST['periode_angsuran'] : 0;
                        
                    //Nasabah Atau Pelanggan Tidak Boleh Memiliki 2 Pinjaman Berjalan Bersamaan
                    $ValidasiDuplikatPinjaman=mysqli_num_rows(mysqli_query($Conn, "SELECT id_pinjaman FROM pinjaman WHERE id_anggota='$SessionIdAkses' AND status='Berjalan'"));
                    if(!empty($ValidasiDuplikatPinjaman)){
                         echo '
                            <div class="alert alert-danger">
                                Anda memiliki pinjaman yang masih berjalan (belum lunas). Selesaikan terlebih dulu pinjaman anda sebelum melanjutkan!
                            </div>
                        ';
                    }else{
                        //Nasabah Atau Pelanggan Tidak Boleh Memiliki 2 Pinjaman Pengajuan Bersamaan
                        $ValidasiDuplikatPinjaman=mysqli_num_rows(mysqli_query($Conn, "SELECT id_pinjaman FROM pinjaman WHERE id_anggota='$SessionIdAkses' AND status='Pending'"));
                        if(!empty($ValidasiDuplikatPinjaman)){
                            echo '
                                <div class="alert alert-danger">
                                    Anda memiliki pinjaman yang masih dalam proses peninjauan. Silahkan batalkan pengajuan tersebut sebelum melanjutkan!
                                </div>
                            ';
                        }else{
                            //Simpan Data
                            $tanggal_pengajuan=date('Y-m-d H:i:s');
                            $tanggal_pencairan=date('Y-m-d H:i:s');
                            $tanggal=date('Y-m-d');

                            //Simpan Pinjaman
                            $EntryPinjaman="INSERT INTO pinjaman (
                                id_pinjaman_jenis,
                                id_anggota,
                                tanggal_pengajuan,
                                tanggal_pencairan,
                                tanggal,
                                jumlah_pinjaman,
                                rp_jasa,
                                rp_denda,
                                angsuran_pokok,
                                angsuran_total,
                                periode_angsuran,
                                status
                            ) VALUES (
                                '$id_pinjaman_jenis',
                                '$SessionIdAkses',
                                '$tanggal_pengajuan',
                                '$tanggal_pencairan',
                                '$tanggal',
                                '$jumlah_pinjaman',
                                '$rp_jasa',
                                '$rp_denda',
                                '$angsuran_pokok',
                                '$angsuran_total',
                                '$periode_angsuran',
                                '$status'
                            )";
                            $InputPinjaman=mysqli_query($Conn, $EntryPinjaman);
                            if($InputPinjaman){
                                echo '
                                    <div class="alert alert-success">
                                        <span id="NotifikasiirimPengajuanPinjamanBerhasil">Success</span>
                                    </div>
                                ';                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                    
                            }else{
                                echo '
                                    <div class="alert alert-danger">
                                        Terjadi Kesalahan Pada Saat Menyimpan Data Pengajuan Penarikan
                                    </div>
                                ';
                            }
                        }
                    }
                }
            }
        }
    }
?>
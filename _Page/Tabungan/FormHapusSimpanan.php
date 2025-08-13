<?php
    //Koneksi
    date_default_timezone_set('Asia/Jakarta');
    include "../../_Config/Connection.php";
    include "../../_Config/GlobalFunction.php";
    include "../../_Config/SettingGeneral.php";
    include "../../_Config/Session.php";
    if(empty($SessionIdAkses)){
        echo '<div class="row">';
        echo '  <div class="col-md-12 mb-3 text-center">';
        echo '      <small class="text-danger">Sesi Akses Sudah Berakhir, Silahkan Login Ulang</small>';
        echo '  </div>';
        echo '</div>';
    }else{
        if(empty($_POST['id_simpanan'])){
            echo '<div class="row">';
            echo '  <div class="col-md-12 mb-3 text-center">';
            echo '      <small class="text-danger">Tidak ada data yang ditangkap oleh sistem</small>';
            echo '  </div>';
            echo '</div>';
        }else{
            $id_simpanan=$_POST['id_simpanan'];

            //Buka Detail Pinjaman
            $sql = "SELECT * FROM simpanan WHERE id_simpanan = ?";
            $stmt = $Conn->prepare($sql);
            $id = 1;
            $stmt->bind_param("i", $id_simpanan);
            
            // Eksekusi statement
            $stmt->execute();
            
            // Ambil hasil query
            $result = $stmt->get_result();
            $DataPinjaman = $result->fetch_assoc();
            
            // Simpan hasil ke variabel
            $id_pinjaman_jenis = $DataPinjaman['id_pinjaman_jenis'] ?? null;
            $id_anggota = $DataPinjaman['id_anggota'] ?? null;
            $id_simpanan_jenis = $DataPinjaman['id_simpanan_jenis'] ?? null;
            $nip = $DataPinjaman['nip'] ?? null;
            $nama = $DataPinjaman['nama'] ?? null;
            $tanggal_simpanan = $DataPinjaman['tanggal_simpanan'] ?? null;
            $tanggal_bayar = $DataPinjaman['tanggal_bayar'] ?? null;
            $kategori = $DataPinjaman['kategori'] ?? null;
            $jumlah = $DataPinjaman['jumlah'] ?? 0;
            $metode_pembayaran = $DataPinjaman['metode_pembayaran'] ?? null;
            $status = $DataPinjaman['status'] ?? null;

            // Tutup statement
            $stmt->close();

            //Format tanggal
            $tanggal_simpanan_format=date('d/m/Y',strtotime($tanggal_simpanan));
            $tanggal_bayar_format=date('d/m/Y',strtotime($tanggal_bayar));

            //Format Rupiah
            $jumlah_format = "Rp " . number_format($jumlah,0,',','.');

            //Routing Status
            if($status=="Pending"){
                $LabelStatus='<span class="badge badge-warning">Pending</span>';
            }else{
                if($status=="Lunas"){
                    $LabelStatus='<span class="badge badge-success">Lunas</span>';
                }else{
                   $LabelStatus='<span class="badge badge-danger">None</span>';
                }
            }

            //Tampilkan Data
            echo '
                <input type="hidden" name="id_simpanan" value="'.$id_simpanan.'">
                <div class="row mb-2">
                    <div class="col-5"><small>Nama Anggota</small></div>
                    <div class="col-1"><small>:</small></div>
                    <div class="col-6"><small><code class="text text-grayish">'.$nama.'</code></small></div>
                </div>
                <div class="row mb-2">
                    <div class="col-5"><small>No.Identitas</small></div>
                    <div class="col-1"><small>:</small></div>
                    <div class="col-6"><small><code class="text text-grayish">'.$nip.'</code></small></div>
                </div>
                <div class="row mb-2">
                    <div class="col-5"><small>Kategori</small></div>
                    <div class="col-1"><small>:</small></div>
                    <div class="col-6"><small><code class="text text-grayish">'.$kategori.' Bulan</code></small></div>
                </div>
                <div class="row mb-2">
                    <div class="col-5"><small>Tanggal Simpanan</small></div>
                    <div class="col-1"><small>:</small></div>
                    <div class="col-6"><small><code class="text text-grayish">'.$tanggal_simpanan_format.'</code></small></div>
                </div>
                <div class="row mb-2">
                    <div class="col-5"><small>Tanggal Bayar</small></div>
                    <div class="col-1"><small>:</small></div>
                    <div class="col-6"><small><code class="text text-grayish">'.$tanggal_bayar_format.'</code></small></div>
                </div>
                <div class="row mb-2">
                    <div class="col-5"><small>Jumlah Simpanan</small></div>
                    <div class="col-1"><small>:</small></div>
                    <div class="col-6"><small><code class="text text-grayish">'.$jumlah_format.'</code></small></div>
                </div>
                <div class="row mb-2">
                    <div class="col-5"><small>Metode Pembayaran</small></div>
                    <div class="col-1"><small>:</small></div>
                    <div class="col-6"><small><code class="text text-grayish">'.$metode_pembayaran.'</code></small></div>
                </div>
                <div class="row mb-3">
                    <div class="col-5 mb-3"><small>Status</small></div>
                    <div class="col-1 mb-3"><small>:</small></div>
                    <div class="col-6 mb-3">'.$LabelStatus.'</div>
                </div>
            ';
            //Routing Tombol Hapus
            if($status=="Lunas"){
                echo '
                    <div class="row">
                        <div class="col-12">
                            <div class="alert alert-danger">
                                Simpanan anggota yang sudah <b>Lunas</b> tidak bisa dihapus.
                            </div>
                        </div>
                    </div>
                ';
            }else{
                echo '
                    <div class="row">
                        <div class="col-12 text-center">
                            <div class="alert alert-warning">
                                <small>
                                    <b><i class="bi bi-exclamation-triangle"></i> Penting!</b><br>
                                    Setelah data simpanan dihapus, maka anggota yang bersangkutan tidak akan bisa melanjutkan prosed pembayaran.
                                </small><br>
                                <b>Apakah anda yakin akan menghapus data tersebut?</b>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-6">
                            <button type="submit" class="btn btn-success btn-rounded btn-block">
                                <i class="bi bi-check"></i> Ya, Hapus
                            </button>
                        </div>
                        <div class="col-6">
                            <button type="button" class="btn btn-dark btn-rounded  btn-block" data-bs-dismiss="modal">
                                <i class="bi bi-x-circle"></i> Tutup
                            </button>
                        </div>
                    </div>
                ';
            }
        }
    }
?>
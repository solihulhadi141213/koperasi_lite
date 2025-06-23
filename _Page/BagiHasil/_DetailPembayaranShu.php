<?php
    // Koneksi & Konfigurasi
    include "../../_Config/Connection.php";
    include "../../_Config/GlobalFunction.php";
    include "../../_Config/Session.php";

    // Time Zone
    date_default_timezone_set('Asia/Jakarta');
    $now = date('Y-m-d H:i:s');

    // Validasi Sesi Login
    if (empty($SessionIdAkses)) {
        echo '
            <div class="alert alert-danger">
                <small>
                    Sesi Akses Sudah Berakhir. Silahkan Login Ulang!
                </small>
            </div>
        ';
    } else{
        if(empty($_POST['id_shu_session'])){
            // Validasi ID SHU
            echo '
                <div class="alert alert-danger">
                    <small>
                        ID Sesi SHU Tidak Boleh Kosong!
                    </small>
                </div>
            ';
        } else {
            // Ambil Data SHU
            $id_shu_session = validateAndSanitizeInput($_POST['id_shu_session']);
            
            $Qry = $Conn->prepare("SELECT * FROM shu_session WHERE id_shu_session = ?");
            $Qry->bind_param("i", $id_shu_session);
            
            if (!$Qry->execute()) {
                echo '
                    <div class="alert alert-danger">
                        <small>
                            Terjadi kesalahan pada saat membuka data sesi SHU <br> Keterangan : '.$Conn->error.'
                        </small>
                    </div>
                ';
            } else {
                $Result = $Qry->get_result();
                $Data = $Result->fetch_assoc();
                $Qry->close();

                if (!$Data) {
                    echo '
                        <div class="alert alert-danger">
                            <small>
                                Data SHU Tidak Ditemukan
                            </small>
                        </div>
                    ';
                } else {
                    //Buat Variabel
                    $periode_hitung1=$Data['periode_hitung1'];
                    $periode_hitung2=$Data['periode_hitung2'];
                    $total_penjualan=$Data['total_penjualan'];
                    $total_simpanan=$Data['total_simpanan'];
                    $total_pinjaman=$Data['total_pinjaman'];
                    $persen_penjualan=$Data['persen_penjualan'];
                    $persen_simpanan=$Data['persen_simpanan'];
                    $persen_pinjaman=$Data['persen_pinjaman'];
                    $shu=$Data['shu'];
                    $status=$Data['status'];

                    //Format tanggal
                    $periode_hitung1=date('d/m/Y',strtotime($periode_hitung1));
                    $periode_hitung2=date('d/m/Y',strtotime($periode_hitung2));

                    //Format Rupiah
                    $shu_rp = "Rp " . number_format($shu,0,',','.');
                    $total_penjualan_rp = "Rp " . number_format($total_penjualan,0,',','.');
                    $total_simpanan_rp = "Rp " . number_format($total_simpanan,0,',','.');
                    $total_pinjaman_rp = "Rp " . number_format($total_pinjaman,0,',','.');

                    //Label Status
                    if($status=="Pending"){
                        $LabelStatus='<span class="badge badge-warning">Pending</span>';
                    }else{
                        $LabelStatus='<span class="badge badge-success">'.$status.'</span>';
                    }

                     //Jumlah Anggota
                    $JumlahRincian = mysqli_num_rows(mysqli_query($Conn, "SELECT*FROM shu_rincian WHERE id_shu_session='$id_shu_session'"));
                    $JumlahRincian_rp = "" . number_format($JumlahRincian,0,',','.');

                    //Jumlah Rincian SHU
                    $sum_alokasi= mysqli_fetch_array(mysqli_query($Conn, "SELECT SUM(shu) AS jumlah FROM shu_rincian WHERE id_shu_session='$id_shu_session'"));
                    if(!empty($sum_alokasi['jumlah'])){
                        $jumlah_alokasi = $sum_alokasi['jumlah'];
                    }else{
                        $jumlah_alokasi =0;
                    }
                    $jumlah_alokasi_rp = "Rp " . number_format($jumlah_alokasi,0,',','.');

                    if($status=="Pending"){
                        echo '
                            <div classs="row mb-4">
                                <div class="col-12 mb-4">
                                    <small>
                                        Setelah anda menyelesaikan realisasi pembayaran SHU kepada anggota, maka ada beberapa hal yang perlu diketahui :<br>
                                        <ul>
                                            <li>
                                                Apabila sebelumnya anda sudah menyimpan pengaturan auto jurnal SHU maka sistem akan membuatkan data jurnal sesuai pengaturan.
                                            </li>
                                            <li>
                                                Apabila sebelumnya anda belum menyimpan pengaturan auto jurnal, maka sistem hanya akan melakukan pembaharuan status.
                                            </li>
                                            <li>
                                                Sistem akan mengubah status sesi SHU menjadi <i>Realisasi</i> dan anda tidak bisa melakukan perubahan pada semua informasi sesi tersebut.
                                            </li>
                                            <li>
                                                Apabila terdapat kesalahan pada data/informasi yang ada, maka anda harus menghapus data lama dan membuat ulang sesi SHU.
                                            </li>
                                            <li>
                                                Pastikan sebelum anda menyelesaikan transaksi ini untuk dapat memastikan terlebih dahulu nilai nominal pembagian.
                                            </li>
                                        </ul>
                                    </small>
                                </div>
                            </div>
                            <div classs="row mb-3 mt-4">
                                <div class="col-12">
                                    <button type="button" class="btn btn-md btn-primary btn-rounded" data-bs-toggle="modal" data-bs-target="#ModalUpdateStatusShu" data-id="'.$id_shu_session.'">
                                        <i class="bi bi-repeat"></i> Update Status SHU
                                    </button>
                                </div>
                            </div>
                        ';
                    }else{
                        echo '
                            <div classs="row mb-4">
                                <div class="col-12 mb-4">
                                    <div class="alert alert-success">
                                        <small>
                                            Data SHU sudah direalisasikan. Anda sudah tidak bisa lagi mengubah informasi pembagian SHU. 

                                        </small>
                                    </div>
                                </div>
                            </div>
                        ';
                    }
                }
            }
        }
    }
?>

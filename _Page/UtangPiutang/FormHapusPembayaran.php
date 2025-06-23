<?php
    //Koneksi
    date_default_timezone_set('Asia/Jakarta');
    include "../../_Config/Connection.php";
    include "../../_Config/GlobalFunction.php";
    include "../../_Config/SettingGeneral.php";
    include "../../_Config/Session.php";
    if(empty($SessionIdAkses)){
        echo '
            <div class="alert alert-danger text-center">
                <small>
                    Sesi Akses Sudah Berakhir, Silahkan Login Ulang
                </small>
            </div>
        ';
    }else{
        //Tangkap id_transaksi_pembayaran
        if(empty($_POST['id_transaksi_pembayaran'])){
            echo '
                <div class="alert alert-danger text-center">
                    <small>
                        ID Pembayaran Tidak Boleh Kosong!
                    </small>
                </div>
            ';
        }else{
            $id_transaksi_pembayaran=validateAndSanitizeInput($_POST['id_transaksi_pembayaran']);
            //Buka Informasi Pembayaran Dengan Prepared Statment
            $Qry = $Conn->prepare("SELECT * FROM transaksi_pembayaran WHERE id_transaksi_pembayaran = ?");
            $Qry->bind_param("s", $id_transaksi_pembayaran);
            if (!$Qry->execute()) {
                $error=$Conn->error;
                echo '
                    <div class="alert alert-danger text-center">
                        <small>
                            Terjadi kesalahan pada saat membuka data pembayaran.<br>
                            Keterangan : '. $error.'
                        </small>
                    </div>
                ';
            }else{
                $Result = $Qry->get_result();
                $Data = $Result->fetch_assoc();
                $Qry->close();

                //Buat Variabel
                $id_transaksi_jual_beli=$Data['id_transaksi_jual_beli'];
                $kategori=$Data['kategori'];
                $tanggal=$Data['tanggal'];
                $jumlah=$Data['jumlah'];

                //Format Rupiah
                $jumlah_rp = "Rp " . number_format($jumlah,0,',','.');

                //Format Tanggal
                $tanggal_format=date('d/m/Y H:i', strtotime($tanggal));

                //Tampilkan Data
                echo '
                    <input type="hidden" name="id_transaksi_pembayaran" value="'.$id_transaksi_pembayaran.'">
                    <div class="row mb-2">
                        <div class="col-3">
                            <small>ID Transaksi</small>
                        </div>
                        <div class="col-1"><small>:</small></div>
                        <div class="col-8">
                            <small class="text-muted">'.$id_transaksi_jual_beli.'</small>
                        </div>
                    </div>
                    <div class="row mb-2">
                        <div class="col-3">
                            <small>Kategori</small>
                        </div>
                        <div class="col-1"><small>:</small></div>
                        <div class="col-8">
                            <small class="text-muted">'.$kategori.'</small>
                        </div>
                    </div>
                     <div class="row mb-2">
                        <div class="col-3">
                            <small>Tanggal</small>
                        </div>
                        <div class="col-1"><small>:</small></div>
                        <div class="col-8">
                            <small class="text-muted">'.$tanggal_format.'</small>
                        </div>
                    </div>
                    <div class="row mb-2">
                        <div class="col-3">
                            <small>Jumlah</small>
                        </div>
                        <div class="col-1"><small>:</small></div>
                        <div class="col-8">
                            <small class="text-muted">'.$jumlah_rp.'</small>
                        </div>
                    </div>
                    <div class="row mb-2 mt-3">
                        <div class="col-12 text-center">
                            <small>
                                Menghapus riwayat pembayaran Utang/Piutang akan membatalkan status transaksi sebelumnya. 
                                <p><b>Apakah anda yakin akan menghapus data tersebut?</b></p>
                            </small>
                        </div>
                    </div>
                ';
            }
        }
    }      
?>
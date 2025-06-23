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
        if(empty($_POST['id_shu_session'])){
            echo '<div class="row">';
            echo '  <div class="col-md-12 mb-3 text-center">';
            echo '      <small class="text-danger">Tidak ada data yang ditangkap oleh sistem</small>';
            echo '  </div>';
            echo '</div>';
        }else{
            $id_shu_session=$_POST['id_shu_session'];
            
            //Buka data
            //Buka data dengan prepared statment
            $Qry = $Conn->prepare("SELECT * FROM shu_session WHERE id_shu_session = ?");
            $Qry->bind_param("i", $id_shu_session);
            if (!$Qry->execute()) {
                $error=$Conn->error;
                echo '
                    <div class="alert alert-danger">
                        <small>Terjadi kesalahan pada saat menampilkan data sesi SHU <br> Keterangan : '.$error.'</small>
                    </div>
                ';
            }else{
                $Result = $Qry->get_result();
                $Data = $Result->fetch_assoc();

                //Apabila Data Tidak Ditemukan
                if(empty($Data['id_shu_session'])){
                    echo '
                        <div class="alert alert-danger">
                            <small>Data Sesi SHU tidak ditemukan!</small>
                        </div>
                    ';
                }else{
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
                    if($status!=="Pending"){
                        echo '
                            <div class="alert alert-danger">
                                <small>Data Sesi SHU Sudah Dibayarkan dan Anda Tidak Bisa Melakukan Perubahan Pada Data Ini!</small>
                            </div>
                        ';
                    }else{
                        //Jumlah Rincian SHU
                        $sum_alokasi= mysqli_fetch_array(mysqli_query($Conn, "SELECT SUM(shu) AS jumlah FROM shu_rincian WHERE id_shu_session='$id_shu_session'"));
                        if(!empty($sum_alokasi['jumlah'])){
                            $jumlah_alokasi = $sum_alokasi['jumlah'];
                        }else{
                            $jumlah_alokasi =0;
                        }
?>
            <input type="hidden" name="id_shu_session" id="id_shu_session" value="<?php echo "$id_shu_session"; ?>">
            <div class="row mb-3">
                <div class="col-md-12">
                    <div class="alert alert-warning">
                        <small>
                            <b>Perlu Diketahui</b><br>
                            Apabila anda menyimpan perubahan pada data SHU ini maka sistem akan menghitung ulang jumlah transaksi anggota berdasarkan form periode waktu. 
                            Rincian yang anda buat melalui proses perhitungan otomatis mungkin perlu diperbaharui. 
                        </small>
                    </div>
                </div>
            </div>
            <div class="row mb-3">
                <div class="col-md-4">
                    <label for="periode_hitung1_edit">Periode Awal Perhitungan</label>
                </div>
                <div class="col-md-8">
                    <input type="date" name="periode_hitung1" id="periode_hitung1_edit" class="form-control" value="<?php echo "$periode_hitung1"; ?>">
                </div>
            </div>
            <div class="row mb-3">
                <div class="col-md-4">
                    <label for="periode_hitung2_edit">Periode Akhir Perhitungan</label>
                </div>
                <div class="col-md-8">
                    <input type="date" name="periode_hitung2" id="periode_hitung2_edit" class="form-control" value="<?php echo "$periode_hitung2"; ?>">
                </div>
            </div>
            <div class="row mb-3">
                <div class="col-md-4">
                    <label for="shu_edit">SHU (Rp)</label>
                </div>
                <div class="col-md-8">
                    <input type="text" name="shu" id="shu_edit" class="form-control form-money" value="<?php echo "$shu"; ?>">
                    <small class="credit">
                        <code class="text text-grayish">Pendapatan (Laba) dikurangi biaya dan pajak</code>
                    </small>
                </div>
            </div>
            <div class="row mb-3">
                <div class="col-md-4">
                    <label for="persen_penjualan_edit">Jasa Usaha/Penjualan (%)</label>
                </div>
                <div class="col-md-8">
                    <input type="number" min="0" max="100" name="persen_penjualan" id="persen_penjualan_edit" class="form-control" placeholder="[0-100]" value="<?php echo "$persen_penjualan"; ?>">
                    <small class="credit">
                        <code class="text text-grayish">
                            Persentase alokasi jasa usaha (penjualan) anggota berdasarkan ADART
                        </code>
                    </small>
                </div>
            </div>
            <div class="row mb-3">
                <div class="col-md-4">
                    <label for="persen_simpanan_edit">Jasa Simpanan/Modal (%)</label>
                </div>
                <div class="col-md-8">
                    <input type="number" min="0" max="100" name="persen_simpanan" id="persen_simpanan_edit" class="form-control" placeholder="[0-100]" value="<?php echo "$persen_simpanan"; ?>">
                    <small class="credit">
                        <code class="text text-grayish">
                            Persentase alokasi jasa modal simpanan anggota berdasarkan ADART
                        </code>
                    </small>
                </div>
            </div>
            <div class="row mb-3">
                <div class="col-md-4">
                    <label for="persen_pinjaman_edit">Jasa Pinjaman (%)</label>
                </div>
                <div class="col-md-8">
                    <input type="number" min="0" max="100" name="persen_pinjaman" id="persen_pinjaman_edit" class="form-control" placeholder="[0-100]" value="<?php echo "$persen_pinjaman"; ?>">
                    <small class="credit">
                        <code class="text text-grayish">
                            Persentase alokasi jasa pinjaman anggota berdasarkan ADART
                        </code>
                    </small>
                </div>
            </div>
            <script>
                initializeMoneyInputs();
            </script>
<?php 
                    } 
                } 
            } 
        } 
    } 
?>
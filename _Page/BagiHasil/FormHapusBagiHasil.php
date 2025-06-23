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
                    $JumlahRincian = "" . number_format($JumlahRincian,0,',','.');

                    //Jumlah Rincian SHU
                    $sum_alokasi= mysqli_fetch_array(mysqli_query($Conn, "SELECT SUM(shu) AS jumlah FROM shu_rincian WHERE id_shu_session='$id_shu_session'"));
                    if(!empty($sum_alokasi['jumlah'])){
                        $jumlah_alokasi = $sum_alokasi['jumlah'];
                    }else{
                        $jumlah_alokasi =0;
                    }
                    $jumlah_alokasi_rp = "Rp " . number_format($jumlah_alokasi,0,',','.');
?>
            <input type="hidden" name="id_shu_session" id="id_shu_session" value="<?php echo "$id_shu_session"; ?>">
            <div class="row mb-2">
                <div class="col-4">
                    <small>Periode Perhitungan</small>
                </div>
                <div class="col-1">:</div>
                <div class="col-7">
                    <small class="text-muted">
                        <?php echo "$periode_hitung1 - $periode_hitung2"; ?>
                    </small>
                </div>
            </div>
            <div class="row mb-2">
                <div class="col-4">
                    <small>Jumlah SHU</small>
                </div>
                <div class="col-1">:</div>
                <div class="col-7">
                    <small class="text-muted">
                        <?php echo "$shu_rp"; ?>
                    </small>
                </div>
            </div>
            <div class="row mb-2">
                <div class="col-4">
                    <small>Persentase Penjualan</small>
                </div>
                <div class="col-1">:</div>
                <div class="col-7">
                    <small class="text-muted">
                        <?php echo "$persen_penjualan %"; ?>
                    </small>
                </div>
            </div>
            <div class="row mb-2">
                <div class="col-4">
                    <small>Persentase Simpanan</small>
                </div>
                <div class="col-1">:</div>
                <div class="col-7">
                    <small class="text-muted">
                        <?php echo "$persen_simpanan %"; ?>
                    </small>
                </div>
            </div>
            <div class="row mb-2">
                <div class="col-4">
                    <small>Persentase Pinjaman</small>
                </div>
                <div class="col-1">:</div>
                <div class="col-7">
                    <small class="text-muted">
                        <?php echo "$persen_pinjaman %"; ?>
                    </small>
                </div>
            </div>
            <div class="row mb-2">
                <div class="col-4">
                    <small>Status</small>
                </div>
                <div class="col-1">:</div>
                <div class="col-7">
                    <small class="text-muted">
                        <?php echo "$LabelStatus"; ?>
                    </small>
                </div>
            </div>
<?php 
                } 
            } 
        } 
    } 
?>
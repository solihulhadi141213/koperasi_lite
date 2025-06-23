<?php
    //Koneksi
    date_default_timezone_set('Asia/Jakarta');
    include "../../_Config/Connection.php";
    include "../../_Config/GlobalFunction.php";
    include "../../_Config/Session.php";
    //Tangkap id_mitra
    if(empty($_POST['id_stok_opename'])){
        echo '  <div class="row">';
        echo '      <div class="col-md-6 mb-3">';
        echo '          ID Stock Opename Tidak Boleh Kosong!.';
        echo '      </div>';
        echo '  </div>';
    }else{
        $id_stok_opename=$_POST['id_stok_opename'];
        //Buka data Stock Opename
        $QryStockOpename = mysqli_query($Conn,"SELECT * FROM stok_opename WHERE id_stok_opename='$id_stok_opename'")or die(mysqli_error($Conn));
        $DataStockOpename = mysqli_fetch_array($QryStockOpename);
        $tanggal= $DataStockOpename['tanggal'];
        $status= $DataStockOpename['status'];
        //Format Tanggal
        $strtotime=strtotime($tanggal);
        $TanggalFormat=date('d/m/Y',$strtotime);
        //Inisiasi Status
        if($status==1){
            $LabelStatus='<span class="badge badge-primary">Selesai</span>';
        }else{
            $LabelStatus='<span class="badge badge-warning">Dalam Pengerjaan</span>';
        }

        //Hitung jumlah item
        $JumlahItem = mysqli_num_rows(mysqli_query($Conn, "SELECT id_stok_opename_barang FROM stok_opename_barang WHERE id_stok_opename='$id_stok_opename'"));

        //Menghitung jumlah kelebihan
        $SumKelebihan = mysqli_fetch_array(mysqli_query($Conn, "SELECT SUM(jumlah) AS jumlah FROM stok_opename_barang WHERE id_stok_opename='$id_stok_opename' AND jumlah>0"));
        $JumlahKelebihan = $SumKelebihan['jumlah'];
        $JumlahKelebihan_rp = "" . number_format($JumlahKelebihan,0,',','.');
        
        //Menghitung jumlah Kekurangan
        $SumKekurangan = mysqli_fetch_array(mysqli_query($Conn, "SELECT SUM(jumlah) AS jumlah FROM stok_opename_barang WHERE id_stok_opename='$id_stok_opename' AND jumlah<0"));
        $JumlahKekurangan = $SumKekurangan['jumlah'];
        $JumlahKekurangan_rp = "" . number_format($JumlahKekurangan,0,',','.');

        echo '
            <div class="row mb-3">
                <div class="col-3"><small>Tanggal</small></div>
                <div class="col-9"><small class="text text-grayish">'.$TanggalFormat.'</small></div>
            </div>
            <div class="row mb-3">
                <div class="col-3"><small>Status</small></div>
                <div class="col-9">'.$LabelStatus.'</div>
            </div>
            <div class="row mb-3">
                <div class="col-3"><small>Jumlah Item</small></div>
                <div class="col-9"><small class="text text-grayish">'.$JumlahItem.' Item</small></div>
            </div>
            <div class="row mb-3">
                <div class="col-3"><small>Selisih (+)</small></div>
                <div class="col-9"><small class="text text-grayish">'.$JumlahKelebihan_rp.'</small></div>
            </div>
            <div class="row mb-3">
                <div class="col-3"><small>Selisih (-)</small></div>
                <div class="col-9"><small class="text text-grayish">'.$JumlahKekurangan_rp.'</small></div>
            </div>
        ';
    }
?>
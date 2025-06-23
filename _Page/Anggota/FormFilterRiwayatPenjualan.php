<?php
    include "../../_Config/Connection.php";
    if(empty($_POST['keyword_by'])){
        echo '<input type="text" name="keyword" id="keyword_riwayat_penjualan" class="form-control">';
    }else{
        $keyword_by=$_POST['keyword_by'];
        if($keyword_by=="tanggal"){
            echo '<input type="date" name="keyword" id="keyword_riwayat_penjualan" class="form-control">';
        }else{
            if($keyword_by=="status"){
                echo '<select name="keyword" id="keyword_riwayat_penjualan" class="form-control">';
                echo '  <option value="">Pilih</option>';
                $query = mysqli_query($Conn, "SELECT DISTINCT status FROM transaksi_jual_beli ORDER BY status ASC");
                while ($data = mysqli_fetch_array($query)) {
                    $status= $data['status'];
                    echo '  <option value="'.$status.'">'.$status.'</option>';
                }
                echo '</select>';
            }else{
                if($keyword_by=="total"){
                    echo '<input type="number" name="keyword" id="keyword_riwayat_penjualan" class="form-control">';
                }else{
                    echo '<input type="text" name="keyword" id="keyword_riwayat_penjualan" class="form-control">';
                }
            }
        }
    }
?>
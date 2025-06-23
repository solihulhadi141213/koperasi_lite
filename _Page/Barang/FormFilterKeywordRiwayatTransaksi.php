<?php
    include "../../_Config/Connection.php";
    if(!empty($_POST['keyword_by'])){
        $KeywordBy=$_POST['keyword_by'];
        
        if($KeywordBy=="kategori"){
            echo '<select name="keyword" id="keyword_riwayat_transaksi" class="form-control">';
            $query = mysqli_query($Conn, "SELECT DISTINCT kategori FROM transaksi_jual_beli ORDER BY kategori ASC");
            while ($data = mysqli_fetch_array($query)) {
                $kategori= $data['kategori'];
                echo '  <option value="'.$kategori.'">'.$kategori.'</option>';
            }
            echo '</select>';
        }else{
            if($KeywordBy=="tanggal"){
                echo ' <input type="date" name="keyword" id="keyword_riwayat_transaksi" class="form-control">';
            }else{
                if($KeywordBy=="status"){
                    echo '<select name="keyword" id="keyword_riwayat_transaksi" class="form-control">';
                    $query = mysqli_query($Conn, "SELECT DISTINCT status FROM transaksi_jual_beli ORDER BY status ASC");
                    while ($data = mysqli_fetch_array($query)) {
                        $status= $data['status'];
                        echo '  <option value="'.$status.'">'.$status.'</option>';
                    }
                    echo '</select>';
                }else{
                    if($KeywordBy=="satuan"){
                        echo '<select name="keyword" id="keyword_riwayat_transaksi" class="form-control">';
                        $query = mysqli_query($Conn, "SELECT DISTINCT satuan FROM transaksi_jual_beli_rincian ORDER BY satuan ASC");
                        while ($data = mysqli_fetch_array($query)) {
                            $satuan= $data['satuan'];
                            echo '  <option value="'.$satuan.'">'.$satuan.'</option>';
                        }
                        echo '</select>';
                    }else{
                        echo ' <input type="text" name="keyword" id="keyword_riwayat_transaksi" class="form-control">';
                    }
                }
            }
        }
    }else{
        echo ' <input type="text" name="keyword" id="keyword_riwayat_transaksi" class="form-control">';
    }
?>
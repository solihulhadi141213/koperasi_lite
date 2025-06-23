<?php
    include "../../_Config/Connection.php";
    if(empty($_POST['keyword_by'])){
        echo '<input type="text" name="keyword" id="keyword_riwayat_simpanan" class="form-control">';
    }else{
        $keyword_by=$_POST['keyword_by'];
        if($keyword_by=="tanggal"){
            echo '<input type="date" name="keyword" id="keyword_riwayat_simpanan" class="form-control">';
        }else{
            if($keyword_by=="kategori"){
                echo '<select name="keyword" id="keyword_riwayat_simpanan" class="form-control">';
                echo '  <option value="">Pilih</option>';
                $query = mysqli_query($Conn, "SELECT DISTINCT kategori FROM simpanan ORDER BY kategori ASC");
                while ($data = mysqli_fetch_array($query)) {
                    $kategori= $data['kategori'];
                    echo '  <option value="'.$kategori.'">'.$kategori.'</option>';
                }
                echo '</select>';
            }else{
                if($keyword_by=="jumlah"){
                    echo '<input type="number" name="keyword" id="keyword_riwayat_simpanan" class="form-control">';
                }else{
                    echo '<input type="text" name="keyword" id="keyword_riwayat_simpanan" class="form-control">';
                }
            }
        }
    }
?>
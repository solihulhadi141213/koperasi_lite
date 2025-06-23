<?php
    include "../../_Config/Connection.php";
    if(!empty($_POST['keyword_by'])){
        $keyword_by=$_POST['keyword_by'];
        if($keyword_by=="expired_date"||$keyword_by=="reminder_date"){
            echo '<label for="keyword">Kata Kunci</label>';
            echo ' <input type="date" name="keyword" id="keyword" class="form-control">';
        }else{
            if($keyword_by=="status"){
                echo '<label for="keyword">Kata Kunci</label>';
                echo '<select name="keyword" id="keyword" class="form-control">';
                $query = mysqli_query($Conn, "SELECT DISTINCT status FROM barang_bacth ORDER BY status ASC");
                while ($data = mysqli_fetch_array($query)) {
                    $status= $data['status'];
                    echo '  <option value="'.$status.'">'.$status.'</option>';
                }
                echo '</select>';
            }else{
                echo '<label for="keyword">Kata Kunci</label>';
                echo ' <input type="text" name="keyword" id="keyword" class="form-control">';
            }
        }
    }else{
        echo '<label for="keyword">Kata Kunci</label>';
        echo ' <input type="text" name="keyword" id="keyword" class="form-control">';
    }
?>
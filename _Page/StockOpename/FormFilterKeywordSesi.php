<?php
    if(!empty($_POST['keyword_by'])){
        $keyword_by=$_POST['keyword_by'];
        if($keyword_by=="tanggal"){
            echo '<label for="keyword">Kata Kunci</label>';
            echo ' <input type="date" name="keyword" id="keyword" class="form-control">';
        }else{
            if($keyword_by=="status"){
                echo '<label for="keyword">Kata Kunci</label>';
                echo '<select name="keyword" id="keyword" class="form-control">';
                echo '  <option value="">Pilih</option>';
                echo '  <option value="1">Selesai</option>';
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
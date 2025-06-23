<?php
    if(!empty($_POST['keyword_by'])){
        $keyword_by=$_POST['keyword_by'];
        if($keyword_by=="tanggal_angsuran"){
            echo '<input type="date" name="keyword" id="keyword" class="form-control">';
        }else{
            if($keyword_by=="tanggal_bayar"){
                echo '<input type="date" name="keyword" id="keyword" class="form-control">';
            }else{
                echo '<input type="text" name="keyword" id="keyword" class="form-control">';
            }
        }
    }else{
        echo '<input type="text" name="keyword" id="keyword" class="form-control">';
    }
?>
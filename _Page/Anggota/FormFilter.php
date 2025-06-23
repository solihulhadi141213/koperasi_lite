<?php
    include "../../_Config/Connection.php";
    if(empty($_POST['keyword_by'])){
       
        echo '<input type="text" name="keyword" id="keyword" class="form-control">';
    }else{
        $keyword_by=$_POST['keyword_by'];
        if($keyword_by=="tanggal_masuk"){
           
            echo '<input type="date" name="keyword" id="keyword" class="form-control">';
        }else{
            if($keyword_by=="tanggal_keluar"){
               
                echo '<input type="date" name="keyword" id="keyword" class="form-control">';
            }else{
                if($keyword_by=="lembaga"){
                   
                    echo '<select name="keyword" id="keyword" class="form-control">';
                    echo '  <option value="">Pilih</option>';
                    $query = mysqli_query($Conn, "SELECT DISTINCT lembaga FROM anggota ORDER BY lembaga ASC");
                    while ($data = mysqli_fetch_array($query)) {
                        $lembaga= $data['lembaga'];
                        echo '  <option value="'.$lembaga.'">'.$lembaga.'</option>';
                    }
                    echo '</select>';
                }else{
                    if($keyword_by=="status"){
                       
                        echo '<select name="keyword" id="keyword" class="form-control">';
                        echo '  <option value="">Pilih</option>';
                        $query = mysqli_query($Conn, "SELECT DISTINCT status FROM anggota ORDER BY status ASC");
                        while ($data = mysqli_fetch_array($query)) {
                            $status= $data['status'];
                            echo '  <option value="'.$status.'">'.$status.'</option>';
                        }
                        echo '</select>';
                    }else{
                       
                        echo '<input type="text" name="keyword" id="keyword" class="form-control">';
                    }
                }
            }
        }
    }
?>
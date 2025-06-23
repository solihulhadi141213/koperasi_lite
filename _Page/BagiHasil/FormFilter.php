<?php
    include "../../_Config/Connection.php";
    if(!empty($_POST['keyword_by'])){
        $keyword_by=$_POST['keyword_by'];
        if($keyword_by=="periode_hitung1"||$keyword_by=="periode_hitung2"){
            echo ' <input type="date" name="keyword" id="keyword" class="form-control">';
        }else{
            if($keyword_by=="modal_anggota"){
                echo ' <input type="number" name="keyword" id="keyword" class="form-control">';
            }else{
                if($keyword_by=="penjualan"){
                    echo ' <input type="number" name="keyword" id="keyword" class="form-control">';
                }else{
                    if($keyword_by=="persen_usaha"){
                        echo ' <input type="number" name="keyword" id="keyword" class="form-control">';
                    }else{
                        if($keyword_by=="persen_modal"){
                            echo ' <input type="number" name="keyword" id="keyword" class="form-control">';
                        }else{
                            if($keyword_by=="status"){
                                echo '<select name="keyword" id="keyword" class="form-control">';
                                echo '<option value="">Pilih..</option>';
                                $query = mysqli_query($Conn, "SELECT DISTINCT status FROM shu_session ORDER BY status ASC");
                                while ($data = mysqli_fetch_array($query)) {
                                    $status= $data['status'];
                                    echo '  <option value="'.$status.'">'.$status.'</option>';
                                }
                                echo '</select>';
                            }else{
                                
                                echo ' <input type="text" name="keyword" id="keyword" class="form-control">';
                            }
                        }
                    }
                }
            }
        }
    }else{
        echo ' <input type="text" name="keyword" id="keyword" class="form-control">';
    }
?>
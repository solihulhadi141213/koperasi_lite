<?php
    include "../../_Config/Connection.php";
    if(!empty($_POST['keyword_by'])){
        $keyword_by=$_POST['keyword_by'];
        if($keyword_by=="nip"){
            echo '<input type="text" name="keyword" id="keyword" class="form-control">';
        }else{
            if($keyword_by=="nama"){
                echo '<input type="text" name="keyword" id="keyword" class="form-control">';
            }else{
                if($keyword_by=="lembaga"){
                    echo '<select name="keyword" id="keyword" class="form-control">';
                    echo '  <option value="">Pilih</option>';
                    $query = mysqli_query($Conn, "SELECT DISTINCT lembaga FROM simpanan ORDER BY lembaga ASC");
                    while ($data = mysqli_fetch_array($query)) {
                        $lembaga= $data['lembaga'];
                        echo '  <option value="'.$lembaga.'">'.$lembaga.'</option>';
                    }
                    echo '</select>';
                }else{
                    if($keyword_by=="lembaga"){
                        echo '<select name="keyword" id="keyword" class="form-control">';
                        echo '  <option value="">Pilih</option>';
                        $query = mysqli_query($Conn, "SELECT DISTINCT lembaga FROM simpanan ORDER BY lembaga ASC");
                        while ($data = mysqli_fetch_array($query)) {
                            $lembaga= $data['lembaga'];
                            echo '  <option value="'.$lembaga.'">'.$lembaga.'</option>';
                        }
                        echo '</select>';
                    }else{
                        if($keyword_by=="ranking"){
                            echo '<select name="keyword" id="keyword" class="form-control">';
                            echo '  <option value="">Pilih</option>';
                            $query = mysqli_query($Conn, "SELECT DISTINCT ranking FROM simpanan ORDER BY ranking ASC");
                            while ($data = mysqli_fetch_array($query)) {
                                $ranking= $data['ranking'];
                                echo '  <option value="'.$ranking.'">'.$ranking.'</option>';
                            }
                            echo '</select>';
                        }else{
                            if($keyword_by=="tanggal"){
                                echo '<input type="date" name="keyword" id="keyword" class="form-control">';
                            }else{
                                if($keyword_by=="kategori"){
                                    echo '<select name="keyword" id="keyword" class="form-control">';
                                    echo '  <option value="">Pilih</option>';
                                    $query = mysqli_query($Conn, "SELECT DISTINCT kategori FROM simpanan ORDER BY kategori ASC");
                                    while ($data = mysqli_fetch_array($query)) {
                                        $kategori= $data['kategori'];
                                        echo '  <option value="'.$kategori.'">'.$kategori.'</option>';
                                    }
                                    echo '</select>';
                                }else{
                                    echo '<input type="text" name="keyword" id="keyword" class="form-control">';
                                }
                            }
                        }
                    }
                }
            }
        }
    }else{
        echo '<input type="text" name="keyword" id="keyword" class="form-control">';
    }
?>
<?php
    include "../../_Config/Connection.php";
    if(empty($_POST['keyword_by'])){
        echo '<label for="keyword">Kata Kunci</label>';
        echo '<input type="text" name="keyword" id="keyword" class="form-control">';
    }else{
        $keyword_by=$_POST['keyword_by'];
        if($keyword_by=="tanggal"){
            echo '<label for="keyword">Kata Kunci</label>';
            echo '<input type="date" name="keyword" id="keyword" class="form-control">';
        }else{
            if($keyword_by=="nama_transaksi"){
                echo '<label for="keyword">Kata Kunci</label>';
                echo '<select name="keyword" id="keyword" class="form-control">';
                echo '  <option value="">Pilih</option>';
                $query = mysqli_query($Conn, "SELECT DISTINCT nama_transaksi FROM transaksi ORDER BY nama_transaksi ASC");
                while ($data = mysqli_fetch_array($query)) {
                    $nama_transaksi= $data['nama_transaksi'];
                    echo '  <option value="'.$nama_transaksi.'">'.$nama_transaksi.'</option>';
                }
                echo '</select>';
            }else{
                if($keyword_by=="kategori"){
                    echo '<label for="keyword">Kata Kunci</label>';
                    echo '<select name="keyword" id="keyword" class="form-control">';
                    echo '  <option value="">Pilih</option>';
                    $query = mysqli_query($Conn, "SELECT DISTINCT kategori FROM transaksi ORDER BY kategori ASC");
                    while ($data = mysqli_fetch_array($query)) {
                        $kategori= $data['kategori'];
                        echo '  <option value="'.$kategori.'">'.$kategori.'</option>';
                    }
                    echo '</select>';
                }else{
                    if($keyword_by=="status"){
                        echo '<label for="keyword">Kata Kunci</label>';
                        echo '<select name="keyword" id="keyword" class="form-control">';
                        echo '  <option value="">Pilih</option>';
                        $query = mysqli_query($Conn, "SELECT DISTINCT status FROM transaksi ORDER BY status ASC");
                        while ($data = mysqli_fetch_array($query)) {
                            $status= $data['status'];
                            echo '  <option value="'.$status.'">'.$status.'</option>';
                        }
                        echo '</select>';
                    }else{
                        echo '<label for="keyword">Kata Kunci</label>';
                        echo '<input type="text" name="keyword" id="keyword" class="form-control">';
                    }
                }
            }
        }
    }
?>
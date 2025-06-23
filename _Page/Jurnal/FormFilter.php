<?php
    //Routing Form Filter
    include "../../_Config/Connection.php";
    if(!empty($_POST['KeywordBy'])){
        $KeywordBy=$_POST['KeywordBy'];
        if($KeywordBy=="tanggal"){
            echo ' <input type="date" name="keyword" id="keyword" class="form-control">';
        }else{
            if($KeywordBy=="kode_perkiraan"){
                echo '<select name="keyword" id="keyword" class="form-control">';
                $query = mysqli_query($Conn, "SELECT DISTINCT kode_perkiraan FROM jurnal ORDER BY kode_perkiraan ASC");
                while ($data = mysqli_fetch_array($query)) {
                    $kode_perkiraan= $data['kode_perkiraan'];
                    echo '  <option value="'.$kode_perkiraan.'">'.$kode_perkiraan.'</option>';
                }
                echo '</select>';
            }else{
                if($KeywordBy=="nama_perkiraan"){
                    echo '<select name="keyword" id="keyword" class="form-control">';
                    $query = mysqli_query($Conn, "SELECT DISTINCT nama_perkiraan FROM jurnal ORDER BY nama_perkiraan ASC");
                    while ($data = mysqli_fetch_array($query)) {
                        $nama_perkiraan= $data['nama_perkiraan'];
                        echo '  <option value="'.$nama_perkiraan.'">'.$nama_perkiraan.'</option>';
                    }
                    echo '</select>';
                }else{
                    if($KeywordBy=="d_k"){
                        echo '<select name="keyword" id="keyword" class="form-control">';
                        $query = mysqli_query($Conn, "SELECT DISTINCT d_k FROM jurnal ORDER BY d_k ASC");
                        while ($data = mysqli_fetch_array($query)) {
                            $d_k= $data['d_k'];
                            echo '  <option value="'.$d_k.'">'.$d_k.'</option>';
                        }
                        echo '</select>';
                    }else{
                        if($KeywordBy=="kategori"){
                            echo '<select name="keyword" id="keyword" class="form-control">';
                            $query = mysqli_query($Conn, "SELECT DISTINCT kategori FROM jurnal ORDER BY kategori ASC");
                            while ($data = mysqli_fetch_array($query)) {
                                $kategori= $data['kategori'];
                                echo '  <option value="'.$kategori.'">'.$kategori.'</option>';
                            }
                            echo '</select>';
                        }else{
                            echo ' <input type="text" name="keyword" id="keyword" class="form-control">';
                        }
                    }
                }
            }
        }
    }else{
        echo ' <input type="text" name="keyword" id="keyword" class="form-control">';
    }
?>
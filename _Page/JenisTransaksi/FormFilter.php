<?php
    include "../../_Config/Connection.php";
    if(empty($_POST['keyword_by'])){
        echo '<label for="keyword">Kata Kunci</label>';
        echo '<input type="text" name="keyword" id="keyword" class="form-control">';
    }else{
        $keyword_by=$_POST['keyword_by'];
        if($keyword_by=="kategori"){
            echo '<label for="keyword">Kata Kunci</label>';
            echo '<select name="keyword" id="keyword" class="form-control">';
            echo '  <option value="">Pilih</option>';
            $query = mysqli_query($Conn, "SELECT DISTINCT kategori FROM transaksi_jenis ORDER BY kategori ASC");
            while ($data = mysqli_fetch_array($query)) {
                $kategori= $data['kategori'];
                echo '  <option value="'.$kategori.'">'.$kategori.'</option>';
            }
            echo '</select>';
        }else{
            if($keyword_by=="id_akun_debet"){
                echo '<label for="keyword">Kata Kunci</label>';
                echo '<select name="keyword" id="keyword" class="form-control">';
                echo '  <option value="">Pilih</option>';
                $query = mysqli_query($Conn, "SELECT DISTINCT id_akun_debet FROM transaksi_jenis ORDER BY id_akun_debet ASC");
                while ($data = mysqli_fetch_array($query)) {
                    $id_akun_debet= $data['id_akun_debet'];
                    $nama_perkiraan_debet=GetDetailData($Conn,'akun_perkiraan','id_perkiraan',$id_akun_debet,'nama');
                    echo '  <option value="'.$id_akun_debet.'">'.$nama_perkiraan_debet.'</option>';
                }
                echo '</select>';
            }else{
                if($keyword_by=="id_akun_kredit"){
                    echo '<label for="keyword">Kata Kunci</label>';
                    echo '<select name="keyword" id="keyword" class="form-control">';
                    echo '  <option value="">Pilih</option>';
                    $query = mysqli_query($Conn, "SELECT DISTINCT id_akun_kredit FROM transaksi_jenis ORDER BY id_akun_kredit ASC");
                    while ($data = mysqli_fetch_array($query)) {
                        $id_akun_kredit= $data['id_akun_kredit'];
                        $nama_perkiraan_kredit=GetDetailData($Conn,'akun_perkiraan','id_perkiraan',$id_akun_kredit,'nama');
                        echo '  <option value="'.$id_akun_kredit.'">'.$nama_perkiraan_kredit.'</option>';
                    }
                    echo '</select>';
                }else{
                    echo '<label for="keyword">Kata Kunci</label>';
                    echo '<input type="text" name="keyword" id="keyword" class="form-control">';
                }
            }
        }
    }
?>
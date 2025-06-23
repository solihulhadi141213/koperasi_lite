<?php
    include "../../_Config/Connection.php";
    
    if(!empty($_POST['keyword_by'])){
        $KeywordBy=$_POST['keyword_by'];
        if($KeywordBy=="tanggal"){
            echo ' <input type="date" name="keyword" id="keyword" class="form-control">';
        }else{
            if($KeywordBy=="kategori"){
                echo '
                    <select name="keyword" id="keyword" class="form-control">
                        <option value="">Pilih</option>
                        <option value="Pembelian">Pembelian</option>
                        <option value="Retur Pembelian">Retur Pembelian</option>
                    </select>
                ';
            }else{
                if($KeywordBy=="status"){
                    echo '
                        <select name="keyword" id="keyword" class="form-control">
                            <option value="">Pilih</option>
                            <option value="Lunas">Lunas</option>
                            <option value="Kredit">Kredit</option>
                        </select>
                    ';
                }else{
                    if($KeywordBy=="id_supplier"){
                        echo '<select name="keyword" id="keyword" class="form-control">';
                        echo '  <option value="">Pilih</option>';
                        //Buka Tabel Supplier
                        $query = mysqli_query($Conn, "SELECT id_supplier, nama_supplier FROM supplier ORDER BY nama_supplier ASC");
                        while ($data = mysqli_fetch_array($query)) {
                            $id_supplier_list= $data['id_supplier'];
                            $nama_supplier= $data['nama_supplier'];
                            echo '<option value="'.$id_supplier_list.'">'.$nama_supplier.'</option>';
                        }
                        echo '</select>';
                    }else{
                        echo ' <input type="text" name="keyword" id="keyword" class="form-control">';
                    }
                }
            }
        }
    }else{
        echo ' <input type="text" name="keyword" id="keyword" class="form-control">';
    }
?>
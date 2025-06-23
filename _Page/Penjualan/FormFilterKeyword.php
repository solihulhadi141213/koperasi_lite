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
                        <option value="Penjualan">Penjualan</option>
                        <option value="Retur Penjualan">Retur Penjualan</option>
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
                    echo ' <input type="text" name="keyword" id="keyword" class="form-control">';
                }
            }
        }
    }else{
        echo ' <input type="text" name="keyword" id="keyword" class="form-control">';
    }
?>
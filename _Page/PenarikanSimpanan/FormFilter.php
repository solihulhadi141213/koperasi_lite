<?php
    include "../../_Config/Connection.php";
    if(empty($_POST['keyword_by'])){
        echo '<input type="text" name="keyword" id="keyword" class="form-control">';
    }else{
        $keyword_by=$_POST['keyword_by'];
        if($keyword_by=="tanggal"){
            echo '<input type="date" name="keyword" id="keyword" class="form-control">';
        }else{
            if($keyword_by=="status"){    
                echo '<select name="keyword" id="keyword" class="form-control">';
                echo '  <option value="">Pilih</option>';
                $query = mysqli_query($Conn, "SELECT DISTINCT status FROM simpanan_penarikan ORDER BY status ASC");
                while ($data = mysqli_fetch_array($query)) {
                    $status= $data['status'];
                    echo '  <option value="'.$status.'">'.$status.'</option>';
                }
                echo '</select>';
            }else{
                if($keyword_by=="id_anggota"){    
                    echo '<select name="keyword" id="keyword" class="form-control">';
                    echo '  <option value="">Pilih</option>';
                    $query = mysqli_query($Conn, "SELECT id_anggota, nama FROM anggota ORDER BY nama ASC");
                    while ($data = mysqli_fetch_array($query)) {
                        $id_anggota= $data['id_anggota'];
                        $nama= $data['nama'];
                        echo '  <option value="'.$id_anggota.'">'.$nama.'</option>';
                    }
                    echo '</select>';
                }else{
                    echo '<input type="text" name="keyword" id="keyword" class="form-control">';
                }
            }
        }
    }
?>
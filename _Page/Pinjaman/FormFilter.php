<?php
    include "../../_Config/Connection.php";
    if(!empty($_POST['keyword_by'])){
        $keyword_by=$_POST['keyword_by'];
        if($keyword_by=="tanggal_pengajuan"){
            echo '<input type="date" name="keyword" id="keyword" class="form-control">';
        }else{
            if($keyword_by=="id_pinjaman_jenis"){
                echo '<select name="keyword" id="keyword" class="form-control">';
                echo '  <option value="">Pilih</option>';
                $query = mysqli_query($Conn, "SELECT id_pinjaman_jenis, nama_pinjaman FROM pinjaman_jenis ORDER BY nama_pinjaman ASC");
                while ($data = mysqli_fetch_array($query)) {
                    $nama_pinjaman= $data['nama_pinjaman'];
                    echo '  <option value="'.$id_pinjaman_jenis.'">'.$nama_pinjaman.'</option>';
                }
                echo '</select>';
            }else{
                if($keyword_by=="id_anggota"){
                    echo '<select name="keyword" id="keyword" class="form-control">';
                    echo '  <option value="">Pilih</option>';
                   $query = mysqli_query($Conn, "SELECT id_anggota, nama FROM anggota ORDER BY nama ASC");
                    while ($data = mysqli_fetch_array($query)) {
                        $nama= $data['nama'];
                        echo '  <option value="'.$id_anggota.'">'.$nama.'</option>';
                    }
                    echo '</select>';
                }else{
                    if($keyword_by=="status"){
                        echo '<select name="keyword" id="keyword" class="form-control">';
                        echo '  <option value="">Pilih</option>';
                        $query = mysqli_query($Conn, "SELECT DISTINCT status FROM pinjaman ORDER BY status ASC");
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
    }else{
        echo '<input type="text" name="keyword" id="keyword" class="form-control">';
    }
?>
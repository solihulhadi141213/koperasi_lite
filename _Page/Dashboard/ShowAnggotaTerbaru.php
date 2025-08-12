<?php
    // Koneksi
    include "../../_Config/Connection.php";
    include "../../_Config/GlobalFunction.php";

    $RowAnggota = mysqli_num_rows(mysqli_query($Conn, "SELECT*FROM anggota"));
    if(empty($RowAnggota)){
        echo '<div class="activity-item d-flex">';
        echo '  Data Anggota Belum Ada';
        echo '</div>';
    }else{
        //Arraykan Simpanan
        $QryAnggota = mysqli_query($Conn, "SELECT nama, tanggal_masuk, status FROM anggota ORDER BY tanggal_masuk DESC LIMIT 5");
        while ($DataAnggota = mysqli_fetch_array($QryAnggota)) {
            $nama= $DataAnggota['nama'];
            $status= $DataAnggota['status'];
            $tanggal= $DataAnggota['tanggal_masuk'];
            $strtotime_anggota= strtotime($tanggal);
            $tanggal_anggota_format=date('d/m/y', $strtotime_anggota);
            //Routing status
            if($status=="Pending"){
                $label_status='<code class="text text-warning">Pending</code>';
            }else{
                if($status=="Keluar"){
                    $label_status='<code class="text text-danger">Keluar</code>';
                }else{
                    $label_status='<code class="text text-success">Aktif</code>';
                }
            }
            echo '<div class="activity-item d-flex">';
            echo '  <div class="activite-label"><code class="text-info">'.$tanggal_anggota_format.'</code></div>';
            echo '  <i class="bi bi-circle-fill activity-badge text-success align-self-start"></i>';
            echo '  <div class="activity-content">';
            echo '      
                        <small class="credit">'.$nama.'</small>
                        <br>
                        <small>'.$label_status.'</small>';
            echo '  </div>';
            echo '</div>';
        }
    }
?>
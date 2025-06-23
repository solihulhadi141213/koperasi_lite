<?php
    // Koneksi dan session
    include "../../_Config/Connection.php";

    $stmt = $Conn->prepare("SELECT DISTINCT satuan FROM barang");
    $stmt->execute();
    $result = $stmt->get_result();
    if ($result->num_rows > 0) {
        while ($data = $result->fetch_assoc()) {
            if(!empty($data['satuan'])){
                $satuan = $data['satuan'];
                echo '<option value="'.$satuan.'">';
            }
        }
    }
?>
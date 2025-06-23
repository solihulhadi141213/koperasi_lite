<?php
    // Koneksi dan session
    include "../../_Config/Connection.php";

    $stmt = $Conn->prepare("SELECT DISTINCT kategori_barang FROM barang");
    $stmt->execute();
    $result = $stmt->get_result();
    if ($result->num_rows > 0) {
        while ($data = $result->fetch_assoc()) {
            if(!empty($data['kategori_barang'])){
                $kategori = $data['kategori_barang'];
                echo '<option value="'.$kategori.'">';
            }
        }
    }
?>
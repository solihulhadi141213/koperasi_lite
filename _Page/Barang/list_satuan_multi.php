<?php
    include "../../_Config/Connection.php";
    $QrySatuanMulti = mysqli_query($Conn, "SELECT DISTINCT satuan_multi FROM barang_satuan ORDER BY satuan_multi ASC");
    while ($DataSatuanMulti = mysqli_fetch_array($QrySatuanMulti)) {
        $satuan_multi= $DataSatuanMulti['satuan_multi'];
        echo '<option value="'.$satuan_multi.'">';
    }
?>
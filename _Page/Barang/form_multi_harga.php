<?php
    // Koneksi dan session
    include "../../_Config/Connection.php";

    $stmt = $Conn->prepare("SELECT * FROM barang_kategori_harga");
    $stmt->execute();
    $result = $stmt->get_result();
    if ($result->num_rows > 0) {
        while ($data = $result->fetch_assoc()) {
            if(!empty($data['id_barang_kategori_harga'])){
                $id_barang_kategori_harga = $data['id_barang_kategori_harga'];
                $kategori_harga = $data['kategori_harga'];
                $keterangan = $data['keterangan'];
                echo '<div class="row mb-3">';
                echo '
                        <div class="col-4">
                            <label for="harga_multi_'.$id_barang_kategori_harga.'">'.$kategori_harga.'</label>
                        </div>
                ';
                echo '  <div class="col-md-8">';
                echo '      <div class="input-group">';
                echo '          <span class="input-group-text">';
                echo '              <small>Rp</small>';
                echo '          </span>';
                echo "          <input type=\"text\" class=\"form-control form-money\" name=\"harga_multi[]\" maxlength=\"15\" inputmode=\"numeric\" id=\"harga_multi_$id_barang_kategori_harga\" oninput=\"this.value = this.value.replace(/[^0-9]/g, '');\">";
                echo '      </div>';
                echo "      <small class=\"text-muted\">* $keterangan</small>";
                echo '  </div>';
                echo '</div>';
            }
        }
    }
?>
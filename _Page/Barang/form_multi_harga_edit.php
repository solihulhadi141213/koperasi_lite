<?php
    // Koneksi dan session
    include "../../_Config/Connection.php";
    include "../../_Config/GlobalFunction.php";
    //Tangkap id_barang
    if(empty($_POST['id_barang'])){
        echo '
            <div class="alert alert-danger">
                ID Barang Tidak Boleh Kosong!
            </div>
        ';
    }else{
        $id_barang=$_POST['id_barang'];
        $stmt = $Conn->prepare("SELECT * FROM barang_kategori_harga");
        $stmt->execute();
        $result = $stmt->get_result();
        if ($result->num_rows > 0) {
            while ($data = $result->fetch_assoc()) {
                if(!empty($data['id_barang_kategori_harga'])){
                    $id_barang_kategori_harga = $data['id_barang_kategori_harga'];
                    $kategori_harga = $data['kategori_harga'];
                    $keterangan = $data['keterangan'];
                    //Harga Barang
                    $Qry = $Conn->prepare("SELECT * FROM barang_harga WHERE id_barang = ? AND id_barang_kategori_harga = ?");
                    $Qry->bind_param("ii", $id_barang, $id_barang_kategori_harga);
                    if (!$Qry->execute()) {
                        $error=$Conn->error;
                        echo '
                            <div class="alert alert-danger">
                                Terjadi Kesalahan : '.$error.'
                            </div>
                        ';
                    }else{
                        $Result = $Qry->get_result();
                        $Data = $Result->fetch_assoc();
                        $Qry->close();
                        //Buat Variabel
                        if(!empty($Data['harga'])){
                            $harga=$Data['harga'];
                        }else{
                            $harga=0;
                        }
                        $harga = ceil($harga);
                        
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
                        echo "          <input type=\"text\" class=\"form-control form-money\" name=\"harga_multi[]\" maxlength=\"15\" inputmode=\"numeric\" id=\"harga_multi_$id_barang_kategori_harga\" oninput=\"this.value = this.value.replace(/[^0-9]/g, '');\" value=\"harga_multi_$harga\">";
                        echo '      </div>';
                        echo "      <small class=\"text-muted\">* $keterangan</small>";
                        echo '  </div>';
                        echo '</div>';
                    }
                }
            }
        }
    }
?>
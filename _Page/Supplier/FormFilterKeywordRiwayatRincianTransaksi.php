<?php
    //Koneksi
    include "../../_Config/Connection.php";

    //Tangkap Dasar Pencarian
    if(!empty($_POST['keyword_by_riwayat_transaksi'])){
        $keyword_by_riwayat_transaksi=$_POST['keyword_by_riwayat_transaksi'];
        if($keyword_by_riwayat_transaksi=="kategori"){
            echo '
                <select name="keyword" id="keyword_riwayat_transaksi" class="form-control">
                    <option value="">Pilih</option>
                    <option value="Pembelian">Pembelian</option>
                    <option value="Retur Pembelian">Retur Pembelian</option>
                </select>
            ';
        }else{
            if($keyword_by_riwayat_transaksi=="tanggal"){
                echo ' <input type="date" name="keyword" id="keyword_riwayat_transaksi" class="form-control">';
            }else{
                if($keyword_by_riwayat_transaksi=="status"){
                    echo '
                        <select name="keyword" id="keyword_riwayat_transaksi" class="form-control">
                            <option value="Lunas">Lunas</option>
                            <option value="Kredit">Kredit/Utang</option>
                        </select>
                    ';
                }else{
                    echo ' <input type="text" name="keyword" id="keyword_riwayat_transaksi" class="form-control">';
                }
            }
        }
    }else{
        echo ' <input type="text" name="keyword" id="keyword_riwayat_transaksi" class="form-control">';
    }
?>
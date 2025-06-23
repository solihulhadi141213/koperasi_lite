<?php
    // Koneksi dan session
    include "../../_Config/Connection.php";
    include "../../_Config/GlobalFunction.php";
    include "../../_Config/Session.php";
    
    // Inisiasi Variabel
    $JmlHalaman = 0;
    $page = 1;
    
    if(empty($SessionIdAkses)){
        echo '
            <tr>
                <td colspan="12" class="text-center text-danger">
                    Sesi Akses Sudah Berakhir! Silahkan Login Ulang
                </td>
            </tr>
        ';
        exit();
    }
    
    // Ambil parameter dengan sanitasi
    $keyword_by = !empty($_POST['keyword_by']) ? $_POST['keyword_by'] : "";
    $keyword = !empty($_POST['keyword']) ? $_POST['keyword'] : "";
    $batas = !empty($_POST['batas']) ? (int)$_POST['batas'] : 10;
    $ShortBy = !empty($_POST['ShortBy']) ? ($_POST['ShortBy'] == 'ASC' ? 'ASC' : 'DESC') : 'DESC';
    $OrderBy = !empty($_POST['OrderBy']) ? $_POST['OrderBy'] : "id_transaksi_jual_beli_rincian";
    $page = !empty($_POST['page']) ? (int)$_POST['page'] : 1;
    $posisi = ($page - 1) * $batas;
    
    // Query dasar untuk menghitung jumlah data
    $countQuery = "SELECT COUNT(tjbr.id_transaksi_jual_beli_rincian) as total 
                  FROM transaksi_jual_beli_rincian tjbr 
                  LEFT JOIN transaksi_jual_beli tjb ON tjbr.id_transaksi_jual_beli = tjb.id_transaksi_jual_beli
                  WHERE (tjb.kategori='Penjualan' OR tjb.kategori='Retur Penjualan')";
    
    // Query dasar untuk mengambil data
    $dataQuery = "SELECT tjbr.*, tjb.kategori, tjb.tanggal 
                 FROM transaksi_jual_beli_rincian tjbr 
                 LEFT JOIN transaksi_jual_beli tjb ON tjbr.id_transaksi_jual_beli = tjb.id_transaksi_jual_beli
                 WHERE (tjb.kategori='Penjualan' OR tjb.kategori='Retur Penjualan')";
    
    // Persiapkan parameter untuk prepared statement
    $params = [];
    $types = "";
    
    // Tambahkan kondisi pencarian
    if(empty($keyword_by)){
        if(!empty($keyword)){
            $countQuery .= " AND (tjbr.nama_barang LIKE ? OR tjbr.satuan LIKE ?)";
            $dataQuery .= " AND (tjbr.nama_barang LIKE ? OR tjbr.satuan LIKE ?)";
            $params = array_merge($params, ["%$keyword%", "%$keyword%"]);
            $types .= "ss";
        }
    } else {
        if(!empty($keyword)){
            if($keyword_by == "kategori"){
                $countQuery = "SELECT COUNT(tjbr.id_transaksi_jual_beli_rincian) as total 
                             FROM transaksi_jual_beli_rincian tjbr 
                             LEFT JOIN transaksi_jual_beli tjb ON tjbr.id_transaksi_jual_beli = tjb.id_transaksi_jual_beli
                             WHERE tjb.kategori=?";
                $dataQuery = "SELECT tjbr.*, tjb.kategori, tjb.tanggal 
                             FROM transaksi_jual_beli_rincian tjbr 
                             LEFT JOIN transaksi_jual_beli tjb ON tjbr.id_transaksi_jual_beli = tjb.id_transaksi_jual_beli
                             WHERE tjb.kategori=?";
                $params = [$keyword];
                $types .= "s";
            } elseif($keyword_by == "tanggal"){
                $countQuery .= " AND (tjb.tanggal LIKE ?)";
                $dataQuery .= " AND (tjb.tanggal LIKE ?)";
                $params = ["%$keyword%"];
                $types .= "s";
            } else {
                $countQuery .= " AND (tjbr.$keyword_by LIKE ?)";
                $dataQuery .= " AND (tjbr.$keyword_by LIKE ?)";
                $params = ["%$keyword%"];
                $types .= "s";
            }
        }
    }
    
    // Hitung jumlah data
    $stmt = $Conn->prepare($countQuery);
    if(!empty($params)){
        $stmt->bind_param($types, ...$params);
    }
    $stmt->execute();
    $result = $stmt->get_result();
    $row = $result->fetch_assoc();
    $jml_data = $row['total'];
    $stmt->close();
    
    if(empty($jml_data)){
        echo '
            <tr>
                <td colspan="12" class="text-center text-danger">
                    Tidak Ada Data Laba Transaksi Yang Ditampilkan.
                </td>
            </tr>
        ';
    } else {
        // Tambahkan sorting dan limit untuk query data
        $dataQuery .= " ORDER BY $OrderBy $ShortBy LIMIT ?, ?";
        $params = array_merge($params, [$posisi, $batas]);
        $types .= "ii";
        
        // Eksekusi query data
        $stmt = $Conn->prepare($dataQuery);
        $stmt->bind_param($types, ...$params);
        $stmt->execute();
        $query = $stmt->get_result();
        
        $no = $posisi + 1;
        while ($data = $query->fetch_assoc()) {
            $id_transaksi_jual_beli_rincian = $data['id_transaksi_jual_beli_rincian'];
            $id_transaksi_jual_beli = $data['id_transaksi_jual_beli'];
            $kategori = $data['kategori'];
            $tanggal = $data['tanggal'];
            $nama_barang = htmlspecialchars($data['nama_barang']);
            $satuan = htmlspecialchars($data['satuan']);
            $qty = (float)$data['qty'];
            $hpp = (float)$data['hpp'];
            $harga = (float)$data['harga'];
            $ppn = (float)$data['ppn'];
            $diskon = (float)$data['diskon'];
            $subtotal = (float)$data['subtotal'];
            
            $total_hpp = $hpp * $qty;
            $margin = $subtotal - $total_hpp;
            
            $hpp_rp = " " . number_format($hpp, 0, ',', '.');
            $total_hpp_rp = " " . number_format($total_hpp, 0, ',', '.');
            $harga_rp = " " . number_format($harga, 0, ',', '.');
            $ppn_rp = " " . number_format($ppn, 0, ',', '.');
            $diskon_rp = " " . number_format($diskon, 0, ',', '.');
            $subtotal_rp = " " . number_format($subtotal, 0, ',', '.');
            $margin_rp = " " . number_format($margin, 0, ',', '.');
            
            if($kategori == "Penjualan"){
                $label_kategori = '<span class="text text-success">PENJUALAN</span>';
            } else {
                $label_kategori = '<span class="text text-warning">RETUR</span>';
            }
            
            if($margin < 0){
                $label_margin = '<span class="text-danger">'.$margin_rp.'</span>';
            } else {
                if($margin > 0){
                    $label_margin = '<span class="text-success">'.$margin_rp.'</span>';
                } else {
                    $label_margin = '<span class="text-dark">'.$margin_rp.'</span>';
                }
            }
            
            $TanggalTransaksi = date('d/m/Y H:i', strtotime($tanggal));
            
            echo '
                <tr>
                    <td><small>'.$no.'</small></td>
                    <td>
                        <a href="javascript:void(0);" class="text text-decoration-underline" data-bs-toggle="modal" data-bs-target="#ModalDetail" data-id="'.$id_transaksi_jual_beli.'">
                            <small>'.$TanggalTransaksi.'</small>
                        </a>
                    </td>
                    <td><small>'.$label_kategori.'</small></td>
                    <td><small>'.$nama_barang.'</small></td>
                    <td><small>'.$hpp_rp.'</small></td>
                    <td><small>'.$harga_rp.'</small></td>
                    <td><small>'.$qty.' '.$satuan.'</small></td>
                    <td><small>'.$ppn_rp.'</small></td>
                    <td><small>'.$diskon_rp.'</small></td>
                    <td><small>'.$subtotal_rp.'</small></td>
                    <td><small>'.$total_hpp_rp.'</small></td>
                    <td><small>'.$label_margin.'</small></td>
                </tr>
            ';
            $no++;
        }
        $stmt->close();
        
        $JmlHalaman = ceil($jml_data / $batas);
    }
?>

<script>
    // Creat Javascript Variabel
    var page_count = <?php echo $JmlHalaman; ?>;
    var curent_page = <?php echo $page; ?>;
    
    // Put Into Pagging Element
    $('#page_info_laba').html('Page ' + curent_page + ' Of ' + page_count);
    
    // Set Pagging Button
    if(curent_page == 1){
        $('#prev_button_laba').prop('disabled', true);
    } else {
        $('#prev_button_laba').prop('disabled', false);
    }
    if(page_count <= curent_page){
        $('#next_button_laba').prop('disabled', true);
    } else {
        $('#next_button_laba').prop('disabled', false);
    }
</script>
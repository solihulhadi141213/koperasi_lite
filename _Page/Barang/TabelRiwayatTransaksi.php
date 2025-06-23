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
                <td colspan="10" class="text-center text-danger">
                    <small>Sesi Akses Sudah Berakhir! Silahkan Login Ulang</small>
                </td>
            </tr>
        ';
    } else {
        if(empty($_POST['id_barang'])){
            echo '
                <tr>
                    <td colspan="10" class="text-center text-danger">
                        <small>ID Barang Tidak Boleh Kosong</small>
                    </td>
                </tr>
            ';
        } else {
            $id_barang = $_POST['id_barang'];

            // Keyword_by
            $keyword_by = !empty($_POST['keyword_by']) ? $_POST['keyword_by'] : "";
            // Keyword
            $keyword = !empty($_POST['keyword']) ? $_POST['keyword'] : "";
            // Batas
            $batas = !empty($_POST['batas']) ? $_POST['batas'] : "10";
            // ShortBy
            $ShortBy = !empty($_POST['ShortBy']) ? $_POST['ShortBy'] : "DESC";
            // OrderBy
            $OrderBy = !empty($_POST['OrderBy']) ? $_POST['OrderBy'] : "id_transaksi_jual_beli_rincian";
            // Atur Page
            $page = !empty($_POST['page']) ? $_POST['page'] : "1";
            $posisi = ($page - 1) * $batas;

            // Query dasar
            $query = "SELECT r.*, t.kategori, t.tanggal, t.status 
                      FROM transaksi_jual_beli_rincian r
                      JOIN transaksi_jual_beli t ON r.id_transaksi_jual_beli = t.id_transaksi_jual_beli
                      WHERE r.id_barang = '$id_barang'";

            // Tambahkan kondisi pencarian
            if (!empty($keyword_by) && !empty($keyword)) {
                $query .= " AND $keyword_by LIKE '%$keyword%'";
            } elseif (!empty($keyword)) {
                $query .= " AND (t.kategori LIKE '%$keyword%' OR t.tanggal LIKE '%$keyword%' OR t.status LIKE '%$keyword%' OR r.satuan LIKE '%$keyword%')";
            }

            // Hitung jumlah data
            $jml_data = mysqli_num_rows(mysqli_query($Conn, $query));

            if(empty($jml_data)){
                echo '
                    <tr>
                        <td colspan="10" class="text-center text-danger">
                            Tidak Ada Data Yang Ditampilkan.
                        </td>
                    </tr>
                ';
            } else {
                // Tambahkan pengurutan dan batasan
                $query .= " ORDER BY $OrderBy $ShortBy LIMIT $posisi, $batas";
                $result = mysqli_query($Conn, $query);

                $no = 1 + $posisi;
                while ($data = mysqli_fetch_assoc($result)) {
                    $id_transaksi_jual_beli_rincian = $data['id_transaksi_jual_beli_rincian'];
                    $id_transaksi_jual_beli = $data['id_transaksi_jual_beli'];
                    $satuan = $data['satuan'];
                    $qty = $data['qty'];
                    $harga = $data['harga'];
                    $ppn = $data['ppn'];
                    $diskon = $data['diskon'];
                    $subtotal = $data['subtotal'];
                    $kategori = $data['kategori'];
                    $tanggal = $data['tanggal'];
                    $status = $data['status'];

                    // Format tanggal
                    $tanggal = date('d/m/Y', strtotime($tanggal));

                    // Label Kategori
                    $label_kategori = '';
                    switch ($kategori) {
                        case 'Pembelian':
                            $label_kategori = '<span class="badge badge-info">Pembelian</span>';
                            break;
                        case 'Penjualan':
                            $label_kategori = '<span class="badge badge-primary">Penjualan</span>';
                            break;
                        case 'Retur Pembelian':
                            $label_kategori = '<span class="badge badge-warning">Retur Pembelian</span>';
                            break;
                        case 'Retur Penjualan':
                            $label_kategori = '<span class="badge badge-danger">Retur Penjualan</span>';
                            break;
                    }

                    // Label Status
                    $label_status = $status == "Lunas" ? '<span class="badge badge-success">Lunas</span>' : '<span class="badge badge-warning">Kredit</span>';

                    // Format Rp
                    $jumlah = $qty * $harga;
                    $jumlah_format = number_format($jumlah, 0, ',', '.');
                    $harga_format = number_format($harga, 0, ',', '.');
                    $diskon_format = number_format($diskon, 0, ',', '.');
                    $ppn_format = number_format($ppn, 0, ',', '.');
                    $subtotal_format = number_format($subtotal, 0, ',', '.');

                    echo '
                        <tr>
                            <td><small>'.$no.'</small></td>
                            <td>
                                <a href="javascript:void(0);" data-bs-toggle="modal" data-bs-target="#ModalDetailTransaksi" data-id="'.$id_transaksi_jual_beli.'" data-id_rincian="'.$id_transaksi_jual_beli_rincian.'">
                                    <small>'.$tanggal.'</small>
                                </a>
                            </td>
                            <td><small>'.$label_kategori.'</small></td>
                            <td><small>'.$harga_format.'</small></td>
                            <td><small>'.$qty.'</small></td>
                            <td><small>'.$satuan.'</small></td>
                            <td><small>'.$jumlah_format.'</small></td>
                            <td><small>'.$ppn_format.'</small></td>
                            <td><small>'.$diskon_format.'</small></td>
                            <td><small>'.$subtotal_format.'</small></td>
                            <td><small>'.$label_status.'</small></td>
                        </tr>
                    ';
                    $no++;
                }
                $JmlHalaman = ceil($jml_data / $batas);
            }
        }
    }
?>

<script>
    // Create Javascript Variabel
    var page_count = <?php echo $JmlHalaman; ?>;
    var curent_page = <?php echo $page; ?>;

    // Put Into Pagging Element
    $('#page_info_riwayat_transaksi').html('Page ' + curent_page + ' Of ' + page_count + '');

    // Set Pagging Button
    if(curent_page == 1){
        $('#prev_button_riwayat_transaksi').prop('disabled', true);
    } else {
        $('#prev_button_riwayat_transaksi').prop('disabled', false);
    }
    if(page_count <= curent_page){
        $('#next_button_riwayat_transaksi').prop('disabled', true);
    } else {
        $('#next_button_riwayat_transaksi').prop('disabled', false);
    }
</script>
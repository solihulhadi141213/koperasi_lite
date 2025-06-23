<?php
    // Koneksi & Konfigurasi
    include "../../_Config/Connection.php";
    include "../../_Config/GlobalFunction.php";
    include "../../_Config/Session.php";
    include "../../_Config/SettingGeneral.php";

    // Time Zone
    date_default_timezone_set('Asia/Jakarta');
    $now = date('Y-m-d H:i:s');

    // Validasi Sesi Login
    if (empty($SessionIdAkses)) {
        echo '
            <div class="alert alert-danger">
                Sesi Akses Sudah Berakhir! Silahkan Login Ulang!
            </div>
        ';
    } elseif (!isset($_POST['id_transaksi_jual_beli']) || empty($_POST['id_transaksi_jual_beli'])) {
        echo '
            <div class="alert alert-danger">
                ID Transaksi Penjualan Tidak Boleh Kosong!
            </div>
        ';
    } else {
        // Ambil Data Transaksi
        $id_transaksi_jual_beli = validateAndSanitizeInput($_POST['id_transaksi_jual_beli']);
        //Buka Data
        $Qry = $Conn->prepare("SELECT * FROM transaksi_jual_beli WHERE id_transaksi_jual_beli = ?");
        $Qry->bind_param("s", $id_transaksi_jual_beli);
        if (!$Qry->execute()) {
            echo '
                <div class="alert alert-danger">
                    Terjadi Kesalahan : '.$Conn->error.'
                </div>
            ';
        } else {
            $Result = $Qry->get_result();
            $Data = $Result->fetch_assoc();
            $Qry->close();
            if (!$Data) {
                echo '
                    <div class="alert alert-danger">
                        Data Transaksi Yang Anda Pilih Tidak Ditemukan Pada Database
                    </div>
                ';
            } else {
                // Ambil Data Transaksi
                $id_supplier = $Data['id_supplier'];
                $kategori = $Data['kategori'];
                $tanggal = $Data['tanggal'];
                $subtotal = pembulatan_nilai($Data['subtotal']);
                $ppn = pembulatan_nilai($Data['ppn']);
                $diskon = pembulatan_nilai($Data['diskon']);
                $total = pembulatan_nilai($Data['total']);
                $cash = pembulatan_nilai($Data['cash']);
                $kembalian = pembulatan_nilai($Data['kembalian']);
                $status = $Data['status'];

                // Format Rupiah
                $subtotal_rp = "" . number_format($subtotal, 0, ',', '.');
                $ppn_rp = "" . number_format($ppn, 0, ',', '.');
                $diskon_rp = "" . number_format($diskon, 0, ',', '.');
                $total_rp = "" . number_format($total, 0, ',', '.');
                $cash_rp = "" . number_format($cash, 0, ',', '.');
                $kembalian_rp = "" . number_format($kembalian, 0, ',', '.');

                // Ambil Nama Supplier
                $nama_supplier = (!empty($id_supplier)) ? GetDetailData($Conn, 'supplier', 'id_supplier', $id_supplier, 'nama_supplier') : "-";

                // Ambil Rincian Transaksi
                $list_rincian = [];
                $stmt = $Conn->prepare("SELECT * FROM transaksi_jual_beli_rincian WHERE id_transaksi_jual_beli = ?");
                $stmt->bind_param("s", $id_transaksi_jual_beli);
                $stmt->execute();
                $result_rincian = $stmt->get_result();

                
                //Tampilkan Data
                echo '
                    <div class="row mb-3 dashed-underline">
                        <div class="col-12 mb-3 text-center">
                            <b>'.$title_page.'</b><br>
                            <small>'.$alamat_bisnis.'</small><br>
                            <small>Telp : '.$telepon_bisnis.'</small>
                        </div>
                    </div>
                    <div class="row mb-2">
                        <div class="col-4">
                            <small>Tanggal/Jam</small>
                        </div>
                        <div class="col-8">
                            <small class="text text-grayish">'.$tanggal.'</small>
                        </div>
                    </div>
                    <div class="row mb-2">
                        <div class="col-4">
                            <small>Supplier</small>
                        </div>
                        <div class="col-8">
                            <small class="text text-grayish">'.$nama_supplier.'</small>
                        </div>
                    </div>
                    <div class="row mb-3 dashed-underline">
                        <div class="col-4">
                            <small>Transaksi</small>
                        </div>
                        <div class="col-8">
                            <small class="text text-grayish">'.$kategori.'</small>
                        </div>
                    </div>
                ';
                echo '<div class="row mb-3 dashed-underline">';
                echo '   <div class="col-12">';
                echo '      <table width="100%">';
                echo '
                    <tr>
                        <td><small>Uraian</small></td>
                        <td><small>Harga*Qty</small></td>
                        <td><small>DSC</small></td>
                        <td align="right"><small>Jumlah</small></td>
                    </tr>
                ';
                $no=1;
                $sum_subtotal=0;
                $sum_ppn=0;
                while ($data_rincian = $result_rincian->fetch_assoc()) {
                    $nama_barang=$data_rincian['nama_barang'];
                    $qty=$data_rincian['qty'];
                    $harga=$data_rincian['harga'];
                    $ppn_rincian=$data_rincian['ppn'];
                    $diskon_rincian=$data_rincian['diskon'];
                    //Bulatkan Nilai
                    $qty=pembulatan_nilai($qty);
                    $harga=pembulatan_nilai($harga);
                    $ppn_rincian=pembulatan_nilai($ppn_rincian);
                    $diskon_rincian=pembulatan_nilai($diskon_rincian);
                    //Format RP
                    $harga_format="" . number_format($data_rincian['harga'], 0, ',', '.');
                    $diskon_rincian_format="" . number_format($data_rincian['diskon'], 0, ',', '.');
                    $jumlah=$qty*$harga;
                    $subtotal=$jumlah-$diskon_rincian;
                    $subtotal_format="" . number_format($subtotal, 0, ',', '.');

                    //Arry
                    $sum_subtotal=$sum_subtotal+$subtotal;
                    $sum_ppn=$sum_ppn+$ppn_rincian;
                    echo '
                        <tr>
                            <td><small><code class="text-grayish">'.$nama_barang.'</code></small></td>
                            <td><small><code class="text-grayish">'.$harga_format.' * '.$qty.'</code></small></td>
                            <td><small><code class="text-grayish">'.$diskon_rincian_format.'</code></small></td>
                            <td align="right"><small><code class="text-grayish">'.$subtotal_format.'</code></small></td>
                        </tr>
                    ';
                    $no++;
                }
                //Format Subtotal
                $sum_subtotal_format= "" . number_format($sum_subtotal, 0, ',', '.');
                $sum_ppn_format= "" . number_format($sum_ppn, 0, ',', '.');
                $total_penjualan=$sum_subtotal+$sum_ppn;
                $total_penjualan_format= "" . number_format($total_penjualan, 0, ',', '.');
                echo '
                    <tr>
                        <td colspan="4"><br></td>
                    </tr>
                    <tr>
                        <td colspan="3">
                            <small>SUBTOTAL</small>
                        </td>
                        <td align="right"><small class="text-dark">'.$sum_subtotal_format.'</small></td>
                    </tr>
                    <tr>
                        <td colspan="3">
                            <small>PPN</small>
                        </td>
                        <td align="right"><small class="text-dark">'.$sum_ppn_format.'</small></td>
                    </tr>
                    <tr>
                        <td colspan="3">
                            <small>TOTAL</small>
                        </td>
                        <td align="right"><small class="text-dark">'.$total_penjualan_format.'</small></td>
                    </tr>
                    <tr>
                        <td colspan="3">
                            <small>CASH/UANG</small>
                        </td>
                        <td align="right"><small class="text-dark">'.$cash_rp.'</small></td>
                    </tr>
                    <tr>
                        <td colspan="3">
                            <small>KEMBALIAN</small>
                        </td>
                        <td align="right"><small class="text-dark">'.$kembalian_rp.'</small></td>
                    </tr>
                ';
                echo '      </table>';
                echo '  </div>';
                echo '</div>';
                echo '
                    <div class="row mb-3 dashed-underline">
                        <div class="col-12 mb-3 text-center">
                            <i>Terima Kasih Atas Kunjungan Anda</i>
                        </div>
                    </div>
                ';
            }
        }
    }
?>

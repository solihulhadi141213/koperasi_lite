<?php
// Koneksi
date_default_timezone_set('Asia/Jakarta');
include "../../_Config/Connection.php";
include "../../_Config/GlobalFunction.php";
include "../../_Config/Session.php";

// Tangkap id_shu_session
if(empty($_POST['id_shu_session'])){
    echo '<div class="alert alert-danger"><small>ID SHU Tidak Boleh Kosong!</small></div>';
} else {
    // Buat Variabel dan Bersihkan
    $id_shu_session = validateAndSanitizeInput($_POST['id_shu_session']);

    // Buka data dengan prepared statement
    $Qry = $Conn->prepare("SELECT * FROM shu_session WHERE id_shu_session = ?");
    $Qry->bind_param("i", $id_shu_session);
    if (!$Qry->execute()) {
        echo '<div class="alert alert-danger"><small>Terjadi kesalahan: ' . $Conn->error . '</small></div>';
    } else {
        $Result = $Qry->get_result();
        $Data = $Result->fetch_assoc();

        if(empty($Data['id_shu_session'])){
            echo '<div class="alert alert-danger"><small>Data Sesi SHU tidak ditemukan!</small></div>';
        } else {
            // Variabel data
            $periode_hitung1 = date('d/m/Y', strtotime($Data['periode_hitung1']));
            $periode_hitung2 = date('d/m/Y', strtotime($Data['periode_hitung2']));

            // Jumlah Rincian SHU
            $sum_alokasi = mysqli_fetch_array(mysqli_query($Conn, "SELECT SUM(shu) AS jumlah FROM shu_rincian WHERE id_shu_session='$id_shu_session'"));
            $jumlah_alokasi = $sum_alokasi['jumlah'] ?? 0;

            // Hitung jumlah record
            $jml_data_rincian = mysqli_num_rows(mysqli_query($Conn, "SELECT id_shu_rincian FROM shu_rincian WHERE id_shu_session='$id_shu_session'"));

            if(empty($jml_data_rincian)){
                echo '<div class="alert alert-danger"><small>Tidak Ada Data SHU yang Ditampilkan</small></div>';
            } else {
                ?>
                <style>
                    .table-container{
                        font-family: arial;
                    }
                    .table-container {
                        width: 100%;
                        overflow-x: auto;
                        margin-top: 10px;
                    }
                    table {
                        width: 100%;
                        border-collapse: collapse;
                        margin-bottom: 15px;
                    }
                    th, td {
                        padding: 10px;
                        border: 1px solid #ddd;
                        text-align: right;
                    }
                    th {
                        background-color: #343a40;
                        color: white;
                        text-align: center;
                    }
                    tr:nth-child(even) {
                        background-color: #f9f9f9;
                    }
                    .text-left {
                        text-align: left !important;
                    }
                    .total-row {
                        background-color: #343a40;
                        color: white;
                        font-weight: bold;
                    }
                </style>

                <div class="table-container">
                    <table>
                        <thead>
                            <tr>
                                <th>No</th>
                                <th class="text-left">Anggota</th>
                                <th>NIP</th>
                                <th>Penjualan</th>
                                <th>Simpanan</th>
                                <th>Pinjaman</th>
                                <th>SHU Penjualan</th>
                                <th>SHU Simpanan</th>
                                <th>SHU Pinjaman</th>
                                <th>SHU Total</th>
                            </tr>
                        </thead>
                        <tbody>
                        <?php
                        $no = 1;
                        $JumlahSimpanan = 0;
                        $JumlahPinjaman = 0;
                        $JumlahPenjualan = 0;
                        $JumlahJasaPenjualan = 0;
                        $JumlahJasaSimpanan = 0;
                        $JumlahJasaPinjaman = 0;
                        $JumlahShu = 0;

                        $query = mysqli_query($Conn, "SELECT * FROM shu_rincian WHERE id_shu_session='$id_shu_session' ORDER BY id_shu_rincian ASC");
                        while ($data = mysqli_fetch_array($query)) {
                            // Variabel data
                            $simpanan = number_format($data['simpanan'], 0, ',', '.');
                            $pinjaman = number_format($data['pinjaman'], 0, ',', '.');
                            $penjualan = number_format($data['penjualan'], 0, ',', '.');
                            $jasa_simpanan = number_format($data['jasa_simpanan'], 0, ',', '.');
                            $jasa_pinjaman = number_format($data['jasa_pinjaman'], 0, ',', '.');
                            $jasa_penjualan = number_format($data['jasa_penjualan'], 0, ',', '.');
                            $shu_rp = number_format($data['shu'], 0, ',', '.');

                            // Hitung total transaksi
                            $JumlahSimpanan += $data['simpanan'];
                            $JumlahPinjaman += $data['pinjaman'];
                            $JumlahPenjualan += $data['penjualan'];

                            // Hitung total jasa
                            $JumlahJasaPenjualan += $data['jasa_penjualan'];
                            $JumlahJasaSimpanan += $data['jasa_simpanan'];
                            $JumlahJasaPinjaman += $data['jasa_pinjaman'];

                            // Total SHU
                            $JumlahShu += $data['shu'];

                            echo "
                                <tr>
                                    <td>$no</td>
                                    <td class='text-left'>{$data['nama_anggota']}</td>
                                    <td>{$data['nip']}</td>
                                    <td>$penjualan</td>
                                    <td>$simpanan</td>
                                    <td>$pinjaman</td>
                                    <td>$jasa_penjualan</td>
                                    <td>$jasa_simpanan</td>
                                    <td>$jasa_pinjaman</td>
                                    <td>$shu_rp</td>
                                </tr>
                            ";

                            $no++;
                        }

                        // Format total
                        $JumlahSimpanan_rp = number_format($JumlahSimpanan, 0, ',', '.');
                        $JumlahPinjaman_rp = number_format($JumlahPinjaman, 0, ',', '.');
                        $JumlahPenjualan_rp = number_format($JumlahPenjualan, 0, ',', '.');
                        $JumlahJasaPenjualan_rp = number_format($JumlahJasaPenjualan, 0, ',', '.');
                        $JumlahJasaSimpanan_rp = number_format($JumlahJasaSimpanan, 0, ',', '.');
                        $JumlahJasaPinjaman_rp = number_format($JumlahJasaPinjaman, 0, ',', '.');
                        $JumlahShu_rp = number_format($JumlahShu, 0, ',', '.');

                        echo "
                            <tr class='total-row'>
                                <td colspan='3'>JUMLAH/TOTAL</td>
                                <td>$JumlahPenjualan_rp</td>
                                <td>$JumlahSimpanan_rp</td>
                                <td>$JumlahPinjaman_rp</td>
                                <td>$JumlahJasaPenjualan_rp</td>
                                <td>$JumlahJasaSimpanan_rp</td>
                                <td>$JumlahJasaPinjaman_rp</td>
                                <td>$JumlahShu_rp</td>
                            </tr>
                        ";
                        ?>
                        </tbody>
                    </table>
                </div>
                <?php
            }
        }
    }
}
?>

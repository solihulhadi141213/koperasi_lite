<?php
    //Koneksi
    date_default_timezone_set('Asia/Jakarta');
    include "../../_Config/Connection.php";
    // Ambil tahun dari form, jika tidak ada gunakan tahun sekarang
    $tahun = isset($_POST['tahun']) ? intval($_POST['tahun']) : date('Y');

    // Query untuk mengambil data transaksi berdasarkan tahun yang dipilih
    $query = "
        SELECT 
            MONTH(tanggal) AS bulan,
            SUM(CASE WHEN kategori = 'Penjualan' THEN total 
                    WHEN kategori = 'Retur Penjualan' THEN -total 
                    ELSE 0 END) AS total_penjualan,
            SUM(CASE WHEN kategori = 'Pembelian' THEN total 
                    WHEN kategori = 'Retur Pembelian' THEN -total 
                    ELSE 0 END) AS total_pembelian
        FROM transaksi_jual_beli
        WHERE YEAR(tanggal) = ?
        GROUP BY MONTH(tanggal)
        ORDER BY bulan ASC
    ";

    $stmt = $Conn->prepare($query);
    $stmt->bind_param("i", $tahun);
    $stmt->execute();
    $result = $stmt->get_result();

    $data = array_fill(1, 12, ['penjualan' => 0, 'pembelian' => 0]); // Inisialisasi bulan

    while ($row = $result->fetch_assoc()) {
        $bulan = intval($row['bulan']);
        $data[$bulan] = [
            'penjualan' => floatval($row['total_penjualan']),
            'pembelian' => floatval($row['total_pembelian'])
        ];
    }

    // Format data untuk JSON response
    $response = [
        'bulan' => array_keys($data),
        'penjualan' => array_column($data, 'penjualan'),
        'pembelian' => array_column($data, 'pembelian')
    ];

    header('Content-Type: application/json');
    echo json_encode($response);
?>

<?php
    // Koneksi
    include "../../_Config/Connection.php";
    include "../../_Config/GlobalFunction.php";

    // Tanggal dan waktu saat ini dalam format Y-m-d H:i:s
    $currentDateTime = date('Y-m-d H:i:s');

    // Query untuk menghitung jumlah data yang sudah expired
    $sqlExpiredAccess = "SELECT COUNT(*) AS total_expired FROM akses_login WHERE date_expired > ?";
    $stmt = $Conn->prepare($sqlExpiredAccess);
    $stmt->bind_param("s", $currentDateTime);
    $stmt->execute();
    $resultExpiredAccess = $stmt->get_result();

    if ($resultExpiredAccess) {
        $totalExpiredAccess = intval($resultExpiredAccess->fetch_assoc()['total_expired'] ?? 0);
        
        if ($totalExpiredAccess > 0) {
            echo '
                <div class="alert alert-info mb-3 alert-dismissible fade show">
                    <small>
                        <i class="bi bi-person-circle"></i> Terdapat '.$totalExpiredAccess.' pengguna sedang login.
                    </small>
                </div>
            ';
        } else {
            echo '
                <div class="alert alert-success mb-3 alert-dismissible fade show">
                    <small>
                        <i class="bi bi-unlock"></i> Tidak ada pengguna yang login.
                    </small>
                </div>
            ';
        }
    } else {
        echo '
            <div class="alert alert-danger mb-3 alert-dismissible fade show">
                <small>
                    <i class="bi bi-x-circle"></i> Gagal mengambil data akses login yang expired.
                </small>
            </div>
        ';
    }
    $stmt->close();
?>
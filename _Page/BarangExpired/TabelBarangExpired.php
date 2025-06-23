<?php
// Koneksi dan session
include "../../_Config/Connection.php";
include "../../_Config/GlobalFunction.php";
include "../../_Config/Session.php";

// Inisialisasi variabel
$JmlHalaman = 0;
$page = 1;

if (empty($SessionIdAkses)) {
    echo '
        <tr>
            <td colspan="7" class="text-center text-danger">
                Sesi Akses Sudah Berakhir! Silahkan Login Ulang
            </td>
        </tr>
    ';
} else {
    // Filter berdasarkan keyword
    $keyword_by = $_POST['keyword_by'] ?? "";
    $keyword = $_POST['keyword'] ?? "";
    $OrderBy = !empty($_POST['OrderBy']) ? $_POST['OrderBy'] : "id_barang_bacth";
    $ShortBy = !empty($_POST['ShortBy']) ? $_POST['ShortBy'] : "DESC";

    // Pastikan nilai $OrderBy hanya dari kolom yang valid
    $allowed_columns = ['id_barang_bacth', 'no_batch', 'expired_date', 'qty_batch', 'reminder_date', 'status', 'nama_barang', 'satuan_barang'];
    if (!in_array($OrderBy, $allowed_columns)) {
        $OrderBy = 'id_barang_bacth'; // Default jika input tidak valid
    }

    $page = isset($_POST['page']) ? (int)$_POST['page'] : 1;
    if ($page < 1) {
        $page = 1; // Jaga agar tidak negatif
    }
    $batas = isset($_POST['batas']) ? (int)$_POST['batas'] : 10;
    $posisi = ($page - 1) * $batas;

    // Query untuk menghitung jumlah data
    $query_jml = "SELECT COUNT(bb.id_barang_bacth) AS total 
                  FROM barang_bacth AS bb
                  JOIN barang AS b ON bb.id_barang = b.id_barang";
    if (!empty($keyword_by) && !empty($keyword)) {
        // Jika pencarian berdasarkan kolom tertentu
        if ($keyword_by === 'nama_barang') {
            $query_jml .= " WHERE b.nama_barang LIKE '%$keyword%'";
        } else {
            $query_jml .= " WHERE bb.$keyword_by LIKE '%$keyword%'";
        }
    } elseif (!empty($keyword)) {
        // Jika pencarian umum (tanpa kolom tertentu)
        $query_jml .= " WHERE bb.no_batch LIKE '%$keyword%' 
                        OR bb.expired_date LIKE '%$keyword%' 
                        OR bb.reminder_date LIKE '%$keyword%' 
                        OR bb.status LIKE '%$keyword%'
                        OR b.nama_barang LIKE '%$keyword%'";
    }

    $result_jml = mysqli_query($Conn, $query_jml);
    if (!$result_jml) {
        die("Error dalam query jumlah data: " . mysqli_error($Conn));
    }
    $jml_data = mysqli_fetch_assoc($result_jml)['total'];

    if ($jml_data == 0) {
        echo '
            <tr>
                <td colspan="8" class="text-center text-danger">
                    Tidak Ada Data Yang Ditampilkan.
                </td>
            </tr>
        ';
    } else {
        $no = 1 + $posisi;

        // Query utama dengan JOIN tabel `barang`
        $query = "SELECT bb.*, b.nama_barang, b.satuan_barang 
                  FROM barang_bacth AS bb
                  JOIN barang AS b ON bb.id_barang = b.id_barang";

        if (!empty($keyword_by) && !empty($keyword)) {
            // Jika pencarian berdasarkan kolom tertentu
            if ($keyword_by === 'nama_barang') {
                $query .= " WHERE b.nama_barang LIKE '%$keyword%'";
            } else {
                $query .= " WHERE bb.$keyword_by LIKE '%$keyword%'";
            }
        } elseif (!empty($keyword)) {
            // Jika pencarian umum (tanpa kolom tertentu)
            $query .= " WHERE bb.no_batch LIKE '%$keyword%' 
                        OR bb.expired_date LIKE '%$keyword%' 
                        OR bb.reminder_date LIKE '%$keyword%' 
                        OR bb.status LIKE '%$keyword%'
                        OR b.nama_barang LIKE '%$keyword%'";
        }

        // Tambahkan ORDER BY dan LIMIT
        $query .= " ORDER BY $OrderBy $ShortBy 
                    LIMIT $posisi, $batas";

        $result = mysqli_query($Conn, $query);
        if (!$result) {
            die("Error dalam query utama: " . mysqli_error($Conn));
        }

        while ($data = mysqli_fetch_array($result)) {
            $id_barang_bacth = $data['id_barang_bacth'];
            $id_barang = $data['id_barang'];
            $no_batch = $data['no_batch'];
            $expired_date = $data['expired_date'];
            $qty_batch = $data['qty_batch'];
            $qty_batch = ($qty_batch == floor($qty_batch)) ? number_format($qty_batch, 0) : $qty_batch;
            $reminder_date = $data['reminder_date'];
            $status = $data['status'];
            $nama_barang = $data['nama_barang'];
            $satuan_barang = $data['satuan_barang'];

            echo '
                <tr>
                    <td><small>' . $no . '</small></td>
                    <td>
                        <a href="javascript:void(0);" data-bs-toggle="modal" data-bs-target="#ModalDetail" data-id="' . $id_barang_bacth . '">
                            <small>' . $no_batch . '</small>
                        </a>
                    </td>
                    <td><small>' . $nama_barang . '</small></td>
                    <td><small>' . $expired_date . '</small></td>
                    <td><small>' . $reminder_date . '</small></td>
                    <td><small>' . $qty_batch . ' ' . $satuan_barang . '</small></td>
                    <td><small>' . $status . '</small></td>
                    <td>
                        <button type="button" class="btn btn-sm btn-floating btn-outline-secondary" data-bs-toggle="dropdown" aria-expanded="false">
                            <i class="bi bi-three-dots"></i>
                        </button>
                        <ul class="dropdown-menu dropdown-menu-end dropdown-menu-arrow">
                            <li class="dropdown-header text-start">
                                <h6>Option</h6>
                            </li>
                            <li>
                                <a class="dropdown-item" href="javascript:void(0)" data-bs-toggle="modal" data-bs-target="#ModalEdit" data-id="' . $id_barang_bacth . '">
                                    <i class="bi bi-pencil"></i> Edit
                                </a>
                            </li>
                            <li>
                                <a class="dropdown-item" href="javascript:void(0)" data-bs-toggle="modal" data-bs-target="#ModalHapus" data-id="' . $id_barang_bacth . '">
                                    <i class="bi bi-trash"></i> Hapus
                                </a>
                            </li>
                        </ul>
                    </td>
                </tr>
            ';
            $no++;
        }
        $JmlHalaman = ceil($jml_data / $batas);
    }
}
?>

<script>
    var page_count = <?php echo $JmlHalaman; ?>;
    var current_page = <?php echo $page; ?>;
    
    $('#page_info').html('Page ' + current_page + ' Of ' + page_count + '');
    
    if (current_page == 1) {
        $('#prev_button').prop('disabled', true);
    } else {
        $('#prev_button').prop('disabled', false);
    }
    if (page_count <= current_page) {
        $('#next_button').prop('disabled', true);
    } else {
        $('#next_button').prop('disabled', false);
    }
</script>
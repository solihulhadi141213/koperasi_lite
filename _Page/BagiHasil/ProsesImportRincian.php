<?php
    require '../../vendor/autoload.php';
    use PhpOffice\PhpSpreadsheet\IOFactory;
    use PhpOffice\PhpSpreadsheet\Reader\Exception;

    include "../../_Config/Connection.php";
    include "../../_Config/GlobalFunction.php";
    include "../../_Config/Session.php";

    date_default_timezone_set('Asia/Jakarta');
    $now = date('Y-m-d H:i:s');

    // Validasi Sesi Akses
    if (empty($SessionIdAkses)) {
        die('<div class="alert alert-danger">Sesi Akses Sudah Berakhir, Silahkan Login Ulang</div>');
    }

    // Validasi ID SHU Session
    if (empty($_POST['id_shu_session'])) {
        die('<div class="alert alert-danger">ID sesi bagi hasil tidak boleh kosong</div>');
    }

    $id_shu_session = $_POST['id_shu_session'];
    $status=GetDetailData($Conn, 'shu_session', 'id_shu_session', $id_shu_session, 'status');
    if($status!=="Pending"){
        die('<div class="alert alert-danger">Sesi SHU Sudah Teralokasikan! Anda Tidak Bisa Mengubah Data Ini!</div>');
    }

    // Validasi File Upload
    if (empty($_FILES['file_import_rincian']['name'])) {
        die('<div class="alert alert-danger">File tidak boleh kosong</div>');
    }

    $file = $_FILES['file_import_rincian']['tmp_name'];
    $filename = $_FILES['file_import_rincian']['name'];
    $file_extension = pathinfo($filename, PATHINFO_EXTENSION);

    // Cek format file
    if (!in_array($file_extension, ['xls', 'xlsx'])) {
        die('<div class="alert alert-danger">Format file harus Excel (.xls / .xlsx)</div>');
    }
    
    try {
        echo '<div class="row mb-3">';
        echo '  <div class="col-12 pre-scrollable overflow-y-scroll" style="max-height: 400px;">';
        echo '      <ul>';
        // Load Spreadsheet
        $spreadsheet = IOFactory::load($file);
        $sheet = $spreadsheet->getActiveSheet();
        $data = $sheet->toArray();

        // Inisialisasi notifikasi
        $notifikasi = "";

        // Looping Data dari Excel (mulai dari baris ke-3 untuk melewati header)
        for ($i = 2; $i < count($data); $i++) {
            // Periksa apakah seluruh baris kosong
            if (empty(implode('', $data[$i]))) {
                continue; // Skip baris kosong
            }

            $no = trim($data[$i][0]);
            $nama_anggota = trim($data[$i][1]);
            $nip = trim($data[$i][2]);
            $penjualan = floatval($data[$i][3]);
            $simpanan = floatval($data[$i][4]);
            $pinjaman = floatval($data[$i][5]);
            $shu_penjualan = floatval($data[$i][6]);
            $shu_simpanan = floatval($data[$i][7]);
            $shu_pinjaman = floatval($data[$i][8]);
            $shu_total = floatval($data[$i][9]);

            // Validasi Data Kosong
            if (empty($no) || empty($nama_anggota) || empty($nip)) {
                $notifikasi .= "<li class='text text-danger'><small>Baris ke-$i: No, Nama, dan NIP wajib diisi.</small></li>";
                continue;
            }

            // Validasi NIP di Database
            $cekAnggota = mysqli_query($Conn, "SELECT id_anggota FROM anggota WHERE nip='$nip' AND status='Aktif'");
            if (mysqli_num_rows($cekAnggota) == 0) {
                $notifikasi .= "<li class='text text-danger'><small>Baris ke-$i: NIP <b>$nip</b> tidak ditemukan atau tidak aktif.</small></li>";
                continue;
            }

            $rowAnggota = mysqli_fetch_assoc($cekAnggota);
            $id_anggota = $rowAnggota['id_anggota'];

            // Cek apakah data sudah ada di tabel shu_rincian
            $cekData = mysqli_query($Conn, "SELECT id_anggota FROM shu_rincian WHERE id_anggota='$id_anggota' AND id_shu_session='$id_shu_session'");

            if (mysqli_num_rows($cekData) == 0) {
                // Insert data baru
                $insert = mysqli_query($Conn, "INSERT INTO shu_rincian 
                    (id_shu_session, id_anggota, nama_anggota, nip, simpanan, pinjaman, penjualan, jasa_simpanan, jasa_pinjaman, jasa_penjualan, shu) 
                    VALUES ('$id_shu_session', '$id_anggota', '$nama_anggota', '$nip', '$simpanan', '$pinjaman', '$penjualan', 
                            '$shu_simpanan', '$shu_pinjaman', '$shu_penjualan', '$shu_total')");

                if ($insert) {
                    $notifikasi .= "<li class='text text-success'><small>Baris ke-$i: Data anggota <b>$nama_anggota</b> berhasil ditambahkan.</small></li>";
                } else {
                    $notifikasi .= "<li class='text text-danger'><small>Baris ke-$i: Gagal menambahkan data untuk <b>$nama_anggota</b>.</small></li>";
                }
            } else {
                // Update data jika sudah ada
                $update = mysqli_query($Conn, "UPDATE shu_rincian SET 
                    nama_anggota='$nama_anggota', nip='$nip', simpanan='$simpanan', pinjaman='$pinjaman', penjualan='$penjualan',
                    jasa_simpanan='$shu_simpanan', jasa_pinjaman='$shu_pinjaman', jasa_penjualan='$shu_penjualan', shu='$shu_total'
                    WHERE id_anggota='$id_anggota' AND id_shu_session='$id_shu_session'");

                if ($update) {
                    $notifikasi .= "<li class='text text-success'><small>Baris ke-$i: Data anggota <b>$nama_anggota</b> berhasil diperbarui.</small></li>";
                } else {
                    $notifikasi .= "<li class='text text-danger'><small>Baris ke-$i: Gagal memperbarui data untuk <b>$nama_anggota</b>.</small></li>";
                }
            }
        }

        // Tampilkan hasil proses import
        echo $notifikasi;

        echo '      </ul>';
        echo '  </div>';
        echo '</div>';
    } catch (Exception $e) {
        die('<div class="alert alert-danger">Terjadi kesalahan dalam membaca file: ' . $e->getMessage() . '</div>');
    }
?>

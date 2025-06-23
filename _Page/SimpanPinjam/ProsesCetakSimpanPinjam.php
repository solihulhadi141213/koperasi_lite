<?php
    // Include PhpSpreadsheet
    require '../../vendor/autoload.php';
    use PhpOffice\PhpSpreadsheet\Spreadsheet;
    use PhpOffice\PhpSpreadsheet\Writer\Xlsx;

    // Set timezone
    date_default_timezone_set('Asia/Jakarta');
    include "../../_Config/Connection.php";
    include "../../_Config/GlobalFunction.php";
    include "../../_Config/SettingGeneral.php";
    include "../../_Config/Session.php";

    if (empty($SessionIdAkses)) {
        die('Sesi Akses Sudah Berakhir, Silahkan Login Ulang');
    } else {
        if (empty($_GET['lembaga']) || empty($_GET['tahun']) || empty($_GET['periode'])) {
            die('Nama Lembaga, Tahun, dan Periode tidak boleh kosong!');
        } else {
            $lembaga = validateAndSanitizeInput($_GET['lembaga']);
            $tahun = validateAndSanitizeInput($_GET['tahun']);
            $periode = validateAndSanitizeInput($_GET['periode']);

            $bulan=0;
            if($periode=="Bulan"){
                if(empty($_GET['bulan'])){
                    $validasi_kelengkapan="Bulan Tidak Boleh Kosong!";
                }else{
                    $bulan=$_GET['bulan'];
                    $validasi_kelengkapan="Valid";
                }
            }else{
                $validasi_kelengkapan="Valid";
            }
            if($validasi_kelengkapan!=="Valid"){
                die($validasi_kelengkapan);
            }else{

                //Buat Keyword
                if($periode=="Bulan"){
                    $keyword = "$tahun-$bulan";
                }else{
                    $keyword = "$tahun";
                }
                

                // Buat Spreadsheet baru
                $spreadsheet = new Spreadsheet();
                $sheet = $spreadsheet->getActiveSheet();

                // Judul laporan
                $sheet->setCellValue('A1', 'LAPORAN SIMPAN PINJAM');
                $sheet->setCellValue('A2', 'Lembaga : ' . $lembaga);
                if($periode=="Bulan"){
                    $sheet->setCellValue('A3', 'Periode : Bulan ' . getNamaBulan($bulan) . ' ' . $tahun);
                }else{
                    $sheet->setCellValue('A3', 'Periode : Tahun ' . $tahun);
                }
                

                // Header kolom
                $sheet->setCellValue('A5', 'NO');
                $sheet->setCellValue('B5', 'ANGGOTA');

                // Menampilkan header jenis simpanan
                $qrySimpanan = mysqli_query($Conn, "SELECT * FROM simpanan_jenis ORDER BY id_simpanan_jenis ASC");
                $col = 'C';
                while ($dataSimpanan = mysqli_fetch_array($qrySimpanan)) {
                    $sheet->setCellValue($col . '5', $dataSimpanan['nama_simpanan']);
                    $col++;
                }

                // Header kolom pinjaman
                $sheet->setCellValue($col . '5', 'ANGSURAN');
                $col++;
                $sheet->setCellValue($col . '5', 'PER');
                $col++;
                $sheet->setCellValue($col . '5', 'JASA');
                $col++;
                $sheet->setCellValue($col . '5', 'JUMLAH');

                // Fetch data anggota dan simpanan/pinjaman
                $qryAnggota = mysqli_query($Conn, "SELECT * FROM anggota WHERE lembaga='$lembaga' ORDER BY nama ASC");
                $row = 6; // Mulai dari baris ke-6
                $no = 1;
                $qrySimpanan = mysqli_query($Conn, "SELECT * FROM simpanan_jenis ORDER BY id_simpanan_jenis ASC");

                // Inisialisasi total
                $totalSimpanan = [];
                while ($dataSimpanan = mysqli_fetch_array($qrySimpanan)) {
                    $id_simpanan_jenis = $dataSimpanan['id_simpanan_jenis'];
                    $totalSimpanan[$id_simpanan_jenis] = 0;
                }
                $totalAngsuran = 0;
                $totalJasa = 0;
                $totalGrand = 0;

                while ($dataAnggota = mysqli_fetch_array($qryAnggota)) {
                    $id_anggota = $dataAnggota['id_anggota'];
                    $nama = $dataAnggota['nama'];

                    $sheet->setCellValue('A' . $row, $no);
                    $sheet->setCellValue('B' . $row, $nama);

                    // Menampilkan simpanan
                    $qrySimpanan = mysqli_query($Conn, "SELECT * FROM simpanan_jenis ORDER BY id_simpanan_jenis ASC");
                    $col = 'C';
                    $jumlahSimpananAnggota = 0;
                    while ($dataSimpanan = mysqli_fetch_array($qrySimpanan)) {
                        $id_simpanan_jenis = $dataSimpanan['id_simpanan_jenis'];
                        $sumSimpanan = mysqli_fetch_array(mysqli_query($Conn, "SELECT SUM(jumlah) AS jumlah FROM simpanan WHERE id_anggota='$id_anggota' AND id_simpanan_jenis='$id_simpanan_jenis' AND tanggal LIKE '%$keyword%'"));
                        $jumlahSimpanan = $sumSimpanan['jumlah'] ?? 0;
                        $totalSimpanan[$id_simpanan_jenis] += $jumlahSimpanan;
                        $jumlahSimpananAnggota += $jumlahSimpanan;
                        $sheet->setCellValue($col . $row, $jumlahSimpanan);
                        $col++;
                    }

                    // Menampilkan angsuran dan jasa
                    $qryPinjaman = mysqli_query($Conn, "SELECT * FROM pinjaman WHERE id_anggota='$id_anggota' AND status='Berjalan'");
                    $dataPinjaman = mysqli_fetch_array($qryPinjaman);
                    $jumlahPinjaman = $dataPinjaman['jumlah_pinjaman'] ?? 0;

                    $sumAngsuran = mysqli_fetch_array(mysqli_query($Conn, "SELECT SUM(pokok) AS pokok FROM pinjaman_angsuran WHERE id_anggota='$id_anggota' AND tanggal_bayar LIKE '%$keyword%'"));
                    $jumlahPokok = $sumAngsuran['pokok'] ?? 0;
                    $totalAngsuran += $jumlahPokok;
                    $sheet->setCellValue($col . $row, $jumlahPokok);
                    $col++;

                    $periodeAngsuran = $dataPinjaman['periode_angsuran'] ?? 0;
                    $angsuranMasuk = mysqli_num_rows(mysqli_query($Conn, "SELECT * FROM pinjaman_angsuran WHERE id_pinjaman='{$dataPinjaman['id_pinjaman']}'"));
                    $sheet->setCellValue($col . $row, "$angsuranMasuk/$periodeAngsuran");
                    $col++;

                    $sumJasa = mysqli_fetch_array(mysqli_query($Conn, "SELECT SUM(jasa) AS jasa FROM pinjaman_angsuran WHERE id_anggota='$id_anggota' AND tanggal_bayar LIKE '%$keyword%'"));
                    $jumlahJasa = $sumJasa['jasa'] ?? 0;
                    $totalJasa += $jumlahJasa;
                    $sheet->setCellValue($col . $row, $jumlahJasa);
                    $col++;

                    // Total per anggota
                    $jumlahPemasukan = $jumlahSimpananAnggota + $jumlahPokok + $jumlahJasa;
                    $totalGrand += $jumlahPemasukan;
                    $sheet->setCellValue($col . $row, $jumlahPemasukan);

                    $row++;
                    $no++;
                }

                // Tambahkan baris total di bagian akhir
                $sheet->setCellValue('A' . $row, 'JUMLAH');
                $sheet->mergeCells('A' . $row . ':B' . $row);

                $col = 'C';
                foreach ($totalSimpanan as $total) {
                    $sheet->setCellValue($col . $row, $total);
                    $col++;
                }
                $sheet->setCellValue($col . $row, $totalAngsuran);
                $col++;
                $sheet->setCellValue($col . $row, '');
                $col++;
                $sheet->setCellValue($col . $row, $totalJasa);
                $col++;
                $sheet->setCellValue($col . $row, $totalGrand);

                // Simpan file ke Excel
                $filename = 'Laporan_Simpan_Pinjam_' . $lembaga . '_' . $bulan . '_' . $tahun . '.xlsx';
                $writer = new Xlsx($spreadsheet);
                header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
                header('Content-Disposition: attachment; filename="' . $filename . '"');
                $writer->save('php://output');
                exit;
            }
        }
    }
?>

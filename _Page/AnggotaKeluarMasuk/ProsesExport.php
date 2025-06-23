<?php
    require '../../vendor/autoload.php';
    use PhpOffice\PhpSpreadsheet\Spreadsheet;
    use PhpOffice\PhpSpreadsheet\Writer\Xlsx;
    use PhpOffice\PhpSpreadsheet\Style\Fill;
    use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;
    //koneksi dan session
    include "../../_Config/Connection.php";
    include "../../_Config/GlobalFunction.php";
    include "../../_Config/Session.php";
    //id_anggota
    if(empty($SessionIdAkses)){
        echo '<div class="row">';
        echo '  <div class="col-md-12 text-center text-danger">';
        echo '      Sesi Login Sudah Berakhir, Silahkan Login Ulang!';
        echo '  </div>';
        echo '</div>';
    }else{
        if(empty($_POST['mode'])){
            $mode='Harian';
        }else{
            $mode=$_POST['mode'];
        }
        if(empty($_POST['tahun'])){
            $year=date('Y');
        }else{
            $year=$_POST['tahun'];
        }
        if(empty($_POST['bulan'])){
            $month=date('m');
        }else{
            $month=$_POST['bulan'];
        }
        // Membuat objek Spreadsheet baru
        $spreadsheet = new Spreadsheet();
        $sheet = $spreadsheet->getActiveSheet();
        // Menulis judul
        $sheet->setCellValue('A1', 'No');
        $sheet->setCellValue('B1', 'Bulan/Tanggal');
        $sheet->setCellValue('C1', 'Masuk');
        $sheet->setCellValue('D1', 'Keluar');
        // Mengatur gaya baris judul
        $sheet->getStyle('A1:D1')->getFont()->setBold(true);
        $sheet->getStyle('A1:D1')->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER);
        // Query untuk mendapatkan data
        //Melakukan Looping Berdasarkan Mode
        if($mode=="Bulanan"){
            // Array nama-nama bulan
            $months = [
                "01" => "Januari",
                "02" => "Februari",
                "03" => "Maret",
                "04" => "April",
                "05" => "Mei",
                "06" => "Juni",
                "07" => "Juli",
                "08" => "Agustus",
                "09" => "September",
                "10" => "Oktober",
                "11" => "November",
                "12" => "Desember"
            ];
            // Melakukan looping dari bulan 01 hingga 12
            $JumlahTotalMasuk=0;
            $JumlahTotalKeluar=0;
            $no=1;
            $row = 2;
            foreach ($months as $number => $name) {
                $Tanggal="$year-$number";
                //Jumlah Anggtoa Masuk Pada Tanggal Tersebut
                $JumlahMasuk=mysqli_num_rows(mysqli_query($Conn, "SELECT id_anggota FROM anggota WHERE tanggal_masuk like '%$Tanggal%'"));
                $JumlahKeluar=mysqli_num_rows(mysqli_query($Conn, "SELECT id_anggota FROM anggota WHERE tanggal_keluar like '%$Tanggal%' AND status='Keluar'"));
                $Periode="$name $year";
                $JumlahMasukText="$JumlahMasuk Orang";
                $JumlahKeluarText="$JumlahKeluar Orang";
                // Kolom kode diatur sebagai teks
                $sheet->setCellValueExplicit('A'.$row, $no, \PhpOffice\PhpSpreadsheet\Cell\DataType::TYPE_STRING);
                $sheet->setCellValueExplicit('B'.$row, $Periode, \PhpOffice\PhpSpreadsheet\Cell\DataType::TYPE_STRING);
                $sheet->setCellValueExplicit('C'.$row, $JumlahMasukText, \PhpOffice\PhpSpreadsheet\Cell\DataType::TYPE_STRING);
                $sheet->setCellValueExplicit('D'.$row, $JumlahKeluarText, \PhpOffice\PhpSpreadsheet\Cell\DataType::TYPE_STRING);
                $row++; // Pindah ke baris berikutnya
                $no++;
            }
        }else{
            $JumlahTotalMasuk=0;
            $JumlahTotalKeluar=0;
            $days_in_month = cal_days_in_month(CAL_GREGORIAN, $month, $year);
            $no=1;
            $row = 2;
            for ($day = 1; $day <= $days_in_month; $day++) {
                // Format tanggal dengan dua digit
                $formatted_day = str_pad($day, 2, "0", STR_PAD_LEFT);
                // Format bulan dengan dua digit
                $formatted_month = str_pad($month, 2, "0", STR_PAD_LEFT);
                $Tanggal="$year-$formatted_month-$formatted_day";
                //Jumlah Anggtoa Masuk Pada Tanggal Tersebut
                $JumlahMasuk=mysqli_num_rows(mysqli_query($Conn, "SELECT id_anggota FROM anggota WHERE tanggal_masuk='$Tanggal'"));
                $JumlahKeluar=mysqli_num_rows(mysqli_query($Conn, "SELECT id_anggota FROM anggota WHERE tanggal_keluar='$Tanggal' AND status='Keluar'"));
                $Periode="$formatted_day/$formatted_month/$year";
                $JumlahMasukText="$JumlahMasuk Orang";
                $JumlahKeluarText="$JumlahKeluar Orang";
                // Kolom kode diatur sebagai teks
                $sheet->setCellValueExplicit('A'.$row, $no, \PhpOffice\PhpSpreadsheet\Cell\DataType::TYPE_STRING);
                $sheet->setCellValueExplicit('B'.$row, $Periode, \PhpOffice\PhpSpreadsheet\Cell\DataType::TYPE_STRING);
                $sheet->setCellValueExplicit('C'.$row, $JumlahMasukText, \PhpOffice\PhpSpreadsheet\Cell\DataType::TYPE_STRING);
                $sheet->setCellValue('D'.$row, $JumlahKeluarText);
                $JumlahTotalMasuk=$JumlahTotalMasuk+$JumlahMasuk;
                $JumlahTotalKeluar=$JumlahTotalKeluar+$JumlahKeluar;
                $row++;
                $no++;
            }
        }
        // Menyesuaikan lebar kolom dengan karakter terpanjang
        foreach(range('A', 'D') as $columnID) {
            $sheet->getColumnDimension($columnID)->setAutoSize(true);
        }
        // Membuat objek Writer untuk menulis Spreadsheet ke dalam file XLSX
        $writer = new Xlsx($spreadsheet);
        // Menyimpan file XLSX
        $filename = 'Rekap-Keluar-Masuk.xlsx';
        header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
        header('Content-Disposition: attachment;filename="'. $filename .'"');
        header('Cache-Control: max-age=0');
        
        // Menulis Spreadsheet ke dalam output PHP
        $writer->save('php://output');
    }
?>
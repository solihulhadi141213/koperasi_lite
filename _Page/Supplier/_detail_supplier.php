<?php
    // Koneksi
    include "../../_Config/Connection.php";
    include "../../_Config/GlobalFunction.php";
    include "../../_Config/Session.php";

    // Time Zone
    date_default_timezone_set('Asia/Jakarta');

    // Time Now Tmp
    $now = date('Y-m-d H:i:s');

    // Inisialisasi respons default
    $response = [
        "status" => "Error",
        "message" => "Belum ada proses yang dilakukan pada sistem."
    ];

    // Validasi sesi login
    if (empty($SessionIdAkses)) {
        $response = [
            "status" => "Error",
            "message" => "Sesi Akses Sudah Berakhir, Silahkan Login Ulang"
        ];
    } else {
        // Validasi Data Tidak Boleh Kosong
        $requiredFields = [
            'id_supplier' => "ID Supplier Tidak Boleh Kosong!"
        ];

        foreach ($requiredFields as $field => $errorMessage) {
            if (empty($_POST[$field])) {
                $response = [
                    "status" => "Error",
                    "message" => $errorMessage
                ];
                echo json_encode($response);
                exit;
            }
        }
        // Buat Variabel
        $id_supplier = validateAndSanitizeInput($_POST['id_supplier']);
        
        //Buka Data Supplier
        $Qry = $Conn->prepare("SELECT * FROM supplier WHERE id_supplier = ?");
        $Qry->bind_param("s", $id_supplier);
        if (!$Qry->execute()) {
            $error=$Conn->error;
            $response = [
                "status" => "Error",
                "message" => $error
            ];
        }else{
            $Result = $Qry->get_result();
            $Data = $Result->fetch_assoc();
            $Qry->close();

            //Buat Variabel
            $nama_supplier=$Data['nama_supplier'];
            $alamat_supplier=$Data['alamat_supplier'];
            $email_supplier=$Data['email_supplier'];
            $kontak_supplier=$Data['kontak_supplier'];

            //Menghitung Jumlah Total Transaksi Pembelian
            $SumTransaksi = mysqli_fetch_array(mysqli_query($Conn, "SELECT SUM(total) AS total FROM transaksi_jual_beli WHERE id_supplier='$id_supplier'"));
            if(empty($SumTransaksi['total'])){
                $JumlahTransaksi =0;
            }else{
                $JumlahTransaksi = $SumTransaksi['total'];
            }
            $JumlahTransaksiFormat = "Rp " . number_format($JumlahTransaksi,0,',','.');

            //Menghitung Jumlah Transaksi Pembelian Kredit
            $SumTransaksiKredit = mysqli_fetch_array(mysqli_query($Conn, "SELECT SUM(total) AS total FROM transaksi_jual_beli WHERE id_supplier='$id_supplier' AND status='Kredit'"));
            if(empty($SumTransaksiKredit['total'])){
                $JumlahTransaksiKredit =0;
            }else{
                $JumlahTransaksiKredit = $SumTransaksiKredit['total'];
            }
            $JumlahTransaksiKreditFormat = "Rp " . number_format($JumlahTransaksiKredit,0,',','.');

            //Menghitung Jumlah Transaksi Retur
            $SumTransaksiRetur = mysqli_fetch_array(mysqli_query($Conn, "SELECT SUM(total) AS total FROM transaksi_jual_beli WHERE id_supplier='$id_supplier' AND kategori='Retur Pembelian'"));
            if(empty($SumTransaksiRetur['total'])){
                $JumlahTransaksiRetur =0;
            }else{
                $JumlahTransaksiRetur = $SumTransaksiRetur['total'];
            }
            $JumlahTransaksiReturFormat = "Rp " . number_format($JumlahTransaksiRetur,0,',','.');
            
            //Buat Dataset
            $dataset = [
                "id_supplier" => $id_supplier,
                "nama_supplier" => $nama_supplier,
                "email_supplier" => $email_supplier,
                "kontak_supplier" => $kontak_supplier,
                "alamat_supplier" => $alamat_supplier,
                "jumlah_transaksi" => $JumlahTransaksi,
                "jumlah_transaksi_kredit" => $JumlahTransaksiKredit,
                "jumlah_transaksi_retur" => $JumlahTransaksiRetur,
                "jumlah_transaksi_format" => $JumlahTransaksiFormat,
                "jumlah_transaksi_kredit_format" => $JumlahTransaksiKreditFormat,
                "jumlah_transaksi_retur_format" => $JumlahTransaksiReturFormat,
            ];

            //Buat Arry Response
            $response = [
                "status" => "Success",
                "message" => "Data Ditemukan",
                "dataset" => $dataset
            ];
        }
    }

    // Output response
    echo json_encode($response);
?>

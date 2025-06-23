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
            'id_transaksi_jual_beli'    => "ID Transaksi Penjualan Tidak Boleh Kosong!",
            'mode'                      => "Mode Form Tidak Boleh Kosong!",
            'tanggal'                   => "Tanggal Transaksi Tidak Boleh Kosong!",
            'jam'                       => "Jam Transaksi Tidak Boleh Kosong!",
            'status'                    => "Status Transaksi Tidak Boleh Kosong!"
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
        $id_transaksi_jual_beli = validateAndSanitizeInput($_POST['id_transaksi_jual_beli']);
        $mode = validateAndSanitizeInput($_POST['mode']);
        $tanggal = validateAndSanitizeInput($_POST['tanggal']);
        $jam = validateAndSanitizeInput($_POST['jam']);
        $status = validateAndSanitizeInput($_POST['status']);
        $tanggal="$tanggal $jam";

        //Buat Variabel Data Yang Tidak Wajib
        if(empty($_POST['cash'])){
            $cash=0;
        }else{
            $cash=$_POST['cash'];
        }
        if(empty($_POST['kembalian'])){
            $kembalian=0;
        }else{
            $kembalian=$_POST['kembalian'];
        }
        $cash = (int) str_replace(".", "", $cash);
        $kembalian = (int) str_replace(".", "", $kembalian);
        //Proses Update
        $UpdateTransaksi = mysqli_query($Conn,"UPDATE transaksi_jual_beli SET 
            tanggal='$tanggal',
            cash='$cash',
            kembalian='$kembalian',
            status='$status'
        WHERE id_transaksi_jual_beli='$id_transaksi_jual_beli'") or die(mysqli_error($Conn)); 
        if($UpdateTransaksi){
            //Apabila Berhasil Simpan Log
            $kategori_log="Transaksi Penjualan";
            $deskripsi_log="Edit Transaksi Penjualan";
            $InputLog=addLog($Conn,$SessionIdAkses,$now,$kategori_log,$deskripsi_log);
            if($InputLog=="Success"){
                $response = [
                    "status" => "Success",
                    "message" => "Edit Transaksi Berhasil!",
                    "id_transaksi_jual_beli" => $id_transaksi_jual_beli,
                    "mode" => $mode,
                ];
            }else{
                $response = [
                    "status" => "Error",
                    "message" => "Terjadi kesalahan pada saat menyimpan log aktivitas"
                ];
            }
        }else{
            $response = [
                "status" => "Error",
                "message" => "Terjadi kesalahan pada saat update data ke database"
            ];
        }
    }

    // Output response
    echo json_encode($response);
?>

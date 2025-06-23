<?php
    //Koneksi
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
            'id_jurnal'     => "ID Jurnal Tidak Boleh Kosong!",
            'tanggal'       => "Tanggal Jurnal Tidak Boleh Kosong!",
            'id_perkiraan'  => "ID Akun Perkiraan Tidak Boleh Kosong!",
            'd_k'           => "Posisi Debet/Kredit Tidak Boleh Kosong!",
            'nominal'       => "Jumlah Nominal Tidak Boleh Kosong!",
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
        $id_jurnal = validateAndSanitizeInput($_POST['id_jurnal']);
        $tanggal = validateAndSanitizeInput($_POST['tanggal']);
        $id_perkiraan = validateAndSanitizeInput($_POST['id_perkiraan']);
        $d_k = validateAndSanitizeInput($_POST['d_k']);
        $nominal = validateAndSanitizeInput($_POST['nominal']);
        
        //Hapus Format Rupiah pada Nominal
        $nominal = (int) str_replace(".", "", $nominal);

        //Buka kode dan nama perkiraan
        $kode_perkiraan=GetDetailData($Conn, 'akun_perkiraan', 'id_perkiraan', $id_perkiraan, 'kode');
        $nama_perkiraan=GetDetailData($Conn, 'akun_perkiraan', 'id_perkiraan', $id_perkiraan, 'nama');
        
        //Proses Update/Edit Jurnal
        $UpdateJurnal = mysqli_query($Conn,"UPDATE jurnal SET 
            tanggal='$tanggal',
            kode_perkiraan='$kode_perkiraan',
            nama_perkiraan='$nama_perkiraan',
            d_k='$d_k',
            nilai='$nominal'
        WHERE id_jurnal='$id_jurnal'") or die(mysqli_error($Conn)); 
        if($UpdateJurnal){
            
            //Apabila Berhasil Simpan Log
            $kategori_log="Jurnal";
            $deskripsi_log="Edit Jurnal";
            $InputLog=addLog($Conn,$SessionIdAkses,$now,$kategori_log,$deskripsi_log);
            if($InputLog=="Success"){
                $response = [
                    "status" => "Success",
                    "message" => "Edit jurnal manual Berhasil!"
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
                "message" => "Terjadi Kesalahan Pada Saat Upodate Data Jurnal"
            ];
        }
    }

    // Output response
    echo json_encode($response);
?>
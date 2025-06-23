<?php
    // Koneksi & Konfigurasi
    include "../../_Config/Connection.php";
    include "../../_Config/GlobalFunction.php";
    include "../../_Config/Session.php";

    // Time Zone
    date_default_timezone_set('Asia/Jakarta');
    $now = date('Y-m-d H:i:s');

    // Default Response
    $response = [
        "status" => "Error",
        "message" => "Belum ada proses yang dilakukan pada sistem."
    ];

    // Validasi Sesi Login
    if (empty($SessionIdAkses)) {
        $response = [
            "status" => "Error",
            "message" => "Sesi Akses Sudah Berakhir, Silahkan Login Ulang"
        ];
    } else{
        if(empty($_POST['id_shu_rincian'])){
            // Validasi ID SHU
            $response = [
                "status" => "Error",
                "message" => "ID Rincian Bagi Hasil (SHU) Tidak Boleh Kosong!"
            ];
        } else {
            // Buat dan Bersihkan Variabel 'id_shu_rincian'
            $id_shu_rincian = validateAndSanitizeInput($_POST['id_shu_rincian']);
            
            //Buka data Dengan Prepared Statment
            $Qry = $Conn->prepare("SELECT * FROM shu_rincian WHERE id_shu_rincian = ?");
            $Qry->bind_param("i", $id_shu_rincian);
            
            if (!$Qry->execute()) {
                $response = [
                    "status" => "Error",
                    "message" => $Conn->error
                ];
            } else {
                $Result = $Qry->get_result();
                $Data = $Result->fetch_assoc();
                $Qry->close();

                if (!$Data) {
                    $response = [
                        "status" => "Error",
                        "message" => "Data SHU tidak ditemukan"
                    ];
                } else {
                    //Buat Variabel
                    $id_shu_session=$Data['id_shu_session'];
                    $id_anggota=$Data['id_anggota'];
                    $nama_anggota=$Data['nama_anggota'];
                    $nip=$Data['nip'];
                    $simpanan=$Data['simpanan'];
                    $pinjaman=$Data['pinjaman'];
                    $penjualan=$Data['penjualan'];
                    $jasa_simpanan=$Data['jasa_simpanan'];
                    $jasa_pinjaman=$Data['jasa_pinjaman'];
                    $jasa_penjualan=$Data['jasa_penjualan'];
                    $shu=$Data['shu'];

                    //Format Rupiah
                    $simpanan_rp = "Rp " . number_format($simpanan,0,',','.');
                    $pinjaman_rp = "Rp " . number_format($pinjaman,0,',','.');
                    $penjualan_rp = "Rp " . number_format($penjualan,0,',','.');
                    $jasa_simpanan_rp = "Rp " . number_format($jasa_simpanan,0,',','.');
                    $jasa_pinjaman_rp = "Rp " . number_format($jasa_pinjaman,0,',','.');
                    $jasa_penjualan_rp = "Rp " . number_format($jasa_penjualan,0,',','.');
                    $shu_rp = "Rp " . number_format($shu,0,',','.');

                    //Status SHU
                    $status=GetDetailData($Conn, 'shu_session', 'id_shu_session', $id_shu_session, 'status');
                    
                    // Data shu_session
                    $shu_session = [
                        "id_shu_session" => $id_shu_session,
                        "status" => $status,
                    ];
                    // Data Response
                    $dataset = [
                        "id_shu_session" => $id_shu_session,
                        "id_shu_rincian" => $id_shu_rincian,
                        "id_anggota" => $id_anggota,
                        "nama_anggota" => $nama_anggota,
                        "nip" => $nip,
                        "simpanan" => $simpanan,
                        "pinjaman" => $pinjaman,
                        "penjualan" => $penjualan,
                        "jasa_simpanan" => $jasa_simpanan,
                        "jasa_pinjaman" => $jasa_pinjaman,
                        "jasa_penjualan" => $jasa_penjualan,
                        "shu" => $shu,
                        "simpanan_rp" => $simpanan_rp,
                        "pinjaman_rp" => $pinjaman_rp,
                        "penjualan_rp" => $penjualan_rp,
                        "jasa_simpanan_rp" => $jasa_simpanan_rp,
                        "jasa_pinjaman_rp" => $jasa_pinjaman_rp,
                        "jasa_penjualan_rp" => $jasa_penjualan_rp,
                        "shu_rp" => $shu_rp,
                    ];

                    // Response JSON
                    $response = [
                        "status" => "Success",
                        "message" => "Data Ditemukan",
                        "dataset" => $dataset,
                        "shu_session" => $shu_session,
                    ];
                }
            }
        }
    }

    // Output JSON Response
    echo json_encode($response);
?>

<?php
    // Koneksi
    include "../../_Config/Connection.php";
    include "../../_Config/GlobalFunction.php";
    include "../../_Config/Session.php";
    include "../../_Config/SettingGeneral.php";

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
            'id_pinjaman' => "ID Pinjaman Tidak Boleh Kosong!"
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
        $id_pinjaman = validateAndSanitizeInput($_POST['id_pinjaman']);

        //Buka Data
        $Qry = $Conn->prepare("SELECT * FROM pinjaman WHERE id_pinjaman = ?");
        $Qry->bind_param("i", $id_pinjaman);
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
            $uuid_pinjaman=$Data['uuid_pinjaman'];
            $id_anggota=$Data['id_anggota'];
            $nama=$Data['nama'];
            $nip=$Data['nip'];
            $lembaga=$Data['lembaga'];
            $ranking=$Data['ranking'];
            $tanggal=$Data['tanggal'];
            $jatuh_tempo=$Data['jatuh_tempo'];
            $jumlah_pinjaman=$Data['jumlah_pinjaman'];
            $denda=$Data['denda'];
            $sistem_denda=$Data['sistem_denda'];
            $persen_jasa=$Data['persen_jasa'];
            $rp_jasa=$Data['rp_jasa'];
            $angsuran_pokok=$Data['angsuran_pokok'];
            $angsuran_total=$Data['angsuran_total'];
            $periode_angsuran=$Data['periode_angsuran'];
            $status=$Data['status'];

            //Format Rupiah
            $jumlah_pinjaman_rp = "Rp " . number_format($jumlah_pinjaman,0,',','.');
            $denda_rp = "Rp " . number_format($denda,0,',','.');
            $rp_jasa_rp = "Rp " . number_format($rp_jasa,0,',','.');
            $angsuran_pokok_rp = "Rp " . number_format($angsuran_pokok,0,',','.');
            $angsuran_total_rp = "Rp " . number_format($angsuran_total,0,',','.');
            
            //Buat Dataset
            $dataset = [
                "uuid_pinjaman" => $uuid_pinjaman,
                "id_anggota" => $id_anggota,
                "nip" => $nip,
                "nama" => $nama,
                "lembaga" => $lembaga,
                "ranking" => $ranking,
                "tanggal" => $tanggal,
                "jatuh_tempo" => $jatuh_tempo,
                "jumlah_pinjaman" => $jumlah_pinjaman,
                "jumlah_pinjaman_rp" => $jumlah_pinjaman_rp,
                "denda" => $denda,
                "denda_rp" => $denda_rp,
                "sistem_denda" => $sistem_denda,
                "persen_jasa" => $persen_jasa,
                "rp_jasa" => $rp_jasa,
                "rp_jasa_rp" => $rp_jasa_rp,
                "angsuran_pokok" => $angsuran_pokok,
                "angsuran_pokok_rp" => $angsuran_pokok_rp,
                "angsuran_total" => $angsuran_total,
                "angsuran_total_rp" => $angsuran_total_rp,
                "periode_angsuran" => $periode_angsuran,
                "status" => $status,
            ];
            //Buat Riwayat Angsuran
            $riwayat_angsuran=[];
            $query_angsuran = mysqli_query($Conn, "SELECT*FROM pinjaman_angsuran WHERE id_pinjaman='$id_pinjaman'");
            while ($data_angsuran= mysqli_fetch_array($query_angsuran)) {
                $id_pinjaman_angsuran= $data_angsuran['id_pinjaman_angsuran'];
                $pokok= $data_angsuran['pokok'];
                $jasa= $data_angsuran['jasa'];
                $denda= $data_angsuran['denda'];
                $jumlah= $data_angsuran['jumlah'];
                $pokok_rp = "Rp " . number_format($pokok,0,',','.');
                $jasa_rp = "Rp " . number_format($jasa,0,',','.');
                $denda_rp = "Rp " . number_format($denda,0,',','.');
                $jumlah_rp = "Rp " . number_format($jumlah,0,',','.');

                //Buat Array
                $riwayat_angsuran[] = [
                    "id_pinjaman_angsuran" => $data_angsuran['id_pinjaman_angsuran'],
                    "uuid_angsuran" => $data_angsuran['uuid_angsuran'],
                    "tanggal_angsuran" => $data_angsuran['tanggal_angsuran'],
                    "tanggal_bayar" => date('d/m/Y', strtotime($data_angsuran['tanggal_bayar'])),
                    "keterlambatan" => $data_angsuran['keterlambatan'],
                    "pokok" => $pokok,
                    "jasa" => $jasa,
                    "denda" => $denda,
                    "jumlah" => $jumlah,
                    "pokok_rp" => $pokok_rp,
                    "jasa_rp" => $jasa_rp,
                    "denda_rp" => $denda_rp,
                    "jumlah_rp" => $jumlah_rp,
                ];
            }
            //Buat Arry Response
            $response = [
                "status" => "Success",
                "message" => "Data Ditemukan",
                "dataset" => $dataset,
                "riwayat_angsuran" => $riwayat_angsuran
            ];
        }
    }

    // Output response
    echo json_encode($response);
?>

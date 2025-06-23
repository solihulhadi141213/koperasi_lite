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
        if(empty($_POST['id_shu_session'])){
            // Validasi ID SHU
            $response = [
                "status" => "Error",
                "message" => "ID Sesi SHU Tidak Boleh Kosong!"
            ];
        } else {
            // Ambil Data SHU
            $id_shu_session = validateAndSanitizeInput($_POST['id_shu_session']);
            
            $Qry = $Conn->prepare("SELECT * FROM shu_session WHERE id_shu_session = ?");
            $Qry->bind_param("i", $id_shu_session);
            
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
                    $periode_hitung1=$Data['periode_hitung1'];
                    $periode_hitung2=$Data['periode_hitung2'];
                    $total_penjualan=$Data['total_penjualan'];
                    $total_simpanan=$Data['total_simpanan'];
                    $total_pinjaman=$Data['total_pinjaman'];
                    $persen_penjualan=$Data['persen_penjualan'];
                    $persen_simpanan=$Data['persen_simpanan'];
                    $persen_pinjaman=$Data['persen_pinjaman'];
                    $shu=$Data['shu'];
                    $status=$Data['status'];

                    //Format tanggal
                    $periode_hitung1=date('d/m/Y',strtotime($periode_hitung1));
                    $periode_hitung2=date('d/m/Y',strtotime($periode_hitung2));

                    //Format Rupiah
                    $shu_rp = "Rp " . number_format($shu,0,',','.');
                    $total_penjualan_rp = "Rp " . number_format($total_penjualan,0,',','.');
                    $total_simpanan_rp = "Rp " . number_format($total_simpanan,0,',','.');
                    $total_pinjaman_rp = "Rp " . number_format($total_pinjaman,0,',','.');

                    //Label Status
                    if($status=="Pending"){
                        $LabelStatus='<span class="badge badge-warning">Pending</span>';
                    }else{
                        $LabelStatus='<span class="badge badge-success">'.$status.'</span>';
                    }

                     //Jumlah Anggota
                    $JumlahRincian = mysqli_num_rows(mysqli_query($Conn, "SELECT*FROM shu_rincian WHERE id_shu_session='$id_shu_session'"));
                    $JumlahRincian_rp = "" . number_format($JumlahRincian,0,',','.');

                    //Jumlah Rincian SHU
                    $sum_alokasi= mysqli_fetch_array(mysqli_query($Conn, "SELECT SUM(shu) AS jumlah FROM shu_rincian WHERE id_shu_session='$id_shu_session'"));
                    if(!empty($sum_alokasi['jumlah'])){
                        $jumlah_alokasi = $sum_alokasi['jumlah'];
                    }else{
                        $jumlah_alokasi =0;
                    }
                    $jumlah_alokasi_rp = "Rp " . number_format($jumlah_alokasi,0,',','.');

                    //Buka Auto Jurnal
                    // Mendapatkan data Pembagian SHU
                    $pembagianShu = getAutoJurnalSHU($Conn, 'Pembagian');
                    $id_perkiraan_debet_pembagian = $pembagianShu['id_perkiraan_debet'];
                    $id_perkiraan_kredit_pembagian = $pembagianShu['id_perkiraan_kredit'];
                    if(!empty($id_perkiraan_debet_pembagian)){
                        $akun_debet_pembagian=GetDetailData($Conn, 'akun_perkiraan', 'id_perkiraan', $id_perkiraan_debet_pembagian, 'nama');
                    }else{
                        $akun_debet_pembagian="-";
                    }
                    if(!empty($id_perkiraan_kredit_pembagian)){
                        $akun_kredit_pembagian=GetDetailData($Conn, 'akun_perkiraan', 'id_perkiraan', $id_perkiraan_kredit_pembagian, 'nama');
                    }else{
                        $akun_kredit_pembagian="-";
                    }

                    // Mendapatkan data Pembayaran SHU
                    $pembayaranShu = getAutoJurnalSHU($Conn, 'Pembayaran');
                    $id_perkiraan_debet_pembayaran = $pembayaranShu['id_perkiraan_debet'];
                    $id_perkiraan_kredit_pembayaran = $pembayaranShu['id_perkiraan_kredit'];
                    if(!empty($id_perkiraan_debet_pembayaran)){
                        $akun_debet_pembayaran=GetDetailData($Conn, 'akun_perkiraan', 'id_perkiraan', $id_perkiraan_debet_pembayaran, 'nama');
                    }else{
                        $akun_debet_pembayaran="-";
                    }
                    if(!empty($id_perkiraan_kredit_pembayaran)){
                        $akun_kredit_pembayaran=GetDetailData($Conn, 'akun_perkiraan', 'id_perkiraan', $id_perkiraan_kredit_pembayaran, 'nama');
                    }else{
                        $akun_kredit_pembayaran="-";
                    }

                    // Data Response
                    $dataset = [
                        "id_shu_session" => $id_shu_session,
                        "periode_hitung1" => $periode_hitung1,
                        "periode_hitung2" => $periode_hitung2,
                        "total_penjualan" => $total_penjualan,
                        "total_simpanan" => $total_simpanan,
                        "total_pinjaman" => $total_pinjaman,
                        "persen_penjualan" => $persen_penjualan,
                        "persen_simpanan" => $persen_simpanan,
                        "persen_pinjaman" => $persen_pinjaman,
                        "shu" => $shu,
                        "status" => $status,
                        "shu_rp" => $shu_rp,
                        "total_penjualan_rp" => $total_penjualan_rp,
                        "total_simpanan_rp" => $total_simpanan_rp,
                        "total_pinjaman_rp" => $total_pinjaman_rp,
                        "LabelStatus" => $LabelStatus,
                        "JumlahRincian" => $JumlahRincian,
                        "JumlahRincian_rp" => $JumlahRincian_rp,
                        "jumlah_alokasi" => $jumlah_alokasi,
                        "jumlah_alokasi_rp" => $jumlah_alokasi_rp,
                    ];
                    //Auto jurnal
                    $auto_jurnal = [
                        "akun_debet_pembagian" => $akun_debet_pembagian,
                        "akun_kredit_pembagian" => $akun_kredit_pembagian,
                        "akun_debet_pembayaran" => $akun_debet_pembayaran,
                        "akun_kredit_pembayaran" => $akun_kredit_pembayaran,
                    ];
                    // Response JSON
                    $response = [
                        "status" => "Success",
                        "message" => "Data Ditemukan",
                        "dataset" => $dataset,
                        "auto_jurnal" => $auto_jurnal
                    ];
                }
            }
        }
    }

    // Output JSON Response
    echo json_encode($response);
?>

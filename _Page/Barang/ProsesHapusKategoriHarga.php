<?php
    //Koneksi
    include "../../_Config/Connection.php";
    include "../../_Config/GlobalFunction.php";
    include "../../_Config/Session.php";

    //Time Zone
    date_default_timezone_set('Asia/Jakarta');

    //Time Now Tmp
    $now=date('Y-m-d H:i:s');

    // Inisialisasi respons default
    $response = [
        "status" => "Error",
        "message" => "Belum ada proses yang dilakukan pada sistem."
    ];

    if(empty($SessionIdAkses)){
        $response = [
            "status" => "Error",
            "message" => "Sesi Akses Sudah Berakhir, Silahkan Login Ulang"
        ];
    }else{
        if(empty($_POST['id_barang_kategori_harga'])){
            $response = [
                "status" => "Error",
                "message" => "ID Kategori Harga Tidak Boleh Kosong!"
            ];
        }else{
            $id_barang_kategori_harga=$_POST['id_barang_kategori_harga'];
            $id_barang_kategori_harga=validateAndSanitizeInput($_POST['id_barang_kategori_harga']);
            //Hapus Akses Berdasarkan id_obat_kategori_harga
            $hapus_kategori_harga = mysqli_query($Conn, "DELETE FROM barang_kategori_harga WHERE id_barang_kategori_harga='$id_barang_kategori_harga'") or die(mysqli_error($Conn));
            if ($hapus_kategori_harga) {
                $kategori_log="Barang";
                $deskripsi_log="Hapus Kategori Harga";
                $InputLog=addLog($Conn,$SessionIdAkses,$now,$kategori_log,$deskripsi_log);
                if($InputLog=="Success"){
                    $response = [
                        "status" => "Success",
                        "message" => "Hapus Kategori Harga Berhasil!"
                    ];
                }else{
                    $response = [
                        "status" => "Error",
                        "message" => "Terjadi kesalahan pada saat akan menyimpan log aktivitas"
                    ];
                }
            }else{
                $response = [
                    "status" => "Error",
                    "message" => "Terjadi kesalahan pada saat akan menghapus data dari database"
                ];
            }
        }
    }
    // Output response sebagai JSON
    // header('Content-Type: application/json');
    echo json_encode($response);
?>
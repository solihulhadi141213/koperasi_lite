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
        if(empty($_POST['id_jurnal'])){
            $response = [
                "status" => "Error",
                "message" => "ID Jurnal Tidak Boleh Kosong!"
            ];
        }else{
            $id_jurnal=$_POST['id_jurnal'];
            
            //Proses hapus jurnal
            $HapusJurnal = mysqli_query($Conn, "DELETE FROM jurnal WHERE id_jurnal='$id_jurnal'") or die(mysqli_error($Conn));
            if($HapusJurnal) {
                
                //Apabila Berhasil Simpan Log
                $kategori_log="Jurnal";
                $deskripsi_log="Hapus Jurnal";
                $InputLog=addLog($Conn,$SessionIdAkses,$now,$kategori_log,$deskripsi_log);
                if($InputLog=="Success"){
                    $response = [
                        "status" => "Success",
                        "message" => "Hapus jurnal manual Berhasil!"
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
                    "message" => "Terjadi Kesalahan Pada Saat Menghapus Jurnal"
                ];
            }
        }
    }

    // Output response
    echo json_encode($response);
?>
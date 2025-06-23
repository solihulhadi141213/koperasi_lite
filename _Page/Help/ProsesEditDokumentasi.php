<?php
    //Koneksi
    include "../../_Config/Connection.php";
    include "../../_Config/GlobalFunction.php";
    include "../../_Config/Session.php";
    date_default_timezone_set('Asia/Jakarta');

    //Set tanggal sekarang
    $now=date('Y-m-d H:i:s');

    //Validasi Akses Login
    if(empty($SessionIdAkses)){
        echo json_encode(['status' => 'Error', 'message' => 'Sesi Akses Sudah Berakhir, Silahkkan Login Ulang']);
    }else{
        

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            // Ambil data dari form
            $id_help      = mysqli_real_escape_string($Conn, trim($_POST['id_help']));
            $judul      = mysqli_real_escape_string($Conn, trim($_POST['judul']));
            $kategori   = mysqli_real_escape_string($Conn, trim($_POST['kategori']));
            $author     = mysqli_real_escape_string($Conn, trim($_POST['author']));
            $tanggal    = mysqli_real_escape_string($Conn, trim($_POST['tanggal']));
            $deskripsi  = $_POST['deskripsi_edit'];

            // Validasi input
            if (empty($id_help)) {
                echo json_encode(['status' => 'Error', 'message' => 'ID Dokumentasi Tidak Boleh Kosong!']);
                exit;
            }
            if (empty($judul)) {
                echo json_encode(['status' => 'Error', 'message' => 'Judul Dokumentasi Tidak Boleh Kosong!']);
                exit;
            }
            if (empty($kategori)) {
                echo json_encode(['status' => 'Error', 'message' => 'Kategori Dokumentasi Tidak Boleh Kosong!']);
                exit;
            }
            if (empty($author)) {
                echo json_encode(['status' => 'Error', 'message' => 'Author Dokumentasi Tidak Boleh Kosong!']);
                exit;
            }
            if (empty($tanggal)) {
                echo json_encode(['status' => 'Error', 'message' => 'Tanggal Dokumentasi Tidak Boleh Kosong!']);
                exit;
            }
            if (empty($deskripsi)) {
                echo json_encode(['status' => 'Error', 'message' => 'Isi Dokumentasi Tidak Boleh Kosong!']);
                exit;
            }
            //Update Ke Database
            $stmt = mysqli_prepare($Conn, "UPDATE help SET judul=?, kategori=?, author=?, datetime_creat=?, deskripsi=? WHERE id_help=?");
            mysqli_stmt_bind_param($stmt, "sssssi", $judul, $kategori, $author, $tanggal, $deskripsi, $id_help);
            $update_result = mysqli_stmt_execute($stmt);
            if ($update_result) {
                //Jika Berhasil Insert Log
                $kategori_log="Dokumentasi";
                $deskripsi_log="Edit Dokumentasi";
                $InputLog=addLog($Conn,$SessionIdAkses,$now,$kategori_log,$deskripsi_log);
                if($InputLog=="Success"){
                    echo json_encode(['status' => 'Success', 'id_help' => $id_help]);
                }else{
                    echo json_encode(['status' => 'Error', 'message' => 'Terjadi Kesalahan Pada Saat Menyimpan Log!']);
                }
                
            } else {
                echo json_encode(['status' => 'Error', 'message' => 'Gagal melakukan update data: ' . mysqli_error($Conn)]);
            }
        } else {
            echo json_encode(['status' => 'Error', 'message' => 'Metode request tidak valid!']);
        }
    }
?>
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
            $judul      = mysqli_real_escape_string($Conn, trim($_POST['judul']));
            $kategori   = mysqli_real_escape_string($Conn, trim($_POST['kategori']));
            $author     = mysqli_real_escape_string($Conn, trim($_POST['author']));
            $tanggal    = mysqli_real_escape_string($Conn, trim($_POST['tanggal']));
            $deskripsi  = mysqli_real_escape_string($Conn, trim($_POST['deskripsi']));

            // Validasi input
            if (empty($judul) || empty($kategori) || empty($author) || empty($tanggal) || empty($deskripsi)) {
                echo json_encode(['status' => 'Error', 'message' => 'Semua kolom harus diisi!']);
                exit;
            }
            //Validasi Judul Tidak Boleh Sama
            $id_help=GetDetailData($Conn, 'help', 'judul', $judul, 'id_help');

            if(!empty($id_help)){
                echo json_encode(['status' => 'Error', 'message' => 'Judul yang anda gunakan sudah ada!']);
                exit;
            }
            // Query Insert ke database
            $sql = "INSERT INTO help (judul, kategori, author, datetime_creat, deskripsi) 
                    VALUES ('$judul', '$kategori', '$author', '$tanggal', '$deskripsi')";

            if (mysqli_query($Conn, $sql)) {
                
                //Buka id_help
                $id_help=GetDetailData($Conn, 'help', 'judul', $judul, 'id_help');
                //Jika Berhasil Insert Log
                $kategori_log="Dokumentasi";
                $deskripsi_log="Tambah Dokumentasi";
                $InputLog=addLog($Conn,$SessionIdAkses,$now,$kategori_log,$deskripsi_log);
                if($InputLog=="Success"){
                    echo json_encode(['status' => 'Success', 'id_help' => "$id_help"]);
                }else{
                    echo json_encode(['status' => 'Error', 'message' => 'Terjadi Kesalahan Pada Saat Menyimpan Log!']);
                }
                
            } else {
                echo json_encode(['status' => 'Error', 'message' => 'Gagal menyimpan data: ' . mysqli_error($Conn)]);
            }
        } else {
            echo json_encode(['status' => 'Error', 'message' => 'Metode request tidak valid!']);
        }
    }
?>
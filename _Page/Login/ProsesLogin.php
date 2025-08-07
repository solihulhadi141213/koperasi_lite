<?php
    //Session Start
    session_start();

    //Koneksi
    include "../../_Config/Connection.php";

    //Time Zone
    date_default_timezone_set('Asia/Jakarta');

    //Inisiasi Waktu
    $date_creat = date('Y-m-d H:i:s');
    $expired_seconds = 60 * 60; // 1 jam
    $date_expired = date('Y-m-d H:i:s', strtotime($date_creat) + $expired_seconds);

    // Generate token
    function generateToken($length = 32) {
        return bin2hex(random_bytes($length / 2));
    }

    // Sanitasi input
    function validateAndSanitizeInput($data) {
        return htmlspecialchars(stripslashes(trim($data)));
    }

    // Validasi input
    if (empty($_POST["email"])) {
        echo '<code>Email tidak boleh kosong</code>';
    } elseif (empty($_POST["password"])) {
        echo '<code>Password tidak boleh kosong</code>';
    } elseif (empty($_POST["mode_akses"])) {
        echo '<code>Mode Akses tidak boleh kosong</code>';
    } else {
        $email = validateAndSanitizeInput($_POST["email"]);
        $password = validateAndSanitizeInput($_POST["password"]);
        $mode_akses = validateAndSanitizeInput($_POST["mode_akses"]);
        $passwordMd5 = md5($password);

        // Siapkan variabel query
        $table = "";
        $id_field = "";
        if ($mode_akses == "Pengurus") {
            $table = "akses";
            $id_field = "id_akses";
            $email_field = "email_akses";
        } elseif ($mode_akses == "Anggota") {
            $table = "anggota";
            $id_field = "id_anggota";
            $email_field = "email";
        } else {
            echo '<code>Mode akses tidak valid</code>';
            exit;
        }

        // Query login tabel sesuai mode
        $sql = "SELECT * FROM $table WHERE $email_field = ? AND password = ?";
        $stmt = $Conn->prepare($sql);
        if ($stmt === false) {
            die('Prepare failed: ' . htmlspecialchars($Conn->error));
        }
        $stmt->bind_param("ss", $email, $passwordMd5);
        $stmt->execute();
        $result = $stmt->get_result();
        $data_akses_login = $result->fetch_assoc();

        if ($data_akses_login) {
            $id = $data_akses_login[$id_field];

            // Bersihkan token lama
            $deleteTokenStmt = $Conn->prepare("DELETE FROM akses_login WHERE id_akses = ? AND kategori = ?");
            if ($deleteTokenStmt === false) {
                die('Prepare failed: ' . htmlspecialchars($Conn->error));
            }
            $deleteTokenStmt->bind_param("is", $id, $mode_akses);
            $deleteTokenStmt->execute();

            // Buat token baru
            $token = generateToken();
            $insertTokenStmt = $Conn->prepare(
                "INSERT INTO akses_login (id_akses, kategori, token, date_creat, date_expired)
                VALUES (?, ?, ?, ?, ?)"
            );
            if ($insertTokenStmt === false) {
                die('Prepare failed: ' . htmlspecialchars($Conn->error));
            }
            $insertTokenStmt->bind_param("issss", $id, $mode_akses, $token, $date_creat, $date_expired);
            $InputAksesLogin = $insertTokenStmt->execute();

            if ($InputAksesLogin) {
                echo '<span id="NotifikasiProsesLoginBerhasil">Success</span>';
                $_SESSION["id_akses"] = $id;
                $_SESSION["login_token"] = $token;
                $_SESSION["mode_akses"] = $mode_akses;
                $_SESSION["NotifikasiSwal"] = "Login Berhasil";
            } else {
                echo '<code>Terjadi kesalahan saat membuat sesi login</code>';
            }
        } else {
            echo '<code>Email atau password tidak valid</code>';
        }
    }
?>
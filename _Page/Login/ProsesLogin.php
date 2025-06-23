<?php
    session_start();
    include "../../_Config/Connection.php";
    date_default_timezone_set('Asia/Jakarta');
    $date_creat = date('Y-m-d H:i:s');
    $expired_seconds = 60 * 60; // 1 hour
    $date_expired = date('Y-m-d H:i:s', strtotime($date_creat) + $expired_seconds);

    // Function to generate a secure token
    function generateToken($length = 32) {
        return bin2hex(random_bytes($length / 2));
    }

    // Function to validate and sanitize input
    function validateAndSanitizeInput($data) {
        return htmlspecialchars(stripslashes(trim($data)));
    }

    // Validate email and password
    if (empty($_POST["email"])) {
        echo '<code>Email tidak boleh kosong</code>';
    } elseif (empty($_POST["password"])) {
        echo '<code>Password tidak boleh kosong</code>';
    } else {
        $email = validateAndSanitizeInput($_POST["email"]);
        $password = validateAndSanitizeInput($_POST["password"]);
        $passwordMd5 = md5($password);

        // Use prepared statements to prevent SQL injection
        $stmt = $Conn->prepare("SELECT * FROM akses WHERE email_akses = ? AND password = ?");
        $stmt->bind_param("ss", $email, $passwordMd5);

        if ($stmt === false) {
            die('Prepare failed: ' . htmlspecialchars($Conn->error));
        }

        $stmt->execute();
        $result = $stmt->get_result();
        $DataAkses = $result->fetch_assoc();

        if ($DataAkses) {
            $id_akses = $DataAkses["id_akses"];

            // Delete old login tokens
            $deleteTokenStmt = $Conn->prepare("DELETE FROM akses_login WHERE id_akses = ?");
            if ($deleteTokenStmt === false) {
                die('Prepare failed: ' . htmlspecialchars($Conn->error));
            }
            $deleteTokenStmt->bind_param("i", $id_akses);
            $deleteTokenStmt->execute();

            //Mode Akses
            $mode_akses="Pengurus";
            
            // Create new login token
            $token = generateToken();
            $insertTokenStmt = $Conn->prepare("INSERT INTO akses_login (id_akses, kategori, token, date_creat, date_expired) VALUES (?, ?, ?, ?, ?)");
            if ($insertTokenStmt === false) {
                die('Prepare failed: ' . htmlspecialchars($Conn->error));
            }
            $insertTokenStmt->bind_param("issss", $id_akses, $mode_akses, $token, $date_creat, $date_expired);
            $InputAksesLogin = $insertTokenStmt->execute();

            if ($InputAksesLogin) {
                echo '<span id="NotifikasiProsesLoginBerhasil">Success</span>';
                $_SESSION["id_akses"] = $id_akses;
                $_SESSION["login_token"] = $token;
                $_SESSION["NotifikasiSwal"] = "Login Berhasil";
            } else {
                echo '<code>Terjadi kesalahan pada saat membuat sesi login</code>';
            }
        } else {
            echo '<code>Kombinasi password dan email yang Anda gunakan tidak valid</code>';
        }
    }
?>

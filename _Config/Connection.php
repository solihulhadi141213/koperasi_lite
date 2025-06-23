<?php
    //Ini adalah halaman untuk melakukan konfigurasi database
    $servername = "localhost";
    $username = "root";
    $password = "arunaparasilvanursari";
    $db = "koperasi_lite";
    // Create connection
    $Conn = new mysqli($servername, $username, $password, $db);
    // Check connection
    if ($Conn->connect_error) {
        die("Connection failed: " . $Conn->connect_error);
    }
?>
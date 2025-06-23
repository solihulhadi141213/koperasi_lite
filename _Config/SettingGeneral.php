<?php
    // Persiapkan query dengan prepared statement
    $sql = "SELECT * FROM setting_general WHERE id_setting_general = ?";
    $stmt = $Conn->prepare($sql);

    // Bind parameter (tipe data integer "i")
    $id = 1;
    $stmt->bind_param("i", $id);

    // Eksekusi statement
    $stmt->execute();

    // Ambil hasil query
    $result = $stmt->get_result();
    $DataSettingGeneral = $result->fetch_assoc();

    // Simpan hasil ke variabel
    $id_setting_general = $DataSettingGeneral['id_setting_general'] ?? null;
    $title_page = $DataSettingGeneral['title_page'] ?? null;
    $kata_kunci = $DataSettingGeneral['kata_kunci'] ?? null;
    $deskripsi = $DataSettingGeneral['deskripsi'] ?? null;
    $alamat_bisnis = $DataSettingGeneral['alamat_bisnis'] ?? null;
    $email_bisnis = $DataSettingGeneral['email_bisnis'] ?? null;
    $telepon_bisnis = $DataSettingGeneral['telepon_bisnis'] ?? null;
    $favicon = $DataSettingGeneral['favicon'] ?? null;
    $logo = $DataSettingGeneral['logo'] ?? null;
    $base_url = $DataSettingGeneral['base_url'] ?? null;
    $AuthorAplikasi = $DataSettingGeneral['author'] ?? null;

    // Tutup statement
    $stmt->close();
?>
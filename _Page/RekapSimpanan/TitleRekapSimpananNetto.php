<?php
    // Koneksi
    include "../../_Config/Connection.php";
    include "../../_Config/GlobalFunction.php";
    include "../../_Config/Session.php";

    // Time Zone
    date_default_timezone_set('Asia/Jakarta');
    // Validasi Periode
    $periode = $_POST['periode'] ?? '';
    $tahun = $_POST['tahun'] ?? '';
    $bulan = $_POST['bulan'] ?? '';

    $periode = validateAndSanitizeInput($periode);
    $tahun = validateAndSanitizeInput($tahun);
    $bulan = validateAndSanitizeInput($bulan);

    if (empty($periode)) {
        echo '
            <div class="alert alert-danger">
                <small>Periode Data Tidak Boleh Kosong! Silahkan Pilih Periode Data Terlebih Dulu!</small>
            </div>
        ';
    }

    if ($periode === "Tahunan" && empty($tahun)) {
        echo '
            <div class="alert alert-danger">
                <small>Tahun Data Tidak Boleh Kosong! Silahkan Pilih Tahun Data Terlebih Dulu!</small>
            </div>
        ';
    }

    if ($periode === "Bulanan" && (empty($tahun) || empty($bulan))) {
        echo '
            <div class="alert alert-danger">
                <small>Tahun Dan Bulan Tidak Boleh Kosong! Silahkan Pilih Tahun dan Bulan Terlebih Dulu!</small>
            </div>
        ';
    }

    $keyword = $periode === "Semua" ? "" : ($periode === "Tahunan" ? "$tahun" : "$tahun-$bulan");
    if($periode=="Semua"){
        $periode_bulan="";
        $periode_tahun="";
        $title_periode='';
    }else{
        if($periode=="Tahunan"){
            $periode_bulan="";
            $periode_tahun="TAHUN $tahun";
            $title_periode='PERIODE ' . $periode_tahun . '';
        }else{
            $nama_bulan = getNamaBulan($bulan);
            $periode_bulan="BULAN $nama_bulan";
            $periode_tahun="TAHUN $tahun";
            $title_periode='PERIODE ' . $periode_bulan . ' ' . $periode_tahun . '';
        }
    }
    echo '
        <div class="row mb-3">
            <div class="col-md-12 text-center">
                REKAP DATA SIMPANAN ANGGOTA (NETTO)<br>
                <span style="text-transform: uppercase;">' . $title_periode . '</span><br>
                <small><i>(Nilai Nominal Simpanan Yang Ditampilkan Sudah Dikurangi Jumlah Penariikan Dana)</i></small>
            </div>
        </div>
        <div class="row mb-3">
            <div class="col-md-12 text-center">
                <button type="button" class="btn btn-sm btn-outline-secondary btn-rounded" data-bs-toggle="modal" data-bs-target="#ModalCetak4">
                    <i class="bi bi-printer"></i> Cetak Data Rekap
                </button>
            </div>
        </div>
    ';
?>
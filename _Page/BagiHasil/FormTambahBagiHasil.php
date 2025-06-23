<?php
    //koneksi dan session
    include "../../_Config/Connection.php";
    include "../../_Config/GlobalFunction.php";
    include "../../_Config/Session.php";
    date_default_timezone_set("Asia/Jakarta");

    //Waktu Sekarang
    $datetime=date('Y-m-d H:i:s');
    $date=date('Y-m-d');

    //Validasi Akses
    if(empty($SessionIdAkses)){
        echo '
            <div class="alert alert-danger">
                <small>Sesi Akses Sudah Berakhir, Silahkan Login Ulang!</small>
            </div>
        ';
    }else{
?>

    <div class="row mb-3">
        <div class="col-md-4">
            <label for="periode_hitung1">Periode Awal Perhitungan</label>
        </div>
        <div class="col-md-8">
            <input type="date" name="periode_hitung1" id="periode_hitung1" class="form-control">
        </div>
    </div>
    <div class="row mb-3">
        <div class="col-md-4">
            <label for="periode_hitung2">Periode Akhir Perhitungan</label>
        </div>
        <div class="col-md-8">
            <input type="date" name="periode_hitung2" id="periode_hitung2" class="form-control">
        </div>
    </div>
    <div class="row mb-3">
        <div class="col-md-4">
            <label for="shu">SHU (Rp)</label>
        </div>
        <div class="col-md-8">
            <input type="text" name="shu" id="shu" class="form-control form-money">
            <small class="credit">
                <code class="text text-grayish">Pendapatan (Laba) dikurangi biaya dan pajak</code>
            </small>
        </div>
    </div>
    <div class="row mb-3">
        <div class="col-md-4">
            <label for="persen_penjualan">Jasa Usaha/Penjualan (%)</label>
        </div>
        <div class="col-md-8">
            <input type="number" min="0" max="100" name="persen_penjualan" id="persen_penjualan" class="form-control" placeholder="[0-100]">
            <small class="credit">
                <code class="text text-grayish">
                    Persentase alokasi jasa usaha (penjualan) anggota berdasarkan ADART
                </code>
            </small>
        </div>
    </div>
    <div class="row mb-3">
        <div class="col-md-4">
            <label for="persen_simpanan">Jasa Simpanan/Modal (%)</label>
        </div>
        <div class="col-md-8">
            <input type="number" min="0" max="100" name="persen_simpanan" id="persen_simpanan" class="form-control" placeholder="[0-100]">
            <small class="credit">
                <code class="text text-grayish">
                    Persentase alokasi jasa modal simpanan anggota berdasarkan ADART
                </code>
            </small>
        </div>
    </div>
    <div class="row mb-3">
        <div class="col-md-4">
            <label for="persen_pinjaman">Jasa Pinjaman (%)</label>
        </div>
        <div class="col-md-8">
            <input type="number" min="0" max="100" name="persen_pinjaman" id="persen_pinjaman" class="form-control" placeholder="[0-100]">
            <small class="credit">
                <code class="text text-grayish">
                    Persentase alokasi jasa pinjaman anggota berdasarkan ADART
                </code>
            </small>
        </div>
    </div>
    <script>
        initializeMoneyInputs();
    </script>
<?php } ?>

<form action="javascript:void(0);" class="row g-3" id="ProsesLupaPassword">
    <div class="card-body">
        <div class="row mb-3">
            <div class="col-md-12 text-center">
                <h5 class="card-title pb-0 fs-4">Lupa Password</h5>
                <p class="text-center small">Sistem akan mengirimkan tautan kode verifikasi ke email anda.</p>
            </div>
        </div>
        <div class="row mb-3">
            <div class="col-12">
                <label for="mode_akses" class="form-label">Mode Akses</label>
                <select name="mode_akses" id="mode_akses" class="form-control">
                    <option value="Pengurus">Pengurus</option>
                    <option value="Anggota">Anggota</option>
                </select>
            </div>
        </div>
        <div class="row mb-3">
            <div class="col-12">
                <label for="email" class="form-label">Masukan Email Anda</label>
                <input type="email" name="email" class="form-control" id="email" required>
            </div>
        </div>
        <div class="row mb-3">
            <div class="col-12">
                Pastikan email yang anda masukan sudah benar.
            </div>
        </div>
        <div class="row mb-3">
            <div class="col-12" id="NotifikasiLupaPassword">
                <!-- Notifikasi Reset Password Akan Muncul Disini -->
            </div>
        </div>
        <div class="row mb-3">
            <div class="col-12">
                <button class="btn btn-primary w-100" type="submit" title="Kirim Tautan Reset Password">
                    <i class="bi bi-send"></i> Kirim Tautan
                </button>
            </div>
        </div>
        <div class="row mb-3">
            <div class="col-12">
                <a href="Login.php" class="btn btn-dark w-100" title="Kembali Ke Halaman Login">
                    <i class="bi bi-chevron-left"></i> Kembali
                </a>
            </div>
        </div>
    </div>
</form>
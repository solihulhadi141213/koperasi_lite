<div class="card-body">
    <div class="pb-2">
        <h5 class="card-title text-center pb-0 fs-4">Login Ke Akun Anda</h5>
        <p class="text-center small">Masukan Email Dan Password Untuk Melakukan Login</p>
    </div>
    <form action="javascript:void(0);" class="row g-3" id="ProsesLogin">
        <div class="col-12">
            <label for="mode_akses" class="form-label">Mode Akses</label>
            <select name="mode_akses" id="mode_akses" class="form-control">
                <option value="Pengurus">Pengurus</option>
                <option value="Anggota">Anggota</option>
            </select>
        </div>
        <div class="col-12">
            <label for="email" class="form-label">Email</label>
            <div class="input-group has-validation">
                <span class="input-group-text" id="inputGroupPrepend">@</span>
                <input type="email" name="email" class="form-control" id="email" required>
                <div class="invalid-feedback">Please enter your username.</div>
            </div>
        </div>
        <div class="col-12">
            <label for="password" class="form-label">Password</label>
            <input type="password" name="password" class="form-control" id="password" required>
            <div class="invalid-feedback">Please enter your password!</div>
            <small class="credit">
                <div class="form-check">
                    <input class="form-check-input" type="checkbox" value="Tampilkan" id="TampilkanPassword2" name="TampilkanPassword2">
                    <label class="form-check-label" for="TampilkanPassword2">
                        Tampilkan Password
                    </label>
                </div>
            </small>
        </div>
        <div class="col-12">
            Pastikan email dan password sudah benar.
        </div>
        <div class="col-12" id="NotifikasiLogin"></div>
        <div class="col-12">
            <button class="btn btn-primary w-100" type="submit">Login</button>
        </div>
        <div class="col-12">
            <p class="small mb-0">Anda Lupa Password? <a href="Login.php?Page=LupaPassword">Reset password</a></p>
        </div>
    </form>
</div>
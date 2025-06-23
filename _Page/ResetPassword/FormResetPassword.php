<?php
    //Inisiasi tanggal sekarang
    date_default_timezone_set("Asia/Jakarta");
    $tanggal_sekarang=date('Y-m-d');

    //menangkap data dari link
    if(empty($_GET['email'])){
        $validasi_data="Parameter Email Tidak Boleh Kosong! Silahkan gunakan tautan yang benar dan valid dari URL yang telah dikirim pada email anda.";
    }else{
        if(empty($_GET['token'])){
            $validasi_data="Parameter Token Tidak Boleh Kosong! Silahkan gunakan tautan yang benar dan valid dari URL yang telah dikirim pada email anda.";
        }else{
            $email=$_GET['email'];
            $token=$_GET['token'];

            //Bersihkan variabel
            $email=validateAndSanitizeInput($email);
            $token=validateAndSanitizeInput($token);
            $token_md5=md5($token);

            //Validasi email dan token pada tabel lupa_password
            // Gunakan prepared statement untuk menghindari SQL Injection
            $query = "SELECT id_lupa_password, id_anggota, id_akses, tanggal_expired 
            FROM lupa_password 
            WHERE email = ? AND code_unik = ?";

            $stmt = mysqli_prepare($Conn, $query);
            mysqli_stmt_bind_param($stmt, "ss", $email, $token_md5);
            mysqli_stmt_execute($stmt);
            $result = mysqli_stmt_get_result($stmt);
            $Data = mysqli_fetch_assoc($result);

            if (!$Data) {
                $validasi_data = "Kombinasi Email Dan Token Yang Anda Gunakan Tidak Valid! Silahkan gunakan tautan yang benar dan valid dari URL yang telah dikirim pada email anda.";
            } else {
                $id_lupa_password = $Data["id_lupa_password"];
                $tanggal_expired = $Data["tanggal_expired"];

                // Pastikan $tanggal_sekarang sudah didefinisikan dengan format yang sesuai
                $tanggal_sekarang = date("Y-m-d H:i:s");

                // Validasi tanggal_expired
                if ($tanggal_expired < $tanggal_sekarang) {
                    $validasi_data = "Tautan yang anda gunakan sudah tidak berlaku! Silahkan kirim ulang tautan lupa password";
                } else {
                    $validasi_data = "Valid";
                    $id_anggota = $Data["id_anggota"];
                    $id_akses = $Data["id_akses"];
                }
            }
        }
    }
    if($validasi_data!=="Valid"){
        echo '
            <div class="card-body text-center">
                <div class="alert alert-danger">
                    <h3>Opss!</h3>
                    <small>'.$validasi_data.'</small>
                </div>
            </div>
            <div class="card-footer text-center">
                <a href="Login.php" class="btn btn-dark w-100" type="button">Kembali Ke Login</a>
            </div>
        ';
    }else{
        //Tampilkan Form
?>
        <form action="javascript:void(0);" id="ProsesResetPassword">
            <input type="hidden" name="email" value="<?php echo "$email"; ?>">
            <input type="hidden" name="token" value="<?php echo "$token"; ?>">
            <div class="card-body">
                <div class="row mb-3">
                    <div class="col-12 pt-4 pb-2">
                        <h5 class="card-title text-center pb-0 fs-4">Reset Password</h5>
                        <p class="text-center small">
                            Silahkan masukan password baru anda disini.
                        </p>
                    </div>
                </div>
                <div class="row mb-3">
                    <div class="col-12">
                        <div class="alert alert-warning">
                            Perlu anda ketahui bahwa tautan ini akan berakhir pada <b><?php echo $tanggal_expired; ?></b>
                        </div>
                    </div>
                </div>
                <div class="row mb-3">
                    <div class="col-12">
                        <label for="password1" class="form-label">Password Baru</label>
                        <input type="password" name="PasswordBaru1" id="PasswordBaru1" class="form-control" required>
                        <small class="text text-muted">
                            Pastikan password yang anda masukan terdiri dari 6-20 karakter numeric dan huruf.
                        </small>
                    </div>
                </div>
                <div class="row mb-3">
                    <div class="col-12">
                        <label for="password2" class="form-label">Ulangi Password</label>
                        <input type="password" name="PasswordBaru2" id="PasswordBaru2" class="form-control" required>
                        <div class="form-check mt-3">
                            <input class="form-check-input" type="checkbox" value="Tampilkan" id="TampilkanUbahPassword" name="TampilkanUbahPassword">
                            <label class="form-check-label" for="TampilkanUbahPassword">
                                <small class="text text-muted">Tampilkan Password</small>
                            </label>
                        </div>
                    </div>
                </div>
                <div class="row mb-3">
                    <div class="col-12" id="NotifikasiResetPassword">

                    </div>
                </div>
                <div class="row mb-3">
                    <div class="col-12">
                        <button class="btn btn-primary w-100" type="submit">
                            <i class="bi bi-save"></i> Simpan Password
                        </button>
                    </div>
                </div>
            </div>
        </form>
<?php 
    }
    mysqli_stmt_close($stmt);
?>
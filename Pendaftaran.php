<!DOCTYPE html>
<html lang="en">
    <head>
        <?php
            //Koneksi
            session_start();
            include "_Config/Connection.php";
            include "_Config/GlobalFunction.php";
            include "_Config/SettingGeneral.php";
            include "_Partial/Head.php";
        ?>
    </head>
    <body>
        <main class="landing_background">
            <div class="container">
                <section class="section register min-vh-100 d-flex flex-column align-items-center justify-content-center py-4">
                    <div class="container">
                        <div class="row justify-content-center">
                            <div class="col-lg-6 col-md-6 d-flex flex-column align-items-center justify-content-center">
                                <img src="assets/img/<?php echo $logo;?>" alt="<?php echo $title_page;?>" width="100px">
                                <div class="d-flex justify-content-center py-2">
                                    <p>
                                        <a href="" class="logo d-flex align-items-center w-auto">
                                            <span class="d-none d-lg-block text-light"><?php echo $title_page;?></span>
                                        </a>
                                    </p>
                                </div>
                                <div class="card mb-3">
                                    <div class="card-body">
                                        <div class="pb-2 border-bottom border-1 mb-3">
                                            <h5 class="card-title text-center pb-0 fs-4">Form Pendaftaran Anggota</h5>
                                            <p class="text-center small">Isi Formulir Pendaftaran Berikut Ini Dengan Lengkap</p>
                                        </div>
                                        <form action="javascript:void(0);" class="row g-3" id="ProsesPendaftaran">
                                            <div class="row mb-2 mt-3">
                                                <div class="col-md-4">
                                                    <label for="nama" class="form-label">Nama Lengkap</label>
                                                </div>
                                                <div class="col-md-8">
                                                    <input type="text" name="nama" class="form-control" id="nama" required>
                                                </div>
                                            </div>
                                            <div class="row mb-2 mt-3">
                                                <div class="col-md-4">
                                                    <label for="nik" class="form-label">No.NIK/KTP</label>
                                                </div>
                                                <div class="col-md-8">
                                                    <input type="text" name="nik" class="form-control" id="nik" plceholder="" required>
                                                </div>
                                            </div>
                                            <div class="row mb-2 mt-3">
                                                <div class="col-md-4">
                                                    <label for="kontak" class="form-label">No.Kontak</label>
                                                </div>
                                                <div class="col-md-8">
                                                    <input type="text" name="kontak" class="form-control" id="kontak" plceholder="+62" required>
                                                </div>
                                            </div>
                                            <div class="row mb-2 mt-3">
                                                <div class="col-md-4">
                                                    <label for="email" class="form-label">Alamat Email</label>
                                                </div>
                                                <div class="col-md-8">
                                                    <input type="email" name="email" class="form-control" id="email" required>
                                                </div>
                                            </div>
                                            <div class="row mb-2 mt-3">
                                                <div class="col-md-4">
                                                    <label for="password1" class="form-label">Password</label>
                                                </div>
                                                <div class="col-md-8">
                                                    <input type="password" name="password1" class="form-control" id="password1" required>
                                                </div>
                                            </div>
                                            <div class="row mb-2 mt-3">
                                                <div class="col-md-4">
                                                    <label for="password2" class="form-label">Ulangi Password</label>
                                                </div>
                                                <div class="col-md-8">
                                                    <input type="password" name="password2" class="form-control" id="password2" required>
                                                    <small class="credit">
                                                        <div class="form-check">
                                                            <input class="form-check-input" type="checkbox" value="Tampilkan" id="TampilkanPassword2" name="TampilkanPassword2">
                                                            <label class="form-check-label" for="TampilkanPassword2">
                                                                Tampilkan Password
                                                            </label>
                                                        </div>
                                                    </small>
                                                </div>
                                            </div>
                                            <div class="row mb-2 mt-3">
                                                <div class="col-md-12">
                                                    Pastikan informasi yang anda masukan sudah benar.
                                                </div>
                                            </div>
                                            <div class="row mb-2 mt-3">
                                                <div class="col-md-12" id="NotifikasiPendaftaran">
                                                    
                                                </div>
                                            </div>
                                            <div class="row mb-2 mt-3">
                                                <div class="col-md-6 mb-2">
                                                    <a href="Login.php" class="btn btn-md btn-warning btn-block">
                                                        Kembali
                                                    </a>
                                                </div>
                                                <div class="col-md-6 mb-2">
                                                    <button class="btn btn-primary w-100" type="submit">Simpan</button>
                                                </div>
                                            </div>
                                        </form>
                                    </div>
                                </div>
                                <div class="credits text-center">
                                    <small>
                                        <div class="copyright text-white">
                                            &copy; Copyright <strong><span><?php echo "$title_page"; ?></span></strong>. All Rights Reserved 2025
                                        </div>
                                        <div class="credits text-white">
                                            Designed by <span class="text text-decoration-underline"><?php echo "$AuthorAplikasi"; ?></span>
                                        </div>
                                    </small>
                                </div>
                            </div>
                        </div>
                    </div>
                </section>
            </div>
    </main>
        <?php
            include "_Partial/FooterJs.php";
            include "_Partial/RoutingSwal.php";
        ?>
        <script>
            //Kondisi saat tampilkan password
            $('#TampilkanPassword2').click(function(){
                if($(this).is(':checked')){
                    $('#password1').attr('type','text');
                    $('#password2').attr('type','text');
                }else{
                    $('#password1').attr('type','password');
                    $('#password2').attr('type','password');
                }
            });

            //Submit Pendaftaran
            $('#ProsesPendaftaran').submit(function (e) {
                e.preventDefault(); // Mencegah reload form biasa

                var ProsesPendaftaran = $('#ProsesPendaftaran').serialize();
                var Loading = '<div class="spinner-border text-info" role="status"><span class="visually-hidden">Loading...</span></div>';
                $('#NotifikasiPendaftaran').html(Loading);

                $.ajax({
                    type: 'POST',
                    url: '_Page/Pendaftaran/ProsesPendaftaran.php',
                    data: ProsesPendaftaran,
                    success: function (data) {
                        $('#NotifikasiPendaftaran').html(data);

                        var NotifikasiPendaftaranBerhasil = $('#NotifikasiPendaftaranBerhasil').html();
                        if (NotifikasiPendaftaranBerhasil == "Success") {
                            Swal.fire({
                                icon    : 'success',
                                title   : 'Pendaftaran Berhasil',
                                text    : 'Kami akan melakukan validasi data anda, silahkan lakukan login untuk mengetahui progres status keanggotaan anda.',
                                confirmButtonText: 'OK'
                            }).then((result) => {
                                if (result.isConfirmed) {
                                    // Reload halaman setelah alert ditutup
                                    window.location.reload();
                                }
                            });
                        }
                    }
                });
            });
        </script>
    </body>
</html>
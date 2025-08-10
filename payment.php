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
                            <div class="col-lg-4 col-md-6 d-flex flex-column align-items-center justify-content-center">
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
                                        <div class="pb-2">
                                            <h5 class="card-title text-center pb-0 fs-4">Simulator Pembayaran</h5>
                                            <p class="text-center small">Semua pembayaran yang dilakukan pada halaman ini tidak nyata</p>
                                        </div>
                                        <form action="javascript:void(0);" class="row g-3" id="ProsesPembayaran">
                                            <div class="col-12">
                                                <label for="mode_pembayaran" class="form-label">Mode Pembayaran</label>
                                                <select name="mode_pembayaran" id="mode_pembayaran" class="form-control">
                                                    <option value="simpanan">Simpanan</option>
                                                    <option value="pinjaman_angsuran ">Angsuran</option>
                                                </select>
                                            </div>
                                            <div class="col-12">
                                                <label for="kode_pembayaran" class="form-label">Kode Pembayaran</label>
                                                <input type="text" name="kode_pembayaran" class="form-control" id="kode_pembayaran" required>
                                            </div>
                                            <div class="col-12">
                                                Pastikan kode pembayaran yang anda masukan sudah benar.
                                            </div>
                                            <div class="col-12" id="NotifikasiPembayaran">
                                                <!-- Notifikasi Pembayaran Akan Muncul Disini -->
                                            </div>
                                            <div class="col-12 mb-2" id="PutTombolBayar">
                                                <button class="btn btn-primary w-100" type="button" id="GeneratePembayaran">Generate</button>
                                                <button class="btn btn-warning w-100" type="button" id="SubmitBayar">Bayar</button>
                                            </div>
                                            <div class="col-12">
                                                <a href="" class="btn btn-md btn-secondary btn-block">
                                                    Reset
                                                </a>
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
        ?>
        <script>
            $(document).ready(function() {
                //Sembunyikan Tombol Bayar
                $('#SubmitBayar').hide();
            });


            $('#GeneratePembayaran').click(function(){
                var ProsesPembayaran = $('#ProsesPembayaran').serialize();
                var Loading='<div class="spinner-border text-info" role="status"><span class="visually-hidden">Loading...</span></div>';
                $('#NotifikasiPembayaran').html("Loading...");
                $.ajax({
                    type 	    : 'POST',
                    url 	    : '_Page/Pembayaran/GeneratePembayaran.php',
                    data 	    :  ProsesPembayaran,
                    success     : function(data){
                        $('#NotifikasiPembayaran').html(data);
                        var InformasiPembayaranBerhasil=$('#InformasiPembayaranBerhasil').val();
                        if(InformasiPembayaranBerhasil=="Success"){
                            $('#GeneratePembayaran').hide();
                            $('#SubmitBayar').show();
                            $('#kode_pembayaran').prop('readonly', true);
                        }
                    }
                });
            });

            //Submit Pembayaran
            $('#SubmitBayar').click(function(){
                var ProsesPembayaran = $('#ProsesPembayaran').serialize();
                var Loading='<div class="spinner-border text-info" role="status"><span class="visually-hidden">Loading...</span></div>';
                $('#NotifikasiPembayaran').html("Loading...");
                $.ajax({
                    type 	    : 'POST',
                    url 	    : '_Page/Pembayaran/ProsesPembayaran.php',
                    data 	    :  ProsesPembayaran,
                    success     : function(data){
                        $('#NotifikasiPembayaran').html(data);
                        var NotifikasiPembayaranBerhasil=$('#NotifikasiPembayaranBerhasil').html();
                        if(NotifikasiPembayaranBerhasil=="Success"){
                            //Tampilkan Swal Bahwa Proses Berhasil
                            Swal.fire({
                                title   : 'Berhasil',
                                text    : 'Pembayaran Berhasil Dilakukan',
                                icon    : 'success',
                                confirmButtonText: 'Tutup'
                            }).then((result) => {
                                if (result.isConfirmed || result.dismiss === Swal.DismissReason.close) {
                                    window.location.href = 'payment.php';
                                }
                            });
                        }
                    }
                });
            });

            //Jika mode Diubah
            $('#mode_pembayaran').change(function(){
                //Sembunyikan Tombol Bayar
                $('#SubmitBayar').hide();

                //Munculkan tombol generate
                $('#GeneratePembayaran').show();
            });

        </script>
    </body>
</html>
<?php
    //Koneksi
    date_default_timezone_set('Asia/Jakarta');
    include "../../_Config/Connection.php";
    include "../../_Config/GlobalFunction.php";
    include "../../_Config/SettingGeneral.php";

    //Session
    include "../../_Config/Session.php";

    //Validasi Session
    if(empty($SessionIdAkses)){
        echo '<div class="row">';
        echo '  <div class="col-md-12 mb-3 text-center">';
        echo '      <small class="text-danger">Sesi Akses Sudah Berakhir, Silahkan Login Ulang</small>';
        echo '  </div>';
        echo '</div>';
    }else{
        if(empty($_POST['id_pinjaman_jenis'])){
            echo '<div class="row">';
            echo '  <div class="col-md-12 mb-3 text-center">';
            echo '      <small class="text-danger">Jenis Pinjaman Tidak Boleh Kosong!</small>';
            echo '  </div>';
            echo '</div>';
        }else{
            if(empty($_POST['jumlah_pinjaman'])){
                echo '<div class="row">';
                echo '  <div class="col-md-12 mb-3 text-center">';
                echo '      <small class="text-danger">Jumlah Pinjaman Tidak Boleh Kosong!</small>';
                echo '  </div>';
                echo '</div>';
            }else{

                //Buat Variabel
                $id_pinjaman_jenis=$_POST['id_pinjaman_jenis'];
                $jumlah_pinjaman=$_POST['jumlah_pinjaman'];
                $id_pinjaman_jenis=validateAndSanitizeInput($id_pinjaman_jenis);
                $jumlah_pinjaman=validateAndSanitizeInput($jumlah_pinjaman);

                //Format Jumlah Pinjaman
                $jumlah_pinjaman_format = "Rp " . number_format($jumlah_pinjaman,0,',',',');

                //Buka Data Jenis Pinjaman
                $nama_pinjaman=GetDetailData($Conn,'pinjaman_jenis','id_pinjaman_jenis',$id_pinjaman_jenis,'nama_pinjaman');
                if(empty($nama_pinjaman)){
                    echo '<div class="row">';
                    echo '  <div class="col-md-12 mb-3 text-center">';
                    echo '      <small class="text-danger">Pinjaman yang anda pilih tidak valid, atau tidak ada pada database!</small>';
                    echo '  </div>';
                    echo '</div>';
                }else{
                    $periode_angsuran=GetDetailData($Conn,'pinjaman_jenis','id_pinjaman_jenis',$id_pinjaman_jenis,'periode_angsuran');
                    $persen_jasa=GetDetailData($Conn,'pinjaman_jenis','id_pinjaman_jenis',$id_pinjaman_jenis,'persen_jasa');

                    //Hitung Angsuran Pokok
                    $angsuran_pokok=$jumlah_pinjaman/$periode_angsuran;
                    $angsuran_pokok=round($angsuran_pokok);
                    $angsuran_pokok_format = "Rp " . number_format($angsuran_pokok,0,',',',');

                    //Hitung Jasa
                    $jasa=$jumlah_pinjaman*($persen_jasa/100);
                    $jasa=round($jasa);
                    $jasa_format = "Rp " . number_format($jasa,0,',',',');

                    //Angsuran Total
                    $angsuran_total=$angsuran_pokok+$jasa;
                    $angsuran_total_format = "Rp " . number_format($angsuran_total,0,',',',');

                    echo '
                        <input type="hidden" name="id_pinjaman_jenis" value="'.$id_pinjaman_jenis.'">
                        <input type="hidden" name="jumlah_pinjaman" value="'.$jumlah_pinjaman.'">
                        <input type="hidden" name="rp_jasa" value="'.$jasa.'">
                        <input type="hidden" name="angsuran_pokok" value="'.$angsuran_pokok.'">
                        <input type="hidden" name="angsuran_total" value="'.$angsuran_total.'">
                        <input type="hidden" name="periode_angsuran" value="'.$periode_angsuran.'">
                        <div class="row mb-2">
                            <div class="col-5"><small>Jumlah Pinjaman</small></div>
                            <div class="col-1"><small>:</small></div>
                            <div class="col-6"><code class="text text-grayish">'.$nama_pinjaman.'</code></div>
                        </div>
                        <div class="row mb-2">
                            <div class="col-5"><small>Periode</small></div>
                            <div class="col-1"><small>:</small></div>
                            <div class="col-6"><code class="text text-grayish">'.$periode_angsuran.' Bulan</code></div>
                        </div>
                        <div class="row mb-2">
                            <div class="col-5"><small>Persen Jasa</small></div>
                            <div class="col-1"><small>:</small></div>
                            <div class="col-6"><code class="text text-grayish">'.$persen_jasa.' %</code></div>
                        </div>
                        <div class="row mb-2">
                            <div class="col-5"><small>Jumlah Pinjaman</small></div>
                            <div class="col-1"><small>:</small></div>
                            <div class="col-6"><code class="text text-grayish">'.$jumlah_pinjaman_format.'</code></div>
                        </div>
                        <div class="row mb-2">
                            <div class="col-5"><small>Angsuran Pokok</small></div>
                            <div class="col-1"><small>:</small></div>
                            <div class="col-6"><code class="text text-grayish">'.$angsuran_pokok_format.'</code></div>
                        </div>
                        <div class="row mb-2">
                            <div class="col-5"><small>Nominal Jasa</small></div>
                            <div class="col-1"><small>:</small></div>
                            <div class="col-6"><code class="text text-grayish">'.$jasa_format.'</code></div>
                        </div>
                        <div class="row mb-2">
                            <div class="col-5"><small>Nominal Angsuran</small></div>
                            <div class="col-1"><small>:</small></div>
                            <div class="col-6"><code class="text text-grayish">'.$angsuran_total_format.'</code></div>
                        </div>
                        <div class="row mb-2">
                            <div class="col-12">
                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox" id="FormSetuju" name="FormSetuju" value="Setuju">
                                    <label class="form-check-label" for="FormSetuju">
                                        <small>
                                            Dengan ini saya setuju dengan syarat dan ketentuan yang berlaku terkait dengan ketentuan pinjaman yang diterapkan.
                                        </small>
                                    </label>
                                </div>
                            </div>
                        </div>
                        <div class="row mt-3">
                            <div class="col-6 mt-3">
                                <button type="button" class="btn btn-dark btn-rounded btn-block" data-bs-toggle="modal" data-bs-target="#ModalTambahPinjaman" data-id="'.$id_pinjaman_jenis.'">
                                    <i class="bi bi-chevron-left"></i> Sebelumnya
                                </button>
                            </div>
                            <div class="col-6 mt-3">
                                <button type="submit" class="btn btn-success btn-rounded btn-block">
                                    Selanjutnya <i class="bi bi-chevron-right"></i>
                                </button>
                            </div>
                        </div>
                    ';
                }
            }
        }
    }
?>
<script>
    
</script>
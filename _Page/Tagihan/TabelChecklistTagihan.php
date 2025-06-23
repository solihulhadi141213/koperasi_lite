<?php
    //koneksi dan session
    include "../../_Config/Connection.php";
    include "../../_Config/GlobalFunction.php";
    include "../../_Config/Session.php";
    date_default_timezone_set("Asia/Jakarta");

    //Validasi Sesi Akses
    if(empty($SessionIdAkses)){
        echo '
            <div class="alert alert-danger">
                <small>Sesi Akses Sudah Berakhir! Silahkan Login Ulang!</small>
            </div>
        ';
    }else{
        //Hitung Jumlah Data
        $jml_data = mysqli_num_rows(mysqli_query($Conn, "SELECT id_pinjaman FROM pinjaman WHERE status='Berjalan'"));
        if(empty($jml_data)){
            echo '
                <div class="alert alert-danger">
                    <small>Tidak Ada Data Pinjaman Yang Berjalan</small>
                </div>
            ';
        }else{
?>
            <div class="row mb-3">
                <div class="table table-responsive">
                    <table class="table table-striped table-hover">
                        <thead>
                            <tr>
                                <td align="left"><b>No</b></td>
                                <td align="left"><b>Anggota</b></td>
                                <td align="left"><b>Pinjaman</b></td>
                                <td align="left"><b>Angsuran</b></td>
                                <td align="left"><b>QTY</b></td>
                                <td align="left"><b>Rp Tunggakan</b></td>
                                <td align="left">
                                    <input class="form-check-input" type="checkbox" id="check_all" name="check_all" value="Ya" checked>
                                    <label class="form-check-label" for="check_all">
                                        <b>Pilih</b>
                                    </label>
                                </td>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                                if(empty($jml_data)){
                                    echo '<tr>';
                                    echo '  <td colspan="7" class="text-center">';
                                    echo '      <code class="text-danger">';
                                    echo '          Tidak Ada Data Pinjaman Yang Dapat Ditampilkan';
                                    echo '      </code>';
                                    echo '  </td>';
                                    echo '</tr>';
                                }else{
                                    $no = 1;
                                    //Tampilkan Data
                                    $query = mysqli_query($Conn, "SELECT*FROM pinjaman WHERE status='Berjalan' ORDER BY id_pinjaman DESC");
                                    while ($data = mysqli_fetch_array($query)) {
                                        $id_pinjaman= $data['id_pinjaman'];
                                        $uuid_pinjaman= $data['uuid_pinjaman'];
                                        $id_anggota= $data['id_anggota'];
                                        $nama= $data['nama'];
                                        $nip= $data['nip'];
                                        $lembaga= $data['lembaga'];
                                        $ranking= $data['ranking'];
                                        $tanggal= $data['tanggal'];
                                        $jatuh_tempo= $data['jatuh_tempo'];
                                        $jumlah_pinjaman= $data['jumlah_pinjaman'];
                                        $periode_angsuran= $data['periode_angsuran'];
                                        $angsuran_total= $data['angsuran_total'];
                                        $status= $data['status'];
                                        if($status=="Berjalan"){
                                            $LabelStatus='<span class="badge badge-info">Berjalan</span>';
                                        }else{
                                            if($status=="Lunas"){
                                                $LabelStatus='<span class="badge badge-success">Lunas</span>';
                                            }else{
                                                if($status=="Macet"){
                                                    $LabelStatus='<span class="badge badge-danger">Macet</span>';
                                                }else{
                                                    $LabelStatus='<span class="badge badge-dark">None</span>';
                                                }
                                            }
                                        }
                                        //Format tanggal
                                        $strtotime=strtotime($tanggal);
                                        $TanggalFormat=date('d/m/Y',$strtotime);
                                        //Format Rupiah
                                        $jumlah_pinjaman_format = "" . number_format($jumlah_pinjaman,0,',','.');
                                        $angsuran_total_format = "" . number_format($angsuran_total,0,',','.');
                                        //Tanggal Sekarang
                                        $TanggalSekarang=date('Y-m-d');
                                        //Simulasi Pinjaman
                                        $JumlahPeriodeTagihan=0;
                                        $JumlahTunggakan=0;
                                        for ( $i=1; $i<=$periode_angsuran; $i++ ){
                                            $GetPeriodePinjaman=date('d/m/Y', strtotime('+'.$i.' month', strtotime($tanggal))); 
                                            //Ubah Format Tangga
                                            $GetPeriodePinjaman2=date('Y-m-d', strtotime('+'.$i.' month', strtotime($tanggal))); 
                                            if($TanggalSekarang>$GetPeriodePinjaman2){
                                                //Cek Apakah Sudah Ada Angsuran
                                                $QryAngsuran = mysqli_query($Conn,"SELECT id_pinjaman_angsuran FROM pinjaman_angsuran WHERE id_pinjaman='$id_pinjaman' AND tanggal_angsuran='$GetPeriodePinjaman2'")or die(mysqli_error($Conn));
                                                $DataAngsuran = mysqli_fetch_array($QryAngsuran);
                                                if(empty($DataAngsuran['id_pinjaman_angsuran'])){
                                                    $JumlahPeriodeTagihan=$JumlahPeriodeTagihan+1;
                                                    $JumlahTunggakan=$JumlahTunggakan+$angsuran_total;
                                                }else{
                                                    $JumlahPeriodeTagihan=$JumlahPeriodeTagihan+0;
                                                    $JumlahTunggakan=$JumlahTunggakan+0;
                                                }
                                            }else{
                                                $JumlahPeriodeTagihan=$JumlahPeriodeTagihan+0;
                                                $JumlahTunggakan=$JumlahTunggakan+0;
                                            }
                                        }
                                        $JumlahTunggakanFormat = "" . number_format($JumlahTunggakan,0,',','.');
                                        if(!empty($JumlahTunggakan)){

                            ?>
                                        <tr>
                                            <td align="left"><small><?php echo "$no"; ?></small></td>
                                            <td align="left"><small><?php echo "$nama"; ?></small></td>
                                            <td align="left"><small><?php echo "$jumlah_pinjaman_format"; ?></small></td>
                                            <td align="left"><small><?php echo "$angsuran_total_format"; ?></small></td>
                                            <td align="left"><small><?php echo "$JumlahPeriodeTagihan"; ?></small></td>
                                            <td align="left"><small><?php echo "$JumlahTunggakanFormat"; ?></small></td>
                                            <td align="left">
                                                <div class="form-check">
                                                    <input class="form-check-input" type="checkbox" id="pilih" name="id_pinjaman[]" value="<?php echo "$id_pinjaman-$JumlahTunggakan"; ?>" checked>
                                                </div>
                                            </td>
                                        
                                        </tr>
                            <?php
                                        $no++; 
                                        }
                                    }
                                    echo '
                                        <tr>
                                            <td colspan="5">
                                                <b>JUMLAH TAGIHAN</b>
                                            </td>
                                            <td id="put_jumlah_tagihan" colspan="2"></td>
                                        </tr>
                                    ';
                                }
                            ?>
                        </tbody>
                    </table>
                </div>
            </div>
            <script>
                $(document).ready(function () {
                    function hitungTotalTagihan() {
                        var ProssesBayarTagihanAngsuran = $('#ProssesBayarTagihanAngsuran').serialize();
                        $.ajax({
                            type: 'POST',
                            url: '_Page/Tagihan/ProsesHitungJumlahTagihan.php',
                            data: ProssesBayarTagihanAngsuran,
                            success: function(data) {
                                $('#put_jumlah_tagihan').html(data);
                            }
                        });
                    }

                    // Hitung ulang saat checkbox berubah
                    $("input[name='id_pinjaman[]']").on("change", function () {
                        hitungTotalTagihan();
                        
                        // Cek apakah semua checkbox dicentang atau tidak
                        let totalCheckbox = $("input[name='id_pinjaman[]']").length;
                        let checkedCheckbox = $("input[name='id_pinjaman[]']:checked").length;
                        
                        $("#check_all").prop("checked", totalCheckbox === checkedCheckbox);
                    });

                    // Toggle semua checkbox
                    $("#check_all").on("change", function () {
                        let isChecked = $(this).prop("checked");
                        $("input[name='id_pinjaman[]']").prop("checked", isChecked);
                        hitungTotalTagihan();
                    });

                    // Hitung total tagihan saat halaman dimuat
                    hitungTotalTagihan();
                });
            </script>
<?php
        }
    }
?>
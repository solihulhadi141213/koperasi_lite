<?php
    //Koneksi
    date_default_timezone_set('Asia/Jakarta');
    include "../../_Config/Connection.php";
    include "../../_Config/GlobalFunction.php";
    include "../../_Config/SettingGeneral.php";
    include "../../_Config/Session.php";
    include '../../vendor/autoload.php';
    if(empty($SessionIdAkses)){
        echo '<div class="row">';
        echo '  <div class="col-md-12 mb-3 text-center">';
        echo '      <small class="text-danger">Sesi Akses Sudah Berakhir, Silahkan Login Ulang</small>';
        echo '  </div>';
        echo '</div>';
    }else{
        if(empty($_POST['tahun'])){
            $tahun="";
        }else{
            $tahun=$_POST['tahun'];
        }
?>

    <div class="row mb-3">
        <div class="col-md-12 text-center">
            <?php
                if(empty($tahun)){
                    echo '
                        <b>REKAPITULASI PINJAMAN ANGGOTA</b><br>
                        SEMUA PERIODE
                    ';
                }else{
                    echo '
                        <b>REKAPITULASI PINJAMAN ANGGOTA</b><br>
                        PERIODE TAHUN '.$tahun.'
                    ';
                }
            ?>
        </div>
    </div>
    <div class="row mb-3">
        <div class="col-md-12 text-center">
            <button type="button" class="btn btn-sm btn-outline-secondary btn-rounded" data-bs-toggle="modal" data-bs-target="#ModalCetakRekapPinjamanAnggota">
                <i class="bi bi-printer"></i> Cetak/Export
            </button>
        </div>
    </div>
    <div class="row mb-3">
        <div class="col-md-12">
            <div class="table table-responsive">
                <table class="table table-hover table-striped table-bordered">
                    <thead>
                        <tr>
                            <th><b>No</b></th>
                            <th><b>Tanggal</b></th>
                            <th><b>Anggota</b></th>
                            <th><b>Jenis Pinjaman</b></th>
                            <th><b>Pinjaman</b></th>
                            <th><b>Pinjaman + Jasa</b></th>
                            <th><b>Angsuran</b></th>
                            <th><b>Lama Angsuran</b></th>
                            <th><b>Sudah Bayar</b></th>
                            <th><b>Jumlah Bayar (Rp)</b></th>
                            <th><b>Sisa Pinjaman</b></th>
                            <th><b>Sisa Pinjaman (Rp)</b></th>
                            <th><b>Status</b></th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                            $jml_data = mysqli_num_rows(mysqli_query($Conn, "SELECT*FROM pinjaman WHERE tanggal like '%$tahun%'"));
                            if(empty($jml_data)){
                                echo '
                                    <tr>
                                        <td colspan="13" class="text-center">
                                            <span class="text-danger">Belum Ada Data Pinjaman Yang Ditampilkan</span>
                                        </td>
                                    </tr>
                                ';
                            }else{
                                $no = 1;
                                $query = mysqli_query($Conn, "SELECT*FROM pinjaman WHERE tanggal like '%$tahun%' ORDER BY id_pinjaman ASC");
                                while ($data = mysqli_fetch_array($query)) {
                                    $id_pinjaman= $data['id_pinjaman'];
                                    $uuid_pinjaman= $data['uuid_pinjaman'];
                                    $id_anggota= $data['id_anggota'];
                                    $id_pinjaman_jenis= $data['id_pinjaman_jenis'];
                                    $nama= $data['nama'];
                                    $nip= $data['nip'];
                                    $lembaga= $data['lembaga'];
                                    $ranking= $data['ranking'];
                                    $tanggal= $data['tanggal'];
                                    $jatuh_tempo= $data['jatuh_tempo'];
                                    $jumlah_pinjaman= $data['jumlah_pinjaman'];
                                    $rp_jasa= $data['rp_jasa'];
                                    $status= $data['status'];
                                    $periode_angsuran= $data['periode_angsuran'];
                                    $angsuran_total= $data['angsuran_total'];

                                    //Format tanggal
                                    $strtotime=strtotime($tanggal);
                                    $TanggalFormat=date('d/m/Y',$strtotime);
                                    
                                    //Format Jumlah Pinjaman Rupiah
                                    $jumlah_pinjaman_format = "" . number_format($jumlah_pinjaman,0,',','.');

                                    //Format Rp Jasa
                                    $estimasi_jumlah_jasa=$rp_jasa*$periode_angsuran;
                                    $jumlah_pinjaman_jasa=$jumlah_pinjaman+$estimasi_jumlah_jasa;
                                    $jumlah_pinjaman_jasa_format = "" . number_format($jumlah_pinjaman_jasa,0,',','.');
                                    
                                    
                                    //Sum Data Angsuran
                                    $Sum = mysqli_fetch_array(mysqli_query($Conn, "SELECT SUM(jumlah) AS total FROM pinjaman_angsuran WHERE id_pinjaman='$id_pinjaman'"));
                                    $JumlahAngsuran = $Sum['total'];
                                    $JumlahAngsuranFormat = "" . number_format($JumlahAngsuran,0,',','.');
                                    
                                    //Row Data Angsuran
                                    $JumlahDataAngsuran = mysqli_num_rows(mysqli_query($Conn, "SELECT id_pinjaman_angsuran FROM pinjaman_angsuran WHERE id_pinjaman='$id_pinjaman'"));
                                    if(empty($JumlahDataAngsuran)){
                                        $LabelAngsuran='<code class="text text-danger">0 Record</code>';
                                    }else{
                                        $LabelAngsuran='<code class="text text-grayish">'.$JumlahDataAngsuran.' Record</code>';
                                    }

                                    //Hiutng Sisa Periode Angsuran
                                    $sisa_pinjaman=$periode_angsuran-$JumlahDataAngsuran;

                                    //Hiutng Sisa Pinjaman
                                    $sisa_pinjaman_rp=$jumlah_pinjaman_jasa-$JumlahAngsuran;
                                    $sisa_pinjaman_rp_format = "" . number_format($sisa_pinjaman_rp,0,',','.');
                                    //Buka Jenis Pinjaman
                                    if(empty($id_pinjaman_jenis)){
                                        $nama_jenis_pinjaman='<span class="text text-muted">NONE</span>';
                                    }else{
                                        $nama_jenis_pinjaman=GetDetailData($Conn, 'pinjaman_jenis', 'id_pinjaman_jenis', $id_pinjaman_jenis, 'nama_pinjaman');
                                    }
                                    //Format Angsuran Total
                                    $angsuran_total = "" . number_format($angsuran_total,0,',','.');
                                    echo '
                                        <tr>
                                            <td><small>'.$no.'</small></td>
                                            <td><small>'.$TanggalFormat.'</small></td>
                                            <td><small>'.$nama.'</small></td>
                                            <td><small>'.$nama_jenis_pinjaman.'</small></td>
                                            <td><small>'.$jumlah_pinjaman_format.'</small></td>
                                            <td><small>'.$jumlah_pinjaman_jasa_format.'</small></td>
                                            <td><small>'.$angsuran_total.'</small></td>
                                            <td><small>'.$periode_angsuran.'</small></td>
                                            <td><small>'.$JumlahDataAngsuran.'</small></td>
                                            <td><small>'.$JumlahAngsuranFormat.'</small></td>
                                            <td><small>'.$sisa_pinjaman.'</small></td>
                                            <td><small>'.$sisa_pinjaman_rp_format.'</small></td>
                                            <td><small>'.$status.'</small></td>
                                        </tr>
                                    ';

                                    $no++;
                                }
                            }
                        ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
<?php 
    }
?>
<?php
    //Koneksi
    date_default_timezone_set('Asia/Jakarta');
    include "../../_Config/Connection.php";
    include "../../_Config/GlobalFunction.php";
    include "../../_Config/SettingGeneral.php";
    include "../../_Config/Session.php";
    if(empty($SessionIdAkses)){
        echo '<div class="row">';
        echo '  <div class="col-md-12 mb-3 text-center">';
        echo '      <small class="text-danger">Sesi Akses Sudah Berakhir, Silahkan Login Ulang</small>';
        echo '  </div>';
        echo '</div>';
    }else{
        $jml_data = mysqli_num_rows(mysqli_query($Conn, "SELECT*FROM pinjaman WHERE status='Berjalan'"));
        $jumlah_nunggak=0;
        //KONDISI PENGATURAN MASING FILTER
        $query = mysqli_query($Conn, "SELECT*FROM pinjaman WHERE status='Berjalan'");
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
            //Format tanggal
            $strtotime=strtotime($tanggal);
            $TanggalFormat=date('d/m/Y',$strtotime);
            //Format Rupiah
            $jumlah_pinjaman_format = "Rp " . number_format($jumlah_pinjaman,0,',','.');
            //Cek Apakah Sudah Sinkron Dengan Jurnal
            $JumlahJurnal = mysqli_num_rows(mysqli_query($Conn, "SELECT*FROM jurnal WHERE kategori='Pinjaman' AND uuid='$uuid_pinjaman'"));
            if(empty($JumlahJurnal)){
                $LabelJurnal='<code class="text text-danger">Jurnal : 0 Rcd</code>';
            }else{
                $LabelJurnal='<code class="text text-grayish">Jurnal : '.$JumlahJurnal.' Rcd</code>';
            }
            //Tanggal Sekarang
            $TanggalSekarang=date('Y-m-d');
            //Simulasi Pinjaman
            $JumlahPinjamanNunggak=0;
            $JumlahTunggakan=0;
            $JumlahPeriodeTagihan=0;
            for ( $i=1; $i<=$periode_angsuran; $i++ ){
                $GetPeriodePinjaman=date('d/m/Y', strtotime('+'.$i.' month', strtotime($tanggal))); 
                //Ubah Format Tangga
                $GetPeriodePinjaman2=date('Y-m-d', strtotime('+'.$i.' month', strtotime($tanggal))); 
                if($TanggalSekarang>$GetPeriodePinjaman2){
                    //Cek Apakah Sudah Ada Angsuran
                    $QryAngsuran = mysqli_query($Conn,"SELECT * FROM pinjaman_angsuran WHERE id_pinjaman='$id_pinjaman' AND tanggal_angsuran='$GetPeriodePinjaman2'")or die(mysqli_error($Conn));
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
            $JumlahTunggakanFormat = "Rp " . number_format($JumlahTunggakan,0,',','.');
            if(empty($JumlahPeriodeTagihan)){
                $jumlah_nunggak=$jumlah_nunggak+0;
            }else{
                $jumlah_nunggak=$jumlah_nunggak+1;
            }
        }
?>
            <div class="row mb-2">
                <div class="col-12">
                    <b># Informasi Data</b>
                </div>
            </div>
            <div class="row mb-2">
                <div class="col-6"><small>Tipe Data</small></div>
                <div class="col-6">
                    <code class="text text-grayish">Excel (.xlsx)</code>
                </div>
            </div>
            <div class="row mb-2">
                <div class="col-6"><small>Jumlah Pinjaman</small></div>
                <div class="col-6">
                    <code class="text text-grayish"><?php echo "$jml_data Record"; ?></code>
                </div>
            </div>
            <div class="row mb-4">
                <div class="col-6"><small>Tunggakan Pinjaman</small></div>
                <div class="col-6">
                    <code class="text text-grayish"><?php echo "$jumlah_nunggak Record"; ?></code>
                </div>
            </div>
            <div class="row mb-2">
                <div class="col col-md-12">
                    <div class="form-check">
                        <input class="form-check-input" type="checkbox" id="sertakan_denda" name="sertakan_denda" value="Ya" >
                        <label class="form-check-label" for="sertakan_denda">
                            <small>Sertakan kolom denda</small>
                        </label>
                    </div>
                </div>
            </div>
            <div class="row mb-3">
                <div class="col col-md-12">
                    <small class="text text-dark">
                        Apakah anda yakin akan mengeksport data tagihan tersebut?
                    </small>
                </div>
            </div>
<?php
    }
?>
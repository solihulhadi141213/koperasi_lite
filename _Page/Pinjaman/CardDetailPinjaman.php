<?php
    //Koneksi
    date_default_timezone_set('Asia/Jakarta');
    include "../../_Config/Connection.php";
    include "../../_Config/GlobalFunction.php";
    include "../../_Config/SettingGeneral.php";
    include "../../_Config/Session.php";
    if(empty($SessionIdAkses)){
        echo '
            <div class="alert alert-danger">
                Sesi Aksess Sudah Berakhir! Silahkan Login Ulang.
            </div>
        ';
    }else{
        if(empty($_POST['id_pinjaman'])){
            echo '
                <div class="alert alert-danger">
                    ID Pinjaman Tidak Boleh Kosong!
                </div>
            ';
        }else{
            $id_pinjaman=$_POST['id_pinjaman'];

            //Buka Detail Pinjaman
            $Qry = $Conn->prepare("SELECT * FROM pinjaman WHERE id_pinjaman = ?");
            $Qry->bind_param("s", $id_pinjaman);
            if (!$Qry->execute()) {
                $error=$Conn->error;
                $response = [
                    "status" => "Error",
                    "message" => $error
                ];
                echo '
                    <div class="alert alert-danger">
                        Terjadi Kesalahan pada saat membuka data pinjaman!<br>
                        Error : '.$error.'
                    </div>
                ';
            }else{
                $Result = $Qry->get_result();
                $Data = $Result->fetch_assoc();
                $Qry->close();
                //Buat Variabel
                $id_anggota=$Data['id_anggota'];
                $uuid_pinjaman=$Data['uuid_pinjaman'];
                $nip=$Data['nip'];
                $nama=$Data['nama'];
                $lembaga=$Data['lembaga'];
                $ranking=$Data['ranking'];
                $tanggal=$Data['tanggal'];
                $jatuh_tempo=$Data['jatuh_tempo'];
                $denda=$Data['denda'];
                $sistem_denda=$Data['sistem_denda'];
                $jumlah_pinjaman=$Data['jumlah_pinjaman'];
                $persen_jasa=$Data['persen_jasa'];
                $rp_jasa=$Data['rp_jasa'];
                $angsuran_pokok=$Data['angsuran_pokok'];
                $angsuran_total=$Data['angsuran_total'];
                $periode_angsuran=$Data['periode_angsuran'];
                $status=$Data['status'];

                //Format tanggal
                $strtotime=strtotime($tanggal);
                $TanggalFormat=date('d/m/Y',$strtotime);
                //Format Rupiah
                $denda_format = "Rp " . number_format($denda,0,',','.');
                $jumlah_pinjaman_format = "Rp " . number_format($jumlah_pinjaman,0,',','.');
                $rp_jasa_format = "Rp " . number_format($rp_jasa,0,',','.');
                $angsuran_pokok_format = "Rp " . number_format($angsuran_pokok,0,',','.');
                $angsuran_total_format = "Rp " . number_format($angsuran_total,0,',','.');
                //Cek Apakah Sudah Sinkron Dengan Jurnal
                $JumlahJurnal = mysqli_num_rows(mysqli_query($Conn, "SELECT*FROM jurnal WHERE kategori='Pinjaman' AND uuid='$uuid_pinjaman'"));
                if(empty($JumlahJurnal)){
                    $LabelJurnal='<code class="text text-danger">Jurnal : 0 Rcd</code>';
                }else{
                    $LabelJurnal='<code class="text text-grayish">Jurnal : '.$JumlahJurnal.' Rcd</code>';
                }
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
?>
            <div class="row mb-3">
                <div class="col-md-6">
                    <div class="row mb-3">
                        <div class="col col-md-4">Tanggal Pinjaman</div>
                        <div class="col col-md-8">
                            <code class="text text-grayish"><?php echo $TanggalFormat; ?></code>
                        </div>
                    </div>
                    <div class="row mb-3">
                        <div class="col col-md-4">NIP</div>
                        <div class="col col-md-8">
                            <code class="text text-grayish"><?php echo $nip; ?></code>
                        </div>
                    </div>
                    <div class="row mb-3">
                        <div class="col col-md-4">Nama</div>
                        <div class="col col-md-8">
                            <code class="text text-grayish"><?php echo $nama; ?></code>
                        </div>
                    </div>
                    <div class="row mb-3">
                        <div class="col col-md-4">Lembaga</div>
                        <div class="col col-md-8">
                            <code class="text text-grayish"><?php echo $lembaga; ?></code>
                        </div>
                    </div>
                    <div class="row mb-3">
                        <div class="col col-md-4">Ranking</div>
                        <div class="col col-md-8">
                            <code class="text text-grayish"><?php echo $ranking; ?></code>
                        </div>
                    </div>
                    <div class="row mb-3">
                        <div class="col col-md-4">Jatuh Tempo</div>
                        <div class="col col-md-8">
                            <code class="text text-grayish"><?php echo "Tanggal $jatuh_tempo"; ?></code>
                        </div>
                    </div>
                    <div class="row mb-3">
                        <div class="col col-md-4">Denda</div>
                        <div class="col col-md-8">
                            <code class="text text-grayish"><?php echo "$denda_format ($sistem_denda)"; ?></code>
                        </div>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="row mb-3">
                        <div class="col col-md-4">Jumlah Pinjaman</div>
                        <div class="col col-md-8">
                            <code class="text text-grayish"><?php echo $jumlah_pinjaman_format; ?></code>
                        </div>
                    </div>
                    <div class="row mb-3">
                        <div class="col col-md-4">Periode Angsuran</div>
                        <div class="col col-md-8">
                            <code class="text text-grayish"><?php echo "$periode_angsuran Kali"; ?></code>
                        </div>
                    </div>
                    <div class="row mb-3">
                        <div class="col col-md-4">% Jasa</div>
                        <div class="col col-md-8">
                            <code class="text text-grayish"><?php echo "$persen_jasa %"; ?></code>
                        </div>
                    </div>
                    <div class="row mb-3">
                        <div class="col col-md-4">Rp Jasa</div>
                        <div class="col col-md-8">
                            <code class="text text-grayish"><?php echo "$rp_jasa_format"; ?></code>
                        </div>
                    </div>
                    <div class="row mb-3">
                        <div class="col col-md-4">Angsuran Pokok</div>
                        <div class="col col-md-8">
                            <code class="text text-grayish"><?php echo "$angsuran_pokok_format"; ?></code>
                        </div>
                    </div>
                    <div class="row mb-3">
                        <div class="col col-md-4">Angsuran + Jasa</div>
                        <div class="col col-md-8">
                            <code class="text text-grayish"><?php echo "$angsuran_total_format"; ?></code>
                        </div>
                    </div>
                    <div class="row mb-3">
                        <div class="col col-md-4">Status</div>
                        <div class="col col-md-8">
                            <code class="text text-grayish"><?php echo "$LabelStatus"; ?></code>
                        </div>
                    </div>
                </div>
            </div>
<?php
            }   
        }
    }
?>
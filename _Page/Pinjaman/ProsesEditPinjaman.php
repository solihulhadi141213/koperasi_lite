<?php
    //Koneksi
    include "../../_Config/Connection.php";
    include "../../_Config/GlobalFunction.php";
    include "../../_Config/Session.php";
    //Menangkap data wilayah
    if(empty($_POST['id_pinjaman'])){
        echo '<code class="text-danger">ID Pinjaman Tidak Boleh Kosong!!</code>';
    }else{
        if(empty($_POST['tanggal'])){
            echo '<code class="text-danger">Tanggal Pinjaman Tidak Boleh Kosong!!</code>';
        }else{
            if(empty($_POST['jatuh_tempo'])){
                echo '<code class="text-danger">Tanggal Jatuh Tempo Tidak Boleh Kosong!!</code>';
            }else{
                if(empty($_POST['jumlah_pinjaman'])){
                    echo '<code class="text-danger">Jumlah Pinjaman Tidak Boleh Kosong!!</code>';
                }else{
                    if(empty($_POST['angsuran_pokok'])){
                        echo '<code class="text-danger">Nilai Angsuran Pokok Tidak Boleh Kosong!!</code>';
                    }else{
                        if(empty($_POST['periode_angsuran'])){
                            echo '<code class="text-danger">Periode Angsuran Tidak Boleh Kosong!!</code>';
                        }else{
                            $id_pinjaman=$_POST['id_pinjaman'];
                            $tanggal=$_POST['tanggal'];
                            $jatuh_tempo=$_POST['jatuh_tempo'];
                            $tanggal_input=date('Y-m-d H:i');
                            $jumlah_pinjaman=$_POST['jumlah_pinjaman'];
                            $angsuran_pokok=$_POST['angsuran_pokok'];
                            $periode_angsuran=$_POST['periode_angsuran'];
                            if(empty($_POST['persen_jasa'])){
                                $persen_jasa="0";
                            }else{
                                $persen_jasa=$_POST['persen_jasa'];
                            }
                            if(empty($_POST['rp_jasa'])){
                                $rp_jasa="0";
                            }else{
                                $rp_jasa=$_POST['rp_jasa'];
                            }
                            if(empty($_POST['angsuran_total'])){
                                $angsuran_total="0";
                            }else{
                                $angsuran_total=$_POST['angsuran_total'];
                            }
                            if(empty($_POST['denda'])){
                                $denda="0";
                            }else{
                                $denda=$_POST['denda'];
                            }
                            if(empty($_POST['sistem_denda'])){
                                $sistem_denda="Harian";
                            }else{
                                $sistem_denda=$_POST['sistem_denda'];
                            }
                            $jumlah_pinjaman= str_replace(",", "", $jumlah_pinjaman);
                            $angsuran_pokok= str_replace(",", "", $angsuran_pokok);
                            $periode_angsuran= str_replace(",", "", $periode_angsuran);
                            $rp_jasa= str_replace(",", "", $rp_jasa);
                            $angsuran_total= str_replace(",", "", $angsuran_total);
                            $denda= str_replace(",", "", $denda);
                            if(!preg_match("/^[0-9]*$/", $jumlah_pinjaman)){
                                echo '<code class="text-danger">Jumlah Pinjaman Hanya Boleh Angka</code>'; 
                            }else{
                                if(!preg_match("/^[0-9]*$/", $angsuran_pokok)){
                                    echo '<code class="text-danger">Nilai Angsuran Hanya Boleh Angka</code>'; 
                                }else{
                                    if(!preg_match("/^[0-9]*$/", $periode_angsuran)){
                                        echo '<code class="text-danger">Periode Angsuran Hanya Boleh Angka</code>'; 
                                    }else{
                                        $pattern = '/^\d+(\.\d+)?$/';
                                        if(!preg_match($pattern, $persen_jasa)) {
                                            echo '<code class="text-danger">Persen Jasa Hanya Boleh Angka</code>'; 
                                        }else{
                                            if(!preg_match("/^[0-9]*$/", $rp_jasa)){
                                                echo '<code class="text-danger">Estimasi Jasa Hanya Boleh Angka</code>'; 
                                            }else{
                                                if(!preg_match("/^[0-9]*$/", $angsuran_total)){
                                                    echo '<code class="text-danger">Jumlah angsuran Hanya Boleh Angka</code>'; 
                                                }else{
                                                    if(!preg_match("/^[0-9]*$/", $denda)){
                                                        echo '<code class="text-danger">Nominal Denda Hanya Boleh Angka</code>'; 
                                                    }else{
                                                        //Bersihkan Variabel
                                                        $id_pinjaman=validateAndSanitizeInput($id_pinjaman);
                                                        $tanggal=validateAndSanitizeInput($tanggal);
                                                        $jatuh_tempo=validateAndSanitizeInput($jatuh_tempo);
                                                        $jumlah_pinjaman=validateAndSanitizeInput($jumlah_pinjaman);
                                                        $angsuran_pokok=validateAndSanitizeInput($angsuran_pokok);
                                                        $periode_angsuran=validateAndSanitizeInput($periode_angsuran);
                                                        $persen_jasa=validateAndSanitizeInput($persen_jasa);
                                                        $rp_jasa=validateAndSanitizeInput($rp_jasa);
                                                        $angsuran_total=validateAndSanitizeInput($angsuran_total);
                                                        $denda=validateAndSanitizeInput($denda);
                                                        $sistem_denda=validateAndSanitizeInput($sistem_denda);
                                                        //Buka UUID
                                                        $uuid_pinjaman=GetDetailData($Conn,'pinjaman','id_pinjaman',$id_pinjaman,'uuid_pinjaman');
                                                        //Melakukan input data
                                                        $UpdatePinjaman = mysqli_query($Conn,"UPDATE pinjaman SET 
                                                            tanggal='$tanggal',
                                                            jatuh_tempo='$jatuh_tempo',
                                                            denda='$denda',
                                                            sistem_denda='$sistem_denda',
                                                            jumlah_pinjaman='$jumlah_pinjaman',
                                                            persen_jasa='$persen_jasa',
                                                            rp_jasa='$rp_jasa',
                                                            angsuran_pokok='$angsuran_pokok',
                                                            angsuran_total='$angsuran_total',
                                                            periode_angsuran='$periode_angsuran'
                                                        WHERE id_pinjaman='$id_pinjaman'") or die(mysqli_error($Conn)); 
                                                        if($UpdatePinjaman){
                                                            $UpdateJurnal = mysqli_query($Conn,"UPDATE jurnal SET 
                                                                tanggal='$tanggal',
                                                                nilai='$jumlah_pinjaman'
                                                            WHERE uuid='$uuid_pinjaman' AND kategori='Pinjaman'") or die(mysqli_error($Conn)); 
                                                            if($UpdateJurnal){
                                                                $KategoriLog="Pinjaman";
                                                                $KeteranganLog="Edit Pinjaman Berhasil    ";
                                                                include "../../_Config/InputLog.php";
                                                                echo '<div class="text-success" id="NotifikasiEditPinjamanBerhasil">Success</div>';
                                                            }else{
                                                                echo '<div class="text-danger">Terjadi kesalahan pada saat update data jurnal.</div>';
                                                            }
                                                        }else{
                                                            echo '<code class="text-danger">Terjadi kesalahan pada saat update simpanan.</code>';
                                                        }
                                                    }
                                                }
                                            }
                                        }
                                    }
                                }
                            }
                        }
                    }
                }
            }
        }
    }
?>
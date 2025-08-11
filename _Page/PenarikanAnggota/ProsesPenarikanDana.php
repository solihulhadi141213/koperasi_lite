<?php
    //koneksi
    include "../../_Config/Connection.php";
    include "../../_Config/GlobalFunction.php";

    //Session
    include "../../_Config/Session.php";

    //Validasi id_simpanan_jenis tidak boleh kosong
    if(empty($SessionIdAkses)){
        echo '
            <div class="alert alert-danger">
                Sesi Akses Sudah Berakhir, Silahkan Login Ulang!
            </div>
        ';
    }else{
        //Validasi id_simpanan_jenis tidak boleh kosong
        if(empty($_POST['id_simpanan_jenis'])){
            echo '
                <div class="alert alert-danger">
                    Jenis Simpanan Tidak Boleh Kosong!
                </div>
            ';
        }else{
            if(empty($_POST['nominal'])){
                echo '
                    <div class="alert alert-danger">
                        Nominal Penarikan Tidak Boleh Kosong!
                    </div>
                ';
            }else{
                if(empty($_POST['bank'])){
                    echo '
                        <div class="alert alert-danger">
                            Nama Bank Tidak Boleh Kosong!
                        </div>
                    ';
                }else{
                    if(empty($_POST['norek'])){
                        echo '
                            <div class="alert alert-danger">
                                Nomor Rekening Tidak Boleh Kosong!
                            </div>
                        ';
                    }else{

                        //Buat Variabel
                        $id_simpanan_jenis=$_POST['id_simpanan_jenis'];
                        $bank=$_POST['bank'];
                        $rekening=$_POST['norek'];
                        $status="Pending";
                        $nominal_penarikan = str_replace('.', '', $_POST['nominal']);
                        //Validasi nominal_penarikan hanya boleh angka
                        if(!preg_match("/^[0-9]*$/", $nominal_penarikan)){
                            echo '
                                <div class="alert alert-danger">
                                    Nominal Penarikan Hanya Boleh Angka!
                                </div>
                            ';
                        }else{
                            //Hitung Saldo
                            //Hitung Saldo Kotor
                            $SumSimpananKotor = mysqli_fetch_array(mysqli_query($Conn, "SELECT SUM(jumlah) AS jumlah FROM simpanan WHERE id_simpanan_jenis='$id_simpanan_jenis' AND id_anggota='$SessionIdAkses' AND status='Lunas'"));
                            $JumlahSimpananKotor = $SumSimpananKotor['jumlah'];

                            //Saldo Penarikan Lunas
                            $SumPenarikanLunas = mysqli_fetch_array(mysqli_query($Conn, "SELECT SUM(nominal) AS nominal FROM simpanan_penarikan  WHERE id_simpanan_jenis='$id_simpanan_jenis' AND id_anggota='$SessionIdAkses' AND status='Lunas'"));
                            $JumlahPenarikanLunas = $SumPenarikanLunas['nominal'];

                            //Hitung Jumlah Simpanan Bersih
                            $JumlahSimpananBersih=$JumlahSimpananKotor-$JumlahPenarikanLunas;

                            //Jumlah Penarikan Tidak Lebih Dari Saldo
                            if($nominal_penarikan>$JumlahSimpananBersih){
                                echo '
                                    <div class="alert alert-danger">
                                        Nominal Penarikan Melebihi Jumlah Saldo!
                                    </div>
                                ';
                            }else{
                                //Simpan Data
                                $tanggal=date('Y-m-d');
                                $status="Pending";
                                $EntryPenarikan="INSERT INTO simpanan_penarikan (
                                    id_simpanan_jenis,
                                    id_anggota,
                                    tanggal,
                                    bank,
                                    rekening,
                                    nominal,
                                    status
                                ) VALUES (
                                    '$id_simpanan_jenis',
                                    '$SessionIdAkses',
                                    '$tanggal',
                                    '$bank',
                                    '$rekening',
                                    '$nominal_penarikan',
                                    '$status'
                                )";
                                $InputPenarikan=mysqli_query($Conn, $EntryPenarikan);
                                if($InputPenarikan){
                                    $_SESSION["NotifikasiSwal"] = "Pengajuan Penarikan Dana Berhasil Dikirim";
                                    echo '
                                        <div class="alert alert-success">
                                            <span id="NotifikasiPenarikanDanaBerhasil">Success</span>
                                        </div>
                                    ';                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                    
                                }else{
                                    echo '
                                        <div class="alert alert-danger">
                                            Terjadi Kesalahan Pada Saat Menyimpan Data Pengajuan Penarikan
                                        </div>
                                    ';
                                }
                            }
                        }
                    }
                }
            }
        }
    }
?>
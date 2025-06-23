<?php
    date_default_timezone_set('Asia/Jakarta');
    include "../../_Config/Connection.php";
    include "../../_Config/GlobalFunction.php";
    include "../../_Config/Session.php";

    //Validasi Akses
    if(empty($SessionIdAkses)){
        echo '
            <div class="alert alert-danger">
                <small>Sesi Akses Sudah Berakhir! Silahkan Login Ulang!</small>
            </div>
        ';
    }else{
        if(empty($_POST['id_akses_fitur'])){
            echo '
                <div class="alert alert-danger">
                    <small>ID Fitur Tidak Boleh Kosong!</small>
                </div>
            ';
        }else{
            $id_akses_fitur = validateAndSanitizeInput($_POST['id_akses_fitur']);

            //Buka Data
            $Qry = $Conn->prepare("SELECT * FROM akses_fitur WHERE id_akses_fitur = ?");
            $Qry->bind_param("i", $id_akses_fitur);
            if (!$Qry->execute()) {
                $error=$Conn->error;
                echo '
                    <div class="alert alert-danger">
                        <small>Terjadi kesalahan pada saat membuka data fitur dari database!<br>Keterangan : '.$error.'</small>
                    </div>
                ';
            }else{
                $Result = $Qry->get_result();
                $Data = $Result->fetch_assoc();
                $Qry->close();

                //Buat Variabel
                $nama=$Data['nama'];
                $kategori=$Data['kategori'];
                $kode=$Data['kode'];
                $keterangan=$Data['keterangan'];

                //Jumlah Akses
                $JumlahPengguna =mysqli_num_rows(mysqli_query($Conn, "SELECT id_akses FROM akses_ijin WHERE id_akses_fitur='$id_akses_fitur'"));
                if(empty($JumlahPengguna)){
                    $label_jumlah_pengguna='<span class="badge badge-danger">NULL</span>';
                }else{
                    $label_jumlah_pengguna='<span class="badge badge-success">'.$JumlahPengguna.' Orang</span>';
                }
                //Tampilkan Data
                echo '
                    <div class="row mb-2">
                        <div class="col-4"><small>Nama Fitur</small></div>
                        <div class="col-1"><small>:</small></div>
                        <div class="col-7"><small class="text text-muted">'.$nama.'</small></div>
                    </div>
                    <div class="row mb-2">
                        <div class="col-4"><small>Kategori</small></div>
                        <div class="col-1"><small>:</small></div>
                        <div class="col-7"><small class="text text-muted">'.$kategori.'</small></div>
                    </div>
                    <div class="row mb-2">
                        <div class="col-4"><small>Kode Fitur</small></div>
                        <div class="col-1"><small>:</small></div>
                        <div class="col-7"><small class="text text-muted">'.$kode.'</small></div>
                    </div>
                    <div class="row mb-2">
                        <div class="col-4"><small>Keterangan</small></div>
                        <div class="col-1"><small>:</small></div>
                        <div class="col-7"><small class="text text-muted">'.$keterangan.'</small></div>
                    </div>
                    <div class="row mb-2">
                        <div class="col-4"><small>Jumlah Akses/User</small></div>
                        <div class="col-1"><small>:</small></div>
                        <div class="col-7"><small class="text text-muted">'.$label_jumlah_pengguna.'</small></div>
                    </div>
                ';
            }
        }
    }
?>

<?php
    //Koneksi
    date_default_timezone_set('Asia/Jakarta');
    include "../../_Config/Connection.php";
    include "../../_Config/GlobalFunction.php";
    include "../../_Config/Session.php";
    //Validasi Akses
    if(empty($SessionIdAkses)){
        echo '  <div class="alert alert-danger text-center">';
        echo '      <small>';
        echo '          Sesi Akses Sudah Berakhir, Silahkan Login Ulang!.';
        echo '      </small>';
        echo '  </div>';
    }else{
        //Hitung Jumlah Data Supplier
        $jml_data = mysqli_num_rows(mysqli_query($Conn, "SELECT id_supplier FROM supplier"));

        //Apabila Tidak Ada Data Yang Di Export
        if(empty($jml_data)){
            echo '
                <div class="alert alert-danger">
                    <small>Tidak Ada Data Supplier Yang Bisa Di Export. Silahkan Tambahkan Data Supplier Terlebih Dulu!</small>
                </div>
            ';
        }else{
            //Menampilkan Form
            echo '
                <div class="row mb-2">
                    <div class="col-4"><small>Jumlah Data</small></div>
                    <div class="col-1"><small>:</small></div>
                    <div class="col-7"><small class="text text-muted">'.$jml_data.'</small></div>
                </div>
                <div class="row mb-2">
                    <div class="col-4"><small>Format Data</small></div>
                    <div class="col-1"><small>:</small></div>
                    <div class="col-7"><small class="text text-muted">Excel</small></div>
                </div>
            ';
            echo '
                <div class="row mb-2">
                    <div class="col-12">
                        <div class="alert alert-warning text-center">
                            <small>Semakin banyak data supplier yang ada maka proses export akan membutuhkan waktu lebih lama.</small>
                        </div>
                    </div>
                </div>
            ';
        }
    }
?>
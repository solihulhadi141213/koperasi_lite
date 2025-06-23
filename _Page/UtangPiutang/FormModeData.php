<?php
    //Tangkap mode_data
    if(!empty($_POST['mode_data'])){
        $mode_data=$_POST['mode_data'];

        //Mode Data Periode
        if($mode_data=="Periode"){
            echo '
                <div class="row mb-3">
                    <div class="col-3">
                        <label for="periode_1">
                            <small>Periode Awal</small>
                        </label>
                    </div>
                    <div class="col-1"><small>:</small></div>
                    <div class="col-8">
                        <input type="date" name="periode_1" id="periode_1" class="form-control">
                    </div>
                </div>
                <div class="row mb-3">
                    <div class="col-3">
                        <label for="periode_2">
                            <small>Periode Akhir</small>
                        </label>
                    </div>
                    <div class="col-1"><small>:</small></div>
                    <div class="col-8">
                        <input type="date" name="periode_2" id="periode_2" class="form-control">
                    </div>
                </div>
            ';
        }else{

            //Mode Data Bulanan
            if($mode_data=="Bulanan"){
                echo '
                    <div class="row mb-3">
                        <div class="col-3">
                            <label for="periode_tahun">
                                <small>Tahun</small>
                            </label>
                        </div>
                        <div class="col-1"><small>:</small></div>
                        <div class="col-8">
                            <input type="number" name="periode_tahun" id="periode_tahun" class="form-control" value="'.date('Y').'">
                        </div>
                    </div>
                ';
                echo '<div class="row mb-3">';
                echo '
                        <div class="col-3">
                            <label for="periode_bulan">
                                <small>Bulan</small>
                            </label>
                        </div>
                ';
                echo '  <div class="col-1"><small>:</small></div>';
                echo '  <div class="col-8">';
                echo '      <select name="periode_bulan" id="periode_bulan" class="form-control">';
                // Array nama-nama bulan
                $nama_bulan = array(
                    '01' => 'Januari',
                    '02' => 'Februari',
                    '03' => 'Maret',
                    '04' => 'April',
                    '05' => 'Mei',
                    '06' => 'Juni',
                    '07' => 'Juli',
                    '08' => 'Agustus',
                    '09' => 'September',
                    '10' => 'Oktober',
                    '11' => 'November',
                    '12' => 'Desember'
                );
                
                // Loop melalui array untuk membuat option
                foreach ($nama_bulan as $kode => $bulan) {
                    echo "<option value='$kode'>$kode - $bulan</option>";
                }
                echo '      </select>';
                echo '  </div>';
                echo '</div>';
            }else{
                 echo '
                    <div class="row mb-3">
                        <div class="col-3">
                            <label for="periode_tanggal">
                                <small>Tanggal</small>
                            </label>
                        </div>
                        <div class="col-1"><small>:</small></div>
                        <div class="col-8">
                            <input type="date" name="periode_tanggal" id="periode_tanggal" class="form-control" value="'.date('Y-m-d').'">
                        </div>
                    </div>
                ';
            }
        }
    }
?>
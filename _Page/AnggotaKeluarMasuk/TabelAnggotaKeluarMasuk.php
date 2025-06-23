<?php
    //koneksi dan session
    include "../../_Config/Connection.php";
    include "../../_Config/GlobalFunction.php";
    include "../../_Config/Session.php";
    //id_anggota
    if(empty($SessionIdAkses)){
        echo '<div class="row">';
        echo '  <div class="col-md-12 text-center text-danger">';
        echo '      Sesi Login Sudah Berakhir, Silahkan Login Ulang!';
        echo '  </div>';
        echo '</div>';
    }else{
        if(empty($_POST['mode'])){
            $mode='Harian';
        }else{
            $mode=$_POST['mode'];
        }
        if(empty($_POST['tahun'])){
            $year=date('Y');
        }else{
            $year=$_POST['tahun'];
        }
        if(empty($_POST['bulan'])){
            $month=date('m');
        }else{
            $month=$_POST['bulan'];
        }
?>
    <!-- <div class="row">
        <div class="col-md-12">
            <small>
                <ul>
                    <li>
                        Mode : <code class="text text-grayish"><?php echo $mode; ?></code>
                    </li>
                    <li>
                        Bulan : <code class="text text-grayish"><?php echo $month; ?></code>
                    </li>
                    <li>
                        Tahun : <code class="text text-grayish"><?php echo $year; ?></code>
                    </li>
                </ul>
            </small>
        </div>
    </div> -->
    <div class="row mb-3">
        <div class="col-md-12">
            <div class="table-responsive">
                <table class="table table-hover table-bordered align-items-center mb-0">
                    <thead class="">
                        <tr>
                            <th class="text-center">
                                <b>No</b>
                            </th>
                            <th class="text-center">
                                <b>Bulan/Tanggal</b>
                            </th>
                            <th class="text-center">
                                <b>Masuk</b>
                            </th>
                            <th class="text-center">
                                <b>Keluar</b>
                            </th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                            //Melakukan Looping Berdasarkan Mode
                            if($mode=="Bulanan"){
                                $no=1;
                                // Array nama-nama bulan
                                $months = [
                                    "01" => "Januari",
                                    "02" => "Februari",
                                    "03" => "Maret",
                                    "04" => "April",
                                    "05" => "Mei",
                                    "06" => "Juni",
                                    "07" => "Juli",
                                    "08" => "Agustus",
                                    "09" => "September",
                                    "10" => "Oktober",
                                    "11" => "November",
                                    "12" => "Desember"
                                ];

                                // Melakukan looping dari bulan 01 hingga 12
                                $JumlahTotalMasuk=0;
                                $JumlahTotalKeluar=0;
                                $no=1;
                                foreach ($months as $number => $name) {
                                    $Tanggal="$year-$number";
                                    //Jumlah Anggtoa Masuk Pada Tanggal Tersebut
                                    $JumlahMasuk=mysqli_num_rows(mysqli_query($Conn, "SELECT id_anggota FROM anggota WHERE tanggal_masuk like '%$Tanggal%'"));
                                    $JumlahKeluar=mysqli_num_rows(mysqli_query($Conn, "SELECT id_anggota FROM anggota WHERE tanggal_keluar like '%$Tanggal%' AND status='Keluar'"));
                                    echo '<tr>';
                                    echo '  <td align="center">'.$no.'</td>';
                                    echo '  <td align="left">'.$name.' '.$year.'</td>';
                                    echo '  <td align="center">';
                                    echo '      <a href="javascript:void(0);" data-bs-toggle="modal" data-bs-target="#ModalListAnggotaMasuk" data-id="Bulanan,'.$Tanggal.'">'.$JumlahMasuk.' Orang</a>';
                                    echo '  </td>';
                                    echo '  <td align="center">';
                                    echo '      <a href="javascript:void(0);" data-bs-toggle="modal" data-bs-target="#ModalListAnggotaKeluar" data-id="Bulanan,'.$Tanggal.'">'.$JumlahKeluar.' Orang</a>';
                                    echo '  </td>';
                                    echo '</tr>';
                                    $JumlahTotalMasuk=$JumlahTotalMasuk+$JumlahMasuk;
                                    $JumlahTotalKeluar=$JumlahTotalKeluar+$JumlahKeluar;
                                    $no++;
                                }
                                echo '<tr>';
                                echo '  <td align="left" colspan="4"></td>';
                                echo '</tr>';
                                echo '<tr>';
                                echo '  <td align="left"></td>';
                                echo '  <td align="left"><b>JUMLAH</b></td>';
                                echo '  <td align="center">';
                                echo '      <b>'.$JumlahTotalMasuk.' Orang</b>';
                                echo '  </td>';
                                echo '  <td align="center">';
                                echo '      <b>'.$JumlahTotalKeluar.' Orang</b>';
                                echo '  </td>';
                                echo '</tr>';
                            }else{
                                $JumlahTotalMasuk=0;
                                $JumlahTotalKeluar=0;
                                $no=1;
                                $days_in_month = cal_days_in_month(CAL_GREGORIAN, $month, $year);
                                for ($day = 1; $day <= $days_in_month; $day++) {
                                    // Format tanggal dengan dua digit
                                    $formatted_day = str_pad($day, 2, "0", STR_PAD_LEFT);
                                    // Format bulan dengan dua digit
                                    $formatted_month = str_pad($month, 2, "0", STR_PAD_LEFT);
                                    $Tanggal="$year-$formatted_month-$formatted_day";
                                    //Jumlah Anggtoa Masuk Pada Tanggal Tersebut
                                    $JumlahMasuk=mysqli_num_rows(mysqli_query($Conn, "SELECT id_anggota FROM anggota WHERE tanggal_masuk='$Tanggal'"));
                                    $JumlahKeluar=mysqli_num_rows(mysqli_query($Conn, "SELECT id_anggota FROM anggota WHERE tanggal_keluar='$Tanggal' AND status='Keluar'"));
                                    echo '<tr>';
                                    echo '  <td align="center">'.$no.'</td>';
                                    echo '  <td align="left">'.$formatted_day.'/'.$formatted_month.'/'.$year.'</td>';
                                    echo '  <td align="center">';
                                    echo '      <a href="javascript:void(0);" data-bs-toggle="modal" data-bs-target="#ModalListAnggotaMasuk" data-id="Bulanan,'.$Tanggal.'">'.$JumlahMasuk.' Orang</a>';
                                    echo '  </td>';
                                    echo '  <td align="center">';
                                    echo '      <a href="javascript:void(0);" data-bs-toggle="modal" data-bs-target="#ModalListAnggotaKeluar" data-id="Bulanan,'.$Tanggal.'">'.$JumlahKeluar.' Orang</a>';
                                    echo '  </td>';
                                    echo '</tr>';
                                    $JumlahTotalMasuk=$JumlahTotalMasuk+$JumlahMasuk;
                                    $JumlahTotalKeluar=$JumlahTotalKeluar+$JumlahKeluar;
                                    $no++;
                                }
                                echo '<tr>';
                                echo '  <td align="left" colspan="4"></td>';
                                echo '</tr>';
                                echo '<tr>';
                                echo '  <td align="left"></td>';
                                echo '  <td align="left"><b>JUMLAH</b></td>';
                                echo '  <td align="center">';
                                echo '      <b>'.$JumlahTotalMasuk.' Orang</b>';
                                echo '  </td>';
                                echo '  <td align="center">';
                                echo '      <b>'.$JumlahTotalKeluar.' Orang</b>';
                                echo '  </td>';
                                echo '</tr>';
                            }
                        ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
<?php } ?>
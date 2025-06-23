<?php
    //Koneksi
    date_default_timezone_set('Asia/Jakarta');
    include "../../_Config/Connection.php";
    include "../../_Config/GlobalFunction.php";
    include "../../_Config/SettingGeneral.php";
    include "../../_Config/Session.php";
    include '../../vendor/autoload.php';
    //Time Zone
    date_default_timezone_set('Asia/Jakarta');
    //Cek Akses
    if(empty($SessionIdAkses)){
        echo '<div class="row mb-3">';
        echo '  <div class="col col-md-12 text-center">';
        echo '      <code>Sesi Akses Sudah Berakhir. Silahkan Login Ulang!</code>';
        echo '  </div>';
        echo '</div>';
    }else{
        $jml_data = mysqli_num_rows(mysqli_query($Conn, "SELECT*FROM akun_perkiraan"));
        //Mencari Level maksimum
        if(!empty($jml_data)){
            $QryMaksimumLevel=mysqli_query($Conn, "SELECT max(level) as level_akun FROM akun_perkiraan")or die(mysqli_error($Conn));
            while($HasilNilai=mysqli_fetch_array($QryMaksimumLevel)){
                $level_akun_max=$HasilNilai['level_akun'];
            }
        }else{
            $level_akun_max=0;
        }
        $level_akun_max=$level_akun_max;
        if(empty($jml_data)){
            echo '<div class="row">';
            echo '  <div class="col text-danger text-center">';
            echo '      <span class="text-center">Belum Ada Akun Perkiraan</span>';
            echo '  </div>';
            echo '</div>';
        }else{
?>
    <div class="table-responsive">
        <table class="table table-hover table-bordered table-striped">
            <thead>
                <tr>
                    <td align="center"><b>No</b></td>
                    <td align="center" colspan="<?php echo $level_akun_max; ?>"><b>Akun Perkiraan</b></td>
                    <td align="center"><b>Level</b></td>
                    <td align="center"><b>Saldo Normal</b></td>
                    <td align="center"><b>Jurnal</b></td>
                    <td align="center"><b>Opsi</b></td>
                </tr>
            </thead>
            <tbody>
                <?php
                    $no = 1;
                    $query = mysqli_query($Conn, "
                        SELECT * FROM akun_perkiraan
                        ORDER BY
                            CAST(SUBSTRING_INDEX(kode, '.', 1) AS UNSIGNED),
                            IF(CHAR_LENGTH(kode) - CHAR_LENGTH(REPLACE(kode, '.', '')) >= 1,
                                CAST(SUBSTRING_INDEX(SUBSTRING_INDEX(kode, '.', 2), '.', -1) AS UNSIGNED), 0),
                            IF(CHAR_LENGTH(kode) - CHAR_LENGTH(REPLACE(kode, '.', '')) >= 2,
                                CAST(SUBSTRING_INDEX(SUBSTRING_INDEX(kode, '.', 3), '.', -1) AS UNSIGNED), 0),
                            IF(CHAR_LENGTH(kode) - CHAR_LENGTH(REPLACE(kode, '.', '')) >= 3,
                                CAST(SUBSTRING_INDEX(kode, '.', -1) AS UNSIGNED), 0)
                    ");
                    while ($data = mysqli_fetch_array($query)) {
                        $id_perkiraan = $data['id_perkiraan'];
                        $kode_perkiraan = $data['kode'];
                        $nama_perkiraan = $data['nama'];
                        $level_perkiraan= $data['level'];
                        $saldo_normal= $data['saldo_normal'];
                        //WARNA TEXT
                        if($saldo_normal=='Kredit'){
                            $LabelSaldo="<span class='text-danger'>$saldo_normal</span>";
                        }else{
                            $LabelSaldo="<span class='text-info'>$saldo_normal</span>";
                        }
                        //Hitung Jurnal Yang Menggunakan Akun Ini
                        $JumlahJurnal=mysqli_num_rows(mysqli_query($Conn, "SELECT * FROM jurnal WHERE kode_perkiraan='$kode_perkiraan'"));
                        $JumlahJurnal = "" . number_format($JumlahJurnal,0,',','.');
                ?>
                        <tr>
                            <td align="center">
                                <?php echo $no; ?>
                            </td>    
                            <?php 
                                if($level_perkiraan=="1"){
                                    echo '<td align="left" colspan="'.$level_akun_max.'"><b>'.$kode_perkiraan.'. '.$nama_perkiraan.'</b></td>';
                                }else{
                                    $JumlahKolomKosong=$level_perkiraan-1;
                                    for ($i = 0; $i < $JumlahKolomKosong; $i++) {
                                        echo '<td align="left"></td>';
                                    }
                                    $JumlahColspan=$level_akun_max- $JumlahKolomKosong;
                                    if($level_perkiraan=="2"){
                                        echo '<td align="left" colspan="'.$JumlahColspan.'">'.$kode_perkiraan.'. '.$nama_perkiraan.'</td>';
                                    }else{
                                        if($level_perkiraan=="3"){
                                            echo '<td align="left" colspan="'.$JumlahColspan.'"><small>'.$kode_perkiraan.'. '.$nama_perkiraan.'</small></td>';
                                        }else{
                                            if($level_perkiraan=="4"){
                                                echo '<td align="left" colspan="'.$JumlahColspan.'"><small class="text text-muted">'.$kode_perkiraan.'. '.$nama_perkiraan.'</small></td>';
                                            }else{
                                                echo '<td align="left" colspan="'.$JumlahColspan.'"><small class="text text-danger">'.$kode_perkiraan.'. '.$nama_perkiraan.'</small></td>';
                                            }
                                        }
                                    }
                                    
                                }
                            ?>    
                            <td class="text-center" align="center">
                                <?php 
                                    echo "$level_perkiraan";
                                ?>
                            </td>
                            <td class="text-left" align="left"><small><?php echo "$saldo_normal";?></small></td>
                            <td class="text-left" align="right">
                                <small class="credit">
                                    <?php 
                                        if(empty($JumlahJurnal)){
                                            echo '-';
                                        }else{
                                            echo '<code class="text-dark">'.$JumlahJurnal.' Record</code>';
                                        }
                                    ?>
                                </small>
                            </td>
                            <td class="text-center" align="center">
                                <a class="btn btn-sm btn-outline-dark btn-floating" href="javascript:void(0);" data-bs-toggle="dropdown" aria-expanded="false">
                                    <i class="bi bi-three-dots"></i>
                                </a>
                                <ul class="dropdown-menu dropdown-menu-end dropdown-menu-arrow" style="">
                                    <li class="dropdown-header text-start">
                                        <h6>Option</h6>
                                    </li>
                                    <li>
                                        <a class="dropdown-item" href="javascript:void(0)" data-bs-toggle="modal" data-bs-target="#ModalDetailAkunPerkiraan" data-id="<?php echo "$id_perkiraan"; ?>">
                                            <i class="bi bi-info-circle"></i> Detail
                                        </a>
                                    </li>
                                    <?php if($level_perkiraan<4){ ?>
                                        <li>
                                            <a class="dropdown-item" href="javascript:void(0)" data-bs-toggle="modal" data-bs-target="#ModalTambahAkunPerkiraanAnak" data-id="<?php echo "$id_perkiraan"; ?>">
                                                <i class="bi bi-plus"></i> Tambah Akun
                                            </a>
                                        </li>
                                    <?php } ?>
                                    <li>
                                        <a class="dropdown-item" href="javascript:void(0)" data-bs-toggle="modal" data-bs-target="#ModalEditAkun" data-id="<?php echo "$id_perkiraan"; ?>">
                                            <i class="bi bi-pencil"></i> Ubah
                                        </a>
                                    </li>
                                    <li>
                                        <a class="dropdown-item" href="javascript:void(0)" data-bs-toggle="modal" data-bs-target="#ModalHapusAkun" data-id="<?php echo "$id_perkiraan"; ?>">
                                            <i class="bi bi-trash"></i> Hapus
                                        </a>
                                    </li>
                                </ul>
                            </td>
                        </tr>
                <?php
                        $no++; 
                    }
                ?>
            </tbody>
        </table>
    </div>
<?php 
        } 
    }
?>
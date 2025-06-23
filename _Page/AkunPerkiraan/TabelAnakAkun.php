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
        echo '<tr>';
        echo '  <td colspan="10" class="text-center">';
        echo '      <code>Sesi Akses Sudah Berakhir. Silahkan Login Ulang!</code>';
        echo '  </td>';
        echo '</tr>';
    }else{
        if(empty($_POST['kode_perkiraan'])){
            echo '<tr>';
            echo '  <td colspan="10" class="text-center">';
            echo '      <code>Kode Perkiraan Tidak Boleh Kosong!</code>';
            echo '  </td>';
            echo '</tr>';
        }else{
            $kode_perkiraan=$_POST['kode_perkiraan'];

?>
    <?php
        $query = mysqli_query($Conn, "SELECT*FROM akun_perkiraan WHERE kd1='$kode_perkiraan' ORDER BY kode ASC");
        while ($data = mysqli_fetch_array($query)) {
            $id_perkiraan = $data['id_perkiraan'];
            $kode_perkiraan = $data['kode'];
            $nama_perkiraan = $data['nama'];
            $level_perkiraan= $data['level'];
            $saldo_normal= $data['saldo_normal'];
            $status= $data['status'];
            //WARNA TEXT
            if($saldo_normal=='Kredit'){
                $LabelSaldo="<span class='text-danger'>$saldo_normal</span>";
            }else{
                $LabelSaldo="<span class='text-info'>$saldo_normal</span>";
            }
            //Label Status
            if($status==''){
                $LabelStatus="<span class='badge badge-dark' title='Status Akun Tidak Diatur'>None</span>";
            }else{
                if($status=='Closed'){
                    $LabelStatus="<span class='badge badge-success' title='Status Akun Dikunci'><i class='bi bi-lock'></i> Dikunci</span>";
                }else{
                    $LabelStatus="<span class='badge badge-info'><i class='bi bi-unlock' title='Status Akun Terbuka'></i> Terbuka</span>";
                }
            }
            //Hitung Jurnal Yang Menggunakan Akun Ini
            $JumlahJurnal=mysqli_num_rows(mysqli_query($Conn, "SELECT * FROM jurnal WHERE kode_perkiraan='$kode_perkiraan'"));
            //Cek Apakah Punya Anak?
            $JumlahAnak=mysqli_num_rows(mysqli_query($Conn, "SELECT * FROM akun_perkiraan WHERE level>'1' AND kd1='$kode_perkiraan'"));
    ?>
        <tr>
            <td align="center">
                <?php
                    if(!empty($JumlahAnak)){
                        echo '<a href="javascript:void(0);" class="MotherAccount" value="'.$kode_perkiraan.'">';
                        echo '  <i class="bi bi-chevron-down"></i>';
                        echo '</a>';
                    }
                ?>
            </td>    
            <?php 
                if($level_perkiraan=="1"){
                    echo '<td align="left" colspan="'.$level_akun_max.'">'.$kode_perkiraan.'. '.$nama_perkiraan.'</td>';
                }else{
                    $JumlahKolomKosong=$level_perkiraan-1;
                    for ($i = 0; $i < $JumlahKolomKosong; $i++) {
                        echo '<td align="left"></td>';
                    }
                    $JumlahColspan=$level_akun_max- $JumlahKolomKosong;
                    echo '<td align="left" colspan="'.$JumlahColspan.'">'.$kode_perkiraan.'. '.$nama_perkiraan.'</td>';
                }
            ?>    
            <td class="text-center" align="center">
                <?php 
                    echo "$level_perkiraan";
                ?>
            </td>
            <td class="text-left" align="left"><small><?php echo "$saldo_normal";?></small></td>
            <td class="text-left" align="right"><small><?php echo "$JumlahJurnal";?></small></td>
            <td class="text-center" align="center">
                <a class="btn btn-sm btn-outline-dark btn-rounded" href="javascript:void(0);" data-bs-toggle="dropdown" aria-expanded="false">
                    <i class="bi bi-three-dots"></i>
                </a>
                <ul class="dropdown-menu dropdown-menu-end dropdown-menu-arrow" style="">
                    <li class="dropdown-header text-start">
                        <h6>Option</h6>
                    </li>
                    <li>
                        <a class="dropdown-item" href="javascript:void(0)" data-bs-toggle="modal" data-bs-target="#ModalDetailAkun" data-id="<?php echo "$id_perkiraan"; ?>">
                            <i class="bi bi-info-circle"></i> Detail
                        </a>
                    </li>
                    <li>
                        <a class="dropdown-item" href="javascript:void(0)" data-bs-toggle="modal" data-bs-target="#ModalTambahAnakAkun" data-id="<?php echo "$id_perkiraan"; ?>">
                            <i class="bi bi-plus"></i> Tambah Akun
                        </a>
                    </li>
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
        }
    }
?>
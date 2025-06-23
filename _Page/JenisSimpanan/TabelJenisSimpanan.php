<?php
    //koneksi dan session
    include "../../_Config/Connection.php";
    include "../../_Config/GlobalFunction.php";
    include "../../_Config/Session.php";
    date_default_timezone_set("Asia/Jakarta");
    $jml_data = mysqli_num_rows(mysqli_query($Conn, "SELECT*FROM simpanan_jenis"));
?>
<?php
    if(empty($SessionIdAkses)){
        echo '
            <tr>
                <td colspan="7" class="text-center text-danger">Sesi Akses Sudah Berakhir, Silahkan Login Ulang!</td>
            </tr>
        ';
    }else{
        if(empty($jml_data)){
            echo '
                <tr>
                    <td colspan="7" class="text-center text-danger">Tidak Ada Data Jenis Simapanan Yang Dapat Ditampilkan. Silahkan tambah jenis simpanan terlebih dulu!</td>
                </tr>
            ';
        }else{
            $no = 1;
            $query = mysqli_query($Conn, "SELECT*FROM simpanan_jenis ORDER BY id_simpanan_jenis ASC");
            while ($data = mysqli_fetch_array($query)) {
                $id_simpanan_jenis= $data['id_simpanan_jenis'];
                $nama_simpanan= $data['nama_simpanan'];
                $rutin= $data['rutin'];
                $nominal= $data['nominal'];
                $id_perkiraan_debet= $data['id_perkiraan_debet'];
                $id_perkiraan_kredit= $data['id_perkiraan_kredit'];
                //Buka Data Perkiraan
                $nama_perkiraan_debet=GetDetailData($Conn,'akun_perkiraan','id_perkiraan',$id_perkiraan_debet,'nama');
                $nama_perkiraan_kredit=GetDetailData($Conn,'akun_perkiraan','id_perkiraan',$id_perkiraan_kredit,'nama');
                //Label Rutin
                if(empty($rutin)){
                    $LabelRutin='<div class="badge badge-danger">Sukarela</div>';
                }else{
                    $LabelRutin='<div class="badge badge-success">Rutin/Wajib</div>';
                }
                $NominalRp = "Rp " . number_format($nominal,0,',','.');
                echo '
                    <tr>
                        <td><small>'.$no.'</small></td>
                        <td><small>'.$nama_simpanan.'</small></td>
                        <td><small>'.$LabelRutin.'</small></td>
                        <td><small>'.$nama_perkiraan_debet.'</small></td>
                        <td><small>'.$nama_perkiraan_kredit.'</small></td>
                        <td><small>'.$NominalRp.'</small></td>
                        <td class="text-center">
                            <button type="button" class="btn btn-sm btn-outline-dark btn-floating" data-bs-toggle="dropdown" aria-expanded="false">
                                <i class="bi bi-three-dots"></i>
                            </button>
                            <ul class="dropdown-menu dropdown-menu-end dropdown-menu-arrow" style="">
                                <li class="dropdown-header text-start">
                                    <h6>Option</h6>
                                </li>
                                <li>
                                    <a class="dropdown-item" href="javascript:void(0)" data-bs-toggle="modal" data-bs-target="#ModalDetailJenisSimpanan" data-id="'.$id_simpanan_jenis.'">
                                        <i class="bi bi-info-circle"></i> Detail
                                    </a>
                                </li>
                                <li>
                                    <a class="dropdown-item" href="javascript:void(0)" data-bs-toggle="modal" data-bs-target="#ModalEditJenisSimpanan" data-id="'.$id_simpanan_jenis.'">
                                        <i class="bi bi-pencil"></i> Edit
                                    </a>
                                </li>
                                <li>
                                    <a class="dropdown-item" href="javascript:void(0)" data-bs-toggle="modal" data-bs-target="#ModalHapusJenisSimpanan" data-id="'.$id_simpanan_jenis.'">
                                        <i class="bi bi-x"></i> Hapus
                                    </a>
                                </li>
                            </ul>
                        </td>
                    </tr>
                ';
                $no++;
            }
        }
    }
?>

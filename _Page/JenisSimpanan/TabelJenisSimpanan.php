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
                <td colspan="6" class="text-center text-danger">Sesi Akses Sudah Berakhir, Silahkan Login Ulang!</td>
            </tr>
        ';
    }else{
        if(empty($jml_data)){
            echo '
                <tr>
                    <td colspan="6" class="text-center text-danger">Tidak Ada Data Jenis Simapanan Yang Dapat Ditampilkan. Silahkan tambah jenis simpanan terlebih dulu!</td>
                </tr>
            ';
        }else{
            $no = 1;
            $query = mysqli_query($Conn, "SELECT*FROM simpanan_jenis ORDER BY id_simpanan_jenis ASC");
            while ($data = mysqli_fetch_array($query)) {
                $id_simpanan_jenis= $data['id_simpanan_jenis'];
                $nama_simpanan= $data['nama_simpanan'];
                $kategori= $data['kategori'];
                $nominal= $data['nominal'];
                
                //Label Kategori Simpanan
                if($kategori=="Simpanan Wajib"){
                    $LabelKategori='<div class="badge badge-danger">Simpanan Wajib</div>';
                }else{
                    if($kategori=="Simpanan Pokok"){
                        $LabelKategori='<div class="badge badge-warning">Simpanan Pokok</div>';
                    }else{
                        $LabelKategori='<div class="badge badge-primary">Simpanan Sukarela</div>';
                    }
                }
                //Label Nominal
                if(empty($nominal)){
                    $LabelNominal='<small class="text-muted">Tidak Ditentukan</small>';
                }else{
                    $NominalRp = "Rp " . number_format($nominal,0,',','.');
                    $LabelNominal='<small class="text-info">'.$NominalRp.'</small>';
                }
                
                //Hitung Jumlah Total Simpanan Berdasarkan id_simpanan_jenis
                $SumSimpanan = mysqli_fetch_array(mysqli_query($Conn, "SELECT SUM(jumlah) AS total FROM simpanan WHERE id_simpanan_jenis='$id_simpanan_jenis' AND kategori!='Penarikan'"));
                $jumlah_simpanan = $SumSimpanan['total'];
                $jumlah_simpanan_format = "" . number_format($jumlah_simpanan,0,',','.');

                //Menghitung Jumlah Penarikan
                $SumPenarikan = mysqli_fetch_array(mysqli_query($Conn, "SELECT SUM(jumlah) AS total FROM simpanan WHERE id_simpanan_jenis='$id_simpanan_jenis' AND kategori='Penarikan'"));
                $jumlah_penarikan = $SumPenarikan['total'];
                $jumlah_penarikan_format = "" . number_format($jumlah_penarikan,0,',','.');

                //Jumlah Netto Simpanan
                $jumlah_simpanan_netto=$jumlah_simpanan-$jumlah_penarikan;
                $jumlah_simpanan_netto_format = "Rp " . number_format($jumlah_simpanan_netto,0,',','.');

                echo '
                    <tr>
                        <td><small>'.$no.'</small></td>
                        <td>
                            <a href="javascript:void(0);" class="text text-info" data-bs-toggle="modal" data-bs-target="#ModalDetailJenisSimpanan" data-id="'.$id_simpanan_jenis.'">
                                <small class="text-decoration-underline">'.$nama_simpanan.'</small>
                            </a>
                        </td>
                        <td><small>'.$LabelKategori.'</small></td>
                        <td><small>'.$LabelNominal.'</small></td>
                        <td><small>'.$jumlah_simpanan_netto_format.'</small></td>
                        <td class="">
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

<?php
    //koneksi dan session
    include "../../_Config/Connection.php";
    include "../../_Config/GlobalFunction.php";
    include "../../_Config/Session.php";
    //inisiasi Variabe;
    $JmlHalaman=0;
    $page=1;
    if(empty($SessionIdAkses)){
        echo '
            <tr>
                <td colspan="7" class="text-center text-danger">
                    Sesi Akses Sudah Berakhir! Silahkan Login Ulang
                </td>
            </tr>
        ';
    }else{
        //Keyword_by
        if(!empty($_POST['keyword_by'])){
            $keyword_by=$_POST['keyword_by'];
        }else{
            $keyword_by="";
        }
        //keyword
        if(!empty($_POST['keyword'])){
            $keyword=$_POST['keyword'];
        }else{
            $keyword="";
        }
        //batas
        if(!empty($_POST['batas'])){
            $batas=$_POST['batas'];
        }else{
            $batas="10";
        }
        //ShortBy
        if(!empty($_POST['ShortBy'])){
            $ShortBy=$_POST['ShortBy'];
        }else{
            $ShortBy="DESC";
        }
        //OrderBy
        if(!empty($_POST['OrderBy'])){
            $OrderBy=$_POST['OrderBy'];
        }else{
            $OrderBy="id_pinjaman_jenis";
        }
        //Atur Page
        if(!empty($_POST['page'])){
            $page=$_POST['page'];
            $posisi = ( $page - 1 ) * $batas;
        }else{
            $page="1";
            $posisi = 0;
        }
        if(empty($keyword_by)){
            if(empty($keyword)){
                $jml_data = mysqli_num_rows(mysqli_query($Conn, "SELECT id_pinjaman_jenis FROM pinjaman_jenis"));
            }else{
                $jml_data = mysqli_num_rows(mysqli_query($Conn, "SELECT id_pinjaman_jenis FROM pinjaman_jenis WHERE nama_pinjaman like '%$keyword%' OR periode_angsuran like '%$keyword%' OR persen_jasa like '%$keyword%'"));
            }
        }else{
            if(empty($keyword)){
                $jml_data = mysqli_num_rows(mysqli_query($Conn, "SELECT id_pinjaman_jenis FROM pinjaman_jenis"));
            }else{
                $jml_data = mysqli_num_rows(mysqli_query($Conn, "SELECT id_pinjaman_jenis FROM pinjaman_jenis WHERE $keyword_by like '%$keyword%'"));
            }
        }
        if(empty($jml_data)){
            echo '
                <tr>
                    <td colspan="7" class="text-center text-danger">
                        Tidak Ada Data Yang Ditampilkan.
                    </td>
                </tr>
            ';
        }else{
            $no = 1+$posisi;
            //KONDISI PENGATURAN MASING FILTER
            if(empty($keyword_by)){
                if(empty($keyword)){
                    $query = mysqli_query($Conn, "SELECT*FROM pinjaman_jenis ORDER BY $OrderBy $ShortBy LIMIT $posisi, $batas");
                }else{
                    $query = mysqli_query($Conn, "SELECT*FROM pinjaman_jenis WHERE nama_pinjaman like '%$keyword%' OR periode_angsuran like '%$keyword%' OR persen_jasa like '%$keyword%' ORDER BY $OrderBy $ShortBy LIMIT $posisi, $batas");
                }
            }else{
                if(empty($keyword)){
                    $query = mysqli_query($Conn, "SELECT*FROM pinjaman_jenis ORDER BY $OrderBy $ShortBy LIMIT $posisi, $batas");
                }else{
                    $query = mysqli_query($Conn, "SELECT*FROM pinjaman_jenis WHERE $keyword_by like '%$keyword%' ORDER BY $OrderBy $ShortBy LIMIT $posisi, $batas");
                }
            }
            while ($data = mysqli_fetch_array($query)) {
                $id_pinjaman_jenis= $data['id_pinjaman_jenis'];
                $nama_pinjaman= $data['nama_pinjaman'];
                $periode_angsuran= $data['periode_angsuran'];
                $persen_jasa= $data['persen_jasa'];
                //Hitung Jumlah Sesi Pinjaman
                $jumlah_sesi_pinjaman = mysqli_num_rows(mysqli_query($Conn, "SELECT id_pinjaman FROM pinjaman WHERE id_pinjaman_jenis='$id_pinjaman_jenis'"));
                echo '
                    <tr>
                        <td><small>'.$no.'</small></td>
                        <td>
                            <a href="javascript:void(0);" class="text text-decoration-underline" data-bs-toggle="modal" data-bs-target="#ModalDetailPinjaman" data-id="'.$id_pinjaman_jenis.'">
                                <small>'.$nama_pinjaman.'</small>
                            </a>
                        </td>
                        <td><small>'.$periode_angsuran.' Bulan</small></td>
                        <td><small>'.$persen_jasa.' %</small></td>
                        <td><small>'.$jumlah_sesi_pinjaman.' Sesi</small></td>
                        <td>
                            <button type="button" class="btn btn-sm btn-floating btn-outline-secondary" data-bs-toggle="dropdown" aria-expanded="false">
                                <i class="bi bi-three-dots"></i>
                            </button>
                            <ul class="dropdown-menu dropdown-menu-end dropdown-menu-arrow" style="">
                                <li class="dropdown-header text-start">
                                    <h6>Option</h6>
                                </li>
                                <li>
                                    <a class="dropdown-item" href="javascript:void(0)" data-bs-toggle="modal" data-bs-target="#ModalEditJenisPinjaman" data-id="'.$id_pinjaman_jenis.'">
                                        <i class="bi bi-pencil"></i> Edit Jenis Pinjaman
                                    </a>
                                </li>
                                <li>
                                    <a class="dropdown-item" href="javascript:void(0)" data-bs-toggle="modal" data-bs-target="#ModalHapusJenisPinjaman" data-id="'.$id_pinjaman_jenis.'">
                                        <i class="bi bi-trash"></i> Hapus Jenis Pinjaman
                                    </a>
                                </li>
                            </ul>
                        </td>
                    </tr>
                ';
                $no++;
            }
            $JmlHalaman = ceil($jml_data/$batas); 
        }
    }
?>

<script>
    //Creat Javascript Variabel
    var page_count=<?php echo $JmlHalaman; ?>;
    var curent_page=<?php echo $page; ?>;
    
    //Put Into Pagging Element
    $('#page_info').html('Page '+curent_page+' Of '+page_count+'');
    
    //Set Pagging Button
    if(curent_page==1){
        $('#prev_button').prop('disabled', true);
    }else{
        $('#prev_button').prop('disabled', false);
    }
    if(page_count<=curent_page){
        $('#next_button').prop('disabled', true);
    }else{
        $('#next_button').prop('disabled', false);
    }
</script>

<?php
    //koneksi dan session
    include "../../_Config/Connection.php";
    include "../../_Config/GlobalFunction.php";
    include "../../_Config/Session.php";

    //Cek Izin Akses
    $IjinEditDokumentasi=IjinAksesSaya($Conn,$SessionIdAkses,'GA4iqizxbIlTU5mMo0W');
    $IjinHapusDokumentasi=IjinAksesSaya($Conn,$SessionIdAkses,'xMAQQmh4DYnyd3JG26J');
    $IjinDetailDokumentasi=IjinAksesSaya($Conn,$SessionIdAkses,'MqOJHVudKBTAhgjU0xl');
    //inisiasi Variabe;
    $JmlHalaman=0;
    $page=1;
    if(empty($SessionIdAkses)){
        echo '
            <tr>
                <td colspan="6" class="text-center text-danger">
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
            $OrderBy="id_help";
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
                $jml_data = mysqli_num_rows(mysqli_query($Conn, "SELECT id_help FROM help"));
            }else{
                $jml_data = mysqli_num_rows(mysqli_query($Conn, "SELECT id_help FROM help WHERE author like '%$keyword%' OR judul like '%$keyword%' OR kategori like '%$keyword%' OR deskripsi like '%$keyword%'"));
            }
        }else{
            if(empty($keyword)){
                $jml_data = mysqli_num_rows(mysqli_query($Conn, "SELECT id_help FROM help"));
            }else{
                $jml_data = mysqli_num_rows(mysqli_query($Conn, "SELECT id_help FROM help WHERE $keyword_by like '%$keyword%'"));
            }
        }
        if(empty($jml_data)){
            echo '
                <tr>
                    <td colspan="6" class="text-center text-danger">
                        Tidak Ada Data Dokumentasi Yang Ditemukan.
                    </td>
                </tr>
            ';
        }else{
            $no = 1+$posisi;
            //KONDISI PENGATURAN MASING FILTER
            if(empty($keyword_by)){
                if(empty($keyword)){
                    $query = mysqli_query($Conn, "SELECT*FROM help ORDER BY $OrderBy $ShortBy LIMIT $posisi, $batas");
                }else{
                    $query = mysqli_query($Conn, "SELECT*FROM help WHERE author like '%$keyword%' OR judul like '%$keyword%' OR kategori like '%$keyword%' OR deskripsi like '%$keyword%' ORDER BY $OrderBy $ShortBy LIMIT $posisi, $batas");
                }
            }else{
                if(empty($keyword)){
                    $query = mysqli_query($Conn, "SELECT*FROM help ORDER BY $OrderBy $ShortBy LIMIT $posisi, $batas");
                }else{
                    $query = mysqli_query($Conn, "SELECT*FROM help WHERE $keyword_by like '%$keyword%' ORDER BY $OrderBy $ShortBy LIMIT $posisi, $batas");
                }
            }
            while ($data = mysqli_fetch_array($query)) {
                $id_help= $data['id_help'];
                $author= $data['author'];
                $judul= $data['judul'];
                $kategori= $data['kategori'];
                if($IjinDetailDokumentasi=="Ada"){
                    $label_judul='<a href="javascript:void(0);" class="detail_dokumentasi" data-id="'.$id_help.'">'.$judul.'</a>';
                    $label_tombol_detail='
                        <li>
                            <a href="javascript:void(0)" class="dropdown-item detail_dokumentasi" data-id="'.$id_help.'">
                                <i class="bi bi-info-circle"></i> Detail Dokumentasi
                            </a>
                        </li>
                    ';
                }else{
                    $label_judul=''.$judul.'';
                    $label_tombol_detail='';
                }
                if($IjinHapusDokumentasi=="Ada"){
                    $label_tombol_edit='
                        <li>
                            <a href="javascript:void(0)" class="dropdown-item edit_dokumentasi" data-id="'.$id_help.'">
                                <i class="bi bi-pencil"></i> Edit Dokumentasi
                            </a>
                        </li>
                    ';
                }else{
                    $label_tombol_edit='';
                }
                if($IjinHapusDokumentasi=="Ada"){
                    $label_tombol_hapus='
                        <li>
                            <a class="dropdown-item" href="javascript:void(0)" data-bs-toggle="modal" data-bs-target="#ModalHapus" data-id="'.$id_help.'">
                                <i class="bi bi-trash"></i> Hapus Dokumentasi
                            </a>
                        </li>
                    ';
                }else{
                    $label_tombol_hapus='';
                }
                $datetime_update= $data['datetime_update'];
                $datetime_update_format=date('d/m/Y',strtotime($datetime_update));
                echo '
                    <tr>
                        <td><small>'.$no.'</small></td>
                        <td>
                            <small>
                                '.$label_judul.'
                            </small>
                        </td>
                        <td><small class="text-muted">'.$kategori.'</small></td>
                        <td><small class="text-muted">'.$datetime_update_format.'</small></td>
                        <td><small class="text-muted"><span class="badge badge-primary"><i class="bi bi-person-circle"></i> '.$author.'</span></small></td>
                        <td>
                            <button type="button" class="btn btn-sm btn-floating btn-outline-secondary" data-bs-toggle="dropdown" aria-expanded="false">
                                <i class="bi bi-three-dots"></i>
                            </button>
                            <ul class="dropdown-menu dropdown-menu-end dropdown-menu-arrow" style="">
                                <li class="dropdown-header text-start">
                                    <h6>Option</h6>
                                </li>
                                '.$label_tombol_detail.'
                                '.$label_tombol_edit.'
                                '.$label_tombol_hapus.'
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

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
            $OrderBy="id_stok_opename";
        }
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
                $jml_data = mysqli_num_rows(mysqli_query($Conn, "SELECT id_stok_opename FROM stok_opename"));
            }else{
                $jml_data = mysqli_num_rows(mysqli_query($Conn, "SELECT id_stok_opename FROM stok_opename WHERE tanggal like '%$keyword%' OR status like '%$keyword%'"));
            }
        }else{
            if(empty($keyword)){
                $jml_data = mysqli_num_rows(mysqli_query($Conn, "SELECT id_stok_opename FROM stok_opename"));
            }else{
                $jml_data = mysqli_num_rows(mysqli_query($Conn, "SELECT id_stok_opename FROM stok_opename WHERE $keyword_by like '%$keyword%'"));
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
                    $query = mysqli_query($Conn, "SELECT*FROM stok_opename ORDER BY $OrderBy $ShortBy LIMIT $posisi, $batas");
                }else{
                    $query = mysqli_query($Conn, "SELECT*FROM stok_opename WHERE tanggal like '%$keyword%' OR status like '%$keyword%' ORDER BY $OrderBy $ShortBy LIMIT $posisi, $batas");
                }
            }else{
                if(empty($keyword)){
                    $query = mysqli_query($Conn, "SELECT*FROM stok_opename ORDER BY $OrderBy $ShortBy LIMIT $posisi, $batas");
                }else{
                    $query = mysqli_query($Conn, "SELECT*FROM stok_opename WHERE $keyword_by like '%$keyword%' ORDER BY $OrderBy $ShortBy LIMIT $posisi, $batas");
                }
            }
            
            while ($data = mysqli_fetch_array($query)) {
                $id_stok_opename= $data['id_stok_opename'];
                $tanggal= $data['tanggal'];
                $status= $data['status'];
                //Routing status
                if($status==1){
                    $label_status='<span class="badge badge-success">Selesai</span>';
                }else{
                    $label_status='<span class="badge badge-warning">Dalam Pengerjaan</span>';
                }
                //Hitung Jumlah Item
                $jumlah_item = mysqli_num_rows(mysqli_query($Conn, "SELECT id_stok_opename_barang FROM stok_opename_barang WHERE id_stok_opename='$id_stok_opename'"));
                
                //Menghitung jumlah kelebihan
                $SumKelebihan = mysqli_fetch_array(mysqli_query($Conn, "SELECT SUM(jumlah) AS jumlah FROM stok_opename_barang WHERE id_stok_opename='$id_stok_opename' AND jumlah>0"));
                $JumlahKelebihan = $SumKelebihan['jumlah'];
                $JumlahKelebihan_rp = "Rp " . number_format($JumlahKelebihan,0,',','.');
                
                //Menghitung jumlah Kekurangan
                $SumKekurangan = mysqli_fetch_array(mysqli_query($Conn, "SELECT SUM(jumlah) AS jumlah FROM stok_opename_barang WHERE id_stok_opename='$id_stok_opename' AND jumlah<0"));
                $JumlahKekurangan = $SumKekurangan['jumlah'];
                $JumlahKekurangan_rp = "Rp " . number_format($JumlahKekurangan,0,',','.');
                echo '
                    <tr>
                        <td><small>'.$no.'</small></td>
                        <td><small>'.$tanggal.'</small></td>
                        <td><small>'.$jumlah_item.' Item</small></td>
                        <td><small>'.$JumlahKelebihan_rp.'</small></td>
                        <td><small>'.$JumlahKekurangan_rp.'</small></td>
                        <td><small>'.$label_status.'</small></td>
                        <td>
                            <button type="button" class="btn btn-sm btn-floating btn-outline-secondary" data-bs-toggle="dropdown" aria-expanded="false">
                                <i class="bi bi-three-dots"></i>
                            </button>
                            <ul class="dropdown-menu dropdown-menu-end dropdown-menu-arrow" style="">
                                <li class="dropdown-header text-start">
                                    <h6>Option</h6>
                                </li>
                                <li>
                                    <a class="dropdown-item" href="index.php?Page=StockOpename&Sub=DetailStockOpename&id='.$id_stok_opename.'">
                                        <i class="bi bi-info-circle"></i> Detail
                                    </a>
                                </li>
                                <li>
                                    <a class="dropdown-item" href="javascript:void(0)" data-bs-toggle="modal" data-bs-target="#ModalEditSesi" data-id="'.$id_stok_opename.'" data-tanggal="'.$tanggal.'" data-status="'.$status.'">
                                        <i class="bi bi-pencil"></i> Edit
                                    </a>
                                </li>
                                <li>
                                    <a class="dropdown-item" href="javascript:void(0)" data-bs-toggle="modal" data-bs-target="#ModalHapusSesi" data-id="'.$id_stok_opename.'" data-tanggal="'.$tanggal.'" data-status="'.$status.'">
                                        <i class="bi bi-trash"></i> Hapus
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

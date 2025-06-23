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
                <td colspan="8" class="text-center text-danger">
                    <small>Sesi Akses Sudah Berakhir! Silahkan Login Ulang</small>
                </td>
            </tr>
        ';
    }else{
        if(empty($_POST['id_supplier'])){
            echo '
                <tr>
                    <td colspan="8" class="text-center text-danger">
                        <small>ID Supplier Tidak Boleh Kosong</small>
                    </td>
                </tr>
            ';
        }else{
            $id_supplier=$_POST['id_supplier'];
        
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
                $OrderBy="tanggal";
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
                    $jml_data = mysqli_num_rows(mysqli_query($Conn, "SELECT id_transaksi_jual_beli FROM transaksi_jual_beli WHERE id_supplier='$id_supplier'"));
                }else{
                    $jml_data = mysqli_num_rows(mysqli_query($Conn, "SELECT id_transaksi_jual_beli FROM transaksi_jual_beli WHERE (id_supplier='$id_supplier') AND (kategori like '%$keyword%' OR tanggal like '%$keyword%' OR status like '%$keyword%')"));
                }
            }else{
                if(empty($keyword)){
                    $jml_data = mysqli_num_rows(mysqli_query($Conn, "SELECT id_transaksi_jual_beli FROM transaksi_jual_beli WHERE id_supplier='$id_supplier'"));
                }else{
                    $jml_data = mysqli_num_rows(mysqli_query($Conn, "SELECT id_transaksi_jual_beli FROM transaksi_jual_beli WHERE (id_supplier='$id_supplier') AND ($keyword_by like '%$keyword%')"));
                }
            }
            if(empty($jml_data)){
                echo '
                    <tr>
                        <td colspan="8" class="text-center text-danger">
                            Tidak Ada Data Yang Ditampilkan.
                        </td>
                    </tr>
                ';
            }else{
                $no = 1+$posisi;
                //KONDISI PENGATURAN MASING FILTER
                if(empty($keyword_by)){
                    if(empty($keyword)){
                        $query = mysqli_query($Conn, "SELECT*FROM transaksi_jual_beli WHERE id_supplier='$id_supplier' ORDER BY $OrderBy $ShortBy LIMIT $posisi, $batas");
                    }else{
                        $query = mysqli_query($Conn, "SELECT*FROM transaksi_jual_beli WHERE (id_supplier='$id_supplier') AND (kategori like '%$keyword%' OR tanggal like '%$keyword%' OR status like '%$keyword%') ORDER BY $OrderBy $ShortBy LIMIT $posisi, $batas");
                    }
                }else{
                    if(empty($keyword)){
                        $query = mysqli_query($Conn, "SELECT*FROM transaksi_jual_beli WHERE id_supplier='$id_supplier' ORDER BY $OrderBy $ShortBy LIMIT $posisi, $batas");
                    }else{
                        $query = mysqli_query($Conn, "SELECT*FROM transaksi_jual_beli WHERE (id_supplier='$id_supplier') AND ($keyword_by like '%$keyword%') ORDER BY $OrderBy $ShortBy LIMIT $posisi, $batas");
                    }
                }
                while ($data = mysqli_fetch_array($query)) {
                    $id_transaksi_jual_beli= $data['id_transaksi_jual_beli'];
                    $kategori= $data['kategori'];
                    $tanggal= $data['tanggal'];
                    $subtotal= $data['subtotal'];
                    $diskon= $data['diskon'];
                    $ppn= $data['ppn'];
                    $total= $data['total'];
                    $status= $data['status'];
                    
                    //Format tanggal
                    $tanggal=date('d/m/Y',strtotime($tanggal));
                    
                    //Label Kategori
                    if($kategori=="Retur Pembelian"){
                        $label_kategori='<span class="badge badge-secondary">Retur</span>';
                    }else{
                        $label_kategori='<span class="badge badge-primary">Pembelian</span>';
                    }

                    //Label Status
                    if($status=="Lunas"){
                        $label_status='<span class="badge badge-success">Lunas</span>';
                    }else{
                        $label_status='<span class="badge badge-warning">Kredit</span>';
                    }

                    //Format Rp
                    $subtotal_format = "" . number_format($subtotal,0,',','.');
                    $diskon_format = "" . number_format($diskon,0,',','.');
                    $ppn_format = "" . number_format($ppn,0,',','.');
                    $total_format = "" . number_format($total,0,',','.');
                    
                    echo '
                        <tr>
                            <td><small>'.$no.'</small></td>
                            <td>
                                <a href="javascript:void(0);" data-bs-toggle="modal" data-bs-target="#ModalDetailTransaksi" data-id="'.$id_transaksi_jual_beli.'">
                                    <small>'.$tanggal.'</small>
                                </a>
                            </td>
                            <td><small>'.$label_kategori.'</small></td>
                            <td><small>'.$subtotal_format.'</small></td>
                            <td><small>'.$ppn_format.'</small></td>
                            <td><small>'.$diskon_format.'</small></td>
                            <td><small>'.$total_format.'</small></td>
                            <td><small>'.$label_status.'</small></td>
                        </tr>
                    ';
                    $no++;
                }
                $JmlHalaman = ceil($jml_data/$batas); 
            }
        }
    }
?>

<script>
    //Creat Javascript Variabel
    var page_count=<?php echo $JmlHalaman; ?>;
    var curent_page=<?php echo $page; ?>;
    
    //Put Into Pagging Element
    $('#page_info_transaksi').html('Page '+curent_page+' Of '+page_count+'');
    
    //Set Pagging Button
    if(curent_page==1){
        $('#prev_button_transaksi').prop('disabled', true);
    }else{
        $('#prev_button_transaksi').prop('disabled', false);
    }
    if(page_count<=curent_page){
        $('#next_button_transaksi').prop('disabled', true);
    }else{
        $('#next_button_transaksi').prop('disabled', false);
    }
</script>

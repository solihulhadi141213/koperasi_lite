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
                <td colspan="9" class="text-center text-danger">
                    Sesi Akses Sudah Berakhir! Silahkan Login Ulang
                </td>
            </tr>
        ';
    }else{
        if(empty($_POST['id_stok_opename'])){
            echo '
                <tr>
                    <td colspan="9" class="text-center text-danger">
                        ID Sesi Stok Opename Tidak Boleh Kosong!
                    </td>
                </tr>
            ';
        }else{
            $id_stok_opename=$_POST['id_stok_opename'];
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
                $OrderBy="id_barang";
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
                    $jml_data = mysqli_num_rows(mysqli_query($Conn, "SELECT id_barang FROM barang"));
                }else{
                    $jml_data = mysqli_num_rows(mysqli_query($Conn, "SELECT id_barang FROM barang WHERE kode_barang like '%$keyword%' OR nama_barang like '%$keyword%' OR kategori_barang like '%$keyword%' OR satuan_barang like '%$keyword%'"));
                }
            }else{
                if(empty($keyword)){
                    $jml_data = mysqli_num_rows(mysqli_query($Conn, "SELECT id_barang FROM barang"));
                }else{
                    $jml_data = mysqli_num_rows(mysqli_query($Conn, "SELECT id_barang FROM barang WHERE $keyword_by like '%$keyword%'"));
                }
            }
            if(empty($jml_data)){
                echo '
                    <tr>
                        <td colspan="9" class="text-center text-danger">
                            Tidak Ada Data Yang Ditampilkan.
                        </td>
                    </tr>
                ';
            }else{
                $no = 1+$posisi;
                //KONDISI PENGATURAN MASING FILTER
                if(empty($keyword_by)){
                    if(empty($keyword)){
                        $query = mysqli_query($Conn, "SELECT*FROM barang ORDER BY $OrderBy $ShortBy LIMIT $posisi, $batas");
                    }else{
                        $query = mysqli_query($Conn, "SELECT*FROM barang WHERE kode_barang like '%$keyword%' OR nama_barang like '%$keyword%' OR kategori_barang like '%$keyword%' OR satuan_barang like '%$keyword%' ORDER BY $OrderBy $ShortBy LIMIT $posisi, $batas");
                    }
                }else{
                    if(empty($keyword)){
                        $query = mysqli_query($Conn, "SELECT*FROM barang ORDER BY $OrderBy $ShortBy LIMIT $posisi, $batas");
                    }else{
                        $query = mysqli_query($Conn, "SELECT*FROM barang WHERE $keyword_by like '%$keyword%' ORDER BY $OrderBy $ShortBy LIMIT $posisi, $batas");
                    }
                }
                while ($data = mysqli_fetch_array($query)) {
                    $id_barang= $data['id_barang'];
                    $kode_barang= $data['kode_barang'];
                    $nama_barang= $data['nama_barang'];
                    $kategori_barang= $data['kategori_barang'];
                    $satuan_barang= $data['satuan_barang'];
                    //Buka Data Stok Opename
                    $QryStockOpename = mysqli_query($Conn,"SELECT * FROM stok_opename_barang WHERE id_stok_opename='$id_stok_opename' AND id_barang='$id_barang'")or die(mysqli_error($Conn));
                    $DataStockOpename = mysqli_fetch_array($QryStockOpename);
                    if(empty($DataStockOpename['id_stok_opename_barang'])){
                        $id_stok_opename_barang ="";
                    }else{
                        $id_stok_opename_barang= $DataStockOpename['id_stok_opename_barang'];
                    }
                    if(empty($DataStockOpename['stok_awal'])){
                        $stok_awal ="-";
                    }else{
                        $stok_awal= $DataStockOpename['stok_awal'];
                        $stok_awal = (float) $stok_awal; // Konversi ke float
                        $stok_awal = ($stok_awal == floor($stok_awal)) ? (int)$stok_awal : $stok_awal;
                    }
                    if(empty($DataStockOpename['stok_akhir'])){
                        $stok_akhir ="-";
                    }else{
                        $stok_akhir= $DataStockOpename['stok_akhir'];
                        $stok_akhir = (float) $stok_akhir; // Konversi ke float
                        $stok_akhir = ($stok_akhir == floor($stok_akhir)) ? (int)$stok_akhir : $stok_akhir;
                    }
                    if(empty($DataStockOpename['stok_gap'])){
                        $stok_gap ="-";
                    }else{
                        $stok_gap= $DataStockOpename['stok_gap'];
                    }
                    if(empty($DataStockOpename['harga_beli'])){
                        $harga_beli_rp ="-";
                    }else{
                        $harga_beli= $DataStockOpename['harga_beli'];
                        $harga_beli_rp = "" . number_format($harga_beli,0,',','.');
                    }
                    if(empty($DataStockOpename['jumlah'])){
                        $jumlah ="-";
                    }else{
                        $jumlah= $DataStockOpename['jumlah'];
                        $jumlah = "" . number_format($jumlah,0,',','.');
                    }
                    echo '
                        <tr>
                            <td><small>'.$no.'</small></td>
                            <td><small>'.$kode_barang.'</small></td>
                            <td><small>'.$nama_barang.'</small></td>
                            <td><small>'.$harga_beli_rp.'</small></td>
                            <td><small>'.$stok_awal.'</small></td>
                            <td><small>'.$stok_akhir.'</small></td>
                            <td><small>'.$stok_gap.'</small></td>
                            <td><small>'.$jumlah.'</small></td>
                            <td>
                                <button type="button" class="btn btn-sm btn-floating btn-primary" data-bs-toggle="modal" data-bs-target="#ModalStockOpename" data-id="'.$id_barang.'" data-id_sesi="'.$id_stok_opename.'" data-id_so="'.$id_stok_opename_barang.'">
                                    <i class="bi bi-pencil"></i>
                                </button>
                            </td>
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
    $('#page_info_barang').html('Page '+curent_page+' Of '+page_count+'');
    
    //Set Pagging Button
    if(curent_page==1){
        $('#prev_button_barang').prop('disabled', true);
    }else{
        $('#prev_button_barang').prop('disabled', false);
    }
    if(page_count<=curent_page){
        $('#next_button_barang').prop('disabled', true);
    }else{
        $('#next_button_barang').prop('disabled', false);
    }
</script>

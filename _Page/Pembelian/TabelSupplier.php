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
        //keyword
        if(!empty($_POST['keyword'])){
            $keyword=$_POST['keyword'];
        }else{
            $keyword="";
        }
        $batas="10";
        $ShortBy="DESC";
        $OrderBy="id_supplier";
        //Atur Page
        if(!empty($_POST['page'])){
            $page=$_POST['page'];
            $posisi = ( $page - 1 ) * $batas;
        }else{
            $page="1";
            $posisi = 0;
        }
        if(empty($keyword)){
            $jml_data = mysqli_num_rows(mysqli_query($Conn, "SELECT id_supplier FROM supplier"));
        }else{
            $jml_data = mysqli_num_rows(mysqli_query($Conn, "SELECT id_supplier FROM supplier WHERE nama_supplier like '%$keyword%' OR alamat_supplier like '%$keyword%' OR email_supplier like '%$keyword%' OR kontak_supplier like '%$keyword%'"));
        }
        if(empty($jml_data)){
            echo '
                <tr>
                    <td colspan="4" class="text-center text-danger">
                        Tidak Ada Data Supplier Yang Ditampilkan.
                    </td>
                </tr>
            ';
        }else{
            $no = 1+$posisi;
            //KONDISI PENGATURAN MASING FILTER
            if(empty($keyword)){
                $query = mysqli_query($Conn, "SELECT*FROM supplier ORDER BY $OrderBy $ShortBy LIMIT $posisi, $batas");
            }else{
                $query = mysqli_query($Conn, "SELECT*FROM supplier WHERE nama_supplier like '%$keyword%' OR alamat_supplier like '%$keyword%' OR email_supplier like '%$keyword%' OR kontak_supplier like '%$keyword%' ORDER BY $OrderBy $ShortBy LIMIT $posisi, $batas");
            }
            while ($data = mysqli_fetch_array($query)) {
                $id_supplier= $data['id_supplier'];
                $nama_supplier= $data['nama_supplier'];
                $kontak_supplier= $data['kontak_supplier'];
                echo '
                    <tr>
                        <td><small>'.$no.'</small></td>
                        <td><small>'.$nama_supplier.'</small></td>
                        <td><small>'.$kontak_supplier.'</small></td>
                        <td>
                            <button type="button" class="btn btn-sm btn-floating btn-primary pilih_supplier_ke_form_pembelian" data-id="'.$id_supplier.'" data-nama="'.$nama_supplier.'">
                                <i class="bi bi-check"></i>
                            </button>
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
    $('#page_info_supplier').html('Page '+curent_page+' Of '+page_count+'');
    
    //Set Pagging Button
    if(curent_page==1){
        $('#prev_button_supplier').prop('disabled', true);
    }else{
        $('#prev_button_supplier').prop('disabled', false);
    }
    if(page_count<=curent_page){
        $('#next_button_supplier').prop('disabled', true);
    }else{
        $('#next_button_supplier').prop('disabled', false);
    }

</script>

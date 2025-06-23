<?php
    //koneksi dan session
    include "../../_Config/Connection.php";
    include "../../_Config/GlobalFunction.php";
    include "../../_Config/Session.php";
    date_default_timezone_set("Asia/Jakarta");
    $JmlHalaman=0;
    $page=0;
    //Validasi Akses 
    if(empty($SessionIdAkses)){
        echo '
            <tr>
                <td class="text-center" colspan="4">
                    <small class="text-danger">Sesi Akses Sudah Berakhir. Silahkan Login Ulang!</small>
                </td>
            </tr>
        ';
    }else{

        // Tangkap id_shu_session
        if(empty($_POST['id_shu_session'])){
            echo '
                <tr>
                    <td class="text-center" colspan="4">
                        <small class="text-danger">ID Sesi Akses Tidak Boleh Kosong!</small>
                    </td>
                </tr>
            ';
        } else {

            //Buat variabel
            $id_shu_session=$_POST['id_shu_session'];

            //keyword
            if(!empty($_POST['keyword'])){
                $keyword=$_POST['keyword'];
            }else{
                $keyword="";
            }
            
            //batas
            $batas="10";

            //ShortBy
            $ShortBy="ASC";
            
            //OrderBy
            $OrderBy="nama";
            //Atur Page
            if(!empty($_POST['page'])){
                $page=$_POST['page'];
                $posisi = ( $page - 1 ) * $batas;
            }else{
                $page="1";
                $posisi = 0;
            }
            if(empty($keyword)){
                $jml_data = mysqli_num_rows(mysqli_query($Conn, "SELECT id_anggota FROM anggota WHERE status='Aktif'"));
            }else{
                $jml_data = mysqli_num_rows(mysqli_query($Conn, "SELECT id_anggota FROM anggota WHERE (status='Aktif') AND (nama like '%$keyword%' OR nip like '%$keyword%')"));
            }
            //Mengatur Halaman
            $JmlHalaman = ceil($jml_data/$batas); 

            //Validasi Apabila Jumlah Data Kosong
            if(empty($jml_data)){
                echo '<tr>';
                echo '  <td colspan="4" class="text-center">';
                echo '      <small class="text-danger">';
                echo '          Tidak Ada Data Anggota Yang Dapat Ditampilkan';
                echo '      </small>';
                echo '  </td>';
                echo '</tr>';
            }else{
                $no = 1+$posisi;
                //KONDISI PENGATURAN MASING FILTER
                if(empty($keyword)){
                    $query = mysqli_query($Conn, "SELECT*FROM anggota WHERE status='Aktif' ORDER BY $OrderBy $ShortBy LIMIT $posisi, $batas");
                }else{
                    $query = mysqli_query($Conn, "SELECT*FROM anggota WHERE (status='Aktif') AND (nama like '%$keyword%' OR nip like '%$keyword%') ORDER BY $OrderBy $ShortBy LIMIT $posisi, $batas");
                }
                while ($data = mysqli_fetch_array($query)) {
                    $id_anggota= $data['id_anggota'];
                    $nip= $data['nip'];
                    $nama= $data['nama'];

                    echo '
                        <tr>
                            <td><small>'.$no.'</small></td>
                            <td><small>'.$nama.'</small></td>
                            <td><small>'.$nip.'</small></td>
                            <td>
                                <button type="button" class="btn btn-sm btn-floating btn-secondary" data-bs-toggle="modal" data-bs-target="#ModalTambahRincianManual" data-id_anggota="'.$id_anggota.'" data-id_shu_session="'.$id_shu_session.'">
                                    <i class="bi bi-check"></i>
                                </button>
                            </td>
                        </tr>
                    ';
                    $no++;
                }
            }
        }
    }
?>

<script>
    //Creat Javascript Variabel
    var page_count=<?php echo $JmlHalaman; ?>;
    var curent_page=<?php echo $page; ?>;
    
    //Put Into Pagging Element
    $('#page_infopage_info_anggota').html('Page '+curent_page+' Of '+page_count+'');
    
    //Set Pagging Button
    if(curent_page==1){
        $('#prev_button_anggota').prop('disabled', true);
    }else{
        $('#prev_button_anggota').prop('disabled', false);
    }
    if(page_count<=curent_page){
        $('#next_button_anggota').prop('disabled', true);
    }else{
        $('#next_button_anggota').prop('disabled', false);
    }
</script>
<?php
    //koneksi dan session
    include "../../_Config/Connection.php";
    include "../../_Config/GlobalFunction.php";
    include "../../_Config/Session.php";
    date_default_timezone_set("Asia/Jakarta");
    if(empty($SessionIdAkses)){
        echo '
            <tr>
                <td colspan="8" class="text-center">
                    <small class="text-danger">Sesi Akses Sudah Berakhir. Silahkan Login Ulang!</small>
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
            $OrderBy="id_simpanan";
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
                $jml_data = mysqli_num_rows(mysqli_query($Conn, "SELECT*FROM simpanan"));
            }else{
                $jml_data = mysqli_num_rows(mysqli_query($Conn, "SELECT*FROM simpanan WHERE tanggal like '%$keyword%' OR nama like '%$keyword%' OR kategori like '%$keyword%'"));
            }
        }else{
            if(empty($keyword)){
                $jml_data = mysqli_num_rows(mysqli_query($Conn, "SELECT*FROM simpanan"));
            }else{
                $jml_data = mysqli_num_rows(mysqli_query($Conn, "SELECT*FROM simpanan WHERE $keyword_by like '%$keyword%'"));
            }
        }
        //Mengatur Halaman
        $JmlHalaman = ceil($jml_data/$batas); 
        $prev=$page-1;
        $next=$page+1;
        if($next>$JmlHalaman){
            $next=$page;
        }else{
            $next=$page+1;
        }
        if($prev<"1"){
            $prev="1";
        }else{
            $prev=$page-1;
        }
        if(empty($jml_data)){
            echo '
                <tr>
                    <td colspan="8" class="text-center">
                        <small class="text-danger">Tidak Ada Data Simpanan Yang Ditampilkan!</small>
                    </td>
                </tr>
            ';
        }else{
            $no = 1+$posisi;
            //KONDISI PENGATURAN MASING FILTER
            if(empty($keyword_by)){
                if(empty($keyword)){
                    $query = mysqli_query($Conn, "SELECT*FROM simpanan ORDER BY $OrderBy $ShortBy LIMIT $posisi, $batas");
                }else{
                    $query = mysqli_query($Conn, "SELECT*FROM simpanan WHERE tanggal like '%$keyword%' OR nama like '%$keyword%' OR kategori like '%$keyword%' ORDER BY $OrderBy $ShortBy LIMIT $posisi, $batas");
                }
            }else{
                if(empty($keyword)){
                    $query = mysqli_query($Conn, "SELECT*FROM simpanan ORDER BY $OrderBy $ShortBy LIMIT $posisi, $batas");
                }else{
                    $query = mysqli_query($Conn, "SELECT*FROM simpanan WHERE $keyword_by like '%$keyword%' ORDER BY $OrderBy $ShortBy LIMIT $posisi, $batas");
                }
            }
            while ($data = mysqli_fetch_array($query)) {
                $id_simpanan= $data['id_simpanan'];
                $id_anggota= $data['id_anggota'];
                $id_simpanan_jenis= $data['id_simpanan_jenis'];
                $nip= $data['nip'];
                $nama= $data['nama'];
                $tanggal= $data['tanggal_simpanan'];
                $kategori= $data['kategori'];
                $jumlah= $data['jumlah'];
                $status= $data['status'];
                //Format Rupiah
                $jumlah_format = "Rp " . number_format($jumlah,0,',','.');

                //Routing Kategori
                if($kategori=="Penarikan"){
                    $LabelKategori='<span class="badge bg-danger">Penarikan</span>';
                    $jumlah_format_label='<span class="text-danger">- '.$jumlah_format.'</span>';
                }else{
                    $LabelKategori='<span class="badge bg-success">Simpanan</span>';
                    $jumlah_format_label='<span class="text-dark">'.$jumlah_format.'</span>';
                }
                $nama_simpanan=GetDetailData($Conn,'simpanan_jenis','id_simpanan_jenis',$id_simpanan_jenis,'nama_simpanan');
                
                //Format tanggal
                $TanggalFormat=date('d/m/Y',strtotime($tanggal));

                //Routing Status
                if($status=="Pending"){
                    $label_status='<span class="badge badge-warning">Pending</span>';
                }else{
                    $label_status='<span class="badge badge-success">Lunas</span>';
                }
                echo '
                    <tr>
                        <td><small>'.$no.'</small></td>
                        <td><small>'.$TanggalFormat.'</small></td>
                        <td><small>'.$nama.'</small></td>
                        <td><small>'.$nip.'</small></td>
                        <td><small>'.$kategori.'</small></td>
                        <td><small>'.$jumlah_format.'</small></td>
                        <td><small>'.$label_status.'</small></td>
                        <td>
                            <button type="button" class="btn btn-sm btn-outline-dark btn-floating" data-bs-toggle="dropdown" aria-expanded="false">
                                <i class="bi bi-three-dots"></i>
                            </button>
                            <ul class="dropdown-menu dropdown-menu-end dropdown-menu-arrow" style="">
                                <li class="dropdown-header text-start">
                                    <h6>Option</h6>
                                </li>
                                <li>
                                    <a class="dropdown-item" href="javascript:void(0)" data-bs-toggle="modal" data-bs-target="#ModalDetailSimpanan" data-id="'.$id_simpanan.'">
                                        <i class="bi bi-info-circle"></i> Detail
                                    </a>
                                </li>
                                <li>
                                    <a class="dropdown-item" href="javascript:void(0)" data-bs-toggle="modal" data-bs-target="#ModalHapusSimpanan" data-id="'.$id_simpanan.'">
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
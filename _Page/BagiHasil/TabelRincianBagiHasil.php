<?php
    //koneksi dan session
    include "../../_Config/Connection.php";
    include "../../_Config/GlobalFunction.php";
    include "../../_Config/Session.php";
    date_default_timezone_set("Asia/Jakarta");

    $JmlHalaman =0;
    $page =0;
    if(empty($SessionIdAkses)){
        echo '<div class="row">';
        echo '  <div class="col-md-12 text-center">';
        echo '      <small class="text-danger">Sesi Akses Sudah Berakhir, Silahkan Login Ulang</small>';
        echo '  </div>';
        echo '</div>';
    }else{
        //id_shu_session
        if(empty($_POST['id_shu_session'])){
            echo '<div class="card-body">';
            echo '  <div class="row">';
            echo '      <div class="col col-md-12">';
            echo '          ID Sessi Bagi Hasil Tidak Boleh Kosong';
            echo '      </div>';
            echo '  </div>';
            echo '</div>';
        }else{
            $id_shu_session=$_POST['id_shu_session'];
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
                $OrderBy="id_shu_rincian";
            }
            //Atur Page
            if(!empty($_POST['page'])){
                $page=$_POST['page'];
                $posisi = ( $page - 1 ) * $batas;
            }else{
                $page="1";
                $posisi = 0;
            }

            //Hitung Jumlah Data
            if(empty($keyword_by)){
                if(empty($keyword)){
                    $jml_data = mysqli_num_rows(mysqli_query($Conn, "SELECT id_shu_rincian FROM shu_rincian WHERE id_shu_session='$id_shu_session'"));
                }else{
                    $jml_data = mysqli_num_rows(mysqli_query($Conn, "SELECT id_shu_rincian FROM shu_rincian WHERE (id_shu_session='$id_shu_session') AND (nama_anggota like '%$keyword%' OR nip like '%$keyword%' OR shu like '%$keyword%')"));
                }
            }else{
                if(empty($keyword)){
                    $jml_data = mysqli_num_rows(mysqli_query($Conn, "SELECT id_shu_rincian FROM shu_rincian WHERE id_shu_session='$id_shu_session'"));
                }else{
                    $jml_data = mysqli_num_rows(mysqli_query($Conn, "SELECT id_shu_rincian FROM shu_rincian WHERE (id_shu_session='$id_shu_session') AND ($keyword_by like '%$keyword%')"));
                }
            }
             //Mengatur Halaman
            $JmlHalaman = ceil($jml_data/$batas); 

            $JumlahJasaSimpanan=0;
            $JumlahJasaPinjaman=0;
            $JumlahShu=0;
            if(empty($jml_data)){
                echo '<tr>';
                echo '  <td colspan="8" class="text-center">';
                echo '      <span class="text-danger">Tidak Ada Rincian Bagi Hasil (SHU) Yang Ditampilkan</span>';
                echo '  </td>';
                echo '</tr>';
            }else{
                $no = 1+$posisi;

                //Buat Query Dinamis
                if(empty($keyword_by)){
                    if(empty($keyword)){
                        $query = mysqli_query($Conn, "SELECT*FROM shu_rincian WHERE id_shu_session='$id_shu_session' ORDER BY $OrderBy $ShortBy LIMIT $posisi, $batas");
                    }else{
                        $query = mysqli_query($Conn, "SELECT*FROM shu_rincian WHERE (id_shu_session='$id_shu_session') AND (nama_anggota like '%$keyword%' OR nip like '%$keyword%' OR shu like '%$keyword%') ORDER BY $OrderBy $ShortBy LIMIT $posisi, $batas");
                    }
                }else{
                    if(empty($keyword)){
                        $query = mysqli_query($Conn, "SELECT*FROM shu_rincian WHERE id_shu_session='$id_shu_session' ORDER BY $OrderBy $ShortBy LIMIT $posisi, $batas");
                    }else{
                        $query = mysqli_query($Conn, "SELECT*FROM shu_rincian WHERE (id_shu_session='$id_shu_session') AND ($keyword_by like '%$keyword%') ORDER BY $OrderBy $ShortBy LIMIT $posisi, $batas");
                    }
                }
                
                while ($data = mysqli_fetch_array($query)) {
                    $id_shu_rincian= $data['id_shu_rincian'];
                    $id_anggota= $data['id_anggota'];
                    $nama_anggota= $data['nama_anggota'];
                    $nip= $data['nip'];
                    $simpanan= $data['simpanan'];
                    $pinjaman= $data['pinjaman'];
                    $penjualan= $data['penjualan'];
                    $jasa_simpanan= $data['jasa_simpanan'];
                    $jasa_pinjaman= $data['jasa_pinjaman'];
                    $jasa_penjualan= $data['jasa_penjualan'];
                    $shu= $data['shu'];
                    $JumlahJasaSimpanan=$JumlahJasaSimpanan+$jasa_simpanan;
                    $JumlahJasaPinjaman=$JumlahJasaPinjaman+$jasa_pinjaman;
                    $JumlahShu=$JumlahShu+$shu;
                    //Format Rupiah
                    $simpanan = "" . number_format($simpanan,0,',','.');
                    $pinjaman = "" . number_format($pinjaman,0,',','.');
                    $penjualan = "" . number_format($penjualan,0,',','.');
                    $jasa_simpanan = "Rp " . number_format($jasa_simpanan,0,',','.');
                    $jasa_pinjaman = "Rp " . number_format($jasa_pinjaman,0,',','.');
                    $jasa_penjualan = "Rp " . number_format($jasa_penjualan,0,',','.');
                    $shu_rp = "Rp " . number_format($shu,0,',','.');
                    
                    //Data Anggota
                    $status=GetDetailData($Conn,'anggota','id_anggota',$id_anggota,'status');
                    if($status=="Aktif"){
                        $text_style="text-primary";
                    }else{
                        $text_style="text-danger";
                    }
                    echo '
                        <tr>
                            <td><small>'.$no.'</small></td>
                            <td>
                                <small>
                                    <a href="javascript:void(0);" class="text text-decoration-underline '.$text_style.'" data-bs-toggle="modal" data-bs-target="#ModalDetailAnggota" data-id="'.$id_anggota.'">
                                        '.$nama_anggota.'
                                    </a>
                                </small>
                            </td>
                            <td><small>'.$nip.'</small></td>
                            <td><small class="text-muted">'.$jasa_penjualan.'</small></td>
                            <td><small class="text-muted">'.$jasa_simpanan.'</small></td>
                            <td><small class="text-muted">'.$jasa_pinjaman.'</small></td>
                            <td><small>'.$shu_rp.'</small></td>
                            <td>
                                <button type="button" class="btn btn-sm btn-outline-dark btn-floating" data-bs-toggle="dropdown" aria-expanded="false">
                                    <i class="bi bi-three-dots"></i>
                                </button>
                                <ul class="dropdown-menu dropdown-menu-end dropdown-menu-arrow" style="">
                                    <li class="dropdown-header text-start">
                                        <h6>Option</h6>
                                    </li>
                                    <li>
                                        <a class="dropdown-item" href="javascript:void(0)" data-bs-toggle="modal" data-bs-target="#ModalDetailRincian" data-id="'.$id_shu_rincian.'">
                                            <i class="bi bi-info-circle"></i> Detail
                                        </a>
                                    </li>
                                    <li>
                                        <a class="dropdown-item" href="javascript:void(0)" data-bs-toggle="modal" data-bs-target="#ModalEditRincian" data-id="'.$id_shu_rincian.'">
                                            <i class="bi bi-pencil"></i> Edit Manual
                                        </a>
                                    </li>
                                    <li>
                                        <a class="dropdown-item" href="javascript:void(0)" data-bs-toggle="modal" data-bs-target="#ModalHapusRincianShu" data-id="'.$id_shu_rincian.'">
                                            <i class="bi bi-x"></i> Hapus Manual
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
    }
?>
<script>
    //Creat Javascript Variabel
    var page_count=<?php echo $JmlHalaman; ?>;
    var curent_page=<?php echo $page; ?>;
    
    //Put Into Pagging Element
    $('#page_info_rincian').html('Page '+curent_page+' Of '+page_count+'');
    
    //Set Pagging Button
    if(curent_page==1){
        $('#prev_button_rincian').prop('disabled', true);
    }else{
        $('#prev_button_rincian').prop('disabled', false);
    }
    if(page_count<=curent_page){
        $('#next_button_rincian').prop('disabled', true);
    }else{
        $('#next_button_rincian').prop('disabled', false);
    }
</script>
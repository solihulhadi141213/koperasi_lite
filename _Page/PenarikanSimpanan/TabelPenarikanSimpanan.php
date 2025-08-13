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
                    <small class="text-danger">
                        Tidak Ada Data Pinjaman Yang Dapat Ditampilkan
                    </small>
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
            $OrderBy="id_simpanan_penarikan";
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
                $jml_data = mysqli_num_rows(mysqli_query($Conn, "SELECT*FROM simpanan_penarikan"));
            }else{
                $jml_data = mysqli_num_rows(mysqli_query($Conn, "SELECT*FROM simpanan_penarikan WHERE id_anggota like '%$id_anggota%' OR tanggal like '%$keyword%' OR bank like '%$keyword%' OR nominal like '%$keyword%' OR status like '%$keyword%'"));
            }
        }else{
            if(empty($keyword)){
                $jml_data = mysqli_num_rows(mysqli_query($Conn, "SELECT*FROM simpanan_penarikan"));
            }else{
                $jml_data = mysqli_num_rows(mysqli_query($Conn, "SELECT*FROM simpanan_penarikan WHERE $keyword_by like '%$keyword%'"));
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
                        <small class="text-danger">
                            Tidak Ada Pengajuan Penarikan Dana Simpanan Yang Ditemukan!
                        </small>
                    </td>
                </tr>
            ';
        }else{
            $no = 1+$posisi;
            //KONDISI PENGATURAN MASING FILTER
            if(empty($keyword_by)){
                if(empty($keyword)){
                    $query = mysqli_query($Conn, "SELECT*FROM simpanan_penarikan ORDER BY $OrderBy $ShortBy LIMIT $posisi, $batas");
                }else{
                    $query = mysqli_query($Conn, "SELECT*FROM simpanan_penarikan WHERE id_anggota like '%$id_anggota%' OR tanggal like '%$keyword%' OR bank like '%$keyword%' OR nominal like '%$keyword%' OR status like '%$keyword%' ORDER BY $OrderBy $ShortBy LIMIT $posisi, $batas");
                }
            }else{
                if(empty($keyword)){
                    $query = mysqli_query($Conn, "SELECT*FROM simpanan_penarikan ORDER BY $OrderBy $ShortBy LIMIT $posisi, $batas");
                }else{
                    $query = mysqli_query($Conn, "SELECT*FROM simpanan_penarikan WHERE $keyword_by like '%$keyword%' ORDER BY $OrderBy $ShortBy LIMIT $posisi, $batas");
                }
            }
            while ($data = mysqli_fetch_array($query)) {
                $id_simpanan_penarikan= $data['id_simpanan_penarikan'];
                $id_simpanan_jenis= $data['id_simpanan_jenis'];
                $id_anggota= $data['id_anggota'];
                $tanggal= $data['tanggal'];
                $bank= $data['bank'];
                $rekening= $data['rekening'];
                $nominal= $data['nominal'];
                $status= $data['status'];
                if($status=="Lunas"){
                    $LabelStatus='<span class="badge badge-success">Lunas</span>';
                }else{
                    if($status=="Pending"){
                        $LabelStatus='<span class="badge badge-warning">Pending</span>';
                    }else{
                        if($status=="Ditolak"){
                            $LabelStatus='<span class="badge badge-danger">Ditolak</span>';
                        }else{
                            $LabelStatus='<span class="badge badge-dark">None</span>';
                        }
                    }
                }
                
                //Format Rupiah
                $nominal_format = "Rp " . number_format($nominal,0,',','.');
                
                //Buka Jenis Simpanan
                $nama_simpanan=GetDetailData($Conn, 'simpanan_jenis', 'id_simpanan_jenis', $id_simpanan_jenis, 'nama_simpanan');

                //Buka Nama Anggota
                $NamaAnggota=GetDetailData($Conn, 'anggota', 'id_anggota', $id_anggota, 'nama');
                $nip=GetDetailData($Conn, 'anggota', 'id_anggota', $id_anggota, 'nip');

                //Format Tanggal
                $tanggal_format=date('d/m/Y', strtotime($tanggal));

                //Tampilkan Data
                echo '<tr>';
                echo '
                    <td><small>'.$no.'</small></td>
                    <td><small>'.$NamaAnggota.'</small></td>
                    <td><small>'.$nip.'</small></td>
                    <td><small>'.$tanggal_format.'</small></td>
                    <td><small>'.$nama_simpanan.'</small></td>
                    <td><small>'.$nominal_format.'</small></td>
                    <td><small>'.$LabelStatus.'</small></td>
                ';
                if($status=="Pending"){
                    echo '
                        <td>
                            <a class="btn btn-sm btn-outline-dark btn-floating" href="javascript:void(0);" data-bs-toggle="dropdown" aria-expanded="false">
                                <i class="bi bi-three-dots"></i>
                            </a>
                            <ul class="dropdown-menu dropdown-menu-end dropdown-menu-arrow" style="">
                                <li class="dropdown-header text-start">
                                    <h6>Option</h6>
                                </li>
                                <li>
                                    <a class="dropdown-item" href="javascript:void(0);" data-bs-toggle="modal" data-bs-target="#ModalDetailPenarikan" data-id="'.$id_simpanan_penarikan.'">
                                        <i class="bi bi-info-circle"></i> Detail
                                    </a>
                                </li>
                                <li>
                                    <a class="dropdown-item" href="javascript:void(0);" data-bs-toggle="modal" data-bs-target="#ModalUpdatePenarikan" data-id="'.$id_simpanan_penarikan.'">
                                        <i class="bi bi-repeat"></i> Update Pengajuan
                                    </a>
                                </li>
                                <li>
                                    <a class="dropdown-item" href="javascript:void(0);" data-bs-toggle="modal" data-bs-target="#ModalHapusPenarikan" data-id="'.$id_simpanan_penarikan.'">
                                        <i class="bi bi-trash"></i> Hapus Pengajuan
                                    </a>
                                </li>
                            </ul>
                        </td>
                    ';
                }else{
                    if($status=="Lunas"){
                        echo '
                            <td>
                                <a class="btn btn-sm btn-outline-dark btn-floating" href="javascript:void(0);" data-bs-toggle="dropdown" aria-expanded="false">
                                    <i class="bi bi-three-dots"></i>
                                </a>
                                <ul class="dropdown-menu dropdown-menu-end dropdown-menu-arrow" style="">
                                    <li class="dropdown-header text-start">
                                        <h6>Option</h6>
                                    </li>
                                    <li>
                                        <a class="dropdown-item" href="javascript:void(0);" data-bs-toggle="modal" data-bs-target="#ModalDetailPenarikan" data-id="'.$id_simpanan_penarikan.'">
                                            <i class="bi bi-info-circle"></i> Detail
                                        </a>
                                    </li>
                                </ul>
                            </td>
                        ';
                    }else{
                        echo '
                            <td>
                                <a class="btn btn-sm btn-outline-dark btn-floating" href="javascript:void(0);" data-bs-toggle="dropdown" aria-expanded="false">
                                    <i class="bi bi-three-dots"></i>
                                </a>
                                <ul class="dropdown-menu dropdown-menu-end dropdown-menu-arrow" style="">
                                    <li class="dropdown-header text-start">
                                        <h6>Option</h6>
                                    </li>
                                    <li>
                                        <a class="dropdown-item" href="javascript:void(0);" data-bs-toggle="modal" data-bs-target="#ModalDetailPenarikan" data-id="'.$id_simpanan_penarikan.'">
                                            <i class="bi bi-info-circle"></i> Detail
                                        </a>
                                    </li>
                                    <li>
                                        <a class="dropdown-item" href="javascript:void(0);" data-bs-toggle="modal" data-bs-target="#ModalHapusPenarikan" data-id="'.$id_simpanan_penarikan.'">
                                            <i class="bi bi-trash"></i> Hapus Pengajuan
                                        </a>
                                    </li>
                                </ul>
                            </td>
                        ';
                    }
                }
                
                echo '</tr>';
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
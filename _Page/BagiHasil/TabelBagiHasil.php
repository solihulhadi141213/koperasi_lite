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
            $OrderBy="id_shu_session";
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
                $jml_data = mysqli_num_rows(mysqli_query($Conn, "SELECT id_shu_session FROM shu_session"));
            }else{
                $jml_data = mysqli_num_rows(mysqli_query($Conn, "SELECT id_shu_session FROM shu_session WHERE like '%$keyword%' OR periode_hitung1 like '%$keyword%' OR periode_hitung2 like '%$keyword%' OR status like '%$keyword%'"));
            }
        }else{
            if(empty($keyword)){
                $jml_data = mysqli_num_rows(mysqli_query($Conn, "SELECT id_shu_session FROM shu_session"));
            }else{
                $jml_data = mysqli_num_rows(mysqli_query($Conn, "SELECT id_shu_session FROM shu_session WHERE $keyword_by like '%$keyword%'"));
            }
        }
        //Mengatur Halaman
        $JmlHalaman = ceil($jml_data/$batas); 
        $prev=$page-1;
        $next=$page+1;
        if(empty($jml_data)){
            echo '
                <tr>
                    <td colspan="8" class="text-center">
                        <small class="text-danger">Tidak Ada Data Yang Ditampilkan</small>
                    </td>
                </tr>
            ';
        }else{
            $no = 1+$posisi;
            //KONDISI PENGATURAN MASING FILTER
            if(empty($keyword_by)){
                if(empty($keyword)){
                    $query = mysqli_query($Conn, "SELECT*FROM shu_session ORDER BY $OrderBy $ShortBy LIMIT $posisi, $batas");
                }else{
                    $query = mysqli_query($Conn, "SELECT*FROM shu_session WHERE sesi_shu like '%$keyword%' OR periode_hitung1 like '%$keyword%' OR periode_hitung2 like '%$keyword%' OR status like '%$keyword%' ORDER BY $OrderBy $ShortBy LIMIT $posisi, $batas");
                }
            }else{
                if(empty($keyword)){
                    $query = mysqli_query($Conn, "SELECT*FROM shu_session ORDER BY $OrderBy $ShortBy LIMIT $posisi, $batas");
                }else{
                    $query = mysqli_query($Conn, "SELECT*FROM shu_session WHERE $keyword_by like '%$keyword%' ORDER BY $OrderBy $ShortBy LIMIT $posisi, $batas");
                }
            }
            while ($data = mysqli_fetch_array($query)) {
                $id_shu_session= $data['id_shu_session'];
                $shu= $data['shu'];
                $periode_hitung1= $data['periode_hitung1'];
                $periode_hitung2= $data['periode_hitung2'];
                $persen_penjualan= $data['persen_penjualan'];
                $persen_simpanan= $data['persen_simpanan'];
                $persen_pinjaman= $data['persen_pinjaman'];
                $status= $data['status'];

                //Format Jumlah SHU
                $shu_rp = "" . number_format($shu,0,',','.');

                $periode_hitung1=date('d/m/y',strtotime($periode_hitung1));
                $periode_hitung2=date('d/m/y',strtotime($periode_hitung2));
                
                //Jumlah Anggota
                $JumlahRincian = mysqli_num_rows(mysqli_query($Conn, "SELECT*FROM shu_rincian WHERE id_shu_session='$id_shu_session'"));
                if(empty($JumlahRincian)){
                    $JumlahRincian ='<small class="text-danger">Tidak Ada</small>';
                }else{
                    $JumlahRincian = "" . number_format($JumlahRincian,0,',','.');
                    $JumlahRincian="$JumlahRincian Orang";
                }
                
                //Jumlah Rincian SHU
                $sum_alokasi= mysqli_fetch_array(mysqli_query($Conn, "SELECT SUM(shu) AS jumlah FROM shu_rincian WHERE id_shu_session='$id_shu_session'"));
                if(!empty($sum_alokasi['jumlah'])){
                    $jumlah_alokasi = $sum_alokasi['jumlah'];
                }else{
                    $jumlah_alokasi =0;
                }
                $jumlah_alokasi_rp = "" . number_format($jumlah_alokasi,0,',','.');

                //Jumlah Jurnal
                $jumlah_jurnal = mysqli_num_rows(mysqli_query($Conn, "SELECT*FROM jurnal WHERE id_shu_session='$id_shu_session'"));
                if(empty($jumlah_jurnal)){
                    $label_jurnal='<span class="badge badge-secondary">NULL</span>';
                }else{
                    $label_jurnal='<span class="badge badge-primary">'.$jumlah_jurnal.' Record</span>';
                }
                //Label Status
                if($status=="Pending"){
                    $LabelStatus='<span class="badge badge-warning">Pending</span>';
                }else{
                    $LabelStatus='<span class="badge badge-success">'.$status.'</span>';
                }
                echo '
                    <tr>
                        <td><small>'.$no.'</small></td>
                        <td>
                            <a href="javascript:void(0)" data-bs-toggle="modal" data-bs-target="#ModalDetailBagiHasil" data-id="'.$id_shu_session.'">
                                <small><code class="text-primary">'.$periode_hitung1.' - '.$periode_hitung2.'</code></small>
                            </a>
                        </td>
                        <td><small>'.$JumlahRincian.'</small></td>
                        <td><small>'.$shu_rp.'</small></td>
                        <td><small>'.$jumlah_alokasi_rp.'</small></td>
                        <td>'.$label_jurnal.'</td>
                        <td>'.$LabelStatus.'</td>
                        <td>
                            <button type="button" class="btn btn-sm btn-outline-dark btn-floating" data-bs-toggle="dropdown" aria-expanded="false">
                                <i class="bi bi-three-dots"></i>
                            </button>
                            <ul class="dropdown-menu dropdown-menu-end dropdown-menu-arrow" style="">
                                <li class="dropdown-header text-start">
                                    <h6>Option</h6>
                                </li>
                                <li>
                                    <a class="dropdown-item" href="javascript:void(0)" data-bs-toggle="modal" data-bs-target="#ModalDetailBagiHasil" data-id="'.$id_shu_session.'">
                                        <i class="bi bi-info-circle"></i> Detail
                                    </a>
                                </li>
                                <li>
                                    <a class="dropdown-item" href="javascript:void(0)" data-bs-toggle="modal" data-bs-target="#ModalEditBagiHasil" data-id="'.$id_shu_session.'">
                                        <i class="bi bi-pencil"></i> Edit
                                    </a>
                                </li>
                                <li>
                                    <a class="dropdown-item" href="javascript:void(0)" data-bs-toggle="modal" data-bs-target="#ModalHapusBagiHasil" data-id="'.$id_shu_session.'">
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
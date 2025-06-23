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
                    <small>Sesi Akses Sudah Berakhir! Silahkan Login Ulang</small>
                </td>
            </tr>
        ';
    }else{
        if(empty($_POST['id_anggota'])){
            echo '
                <tr>
                    <td colspan="9" class="text-center text-danger">
                        <small>ID Anggota Tidak Boleh Kosong!</small>
                    </td>
                </tr>
            ';
        }else{
            $id_anggota=validateAndSanitizeInput($_POST['id_anggota']);

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
                    $jml_data = mysqli_num_rows(mysqli_query($Conn, "SELECT id_pinjaman FROM pinjaman WHERE id_anggota='$id_anggota'"));
                }else{
                    $jml_data = mysqli_num_rows(mysqli_query($Conn, "SELECT id_pinjaman FROM pinjaman WHERE (id_anggota='$id_anggota') AND (tanggal like '%$keyword%' OR jumlah_pinjaman like '%$keyword%' OR status like '%$keyword%')"));
                }
            }else{
                if(empty($keyword)){
                    $jml_data = mysqli_num_rows(mysqli_query($Conn, "SELECT id_pinjaman FROM pinjaman WHERE id_anggota='$id_anggota'"));
                }else{
                    $jml_data = mysqli_num_rows(mysqli_query($Conn, "SELECT id_pinjaman FROM pinjaman WHERE (id_anggota='$id_anggota') AND ($keyword_by like '%$keyword%')"));
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
                        $query = mysqli_query($Conn, "SELECT*FROM pinjaman WHERE id_anggota='$id_anggota' ORDER BY $OrderBy $ShortBy LIMIT $posisi, $batas");
                    }else{
                        $query = mysqli_query($Conn, "SELECT*FROM pinjaman WHERE (id_anggota='$id_anggota') AND (tanggal like '%$keyword%' OR jumlah_pinjaman like '%$keyword%' OR status like '%$keyword%') ORDER BY $OrderBy $ShortBy LIMIT $posisi, $batas");
                    }
                }else{
                    if(empty($keyword)){
                        $query = mysqli_query($Conn, "SELECT*FROM pinjaman WHERE id_anggota='$id_anggota' ORDER BY $OrderBy $ShortBy LIMIT $posisi, $batas");
                    }else{
                        $query = mysqli_query($Conn, "SELECT*FROM pinjaman WHERE (id_anggota='$id_anggota') AND ($keyword_by like '%$keyword%') ORDER BY $OrderBy $ShortBy LIMIT $posisi, $batas");
                    }
                }
                while ($data = mysqli_fetch_array($query)) {
                    $id_pinjaman= $data['id_pinjaman'];
                    $tanggal= $data['tanggal'];
                    $jumlah_pinjaman= $data['jumlah_pinjaman'];
                    $periode_angsuran= $data['periode_angsuran'];
                    $angsuran_total= $data['angsuran_total'];
                    $status= $data['status'];

                    //Format Tanggal
                    $tanggal=date('d/m/Y',strtotime($tanggal));
                    
                    //Periode Angsuran Masuk
                    $JumlahAngsuranBerjalan = mysqli_num_rows(mysqli_query($Conn, "SELECT*FROM pinjaman_angsuran WHERE id_pinjaman='$id_pinjaman'"));
                    
                    //Jumlah Angsuran Masuk
                    $SumAngsuran = mysqli_fetch_array(mysqli_query($Conn, "SELECT SUM(jumlah) AS jumlah FROM pinjaman_angsuran WHERE id_pinjaman='$id_pinjaman'"));
                    $JumlahAngsuran = $SumAngsuran['jumlah'];

                    //Hitung Sisa Pinjaman
                    $SumAngsuranPokok = mysqli_fetch_array(mysqli_query($Conn, "SELECT SUM(pokok) AS pokok FROM pinjaman_angsuran WHERE id_pinjaman='$id_pinjaman'"));
                    $JumlahAngsuranPokok = $SumAngsuranPokok['pokok'];
                    $sis_pinjaman=$jumlah_pinjaman-$JumlahAngsuranPokok;
                    
                    //Format Rp
                    $jumlah_pinjaman = "Rp " . number_format($jumlah_pinjaman,0,',','.');
                    $NominalAngsuran = "Rp " . number_format($angsuran_total,0,',','.');
                    $JumlahAngsuran = "Rp " . number_format($JumlahAngsuran,0,',','.');
                    $JumlahSisaPinjaman = "Rp " . number_format($sis_pinjaman,0,',','.');

                    //Cek Data Jurnal
                    $jumlah_jurnal = mysqli_num_rows(mysqli_query($Conn, "SELECT id_simpanan FROM jurnal WHERE id_pinjaman='$id_pinjaman'"));
                    if(empty($jumlah_jurnal)){
                        $label_jurnal='<span class="badge badge-danger">None</span>';
                    }else{
                        $label_jurnal='<span class="badge badge-success">Tersedia</span>';
                    }
                    if($status=="Lunas"){
                        $label_status='<span class="badge badge-success">Lunas</span>';
                    }else{
                        $label_status='<span class="badge badge-warning">Berjalan</span>';
                    }
                    echo '
                        <tr>
                            <td><small>'.$no.'</small></td>
                            <td>
                                <a href="javascript:void(0);" data-bs-toggle="modal" data-bs-target="#ModalDetailPinjamanAnggota" data-id="'.$id_pinjaman.'">
                                    <small>'.$tanggal.'</small>
                                </a>
                            </td>
                            <td><small>'.$jumlah_pinjaman.'</small></td>
                            <td><small>'.$NominalAngsuran.'</small></td>
                            <td><small>'.$JumlahAngsuranBerjalan.' / '.$periode_angsuran.'</small></td>
                            <td><small>'.$JumlahAngsuran.'</small></td>
                            <td><small>'.$JumlahSisaPinjaman.'</small></td>
                            <td><small>'.$label_jurnal.'</small></td>
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
    $('#page_info_riwayat_pinjaman').html('Page '+curent_page+' Of '+page_count+'');
    
    //Set Pagging Button
    if(curent_page==1){
        $('#prev_button_riwayat_pinjaman').prop('disabled', true);
    }else{
        $('#prev_button_riwayat_pinjaman').prop('disabled', false);
    }
    if(page_count<=curent_page){
        $('#next_button_riwayat_pinjaman').prop('disabled', true);
    }else{
        $('#next_button_riwayat_pinjaman').prop('disabled', false);
    }
</script>

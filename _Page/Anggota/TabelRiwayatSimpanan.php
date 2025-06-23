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
                <td colspan="5" class="text-center text-danger">
                    <small>Sesi Akses Sudah Berakhir! Silahkan Login Ulang</small>
                </td>
            </tr>
        ';
    }else{
        if(empty($_POST['id_anggota'])){
            echo '
                <tr>
                    <td colspan="5" class="text-center text-danger">
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
                    $jml_data = mysqli_num_rows(mysqli_query($Conn, "SELECT id_simpanan FROM simpanan WHERE id_anggota='$id_anggota'"));
                }else{
                    $jml_data = mysqli_num_rows(mysqli_query($Conn, "SELECT id_simpanan FROM simpanan WHERE (id_anggota='$id_anggota') AND (tanggal like '%$keyword%' OR kategori like '%$keyword%' OR jumlah like '%$keyword%')"));
                }
            }else{
                if(empty($keyword)){
                    $jml_data = mysqli_num_rows(mysqli_query($Conn, "SELECT id_simpanan FROM simpanan WHERE id_anggota='$id_anggota'"));
                }else{
                    $jml_data = mysqli_num_rows(mysqli_query($Conn, "SELECT id_simpanan FROM simpanan WHERE (id_anggota='$id_anggota') AND ($keyword_by like '%$keyword%')"));
                }
            }
            if(empty($jml_data)){
                echo '
                    <tr>
                        <td colspan="5" class="text-center text-danger">
                            Tidak Ada Data Yang Ditampilkan.
                        </td>
                    </tr>
                ';
            }else{
                $no = 1+$posisi;
                //KONDISI PENGATURAN MASING FILTER
                if(empty($keyword_by)){
                    if(empty($keyword)){
                        $query = mysqli_query($Conn, "SELECT*FROM simpanan WHERE id_anggota='$id_anggota' ORDER BY $OrderBy $ShortBy LIMIT $posisi, $batas");
                    }else{
                        $query = mysqli_query($Conn, "SELECT*FROM simpanan WHERE (id_anggota='$id_anggota') AND (tanggal like '%$keyword%' OR kategori like '%$keyword%' OR jumlah like '%$keyword%') ORDER BY $OrderBy $ShortBy LIMIT $posisi, $batas");
                    }
                }else{
                    if(empty($keyword)){
                        $query = mysqli_query($Conn, "SELECT*FROM simpanan WHERE id_anggota='$id_anggota' ORDER BY $OrderBy $ShortBy LIMIT $posisi, $batas");
                    }else{
                        $query = mysqli_query($Conn, "SELECT*FROM simpanan WHERE (id_anggota='$id_anggota') AND ($keyword_by like '%$keyword%') ORDER BY $OrderBy $ShortBy LIMIT $posisi, $batas");
                    }
                }
                while ($data = mysqli_fetch_array($query)) {
                    $id_simpanan= $data['id_simpanan'];
                    $id_simpanan_jenis= $data['id_simpanan_jenis'];
                    $tanggal= $data['tanggal'];
                    $kategori= $data['kategori'];
                    $jumlah= $data['jumlah'];
                    $keterangan= $data['keterangan'];
                    $rutin= $data['rutin'];
                    
                    //Format Data
                    $jumlah_rp = "Rp " . number_format($jumlah,0,',','.');
                    $tanggal=date('d F Y', strtotime($tanggal));

                    //Cek Data Jurnal
                    $jumlah_jurnal = mysqli_num_rows(mysqli_query($Conn, "SELECT id_simpanan FROM jurnal WHERE id_simpanan='$id_simpanan'"));
                    if(empty($jumlah_jurnal)){
                        $label_jurnal='<span class="badge badge-danger">None</span>';
                    }else{
                        $label_jurnal='<span class="badge badge-success">Tersedia</span>';
                    }

                    //Label Jenis Siimpanan
                    $nama_jenis_simpanan=GetDetailData($Conn, 'simpanan_jenis', 'id_simpanan_jenis', $id_simpanan_jenis, 'nama_simpanan');
                    if($kategori=="Penarikan"){
                        $label_kategori='<span class="badge badge-danger">Penarikan ('.$nama_jenis_simpanan.')</span>';
                    }else{
                        $label_kategori='<span class="badge badge-info">'.$kategori.'</span>';
                    }
                    echo '
                        <tr>
                            <td><small>'.$no.'</small></td>
                            <td><small>'.$tanggal.'</small></td>
                            <td><small>'.$label_kategori.'</small></td>
                            <td><small>'.$jumlah_rp.'</small></td>
                            <td><small>'.$label_jurnal.'</small></td>
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
    $('#page_info_riwayat_simpanan').html('Page '+curent_page+' Of '+page_count+'');
    
    //Set Pagging Button
    if(curent_page==1){
        $('#prev_button_riwayat_simpanan').prop('disabled', true);
    }else{
        $('#prev_button_riwayat_simpanan').prop('disabled', false);
    }
    if(page_count<=curent_page){
        $('#next_button_riwayat_simpanan').prop('disabled', true);
    }else{
        $('#next_button_riwayat_simpanan').prop('disabled', false);
    }
</script>

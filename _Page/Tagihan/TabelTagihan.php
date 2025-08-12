<?php
    //koneksi dan session
    include "../../_Config/Connection.php";
    include "../../_Config/GlobalFunction.php";
    include "../../_Config/Session.php";
    date_default_timezone_set("Asia/Jakarta");
    if(empty($SessionIdAkses)){
        echo '<div class="row">';
        echo '  <div class="col-md-12 text-center">';
        echo '      <small class="text-danger">Sesi Akses Sudah Berakhir, Silahkan Login Ulang</small>';
        echo '  </div>';
        echo '</div>';
    }else{
        //periode_tahun
        if(!empty($_POST['periode_tahun'])){
            $periode_tahun=$_POST['periode_tahun'];
        }else{
            $periode_tahun=date('Y');
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
        //Atur Page
        if(!empty($_POST['page'])){
            $page=$_POST['page'];
            $posisi = ( $page - 1 ) * $batas;
        }else{
            $page="1";
            $posisi = 0;
        }
        //orderby
        $OrderBy="nama";
        $ShortBy="ASC";
         if(empty($keyword)){
            $jml_data = mysqli_num_rows(mysqli_query($Conn, "SELECT*FROM anggota"));
        }else{
            $jml_data = mysqli_num_rows(mysqli_query($Conn, "SELECT*FROM anggota WHERE nip like '%$keyword%' OR nama like '%$keyword%'"));
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
        $no = 1+$posisi;
        //KONDISI PENGATURAN MASING FILTER
        if(empty($keyword)){
            $query = mysqli_query($Conn, "SELECT*FROM anggota ORDER BY $OrderBy $ShortBy LIMIT $posisi, $batas");
        }else{
            $query = mysqli_query($Conn, "SELECT*FROM anggota WHERE nip like '%$keyword%' OR nama like '%$keyword%' ORDER BY $OrderBy $ShortBy LIMIT $posisi, $batas");
        }
        while ($data = mysqli_fetch_array($query)) {
            $id_anggota= $data['id_anggota'];
            $nama= $data['nama'];

            //Tampilkan Row
            echo '<tr>';
            echo '  <td><small>'.$no.'</small></td>';
            echo '  <td><small>'.$nama.'</small></td>';
            for ($i = 1; $i <= 12; $i++) {
                $bulan = str_pad($i, 2, '0', STR_PAD_LEFT);
                $tahun_bulan="$periode_tahun-$bulan";
                
                // Buka Detail Angsuran Masing-Masing
                $QryPinjamanAngsuran = mysqli_query($Conn,"SELECT * FROM pinjaman_angsuran WHERE id_anggota='$id_anggota' AND tanggal_angsuran LIKE '%$tahun_bulan%'")or die(mysqli_error($Conn));
                $DataPinjamanAngsuran = mysqli_fetch_array($QryPinjamanAngsuran);
                if(empty($DataPinjamanAngsuran['id_pinjaman_angsuran'])){
                    echo '
                        <td>
                            <small class="text-dark">-</small>
                        </td>
                    ';
                }else{
                    $id_pinjaman_angsuran=$DataPinjamanAngsuran['id_pinjaman_angsuran'];
                    $tanggal_angsuran=$DataPinjamanAngsuran['tanggal_angsuran'];
                    $jumlah_angsuran=$DataPinjamanAngsuran['jumlah'];
                    $StatusAngsuran=$DataPinjamanAngsuran['status'];
                    $jumlah_angsuran_rupiah = "Rp " . number_format($jumlah_angsuran, 0, ',', '.');

                    //Rout Berdasarkan Status Angsuran
                    if($StatusAngsuran=="None"){

                        //Angsuran Jatuh Tempo
                        if($tanggal_angsuran<date('Y-m-d')){
                            echo '
                                <td>
                                    <a href="javascript:void(0);" class="badge badge-danger" data-bs-toggle="modal" data-bs-target="#ModalDetailAngsuran" data-id="'.$id_pinjaman_angsuran.'">
                                        '.$jumlah_angsuran_rupiah.'
                                    </a>
                                </td>
                            ';
                        }else{
                            echo '
                                <td>
                                    <a href="javascript:void(0);" class="badge badge-dark" data-bs-toggle="modal" data-bs-target="#ModalDetailAngsuran" data-id="'.$id_pinjaman_angsuran.'">
                                        '.$jumlah_angsuran_rupiah.'
                                    </a>
                                </td>
                            ';
                        }
                        
                    }else{
                        if($StatusAngsuran=="Pending"){
                            echo '
                                <td>
                                    <a href="javascript:void(0);" class="badge badge-warning" data-bs-toggle="modal" data-bs-target="#ModalDetailAngsuran" data-id="'.$id_pinjaman_angsuran.'">
                                        '.$jumlah_angsuran_rupiah.'
                                    </a>
                                </td>
                            ';
                        }else{
                            if($StatusAngsuran=="Lunas"){
                                echo '
                                    <td>
                                        <a href="javascript:void(0);" class="badge badge-success" data-bs-toggle="modal" data-bs-target="#ModalDetailAngsuran" data-id="'.$id_pinjaman_angsuran.'">
                                            '.$jumlah_angsuran_rupiah.'
                                        </a>
                                    </td>
                                ';
                            }else{
                                echo '
                                    <td>
                                        <small class="text-danger">Error</small>
                                    </td>
                                ';
                            }
                        }
                    }
                }
            }
            echo '</tr>';
            $no++;
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
<?php
    }
?>
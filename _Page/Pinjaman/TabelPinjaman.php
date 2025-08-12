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
            $OrderBy="id_pinjaman";
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
                $jml_data = mysqli_num_rows(mysqli_query($Conn, "SELECT*FROM pinjaman"));
            }else{
                $jml_data = mysqli_num_rows(mysqli_query($Conn, "SELECT*FROM pinjaman WHERE tanggal_pengajuan like '%$keyword%' OR tanggal_pencairan like '%$keyword%' OR tanggal like '%$keyword%' OR jumlah_pinjaman like '%$keyword%' OR status like '%$keyword%'"));
            }
        }else{
            if(empty($keyword)){
                $jml_data = mysqli_num_rows(mysqli_query($Conn, "SELECT*FROM pinjaman"));
            }else{
                $jml_data = mysqli_num_rows(mysqli_query($Conn, "SELECT*FROM pinjaman WHERE $keyword_by like '%$keyword%'"));
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
?>
        <div class="row mb-3">
            <div class="table table-responsive">
                <table class="table table-striped table-hover">
                    <thead>
                        <tr>
                            <td align="center"><b>No</b></td>
                            <td align="left"><b>Tanggal</b></td>
                            <td align="left"><b>Nama Anggota</b></td>
                            <td align="left"><b>NIK</b></td>
                            <td align="left"><b>Jumlah Pinjaman</b></td>
                            <td align="left"><b>Angsuran Masuk</b></td>
                            <td align="left"><b>Status</b></td>
                            <td align="center"><b>Opsi</b></td>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                            if(empty($jml_data)){
                                echo '<tr>';
                                echo '  <td colspan="8" class="text-center">';
                                echo '      <code class="text-danger">';
                                echo '          Tidak Ada Data Pinjaman Yang Dapat Ditampilkan';
                                echo '      </code>';
                                echo '  </td>';
                                echo '</tr>';
                            }else{
                                $no = 1+$posisi;
                                //KONDISI PENGATURAN MASING FILTER
                                if(empty($keyword_by)){
                                    if(empty($keyword)){
                                        $query = mysqli_query($Conn, "SELECT*FROM pinjaman ORDER BY $OrderBy $ShortBy LIMIT $posisi, $batas");
                                    }else{
                                        $query = mysqli_query($Conn, "SELECT*FROM pinjaman WHERE tanggal_pengajuan like '%$keyword%' OR tanggal_pencairan like '%$keyword%' OR tanggal like '%$keyword%' OR jumlah_pinjaman like '%$keyword%' OR status like '%$keyword%' ORDER BY $OrderBy $ShortBy LIMIT $posisi, $batas");
                                    }
                                }else{
                                    if(empty($keyword)){
                                        $query = mysqli_query($Conn, "SELECT*FROM pinjaman ORDER BY $OrderBy $ShortBy LIMIT $posisi, $batas");
                                    }else{
                                        $query = mysqli_query($Conn, "SELECT*FROM pinjaman WHERE $keyword_by like '%$keyword%' ORDER BY $OrderBy $ShortBy LIMIT $posisi, $batas");
                                    }
                                }
                                while ($data = mysqli_fetch_array($query)) {
                                    $id_pinjaman= $data['id_pinjaman'];
                                    $id_anggota= $data['id_anggota'];
                                    $id_pinjaman_jenis= $data['id_pinjaman_jenis'];
                                    $tanggal_pengajuan= $data['tanggal_pengajuan'];
                                    $tanggal_pencairan= $data['tanggal_pencairan'];
                                    $tanggal= $data['tanggal'];
                                    $jumlah_pinjaman= $data['jumlah_pinjaman'];
                                    $status= $data['status'];
                                    if($status=="Berjalan"){
                                        $LabelStatus='<span class="badge badge-info">Berjalan</span>';
                                    }else{
                                        if($status=="Lunas"){
                                            $LabelStatus='<span class="badge badge-success">Lunas</span>';
                                        }else{
                                            if($status=="Macet"){
                                                $LabelStatus='<span class="badge badge-danger">Macet</span>';
                                            }else{
                                               if($status=="Pending"){
                                                    $LabelStatus='<span class="badge badge-danger">Pending</span>';
                                                }else{
                                                    $LabelStatus='<span class="badge badge-dark">None</span>';
                                                }
                                            }
                                        }
                                    }
                                   
                                    //Format Rupiah
                                    $jumlah_pinjaman_format = "Rp " . number_format($jumlah_pinjaman,0,',','.');
                                    
                                    //Sum Data Angsuran
                                    $Sum = mysqli_fetch_array(mysqli_query($Conn, "SELECT SUM(jumlah) AS total FROM pinjaman_angsuran WHERE id_pinjaman='$id_pinjaman' AND status='Lunas'"));
                                    $JumlahAngsuran = $Sum['total'];
                                    $JumlahAngsuranFormat = "Rp " . number_format($JumlahAngsuran,0,',','.');

                                    //Buka Jenis Pinjaman
                                    $nama_jenis_pinjaman=GetDetailData($Conn, 'pinjaman_jenis', 'id_pinjaman_jenis', $id_pinjaman_jenis, 'nama_pinjaman');

                                    //Buka Nama Anggota
                                    $NamaAnggota=GetDetailData($Conn, 'anggota', 'id_anggota', $id_anggota, 'nama');
                                    $nip=GetDetailData($Conn, 'anggota', 'id_anggota', $id_anggota, 'nip');

                                    //Format Tanggal
                                    $tanggal_pengajuan_format=date('d/m/Y', strtotime($tanggal_pengajuan));
                        ?>
                                    <tr>
                                        <td align="center">
                                            <small class="credit"><?php echo $no; ?></small>
                                        </td>
                                        <td align="left">
                                            <small><?php echo $tanggal_pengajuan_format; ?></small>
                                        </td>
                                        <td align="left">
                                            <?php 
                                                echo "$NamaAnggota"; 
                                            ?>
                                        </td>
                                        <td align="left">
                                            <small class="credit">
                                                <?php 
                                                    echo "$nip<br>"; 
                                                ?>
                                            </small>
                                        </td>
                                        <td align="left">
                                            <small class="credit">
                                                <?php 
                                                    echo "$jumlah_pinjaman_format"; 
                                                ?>
                                            </small>
                                        </td>
                                        <td align="left">
                                            <small class="credit">
                                                <?php 
                                                    echo "$JumlahAngsuranFormat"; 
                                                ?>
                                            </small>
                                        </td>
                                        <td align="left">
                                            <?php echo $LabelStatus; ?>
                                        </td>
                                        <td align="center">
                                            <a class="btn btn-sm btn-outline-dark btn-floating" href="javascript:void(0);" data-bs-toggle="dropdown" aria-expanded="false">
                                                <i class="bi bi-three-dots"></i>
                                            </a>
                                            <ul class="dropdown-menu dropdown-menu-end dropdown-menu-arrow" style="">
                                                <li class="dropdown-header text-start">
                                                    <h6>Option</h6>
                                                </li>
                                                <li>
                                                    <a class="dropdown-item" href="javascript:void(0)" data-bs-toggle="modal" data-bs-target="#ModalDetailPinjaman" data-id="<?php echo "$id_pinjaman"; ?>">
                                                        <i class="bi bi-info-circle"></i> Detail Pinjaman
                                                    </a>
                                                </li>
                                                <?php
                                                    //Melakukan Routing Option Berdasarkan Status Pinjaman
                                                    if($status=="Pending"){
                                                        echo '
                                                            <li>
                                                                <a class="dropdown-item" href="javascript:void(0)" data-bs-toggle="modal" data-bs-target="#ModalUpdatePinjaman" data-id="'.$id_pinjaman.'">
                                                                    <i class="bi bi-pencil"></i> Update Status
                                                                </a>
                                                            </li>
                                                            <li>
                                                                <a class="dropdown-item" href="javascript:void(0)" data-bs-toggle="modal" data-bs-target="#ModalHapusPinjaman" data-id="'.$id_pinjaman.'">
                                                                    <i class="bi bi-x"></i> Hapus Pinjaman
                                                                </a>
                                                            </li>
                                                        ';
                                                    }else{
                                                        if($status=="Ditolak"){
                                                            echo '
                                                                <li>
                                                                    <a class="dropdown-item" href="javascript:void(0)" data-bs-toggle="modal" data-bs-target="#ModalHapusPinjaman" data-id="'.$id_pinjaman.'">
                                                                        <i class="bi bi-x"></i> Hapus Pinjaman
                                                                    </a>
                                                                </li>
                                                            ';
                                                        }
                                                    }
                                                ?>
                                            </ul>
                                        </td>
                                    </tr>
                        <?php
                                    $no++; 
                                }
                            }
                        ?>
                    </tbody>
                </table>
            </div>
        </div>
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
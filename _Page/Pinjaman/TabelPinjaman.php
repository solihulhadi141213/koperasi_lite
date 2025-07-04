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
                $jml_data = mysqli_num_rows(mysqli_query($Conn, "SELECT*FROM pinjaman WHERE nama like '%$keyword%' OR nip like '%$keyword%' OR tanggal like '%$keyword%' OR jumlah_pinjaman like '%$keyword%' OR status like '%$keyword%'"));
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
        <script>
            //ketika klik next
            $('#NextPage').click(function() {
                var page=$('#NextPage').val();
                $('#page').val(page);
                var ProsesFilter = $('#ProsesFilter').serialize();
                $.ajax({
                    type: 'POST',
                    url: '_Page/Pinjaman/TabelPinjaman.php',
                    data: ProsesFilter,
                    success: function(data) {
                        $('#MenampilkanTabelPinjaman').html(data);
                    }
                });
            });
            //Ketika klik Previous
            $('#PrevPage').click(function() {
                var page = $('#PrevPage').val();
                $('#page').val(page);
                var ProsesFilter = $('#ProsesFilter').serialize();
                $.ajax({
                    type: 'POST',
                    url: '_Page/Pinjaman/TabelPinjaman.php',
                    data: ProsesFilter,
                    success: function(data) {
                        $('#MenampilkanTabelPinjaman').html(data);
                    }
                });
            });
        </script>
        <!-- <div class="row">
            <div class="col-md-3">
                <small class="credit">
                    Halaman : <code class="text-grayish"><?php echo "$page/$JmlHalaman"; ?></code>
                </small><br>
                <small class="credit">
                    Jumlah Data : <code class="text-grayish"><?php echo "$jml_data"; ?></code>
                </small>
            </div>
        </div> -->
        <div class="row mb-3">
            <div class="table table-responsive">
                <table class="table table-striped table-hover">
                    <thead>
                        <tr>
                            <td align="center"><b>No</b></td>
                            <td align="left"><b>Tanggal</b></td>
                            <td align="left"><b>Nama Anggota</b></td>
                            <td align="left"><b>No.Induk</b></td>
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
                                        $query = mysqli_query($Conn, "SELECT*FROM pinjaman WHERE nama like '%$keyword%' OR nip like '%$keyword%' OR tanggal like '%$keyword%' OR jumlah_pinjaman like '%$keyword%' OR status like '%$keyword%' ORDER BY $OrderBy $ShortBy LIMIT $posisi, $batas");
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
                                    $uuid_pinjaman= $data['uuid_pinjaman'];
                                    $id_anggota= $data['id_anggota'];
                                    $id_pinjaman_jenis= $data['id_pinjaman_jenis'];
                                    $nama= $data['nama'];
                                    $nip= $data['nip'];
                                    $tanggal= $data['tanggal'];
                                    $jatuh_tempo= $data['jatuh_tempo'];
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
                                                $LabelStatus='<span class="badge badge-dark">None</span>';
                                            }
                                        }
                                    }
                                    //Format tanggal
                                    $strtotime=strtotime($tanggal);
                                    $TanggalFormat=date('d/m/Y',$strtotime);
                                    //Format Rupiah
                                    $jumlah_pinjaman_format = "Rp " . number_format($jumlah_pinjaman,0,',','.');
                                    
                                    //Sum Data Angsuran
                                    $Sum = mysqli_fetch_array(mysqli_query($Conn, "SELECT SUM(jumlah) AS total FROM pinjaman_angsuran WHERE id_pinjaman='$id_pinjaman'"));
                                    $JumlahAngsuran = $Sum['total'];
                                    $JumlahAngsuranFormat = "Rp " . number_format($JumlahAngsuran,0,',','.');
                                    
                                    //Row Data Angsuran
                                    $JumlahDataAngsuran = mysqli_num_rows(mysqli_query($Conn, "SELECT*FROM pinjaman_angsuran WHERE id_pinjaman='$id_pinjaman'"));
                                    if(empty($JumlahDataAngsuran)){
                                        $LabelAngsuran='<code class="text text-danger">0 Record</code>';
                                    }else{
                                        $LabelAngsuran='<code class="text text-grayish">'.$JumlahDataAngsuran.' Record</code>';
                                    }

                                    //Buka Jenis Pinjaman
                                    $nama_jenis_pinjaman=GetDetailData($Conn, 'pinjaman_jenis', 'id_pinjaman_jenis', $id_pinjaman_jenis, 'nama_pinjaman');
                        ?>
                                    <tr>
                                        <td align="center">
                                            <small class="credit"><?php echo $no; ?></small>
                                        </td>
                                        <td align="left">
                                            <a href="javascript:void(0);" data-bs-toggle="modal" data-bs-target="#ModalDetailPinjaman" data-id="<?php echo "$id_pinjaman"; ?>">
                                                <small><?php echo $TanggalFormat; ?></small>
                                            </a>
                                        </td>
                                        <td align="left">
                                            <?php 
                                                echo "$nama"; 
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
                                                        <i class="bi bi-info-circle"></i> Detail
                                                    </a>
                                                </li>
                                                <!-- <li>
                                                    <a class="dropdown-item" href="javascript:void(0)" data-bs-toggle="modal" data-bs-target="#ModalDetailAngsuran" data-id="<?php echo "$id_pinjaman"; ?>">
                                                        <i class="bi bi-table"></i> Angsuran
                                                    </a>
                                                </li> -->
                                                <li>
                                                    <a class="dropdown-item" href="javascript:void(0)" data-bs-toggle="modal" data-bs-target="#ModalEditPinjamanAnggota" data-id="<?php echo "$id_pinjaman"; ?>">
                                                        <i class="bi bi-pencil"></i> Edit
                                                    </a>
                                                </li>
                                                <li>
                                                    <a class="dropdown-item" href="javascript:void(0)" data-bs-toggle="modal" data-bs-target="#ModalHapusPinjaman" data-id="<?php echo "$id_pinjaman"; ?>">
                                                        <i class="bi bi-x"></i> Hapus
                                                    </a>
                                                </li>
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
        <div class="row mb-3">
            <div class="col-md-12 text-center">
                <div class="btn-group shadow-0" role="group" aria-label="Basic example">
                    <button class="btn btn-sm btn-info" id="PrevPage" value="<?php echo $prev;?>">
                        <i class="bi bi-chevron-left"></i>
                    </button>
                    <button class="btn btn-sm btn-outline-info">
                        <?php echo "$page of $JmlHalaman"; ?>
                    </button>
                    <button class="btn btn-sm btn-info" id="NextPage" value="<?php echo $next;?>">
                        <i class="bi bi-chevron-right"></i>
                    </button>
                </div>
            </div>
        </div>
<?php
    }
?>
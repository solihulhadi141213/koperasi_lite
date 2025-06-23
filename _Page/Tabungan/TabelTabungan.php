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
?>
        <script>
            //ketika klik next
            $('#NextPage').click(function() {
                var page=$('#NextPage').val();
                $('#page').val(page);
                var ProsesFilter = $('#ProsesFilter').serialize();
                $.ajax({
                    type: 'POST',
                    url: '_Page/Tabungan/TabelTabungan.php',
                    data: ProsesFilter,
                    success: function(data) {
                        $('#MenampilkanTabelTabungan').html(data);
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
                    url: '_Page/Tabungan/TabelTabungan.php',
                    data: ProsesFilter,
                    success: function(data) {
                        $('#MenampilkanTabelTabungan').html(data);
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
                            <td align="left"><b>Kategori</b></td>
                            <td align="left"><b>Jenis Simpanan</b></td>
                            <td align="left"><b>Nominal</b></td>
                            <td align="center"><b>Opsi</b></td>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                            if(empty($jml_data)){
                                echo '<tr>';
                                echo '  <td colspan="7" class="text-center">';
                                echo '      <code class="text-danger">';
                                echo '          Tidak Ada Data Simpanan Yang Dapat Ditampilkan';
                                echo '      </code>';
                                echo '  </td>';
                                echo '</tr>';
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
                                    $uuid_simpanan= $data['uuid_simpanan'];
                                    $id_anggota= $data['id_anggota'];
                                    $id_akses= $data['id_akses'];
                                    $id_simpanan_jenis= $data['id_simpanan_jenis'];
                                    $rutin= $data['rutin'];
                                    $nip= $data['nip'];
                                    $nama= $data['nama'];
                                    $tanggal= $data['tanggal'];
                                    $kategori= $data['kategori'];
                                    $jumlah= $data['jumlah'];
                                    //Format Rupiah
                                    $jumlah_format = "" . number_format($jumlah,0,',','.');

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
                                    $strtotime=strtotime($tanggal);
                                    $TanggalFormat=date('d/m/Y',$strtotime);
                        ?>
                                    <tr>
                                        <td align="center"><?php echo $no; ?></td>
                                        <td align="left">
                                            <small class="credit">
                                                <?php echo "$TanggalFormat"; ?>
                                            </small>
                                        </td>
                                        <td align="left">
                                            <small class="credit">
                                                <?php echo "$nama"; ?>
                                            </small>
                                        </td>
                                        <td align="left">
                                            <small class="credit">
                                                <?php echo "$nip"; ?>
                                            </small>
                                        </td>
                                        <td align="left">
                                           <?php echo "$LabelKategori"; ?>
                                        </td>
                                        <td align="left">
                                           <small class="text-muted"><?php echo "$nama_simpanan"; ?></small>
                                        </td>
                                        <td align="">
                                            <small class="credit">
                                                <?php 
                                                    echo "$jumlah_format_label";
                                                ?>
                                            </small>
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
                                                    <a class="dropdown-item" href="javascript:void(0)" data-bs-toggle="modal" data-bs-target="#ModalDetailSimpanan" data-id="<?php echo "$id_simpanan"; ?>">
                                                        <i class="bi bi-info-circle"></i> Detail
                                                    </a>
                                                </li>
                                                <li>
                                                    <a class="dropdown-item" href="javascript:void(0)" data-bs-toggle="modal" data-bs-target="#ModalEditSimpanan" data-id="<?php echo "$id_simpanan"; ?>">
                                                        <i class="bi bi-pencil"></i> Edit
                                                    </a>
                                                </li>
                                                <li>
                                                    <a class="dropdown-item" href="javascript:void(0)" data-bs-toggle="modal" data-bs-target="#ModalHapusSimpanan" data-id="<?php echo "$id_simpanan"; ?>">
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
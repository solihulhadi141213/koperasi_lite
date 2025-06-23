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
                $jml_data = mysqli_num_rows(mysqli_query($Conn, "SELECT*FROM pinjaman WHERE status='Berjalan'"));
            }else{
                $jml_data = mysqli_num_rows(mysqli_query($Conn, "SELECT*FROM pinjaman WHERE (status='Berjalan') AND (nama like '%$keyword%' OR nip like '%$keyword%' OR lembaga like '%$keyword%' OR ranking like '%$keyword%' OR tanggal like '%$keyword%' OR jumlah_pinjaman like '%$keyword%' OR status like '%$keyword%')"));
            }
        }else{
            if(empty($keyword)){
                $jml_data = mysqli_num_rows(mysqli_query($Conn, "SELECT*FROM pinjaman WHERE status='Berjalan'"));
            }else{
                $jml_data = mysqli_num_rows(mysqli_query($Conn, "SELECT*FROM pinjaman WHERE (status='Berjalan') AND ($keyword_by like '%$keyword%')"));
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
                    url: '_Page/Tagihan/TabelTagihan.php',
                    data: ProsesFilter,
                    success: function(data) {
                        $('#MenampilkanTabelTagihan').html(data);
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
                    url: '_Page/Tagihan/TabelTagihan.php',
                    data: ProsesFilter,
                    success: function(data) {
                        $('#MenampilkanTabelTagihan').html(data);
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
                <table class="table table-bordered table-hover">
                    <thead>
                        <tr>
                            <td align="center"><b>No</b></td>
                            <td align="center"><b>Tanggal Pinjaman</b></td>
                            <td align="center"><b>Nama & NIP</b></td>
                            <td align="center"><b>Divisi/Unit & Ranking</b></td>
                            <td align="center"><b>Rp Pinjaman</b></td>
                            <td align="center"><b>Tunggakan</b></td>
                            <td align="center"><b>Opsi</b></td>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                            if(empty($jml_data)){
                                echo '<tr>';
                                echo '  <td colspan="7" class="text-center">';
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
                                        $query = mysqli_query($Conn, "SELECT*FROM pinjaman WHERE status='Berjalan' ORDER BY $OrderBy $ShortBy LIMIT $posisi, $batas");
                                    }else{
                                        $query = mysqli_query($Conn, "SELECT*FROM pinjaman WHERE (status='Berjalan') AND (nama like '%$keyword%' OR nip like '%$keyword%' OR lembaga like '%$keyword%' OR ranking like '%$keyword%' OR tanggal like '%$keyword%' OR jumlah_pinjaman like '%$keyword%' OR status like '%$keyword%') ORDER BY $OrderBy $ShortBy LIMIT $posisi, $batas");
                                    }
                                }else{
                                    if(empty($keyword)){
                                        $query = mysqli_query($Conn, "SELECT*FROM pinjaman WHERE status='Berjalan' ORDER BY $OrderBy $ShortBy LIMIT $posisi, $batas");
                                    }else{
                                        $query = mysqli_query($Conn, "SELECT*FROM pinjaman WHERE (status='Berjalan') AND ($keyword_by like '%$keyword%') ORDER BY $OrderBy $ShortBy LIMIT $posisi, $batas");
                                    }
                                }
                                while ($data = mysqli_fetch_array($query)) {
                                    $id_pinjaman= $data['id_pinjaman'];
                                    $uuid_pinjaman= $data['uuid_pinjaman'];
                                    $id_anggota= $data['id_anggota'];
                                    $nama= $data['nama'];
                                    $nip= $data['nip'];
                                    $lembaga= $data['lembaga'];
                                    $ranking= $data['ranking'];
                                    $tanggal= $data['tanggal'];
                                    $jatuh_tempo= $data['jatuh_tempo'];
                                    $jumlah_pinjaman= $data['jumlah_pinjaman'];
                                    $periode_angsuran= $data['periode_angsuran'];
                                    $angsuran_total= $data['angsuran_total'];
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
                                    //Cek Apakah Sudah Sinkron Dengan Jurnal
                                    $JumlahJurnal = mysqli_num_rows(mysqli_query($Conn, "SELECT*FROM jurnal WHERE kategori='Pinjaman' AND uuid='$uuid_pinjaman'"));
                                    if(empty($JumlahJurnal)){
                                        $LabelJurnal='<code class="text text-danger">Jurnal : 0 Rcd</code>';
                                    }else{
                                        $LabelJurnal='<code class="text text-grayish">Jurnal : '.$JumlahJurnal.' Rcd</code>';
                                    }
                                    //Tanggal Sekarang
                                    $TanggalSekarang=date('Y-m-d');
                                    //Simulasi Pinjaman
                                    $JumlahPeriodeTagihan=0;
                                    $JumlahTunggakan=0;
                                    for ( $i=1; $i<=$periode_angsuran; $i++ ){
                                        $GetPeriodePinjaman=date('d/m/Y', strtotime('+'.$i.' month', strtotime($tanggal))); 
                                        //Ubah Format Tangga
                                        $GetPeriodePinjaman2=date('Y-m-d', strtotime('+'.$i.' month', strtotime($tanggal))); 
                                        if($TanggalSekarang>$GetPeriodePinjaman2){
                                            //Cek Apakah Sudah Ada Angsuran
                                            $QryAngsuran = mysqli_query($Conn,"SELECT * FROM pinjaman_angsuran WHERE id_pinjaman='$id_pinjaman' AND tanggal_angsuran='$GetPeriodePinjaman2'")or die(mysqli_error($Conn));
                                            $DataAngsuran = mysqli_fetch_array($QryAngsuran);
                                            if(empty($DataAngsuran['id_pinjaman_angsuran'])){
                                                $JumlahPeriodeTagihan=$JumlahPeriodeTagihan+1;
                                                $JumlahTunggakan=$JumlahTunggakan+$angsuran_total;
                                            }else{
                                                $JumlahPeriodeTagihan=$JumlahPeriodeTagihan+0;
                                                $JumlahTunggakan=$JumlahTunggakan+0;
                                            }
                                        }else{
                                            $JumlahPeriodeTagihan=$JumlahPeriodeTagihan+0;
                                            $JumlahTunggakan=$JumlahTunggakan+0;
                                        }
                                    }
                                    $JumlahTunggakanFormat = "Rp " . number_format($JumlahTunggakan,0,',','.');
                        ?>
                                    <tr>
                                        <td align="center">
                                            <small class="credit"><?php echo $no; ?></small>
                                        </td>
                                        <td align="left">
                                            <small class="credit">
                                                <?php echo $TanggalFormat; ?>
                                            </small>
                                        </td>
                                        <td align="left">
                                            <?php 
                                                echo "$nama <br>"; 
                                                echo '<code class="text-dark">NIP: </code> <code class="text text-grayish">'.$nip.'</code>';
                                            ?>
                                        </td>
                                        <td align="left">
                                            <small class="credit">
                                                <?php 
                                                    echo "$lembaga<br>"; 
                                                    echo '<code class="text-dark">Ranking : </code> <code class="text text-grayish">'.$ranking.'</code>';
                                                ?>
                                            </small>
                                        </td>
                                        <td align="right">
                                            <small class="credit">
                                                <?php 
                                                    echo "$jumlah_pinjaman_format <br>"; 
                                                    echo "$LabelJurnal"; 
                                                ?>
                                            </small>
                                        </td>
                                        <td align="right">
                                            <small class="credit">
                                                <?php 
                                                    echo "$JumlahTunggakanFormat<br>"; 
                                                    echo '<code class="text-dark"></code> <code class="text text-grayish">'.$JumlahPeriodeTagihan.' Bulan</code>';
                                                ?>
                                            </small>
                                        </td>
                                        <td align="center">
                                            <a class="btn btn-sm btn-outline-dark btn-rounded" href="javascript:void(0);" data-bs-toggle="dropdown" aria-expanded="false">
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
                <small class="credit">
                    <b>Keterangan :</b>
                    Jumlah tunggakan belum termasuk denda keterlambatan.
                </small>
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
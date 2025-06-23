<?php
    //koneksi dan session
    include "../../_Config/Connection.php";
    include "../../_Config/GlobalFunction.php";
    date_default_timezone_set("Asia/Jakarta");
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
        $OrderBy="id_transaksi";
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
            $jml_data = mysqli_num_rows(mysqli_query($Conn, "SELECT*FROM transaksi"));
        }else{
            $jml_data = mysqli_num_rows(mysqli_query($Conn, "SELECT*FROM transaksi WHERE nama_transaksi like '%$keyword%' OR kategori like '%$keyword%' OR tanggal like '%$keyword%' OR jumlah like '%$keyword%' OR pembayaran like '%$keyword%' OR status like '%$keyword%'"));
        }
    }else{
        if(empty($keyword)){
            $jml_data = mysqli_num_rows(mysqli_query($Conn, "SELECT*FROM transaksi"));
        }else{
            $jml_data = mysqli_num_rows(mysqli_query($Conn, "SELECT*FROM transaksi WHERE $keyword_by like '%$keyword%'"));
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
        var batas="<?php echo "$batas"; ?>";
        var keyword="<?php echo "$keyword"; ?>";
        var keyword_by="<?php echo "$keyword_by"; ?>";
        var OrderBy="<?php echo "$OrderBy"; ?>";
        var ShortBy="<?php echo "$ShortBy"; ?>";
        $.ajax({
            url     : "_Page/Transaksi/TabelTransaksi.php",
            method  : "POST",
            data 	:  { page: page, batas: batas, keyword: keyword, keyword_by: keyword_by, OrderBy: OrderBy, ShortBy: ShortBy },
            success: function (data) {
                $('#MenampilkanTabelTransaksi').html(data);
                $('#page').val(page);
            }
        })
    });
    //Ketika klik Previous
    $('#PrevPage').click(function() {
        var page = $('#PrevPage').val();
        var batas="<?php echo "$batas"; ?>";
        var keyword="<?php echo "$keyword"; ?>";
        var keyword_by="<?php echo "$keyword_by"; ?>";
        var OrderBy="<?php echo "$OrderBy"; ?>";
        var ShortBy="<?php echo "$ShortBy"; ?>";
        $.ajax({
            url     : "_Page/Transaksi/TabelTransaksi.php",
            method  : "POST",
            data 	:  { page: page, batas: batas, keyword: keyword, keyword_by: keyword_by, OrderBy: OrderBy, ShortBy: ShortBy },
            success : function (data) {
                $('#MenampilkanTabelTransaksi').html(data);
                $('#page').val(page);
            }
        })
    });
</script>
<div class="row">
    <div class="col-md-4">
        <small class="credit">
            Halaman : <code class="text-grayish"><?php echo "$page/$JmlHalaman"; ?></code>
        </small><br>
        <small class="credit">
            Jumlah Data : <code class="text-grayish"><?php echo "$jml_data"; ?></code>
        </small>
    </div>
</div>
<div class="row mb-3">
    <div class="table table-responsive">
        <table class="table table-bordered table-hover">
            <thead>
                <tr>
                    <td align="center"><b>No</b></td>
                    <td align="center"><b>Tanggal & Jam</b></td>
                    <td align="center"><b>Nama Transaksi</b></td>
                    <td align="center"><b>Kategori</b></td>
                    <td align="center"><b>Jumlah</b></td>
                    <td align="center"><b>Pembayaran</b></td>
                    <td align="center"><b>Status</b></td>
                    <td align="center"><b>Opsi</b></td>
                </tr>
            </thead>
            <tbody>
                <?php
                    if(empty($jml_data)){
                        echo '<tr>';
                        echo '  <td colspan="8" class="text-center">';
                        echo '      <code class="text-danger">';
                        echo '          Tidak Ada Data Transaksi Yang Dapat Ditampilkan';
                        echo '      </code>';
                        echo '  </td>';
                        echo '</tr>';
                    }else{
                        $no = 1+$posisi;
                        //KONDISI PENGATURAN MASING FILTER
                        if(empty($keyword_by)){
                            if(empty($keyword)){
                                $query = mysqli_query($Conn, "SELECT*FROM transaksi ORDER BY $OrderBy $ShortBy LIMIT $posisi, $batas");
                            }else{
                                $query = mysqli_query($Conn, "SELECT*FROM transaksi WHERE nama_transaksi like '%$keyword%' OR kategori like '%$keyword%' OR tanggal like '%$keyword%' OR jumlah like '%$keyword%' OR pembayaran like '%$keyword%' OR status like '%$keyword%' ORDER BY $OrderBy $ShortBy LIMIT $posisi, $batas");
                            }
                        }else{
                            if(empty($keyword)){
                                $query = mysqli_query($Conn, "SELECT*FROM transaksi ORDER BY $OrderBy $ShortBy LIMIT $posisi, $batas");
                            }else{
                                $query = mysqli_query($Conn, "SELECT*FROM transaksi WHERE $keyword_by like '%$keyword%' ORDER BY $OrderBy $ShortBy LIMIT $posisi, $batas");
                            }
                        }
                        while ($data = mysqli_fetch_array($query)) {
                            $id_transaksi= $data['id_transaksi'];
                            $uuid_transaksi= $data['uuid_transaksi'];
                            $nama_transaksi= $data['nama_transaksi'];
                            $kategori= $data['kategori'];
                            $tanggal= $data['tanggal'];
                            $jumlah= $data['jumlah'];
                            $pembayaran= $data['pembayaran'];
                            $status= $data['status'];
                            $PembayaranFormat = "" . number_format($pembayaran,0,',','.');
                            $JumlahFormat = "Rp " . number_format($jumlah,0,',','.');
                            //Format Tanggal
                            $strtotime=strtotime($tanggal);
                            $TanggalFormat=date('d/m/Y H:i:s T', $strtotime);
                ?>
                            <tr>
                                <td align="center"><?php echo $no; ?></td>
                                <td align="left">
                                    <small class="credit">
                                        <code class="text-dark"><?php echo $TanggalFormat; ?></code>
                                    </small>
                                </td>
                                <td align="left">
                                    <small class="credit">
                                        <code class="text-dark"><?php echo $nama_transaksi; ?></code>
                                    </small>
                                </td>
                                <td align="left">
                                    <small class="credit">
                                        <code class="text-dark"><?php echo $kategori; ?></code>
                                    </small>
                                </td>
                                <td align="right">
                                    <small class="credit">
                                        <code class="text-dark"><?php echo $JumlahFormat; ?></code>
                                    </small>
                                </td>
                                <td align="right">
                                    <small class="credit">
                                        <code class="text-dark"><?php echo $PembayaranFormat; ?></code>
                                    </small>
                                </td>
                                <td align="center">
                                    <?php
                                        if($status=="Lunas"){
                                            echo '<badge class="badge bg-success">Lunas</badge>';
                                        }else{
                                            if($status=="Utang"){
                                                echo '<badge class="badge bg-danger">Utang</badge>';
                                            }else{
                                                if($status=="Piutang"){
                                                    echo '<badge class="badge bg-warning">Piutang</badge>';
                                                }else{
                                                    echo '<badge class="badge bg-dark">None</badge>';
                                                }
                                            }
                                        }
                                    ?>
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
                                            <a class="dropdown-item" href="javascript:void(0)" data-bs-toggle="modal" data-bs-target="#ModalDetail" data-id="<?php echo "$id_transaksi"; ?>">
                                                <i class="bi bi-info-circle"></i> Detail
                                            </a>
                                        </li>
                                        <li>
                                            <a class="dropdown-item" href="index.php?Page=Transaksi&Sub=EditTransaksi&id=<?php echo "$id_transaksi"; ?>">
                                                <i class="bi bi-pencil"></i> Ubah/Edit
                                            </a>
                                        </li>
                                        <li>
                                            <a class="dropdown-item" href="javascript:void(0)" data-bs-toggle="modal" data-bs-target="#ModalHapus" data-id="<?php echo "$id_transaksi"; ?>">
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
<div class="row">
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
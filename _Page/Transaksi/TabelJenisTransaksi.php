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
        $OrderBy="id_transaksi_jenis";
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
            $jml_data = mysqli_num_rows(mysqli_query($Conn, "SELECT*FROM transaksi_jenis"));
        }else{
            $jml_data = mysqli_num_rows(mysqli_query($Conn, "SELECT*FROM transaksi_jenis WHERE nama like '%$keyword%' OR kategori like '%$keyword%' OR deskripsi like '%$keyword%'"));
        }
    }else{
        if(empty($keyword)){
            $jml_data = mysqli_num_rows(mysqli_query($Conn, "SELECT*FROM transaksi_jenis"));
        }else{
            $jml_data = mysqli_num_rows(mysqli_query($Conn, "SELECT*FROM transaksi_jenis WHERE $keyword_by like '%$keyword%'"));
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
            url     : "_Page/Transaksi/TabelJenisTransaksi.php",
            method  : "POST",
            data 	:  { page: page, batas: batas, keyword: keyword, keyword_by: keyword_by, OrderBy: OrderBy, ShortBy: ShortBy },
            success: function (data) {
                $('#MenampilkanTabelJenisTransaksi').html(data);
                $('#PutPageJenisTransaksi').val(page);
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
            url     : "_Page/Transaksi/TabelJenisTransaksi.php",
            method  : "POST",
            data 	:  { page: page, batas: batas, keyword: keyword, keyword_by: keyword_by, OrderBy: OrderBy, ShortBy: ShortBy },
            success : function (data) {
                $('#MenampilkanTabelJenisTransaksi').html(data);
                $('#PutPageJenisTransaksi').val(page);
            }
        })
    });
    // Pilih jenis transaksi
    $(document).on('click', '.pilih_jenis_transaksi', function(e) {
        var id_transaksi_jenis = $(this).data('id');
        var jenis_transaksi = $('#jenis_transaksi_pilih' + id_transaksi_jenis).html();
        var kategori_transaksi = $('#kategori_transaksi_pilih' + id_transaksi_jenis).html();

        $('#id_transaksi_jenis').html('<option value="' + id_transaksi_jenis + '">' + jenis_transaksi + '</option>');
        $('#kategori').val(kategori_transaksi);
        $('#ModalPilihJenisTransaksi').modal('hide');
    });
</script>
<div class="row mb-3">
    <div class="table table-responsive">
        <table class="table table-bordered table-hover">
            <thead>
                <tr>
                    <td align="center"><b>No</b></td>
                    <td align="center"><b>Nama Transaksi</b></td>
                    <td align="center"><b>Kategori</b></td>
                    <td align="center"><b>Opsi</b></td>
                </tr>
            </thead>
            <tbody>
                <?php
                    if(empty($jml_data)){
                        echo '<tr>';
                        echo '  <td colspan="4" class="text-center">';
                        echo '      <code class="text-danger">';
                        echo '          Tidak Ada Data Jenis Transaksi Yang Dapat Ditampilkan';
                        echo '      </code>';
                        echo '  </td>';
                        echo '</tr>';
                    }else{
                        $no = 1+$posisi;
                        //KONDISI PENGATURAN MASING FILTER
                        if(empty($keyword_by)){
                            if(empty($keyword)){
                                $query = mysqli_query($Conn, "SELECT*FROM transaksi_jenis ORDER BY $OrderBy $ShortBy LIMIT $posisi, $batas");
                            }else{
                                $query = mysqli_query($Conn, "SELECT*FROM transaksi_jenis WHERE nama like '%$keyword%' OR kategori like '%$keyword%' OR deskripsi like '%$keyword%' ORDER BY $OrderBy $ShortBy LIMIT $posisi, $batas");
                            }
                        }else{
                            if(empty($keyword)){
                                $query = mysqli_query($Conn, "SELECT*FROM transaksi_jenis ORDER BY $OrderBy $ShortBy LIMIT $posisi, $batas");
                            }else{
                                $query = mysqli_query($Conn, "SELECT*FROM transaksi_jenis WHERE $keyword_by like '%$keyword%' ORDER BY $OrderBy $ShortBy LIMIT $posisi, $batas");
                            }
                        }
                        while ($data = mysqli_fetch_array($query)) {
                            $id_transaksi_jenis= $data['id_transaksi_jenis'];
                            $nama= $data['nama'];
                            $kategori= $data['kategori'];
                            $deskripsi= $data['deskripsi'];
                            $id_akun_debet= $data['id_akun_debet'];
                            $id_akun_kredit= $data['id_akun_kredit'];
                            //Membuka Akun
                            $AkunDebet=GetDetailData($Conn,'akun_perkiraan','id_perkiraan',$id_akun_debet,'nama');
                            $AkunKredit=GetDetailData($Conn,'akun_perkiraan','id_perkiraan',$id_akun_kredit,'nama');

                ?>
                            <tr>
                                <td align="center"><?php echo $no; ?></td>
                                <td align="left">
                                    <span id="jenis_transaksi_pilih<?php echo "$id_transaksi_jenis"; ?>">
                                        <?php echo "$nama"; ?>
                                    </span>
                                    <br>
                                    <small class="credit">
                                        <code class="text text-grayish"><?php echo $deskripsi; ?></code>
                                    </small>
                                </td>
                                <td align="left">
                                    <small class="credit">
                                        <code class="text text-dark" id="kategori_transaksi_pilih<?php echo "$id_transaksi_jenis"; ?>"><?php echo $kategori; ?></code>
                                    </small>
                                </td>
                                <td align="center">
                                    <button type="button" class="btn btn-sm btn-primary pilih_jenis_transaksi" data-id="<?php echo "$id_transaksi_jenis"; ?>">
                                        Pilih
                                    </button>
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
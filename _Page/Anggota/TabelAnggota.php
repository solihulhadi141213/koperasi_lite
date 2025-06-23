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
        $OrderBy="id_anggota";
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
            $jml_data = mysqli_num_rows(mysqli_query($Conn, "SELECT*FROM anggota"));
        }else{
            $jml_data = mysqli_num_rows(mysqli_query($Conn, "SELECT*FROM anggota WHERE tanggal_masuk like '%$keyword%' OR tanggal_keluar like '%$keyword%' OR nip like '%$keyword%' OR nama like '%$keyword%' OR email like '%$keyword%' OR kontak like '%$keyword%' OR lembaga like '%$keyword%' OR ranking like '%$keyword%' OR status like '%$keyword%'"));
        }
    }else{
        if(empty($keyword)){
            $jml_data = mysqli_num_rows(mysqli_query($Conn, "SELECT*FROM anggota"));
        }else{
            $jml_data = mysqli_num_rows(mysqli_query($Conn, "SELECT*FROM anggota WHERE $keyword_by like '%$keyword%'"));
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
            url     : "_Page/Anggota/TabelAnggota.php",
            method  : "POST",
            data 	:  { page: page, batas: batas, keyword: keyword, keyword_by: keyword_by, OrderBy: OrderBy, ShortBy: ShortBy },
            success: function (data) {
                $('#MenampilkanTabelAnggota').html(data);
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
            url     : "_Page/Anggota/TabelAnggota.php",
            method  : "POST",
            data 	:  { page: page, batas: batas, keyword: keyword, keyword_by: keyword_by, OrderBy: OrderBy, ShortBy: ShortBy },
            success : function (data) {
                $('#MenampilkanTabelAnggota').html(data);
                $('#page').val(page);
            }
        })
    });
</script>
<!-- <div class="row">
    <div class="col-md-4">
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
                    <td align="center"><b>Anggota</b></td>
                    <td align="center"><b>Tanggal</b></td>
                    <td align="center"><b>Email & Kontak</b></td>
                    <td align="center"><b>Divisi & Ranking</b></td>
                    <td align="center"><b>Akses & Status</b></td>
                    <td align="center"><b>Opsi</b></td>
                </tr>
            </thead>
            <tbody>
                <?php
                    if(empty($jml_data)){
                        echo '<tr>';
                        echo '  <td colspan="7" class="text-center">';
                        echo '      <code class="text-danger">';
                        echo '          Tidak Ada Data Anggota Yang Dapat Ditampilkan';
                        echo '      </code>';
                        echo '  </td>';
                        echo '</tr>';
                    }else{
                        $no = 1+$posisi;
                        //KONDISI PENGATURAN MASING FILTER
                        if(empty($keyword_by)){
                            if(empty($keyword)){
                                $query = mysqli_query($Conn, "SELECT*FROM anggota ORDER BY $OrderBy $ShortBy LIMIT $posisi, $batas");
                            }else{
                                $query = mysqli_query($Conn, "SELECT*FROM anggota WHERE tanggal_masuk like '%$keyword%' OR tanggal_keluar like '%$keyword%' OR nip like '%$keyword%' OR nama like '%$keyword%' OR email like '%$keyword%' OR kontak like '%$keyword%' OR lembaga like '%$keyword%' OR ranking like '%$keyword%' OR status like '%$keyword%' ORDER BY $OrderBy $ShortBy LIMIT $posisi, $batas");
                            }
                        }else{
                            if(empty($keyword)){
                                $query = mysqli_query($Conn, "SELECT*FROM anggota ORDER BY $OrderBy $ShortBy LIMIT $posisi, $batas");
                            }else{
                                $query = mysqli_query($Conn, "SELECT*FROM anggota WHERE $keyword_by like '%$keyword%' ORDER BY $OrderBy $ShortBy LIMIT $posisi, $batas");
                            }
                        }
                        while ($data = mysqli_fetch_array($query)) {
                            $id_anggota= $data['id_anggota'];
                            $tanggal_masuk= $data['tanggal_masuk'];
                            $tanggal_keluar= $data['tanggal_keluar'];
                            $nip= $data['nip'];
                            $nama= $data['nama'];
                            $email= $data['email'];
                            $kontak= $data['kontak'];
                            $lembaga= $data['lembaga'];
                            $ranking= $data['ranking'];
                            if(empty($data['foto'])){
                                $foto="No-Image.PNG";
                            }else{
                                $foto= $data['foto'];
                            }
                            $akses_anggota= $data['akses_anggota'];
                            if($akses_anggota==1){
                                $password= $data['password'];
                                $password="*****";
                            }else{
                                $password="-";
                            }
                            $status= $data['status'];
                            if($status=="Keluar"){
                                $strtotime2=strtotime($tanggal_keluar);
                                $TanggalKeluar=date('d/m/Y', $strtotime2);
                                $LabelStatus='<span class="text-danger">Keluar</span>';
                            }else{
                                $TanggalKeluar="-";
                                $LabelStatus='<span class="text-success">Aktif</span>';
                            }
                            //Format Tanggal
                            $strtotime1=strtotime($tanggal_masuk);
                            //Menampilkan Tanggal
                            $TanggalMasuk=date('d/m/Y', $strtotime1);
                ?>
                            <tr>
                                <td align="center"><?php echo $no; ?></td>
                                <td align="left">
                                    <small class="credit">
                                        <?php
                                            echo '<a href="javascript:void(0);" data-bs-toggle="modal" data-bs-target="#ModalDetailAnggota" data-id="'.$id_anggota.'" class="text text-decoration-underline">';
                                            echo '  '.$nama.'';
                                            echo '</a>';
                                            echo "<br>";
                                            echo '<code class="text text-grayish">NIP : '.$nip.'</code>';
                                        ?>
                                    </small>
                                </td>
                                <td align="left">
                                    <small class="credit">
                                        <?php
                                            echo '<code class="text text-dark">Masuk : </code>';
                                            echo '<code class="text text-grayish">'.$TanggalMasuk.'</code><br>';
                                            echo '<code class="text text-dark">Keluar : </code>';
                                            echo '<code class="text text-grayish">'.$TanggalKeluar.'</code><br>';
                                        ?>
                                    </small>
                                </td>
                                <td align="left">
                                    <small class="credit">
                                        <?php
                                            echo '<i class="bi bi-envelope"></i> '.$email.'';
                                            echo "<br>";
                                            echo '<code class="text text-grayish"><i class="bi bi-phone"></i> '.$kontak.'</code>';
                                        ?>
                                    </small>
                                </td>
                                <td align="left">
                                    <small class="credit">
                                        <?php
                                            echo '<code class="text text-dark">Divisi : </code>';
                                            echo '<code class="text text-grayish">'.$lembaga.'</code><br>';
                                            echo '<code class="text text-dark">Ranking : </code>';
                                            echo '<code class="text text-grayish">'.$ranking.'</code><br>';
                                        ?>
                                    </small>
                                </td>
                                <td align="left">
                                    <small class="credit">
                                        <?php
                                            echo '<code class="text text-dark">Password : </code>';
                                            echo '<code class="text text-grayish">'.$password.'</code><br>';
                                            echo '<code class="text text-dark">Status : </code>';
                                            echo '<code class="text text-grayish">'.$LabelStatus.'</code><br>';
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
                                            <a class="dropdown-item" href="javascript:void(0)" data-bs-toggle="modal" data-bs-target="#ModalDetailAnggota" data-id="<?php echo "$id_anggota"; ?>">
                                                <i class="bi bi-info-circle"></i> Detail
                                            </a>
                                        </li>
                                        <li>
                                            <a class="dropdown-item" href="javascript:void(0)" data-bs-toggle="modal" data-bs-target="#ModalEditAnggota" data-id="<?php echo "$id_anggota"; ?>">
                                                <i class="bi bi-pencil"></i> Ubah Anggota
                                            </a>
                                        </li>
                                        <li>
                                            <a class="dropdown-item" href="javascript:void(0)" data-bs-toggle="modal" data-bs-target="#ModalUbahFotoAnggota" data-id="<?php echo "$id_anggota"; ?>">
                                                <i class="bi bi-image"></i> Ubah Foto
                                            </a>
                                        </li>
                                        <li>
                                            <a class="dropdown-item" href="javascript:void(0)" data-bs-toggle="modal" data-bs-target="#ModalHapusAnggota" data-id="<?php echo "$id_anggota"; ?>">
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
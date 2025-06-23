<?php
    //koneksi dan session
    include "../../_Config/Connection.php";
    include "../../_Config/GlobalFunction.php";
    include "../../_Config/Session.php";
    //keyword
    if(!empty($_POST['KeywordAnggota'])){
        $keyword=$_POST['KeywordAnggota'];
    }else{
        $keyword="";
    }
    //batas
    $batas="10";
    //ShortBy
    if(!empty($_POST['ShortBy'])){
        $ShortBy=$_POST['ShortBy'];
    }else{
        $ShortBy="ASC";
    }
    //OrderBy
    $OrderBy="id_anggota";
    //Atur Halaman
    if(!empty($_POST['Halaman'])){
        $page=$_POST['Halaman'];
        $posisi = ( $page - 1 ) * $batas;
    }else{
        $page="1";
        $posisi = 0;
    }
    if(empty($keyword)){
        $jml_data = mysqli_num_rows(mysqli_query($Conn, "SELECT*FROM anggota"));
    }else{
        $jml_data = mysqli_num_rows(mysqli_query($Conn, "SELECT*FROM anggota WHERE nama like '%$keyword%' OR nip like '%$keyword%' OR status like '%$keyword%'"));
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
    $('#NextPageAnggota').click(function() {
        var NextPageAnggota="<?php echo "$next"; ?>";
        var KeywordAnggota="<?php echo "$keyword"; ?>";
        $.ajax({
            url     : "_Page/Tabungan/ListAnggota.php",
            method  : "POST",
            data 	:  { Halaman: NextPageAnggota, KeywordAnggota: KeywordAnggota },
            success: function (data) {
                $('#MenampilkanListAnggota').html(data);
            }
        })
    });
    //Ketika klik Previous
    $('#PrevPageAnggota').click(function() {
        var PrevPageAnggota ="<?php echo "$prev"; ?>";
        var KeywordAnggota="<?php echo "$keyword"; ?>";
        $.ajax({
            url     : "_Page/Tabungan/ListAnggota.php",
            method  : "POST",
            data 	:  { Halaman: PrevPageAnggota, KeywordAnggota: KeywordAnggota },
            success : function (data) {
                $('#MenampilkanListAnggota').html(data);
            }
        })
    });
</script>
<div class="row mb-3">
    <div class="col-md-12" style="height: 350px; overflow-y: scroll;">
        <div class="table-responsive">
            <table class="table table-hover table-bordered align-items-center mb-0">
                <thead class="">
                    <tr>
                        <th class="text-center">
                            <b>NO</b>
                        </th>
                        <th class="text-center">
                            <b>Anggota</b>
                        </th>
                        <th class="text-center">
                            <b>Lembaga</b>
                        </th>
                        <th class="text-center">
                            <b>Status</b>
                        </th>
                        <th class="text-center">
                            <b>Opsi</b>
                        </th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                        if(empty($jml_data)){
                            echo '<tr>';
                            echo '  <td colspan="5" class="text-center">';
                            echo '      <span class="text-danger">Tidak Ada Data yang Ditampilkan</span>';
                            echo '  </td>';
                            echo '</tr>';
                        }else{
                            $no = 1+$posisi;
                            //KONDISI PENGATURAN MASING FILTER
                            if(empty($keyword)){
                                $query = mysqli_query($Conn, "SELECT*FROM anggota ORDER BY $OrderBy $ShortBy LIMIT $posisi, $batas");
                            }else{
                                $query = mysqli_query($Conn, "SELECT*FROM anggota WHERE nama like '%$keyword%' OR nip like '%$keyword%' OR status like '%$keyword%' ORDER BY $OrderBy $ShortBy LIMIT $posisi, $batas");
                            }
                            while ($data = mysqli_fetch_array($query)) {
                                $id_anggota= $data['id_anggota'];
                                $tanggal_masuk= $data['tanggal_masuk'];
                                $lembaga= $data['lembaga'];
                                $ranking= $data['ranking'];
                                if(empty($data['nip'])){
                                    $nip='<span class="text-danger">-</span>';
                                }else{
                                    $nip= $data['nip'];
                                }
                                $nama= $data['nama'];
                                $status= $data['status'];
                                if($status=="Aktif"){
                                    $LabelStatus='<span class="badge bg-success">Aktif</span>';
                                }else{
                                    $LabelStatus='<span class="badge bg-danger">'.$status.'</span>';
                                }
                            ?>
                        <tr>
                            <td class="text-center text-xs">
                                <?php echo "$no" ?>
                            </td>
                            <td class="text-left" align="left">
                                <?php 
                                    echo "$nama <br>";
                                    echo '<small class="text text-grayish">'.$nip.'</small>';
                                ?>
                            </td>
                            <td class="text-left" align="left">
                                <?php 
                                    echo "$lembaga <br>";
                                    echo '<small class="text text-grayish">Ranking '.$ranking.'</small>';
                                ?>
                            </td>
                            <td class="text-center">
                                <?php echo "$LabelStatus" ?>
                            </td>
                            <td align="center">
                                <?php if($status=="Aktif"){ ?>
                                    <button type="button" class="btn btn-primary btn-sm" data-bs-toggle="modal" data-bs-target="#ModalTambahSimpanan" data-id="<?php echo "$id_anggota"; ?>">
                                        <i class="bi bi-check"></i> Pilih
                                    </button>  
                                <?php }else{ ?>
                                    <button type="button" class="btn btn-grayish btn-sm" disabled>
                                        <i class="bi bi-check"></i> Pilih
                                    </button>  
                                <?php } ?>
                            </td>
                        </tr>
                        <?php
                            $no++; }}
                        ?>
                </tbody>
            </table>
        </div>
    </div>
</div>
<div class="row mb-3">
    <div class="col-md-12 text-center">
        <div class="btn-group shadow-0" role="group" aria-label="Basic example">
            <button class="btn btn-sm btn-info" id="PrevPageAnggota">
                <i class="bi bi-chevron-left"></i>
            </button>
            <button class="btn btn-sm btn-outline-info">
                <?php echo "$page of $JmlHalaman"; ?>
            </button>
            <button class="btn btn-sm btn-info" id="NextPageAnggota">
                <i class="bi bi-chevron-right"></i>
            </button>
        </div>
    </div>
</div>
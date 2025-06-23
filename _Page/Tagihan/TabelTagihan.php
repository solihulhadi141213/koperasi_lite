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
            $OrderBy="id_pinjaman_angsuran";
        }
        //Atur Page
        if(!empty($_POST['page'])){
            $page=$_POST['page'];
            $posisi = ( $page - 1 ) * $batas;
        }else{
            $page="1";
            $posisi = 0;
        }
        // Query untuk menghitung jumlah data
        if(empty($keyword_by)) {
            if(empty($keyword)) {
                $jml_data = mysqli_num_rows(mysqli_query($Conn, "
                    SELECT pa.* 
                    FROM pinjaman_angsuran pa
                    JOIN anggota a ON pa.id_anggota = a.id_anggota
                "));
            } else {
                $jml_data = mysqli_num_rows(mysqli_query($Conn, "
                    SELECT pa.* 
                    FROM pinjaman_angsuran pa
                    JOIN anggota a ON pa.id_anggota = a.id_anggota
                    WHERE pa.id_anggota LIKE '%$keyword%' 
                    OR a.nama LIKE '%$keyword%' 
                    OR a.nip LIKE '%$keyword%'
                    OR pa.tanggal_angsuran LIKE '%$keyword%'
                    OR pa.tanggal_bayar LIKE '%$keyword%'
                "));
            }
        } else {
            if(empty($keyword)) {
                $jml_data = mysqli_num_rows(mysqli_query($Conn, "
                    SELECT pa.* 
                    FROM pinjaman_angsuran pa
                    JOIN anggota a ON pa.id_anggota = a.id_anggota
                "));
            } else {
                // Jika pencarian berdasarkan field tertentu
                if($keyword_by == "nama" || $keyword_by == "nip") {
                    $jml_data = mysqli_num_rows(mysqli_query($Conn, "
                        SELECT pa.* 
                        FROM pinjaman_angsuran pa
                        JOIN anggota a ON pa.id_anggota = a.id_anggota
                        WHERE a.$keyword_by LIKE '%$keyword%'
                    "));
                } else {
                    $jml_data = mysqli_num_rows(mysqli_query($Conn, "
                        SELECT pa.* 
                        FROM pinjaman_angsuran pa
                        JOIN anggota a ON pa.id_anggota = a.id_anggota
                        WHERE pa.$keyword_by LIKE '%$keyword%'
                    "));
                }
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
        <div class="row mb-3">
            <div class="table table-responsive">
                <table class="table table-bordered table-hover">
                    <thead>
                        <tr>
                            <td align="center"><b>No</b></td>
                            <td align="center"><b>Tgl Angsuran</b></td>
                            <td align="center"><b>Tgl Bayar</b></td>
                            <td align="center"><b>Nama Anggota</b></td>
                            <td align="center"><b>No. Induk</b></td>
                            <td align="center"><b>Pokok</b></td>
                            <td align="center"><b>Jasa</b></td>
                            <td align="center"><b>Denda</b></td>
                            <td align="center"><b>Jumlah</b></td>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                            if(empty($jml_data)){
                                echo '<tr>';
                                echo '  <td colspan="9" class="text-center">';
                                echo '      <code class="text-danger">';
                                echo '          Tidak Ada Data Pinjaman Yang Dapat Ditampilkan';
                                echo '      </code>';
                                echo '  </td>';
                                echo '</tr>';
                            }else{
                                $no = 1+$posisi;
                                //KONDISI PENGATURAN MASING FILTER
                                // Query untuk menampilkan data
                                if(empty($keyword_by)) {
                                    if(empty($keyword)) {
                                        $query = mysqli_query($Conn, "
                                            SELECT pa.*, a.nama, a.nip 
                                            FROM pinjaman_angsuran pa
                                            JOIN anggota a ON pa.id_anggota = a.id_anggota
                                            ORDER BY $OrderBy $ShortBy 
                                            LIMIT $posisi, $batas
                                        ");
                                    } else {
                                        $query = mysqli_query($Conn, "
                                            SELECT pa.*, a.nama, a.nip 
                                            FROM pinjaman_angsuran pa
                                            JOIN anggota a ON pa.id_anggota = a.id_anggota
                                            WHERE pa.id_anggota LIKE '%$keyword%' 
                                            OR a.nama LIKE '%$keyword%' 
                                            OR a.nip LIKE '%$keyword%'
                                            OR pa.tanggal_angsuran LIKE '%$keyword%'
                                            OR pa.tanggal_bayar LIKE '%$keyword%'
                                            ORDER BY $OrderBy $ShortBy 
                                            LIMIT $posisi, $batas
                                        ");
                                    }
                                } else {
                                    if(empty($keyword)) {
                                        $query = mysqli_query($Conn, "
                                            SELECT pa.*, a.nama, a.nip 
                                            FROM pinjaman_angsuran pa
                                            JOIN anggota a ON pa.id_anggota = a.id_anggota
                                            ORDER BY $OrderBy $ShortBy 
                                            LIMIT $posisi, $batas
                                        ");
                                    } else {
                                        if($keyword_by == "nama" || $keyword_by == "nip") {
                                            $query = mysqli_query($Conn, "
                                                SELECT pa.*, a.nama, a.nip 
                                                FROM pinjaman_angsuran pa
                                                JOIN anggota a ON pa.id_anggota = a.id_anggota
                                                WHERE a.$keyword_by LIKE '%$keyword%'
                                                ORDER BY $OrderBy $ShortBy 
                                                LIMIT $posisi, $batas
                                            ");
                                        } else {
                                            $query = mysqli_query($Conn, "
                                                SELECT pa.*, a.nama, a.nip 
                                                FROM pinjaman_angsuran pa
                                                JOIN anggota a ON pa.id_anggota = a.id_anggota
                                                WHERE pa.$keyword_by LIKE '%$keyword%'
                                                ORDER BY $OrderBy $ShortBy 
                                                LIMIT $posisi, $batas
                                            ");
                                        }
                                    }
                                }
                                while ($data = mysqli_fetch_array($query)) {
                                    $id_pinjaman_angsuran= $data['id_pinjaman_angsuran'];
                                    $id_anggota= $data['id_anggota'];
                                    $tanggal_angsuran= $data['tanggal_angsuran'];
                                    $tanggal_bayar= $data['tanggal_bayar'];
                                    $keterlambatan= $data['keterlambatan'];
                                    $pokok= $data['pokok'];
                                    $jasa= $data['jasa'];
                                    $denda= $data['denda'];
                                    $jumlah= $data['jumlah'];
                                    //Format tanggal
                                    $tanggal_angsuran_format=date('d/m/Y',strtotime($tanggal_angsuran));
                                    $tanggal_bayar_format=date('d/m/Y',strtotime($tanggal_bayar));
                                   
                                    //Format Rupiah
                                    $keterlambatan_format = "Rp " . number_format($keterlambatan,0,',','.');
                                    $pokok_format = "Rp " . number_format($pokok,0,',','.');
                                    $jasa_format = "Rp " . number_format($jasa,0,',','.');
                                    $denda_format = "Rp " . number_format($denda,0,',','.');
                                    $jumlah_format = "Rp " . number_format($jumlah,0,',','.');

                                    //Buka Data Anggota
                                    $nip=GetDetailData($Conn,'anggota','id_anggota',$id_anggota,'nip');
                                    $nama=GetDetailData($Conn,'anggota','id_anggota',$id_anggota,'nama');
                        ?>
                                    <tr>
                                        <td align="center">
                                            <small class="credit"><?php echo $no; ?></small>
                                        </td>
                                        <td align="left">
                                            <small class="credit"><?php echo $tanggal_angsuran_format; ?></small>
                                        </td>
                                        <td align="left">
                                            <small class="credit"><?php echo $tanggal_bayar_format; ?></small>
                                        </td>
                                        <td align="left">
                                            <small class="credit"><?php echo $nama; ?></small>
                                        </td>
                                        <td align="left">
                                            <small class="credit"><?php echo $nip; ?></small>
                                        </td>
                                        <td align="left">
                                            <small class="credit"><?php echo $pokok_format; ?></small>
                                        </td>
                                        <td align="left">
                                            <small class="credit"><?php echo $jasa_format; ?></small>
                                        </td>
                                        <td align="left">
                                            <small class="credit"><?php echo $denda_format; ?></small>
                                        </td>
                                        <td align="left">
                                            <small class="credit"><?php echo $jumlah_format; ?></small>
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
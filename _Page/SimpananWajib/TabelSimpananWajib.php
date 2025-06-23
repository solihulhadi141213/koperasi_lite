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
        //mode_periode
        if(!empty($_POST['mode_periode'])){
            $mode_periode=$_POST['mode_periode'];
        }else{
            $mode_periode="Bulanan";
        }
        //Semester
        if(!empty($_POST['semester'])){
            $semester=$_POST['semester'];
        }else{
            $semester="1";
        }
        //Apabila Mode Yang Dipilih Bulanan
        if($mode_periode=="Bulanan"){
            $tahun_awal="";
            $tahun_akhir="";
            //Tahun Wajib Ada
            if(empty($_POST['tahun'])){
                $ValidasiMode="Tahun Tidak Boleh Kosong";
                $tahun_akhir="";
            }else{
                $ValidasiMode="Valid";
                $tahun=$_POST['tahun'];
            }
        }else{
            //Apabila Mode Yang Dipilih Tahunan
            //Tahun Wajib Ada
            $tahun_akhir="";
            if(empty($_POST['tahun_awal'])){
                $ValidasiMode="Tahun Awal Tidak Boleh Kosong";
                $tahun_awal="";
                $tahun_akhir="";
            }else{
                if(empty($_POST['tahun_akhir'])){
                    $ValidasiMode="Tahun Akhir Tidak Boleh Kosong";
                    $tahun_awal="";
                    $tahun_akhir="";
                }else{
                    $ValidasiMode="Valid";
                    $tahun_awal=$_POST['tahun_awal'];
                    $tahun_akhir=$_POST['tahun_akhir'];
                }
            }
        }
        if($ValidasiMode!=="Valid"){
            echo '<div class="row">';
            echo '  <div class="col-md-12 text-center">';
            echo '      <small class="text-danger">'.$ValidasiMode.'</small>';
            echo '  </div>';
            echo '</div>';
        }else{
            //id_simpanan_jenis
            if(!empty($_POST['id_simpanan_jenis'])){
                $id_simpanan_jenis=$_POST['id_simpanan_jenis'];
                $nama_simpanan=GetDetailData($Conn,'simpanan_jenis','id_simpanan_jenis',$id_simpanan_jenis,'nama_simpanan');
            }else{
                $id_simpanan_jenis="";
                $nama_simpanan="Semua Jenis Simpanan";
            }
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
                $('#page').val(page);
                var ProsesFilter = $('#ProsesFilter').serialize();
                $.ajax({
                    type: 'POST',
                    url: '_Page/SimpananWajib/TabelSimpananWajib.php',
                    data: ProsesFilter,
                    success: function(data) {
                        $('#MenampilkanTabelSimpananWajib').html(data);
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
                    url: '_Page/SimpananWajib/TabelSimpananWajib.php',
                    data: ProsesFilter,
                    success: function(data) {
                        $('#MenampilkanTabelSimpananWajib').html(data);
                    }
                });
            });
        </script>
        <div class="row">
            <!-- <div class="col-md-3">
                <small class="credit">
                    Halaman : <code class="text-grayish"><?php echo "$page/$JmlHalaman"; ?></code>
                </small><br>
                <small class="credit">
                    Jumlah Data : <code class="text-grayish"><?php echo "$jml_data"; ?></code>
                </small>
            </div> -->
            <div class="col-md-12 mb-3 text-center">
                <b class="text text-decoration-underline"><?php echo "$nama_simpanan"; ?></b><br>
                <small class="credit">
                    Periode : <code class="text-grayish"><?php echo "$mode_periode"; ?></code>
                </small>//
                <small class="credit">
                    Tahun : 
                    <code class="text-grayish">
                        <?php 
                            if($mode_periode=="Bulanan"){
                                echo "$tahun"; 
                            }else{
                                echo "$tahun_awal - $tahun_akhir"; 
                            }
                        ?>
                    </code>
                </small>//
                <small class="credit">
                    Semester : 
                    <code class="text-grayish">
                        <?php 
                            if($mode_periode=="Bulanan"){
                                echo "$semester"; 
                            }else{
                                echo "None"; 
                            }
                        ?>
                    </code>
                </small>
            </div>
        </div>
        <div class="row mb-2">
            <div class="col-12 mb-2 text-center">
                <button type="button" class="btn btn-sm btn-rounded jump_to <?php if($semester=="1"){echo 'btn-secondary';}else{echo 'btn-outline-secondary';} ?> m-2" <?php if($semester=="1"){echo 'disabled';} ?> data-id="1">
                    Semester 1
                </button>
                <button type="button" class="btn btn-sm btn-rounded jump_to <?php if($semester=="2"){echo 'btn-secondary';}else{echo 'btn-outline-secondary';} ?> m-2" <?php if($semester=="2"){echo 'disabled';} ?> data-id="2">
                    Semester 2
                </button>
            </div>
        </div>
        <div class="row mb-3">
            <div class="table table-responsive">
                <table class="table table-bordered table-hover">
                    <thead>
                        <tr>
                            <td align="center"><b>No</b></td>
                            <td align="center"><b>Anggota</b></td>
                            <td align="center"><b>Divisi/Ranking </b></td>
                            <?php
                                //Looping Berdasarkan Mode
                                if($mode_periode=="Bulanan"){
                                    if($semester=="1"){
                                        $months = [
                                            "01" => "Jan",
                                            "02" => "Feb",
                                            "03" => "Mar",
                                            "04" => "Apr",
                                            "05" => "Mei",
                                            "06" => "Jun"
                                        ];
                                    }else{
                                        $months = [
                                            "07" => "Jul",
                                            "08" => "Agu",
                                            "09" => "Sep",
                                            "10" => "Okt",
                                            "11" => "Nov",
                                            "12" => "Des"
                                        ];
                                    }
                                    foreach ($months as $number => $name) {
                                        echo '<td align="center"><b>'.$name.'</b></td>';
                                    }
                                }else{
                                    for ($tahun = $tahun_awal; $tahun <= $tahun_akhir; $tahun++) {
                                        echo '<td align="center"><b>'.$tahun.'</b></td>';
                                    }
                                }
                            ?>
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
                                    $status= $data['status'];
                                    if($status=="Keluar"){
                                        $strtotime2=strtotime($tanggal_keluar);
                                        $TanggalKeluar=date('d/m/Y', $strtotime2);
                                        $LabelStatus='<span class="text-danger">Keluar</span>';
                                    }else{
                                        $TanggalKeluar="-";
                                        $LabelStatus='<span class="text-success">Aktif</span>';
                                    }
                        ?>
                                    <tr>
                                        <td align="center"><?php echo $no; ?></td>
                                        <td align="left">
                                            <small class="credit">
                                                <?php
                                                    if($status=="Keluar"){
                                                        echo '<a href="javascript:void(0);" class="text-danger" data-bs-toggle="modal" data-bs-target="#ModalDetailAnggota" data-id="'.$id_anggota.'" class="text text-decoration-underline">';
                                                        echo '  '.$nama.'';
                                                        echo '</a>';
                                                    }else{
                                                        echo '<a href="javascript:void(0);" class="text-primary" data-bs-toggle="modal" data-bs-target="#ModalDetailAnggota" data-id="'.$id_anggota.'" class="text text-decoration-underline">';
                                                        echo '  '.$nama.'';
                                                        echo '</a>';
                                                    }
                                                    echo "<br>";
                                                    echo '<code class="text text-dark">NIP : </code>';
                                                    echo '<code class="text text-grayish">'.$nip.'</code>';
                                                ?>
                                            </small>
                                        </td>
                                        <td align="left">
                                            <small class="credit">
                                                <?php
                                                    echo '<code class="text text-dark">Divisi/Unit : </code>';
                                                    echo '<code class="text text-grayish">'.$lembaga.'</code><br>';
                                                    echo '<code class="text text-dark">Ranking : </code>';
                                                    echo '<code class="text text-grayish">'.$ranking.'</code>';
                                                ?>
                                            </small>
                                        </td>
                                        <?php
                                            //Looping Berdasarkan Mode
                                            if($mode_periode=="Bulanan"){
                                                if($semester=="1"){
                                                    $months = [
                                                        "01" => "Jan",
                                                        "02" => "Feb",
                                                        "03" => "Mar",
                                                        "04" => "Apr",
                                                        "05" => "Mei",
                                                        "06" => "Jun"
                                                    ];
                                                }else{
                                                    $months = [
                                                        "07" => "Jul",
                                                        "08" => "Agu",
                                                        "09" => "Sep",
                                                        "10" => "Okt",
                                                        "11" => "Nov",
                                                        "12" => "Des"
                                                    ];
                                                }
                                                foreach ($months as $number => $name) {
                                                    $PeriodeKey="$tahun-$number";
                                                    if(!empty($_POST['id_simpanan_jenis'])){
                                                        $id_simpanan_jenis=$_POST['id_simpanan_jenis'];
                                                        //Menghitung Jumlah Simpanan
                                                        $Sum = mysqli_fetch_array(mysqli_query($Conn, "SELECT SUM(jumlah) AS total FROM simpanan WHERE (id_anggota='$id_anggota' AND id_simpanan_jenis='$id_simpanan_jenis') AND (tanggal like '%$PeriodeKey%')"));
                                                        $jumlah_simpanan = $Sum['total'];
                                                        $jumlah_simpanan = "" . number_format($jumlah_simpanan,0,',','.');
                                                    }else{
                                                        //Menghitung Jumlah Simpanan
                                                        $Sum = mysqli_fetch_array(mysqli_query($Conn, "SELECT SUM(jumlah) AS total FROM simpanan WHERE (id_anggota='$id_anggota' AND rutin=1) AND (tanggal like '%$PeriodeKey%')"));
                                                        $jumlah_simpanan = $Sum['total'];
                                                        $jumlah_simpanan = "" . number_format($jumlah_simpanan,0,',','.');
                                                    }
                                                    if($jumlah_simpanan==0){
                                                        echo '<td align="right">';
                                                        echo '  <small class="credit">';
                                                        echo '      <code>';
                                                        echo '          <a href="javascript:void(0);" class="text text-danger" data-bs-toggle="modal" data-bs-target="#ModalTambahSimpananWajibParsial" data-id="'.$id_anggota.','.$mode_periode.','.$PeriodeKey.','.$id_simpanan_jenis.'">';
                                                        echo '              '.$jumlah_simpanan.'<br> <i class="bi bi-plus"></i> Tambah';
                                                        echo '          </a>';
                                                        echo '      </code>';
                                                        echo '  </small>';
                                                        echo '</td>';
                                                    }else{
                                                        echo '<td align="right">';
                                                        echo '  <small class="credit">';
                                                        echo '      <code>';
                                                        echo '          <a href="javascript:void(0);" class="text text-primary" data-bs-toggle="modal" data-bs-target="#ModalDetailSimpananWajib" data-id="'.$id_anggota.','.$mode_periode.','.$PeriodeKey.','.$id_simpanan_jenis.'">';
                                                        echo '              '.$jumlah_simpanan.'';
                                                        echo '          </a>';
                                                        echo '      </code>';
                                                        echo '  </small>';
                                                        echo '</td>';
                                                    }
                                                    
                                                }
                                            }else{
                                                for ($tahun = $tahun_awal; $tahun <= $tahun_akhir; $tahun++) {
                                                    $PeriodeKey="$tahun";
                                                    if(!empty($_POST['id_simpanan_jenis'])){
                                                        $id_simpanan_jenis=$_POST['id_simpanan_jenis'];
                                                        //Menghitung Jumlah Simpanan
                                                        $Sum = mysqli_fetch_array(mysqli_query($Conn, "SELECT SUM(jumlah) AS total FROM simpanan WHERE (id_anggota='$id_anggota' AND id_simpanan_jenis='$id_simpanan_jenis') AND (tanggal like '%$PeriodeKey%')"));
                                                        $jumlah_simpanan = $Sum['total'];
                                                        $jumlah_simpanan = "" . number_format($jumlah_simpanan,0,',','.');
                                                    }else{
                                                        //Menghitung Jumlah Simpanan
                                                        $Sum = mysqli_fetch_array(mysqli_query($Conn, "SELECT SUM(jumlah) AS total FROM simpanan WHERE (id_anggota='$id_anggota' AND rutin=1) AND (tanggal like '%$PeriodeKey%')"));
                                                        $jumlah_simpanan = $Sum['total'];
                                                        $jumlah_simpanan = "" . number_format($jumlah_simpanan,0,',','.');
                                                    }
                                                    if($jumlah_simpanan==0){
                                                        echo '<td align="right">';
                                                        echo '  <small class="credit">';
                                                        echo '      <code>';
                                                        echo '          <a href="javascript:void(0);" class="text text-danger" data-bs-toggle="modal" data-bs-target="#ModalTambahSimpananWajibParsial" data-id="'.$id_anggota.','.$mode_periode.','.$PeriodeKey.',,'.$id_simpanan_jenis.'">';
                                                        echo '              '.$jumlah_simpanan.'<br> <i class="bi bi-plus"></i> Tambah';
                                                        echo '          </a>';
                                                        echo '      </code>';
                                                        echo '  </small>';
                                                        echo '</td>';
                                                    }else{
                                                        echo '<td align="right">';
                                                        echo '  <small class="credit">';
                                                        echo '      <code>';
                                                        echo '          <a href="javascript:void(0);" class="text text-primary" data-bs-toggle="modal" data-bs-target="#ModalDetailSimpananWajib" data-id="'.$id_anggota.','.$mode_periode.','.$PeriodeKey.',,'.$id_simpanan_jenis.'">';
                                                        echo '              '.$jumlah_simpanan.'';
                                                        echo '          </a>';
                                                        echo '      </code>';
                                                        echo '  </small>';
                                                        echo '</td>';
                                                    }
                                                }
                                            }
                                        ?>
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
        <script>
            $('.jump_to').click(function(){
                var semester= $(this).data('id');
                //Ubah Form Filter
                $('#semester').val(semester);
                //Tamppilkan Data
                filterAndLoadTable();
            });
        </script>
<?php
        }
    }
?>
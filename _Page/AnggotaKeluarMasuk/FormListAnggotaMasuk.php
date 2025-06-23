<?php
    //koneksi dan session
    include "../../_Config/Connection.php";
    include "../../_Config/GlobalFunction.php";
    include "../../_Config/Session.php";
    //id_anggota
    if(empty($SessionIdAkses)){
        echo '<div class="row">';
        echo '  <div class="col-md-12 text-center text-danger">';
        echo '      Sesi Login Sudah Berakhir, Silahkan Login Ulang!';
        echo '  </div>';
        echo '</div>';
    }else{
        if(empty($_POST['Getdata'])){
            echo '<div class="row">';
            echo '  <div class="col-md-12 text-center text-danger">';
            echo '      Tidak ada parameter data yang dikirim!';
            echo '  </div>';
            echo '</div>';
        }else{
            $Getdata=$_POST['Getdata'];
            //Explode GetData
            $explode = explode(",", $Getdata);
            $mode=$explode['0'];
            $Tanggal=$explode['1'];
            if(empty($mode)){
                echo '<div class="row">';
                echo '  <div class="col-md-12 text-center text-danger">';
                echo '      Mode tidak boleh kosong!';
                echo '  </div>';
                echo '</div>';
            }else{
                if(empty($Tanggal)){
                    echo '<div class="row">';
                    echo '  <div class="col-md-12 text-center text-danger">';
                    echo '      Tanggal tidak boleh kosong!';
                    echo '  </div>';
                    echo '</div>';
                }else{
?>
                    <div class="row">
                        <div class="col-md-12" style="height: 350px; overflow-y: scroll;">
                            <div class="table-responsive">
                                <table class="table table-hover table-bordered align-items-center mb-0">
                                    <thead class="">
                                        <tr>
                                            <th class="text-center"><b>No</b></th>
                                            <th class="text-center"><b>NIP</b></th>
                                            <th class="text-center"><b>Nama Anggota</b></th>
                                            <th class="text-center"><b>Tanggal Masuk</b></th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php
                                            //Melakukan Looping Berdasarkan Mode
                                            $no=1;
                                            $query = mysqli_query($Conn, "SELECT*FROM anggota WHERE tanggal_masuk like '%$Tanggal%'");
                                            while ($data = mysqli_fetch_array($query)) {
                                                $id_anggota= $data['id_anggota'];
                                                $tanggal_masuk= $data['tanggal_masuk'];
                                                $tanggal_keluar= $data['tanggal_keluar'];
                                                $nip= $data['nip'];
                                                $nama= $data['nama'];
                                                echo '<tr>';
                                                echo '  <td align="center">'.$no.'</td>';
                                                echo '  <td align="left">'.$nip.'</td>';
                                                echo '  <td align="left">'.$nama.'</td>';
                                                echo '  <td align="left">'.$tanggal_masuk.'</td>';
                                                echo '</tr>';
                                                $no++;
                                            }
                                        ?>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>

<?php
                }
            }
        }
    }
?>
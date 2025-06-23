<?php
    //Koneksi
    date_default_timezone_set('Asia/Jakarta');
    include "../../_Config/Connection.php";
    include "../../_Config/GlobalFunction.php";
    include "../../_Config/SettingGeneral.php";
    include "../../_Config/Session.php";
    if(empty($SessionIdAkses)){
        echo '<div class="row">';
        echo '  <div class="col-md-12 mb-3 text-center">';
        echo '      <small class="text-danger">Sesi Akses Sudah Berakhir, Silahkan Login Ulang</small>';
        echo '  </div>';
        echo '</div>';
    }else{
        if(empty($_POST['GetData'])){
            echo '<div class="row">';
            echo '  <div class="col-md-12 mb-3 text-center">';
            echo '      <small class="text-danger">Tidak ada data yang ditangkap oleh sistem</small>';
            echo '  </div>';
            echo '</div>';
        }else{
            $GetData=$_POST['GetData'];
            //Explode
            $explode=explode(',',$GetData);
            $id_anggota=$explode[0];
            $mode_periode=$explode[1];
            $PeriodeKey=$explode[2];
            $id_simpanan_jenis=$explode[3];
            //Buka Detail Anggota
            $tanggal_masuk=GetDetailData($Conn,'anggota','id_anggota',$id_anggota,'tanggal_masuk');
            $tanggal_keluar=GetDetailData($Conn,'anggota','id_anggota',$id_anggota,'tanggal_keluar');
            $email=GetDetailData($Conn,'anggota','id_anggota',$id_anggota,'email');
            $nip=GetDetailData($Conn,'anggota','id_anggota',$id_anggota,'nip');
            $nama=GetDetailData($Conn,'anggota','id_anggota',$id_anggota,'nama');
            $password=GetDetailData($Conn,'anggota','id_anggota',$id_anggota,'password');
            $kontak=GetDetailData($Conn,'anggota','id_anggota',$id_anggota,'kontak');
            $lembaga=GetDetailData($Conn,'anggota','id_anggota',$id_anggota,'lembaga');
            $ranking=GetDetailData($Conn,'anggota','id_anggota',$id_anggota,'ranking');
            $foto=GetDetailData($Conn,'anggota','id_anggota',$id_anggota,'foto');
            $akses_anggota=GetDetailData($Conn,'anggota','id_anggota',$id_anggota,'akses_anggota');
            $status=GetDetailData($Conn,'anggota','id_anggota',$id_anggota,'status');
            $alasan_keluar=GetDetailData($Conn,'anggota','id_anggota',$id_anggota,'alasan_keluar');
            if(empty($foto)){
                $foto="No-Image.PNG";
            }else{
                $foto=GetDetailData($Conn,'anggota','id_anggota',$id_anggota,'foto');
            }
            if($akses_anggota==1){
                $password=GetDetailData($Conn,'anggota','id_anggota',$id_anggota,'password');
            }else{
                $password="-";
            }
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
            <div class="row mb-3">
                <div class="col col-md-4">Nomor Induk</div>
                <div class="col col-md-8">
                    <code class="text text-grayish"><?php echo $nip; ?></code>
                </div>
            </div>
            <div class="row mb-3">
                <div class="col col-md-4">Nama Lengkap</div>
                <div class="col col-md-8">
                    <code class="text text-grayish"><?php echo $nama; ?></code>
                </div>
            </div>
            <div class="row mb-3">
                <div class="col col-md-4">Divisi/Unit</div>
                <div class="col col-md-8">
                    <code class="text text-grayish"><?php echo $lembaga; ?></code>
                </div>
            </div>
            <div class="row mb-3">
                <div class="col col-md-4">Ranking</div>
                <div class="col col-md-8">
                    <code class="text text-grayish"><?php echo $ranking; ?></code>
                </div>
            </div>
            <div class="row mb-3">
                <div class="col col-md-4">Status</div>
                <div class="col col-md-8">
                    <code class="text text-grayish"><?php echo $LabelStatus; ?></code>
                </div>
            </div>
            <div class="row">
                <div class="col-md-12">
                    <div class="table table-responsive">
                        <table class="table table-bordered table-hover">
                            <thead>
                                <tr>
                                    <td align="center"><b>No</b></td>
                                    <td align="center"><b>Tanggal</b></td>
                                    <td align="center"><b>Simpanan</b></td>
                                    <td align="center"><b>Nominal</b></td>
                                    <td align="center"><b>Option</b></td>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                    $no=1;
                                    $JumlahTotal=0;
                                    if(empty($id_simpanan_jenis)){
                                        $query = mysqli_query($Conn, "SELECT*FROM simpanan WHERE (id_anggota='$id_anggota' AND rutin=1) AND (tanggal like '%$PeriodeKey%')");
                                    }else{
                                        $query = mysqli_query($Conn, "SELECT*FROM simpanan WHERE (id_anggota='$id_anggota' AND id_simpanan_jenis='$id_simpanan_jenis') AND (tanggal like '%$PeriodeKey%')");
                                    }
                                    while ($data = mysqli_fetch_array($query)) {
                                        $id_simpanan= $data['id_simpanan'];
                                        $tanggal= $data['tanggal'];
                                        $kategori= $data['kategori'];
                                        $jumlah= $data['jumlah'];
                                        $JumlahFormat = "" . number_format($jumlah,0,',','.');
                                        $JumlahTotal=$JumlahTotal+$jumlah;
                                        $strtotime=strtotime($tanggal);
                                        $TanggalFormat=date('d M Y',$strtotime);
                                        echo '<tr>';
                                        echo '  <td align="center">'.$no.'</td>';
                                        echo '  <td>'.$TanggalFormat.'</td>';
                                        echo '  <td>'.$kategori.'</td>';
                                        echo '  <td align="right">'.$JumlahFormat.'</td>';
                                        echo '  <td align="center">';
                                        echo '      <a class="btn btn-sm btn-outline-dark btn-rounded" href="javascript:void(0);" data-bs-toggle="dropdown" aria-expanded="false">';
                                        echo '          <i class="bi bi-three-dots"></i>';
                                        echo '      </a>';
                                        echo '      <ul class="dropdown-menu dropdown-menu-end dropdown-menu-arrow" style="">';
                                        echo '          <li>';
                                        echo '              <a class="dropdown-item" href="javascript:void(0)" data-bs-toggle="modal" data-bs-target="#ModalEditSimpanan" data-id="'.$GetData.'/'.$id_simpanan.'">';
                                        echo '                  <i class="bi bi-pencil"></i> Edit';
                                        echo '              </a>';
                                        echo '          </li>';
                                        echo '          <li>';
                                        echo '              <a class="dropdown-item" href="javascript:void(0)" data-bs-toggle="modal" data-bs-target="#ModalHapusSimpanan" data-id="'.$GetData.'/'.$id_simpanan.'">';
                                        echo '                  <i class="bi bi-trash"></i> Hapus';
                                        echo '              </a>';
                                        echo '          </li>';
                                        echo '      </ul>';
                                        echo '  </td>';
                                        echo '</tr>';
                                        $no++;
                                    }
                                    $JumlahTotalFormat = "" . number_format($JumlahTotal,0,',','.');
                                    echo '<tr>';
                                    echo '  <td align="center" colspan="3"><b>JUMLAH</b></td>';
                                    echo '  <td align="right"><b>'.$JumlahTotalFormat.'</b></td>';
                                    echo '  <td>';
                                    echo '';
                                    echo '  </td>';
                                    echo '</tr>';
                                ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>

<?php
        }
    }
?>
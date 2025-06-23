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
        if(empty($_POST['id_simpanan'])){
            echo '<div class="row">';
            echo '  <div class="col-md-12 mb-3 text-center">';
            echo '      <small class="text-danger">Tidak ada data yang ditangkap oleh sistem</small>';
            echo '  </div>';
            echo '</div>';
        }else{
            $id_simpanan=$_POST['id_simpanan'];
            //Buka Detail Simpanan
            $id_anggota=GetDetailData($Conn,'simpanan','id_simpanan',$id_simpanan,'id_anggota');
            $uuid_simpanan=GetDetailData($Conn,'simpanan','id_simpanan',$id_simpanan,'uuid_simpanan');
            $id_akses=GetDetailData($Conn,'simpanan','id_simpanan',$id_simpanan,'id_akses');
            $id_simpanan_jenis=GetDetailData($Conn,'simpanan','id_simpanan',$id_simpanan,'id_simpanan_jenis');
            $rutin=GetDetailData($Conn,'simpanan','id_simpanan',$id_simpanan,'rutin');
            $nip=GetDetailData($Conn,'simpanan','id_simpanan',$id_simpanan,'nip');
            $nama=GetDetailData($Conn,'simpanan','id_simpanan',$id_simpanan,'nama');
            $lembaga=GetDetailData($Conn,'simpanan','id_simpanan',$id_simpanan,'lembaga');
            $ranking=GetDetailData($Conn,'simpanan','id_simpanan',$id_simpanan,'ranking');
            $tanggal=GetDetailData($Conn,'simpanan','id_simpanan',$id_simpanan,'tanggal');
            $kategori=GetDetailData($Conn,'simpanan','id_simpanan',$id_simpanan,'kategori');
            $keterangan=GetDetailData($Conn,'simpanan','id_simpanan',$id_simpanan,'keterangan');
            $jumlah=GetDetailData($Conn,'simpanan','id_simpanan',$id_simpanan,'jumlah');
            if($kategori=="Penarikan"){
                $LabelKategori='<code class="text text-danger">Penarikan dana simpanan</code>';
            }else{
                $LabelKategori='<code class="text text-success">'.$kategori.'</code>';
            }
            //Format tanggal
            $strtotime=strtotime($tanggal);
            $TanggalFormat=date('d/m/Y',$strtotime);
            //Format Rupiah
            $jumlah_format = "Rp " . number_format($jumlah,0,',','.');
            if(empty($keterangan)){
                $keterangan="-";
            }
?>
            <div class="row mb-3">
                <div class="col col-md-12">
                    <div class="table table-responsive">
                        <table class="table table-bordered table-hover">
                            <thead>
                                <tr>
                                    <td class="text-center" colspan="5"><b>JURNAL SIMPANAN</b></td>
                                </tr>
                                <tr>
                                    <td class="text-center"><b>Kode</b></td>
                                    <td class="text-center"><b>Akun Perkiraan</b></td>
                                    <td class="text-center"><b>Debet</b></td>
                                    <td class="text-center"><b>Kredit</b></td>
                                    <td class="text-center"><b>Option</b></td>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                    $AdaJurnal=GetDetailData($Conn,'jurnal','uuid',$uuid_simpanan,'uuid');
                                    if(empty($AdaJurnal)){
                                        echo '<tr>';
                                        echo '  <td colspan="5" align="center" class="text-danger">Tidak Ada Jurnal Untuk Transaksi Simpanan Ini</td>';
                                        echo '</tr>';
                                    }else{
                                        $JumlahSaldoDebet=0;
                                        $JumlahSaldoKredit=0;
                                        $query = mysqli_query($Conn, "SELECT*FROM jurnal WHERE uuid='$uuid_simpanan' ORDER BY d_k ASC");
                                        while ($data = mysqli_fetch_array($query)) {
                                            $id_jurnal= $data['id_jurnal'];
                                            $kode_perkiraan= $data['kode_perkiraan'];
                                            $nama_perkiraan= $data['nama_perkiraan'];
                                            $d_k= $data['d_k'];
                                            $nilai= $data['nilai'];
                                            //Format Rupiah
                                            $NilaiFormat = "Rp " . number_format($nilai,0,',','.');
                                            if($d_k=="D"){
                                                $JumlahSaldoDebet=$JumlahSaldoDebet+$nilai;
                                                $JumlahSaldoKredit=$JumlahSaldoKredit+0;
                                                echo '<tr>';
                                                echo '  <td align="left"><code class="text text-grayish">'.$kode_perkiraan.'</code></td>';
                                                echo '  <td align="left"><code class="text text-grayish">'.$nama_perkiraan.'</code></td>';
                                                echo '  <td align="right"><code class="text text-grayish">'.$NilaiFormat.'</code></td>';
                                                echo '  <td align="right"><code class="text text-grayish">-</code></td>';
                                                echo '  <td align="center">';
                                                echo '      <a class="btn btn-sm btn-outline-dark btn-rounded" href="javascript:void(0);" data-bs-toggle="dropdown" aria-expanded="false">';
                                                echo '          <i class="bi bi-three-dots"></i>';
                                                echo '      </a>';
                                                echo '      <ul class="dropdown-menu dropdown-menu-end dropdown-menu-arrow" style="">';
                                                echo '          <li class="dropdown-header text-start">';
                                                echo '              <h6>Option</h6>';
                                                echo '          </li>';
                                                echo '          <li>';
                                                echo '              <a class="dropdown-item" href="javascript:void(0)" data-bs-toggle="modal" data-bs-target="#ModalEditJurnalSimpanan" data-id="'.$id_jurnal.'">';
                                                echo '                  <i class="bi bi-pencil"></i> Edit';
                                                echo '              </a>';
                                                echo '              <a class="dropdown-item" href="javascript:void(0)" data-bs-toggle="modal" data-bs-target="#ModalHapusJurnalSimpanan" data-id="'.$id_jurnal.'">';
                                                echo '                  <i class="bi bi-x"></i> Hapus';
                                                echo '              </a>';
                                                echo '      </ul>';
                                                echo '  </td>';
                                                echo '</tr>';
                                            }else{
                                                $JumlahSaldoDebet=$JumlahSaldoDebet+0;
                                                $JumlahSaldoKredit=$JumlahSaldoKredit+$nilai;
                                                echo '<tr>';
                                                echo '  <td align="left"><code class="text text-grayish">'.$kode_perkiraan.'</code></td>';
                                                echo '  <td align="left"><code class="text text-grayish">'.$nama_perkiraan.'</code></td>';
                                                echo '  <td align="right"><code class="text text-grayish">-</code></td>';
                                                echo '  <td align="right"><code class="text text-grayish">'.$NilaiFormat.'</code></td>';
                                                echo '  <td align="center">';
                                                echo '      <a class="btn btn-sm btn-outline-dark btn-rounded" href="javascript:void(0);" data-bs-toggle="dropdown" aria-expanded="false">';
                                                echo '          <i class="bi bi-three-dots"></i>';
                                                echo '      </a>';
                                                echo '      <ul class="dropdown-menu dropdown-menu-end dropdown-menu-arrow" style="">';
                                                echo '          <li class="dropdown-header text-start">';
                                                echo '              <h6>Option</h6>';
                                                echo '          </li>';
                                                echo '          <li>';
                                                echo '              <a class="dropdown-item" href="javascript:void(0)" data-bs-toggle="modal" data-bs-target="#ModalEditJurnalSimpanan" data-id="'.$id_jurnal.'">';
                                                echo '                  <i class="bi bi-pencil"></i> Edit';
                                                echo '              </a>';
                                                echo '              <a class="dropdown-item" href="javascript:void(0)" data-bs-toggle="modal" data-bs-target="#ModalHapusJurnalSimpanan" data-id="'.$id_jurnal.'">';
                                                echo '                  <i class="bi bi-x"></i> Hapus';
                                                echo '              </a>';
                                                echo '      </ul>';
                                                echo '  </td>';
                                                echo '</tr>';
                                            }
                                        }
                                        $JumlahSaldoDebet = "Rp " . number_format($JumlahSaldoDebet,0,',','.');
                                        $JumlahSaldoKredit = "Rp " . number_format($JumlahSaldoKredit,0,',','.');
                                        echo '<tr>';
                                        echo '  <td align="center" colspan="2"><b>JUMLAH/SALDO</b></td>';
                                        echo '  <td align="right"><b>'.$JumlahSaldoDebet.'</b></td>';
                                        echo '  <td align="right"><b>'.$JumlahSaldoKredit.'</b></td>';
                                        echo '  <td align="right"></td>';
                                        echo '</tr>';
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
?>
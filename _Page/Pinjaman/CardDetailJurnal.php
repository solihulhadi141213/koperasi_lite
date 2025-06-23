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
        if(empty($_POST['id_pinjaman'])){
            echo '<div class="row">';
            echo '  <div class="col-md-12 mb-3 text-center">';
            echo '      <small class="text-danger">Tidak ada data yang ditangkap oleh sistem</small>';
            echo '  </div>';
            echo '</div>';
        }else{
            $id_pinjaman=$_POST['id_pinjaman'];
            //Buka Detail Pinjaman
            $id_anggota=GetDetailData($Conn,'pinjaman','id_pinjaman',$id_pinjaman,'id_anggota');
            $uuid_pinjaman=GetDetailData($Conn,'pinjaman','id_pinjaman',$id_pinjaman,'uuid_pinjaman');
            $nip=GetDetailData($Conn,'pinjaman','id_pinjaman',$id_pinjaman,'nip');
            $nama=GetDetailData($Conn,'pinjaman','id_pinjaman',$id_pinjaman,'nama');
            $lembaga=GetDetailData($Conn,'pinjaman','id_pinjaman',$id_pinjaman,'lembaga');
            $ranking=GetDetailData($Conn,'pinjaman','id_pinjaman',$id_pinjaman,'ranking');
            $tanggal=GetDetailData($Conn,'pinjaman','id_pinjaman',$id_pinjaman,'tanggal');
            $jatuh_tempo=GetDetailData($Conn,'pinjaman','id_pinjaman',$id_pinjaman,'jatuh_tempo');
            $denda=GetDetailData($Conn,'pinjaman','id_pinjaman',$id_pinjaman,'denda');
            $sistem_denda=GetDetailData($Conn,'pinjaman','id_pinjaman',$id_pinjaman,'sistem_denda');
            $jumlah_pinjaman=GetDetailData($Conn,'pinjaman','id_pinjaman',$id_pinjaman,'jumlah_pinjaman');
            $persen_jasa=GetDetailData($Conn,'pinjaman','id_pinjaman',$id_pinjaman,'persen_jasa');
            $rp_jasa=GetDetailData($Conn,'pinjaman','id_pinjaman',$id_pinjaman,'rp_jasa');
            $angsuran_pokok=GetDetailData($Conn,'pinjaman','id_pinjaman',$id_pinjaman,'angsuran_pokok');
            $angsuran_total=GetDetailData($Conn,'pinjaman','id_pinjaman',$id_pinjaman,'angsuran_total');
            $periode_angsuran=GetDetailData($Conn,'pinjaman','id_pinjaman',$id_pinjaman,'periode_angsuran');
            $status=GetDetailData($Conn,'pinjaman','id_pinjaman',$id_pinjaman,'status');
            //Format tanggal
            $strtotime=strtotime($tanggal);
            $TanggalFormat=date('d/m/Y',$strtotime);
?>
            <div class="row mb-3">
                <div class="col col-md-12">
                    <div class="alert alert-info alert-dismissible fade show" role="alert">
                        <b>Keterangan</b><br>
                        Berikut ini adalah detail data jurnal pinjaman yang terhubung.
                        Pada halaman ini anda bisa mengelola jurnal pinjaman tersebut secara dinamis.
                    </div>
                </div>
            </div>
            <div class="row mb-3">
                <div class="col col-md-10"></div>
                <div class="col col-md-2">
                    <button type="button" class="btn btn-md btn-primary btn-rounded btn-block" data-bs-toggle="modal" data-bs-target="#ModalTambahJurnalPinjaman" data-id="<?php echo "$id_pinjaman"; ?>">
                        <i class="bi bi-plus"></i> Tambah
                    </button>
                </div>
            </div>
            <div class="row mb-3">
                <div class="col col-md-12">
                    <div class="table table-responsive">
                        <table class="table table-bordered table-hover">
                            <thead>
                                <tr>
                                    <td class="text-left" colspan="5">
                                        Referensi : <code class="text text-grayish"><?php echo "Pinjaman-$TanggalFormat"; ?></code>
                                    </td>
                                </tr>
                                <tr>
                                    <td class="text-center"><b>Kode</b></td>
                                    <td class="text-center"><b>Akun Perkiraan</b></td>
                                    <td class="text-center"><b>Debet</b></td>
                                    <td class="text-center"><b>Kredit</b></td>
                                    <td class="text-center"><b>Opsi</b></td>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                    $AdaJurnal=GetDetailData($Conn,'jurnal','uuid',$uuid_pinjaman,'uuid');
                                    if(empty($AdaJurnal)){
                                        echo '<tr>';
                                        echo '  <td colspan="5" align="center" class="text-danger">Tidak Ada Jurnal Untuk Transaksi pinjaman Ini</td>';
                                        echo '</tr>';
                                    }else{
                                        $JumlahSaldoDebet=0;
                                        $JumlahSaldoKredit=0;
                                        $query = mysqli_query($Conn, "SELECT*FROM jurnal WHERE uuid='$uuid_pinjaman' ORDER BY d_k ASC");
                                        while ($data = mysqli_fetch_array($query)) {
                                            $id_jurnal= $data['id_jurnal'];
                                            $uuid= $data['uuid'];
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
                                                echo '          <i class="bi bi-three-dots"></i> Opsi';
                                                echo '      </a>';
                                                echo '      <ul class="dropdown-menu dropdown-menu-end dropdown-menu-arrow" style="">';
                                                echo '          <li>';
                                                echo '              <a class="dropdown-item" href="javascript:void(0)" data-bs-toggle="modal" data-bs-target="#ModalEditJurnalPinjaman" data-id="'.$id_jurnal.'">';
                                                echo '                  <i class="bi bi-pencil"></i> Ubah';
                                                echo '              </a>';
                                                echo '          </li>';
                                                echo '          <li>';
                                                echo '              <a class="dropdown-item" href="javascript:void(0)" data-bs-toggle="modal" data-bs-target="#ModalHapusJurnalPinjaman" data-id="'.$id_jurnal.'">';
                                                echo '                  <i class="bi bi-x"></i> Hapus';
                                                echo '              </a>';
                                                echo '          </li>';
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
                                                echo '          <i class="bi bi-three-dots"></i> Opsi';
                                                echo '      </a>';
                                                echo '      <ul class="dropdown-menu dropdown-menu-end dropdown-menu-arrow" style="">';
                                                echo '          <li>';
                                                echo '              <a class="dropdown-item" href="javascript:void(0)" data-bs-toggle="modal" data-bs-target="#ModalEditJurnalPinjaman" data-id="'.$id_jurnal.'">';
                                                echo '                  <i class="bi bi-pencil"></i> Ubah';
                                                echo '              </a>';
                                                echo '          </li>';
                                                echo '          <li>';
                                                echo '              <a class="dropdown-item" href="javascript:void(0)" data-bs-toggle="modal" data-bs-target="#ModalHapusJurnalPinjaman" data-id="'.$id_jurnal.'">';
                                                echo '                  <i class="bi bi-x"></i> Hapus';
                                                echo '              </a>';
                                                echo '          </li>';
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
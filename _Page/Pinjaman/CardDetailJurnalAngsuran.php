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
        if(empty($_POST['id_angsuran'])){
            echo '<div class="row">';
            echo '  <div class="col-md-12 mb-3 text-center">';
            echo '      <small class="text-danger">Tidak ada data yang ditangkap oleh sistem</small>';
            echo '  </div>';
            echo '</div>';
        }else{
            $id_pinjaman_angsuran=$_POST['id_angsuran'];
            $uuid_angsuran=GetDetailData($Conn,'pinjaman_angsuran','id_pinjaman_angsuran',$id_pinjaman_angsuran,'uuid_angsuran');
            $tanggal_angsuran=GetDetailData($Conn,'pinjaman_angsuran','id_pinjaman_angsuran',$id_pinjaman_angsuran,'tanggal_angsuran');
            $tanggal_bayar=GetDetailData($Conn,'pinjaman_angsuran','id_pinjaman_angsuran',$id_pinjaman_angsuran,'tanggal_bayar');
?>
            <div class="row mb-3">
                <div class="col col-md-12">
                    <div class="alert alert-info alert-dismissible fade show" role="alert">
                        <b>Keterangan</b><br>
                        Berikut ini adalah detail data jurnal angsuran pinjaman yang terhubung.
                        Pada halaman ini anda bisa mengelola jurnal angsuran tersebut secara dinamis.
                    </div>
                </div>
            </div>
            <div class="row mb-3">
                <div class="col col-md-10"></div>
                <div class="col col-md-2">
                    <button type="button" class="btn btn-md btn-primary btn-rounded btn-block" data-bs-toggle="modal" data-bs-target="#ModalTambahJurnalAngsuran" data-id="<?php echo "$id_pinjaman_angsuran"; ?>">
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
                                        Referensi : <code class="text text-grayish"><?php echo "Angsuran-$tanggal_angsuran"; ?></code>
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
                                    $AdaJurnal=GetDetailData($Conn,'jurnal','uuid',$uuid_angsuran,'uuid');
                                    if(empty($AdaJurnal)){
                                        echo '<tr>';
                                        echo '  <td colspan="5" align="center" class="text-danger">Tidak Ada Jurnal Untuk Transaksi pinjaman Ini</td>';
                                        echo '</tr>';
                                    }else{
                                        $JumlahSaldoDebet=0;
                                        $JumlahSaldoKredit=0;
                                        $query = mysqli_query($Conn, "SELECT*FROM jurnal WHERE uuid='$uuid_angsuran' ORDER BY d_k ASC");
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
                                                echo '              <a class="dropdown-item" href="javascript:void(0)" data-bs-toggle="modal" data-bs-target="#ModalEditJurnalAngsuran" data-id="'.$id_jurnal.'">';
                                                echo '                  <i class="bi bi-pencil"></i> Ubah';
                                                echo '              </a>';
                                                echo '          </li>';
                                                echo '          <li>';
                                                echo '              <a class="dropdown-item" href="javascript:void(0)" data-bs-toggle="modal" data-bs-target="#ModalHapusJurnalAngsuran" data-id="'.$id_jurnal.'">';
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
                                                echo '              <a class="dropdown-item" href="javascript:void(0)" data-bs-toggle="modal" data-bs-target="#ModalEditJurnalAngsuran" data-id="'.$id_jurnal.'">';
                                                echo '                  <i class="bi bi-pencil"></i> Ubah';
                                                echo '              </a>';
                                                echo '          </li>';
                                                echo '          <li>';
                                                echo '              <a class="dropdown-item" href="javascript:void(0)" data-bs-toggle="modal" data-bs-target="#ModalHapusJurnalAngsuran" data-id="'.$id_jurnal.'">';
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
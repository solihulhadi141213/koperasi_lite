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
        //Tangkap id_transaksi
        if(empty($_POST['id_transaksi'])){
            echo '<div class="row">';
            echo '  <div class="col-md-12 mb-3 text-center">';
            echo '      <small class="text-danger">ID Transaksi Tidak Boleh Kosong!</small>';
            echo '  </div>';
            echo '</div>';
        }else{
            $id_transaksi=$_POST['id_transaksi'];
            //Bersihkan Variabel
            $id_transaksi=validateAndSanitizeInput($id_transaksi);
            //Buka Informasi
            $uuid_transaksi=GetDetailData($Conn,'transaksi','id_transaksi',$id_transaksi,'uuid_transaksi');
            $id_transaksi_jenis=GetDetailData($Conn,'transaksi','id_transaksi',$id_transaksi,'id_transaksi_jenis');
            $nama_transaksi=GetDetailData($Conn,'transaksi','id_transaksi',$id_transaksi,'nama_transaksi');
            $kategori=GetDetailData($Conn,'transaksi','id_transaksi',$id_transaksi,'kategori');
            $tanggal=GetDetailData($Conn,'transaksi','id_transaksi',$id_transaksi,'tanggal');
            $jumlah=GetDetailData($Conn,'transaksi','id_transaksi',$id_transaksi,'jumlah');
            $pembayaran=GetDetailData($Conn,'transaksi','id_transaksi',$id_transaksi,'pembayaran');
            $status=GetDetailData($Conn,'transaksi','id_transaksi',$id_transaksi,'status');
            if(empty($pembayaran)){
                $pembayaran=0;
            }
            //Menghitung Jumlah Rincian
            $JumlahRincian = mysqli_num_rows(mysqli_query($Conn, "SELECT*FROM transaksi_rincian WHERE id_transaksi='$id_transaksi'"));
            //Jumlah Jurnal
            $JumlahJurnal = mysqli_num_rows(mysqli_query($Conn, "SELECT*FROM jurnal WHERE uuid='$uuid_transaksi'"));
            //Format Angka
            $JumlahFormat = "" . number_format($jumlah,0,',','.');
            $PembayaranFormat = "Rp " . number_format($pembayaran,0,',','.');
            //Format Tanggal
            $strtotime=strtotime($tanggal);
            $TanggalFormat=date('d/m/Y H:i:s T', $strtotime);
            $TanggalKode=date('d/m/Y', $strtotime);
?>
    <table class="table table-bordered table-hover">
        <thead>
            <tr>
                <td align="left" colspan="5">
                    <small class="credit">
                        Referensi : 
                        <code class="text text-grayish">
                            <?php echo "TRANS-$id_transaksi_jenis-$TanggalKode-$id_transaksi"; ?>
                        </code>
                    </small>
                </td>
            </tr>
            <tr>
                <td align="center"><b>Kode</b></td>
                <td align="center"><b>Akun Perkiraan</b></td>
                <td align="center"><b>Debet</b></td>
                <td align="center"><b>Kredit</b></td>
                <td align="center"><b>Opsi</b></td>
            </tr>
        </thead>
        <tbody>
            <?php
                //Menampilkan Jurnal
                $JumlahDebet=0;
                $JumlahKredit=0;
                if(!empty($JumlahJurnal)){
                    $query = mysqli_query($Conn, "SELECT*FROM jurnal WHERE kategori='Transaksi' AND uuid='$uuid_transaksi' ORDER BY id_jurnal ASC");
                    while ($data = mysqli_fetch_array($query)) {
                        $id_jurnal= $data['id_jurnal'];
                        $kode_perkiraan= $data['kode_perkiraan'];
                        $nama_perkiraan= $data['nama_perkiraan'];
                        $d_k= $data['d_k'];
                        $nilai= $data['nilai'];
                        $NilaiFormat = "Rp " . number_format($nilai,0,',','.');
                        if($d_k=="D"){
                            $JumlahDebet=$JumlahDebet+$nilai;
                            $JumlahKredit=$JumlahKredit+0;
                            echo '<tr>';
                            echo '  <td align="center">'.$kode_perkiraan.'</td>';
                            echo '  <td align="left">'.$nama_perkiraan.'</td>';
                            echo '  <td align="right">'.$NilaiFormat.'</td>';
                            echo '  <td align="right">-</td>';
                            echo '  <td align="center">';
                            echo '      <a class="btn btn-sm btn-outline-dark btn-rounded" href="javascript:void(0);" data-bs-toggle="dropdown" aria-expanded="false">';
                            echo '          <i class="bi bi-three-dots"></i>';
                            echo '      </a>';
                            echo '      <ul class="dropdown-menu dropdown-menu-end dropdown-menu-arrow" style="">';
                            echo '          <li class="dropdown-header text-start">';
                            echo '              <h6>Option</h6>';
                            echo '          </li>';
                            echo '          <li>';
                            echo '              <a class="dropdown-item" href="javascript:void(0)" data-bs-toggle="modal" data-bs-target="#ModalEditJurnal" data-id="'.$id_jurnal.'">';
                            echo '                  <i class="bi bi-pencil"></i> Ubah/Edit';
                            echo '              </a>';
                            echo '              <a class="dropdown-item" href="javascript:void(0)" data-bs-toggle="modal" data-bs-target="#ModalHapusJurnal" data-id="'.$id_jurnal.'">';
                            echo '                  <i class="bi bi-trash"></i> Hapus';
                            echo '              </a>';
                            echo '      </ul>';
                            echo '  </td>';
                            echo '</tr>';
                        }else{
                            $JumlahDebet=$JumlahDebet+0;
                            $JumlahKredit=$JumlahKredit+$nilai;
                            echo '<tr>';
                            echo '  <td align="center">'.$kode_perkiraan.'</td>';
                            echo '  <td align="left">'.$nama_perkiraan.'</td>';
                            echo '  <td align="right">-</td>';
                            echo '  <td align="right">'.$NilaiFormat.'</td>';
                            echo '  <td align="center">';
                            echo '      <a class="btn btn-sm btn-outline-dark btn-rounded" href="javascript:void(0);" data-bs-toggle="dropdown" aria-expanded="false">';
                            echo '          <i class="bi bi-three-dots"></i>';
                            echo '      </a>';
                            echo '      <ul class="dropdown-menu dropdown-menu-end dropdown-menu-arrow" style="">';
                            echo '          <li class="dropdown-header text-start">';
                            echo '              <h6>Option</h6>';
                            echo '          </li>';
                            echo '          <li>';
                            echo '              <a class="dropdown-item" href="javascript:void(0)" data-bs-toggle="modal" data-bs-target="#ModalEditJurnal" data-id="'.$id_jurnal.'">';
                            echo '                  <i class="bi bi-pencil"></i> Ubah/Edit';
                            echo '              </a>';
                            echo '              <a class="dropdown-item" href="javascript:void(0)" data-bs-toggle="modal" data-bs-target="#ModalHapusJurnal" data-id="'.$id_jurnal.'">';
                            echo '                  <i class="bi bi-trash"></i> Hapus';
                            echo '              </a>';
                            echo '      </ul>';
                            echo '  </td>';
                            echo '</tr>';
                        }
                    }
                }
                $JumlahDebetFormat = "Rp " . number_format($JumlahDebet,0,',','.');
                $JumlahKreditFormat = "Rp " . number_format($JumlahKredit,0,',','.');
            ?>
            <tr>
                <td align="right" colspan="2">
                    <b>JUMLAH/SALDO</b>
                </td>
                <td align="right"><b><?php echo $JumlahDebetFormat; ?></b></td>
                <td align="right"><b><?php echo $JumlahKreditFormat; ?></b></td>
                <td align="right"></td>
            </tr>
        </tbody>
    </table>
<?php 
        }
    }
?>
<?php
    //koneksi dan session
    include "../../_Config/Connection.php";
    include "../../_Config/GlobalFunction.php";
    include "../../_Config/Session.php";
    date_default_timezone_set("Asia/Jakarta");
    if(empty($SessionIdAkses)){
        echo '<tr>';
        echo '  <td colspan="6" class="text-center">';
        echo '      <small class="text-danger">Sesi Akses Sudah Berakhir, Silahkan Login Ulang</small>';
        echo '  </td>';
        echo '</tr>';
    }else{
        if(empty($_POST['id_shu_session'])){
            echo '
                <tr>
                    <td colspan="6" class="text-center">
                        <small class="text-danger">ID Sesi SHU Tidak Boleh Kosong!</small>
                    </td>
                </tr>
            ';
        }else{
            $id_shu_session=$_POST['id_shu_session'];
            
            //Buka UID
            $uuid_shu_session=GetDetailData($Conn,'shu_session','id_shu_session',$id_shu_session,'uuid_shu_session');
            $jml_data = mysqli_num_rows(mysqli_query($Conn, "SELECT*FROM jurnal WHERE id_shu_session='$id_shu_session'"));
            if(empty($jml_data)){
                echo '
                    <tr>
                        <td colspan="6" class="text-center">
                            <small class="text-danger">Tidak Ada Data Jurnal Untuk Transaksi SHU ini</small>
                        </td>
                    </tr>
                ';
            }else{
                $JumlahSaldoDebet=0;
                $JumlahSaldoKredit=0;
                $no=1;
                $query = mysqli_query($Conn, "SELECT*FROM jurnal WHERE id_shu_session='$id_shu_session' ORDER BY id_jurnal DESC");
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
                        echo '  <td align="left"><small class="text text-muted">'.$no.'</small></td>';
                        echo '  <td align="left"><small class="text text-muted">'.$kode_perkiraan.'</small></td>';
                        echo '  <td align="left"><small class="text text-muted">'.$nama_perkiraan.'</small></td>';
                        echo '  <td align="left"><small class="text text-muted">'.$NilaiFormat.'</small></td>';
                        echo '  <td align="left"><small class="text text-muted">-</small></td>';
                        echo '  <td align="center">';
                        echo '      <a class="btn btn-sm btn-outline-dark btn-floating" href="javascript:void(0);" data-bs-toggle="dropdown" aria-expanded="false">';
                        echo '          <i class="bi bi-three-dots"></i>';
                        echo '      </a>';
                        echo '      <ul class="dropdown-menu dropdown-menu-end dropdown-menu-arrow" style="">';
                        echo '          <li>';
                        echo '              <a class="dropdown-item" href="javascript:void(0)" data-bs-toggle="modal" data-bs-target="#ModalEditJurnal" data-id="'.$id_jurnal.'">';
                        echo '                  <i class="bi bi-pencil"></i> Ubah';
                        echo '              </a>';
                        echo '          </li>';
                        echo '          <li>';
                        echo '              <a class="dropdown-item" href="javascript:void(0)" data-bs-toggle="modal" data-bs-target="#ModalHapusJurnal" data-id="'.$id_jurnal.'">';
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
                        echo '  <td align="left"><small class="text text-muted">'.$no.'</small></td>';
                        echo '  <td align="left"><small class="text text-muted">'.$kode_perkiraan.'</small></td>';
                        echo '  <td align="left"><small class="text text-muted">'.$nama_perkiraan.'</small></td>';
                        echo '  <td align="left"><small class="text text-muted">-</small></td>';
                        echo '  <td align="left"><small class="text text-muted">'.$NilaiFormat.'</small></td>';
                        echo '  <td align="center">';
                        echo '      <a class="btn btn-sm btn-outline-dark btn-floating" href="javascript:void(0);" data-bs-toggle="dropdown" aria-expanded="false">';
                        echo '          <i class="bi bi-three-dots"></i>';
                        echo '      </a>';
                        echo '      <ul class="dropdown-menu dropdown-menu-end dropdown-menu-arrow" style="">';
                        echo '          <li>';
                        echo '              <a class="dropdown-item" href="javascript:void(0)" data-bs-toggle="modal" data-bs-target="#ModalEditJurnal" data-id="'.$id_jurnal.'">';
                        echo '                  <i class="bi bi-pencil"></i> Ubah';
                        echo '              </a>';
                        echo '          </li>';
                        echo '          <li>';
                        echo '              <a class="dropdown-item" href="javascript:void(0)" data-bs-toggle="modal" data-bs-target="#ModalHapusJurnal" data-id="'.$id_jurnal.'">';
                        echo '                  <i class="bi bi-x"></i> Hapus';
                        echo '              </a>';
                        echo '          </li>';
                        echo '      </ul>';
                        echo '  </td>';
                        echo '</tr>';
                    }
                    $no++;
                }
                $JumlahSaldoDebet = "Rp " . number_format($JumlahSaldoDebet,0,',','.');
                $JumlahSaldoKredit = "Rp " . number_format($JumlahSaldoKredit,0,',','.');
                // echo '<tr>';
                // echo '  <td align="center" colspan="3"><b>JUMLAH/SALDO</b></td>';
                // echo '  <td align="left"><b>'.$JumlahSaldoDebet.'</b></td>';
                // echo '  <td align="left"><b>'.$JumlahSaldoKredit.'</b></td>';
                // echo '  <td align="left"></td>';
                // echo '</tr>';
            }
        }
    }
?>
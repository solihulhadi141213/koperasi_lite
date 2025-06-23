<?php
    //koneksi dan session
    include "../../_Config/Connection.php";
    include "../../_Config/GlobalFunction.php";
    include "../../_Config/Session.php";
    if(empty($SessionIdAkses)){
        echo '
            <div class="alert alert-danger">
                <small>Sesi Akses Sudah Berakhir! Silahkan Login Ulang!</small>
            </div>
        ';
    }else{
        if(empty($_POST['id_anggota'])){
            echo '
                <div class="alert alert-danger">
                    <small>ID Anggota Tidak Boleh Kosong!</small>
                </div>
            ';
        }else{
            if(empty($_POST['periode'])){
                echo '
                    <div class="alert alert-danger">
                        <small>Periode Data Tidak Boleh Kosong!</small>
                    </div>
                ';
            }else{
                //Buat Dalam Bentuk Variabel Yang Sudah Dibersihkan
                $id_anggota=validateAndSanitizeInput($_POST['id_anggota']);
                $periode=validateAndSanitizeInput($_POST['periode']);
                //Format Periode Data
                $periode_format=date('d F Y', strtotime($periode));
                //Buka Data Informasi Anggota
                $Qry = $Conn->prepare("SELECT * FROM anggota WHERE id_anggota = ?");
                $Qry->bind_param("i", $id_anggota);
                if (!$Qry->execute()) {
                    $error=$Conn->error;
                    echo '
                        <div class="alert alert-danger">
                            <small>'.$error.'</small>
                        </div>
                    ';
                }else{
                    $Result = $Qry->get_result();
                    $Data = $Result->fetch_assoc();
                    $Qry->close();

                    //Buat Variabel
                    $tanggal_masuk=$Data['tanggal_masuk'];
                    $tanggal_keluar=$Data['tanggal_keluar'];
                    $nip=$Data['nip'];
                    $nama=$Data['nama'];
                    $email=$Data['email'];
                    $password=$Data['password'];
                    $kontak=$Data['kontak'];
                    $lembaga=$Data['lembaga'];
                    $ranking=$Data['ranking'];
                    $foto=$Data['foto'];
                    $akses_anggota=$Data['akses_anggota'];
                    $status=$Data['status'];
                    $alasan_keluar=$Data['alasan_keluar'];
                    echo '
                        <div class="row mb-2">
                            <div class="col-12">
                                <b>POTONGAN KOPERASI</b>
                            </div>
                        </div>
                        <div class="row mb-2">
                            <div class="col-4"><small>Periode</small></div>
                            <div class="col-1"><small>:</small></div>
                            <div class="col-7"><small class="text text-dark">'.$periode_format.'</small></div>
                        </div>
                        <div class="row mb-2">
                            <div class="col-4"><small>No.Induk</small></div>
                            <div class="col-1"><small>:</small></div>
                            <div class="col-7"><small class="text text-dark">'.$nip.'</small></div>
                        </div>
                        <div class="row mb-2">
                            <div class="col-4"><small>Nama Anggota</small></div>
                            <div class="col-1"><small>:</small></div>
                            <div class="col-7"><small class="text text-dark">'.$nama.'</small></div>
                        </div>
                        <div class="row mb-2">
                            <div class="col-4"><small>Divisi/Unit Kerja</small></div>
                            <div class="col-1"><small>:</small></div>
                            <div class="col-7"><small class="text text-dark">'.$lembaga.'</small></div>
                        </div>
                        <div class="row mb-2">
                            <div class="col-4"><small>Status Anggota</small></div>
                            <div class="col-1"><small>:</small></div>
                            <div class="col-7"><small class="text text-dark">'.$status.'</small></div>
                        </div>
                    ';
                    echo '<div class="row mb-2">';
                    echo '  <div class="col-12">';
                    echo '      <div class="table_custome">';
                    echo '          <table class="table_custome" width="100%">';
                    echo '
                                        <thead>
                                            <tr>
                                                <th align="center"><b>No</b></th>
                                                <th align="center"><b>Uraian</b></th>
                                                <th align="center"><b>Potongan</b></th>
                                                <th align="center"><b>Sisa Angsuran</b></th>
                                                <th align="center"><b>Sisa Pelunasan</b></th>
                                            </tr>
                                        </thead>
                    ';
                    echo '              <tbody>';
                    //List Jenis Pinjaman
                    $no=1;
                    $total_sisa_angsuran=0;
                    $total_potongan=0;
                    $query = mysqli_query($Conn, "SELECT*FROM pinjaman_jenis ORDER BY id_pinjaman_jenis ASC");
                    while ($data = mysqli_fetch_array($query)) {
                        $id_pinjaman_jenis= $data['id_pinjaman_jenis'];
                        $nama_pinjaman= $data['nama_pinjaman'];
                        //Buka Detail Pinjaman
                        $potongan=0;
                        $periode_angsuran=0;
                        $nominal_sisa_angsuran=0;
                        //Buka Data Pinjaman Yang Belum Lunas
                        $QrySesiPinjaman = $Conn->prepare("SELECT * FROM pinjaman WHERE id_pinjaman_jenis = ? AND id_anggota = ? AND status!='Lunas' AND tanggal<= ?");
                        $QrySesiPinjaman->bind_param("iis", $id_pinjaman_jenis, $id_anggota, $periode);
                        if (!$QrySesiPinjaman->execute()) {
                            $potongan=0;
                            $periode_angsuran=0;
                            $error=$Conn->error;
                            echo '
                                <tr>
                                    <td colspan="5"><small class="text-danger">'.$error.'</small></td>
                                </tr>
                            ';
                        }else{
                            $ResultSesiPinjaman = $QrySesiPinjaman->get_result();
                            $DataSesiPinjaman = $ResultSesiPinjaman->fetch_assoc();
                            $QrySesiPinjaman->close();

                            //Buat Variabel Pinjaman
                            if(empty($DataSesiPinjaman['id_pinjaman'])){
                                $potongan=0;
                                $periode_angsuran=0;
                            }else{
                                $id_pinjaman=$DataSesiPinjaman['id_pinjaman'];
                                $potongan=$DataSesiPinjaman['angsuran_total'];
                                $periode_angsuran=$DataSesiPinjaman['periode_angsuran'];
                                $total_angsuran=$potongan*$periode_angsuran;
                                
                                //Hitung Periode Angsuran masuk
                                $_pa_stmt = $Conn->prepare("SELECT id_pinjaman_angsuran FROM pinjaman_angsuran WHERE id_pinjaman = ? AND tanggal_angsuran <= ?");
                                $_pa_stmt->bind_param("is", $id_pinjaman, $periode);
                                $_pa_stmt->execute();
                                $_pa_result = $_pa_stmt->get_result();
                                $jumlah_angsuran_masuk = $_pa_result->num_rows;
                                $_pa_stmt->close();
                                
                                //Hitung Nominal Angsuran Masuk
                                $_pa_stmt_sum = $Conn->prepare("SELECT SUM(jumlah) AS jumlah FROM pinjaman_angsuran WHERE id_pinjaman = ? AND tanggal_angsuran <= ?");
                                $_pa_stmt_sum->bind_param("is", $id_pinjaman, $periode);
                                $_pa_stmt_sum->execute();
                                $_pa_result_sum = $_pa_stmt_sum->get_result();

                                $JumlahAngsuran = 0;
                                if ($_pa_row_sum = $_pa_result_sum->fetch_assoc()) {
                                    $JumlahAngsuran = $_pa_row_sum['jumlah'] ?? 0;
                                }

                                $_pa_stmt_sum->close();

                                //Menghitung Sisa Periode Angsuran
                                $periode_angsuran=$periode_angsuran-$jumlah_angsuran_masuk;

                                //Menghitung Nominal Sisa Angsuran
                                $nominal_sisa_angsuran=$total_angsuran-$JumlahAngsuran;
                            }
                        }

                        //Format Nominal
                        $potongan_rp = "Rp " . number_format($potongan,0,',','.');
                        $nominal_sisa_angsuran_rp = "Rp " . number_format($nominal_sisa_angsuran,0,',','.');
                        echo '
                            <tr>
                                <td align="center"><small>'.$no.'</small></td>
                                <td align="left"><small>'.$nama_pinjaman.'</small></td>
                                <td align="right"><small>'.$potongan_rp.'</small></td>
                                <td align="right"><small>'.$periode_angsuran.'</small></td>
                                <td align="right"><small>'.$nominal_sisa_angsuran_rp.'</small></td>
                            </tr>
                        ';
                        $no++;

                        $total_potongan=$total_potongan+$potongan;
                        $total_sisa_angsuran=$total_sisa_angsuran+$nominal_sisa_angsuran;
                    }

                    //Menghitung Jumlah Pembelian Anggota Yang Belum Lunas
                    $SumPenjualan = mysqli_fetch_array(mysqli_query($Conn, "SELECT SUM(total) AS total FROM transaksi_jual_beli WHERE id_anggota='$id_anggota' AND kategori='Penjualan' AND status='Kredit' AND tanggal<='$periode'"));
                    $JumlahNomiinalPenjualan = $SumPenjualan['total'];
                    $SumPenjualanRetur = mysqli_fetch_array(mysqli_query($Conn, "SELECT SUM(total) AS total FROM transaksi_jual_beli WHERE id_anggota='$id_anggota' AND kategori='Retur Penjualan' AND status='Kredit' AND tanggal<='$periode'"));
                    $JumlahNomiinalPenjualanRetur = $SumPenjualanRetur['total'];
                    //Hitung Jumlah
                    $jumlah_penjualan_anggota=$JumlahNomiinalPenjualan-$JumlahNomiinalPenjualanRetur;
                    $jumlah_penjualan_anggota_rp = "Rp " . number_format($jumlah_penjualan_anggota,0,',','.');
                    echo '
                                    <tr>
                                        <td align="center"><small>'.$no.'</small></td>
                                        <td align="left"><small>Utang Belanja/Pembelian</small></td>
                                        <td align="right"><small>'.$jumlah_penjualan_anggota_rp.'</small></td>
                                        <td align="right"><small>-</small></td>
                                        <td align="right"><small>'.$jumlah_penjualan_anggota_rp.'</small></td>
                                    </tr>
                    ';
                    $total_potongan=$total_potongan+$jumlah_penjualan_anggota;
                    $total_potongan_rp = "Rp " . number_format($total_potongan,0,',','.');

                    $total_sisa_angsuran=$total_sisa_angsuran+$jumlah_penjualan_anggota;
                    $total_sisa_angsuran_rp = "Rp " . number_format($total_sisa_angsuran,0,',','.');
                    echo '
                                    <tr>
                                        <td><small></small></td>
                                        <td><small><b>TOTAL</b></small></td>
                                        <td align="right"><small><b>'.$total_potongan_rp.'</b></small></td>
                                        <td align="right"><small>-</small></td>
                                        <td align="right"><small><b>'.$total_sisa_angsuran_rp.'</b></small></td>
                                    </tr>
                    ';
                    echo '              </tbody>';
                    echo '          </table>';
                    echo '      </div>';
                    echo '  </div>';
                    echo '</div>';
                }
            }
        }
    }
?>
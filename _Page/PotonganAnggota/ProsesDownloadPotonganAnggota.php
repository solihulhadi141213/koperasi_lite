<?php
    //koneksi dan session
    include "../../_Config/Connection.php";
    include "../../_Config/GlobalFunction.php";
    include "../../_Config/Session.php";
    if(empty($SessionIdAkses)){
        echo '
            <div class="alert alert-danger">
                Sesi Akses Sudah Berakhir! Silahkan Login Ulang!
            </div>
        ';
    }else{
        if(empty($_POST['periode'])){
            echo '
                <div class="alert alert-danger">
                    Periode Data Tidak Boleh Kosong!
                </div>
            ';
        }else{
            if(empty($_POST['tipe_download'])){
                echo '
                    <div class="alert alert-danger">
                        Tipe Data Tidak Boleh Kosong!
                    </div>
                ';
            }else{
                echo '<html>';
                echo '  <head>';
                echo '      <title>Data Potongan Koperasi Anggota</title>';
                echo '
                    <style type="text/css">
                        body{
                            font-family: Arial, Helvetica, sans-serif;
                            color: black;
                        }
                        table tr td{
                            border: 1px solid #999;
                            padding: 8px 20px;
                            
                        }
                    </style>
                ';
                echo '  </head>';
                
                echo '  <body>';
                //Buat Dalam Bentuk Variabel Yang Sudah Dibersihkan
                $periode=validateAndSanitizeInput($_POST['periode']);
                $tipe_download=validateAndSanitizeInput($_POST['tipe_download']);
                $jumlah_pinjaman_jenis=mysqli_num_rows(mysqli_query($Conn, "SELECT*FROM pinjaman_jenis"));
                $colspan=$jumlah_pinjaman_jenis+5;

                //Buat Dalam CSV
                header("Content-Type: application/vnd.ms-excel");
                header("Content-Disposition: attachment; filename=potongan_anggota.xls");
                //Format Periode Data
                $periode_format=date('d F Y', strtotime($periode));
                //Tampilkan Data Dalam Mode Table
                if($tipe_download=="Table"){
                    echo '<table width="100%">';
                    echo '  
                    <tr>
                        <td align="center" rowspan="2"><b>No</b></td>
                        <td align="center" rowspan="2"><b>Nama Anggota</b></td>
                        <td align="center" rowspan="2"><b>No.Induk</b></td>
                        <td align="center" colspan="'.$jumlah_pinjaman_jenis.'"><b>Potongan/Jenis Pinjaman</b></td>
                        <td align="center" rowspan="2"><b>Pembelian</b></td>
                        <td align="center" rowspan="2"><b>Jumlah Potongan</b></td>
                    </tr>
                    ';
                    echo '<tr>';
                    $query_jenis_pinjaman = mysqli_query($Conn, "SELECT*FROM pinjaman_jenis ORDER BY id_pinjaman_jenis ASC");
                    while ($data_jenis_pinjaman = mysqli_fetch_array($query_jenis_pinjaman)) {
                        $id_pinjaman_jenis= $data_jenis_pinjaman['id_pinjaman_jenis'];
                        $nama_pinjaman= $data_jenis_pinjaman['nama_pinjaman'];
                        echo '<td class="text-center"><b>'.$nama_pinjaman.'</b></td>';
                    }
                    echo '</tr>';
                    $jml_data = mysqli_num_rows(mysqli_query($Conn, "SELECT id_anggota FROM anggota"));
                    if(empty($jml_data)){
                        echo '
                            <tr>
                                <td colspan="'.$colspan.'" class="text-center text-danger">
                                    Tidak Ada Data Anggota Yang Bisa Ditampilkan!
                                </td>
                            </tr>
                        ';
                    }else{
                        $no=1;
                        $query_anggota = mysqli_query($Conn, "SELECT*FROM anggota WHERE status='Aktif' ORDER BY nama ASC");
                        while ($data_anggota = mysqli_fetch_array($query_anggota)) {
                            $id_anggota= $data_anggota['id_anggota'];
                            $nama= $data_anggota['nama'];
                            $nip= $data_anggota['nip'];
                            echo '<tr>';
                            echo '  <td>'.$no.'</td>';
                            echo '  <td>'.$nama.'</td>';
                            echo '  <td>'.$nip.'</td>';
                            $jumlah_total_potongan_angsuran=0;
                            $QryPinjaman = mysqli_query($Conn, "SELECT id_pinjaman_jenis FROM pinjaman_jenis ORDER BY id_pinjaman_jenis ASC");
                            while ($DataPinjaman = mysqli_fetch_array($QryPinjaman)) {
                                $id_pinjaman_jenis= $DataPinjaman['id_pinjaman_jenis'];
                                
                                //Buka Detail Pinjaman
                                $QrySesiPinjaman = $Conn->prepare("SELECT * FROM pinjaman WHERE id_pinjaman_jenis = ? AND id_anggota = ? AND status!='Lunas' AND tanggal<= ?");
                                $QrySesiPinjaman->bind_param("iis", $id_pinjaman_jenis, $id_anggota, $periode);
                                if (!$QrySesiPinjaman->execute()) {
                                    $error=$Conn->error;
                                    echo '<td>'.$error.'</td>';
                                    $jumlah_total_potongan_angsuran=$jumlah_total_potongan_angsuran+0;
                                }else{
                                    $ResultSesiPinjaman = $QrySesiPinjaman->get_result();
                                    $DataSesiPinjaman = $ResultSesiPinjaman->fetch_assoc();
                                    $QrySesiPinjaman->close();

                                    //Buat Variabel Pinjaman
                                    if(empty($DataSesiPinjaman['angsuran_total'])){
                                        $angsuran_total=0;
                                    }else{
                                        $angsuran_total=$DataSesiPinjaman['angsuran_total'];
                                    }
                                    $jumlah_total_potongan_angsuran=$jumlah_total_potongan_angsuran+$angsuran_total;
                                    $angsuran_total_rp = "Rp " . number_format($angsuran_total,0,',','.');
                                    echo '<td>'.$angsuran_total_rp.'</td>';
                                }
                            }
                            //Menghitung Jumlah Pembelian Anggota Yang Belum Lunas
                            $SumPenjualan = mysqli_fetch_array(mysqli_query($Conn, "SELECT SUM(total) AS total FROM transaksi_jual_beli WHERE id_anggota='$id_anggota' AND kategori='Penjualan' AND status='Kredit' AND tanggal<='$periode'"));
                            $JumlahNomiinalPenjualan = $SumPenjualan['total'];
                            $SumPenjualanRetur = mysqli_fetch_array(mysqli_query($Conn, "SELECT SUM(total) AS total FROM transaksi_jual_beli WHERE id_anggota='$id_anggota' AND kategori='Retur Penjualan' AND status='Kredit' AND tanggal<='$periode'"));
                            $JumlahNomiinalPenjualanRetur = $SumPenjualanRetur['total'];
                            //Hitung Jumlah
                            $jumlah_penjualan_anggota=$JumlahNomiinalPenjualan-$JumlahNomiinalPenjualanRetur;
                            $jumlah_penjualan_anggota_rp = "Rp " . number_format($jumlah_penjualan_anggota,0,',','.');

                            //Akumulasikan
                            $jumlah_total_potongan_anggota=$jumlah_penjualan_anggota+$jumlah_total_potongan_angsuran;
                            $jumlah_total_potongan_anggota_rp = "Rp " . number_format($jumlah_total_potongan_anggota,0,',','.');
                            echo '  <td>'.$jumlah_penjualan_anggota_rp.'</td>';
                            echo '  <td>'.$jumlah_total_potongan_anggota_rp.'</td>';
                            echo '</tr>';
                            $no++;
                        }
                    }
                    echo '</table>';
                }else{

                    // Tampilkan Data Dalam Mode Draft
                    echo '<table width="100%">';
                    $jml_data = mysqli_num_rows(mysqli_query($Conn, "SELECT id_anggota FROM anggota"));
                    if(empty($jml_data)){
                        echo '
                            <tr>
                                <td colspan="'.$colspan.'" class="text-center text-danger">
                                    Tidak Ada Data Anggota Yang Bisa Ditampilkan!
                                </td>
                            </tr>
                        ';
                    }else{
                        $no=1;
                        $query_anggota = mysqli_query($Conn, "SELECT*FROM anggota WHERE status='Aktif' ORDER BY nama ASC");
                        while ($data_anggota = mysqli_fetch_array($query_anggota)) {
                            $id_anggota= $data_anggota['id_anggota'];
                            $nama= $data_anggota['nama'];
                            $nip= $data_anggota['nip'];
                            $lembaga=$data_anggota['lembaga'];
                            $ranking=$data_anggota['ranking'];
                            echo '
                                <tr>
                                    <td colspan="5"><b>POTONGAN KOPERASI</b></td>
                                </tr>
                            ';
                            echo '
                                <tr>
                                    <td colspan="2"><b>Periode</b></td>
                                    <td colspan="3">'.$periode_format.'</td>
                                </tr>
                            ';
                            echo '
                                <tr>
                                    <td colspan="2"><b>No.Induk</b></td>
                                    <td colspan="3">'.$nip.'</td>
                                </tr>
                            ';
                            echo '
                                <tr>
                                    <td colspan="2"><b>Nama Anggota</b></td>
                                    <td colspan="3">'.$nama.'</td>
                                </tr>
                            ';
                            echo '
                                <tr>
                                    <td colspan="2"><b>Unit Kerja</b></td>
                                    <td colspan="3">'.$lembaga.'</td>
                                </tr>
                            ';
                            echo '
                                <tr>
                                    <td align="center"><b>No</b></td>
                                    <td align="center"><b>Uraian</b></td>
                                    <td align="center"><b>Potongan</b></td>
                                    <td align="center"><b>Sisa Angsuran</b></td>
                                    <td align="center"><b>Sisa Pelunasan</b></td>
                                </tr>
                            ';
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
                                            <td colspan="5">'.$error.'</td>
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
                                        <td align="center">'.$no.'</td>
                                        <td align="left">'.$nama_pinjaman.'</td>
                                        <td align="right">'.$potongan_rp.'</td>
                                        <td align="right">'.$periode_angsuran.'</td>
                                        <td align="right">'.$nominal_sisa_angsuran_rp.'</td>
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
                                                <td align="center">'.$no.'</td>
                                                <td align="left">Utang Belanja/Pembelian</td>
                                                <td align="right">'.$jumlah_penjualan_anggota_rp.'</td>
                                                <td align="right">-</td>
                                                <td align="right">'.$jumlah_penjualan_anggota_rp.'</td>
                                            </tr>
                            ';
                            $total_potongan=$total_potongan+$jumlah_penjualan_anggota;
                            $total_potongan_rp = "Rp " . number_format($total_potongan,0,',','.');

                            $total_sisa_angsuran=$total_sisa_angsuran+$jumlah_penjualan_anggota;
                            $total_sisa_angsuran_rp = "Rp " . number_format($total_sisa_angsuran,0,',','.');
                            echo '
                                            <tr>
                                                <td></td>
                                                <td><b>TOTAL</b></td>
                                                <td align="right"><b>'.$total_potongan_rp.'</b></td>
                                                <td align="right">-</td>
                                                <td align="right"><b>'.$total_sisa_angsuran_rp.'</b></td>
                                            </tr>
                            ';
                            echo '
                                <tr class="batas_data">
                                    <td colspan="5"></td>
                                </tr>
                            ';
                        }
                    }
                    echo '</table>';
                }
                echo '  </body>';
                echo '</html>';
            }
        }
    }
?>
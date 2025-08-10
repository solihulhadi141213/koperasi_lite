<?php
    //koneksi dan session
    include "../../_Config/Connection.php";
    include "../../_Config/GlobalFunction.php";
    include "../../_Config/Session.php";
    

    if(empty($SessionIdAkses)){
        echo '
            <tr>
                <td colspan="7" class="text-center text-danger">
                    Sesi Akses Sudah Berakhir! Silahkan Login Ulang
                </td>
            </tr>
        ';
    }else{
        $jml_data = mysqli_num_rows(mysqli_query($Conn, "SELECT id_simpanan FROM simpanan WHERE id_anggota='$SessionIdAkses' AND kategori='Simpanan Sukarela'"));
        if(empty($jml_data)){
            echo '
                <tr>
                    <td colspan="7" class="text-center text-danger">
                        Anda Belum Mempunyai Simpanan Sukarela
                    </td>
                </tr>
            ';
        }else{
            $no=1;
            $QrySimpanan = mysqli_query($Conn, "SELECT*FROM simpanan WHERE id_anggota='$SessionIdAkses' AND kategori='Simpanan Sukarela' ORDER BY tanggal_simpanan DESC");
            while ($DataSimpanan = mysqli_fetch_array($QrySimpanan)) {
                $id_simpanan= $DataSimpanan['id_simpanan'];
                $id_simpanan_jenis= $DataSimpanan['id_simpanan_jenis'];
                $uuid_simpanan= $DataSimpanan['uuid_simpanan'];
                $tanggal_bayar = $DataSimpanan['tanggal_bayar'];
                $metode_pembayaran = $DataSimpanan['metode_pembayaran'];
                $jumlah = $DataSimpanan['jumlah'];
                $jumlah_format = "Rp " . number_format($jumlah,0,',','.');
                $status_simpanan = $DataSimpanan['status'];

                //Buka Nama Jenis Simpanan
                $nama_simpanan=GetDetailData($Conn,'simpanan_jenis','id_simpanan_jenis',$id_simpanan_jenis,'nama_simpanan');

                //Inisiasi Status
                if($status_simpanan=="Pending"){
                    $label_status='<span class="badge badge-danger">Pending</span>';
                }else{
                    $label_status='<span class="badge badge-success">Lunas</span>';
                }
                echo '
                    <tr>
                        <td><small>'.$no.'</small></td>
                        <td><small>'.$tanggal_bayar.'</small></td>
                        <td><small>'.$nama_simpanan.'</small></td>
                        <td><small>'.$jumlah_format.'</small></td>
                        <td><small>'.$metode_pembayaran.'</small></td>
                        <td><small>'.$label_status.'</small></td>
                        <td>
                            <a href="index.php?Page=SimpananAnggota&Sub=DetailSimpananAnggota&uuid='.$uuid_simpanan.'" class="btn btn-md btn-info">
                                Detail
                            </a>
                        </td>
                    </tr>
                ';
                $no++;
            }
        }
    }
?>
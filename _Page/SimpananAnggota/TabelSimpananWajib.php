<?php
    //koneksi dan session
    include "../../_Config/Connection.php";
    include "../../_Config/GlobalFunction.php";
    

    if(empty($_POST['id_simpanan_jenis'])){
        echo '
            <tr>
                <td colspan="7" class="text-center text-danger">
                    Jenis Simpanan Wajib Tidak Ditentukan
                </td>
            </tr>
        ';
    }else{
        if(empty($_POST['id_anggota'])){
            echo '
                <tr>
                    <td colspan="7" class="text-center text-danger">
                        ID Anggota Tidak Ditentukan
                    </td>
                </tr>
            ';
        }else{
            if(empty($_POST['tahun'])){
                echo '
                    <tr>
                        <td colspan="7" class="text-center text-danger">
                            Periode Tahun Tidak Ditentukan
                        </td>
                    </tr>
                ';
            }else{
                $id_simpanan_jenis=$_POST['id_simpanan_jenis'];
                $id_anggota=$_POST['id_anggota'];
                $tahun=$_POST['tahun'];
                //Buka Data anggota
                $tanggal_masuk=GetDetailData($Conn,'anggota','id_anggota',$id_anggota,'tanggal_masuk');
                $bulan_masuk=date('F',strtotime($tanggal_masuk));
                $bulan_tahun_masuk=date('Y-m',strtotime($tanggal_masuk));
                $bulan_tahun_sekarang=date('Y-m');
                //Melakukan Looping Bulan
                for ($i = 1; $i <= 12; $i++) {
                    $bulan=sprintf("%02d", $i);
                    $periode="01-$bulan-$tahun";
                    $periode_ymd="$tahun-$bulan-01";
                    $nama_bulan=date('F',strtotime($periode));
                    $bulan_tahun=date('Y-m',strtotime($periode));

                    //Buka Data Simpanan
                    $QrySimpanan = $Conn->prepare("SELECT * FROM simpanan WHERE id_simpanan_jenis = ? AND id_anggota = ? AND tanggal_simpanan = ?");
                    // Bind parameter dan eksekusi
                    $QrySimpanan->bind_param("iss", $id_simpanan_jenis, $id_anggota, $periode_ymd);
                    if (!$QrySimpanan->execute()) {
                        die("Query execution failed: " . $QrySimpanan->error);
                    }

                    $ResultSimpanan = $QrySimpanan->get_result();
                    $DataSimpanan = $ResultSimpanan->fetch_assoc();
                    
                    if ($ResultSimpanan->num_rows > 0) {
                        $id_simpanan = $DataSimpanan['id_simpanan'];
                        $tanggal_bayar = $DataSimpanan['tanggal_bayar'];
                        $status_simpanan = $DataSimpanan['status'];
                        $uuid_simpanan = $DataSimpanan['uuid_simpanan'];
                        $jumlah = $DataSimpanan['jumlah'];
                        $metode_pembayaran = $DataSimpanan['metode_pembayaran'];
                        $jumlah_format = "Rp " . number_format($jumlah,0,',','.');
                    }else{
                        $id_simpanan ="";
                        $tanggal_bayar = "-";
                        $status_simpanan = "-";
                        $uuid_simpanan = "";
                        $jumlah = 0;
                        $metode_pembayaran = "-";
                        $jumlah_format = "Rp " . number_format($jumlah,0,',','.');
                    }
                    //Label Status Bayar
                    if($status_simpanan=="Pending"){
                        $label_status='<span class="badge badge-danger">Pending</span>';
                        $TombolOpsi='<a href="index.php?Page=SimpananAnggota&Sub=DetailSimpananAnggota&uuid='.$uuid_simpanan.'" class="btn btn-md btn-info">Detail</a>';
                    }else{
                        if($status_simpanan=="Lunas"){
                            $label_status='<span class="badge badge-success">Lunas</span>';
                            $TombolOpsi='<a href="index.php?Page=SimpananAnggota&Sub=DetailSimpananAnggota&uuid='.$uuid_simpanan.'" class="btn btn-md btn-info">Detail</a>';
                        }else{
                            $label_status='<span class="badge badge-dark">None</span>';
                            $TombolOpsi='<button type="button" class="btn btn-md btn-primary" data-bs-toggle="modal" data-bs-target="#ModalBayarSimpananWajib" data-id_simpanan_jenis="'.$id_simpanan_jenis.'" data-id_anggota="'.$id_anggota.'" data-periode="'.$periode.'">Bayar</button>';
                        }
                    }
                    //Apabila Periode Bulan Tahun Sama Dengan Periode Masuk
                    if($bulan_tahun==$bulan_tahun_sekarang){
                        $warna_baris="text-white bg-warning";
                    }else{

                        //Apabila Periode Bulan Tahun Kurang Dari Periode Masuk
                        if($bulan_tahun<$bulan_tahun_masuk){
                            $warna_baris="text-white bg-dark";
                            $TombolOpsi='';
                        }else{
                            if($bulan_tahun>=$bulan_tahun_masuk&&$bulan_tahun<$bulan_tahun_sekarang&&$id_simpanan==""){
                                $warna_baris="text-dark bg-danger";
                                $TombolOpsi='<button type="button" class="btn btn-md btn-primary" data-bs-toggle="modal" data-bs-target="#ModalBayarSimpananWajib" data-id_simpanan_jenis="'.$id_simpanan_jenis.'" data-id_anggota="'.$id_anggota.'" data-periode="'.$periode.'">Bayar</button>';
                            }else{
                                $warna_baris="text-dark bg-white";
                            }
                        }
                    }
                    echo '
                        <tr>
                            <td class="'.$warna_baris.'"><small>'.$i.'</small></td>
                            <td class="'.$warna_baris.'"><small>'.$nama_bulan.'</small></td>
                            <td class="'.$warna_baris.'"><small>'.$tanggal_bayar.'</small></td>
                            <td class="'.$warna_baris.'"><small>'.$metode_pembayaran.'</small></td>
                            <td class="'.$warna_baris.'"><small>'.$jumlah_format.'</small></td>
                            <td class="'.$warna_baris.'"><small>'.$label_status.'</small></td>
                            <td class="'.$warna_baris.'">'.$TombolOpsi.'</td>
                        </tr>
                    ';
                }
            }
        }
    }

?>
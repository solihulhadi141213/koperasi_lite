<?php
    //koneksi dan session
    include "../../_Config/Connection.php";
    include "../../_Config/GlobalFunction.php";
    include "../../_Config/Session.php";

    //Jumlah Data Pinjaman Anggota
    $jumlah_pinjaman=mysqli_num_rows(mysqli_query($Conn, "SELECT id_pinjaman FROM pinjaman WHERE id_anggota='$SessionIdAkses'"));
    if(empty($jumlah_pinjaman)){
        echo '
            <tr>
                <td colspan="6" class="text-center">
                    <small>Anda Tidak Memiliki Pengajuan Pinjaman</small>
                </td>
            </tr>
        ';
    }else{
        $no=1;
        $query = mysqli_query($Conn, "SELECT*FROM pinjaman WHERE id_anggota='$SessionIdAkses' ORDER BY id_pinjaman DESC");
        while ($data = mysqli_fetch_array($query)) {
            $id_pinjaman= $data['id_pinjaman'];
            $id_pinjaman_jenis= $data['id_pinjaman_jenis'];
            $tanggal= $data['tanggal'];
            $jumlah_pinjaman= $data['jumlah_pinjaman'];
            $status= $data['status'];

            //Format Rupiah
            $jumlah_pinjaman_format = "" . number_format($jumlah_pinjaman,0,',',',');

            //Buka Data Jenis Pinjaman
            $nama_pinjaman=GetDetailData($Conn,'pinjaman_jenis','id_pinjaman_jenis',$id_pinjaman_jenis,'nama_pinjaman');
            $persen_jasa=GetDetailData($Conn,'pinjaman_jenis','id_pinjaman_jenis',$id_pinjaman_jenis,'persen_jasa');

            //Label Status
            if($status=="Pending"){
                $label_status='<span class="badge badge-warning">Pending</span>';
            }else{
                if($status=="Berjalan"){
                    $label_status='<span class="badge badge-info">Berjalan</span>';
                }else{
                    if($status=="Lunas"){
                        $label_status='<span class="badge badge-success">Lunas</span>';
                    }else{
                        if($status=="Macet"){
                            $label_status='<span class="badge badge-danger">Macet</span>';
                        }else{
                            if($status=="Ditolak"){
                                $label_status='<span class="badge badge-danger">Ditolak</span>';
                            }else{
                                $label_status='<span class="badge badge-primary">'.$status.'</span>';
                            }
                        }
                    }
                }
            }

            //Tampilkan Data
            echo '
                <tr>
                    <td><small>'.$no.'</small></td>
                    <td><small>'.$nama_pinjaman.'</small></td>
                    <td><small>'.$tanggal.'</small></td>
                    <td><small>'.$jumlah_pinjaman_format.'</small></td>
                    <td><small>'.$label_status.'</small></td>
                    <td>
                        <a href="javascript:void(0);" class="btn btn-sm btn-rounded btn-outline-dark" data-bs-toggle="modal" data-bs-target="#ModalDetailPinjaman" data-id="'.$id_pinjaman.'">
                            Detail
                        </a>
                    </td>
                </tr>
            ';
            $no++;
        }
    }
?>
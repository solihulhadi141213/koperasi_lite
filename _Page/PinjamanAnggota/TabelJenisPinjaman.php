<?php
    //koneksi dan session
    include "../../_Config/Connection.php";
    include "../../_Config/GlobalFunction.php";
    include "../../_Config/Session.php";

    //Jumlah Jenis Pinjaman
    $jumlah_jenis_pinjaman=mysqli_num_rows(mysqli_query($Conn, "SELECT id_pinjaman_jenis FROM pinjaman_jenis"));
    if(empty($jumlah_jenis_pinjaman)){
        echo '
            <tr>
                <td class="text-center" colspan="3">
                    <small>Belum Ada Data Jenis Pinjaman</small>
                </td>
            </tr>
        ';
    }else{
        $no=1;
        $query = mysqli_query($Conn, "SELECT*FROM pinjaman_jenis ORDER BY nama_pinjaman ASC");
        while ($data = mysqli_fetch_array($query)) {
            $id_pinjaman_jenis= $data['id_pinjaman_jenis'];
            $nama_pinjaman= $data['nama_pinjaman'];
            $periode_angsuran= $data['periode_angsuran'];
            $persen_jasa= $data['persen_jasa'];

            //Tampilkan Data
            echo '
                <tr>
                    <td><small>'.$no.'</small></td>
                    <td>
                        <small>'.$nama_pinjaman.'</small><br>
                        <small>
                            <code class="text text-grayish">
                                '.$periode_angsuran.' Bulan / '.$persen_jasa.' %
                            </code>
                        </small>
                    </td>
                    <td class="text-end">
                        <a href="javascript:void(0);" class="btn btn-sm btn-rounded btn-info" data-bs-toggle="modal" data-bs-target="#ModalTambahPinjaman" data-id="'.$id_pinjaman_jenis.'">
                            <i class="bi bi-check-circle"></i> Pilih
                        </a>
                    </td>
                </tr>
            ';
            $no++;
        }
    }
?>
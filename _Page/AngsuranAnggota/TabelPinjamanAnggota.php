<?php
    //koneksi dan session
    include "../../_Config/Connection.php";
    include "../../_Config/GlobalFunction.php";
    date_default_timezone_set("Asia/Jakarta");

    //Keyword_by
    if(empty($_POST['id_pinjaman'])){
        echo '
            <tr>
                <td colspan="10" class="text-center">
                    <small class="text-danger">ID Pinjaman Tidak Boleh Kosong!</small>
                </td>
            </tr>
        ';
    }else{
        //Buat Variabel
        $id_pinjaman=$_POST['id_pinjaman'];

        //Hitung Data
        $jml_data = mysqli_num_rows(mysqli_query($Conn, "SELECT id_pinjaman_angsuran FROM pinjaman_angsuran WHERE id_pinjaman='$id_pinjaman'"));
        if(empty($jml_data)){
            echo '
                <tr>
                    <td colspan="10" class="text-center">
                        <small class="text-danger">ID Pinjaman Tidak Boleh Kosong!</small>
                    </td>
                </tr>
            ';
        }else{
            $no = 1;
            $query = mysqli_query($Conn, "SELECT*FROM pinjaman_angsuran WHERE id_pinjaman='$id_pinjaman' ORDER BY id_pinjaman_angsuran ASC");
            while ($data = mysqli_fetch_array($query)) {
                $id_pinjaman_angsuran= $data['id_pinjaman_angsuran'];
                $id_pinjaman= $data['id_pinjaman'];
                $kode_pembayaran= $data['kode_pembayaran'];
                $tanggal_angsuran= $data['tanggal_angsuran'];
                $tanggal_bayar= $data['tanggal_bayar'];
                $keterlambatan= $data['keterlambatan'];
                $pokok= $data['pokok'];
                $jasa= $data['jasa'];
                $denda= $data['denda'];
                $jumlah= $data['jumlah'];
                $status= $data['status'];

                //Angsuran Pokok
                $pokok_format = "Rp " . number_format($pokok,0,',','.');

                //Nominal Denda
                $denda_format = "Rp " . number_format($denda,0,',','.');

                //Nominal Jasa
                $jasa_format = "Rp " . number_format($jasa,0,',','.');
                
                //Format Tanggal
                $TanggalAngsuranFormat=date('d/m/Y', strtotime($tanggal_angsuran));
                $PeriodeAngsuran=date('m/Y', strtotime($tanggal_angsuran));

                if($status=="None"){
                    $TanggalBayarFormat="-";
                }else{
                    $TanggalBayarFormat=date('d/m/Y', strtotime($tanggal_bayar));
                }
                
                //Nominal Angsuran
                $jumlah_format = "Rp " . number_format($jumlah,0,',','.');

                //Routing Status
                if($status=="None"){
                    $status_label='<span class="badge badge-dark">None</span>';
                    $tombol_opsi='<button type="button" class="btn btn-sm btn-rounded btn-outline-warning" data-bs-toggle="modal" data-bs-target="#ModalBayarAngsuran" data-id="'.$id_pinjaman_angsuran.'">Bayar</span>';
                }else{
                    if($status=="Pending"){
                        $status_label='<span class="badge badge-warning">Pending</span>';
                        $tombol_opsi='<button type="button" class="btn btn-sm btn-rounded btn-outline-info show_detail_pembayaran" data-id="'.$kode_pembayaran.'">Detail</span>';
                    }else{
                        if($status=="Lunas"){
                            $status_label='<span class="badge badge-success">Lunas</span>';
                            $tombol_opsi='<button type="button" class="btn btn-sm btn-rounded btn-outline-info show_detail_pembayaran" data-id="'.$kode_pembayaran.'">Detail</span>';
                        }else{
                            $status_label='<span class="badge badge-dark">None</span>';
                            $tombol_opsi='<button type="button" class="btn btn-sm btn-rounded btn-outline-warning" data-bs-toggle="modal" data-bs-target="#ModalBayarAngsuran" data-id="'.$id_pinjaman_angsuran.'">Bayar</span>';
                        }
                    }
                }

                //Routing bg
                if($PeriodeAngsuran==date('m/Y')){
                    $bg='table-active';
                }else{
                    $bg='';
                }

                //Menghitung Hari Keterlambatan
                // Buat objek DateTime
                $date1 = new DateTime($tanggal_angsuran);
                $date2 = new DateTime($tanggal_bayar);

                // Hitung selisih
                $diff = $date1->diff($date2);

                // Ambil jumlah hari
                $hari_keterlambatan = $diff->days;

                // Jika tanggal bayar lebih awal atau sama dengan angsuran, anggap tidak telat
                if ($date2 <= $date1) {
                    $hari_keterlambatan = 0;
                }
                //Tampilkan Data
                echo '
                    <tr class="'.$bg.'">
                        <td><small>'.$no.'</small></td>
                        <td><small>'.$TanggalAngsuranFormat.'</small></td>
                        <td><small>'.$TanggalBayarFormat.'</small></td>
                        <td><small>'.$hari_keterlambatan.' Hari</small></td>
                        <td><small>'.$pokok_format.'</small></td>
                        <td><small>'.$jasa_format.'</small></td>
                        <td><small>'.$denda_format.'</small></td>
                        <td><small>'.$jumlah_format.'</small></td>
                        <td><small>'.$status_label.'</small></td>
                        <td><small>'.$tombol_opsi.'</small></td>
                    </tr>
                ';
                $no++;
            }
        }
    }
?>
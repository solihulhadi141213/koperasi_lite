<?php
    //koneksi dan session
    include "../../_Config/Connection.php";
    include "../../_Config/GlobalFunction.php";
    include "../../_Config/SettingGeneral.php";
    date_default_timezone_set("Asia/Jakarta");

    //Variabel kosong agar tidak error
    $periode_1_format="";
    $periode_2_format="";
    //Keyword_by
    if(empty($_POST['periode_1'])){
        echo '
            <tr>
                <td colspan="7" class="text-center">
                    <small class="text-danger">
                        Periode Awal Tidak Boleh Kosong!
                    </small>
                </td>
            </tr>
        ';
    }else{
        if(empty($_POST['periode_2'])){
            echo '
                <tr>
                    <td colspan="7" class="text-center">
                        <small class="text-danger">
                            Periode Akhir Tidak Boleh Kosong!
                        </small>
                    </td>
                </tr>
            ';
        }else{
            //Buat Variabel
            $periode_1=$_POST['periode_1'];
            $periode_2=$_POST['periode_2'];

            // Format Periode Awal Dan Periode Akhir
            $periode_1_format = date('d/m/Y', strtotime($_POST['periode_1']));
            $periode_2_format = date('d/m/Y', strtotime($_POST['periode_2']));

            //Hitung Data
            $query = "SELECT * FROM pinjaman_angsuran 
                    WHERE tanggal_angsuran >= '$periode_1' 
                    AND tanggal_angsuran <= '$periode_2'";
            $jml_data = mysqli_num_rows(mysqli_query($Conn, $query));

            //Apabila Ada atau Tidak
            if(empty($jml_data)){
                echo '
                    <tr>
                        <td colspan="7" class="text-center">
                            <small class="text-danger">
                                Data Pinjaman Tidak Ditemukan!
                            </small>
                        </td>
                    </tr>
                ';
            }else{
                $no = 1;
                //Tampilkan Data
                $query = mysqli_query($Conn, "SELECT*FROM pinjaman_angsuran WHERE tanggal_angsuran >= '$periode_1' AND tanggal_angsuran <= '$periode_2' ORDER BY tanggal_angsuran ASC");
                while ($data = mysqli_fetch_array($query)) {
                    $id_pinjaman_angsuran= $data['id_pinjaman_angsuran'];
                    $id_anggota= $data['id_anggota'];
                    $tanggal_angsuran= $data['tanggal_angsuran'];
                    $tanggal_bayar= $data['tanggal_bayar'];
                    $keterlambatan= $data['keterlambatan'];
                    $pokok= $data['pokok'];
                    $jasa= $data['jasa'];
                    $denda= $data['denda'];
                    $jumlah= $data['jumlah'];
                    //Format tanggal
                    $tanggal_angsuran_format=date('d/m/Y',strtotime($tanggal_angsuran));
                    $tanggal_bayar_format=date('d/m/Y',strtotime($tanggal_bayar));
                    
                    //Format Rupiah
                    $keterlambatan_format = "Rp " . number_format($keterlambatan,0,',','.');
                    $pokok_format = "Rp " . number_format($pokok,0,',','.');
                    $jasa_format = "Rp " . number_format($jasa,0,',','.');
                    $denda_format = "Rp " . number_format($denda,0,',','.');
                    $jumlah_format = "Rp " . number_format($jumlah,0,',','.');

                    //Buka Data Anggota
                    $nip=GetDetailData($Conn,'anggota','id_anggota',$id_anggota,'nip');
                    $nama=GetDetailData($Conn,'anggota','id_anggota',$id_anggota,'nama');
                    echo '
                        <tr>
                            <td align="center">'.$no.'</td>
                            <td align="left">'.$tanggal_angsuran_format.'</td>
                            <td align="left">'.$tanggal_bayar_format.'</td>
                            <td align="left">'.$nama.'</td>
                            <td align="left">'.$nip.'</td>
                            <td align="left">'.$pokok_format.'</td>
                            <td align="left">'.$jasa_format.'</td>
                            <td align="left">'.$denda_format.'</td>
                            <td align="left">'.$jumlah_format.'</td>
                        </tr>
                    ';
                    $no++;
                }
            }
        }
    }
?>
<script>
    $('#periode_data_laporan_angsuran').html('<?php echo " $periode_1_format S/D  $periode_2_format"; ?>');
</script>
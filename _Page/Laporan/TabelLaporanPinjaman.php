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
            $query = "SELECT * FROM pinjaman 
                    WHERE tanggal >= '$periode_1' 
                    AND tanggal <= '$periode_2'";
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
                $query = mysqli_query($Conn, "SELECT*FROM pinjaman WHERE tanggal >= '$periode_1' AND tanggal <= '$periode_2' ORDER BY tanggal ASC");
                while ($data = mysqli_fetch_array($query)) {
                    $id_pinjaman= $data['id_pinjaman'];
                    $id_anggota= $data['id_anggota'];
                    $nip= $data['nip'];
                    $nama= $data['nama'];
                    $tanggal= $data['tanggal'];
                    $jumlah_pinjaman= $data['jumlah_pinjaman'];
                    $status= $data['status'];

                    //Format Rupiah
                    $jumlah_pinjaman_format = "" . number_format($jumlah_pinjaman,0,',','.');

                    //Format tanggal
                    $strtotime=strtotime($tanggal);
                    $TanggalFormat=date('d/m/Y',$strtotime);

                    //Hitung angsuran masuk
                    $angsuran_masuk=0;
                    $angsuran_masuk_format = "" . number_format($angsuran_masuk,0,',','.');
                    echo '
                        <tr>
                            <td align="center">'.$no.'</td>
                            <td align="left">'.$TanggalFormat.'</td>
                            <td align="left">'.$nama.'</td>
                            <td align="left">'.$nip.'</td>
                            <td align="left">'.$jumlah_pinjaman_format.'</td>
                            <td align="left">'.$angsuran_masuk_format.'</td>
                            <td align="left">'.$status.'</td>
                        </tr>
                    ';
                    $no++;
                }
            }
        }
    }
?>
<script>
    $('#periode_data_laporan_pinjaman').html('<?php echo " $periode_1_format S/D  $periode_2_format"; ?>');
</script>
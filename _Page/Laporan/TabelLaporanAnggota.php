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
            $query = "SELECT * FROM anggota 
                    WHERE tanggal_masuk >= '$periode_1' 
                    AND tanggal_masuk <= '$periode_2'";
            $jml_data = mysqli_num_rows(mysqli_query($Conn, $query));

            //Apabila Ada atau Tidak
            if(empty($jml_data)){
                echo '
                    <tr>
                        <td colspan="7" class="text-center">
                            <small class="text-danger">
                                Data Anggota Tidak Ditemukan!
                            </small>
                        </td>
                    </tr>
                ';
            }else{
                $no = 1;
                //Tampilkan Data
                $query = mysqli_query($Conn, "SELECT*FROM anggota WHERE tanggal_masuk >= '$periode_1' AND tanggal_masuk <= '$periode_2' ORDER BY tanggal_masuk ASC");
                while ($data = mysqli_fetch_array($query)) {
                    $id_anggota= $data['id_anggota'];
                    $tanggal_masuk= $data['tanggal_masuk'];
                    $tanggal_keluar= $data['tanggal_keluar'];
                    $nip= $data['nip'];
                    $nama= $data['nama'];
                    $email= $data['email'];
                    $kontak= $data['kontak'];
                    $status= $data['status'];

                    //Format Tanggal
                    $TanggalMasuk=date('d/m/Y', strtotime($tanggal_masuk));

                    echo '
                        <tr>
                            <td align="center">'.$no.'</td>
                            <td align="left">'.$TanggalMasuk.'</td>
                            <td align="left">'.$nama.'</td>
                            <td align="left">'.$nip.'</td>
                            <td align="left">'.$email.'</td>
                            <td align="left">'.$kontak.'</td>
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
    $('#periode_data_laporan_anggota').html('<?php echo " $periode_1_format S/D  $periode_2_format"; ?>');
</script>
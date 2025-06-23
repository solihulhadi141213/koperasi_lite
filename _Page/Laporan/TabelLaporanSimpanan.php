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
            $query = "SELECT * FROM simpanan 
                    WHERE tanggal >= '$periode_1' 
                    AND tanggal <= '$periode_2'";
            $jml_data = mysqli_num_rows(mysqli_query($Conn, $query));

            //Apabila Ada atau Tidak
            if(empty($jml_data)){
                echo '
                    <tr>
                        <td colspan="7" class="text-center">
                            <small class="text-danger">
                                Data Simpanan Tidak Ditemukan!
                            </small>
                        </td>
                    </tr>
                ';
            }else{
                $no = 1;
                //Tampilkan Data
                $query = mysqli_query($Conn, "SELECT*FROM simpanan WHERE tanggal >= '$periode_1' AND tanggal <= '$periode_2' ORDER BY tanggal ASC");
                while ($data = mysqli_fetch_array($query)) {
                    $id_simpanan= $data['id_simpanan'];
                    $uuid_simpanan= $data['uuid_simpanan'];
                    $id_anggota= $data['id_anggota'];
                    $id_akses= $data['id_akses'];
                    $id_simpanan_jenis= $data['id_simpanan_jenis'];
                    $rutin= $data['rutin'];
                    $nip= $data['nip'];
                    $nama= $data['nama'];
                    $tanggal= $data['tanggal'];
                    $kategori= $data['kategori'];
                    $jumlah= $data['jumlah'];

                    //Format Rupiah
                    $jumlah_format = "" . number_format($jumlah,0,',','.');

                    //Routing Kategori
                    if($kategori=="Penarikan"){
                        $LabelKategori='Penarikan';
                        $jumlah_format_label='- '.$jumlah_format.'';
                    }else{
                        $LabelKategori='Simpanan';
                        $jumlah_format_label=''.$jumlah_format.'';
                    }
                    $nama_simpanan=GetDetailData($Conn,'simpanan_jenis','id_simpanan_jenis',$id_simpanan_jenis,'nama_simpanan');
                    
                    //Format tanggal
                    $strtotime=strtotime($tanggal);
                    $TanggalFormat=date('d/m/Y',$strtotime);
                    echo '
                        <tr>
                            <td align="center">'.$no.'</td>
                            <td align="left">'.$TanggalFormat.'</td>
                            <td align="left">'.$nama.'</td>
                            <td align="left">'.$nip.'</td>
                            <td align="left">'.$LabelKategori.'</td>
                            <td align="left">'.$nama_simpanan.'</td>
                            <td align="left">'.$jumlah_format_label.'</td>
                        </tr>
                    ';
                    $no++;
                }
            }
        }
    }
?>
<script>
    $('#periode_data_laporan_simpanan').html('<?php echo " $periode_1_format S/D  $periode_2_format"; ?>');
</script>
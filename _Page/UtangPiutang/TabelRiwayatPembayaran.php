<?php
    //koneksi dan session
    include "../../_Config/Connection.php";
    include "../../_Config/GlobalFunction.php";
    include "../../_Config/Session.php";
    //inisiasi Variabe;
    $JmlHalaman=0;
    $page=1;
    if(empty($SessionIdAkses)){
        echo '
            <tr>
                <td colspan="7" class="text-center text-danger">
                    Sesi Akses Sudah Berakhir! Silahkan Login Ulang
                </td>
            </tr>
        ';
    }else{
        //Keyword_by
        if(!empty($_POST['keyword_by'])){
            $keyword_by=$_POST['keyword_by'];
        }else{
            $keyword_by="";
        }
        //keyword
        if(!empty($_POST['keyword'])){
            $keyword=$_POST['keyword'];
        }else{
            $keyword="";
        }
        //batas
        if(!empty($_POST['batas'])){
            $batas=$_POST['batas'];
        }else{
            $batas="10";
        }
        //ShortBy
        if(!empty($_POST['ShortBy'])){
            $ShortBy=$_POST['ShortBy'];
        }else{
            $ShortBy="DESC";
        }
        //OrderBy
        if(!empty($_POST['OrderBy'])){
            $OrderBy=$_POST['OrderBy'];
        }else{
            $OrderBy="tanggal";
        }
        //Atur Page
        if(!empty($_POST['page'])){
            $page=$_POST['page'];
            $posisi = ( $page - 1 ) * $batas;
        }else{
            $page="1";
            $posisi = 0;
        }
        if(empty($keyword_by)){
            if(empty($keyword)){
                $jml_data = mysqli_num_rows(mysqli_query($Conn, "SELECT id_transaksi_pembayaran FROM transaksi_pembayaran"));
            }else{
                $jml_data = mysqli_num_rows(mysqli_query($Conn, "SELECT id_transaksi_pembayaran FROM transaksi_pembayaran WHERE tanggal like '%$keyword%' OR kategori like '%$keyword%'"));
            }
        }else{
            if(empty($keyword)){
                $jml_data = mysqli_num_rows(mysqli_query($Conn, "SELECT id_transaksi_pembayaran FROM transaksi_pembayaran"));
            }else{
                $jml_data = mysqli_num_rows(mysqli_query($Conn, "SELECT id_transaksi_pembayaran FROM transaksi_pembayaran WHERE $keyword_by like '%$keyword%'"));
            }
        }
        if(empty($jml_data)){
            echo '
                <tr>
                    <td colspan="7" class="text-center text-danger">
                        Tidak Ada Data Yang Ditampilkan.
                    </td>
                </tr>
            ';
        }else{
            $no = 1+$posisi;
            //KONDISI PENGATURAN MASING FILTER
            if(empty($keyword_by)){
                if(empty($keyword)){
                    $query = mysqli_query($Conn, "SELECT*FROM transaksi_pembayaran ORDER BY $OrderBy $ShortBy LIMIT $posisi, $batas");
                }else{
                    $query = mysqli_query($Conn, "SELECT*FROM transaksi_pembayaran WHERE tanggal like '%$keyword%' OR kategori like '%$keyword%' ORDER BY $OrderBy $ShortBy LIMIT $posisi, $batas");
                }
            }else{
                if(empty($keyword)){
                    $query = mysqli_query($Conn, "SELECT*FROM transaksi_pembayaran ORDER BY $OrderBy $ShortBy LIMIT $posisi, $batas");
                }else{
                    $query = mysqli_query($Conn, "SELECT*FROM transaksi_pembayaran WHERE $keyword_by LIKE '%$keyword%' ORDER BY $OrderBy $ShortBy LIMIT $posisi, $batas");
                }
            }
            while ($data = mysqli_fetch_array($query)) {
                $id_transaksi_pembayaran= $data['id_transaksi_pembayaran'];
                $id_transaksi_jual_beli= $data['id_transaksi_jual_beli'];
                $kategori= $data['kategori'];
                $tanggal= $data['tanggal'];
                $jumlah= $data['jumlah'];
                $jumlah_rp = "Rp " . number_format($jumlah,0,',','.');

                //Format Tanggal
                $tanggal_format=date('d/m/Y H:i', strtotime($tanggal));

                //Buka Data Transaksi dari tabel 'transaksi_jual_beli' Dengan Prepared Statment
                $QryTransaksi = $Conn->prepare("SELECT * FROM transaksi_jual_beli WHERE id_transaksi_jual_beli = ?");
                $QryTransaksi->bind_param("s", $id_transaksi_jual_beli);
                
                if (!$QryTransaksi->execute()) {
                    $tanggal_transaksi_format='<i class="text-danger">Error</span>';
                    $nama_anggota='<i class="text-danger">Error</span>';
                } else {
                    $Result = $QryTransaksi->get_result();
                    $DataTransaksi = $Result->fetch_assoc();
                    $QryTransaksi->close();

                    if (!$DataTransaksi) {
                        $tanggal_transaksi_format='<i class="text-danger">None</span>';
                        $nama_anggota='<i class="text-danger">None</span>';
                    } else {
                        // Ambil Data Transaksi
                        $id_anggota = $DataTransaksi['id_anggota'];
                        $tanggal_transaksi = $DataTransaksi['tanggal'];
                        $tanggal_transaksi_format=date('d/m/Y H:i', strtotime($tanggal_transaksi));
                    }
                }
                //Buka Data Anggota
                if(empty($id_anggota)){
                    $nama_anggota='<i class="text-danger">None</i>';
                }else{
                    //Buka nama anggota dari tabel 'anggota'
                    $nama_anggota=GetDetailData($Conn, 'anggota', 'id_anggota', $id_anggota, 'nama');
                    $nama_anggota='<i class="text-success">'.$nama_anggota.'</i>';
                }
                
                //Tampilkan Data
                echo '
                    <tr>
                        <td><small>'.$no.'</small></td>
                        <td>
                            <a href="javascript:void(0);" class="text text-decoration-underline" data-bs-toggle="modal" data-bs-target="#ModalDetailPenjualan" data-id="'.$id_transaksi_jual_beli.'">
                                <small>'.$tanggal_transaksi_format.'</small>
                            </a>
                        </td>
                        <td>
                            <a href="javascript:void(0);" class="text text-decoration-underline" data-bs-toggle="modal" data-bs-target="#ModalDetailPembayaran" data-id="'.$id_transaksi_pembayaran.'">
                                <small>'.$tanggal_format.'</small>
                            </a>
                        </td>
                        <td><small>'.$kategori.'</small></td>
                        <td>
                            <a href="javascript:void(0);" class="text text-success text-decoration-underline" data-bs-toggle="modal" data-bs-target="#ModalDetailAnggota" data-id="'.$id_anggota.'">
                                <small>'.$nama_anggota.'</small>
                            </a>
                        </td>
                        <td><small>'.$jumlah_rp.'</small></td>
                        <td>
                            <button type="button" class="btn btn-sm btn-floating btn-outline-secondary" data-bs-toggle="dropdown" aria-expanded="false">
                                <i class="bi bi-three-dots"></i>
                            </button>
                            <ul class="dropdown-menu dropdown-menu-end dropdown-menu-arrow" style="">
                                <li class="dropdown-header text-start">
                                    <h6>Option</h6>
                                </li>
                                <li>
                                    <a class="dropdown-item" href="javascript:void(0)" data-bs-toggle="modal" data-bs-target="#ModalDetailPembayaran" data-id="'.$id_transaksi_pembayaran.'">
                                        <i class="bi bi-info-circle"></i> Detail Pembayaran
                                    </a>
                                </li>
                                <li>
                                    <a class="dropdown-item" href="javascript:void(0)" data-bs-toggle="modal" data-bs-target="#ModalEditPembayaran" data-id="'.$id_transaksi_pembayaran.'">
                                        <i class="bi bi-pencil"></i> Edit Pembayaran
                                    </a>
                                </li>
                                <li>
                                    <a class="dropdown-item" href="javascript:void(0)" data-bs-toggle="modal" data-bs-target="#ModalHapusPembayaran" data-id="'.$id_transaksi_pembayaran.'">
                                        <i class="bi bi-trash"></i> Hapus Pembayaran
                                    </a>
                                </li>
                            </ul>
                        </td>
                    </tr>
                ';
                $no++;
            }
            $JmlHalaman = ceil($jml_data/$batas); 
        }
    }
?>

<script>
    //Creat Javascript Variabel
    var page_count=<?php echo $JmlHalaman; ?>;
    var curent_page=<?php echo $page; ?>;
    
    //Put Into Pagging Element
    $('#page_info_riwayat').html('Page '+curent_page+' Of '+page_count+'');
    
    //Set Pagging Button
    if(curent_page==1){
        $('#prev_button_riwayat').prop('disabled', true);
    }else{
        $('#prev_button_riwayat').prop('disabled', false);
    }
    if(page_count<=curent_page){
        $('#next_button_riwayat').prop('disabled', true);
    }else{
        $('#next_button_riwayat').prop('disabled', false);
    }
</script>

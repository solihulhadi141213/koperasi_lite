<?php
    include "../../_Config/Connection.php";
    include "../../_Config/GlobalFunction.php";
    if(empty($_POST['id_barang'])){
        echo '
            <div class="alert alert-danger text-center">
                <small>
                    ID Barang Tidak Boleh Kosong!
                </small>
            </div>
        ';
    }else{
        $id_barang=$_POST['id_barang'];
        $JumlahSatuanMulti = mysqli_num_rows(mysqli_query($Conn, "SELECT id_barang_satuan FROM barang_satuan WHERE id_barang='$id_barang'"));
        if(empty($JumlahSatuanMulti)){
            echo '
                <div class="alert alert-warning text-center">
                    <small>
                        Belum Ada Data Multi Satuan Pada Item Barang Ini.
                    </small>
                </div>
            ';
        }else{
            //Buka Data Barang
            $satuan_barang=GetDetailData($Conn, 'barang', 'id_barang', $id_barang, 'satuan_barang');
            $konversi=GetDetailData($Conn, 'barang', 'id_barang', $id_barang, 'konversi');
            $stok_barang=GetDetailData($Conn, 'barang', 'id_barang', $id_barang, 'stok_barang');

            //Tampilkan List Multi Satuan
            $QrySatuanMulti = mysqli_query($Conn, "SELECT * FROM barang_satuan WHERE id_barang='$id_barang' ORDER BY satuan_multi ASC");
            while ($DataSatuanMulti = mysqli_fetch_array($QrySatuanMulti)) {
                $id_barang_satuan= $DataSatuanMulti['id_barang_satuan'];
                $satuan_multi= $DataSatuanMulti['satuan_multi'];
                $konversi_multi= $DataSatuanMulti['konversi_multi'];
                $stok_multi=$konversi_multi*($konversi_multi/$konversi);
                echo '
                    <div class="row mb-2">
                        <div class="col-4"><small>'.$satuan_multi.'</small></div>
                        <div class="col-3">
                            <small>
                                <code class="text text-grayish">'.$konversi_multi.' '.$satuan_barang.'</code>
                            </small>
                        </div>
                        <div class="col-3">
                            <small>
                                <code class="text text-grayish">'.$stok_multi.' '.$satuan_barang.'</code>
                            </small>
                        </div>
                        <div class="col-2 text-center">
                            <a href="javascript:void(0);" class="text-grayish" data-bs-toggle="dropdown" aria-expanded="false">
                                <i class="bi bi-three-dots"></i>
                            </a>
                            <ul class="dropdown-menu dropdown-menu-end dropdown-menu-arrow" style="">
                                <li class="dropdown-header text-start">
                                    <h6>Option</h6>
                                </li>
                                <li>
                                    <a class="dropdown-item" href="javascript:void(0)" data-bs-toggle="modal" data-bs-target="#ModalEditSatuan" data-id="'.$id_barang_satuan.'" data-name="'.$satuan_multi.'" data-konversi="'.$konversi_multi.'">
                                        <i class="bi bi-pencil"></i> Edit
                                    </a>
                                </li>
                                <li>
                                    <a class="dropdown-item" href="javascript:void(0)" data-bs-toggle="modal" data-bs-target="#ModalHapusSatuanMulti" data-id="'.$id_barang_satuan.'" data-name="'.$satuan_multi.'" data-konversi="'.$konversi_multi.'">
                                        <i class="bi bi-trash"></i> Hapus
                                    </a>
                                </li>
                            </ul>
                        </div>
                    </div>
                ';
            }
        }
    }
    
?>
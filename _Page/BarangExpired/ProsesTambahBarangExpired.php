<?php
    //Koneksi
    include "../../_Config/Connection.php";
    include "../../_Config/GlobalFunction.php";
    include "../../_Config/Session.php";

    // Time Zone
    date_default_timezone_set('Asia/Jakarta');

    // Time Now Tmp
    $now = date('Y-m-d H:i:s');

    //Tangkap variabel
    if(empty($_POST['id_barang'])){
        echo '<span class="text-danger">ID Barang Tidak Boleh Kosong!</span>';
    }else{
        if(empty($_POST['no_batch'])){
            echo '<span class="text-danger">Nomor Batch Tidak Boleh Kosong!</span>';
        }else{
            if(empty($_POST['expired_date'])){
                echo '<span class="text-danger">Tanggal Expired Tidak Boleh Kosong!</span>';
            }else{
                if(empty($_POST['reminder_date'])){
                    echo '<span class="text-danger">Tanggal Pemberitahuan Tidak Boleh Kosong!</span>';
                }else{
                    if(empty($_POST['qty_batch'])){
                        echo '<span class="text-danger">Jumlah Tidak Boleh Kosong!</span>';
                    }else{
                        if(empty($_POST['status'])){
                            echo '<span class="text-danger">Status Tidak Boleh Kosong!</span>';
                        }else{
                            if(strlen($_POST['no_batch'])>20){
                                echo '<span class="text-danger">Nomor Batch Maksimal 20 Digit!</span>';
                            }else{
                                $id_barang=validateAndSanitizeInput($_POST['id_barang']);
                                $no_batch=validateAndSanitizeInput($_POST['no_batch']);
                                $expired_date=validateAndSanitizeInput($_POST['expired_date']);
                                $qty_batch=validateAndSanitizeInput($_POST['qty_batch']);
                                $reminder_date=validateAndSanitizeInput($_POST['reminder_date']);
                                $status=validateAndSanitizeInput($_POST['status']);
                                //Buka Konversi Barang
                                $konversi=GetDetailData($Conn, 'barang', 'id_barang', $id_barang, 'konversi');

                                if(empty($_POST['id_barang_satuan'])){
                                    $id_barang_satuan=0;
                                    $qty=$qty_batch;
                                }else{
                                    $id_barang_satuan=$_POST['id_barang_satuan'];
                                    //Buka satuan multi
                                    $QryBarang = mysqli_query($Conn,"SELECT * FROM barang_satuan WHERE id_barang_satuan='$id_barang_satuan'")or die(mysqli_error($Conn));
                                    $DataBarang = mysqli_fetch_array($QryBarang);
                                    $konversi_multi= $DataBarang['konversi_multi'];
                                    $qty=$qty_batch*($konversi_multi/$konversi);
                                }
                                //Validasi duplikasi data
                                $ValidasiDuplikat=mysqli_num_rows(mysqli_query($Conn, "SELECT*FROM barang_bacth WHERE no_batch='$no_batch'"));
                                if(!empty($ValidasiDuplikat)){
                                    echo '<span class="text-danger">Nomor Batch Yang Anda Gunakan Sudah Ada!</span>';
                                }else{
                                    //Simpan data
                                    $EnterExpiredDate="INSERT INTO barang_bacth (
                                        id_barang,
                                        no_batch,
                                        expired_date,
                                        qty_batch,
                                        reminder_date,
                                        status
                                    ) VALUES (
                                        '$id_barang',
                                        '$no_batch',
                                        '$expired_date',
                                        '$qty',
                                        '$reminder_date',
                                        '$status'
                                    )";
                                    $InputExpiredDate=mysqli_query($Conn, $EnterExpiredDate);
                                    if($InputExpiredDate){
                                        //Simpan LOG
                                        $kategori_log="Barang";
                                        $deskripsi_log="Tambah Barang Batch & Expired";
                                        $InputLog=addLog($Conn,$SessionIdAkses,$now,$kategori_log,$deskripsi_log);
                                        if($InputLog=="Success"){
                                            echo '<small class="text-success" id="NotifikasiTambahExpiredDateBerhasil">Success</small>';
                                        }else{
                                            echo '<span class="text-danger">Terjadi kesalahan pada saat menyimpan log!</span>';
                                        }
                                        
                                    }else{
                                        echo '<span class="text-danger">Terjadi kesalahan pada saat menyimpan data expired date!</span>';
                                    }
                                }
                            }
                        }
                    }
                }
            }
        }
    }
?>
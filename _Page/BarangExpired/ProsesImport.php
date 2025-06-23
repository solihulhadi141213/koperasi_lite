<?php
    require '../../vendor/autoload.php';
    use PhpOffice\PhpSpreadsheet\Spreadsheet;
    use PhpOffice\PhpSpreadsheet\Reader\Csv;
    use PhpOffice\PhpSpreadsheet\Reader\Xlsx;
    include "../../_Config/Connection.php";
    include "../../_Config/GlobalFunction.php";
    include "../../_Config/Session.php";
    //Time Zone
    date_default_timezone_set('Asia/Jakarta');
    //Time Now Tmp
    $now=date('Y-m-d H:i:s');
    //Validasi File
    if(empty($SessionIdAkses)){
        echo '<small class="text-danger">Sesi Akses Sudah Berakhir, Silahkan Login Ulang</small>';
    }else{
        if(empty($_FILES['file_excel']['name'])){
            echo '<code class="text-danger">File tidak boleh kosong</code>';
        }else{
            $nama_file=$_FILES['file_excel']['name'];
            $file_mimes = array('application/octet-stream', 'application/vnd.ms-excel', 'application/x-csv', 'text/x-csv', 'text/csv', 'application/csv', 'application/excel', 'application/vnd.msexcel', 'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
            if(isset($_FILES['file_excel']['name']) && in_array($_FILES['file_excel']['type'], $file_mimes)) {
                $arr_file = explode('.', $_FILES['file_excel']['name']);
                $extension = end($arr_file);
                if('csv' == $extension) {
                    $reader = new \PhpOffice\PhpSpreadsheet\Reader\Csv();
                } else {
                    $reader = new \PhpOffice\PhpSpreadsheet\Reader\Xlsx();
                }
                $spreadsheet = $reader->load($_FILES['file_excel']['tmp_name']);
                $sheetData = $spreadsheet->getActiveSheet()->toArray();
                $JumlahBaris=count($sheetData);
                $JumlahValidator=$JumlahBaris-1;
                if(empty($JumlahValidator)){
                    echo '<code class="text-danger">Tidak ada data pada file excel yang anda upload</code>';
                }else{
                    echo '<ol class="scroll_div">';
                    $JumlahKodeValid=0;
                    for($i=1; $i<$JumlahBaris; $i++){
                        if(empty($sheetData[$i]['1'])){
                            echo '<li class="text-danger">Baris ke '.$i.' Kode Barang tidak boleh kosong</li>';
                        }else{
                            if(empty($sheetData[$i]['2'])){
                                echo '<li class="text-danger">Baris ke '.$i.' : Nomor Batch tidak boleh kosong</li>';
                            }else{
                                if(empty($sheetData[$i]['3'])){
                                    echo '<li class="text-danger">Baris ke '.$i.' : Tanggal Expired tidak boleh kosong</li>';
                                }else{
                                    if(empty($sheetData[$i]['4'])){
                                        echo '<li class="text-danger">Baris ke '.$i.' : Reminder date tidak boleh kosong</li>';
                                    }else{
                                        if(empty($sheetData[$i]['5'])){
                                            echo '<li class="text-danger">Baris ke '.$i.' : QTY tidak boleh kosong</li>';
                                        }else{
                                            if(empty($sheetData[$i]['6'])){
                                                echo '<li class="text-danger">Baris ke '.$i.' : Status tidak boleh kosong</li>';
                                            }else{
                                                if(empty($sheetData[$i]['0'])){
                                                    $no ="";
                                                }else{
                                                    $no = $sheetData[$i]['0'];
                                                }
                                                $kode_barang = $sheetData[$i]['1'];
                                                $no_batch = $sheetData[$i]['2'];
                                                $expired_date = $sheetData[$i]['3'];
                                                $reminder_date = $sheetData[$i]['4'];
                                                $qty_batch = $sheetData[$i]['5'];
                                                $status = $sheetData[$i]['6'];
                                                
                                                //Bersihkan Variabel
                                                $kode_barang=validateAndSanitizeInput($kode_barang);
                                                $no_batch=validateAndSanitizeInput($no_batch);
                                                $expired_date=validateAndSanitizeInput($expired_date);
                                                $reminder_date=validateAndSanitizeInput($reminder_date);
                                                $qty_batch=validateAndSanitizeInput($qty_batch);
                                                $status=validateAndSanitizeInput($status);

                                                //Validasi Duplikasi
                                                $validasi_nomor_batch=mysqli_num_rows(mysqli_query($Conn, "SELECT*FROM barang_bacth WHERE no_batch='$no_batch'"));

                                                //Format Tanggal
                                                $strtotime1=strtotime($expired_date);
                                                $strtotime2=strtotime($reminder_date);
                                                //Buat Tanggal
                                                $expired_date=date('Y-m-d',$strtotime1);
                                                $reminder_date=date('Y-m-d',$strtotime2);

                                                //Validasi Jumlah Digit Nomor Batch
                                                if(strlen($no_batch)>20){
                                                    $ValidasiDigitBatch="Digit Batch Maksimal 20";
                                                }else{
                                                    $ValidasiDigitBatch="Valid";
                                                }
                                                
                                                //Buka id_barang
                                                $id_barang=GetDetailData($Conn,'barang','kode_barang',$kode_barang,'id_barang');

                                                //Validasi Jumlah Karakter
                                                if(empty($id_barang)){
                                                    echo '<li class="text-danger">Baris ke '.$i.' : Kode Barang  '.$kode_barang.' Tidak Valid</li>';
                                                }else{
                                                    if(!preg_match("/^[^a-zA-Z ]*$/", $qty_batch)){
                                                        echo '<li class="text-danger">Baris ke '.$i.' : QTY hanya boleh diisi angka</li>';
                                                    }else{
                                                        if(!empty($validasi_nomor_batch)){
                                                            echo '<li class="text-danger">Baris ke '.$i.' : Nomor Batch Sudah Ada Sebelumnya</li>';
                                                        }else{
                                                            if($ValidasiDigitBatch!=="Valid"){
                                                                echo '<li class="text-danger">Baris ke '.$i.' : '.$ValidasiDigitBatch.'</li>';
                                                            }else{
                                                                if($status!=="Terdaftar"&&$status!=="Terjual"){
                                                                    echo '<li class="text-danger">Baris ke '.$i.' : Status tidak valid</li>';
                                                                }else{
                                                                    //Simpan Data
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
                                                                        '$qty_batch',
                                                                        '$reminder_date',
                                                                        '$status'
                                                                    )";
                                                                    $InputExpiredDate=mysqli_query($Conn, $EnterExpiredDate);
                                                                    if($InputExpiredDate){
                                                                        $JumlahKodeValid=$JumlahKodeValid+1;
                                                                        echo '<li class="text-success">Baris ke '.$i.' : Data Valid</li>';
                                                                    }else{
                                                                        echo '<li class="text-danger">Baris ke '.$i.' : Terjadi kesalahan pada saat menyimpan data</li>';
                                                                    }
                                                                }
                                                            }
                                                        }
                                                    }
                                                }
                                            }
                                        }
                                    }
                                }
                            }
                        }
                    }
                    echo '</ol>';
                    if($JumlahKodeValid!==$JumlahValidator){
                        echo '<code class="text-danger">Data yang diimport ada yang tidak valid. Silahkan periksa dan perbaiki terlebih dulu</code>';
                    }else{
                        echo '<small class="text-success">Semua data yang diimport berhasil disimpan</small>';
                    }
                }
            }
        }
    }
?>
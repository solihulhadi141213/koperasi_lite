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
                            echo '<li class="text-danger">Baris ke '.$i.' NIP tidak boleh kosong</li>';
                        }else{
                            if(empty($sheetData[$i]['2'])){
                                echo '<li class="text-danger">Baris ke '.$i.' : Nama anggota tidak boleh kosong</li>';
                            }else{
                                if(empty($sheetData[$i]['6'])){
                                    echo '<li class="text-danger">Baris ke '.$i.' : Lembaga tidak boleh kosong</li>';
                                }else{
                                    if(empty($sheetData[$i]['7'])){
                                        echo '<li class="text-danger">Baris ke '.$i.' : Ranking tidak boleh kosong</li>';
                                    }else{
                                        if(empty($sheetData[$i]['8'])){
                                            echo '<li class="text-danger">Baris ke '.$i.' : Status tidak boleh kosong</li>';
                                        }else{
                                            if(empty($sheetData[$i]['9'])){
                                                echo '<li class="text-danger">Baris ke '.$i.' : Tanggal Masuk tidak boleh kosong</li>';
                                            }else{
                                                if(empty($sheetData[$i]['0'])){
                                                    $no ="";
                                                }else{
                                                    $no = $sheetData[$i]['0'];
                                                }
                                                $nip = $sheetData[$i]['1'];
                                                $nama = $sheetData[$i]['2'];
                                                $lembaga = $sheetData[$i]['6'];
                                                $ranking = $sheetData[$i]['7'];
                                                $status = $sheetData[$i]['8'];
                                                $tanggal_masuk = $sheetData[$i]['9'];
                                                if(empty($sheetData[$i]['3'])){
                                                    $email ="";
                                                    $ValidasiEmailDuplikat="";
                                                }else{
                                                    $email = $sheetData[$i]['3'];
                                                    $ValidasiEmailDuplikat=mysqli_num_rows(mysqli_query($Conn, "SELECT*FROM anggota WHERE email='$email'"));
                                                }
                                                if(empty($sheetData[$i]['4'])){
                                                    $password ="";
                                                    $akses_anggota=0;
                                                }else{
                                                    $password = $sheetData[$i]['4'];
                                                    $akses_anggota=1;
                                                }
                                                if(empty($sheetData[$i]['5'])){
                                                    $kontak =0;
                                                    $ValidasiKontakDuplikat=0;
                                                    $JumlahKarakterKontak=0;
                                                }else{
                                                    $kontak = $sheetData[$i]['5'];
                                                    $ValidasiKontakDuplikat=mysqli_num_rows(mysqli_query($Conn, "SELECT*FROM anggota WHERE kontak='$kontak'"));
                                                    $JumlahKarakterKontak=strlen($kontak);
                                                }
                                                if(empty($sheetData[$i]['10'])){
                                                    $tanggal_keluar =date('Y-m-d');
                                                }else{
                                                    $tanggal_keluar = $sheetData[$i]['10'];
                                                }
                                                $nip=validateAndSanitizeInput($nip);
                                                $nama=validateAndSanitizeInput($nama);
                                                $tanggal_masuk=validateAndSanitizeInput($tanggal_masuk);
                                                $tanggal_keluar=validateAndSanitizeInput($tanggal_keluar);
                                                $lembaga=validateAndSanitizeInput($lembaga);
                                                $ranking=validateAndSanitizeInput($ranking);
                                                $status=validateAndSanitizeInput($status);
                                                $kontak=validateAndSanitizeInput($kontak);
                                                $email=validateAndSanitizeInput($email);
                                                $password=validateAndSanitizeInput($password);
                                                //Format Tanggal
                                                $strtotime1=strtotime($tanggal_masuk);
                                                $strtotime2=strtotime($tanggal_keluar);
                                                //Buat Tanggal
                                                $tanggal_masuk=date('Y-m-d',$strtotime1);
                                                $tanggal_keluar=date('Y-m-d',$strtotime2);
                                                $JumlahKarakterNip=strlen($nip);
                                                $ValidasiNip=mysqli_num_rows(mysqli_query($Conn, "SELECT*FROM anggota WHERE nip='$nip'"));
                                                //Validasi Jumlah Karakter
                                                if($JumlahKarakterKontak>20){
                                                    echo '<li class="text-danger">Baris ke '.$i.' : Kontak Tidak boleh lebih dari 20 karakter</li>';
                                                }else{
                                                    if(!preg_match("/^[^a-zA-Z ]*$/", $kontak)){
                                                        echo '<li class="text-danger">Baris ke '.$i.' : Kontak hanya boleh diisi angka</li>';
                                                    }else{
                                                        if($JumlahKarakterNip>32){
                                                            echo '<li class="text-danger">Baris ke '.$i.' : NIP maksimal 32 karakter</li>';
                                                        }else{
                                                            if(!empty($ValidasiNip)){
                                                                echo '<li class="text-danger">Baris ke '.$i.' : NIP Tersebut Sudah Terdaftar</li>';
                                                            }else{
                                                                if(!empty($ValidasiEmailDuplikat)){
                                                                    echo '<li class="text-danger">Baris ke '.$i.' : Email Tersebut Sudah Terdaftar</li>';
                                                                }else{
                                                                    if(!empty($ValidasiKontakDuplikat)){
                                                                        echo '<li class="text-danger">Baris ke '.$i.' : Kontak Tersebut Sudah Terdaftar</li>';
                                                                    }else{
                                                                        //Simpan Data
                                                                        $EntryAnggota="INSERT INTO anggota (
                                                                            tanggal_masuk,
                                                                            tanggal_keluar,
                                                                            nip,
                                                                            nama,
                                                                            email,
                                                                            password,
                                                                            kontak,
                                                                            lembaga,
                                                                            ranking,
                                                                            foto,
                                                                            akses_anggota,
                                                                            status
                                                                        ) VALUES (
                                                                            '$tanggal_masuk',
                                                                            '$tanggal_keluar',
                                                                            '$nip',
                                                                            '$nama',
                                                                            '$email',
                                                                            '$password',
                                                                            '$kontak',
                                                                            '$lembaga',
                                                                            '$ranking',
                                                                            '',
                                                                            '$akses_anggota',
                                                                            '$status'
                                                                        )";
                                                                        $InputAnggota=mysqli_query($Conn, $EntryAnggota);
                                                                        if($InputAnggota){
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
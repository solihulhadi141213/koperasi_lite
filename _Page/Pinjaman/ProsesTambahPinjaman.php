<?php
    //Koneksi
    include "../../_Config/Connection.php";
    include "../../_Config/GlobalFunction.php";
    include "../../_Config/Session.php";
    //Menangkap data wilayah
    if(empty($_POST['id_anggota'])){
        echo '<code class="text-danger">ID Anggota Tidak Boleh Kosong!!</code>';
    }else{
        if(empty($_POST['tanggal'])){
            echo '<code class="text-danger">Tanggal Pinjaman Tidak Boleh Kosong!!</code>';
        }else{
            if(empty($_POST['jatuh_tempo'])){
                echo '<code class="text-danger">Tanggal Jatuh Tempo Tidak Boleh Kosong!!</code>';
            }else{
                if(empty($_POST['jumlah_pinjaman'])){
                    echo '<code class="text-danger">Jumlah Pinjaman Tidak Boleh Kosong!!</code>';
                }else{
                    if(empty($_POST['angsuran_pokok'])){
                        echo '<code class="text-danger">Nilai Angsuran Pokok Tidak Boleh Kosong!!</code>';
                    }else{
                        if(empty($_POST['periode_angsuran'])){
                            echo '<code class="text-danger">Periode Angsuran Tidak Boleh Kosong!!</code>';
                        }else{
                            $id_anggota=$_POST['id_anggota'];
                            $tanggal=$_POST['tanggal'];
                            $jatuh_tempo=$_POST['jatuh_tempo'];
                            $tanggal_input=date('Y-m-d H:i');
                            $jumlah_pinjaman=$_POST['jumlah_pinjaman'];
                            $angsuran_pokok=$_POST['angsuran_pokok'];
                            $periode_angsuran=$_POST['periode_angsuran'];


                            if(empty($_POST['persen_jasa'])){
                                $persen_jasa="0";
                            }else{
                                $persen_jasa=$_POST['persen_jasa'];
                            }
                            if(empty($_POST['rp_jasa'])){
                                $rp_jasa="0";
                            }else{
                                $rp_jasa=$_POST['rp_jasa'];
                            }
                            if(empty($_POST['angsuran_total'])){
                                $angsuran_total="0";
                            }else{
                                $angsuran_total=$_POST['angsuran_total'];
                            }
                            if(empty($_POST['denda'])){
                                $denda="0";
                            }else{
                                $denda=$_POST['denda'];
                            }
                            if(empty($_POST['sistem_denda'])){
                                $sistem_denda="Harian";
                            }else{
                                $sistem_denda=$_POST['sistem_denda'];
                            }

                            if(empty($_POST['id_pinjaman_jenis'])){
                                $id_pinjaman_jenis="";
                            }else{
                                $id_pinjaman_jenis=$_POST['id_pinjaman_jenis'];
                            }

                            $jumlah_pinjaman= str_replace(",", "", $jumlah_pinjaman);
                            $angsuran_pokok= str_replace(",", "", $angsuran_pokok);
                            $periode_angsuran= str_replace(",", "", $periode_angsuran);
                            $rp_jasa= str_replace(",", "", $rp_jasa);
                            $angsuran_total= str_replace(",", "", $angsuran_total);
                            $denda= str_replace(",", "", $denda);
                            if(!preg_match("/^[0-9]*$/", $jumlah_pinjaman)){
                                echo '<code class="text-danger">Jumlah Pinjaman Hanya Boleh Angka</code>'; 
                            }else{
                                if(!preg_match("/^[0-9]*$/", $angsuran_pokok)){
                                    echo '<code class="text-danger">Nilai Angsuran Hanya Boleh Angka</code>'; 
                                }else{
                                    if(!preg_match("/^[0-9]*$/", $periode_angsuran)){
                                        echo '<code class="text-danger">Periode Angsuran Hanya Boleh Angka</code>'; 
                                    }else{
                                        $pattern = '/^\d+(\.\d+)?$/';
                                        if(!preg_match($pattern, $persen_jasa)) {
                                            echo '<code class="text-danger">Persen Jasa Hanya Boleh Angka</code>'; 
                                        }else{
                                            if(!preg_match("/^[0-9]*$/", $rp_jasa)){
                                                echo '<code class="text-danger">Estimasi Jasa Hanya Boleh Angka</code>'; 
                                            }else{
                                                if(!preg_match("/^[0-9]*$/", $angsuran_total)){
                                                    echo '<code class="text-danger">Jumlah angsuran Hanya Boleh Angka</code>'; 
                                                }else{
                                                    if(!preg_match("/^[0-9]*$/", $denda)){
                                                        echo '<code class="text-danger">Nominal Denda Hanya Boleh Angka</code>'; 
                                                    }else{
                                                        //Bersihkan Variabel
                                                        $id_anggota=validateAndSanitizeInput($id_anggota);
                                                        $tanggal=validateAndSanitizeInput($tanggal);
                                                        $jatuh_tempo=validateAndSanitizeInput($jatuh_tempo);
                                                        $jumlah_pinjaman=validateAndSanitizeInput($jumlah_pinjaman);
                                                        $angsuran_pokok=validateAndSanitizeInput($angsuran_pokok);
                                                        $periode_angsuran=validateAndSanitizeInput($periode_angsuran);
                                                        $persen_jasa=validateAndSanitizeInput($persen_jasa);
                                                        $rp_jasa=validateAndSanitizeInput($rp_jasa);
                                                        $angsuran_total=validateAndSanitizeInput($angsuran_total);
                                                        $denda=validateAndSanitizeInput($denda);
                                                        $sistem_denda=validateAndSanitizeInput($sistem_denda);
                                                        $id_pinjaman_jenis=validateAndSanitizeInput($id_pinjaman_jenis);
                                                        //Buka Data Anggota
                                                        $nip=GetDetailData($Conn,'anggota','id_anggota',$id_anggota,'nip');
                                                        $nama=GetDetailData($Conn,'anggota','id_anggota',$id_anggota,'nama');
                                                        $lembaga=GetDetailData($Conn,'anggota','id_anggota',$id_anggota,'lembaga');
                                                        $ranking=GetDetailData($Conn,'anggota','id_anggota',$id_anggota,'ranking');
                                                        //Validasi Duplikasi Data
                                                        $ValidasiDataDuplikat= mysqli_num_rows(mysqli_query($Conn, "SELECT*FROM pinjaman WHERE id_anggota='$id_anggota' AND tanggal='$tanggal' AND jumlah_pinjaman='$jumlah_pinjaman'"));
                                                        if(!empty($ValidasiDataDuplikat)){
                                                            echo '<div class="text-danger">Data Tersebut Sudah Ada!!</div>';
                                                        }else{
                                                            $uuid_pinjaman=generateUuidV1();
                                                            $status="Berjalan";
                                                            $id_auto_jurnal=GetDetailData($Conn,'auto_jurnal','kategori_transaksi','Pinjaman','id_auto_jurnal');
                                                            if(empty($id_auto_jurnal)){
                                                                echo '<code class="text-danger">Auto Jurnal Belum Diatur</code>';
                                                            }else{ 
                                                                $debet_id=GetDetailData($Conn,'auto_jurnal','id_auto_jurnal',$id_auto_jurnal,'debet_id');
                                                                $debet_name=GetDetailData($Conn,'auto_jurnal','id_auto_jurnal',$id_auto_jurnal,'debet_name');
                                                                $kredit_id=GetDetailData($Conn,'auto_jurnal','id_auto_jurnal',$id_auto_jurnal,'kredit_id');
                                                                $kredit_name=GetDetailData($Conn,'auto_jurnal','id_auto_jurnal',$id_auto_jurnal,'kredit_name');
                                                                //Buka Akun Debet
                                                                $KodeDebet =GetDetailData($Conn,'akun_perkiraan','id_perkiraan',$debet_id,'kode');
                                                                //Buka Akun Kredit
                                                                $KodeKredit =GetDetailData($Conn,'akun_perkiraan','id_perkiraan',$kredit_id,'kode');
                                                                if(empty($KodeDebet)){
                                                                    echo '<code class="text-danger">Pengaturan Auto Jurnal Debet Tidak Valid</code>';
                                                                }else{
                                                                    if(empty($KodeKredit)){
                                                                        echo '<code class="text-danger">Pengaturan Auto Jurnal Kredit Tidak Valid</code>';
                                                                    }else{
                                                                        //Periksa Apakah Anggota Bersangkutan Sudah Punya Pinjaman Yang belum Lunas
                                                                        $PinjamanBelumLunas= mysqli_num_rows(mysqli_query($Conn, "SELECT*FROM pinjaman WHERE id_anggota='$id_anggota' AND id_pinjaman_jenis='$id_pinjaman_jenis' AND status!='Lunas'"));
                                                                        if(!empty($PinjamanBelumLunas)){
                                                                            echo '<code class="text-danger">Anggota Tersebut Masih Memiliki Piinjaman Yang Belum Lunas!</code>'; 
                                                                        }else{
                                                                            //Melakukan input data
                                                                            $entry="INSERT INTO pinjaman (
                                                                                id_pinjaman_jenis, 
                                                                                uuid_pinjaman,
                                                                                id_anggota,
                                                                                nama,
                                                                                nip,
                                                                                lembaga,
                                                                                ranking,
                                                                                tanggal,
                                                                                jatuh_tempo,
                                                                                denda,
                                                                                sistem_denda,
                                                                                jumlah_pinjaman,
                                                                                persen_jasa,
                                                                                rp_jasa,
                                                                                angsuran_pokok,
                                                                                angsuran_total,
                                                                                periode_angsuran,
                                                                                status
                                                                            ) VALUES (
                                                                                '$id_pinjaman_jenis',
                                                                                '$uuid_pinjaman',
                                                                                '$id_anggota',
                                                                                '$nama',
                                                                                '$nip',
                                                                                '$lembaga',
                                                                                '$ranking',
                                                                                '$tanggal',
                                                                                '$jatuh_tempo',
                                                                                '$denda',
                                                                                '$sistem_denda',
                                                                                '$jumlah_pinjaman',
                                                                                '$persen_jasa',
                                                                                '$rp_jasa',
                                                                                '$angsuran_pokok',
                                                                                '$angsuran_total',
                                                                                '$periode_angsuran',
                                                                                '$status'
                                                                            )";
                                                                            $Input=mysqli_query($Conn, $entry);
                                                                            if($Input){
                                                                                //Cari id_pinjaman
                                                                                $id_pinjaman=GetDetailData($Conn,'pinjaman','uuid_pinjaman',$uuid_pinjaman,'id_pinjaman');
                                                                                //Simpan Ke Jurnal Kredit
                                                                                $EntryDataKredit="INSERT INTO jurnal (
                                                                                    kategori,
                                                                                    uuid,
                                                                                    id_pinjaman,
                                                                                    tanggal,
                                                                                    kode_perkiraan,
                                                                                    nama_perkiraan,
                                                                                    d_k,
                                                                                    nilai
                                                                                ) VALUES (
                                                                                    'Pinjaman',
                                                                                    '$uuid_pinjaman',
                                                                                    '$id_pinjaman',
                                                                                    '$tanggal',
                                                                                    '$KodeKredit',
                                                                                    '$kredit_name',
                                                                                    'K',
                                                                                    '$jumlah_pinjaman'
                                                                                )";
                                                                                $InputDataKredit=mysqli_query($Conn, $EntryDataKredit);
                                                                                if($InputDataKredit){
                                                                                    //Simpan Ke Jurnal Debet
                                                                                    $EntryDataDebet="INSERT INTO jurnal (
                                                                                        kategori,
                                                                                        uuid,
                                                                                        id_pinjaman,
                                                                                        tanggal,
                                                                                        kode_perkiraan,
                                                                                        nama_perkiraan,
                                                                                        d_k,
                                                                                        nilai
                                                                                    ) VALUES (
                                                                                        'Pinjaman',
                                                                                        '$uuid_pinjaman',
                                                                                        '$id_pinjaman',
                                                                                        '$tanggal',
                                                                                        '$KodeDebet',
                                                                                        '$debet_name',
                                                                                        'D',
                                                                                        '$jumlah_pinjaman'
                                                                                    )";
                                                                                    $InputDataDebet=mysqli_query($Conn, $EntryDataDebet);
                                                                                    if($InputDataDebet){
                                                                                        $KategoriLog="Pinjaman";
                                                                                        $KeteranganLog="Tambah Pinjaman Berhasil    ";
                                                                                        include "../../_Config/InputLog.php";
                                                                                        echo '<div class="text-success" id="NotifikasiTambahPinjamanBerhasil">Success</div>';
                                                                                    }else{
                                                                                        echo '<div class="text-danger">Terjadi kesalahan pada saat menyimpan data jurnal Debet!!</div>';
                                                                                    }
                                                                                }else{
                                                                                    echo '<div class="text-danger">Terjadi kesalahan pada saat menyimpan data jurnal Kredit!!</div>';
                                                                                }
                                                                            }else{
                                                                                echo '<code class="text-danger">Terjadi kesalahan pada saat menyimpan data pinjaman</code><br>';
                                                                                echo "Error: " . $entry . "<br>" . mysqli_error($Conn);
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
                    }
                }
            }
        }
    }
?>
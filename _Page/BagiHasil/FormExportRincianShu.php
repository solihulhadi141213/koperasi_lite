<?php
    //Koneksi
    date_default_timezone_set('Asia/Jakarta');
    include "../../_Config/Connection.php";
    include "../../_Config/GlobalFunction.php";
    include "../../_Config/Session.php";

    //Tangkap id_shu_session
    if(empty($_POST['id_shu_session'])){
        echo '
            <div class="alert alert-danger">
                <small>
                    ID SHU Tidak Boleh Kosong!
                </small>
            </div>
        ';
    }else{
        $id_shu_session=validateAndSanitizeInput($_POST['id_shu_session']);
        //Buka data dengan prepared statment
        $Qry = $Conn->prepare("SELECT * FROM shu_session WHERE id_shu_session = ?");
        $Qry->bind_param("i", $id_shu_session);
        if (!$Qry->execute()) {
            $error=$Conn->error;
            echo '
                <div class="alert alert-danger">
                    <small>
                        Terjadi kesalahan pada saat menampilkan data sesi SHU <br> Keterangan : '.$error.'
                    </small>
                </div>
            ';
        }else{
            $Result = $Qry->get_result();
            $Data = $Result->fetch_assoc();

            //Apabila Data Tidak Ditemukan
            if(empty($Data['id_shu_session'])){
                echo '
                    <div class="alert alert-danger">
                        <small>
                            Data Sesi SHU tidak ditemukan!
                        </small>
                    </div>
                ';
            }else{
                //Buat Variabel
                $periode_hitung1=$Data['periode_hitung1'];
                $periode_hitung2=$Data['periode_hitung2'];
                $total_penjualan=$Data['total_penjualan'];
                $total_simpanan=$Data['total_simpanan'];
                $total_pinjaman=$Data['total_pinjaman'];
                $persen_penjualan=$Data['persen_penjualan'];
                $persen_simpanan=$Data['persen_simpanan'];
                $persen_pinjaman=$Data['persen_pinjaman'];
                $shu=$Data['shu'];
                $status=$Data['status'];

                //Format tanggal
                $periode_hitung1=date('d/m/Y',strtotime($periode_hitung1));
                $periode_hitung2=date('d/m/Y',strtotime($periode_hitung2));

                //Jumlah Rincian SHU
                $sum_alokasi= mysqli_fetch_array(mysqli_query($Conn, "SELECT SUM(shu) AS jumlah FROM shu_rincian WHERE id_shu_session='$id_shu_session'"));
                if(!empty($sum_alokasi['jumlah'])){
                    $jumlah_alokasi = $sum_alokasi['jumlah'];
                }else{
                    $jumlah_alokasi =0;
                }

                //Hitung Jumlah Record
                $jml_data_rincian = mysqli_num_rows(mysqli_query($Conn, "SELECT id_shu_rincian FROM shu_rincian WHERE id_shu_session='$id_shu_session'"));
                $jml_data_rincian = "" . number_format($jml_data_rincian,0,',','.');
                //Tampilkan Data Pada Modal
                echo '
                    <input type="hidden" name="id_shu_session" id="put_id_shu_session_for_export_rincian" value="'.$id_shu_session.'">
                    <div class="row mb-2">
                        <div class="col-12">
                            <small>Silahkan pilih tipe/format data yang ingin anda tampilkan</small>
                        </div>
                    </div>
                    <div class="row mb-2">
                        <div class="col-4">
                            <small>Periode Perhitungan</small>
                        </div>
                        <div class="col-1">:</div>
                        <div class="col-7">
                            <small class="text-muted">
                                '.$periode_hitung1.' - '.$periode_hitung2.'
                            </small>
                        </div>
                    </div>
                    <div class="row mb-2">
                        <div class="col-4">
                            <small>Jumlah Record</small>
                        </div>
                        <div class="col-1">:</div>
                        <div class="col-7">
                            <small class="text-muted">
                                '.$jml_data_rincian.' Record
                            </small>
                        </div>
                    </div>
                    <div class="row mb-3">
                        <div class="col-4 mb-3">
                            <small>Type/Format</small>
                        </div>
                        <div class="col-1 mb-3">:</div>
                        <div class="col-7 mb-3">
                            <select name="format_export_rincian" id="format_export_rincian" class="form-control">
                                <option value="">Pilih</option>
                                <option value="HTML">HTML</option>
                                <option value="Excel">Excel</option>
                            </select>
                        </div>
                    </div>
                    <div class="row mb-2">
                        <div class="col-12">
                            <div class="alert alert-warning">
                                <small>
                                    Semakin banyak record rincian data maka proses mungkin akan membutuhkan waktu lebih lama.
                                </small>
                            </div>
                        </div>
                    </div>
                ';
            }
        }
    }
?>
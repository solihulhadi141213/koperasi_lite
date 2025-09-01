<?php
    //koneksi dan session
    include "../../_Config/Connection.php";
    include "../../_Config/GlobalFunction.php";

    //Zona waktu
    date_default_timezone_set('Asia/Jakarta');

    //Time Now Tmp
    $now=date('Y-m-d');

    //Validasi id_pinjaman_angsuran tidak boleh kosong
    if(empty($_POST['id_pinjaman_angsuran'])){
        echo '
            <div class="alert alert-danger">
                ID Angsuran Pinjaman Tidak Boleh Kosong!
            </div>
        ';
    }else{
        
        //Validasi metode_pembayaran tidak boleh kosong
        if(empty($_POST['metode_pembayaran'])){
            echo '
                <div class="alert alert-danger">
                    Metode Pembayaran Tidak Boleh Kosong!
                </div>
            ';
        }else{
            $id_pinjaman_angsuran=$_POST['id_pinjaman_angsuran'];
            $metode_pembayaran=$_POST['metode_pembayaran'];

            $keterlambatan = isset($_POST['keterlambatan']) ? trim($_POST['keterlambatan']) : 0;
            $pokok = isset($_POST['pokok']) ? trim($_POST['pokok']) : 0;
            $jasa = isset($_POST['jasa']) ? trim($_POST['jasa']) : 0;
            $denda = isset($_POST['denda']) ? trim($_POST['denda']) : 0;
            $jumlah = isset($_POST['jumlah']) ? trim($_POST['jumlah']) : 0;

            //Buat kode pembayaran
            $kode_pembayaran=GenerateKodeBarang(12);

            //Update Data Angsuran
            $UpdateStatusAngsuran = mysqli_query($Conn,"UPDATE pinjaman_angsuran SET 
                kode_pembayaran='$kode_pembayaran',
                metode_pembayaran='$metode_pembayaran',
                keterlambatan='$keterlambatan',
                pokok='$pokok',
                jasa='$jasa',
                denda='$denda',
                jumlah='$jumlah',
                tanggal_bayar='$now',
                status='Pending'
            WHERE id_pinjaman_angsuran='$id_pinjaman_angsuran'") or die(mysqli_error($Conn)); 
            if($UpdateStatusAngsuran){
                echo '
                    <div class="alert alert-success">
                       <small id="get_kode_pembayaran">'.$kode_pembayaran.'</small><br>
                       <small id="NotifikasiBayarAngsuranBerhasil">Success</small>
                    </div>
                ';
            }else{
                echo '
                    <div class="alert alert-danger">
                        Terjadi kesalahan pada saat melakukan update angsuran!
                    </div>
                ';
            }
        }
    }
?>
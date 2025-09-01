<?php
    //koneksi dan session
    include "../../_Config/Connection.php";
    include "../../_Config/GlobalFunction.php";

    //Validasi id_pinjaman_angsuran tidak boleh kosong
    if(empty($_POST['id_pinjaman_angsuran'])){
        echo '
            <div class="alert alert-danger">
                ID Angsuran Pinjaman Tidak Boleh Kosong!
            </div>
        ';
    }else{
        $id_pinjaman_angsuran=$_POST['id_pinjaman_angsuran'];
        
        //Buka Jenis Simpanan
        $id_pinjaman=GetDetailData($Conn,'pinjaman_angsuran','id_pinjaman_angsuran',$id_pinjaman_angsuran,'id_pinjaman');
        $tanggal_angsuran=GetDetailData($Conn,'pinjaman_angsuran','id_pinjaman_angsuran',$id_pinjaman_angsuran,'tanggal_angsuran');
        $tanggal_bayar=GetDetailData($Conn,'pinjaman_angsuran','id_pinjaman_angsuran',$id_pinjaman_angsuran,'tanggal_bayar');
        $pokok=GetDetailData($Conn,'pinjaman_angsuran','id_pinjaman_angsuran',$id_pinjaman_angsuran,'pokok');
        $jasa=GetDetailData($Conn,'pinjaman_angsuran','id_pinjaman_angsuran',$id_pinjaman_angsuran,'jasa');
        $jumlah=GetDetailData($Conn,'pinjaman_angsuran','id_pinjaman_angsuran',$id_pinjaman_angsuran,'jumlah');

        //Buka Nominal Denda
        $rp_denda=GetDetailData($Conn,'pinjaman','id_pinjaman',$id_pinjaman,'rp_denda');

        //Tanggal Bayar
        $tanggal_bayar=date('Y-m-d');

        //Hitung Keterlambatan
        $date1 = new DateTime($tanggal_angsuran);
        $date2 = new DateTime($tanggal_bayar);

        // Hitung selisih
        $diff = $date1->diff($date2);

        // Ambil jumlah hari
        $hari_keterlambatan = $diff->days;

        // Jika tanggal bayar lebih awal atau sama dengan angsuran, anggap tidak telat
        if ($date2 <= $date1) {
            $hari_keterlambatan = 0;
            $denda = 0;
        }else{
            //Buka Nominal Denda
            $rp_denda=GetDetailData($Conn,'pinjaman','id_pinjaman',$id_pinjaman,'rp_denda');
            
        }

        //Hitung Denda
        $denda =$rp_denda*$hari_keterlambatan;

        //Detail Pinjaman
        $jumlah_pinjaman=GetDetailData($Conn,'pinjaman','id_pinjaman',$id_pinjaman,'jumlah_pinjaman');
        $id_pinjaman_jenis=GetDetailData($Conn,'pinjaman','id_pinjaman',$id_pinjaman,'id_pinjaman_jenis');

        //Nama Jenis Pinjaman
        $nama_pinjaman=GetDetailData($Conn,'pinjaman_jenis','id_pinjaman_jenis',$id_pinjaman_jenis,'nama_pinjaman');

        //Menghitung Jumlah Angsuran
        $jumlah_angsuran=$pokok+$jasa+$denda;

        //Format Rupiah
        $jumlah_pinjaman_format = "Rp " . number_format($jumlah_pinjaman,0,',','.');
        $pokok_Format = "Rp " . number_format($pokok,0,',','.');
        $jasa_Format = "Rp " . number_format($jasa,0,',','.');
        $denda_format = "Rp " . number_format($denda,0,',','.');
        $jumlah_Format = "Rp " . number_format($jumlah_angsuran,0,',','.');

        //Format Tanggal
        $tanggal_angsuran_format=date('d/m/Y', strtotime($tanggal_angsuran));
        $tanggal_bayar_format=date('d/m/Y', strtotime($tanggal_bayar));

        echo '<input type="hidden" name="id_pinjaman_angsuran" value="'.$id_pinjaman_angsuran.'">';
        echo '<input type="hidden" name="keterlambatan" value="'.$hari_keterlambatan.'">';
        echo '<input type="hidden" name="pokok" value="'.$pokok.'">';
        echo '<input type="hidden" name="jasa" value="'.$jasa.'">';
        echo '<input type="hidden" name="denda" value="'.$denda.'">';
        echo '<input type="hidden" name="jumlah" value="'.$jumlah_angsuran.'">';
        echo '
            <div class="row mb-2">
                <div class="col-5"><small>Nama Pinjaman</small></div>
                <div class="col-1"><small>:</small></div>
                <div class="col-6"><small><code class="text text-grayish">'.$nama_pinjaman.'</code></small></div>
            </div>
            <div class="row mb-2">
                <div class="col-5"><small>Jumlah Pinjaman</small></div>
                <div class="col-1"><small>:</small></div>
                <div class="col-6"><small><code class="text text-grayish">'.$jumlah_pinjaman_format.'</code></small></div>
            </div>
            <div class="row mb-2">
                <div class="col-5"><small>Periode Angsuran</small></div>
                <div class="col-1"><small>:</small></div>
                <div class="col-6"><small><code class="text text-grayish">'.$tanggal_angsuran_format.'</code></small></div>
            </div>
            <div class="row mb-2">
                <div class="col-5"><small>Tgl.Bayar</small></div>
                <div class="col-1"><small>:</small></div>
                <div class="col-6"><small><code class="text text-grayish">'.$tanggal_bayar.'</code></small></div>
            </div>
            <div class="row mb-2">
                <div class="col-5"><small>Keterlambatan</small></div>
                <div class="col-1"><small>:</small></div>
                <div class="col-6"><small><code class="text text-grayish">'.$hari_keterlambatan.' Hari</code></small></div>
            </div>
            <div class="row mb-2">
                <div class="col-5"><small>Angsuran Pokok</small></div>
                <div class="col-1"><small>:</small></div>
                <div class="col-6"><small><code class="text text-grayish">'.$pokok_Format.'</code></small></div>
            </div>
            <div class="row mb-2">
                <div class="col-5"><small>Jasa Pinjaman</small></div>
                <div class="col-1"><small>:</small></div>
                <div class="col-6"><small><code class="text text-grayish">'.$jasa_Format.'</code></small></div>
            </div>
            <div class="row mb-2">
                <div class="col-5"><small>Denda</small></div>
                <div class="col-1"><small>:</small></div>
                <div class="col-6"><small><code class="text text-grayish">'.$denda_format.'</code></small></div>
            </div>
            <div class="row mb-2">
                <div class="col-5"><small>Jumlah Angsuran</small></div>
                <div class="col-1"><small>:</small></div>
                <div class="col-6"><small><code class="text text-grayish">'.$jumlah_Format.'</code></small></div>
            </div>
            <div class="row mb-2 mt-3">
                <div class="col-12 mt-3">
                    <small>
                        <b>Pilih Metode Pembayaran</b>
                    </small>
                    <select class="form-control" name="metode_pembayaran">
                        <option value="">Pilih</option>
                        <option value="BRI-Virtual Account">BRI-Virtual Account</option>
                        <option value="BNI-Virtual Account">BNI-Virtual Account</option>
                        <option value="Mandiri-Virtual Account">Mandiri-Virtual Account</option>
                        <option value="BCA-Virtual Account">BCA-Virtual Account</option>
                        <option value="Retail-Indomart/Alfamart">Retail-Indomart/Alfamart</option>
                    </select>
                </div>
            </div>
        ';
    }
?>
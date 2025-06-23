<?php
    //Koneksi
    date_default_timezone_set('Asia/Jakarta');
    include "../../_Config/Connection.php";
    include "../../_Config/GlobalFunction.php";
    include "../../_Config/SettingGeneral.php";
    include "../../_Config/Session.php";
    if(empty($SessionIdAkses)){
        echo '<div class="row">';
        echo '  <div class="col-md-12 mb-3 text-center">';
        echo '      <small class="text-danger">Sesi Akses Sudah Berakhir, Silahkan Login Ulang</small>';
        echo '  </div>';
        echo '</div>';
    }else{
        if(empty($_POST['id_simpanan'])){
            echo '<div class="row">';
            echo '  <div class="col-md-12 mb-3 text-center">';
            echo '      <small class="text-danger">Tidak ada data yang ditangkap oleh sistem</small>';
            echo '  </div>';
            echo '</div>';
        }else{
            $id_simpanan=$_POST['id_simpanan'];
            //Buka Detail Simpanan
            $id_anggota=GetDetailData($Conn,'simpanan','id_simpanan',$id_simpanan,'id_anggota');
            $id_akses=GetDetailData($Conn,'simpanan','id_simpanan',$id_simpanan,'id_akses');
            $id_simpanan_jenis=GetDetailData($Conn,'simpanan','id_simpanan',$id_simpanan,'id_simpanan_jenis');
            $rutin=GetDetailData($Conn,'simpanan','id_simpanan',$id_simpanan,'rutin');
            $nip=GetDetailData($Conn,'simpanan','id_simpanan',$id_simpanan,'nip');
            $nama=GetDetailData($Conn,'simpanan','id_simpanan',$id_simpanan,'nama');
            $lembaga=GetDetailData($Conn,'simpanan','id_simpanan',$id_simpanan,'lembaga');
            $ranking=GetDetailData($Conn,'simpanan','id_simpanan',$id_simpanan,'ranking');
            $tanggal=GetDetailData($Conn,'simpanan','id_simpanan',$id_simpanan,'tanggal');
            $kategori=GetDetailData($Conn,'simpanan','id_simpanan',$id_simpanan,'kategori');
            $keterangan=GetDetailData($Conn,'simpanan','id_simpanan',$id_simpanan,'keterangan');
            $jumlah=GetDetailData($Conn,'simpanan','id_simpanan',$id_simpanan,'jumlah');
            if($kategori=="Penarikan"){
                $LabelKategori='<code class="text text-danger">Penarikan dana simpanan</code>';
            }else{
                $LabelKategori='<code class="text text-success">'.$kategori.'</code>';
            }
            //Format tanggal
            $strtotime=strtotime($tanggal);
            $TanggalFormat=date('d/m/Y',$strtotime);
            //Format Rupiah
            $jumlah_format = "Rp " . number_format($jumlah,0,',','.');
            if(empty($keterangan)){
                $keterangan="";
            }
?>
            <input type="hidden" name="id_simpanan" class="form-control" value="<?php echo $id_simpanan; ?>">
            <input type="hidden" name="id_anggota" class="form-control" value="<?php echo $id_anggota; ?>">
            <div class="row mb-3">
                <div class="col-md-4">Nama Anggota</div>
                <div class="col-md-8">
                    <code class="text text-grayish"><?php echo "$nama"; ?></code>
                </div>
            </div>
            <div class="row mb-3">
                <div class="col-md-4">NIP</div>
                <div class="col-md-8">
                    <code class="text text-grayish"><?php echo "$nip"; ?></code>
                </div>
            </div>
            <div class="row mb-3">
                <div class="col-md-4">
                    <label for="tanggal_simpanan_edit">Tanggal Simpanan</label>
                </div>
                <div class="col-md-8">
                    <input type="date" id="tanggal_simpanan_edit" name="tanggal" class="form-control" value="<?php echo $tanggal; ?>">
                </div>
            </div>
            <div class="row mb-3">
                <div class="col-md-4">
                    <label for="id_simpanan_jenis_edit">Jenis Simpanan</label>
                </div>
                <div class="col-md-8">
                    <select name="id_simpanan_jenis" id="id_simpanan_jenis_edit" class="form-control">
                        <option value="">Pilih</option>
                        <option <?php if($id_simpanan_jenis==0){echo "selected";} ?> value="Penarikan">Penarikan</option>
                        <optgroup label="Simpanan Wajib/Rutin">
                        <?php
                            //Menampilkan Simpanan Wajib
                            $query = mysqli_query($Conn, "SELECT*FROM simpanan_jenis WHERE rutin='1' ORDER BY nama_simpanan ASC");
                            while ($data = mysqli_fetch_array($query)) {
                                $id_simpanan_jenis_list= $data['id_simpanan_jenis'];
                                $nama_simpanan= $data['nama_simpanan'];
                                $rutin= $data['rutin'];
                                $nominal= $data['nominal'];
                                if($id_simpanan_jenis==$id_simpanan_jenis_list){
                                    echo '<option selected value="'.$id_simpanan_jenis.'" data-id="'.$nominal.'">'.$nama_simpanan.'</option>';
                                }else{
                                    echo '<option value="'.$id_simpanan_jenis.'" data-id="'.$nominal.'">'.$nama_simpanan.'</option>';
                                }
                            }
                        ?>
                        </optgroup>
                        <optgroup label="Simpanan Sukarela">
                        <?php
                            //Menampilkan Simpanan Wajib
                            $query = mysqli_query($Conn, "SELECT*FROM simpanan_jenis WHERE rutin='0' ORDER BY nama_simpanan ASC");
                            while ($data = mysqli_fetch_array($query)) {
                                $id_simpanan_jenis_list= $data['id_simpanan_jenis'];
                                $nama_simpanan= $data['nama_simpanan'];
                                $rutin= $data['rutin'];
                                $nominal= $data['nominal'];
                                if($id_simpanan_jenis==$id_simpanan_jenis_list){
                                    echo '<option selected value="'.$id_simpanan_jenis.'" data-id="'.$nominal.'">'.$nama_simpanan.'</option>';
                                }else{
                                    echo '<option value="'.$id_simpanan_jenis.'" data-id="'.$nominal.'">'.$nama_simpanan.'</option>';
                                }
                            }
                        ?>
                        </optgroup>
                    </select>
                </div>
            </div>
            <div class="row mb-3">
                <div class="col-md-4">
                    <label for="nominal_simpanan_edit">Nominal (RP)</label>
                </div>
                <div class="col-md-8">
                    <input type="text" id="nominal_simpanan_edit" name="nominal" class="form-control" value="<?php echo $jumlah; ?>">
                </div>
            </div>
            <div class="row mb-3">
                <div class="col-md-4">
                    <label for="keterangan_edit">Keterangan</label>
                </div>
                <div class="col-md-8">
                    <textarea name="keterangan" id="keterangan_edit" class="form-control"><?php echo $keterangan; ?></textarea>
                    <small class="credit">
                        <code class="text text-grayish">
                            Informasi lain terkait simpanan anggtoa jika dibutuhkan
                        </code>
                    </small>
                </div>
            </div>
            <div class="row mb-3">
                <div class="col-md-4"></div>
                <div class="col-md-8 text-primary">
                    Pastikan parameter yang anda masukan sudah sesuai
                </div>
            </div>
            <div class="row mb-3">
                <div class="col-md-12 text-primary">
                    
                </div>
            </div>
            <script>
                function formatRupiah(angka) {
                    var numberString = angka.toString();
                    var sisa = numberString.length % 3;
                    var rupiah = numberString.substr(0, sisa);
                    var ribuan = numberString.substr(sisa).match(/\d{3}/g);
                    
                    if (ribuan) {
                        var separator = sisa ? '.' : '';
                        rupiah += separator + ribuan.join('.');
                    }
                    return 'Rp' + rupiah;
                }
                $('#nominal_simpanan_edit').on('keypress', function(e) {
                    // Hanya mengizinkan angka (0-9)
                    if (e.which < 48 || e.which > 57) {
                        e.preventDefault();
                    }
                });
                $('#id_simpanan_jenis_edit').on('change', function() {
                    var NominalSimpanan = $(this).find(':selected').data('id');
                    $('#nominal_simpanan_edit').val(NominalSimpanan);
                });
            </script>
<?php
        }
    }
?>
//Fungsi Menampilkan Data
function ShowPinjaman() {
    $.ajax({
        type    : 'POST',
        url     : '_Page/PinjamanAnggota/TabelPinjamanAnggota.php',
        success: function(data) {
            $('#TabelPinjamanAnggota').html(data);
        }
    });
}
//Fungsi Untuk Format Rupiah
function formatRupiah(angka) {
    return 'Rp ' + parseFloat(angka).toLocaleString('id-ID', { minimumFractionDigits: 0 });
}

// Fungsi untuk memproses input pada elemen dengan class form-money
function processInput(event) {
    let input = event.target;
    let originalValue = input.value;

    // Hilangkan titik dari nilai asli untuk penghitungan
    let rawValue = originalValue.replace(/\./g, "");

    // Format nilai input
    let formattedValue = formatMoney(rawValue);

    // Update nilai input dengan nilai yang telah diformat
    input.value = formattedValue;
}

// Fungsi untuk memformat angka menjadi format ribuan
function formatMoney(value) {
    if (!value) return ""; // Jika kosong, kembalikan string kosong
    // Hilangkan karakter selain angka
    value = value.toString().replace(/[^0-9]/g, "");
    // Tambahkan pemisah ribuan (titik)
    return value.replace(/\B(?=(\d{3})+(?!\d))/g, ".");
}

// Fungsi untuk menginisialisasi elemen form-money
function initializeMoneyInputs() {
    const moneyInputs = document.querySelectorAll(".form-money");
    moneyInputs.forEach(function (input) {
        // Format nilai awal jika sudah ada
        input.value = formatMoney(input.value);

        // Pastikan input diformat dengan benar
        input.removeEventListener("input", processInput); // Menghapus event listener sebelumnya
        input.addEventListener("input", processInput);
    });
}

//Ketika Halaman Load Pertama Kali
$(document).ready(function() {

    //Tampilkan Data Pengajuan Pinjaman
    ShowPinjaman();
    initializeMoneyInputs();

    //Modal Pilih Pinjaman
    $('#ModalPilihPinjaman').on('show.bs.modal', function (e) {
        $.ajax({
            type 	    : 'POST',
            url 	    : '_Page/PinjamanAnggota/TabelJenisPinjaman.php',
            success     : function(data){
                $('#TabelJenisPinjaman').html(data);
            }
        });
    });

    //Tambah Pinjaman
    $('#ModalTambahPinjaman').on('show.bs.modal', function (e) {
        var id_pinjaman_jenis= $(e.relatedTarget).data('id');
        $('#FormTambahPinjaman').html("Loading...");
        $.ajax({
            type 	    : 'POST',
            url 	    : '_Page/PinjamanAnggota/FormTambahPinjaman.php',
            data        : {id_pinjaman_jenis: id_pinjaman_jenis},
            success     : function(data){
                $('#FormTambahPinjaman').html(data);
                $('#put_id_pinjaman_jenis').val(id_pinjaman_jenis);
            }
        });
    });

    //Proses Tamabah Pinjaman
    $('#ProsesTambahPinjaman').submit(function(e){
        e.preventDefault(); // Mencegah form submit default
        
        var id_pinjaman_jenis = $('#put_id_pinjaman_jenis').val();
        var jumlah_pinjaman = $('#jumlah_pinjaman').val();
        
        // Hilangkan titik (format ribuan) dan konversi ke angka
        var jumlah_numerik = parseInt(jumlah_pinjaman.replace(/\./g, ''));
        
        // Validasi
        if (jumlah_numerik < 500000) {
             if (!/^\d{1,3}(?:\.\d{3})*$/.test(jumlah_pinjaman)) {
                $('#NotifikasiTambahPinjaman').html('<div class="alert alert-danger"><small>Format jumlah pinjaman tidak valid. Gunakan format seperti 1.000.000</small></div>');
            }else{
                $('#NotifikasiTambahPinjaman').html('<div class="alert alert-danger"><small>Jumlah nominal pinjaman minimal 500.000</small></div>');
            }
        } else {
            $('#ModalTambahPinjaman').modal('hide');
            $('#ModalKirimPengajuanPinjaman').modal('show');

            $.ajax({
                type 	    : 'POST',
                url 	    : '_Page/PinjamanAnggota/FormKirimPengajuanPinjaman.php',
                data        : {id_pinjaman_jenis: id_pinjaman_jenis, jumlah_pinjaman: jumlah_numerik},
                success     : function(data){
                    $('#FormKirimPengajuanPinjaman').html(data);
                }
            });
        }
    });

    //Proses Kirim Pengajuan Pinjaman
    $('#ProsesKirimPengajuanPinjaman').submit(function(){
        $('#NotifikasiirimPengajuanPinjaman').html('<div class="spinner-border text-secondary" role="status"><span class="sr-only"></span></div>');
        var form = $('#ProsesKirimPengajuanPinjaman')[0];
        var data = new FormData(form);
        $.ajax({
            type 	    : 'POST',
            url 	    : '_Page/PinjamanAnggota/ProsesKirimPengajuanPinjaman.php',
            data 	    :  data,
            cache       : false,
            processData : false,
            contentType : false,
            enctype     : 'multipart/form-data',
            success     : function(data){
                $('#NotifikasiirimPengajuanPinjaman').html(data);
                var NotifikasiirimPengajuanPinjamanBerhasil=$('#NotifikasiirimPengajuanPinjamanBerhasil').html();
                if(NotifikasiirimPengajuanPinjamanBerhasil=="Success"){
                    $('#ModalKirimPengajuanPinjaman').modal('hide');
                    Swal.fire(
                        'Success!',
                        'Pengajuan Pinjaman Berhasil Dikirim',
                        'success'
                    )
                    ShowPinjaman();
                }
            }
        });
    });

    //Modal Detail Pinjaman
    $('#ModalDetailPinjaman').on('show.bs.modal', function (e) {
        var id_pinjaman= $(e.relatedTarget).data('id');
        $('#FormDetailPinjaman').html("Loading...");
        $.ajax({
            type 	    : 'POST',
            url 	    : '_Page/PinjamanAnggota/FormDetailPinjaman.php',
            data        : {id_pinjaman: id_pinjaman},
            success     : function(data){
                $('#FormDetailPinjaman').html(data);
            }
        });
    });

    //Modal Pembatalan Pinjaman
    $('#ModalPembatalanPengajuan').on('show.bs.modal', function (e) {
        var id_pinjaman= $(e.relatedTarget).data('id');
        $('#FormPembatalanPengajuan').html("Loading...");
        $('#NotifikasiPembatalanPengajuan').html("");
        $.ajax({
            type 	    : 'POST',
            url 	    : '_Page/PinjamanAnggota/FormPembatalanPengajuan.php',
            data        : {id_pinjaman: id_pinjaman},
            success     : function(data){
                $('#FormPembatalanPengajuan').html(data);
            }
        });
    });

    //Proses Pembatalan Pengajuan Pinjaman
    $('#ProsesPembatalanPengajuan').submit(function(){
        $('#NotifikasiPembatalanPengajuan').html('<div class="spinner-border text-secondary" role="status"><span class="sr-only"></span></div>');
        var form = $('#ProsesPembatalanPengajuan')[0];
        var data = new FormData(form);
        $.ajax({
            type 	    : 'POST',
            url 	    : '_Page/PinjamanAnggota/ProsesPembatalanPengajuan.php',
            data 	    :  data,
            cache       : false,
            processData : false,
            contentType : false,
            enctype     : 'multipart/form-data',
            success     : function(data){
                $('#NotifikasiPembatalanPengajuan').html(data);
                var NotifikasiPembatalanPengajuanBerhasil=$('#NotifikasiPembatalanPengajuanBerhasil').html();
                if(NotifikasiPembatalanPengajuanBerhasil=="Success"){
                    $('#ModalPembatalanPengajuan').modal('hide');
                    Swal.fire(
                        'Success!',
                        'Pengajuan Pinjaman Berhasil Dibatalkan',
                        'success'
                    )
                    ShowPinjaman();
                }
            }
        });
    });
});
function filterAndLoadTable() {
    var ProsesFilter = $('#ProsesFilter').serialize();
    $.ajax({
        type 	    : 'POST',
        url 	    : '_Page/Jurnal/TabelJurnal.php',
        data 	    :  ProsesFilter,
        success     : function(data){
            $('#MenampilkanTabelJurnal').html(data);
        }
    });
}
// Fungsi untuk validasi periode
function validatePeriode() {
    var periode1 = $('#periode_1').val();
    var periode2 = $('#periode_2').val();

    // Cek jika periode1 dan periode2 memiliki nilai
    if (periode1 && periode2) {
        // Jika Periode Awal lebih besar dari Periode Akhir, tampilkan pesan error
        if (new Date(periode1) > new Date(periode2)) {
            $('#NotifikasiFormExport').html('<small class="text-danger">Periode Awal tidak boleh lebih besar dari Periode Akhir</small>');
            $('#periode_1').val(''); // Reset Periode Awal
        } else {
            // Jika periode benar, ganti notifikasi menjadi pesan sukses
            $('#NotifikasiFormExport').html('<small class="text-success">Data Jurnal Siap Di Export</small>');
        }
    } else {
        // Jika salah satu periode belum diisi, kosongkan notifikasi
        $('#NotifikasiFormExport').html('');
    }
}
//Ketika Keyword By Dipilih
$('#KeywordBy').change(function(){
    var KeywordBy = $('#KeywordBy').val();
    $('#FormFilter').html('Loading...');
    $.ajax({
        type 	    : 'POST',
        url 	    : '_Page/Jurnal/FormFilter.php',
        data 	    :  {KeywordBy: KeywordBy},
        success     : function(data){
            $('#FormFilter').html(data);
        }
    });
});
//Ketika Filter Di Submit
$('#ProsesFilter').submit(function(){
    $('#page').val('1');
    filterAndLoadTable();
    $('#ModalFilter').modal('hide');
});
//Menampilkan Data Pertama Kali
$(document).ready(function() {
    filterAndLoadTable();
});
//Proses Tambah Jurnal
$('#ProsesTambahJurnal').submit(function(event){
    event.preventDefault(); // Mencegah form dari reload halaman
    $('#NotifikasiTambahJurnal').html('Loading...');
    var form = $('#ProsesTambahJurnal')[0];
    var data = new FormData(form);
    $.ajax({
        type: 'POST',
        url: '_Page/Jurnal/ProsesTambahJurnal.php',
        data: data,
        cache: false,
        processData: false,
        contentType: false,
        enctype: 'multipart/form-data',
        success: function(response){
            $('#NotifikasiTambahJurnal').html(response);
            // Mengecek jika respons sukses
            var NotifikasiTambahJurnalBerhasil = $('#NotifikasiTambahJurnalBerhasil').html();
            if(NotifikasiTambahJurnalBerhasil === "Success"){
                $('#NotifikasiTambahJurnal').html('');
                $('#ProsesFilter').trigger('reset');
                $('#ProsesTambahJurnal').trigger('reset');
                $('#ModalTambahJurnalKeuangan').modal('hide');
                Swal.fire({
                    title: 'Success!',
                    text: 'Tambah Jurnal Berhasil!',
                    icon: 'success'
                });
                // Menampilkan data terbaru
                filterAndLoadTable();
            }
        },
        error: function(xhr, status, error){
            // Menampilkan pesan error jika terjadi masalah
            $('#NotifikasiTambahJurnal').html('Error: ' + error);
            Swal.fire({
                title: 'Error!',
                text: 'Ada masalah saat menambahkan jurnal.',
                icon: 'error'
            });
        }
    });
});
//Modal Detail Jurnal
$('#ModalDetailJurnal').on('show.bs.modal', function (e) {
    var id_jurnal = $(e.relatedTarget).data('id');
    $('#FormDetailJurnal').html("Loading...");
    $.ajax({
        type 	    : 'POST',
        url 	    : '_Page/Jurnal/FormDetailJurnal.php',
        data        : {id_jurnal: id_jurnal},
        success     : function(data){
            $('#FormDetailJurnal').html(data);
        }
    });
});
//Modal Edit Jurnal
$('#ModalEditJurnal').on('show.bs.modal', function (e) {
    var id_jurnal = $(e.relatedTarget).data('id');
    $('#FormEditJurnal').html("Loading...");
    $.ajax({
        type 	    : 'POST',
        url 	    : '_Page/Jurnal/FormEditJurnal.php',
        data        : {id_jurnal: id_jurnal},
        success     : function(data){
            $('#FormEditJurnal').html(data);
            $('#NotifikasiEditJurnal').html('<small>Pastikan data jurnal sudah sesuai</small>');
        }
    });
});
$('#ProsesEditJurnal').submit(function(event){
    event.preventDefault(); // Mencegah form dari reload halaman
    $('#NotifikasiEditJurnal').html('Loading...');
    var form = $('#ProsesEditJurnal')[0];
    var data = new FormData(form);
    $.ajax({
        type: 'POST',
        url: '_Page/Jurnal/ProsesEditJurnal.php',
        data: data,
        cache: false,
        processData: false,
        contentType: false,
        enctype: 'multipart/form-data',
        success: function(response){
            $('#NotifikasiEditJurnal').html(response);
            // Mengecek jika respons sukses
            var NotifikasiEditJurnalBerhasil = $('#NotifikasiEditJurnalBerhasil').html();
            if(NotifikasiEditJurnalBerhasil === "Success"){
                $('#NotifikasiEditJurnal').html('');
                $('#ModalEditJurnal').modal('hide');
                Swal.fire({
                    title: 'Success!',
                    text: 'Edit Jurnal Berhasil!',
                    icon: 'success'
                });
                // Menampilkan data terbaru
                filterAndLoadTable();
            }
        },
        error: function(xhr, status, error){
            // Menampilkan pesan error jika terjadi masalah
            $('#NotifikasiEditJurnal').html('Error: ' + error);
            Swal.fire({
                title: 'Error!',
                text: 'Ada masalah saat melakukan update jurnal.',
                icon: 'error'
            });
        }
    });
});
//Modal Hapus Jurnal
$('#ModalHapusJurnal').on('show.bs.modal', function (e) {
    var id_jurnal = $(e.relatedTarget).data('id');
    $('#FormHapusJurnal').html("Loading...");
    $.ajax({
        type 	    : 'POST',
        url 	    : '_Page/Jurnal/FormHapusJurnal.php',
        data        : {id_jurnal: id_jurnal},
        success     : function(data){
            $('#FormHapusJurnal').html(data);
            $('#NotifikasiHapusJurnal').html('<small>Apakah anda yakin akan menghapus data ini?</small>');
        }
    });
});
//Proses Hapus Jurnal
$('#ProsesHapusJurnal').submit(function(event){
    event.preventDefault(); // Mencegah form dari reload halaman
    $('#NotifikasiHapusJurnal').html('Loading...');
    var form = $('#ProsesHapusJurnal')[0];
    var data = new FormData(form);
    $.ajax({
        type: 'POST',
        url: '_Page/Jurnal/ProsesHapusJurnal.php',
        data: data,
        cache: false,
        processData: false,
        contentType: false,
        enctype: 'multipart/form-data',
        success: function(response){
            $('#NotifikasiHapusJurnal').html(response);
            // Mengecek jika respons sukses
            var NotifikasiHapusJurnalBerhasil = $('#NotifikasiHapusJurnalBerhasil').html();
            if(NotifikasiHapusJurnalBerhasil === "Success"){
                $('#NotifikasiHapusJurnal').html('');
                $('#ModalHapusJurnal').modal('hide');
                Swal.fire({
                    title: 'Success!',
                    text: 'Hapus Jurnal Berhasil!',
                    icon: 'success'
                });
                // Menampilkan data terbaru
                filterAndLoadTable();
            }
        },
        error: function(xhr, status, error){
            // Menampilkan pesan error jika terjadi masalah
            $('#NotifikasiEditJurnal').html('Error: ' + error);
            Swal.fire({
                title: 'Error!',
                text: 'Ada masalah saat melakukan update jurnal.',
                icon: 'error'
            });
        }
    });
});
//Modal Export
$('#ModalExport').on('show.bs.modal', function (e) {
    // Event listener untuk perubahan pada kedua input
    $('#periode_1, #periode_2').on('change', function() {
        validatePeriode();
    });
});
//Format Uang
$('#nominal').keypress(function(event) {
    // Hanya mengizinkan angka (0-9) dan tombol kontrol seperti backspace
    var charCode = (event.which) ? event.which : event.keyCode;
    if (charCode > 31 && (charCode < 48 || charCode > 57)) {
        return false;
    }
    return true;
});
// Memformat input menjadi format uang dengan pemisah ribuan
$('.format_uang').on('input', function() {
    var input = $(this).val();
    // Hapus semua karakter non-digit
    input = input.replace(/[\D\s\._\-]+/g, "");
    if (input) {
        // Format dengan pemisah ribuan
        var formattedInput = parseInt(input, 10).toLocaleString('en-US');
        $(this).val(formattedInput);
    } else {
        $(this).val('');
    }
});

//Fungsi Menampilkan Data Simpanan Wajib
function ShowSimpananWajib() {
    var FilterSimpananWajib = $('#FilterSimpananWajib').serialize();
    $.ajax({
        type    : 'POST',
        url     : '_Page/SimpananAnggota/TabelSimpananWajib.php',
        data    : FilterSimpananWajib,
        success: function(data) {
            $('#TabelSimpananWajib').html(data);
        }
    });
}
//Fungsi Menampilkan Data Simpanan Sukarela
function ShowSimpananSukarela() {
    var FilterSimpananSukarela = $('#FilterSimpananSukarela').serialize();
    $.ajax({
        type    : 'POST',
        url     : '_Page/SimpananAnggota/TabelSimpananSukarela.php',
        data    : FilterSimpananSukarela,
        success: function(data) {
            $('#TabelSimpananSukarela').html(data);
        }
    });
}
$(document).ready(function() {
    ShowSimpananWajib();
    ShowSimpananSukarela();
});

//Modal Form Pembayaran Simpanan
$('#ModalBayarSimpanan').on('show.bs.modal', function (e) {
    var id_simpanan_jenis= $(e.relatedTarget).data('id_simpanan_jenis');
    var id_anggota= $(e.relatedTarget).data('id_anggota');
    $('#FormBayarSimpanan').html("Loading...");
    $('#PetunjukBayarSimpanan').html("");
    $('#NotifikasiBayarSimpanan').html("");
    $.ajax({
        type 	    : 'POST',
        url 	    : '_Page/SimpananAnggota/FormBayarSimpanan.php',
        data        : {id_simpanan_jenis: id_simpanan_jenis, id_anggota: id_anggota},
        success     : function(data){
            $('#FormBayarSimpanan').html(data);
        }
    });
});

//Modal Form Pembayaran Simpanan Wajib
$('#ModalBayarSimpananWajib').on('show.bs.modal', function (e) {
    var id_simpanan_jenis= $(e.relatedTarget).data('id_simpanan_jenis');
    var id_anggota= $(e.relatedTarget).data('id_anggota');
    var periode= $(e.relatedTarget).data('periode');
    $('#FormBayarSimpananWajib').html("Loading...");
    $('#NotifikasiBayarSimpananWajib').html("");
    $.ajax({
        type 	    : 'POST',
        url 	    : '_Page/SimpananAnggota/FormBayarSimpananWajib.php',
        data        : {id_simpanan_jenis: id_simpanan_jenis, id_anggota: id_anggota, periode: periode},
        success     : function(data){
            $('#FormBayarSimpananWajib').html(data);
        }
    });
});

//Proses Simpan Pembayaran
$('#ProsesBayarSimpanan').submit(function(){
    $('#NotifikasiBayarSimpanan').html('<div class="spinner-border text-secondary" role="status"><span class="sr-only"></span></div>');
    var form = $('#ProsesBayarSimpanan')[0];
    var data = new FormData(form);
    $.ajax({
        type 	    : 'POST',
        url 	    : '_Page/SimpananAnggota/ProsesBayarSimpanan.php',
        data 	    :  data,
        cache       : false,
        processData : false,
        contentType : false,
        enctype     : 'multipart/form-data',
        success     : function(data){
            $('#NotifikasiBayarSimpanan').html(data);
            var NotifikasiBayarSimpananBerhasil=$('#NotifikasiBayarSimpananBerhasil').html();
            var get_uuide_simpanan=$('#get_uuide_simpanan').val();
            if(NotifikasiBayarSimpananBerhasil=="Success"){
                window.location.href = 'index.php?Page=SimpananAnggota&Sub=DetailSimpananAnggota&uuid=' + get_uuide_simpanan;
            }
        }
    });
});

//Proses Simpan Pembayaran
$('#ProsesBayarSimpananWajib').submit(function(){
    $('#NotifikasiBayarSimpananWajib').html('<div class="spinner-border text-secondary" role="status"><span class="sr-only"></span></div>');
    var form = $('#ProsesBayarSimpananWajib')[0];
    var data = new FormData(form);
    $.ajax({
        type 	    : 'POST',
        url 	    : '_Page/SimpananAnggota/ProsesBayarSimpananWajib.php',
        data 	    :  data,
        cache       : false,
        processData : false,
        contentType : false,
        enctype     : 'multipart/form-data',
        success     : function(data){
            $('#NotifikasiBayarSimpananWajib').html(data);
            var NotifikasiBayarSimpananWajibBerhasil=$('#NotifikasiBayarSimpananWajibBerhasil').html();
            var get_uuide_simpanan_wajib=$('#get_uuide_simpanan_wajib').val();
            if(NotifikasiBayarSimpananWajibBerhasil=="Success"){
                window.location.href = 'index.php?Page=SimpananAnggota&Sub=DetailSimpananAnggota&uuid=' + get_uuide_simpanan_wajib;
            }
        }
    });
});

//Modal Pembatalan Simpanan
$('#ModalPembatalan').on('show.bs.modal', function (e) {
    var uuid= $(e.relatedTarget).data('id');
    //Empty Notification
    $('#NotifikasiPembatalan').html("");

    //Put uuid
    $('#put_uuid_simpanan').val(uuid);
    
});

//Proses Pembatalan
$('#ProsesPembatalan').submit(function(){
    $('#NotifikasiPembatalan').html('<div class="spinner-border text-secondary" role="status"><span class="sr-only"></span></div>');
    var form = $('#ProsesPembatalan')[0];
    var data = new FormData(form);
    $.ajax({
        type        : 'POST',
        url         : '_Page/SimpananAnggota/ProsesPembatalan.php',
        data        : data,
        cache       : false,
        processData : false,
        contentType : false,
        enctype     : 'multipart/form-data',
        success: function(data){
            $('#NotifikasiPembatalan').html(data);
            var NotifikasiPembatalanBerhasil = $('#NotifikasiPembatalanBerhasil').html();
            if(NotifikasiPembatalanBerhasil=="Success"){
                //tutup modal
                window.location.href = 'index.php?Page=SimpananAnggota';
            }
        }
    });
});

//Merubah Periode Waktu
$(document).on('click', '#PeriodePrev', function() {
    var periode_now = parseInt($('#tahun_simpanan_wajib').val(), 10); // Pastikan nilai diambil sebagai angka
    var next_periode = periode_now - 1;
    $('#tahun_simpanan_wajib').val(next_periode);
    ShowSimpananWajib();
});
$(document).on('click', '#PeriodeNext', function() {
    var periode_now = parseInt($('#tahun_simpanan_wajib').val(), 10); // Pastikan nilai diambil sebagai angka
    var next_periode = periode_now + 1;
    $('#tahun_simpanan_wajib').val(next_periode);
    ShowSimpananWajib();
});

//Ketika Simpanan Sukarela di Change
$('#id_simpanan_jenis_sukarela').change(function(){
    var id_simpanan_jenis =$('#id_simpanan_jenis_sukarela').val();
    $.ajax({
        type 	    : 'POST',
        url 	    : '_Page/SimpananAnggota/FormNominal.php',
        data        : {id_simpanan_jenis: id_simpanan_jenis},
        success     : function(data){
            $('#form_nominal_simpanan_sukarela').html(data);
        }
    });
});

//Proses Simpan Sukarela
$('#ProsesTambahSimpananSukarela').submit(function(){
    $('#NotifikasiTambahSimpananSukarela').html('<div class="spinner-border text-secondary" role="status"><span class="sr-only"></span></div>');
    var form = $('#ProsesTambahSimpananSukarela')[0];
    var data = new FormData(form);
    $.ajax({
        type 	    : 'POST',
        url 	    : '_Page/SimpananAnggota/ProsesTambahSimpananSukarela.php',
        data 	    :  data,
        cache       : false,
        processData : false,
        contentType : false,
        enctype     : 'multipart/form-data',
        success     : function(data){
            $('#NotifikasiTambahSimpananSukarela').html(data);
            var NotifikasiTambahSimpananSukarelaBerhasil=$('#NotifikasiTambahSimpananSukarelaBerhasil').html();
            var get_uuide_simpanan_sukarela=$('#get_uuide_simpanan_sukarela').val();
            if(NotifikasiTambahSimpananSukarelaBerhasil=="Success"){
               window.location.href = 'index.php?Page=SimpananAnggota&Sub=DetailSimpananAnggota&uuid=' + get_uuide_simpanan_sukarela;
            }
        }
    });
});

//Fungsi Menampilkan Data
function filterAndLoadTable() {
    var ProsesFilter = $('#ProsesFilter').serialize();
    $.ajax({
        type: 'POST',
        url: '_Page/RekapSimpanan/TabelRekapSimpanan.php',
        data: ProsesFilter,
        success: function(data) {
            $('#MenampilkanTabelRekapSimpanan').html(data);
        }
    });
}
function filterAndLoadTable2() {
    var ProsesFilterRank = $('#ProsesFilterRank').serialize();
    $.ajax({
        type: 'POST',
        url: '_Page/RekapSimpanan/TabelRekapSimpananRank.php',
        data: ProsesFilterRank,
        success: function(data) {
            $('#MenampilkanTabelRekapSimpananRank').html(data);
        }
    });
}
function filterAndLoadTable3() {
    var ProsesFilterAnggota = $('#ProsesFilterAnggota').serialize();
    $.ajax({
        type: 'POST',
        url: '_Page/RekapSimpanan/TabelRekapSimpananAnggota.php',
        data: ProsesFilterAnggota,
        success: function(data) {
            $('#MenampilkanTabelRekapSimpananAnggota').html(data);
        }
    });
}
function filterAndLoadTable4() {
    var ProsesFilterSimpananNetto = $('#ProsesFilterSimpananNetto').serialize();
    $.ajax({
        type        : 'POST',
        url         : '_Page/RekapSimpanan/TabelRekapSimpananNetto.php',
        data        : ProsesFilterSimpananNetto,
        success: function(data) {
            $('#TabelSimpananNetto').html(data);
        }
    });

    //Menampilkan Judul
    $.ajax({
        type        : 'POST',
        url         : '_Page/RekapSimpanan/TitleRekapSimpananNetto.php',
        data        : ProsesFilterSimpananNetto,
        success: function(data) {
            $('#TitleRekapSimpananNetto').html(data);
        }
    });
}
function toggleFields() {
    var periode = $('#periode').val();
    if (periode === 'Semua') {
        $('#FormTahun').hide();
        $('#FormBulan').hide();
    } else if (periode === 'Tahunan') {
        $('#FormTahun').show();
        $('#FormBulan').hide();
    } else if (periode === 'Bulanan') {
        $('#FormTahun').show();
        $('#FormBulan').show();
    }
}
function toggleFields2() {
    var periode = $('#periode_rank').val();
    if (periode === 'Semua') {
        $('#FormTahunRank').hide();
        $('#FormBulanRank').hide();
    } else if (periode === 'Tahunan') {
        $('#FormTahunRank').show();
        $('#FormBulanRank').hide();
    } else if (periode === 'Bulanan') {
        $('#FormTahunRank').show();
        $('#FormBulanRank').show();
    }
}
function toggleFields3() {
    var periode = $('#periode_anggota').val();
    if (periode === 'Semua') {
        $('#FormTahunAnggota').hide();
        $('#FormBulanAnggota').hide();
    } else if (periode === 'Tahunan') {
        $('#FormTahunAnggota').show();
        $('#FormBulanAnggota').hide();
    } else if (periode === 'Bulanan') {
        $('#FormTahunAnggota').show();
        $('#FormBulanAnggota').show();
    }
}
function toggleFields4() {
    var periode = $('#periode_simpanan_netto').val();
    if (periode === 'Semua') {
        $('#FormTahunSimpananNetto').hide();
        $('#FormBulanSimpananNetto').hide();
    } else if (periode === 'Tahunan') {
        $('#FormTahunSimpananNetto').show();
        $('#FormBulanSimpananNetto').hide();
    } else if (periode === 'Bulanan') {
        $('#FormTahunSimpananNetto').show();
        $('#FormBulanSimpananNetto').show();
    }
}
$(document).ready(function() {
    // filterAndLoadTable();
    // filterAndLoadTable2();
    // filterAndLoadTable3();
    // Panggil fungsi toggleFields saat halaman dimuat
    toggleFields();
    toggleFields2();
    toggleFields3();
    toggleFields4();
    // Panggil fungsi toggleFields saat periode diubah
    $('#periode').change(function() {
        toggleFields();
    });
    $('#periode_rank').change(function() {
        toggleFields2();
    });
    $('#periode_anggota').change(function() {
        toggleFields3();
    });
    $('#periode_simpanan_netto').change(function() {
        toggleFields4();
    });
});
//Proses Filter Lembaga
$('#ProsesFilter').submit(function(){
    $('#MenampilkanTabelRekapSimpanan').html('<div class="spinner-border text-secondary" role="status"><span class="sr-only"></span></div>');
    var form = $('#ProsesFilter')[0];
    var data = new FormData(form);
    $.ajax({
        type 	    : 'POST',
        url 	    : '_Page/RekapSimpanan/TabelRekapSimpanan.php',
        data 	    :  data,
        cache       : false,
        processData : false,
        contentType : false,
        enctype     : 'multipart/form-data',
        success     : function(data){
            $('#MenampilkanTabelRekapSimpanan').html(data);
            $('#ModalFilter').modal('hide');
        }
    });
});
//Proses FilterRank
$('#ProsesFilterRank').submit(function(){
    $('#MenampilkanTabelRekapSimpananRank').html('<div class="spinner-border text-secondary" role="status"><span class="sr-only"></span></div>');
    var form = $('#ProsesFilterRank')[0];
    var data = new FormData(form);
    $.ajax({
        type 	    : 'POST',
        url 	    : '_Page/RekapSimpanan/TabelRekapSimpananRank.php',
        data 	    :  data,
        cache       : false,
        processData : false,
        contentType : false,
        enctype     : 'multipart/form-data',
        success     : function(data){
            $('#MenampilkanTabelRekapSimpananRank').html(data);
            $('#ModalFilterRank').modal('hide');
        }
    });
});
//Proses FilterAnggota
$('#ProsesFilterAnggota').submit(function(){
    $('#MenampilkanTabelRekapSimpananAnggota').html('<div class="spinner-border text-secondary" role="status"><span class="sr-only"></span></div>');
    var form = $('#ProsesFilterAnggota')[0];
    var data = new FormData(form);
    $.ajax({
        type 	    : 'POST',
        url 	    : '_Page/RekapSimpanan/TabelRekapSimpananAnggota.php',
        data 	    :  data,
        cache       : false,
        processData : false,
        contentType : false,
        enctype     : 'multipart/form-data',
        success     : function(data){
            $('#MenampilkanTabelRekapSimpananAnggota').html(data);
            $('#ModalFilterAnggota').modal('hide');
        }
    });
});
//Proses Filter Simpanan Netto
$('#ProsesFilterSimpananNetto').submit(function(){
    $('#put_page_simpanan_netto').val(1);
    $('#ModadlFilterSimpananNetto').modal('hide');
    filterAndLoadTable4();
});
//Pagging Simpanan Netto
$(document).on('click', '#next_button_simpanan_netto', function() {
    var page_now = parseInt($('#put_page_simpanan_netto').val(), 10); // Pastikan nilai diambil sebagai angka
    var next_page = page_now + 1;
    $('#put_page_simpanan_netto').val(next_page);
    filterAndLoadTable4(0);
});
$(document).on('click', '#prev_button_simpanan_netto', function() {
    var page_now = parseInt($('#put_page_simpanan_netto').val(), 10); // Pastikan nilai diambil sebagai angka
    var next_page = page_now - 1;
    $('#put_page_simpanan_netto').val(next_page);
    filterAndLoadTable4();
});

//Modal Cetak Rekap Simpanan
$('#ModalCetak').on('show.bs.modal', function (e) {
    var ProsesFilter = $('#ProsesFilter').serialize();
    $.ajax({
        type: 'POST',
        url: '_Page/RekapSimpanan/FormCetakDataRekap.php',
        data: ProsesFilter,
        success: function(data) {
            $('#FormCetakDataRekap').html(data);
        }
    });
});

//Modal Cetak Rekap Simpanan Rank
$('#ModalCetak2').on('show.bs.modal', function (e) {
    var ProsesFilter = $('#ProsesFilterRank').serialize();
    $.ajax({
        type: 'POST',
        url: '_Page/RekapSimpanan/FormCetakDataRekap2.php',
        data: ProsesFilter,
        success: function(data) {
            $('#FormCetakDataRekap2').html(data);
        }
    });
});

//Modal Cetak Rekap Simpanan Anggota
$('#ModalCetak3').on('show.bs.modal', function (e) {
    var ProsesFilter = $('#ProsesFilterAnggota').serialize();
    $.ajax({
        type: 'POST',
        url: '_Page/RekapSimpanan/FormCetakDataRekap3.php',
        data: ProsesFilter,
        success: function(data) {
            $('#FormCetakDataRekap3').html(data);
        }
    });
});

//Modal Cetak Rekap Simpanan Anggota (NETTO)
$('#ModalCetak4').on('show.bs.modal', function (e) {
    var ProsesFilter = $('#ProsesFilterSimpananNetto').serialize();
    $.ajax({
        type: 'POST',
        url: '_Page/RekapSimpanan/FormCetakDataRekap4.php',
        data: ProsesFilter,
        success: function(data) {
            $('#FormCetakDataRekap4').html(data);
        }
    });
});
//Fungsi Menampilkan Data
function filterAndLoadTable() {
    var ProsesFilter = $('#ProsesFilter').serialize();
    $.ajax({
        type: 'POST',
        url: '_Page/RekapAnggota/TabelRekapAnggota.php',
        data: ProsesFilter,
        success: function(data) {
            $('#MenampilkanTabelRekapAnggota').html(data);
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
$(document).ready(function() {
    filterAndLoadTable();
    // Panggil fungsi toggleFields saat halaman dimuat
    toggleFields();
    // Panggil fungsi toggleFields saat periode diubah
    $('#periode').change(function() {
        toggleFields();
    });
});
//Proses Filter
$('#ProsesFilter').submit(function(){
    $('#MenampilkanTabelRekapAnggota').html('<div class="spinner-border text-secondary" role="status"><span class="sr-only"></span></div>');
    var form = $('#ProsesFilter')[0];
    var data = new FormData(form);
    $.ajax({
        type 	    : 'POST',
        url 	    : '_Page/RekapAnggota/TabelRekapAnggota.php',
        data 	    :  data,
        cache       : false,
        processData : false,
        contentType : false,
        enctype     : 'multipart/form-data',
        success     : function(data){
            $('#MenampilkanTabelRekapAnggota').html(data);
            $('#ModalFilter').modal('hide');
        }
    });
});
//Modal Cetak Rekap Simpanan
$('#ModalCetak').on('show.bs.modal', function (e) {
    var ProsesFilter = $('#ProsesFilter').serialize();
    $.ajax({
        type: 'POST',
        url: '_Page/RekapAnggota/FormCetakDataRekap.php',
        data: ProsesFilter,
        success: function(data) {
            $('#FormCetakDataRekap').html(data);
        }
    });
});
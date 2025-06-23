//Fungsi Menampilkan Data
function filterAndLoadTable() {
    var ProsesFilter = $('#ProsesFilter').serialize();
    $.ajax({
        type: 'POST',
        url: '_Page/AnggotaKeluarMasuk/TabelAnggotaKeluarMasuk.php',
        data: ProsesFilter,
        success: function(data) {
            $('#MenampilkanTabelAnggotaKeluarMasuk').html(data);
        }
    });
}
$(document).ready(function() {
    filterAndLoadTable();
});
$('#ProsesFilter').submit(function(){
    filterAndLoadTable();
    $('#ModalFilter').modal('hide');
});
$('#mode').change(function(){
    var mode = $('#mode').val();
    if(mode=='Harian'){
        $('#FormBulan').show();
    }else{
        $('#FormBulan').hide();
    }
});
//Modal Export
$('#ModalExport').on('show.bs.modal', function (e) {
    var mode =$('#mode').val();
    var tahun =$('#tahun').val();
    var bulan =$('#bulan').val();
    $('#FormExport').html("Loading...");
    $.ajax({
        type 	    : 'POST',
        url 	    : '_Page/AnggotaKeluarMasuk/FormExport.php',
        data        : {mode: mode, tahun: tahun, bulan: bulan},
        success     : function(data){
            $('#FormExport').html(data);
        }
    });
});
//List Anggota Masuk
$('#ModalListAnggotaMasuk').on('show.bs.modal', function (e) {
    var Getdata= $(e.relatedTarget).data('id');
    $('#FormListAnggotaMasuk').html("Loading...");
    $.ajax({
        type 	    : 'POST',
        url 	    : '_Page/AnggotaKeluarMasuk/FormListAnggotaMasuk.php',
        data        : {Getdata: Getdata},
        success     : function(data){
            $('#FormListAnggotaMasuk').html(data);
        }
    });
});
//List Anggota Keluar
$('#ModalListAnggotaKeluar').on('show.bs.modal', function (e) {
    var Getdata= $(e.relatedTarget).data('id');
    $('#FormListAnggotaKeluar').html("Loading...");
    $.ajax({
        type 	    : 'POST',
        url 	    : '_Page/AnggotaKeluarMasuk/FormListAnggotaKeluar.php',
        data        : {Getdata: Getdata},
        success     : function(data){
            $('#FormListAnggotaKeluar').html(data);
        }
    });
});
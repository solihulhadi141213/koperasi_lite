function filterAndLoadTable() {
    var ProsesFilter = $('#ProsesFilter').serialize();
    $.ajax({
        type: 'POST',
        url: '_Page/SimpananWajib/TabelSimpananWajib.php',
        data: ProsesFilter,
        success: function(data) {
            $('#MenampilkanTabelSimpananWajib').html(data);
        }
    });
}
$(document).ready(function() {
    filterAndLoadTable();
});
$('#mode_periode').change(function(){
    var mode_periode = $('#mode_periode').val();
    $.ajax({
        type 	    : 'POST',
        url 	    : '_Page/SimpananWajib/FormTahun.php',
        data 	    :  {mode_periode: mode_periode},
        success     : function(data){
            $('#FormTahun').html(data);
        }
    });
});
$('#keyword_by').change(function(){
    var keyword_by = $('#keyword_by').val();
    $.ajax({
        type 	    : 'POST',
        url 	    : '_Page/SimpananWajib/FormFilter.php',
        data 	    :  {keyword_by: keyword_by},
        success     : function(data){
            $('#FormFilter').html(data);
        }
    });
});
$('#ProsesFilter').submit(function(){
    $('#page').val("1");
    filterAndLoadTable();
    $('#ModalFilter').modal('hide');
});
//Detail Anggota
$('#ModalDetailAnggota').on('show.bs.modal', function (e) {
    var id_anggota= $(e.relatedTarget).data('id');
    $('#FormDetailAnggota').html("Loading...");
    $.ajax({
        type 	    : 'POST',
        url 	    : '_Page/Anggota/FormDetailAnggota.php',
        data        : {id_anggota: id_anggota},
        success     : function(data){
            $('#FormDetailAnggota').html(data);
        }
    });
});
//Modal Tambah Simpanan Wajib
$('#ModalTambahSimpananWajib').on('show.bs.modal', function (e) {
    $('#FormTambahSimpananWajib').html("Loading...");
    $.ajax({
        type 	    : 'POST',
        url 	    : '_Page/SimpananWajib/FormTambahSimpananWajib.php',
        success     : function(data){
            $('#FormTambahSimpananWajib').html(data);
            $('#NotifikasiTambahSimpananWajib').html('');
        }
    });
});
//Proses Tambah Simpanan
$('#ProsesTambahSimpananWajib').submit(function(){
    $('#NotifikasiTambahSimpananWajib').html('<div class="spinner-border text-secondary" role="status"><span class="sr-only"></span></div>');
    var form = $('#ProsesTambahSimpananWajib')[0];
    var data = new FormData(form);
    $.ajax({
        type 	    : 'POST',
        url 	    : '_Page/SimpananWajib/ProsesTambahSimpananWajib.php',
        data 	    :  data,
        cache       : false,
        processData : false,
        contentType : false,
        enctype     : 'multipart/form-data',
        success     : function(data){
            $('#NotifikasiTambahSimpananWajib').html(data);
            $('#page').val("1");
            filterAndLoadTable();
        }
    });
});
//Detail Simpanan Wajib
$('#ModalDetailSimpananWajib').on('show.bs.modal', function (e) {
    var GetData= $(e.relatedTarget).data('id');
    $('#FormDetailSimpananWajib').html("Loading...");
    $.ajax({
        type 	    : 'POST',
        url 	    : '_Page/SimpananWajib/FormDetailSimpananWajib.php',
        data        : {GetData: GetData},
        success     : function(data){
            $('#FormDetailSimpananWajib').html(data);
        }
    });
});
//Edit Simpanan Wajib
$('#ModalEditSimpanan').on('show.bs.modal', function (e) {
    var GetData= $(e.relatedTarget).data('id');
    $('#FormEditSimpanan').html("Loading...");
    $.ajax({
        type 	    : 'POST',
        url 	    : '_Page/SimpananWajib/FormEditSimpanan.php',
        data        : {GetData: GetData},
        success     : function(data){
            $('#FormEditSimpanan').html(data);
        }
    });
});
//Proses Edit Simpanan
$('#ProsesEditSimpanan').submit(function(){
    $('#NotifikasiEditSimpanan').html('Loading...');
    var form = $('#ProsesEditSimpanan')[0];
    var data = new FormData(form);
    $.ajax({
        type 	    : 'POST',
        url 	    : '_Page/SimpananWajib/ProsesEditSimpanan.php',
        data 	    :  data,
        cache       : false,
        processData : false,
        contentType : false,
        enctype     : 'multipart/form-data',
        success     : function(data){
            $('#NotifikasiEditSimpanan').html(data);
            var NotifikasiEditSimpananBerhasil=$('#NotifikasiEditSimpananBerhasil').html();
            if(NotifikasiEditSimpananBerhasil=="Success"){
                $('#NotifikasiEditSimpanan').html('');
                $('#ModalEditSimpanan').modal('hide');
                Swal.fire(
                    'Success!',
                    'Edit Simpanan Berhasil!',
                    'success'
                )
                //Menampilkan Data
                filterAndLoadTable();
            }
        }
    });
});
//Hapus Simpanan Wajib
$('#ModalHapusSimpanan').on('show.bs.modal', function (e) {
    var GetData= $(e.relatedTarget).data('id');
    $('#FormHapusSimpanan').html("Loading...");
    $.ajax({
        type 	    : 'POST',
        url 	    : '_Page/SimpananWajib/FormHapusSimpanan.php',
        data        : {GetData: GetData},
        success     : function(data){
            $('#FormHapusSimpanan').html(data);
        }
    });
});
//Proses Hapus Simpanan
$('#ProsesHapusSimpanan').submit(function(){
    $('#NotifikasiHapusSimpanan').html('Loading...');
    var form = $('#ProsesHapusSimpanan')[0];
    var data = new FormData(form);
    $.ajax({
        type 	    : 'POST',
        url 	    : '_Page/SimpananWajib/ProsesHapusSimpanan.php',
        data 	    :  data,
        cache       : false,
        processData : false,
        contentType : false,
        enctype     : 'multipart/form-data',
        success     : function(data){
            $('#NotifikasiHapusSimpanan').html(data);
            var NotifikasiHapusSimpananBerhasil=$('#NotifikasiHapusSimpananBerhasil').html();
            if(NotifikasiHapusSimpananBerhasil=="Success"){
                $('#NotifikasiHapusSimpanan').html('');
                $('#ModalHapusSimpanan').modal('hide');
                Swal.fire(
                    'Success!',
                    'Hapus Simpanan Berhasil!',
                    'success'
                )
                //Menampilkan Data
                filterAndLoadTable();
            }
        }
    });
});
//Export Simpanan Wajib
$('#ModalExport').on('show.bs.modal', function (e) {
    var ProsesFilter = $('#ProsesFilter').serialize();
    $.ajax({
        type: 'POST',
        url: '_Page/SimpananWajib/FormExport.php',
        data: ProsesFilter,
        success: function(data) {
            $('#FormExport').html(data);
        }
    });
});
//Form Tambah Simpanan Wajib Parsial
$('#ModalTambahSimpananWajibParsial').on('show.bs.modal', function (e) {
    var GetData= $(e.relatedTarget).data('id');
    $('#FormTambahSimpananWajibParsial').html("Loading...");
    $('#NotifikasiTambahSimpananWajibParsial').html("");
    $.ajax({
        type 	    : 'POST',
        url 	    : '_Page/SimpananWajib/FormTambahSimpananWajibParsial.php',
        data        : {GetData: GetData},
        success     : function(data){
            $('#FormTambahSimpananWajibParsial').html(data);
        }
    });
});
//Proses Tambah Simpanan Parsial
$('#ProsesTambahSimpananWajibParsial').submit(function(){
    $('#NotifikasiTambahSimpananWajibParsial').html('Loading...');
    var form = $('#ProsesTambahSimpananWajibParsial')[0];
    var data = new FormData(form);
    $.ajax({
        type 	    : 'POST',
        url 	    : '_Page/SimpananWajib/ProsesTambahSimpananWajibParsial.php',
        data 	    :  data,
        cache       : false,
        processData : false,
        contentType : false,
        enctype     : 'multipart/form-data',
        success     : function(data){
            $('#NotifikasiTambahSimpananWajibParsial').html(data);
            var NotifikasiTambahSimpananWajibParsialBerhasil=$('#NotifikasiTambahSimpananWajibParsialBerhasil').html();
            if(NotifikasiTambahSimpananWajibParsialBerhasil=="Success"){
                $('#NotifikasiTambahSimpananWajibParsial').html('');
                $('#ModalTambahSimpananWajibParsial').modal('hide');
                Swal.fire(
                    'Success!',
                    'Tambah Simpanan Wajib Berhasil!',
                    'success'
                )
                //Menampilkan Data
                filterAndLoadTable();
            }
        }
    });
});
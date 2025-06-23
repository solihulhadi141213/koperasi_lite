function filterAndLoadTable() {
    var ProsesFilter = $('#ProsesFilter').serialize();
    $.ajax({
        type: 'POST',
        url: '_Page/JenisTransaksi/TabelJenisTransaksi.php',
        data: ProsesFilter,
        success: function(data) {
            $('#MenampilkanTabelJenisTransaksi').html(data);
        }
    });
}
$(document).ready(function() {
    filterAndLoadTable();
});
$('#keyword_by').change(function(){
    var keyword_by = $('#keyword_by').val();
    $.ajax({
        type 	    : 'POST',
        url 	    : '_Page/JenisTransaksi/FormFilter.php',
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
//Proses Tambah Jenis Transaksi
$('#ProsesTambahJenisTransaksi').submit(function(){
    $('#NotifikasiTambahJenisTransaksi').html('<div class="spinner-border text-secondary" role="status"><span class="sr-only"></span></div>');
    var form = $('#ProsesTambahJenisTransaksi')[0];
    var data = new FormData(form);
    $.ajax({
        type 	    : 'POST',
        url 	    : '_Page/JenisTransaksi/ProsesTambahJenisTransaksi.php',
        data 	    :  data,
        cache       : false,
        processData : false,
        contentType : false,
        enctype     : 'multipart/form-data',
        success     : function(data){
            $('#NotifikasiTambahJenisTransaksi').html(data);
            var NotifikasiTambahJenisTransaksiBerhasil=$('#NotifikasiTambahJenisTransaksiBerhasil').html();
            if(NotifikasiTambahJenisTransaksiBerhasil=="Success"){
                $('#NotifikasiTambahJenisTransaksi').html('');
                $('#page').val("1");
                $("#ProsesFilter")[0].reset();
                $("#ProsesTambahJenisTransaksi")[0].reset();
                $('#ModalTambahJenisTransaksi').modal('hide');
                Swal.fire(
                    'Success!',
                    'Tambah Jenis Transaksi Berhasil!',
                    'success'
                )
                //Menampilkan Data
                filterAndLoadTable();
            }
        }
    });
});
//Detail Jenis Transaksi
$('#ModalDetail').on('show.bs.modal', function (e) {
    var id_transaksi_jenis= $(e.relatedTarget).data('id');
    $('#FormDetail').html("Loading...");
    $.ajax({
        type 	    : 'POST',
        url 	    : '_Page/JenisTransaksi/FormDetail.php',
        data        : {id_transaksi_jenis: id_transaksi_jenis},
        success     : function(data){
            $('#FormDetail').html(data);
        }
    });
});
//Modal Edit
$('#ModalEdit').on('show.bs.modal', function (e) {
    var id_transaksi_jenis= $(e.relatedTarget).data('id');
    $('#FormEdit').html("Loading...");
    $.ajax({
        type 	    : 'POST',
        url 	    : '_Page/JenisTransaksi/FormEdit.php',
        data        : {id_transaksi_jenis: id_transaksi_jenis},
        success     : function(data){
            $('#FormEdit').html(data);
            $('#NotifikasiEdit').html('');
        }
    });
});
//Proses Edit Anggota
$('#ProsesEdit').submit(function(){
    $('#NotifiasiEdit').html('<div class="spinner-border text-secondary" role="status"><span class="sr-only"></span></div>');
    var form = $('#ProsesEdit')[0];
    var data = new FormData(form);
    $.ajax({
        type 	    : 'POST',
        url 	    : '_Page/JenisTransaksi/ProsesEdit.php',
        data 	    :  data,
        cache       : false,
        processData : false,
        contentType : false,
        enctype     : 'multipart/form-data',
        success     : function(data){
            $('#NotifiasiEdit').html(data);
            var NotifiasiEditBerhasil=$('#NotifiasiEditBerhasil').html();
            if(NotifiasiEditBerhasil=="Success"){
                $('#NotifiasiEdit').html('');
                $('#ModalEdit').modal('hide');
                Swal.fire(
                    'Success!',
                    'Edit Jenis Transaksi Berhasil!',
                    'success'
                )
                //Menampilkan Data
                filterAndLoadTable();
            }
        }
    });
});
//Modal Hapus Anggota
$('#ModalHapus').on('show.bs.modal', function (e) {
    var id_transaksi_jenis= $(e.relatedTarget).data('id');
    $('#FormHapus').html("Loading...");
    $.ajax({
        type 	    : 'POST',
        url 	    : '_Page/JenisTransaksi/FormHapus.php',
        data        : {id_transaksi_jenis: id_transaksi_jenis},
        success     : function(data){
            $('#FormHapus').html(data);
            $('#NotifikasiHapus').html('');
        }
    });
});
//Proses Hapus Jenis Transaksi
$('#ProsesHapus').submit(function(){
    $('#NotifikasiHapus').html('<div class="spinner-border text-secondary" role="status"><span class="sr-only"></span></div>');
    var form = $('#ProsesHapus')[0];
    var data = new FormData(form);
    $.ajax({
        type 	    : 'POST',
        url 	    : '_Page/JenisTransaksi/ProsesHapus.php',
        data 	    :  data,
        cache       : false,
        processData : false,
        contentType : false,
        enctype     : 'multipart/form-data',
        success     : function(data){
            $('#NotifikasiHapus').html(data);
            var NotifikasiHapusBerhasil=$('#NotifikasiHapusBerhasil').html();
            if(NotifikasiHapusBerhasil=="Success"){
                $('#NotifikasiHapus').html('');
                $('#ModalHapus').modal('hide');
                Swal.fire(
                    'Success!',
                    'Hapus Jenis Transaksi Berhasil!',
                    'success'
                )
                //Menampilkan Data
                filterAndLoadTable();
            }
        }
    });
});
function filterAndLoadTable() {
    var ProsesFilter = $('#ProsesFilter').serialize();
    $.ajax({
        type: 'POST',
        url: '_Page/Pinjaman/TabelPinjaman.php',
        data: ProsesFilter,
        success: function(data) {
            $('#MenampilkanTabelPinjaman').html(data);
        }
    });
}
function showListAnggota() {
    var ProsesCariAnggota = $('#ProsesCariAnggota').serialize();
    $('#MenampilkanListAnggota').html('Loading...');
    $.ajax({
        type 	    : 'POST',
        url 	    : '_Page/Pinjaman/TabelAnggota.php',
        data 	    :  ProsesCariAnggota,
        success     : function(data){
            $('#MenampilkanListAnggota').html(data);
        }
    });
}
function ShowDetailPinjaman() {
    var id_pinjaman = $('#GetIdPinjaman').val();
    $.ajax({
        type    : 'POST',
        url     : '_Page/Pinjaman/CardDetailPinjaman.php',
        data    : {id_pinjaman: id_pinjaman},
        success: function(data) {
            $('#MenampilkanDetailPinjaman').html(data);
        }
    });
}
function ShowDetailAngsuran() {
    var id_pinjaman = $('#GetIdPinjaman').val();
    $.ajax({
        type    : 'POST',
        url     : '_Page/Pinjaman/CardDetailAngsuran.php',
        data    : {id_pinjaman: id_pinjaman},
        success: function(data) {
            $('#MenampilkanAngsuranPinjaman').html(data);
        }
    });
}
function ShowDetailJurnal() {
    var id_pinjaman = $('#GetIdPinjaman').val();
    $.ajax({
        type    : 'POST',
        url     : '_Page/Pinjaman/CardDetailJurnal.php',
        data    : {id_pinjaman: id_pinjaman},
        success: function(data) {
            $('#MenampilkanJurnalPinjaman').html(data);
        }
    });
}
function ShowDetailJurnalAngsuran() {
    var id_angsuran = $('#GetIdAngsuran').val();
    $.ajax({
        type    : 'POST',
        url     : '_Page/Pinjaman/CardDetailJurnalAngsuran.php',
        data    : {id_angsuran: id_angsuran},
        success: function(data) {
            $('#MenampilkanTabelJurnalAngsuran').html(data);
        }
    });
}
$(document).ready(function() {
    filterAndLoadTable();
    showListAnggota();
    ShowDetailPinjaman();
    ShowDetailAngsuran();
    ShowDetailJurnal();
    ShowDetailJurnalAngsuran();
});
$('#keyword_by').change(function(){
    var keyword_by = $('#keyword_by').val();
    $.ajax({
        type 	    : 'POST',
        url 	    : '_Page/Pinjaman/FormFilter.php',
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
$('#ProsesCariAnggota').submit(function(){
    showListAnggota();
});
//Modal Auto Jurnal
$('#ModalAutoJurnal').on('show.bs.modal', function (e) {
    $('#FormSimpanAutoJurnal').html("Loading...");
    $.ajax({
        type 	    : 'POST',
        url 	    : '_Page/Pinjaman/FormSimpanAutoJurnal.php',
        success     : function(data){
            $('#FormSimpanAutoJurnal').html(data);
            $('#NotifikasiSimpanAutoJurnal').html('');
        }
    });
});
//Proses Simpan Auto Jurnal
$('#ProsesSimpanAutoJurnal').submit(function(){
    $('#NotifikasiSimpanAutoJurnal').html('<div class="spinner-border text-secondary" role="status"><span class="sr-only"></span></div>');
    var form = $('#ProsesSimpanAutoJurnal')[0];
    var data = new FormData(form);
    $.ajax({
        type 	    : 'POST',
        url 	    : '_Page/Pinjaman/ProsesSimpanAutoJurnal.php',
        data 	    :  data,
        cache       : false,
        processData : false,
        contentType : false,
        enctype     : 'multipart/form-data',
        success     : function(data){
            $('#NotifikasiSimpanAutoJurnal').html(data);
            var NotifikasiSimpanAutoJurnalBerhasil=$('#NotifikasiSimpanAutoJurnalBerhasil').html();
            if(NotifikasiSimpanAutoJurnalBerhasil=="Success"){
                $('#NotifikasiSimpanAutoJurnal').html('');
                $('#ModalAutoJurnal').modal('hide');
                Swal.fire(
                    'Success!',
                    'Pengaturan Auto Jurnal Berhasil!',
                    'success'
                )
            }
        }
    });
});
//Tambah Pinjaman
$('#ModalTambahPinjaman').on('show.bs.modal', function (e) {
    var id_anggota= $(e.relatedTarget).data('id');
    $('#FormTambahPinjaman').html("Loading...");
    $.ajax({
        type 	    : 'POST',
        url 	    : '_Page/Pinjaman/FormTambahPinjaman.php',
        data        : {id_anggota: id_anggota},
        success     : function(data){
            $('#FormTambahPinjaman').html(data);
        }
    });
});
$('#HitungSimulasi').click(function(){
    //menangkap data-id
    $(this).data('id', 'Hide');
    var form = $('#ProsesTambahPinjaman')[0];
    var data = new FormData(form);
    $.ajax({
        type 	    : 'POST',
        url 	    : '_Page/Pinjaman/SimulasiPinjaman.php',
        data 	    :  data,
        cache       : false,
        processData : false,
        contentType : false,
        enctype     : 'multipart/form-data',
        success     : function(data){
            $('#SimulasiPinjaman').html(data);
        }
    });
});
//Proses Tambah Pinjaman
$('#ProsesTambahPinjaman').submit(function(){
    $('#NotifikasiTambahPinjaman').html('<div class="spinner-border text-secondary" role="status"><span class="sr-only"></span></div>');
    var form = $('#ProsesTambahPinjaman')[0];
    var data = new FormData(form);
    $.ajax({
        type 	    : 'POST',
        url 	    : '_Page/Pinjaman/ProsesTambahPinjaman.php',
        data 	    :  data,
        cache       : false,
        processData : false,
        contentType : false,
        enctype     : 'multipart/form-data',
        success     : function(data){
            $('#NotifikasiTambahPinjaman').html(data);
            var NotifikasiTambahPinjamanBerhasil=$('#NotifikasiTambahPinjamanBerhasil').html();
            if(NotifikasiTambahPinjamanBerhasil=="Success"){
                $('#NotifikasiTambahPinjaman').html('');
                $('#ModalTambahPinjaman').modal('hide');
                $('#page').val("1");
                Swal.fire(
                    'Success!',
                    'Tambah Pinjaman Berhasil!',
                    'success'
                )
                //Menampilkan Data
                filterAndLoadTable();
            }
        }
    });
});
//Detail Pinjaman
$('#ModalDetailPinjaman').on('show.bs.modal', function (e) {
    var id_pinjaman= $(e.relatedTarget).data('id');
    $('#FormDetailPinjaman').html("Loading...");
    $.ajax({
        type 	    : 'POST',
        url 	    : '_Page/Pinjaman/FormDetailPinjaman.php',
        data        : {id_pinjaman: id_pinjaman},
        success     : function(data){
            $('#FormDetailPinjaman').html(data);
        }
    });
});
//Edit Pinjaman
$('#ModalEditPinjamanAnggota').on('show.bs.modal', function (e) {
    var id_pinjaman= $(e.relatedTarget).data('id');
    $('#FormEditPinjaman').html("Loading...");
    $.ajax({
        type 	    : 'POST',
        url 	    : '_Page/Pinjaman/FormEditPinjaman.php',
        data        : {id_pinjaman: id_pinjaman},
        success     : function(data){
            $('#FormEditPinjaman').html(data);
            $('#NotifikasiEditPinjaman').html("");
        }
    });
});
//Proses Edit Pinjaman
$('#ProsesEditPinjaman').submit(function(){
    $('#NotifikasiEditPinjaman').html('<div class="spinner-border text-secondary" role="status"><span class="sr-only"></span></div>');
    var form = $('#ProsesEditPinjaman')[0];
    var data = new FormData(form);
    $.ajax({
        type 	    : 'POST',
        url 	    : '_Page/Pinjaman/ProsesEditPinjaman.php',
        data 	    :  data,
        cache       : false,
        processData : false,
        contentType : false,
        enctype     : 'multipart/form-data',
        success     : function(data){
            $('#NotifikasiEditPinjaman').html(data);
            var NotifikasiEditPinjamanBerhasil=$('#NotifikasiEditPinjamanBerhasil').html();
            if(NotifikasiEditPinjamanBerhasil=="Success"){
                $('#NotifikasiEditPinjaman').html('');
                $('#ModalEditPinjamanAnggota').modal('hide');
                Swal.fire(
                    'Success!',
                    'Edit Pinjaman Berhasil!',
                    'success'
                )
                //Menampilkan Data
                filterAndLoadTable();
            }
        }
    });
});
//Hapus Pinjaman
$('#ModalHapusPinjaman').on('show.bs.modal', function (e) {
    var id_pinjaman= $(e.relatedTarget).data('id');
    $('#FormHapusPinjaman').html("Loading...");
    $.ajax({
        type 	    : 'POST',
        url 	    : '_Page/Pinjaman/FormHapusPinjaman.php',
        data        : {id_pinjaman: id_pinjaman},
        success     : function(data){
            $('#FormHapusPinjaman').html(data);
            $('#NotifikasiHapusPinjaman').html("");
        }
    });
});
//Proses Hapus Pinjaman
$('#ProsesHapusPinjaman').submit(function(){
    $('#NotifikasiHapusPinjaman').html('<div class="spinner-border text-secondary" role="status"><span class="sr-only"></span></div>');
    var form = $('#ProsesHapusPinjaman')[0];
    var data = new FormData(form);
    $.ajax({
        type 	    : 'POST',
        url 	    : '_Page/Pinjaman/ProsesHapusPinjaman.php',
        data 	    :  data,
        cache       : false,
        processData : false,
        contentType : false,
        enctype     : 'multipart/form-data',
        success     : function(data){
            $('#NotifikasiHapusPinjaman').html(data);
            var NotifikasiHapusPinjamanBerhasil=$('#NotifikasiHapusPinjamanBerhasil').html();
            if(NotifikasiHapusPinjamanBerhasil=="Success"){
                $('#NotifikasiHapusPinjaman').html('');
                $('#ModalHapusPinjaman').modal('hide');
                Swal.fire(
                    'Success!',
                    'Hapus Pinjaman Berhasil!',
                    'success'
                )
                //Menampilkan Data
                filterAndLoadTable();
            }
        }
    });
});
//Menampilkan Form Angsuran
$('#ModalTambahAngsuran').on('show.bs.modal', function (e) {
    var GetData = $(e.relatedTarget).data('id');
    $('#FormTambahAngsuran').html("Loading...");
    $.ajax({
        type 	    : 'POST',
        url 	    : '_Page/Pinjaman/FormTambahAngsuran.php',
        data        : {GetData: GetData},
        success     : function(data){
            $('#FormTambahAngsuran').html(data);
            $('#NotifikasiTambahAngsuran').html('');
        }
    });
});
//Proses Simpan Angsuran
$('#ProsesTambahAngsuran').submit(function(){
    $('#NotifikasiTambahAngsuran').html('Loading...');
    var form = $('#ProsesTambahAngsuran')[0];
    var data = new FormData(form);
    $.ajax({
        type 	    : 'POST',
        url 	    : '_Page/Pinjaman/ProsesTambahAngsuran.php',
        data 	    :  data,
        cache       : false,
        processData : false,
        contentType : false,
        enctype     : 'multipart/form-data',
        success     : function(data){
            $('#NotifikasiTambahAngsuran').html(data);
            var NotifikasiTambahAngsuranBerhasil=$('#NotifikasiTambahAngsuranBerhasil').html();
            if(NotifikasiTambahAngsuranBerhasil=="Success"){
                $('#NotifikasiTambahAngsuran').html('');
                $('#ModalTambahAngsuran').modal('hide');
                Swal.fire(
                    'Success!',
                    'Tambah Angsuran Berhasil!',
                    'success'
                )
                //Menampilkan Data
                ShowDetailPinjaman();
                ShowDetailAngsuran();
            }
        }
    });
});
//Menampilkan Form Detail Angsuran
$('#ModalDetailPinjamanAngsuran').on('show.bs.modal', function (e) {
    var id_pinjaman_angsuran = $(e.relatedTarget).data('id');
    $('#FormDetailPinjamanAngsuran').html("Loading...");
    $.ajax({
        type 	    : 'POST',
        url 	    : '_Page/Pinjaman/FormDetailAngsuran.php',
        data        : {id_pinjaman_angsuran: id_pinjaman_angsuran},
        success     : function(data){
            $('#FormDetailPinjamanAngsuran').html(data);
        }
    });
});
//Menampilkan Form Hapus Angsuran
$('#ModalHapusPinjamanAngsuran').on('show.bs.modal', function (e) {
    var id_pinjaman_angsuran = $(e.relatedTarget).data('id');
    $('#FormHapusAngsuran').html("Loading...");
    $.ajax({
        type 	    : 'POST',
        url 	    : '_Page/Pinjaman/FormHapusAngsuran.php',
        data        : {id_pinjaman_angsuran: id_pinjaman_angsuran},
        success     : function(data){
            $('#FormHapusAngsuran').html(data);
            $('#NotifikasiHapusAngsuran').html('');
        }
    });
});
//Proses Simpan Angsuran
$('#ProsesHapusAngsuran').submit(function(){
    $('#NotifikasiHapusAngsuran').html('Loading...');
    var form = $('#ProsesHapusAngsuran')[0];
    var data = new FormData(form);
    $.ajax({
        type 	    : 'POST',
        url 	    : '_Page/Pinjaman/ProsesHapusAngsuran.php',
        data 	    :  data,
        cache       : false,
        processData : false,
        contentType : false,
        enctype     : 'multipart/form-data',
        success     : function(data){
            $('#NotifikasiHapusAngsuran').html(data);
            var NotifikasiHapusAngsuranBerhasil=$('#NotifikasiHapusAngsuranBerhasil').html();
            if(NotifikasiHapusAngsuranBerhasil=="Success"){
                $('#NotifikasiHapusAngsuran').html('');
                $('#ModalHapusPinjamanAngsuran').modal('hide');
                Swal.fire(
                    'Success!',
                    'Hapus Angsuran Berhasil!',
                    'success'
                )
                //Menampilkan Data
                ShowDetailAngsuran();
            }
        }
    });
});
//Menampilkan Form Cetak Bukti Angsuran
$('#ModalCetakBuktiAngsuran').on('show.bs.modal', function (e) {
    var id_pinjaman_angsuran = $(e.relatedTarget).data('id');
    $('#FormCetakBuktiAngsuran').html("Loading...");
    $.ajax({
        type 	    : 'POST',
        url 	    : '_Page/Pinjaman/FormCetakBuktiAngsuran.php',
        data        : {id_pinjaman_angsuran: id_pinjaman_angsuran},
        success     : function(data){
            $('#FormCetakBuktiAngsuran').html(data);
        }
    });
});
//Menampilkan Form Export Angsuran
$('#ModalExportAngsuran').on('show.bs.modal', function (e) {
    var id_pinjaman = $(e.relatedTarget).data('id');
    $('#FormExportAngsuran').html("Loading...");
    $.ajax({
        type 	    : 'POST',
        url 	    : '_Page/Pinjaman/FormExportAngsuran.php',
        data        : {id_pinjaman: id_pinjaman},
        success     : function(data){
            $('#FormExportAngsuran').html(data);
        }
    });
});
//Modal Tambah Jurnal Pinjaman
$('#ModalTambahJurnalPinjaman').on('show.bs.modal', function (e) {
    var id_pinjaman = $(e.relatedTarget).data('id');
    $('#FormTambahJurnalPinjaman').html("Loading...");
    $.ajax({
        type 	    : 'POST',
        url 	    : '_Page/Pinjaman/FormTambahJurnalPinjaman.php',
        data        : {id_pinjaman: id_pinjaman},
        success     : function(data){
            $('#FormTambahJurnalPinjaman').html(data);
            $('#NotifikasiTambahJurnalPinjaman').html("");
        }
    });
});
//Proses Tambah Jurnal Pinjaman
$('#ProsesTambahJurnalPinjaman').submit(function(){
    $('#NotifikasiTambahJurnalPinjaman').html('Loading...');
    var form = $('#ProsesTambahJurnalPinjaman')[0];
    var data = new FormData(form);
    $.ajax({
        type 	    : 'POST',
        url 	    : '_Page/Pinjaman/ProsesTambahJurnalPinjaman.php',
        data 	    :  data,
        cache       : false,
        processData : false,
        contentType : false,
        enctype     : 'multipart/form-data',
        success     : function(data){
            $('#NotifikasiTambahJurnalPinjaman').html(data);
            var NotifikasiTambahJurnalPinjamanBerhasil=$('#NotifikasiTambahJurnalPinjamanBerhasil').html();
            if(NotifikasiTambahJurnalPinjamanBerhasil=="Success"){
                $('#NotifikasiTambahJurnalPinjaman').html('');
                $('#ModalTambahJurnalPinjaman').modal('hide');
                Swal.fire(
                    'Success!',
                    'Tambah Jurnal Pinjaman Berhasil!',
                    'success'
                )
                //Menampilkan Data
                ShowDetailPinjaman();
                ShowDetailJurnal();
            }
        }
    });
});
//Modal Edit Jurnal Pinjaman
$('#ModalEditJurnalPinjaman').on('show.bs.modal', function (e) {
    var id_jurnal = $(e.relatedTarget).data('id');
    $('#FormEditJurnalPinjaman').html("Loading...");
    $.ajax({
        type 	    : 'POST',
        url 	    : '_Page/Pinjaman/FormEditJurnalPinjaman.php',
        data        : {id_jurnal: id_jurnal},
        success     : function(data){
            $('#FormEditJurnalPinjaman').html(data);
            $('#NotifikasiEditJurnalPinjaman').html("");
        }
    });
});
//Proses Edit Jurnal Pinjaman
$('#ProsesEditJurnalPinjaman').submit(function(){
    $('#NotifikasiEditJurnalPinjaman').html('Loading...');
    var form = $('#ProsesEditJurnalPinjaman')[0];
    var data = new FormData(form);
    $.ajax({
        type 	    : 'POST',
        url 	    : '_Page/Pinjaman/ProsesEditJurnalPinjaman.php',
        data 	    :  data,
        cache       : false,
        processData : false,
        contentType : false,
        enctype     : 'multipart/form-data',
        success     : function(data){
            $('#NotifikasiEditJurnalPinjaman').html(data);
            var NotifikasiEditJurnalPinjamanBerhasil=$('#NotifikasiEditJurnalPinjamanBerhasil').html();
            if(NotifikasiEditJurnalPinjamanBerhasil=="Success"){
                $('#NotifikasiEditJurnalPinjaman').html('');
                $('#ModalEditJurnalPinjaman').modal('hide');
                Swal.fire(
                    'Success!',
                    'Edit Jurnal Pinjaman Berhasil!',
                    'success'
                )
                //Menampilkan Data
                ShowDetailPinjaman();
                ShowDetailJurnal();
            }
        }
    });
});
//Modal Hhapus Jurnal Pinjaman
$('#ModalHapusJurnalPinjaman').on('show.bs.modal', function (e) {
    var id_jurnal = $(e.relatedTarget).data('id');
    $('#FormHapusJurnalPinjaman').html("Loading...");
    $.ajax({
        type 	    : 'POST',
        url 	    : '_Page/Pinjaman/FormHapusJurnalPinjaman.php',
        data        : {id_jurnal: id_jurnal},
        success     : function(data){
            $('#FormHapusJurnalPinjaman').html(data);
            $('#NotifikasiHapusJurnalPinjaman').html("");
        }
    });
});
//Proses Hapus Jurnal Pinjaman
$('#ProsesHapusJurnalPinjaman').submit(function(){
    $('#NotifikasiHapusJurnalPinjaman').html('Loading...');
    var form = $('#ProsesHapusJurnalPinjaman')[0];
    var data = new FormData(form);
    $.ajax({
        type 	    : 'POST',
        url 	    : '_Page/Pinjaman/ProsesHapusJurnalPinjaman.php',
        data 	    :  data,
        cache       : false,
        processData : false,
        contentType : false,
        enctype     : 'multipart/form-data',
        success     : function(data){
            $('#NotifikasiHapusJurnalPinjaman').html(data);
            var NotifikasiHapusJurnalPinjamanBerhasil=$('#NotifikasiHapusJurnalPinjamanBerhasil').html();
            if(NotifikasiHapusJurnalPinjamanBerhasil=="Success"){
                $('#NotifikasiHapusJurnalPinjaman').html('');
                $('#ModalHapusJurnalPinjaman').modal('hide');
                Swal.fire(
                    'Success!',
                    'Hapus Jurnal Pinjaman Berhasil!',
                    'success'
                )
                //Menampilkan Data
                ShowDetailPinjaman();
                ShowDetailJurnal();
            }
        }
    });
});
//Ketika Jurnal Dipilih
$('#JurnalPinjaman').click(function(){
    $('#DetailPinjamanLainnya').html('<div class="spinner-border text-secondary" role="status"><span class="sr-only"></span></div>');
    $.ajax({
        type 	    : 'POST',
        url 	    : '_Page/Pinjaman/JurnalPinjaman.php',
        data 	    :  {GetIdPinjaman: GetIdPinjaman},
        enctype     : 'multipart/form-data',
        success     : function(data){
            $('#DetailPinjamanLainnya').html(data);
            $('#AngsuranPinjaman').removeClass('bg-info text-light');
            $('#JurnalPinjaman').addClass('bg-info text-light');
            $('#SimulasiPinjaman').removeClass('bg-info text-light');
            //Menampilkan Tabel Angsuran Berdasarkan GetIdPinjaman
            $('#MenampilkanTabelJurnal').html('Loading..');
            $.ajax({
                type 	    : 'POST',
                url 	    : '_Page/Pinjaman/TabelJurnal.php',
                data 	    :  {GetIdPinjaman: GetIdPinjaman},
                enctype     : 'multipart/form-data',
                success     : function(data){
                    $('#MenampilkanTabelJurnal').html(data);
                }
            });
        }
    });
});
//Modal Tambah Jurnal Angsuran
$('#ModalTambahJurnalAngsuran').on('show.bs.modal', function (e) {
    var id_pinjaman_angsuran = $(e.relatedTarget).data('id');
    $('#FormTambahJurnalAngsuran').html("Loading...");
    $.ajax({
        type 	    : 'POST',
        url 	    : '_Page/Pinjaman/FormTambahJurnalAngsuran.php',
        data        : {id_pinjaman_angsuran: id_pinjaman_angsuran},
        success     : function(data){
            $('#FormTambahJurnalAngsuran').html(data);
            $('#NotifikasiTambahJurnalAngsuran').html("");
        }
    });
});
//Proses Tambah Jurnal Angsuran
$('#ProsesTambahJurnalAngsuran').submit(function(){
    $('#NotifikasiTambahJurnalAngsuran').html('Loading...');
    var form = $('#ProsesTambahJurnalAngsuran')[0];
    var data = new FormData(form);
    $.ajax({
        type 	    : 'POST',
        url 	    : '_Page/Pinjaman/ProsesTambahJurnalAngsuran.php',
        data 	    :  data,
        cache       : false,
        processData : false,
        contentType : false,
        enctype     : 'multipart/form-data',
        success     : function(data){
            $('#NotifikasiTambahJurnalAngsuran').html(data);
            var NotifikasiTambahJurnalAngsuranBerhasil=$('#NotifikasiTambahJurnalAngsuranBerhasil').html();
            if(NotifikasiTambahJurnalAngsuranBerhasil=="Success"){
                $('#NotifikasiTambahJurnalAngsuran').html('');
                $('#ModalTambahJurnalAngsuran').modal('hide');
                Swal.fire(
                    'Success!',
                    'Tambah Jurnal Angsuran Berhasil!',
                    'success'
                )
                //Menampilkan Data
                ShowDetailJurnalAngsuran();
            }
        }
    });
});
//Modal Edit Jurnal Angsuran
$('#ModalEditJurnalAngsuran').on('show.bs.modal', function (e) {
    var id_jurnal = $(e.relatedTarget).data('id');
    $('#FormEditJurnalAngsuran').html("Loading...");
    $.ajax({
        type 	    : 'POST',
        url 	    : '_Page/Pinjaman/FormEditJurnalAngsuran.php',
        data        : {id_jurnal: id_jurnal},
        success     : function(data){
            $('#FormEditJurnalAngsuran').html(data);
            $('#NotifikasiEditJurnalAngsuran').html("");
        }
    });
});
//Proses Tambah Jurnal Angsuran
$('#ProsesEditJurnalAngsuran').submit(function(){
    $('#NotifikasiEditJurnalAngsuran').html('Loading...');
    var form = $('#ProsesEditJurnalAngsuran')[0];
    var data = new FormData(form);
    $.ajax({
        type 	    : 'POST',
        url 	    : '_Page/Pinjaman/ProsesEditJurnalAngsuran.php',
        data 	    :  data,
        cache       : false,
        processData : false,
        contentType : false,
        enctype     : 'multipart/form-data',
        success     : function(data){
            $('#NotifikasiEditJurnalAngsuran').html(data);
            var NotifikasiEditJurnalAngsuranBerhasil=$('#NotifikasiEditJurnalAngsuranBerhasil').html();
            if(NotifikasiEditJurnalAngsuranBerhasil=="Success"){
                $('#NotifikasiEditJurnalAngsuran').html('');
                $('#ModalEditJurnalAngsuran').modal('hide');
                Swal.fire(
                    'Success!',
                    'Edit Jurnal Angsuran Berhasil!',
                    'success'
                )
                //Menampilkan Data
                ShowDetailJurnalAngsuran();
            }
        }
    });
});
//Modal Hhapus Jurnal Angsuran
$('#ModalHapusJurnalAngsuran').on('show.bs.modal', function (e) {
    var id_jurnal = $(e.relatedTarget).data('id');
    $('#FormHapusJurnalAngsuran').html("Loading...");
    $.ajax({
        type 	    : 'POST',
        url 	    : '_Page/Pinjaman/FormHapusJurnalAngsuran.php',
        data        : {id_jurnal: id_jurnal},
        success     : function(data){
            $('#FormHapusJurnalAngsuran').html(data);
            $('#NotifikasiHapusJurnalAngsuran').html("");
        }
    });
});
//Proses Hapus Jurnal Pinjaman
$('#ProsesHapusJurnalAngsuran').submit(function(){
    $('#NotifikasiHapusJurnalAngsuran').html('Loading...');
    var form = $('#ProsesHapusJurnalAngsuran')[0];
    var data = new FormData(form);
    $.ajax({
        type 	    : 'POST',
        url 	    : '_Page/Pinjaman/ProsesHapusJurnalAngsuran.php',
        data 	    :  data,
        cache       : false,
        processData : false,
        contentType : false,
        enctype     : 'multipart/form-data',
        success     : function(data){
            $('#NotifikasiHapusJurnalAngsuran').html(data);
            var NotifikasiHapusJurnalAngsuranBerhasil=$('#NotifikasiHapusJurnalAngsuranBerhasil').html();
            if(NotifikasiHapusJurnalAngsuranBerhasil=="Success"){
                $('#NotifikasiHapusJurnalAngsuran').html('');
                $('#ModalHapusJurnalAngsuran').modal('hide');
                Swal.fire(
                    'Success!',
                    'Hapus Jurnal Angsuran Berhasil!',
                    'success'
                )
                //Menampilkan Data
                ShowDetailJurnalAngsuran();
            }
        }
    });
});
//Ketika SimulasiPinjaman Dipilih
$('#SimulasiPinjaman').click(function(){
    $('#DetailPinjamanLainnya').html('<div class="spinner-border text-secondary" role="status"><span class="sr-only"></span></div>');
    $.ajax({
        type 	    : 'POST',
        url 	    : '_Page/Pinjaman/SimulasiPinjaman2.php',
        data 	    :  {GetIdPinjaman: GetIdPinjaman},
        enctype     : 'multipart/form-data',
        success     : function(data){
            $('#DetailPinjamanLainnya').html(data);
            $('#AngsuranPinjaman').removeClass('bg-info text-light');
            $('#JurnalPinjaman').removeClass('bg-info text-light');
            $('#SimulasiPinjaman').addClass('bg-info text-light');
        }
    });
});

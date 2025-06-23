KontenRekapTahunanLama = $('#MenampilkanTabelPinjamanPeriode').html();
function RekapPinjamanPeriode() {
    // Efek fade-out sebelum loading spinner muncul
    $('#MenampilkanTabelPinjamanPeriode').fadeOut(300, function () {
        $(this).html('<div class="spinner-border text-secondary" role="status"><span class="sr-only"></span></div>').fadeIn(300);
    });

    var form = $('#ProsesFilterPeriodeTahunan')[0];
    var data = new FormData(form);

    $.ajax({
        type        : 'POST',
        url         : '_Page/RekapPinjaman/TabelPinjamanPeriode.php',
        data        : data,
        cache       : false,
        processData : false,
        contentType : false,
        enctype     : 'multipart/form-data',
        success     : function(data){
            $('#MenampilkanTabelPinjamanPeriode').fadeOut(300, function () {
                $(this).html(data).fadeIn(300);
            });
            $('#ModalRekapTahunan').modal('hide');
            $('#ShowRekapTahunan').html('<i class="bi bi-chevron-up"></i>').prop("disabled", false);
        }
    });
}

function HideRekapTahunan() {
    $('#MenampilkanTabelPinjamanPeriode').slideUp(300, function () {
        $(this).html(KontenRekapTahunanLama).slideDown(300);
    });
    $('#ShowRekapTahunan').html('<i class="bi bi-chevron-down"></i>').prop("disabled", true);
}

KontenRekapUnitDivisiLama = $('#MenampilkanTabelPinjamanUnitDivisi').html();
function RekapUnitDivisi() {
    // Efek fade-out sebelum loading spinner muncul
    $('#MenampilkanTabelPinjamanUnitDivisi').fadeOut(300, function () {
        $(this).html('<div class="spinner-border text-secondary" role="status"><span class="sr-only"></span></div>').fadeIn(300);
    });

    var form = $('#ProsesRekapUnitDivisi')[0];
    var data = new FormData(form);

    $.ajax({
        type        : 'POST',
        url         : '_Page/RekapPinjaman/TabelPinjamanUnitDivisi.php',
        data        : data,
        cache       : false,
        processData : false,
        contentType : false,
        enctype     : 'multipart/form-data',
        success     : function(data){
            $('#MenampilkanTabelPinjamanUnitDivisi').fadeOut(300, function () {
                $(this).html(data).fadeIn(300);
            });
            $('#ModalRekapUnitDivisi').modal('hide');
            $('#ShowRekapUnitDivisi').html('<i class="bi bi-chevron-up"></i>').prop("disabled", false);
        }
    });
}

function HideRekapUnitDivisi() {
    $('#MenampilkanTabelPinjamanUnitDivisi').slideUp(300, function () {
        $(this).html(KontenRekapUnitDivisiLama).slideDown(300);
    });
    $('#ShowRekapUnitDivisi').html('<i class="bi bi-chevron-down"></i>').prop("disabled", true);
}


KontenRekapPinjamanAnggota = $('#MenampilkanRekapPinjamanAnggota').html();
function RekapPinjamanAnggota() {
    // Simpan konten sebelum diganti
    

    // Efek fade-out sebelum loading spinner muncul
    $('#MenampilkanRekapPinjamanAnggota').fadeOut(300, function () {
        $(this).html('<div class="spinner-border text-secondary" role="status"><span class="sr-only"></span></div>').fadeIn(300);
    });

    var form = $('#ProsesRekapPinjamanAnggota')[0];
    var data = new FormData(form);

    $.ajax({
        type        : 'POST',
        url         : '_Page/RekapPinjaman/TabelRekapPinjamanAnggota.php',
        data        : data,
        cache       : false,
        processData : false,
        contentType : false,
        enctype     : 'multipart/form-data',
        success     : function(data){
            $('#MenampilkanRekapPinjamanAnggota').fadeOut(300, function () {
                $(this).html(data).fadeIn(300);
            });
            $('#ShowRekapPinjamanAnggota').html('<i class="bi bi-chevron-up"></i>').prop("disabled", false);
        }
    });
}

function HideRekapPinjamanAnggota() {
    $('#MenampilkanRekapPinjamanAnggota').slideUp(300, function () {
        $(this).html(KontenRekapPinjamanAnggota).slideDown(300);
    });
    $('#ShowRekapPinjamanAnggota').html('<i class="bi bi-chevron-down"></i>').prop("disabled", true);
}


$(document).ready(function() {
    // RekapTahunan();
    // RekapPinjamanAnggota();

    //Proses Menampilkan Periode Tahunan
    $('#ProsesFilterPeriodeTahunan').submit(function(){
        RekapPinjamanPeriode();
    });

    //Proses Menampilkan Rekap Unit Divisi
    $('#ProsesRekapUnitDivisi').submit(function(){
        RekapUnitDivisi();
        $('#ModalRekapUnitDivisi').modal('hide');
    });

    //Proses Menampilkan Periode Tahunan
    $('#ProsesRekapPinjamanAnggota').submit(function(){
        RekapPinjamanAnggota();
        $('#ModalRekapPinjamanAnggota').modal('hide');
    });

    //Modal Cetak Pinjaman Periode
    $('#ModalCetakPinjamanPeriode').on('show.bs.modal', function (e) {
        var tahun= $('#tahun').val();
        if(tahun==""){
            $('#put_tahun_cetak_rekap_periode').val('Semua');
        }else{
            $('#put_tahun_cetak_rekap_periode').val(tahun);
        }

        //Kosongkan Notifikasi
        $('#NotifikasiCetakRekapPinjamanPeriode').html("");
    });

    //Proses Cetak Pinjaman Periode
    $("#ProsesCetakPinjamanPeriode").submit(function(e) {
        e.preventDefault(); // Mencegah form submit default

        // Ambil nilai dari input dan select
        var tahun = $("#put_tahun_cetak_rekap_periode").val();
        var format = $("#type_data_rekap_periode").val();

        // Tentukan URL berdasarkan format yang dipilih
        var url = (format === "PDF") 
            ? "_Page/RekapPinjaman/ProsesExportRekapPinjamanPeriodePdf.php?tahun=" + tahun 
            : "_Page/RekapPinjaman/ProsesExportRekapPinjamanPeriodeExcel.php?tahun=" + tahun;

        // Tampilkan notifikasi loading
        $("#NotifikasiCetakRekapPinjamanPeriode").html('<span class="text-primary">Loading... Mohon tunggu</span>');

        // Buka tab baru dengan URL yang sesuai
        window.open(url, "_blank");

        // Hilangkan notifikasi setelah beberapa detik
        setTimeout(function() {
            $("#NotifikasiCetakRekapPinjamanPeriode").html('');
        }, 3000);
    });

    //Modal Cetak Reka pPinjaman Anggota
    $('#ModalCetakRekapPinjamanAnggota').on('show.bs.modal', function (e) {
        var tahun= $('#tahun_rekap_pinjaman').val();
        if(tahun==""){
            $('#put_tahun_cetak_rekap_anggota').val('Semua');
        }else{
            $('#put_tahun_cetak_rekap_anggota').val(tahun);
        }

        //Kosongkan Notifikasi
        $('#NotifikasiCetakRekapPinjamanAnggota').html("");
    });

    //Proses Cetak Rekap Pinjaman Anggota
    $("#ProsesCetakRekapPinjamanAnggota").submit(function(e) {
        e.preventDefault(); // Mencegah form submit default

        // Ambil nilai dari input dan select
        var tahun = $("#put_tahun_cetak_rekap_anggota").val();
        var format = $("#type_data_rekap_anggota").val();

        // Tentukan URL berdasarkan format yang dipilih
        var url = (format === "PDF") 
            ? "_Page/RekapPinjaman/ProsesExportRekapPinjamanAnggotaPdf.php?tahun=" + tahun 
            : "_Page/RekapPinjaman/ProsesExportRekapPinjamanAnggotaExcel.php?tahun=" + tahun;

        // Tampilkan notifikasi loading
        $("#NotifikasiCetakRekapPinjamanAnggota").html('<span class="text-primary">Loading... Mohon tunggu</span>');

        // Buka tab baru dengan URL yang sesuai
        window.open(url, "_blank");

        // Hilangkan notifikasi setelah beberapa detik
        setTimeout(function() {
            $("#NotifikasiCetakRekapPinjamanAnggota").html('');
        }, 3000);
    });

    //Ketika Muncul Modal Cetak Rekap Pinjaman Unit Divisi
    $('#ModalCetakRekapPinjamanUnitDivisi').on('show.bs.modal', function (e) {
        var tahun= $('#tahun_unit_divisi').val();
        if(tahun==""){
            $('#put_tahun_cetak_rekap_unit_divisi').val('Semua');
        }else{
            $('#put_tahun_cetak_rekap_unit_divisi').val(tahun);
        }

        //Kosongkan Notifikasi
        $('#NotifikasiCetakRekapPinjamanUnitDivisi').html("");
    });

    //Proses Cetak Rekap Pinjaman Unit / Divisi
    $("#ProsesCetakRekapPinjamanUnitDivisi").submit(function(e) {
        e.preventDefault(); // Mencegah form submit default

        // Ambil nilai dari input dan select
        var tahun = $("#put_tahun_cetak_rekap_unit_divisi").val();
        var format = $("#type_data_rekap_unit_divisi").val();

        // Tentukan URL berdasarkan format yang dipilih
        var url = (format === "PDF") 
            ? "_Page/RekapPinjaman/ProsesExportPinjamanUnitDivisiPdf.php?tahun=" + tahun 
            : "_Page/RekapPinjaman/ProsesExportPinjamanUnitDivisiExcel.php?tahun=" + tahun;

        // Tampilkan notifikasi loading
        $("#NotifikasiCetakRekapPinjamanUnitDivisi").html('<span class="text-primary">Loading... Mohon tunggu</span>');

        // Buka tab baru dengan URL yang sesuai
        window.open(url, "_blank");

        // Hilangkan notifikasi setelah beberapa detik
        setTimeout(function() {
            $("#NotifikasiCetakRekapPinjamanUnitDivisi").html('');
        }, 3000);
    });

    //Menyembunyikan Konten
    $('#ShowRekapTahunan').click(function(){
        HideRekapTahunan();
    });
    $('#ShowRekapUnitDivisi').click(function(){
        HideRekapUnitDivisi();
    });
    $('#ShowRekapPinjamanAnggota').click(function(){
        HideRekapPinjamanAnggota();
    });
});

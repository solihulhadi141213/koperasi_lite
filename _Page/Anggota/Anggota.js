//Fungsi Untuk Menampilkan Data Anggota
function filterAndLoadTable() {
    var ProsesFilter = $('#ProsesFilter').serialize();
    $.ajax({
        type: 'POST',
        url: '_Page/Anggota/TabelAnggota.php',
        data: ProsesFilter,
        success: function(data) {
            $('#MenampilkanTabelAnggota').html(data);
        }
    });
}
//Fungsi Untuk Menampilkan Detail Anggota
function ShowDetailInline(id_anggota) {
    
    $.ajax({
        type        : 'POST',
        url         : '_Page/Anggota/_detail_anggota.php',
        data        : {id_anggota: id_anggota},
        dataType    : "json",
        success: function(response) {
            if(response.status=="Success"){
                var tanggal_masuk=response.dataset.tanggal_masuk;
                var tanggal_keluar=response.dataset.tanggal_keluar;
                var nip=response.dataset.nip;
                var nama=response.dataset.nama;
                var email=response.dataset.email;
                var password=response.dataset.password;
                var kontak=response.dataset.kontak;
                var lembaga=response.dataset.lembaga;
                var ranking=response.dataset.ranking;
                var foto=response.dataset.foto;
                var base_url=response.dataset.base_url;
                var akses_anggota=response.dataset.akses_anggota;
                var status=response.dataset.status;
                var alasan_keluar=response.dataset.alasan_keluar;
                if(akses_anggota==1){
                    var label_akses_anggota='<span class="badge badge-success">Tersedia</span>';
                }else{
                    var label_akses_anggota='<span class="badge badge-danger">Tidak Ada</span>';
                }
                if(status=="Aktif"){
                    var label_status='<span class="badge badge-success">Aktif</span>';
                }else{
                    var label_status='<span class="badge badge-danger">Tidak Aktif</span>';
                }

                //Tampilkan Data
                $('#put_detail_anggota').html(`
                    <div class="row mb-2">
                        <div class="col-md-5 mb-3">
                            <div class="row mb-2">
                                <div class="col-12"><b># Informasi Identitas Anggota</b></div>
                            </div>
                            <div class="row mb-2">
                                <div class="col-4"><small>Nama Anggota</small></div>
                                <div class="col-1"><small>:</small></div>
                                <div class="col-7"><small class="text-muted">${nama}</small></div>
                            </div>
                            <div class="row mb-2">
                                <div class="col-4"><small>Nomor Induk</small></div>
                                <div class="col-1"><small>:</small></div>
                                <div class="col-7"><small class="text-muted">${nip}</small></div>
                            </div>
                            <div class="row mb-2">
                                <div class="col-4"><small>Email</small></div>
                                <div class="col-1"><small>:</small></div>
                                <div class="col-7"><small class="text-muted">${email}</small></div>
                            </div>
                            <div class="row mb-2">
                                <div class="col-4"><small>Kontak</small></div>
                                <div class="col-1"><small>:</small></div>
                                <div class="col-7"><small class="text-muted">${kontak}</small></div>
                            </div>
                            <div class="row mb-2">
                                <div class="col-4"><small>Divisi/Unit</small></div>
                                <div class="col-1"><small>:</small></div>
                                <div class="col-7"><small class="text-muted">${lembaga}</small></div>
                            </div>
                            <div class="row mb-2">
                                <div class="col-4"><small>Group/Ranking</small></div>
                                <div class="col-1"><small>:</small></div>
                                <div class="col-7"><small class="text-muted">${ranking}</small></div>
                            </div>
                        </div>
                        <div class="col-md-4 mb-3">
                            <div class="row mb-2">
                                <div class="col-12"><b># Informasi Status Anggota</b></div>
                            </div>
                            <div class="row mb-2">
                                <div class="col-4"><small>Tanggal Masuk</small></div>
                                <div class="col-1"><small>:</small></div>
                                <div class="col-7"><small class="text-muted">${tanggal_masuk}</small></div>
                            </div>
                            <div class="row mb-2">
                                <div class="col-4"><small>Tanggal Keluar</small></div>
                                <div class="col-1"><small>:</small></div>
                                <div class="col-7"><small class="text-muted">${tanggal_keluar}</small></div>
                            </div>
                            <div class="row mb-2">
                                <div class="col-4"><small>Akses Anggota</small></div>
                                <div class="col-1"><small>:</small></div>
                                <div class="col-7"><small class="text-muted">${label_akses_anggota}</small></div>
                            </div>
                            <div class="row mb-2">
                                <div class="col-4"><small>Status Anggota</small></div>
                                <div class="col-1"><small>:</small></div>
                                <div class="col-7"><small class="text-muted">${label_status}</small></div>
                            </div>
                            <div class="row mb-2">
                                <div class="col-4"><small>Alasan Keluar</small></div>
                                <div class="col-1"><small>:</small></div>
                                <div class="col-7"><small class="text-muted">${alasan_keluar}</small></div>
                            </div>
                        </div>
                        <div class="col-md-3 mb-3">
                            <div class="row mb-2">
                                <div class="col-12"><b># Foto Profil Anggota</b></div>
                            </div>
                            <div class="row mb-2">
                                <div class="col-12">
                                    <img src="${base_url}/assets/img/Anggota/${foto}" alt="" width="60%" class="rounded-circle">
                                </div>
                            </div>
                        </div>
                    </div>
                `);
            }else{
                Swal.fire(
                    'Opss!',
                    response.message,
                    'error'
                );
            }
        },
        error: function () {
            Swal.fire(
                'Opss!',
                'Terjadi kesalahan pada saat menampilkan detail informasi anggota!',
                'error'
            );
        }
    });
}

//Fungsi Untuk Menampilkan Data Riwayat Simpanan
function ShowRiwayatSimpananInline() {
    var ProsesFilterRiwayatSimpanan = $('#ProsesFilterRiwayatSimpanan').serialize();
    $.ajax({
        type    : 'POST',
        url     : '_Page/Anggota/TabelRiwayatSimpanan.php',
        data    : ProsesFilterRiwayatSimpanan,
        success: function(data) {
            $('#put_tabel_riwayat_simpanan').html(data);
        }
    });
}

//Fungsi Untuk Menampilkan Data Riwayat Pinjaman
function ShowRiwayatPinjamanInline() {
    var ProsesFilterRiwayatPinjaman = $('#ProsesFilterRiwayatPinjaman').serialize();
    $.ajax({
        type    : 'POST',
        url     : '_Page/Anggota/TabelRiwayatPinjaman.php',
        data    : ProsesFilterRiwayatPinjaman,
        success: function(data) {
            $('#put_tabel_riwayat_pinjaman').html(data);
        }
    });
}

//Fungsi Untuk Menampilkan Data Riwayat Penjualan
function ShowRiwayatPenjualanInline() {
    var ProsesFilterRiwayatPenjualan = $('#ProsesFilterRiwayatPenjualan').serialize();
    $.ajax({
        type    : 'POST',
        url     : '_Page/Anggota/TabelRiwayatPenjualan.php',
        data    : ProsesFilterRiwayatPenjualan,
        success: function(data) {
            $('#put_tabel_riwayat_penjualan').html(data);
        }
    });
}
// Fungsi untuk memformat angka ke Rupiah tanpa desimal
function formatRupiah(angka) {
    return new Intl.NumberFormat('id-ID', { 
        style: 'currency', 
        currency: 'IDR', 
        minimumFractionDigits: 0, 
        maximumFractionDigits: 0 
    }).format(angka);
}

$(document).ready(function() {
    filterAndLoadTable();
    //Form Password dan tanggal keluar Untuk Pertama Kali
    $('#form_password').hide();
    $('#form_tanggal_keluar').hide();
    $('#form_alasan_keluar').hide();

    //Apabila Berada di Halaman Detail
    if ($("#GetIdAnggota").length) {
        //Menampilkan Detail Anggota
        var id_anggota=$("#GetIdAnggota").html();
        ShowDetailInline(id_anggota);

        //Menempelkan id_anggota ke filter put_id_anggota_riwayat_simpanan dan put_id_anggota_riwayat_pinjaman
        $("#put_id_anggota_riwayat_simpanan").val(id_anggota);
        $("#put_id_anggota_riwayat_pinjaman").val(id_anggota);
        $("#put_id_anggota_riwayat_penjualan").val(id_anggota);
        ShowRiwayatSimpananInline();
        ShowRiwayatPinjamanInline();
        ShowRiwayatPenjualanInline();

        //Pagging Riwayat Simpanan
        $(document).on('click', '#next_button_riwayat_simpanan', function() {
            var page_now = parseInt($('#put_page_riwayat_simpanan').val(), 10); // Pastikan nilai diambil sebagai angka
            var next_page = page_now + 1;
            $('#put_page_riwayat_simpanan').val(next_page);
            ShowRiwayatSimpananInline();
        });
        $(document).on('click', '#prev_button_riwayat_simpanan', function() {
            var page_now = parseInt($('#put_page_riwayat_simpanan').val(), 10); // Pastikan nilai diambil sebagai angka
            var next_page = page_now - 1;
            $('#put_page_riwayat_simpanan').val(next_page);
            ShowRiwayatSimpananInline();
        });

        //Pagging Riwayat Pinjaman
        $(document).on('click', '#next_button_riwayat_pinjaman', function() {
            var page_now = parseInt($('#put_page_riwayat_pinjaman').val(), 10); // Pastikan nilai diambil sebagai angka
            var next_page = page_now + 1;
            $('#put_page_riwayat_pinjaman').val(next_page);
            ShowRiwayatPinjamanInline();
        });
        $(document).on('click', '#prev_button_riwayat_pinjaman', function() {
            var page_now = parseInt($('#put_page_riwayat_pinjaman').val(), 10); // Pastikan nilai diambil sebagai angka
            var next_page = page_now - 1;
            $('#put_page_riwayat_pinjaman').val(next_page);
            ShowRiwayatPinjamanInline();
        });

        //Pagging Riwayat Penjualan
        $(document).on('click', '#next_button_riwayat_penjualan', function() {
            var page_now = parseInt($('#put_page_riwayat_penjualan').val(), 10); // Pastikan nilai diambil sebagai angka
            var next_page = page_now + 1;
            $('#put_page_riwayat_penjualan').val(next_page);
            ShowRiwayatPenjualanInline();
        });
        $(document).on('click', '#prev_button_riwayat_penjualan', function() {
            var page_now = parseInt($('#put_page_riwayat_penjualan').val(), 10); // Pastikan nilai diambil sebagai angka
            var next_page = page_now - 1;
            $('#put_page_riwayat_penjualan').val(next_page);
            ShowRiwayatPenjualanInline();
        });

        //Keyword By Riwayat Simpanan
        $('#keyword_by_riwayat_simpanan').change(function(){
            var keyword_by = $('#keyword_by_riwayat_simpanan').val();
            $.ajax({
                type 	    : 'POST',
                url 	    : '_Page/Anggota/FormFilterRiwayatSimpanan.php',
                data 	    :  {keyword_by: keyword_by},
                success     : function(data){
                    $('#FormFilterRiwayatSimpanan').html(data);
                }
            });
        });

        //Keyword By Riwayat Pinjaman
        $('#keyword_by_riwayat_pinjaman').change(function(){
            var keyword_by = $('#keyword_by_riwayat_pinjaman').val();
            $.ajax({
                type 	    : 'POST',
                url 	    : '_Page/Anggota/FormFilterRiwayatPinjaman.php',
                data 	    :  {keyword_by: keyword_by},
                success     : function(data){
                    $('#FormFilterRiwayatPinjaman').html(data);
                }
            });
        });

        //Keyword By Riwayat Penjualan
        $('#keyword_by_riwayat_penjualan').change(function(){
            var keyword_by = $('#keyword_by_riwayat_penjualan').val();
            $.ajax({
                type 	    : 'POST',
                url 	    : '_Page/Anggota/FormFilterRiwayatPenjualan.php',
                data 	    :  {keyword_by: keyword_by},
                success     : function(data){
                    $('#FormFilterRiwayatPenjualan').html(data);
                }
            });
        });

        //Proses Filter Riwayat Simpanan
        $('#ProsesFilterRiwayatSimpanan').submit(function(){
            $('#put_page_riwayat_simpanan').val("1");
            ShowRiwayatSimpananInline();
            $('#ModalFilterRiwayatSimpanan').modal('hide');
        });

        //Proses Filter Riwayat Pinjaman
        $('#ProsesFilterRiwayatPinjaman').submit(function(){
            $('#put_page_riwayat_pinjaman').val("1");
            ShowRiwayatPinjamanInline();
            $('#ModalFilterRiwayatPinjaman').modal('hide');
        });

        //Proses Filter Riwayat Penjualan
        $('#ProsesFilterRiwayatPenjualan').submit(function(){
            $('#put_page_riwayat_penjualan').val("1");
            ShowRiwayatPenjualanInline();
            $('#ModalFilterRiwayatPenjualan').modal('hide');
        });
    }
});
$('#keyword_by').change(function(){
    var keyword_by = $('#keyword_by').val();
    $.ajax({
        type 	    : 'POST',
        url 	    : '_Page/Anggota/FormFilter.php',
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
//Validasi Kontak Hanya Boleh Angka
$('#kontak').keypress(function(event) {
    // Hanya mengizinkan angka (0-9) dan tombol kontrol seperti backspace
    var charCode = (event.which) ? event.which : event.keyCode;
    if (charCode > 31 && (charCode < 48 || charCode > 57)) {
        return false;
    }
    return true;
});
//Menampilkan Password
$('#tampilkan_password_anggota').click(function(){
    if($(this).is(':checked')){
        $('#password').attr('type','text');
    }else{
        $('#password').attr('type','password');
    }
});
//Menampilkan Form Password Saat akses_anggota bernilai Ya
$('#akses_anggota').click(function(){
    if($(this).is(':checked')){
        $('#form_password').show();
    }else{
        $('#form_password').hide();
    }
});
//Kondisi Ketika Dipilih Status Anggota
$('#status').change(function(){
    var status = $('#status').val();
    if(status=="Keluar"){
        $('#form_tanggal_keluar').show();
        $('#form_alasan_keluar').show();
    }else{
        $('#form_tanggal_keluar').hide();
        $('#form_alasan_keluar').hide();
    }
});
//Proses Tambah Anggota
$('#ProsesTambahAnggota').submit(function(){
    $('#NotifikasiTambahAnggota').html('<div class="spinner-border text-secondary" role="status"><span class="sr-only"></span></div>');
    var form = $('#ProsesTambahAnggota')[0];
    var data = new FormData(form);
    $.ajax({
        type 	    : 'POST',
        url 	    : '_Page/Anggota/ProsesTambahAnggota.php',
        data 	    :  data,
        cache       : false,
        processData : false,
        contentType : false,
        enctype     : 'multipart/form-data',
        success     : function(data){
            $('#NotifikasiTambahAnggota').html(data);
            var NotifikasiTambahAnggotaBerhasil=$('#NotifikasiTambahAnggotaBerhasil').html();
            if(NotifikasiTambahAnggotaBerhasil=="Success"){
                $('#NotifikasiTambahAnggota').html('');
                $('#page').val("1");
                $("#ProsesFilter")[0].reset();
                $("#ProsesTambahAnggota")[0].reset();
                $('#ModalTambahAnggota').modal('hide');
                Swal.fire(
                    'Success!',
                    'Tambah Anggota Berhasil!',
                    'success'
                )
                //Menampilkan Data
                filterAndLoadTable();
            }
        }
    });
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
//Modal Edit Anggota
$('#ModalEditAnggota').on('show.bs.modal', function (e) {
    var id_anggota= $(e.relatedTarget).data('id');
    $('#FormEditAnggota').html("Loading...");
    $.ajax({
        type 	    : 'POST',
        url 	    : '_Page/Anggota/FormEditAnggota.php',
        data        : {id_anggota: id_anggota},
        success     : function(data){
            $('#FormEditAnggota').html(data);
            $('#NotifikasiEditAnggota').html('');
        }
    });
});
//Proses Edit Anggota
$('#ProsesEditAnggota').submit(function(){
    $('#NotifikasiEditAnggota').html('<div class="spinner-border text-secondary" role="status"><span class="sr-only"></span></div>');
    var form = $('#ProsesEditAnggota')[0];
    var data = new FormData(form);
    $.ajax({
        type 	    : 'POST',
        url 	    : '_Page/Anggota/ProsesEditAnggota.php',
        data 	    :  data,
        cache       : false,
        processData : false,
        contentType : false,
        enctype     : 'multipart/form-data',
        success     : function(data){
            $('#NotifikasiEditAnggota').html(data);
            var NotifikasiEditAnggotaBerhasil=$('#NotifikasiEditAnggotaBerhasil').html();
            if(NotifikasiEditAnggotaBerhasil=="Success"){
                if ($("#GetIdAnggota").length) {
                    $('#NotifikasiEditAnggota').html('');
                    $("#ProsesEditAnggota")[0].reset();
                    $('#ModalEditAnggota').modal('hide');
                    Swal.fire(
                        'Success!',
                        'Edit Anggota Berhasil!',
                        'success'
                    )
                    //Menampilkan Data
                    var id_anggota=$("#GetIdAnggota").html();
                    ShowDetailInline(id_anggota);
                }else{
                    $('#NotifikasiEditAnggota').html('');
                    $("#ProsesEditAnggota")[0].reset();
                    $('#ModalEditAnggota').modal('hide');
                    Swal.fire(
                        'Success!',
                        'Edit Anggota Berhasil!',
                        'success'
                    )
                    //Menampilkan Data
                    filterAndLoadTable();
                }
            }
        }
    });
});
//Modal Ubah Foto Anggota
$('#ModalUbahFotoAnggota').on('show.bs.modal', function (e) {
    var id_anggota= $(e.relatedTarget).data('id');
    $('#FormUbahFotoAnggota').html("Loading...");
    $.ajax({
        type 	    : 'POST',
        url 	    : '_Page/Anggota/FormUbahFotoAnggota.php',
        data        : {id_anggota: id_anggota},
        success     : function(data){
            $('#FormUbahFotoAnggota').html(data);
            $('#NotifikasiUbahFotoAnggota').html('');
        }
    });
});
//Proses Ubah Foto Anggota
$('#ProsesUbahFotoAnggota').submit(function(){
    $('#NotifikasiUbahFotoAnggota').html('<div class="spinner-border text-secondary" role="status"><span class="sr-only"></span></div>');
    var form = $('#ProsesUbahFotoAnggota')[0];
    var data = new FormData(form);
    $.ajax({
        type 	    : 'POST',
        url 	    : '_Page/Anggota/ProsesUbahFotoAnggota.php',
        data 	    :  data,
        cache       : false,
        processData : false,
        contentType : false,
        enctype     : 'multipart/form-data',
        success     : function(data){
            $('#NotifikasiUbahFotoAnggota').html(data);
            var NotifikasiUbahFotoAnggotaBerhasil=$('#NotifikasiUbahFotoAnggotaBerhasil').html();
            if(NotifikasiUbahFotoAnggotaBerhasil=="Success"){

                if ($("#GetIdAnggota").length) {
                    $('#NotifikasiUbahFotoAnggota').html('');
                    $('#ModalUbahFotoAnggota').modal('hide');
                    Swal.fire(
                        'Success!',
                        'Ubah Foto Anggota Berhasil!',
                        'success'
                    )
                    var id_anggota=$("#GetIdAnggota").html();
                    ShowDetailInline(id_anggota);
                }else{
                    $('#NotifikasiUbahFotoAnggota').html('');
                    $('#ModalUbahFotoAnggota').modal('hide');
                    Swal.fire(
                        'Success!',
                        'Ubah Foto Anggota Berhasil!',
                        'success'
                    );
                    //Menampilkan Data
                    filterAndLoadTable();
                }
                
            }
        }
    });
});
//Modal Hapus Anggota
$('#ModalHapusAnggota').on('show.bs.modal', function (e) {
    var id_anggota= $(e.relatedTarget).data('id');
    $('#FormHapusAnggota').html("Loading...");
    $.ajax({
        type 	    : 'POST',
        url 	    : '_Page/Anggota/FormHapusAnggota.php',
        data        : {id_anggota: id_anggota},
        success     : function(data){
            $('#FormHapusAnggota').html(data);
            $('#NotifikasiHapusAnggota').html('');
        }
    });
});
//Proses Hapus Anggota
$('#ProsesHapusAnggota').submit(function(){
    $('#NotifikasiHapusAnggota').html('<div class="spinner-border text-secondary" role="status"><span class="sr-only"></span></div>');
    var form = $('#ProsesHapusAnggota')[0];
    var data = new FormData(form);
    $.ajax({
        type 	    : 'POST',
        url 	    : '_Page/Anggota/ProsesHapusAnggota.php',
        data 	    :  data,
        cache       : false,
        processData : false,
        contentType : false,
        enctype     : 'multipart/form-data',
        success     : function(data){
            $('#NotifikasiHapusAnggota').html(data);
            var NotifikasiHapusAnggotaBerhasil=$('#NotifikasiHapusAnggotaBerhasil').html();
            if(NotifikasiHapusAnggotaBerhasil=="Success"){
                if ($("#GetIdAnggota").length) {
                    window.location.href = "index.php?Page=Anggota";
                }else{
                    $('#NotifikasiHapusAnggota').html('');
                    $('#ModalHapusAnggota').modal('hide');
                    Swal.fire(
                        'Success!',
                        'Hapus Anggota Berhasil!',
                        'success'
                    )
                    //Menampilkan Data
                    filterAndLoadTable();
                }
            }
        }
    });
});
//Modal Export Anggota
$('#ModalExport').on('show.bs.modal', function (e) {
    $('#FormExport').html("Loading...");
    $.ajax({
        type 	    : 'POST',
        url 	    : '_Page/Anggota/FormExport.php',
        success     : function(data){
            $('#FormExport').html(data);
        }
    });
});
//Proses Import Data Anggota
$('#ProsesImport').submit(function(){
    $('#NotifikasiImport').html('<div class="spinner-border text-secondary" role="status"><span class="sr-only"></span></div>');
    var form = $('#ProsesImport')[0];
    var data = new FormData(form);
    $.ajax({
        type 	    : 'POST',
        url 	    : '_Page/Anggota/ProsesImport.php',
        data 	    :  data,
        cache       : false,
        processData : false,
        contentType : false,
        enctype     : 'multipart/form-data',
        success     : function(data){
            $('#NotifikasiImport').html(data);
            filterAndLoadTable();
        }
    });
});
//Halaman Detail Lainnya
$('#DashboardAnggota').click(function(){
    var GetIdAnggota=$('#GetIdAnggota').html();
    $('#HalamanDetailLainnya').html('Loading...');
    $.ajax({
        type 	    : 'POST',
        url 	    : '_Page/Anggota/DashboardAnggota.php',
        data 	    :  {id_anggota: GetIdAnggota},
        success     : function(data){
            $('#HalamanDetailLainnya').html(data);
            $('.dropdown-item').removeClass('text-white bg-info');
            $('#DashboardAnggota').addClass('text-white bg-info');
        }
    });
});
// Detail Pembelian Anggota
$('#PembelianAnggota').click(function(){
    var GetIdAnggota=$('#GetIdAnggota').html();
    $('#HalamanDetailLainnya').html('Loading...');
    $.ajax({
        type 	    : 'POST',
        url 	    : '_Page/Anggota/PembelianAnggota.php',
        data 	    :  {id_anggota: GetIdAnggota},
        success     : function(data){
            $('#HalamanDetailLainnya').html(data);
            $('.dropdown-item').removeClass('text-white bg-info');
            $('#PembelianAnggota').addClass('text-white bg-info');
            //Menampilkan Tabel Pembelian
            $('#MenampilkanTabelPembelian').html('Loading...');
            $.ajax({
                type 	    : 'POST',
                url 	    : '_Page/Anggota/TabelPembelianAnggota.php',
                data        : {id_anggota: GetIdAnggota},
                success     : function(data){
                    $('#MenampilkanTabelPembelian').html(data);
                }
            });
            //ketika KeywordByPembelian Diubah
            $('#KeywordByPembelian').change(function() {
                var KeywordByPembelian = $('#KeywordByPembelian').val();
                $('#FormKeywordPembelian').html('Loading...');
                $.ajax({
                    type 	    : 'POST',
                    url 	    : '_Page/Anggota/FormKeywordPembelian.php',
                    data 	    :  {KeywordByPembelian: KeywordByPembelian},
                    success     : function(data){
                        $('#FormKeywordPembelian').html(data);
                    }
                });
            });
            //ketika Pencarian submt
            $('#ProsesBatasPembelian').submit(function() {
                var ProsesBatasPembelian = $('#ProsesBatasPembelian').serialize();
                $('#MenampilkanTabelPembelian').html('Loading...');
                $.ajax({
                    type 	    : 'POST',
                    url 	    : '_Page/Anggota/TabelPembelianAnggota.php',
                    data 	    :  ProsesBatasPembelian,
                    success     : function(data){
                        $('#MenampilkanTabelPembelian').html(data);
                    }
                });
            });
            $('#BatasPembelian').change(function() {
                var ProsesBatasPembelian = $('#ProsesBatasPembelian').serialize();
                $('#MenampilkanTabelPembelian').html('Loading...');
                $.ajax({
                    type 	    : 'POST',
                    url 	    : '_Page/Anggota/TabelPembelianAnggota.php',
                    data 	    :  ProsesBatasPembelian,
                    success     : function(data){
                        $('#MenampilkanTabelPembelian').html(data);
                    }
                });
            });
            $('#ShortByPembelian').change(function() {
                var ProsesBatasPembelian = $('#ProsesBatasPembelian').serialize();
                $('#MenampilkanTabelPembelian').html('Loading...');
                $.ajax({
                    type 	    : 'POST',
                    url 	    : '_Page/Anggota/TabelPembelianAnggota.php',
                    data 	    :  ProsesBatasPembelian,
                    success     : function(data){
                        $('#MenampilkanTabelPembelian').html(data);
                    }
                });
            });
            $('#KeywordByPembelian').change(function() {
                var ProsesBatasPembelian = $('#ProsesBatasPembelian').serialize();
                $('#MenampilkanTabelPembelian').html('Loading...');
                $.ajax({
                    type 	    : 'POST',
                    url 	    : '_Page/Anggota/TabelPembelianAnggota.php',
                    data 	    :  ProsesBatasPembelian,
                    success     : function(data){
                        $('#MenampilkanTabelPembelian').html(data);
                    }
                });
            });
        }
    });
});
//Detail Rincian Anggota
$('#RincianAnggota').click(function(){
    var GetIdAnggota=$('#GetIdAnggota').html();
    $('#HalamanDetailLainnya').html('Loading...');
    $.ajax({
        type 	    : 'POST',
        url 	    : '_Page/Anggota/RinciannAnggota.php',
        data 	    :  {id_anggota: GetIdAnggota},
        success     : function(data){
            $('#HalamanDetailLainnya').html(data);
            $('.dropdown-item').removeClass('text-white bg-info');
            $('#RincianAnggota').addClass('text-white bg-info');
            //Menampilkan tabel rincian
            $('#MenampilkanTabelRincian').html('Loading...');
            $.ajax({
                type 	    : 'POST',
                url 	    : '_Page/Anggota/TabelRincianAnggota.php',
                data        : {id_anggota: GetIdAnggota},
                success     : function(data){
                    $('#MenampilkanTabelRincian').html(data);
                }
            });
            //ketika Pencarian submt
            $('#ProsesBatasRincian').submit(function() {
                var ProsesBatasRincian = $('#ProsesBatasRincian').serialize();
                $('#MenampilkanTabelRincian').html('Loading...');
                $.ajax({
                    type 	    : 'POST',
                    url 	    : '_Page/Anggota/TabelRincianAnggota.php',
                    data 	    :  ProsesBatasRincian,
                    success     : function(data){
                        $('#MenampilkanTabelRincian').html(data);
                    }
                });
            });
            $('#BatasRincian').change(function() {
                var ProsesBatasRincian = $('#ProsesBatasRincian').serialize();
                $('#MenampilkanTabelRincian').html('Loading...');
                $.ajax({
                    type 	    : 'POST',
                    url 	    : '_Page/Anggota/TabelRincianAnggota.php',
                    data 	    :  ProsesBatasRincian,
                    success     : function(data){
                        $('#MenampilkanTabelRincian').html(data);
                    }
                });
            });
            $('#ShortByRincian').change(function() {
                var ProsesBatasRincian = $('#ProsesBatasRincian').serialize();
                $('#MenampilkanTabelRincian').html('Loading...');
                $.ajax({
                    type 	    : 'POST',
                    url 	    : '_Page/Anggota/TabelRincianAnggota.php',
                    data 	    :  ProsesBatasRincian,
                    success     : function(data){
                        $('#MenampilkanTabelRincian').html(data);
                    }
                });
            });
            $('#KeywordByRincian').change(function() {
                var KeywordByRincian = $('#KeywordByRincian').val();
                $('#FormKeywordRincian').html('Loading...');
                $.ajax({
                    type 	    : 'POST',
                    url 	    : '_Page/Anggota/FormKeywordRincian.php',
                    data 	    :  {KeywordByRincian: KeywordByRincian},
                    success     : function(data){
                        $('#FormKeywordRincian').html(data);
                    }
                });
            });
        }
    });
});
//Detail Simpanan Anggota
$('#SimpananAnggota').click(function(){
    var GetIdAnggota=$('#GetIdAnggota').html();
    $('#HalamanDetailLainnya').html('Loading...');
    $.ajax({
        type 	    : 'POST',
        url 	    : '_Page/Anggota/SimpananAnggota.php',
        data 	    :  {id_anggota: GetIdAnggota},
        success     : function(data){
            $('#HalamanDetailLainnya').html(data);
            $('.dropdown-item').removeClass('text-white bg-info');
            $('#SimpananAnggota').addClass('text-white bg-info');
            //menampilkan Tabel Simpanan
            $('#MenampilkanTabelSimpanan').html('Loading...');
            $.ajax({
                type 	    : 'POST',
                url 	    : '_Page/Anggota/TabelSimpananAnggota.php',
                data        : {id_anggota: GetIdAnggota},
                success     : function(data){
                    $('#MenampilkanTabelSimpanan').html(data);
                }
            });
            // //ketika Pencarian submt
            // $('#ProsesBatasSimpanan').submit(function() {
            //     var ProsesBatasSimpanan = $('#ProsesBatasSimpanan').serialize();
            //     $('#MenampilkanTabelSimpanan').html('Loading...');
            //     $.ajax({
            //         type 	    : 'POST',
            //         url 	    : '_Page/Anggota/TabelSimpananAnggota.php',
            //         data 	    :  ProsesBatasSimpanan,
            //         success     : function(data){
            //             $('#MenampilkanTabelSimpanan').html(data);
            //         }
            //     });
            // });
            // $('#BatasSimpanan').change(function() {
            //     var ProsesBatasSimpanan = $('#ProsesBatasSimpanan').serialize();
            //     $('#MenampilkanTabelSimpanan').html('Loading...');
            //     $.ajax({
            //         type 	    : 'POST',
            //         url 	    : '_Page/Anggota/TabelSimpananAnggota.php',
            //         data 	    :  ProsesBatasSimpanan,
            //         success     : function(data){
            //             $('#MenampilkanTabelSimpanan').html(data);
            //         }
            //     });
            // });
            // $('#OrderBySimpanann').change(function() {
            //     var ProsesBatasSimpanan = $('#ProsesBatasSimpanan').serialize();
            //     $('#MenampilkanTabelSimpanan').html('Loading...');
            //     $.ajax({
            //         type 	    : 'POST',
            //         url 	    : '_Page/Anggota/TabelSimpananAnggota.php',
            //         data 	    :  ProsesBatasSimpanan,
            //         success     : function(data){
            //             $('#MenampilkanTabelSimpanan').html(data);
            //         }
            //     });
            // });
            // $('#ShortBySimpanan').change(function() {
            //     var ProsesBatasSimpanan = $('#ProsesBatasSimpanan').serialize();
            //     $('#MenampilkanTabelSimpanan').html('Loading...');
            //     $.ajax({
            //         type 	    : 'POST',
            //         url 	    : '_Page/Anggota/TabelSimpananAnggota.php',
            //         data 	    :  ProsesBatasSimpanan,
            //         success     : function(data){
            //             $('#MenampilkanTabelSimpanan').html(data);
            //         }
            //     });
            // });
            // $('#KeywordBySimpanan').change(function() {
            //     var KeywordBySimpanan = $('#KeywordBySimpanan').val();
            //     $('#FormKeywordSimpanan').html('Loading...');
            //     $.ajax({
            //         type 	    : 'POST',
            //         url 	    : '_Page/Anggota/FormKeywordSimpanan.php',
            //         data 	    :  {KeywordBySimpanan: KeywordBySimpanan},
            //         success     : function(data){
            //             $('#FormKeywordSimpanan').html(data);
            //         }
            //     });
            // });
        }
    });
});
$('#PinjamanAnggota').click(function(){
    var GetIdAnggota=$('#GetIdAnggota').html();
    $('#HalamanDetailLainnya').html('Loading...');
    $.ajax({
        type 	    : 'POST',
        url 	    : '_Page/Anggota/PinjamanAnggota.php',
        data 	    :  {id_anggota: GetIdAnggota},
        success     : function(data){
            $('#HalamanDetailLainnya').html(data);
            $('.dropdown-item').removeClass('text-white bg-info');
            $('#PinjamanAnggota').addClass('text-white bg-info');
            //menampilkan Tabel Pinjaman
            $('#MenampilkanTabelPinjaman').html('Loading...');
            $.ajax({
                type 	    : 'POST',
                url 	    : '_Page/Anggota/TabelPinjamanAnggota.php',
                data        : {id_anggota: GetIdAnggota},
                success     : function(data){
                    $('#MenampilkanTabelPinjaman').html(data);
                }
            });
        }
    });
});
$('#BagiHasilAnggota').click(function(){
    var GetIdAnggota=$('#GetIdAnggota').html();
    $('#HalamanDetailLainnya').html('Loading...');
    $.ajax({
        type 	    : 'POST',
        url 	    : '_Page/Anggota/BagiHasilAnggota.php',
        data 	    :  {id_anggota: GetIdAnggota},
        success     : function(data){
            $('#HalamanDetailLainnya').html(data);
            $('.dropdown-item').removeClass('text-white bg-info');
            $('#BagiHasilAnggota').addClass('text-white bg-info');
            //menampilkan Tabel BagiHasil
            $('#MenampilkanTabelBagiHasil').html('Loading...');
            $.ajax({
                type 	    : 'POST',
                url 	    : '_Page/Anggota/TabelBagiHasil.php',
                data        : {id_anggota: GetIdAnggota},
                success     : function(data){
                    $('#MenampilkanTabelBagiHasil').html(data);
                }
            });
        }
    });
});
//Export Transaksi Anggota
$('#ModalExportPembelian').on('show.bs.modal', function (e) {
    var id_anggota = $(e.relatedTarget).data('id');
    $('#FormExportTransaksi').html("Loading...");
    $.ajax({
        type 	    : 'POST',
        url 	    : '_Page/Anggota/FormExportTransaksi.php',
        data        : {id_anggota: id_anggota},
        success     : function(data){
            $('#FormExportTransaksi').html(data);
        }
    });
});
//Detail Transaksi
$('#ModalDetailTransaksi').on('show.bs.modal', function (e) {
    var id_transaksi = $(e.relatedTarget).data('id');
    $('#FormDetailTransaksi').html("Loading...");
    $.ajax({
        type 	    : 'POST',
        url 	    : '_Page/Transaksi/FormDetailTransaksi.php',
        data        : {id_transaksi: id_transaksi},
        success     : function(data){
            $('#FormDetailTransaksi').html(data);
        }
    });
});
//Export Rincian Anggota
$('#ModalExportRincian').on('show.bs.modal', function (e) {
    var id_anggota = $(e.relatedTarget).data('id');
    $('#FormExportRincian').html("Loading...");
    $.ajax({
        type 	    : 'POST',
        url 	    : '_Page/Anggota/FormExportRincian.php',
        data        : {id_anggota: id_anggota},
        success     : function(data){
            $('#FormExportRincian').html(data);
        }
    });
});
//Export Simpanan Anggota
$('#ModalExportSimpanan').on('show.bs.modal', function (e) {
    var id_anggota = $(e.relatedTarget).data('id');
    $('#FormExportSimpanan').html("Loading...");
    $.ajax({
        type 	    : 'POST',
        url 	    : '_Page/Anggota/FormExportSimpanan.php',
        data        : {id_anggota: id_anggota},
        success     : function(data){
            $('#FormExportSimpanan').html(data);
        }
    });
});

//Hapus Anggota
$('#ModalDeleteAnggota').on('show.bs.modal', function (e) {
    var GetData = $(e.relatedTarget).data('id');
    var pecah = GetData.split(",");
    var id_anggota = pecah[0];
    var keyword = pecah[1];
    var batas = pecah[2];
    var ShortBy = pecah[3];
    var OrderBy = pecah[4];
    var page = pecah[5];
    var posisi = pecah[6];
    var keyword_by = pecah[7];
    $('#FormDeleteAnggota').html("Loading...");
    $.ajax({
        type 	    : 'POST',
        url 	    : '_Page/Anggota/FormDeleteAnggota.php',
        data        : {id_anggota: id_anggota},
        success     : function(data){
            $('#FormDeleteAnggota').html(data);
            //Konfirmasi Hapus Anggota
            $('#KonfirmasiHapusAnggota').click(function(){
                $('#NotifikasiHapusAnggota').html('<div class="spinner-border text-secondary" role="status"><span class="sr-only"></span></div>');
                $.ajax({
                    type 	    : 'POST',
                    url 	    : '_Page/Anggota/ProsesHapusAnggota.php',
                    data        : {id_anggota: id_anggota},
                    success     : function(data){
                        $('#NotifikasiHapusAnggota').html(data);
                        var NotifikasiHapusAnggotaBerhasil=$('#NotifikasiHapusAnggotaBerhasil').html();
                        if(NotifikasiHapusAnggotaBerhasil=="Success"){
                            $.ajax({
                                type 	    : 'POST',
                                url 	    : '_Page/Anggota/TabelAnggota.php',
                                data 	    :  {keyword: keyword, batas: batas, ShortBy: ShortBy, OrderBy: OrderBy, page: page, posisi: posisi, keyword_by: keyword_by},
                                success     : function(data){
                                    $('#MenampilkanTabelAnggota').html(data);
                                    $('#ModalDeleteAnggota').modal('hide');
                                    swal("Good Job!", "Hapus Anggota Berhasil!", "success");
                                }
                            });
                        }
                    }
                });
            });
        }
    });
});
//Edit Anggota 2
$('#ModalEditAnggota2').on('show.bs.modal', function (e) {
    var id_anggota = $(e.relatedTarget).data('id');
    $('#FormEditAnggota2').html("Loading...");
    $.ajax({
        type 	    : 'POST',
        url 	    : '_Page/Anggota/FormEditAnggota.php',
        data        : {id_anggota: id_anggota},
        success     : function(data){
            $('#FormEditAnggota2').html(data);
            //Proses Edit Anggota
            $('#ProsesEditAnggota2').submit(function(){
                $('#NotifikasiEditAnggota').html('<div class="spinner-border text-secondary" role="status"><span class="sr-only"></span></div>');
                var form = $('#ProsesEditAnggota2')[0];
                var data = new FormData(form);
                $.ajax({
                    type 	    : 'POST',
                    url 	    : '_Page/Anggota/ProsesEditAnggota.php',
                    data 	    :  data,
                    cache       : false,
                    processData : false,
                    contentType : false,
                    enctype     : 'multipart/form-data',
                    success     : function(data){
                        $('#NotifikasiEditAnggota').html(data);
                        var NotifikasiEditAnggotaBerhasil=$('#NotifikasiEditAnggotaBerhasil').html();
                        if(NotifikasiEditAnggotaBerhasil=="Success"){
                            location.reload();
                        }
                    }
                });
            });
        }
    });
});
//Modal Tambah Akses Anggota
$('#ModalTambahAksesAnggota').on('show.bs.modal', function (e) {
    $('#FormTambahAksesAnggota').html("Loading...");
    $.ajax({
        type 	    : 'POST',
        url 	    : '_Page/Anggota/FormTambahAksesAnggota.php',
        success     : function(data){
            $('#FormTambahAksesAnggota').html(data);
            //Kondisi saat tampilkan password
            $('.form-check-input').click(function(){
                if($(this).is(':checked')){
                    $('#password1').attr('type','text');
                    $('#password2').attr('type','text');
                }else{
                    $('#password1').attr('type','password');
                    $('#password2').attr('type','password');
                }
            });
        }
    });
});
//Modal Status Akses Anggota
$('#ModalStatusAksesAnggota').on('show.bs.modal', function (e) {
    var GetData = $(e.relatedTarget).data('id');
    var pecah = GetData.split(",");
    var id_akses_anggota = pecah[0];
    var keyword = pecah[1];
    var batas = pecah[2];
    var ShortBy = pecah[3];
    var OrderBy = pecah[4];
    var page = pecah[5];
    var keyword_by = pecah[6];
    $('#FormStatusAksesAnggota').html("Loading...");
    $.ajax({
        type 	    : 'POST',
        url 	    : '_Page/Anggota/FormStatusAksesAnggota.php',
        data        : {id_akses_anggota: id_akses_anggota},
        success     : function(data){
            $('#FormStatusAksesAnggota').html(data);
            $('#TabelPilihAnggota').html(data);
            $.ajax({
                url     : "_Page/Anggota/TabelPilihAnggota.php",
                method  : "POST",
                data 	:  { id_akses_anggota: id_akses_anggota },
                success: function (data) {
                    $('#TabelPilihAnggota').html(data);
                }
            });
            $('#CariPilihAnggota').submit(function(){
                var CariPilihAnggota = $('#CariPilihAnggota').serialize();
                $('#TabelPilihAnggota').html('Loading...');
                $.ajax({
                    type 	    : 'POST',
                    url 	    : '_Page/Anggota/TabelPilihAnggota.php',
                    data 	    :  CariPilihAnggota,
                    success     : function(data){
                        $('#TabelPilihAnggota').html(data);
                    }
                });
            });
            $('#BatasCariAnggota').change(function(){
                var CariPilihAnggota = $('#CariPilihAnggota').serialize();
                $('#TabelPilihAnggota').html('Loading...');
                $.ajax({
                    type 	    : 'POST',
                    url 	    : '_Page/Anggota/TabelPilihAnggota.php',
                    data 	    :  CariPilihAnggota,
                    success     : function(data){
                        $('#TabelPilihAnggota').html(data);
                    }
                });
            });
        }
    });
});
//Hapus Hubungkan Anggota
$('#ModalHubungkanAnggota').on('show.bs.modal', function (e) {
    var GetData = $(e.relatedTarget).data('id');
    var pecah = GetData.split(",");
    var id_anggota = pecah[0];
    var id_akses_anggota = pecah[1];
    $('#FormHubungkanAnggota').html("Loading...");
    $.ajax({
        type 	    : 'POST',
        url 	    : '_Page/Anggota/FormHubungkanAnggota.php',
        data        : {id_anggota: id_anggota, id_akses_anggota: id_akses_anggota},
        success     : function(data){
            $('#FormHubungkanAnggota').html(data);
            //Konfirmasi Hubungkan Anggota
            $('#KonfirmasiHubungkanAnggota').click(function(){
                $('#NotifikasiHubungkanAnggota').html('Loading...');
                $.ajax({
                    type 	    : 'POST',
                    url 	    : '_Page/Anggota/ProsesHubungkanAksesAnggota.php',
                    data        : {id_anggota: id_anggota, id_akses_anggota: id_akses_anggota},
                    success     : function(data){
                        $('#NotifikasiHubungkanAnggota').html(data);
                        var NotifikasiHubungkanAnggotaBerhasil=$('#NotifikasiHubungkanAnggotaBerhasil').html();
                        if(NotifikasiHubungkanAnggotaBerhasil=="Success"){
                            $('#MenampilkanTabelAksesAnggota').html('Loading...');
                            $.ajax({
                                url     : "_Page/Anggota/TabelAksesAnggota.php",
                                method  : "POST",
                                success: function (data) {
                                    $('#MenampilkanTabelAksesAnggota').html(data);
                                    $('#ModalHubungkanAnggota').modal('hide');
                                    swal("Good Job!", "Menghubungkan Akses Anggota Berhasil!", "success");
                                }
                            })
                        }
                    }
                });
            });
        }
    });
});
//Hapus Akses Anggota
$('#ModalDeletePermintaanAksesAnggota').on('show.bs.modal', function (e) {
    var GetData = $(e.relatedTarget).data('id');
    var pecah = GetData.split(",");
    var id_akses_anggota = pecah[0];
    var keyword = pecah[1];
    var batas = pecah[2];
    var ShortBy = pecah[3];
    var OrderBy = pecah[4];
    var page = pecah[5];
    var keyword_by = pecah[6];
    $('#FormDeletePermintaanAksesAnggota').html("Loading...");
    $.ajax({
        type 	    : 'POST',
        url 	    : '_Page/Anggota/FormDeletePermintaanAksesAnggota.php',
        data        : {id_akses_anggota: id_akses_anggota},
        success     : function(data){
            $('#FormDeletePermintaanAksesAnggota').html(data);
            //Konfirmasi Delete Permintaan Akses Anggota
            $('#KonfirmasiDeletePermintaanAksesAnggota').click(function(){
                $('#NotifikasiHapusPermintaanAksesAnggota').html('<div class="spinner-border text-secondary" role="status"><span class="sr-only"></span></div>');
                $.ajax({
                    type 	    : 'POST',
                    url 	    : '_Page/Anggota/ProsesHapusAksesAnggota.php',
                    data        : {id_akses_anggota: id_akses_anggota},
                    success     : function(data){
                        $('#NotifikasiHapusPermintaanAksesAnggota').html(data);
                        var NotifikasiHapusPermintaanAksesAnggotaBerhasil=$('#NotifikasiHapusPermintaanAksesAnggotaBerhasil').html();
                        if(NotifikasiHapusPermintaanAksesAnggotaBerhasil=="Success"){
                            $.ajax({
                                url     : "_Page/Anggota/TabelAksesAnggota.php",
                                method  : "POST",
                                data 	:  { page: page, BatasAksesAnggota: batas, KeywordAksesAnggota: keyword, KeywordByAksesAnggota: keyword_by, OrderByAksesAnggota: OrderBy, ShortByAksesAnggota: ShortBy },
                                success: function (data) {
                                    $('#MenampilkanTabelAksesAnggota').html(data);
                                    $('#ModalDeletePermintaanAksesAnggota').modal('hide');
                                    swal("Good Job!", "Hapus Akses Anggota Berhasil!", "success");
                                }
                            })
                        }
                    }
                });
            });
        }
    });
});

//Modal rekapitulasi Simpanan Anggota
$('#ModalRekapSiimpananAnggota').on('show.bs.modal', function (e) {
    var id_anggota = $(e.relatedTarget).data('id');
    $('#FormRekapSiimpananAnggota').html("Loading...");
    $.ajax({
        type 	    : 'POST',
        url 	    : '_Page/Anggota/FormRekapSiimpananAnggota.php',
        data        : {id_anggota: id_anggota},
        success     : function(data){
            $('#FormRekapSiimpananAnggota').html(data);
        }
    });
});

//Modal Export Riwayat Simpanan Anggota
$('#ModalExportRiwayatSimpanan').on('show.bs.modal', function (e) {

    //Tangkap id_anggota
    var id_anggota = $(e.relatedTarget).data('id');

    //Disable Tombol
    $('ButtonExportRiwayatSimpanan').prop("disabled", true);

    //Buka Data Anggota Dengan AJAX
    $.ajax({
        type        : 'POST',
        url         : '_Page/Anggota/_detail_anggota.php',
        data        : {id_anggota: id_anggota},
        dataType    : "json",
        success: function(response) {
            if(response.status=="Success"){

                //Apabila Berhasil Enable Tombol
                $('ButtonExportRiwayatSimpanan').prop("disabled", false);

                //Buka Nama Dan NIP
                var nip=response.dataset.nip;
                var nama=response.dataset.nama;

                //Tampilkan Data
                $('#form_export_riwayat_simpanan').html(`
                    <input type="hidden" class="form-control" name="id_anggota" value="${id_anggota}">
                    <div class="row mb-3">
                        <div class="col-4"><small>Nama Anggota</small></div>
                        <div class="col-1"><small>:</small></div>
                        <div class="col-7"><small class="text-muted">${nama}</small></div>
                    </div>
                    <div class="row mb-3">
                        <div class="col-4"><small>Nomor Induk</small></div>
                        <div class="col-1"><small>:</small></div>
                        <div class="col-7"><small class="text-muted">${nip}</small></div>
                    </div>
                    <div class="row mb-3">
                        <div class="col-4">
                            <small><label for="periode_1_riwayat_simpanan">Periode Awal</label></small>
                        </div>
                        <div class="col-1"><small>:</small></div>
                        <div class="col-7">
                            <input type="date" class="form-control" name="periode_1" id="periode_1_riwayat_simpanan">
                        </div>
                    </div>
                    <div class="row mb-3">
                        <div class="col-4">
                            <small><label for="periode_2_riwayat_simpanan">Periode Akhir</label></small>
                        </div>
                        <div class="col-1"><small>:</small></div>
                        <div class="col-7">
                            <input type="date" class="form-control" name="periode_2" id="periode_2_riwayat_simpanan">
                        </div>
                    </div>
                `);
            }else{
                //Apabila Terjadi kesalahan Disable Tombol
                $('ButtonExportRiwayatSimpanan').prop("disabled", true);

                //Tampilkan Kesalahan
                $('#form_export_riwayat_simpanan').html('<div class="alert alert-danger">'+response.message+'</div>');
            }
        },
        error: function () {
            $('#form_export_riwayat_simpanan').html('<div class="alert alert-danger">Terjadi kesalahan pada saat menampilkan detail informasi anggota!</div>');
            $('ButtonExportRiwayatSimpanan').prop("disabled", true);
        }
    });
});


//Modal Detail Pinjaman Anggota
$('#ModalDetailPinjamanAnggota').on('show.bs.modal', function (e) {

    //Tangkap iid_pinjaman
    var id_pinjaman = $(e.relatedTarget).data('id');

    //Disable Tombol
    $('ButtonExportRiwayatSimpanan').prop("disabled", true);

    //Buka Data Pinjaman Dengan AJAX
    $.ajax({
        type        : 'POST',
        url         : '_Page/Pinjaman/_detail_pinjaman.php',
        data        : {id_pinjaman: id_pinjaman},
        dataType    : "json",
        success: function(response) {
            if(response.status=="Success"){

                //Apabila Berhasil Enable Tombol
                $('ButtonExportRiwayatPinjaman').prop("disabled", false);

                //Buka tanggal
                var tanggal=response.dataset.tanggal;
                var jumlah_pinjaman_rp=response.dataset.jumlah_pinjaman_rp;
                var rp_jasa_rp=response.dataset.rp_jasa_rp;
                var angsuran_pokok_rp=response.dataset.angsuran_pokok_rp;
                var angsuran_total_rp=response.dataset.angsuran_total_rp;
                var periode_angsuran=response.dataset.periode_angsuran;
                var status=response.dataset.status;

                //List Angsuran
                var riwayat_angsuran=response.riwayat_angsuran;

                //Tampilkan Data
                $('#form_detail_riwayat_pinjaman').html(`
                    <input type="hidden" class="form-control" name="id_pinjaman" value="${id_pinjaman}">
                    <div class="row mb-3">
                        <div class="col-4"><small>Tanggal Pinjaman</small></div>
                        <div class="col-1"><small>:</small></div>
                        <div class="col-7"><small class="text-muted">${tanggal}</small></div>
                    </div>
                    <div class="row mb-3">
                        <div class="col-4"><small>Jumlah Pinjaman</small></div>
                        <div class="col-1"><small>:</small></div>
                        <div class="col-7"><small class="text-muted">${jumlah_pinjaman_rp}</small></div>
                    </div>
                    <div class="row mb-3">
                        <div class="col-4"><small>Angsuran Pokok</small></div>
                        <div class="col-1"><small>:</small></div>
                        <div class="col-7"><small class="text-muted">${angsuran_pokok_rp}</small></div>
                    </div>
                    <div class="row mb-3">
                        <div class="col-4"><small>Jasa</small></div>
                        <div class="col-1"><small>:</small></div>
                        <div class="col-7"><small class="text-muted">${rp_jasa_rp}</small></div>
                    </div>
                    <div class="row mb-3">
                        <div class="col-4"><small>Jumlah Angsuran</small></div>
                        <div class="col-1"><small>:</small></div>
                        <div class="col-7"><small class="text-muted">${angsuran_total_rp}</small></div>
                    </div>
                    <div class="row mb-3">
                        <div class="col-4"><small>Periode Angsuran</small></div>
                        <div class="col-1"><small>:</small></div>
                        <div class="col-7"><small class="text-muted">${periode_angsuran}</small></div>
                    </div>
                    <div class="row mb-3">
                        <div class="col-4"><small>Status</small></div>
                        <div class="col-1"><small>:</small></div>
                        <div class="col-7"><small class="text-muted">${status}</small></div>
                    </div>
                `);

                //Tampilkan Riwayat Angsuran
                var riwayat_angsuran = response.riwayat_angsuran;
                var tableContent = '';

                // Variabel untuk menghitung total
                var totalPokok = 0;
                var totalJasa = 0;
                var totalDenda = 0;
                var totalJumlah = 0;

                if (riwayat_angsuran.length > 0) {
                    riwayat_angsuran.forEach(function (item, index) {
                        // Konversi data ke integer
                        var pokok = parseInt(item.pokok) || 0;
                        var jasa = parseInt(item.jasa) || 0;
                        var denda = parseInt(item.denda) || 0;
                        var jumlah = parseInt(item.jumlah) || 0;

                        // Tambahkan ke total masing-masing
                        totalPokok += pokok;
                        totalJasa += jasa;
                        totalDenda += denda;
                        totalJumlah += jumlah;

                        tableContent += `
                            <tr>
                                <td><small>${index + 1}</small></td>
                                <td><small>${item.tanggal_bayar}</small></td>
                                <td><small>${formatRupiah(pokok)}</small></td>
                                <td><small>${formatRupiah(jasa)}</small></td>
                                <td><small>${formatRupiah(denda)}</small></td>
                                <td><small>${formatRupiah(jumlah)}</small></td>
                            </tr>
                        `;
                    });

                    // Tambahkan baris total di akhir tabel
                    tableContent += `
                        <tr>
                            <th colspan="2" class="text-end"><small><b>TOTAL</b></small></th>
                            <th><small><b>${formatRupiah(totalPokok)}</b></small></th>
                            <th><small><b>${formatRupiah(totalJasa)}</b></small></th>
                            <th><small><b>${formatRupiah(totalDenda)}</b></small></th>
                            <th><small><b>${formatRupiah(totalJumlah)}</b></small></th>
                        </tr>
                    `;
                } else {
                    tableContent = `
                        <tr>
                            <td colspan="6" class="text-center">
                                <small class="text-danger">Tidak Ada Data Riwayat Angsuran Yang Ditampilkan</small>
                            </td>
                        </tr>
                    `;
                }

                $('#table_riwayat_angsuran').html(tableContent);
            }else{
                //Apabila Terjadi kesalahan Disable Tombol
                $('ButtonExportRiwayatPinjaman').prop("disabled", true);

                //Tampilkan Kesalahan
                $('#form_detail_riwayat_pinjaman').html('<div class="alert alert-danger">'+response.message+'</div>');
            }
        },
        error: function () {
            $('#form_detail_riwayat_pinjaman').html('<div class="alert alert-danger">Terjadi kesalahan pada saat menampilkan detail informasi anggota!</div>');
            $('ButtonExportRiwayatPinjaman').prop("disabled", true);
        }
    });
});


//Modal Detail
$('#ModalDetailPenjualan').on('show.bs.modal', function (e) {
    //Tangkap id_transaksi_jual_beli dari modal detail
    var id_transaksi_jual_beli = $(e.relatedTarget).data('id');
    
    //Buka Detail Barang
    $.ajax({
        type 	    : 'POST',
        url 	    : '_Page/Penjualan/detail_penjualan.php',
        data        : {id_transaksi_jual_beli: id_transaksi_jual_beli},
        dataType    : "json",
        success     : function(response){
            if(response.status=="Success"){

                var data = response.dataset;
                var list_rincian = response.list_rincian;
                
                //Tempelkan Ke Element
                $('#FormDetailPenjualan').html(`
                    <input type="hidden" name="id" value="${id_transaksi_jual_beli}">
                    <div class="row mb-2">
                        <div class="col-4"><small>Tanggal</small></div>
                        <div class="col-8">
                            <small class="text text-grayish">${data.tanggal}</small>
                        </div>
                    </div>
                    <div class="row mb-2">
                        <div class="col-4"><small>Anggota</small></div>
                        <div class="col-8">
                            <a href="javascriipt:void(0);" data-bs-toggle="modal" data-bs-target="#ModalListAnggotaEdit" data-id="${id_transaksi_jual_beli}" data-mode="List">
                                <small class="text text-grayish">${data.nama_anggota}</small>
                            </a>
                        </div>
                    </div>
                    <div class="row mb-2">
                        <div class="col-4"><small>Kategori</small></div>
                        <div class="col-8">
                            <small class="text text-grayish">${data.kategori}</small>
                        </div>
                    </div>
                    <div class="row mb-2">
                        <div class="col-4"><small>Subtotal</small></div>
                        <div class="col-8">
                            <small class="text text-grayish">${data.subtotal_rp}</small>
                        </div>
                    </div>
                    <div class="row mb-2">
                        <div class="col-4"><small>PPN</small></div>
                        <div class="col-8">
                            <small class="text text-grayish">${data.ppn_rp}</small>
                        </div>
                    </div>
                    <div class="row mb-2">
                        <div class="col-4"><small>Diskon</small></div>
                        <div class="col-8">
                            <small class="text text-grayish">${data.diskon_rp}</small>
                        </div>
                    </div>
                    <div class="row mb-2">
                        <div class="col-4"><small>Total</small></div>
                        <div class="col-8">
                            <small class="text text-grayish">${data.total_rp}</small>
                        </div>
                    </div>
                    <div class="row mb-2">
                        <div class="col-4"><small>Cash</small></div>
                        <div class="col-8">
                            <small class="text text-grayish">${data.cash_rp}</small>
                        </div>
                    </div>
                    <div class="row mb-2">
                        <div class="col-4"><small>Kembalian</small></div>
                        <div class="col-8">
                            <small class="text text-grayish">${data.kembalian_rp}</small>
                        </div>
                    </div>
                    <div class="row mb-2">
                        <div class="col-4"><small>Status</small></div>
                        <div class="col-8">
                            <small class="text text-grayish">${data.status}</small>
                        </div>
                    </div>
                `);
                var rincianList = response.list_rincian;
                var html = "";

                // Inisialisasi total
                var totalPpn = 0;
                var totalDiskon = 0;
                var totalSubtotal = 0;

                if (rincianList.length > 0) {
                    $.each(rincianList, function(index, item) {
                        html += `
                            <tr>
                                <td>${index + 1}</td>
                                <td>${item.nama_barang}</td>
                                <td>${item.qty}</td>
                                <td class="text-end">${item.harga_rp}</td>
                                <td class="text-end">${item.ppn_rp}</td>
                                <td class="text-end">${item.diskon_rp}</td>
                                <td class="text-end">${item.subtotal_rp}</td>
                            </tr>
                        `;

                        // Hitung total
                        totalPpn += parseFloat(item.ppn);
                        totalDiskon += parseFloat(item.diskon);
                        totalSubtotal += parseFloat(item.subtotal);
                    });

                    // Tambahkan baris total di akhir tabel
                    html += `
                        <tr class="fw-bold bg-light">
                            <td colspan="4" class="text-center">Total</td>
                            <td class="text-end">Rp ${totalPpn.toLocaleString("id-ID")}</td>
                            <td class="text-end">Rp ${totalDiskon.toLocaleString("id-ID")}</td>
                            <td class="text-end">Rp ${totalSubtotal.toLocaleString("id-ID")}</td>
                        </tr>
                    `;
                } else {
                    html = '<tr><td colspan="7" class="text-center">Tidak ada rincian transaksi</td></tr>';
                }

                // Masukkan ke dalam tabel
                $("#ListDetailPenjualan").html(html);

                //Enable tombol
                $('#ButtonDetailPenjualanSelengkapnya').prop("disabled", false);
            }else{
                //Tempelkan Notifikasi
                $('#FormDetailPenjualan').html(
                    `<div class="alert alert-danger" role="alert">${response.message}</div>`
                );
                //Disable tombol
                $('#ButtonDetailPenjualanSelengkapnya').prop("disabled", true);
            }
        },
        error: function () {
            //Tempelkan Notifikasi
            $('#FormDetailPenjualan').html(
                '<div class="alert alert-danger" role="alert">Terjadi kesalahan pada sistem. Silakan coba lagi.</div>'
            );
            //Disable tombol
            $('#ButtonDetailPenjualanSelengkapnya').prop("disabled", true);
        },
    });
});

//Modal Export Riwayat Transaksi Penjualan
$('#ModalExportRiwayatPenjualan').on('show.bs.modal', function (e) {
    //Tangkap id_anggota dari modal detail
    var id_anggota = $(e.relatedTarget).data('id');
    
    //Disable Button
    $('#ButtonExportPenjualanAnggota').prop("disabled", true);

    //Buka Detail Anggota Dengan AJAX
    $.ajax({
        type 	    : 'POST',
        url 	    : '_Page/Anggota/_detail_anggota.php',
        data        : {id_anggota: id_anggota},
        dataType    : "json",
        success     : function(response){
            if(response.status=="Success"){

                //Jika Berhasil Enable Button
                $('#ButtonExportPenjualanAnggota').prop("disabled", false);

                var dataset = response.dataset;
                
                //Tempelkan Ke Element
                $('#FormExportPenjualanAnggota').html(`
                    <input type="hidden" name="id_anggota" value="${id_anggota}">
                    <div class="row mb-3">
                        <div class="col-4"><small>Nama Anggota</small></div>
                        <div class="col-1"><small>:</small></div>
                        <div class="col-7">
                            <small class="text-muted">${dataset.nama}</small>
                        </div>
                    </div>
                    <div class="row mb-3">
                        <div class="col-4"><small>Nomor Induk</small></div>
                        <div class="col-1"><small>:</small></div>
                        <div class="col-7">
                            <small class="text-muted">${dataset.nip}</small>
                        </div>
                    </div>
                    <div class="row mb-3">
                        <div class="col-4"><label for="periode_awal_export"><small>Periode Awal</small></label></div>
                        <div class="col-1"><small>:</small></div>
                        <div class="col-7">
                            <input type="date" name="periode_awal_export" id="periode_awal_export" class="form-control">
                        </div>
                    </div>
                    <div class="row mb-3">
                        <div class="col-4"><label for="periode_akhir_export"><small>Periode Akhir</small></label></div>
                        <div class="col-1"><small>:</small></div>
                        <div class="col-7">
                            <input type="date" name="periode_akhir_export" id="periode_akhir_export" class="form-control">
                        </div>
                    </div>
                    <div class="row mb-3">
                        <div class="col-4"><label for="kategori_data_penjualan"><small>Kategori Data</small></label></div>
                        <div class="col-1"><small>:</small></div>
                        <div class="col-7">
                            <select class="form-control" name="kategori_data_penjualan" id="kategori_data_penjualan">
                                <option value="">Pilih</option>
                                <option value="Transaksi">Transaksi</option>
                                <option value="Rincian">Rincian</option>
                            </select>
                        </div>
                    </div>
                `);

                //Kosongkan Notifikasi
                $('#NotifikasiExportPenjualanAnggota').html('');

            }else{
                //Tempelkan Notifikasi
                $('#FormExportPenjualanAnggota').html(
                    `<div class="alert alert-danger" role="alert">${response.message}</div>`
                );

                //Disable tombol
                $('#ButtonExportPenjualanAnggota').prop("disabled", true);
            }
        },
        error: function () {
            //Tempelkan Notifikasi
            $('#FormExportPenjualanAnggota').html(
                '<div class="alert alert-danger" role="alert">Terjadi kesalahan pada sistem. Silakan coba lagi.</div>'
            );
            //Disable tombol
            $('#ButtonExportPenjualanAnggota').prop("disabled", true);
        },
    });
});

// Handle form submission
// Handle form submission
$("#ProsesExportRiwayatPenjualan").submit(function(e) {
    e.preventDefault();

    // Get values from the form
    const periode_awal = $("#periode_awal_export").val();
    const periode_akhir = $("#periode_akhir_export").val();
    const kategori_data_penjualan = $("#kategori_data_penjualan").val();
    const id_anggota = $("input[name='id_anggota']").val();

    // Validate date range
    if (new Date(periode_awal) > new Date(periode_akhir)) {
        // Invalid date range, show alert
        $("#NotifikasiExportPenjualanAnggota").html('<div class="alert alert-danger">Periode Awal tidak boleh lebih besar dari Periode Akhir.</div>');
        return;
    }

    // Reset any previous alerts
    $("#NotifikasiExportPenjualanAnggota").html('');

    // Prepare data for GET request
    const data = {
        id_anggota: id_anggota,
        periode_awal: periode_awal,
        periode_akhir: periode_akhir,
        kategori_data_penjualan: kategori_data_penjualan
    };

    // Determine the appropriate PHP file for the request based on kategori_data_penjualan
    let url = "";
    if (kategori_data_penjualan === "Transaksi") {
        url = "_Page/Anggota/ProsesExportTransaksiAnggota.php";
    } else if (kategori_data_penjualan === "Rincian") {
        url = "_Page/Anggota/ProsesExportRincianTransaksiAnggota.php";
    } else {
        $("#NotifikasiExportPenjualanAnggota").html('<div class="alert alert-danger">Pilih kategori data terlebih dahulu.</div>');
        return;
    }

    // Send data via GET request by constructing a query string
    const queryString = $.param(data);  // Create a query string from the data object

    // Open the URL in a new tab with the data appended as query parameters
    window.open(url + '?' + queryString, '_blank');

    // Display success notification
    $("#NotifikasiExportPenjualanAnggota").html('<div class="alert alert-success">Export berhasil! Halaman baru akan dibuka.</div>');
});

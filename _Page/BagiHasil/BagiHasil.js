function ShowData() {
    var ProsesFilter = $('#ProsesFilter').serialize();
    $('#TabelBagiHasil').html('<tr><td colspan="9" class="text-center">Loading...</td></tr>');
    $.ajax({
        type: 'POST',
        url: '_Page/BagiHasil/TabelBagiHasil.php',
        data: ProsesFilter,
        success: function(data) {
            $('#TabelBagiHasil').html(data);
        }
    });
}

//Fungsi Untuk Menampilkan Tabel Pilih Anggota
function ShowPilihAnggota() {
    var filter_pilih_anggota = $('#filter_pilih_anggota').serialize();
    $.ajax({
        type    : 'POST',
        url     : '_Page/BagiHasil/TabelAnggota.php',
        data    : filter_pilih_anggota,
        success: function(data) {
            $('#tabel_anggota').html(data);
        }
    });
}

//Fungsi Untuk Menampilkan detail SHU inline
function show_shu_inline(id_shu_session) {
    
    $.ajax({
        type        : 'POST',
        url         : '_Page/BagiHasil/_detail_bagi_hasil.php',
        data        : {id_shu_session: id_shu_session},
        dataType    : "json",
        success: function(response) {
            if(response.status=="Success"){
                var dataset=response.dataset;
                //Loading detail_shu_inline
                $('#detail_shu_inline').html('Loading...');
                
                //Tampilkan Data
                $('#detail_shu_inline').html(`
                    <div class="row">
                        <div class="col-md-6">
                            <div class="row mb-2">
                                <div class="col-12">
                                    <b># Informasi Pengaturan SHU</b>
                                </div>
                            </div>
                            <div class="row mb-2">
                                <div class="col-4">
                                    <small>Periode Perhitungan</small>
                                </div>
                                <div class="col-1">:</div>
                                <div class="col-7">
                                    <small class="text-muted">
                                        ${dataset.periode_hitung1} - ${dataset.periode_hitung2}
                                    </small>
                                </div>
                            </div>
                            <div class="row mb-2">
                                <div class="col-4">
                                    <small>Jumlah SHU</small>
                                </div>
                                <div class="col-1">:</div>
                                <div class="col-7">
                                    <small class="text-muted">
                                        ${dataset.shu_rp}
                                    </small>
                                </div>
                            </div>
                            <div class="row mb-4">
                                <div class="col-4">
                                    <small>Status</small>
                                </div>
                                <div class="col-1">:</div>
                                <div class="col-7">
                                    ${dataset.LabelStatus}
                                </div>
                            </div>
                            <div class="row mb-3 mt-3">
                                <div class="col-12">
                                    <b># Persentase SHU</b>
                                </div>
                            </div>
                            <div class="row mb-2">
                                <div class="col-4">
                                    <small>Persentase Penjualan</small>
                                </div>
                                <div class="col-1">:</div>
                                <div class="col-7">
                                    <small class="text-muted">
                                        ${dataset.persen_penjualan} %
                                    </small>
                                </div>
                            </div>
                            <div class="row mb-2">
                                <div class="col-4">
                                    <small>Persentase Simpanan</small>
                                </div>
                                <div class="col-1">:</div>
                                <div class="col-7">
                                    <small class="text-muted">
                                        ${dataset.persen_simpanan} %
                                    </small>
                                </div>
                            </div>
                            <div class="row mb-2">
                                <div class="col-4">
                                    <small>Persentase Pinjaman</small>
                                </div>
                                <div class="col-1">:</div>
                                <div class="col-7">
                                    <small class="text-muted">
                                        ${dataset.persen_pinjaman} %
                                    </small>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="row mb-3 mt-3">
                                <div class="col-12">
                                    <b># Perhitungan Total Transaksi Semua Anggota</b>
                                </div>
                            </div>
                            <div class="row mb-2">
                                <div class="col-4">
                                    <small>Total Penjualan Anggota</small>
                                </div>
                                <div class="col-1">:</div>
                                <div class="col-7">
                                    <small class="text-muted">
                                        ${dataset.total_penjualan_rp}
                                    </small>
                                </div>
                            </div>
                            <div class="row mb-2">
                                <div class="col-4">
                                    <small>Total Simpanan Anggota</small>
                                </div>
                                <div class="col-1">:</div>
                                <div class="col-7">
                                    <small class="text-muted">
                                        ${dataset.total_simpanan_rp}
                                    </small>
                                </div>
                            </div>
                            <div class="row mb-4">
                                <div class="col-4">
                                    <small>Total Pinjaman Anggota</small>
                                </div>
                                <div class="col-1">:</div>
                                <div class="col-7">
                                    <small class="text-muted">
                                        ${dataset.total_pinjaman_rp}
                                    </small>
                                </div>
                            </div>
                            <div class="row mb-3 mt-3">
                                <div class="col-12">
                                    <b># Alokasi SHU</b>
                                </div>
                            </div>
                            <div class="row mb-2">
                                <div class="col-4">
                                    <small>Jumlah Anggota</small>
                                </div>
                                <div class="col-1">:</div>
                                <div class="col-7">
                                    <small class="text-muted">
                                        ${dataset.JumlahRincian}
                                    </small>
                                </div>
                            </div>
                            <div class="row mb-2">
                                <div class="col-4">
                                    <small>Total Alokasi Pembagian</small>
                                </div>
                                <div class="col-1">:</div>
                                <div class="col-7">
                                    <small class="text-muted">
                                        ${dataset.jumlah_alokasi_rp}
                                    </small>
                                </div>
                            </div>
                        </div>
                    </div>
                `);
            }else{
                //Apabila Terdapat kesalahan Tampilkan Pesan kesalahan dalam bentuk swal
                Swal.fire(
                    'Opss!',
                    response.message,
                    'error'
                );
            }
        },
        error: function () {
            //Apabila Terdapat kesalahan Tampilkan Swal
            Swal.fire(
                'Opss!',
                'Terjadi kesalahan pada saat menampilkan detail SHU',
                'error'
            );
        }
    });
}

function ShowRincianBagiHasil() {
    var ProsesFilterRincianShu = $('#ProsesFilterRincianShu').serialize();
    $.ajax({
        type    : 'POST',
        url     : '_Page/BagiHasil/TabelRincianBagiHasil.php',
        data    : ProsesFilterRincianShu,
        success: function(data) {
            $('#MenampilkanRincianBagiHasil').html(data);
        }
    });
}

function ShowPembayaranShu() {
    var id_shu_session = $('#GetIdShuSession').val();
    $.ajax({
        type    : 'POST',
        url     : '_Page/BagiHasil/_DetailPembayaranShu.php',
        data    : {id_shu_session: id_shu_session},
        success: function(data) {
            $('#MenampilkanInformasiPembayaran').html(data);
        }
    });
}

function ShowJurnalBagiHasil() {
    var GetIdShuSession = $('#GetIdShuSession').val();
    $.ajax({
        type    : 'POST',
        url     : '_Page/BagiHasil/TabelJurnalBagiHasil.php',
        data    : {id_shu_session: GetIdShuSession},
        success: function(data) {
            $('#TabelJurnalShu').html(data);
        }
    });
}

// Fungsi untuk memproses input pada elemen dengan class form-money
function processInput(event) {
    let input = event.target;
    let originalValue = input.value;

    // Hilangkan titik dari nilai asli untuk penghitungan
    let rawValue = originalValue.replace(/\./g, "");

    // Format nilai input
    let formattedValue = formatMoney(rawValue);

    // Update nilai input dengan nilai yang telah diformat
    input.value = formattedValue;
}

// Fungsi untuk memformat angka menjadi format ribuan
function formatMoney(value) {
    if (!value) return ""; // Jika kosong, kembalikan string kosong
    // Hilangkan karakter selain angka
    value = value.toString().replace(/[^0-9]/g, "");
    // Tambahkan pemisah ribuan (titik)
    return value.replace(/\B(?=(\d{3})+(?!\d))/g, ".");
}

// Fungsi untuk menginisialisasi elemen form-money
function initializeMoneyInputs() {
    const moneyInputs = document.querySelectorAll(".form-money");
    moneyInputs.forEach(function (input) {
        // Format nilai awal jika sudah ada
        input.value = formatMoney(input.value);

        // Pastikan input diformat dengan benar
        input.removeEventListener("input", processInput); // Menghapus event listener sebelumnya
        input.addEventListener("input", processInput);
    });
}

// Fungsi untuk menghitung total SHU
function calculateSHU() {
    let jasaPenjualan = parseInt($("#jasa_penjualan_manual").val().replace(/\./g, "")) || 0;
    let jasaSimpanan = parseInt($("#jasa_simpanan_manual").val().replace(/\./g, "")) || 0;
    let jasaPinjaman = parseInt($("#jasa_pinjaman_manual").val().replace(/\./g, "")) || 0;

    let totalSHU = jasaPenjualan + jasaSimpanan + jasaPinjaman;

    // Update nilai SHU dengan format ribuan
    $("#shu_manual").val(formatMoney(totalSHU));
}

// Fungsi untuk menghitung total SHU Mode Edit
function calculateSHUEdit() {
    let jasaPenjualan = parseInt($("#jasa_penjualan_manual_edit").val().replace(/\./g, "")) || 0;
    let jasaSimpanan = parseInt($("#jasa_simpanan_manual_edit").val().replace(/\./g, "")) || 0;
    let jasaPinjaman = parseInt($("#jasa_pinjaman_manual_edit").val().replace(/\./g, "")) || 0;

    let totalSHU = jasaPenjualan + jasaSimpanan + jasaPinjaman;

    // Update nilai SHU dengan format ribuan
    $("#shu_manual_edit").val(formatMoney(totalSHU));
}
//Fungsi Untuk Menghitung SHU anggota
function hitung_shu_anggota() {
    var ProsesHitungShu = $('#ProsesHitungShu').serialize();
    $.ajax({
        type        : 'POST',
        url         : '_Page/BagiHasil/ProsesHitungShu.php',
        data        : ProsesHitungShu,
        dataType    : "json",
        success: function(response) {
            if(response.status=="Success"){

                //Apabila berhasiil

                //Ambil page dan jumlah data
                var row_data_now=response.row_data_now;
                var count_data=response.count_data;
                var page_now=response.page_now;

                //Tempelkan data tersebut ke element form
                $('#page_perhitungan').val(row_data_now);
                $('#row_data_now').html(page_now);
                $('#count_data').html(count_data);

                //Pernyataan Statment
                $('#statment_proses').html('<span class="text-warning">Sedang Menghiitung...</span>');
                //Hitung ulang (panggil ulang fungsi)
                hitung_shu_anggota();

            }else{
                if(response.status=="Selesai"){
                    //Apabila selesai
                    //tutup modal
                    // $('#ModalHitungShu').modal('hide');
                    $('#statment_proses').html('<span class="text-success">Proses Selesai</span>');
                    //tampilkan swal
                    Swal.fire(
                        'Selesai!',
                        'Perhitungan SHU selesai!',
                        'success'
                    );

                    //Tampilkan rincian SHU
                    ShowRincianBagiHasil();

                    //Reload Detail SHU
                    var id_shu_session=$('#GetIdShuSession').val();
                    show_shu_inline(id_shu_session);
                }else{
                    //Apabila Terjadi kesalahan

                    //tampilkan swal
                    Swal.fire(
                        'Selesai!',
                        response.message,
                        'error'
                    );

                    //Tampilkan rincian SHU
                    ShowRincianBagiHasil();
                }
            }
        },
        error: function () {
            //Apabila Terdapat kesalahan Tampilkan Swal
            Swal.fire(
                'Opss!',
                'Terjadi kesalahan pada saat menghiutng SHU anggota',
                'error'
            );
        }
    });
}

$(document).ready(function() {
    //Menampilkan Data Pertama Kali
    ShowData();

    
    if ($("#GetIdShuSession").length) {
        var id_shu_session=$('#GetIdShuSession').val();

        //Tempelkan id_shu_session Pada Modal Filter Rincian
        $('#put_id_shu_session_filter_rincian').val(id_shu_session);
        
        //Tampilkan Detail SHU
        show_shu_inline(id_shu_session);
        
        //Tampilkan Rincian SHU
        ShowRincianBagiHasil();

        //Tampilkan informasi pembayaran
        ShowPembayaranShu();

        //Tampilkan Jurnal
        ShowJurnalBagiHasil();

        //Kettika filter rincian di submit
        $('#ProsesFilterRincianShu').submit(function(){
            //Rerset Halaman Ke Halaman 1
            $('#put_page_rincian_shu').val("1");
            
            //Reload data rincian
            ShowRincianBagiHasil();

            //Tutup Modal
            $('#ModalFilterRincianShu').modal('hide');
        });

        //Pagging Data Rincian
        $(document).on('click', '#next_button_rincian', function() {
            var page_now = parseInt($('#put_page_rincian_shu').val(), 10); // Pastikan nilai diambil sebagai angka
            var next_page = page_now + 1;
            $('#put_page_rincian_shu').val(next_page);
            ShowRincianBagiHasil();
        });
        $(document).on('click', '#prev_button_rincian', function() {
            var page_now = parseInt($('#put_page_rincian_shu').val(), 10); // Pastikan nilai diambil sebagai angka
            var next_page = page_now - 1;
            $('#put_page_rincian_shu').val(next_page);
            ShowRincianBagiHasil();
        });
    }

    //Apabila keyword_by diubah
    $('#keyword_by').change(function(){
        var keyword_by = $('#keyword_by').val();
        $.ajax({
            type 	    : 'POST',
            url 	    : '_Page/BagiHasil/FormFilter.php',
            data 	    :  {keyword_by: keyword_by},
            success     : function(data){
                $('#FormFilter').html(data);
            }
        });
    });

    //Kettika filter di submit
    $('#ProsesFilter').submit(function(){
        $('#page').val("1");
        ShowData();
        $('#ModalFilter').modal('hide');
    });

    //PAGGING
    $(document).on('click', '#next_button', function() {
        var page_now = parseInt($('#page').val(), 10); // Pastikan nilai diambil sebagai angka
        var next_page = page_now + 1;
        $('#page').val(next_page);
        ShowData();
    });
    $(document).on('click', '#prev_button', function() {
        var page_now = parseInt($('#page').val(), 10); // Pastikan nilai diambil sebagai angka
        var next_page = page_now - 1;
        $('#page').val(next_page);
        ShowData();
    });

    //Modal Tambah Bagi Hasil
    $('#ModalTambahBagiHasil').on('show.bs.modal', function (e) {
        $('#FormTambahBagiHasil').html("Loading...");
        $.ajax({
            type 	    : 'POST',
            url 	    : '_Page/BagiHasil/FormTambahBagiHasil.php',
            success     : function(data){
                $('#FormTambahBagiHasil').html(data);
                $('#NotifikasiTambahBagiHasil').html("");
            }
        });
    });

    //Proses Tambah Sesi Bagi Hasil
    $('#ProsesTambahBagiHasil').submit(function(){
        $('#NotifikasiTambahBagiHasil').html('<div class="spinner-border text-secondary" role="status"><span class="sr-only"></span></div>');
        var form = $('#ProsesTambahBagiHasil')[0];
        var data = new FormData(form);
        $.ajax({
            type 	    : 'POST',
            url 	    : '_Page/BagiHasil/ProsesTambahBagiHasil.php',
            data 	    :  data,
            cache       : false,
            processData : false,
            contentType : false,
            enctype     : 'multipart/form-data',
            success     : function(data){
                $('#NotifikasiTambahBagiHasil').html(data);
                var NotifikasiTambahBagiHasilBerhasil=$('#NotifikasiTambahBagiHasilBerhasil').html();
                if(NotifikasiTambahBagiHasilBerhasil=="Success"){
                    $('#ProsesTambahBagiHasil')[0].reset();
                    $('#ProsesFilter')[0].reset();
                    ShowData();
                    $('#NotifikasiTambahBagiHasil').html('');
                    $('#ModalTambahBagiHasil').modal('hide');
                    Swal.fire(
                        'Success!',
                        'Tambah Sesi Bagi Hasil (SHU) Berhasil!',
                        'success'
                    )
                }
            }
        });
    });

    //Modal Detail Bagi Hasil
    $('#ModalDetailBagiHasil').on('show.bs.modal', function (e) {
        var id_shu_session = $(e.relatedTarget).data('id');
        $('#FormDetailBagiHasil').html("Loading...");
        $.ajax({
            type 	    : 'POST',
            url 	    : '_Page/BagiHasil/FormDetailBagiHasil.php',
            data 	    :  {id_shu_session: id_shu_session},
            success     : function(data){
                $('#FormDetailBagiHasil').html(data);
            }
        });
    });

    //Modal Edit Bagi Hasil
    $('#ModalEditBagiHasil').on('show.bs.modal', function (e) {
        var id_shu_session = $(e.relatedTarget).data('id');
        $('#FormEditBagiHasil').html("Loading...");
        $.ajax({
            type 	    : 'POST',
            url 	    : '_Page/BagiHasil/FormEditBagiHasil.php',
            data        : {id_shu_session: id_shu_session},
            success     : function(data){
                $('#FormEditBagiHasil').html(data);
                $('#NotifikasiEditBagiHasil').html('');
            }
        });
    });

    //Proses Edit Sesi Bagi Hasil
    $('#ProsesEditBagiHasil').submit(function(){
        $('#NotifikasiEditBagiHasil').html('<div class="spinner-border text-secondary" role="status"><span class="sr-only"></span></div>');
        var form = $('#ProsesEditBagiHasil')[0];
        var data = new FormData(form);
        $.ajax({
            type 	    : 'POST',
            url 	    : '_Page/BagiHasil/ProsesEditBagiHasil.php',
            data 	    :  data,
            cache       : false,
            processData : false,
            contentType : false,
            enctype     : 'multipart/form-data',
            success     : function(data){
                $('#NotifikasiEditBagiHasil').html(data);
                var NotifikasiEditBagiHasilBerhasil=$('#NotifikasiEditBagiHasilBerhasil').html();
                if(NotifikasiEditBagiHasilBerhasil=="Success"){
                    $('#ProsesEditBagiHasil')[0].reset();
                    if ($("#GetIdShuSession").length) {
                        var id_shu_session=$('#GetIdShuSession').val();
                        show_shu_inline(id_shu_session);
                    }else{
                        ShowData();
                    }
                    
                    $('#NotifikasiEditBagiHasil').html('');
                    $('#ModalEditBagiHasil').modal('hide');
                    Swal.fire(
                        'Success!',
                        'Edit Sesi Bagi Hasil (SHU) Berhasil!',
                        'success'
                    )
                }
            }
        });
    });
    //Modal Form Hapus Bagi Hasil
    $('#ModalHapusBagiHasil').on('show.bs.modal', function (e) {
        var id_shu_session = $(e.relatedTarget).data('id');
        $('#FormHapusBagiHasil').html("Loading...");
        $.ajax({
            type 	    : 'POST',
            url 	    : '_Page/BagiHasil/FormHapusBagiHasil.php',
            data        : {id_shu_session: id_shu_session},
            success     : function(data){
                $('#FormHapusBagiHasil').html(data);
                $('#NotifikasiHapusSesiBagiHasil').html('<small><code>Apakah Anda Yakin Akan Menghapus Sesi Bagi Hasil Ini?</code></small>');
            }
        });
    });
    
    //Proses Hapus Sesi Bagi Hasil
    $('#ProsesHapusBagiHasil').submit(function(){
        $('#NotifikasiHapusSesiBagiHasil').html('<div class="spinner-border text-secondary" role="status"><span class="sr-only"></span></div>');
        var form = $('#ProsesHapusBagiHasil')[0];
        var data = new FormData(form);
        $.ajax({
            type 	    : 'POST',
            url 	    : '_Page/BagiHasil/ProsesHapusBagiHasil.php',
            data 	    :  data,
            cache       : false,
            processData : false,
            contentType : false,
            enctype     : 'multipart/form-data',
            success     : function(data){
                $('#NotifikasiHapusSesiBagiHasil').html(data);
                var NotifikasiHapusSesiBagiHasilBerhasil=$('#NotifikasiHapusSesiBagiHasilBerhasil').html();
                if(NotifikasiHapusSesiBagiHasilBerhasil=="Success"){
                    $('#ProsesHapusBagiHasil')[0].reset();
                    ShowData();
                    $('#NotifikasiHapusSesiBagiHasil').html('');
                    $('#ModalHapusBagiHasil').modal('hide');
                    Swal.fire(
                        'Success!',
                        'Hapus Sesi Bagi Hasil (SHU) Berhasil!',
                        'success'
                    )
                }
            }
        });
    });

    //Modal Hitung Otomatis
    $('#ModalHitungShu').on('show.bs.modal', function (e) {
        var id_shu_session = $(e.relatedTarget).data('id');
        $('#FormHitungShu').html("Loading...");
        $.ajax({
            type 	    : 'POST',
            url 	    : '_Page/BagiHasil/FormHitungShu.php',
            data        : {id_shu_session: id_shu_session},
            success     : function(data){
                $('#FormHitungShu').html(data);
                //Sembunyikan Notifikasi
                $('#NotifikasiHitungShu').hide();
            }
        });
    });

    //Ketika Proses Dimulai
    $('#ProsesHitungShu').submit(function(){
        $('#NotifikasiHitungShu').show();
        hitung_shu_anggota();
    });

    //Modal Export Rincian Bagi Hasil
    $('#ModalExportRincianShu').on('show.bs.modal', function (e) {
        var id_shu_session = $(e.relatedTarget).data('id');
        $('#FormExportRincianShu').html("Loading...");
        $.ajax({
            type 	    : 'POST',
            url 	    : '_Page/BagiHasil/FormExportRincianShu.php',
            data        : {id_shu_session: id_shu_session},
            success     : function(data){
                $('#FormExportRincianShu').html(data);
                $('#NotifikasiExportRincianShu').html("");
            }
        });
    });

    //Ketika Proses Export Rincian di 'Submit'
    $('#ProsesExportRincianShu').submit(function (e) {
        e.preventDefault(); // Mencegah submit default
    
        $('#NotifikasiExportRincianShu').html('Loading...');
        
        // Tangkap Data
        var id_shu_session = $('#put_id_shu_session_for_export_rincian').val();
        var format_export_rincian = $('#format_export_rincian').val();
    
        // Apabila Format/type belum dipilih
        if (!format_export_rincian) {
            $('#NotifikasiExportRincianShu').html('<div class="alert alert-danger"><small>Anda belum memilih format/type data yang diinginkan!</small></div>');
        } else {
            var url_export = (format_export_rincian == "HTML") 
                ? '_Page/BagiHasil/ProsesExportRincianHtml.php' 
                : '_Page/BagiHasil/ProsesExportRincianExcel.php';
    
            // Membuat form secara dinamis
            var form = $('<form>', {
                method: 'POST',
                action: url_export,
                target: '_blank' // Membuka di tab baru
            }).append($('<input>', {
                type: 'hidden',
                name: 'id_shu_session',
                value: id_shu_session
            }));
    
            // Menambahkan form ke body dan mengirimkan data
            $('body').append(form);
            form.submit();
            form.remove(); // Menghapus form setelah submit

            $('#NotifikasiExportRincianShu').html('');
        }
    });

    //Modal Import Rincian
    $('#ModalImportRincian').on('show.bs.modal', function (e) {
        var id_shu_session = $(e.relatedTarget).data('id');
        $.ajax({
            type        : 'POST',
            url         : '_Page/BagiHasil/_detail_bagi_hasil.php',
            data        : {id_shu_session: id_shu_session},
            dataType    : "json",
            success: function(response) {
                if(response.status=="Success"){
                    var dataset=response.dataset;
                    if(dataset.status=="Pending"){
                        //Reset Form
                        $('#ProsesImportRincian')[0].reset();

                        //Kosongkan Notifikasi
                        $('#NotifikasiImportRincian').html("");

                        //Tempelkan 'id_shu_session' ke form 'put_id_shu_session_to_import'
                        $('#put_id_shu_session_to_import').val(id_shu_session);

                        //Enable button
                        $('#ButtonImportRincian').prop("disabled", false);
                    }else{
                        $('#NotifikasiImportRincian').html('<div class="alert alert-danger">Status SHU Tersebut Sudah Teralokasikan! Anda Tidak Bisa Mengubah Data Ini</div>');
                        $('#ButtonImportRincian').prop("disabled", true);
                    }
                }else{
                    //Apabila Terdapat kesalahan Tampilkan Pesan kesalahan dalam bentuk swal
                    Swal.fire(
                        'Opss!',
                        response.message,
                        'error'
                    );
                    $('#ButtonImportRincian').prop("disabled", true);
                }
            },
            //Apabila Terdapat kesalahan Tampilkan Swal
            error: function () {
                Swal.fire(
                    'Opss!',
                    'Terjadi kesalahan pada saat menampilkan detail SHU',
                    'error'
                );
                $('#ButtonImportRincian').prop("disabled", true);
            }
        });
        
    });

    //Validasi File Yang Di Upload
    document.getElementById('file_import_rincian').addEventListener('change', function(event) {
        var file = event.target.files[0]; // Ambil file yang diupload
        var allowedExtensions = ['xlsx', 'xls']; // Ekstensi yang diizinkan
        var maxSize = 10 * 1024 * 1024; // Maksimal 10 MB
        var notificationElement = document.getElementById('NotifikasiImportRincian');
    
        // Bersihkan notifikasi sebelumnya
        notificationElement.innerHTML = '';
    
        if (!file) {
            return; // Jika tidak ada file yang dipilih, tidak perlu validasi
        }
    
        var fileExtension = file.name.split('.').pop().toLowerCase(); // Ambil ekstensi file
        var fileSize = file.size; // Ukuran file dalam byte
    
        // Validasi ekstensi file
        if (!allowedExtensions.includes(fileExtension)) {
            notificationElement.innerHTML = `<div class="alert alert-danger">Format file tidak valid! Harap unggah file Excel (.xlsx / .xls).</div>`;
            event.target.value = ''; // Reset input file
            return;
        }
    
        // Validasi ukuran file
        if (fileSize > maxSize) {
            notificationElement.innerHTML = `<div class="alert alert-danger">Ukuran file terlalu besar! Maksimal 10 MB.</div>`;
            event.target.value = ''; // Reset input file
            return;
        }
    
        // Jika lolos validasi, tampilkan notifikasi sukses
        notificationElement.innerHTML = `<div class="alert alert-success">File valid! Siap untuk diimport.</div>`;
    });

    //Proses Import Data
    $('#ProsesImportRincian').submit(function(e) {
        e.preventDefault(); // Mencegah form dikirim secara default

        var formData = new FormData(this); // Ambil semua data dalam form
        var notificationElement = $('#NotifikasiImportRincian');

        // Tampilkan loading sementara
        notificationElement.html('<div class="alert alert-info">Memproses import, mohon tunggu...</div>');

        $.ajax({
            url         : '_Page/BagiHasil/ProsesImportRincian.php', // Tujuan request
            type        : 'POST',
            data        : formData,
            contentType : false, 
            processData : false,
            success: function(response) {
                // Menampilkan hasil dari server
                $('#NotifikasiImportRincian').html(response);
            },
            error: function(xhr, status, error) {
                notificationElement.html('<div class="alert alert-danger">Terjadi kesalahan: ' + error + '</div>');
            }
        });
    });

    //Modal Pilih Anggota Muncul
    $('#ModalPilihAnggota').on('show.bs.modal', function (e) {
        var id_shu_session = $(e.relatedTarget).data('id');

        //Tempelkan Ke Form
        $('#put_id_shu_session_pilih_anggota').val(id_shu_session);

        //Reset Halaman
        $('#put_page_for_pilih_anggota').val(1);

        //Jalankan Function
        ShowPilihAnggota();

    });

    //Pagging Anggota
    $(document).on('click', '#next_button_anggota', function() {
        var page_now = parseInt($('#put_page_for_pilih_anggota').val(), 10); // Pastikan nilai diambil sebagai angka
        var next_page = page_now + 1;
        $('#put_page_for_pilih_anggota').val(next_page);
        ShowPilihAnggota();
    });
    $(document).on('click', '#prev_button_anggota', function() {
        var page_now = parseInt($('#put_page_for_pilih_anggota').val(), 10); // Pastikan nilai diambil sebagai angka
        var next_page = page_now - 1;
        $('#put_page_for_pilih_anggota').val(next_page);
        ShowPilihAnggota();
    });

    //Modal Tambah Rincian Manual
    $('#ModalTambahRincianManual').on('show.bs.modal', function (e) {
        var id_anggota = $(e.relatedTarget).data('id_anggota');
        var id_shu_session = $(e.relatedTarget).data('id_shu_session');

        //Kosongkan Notifikasi
        $('#FormTambahRincianManual').html("Loading...");

        //Tampilkan Form
        $.ajax({
            url         : '_Page/BagiHasil/FormTambahRincianManual.php', // Tujuan request
            type        : 'POST',
            data        : {id_anggota: id_anggota, id_shu_session: id_shu_session},
            success: function(response) {
                // Menampilkan hasil dari server
                $('#FormTambahRincianManual').html(response);

                //Panggil Fungsi Money
                initializeMoneyInputs();

                //Panggil Fungsi Calculate SHU
                calculateSHU();

                // Event listener untuk menghitung total SHU setiap kali input berubah
                $("#jasa_penjualan_manual, #jasa_simpanan_manual, #jasa_pinjaman_manual").on("input", function () {
                    calculateSHU();
                });
            }
        });

        //Tempelkan Pada Tombol Kembali
        $('.btn-dark[data-bs-target="#ModalPilihAnggota"]').attr("data-id", id_anggota);

        

    });

    //Proses Tambah SHU Manual
    $('#ProsesTambahRincianManual').submit(function(){
        $('#NotifikasiTambahRincianManual').html('<div class="spinner-border text-secondary" role="status"><span class="sr-only"></span></div>');
        var form = $('#ProsesTambahRincianManual')[0];
        var data = new FormData(form);
        $.ajax({
            type 	    : 'POST',
            url 	    : '_Page/BagiHasil/ProsesTambahRincianManual.php',
            data 	    :  data,
            cache       : false,
            processData : false,
            contentType : false,
            enctype     : 'multipart/form-data',
            success     : function(data){
                $('#NotifikasiTambahRincianManual').html(data);
                var NotifikasiTambahRincianManualBerhasil=$('#NotifikasiTambahRincianManualBerhasil').html();
                if(NotifikasiTambahRincianManualBerhasil=="Success"){
                    $('#ProsesTambahRincianManual')[0].reset();
                    ShowRincianBagiHasil();
                    $('#NotifikasiTambahRincianManual').html('');
                    $('#ModalTambahRincianManual').modal('hide');
                    Swal.fire(
                        'Success!',
                        'Tambah Rincian Bagi Hasil Manual (SHU) Berhasil!',
                        'success'
                    )
                }
            }
        });
    });

    //Modal Rincian SHU
    $('#ModalDetailRincian').on('show.bs.modal', function (e) {
        var id_shu_rincian = $(e.relatedTarget).data('id');

        //Loading Form
        $('#FormDetailRincian').html("Loading...");

        //Tampilkan Form
        $.ajax({
            url         : '_Page/BagiHasil/detail_rincian.php',
            type        : 'POST',
            data        : {id_shu_rincian: id_shu_rincian},
            dataType    : "json",
            success: function(response) {
                if(response.status=="Success"){
                    //Apabila Berhasil Ambil Data
                    var dataset=response.dataset;
                    var nama_anggota=dataset.nama_anggota;
                    var nip=dataset.nip;
                    var simpanan_rp=dataset.simpanan_rp;
                    var pinjaman_rp=dataset.pinjaman_rp;
                    var penjualan_rp=dataset.penjualan_rp;
                    var jasa_simpanan_rp=dataset.jasa_simpanan_rp;
                    var jasa_pinjaman_rp=dataset.jasa_pinjaman_rp;
                    var jasa_penjualan_rp=dataset.jasa_penjualan_rp;
                    var shu_rp=dataset.shu_rp;
                    
                    //Tampilkan pada element html
                    $('#FormDetailRincian').html(`
                        <div class="row mb-2">
                            <div class="col-4"><small>Nama Anggota</small></div>
                            <div class="col-1"><small>:</small></div>
                            <div class="col-7"><small class="text text-muted">${nama_anggota}</small></div>
                        </div>
                        <div class="row mb-2">
                            <div class="col-4"><small>Nomor Induk</small></div>
                            <div class="col-1"><small>:</small></div>
                            <div class="col-7"><small class="text text-muted">${nip}</small></div>
                        </div>
                        <div class="row mb-2">
                            <div class="col-4"><small>Simpanan</small></div>
                            <div class="col-1"><small>:</small></div>
                            <div class="col-7"><small class="text text-muted">${simpanan_rp}</small></div>
                        </div>
                        <div class="row mb-2">
                            <div class="col-4"><small>Pinjaman</small></div>
                            <div class="col-1"><small>:</small></div>
                            <div class="col-7"><small class="text text-muted">${pinjaman_rp}</small></div>
                        </div>
                        <div class="row mb-2">
                            <div class="col-4"><small>Penjualan</small></div>
                            <div class="col-1"><small>:</small></div>
                            <div class="col-7"><small class="text text-muted">${penjualan_rp}</small></div>
                        </div>
                        <div class="row mb-2">
                            <div class="col-4"><small>Jasa Simpanan</small></div>
                            <div class="col-1"><small>:</small></div>
                            <div class="col-7"><small class="text text-muted">${jasa_simpanan_rp}</small></div>
                        </div>
                        <div class="row mb-2">
                            <div class="col-4"><small>Jasa Pinjaman</small></div>
                            <div class="col-1"><small>:</small></div>
                            <div class="col-7"><small class="text text-muted">${jasa_pinjaman_rp}</small></div>
                        </div>
                        <div class="row mb-2">
                            <div class="col-4"><small>Jasa Penjualan</small></div>
                            <div class="col-1"><small>:</small></div>
                            <div class="col-7"><small class="text text-muted">${jasa_penjualan_rp}</small></div>
                        </div>
                        <div class="row mb-2">
                            <div class="col-4"><small>SHU Anggota</small></div>
                            <div class="col-1"><small>:</small></div>
                            <div class="col-7"><small class="text text-muted">${shu_rp}</small></div>
                        </div>
                    `);
                }else{
                    //Apabila Terjadi kesalahan
    
                    //tampilkan swal
                    Swal.fire(
                        'Opss!',
                        response.message,
                        'error'
                    );
                }
            },
            error: function () {
                //Apabila Terdapat kesalahan Tampilkan Swal
                Swal.fire(
                    'Opss!',
                    'Terjadi kesalahan pada saat Menampilkan detail rincian',
                    'error'
                );
            }
        });

    });

    //Modal Edit Rincian
    $('#ModalEditRincian').on('show.bs.modal', function (e) {
        var id_shu_rincian = $(e.relatedTarget).data('id');

        //Loading Form
        $('#FormEditRincian').html("Loading...");

        //Disable tombol
        $('#ButtonEditRincian').prop("disabled", true);

        //Buka Data Dengan Ajax
        $.ajax({
            url         : '_Page/BagiHasil/detail_rincian.php',
            type        : 'POST',
            data        : {id_shu_rincian: id_shu_rincian},
            dataType    : "json",
            success: function(response) {
                if(response.status=="Success"){
                    //Apabila Berhasil Ambil Data
                    var dataset=response.dataset;
                    var nama_anggota=dataset.nama_anggota;
                    var nip=dataset.nip;
                    var simpanan=dataset.simpanan;
                    var pinjaman=dataset.pinjaman;
                    var penjualan=dataset.penjualan;
                    var jasa_simpanan=dataset.jasa_simpanan;
                    var jasa_pinjaman=dataset.jasa_pinjaman;
                    var jasa_penjualan=dataset.jasa_penjualan;
                    var shu=dataset.shu;
                    var status=response.shu_session.status;

                    if(status!=="Pending"){
                        $('#FormEditRincian').html(`
                            <div class="alert alert-danger">
                                <div class="small">
                                    Sesi SHU Sudah Teralokasikan! Anda Tidak Bisa Mengubah Data Ini!
                                </div>
                            </div>
                        `);

                        //Disable Button
                        $('#ButtonEditRincian').prop("disabled", true);
                    }else{
                        //Tampilkan pada element html
                        $('#FormEditRincian').html(`
                            <input type="hidden" name="id_shu_rincian" value="${id_shu_rincian}">
                            <div class="row mb-3">
                                <div class="col-4">
                                    <small>Nama Anggota</small>
                                </div>
                                <div class="col-8"><small class="text text-muted">${nama_anggota}</small></div>
                            </div>
                            <div class="row mb-3">
                                <div class="col-4">
                                    <small>Nomor Induk</small>
                                </div>
                                <div class="col-8"><small class="text text-muted">${nip}</small></div>
                            </div>
                            <div class="row mb-3">
                                <div class="col-4">
                                    <label for="penjualan_manual_edit">
                                        <small>Jumlah Penjualan</small>
                                    </label>
                                </div>
                                <div class="col-8">
                                    <input type="text" name="penjualan" id="penjualan_manual_edit" class="form-control form-money" value="${penjualan}">
                                </div>
                            </div>
                            <div class="row mb-3">
                                <div class="col-4">
                                    <label for="simpanan_manual_edit">
                                        <small>Jumlah Simpanan</small>
                                    </label>
                                </div>
                                <div class="col-8">
                                    <input type="text" name="simpanan" id="simpanan_manual_edit" class="form-control form-money" value="${simpanan}">
                                </div>
                            </div>
                            <div class="row mb-3">
                                <div class="col-4">
                                    <label for="pinjaman_manual_edit">
                                        <small>Jumlah Pinjaman</small>
                                    </label>
                                </div>
                                <div class="col-8">
                                    <input type="text" name="pinjaman" id="pinjaman_manual_edit" class="form-control form-money" value="${pinjaman}">
                                </div>
                            </div>
                            <div class="row mb-3">
                                <div class="col-4">
                                    <label for="jasa_penjualan_manual_edit">
                                        <small>Jasa Penjualan</small>
                                    </label>
                                </div>
                                <div class="col-8">
                                    <input type="text" name="jasa_penjualan" id="jasa_penjualan_manual_edit" class="form-control form-money" value="${jasa_penjualan}">
                                </div>
                            </div>
                            <div class="row mb-3">
                                <div class="col-4">
                                    <label for="jasa_simpanan_manual_edit">
                                        <small>Jasa Siimpanan</small>
                                    </label>
                                </div>
                                <div class="col-8">
                                    <input type="text" name="simpanan_manual" id="jasa_simpanan_manual_edit" class="form-control form-money" value="${jasa_simpanan}">
                                </div>
                            </div>
                            <div class="row mb-3">
                                <div class="col-4">
                                    <label for="jasa_pinjaman_manual_edit">
                                        <small>Jasa Pinjaman</small>
                                    </label>
                                </div>
                                <div class="col-8">
                                    <input type="text" name="jasa_pinjaman" id="jasa_pinjaman_manual_edit" class="form-control form-money" value="${jasa_pinjaman}">
                                </div>
                            </div>
                            <div class="row mb-3">
                                <div class="col-4">
                                    <label for="shu_manual_edit">
                                        <small>Jumlah SHU</small>
                                    </label>
                                </div>
                                <div class="col-8">
                                    <input type="text" readonly name="shu" id="shu_manual_edit" class="form-control form-money" value="${shu}">
                                </div>
                            </div>
                        `);

                        $('#ButtonEditRincian').prop("disabled", false);
                        //Panggil Fungsi Money
                        initializeMoneyInputs();
                        
                        //Panggil Fungsi Calculate SHU
                        calculateSHUEdit();

                        // Event listener untuk menghitung total SHU setiap kali input berubah
                        $("#jasa_penjualan_manual_edit, #jasa_simpanan_manual_edit, #jasa_pinjaman_manual_edit").on("input", function () {
                            calculateSHUEdit();
                        });
                    }

                }else{
                    //Apabila Terjadi kesalahan
    
                    //tampilkan swal
                    Swal.fire(
                        'Selesai!',
                        response.message,
                        'error'
                    );

                    //Disable Button
                    $('#ButtonEditRincian').prop("disabled", true);
                }
            },
            error: function () {
                //Apabila Terdapat kesalahan Tampilkan Swal
                Swal.fire(
                    'Opss!',
                    'Terjadi kesalahan pada saat membuka data rincian',
                    'error'
                );

                //Disable Button
                $('#ButtonEditRincian').prop("disabled", true);
            }
        });
    });
    
    //Proses Edit SHU Manual
    $('#ProsesEditRincian').submit(function(){
        $('#NotifikasiEditRincian').html('<div class="spinner-border text-secondary" role="status"><span class="sr-only"></span></div>');
        var form = $('#ProsesEditRincian')[0];
        var data = new FormData(form);
        $.ajax({
            type 	    : 'POST',
            url 	    : '_Page/BagiHasil/ProsesEditRincian.php',
            data 	    :  data,
            cache       : false,
            processData : false,
            contentType : false,
            enctype     : 'multipart/form-data',
            success     : function(data){
                $('#NotifikasiEditRincian').html(data);
                var NotifikasiEditRincianBerhasil=$('#NotifikasiEditRincianBerhasil').html();
                if(NotifikasiEditRincianBerhasil=="Success"){
                    $('#ProsesEditRincian')[0].reset();
                    ShowRincianBagiHasil();
                    $('#NotifikasiEditRincian').html('');
                    $('#ModalEditRincian').modal('hide');
                    Swal.fire(
                        'Success!',
                        'Edit Rincian Bagi Hasil Manual (SHU) Berhasil!',
                        'success'
                    )
                }
            }
        });
    });

    //Modal Hapus Rincian
    $('#ModalHapusRincianShu').on('show.bs.modal', function (e) {
        var id_shu_rincian = $(e.relatedTarget).data('id');

        //Loading Form
        $('#FormHapusRincianShu').html("Loading...");

        //Kosongkan Notifikasi
        $('#NotifikasiHapusRincianShu').html("");

        //Disable Tombol
        $('#ButtonHapusRincianShu').prop("disabled", true);

        //Buka Data Dengan Ajax
        $.ajax({
            url         : '_Page/BagiHasil/detail_rincian.php',
            type        : 'POST',
            data        : {id_shu_rincian: id_shu_rincian},
            dataType    : "json",
            success: function(response) {
                if(response.status=="Success"){
                    //Apabila Berhasil Ambil Data
                    var dataset=response.dataset;
                    var nama_anggota=dataset.nama_anggota;
                    var nip=dataset.nip;
                    var jasa_simpanan_rp=dataset.jasa_simpanan_rp;
                    var jasa_pinjaman_rp=dataset.jasa_pinjaman_rp;
                    var jasa_penjualan_rp=dataset.jasa_penjualan_rp;
                    var shu_rp=dataset.shu_rp;
                    var status=response.shu_session.status;
                    if(status=="Pending"){
                        //Tampilkan pada element html
                        $('#FormHapusRincianShu').html(`
                            <input type="hidden" name="id_shu_rincian" value="${id_shu_rincian}">
                            <div class="row mb-3">
                                <div class="col-4">
                                    <small>Nama Anggota</small>
                                </div>
                                <div class="col-8"><small class="text text-muted">${nama_anggota}</small></div>
                            </div>
                            <div class="row mb-3">
                                <div class="col-4">
                                    <small>Nomor Induk</small>
                                </div>
                                <div class="col-8"><small class="text text-muted">${nip}</small></div>
                            </div>
                            <div class="row mb-3">
                                <div class="col-4">
                                    <small>Jasa Simpanan</small>
                                </div>
                                <div class="col-8"><small class="text text-muted">${jasa_simpanan_rp}</small></div>
                            </div>
                            <div class="row mb-3">
                                <div class="col-4">
                                    <small>Jasa Pinjaman</small>
                                </div>
                                <div class="col-8"><small class="text text-muted">${jasa_pinjaman_rp}</small></div>
                            </div>
                            <div class="row mb-3">
                                <div class="col-4">
                                    <small>Jasa Penjualan</small>
                                </div>
                                <div class="col-8"><small class="text text-muted">${jasa_penjualan_rp}</small></div>
                            </div>
                            <div class="row mb-3">
                                <div class="col-4">
                                    <small>SHU Anggota</small>
                                </div>
                                <div class="col-8"><small class="text text-muted">${shu_rp}</small></div>
                            </div>
                            <div class="row mb-3">
                                <div class="col-12">
                                    <small>Apakah anda yakin akan menghapus data tersebut?</small>
                                </div>
                            </div>
                        `);

                        //Enable Tombol
                        $('#ButtonHapusRincianShu').prop("disabled", false);
                    }else{
                        $('#FormHapusRincianShu').html(`
                            <div class="alert alert-danger">
                                Sesi SHU Sudah Teralokasikan! Anda Tidak Bisa Menghapus Data Ini!
                            </div>
                        `);
                        $('#ButtonHapusRincianShu').prop("disabled", true);
                    }
                }else{
                    //Apabila Terjadi kesalahan
    
                    //tampilkan swal
                    Swal.fire(
                        'Selesai!',
                        response.message,
                        'error'
                    );

                    //Disable Tombol
                    $('#ButtonHapusRincianShu').prop("disabled", true);
                }
            },
            error: function () {
                //Apabila Terdapat kesalahan Tampilkan Swal
                Swal.fire(
                    'Opss!',
                    'Terjadi kesalahan pada saat membuka data rincian',
                    'error'
                );
                
                //Disable Tombol
                $('#ButtonHapusRincianShu').prop("disabled", true);
            }
        });
    });

    //Proses Hapus Rincian
    $('#ProsesHapusRincianShu').submit(function(){
        //Loading Notifikasi
        $('#NotifikasiHapusRincianShu').html('<div class="spinner-border text-secondary" role="status"><span class="sr-only"></span></div>');

        //Kirim Data Dengan AJAX
        var form = $('#ProsesHapusRincianShu')[0];
        var data = new FormData(form);
        $.ajax({
            type 	    : 'POST',
            url 	    : '_Page/BagiHasil/ProsesHapusRincianShu.php',
            data 	    :  data,
            cache       : false,
            processData : false,
            contentType : false,
            enctype     : 'multipart/form-data',
            success     : function(data){
                $('#NotifikasiHapusRincianShu').html(data);

                //Tangkap Notifikasi
                var NotifikasiHapusRincianShuBerhasil=$('#NotifikasiHapusRincianShuBerhasil').html();
                if(NotifikasiHapusRincianShuBerhasil=="Success"){

                    //Apabila Berhasil
                    ShowRincianBagiHasil();
                    
                    //Tutup Modal
                    $('#ModalHapusRincianShu').modal('hide');

                    //Tampilkan Swal
                    Swal.fire(
                        'Success!',
                        'Hapus Rincian Bagi Hasil Manual (SHU) Berhasil!',
                        'success'
                    )
                }
            }
        });
    });

    //Modal Hapus Semua Rincian
    $('#ModalHapusSemuaRincian').on('show.bs.modal', function (e) {
        var id_shu_session = $(e.relatedTarget).data('id');

        //Loading Form
        $('#FormHapusSemuaRincian').html("Loading...");

        //Kosongkan Notifikasi
        $('#NotifikasiHapusSemuaRincian').html("");

        //Disable Tombol
        $('#ButtonHapusSemuaRincian').prop("disabled", true);

        //Buka Data Dengan Ajax
        $.ajax({
            url         : '_Page/BagiHasil/_detail_bagi_hasil.php',
            type        : 'POST',
            data        : {id_shu_session: id_shu_session},
            dataType    : "json",
            success: function(response) {
                if(response.status=="Success"){
                    //Apabila Berhasil Ambil Data
                    var dataset=response.dataset;
                    var JumlahRincian_rp=dataset.JumlahRincian_rp;
                    var periode_hitung1=dataset.periode_hitung1;
                    var periode_hitung2=dataset.periode_hitung2;
                    var status=dataset.status;
                    
                    if(status!=="Pending"){
                        $('#FormHapusSemuaRincian').html(`
                            <div class="alert alert-danger">
                                <div class="small">
                                    Sesi SHU Sudah Teralokasikan! Anda Tidak Bisa Mengubah Data Ini!
                                </div>
                            </div>
                        `);
                        $('#ButtonHapusSemuaRincian').prop("disabled", true);
                    }else{
                        //Tampilkan pada element html
                        $('#FormHapusSemuaRincian').html(`
                            <input type="hidden" name="id_shu_session" value="${id_shu_session}">
                            <div class="row mb-3">
                                <div class="col-4">
                                    <small>Periode Sesi SHU</small>
                                </div>
                                <div class="col-8"><small class="text text-muted">${periode_hitung1} - ${periode_hitung2}</small></div>
                            </div>
                            <div class="row mb-3">
                                <div class="col-4">
                                    <small>Status</small>
                                </div>
                                <div class="col-8"><small class="text text-muted">${status}</small></div>
                            </div>
                            <div class="row mb-3">
                                <div class="col-4">
                                    <small>Jumlah Rincian</small>
                                </div>
                                <div class="col-8"><small class="text text-muted">${JumlahRincian_rp} Record</small></div>
                            </div>
                            <div class="row mb-3">
                                <div class="col-12">
                                    <small>Apakah anda yakin ingin menghapus semua data rincian Sesi SHU tersebut?</small>
                                </div>
                            </div>
                        `);

                        //Enable Tombol
                        $('#ButtonHapusSemuaRincian').prop("disabled", false);
                    }
                    
                }else{
                    //Apabila Terjadi kesalahan
    
                    //tampilkan swal
                    Swal.fire(
                        'Selesai!',
                        response.message,
                        'error'
                    );

                    //Disable Tombol
                    $('#ButtonHapusSemuaRincian').prop("disabled", true);
                }
            },
            error: function () {
                //Apabila Terdapat kesalahan Tampilkan Swal
                Swal.fire(
                    'Opss!',
                    'Terjadi kesalahan pada saat membuka data sesi SHU',
                    'error'
                );
                
                //Disable Tombol
                $('#ButtonHapusSemuaRincian').prop("disabled", true);
            }
        });
    });

    //Proses Menghapus Semua Data Rincian
    $('#ProsesHapusSemuaRincian').submit(function(){
        //Loading Notifikasi
        $('#NotifikasiHapusSemuaRincian').html('<div class="spinner-border text-secondary" role="status"><span class="sr-only"></span></div>');

        //Kirim Data Dengan AJAX
        var form = $('#ProsesHapusSemuaRincian')[0];
        var data = new FormData(form);
        $.ajax({
            type 	    : 'POST',
            url 	    : '_Page/BagiHasil/ProsesHapusSemuaRincian.php',
            data 	    :  data,
            cache       : false,
            processData : false,
            contentType : false,
            enctype     : 'multipart/form-data',
            success     : function(data){
                $('#NotifikasiHapusSemuaRincian').html(data);

                //Tangkap Notifikasi
                var NotifikasiHapusSemuaRincianBerhasil=$('#NotifikasiHapusSemuaRincianBerhasil').html();
                if(NotifikasiHapusSemuaRincianBerhasil=="Success"){

                    //Apabila Berhasil
                    ShowRincianBagiHasil();
                    
                    //Tutup Modal
                    $('#ModalHapusSemuaRincian').modal('hide');

                    //Tampilkan Swal
                    Swal.fire(
                        'Success!',
                        'Hapus Rincian Bagi Hasil Manual (SHU) Berhasil!',
                        'success'
                    )
                }
            }
        });
    });

    //Modal Detail Anggota
    $('#ModalDetailAnggota').on('show.bs.modal', function (e) {
        var id_anggota = $(e.relatedTarget).data('id');
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

    //Modal Update Status SHU
    $('#ModalUpdateStatusShu').on('show.bs.modal', function (e) {
        var id_shu_session = $(e.relatedTarget).data('id');

        //Loading Form
        $('#FormUpdateStatusShu').html("Loading...");

        //Kosongkan Notifikasi
        $('#NotifikasiUpdateStatusShu').html("");

        //Disable Tombol
        $('#ButtonUpdateStatusShu').prop("disabled", true);

        //Buka Data Dengan Ajax
        $.ajax({
            url         : '_Page/BagiHasil/_detail_bagi_hasil.php',
            type        : 'POST',
            data        : {id_shu_session: id_shu_session},
            dataType    : "json",
            success: function(response) {
                if(response.status=="Success"){
                    //Apabila Berhasil Ambil Data
                    var dataset=response.dataset;
                    var JumlahRincian_rp=dataset.JumlahRincian_rp;
                    var periode_hitung1=dataset.periode_hitung1;
                    var periode_hitung2=dataset.periode_hitung2;
                    var status=dataset.status;
                    var jumlah_alokasi_rp=dataset.jumlah_alokasi_rp;
                    
                    //Tampilkan pada element html
                    $('#FormUpdateStatusShu').html(`
                        <input type="hidden" name="id_shu_session" value="${id_shu_session}">
                        <div class="row mb-2 mt-3">
                            <div class="col-12">
                                # Detail Informasi Sesi SHU
                            </div>
                        </div>
                        <div class="row mb-2">
                            <div class="col-4">
                                <small>Periode Sesi SHU</small>
                            </div>
                            <div class="col-8"><small class="text text-muted">${periode_hitung1} - ${periode_hitung2}</small></div>
                        </div>
                        <div class="row mb-2">
                            <div class="col-4">
                                <small>Status</small>
                            </div>
                            <div class="col-8"><small class="text text-muted">${status}</small></div>
                        </div>
                        <div class="row mb-4">
                            <div class="col-4">
                                <small>Jumlah Rincian</small>
                            </div>
                            <div class="col-8"><small class="text text-muted">${JumlahRincian_rp} Record</small></div>
                        </div>
                        <div class="row mb-2 mt-3">
                            <div class="col-12">
                                # Akun Jurnal Pembagian SHU
                            </div>
                        </div>
                        <div class="row mb-2">
                            <div class="col-4">
                                <small>Debet</small>
                            </div>
                            <div class="col-8"><small class="text text-muted">${response.auto_jurnal.akun_debet_pembagian}</small></div>
                        </div>
                        <div class="row mb-4">
                            <div class="col-4">
                                <small>Kredit</small>
                            </div>
                            <div class="col-8"><small class="text text-muted">${response.auto_jurnal.akun_kredit_pembagian}</small></div>
                        </div>
                        <div class="row mb-4">
                            <div class="col-4">
                                <small>Nominal</small>
                            </div>
                            <div class="col-8"><small class="text text-muted">${jumlah_alokasi_rp}</small></div>
                        </div>
                        <div class="row mb-2 mt-3">
                            <div class="col-12">
                                # Akun Jurnal Pembayaran SHU
                            </div>
                        </div>
                        <div class="row mb-2">
                            <div class="col-4">
                                <small>Debet</small>
                            </div>
                            <div class="col-8"><small class="text text-muted">${response.auto_jurnal.akun_debet_pembayaran}</small></div>
                        </div>
                        <div class="row mb-2">
                            <div class="col-4">
                                <small>Kredit</small>
                            </div>
                            <div class="col-8"><small class="text text-muted">${response.auto_jurnal.akun_kredit_pembayaran}</small></div>
                        </div>
                        <div class="row mb-4">
                            <div class="col-4">
                                <small>Nominal</small>
                            </div>
                            <div class="col-8"><small class="text text-muted">${jumlah_alokasi_rp}</small></div>
                        </div>
                        <div class="row mb-2">
                            <div class="col-12">
                                <small>Apakah anda yakin ingin melakukan update pada Sesi SHU tersebut?</small>
                            </div>
                        </div>
                    `);

                    //Enable Tombol
                    $('#ButtonUpdateStatusShu').prop("disabled", false);
                }else{
                    //Apabila Terjadi kesalahan
    
                    //tampilkan swal
                    Swal.fire(
                        'Selesai!',
                        response.message,
                        'error'
                    );

                    //Disable Tombol
                    $('#ButtonUpdateStatusShu').prop("disabled", true);
                }
            },
            error: function () {
                //Apabila Terdapat kesalahan Tampilkan Swal
                Swal.fire(
                    'Opss!',
                    'Terjadi kesalahan pada saat membuka data sesi SHU',
                    'error'
                );
                
                //Disable Tombol
                $('#ButtonUpdateStatusShu').prop("disabled", true);
            }
        });
    });

    //Proses Update Sei SHU
    $('#ProsesUpdateStatusShu').submit(function(){
        //Loading Notifikasi
        $('#NotifikasiUpdateStatusShu').html('<div class="spinner-border text-secondary" role="status"><span class="sr-only"></span></div>');

        //Kirim Data Dengan AJAX
        var form = $('#ProsesUpdateStatusShu')[0];
        var data = new FormData(form);
        $.ajax({
            type 	    : 'POST',
            url 	    : '_Page/BagiHasil/ProsesUpdateStatusShu.php',
            data 	    :  data,
            cache       : false,
            processData : false,
            contentType : false,
            enctype     : 'multipart/form-data',
            success     : function(data){
                $('#NotifikasiUpdateStatusShu').html(data);

                //Tangkap Notifikasi
                var NotifikasiUpdateStatusShuBerhasil=$('#NotifikasiUpdateStatusShuBerhasil').html();
                if(NotifikasiUpdateStatusShuBerhasil=="Success"){

                    //Apabila Berhasil
                    var id_shu_session=$('#GetIdShuSession').val();
                    show_shu_inline(id_shu_session);
                    ShowPembayaranShu();
                    ShowRincianBagiHasil();
                    ShowJurnalBagiHasil();
                    
                    //Tutup Modal
                    $('#ModalUpdateStatusShu').modal('hide');

                    //Tampilkan Swal
                    Swal.fire(
                        'Success!',
                        'Update Sesi Bagi Hasil (SHU) Berhasil!',
                        'success'
                    )
                }
            }
        });
    });

    //Modal Tambah Jurnal
    $('#ModalTambahJurnal').on('show.bs.modal', function (e) {
        var id_shu_session = $(e.relatedTarget).data('id');
        $('#FormTambahJurnal').html("Loading...");
        $.ajax({
            type 	    : 'POST',
            url 	    : '_Page/BagiHasil/FormTambahJurnal.php',
            data        : {id_shu_session: id_shu_session},
            success     : function(data){
                $('#FormTambahJurnal').html(data);

                //Kosongkan Notifikasi
                $('#NotifikasiTambahJurnal').html('');
            }
        });
    });

    //Proses Tambah Jurnal
    $('#ProsesTambahJurnal').submit(function(){
        $('#NotifikasiTambahJurnal').html('Loading...');
        var form = $('#ProsesTambahJurnal')[0];
        var data = new FormData(form);
        $.ajax({
            type 	    : 'POST',
            url 	    : '_Page/BagiHasil/ProsesTambahJurnal.php',
            data 	    :  data,
            cache       : false,
            processData : false,
            contentType : false,
            enctype     : 'multipart/form-data',
            success     : function(data){
                $('#NotifikasiTambahJurnal').html(data);
                var NotifikasiTambahJurnalBerhasil=$('#NotifikasiTambahJurnalBerhasil').html();
                if(NotifikasiTambahJurnalBerhasil=="Success"){
                    $('#NotifikasiTambahJurnal').html('');
                    $('#ModalTambahJurnal').modal('hide');
                    Swal.fire(
                        'Success!',
                        'Tambah Jurnal Berhasil!',
                        'success'
                    )
                    //Menampilkan Data
                    ShowJurnalBagiHasil();
                }
            }
        });
    });

    //Modal Edit Jurnal
    $('#ModalEditJurnal').on('show.bs.modal', function (e) {
        var id_jurnal = $(e.relatedTarget).data('id');
        $('#FormEditJurnal').html("Loading...");
        $.ajax({
            type 	    : 'POST',
            url 	    : '_Page/BagiHasil/FormEditJurnal.php',
            data        : {id_jurnal: id_jurnal},
            success     : function(data){
                $('#FormEditJurnal').html(data);
                
                //Kosongkan Notifikasi
                $('#NotifikasiEditJurnal').html('');
            }
        });
    });
    //Proses Edit Jurnal
    $('#ProsesEditJurnal').submit(function(){
        $('#NotifikasiEditJurnal').html('Loading...');
        var form = $('#ProsesEditJurnal')[0];
        var data = new FormData(form);
        $.ajax({
            type 	    : 'POST',
            url 	    : '_Page/BagiHasil/ProsesEditJurnal.php',
            data 	    :  data,
            cache       : false,
            processData : false,
            contentType : false,
            enctype     : 'multipart/form-data',
            success     : function(data){
                $('#NotifikasiEditJurnal').html(data);
                var NotifikasiEditJurnalBerhasil=$('#NotifikasiEditJurnalBerhasil').html();
                if(NotifikasiEditJurnalBerhasil=="Success"){
                    $('#NotifikasiEditJurnal').html('');
                    $('#ModalEditJurnal').modal('hide');
                    Swal.fire(
                        'Success!',
                        'Edit Jurnal Berhasil!',
                        'success'
                    )
                    ShowJurnalBagiHasil();
                }
            }
        });
    });

    //Modal Hapus Jurnal 
    $('#ModalHapusJurnal').on('show.bs.modal', function (e) {
        var id_jurnal = $(e.relatedTarget).data('id');
        $('#FormHapusJurnal').html("Loading...");
        $.ajax({
            type 	    : 'POST',
            url 	    : '_Page/BagiHasil/FormHapusJurnal.php',
            data        : {id_jurnal: id_jurnal},
            success     : function(data){
                $('#FormHapusJurnal').html(data);
                $('#NotifikasiHapusJurnal').html("");
            }
        });
    });
    //Proses Hapus Jurnal 
    $('#ProsesHapusJurnal').submit(function(){
        $('#NotifikasiHapusJurnal').html('Loading...');
        var form = $('#ProsesHapusJurnal')[0];
        var data = new FormData(form);
        $.ajax({
            type 	    : 'POST',
            url 	    : '_Page/BagiHasil/ProsesHapusJurnal.php',
            data 	    :  data,
            cache       : false,
            processData : false,
            contentType : false,
            enctype     : 'multipart/form-data',
            success     : function(data){
                $('#NotifikasiHapusJurnal').html(data);
                var NotifikasiHapusJurnalBerhasil=$('#NotifikasiHapusJurnalBerhasil').html();
                if(NotifikasiHapusJurnalBerhasil=="Success"){
                    $('#NotifikasiHapusJurnal').html('');
                    $('#ModalHapusJurnal').modal('hide');
                    Swal.fire(
                        'Success!',
                        'Hapus Jurnal  Berhasil!',
                        'success'
                    )
                    //Menampilkan Data
                    ShowJurnalBagiHasil();
                }
            }
        });
    });

});













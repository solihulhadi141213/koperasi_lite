//Fungsi Menampilkan Data Akses
function ShowData() {
    var ProsesFilter = $('#ProsesFilter').serialize();
    $('#TabelBarang').html('<tr><td class="text-center">Loading...</td></tr>');
    $.ajax({
        type    : 'POST',
        url     : '_Page/Barang/TabelBarang.php',
        data    : ProsesFilter,
        success: function(data) {
            $('#TabelBarang').html(data);
        }
    });
}
function formatRupiah(angka) {
    return 'Rp ' + parseFloat(angka).toLocaleString('id-ID', { minimumFractionDigits: 0 });
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
function ShowListSatuanMulti(id_barang) {
    $.ajax({
        type    : 'POST',
        url     : '_Page/Barang/ListSatuanMulti.php',
        data    : {id_barang: id_barang},
        success: function(data) {
            $('#informasi_multi_satuan').html(data);
        }
    });
}
function DetailBarangOnModal(id_barang) {
    $.ajax({
        type 	    : 'POST',
        url 	    : '_Page/Barang/detail_barang.php',
        data        : {id_barang: id_barang},
        dataType    : "json",
        success     : function(response){
            if(response.status=="Success"){
                //Sembunyikan Notifikasi Detail Barang
                $("#NotifikasiDetailBarang").hide();

                //Munculkan Form Detail
                $("#form_detail_barang").show();

                //Buka Data
                var data = response.dataset;
                var multi_harga = response.multi_harga || [];

                // Tempelkan Data ke Elemen yang Sesuai
                $('.kode_barang').html(`<code class="text-grayish">${data.kode_barang}</code>`);
                $('.nama_barang').html(`<code class="text-grayish">${data.nama_barang}</code>`);
                $('.kategori_barang').html(`<code class="text-grayish">${data.kategori_barang}</code>`);
                $('.satuan_barang').html(`<code class="text-grayish">${data.konversi} / ${data.satuan_barang}</code>`);
                $('.stok_barang').html(`<code class="text-grayish">${parseFloat(data.stok_barang).toLocaleString('id-ID')} ${data.satuan_barang}</code>`);
                $('.stok_minimum').html(`<code class="text-grayish">${parseFloat(data.stok_minimum).toLocaleString('id-ID')} ${data.satuan_barang} </code>`);
                $('.harga_beli').html(`<code class="text-grayish">${data.harga_beli_format}</code>`);
                $('#put_id_barang_detail').val(id_barang);

                // Pastikan informasi_multi_harga kosong sebelum menambahkan data baru
                $("#informasi_multi_harga").empty();

                // Looping multi_harga dan tambahkan ke tampilan
                $.each(multi_harga, function (index, item) {
                    var row = `<div class="row mb-2">
                                <div class="col-4"><small>${item.kategori_harga}</small></div>
                                <div class="col-8"><small><code class="text-grayish">Rp ${item.harga_format} (${item.persen_laba} %)</code></small></div>
                            </div>`;
                    $("#informasi_multi_harga").append(row);
                });

                //Menampilkan Data Satuan Multi
                ShowListSatuanMulti(id_barang);
            }else{
                //Munculkan Notifikasi Detail Barang
                $("#NotifikasiDetailBarang").show();
                    
                //Sembunyikan Form Detail
                $("#form_detail_barang").hide();

                //Tempelkan Notifikasi
                $('#NotifikasiDetailBarang').html(
                    `<div class="alert alert-danger" role="alert">${response.message}</div>`
                );
            }
        },
        error: function () {
            //Munculkan Notifikasi Detail Barang
            $("#NotifikasiDetailBarang").show();
                
            //Sembunyikan Form Detail
            $("#form_detail_barang").hide();
            
            //Tempelkan Notifikasi
            $('#NotifikasiDetailBarang').html(
                '<div class="alert alert-danger" role="alert">Terjadi kesalahan pada sistem. Silakan coba lagi.</div>'
            );
        },
    });
}
function DetailBarangOnPage(id_barang) {
    $.ajax({
        type 	    : 'POST',
        url 	    : '_Page/Barang/detail_barang.php',
        data        : {id_barang: id_barang},
        dataType    : "json",
        success     : function(response){
            if(response.status=="Success"){
                
                //Buka Data
                var data = response.dataset;
                var multi_harga = response.multi_harga || [];

                // Siapkan HTML untuk multi_harga
                var multiHargaHTML = ``;

                $.each(multi_harga, function(index, item) {
                    multiHargaHTML += `
                        <div class="row mb-2">
                            <div class="col-6"><small>${item.kategori_harga}</small></div>
                            <div class="col-6"><small class="text text-grayish">Rp ${item.harga_format}</small></div>
                        </div>
                    `;
                });

                // Tempelkan Data ke Elemen yang Sesuai
                $('#DetailBarangOnPage').html(`
                    <div class="row">
                        <!-- Kolom Kiri: Informasi Barang -->
                        <div class="col-md-6">
                            <div class="row mb-3">
                                <div class="col-12"><b># Informasi Barang</b></div>
                            </div>
                            <div class="row mb-3">
                                <div class="col-4"><small>Kode Barang</small></div>
                                <div class="col-8"><small class="text text-grayish">${data.kode_barang}</small></div>
                            </div>
                            <div class="row mb-3">
                                <div class="col-4"><small>Nama/Merek</small></div>
                                <div class="col-8"><small class="text text-grayish">${data.nama_barang}</small></div>
                            </div>
                            <div class="row mb-3">
                                <div class="col-4"><small>Kategori Barang</small></div>
                                <div class="col-8"><small class="text text-grayish">${data.kategori_barang}</small></div>
                            </div>
                            <div class="row mb-3">
                                <div class="col-4"><small>Satuan</small></div>
                                <div class="col-8"><small class="text text-grayish">${data.konversi} / ${data.satuan_barang}</small></div>
                            </div>
                            <div class="row mb-3">
                                <div class="col-4"><small>Stok</small></div>
                                <div class="col-8"><small class="text text-grayish">${data.stok_barang} ${data.satuan_barang}</small></div>
                            </div>
                        </div>

                        <!-- Kolom Kanan: Multi Harga -->
                        <div class="col-md-6">
                            <div class="row mb-3">
                                <div class="col-12"><b># Informasi Harga</b></div>
                            </div>
                            <div class="row mb-3">
                                <div class="col-6"><small>Harga Beli</small></div>
                                <div class="col-6"><small class="text text-grayish text-decoration-underline">${data.harga_beli_format}</small></div>
                            </div>
                            ${multiHargaHTML}
                        </div>
                    </div>
                `);
            }else{
                // Tempelkan Notifikasi
                $('#DetailBarangOnPage').html(
                    `<div class="alert alert-danger" role="alert">${response.message}</div>`
                );
            }
        },
        error: function () {
            // Tempelkan Notifikasi
            $('#DetailBarangOnPage').html(
                '<div class="alert alert-danger" role="alert">Terjadi kesalahan pada sistem. Silakan coba lagi.</div>'
            );
        },
    });
}

//Fungsi Menampilkan Riwayat Transaksi
function ShowRiwayatTransaksi(id_barang) {
    //Tempelkan id_barang ke form filter
    $('#put_id_barang_for_filter_riwayat_transaksi').val(id_barang);

    //Form Filter
    var ProsesFilterRiwayatTransaksi = $('#ProsesFilterRiwayatTransaksi').serialize();
    $('#TabelRiwayatTransaksi').html('<tr><td class="text-center" colspan="10">Loading...</td></tr>');
    $.ajax({
        type    : 'POST',
        url     : '_Page/Barang/TabelRiwayatTransaksi.php',
        data    : ProsesFilterRiwayatTransaksi,
        success: function(data) {
            $('#TabelRiwayatTransaksi').html(data);
        }
    });
}

let video = document.getElementById('qr-video');
let scanning = false;
let videoStream = null;

function startQRScanner() {
    navigator.mediaDevices.getUserMedia({ video: { facingMode: "environment" } })
        .then(function (stream) {
            videoStream = stream;
            video.srcObject = stream;
            video.setAttribute("playsinline", true); // Agar tidak fullscreen di iOS
            
            video.onloadedmetadata = () => {
                video.play();
                scanning = true;
                scanQRCode(); // Mulai scan setelah video siap
            };
        })
        .catch(function (err) {
            console.error("Error accessing camera: ", err);
        });
}

function stopQRScanner() {
    scanning = false;
    if (videoStream) {
        videoStream.getTracks().forEach(track => track.stop());
    }
}

function scanQRCode() {
    if (scanning) {
        const canvas = document.createElement('canvas');
        const context = canvas.getContext('2d');
        
        // Cek apakah video sudah siap dengan dimensi valid
        if (video.videoWidth > 0 && video.videoHeight > 0) {
            canvas.width = video.videoWidth;
            canvas.height = video.videoHeight;
            context.drawImage(video, 0, 0, canvas.width, canvas.height);
            
            const imageData = context.getImageData(0, 0, canvas.width, canvas.height);
            const code = jsQR(imageData.data, canvas.width, canvas.height);
            
            if (code) {
                $('#get_resume_kode_barang').val(code.data);
                stopQRScanner();
                // $('#ModalScanBarang').modal('hide');
            } else {
                requestAnimationFrame(scanQRCode);
            }
        } else {
            // Tunggu dan coba lagi jika dimensi belum valid
            requestAnimationFrame(scanQRCode);
        }
    }
}


$(document).ready(function() {
    //Menampilkan Data Pertama Kali
    ShowData();

    //Ketika Membuka Halaman Mandiri Detail Barang
    if ($("#DetailBarangOnPage").length) {
        var id_barang_in_line=$('#put_id_barang_in_line_page').val();
        DetailBarangOnPage(id_barang_in_line);

        //Tampilkan Tabel Riwayat transaksi
        ShowRiwayatTransaksi(id_barang_in_line);

        //Filter RIWAYAT TRANSAKSI
        $('#keyword_by_riwayat_transaksi').change(function(){
            var keyword_by = $('#keyword_by_riwayat_transaksi').val();
            $.ajax({
                type 	    : 'POST',
                url 	    : '_Page/Barang/FormFilterKeywordRiwayatTransaksi.php',
                data 	    :  {keyword_by: keyword_by},
                success     : function(data){
                    $('#FormFilterKeywordRiwayatTransaksi').html(data);
                }
            });
        });

        //Ketika Submit Filter
        $('#ProsesFilterRiwayatTransaksi').submit(function(){
            //Kembalikan ke halaman 1
            $('#page_riwayat_transaksi').val(1);

            //Tampilkan Data
            ShowRiwayatTransaksi(id_barang_in_line);

            //Tutup Modal
            $('#ModalFilterRiwayatTransaksi').modal('hide');
        });


        //PAGGING
        $(document).on('click', '#next_button_riwayat_transaksi', function() {
            var page_now = parseInt($('#page_riwayat_transaksi').val(), 10); // Pastikan nilai diambil sebagai angka
            var next_page = page_now + 1;
            $('#page_riwayat_transaksi').val(next_page);
            ShowRiwayatTransaksi(id_barang_in_line);
        });
        $(document).on('click', '#prev_button_riwayat_transaksi', function() {
            var page_now = parseInt($('#page_riwayat_transaksi').val(), 10); // Pastikan nilai diambil sebagai angka
            var next_page = page_now - 1;
            $('#page_riwayat_transaksi').val(next_page);
            ShowRiwayatTransaksi(id_barang_in_line);
        });

        //Modal Detail Transaksi
        $('#ModalDetailTransaksi').on('show.bs.modal', function (e) {
            var id_transaksi_jual_beli= $(e.relatedTarget).data('id');
            var id_transaksi_jual_beli_rincian= $(e.relatedTarget).data('id_rincian');

            //Loading
            $('#FormDetailTransaksi').html('Loading...');

            //Tampikan Dalam Ajax
            $.ajax({
                type 	    : 'POST',
                url 	    : '_Page/Barang/FormDetailTransaksi.php',
                data 	    :  {
                    id_transaksi_jual_beli: id_transaksi_jual_beli, 
                    id_transaksi_jual_beli_rincian: id_transaksi_jual_beli_rincian
                },
                success     : function(data){
                    $('#FormDetailTransaksi').html(data);
                }
            });
        });




    }
    //Ketika Batas Diubah
    $('#batas').change(function(){
        ShowData();
    });
    
    //Ketika keyword By Diubah
    $('#keyword_by').change(function(){
        var keyword_by = $('#keyword_by').val();
        $.ajax({
            type 	    : 'POST',
            url 	    : '_Page/Barang/FormFilterKeyword.php',
            data 	    :  {keyword_by: keyword_by},
            success     : function(data){
                $('#FormFilterKeyword').html(data);
            }
        });
    });

    //Ketika Submit Filter
    $('#ProsesFilter').submit(function(){
        //Kembalikan ke halaman 1
        $('#page').val(1);
        ShowData();
        //Tutup Modal
        $('#ModalFilter').modal('hide');
    });

    //Pagging
    $(document).on('click', '#next_button', function() {
        var page_now = parseInt($('#page').val(), 10); // Pastikan nilai diambil sebagai angka
        var next_page = page_now + 1;
        $('#page').val(next_page);
        ShowData(0);
    });
    $(document).on('click', '#prev_button', function() {
        var page_now = parseInt($('#page').val(), 10); // Pastikan nilai diambil sebagai angka
        var next_page = page_now - 1;
        $('#page').val(next_page);
        ShowData(0);
    });


    //Ketika class modal_scan_barang si click
    $('.modal_scan_barang').click(function(){
        $('#ModalScanBarang').modal('show');
    });
    
    // Event ketika modal ditampilkan
    $('#ModalScanBarang').on('shown.bs.modal', function () {
        startQRScanner();
    });

    // Event ketika modal ditutup
    $('#ModalScanBarang').on('hidden.bs.modal', function () {
        stopQRScanner();
    });

    //Modal Kategori Harga
    $('#ModalKategoriHarga').on('show.bs.modal', function (e) {
        $('#TabelKategoriHarga').html("Loading...");
        $.ajax({
            type 	    : 'POST',
            url 	    : '_Page/Barang/TabelKategoriHarga.php',
            success     : function(data){
                $('#TabelKategoriHarga').html(data);
            }
        });
    });

    //Proses Tambah Kategori Harga
    $("#ProsesTambahKategoriHarga").on("submit", function (e) {
        e.preventDefault();
        // Tombol loading
        let $FormElement = $("#ProsesTambahKategoriHarga");
        let $ModalElement = $("#ModalTambahKategoriHarga");
        let $Notifikasi = $("#NotifikasiTambahKategoriHarga");
        let $ButtonProses = $("#ButtonTambahKategoriHarga");
        let ButtonElement = '<i class="bi bi-save"></i> Simpan';
        $ButtonProses.html('Loading..');
        $ButtonProses.prop("disabled", true);
    
        // Ambil data form
        let formData = new FormData(this);
    
        // Kirim data ke server
        $.ajax({
            url         : "_Page/Barang/ProsesTambahKategoriHarga.php",
            type        : "POST",
            data        : formData,
            contentType : false,
            processData : false,
            dataType    : "json",
            success: function (response) {
                //Apabila Proses Berhasil
                if (response.status === "Success") {
                    
                    //reset form
                    $FormElement[0].reset();
    
                    //Tampilkan Ulang Data
                    $('#ModalKategoriHarga').modal('show');
                    $('#TabelKategoriHarga').html("Loading...");
                    $.ajax({
                        type 	    : 'POST',
                        url 	    : '_Page/Barang/TabelKategoriHarga.php',
                        success     : function(data){
                            $('#TabelKategoriHarga').html(data);
                        }
                    });
                    
                    // Tampilkan swal notifikasi
                    Swal.fire(
                        'Success!',
                        'Tambah Kategori Harga Berhasil!',
                        'success'
                    )
    
                    // Reset tombol
                    $ButtonProses.html(ButtonElement);
                    $ButtonProses.prop("disabled", false);
    
                    //Kosongkan Notifikasi
                    $Notifikasi.html('');
    
                    //Tutup Modal
                    $ModalElement.modal('hide');
                } else {
                    // Tampilkan pesan error
                    $Notifikasi.html(
                        `<div class="alert alert-danger" role="alert">${response.message}</div>`
                    );
                    $ButtonProses.html(ButtonElement).prop("disabled", false);
                }
            },
            error: function () {
                $Notifikasi.html(
                    '<div class="alert alert-danger" role="alert">Terjadi kesalahan pada sistem. Silakan coba lagi.</div>'
                );
                $ButtonProses.html(ButtonElement).prop("disabled", false);
            },
        });
    });

    //Modal Edit Kategori Harga
    $('#ModalEditKategoriHarga').on('show.bs.modal', function (e) {
        var id_barang_kategori_harga= $(e.relatedTarget).data('id');
        $('#ButtonEditKategoriHarga').prop("disabled", true);
        $.ajax({
            type 	    : 'POST',
            url 	    : '_Page/Barang/detail_kategori_harga.php',
            data        : {id_barang_kategori_harga: id_barang_kategori_harga},
            dataType    : "json",
            success     : function(response){
                if (response.status === "Success") {
                    $('#FormEditKategoriHarga').show();
                    var kategori_harga=response.dataset.kategori_harga;
                    var keterangan=response.dataset.keterangan;
                    
                    //Tempelkan Ke Form
                    $('#put_id_barang_kategori_harga_edit').val(id_barang_kategori_harga);
                    $('#nama_kategori_harga_edit').val(kategori_harga);
                    $('#keterangan_kategori_harga_edit').val(keterangan);
                    //Aktivkan Tombol
                    $('#ButtonEditKategoriHarga').prop("disabled", false);

                    //Kosongkan Notifikasi
                    $('#NotifikasiEditKategoriHarga').html("");
                }else{
                    $('#ButtonEditKategoriHarga').prop("disabled", true);
                    $('#NotifikasiEditKategoriHarga').html(
                        `<div class="alert alert-danger" role="alert">${response.message}</div>`
                    );
                    $('#FormEditKategoriHarga').hide();
                }
            },
            error: function () {
                $('#NotifikasiEditKategoriHarga').html(
                    '<div class="alert alert-danger" role="alert">Terjadi kesalahan pada sistem. Silakan coba lagi.</div>'
                );
                $('#ButtonEditKategoriHarga').prop("disabled", true);
                $('#FormEditKategoriHarga').hide();
            },
        });
    });

    //Proses Edit Kategori Harga
    $("#ProsesEditKategoriHarga").on("submit", function (e) {
        e.preventDefault();
        // Tombol loading
        let $FormElement = $("#ProsesEditKategoriHarga");
        let $ModalElement = $("#ModalEditKategoriHarga");
        let $Notifikasi = $("#NotifikasiEditKategoriHarga");
        let $ButtonProses = $("#ButtonEditKategoriHarga");
        let ButtonElement = '<i class="bi bi-save"></i> Simpan';
        $ButtonProses.html('Loading..');
        $ButtonProses.prop("disabled", true);
    
        // Ambil data form
        let formData = new FormData(this);
    
        // Kirim data ke server
        $.ajax({
            url         : "_Page/Barang/ProsesEditKategoriHarga.php",
            type        : "POST",
            data        : formData,
            contentType : false,
            processData : false,
            dataType    : "json",
            success: function (response) {
                //Apabila Proses Berhasil
                if (response.status === "Success") {
                    
                    //reset form
                    $FormElement[0].reset();
    
                    //Tampilkan Ulang Data
                    $('#ModalKategoriHarga').modal('show');
                    $('#TabelKategoriHarga').html("Loading...");
                    $.ajax({
                        type 	    : 'POST',
                        url 	    : '_Page/Barang/TabelKategoriHarga.php',
                        success     : function(data){
                            $('#TabelKategoriHarga').html(data);
                        }
                    });
                    
                    // Tampilkan swal notifikasi
                    Swal.fire(
                        'Success!',
                        'Edit Kategori Harga Berhasil!',
                        'success'
                    )
    
                    // Reset tombol
                    $ButtonProses.html(ButtonElement);
                    $ButtonProses.prop("disabled", false);
    
                    //Kosongkan Notifikasi
                    $Notifikasi.html('');
    
                    //Tutup Modal
                    $ModalElement.modal('hide');
                } else {
                    // Tampilkan pesan error
                    $Notifikasi.html(
                        `<div class="alert alert-danger" role="alert">${response.message}</div>`
                    );
                    $ButtonProses.html(ButtonElement).prop("disabled", false);
                }
            },
            error: function () {
                $Notifikasi.html(
                    '<div class="alert alert-danger" role="alert">Terjadi kesalahan pada sistem. Silakan coba lagi.</div>'
                );
                $ButtonProses.html(ButtonElement).prop("disabled", false);
            },
        });
    });
    
    //Modal Hapus Kategori Harga
    $('#ModalHapusKategoriHarga').on('show.bs.modal', function (e) {
        var id_barang_kategori_harga= $(e.relatedTarget).data('id');
        $('#ButtonHapusKategoriHarga').prop("disabled", true);
        $.ajax({
            type 	    : 'POST',
            url 	    : '_Page/Barang/detail_kategori_harga.php',
            data        : {id_barang_kategori_harga: id_barang_kategori_harga},
            dataType    : "json",
            success     : function(response){
                if (response.status === "Success") {
                    $('#FormHapusKategoriHarga').show();
                    var kategori_harga=response.dataset.kategori_harga;
                    var keterangan=response.dataset.keterangan;
                    var jumlah_item=response.dataset.jumlah_item;
                    
                    //Tempelkan Ke Form
                    $('#put_id_barang_kategori_harga_hapus').val(id_barang_kategori_harga);
                    $('#put_kategori_harga').html(kategori_harga);
                    $('#put_keterangan').html(keterangan);
                    $('#put_jumlah_item').html(jumlah_item);
                    //Aktivkan Tombol
                    $('#ButtonHapusKategoriHarga').prop("disabled", false);

                    //Kosongkan Notifikasi
                    $('#NotifikasiHapusKategoriHarga').html("");
                }else{
                    $('#ButtonHapusKategoriHarga').prop("disabled", true);
                    $('#NotifikasiHapusKategoriHarga').html(
                        `<div class="alert alert-danger" role="alert">${response.message}</div>`
                    );
                    $('#FormHapusKategoriHarga').hide();
                }
            },
            error: function () {
                $('#NotifikasiHapusKategoriHarga').html(
                    '<div class="alert alert-danger" role="alert">Terjadi kesalahan pada sistem. Silakan coba lagi.</div>'
                );
                $('#ButtonHapusKategoriHarga').prop("disabled", true);
                $('#FormHapusKategoriHarga').hide();
            },
        });
    });

    //Proses Hapus Kategori Harga
    $("#ProsesHapusKategoriHarga").on("submit", function (e) {
        e.preventDefault();
        // Tombol loading
        let $FormElement = $("#ProsesHapusKategoriHarga");
        let $ModalElement = $("#ModalHapusKategoriHarga");
        let $Notifikasi = $("#NotifikasiHapusKategoriHarga");
        let $ButtonProses = $("#ButtonHapusKategoriHarga");
        let ButtonElement = '<i class="bi bi-check"></i> Ya, Hapus';
        $ButtonProses.html('Loading..');
        $ButtonProses.prop("disabled", true);

        // Ambil data form
        let formData = new FormData(this);

        // Kirim data ke server
        $.ajax({
            url         : "_Page/Barang/ProsesHapusKategoriHarga.php",
            type        : "POST",
            data        : formData,
            contentType : false,
            processData : false,
            dataType    : "json",
            success: function (response) {
                //Apabila Proses Berhasil
                if (response.status === "Success") {
                    
                    //reset form
                    $FormElement[0].reset();

                    //Tampilkan Ulang Data
                    $('#ModalKategoriHarga').modal('show');
                    $('#TabelKategoriHarga').html("Loading...");
                    $.ajax({
                        type 	    : 'POST',
                        url 	    : '_Page/Barang/TabelKategoriHarga.php',
                        success     : function(data){
                            $('#TabelKategoriHarga').html(data);
                        }
                    });
                    
                    // Tampilkan swal notifikasi
                    Swal.fire(
                        'Success!',
                        'Hapus Kategori Harga Berhasil!',
                        'success'
                    )

                    // Reset tombol
                    $ButtonProses.html(ButtonElement);
                    $ButtonProses.prop("disabled", false);

                    //Kosongkan Notifikasi
                    $Notifikasi.html('');

                    //Tutup Modal
                    $ModalElement.modal('hide');
                } else {
                    // Tampilkan pesan error
                    $Notifikasi.html(
                        `<div class="alert alert-danger" role="alert">${response.message}</div>`
                    );
                    $ButtonProses.html(ButtonElement).prop("disabled", false);
                }
            },
            error: function () {
                $Notifikasi.html(
                    '<div class="alert alert-danger" role="alert">Terjadi kesalahan pada sistem. Silakan coba lagi.</div>'
                );
                $ButtonProses.html(ButtonElement).prop("disabled", false);
            },
        });
    });

    // Metika Modal Tambah Barang
    $('#ModalTambahBarang').on('show.bs.modal', function (e) {
        // Menampilkan list_kategori
        $.ajax({
            type    : 'POST',
            url     : '_Page/Barang/list_kategori.php',
            success: function(data) {
                $('#list_kategori').html(data);
            }
        });

        // Menampilkan list_satuan
        $.ajax({
            type    : 'POST',
            url     : '_Page/Barang/list_satuan.php',
            success: function(data) {
                $('#list_satuan').html(data);
            }
        });

        // Menampilkan form multi harga
        $.ajax({
            type    : 'POST',
            url     : '_Page/Barang/form_multi_harga.php',
            success: function(data) {
                $('#form_multi_harga').html(data);

                // Setelah form multi harga dimuat, inisialisasi input form-money
                initializeMoneyInputs();  // Memastikan elemen baru diformat
            }
        });

        // Inisialisasi elemen form-money untuk input yang sudah ada
        initializeMoneyInputs();
    });

    //Proses Tambah Barang
    $("#ProsesTambahBarang").on("submit", function (e) {
        e.preventDefault();
        // Tombol loading
        let $FormElement = $("#ProsesTambahBarang");
        let $ModalElement = $("#ModalTambahBarang");
        let $Notifikasi = $("#NotifikasiTambahBarang");
        let $ButtonProses = $("#ButtonTambahBarang");
        let ButtonElement = '<i class="bi bi-save"></i> Simpan';
        $ButtonProses.html('Loading..');
        $ButtonProses.prop("disabled", true);

        // Ambil data form
        let formData = new FormData(this);

        // Kirim data ke server
        $.ajax({
            url         : "_Page/Barang/ProsesTambahBarang.php",
            type        : "POST",
            data        : formData,
            contentType : false,
            processData : false,
            dataType    : "json",
            success: function (response) {
                //Apabila Proses Berhasil
                if (response.status === "Success") {
                    
                    //reset form
                    $FormElement[0].reset();

                    //Tampilkan Ulang Data
                    $('#ProsesFilter')[0].reset();
                    ShowData();
                    
                    // Tampilkan swal notifikasi
                    Swal.fire(
                        'Success!',
                        'Tambah Barang Berhasil!',
                        'success'
                    )

                    // Reset tombol
                    $ButtonProses.html(ButtonElement);
                    $ButtonProses.prop("disabled", false);

                    //Kosongkan Notifikasi
                    $Notifikasi.html('');

                    //Tutup Modal
                    $ModalElement.modal('hide');
                } else {
                    // Tampilkan pesan error
                    $Notifikasi.html(
                        `<div class="alert alert-danger" role="alert">${response.message}</div>`
                    );
                    $ButtonProses.html(ButtonElement).prop("disabled", false);
                }
            },
            error: function () {
                $Notifikasi.html(
                    '<div class="alert alert-danger" role="alert">Terjadi kesalahan pada sistem. Silakan coba lagi.</div>'
                );
                $ButtonProses.html(ButtonElement).prop("disabled", false);
            },
        });
    });

    //Modal Detail Barang Dengan Event Delegation
    $(document).on("click", ".ModalDetailBarang", function () {
        var id_barang = $(this).data("id");
        $('#ModalDetailBarang').modal('show');
        DetailBarangOnModal(id_barang);
    });

    //Modal Detail Kode Barang
    $('#ModalDetailKode').on('show.bs.modal', function (e) {
        var id_barang= $(e.relatedTarget).data('id');

        //Tangkap Data Dari Form
        var type_code=$('#type_code').val();
        var tampilkan_nama_barang_for_code=$('#tampilkan_nama_barang_for_code').val();
        var kategori_harga_kode=$('#kategori_harga_kode').val();
        
        //Kosongkan PreviewBarcodeKode
        $('#PreviewBarcodeKode').html("");
        //Sembunyikan Tombol
        // $('#ButtonCetakKode').hide();
        $.ajax({
            type 	    : 'POST',
            url 	    : '_Page/Barang/detail_kode_barang.php',
            data        : {id_barang: id_barang, type_code: type_code, tampilkan_nama_barang_for_code: tampilkan_nama_barang_for_code, id_barang_kategori_harga: kategori_harga_kode},
            success     : function(response){
                $('#PreviewBarcodeKode').html(response);
            }
        });

        //Apabila Kategori Harga Diubah
        $("#kategori_harga_kode").on("change", function (e) {
            var type_code=$('#type_code').val();
            var tampilkan_nama_barang_for_code=$('#tampilkan_nama_barang_for_code').val();
            var kategori_harga_kode=$('#kategori_harga_kode').val();
            $.ajax({
                type 	    : 'POST',
                url 	    : '_Page/Barang/detail_kode_barang.php',
                data        : {id_barang: id_barang, type_code: type_code, tampilkan_nama_barang_for_code: tampilkan_nama_barang_for_code, id_barang_kategori_harga: kategori_harga_kode},
                success     : function(response){
                    $('#PreviewBarcodeKode').html(response);
                }
            });
        });

        //Apabila tampilkan_nama_barang_for_code Diubah
        $("#tampilkan_nama_barang_for_code").on("change", function (e) {
            var type_code=$('#type_code').val();
            var tampilkan_nama_barang_for_code=$('#tampilkan_nama_barang_for_code').val();
            var kategori_harga_kode=$('#kategori_harga_kode').val();
            $.ajax({
                type 	    : 'POST',
                url 	    : '_Page/Barang/detail_kode_barang.php',
                data        : {id_barang: id_barang, type_code: type_code, tampilkan_nama_barang_for_code: tampilkan_nama_barang_for_code, id_barang_kategori_harga: kategori_harga_kode},
                success     : function(response){
                    $('#PreviewBarcodeKode').html(response);
                }
            });
        });

        //Apabila type_code Diubah
        $("#type_code").on("change", function (e) {
            var type_code=$('#type_code').val();
            var tampilkan_nama_barang_for_code=$('#tampilkan_nama_barang_for_code').val();
            var kategori_harga_kode=$('#kategori_harga_kode').val();
            $.ajax({
                type 	    : 'POST',
                url 	    : '_Page/Barang/detail_kode_barang.php',
                data        : {id_barang: id_barang, type_code: type_code, tampilkan_nama_barang_for_code: tampilkan_nama_barang_for_code, id_barang_kategori_harga: kategori_harga_kode},
                success     : function(response){
                    $('#PreviewBarcodeKode').html(response);
                }
            });
        });
    });
    function resetButton() {
        $('#ButtonCetakKode').prop('disabled', false).html('<i class="bi bi-printer"></i> Cetak Code');
    }
    $('#ProsesCetakCodeBarang').submit(function(event) {
        event.preventDefault(); // Mencegah reload halaman
        
        var formatCetak = $('#type_file_code').val(); // Ambil format yang dipilih
        var content = document.getElementById("PreviewBarcodeKode"); // Ambil elemen yang ingin dicetak

        if (!formatCetak) {
            $('#NotifikasiCetakKode').html('<div class="alert alert-danger">Silakan pilih format cetak!</div>');
            return;
        }

        // Tampilkan loading
        $('#NotifikasiCetakKode').html('<div class="alert alert-info">Sedang memproses cetak...</div>');
        $('#ButtonCetakKode').prop('disabled', true).html('<i class="bi bi-hourglass-split"></i> Memproses...');

        setTimeout(() => {
            if (formatCetak === "PDF") {
                html2canvas(content, { scale: 2 }).then(canvas => {
                    var imgData = canvas.toDataURL("image/png");
                    var { jsPDF } = window.jspdf;
                    var doc = new jsPDF("p", "mm", "a4");
                    var imgWidth = 190;
                    var imgHeight = (canvas.height * imgWidth) / canvas.width;

                    doc.addImage(imgData, "PNG", 10, 10, imgWidth, imgHeight);
                    doc.save("kode_barang.pdf");

                    $('#NotifikasiCetakKode').html('<div class="alert alert-success">Download PDF berhasil!</div>');
                    resetButton();
                }).catch(error => {
                    $('#NotifikasiCetakKode').html('<div class="alert alert-danger">Gagal mencetak PDF!</div>');
                    resetButton();
                });
            } else if (formatCetak === "Image") {
                html2canvas(content, { scale: 2 }).then(canvas => {
                    var imgData = canvas.toDataURL("image/png");
                    var link = document.createElement("a");
                    link.href = imgData;
                    link.download = "kode_barang.png";
                    link.click();

                    $('#NotifikasiCetakKode').html('<div class="alert alert-success">Download gambar berhasil!</div>');
                    resetButton();
                }).catch(error => {
                    $('#NotifikasiCetakKode').html('<div class="alert alert-danger">Gagal mencetak gambar!</div>');
                    resetButton();
                });
            } else if (formatCetak === "Direct") {
                var printWindow = window.open("", "", "width=800,height=600");
                printWindow.document.write('<html><head><title>Cetak Nota</title>');
                printWindow.document.write('<link rel="stylesheet" href="assets/vendor/bootstrap/css/bootstrap.min.css">');
                printWindow.document.write('</head><body>');
                printWindow.document.write(content.innerHTML);
                printWindow.document.write('</body></html>');
                printWindow.document.close();
                printWindow.focus();

                setTimeout(() => {
                    printWindow.print();
                    printWindow.close();
                    $('#NotifikasiCetakKode').html('<div class="alert alert-success">Pencetakan berhasil!</div>');
                    resetButton();
                }, 1000);
            }
        }, 1000);
    });

    //Modal Edit Barang
    $('#ModalEditBarang').on('show.bs.modal', function (e) {
        var id_barang= $(e.relatedTarget).data('id');
        //Kosongkan Notifikasi
        $('#NotifikasiEditBarang').html("");
        $.ajax({
            type 	    : 'POST',
            url 	    : '_Page/Barang/detail_barang.php',
            data        : {id_barang: id_barang},
            dataType    : "json",
            success     : function(response){
                if(response.status=="Success"){

                    //Kosongkan Notifikasi
                    $('#NotifikasiEditBarang').html("");
                        
                    //Munculkan Form
                    $("#form_edit_barang").show();

                    var data = response.dataset;
                    var multi_harga = response.multi_harga || [];

                    // Tempelkan Data ke Elemen yang Sesuai Form
                    $('#put_id_barang_edit').val(`${id_barang}`);
                    $('#kode_edit').val(`${data.kode_barang}`);
                    $('#nama_edit').val(`${data.nama_barang}`);
                    $('#kategori_edit').val(`${data.kategori_barang}`);
                    $('#satuan_edit').val(`${data.satuan_barang}`);
                    $('#isi_edit').val(`${data.konversi}`);
                    $('#stok_edit').val(`${data.stok_barang}`);
                    $('#stok_min_edit').val(`${data.stok_minimum}`);
                    $('#harga_edit').val(`${data.harga_beli}`);

                    // Menampilkan list_kategori_edit
                    $.ajax({
                        type    : 'POST',
                        url     : '_Page/Barang/list_kategori.php',
                        success: function(data) {
                            $('#list_kategori_edit').html(data);
                        }
                    });

                    // Menampilkan list_satuan_edit
                    $.ajax({
                        type    : 'POST',
                        url     : '_Page/Barang/list_satuan.php',
                        success: function(data) {
                            $('#list_satuan_edit').html(data);
                        }
                    });

                    // Menampilkan form multi harga
                    $.ajax({
                        type    : 'POST',
                        url     : '_Page/Barang/form_multi_harga_edit.php',
                        data    : {id_barang: id_barang},
                        success: function(data) {
                            $('#form_multi_harga_edit').html(data);

                            // Setelah form multi harga dimuat, inisialisasi input form-money
                            initializeMoneyInputs();  // Memastikan elemen baru diformat
                        }
                    });

                    // Inisialisasi elemen form-money untuk input yang sudah ada
                    initializeMoneyInputs();
                }else{
                    //Sembunyikan Form
                    $("#form_edit_barang").hide();

                    //Tempelkan Notifikasi
                    $('#NotifikasiEditBarang').html(
                        `<div class="alert alert-danger" role="alert">${response.message}</div>`
                    );
                }
            },
            error: function () {

                //Sembunyikan Form
                $("#form_edit_barang").hide();
                
                //Tempelkan Notifikasi
                $('#NotifikasiEditBarang').html(
                    '<div class="alert alert-danger" role="alert">Terjadi kesalahan pada sistem. Silakan coba lagi.</div>'
                );
            },
        });
    });

    //Proses Edit Barang
    $("#ProsesEditBarang").on("submit", function (e) {
        e.preventDefault();
        // Tombol loading
        let $FormElement = $("#ProsesEditBarang");
        let $ModalElement = $("#ModalEditBarang");
        let $Notifikasi = $("#NotifikasiEditBarang");
        let $ButtonProses = $("#ButtonEditBarang");
        let ButtonElement = '<i class="bi bi-save"></i> Simpan';
        $ButtonProses.html('Loading..');
        $ButtonProses.prop("disabled", true);

        // Ambil data form
        let formData = new FormData(this);

        // Kirim data ke server
        $.ajax({
            url         : "_Page/Barang/ProsesEditBarang.php",
            type        : "POST",
            data        : formData,
            contentType : false,
            processData : false,
            dataType    : "json",
            success: function (response) {
                //Apabila Proses Berhasil
                if (response.status === "Success") {
                    
                    //reset form
                    $FormElement[0].reset();

                    //Tampilkan Ulang Data Tanpa Reset
                    ShowData();
                    
                    // Tampilkan swal notifikasi
                    Swal.fire(
                        'Success!',
                        'Edit Barang Berhasil!',
                        'success'
                    )

                    // Reset tombol
                    $ButtonProses.html(ButtonElement);
                    $ButtonProses.prop("disabled", false);

                    //Kosongkan Notifikasi
                    $Notifikasi.html('');

                    //Tutup Modal
                    $ModalElement.modal('hide');
                } else {
                    // Tampilkan pesan error
                    $Notifikasi.html(
                        `<div class="alert alert-danger" role="alert">${response.message}</div>`
                    );
                    $ButtonProses.html(ButtonElement).prop("disabled", false);
                }
            },
            error: function () {
                $Notifikasi.html(
                    '<div class="alert alert-danger" role="alert">Terjadi kesalahan pada sistem. Silakan coba lagi.</div>'
                );
                $ButtonProses.html(ButtonElement).prop("disabled", false);
            },
        });
    });

    //Modal Hapus Barang
    $('#ModalHapusBarang').on('show.bs.modal', function (e) {
        var id_barang= $(e.relatedTarget).data('id');
        //Kosongkan Notifikasi
        $('#NotifikasiHapusBarang').html("");
        $.ajax({
            type 	    : 'POST',
            url 	    : '_Page/Barang/detail_barang.php',
            data        : {id_barang: id_barang},
            dataType    : "json",
            success     : function(response){
                if(response.status=="Success"){

                    //Kosongkan Notifikasi
                    $('#NotifikasiHapusBarang').html("");

                    var data = response.dataset;
                    var nama_barang=data.nama_barang;
                    var kode_barang=data.kode_barang;
                    var kategori_barang=data.kategori_barang;
                    var satuan_barang=data.satuan_barang;
                    //Tempelkan Ke Form
                    $('#FormHapusBarang').html(`
                        <input type="hidden" name="id_barang" value="${id_barang}">
                        <div class="row mb-2">
                            <div class="col-4"><small>Kode Barang</small></div>
                            <div class="col-8">
                                <small><code class="text text-grayish">${kode_barang}</code></small>
                            </div>
                        </div>
                        <div class="row mb-2">
                            <div class="col-4"><small>Nama/Merek</small></div>
                            <div class="col-8">
                                <small><code class="text text-grayish">${nama_barang}</code></small>
                            </div>
                        </div>
                        <div class="row mb-2">
                            <div class="col-4"><small>Kategori</small></div>
                            <div class="col-8">
                                <small><code class="text text-grayish">${kategori_barang}</code></small>
                            </div>
                        </div>
                        <div class="row mb-2">
                            <div class="col-4"><small>Satuan</small></div>
                            <div class="col-8">
                                <small><code class="text text-grayish">${satuan_barang}</code></small>
                            </div>
                        </div>
                        <div class="row mb-2 mt-3">
                            <div class="col-12">Apakah anda yakin akan menghapus data barang tersebut?</div>
                        </div>
                    `);
                    //Enable tombol
                    $('#ButtonHapusBarang').prop("disabled", false);
                }else{
                    //Tempelkan Notifikasi
                    $('#NotifikasiHapusBarang').html(
                        `<div class="alert alert-danger" role="alert">${response.message}</div>`
                    );
                    //Disable tombol
                    $('#ButtonHapusBarang').prop("disabled", true);
                }
            },
            error: function () {
                //Tempelkan Notifikasi
                $('#NotifikasiHapusBarang').html(
                    '<div class="alert alert-danger" role="alert">Terjadi kesalahan pada sistem. Silakan coba lagi.</div>'
                );
                //Disable tombol
                $('#ButtonHapusBarang').prop("disabled", true);
            },
        });
    });

    //Proses Hapus Barang
    $("#ProsesHapusBarang").on("submit", function (e) {
        e.preventDefault();
        // Tombol loading
        let $FormElement = $("#ProsesHapusBarang");
        let $ModalElement = $("#ModalHapusBarang");
        let $Notifikasi = $("#NotifikasiHapusBarang");
        let $ButtonProses = $("#ButtonHapusBarang");
        let ButtonElement = '<i class="bi bi-check"></i> Ya, Hapus';
        $ButtonProses.html('Loading..');
        $ButtonProses.prop("disabled", true);

        // Ambil data form
        let formData = new FormData(this);

        // Kirim data ke server
        $.ajax({
            url         : "_Page/Barang/ProsesHapusBarang.php",
            type        : "POST",
            data        : formData,
            contentType : false,
            processData : false,
            dataType    : "json",
            success: function (response) {
                //Apabila Proses Berhasil
                if (response.status === "Success") {
                    
                    //reset form
                    $FormElement[0].reset();

                    //Tampilkan Ulang Data Tanpa Reset
                    ShowData();
                    
                    // Tampilkan swal notifikasi
                    Swal.fire(
                        'Success!',
                        'Hapus Barang Berhasil!',
                        'success'
                    )

                    // Reset tombol
                    $ButtonProses.html(ButtonElement);
                    $ButtonProses.prop("disabled", false);

                    //Kosongkan Notifikasi
                    $Notifikasi.html('');

                    //Tutup Modal
                    $ModalElement.modal('hide');
                } else {
                    // Tampilkan pesan error
                    $Notifikasi.html(
                        `<div class="alert alert-danger" role="alert">${response.message}</div>`
                    );
                    $ButtonProses.html(ButtonElement).prop("disabled", false);
                }
            },
            error: function () {
                $Notifikasi.html(
                    '<div class="alert alert-danger" role="alert">Terjadi kesalahan pada sistem. Silakan coba lagi.</div>'
                );
                $ButtonProses.html(ButtonElement).prop("disabled", false);
            },
        });
    });

    //Modal Tambah Satuan
    $('#ModalTambahSatuan').on('show.bs.modal', function (e) {
        //Tangkap id_barang dari modal detail
        var id_barang = $('#put_id_barang_detail').val();
        //Tempelkan id_barang Ke data-id Tombol Kembali
        $(".kembali_ke_detail_barang").attr("data-id", id_barang);
        $("#ButtonTambahSatuan").attr("data-id", id_barang);
        //Tempelkan ke form put_id_barang_tambah_satuan
        $("#put_id_barang_tambah_satuan").val(id_barang);
        //Buka Detail Barang
        $.ajax({
            type 	    : 'POST',
            url 	    : '_Page/Barang/detail_barang.php',
            data        : {id_barang: id_barang},
            dataType    : "json",
            success     : function(response){
                if(response.status=="Success"){

                    //Kosongkan Notifikasi
                    $('#NotifikasiTambahSatuan').html("");

                    var data = response.dataset;
                    var nama_barang=data.nama_barang;
                    var kode_barang=data.kode_barang;
                    var kategori_barang=data.kategori_barang;
                    var satuan_barang=data.satuan_barang;
                    //Tempelkan Ke Form
                    $('#FormDetailBarangSatuan').html(`
                        <input type="hidden" name="id_barang" value="${id_barang}">
                        <div class="row mb-2">
                            <div class="col-4"><small>Kode Barang</small></div>
                            <div class="col-8">
                                <small><code class="text text-grayish">${kode_barang}</code></small>
                            </div>
                        </div>
                        <div class="row mb-2">
                            <div class="col-4"><small>Nama/Merek</small></div>
                            <div class="col-8">
                                <small><code class="text text-grayish">${nama_barang}</code></small>
                            </div>
                        </div>
                        <div class="row mb-2">
                            <div class="col-4"><small>Kategori</small></div>
                            <div class="col-8">
                                <small><code class="text text-grayish">${kategori_barang}</code></small>
                            </div>
                        </div>
                        <div class="row mb-2">
                            <div class="col-4"><small>Satuan</small></div>
                            <div class="col-8">
                                <small><code class="text text-grayish">${satuan_barang}</code></small>
                            </div>
                        </div>
                    `);
                    //Enable tombol
                    $('#ButtonTambahSatuan').prop("disabled", false);
                    //Data List Satuan Multi
                    $.ajax({
                        type    : 'POST',
                        url     : '_Page/Barang/list_satuan_multi.php',
                        success: function(data) {
                            $('#ListSatuanMulti').html(data);
                        }
                    });
                }else{
                    //Tempelkan Notifikasi
                    $('#NotifikasiTambahSatuan').html(
                        `<div class="alert alert-danger" role="alert">${response.message}</div>`
                    );
                    //Disable tombol
                    $('#ButtonTambahSatuan').prop("disabled", true);
                }
            },
            error: function () {
                //Tempelkan Notifikasi
                $('#NotifikasiHapusBarang').html(
                    '<div class="alert alert-danger" role="alert">Terjadi kesalahan pada sistem. Silakan coba lagi.</div>'
                );
                //Disable tombol
                $('#ButtonTambahSatuan').prop("disabled", true);
            },
        });
    });

    //Proses Tambah Multi Satuan
    $("#ProsesTambahSatuan").on("submit", function (e) {
        e.preventDefault();
        // Tombol loading
        let $FormElement = $("#ProsesTambahSatuan");
        let $ModalElement = $("#ModalTambahSatuan");
        let $Notifikasi = $("#NotifikasiTambahSatuan");
        let $ButtonProses = $("#ButtonTambahSatuan");
        let ButtonElement = '<i class="bi bi-save"></i> Simpan';
        $ButtonProses.html('Loading..');
        $ButtonProses.prop("disabled", true);

        // Ambil data form
        let formData = new FormData(this);

        // Kirim data ke server
        $.ajax({
            url         : "_Page/Barang/ProsesTambahSatuan.php",
            type        : "POST",
            data        : formData,
            contentType : false,
            processData : false,
            dataType    : "json",
            success: function (response) {
                //Apabila Proses Berhasil
                if (response.status === "Success") {
                    
                    //reset form
                    $FormElement[0].reset();

                    //Tampilkan Ulang Data Detail Barang
                    var id_barang = $('#put_id_barang_detail').val();
                    ShowListSatuanMulti(id_barang);
                    //Tampilkan Modal Detail
                    $('#ModalDetailBarang').modal('show');
                    DetailBarangOnModal(id_barang);
                    
                    // Tampilkan swal notifikasi
                    Swal.fire(
                        'Success!',
                        'Tambah Satuan Berhasil Berhasil!',
                        'success'
                    )

                    // Reset tombol
                    $ButtonProses.html(ButtonElement);
                    $ButtonProses.prop("disabled", false);

                    //Kosongkan Notifikasi
                    $Notifikasi.html('');

                    //Tutup Modal
                    $ModalElement.modal('hide');
                } else {
                    // Tampilkan pesan error
                    $Notifikasi.html(
                        `<div class="alert alert-danger" role="alert">${response.message}</div>`
                    );
                    $ButtonProses.html(ButtonElement).prop("disabled", false);
                }
            },
            error: function () {
                $Notifikasi.html(
                    '<div class="alert alert-danger" role="alert">Terjadi kesalahan pada sistem. Silakan coba lagi.</div>'
                );
                $ButtonProses.html(ButtonElement).prop("disabled", false);
            },
        });
    });

    //Modal Edit Satuan
    $('#ModalEditSatuan').on('show.bs.modal', function (e) {
        //Tangkap id_barang dari modal detail dan id_barang_satuan dari tombol
        var id_barang = $('#put_id_barang_detail').val();
        var id_barang_satuan = $(e.relatedTarget).data('id');
        var satuan_multi = $(e.relatedTarget).data('name');
        var konversi = $(e.relatedTarget).data('konversi');
        //Tempelkan id_barang Ke data-id Tombol Kembali
        $(".kembali_ke_detail_barang").attr("data-id", id_barang);
        
        //Tempelkan id_barang_satuan ke form put_id_barang_satuan_edit
        $("#put_id_barang_satuan_edit").val(id_barang_satuan);
        
        //Tempelkan satuan_multi ke form satuan_multi_edit
        $("#satuan_multi_edit").val(satuan_multi);

        //Tempelkan konversi ke form konversi_satuan_multi_edit
        $("#konversi_satuan_multi_edit").val(konversi);

        //Kosongkan Notifikasi
        $('#NotifikasiEditSatuan').html("");
    });

    //Proses Edit Multi Satuan
    $("#ProsesEditSatuan").on("submit", function (e) {
        e.preventDefault();
        // Tombol loading
        let $FormElement = $("#ProsesEditSatuan");
        let $ModalElement = $("#ModalEditSatuan");
        let $Notifikasi = $("#NotifikasiEditSatuan");
        let $ButtonProses = $("#ButtonEditSatuan");
        let ButtonElement = '<i class="bi bi-save"></i> Simpan';
        $ButtonProses.html('Loading..');
        $ButtonProses.prop("disabled", true);

        // Ambil data form
        let formData = new FormData(this);

        // Kirim data ke server
        $.ajax({
            url         : "_Page/Barang/ProsesEditSatuan.php",
            type        : "POST",
            data        : formData,
            contentType : false,
            processData : false,
            dataType    : "json",
            success: function (response) {
                //Apabila Proses Berhasil
                if (response.status === "Success") {
                    
                    //reset form
                    $FormElement[0].reset();

                    //Tampilkan Ulang Data Detail Barang
                    var id_barang = $('#put_id_barang_detail').val();
                    ShowListSatuanMulti(id_barang);
                    //Tampilkan Modal Detail
                    $('#ModalDetailBarang').modal('show');
                    DetailBarangOnModal(id_barang);
                    
                    // Tampilkan swal notifikasi
                    Swal.fire(
                        'Success!',
                        'Edit Satuan Berhasil Berhasil!',
                        'success'
                    )

                    // Reset tombol
                    $ButtonProses.html(ButtonElement);
                    $ButtonProses.prop("disabled", false);

                    //Kosongkan Notifikasi
                    $Notifikasi.html('');

                    //Tutup Modal
                    $ModalElement.modal('hide');
                } else {
                    // Tampilkan pesan error
                    $Notifikasi.html(
                        `<div class="alert alert-danger" role="alert">${response.message}</div>`
                    );
                    $ButtonProses.html(ButtonElement).prop("disabled", false);
                }
            },
            error: function () {
                $Notifikasi.html(
                    '<div class="alert alert-danger" role="alert">Terjadi kesalahan pada sistem. Silakan coba lagi.</div>'
                );
                $ButtonProses.html(ButtonElement).prop("disabled", false);
            },
        });
    });

    //Modal Hapus Multi Satuan
    $('#ModalHapusSatuanMulti').on('show.bs.modal', function (e) {
        //Tangkap id_barang dari modal detail dan id_barang_satuan dari tombol
        var id_barang = $('#put_id_barang_detail').val();
        var id_barang_satuan = $(e.relatedTarget).data('id');
        var satuan_multi = $(e.relatedTarget).data('name');
        var konversi = $(e.relatedTarget).data('konversi');
        //Tempelkan id_barang Ke data-id Tombol Kembali
        $(".kembali_ke_detail_barang").attr("data-id", id_barang);
        
        //Tempelkan Data Ke Element FormHapusSatuanMulti
        $("#FormHapusSatuanMulti").html(`
            <input type="hidden" name="id_barang_satuan" value="${id_barang_satuan}">
            <div class="row mb-2">
                <div class="col-4"><small>Satuan Multi</small></div>
                <div class="col-8"><small class="text text-grayish">${satuan_multi}</small></div>
            </div>
            <div class="row mb-3">
                <div class="col-4"><small>Isi/Satuan</small></div>
                <div class="col-8"><small class="text text-grayish">${konversi}</small></div>
            </div>
            <div class="row mt-3">
                <div class="col-12"><small>Apakah Anda Yakin Akan Menghapus Data Tersebut?</small></div>
            </div>
        `);

        //Kosongkan Notifikasi
        $('#NotifikasiHapusSatuanMulti').html("");
    });
    //Proses Hapus Multi Satuan
    $("#ProsesHapusSatuanMulti").on("submit", function (e) {
        e.preventDefault();
        // Tombol loading
        let $FormElement = $("#ProsesHapusSatuanMulti");
        let $ModalElement = $("#ModalHapusSatuanMulti");
        let $Notifikasi = $("#NotifikasiHapusSatuanMulti");
        let $ButtonProses = $("#ButtonHapusSatuanMulti");
        let ButtonElement = '<i class="bi bi-check"></i> Ya, Hapus';
        $ButtonProses.html('Loading..');
        $ButtonProses.prop("disabled", true);

        // Ambil data form
        let formData = new FormData(this);

        // Kirim data ke server
        $.ajax({
            url         : "_Page/Barang/ProsesHapusSatuanMulti.php",
            type        : "POST",
            data        : formData,
            contentType : false,
            processData : false,
            dataType    : "json",
            success: function (response) {
                //Apabila Proses Berhasil
                if (response.status === "Success") {
                    
                    //reset form
                    $FormElement[0].reset();

                    //Tampilkan Ulang Data Detail Barang
                    var id_barang = $('#put_id_barang_detail').val();
                    ShowListSatuanMulti(id_barang);
                    //Tampilkan Modal Detail
                    $('#ModalDetailBarang').modal('show');
                    DetailBarangOnModal(id_barang);
                    
                    // Tampilkan swal notifikasi
                    Swal.fire(
                        'Success!',
                        'Hapus Satuan Berhasil Berhasil!',
                        'success'
                    )

                    // Reset tombol
                    $ButtonProses.html(ButtonElement);
                    $ButtonProses.prop("disabled", false);

                    //Kosongkan Notifikasi
                    $Notifikasi.html('');

                    //Tutup Modal
                    $ModalElement.modal('hide');
                } else {
                    // Tampilkan pesan error
                    $Notifikasi.html(
                        `<div class="alert alert-danger" role="alert">${response.message}</div>`
                    );
                    $ButtonProses.html(ButtonElement).prop("disabled", false);
                }
            },
            error: function () {
                $Notifikasi.html(
                    '<div class="alert alert-danger" role="alert">Terjadi kesalahan pada sistem. Silakan coba lagi.</div>'
                );
                $ButtonProses.html(ButtonElement).prop("disabled", false);
            },
        });
    });

});



//Tambah Batch & Expired
$('#ModalTambahExpiredDate').on('show.bs.modal', function (e) {
    var id_barang = $(e.relatedTarget).data('id');
    $('#FormTambahExpiredDate').html("Loading...");
    $.ajax({
        type 	    : 'POST',
        url 	    : '_Page/Barang/FormTambahExpiredDate.php',
        data        : {id_barang: id_barang},
        success     : function(data){
            $('#FormTambahExpiredDate').html(data);
            //Proses Tambah kategori harga
            $('#ProsesTambahExpiredDate').submit(function(){
                $('#NotifikasiTambahExpiredDate').html('<div class="spinner-border text-secondary" role="status"><span class="sr-only"></span></div>');
                var form = $('#ProsesTambahExpiredDate')[0];
                var data = new FormData(form);
                $.ajax({
                    type 	    : 'POST',
                    url 	    : '_Page/Barang/ProsesTambahExpiredDate.php',
                    data 	    :  data,
                    cache       : false,
                    processData : false,
                    contentType : false,
                    enctype     : 'multipart/form-data',
                    success     : function(data){
                        $('#NotifikasiTambahExpiredDate').html(data);
                        var NotifikasiTambahExpiredDateBerhasil=$('#NotifikasiTambahExpiredDateBerhasil').html();
                        if(NotifikasiTambahExpiredDateBerhasil=="Success"){
                            location.reload();
                        }
                    }
                });
            });
        }
    });
});

//Edit Expired Date
$('#ModalEditExpiredDate').on('show.bs.modal', function (e) {
    var id_barang_bacth = $(e.relatedTarget).data('id');
    $('#FormEditExpiredDate').html("Loading...");
    $.ajax({
        type 	    : 'POST',
        url 	    : '_Page/Barang/FormEditExpiredDate.php',
        data        : {id_barang_bacth: id_barang_bacth},
        success     : function(data){
            $('#FormEditExpiredDate').html(data);
            //Proses Edit kategori harga
            $('#ProsesEditExpiredDate').submit(function(){
                $('#NotifikasiEditExpiredDate').html('<div class="spinner-border text-secondary" role="status"><span class="sr-only"></span></div>');
                var form = $('#ProsesEditExpiredDate')[0];
                var data = new FormData(form);
                $.ajax({
                    type 	    : 'POST',
                    url 	    : '_Page/Barang/ProsesEditExpiredDate.php',
                    data 	    :  data,
                    cache       : false,
                    processData : false,
                    contentType : false,
                    enctype     : 'multipart/form-data',
                    success     : function(data){
                        $('#NotifikasiEditExpiredDate').html(data);
                        var NotifikasiEditExpiredDateBerhasil=$('#NotifikasiEditExpiredDateBerhasil').html();
                        if(NotifikasiEditExpiredDateBerhasil=="Success"){
                            location.reload();
                        }
                    }
                });
            });
        }
    });
});
//Hapus Satuan Barang
$('#ModalDeleteExpiredDate').on('show.bs.modal', function (e) {
    var id_barang_bacth = $(e.relatedTarget).data('id');
    $('#FormHapusExpiredDate').html("Loading...");
    $.ajax({
        type 	    : 'POST',
        url 	    : '_Page/Barang/FormHapusExpiredDate.php',
        data        : {id_barang_bacth: id_barang_bacth},
        success     : function(data){
            $('#FormHapusExpiredDate').html(data);
            //Konfirmasi Hapus Barang
            $('#KonfirmasiHapusExpiredDate').click(function(){
                $('#NotifikasiHapusExpiredDate').html('<div class="spinner-border text-secondary" role="status"><span class="sr-only"></span></div>');
                $.ajax({
                    type 	    : 'POST',
                    url 	    : '_Page/Barang/ProsesHapusExpiredDate.php',
                    data        : {id_barang_bacth: id_barang_bacth},
                    success     : function(data){
                        $('#NotifikasiHapusExpiredDate').html(data);
                        var NotifikasiHapusExpiredDateBerhasil=$('#NotifikasiHapusExpiredDateBerhasil').html();
                        if(NotifikasiHapusExpiredDateBerhasil=="Success"){
                            location.reload();
                        }
                    }
                });
            });
        }
    });
});

//Modal Import Barang
$('#ModalImportBarang').on('show.bs.modal', function () {
    // Reset form dan notifikasi saat modal muncul
    $('#ProsesImportBarang')[0].reset();
    $('#NotifikasiImportBarang').html('');
});

//Validasi File Import
$('#file_barang').on('change', function () {
    var file = this.files[0];
    var validTypes = ['application/vnd.openxmlformats-officedocument.spreadsheetml.sheet', 'application/vnd.ms-excel'];
    var maxSize = 10 * 1024 * 1024; // 10 MB

    // Reset notifikasi
    $('#NotifikasiImportBarang').html('');

    if (file) {
        if (!validTypes.includes(file.type)) {
            $('#NotifikasiImportBarang').html('<div class="alert alert-danger">Format file tidak valid. Hanya diperbolehkan file Excel (.xls, .xlsx).</div>');
            $(this).val(''); // Reset input file
            return;
        }

        if (file.size > maxSize) {
            $('#NotifikasiImportBarang').html('<div class="alert alert-danger">Ukuran file terlalu besar. Maksimal 10 MB.</div>');
            $(this).val(''); // Reset input file
            return;
        }

        $('#NotifikasiImportBarang').html('<div class="alert alert-success">File valid dan siap untuk diimport.</div>');
    }
});

//Proses Import
$('#ProsesImportBarang').on('submit', function (e) {
    e.preventDefault();
    var formData = new FormData(this);

    $.ajax({
        url: '_Page/Barang/ProsesImportBarang.php',
        type: 'POST',
        data: formData,
        contentType: false,
        processData: false,
        beforeSend: function () {
            $('#NotifikasiImportBarang').html('<div class="alert alert-info">Sedang memproses import...</div>');
        },
        success: function (response) {
            $('#NotifikasiImportBarang').html(response);
            
            //Reset Filter
            $('#ProsesFilter')[0].reset();
            
            //Tampilkan Data
            ShowData();

        },
        error: function () {
            $('#NotifikasiImportBarang').html('<div class="alert alert-danger">Terjadi kesalahan saat mengimpor data.</div>');
        }
    });
});


//Hapus Satuan Barang
$('#ModalExportRiwayatTransaksi').on('show.bs.modal', function (e) {
    var id_barang =$(e.relatedTarget).data('id');
    $('#FormExportRiwayatTransaksi').html('Loading...');
    $.ajax({
        type 	    : 'POST',
        url 	    : '_Page/Barang/FormExportRiwayatTransaksi.php',
        data 	    :  {id_barang: id_barang},
        success     : function(data){
            $('#FormExportRiwayatTransaksi').html(data);
        }
    });
});
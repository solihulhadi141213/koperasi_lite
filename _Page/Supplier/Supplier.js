//Fungsi Menampilkan Data Supplier
function ShowData() {
    var ProsesFilter = $('#ProsesFilter').serialize();
    $.ajax({
        type    : 'POST',
        url     : '_Page/Supplier/TabelSupplier.php',
        data    : ProsesFilter,
        success: function(data) {
            $('#TabelSupplier').html(data);
        }
    });
}

//Fungsi Menampilkan Informasi Detail Supplier
function ShowDetailSupplier(id_supplier) {
    //Loading element
    $('#detail_supplier').html('<div class="row"><div class="col-md-12 text-center">Loading...</div></div>');
    $.ajax({
        type        : 'POST',
        url         : '_Page/Supplier/_detail_supplier.php',
        data        : {id_supplier: id_supplier},
        dataType    : "json",
        success: function(response) {
            if(response.status=="Success"){
                $('#detail_supplier').html(`
                    <div class="row mb-3">
                        <div class="col-md-6">
                            <div class="row mb-2">
                                <div class="col-4"><small>ID.Supplier</small></div>
                                <div class="col-8"><small class="text text-muted">${response.dataset.id_supplier}</small></div>
                            </div>
                            <div class="row mb-2">
                                <div class="col-4"><small>Nama Supplier</small></div>
                                <div class="col-8"><small class="text text-muted">${response.dataset.nama_supplier}</small></div>
                            </div>
                            <div class="row mb-2">
                                <div class="col-4"><small>Email</small></div>
                                <div class="col-8"><small class="text text-muted">${response.dataset.email_supplier}</small></div>
                            </div>
                            <div class="row mb-2">
                                <div class="col-4"><small>Kontak</small></div>
                                <div class="col-8"><small class="text text-muted">${response.dataset.kontak_supplier}</small></div>
                            </div>
                            <div class="row mb-2">
                                <div class="col-4"><small>Alamat</small></div>
                                <div class="col-8"><small class="text text-muted">${response.dataset.alamat_supplier}</small></div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="row mb-2">
                                <div class="col-4"><small>Jumlah Pembelian</small></div>
                                <div class="col-8"><small class="text text-muted">${response.dataset.jumlah_transaksi_format}</small></div>
                            </div>
                            <div class="row mb-2">
                                <div class="col-4"><small>Retur Pembelian</small></div>
                                <div class="col-8"><small class="text text-muted">${response.dataset.jumlah_transaksi_retur_format}</small></div>
                            </div>
                            <div class="row mb-2">
                                <div class="col-4"><small>Utang Usaha</small></div>
                                <div class="col-8"><small class="text text-muted">${response.dataset.jumlah_transaksi_kredit_format}</small></div>
                            </div>
                        </div>
                    </div>
                `);
            }else{
                //Apabila Response Error
                Swal.fire({
                    title: "Opss!",
                    text: response.message,
                    icon: "error",
                    confirmButtonText: "Tutup"
                }).then((result) => {
                    if (result.isConfirmed || result.isDismissed) {
                        // Redirect ke halaman yang diinginkan
                        window.location.href = "index.php?Page=Supplier"; 
                    }
                });
            }
        },
        error: function () {
            //Apabila format json gagal dibaca
            Swal.fire({
                title: "Opss!",
                text: "Terjadi kesalahan pada saat akan menampilkan detail supplier",
                icon: "error",
                confirmButtonText: "Tutup"
            }).then((result) => {
                if (result.isConfirmed || result.isDismissed) {
                    window.location.href = "index.php?Page=Supplier"; 
                }
            });
        },
    });
}

//Fungsi Menampilkan Riwayat Transaksi
function ShowRiwayatTransaksi(id_supplier) {
    //Tempelkan id_supplier ke form filter
    $('#put_id_supplier_on_riwayat_transaksi').val(id_supplier);
    var ProsesFilterriwayatTransaksi = $('#ProsesFilterriwayatTransaksi').serialize();
    //Loading
    $('#TabelTransaksiSupplier').html(`
        <tr>
            <td colspan="8" class="text-center">Loading...</td>
        </tr>
    `);
    $.ajax({
        type    : 'POST',
        url     : '_Page/Supplier/TabelRiwayatTransaksi.php',
        data    : ProsesFilterriwayatTransaksi,
        success: function(data) {
            $('#TabelTransaksiSupplier').html(data);
        }
    });
}

//Fungsi Menampilkan Riwayat Riwayat Transaksi
function ShowRiwayatRincianTransaksi(id_supplier) {
    //Tempelkan id_supplier ke form filter
    $('#put_id_supplier_on_riwayat_rincian_transaksi').val(id_supplier);
    var ProsesFilterRincian = $('#ProsesFilterRincian').serialize();
    //Loading
    $('#TabelRincianTransaksiSupplier').html(`
        <tr>
            <td colspan="10" class="text-center">Loading...</td>
        </tr>
    `);
    $.ajax({
        type    : 'POST',
        url     : '_Page/Supplier/TabelRiwayatRincianTransaksi.php',
        data    : ProsesFilterRincian,
        success: function(data) {
            $('#TabelRincianTransaksiSupplier').html(data);
        }
    });
}

$(document).ready(function() {
    //Inisiasi Data Pertama Kali
    ShowData();

    //Ketika Batas Diubah
    $('#batas').change(function(){
        ShowData();
    });

    //Ketiika keyword_by Diubah
    $('#keyword_by').change(function(){
        var KeywordBy = $('#keyword_by').val();
        $('#FormFilterKeyword').html('Loading...');
        $.ajax({
            type 	    : 'POST',
            url 	    : '_Page/Supplier/FormFilterKeyword.php',
            data 	    :  {KeywordBy: KeywordBy},
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

    //Ketika menampilkan detail supplier
    if ($("#put_id_supplier_on_detail").length) {
        var id_supplier=$("#put_id_supplier_on_detail").val();

        //Menampilkan Detail
        ShowDetailSupplier(id_supplier);

        //Menampilkan Riwayat Transaksi
        ShowRiwayatTransaksi(id_supplier);

        //Menampilkan Riwayat Rincian Transaksi
        ShowRiwayatRincianTransaksi(id_supplier);

        //Pagging Riwayat Transaksi
        $(document).on('click', '#next_button_transaksi', function() {
            var page_now = parseInt($('#page_riwayat_transaksi').val(), 10);
            var next_page = page_now + 1;
            $('#page_riwayat_transaksi').val(next_page);
            ShowRiwayatTransaksi(id_supplier);
        });
        $(document).on('click', '#prev_button_transaksi', function() {
            var page_now = parseInt($('#page_riwayat_transaksi').val(), 10);
            var next_page = page_now - 1;
            $('#page_riwayat_transaksi').val(next_page);
            ShowRiwayatTransaksi(id_supplier);
        });

        //Pagging Riwayat Rincian Transaksi
        $(document).on('click', '#next_button_rincian_transaksi', function() {
            var page_now = parseInt($('#page_riwayat_rincian_transaksi').val(), 10);
            var next_page = page_now + 1;
            $('#page_riwayat_rincian_transaksi').val(next_page);
            ShowRiwayatRincianTransaksi(id_supplier);
        });
        $(document).on('click', '#prev_button_rincian_transaksi', function() {
            var page_now = parseInt($('#page_riwayat_rincian_transaksi').val(), 10);
            var next_page = page_now - 1;
            $('#page_riwayat_rincian_transaksi').val(next_page);
            ShowRiwayatRincianTransaksi(id_supplier);
        });

        //Ketiika keyword_by_riwayat_transaksi Diubah
        $('#keyword_by_riwayat_transaksi').change(function(){
            var keyword_by_riwayat_transaksi = $('#keyword_by_riwayat_transaksi').val();
            $('#FormFilterKeywordRiwayatTransaksi').html('Loading...');
            $.ajax({
                type 	    : 'POST',
                url 	    : '_Page/Supplier/FormFilterKeywordRiwayatTransaksi.php',
                data 	    :  {keyword_by_riwayat_transaksi: keyword_by_riwayat_transaksi},
                success     : function(data){
                    $('#FormFilterKeywordRiwayatTransaksi').html(data);
                }
            });
        });

        //Ketiika keyword_by_riwayat_rincian_transaksi Diubah
        $('#keyword_by_riwayat_rincian_transaksi').change(function(){
            var keyword_by_riwayat_rincian_transaksi = $('#keyword_by_riwayat_rincian_transaksi').val();
            $('#FormFilterKeywordRiwayatRincianTransaksi').html('Loading...');
            $.ajax({
                type 	    : 'POST',
                url 	    : '_Page/Supplier/FormFilterKeywordRiwayatRincianTransaksi.php',
                data 	    :  {keyword_by_riwayat_rincian_transaksi: keyword_by_riwayat_rincian_transaksi},
                success     : function(data){
                    $('#FormFilterKeywordRiwayatRincianTransaksi').html(data);
                }
            });
        });
        
        //Ketika Submit Filter
        $('#ProsesFilterriwayatTransaksi').submit(function(){
            
            //Kembalikan ke halaman 1
            $('#page_riwayat_transaksi').val(1);

            //Tampilkan Data
            ShowRiwayatTransaksi(id_supplier);

            //Tutup 'ModalFilterriwayatTransaksi'
            $('#ModalFilterriwayatTransaksi').modal('hide');
        });

        //Ketika Submit ProsesFilterRincian 
        $('#ProsesFilterRincian').submit(function(){
            
            //Kembalikan ke halaman 1
            $('#page_riwayat_rincian_transaksi').val(1);

            //Tampilkan Data
            ShowRiwayatRincianTransaksi(id_supplier);

            //Tutup 'ModalFilterRincian'
            $('#ModalFilterRincian').modal('hide');
        });
    }

    //Modal Export Supplier
    $('#ModalExportSupplier').on('show.bs.modal', function (e) {
        $('#FormExportSupplier').html("Loading...");
        $.ajax({
            type 	    : 'POST',
            url 	    : '_Page/Supplier/FormExportSupplier.php',
            success     : function(data){
                $('#FormExportSupplier').html(data);
            }
        });
    });

    //Modal Impoer Supplier
    $('#ModalImportSupplier').on('show.bs.modal', function () {
        // Reset form dan notifikasi saat modal muncul
        $('#ProsesImportSupplier')[0].reset();
        $('#NotifikasiImportSupplier').html('');
    });

    //Validasi File Import
    $('#file_supplier').on('change', function () {
        var file = this.files[0];
        var validTypes = ['application/vnd.openxmlformats-officedocument.spreadsheetml.sheet', 'application/vnd.ms-excel'];
        var maxSize = 10 * 1024 * 1024; // 10 MB

        // Reset notifikasi
        $('#NotifikasiImportSupplier').html('');

        if (file) {
            if (!validTypes.includes(file.type)) {
                $('#NotifikasiImportSupplier').html('<div class="alert alert-danger">Format file tidak valid. Hanya diperbolehkan file Excel (.xls, .xlsx).</div>');
                $(this).val(''); // Reset input file
                return;
            }

            if (file.size > maxSize) {
                $('#NotifikasiImportSupplier').html('<div class="alert alert-danger">Ukuran file terlalu besar. Maksimal 10 MB.</div>');
                $(this).val(''); // Reset input file
                return;
            }

            $('#NotifikasiImportSupplier').html('<div class="alert alert-success">File valid dan siap untuk diimport.</div>');
        }
    });

    //Proses Import
    $('#ProsesImportSupplier').on('submit', function (e) {
        e.preventDefault();
        var formData = new FormData(this);

        $.ajax({
            url: '_Page/Supplier/ProsesImportSupplier.php',
            type: 'POST',
            data: formData,
            contentType: false,
            processData: false,
            beforeSend: function () {
                $('#NotifikasiImportSupplier').html('<div class="alert alert-info">Sedang memproses import...</div>');
            },
            success: function (response) {
                $('#NotifikasiImportSupplier').html(response);
                
                //Reset Filter
                $('#ProsesFilter')[0].reset();
                
                //Tampilkan Data
                ShowData();

            },
            error: function () {
                $('#NotifikasiImportSupplier').html('<div class="alert alert-danger">Terjadi kesalahan saat mengimpor data.</div>');
            }
        });
    });

    //Proses Tambah Supplier
    $('#ProsesTambahSupplier').submit(function(){
        $('#NotifikasiTambahSupplier').html('<div class="spinner-border text-secondary" role="status"><span class="sr-only"></span></div>');
        var form = $('#ProsesTambahSupplier')[0];
        var data = new FormData(form);
        $.ajax({
            type 	    : 'POST',
            url 	    : '_Page/Supplier/ProsesTambahSupplier.php',
            data 	    :  data,
            cache       : false,
            processData : false,
            contentType : false,
            enctype     : 'multipart/form-data',
            success     : function(data){
                $('#NotifikasiTambahSupplier').html(data);
                var NotifikasiTambahSupplierBerhasil=$('#NotifikasiTambahSupplierBerhasil').html();
                if(NotifikasiTambahSupplierBerhasil=="Success"){
                    $('#NotifikasiTambahSupplier').html("");
                    //Reset Form Filter
                    $('#ProsesFilter')[0].reset();

                    //Reset Form ProsesTambahSupplier
                    $('#ProsesTambahSupplier')[0].reset();

                    //Tutup Modal
                    $('#ModalTambahSupplier').modal('hide');

                    //Tampilkan Swal
                    Swal.fire(
                        'Success!',
                        'Tambah Supplier Berhasil!',
                        'success'
                    )

                    //Tampilkan Data
                    ShowData(0);
                }
            }
        });
    });

    //Detail Supplier
    $('#ModalDetailSupplier').on('show.bs.modal', function (e) {
        var id_supplier= $(e.relatedTarget).data('id');
        $('#FormDetailSupplier').html("Loading...");
        $.ajax({
            type 	    : 'POST',
            url 	    : '_Page/Supplier/FormDetailSupplier.php',
            data        : {id_supplier: id_supplier},
            success     : function(data){
                $('#FormDetailSupplier').html(data);
            }
        });
    });

    //Edit Supplier
    $('#ModalEditSupplier').on('show.bs.modal', function (e) {
        var id_supplier = $(e.relatedTarget).data('id');
        $('#FormEditSupplier').html("Loading...");
        $('#NotifikasiEditSupplier').html("");
        $.ajax({
            type 	    : 'POST',
            url 	    : '_Page/Supplier/FormEditSupplier.php',
            data        : {id_supplier: id_supplier},
            success     : function(data){
                $('#FormEditSupplier').html(data);
            }
        });
    });

    //Proses Edit Supplier
    $('#ProsesEditSupplier').submit(function(){
        $('#NotifikasiEditSupplier').html('<div class="spinner-border text-secondary" role="status"><span class="sr-only"></span></div>');
        var form = $('#ProsesEditSupplier')[0];
        var data = new FormData(form);
        $.ajax({
            type 	    : 'POST',
            url 	    : '_Page/Supplier/ProsesEditSupplier.php',
            data 	    :  data,
            cache       : false,
            processData : false,
            contentType : false,
            enctype     : 'multipart/form-data',
            success     : function(data){
                $('#NotifikasiEditSupplier').html(data);
                var NotifikasiEditSupplierBerhasil=$('#NotifikasiEditSupplierBerhasil').html();
                if(NotifikasiEditSupplierBerhasil=="Success"){
                    
                    //Kosongkan Notifikasi
                    $('#NotifikasiEditSupplier').html("");
                    //Reset Form Filter
                    $('#ProsesEditSupplier')[0].reset();

                    //Tutup Modal
                    $('#ModalEditSupplier').modal('hide');

                    //Tampilkan Swal
                    Swal.fire(
                        'Success!',
                        'Edit Supplier Berhasil!',
                        'success'
                    )

                    //Tampilkan Data
                    ShowData(0);

                    //Jika Posisi Sedang Dalam Detail Supplier
                    if ($("#put_id_supplier_on_detail").length) {
                        var id_supplier=$("#put_id_supplier_on_detail").val();
                        ShowDetailSupplier(id_supplier);
                    }
                }
            }
        });
    });

    //Modal Hapus Supplier
    $('#ModalHapusSupplier').on('show.bs.modal', function (e) {
        var id_supplier = $(e.relatedTarget).data('id');
        $('#FormHapusSupplier').html("Loading...");
        $.ajax({
            type 	    : 'POST',
            url 	    : '_Page/Supplier/FormHapusSupplier.php',
            data        : {id_supplier: id_supplier},
            success     : function(data){
                $('#FormHapusSupplier').html(data);
                //Bersihkan Notifikasi
                $('#NotifikasiHapusSupplier').html("");
            }
        });
    });

    //Proses Hapus Supplier
    $('#ProsesHapusSupplier').submit(function(){
        $('#NotifikasiHapusSupplier').html('<div class="spinner-border text-secondary" role="status"><span class="sr-only"></span></div>');
        var form = $('#ProsesHapusSupplier')[0];
        var data = new FormData(form);
        $.ajax({
            type 	    : 'POST',
            url 	    : '_Page/Supplier/ProsesHapusSupplier.php',
            data 	    :  data,
            cache       : false,
            processData : false,
            contentType : false,
            enctype     : 'multipart/form-data',
            success     : function(data){
                $('#NotifikasiHapusSupplier').html(data);
                var NotifikasiHapusSupplierBerhasil=$('#NotifikasiHapusSupplierBerhasil').html();
                if(NotifikasiHapusSupplierBerhasil=="Success"){
                    
                    //Kosongkan Notifikasi
                    $('#NotifikasiHapusSupplier').html("");
                    //Reset Form Filter
                    $('#ProsesHapusSupplier')[0].reset();

                    //Tutup Modal
                    $('#ModalHapusSupplier').modal('hide');

                    //Tampilkan Swal
                    Swal.fire(
                        'Success!',
                        'Hapus Supplier Berhasil!',
                        'success'
                    )

                    //Tampilkan Data
                    ShowData(0);
                }
            }
        });
    });

    //Modal Detail Transaksi
    $('#ModalDetailTransaksi').on('show.bs.modal', function (e) {
        //Tangkap id_transaksi_jual_beli dari modal detail
        var id_transaksi_jual_beli = $(e.relatedTarget).data('id');
        
        //Buka Detail Barang
        $.ajax({
            type 	    : 'POST',
            url 	    : '_Page/Pembelian/detail_pembelian.php',
            data        : {id_transaksi_jual_beli: id_transaksi_jual_beli},
            dataType    : "json",
            success     : function(response){
                if(response.status=="Success"){

                    var data = response.dataset;
                    var list_rincian = response.list_rincian;
                    
                    //Tempelkan Ke Element
                    $('#FormDetailTransaksi').html(`
                        <input type="hidden" name="id" value="${id_transaksi_jual_beli}">
                        <div class="row mb-2">
                            <div class="col-4"><small>Tanggal</small></div>
                            <div class="col-8">
                                <small class="text text-grayish">${data.tanggal}</small>
                            </div>
                        </div>
                        <div class="row mb-2">
                            <div class="col-4"><small>Supplier</small></div>
                            <div class="col-8">
                                <a href="javascriipt:void(0);" data-bs-toggle="modal" data-bs-target="#ModalListSupplierEdit" data-id="${id_transaksi_jual_beli}" data-mode="List">
                                    <small class="text text-grayish">${data.nama_supplier}</small>
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
                    $("#ListRincianTransaksi").html(html);

                    //Enable tombol
                    $('#ButtonSelengkapnyaTransaksi').prop("disabled", false);
                }else{
                    //Tempelkan Notifikasi
                    $('#FormDetailTransaksi').html(
                        `<div class="alert alert-danger" role="alert">${response.message}</div>`
                    );
                    //Disable tombol
                    $('#ButtonSelengkapnyaTransaksi').prop("disabled", true);
                }
            },
            error: function () {
                //Tempelkan Notifikasi
                $('#FormDetailTransaksi').html(
                    '<div class="alert alert-danger" role="alert">Terjadi kesalahan pada sistem. Silakan coba lagi.</div>'
                );
                //Disable tombol
                $('#ButtonSelengkapnyaTransaksi').prop("disabled", true);
            },
        });
    });

    //Modal Export Transaksi
    $('#ModalExportTransaksi').on('show.bs.modal', function (e) {
        //Kosongkan Notifikasi
        $('#NotifikasiExportTransaksi').html("");

        //Kembalikan Button
        $('#ButtonExportTransaksi').prop('disabled', false).html('<i class="bi bi-download"></i> Download/Export');

        //Tangkap ID Supplier
        var id_supplier= $(e.relatedTarget).data('id');
        
        //Tempelkan Ke Form
        $('#put_id_supplier_for_export_transaksi').val(id_supplier);
        
        //Buka Detail Supplier
        $.ajax({
            type        : 'POST',
            url         : '_Page/Supplier/_detail_supplier.php',
            data        : {id_supplier: id_supplier},
            dataType    : "json",
            success: function(response) {
                if(response.status=="Success"){
                    $('#put_nama_supplier').html(response.dataset.nama_supplier);
                }else{
                    $('#put_nama_supplier').html('<small class="text-danger">'+response.message+'</small>');
                }
            },
            error: function () {
                //Apabila format json gagal dibaca
                $('#put_nama_supplier').html('<small class="text-danger">Error</small>');
            },
        });
    });

    //Proses Export Transaksi
    $('#ProsesExportTransaksi').on('submit', function (e) {
        e.preventDefault();
        
        let periodeAwal = $('#periode_transaksi_1').val();
        let periodeAkhir = $('#periode_transaksi_2').val();
        let idSupplier = $('#put_id_supplier_for_export_transaksi').val();
        let button = $('#ButtonExportTransaksi');
        let notif = $('#NotifikasiExportTransaksi');
        
        // Validasi periode
        if (periodeAwal && periodeAkhir && periodeAkhir < periodeAwal) {
            notif.html('<div class="alert alert-danger">Periode akhir tidak boleh lebih kecil dari periode awal.</div>');
            return;
        }
        
        // Disable tombol dan tampilkan loading
        button.prop('disabled', true).html('<i class="bi bi-arrow-clockwise"></i> Memproses...');
        notif.html('');
        
        $.ajax({
            url: '_Page/Supplier/ProsesExportRiwayatTransaksi.php',
            type: 'POST',
            data: {
                id_supplier: idSupplier,
                periode_awal: periodeAwal,
                periode_akhir: periodeAkhir
            },
            xhrFields: {
                responseType: 'blob' // Menerima file sebagai blob
            },
            success: function (response, status, xhr) {
                let filename = "Riwayat_Transaksi.xlsx";
                let blob = new Blob([response], { type: xhr.getResponseHeader('Content-Type') });
                let link = document.createElement('a');
                link.href = window.URL.createObjectURL(blob);
                link.download = filename;
                document.body.appendChild(link);
                link.click();
                document.body.removeChild(link);
                
                $('#ModalExportTransaksi').modal('hide');
                $('#ProsesExportTransaksi')[0].reset();
                
                // Tampilkan Swal
                Swal.fire(
                    'Success!',
                    'Download Riwayat Transaksi Berhasil!',
                    'success'
                );
            },
            error: function () {
                notif.html('<div class="alert alert-danger">Terjadi kesalahan dalam proses ekspor.</div>');
            },
            complete: function () {
                // Kembalikan tombol ke kondisi semula
                button.prop('disabled', false).html('<i class="bi bi-download"></i> Download/Export');
            }
        });
    });


    //Modal Export Rincian Transaksi
    $('#ModalExportRincian').on('show.bs.modal', function (e) {
        //Kosongkan Notifikasi
        $('#NotifikasiExportRincian').html("");

        //Kembalikan Button
        $('#ButtonExportRincian').prop('disabled', false).html('<i class="bi bi-download"></i> Download/Export');

        //Tangkap ID Supplier
        var id_supplier= $(e.relatedTarget).data('id');
        
        //Tempelkan Ke Form
        $('#put_id_supplier_for_export_rincian_transaksi').val(id_supplier);
        
        //Buka Detail Supplier
        $.ajax({
            type        : 'POST',
            url         : '_Page/Supplier/_detail_supplier.php',
            data        : {id_supplier: id_supplier},
            dataType    : "json",
            success: function(response) {
                if(response.status=="Success"){
                    $('#put_nama_supplier_for_export_rincian').html(response.dataset.nama_supplier);
                }else{
                    $('#put_nama_supplier_for_export_rincian').html('<small class="text-danger">'+response.message+'</small>');
                }
            },
            error: function () {
                //Apabila format json gagal dibaca
                $('#put_nama_supplier_for_export_rincian').html('<small class="text-danger">Error</small>');
            },
        });
    });
    //Proses Export Rincian
    $('#ProsesExportRincian').on('submit', function() {
        // Menutup modal setelah form di-submit
        $('#ModalExportRincian').modal('hide');

        // Mereset form setelah beberapa detik (opsional)
        setTimeout(function() {
            $('#ProsesExportRincian')[0].reset();
        }, 1000); // Delay 1 detik sebelum reset form
    });


});







$('#RincianBarang').click(function(){
    $('#HalamanDetailSupplier').html('<div class="spinner-border text-secondary" role="status"><span class="sr-only"></span></div>');
    var GetIdSupplier =$('#GetIdSupplier').html();
    $.ajax({
        type 	    : 'POST',
        url 	    : '_Page/Supplier/RincianBarang.php',
        data 	    :  {GetIdSupplier: GetIdSupplier},
        success     : function(data){
            $('#HalamanDetailSupplier').html(data);
        }
    });
});
$('#RiwayatTransaksi').click(function(){
    $('#HalamanDetailSupplier').html('<div class="spinner-border text-secondary" role="status"><span class="sr-only"></span></div>');
    var GetIdSupplier =$('#GetIdSupplier').html();
    $.ajax({
        type 	    : 'POST',
        url 	    : '_Page/Supplier/RiwayatTransaksi.php',
        data 	    :  {GetIdSupplier: GetIdSupplier},
        success     : function(data){
            $('#HalamanDetailSupplier').html(data);
        }
    });
});



//Proses Import Data Anggota
$('#ProsesImportDataSupplier').submit(function(){
    $('#NotifikasiLogProsesImport').html('<div class="spinner-border text-secondary" role="status"><span class="sr-only"></span></div>');
    var form = $('#ProsesImportDataSupplier')[0];
    var data = new FormData(form);
    $.ajax({
        type 	    : 'POST',
        url 	    : '_Page/Supplier/ProsesImportDataSupplier.php',
        data 	    :  data,
        cache       : false,
        processData : false,
        contentType : false,
        enctype     : 'multipart/form-data',
        success     : function(data){
            $('#NotifikasiLogProsesImport').html(data);
            swal("Import Selesai!", "Silahakan Cek Kembali Proses Import Melalui Log!", "success");
        }
    });
});


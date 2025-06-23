//Fungsi Untuk Menampilkan Data Utang Piutang
function ShowPenjualan() {
    var ProsesFilterPenjualan = $('#ProsesFilterPenjualan').serialize();
    $.ajax({
        type: 'POST',
        url: '_Page/UtangPiutang/TabelUtangPiutangPenjualan.php',
        data: ProsesFilterPenjualan,
        success: function(data) {
            $('#TabelUtangPiutangPenjualan').html(data);
        }
    });
}

// Fungsi untuk memeriksa apakah ada checkbox yang tercentang
function checkSelectedItems() {
    // Cek apakah ada checkbox item_penjualan yang tercentang
    const anyChecked = $('.item_penjualan:checked').length > 0;
    
    // Update status tombol bayar
    $('#ButtonTambahPembayaranPenjualan').prop('disabled', !anyChecked);
}

//Fungsi Menampilkan Riwayat Pembayaran
function ShowRiwayatPembayaran() {
    var ProsesFilterRiwayatPembayaran = $('#ProsesFilterRiwayatPembayaran').serialize();
    $.ajax({
        type: 'POST',
        url: '_Page/UtangPiutang/TabelRiwayatPembayaran.php',
        data: ProsesFilterRiwayatPembayaran,
        success: function(data) {
            $('#TabelRiwayatPembayaran').html(data);
        }
    });
}

//Fungsi Untuk Format Rupiah
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

$(document).ready(function() {
    //Menampilkan Data Pertama Kali
    ShowPenjualan();

    //Ketika Filter Di Submit
    $('#ProsesFilterPenjualan').submit(function() {
        ShowPenjualan();

        //Tutup Modal
        $('#ModalFilterPenjualan').modal('hide');
    });

    //Penanganan Form Filter Utang Piutang
    $('#keyword_by_penjualan').change(function() {
        var keyword_by= $('#keyword_by_penjualan').val();
        $.ajax({
            type    : 'POST',
            url     : '_Page/UtangPiutang/FormFilterPenjualan.php',
            data    : {keyword_by: keyword_by},
            success: function(data) {
                $('#FormFilterPenjualan').html(data);
            }
        });
    });

    //Pagging
    $(document).on('click', '#next_button_penjualan', function() {
        var page_penjualan = parseInt($('#page_penjualan').val(), 10); // Pastikan nilai diambil sebagai angka
        var page_penjualan_selanjutnya = page_penjualan + 1;
        $('#page_penjualan').val(page_penjualan_selanjutnya);
        ShowPenjualan();
    });
    $(document).on('click', '#prev_button_penjualan', function() {
        var page_penjualan = parseInt($('#page_penjualan').val(), 10); // Pastikan nilai diambil sebagai angka
        var page_penjualan_selanjutnya = page_penjualan - 1;
        $('#page_penjualan').val(page_penjualan_selanjutnya);
        ShowPenjualan();
    });
    
    // Inisialisasi: disable tombol bayar saat pertama kali load
    $('#ButtonTambahPembayaranPenjualan').prop('disabled', true);

    // Event handler untuk checkbox "check all"
    $('#check_all_penjualan').change(function() {
        // Centang/uncentang semua checkbox item
        $('.item_penjualan').prop('checked', $(this).prop('checked'));
        
        // Periksa status checkbox
        checkSelectedItems();
    });
    
    // Event handler untuk checkbox individual
    $(document).on('change', '.item_penjualan', function() {
        // Periksa status checkbox
        checkSelectedItems();
        
        // Update status "check all" jika perlu
        const allChecked = $('.item_penjualan').length === $('.item_penjualan:checked').length;
        $('#check_all_penjualan').prop('checked', allChecked);
    });

    //Modal Detail Penjualan
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
                    $('#FormDetail').html(`
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
                    $("#ListDetail").html(html);

                    //Enable tombol
                    $('#ButtonSelengkapnya').prop("disabled", false);
                }else{
                    //Tempelkan Notifikasi
                    $('#FormDetail').html(
                        `<div class="alert alert-danger" role="alert">${response.message}</div>`
                    );
                    //Disable tombol
                    $('#ButtonSelengkapnya').prop("disabled", true);
                }
            },
            error: function () {
                //Tempelkan Notifikasi
                $('#FormDetail').html(
                    '<div class="alert alert-danger" role="alert">Terjadi kesalahan pada sistem. Silakan coba lagi.</div>'
                );
                //Disable tombol
                $('#ButtonSelengkapnya').prop("disabled", true);
            },
        });
    });

    //Modal Pembayaran Penjualan
    $('#ModalPembayaranPiutangPenjualan').on('show.bs.modal', function (e) {
        //Tangkap id_transaksi_jual_beli dari modal detail
        var id_transaksi_jual_beli = $(e.relatedTarget).data('id');

        //Kosongkan Notifikasi
        $("#NotifikasiPembayaranPiutangPenjualan").html("");
        //Disabled Tombol
        $('#ButtonPembayaranPiutangPenjualan').prop("disabled", false);

        //Buka Detail Transaksi
        $.ajax({
            type 	    : 'POST',
            url 	    : '_Page/Penjualan/detail_penjualan.php',
            data        : {id_transaksi_jual_beli: id_transaksi_jual_beli},
            dataType    : "json",
            success     : function(response){
                if(response.status=="Success"){
                    //Buat Variabel
                    var id_anggota = response.dataset.id_anggota;
                    var nama_anggota = response.dataset.nama_anggota;
                    var kategori = response.dataset.kategori;
                    var total = response.dataset.total;
                    var sisa_tunggakan = response.dataset.sisa_tunggakan;
                    
                    //Tempelkan ID Transaksi Ke Form
                    $('#id_transaksi_penjualan').val(id_transaksi_jual_beli);
                    
                    //Tempelkan nama anggota Ke Form
                    $('#anggota_pembayaran_piutang_penjualan').html('<option value="'+id_anggota+'">'+nama_anggota+'</option>');

                    //Tempelkan Kategori Ke Form
                    $('#kategori_transaksi_pembayaran_piutang_penjualan').val(kategori);
                    
                    //Tempelkan Nominal Total Ke Form
                    $('#nominal_pembayaran_piutang_penjualan').val(sisa_tunggakan);
                    
                    //Enable tombol
                    $('#ButtonPembayaranPiutangPenjualan').prop("disabled", false);

                    //Inisiasi Function Form uang Rupiah
                    initializeMoneyInputs();

                    //Tempelkan Notifikasi
                    $('#NotifikasiPembayaranPiutangPenjualan').html(
                        `<div class="alert alert-warning" role="alert">
                            <small>Setelah melakukan pembayaran sesuai jumlah tagihan maka status transaksi akan Lunas dan tidak akan ditampilkan lagi pada tabel ini.</small>
                        </div>`
                    );
                }else{
                    //Tempelkan Notifikasi
                    $('#NotifikasiPembayaranPiutangPenjualan').html(
                        `<div class="alert alert-danger" role="alert">${response.message}</div>`
                    );
                    //Disable tombol
                    $('#ButtonPembayaranPiutangPenjualan').prop("disabled", true);
                }
            },
            error: function () {
                //Tempelkan Notifikasi
                $('#NotifikasiPembayaranPiutangPenjualan').html(
                    '<div class="alert alert-danger" role="alert">Terjadi kesalahan pada sistem. Silakan coba lagi.</div>'
                );
                //Disable tombol
                $('#ButtonPembayaranPiutangPenjualan').prop("disabled", true);
            },
        });
    });

    //Proses Pembayaran
    $("#ProsesPembayaranPiutangPenjualan").on("submit", function (e) {
        e.preventDefault();
        // Tombol loading
        $("#ButtonPembayaranPiutangPenjualan").html('Loading..');
        $("#ButtonPembayaranPiutangPenjualan").prop("disabled", true);
        let ButtonElement = '<i class="bi bi-save"></i> Simpan';
        // Ambil data form
        let formData = new FormData(this);

        // Kirim data ke server
        $.ajax({
            url         : "_Page/UtangPiutang/ProsesPembayaranPiutangPenjualan.php",
            type        : "POST",
            data        : formData,
            contentType : false,
            processData : false,
            dataType    : "json",
            success: function (response) {
                //Apabila Proses Berhasil
                if (response.status === "Success") {
                    $("#ButtonPembayaranPiutangPenjualan").html(ButtonElement).prop("disabled", false);
                    $('#NotifikasiPembayaranPiutangPenjualan').html('');
                    
                    //Tutup Modal
                    $('#ModalPembayaranPiutangPenjualan').modal('hide');
                    
                    //Tampilkan Alert
                    Swal.fire(
                        'Success!',
                        'Pembayaran Utang/Piutang Penjualan Berhasil!',
                        'success'
                    );
                    
                    //Reload Data
                    ShowPenjualan();
                } else {
                    // Tampilkan pesan error
                    $("#NotifikasiPembayaranPiutangPenjualan").html(
                        `<div class="alert alert-danger" role="alert">${response.message}</div>`
                    );
                    $("#ButtonPembayaranPiutangPenjualan").html(ButtonElement).prop("disabled", false);
                }
            },
            error: function () {
                $("#NotifikasiPembayaranPiutangPenjualan").html(
                    '<div class="alert alert-danger" role="alert">Terjadi kesalahan pada sistem. Silakan coba lagi.</div>'
                );
                $("#ButtonPembayaranPiutangPenjualan").html(ButtonElement).prop("disabled", false);
            },
        });
    });

    //Modal Riwayat Pembayaran
    $('#ModalRiwayatPembayaran').on('show.bs.modal', function (e) {
        //Tangkap id_transaksi_jual_beli dari modal detail
        var kategori = $(e.relatedTarget).data('id');

        //Tempelkan Nilai kategori ke id kategori_riwayat
        $("#kategori_riwayat").val(kategori);
    });

    //PENANGANAN HALAMAN RIWAYAT PEMBAYARAN
    if ($('#TabelRiwayatPembayaran').length) {
        ShowRiwayatPembayaran();

        //Ketika keyword_by_riwayat_pembayaran diubah
         $('#keyword_by_riwayat_pembayaran').change(function() {
           var keyword_by_riwayat_pembayaran=$('#keyword_by_riwayat_pembayaran').val();

            //Tampilkan filter dengan AJAX
            $.ajax({
                type    : 'POST',
                url     : '_Page/UtangPiutang/FormFilterRiwayatPembayaran.php',
                data    : {keyword_by_riwayat_pembayaran: keyword_by_riwayat_pembayaran},
                success: function(data) {
                    $('#FormFilterRiwayatPembayaran').html(data);
                }
            });
        });

        //Ketika Filter Di submit
        $('#ProsesFilterRiwayatPembayaran').submit(function() {
            ShowRiwayatPembayaran();

            //Tutup Modal
            $('#ModalFilterRiwayatPembayaran').modal('hide');
        });

        //Pagging Tabel Riwayat Pembayaran
        $(document).on('click', '#next_button_riwayat', function() {
            var page_now = parseInt($('#page_riwayat_pembayaran').val(), 10); // Pastikan nilai diambil sebagai angka
            var next_page = page_now + 1;
            $('#page_riwayat_pembayaran').val(next_page);
            ShowRiwayatPembayaran();
        });
        $(document).on('click', '#prev_button_riwayat', function() {
            var page_now = parseInt($('#page_riwayat_pembayaran').val(), 10); // Pastikan nilai diambil sebagai angka
            var next_page = page_now - 1;
            $('#page_riwayat_pembayaran').val(next_page);
            ShowRiwayatPembayaran();
        });
    }

    //Modal ModalPembayaranPenjualanMultiple Muncul
    $('#ModalPembayaranPenjualanMultiple').on('show.bs.modal', function (e) {
        var ProsesDetailMulti=$("#ProsesDetailMulti").serialize();

        //Kirimkan Data Dengan Ajax
        $('#ListPembayaranPenjualanMultiple').html('<tr><td colspan="6" class="text-center">Loading...</td></tr>');
        $.ajax({
            type    : 'POST',
            url     : '_Page/UtangPiutang/ListPembayaranPenjualanMultiple.php',
            data    : ProsesDetailMulti,
            success: function(data) {
                $('#ListPembayaranPenjualanMultiple').html(data);
            }
        });
    });

    //Proses Pembayaran Multiple
    $("#ProsesPembayaranPenjualanMultiple").on("submit", function (e) {
        e.preventDefault();
        // Tombol loading
        $("#ButtonPembayaranPenjualanMultiple").html('Loading..');
        $("#ButtonPembayaranPenjualanMultiple").prop("disabled", true);
        let ButtonElement = '<i class="bi bi-save"></i> Simpan Pembayaran';
        // Ambil data form
        let formData = new FormData(this);

        // Kirim data ke server
        $.ajax({
            url         : "_Page/UtangPiutang/ProsesPembayaranPenjualanMultiple.php",
            type        : "POST",
            data        : formData,
            contentType : false,
            processData : false,
            success: function (response) {
                //Apabila Proses Berhasil
                $('#ListPembayaranPenjualanMultiple').html(response);

                //Kembalikan Element Tombol
                $("#ButtonPembayaranPenjualanMultiple").html(ButtonElement);

                //Reload Data
                ShowPenjualan();
            }
        });
    });

    //Modal Detail Anggota
    $('#ModalDetailAnggota').on('show.bs.modal', function (e) {
        //Tangkap id_anggota dari modal detail
        var id_anggota = $(e.relatedTarget).data('id');

        //Loading
        $("#FormDetailAnggota").html('Loading...');

        //Tampilkan Data Dengan AJAX
        $.ajax({
            url         : "_Page/Anggota/FormDetailAnggota.php",
            type        : "POST",
            data        : {id_anggota: id_anggota},
            success: function (response) {
                $('#FormDetailAnggota').html(response);
            }
        });
    });

    //Modal Detail Pembayaran
    $('#ModalDetailPembayaran').on('show.bs.modal', function (e) {
        //Tangkap id_anggota dari modal detail
        var id_transaksi_pembayaran = $(e.relatedTarget).data('id');

        //Loading
        $("#FormDetailPembayaran").html('Loading...');

        //Tampilkan Data Dengan AJAX
        $.ajax({
            url         : "_Page/UtangPiutang/FormDetailPembayaran.php",
            type        : "POST",
            data        : {id_transaksi_pembayaran: id_transaksi_pembayaran},
            success: function (response) {
                $('#FormDetailPembayaran').html(response);
            }
        });
    });

    //Ketika Mode Data Diubah
    $("#mode_data").on("change", function (e) {
       var mode_data=$('#mode_data').val();

       //Routing Dengan Aja PHP
       $.ajax({
            url         : "_Page/UtangPiutang/FormModeData.php",
            type        : "POST",
            data        : {mode_data: mode_data},
            success: function (response) {
                $('#ShortPeriode').html(response);
            }
        });
    });

    //Modal Edit Pembayaran
    $('#ModalEditPembayaran').on('show.bs.modal', function (e) {
        //Tangkap id_anggota dari modal detail
        var id_transaksi_pembayaran = $(e.relatedTarget).data('id');

        //Loading
        $("#FormEditPembayaran").html('Loading...');

        //Kosongkan Notifikasi
        $("#NotifikasiEditPembayaran").html('');

        //Tampilkan Data Dengan AJAX
        $.ajax({
            url         : "_Page/UtangPiutang/FormEditPembayaran.php",
            type        : "POST",
            data        : {id_transaksi_pembayaran: id_transaksi_pembayaran},
            success: function (response) {
                $('#FormEditPembayaran').html(response);
            }
        });
    });

    //Proses Edit Pembayaran
    $("#ProsesEditPembayaran").on("submit", function (e) {
        e.preventDefault();
        
        // Tombol loading
        $("#ButtonEditPembayaran").html('Loading..');
        $("#ButtonEditPembayaran").prop("disabled", true);
        let ButtonElement = '<i class="bi bi-save"></i> Simpan';
        
        // Ambil data form
        let formData = new FormData(this);

        // Kirim data ke server
        $.ajax({
            url         : "_Page/UtangPiutang/ProsesEditPembayaran.php",
            type        : "POST",
            data        : formData,
            contentType : false,
            processData : false,
            dataType    : "json",
            success: function (response) {
                //Apabila Proses Berhasil
                if (response.status === "Success") {
                    $("#ButtonEditPembayaran").html(ButtonElement).prop("disabled", false);
                    $('#NotifikasiEditPembayaran').html('');
                    
                    //Tutup Modal
                    $('#ModalEditPembayaran').modal('hide');
                    
                    //Tampilkan Alert
                    Swal.fire(
                        'Success!',
                        'Ubah Pembayaran Utang/Piutang Penjualan Berhasil!',
                        'success'
                    );
                    
                    //Reload Data
                    ShowRiwayatPembayaran();
                } else {
                    // Tampilkan pesan error
                    $("#NotifikasiEditPembayaran").html(
                        `<div class="alert alert-danger" role="alert">${response.message}</div>`
                    );
                    $("#ButtonEditPembayaran").html(ButtonElement).prop("disabled", false);
                }
            },
            error: function () {
                $("#NotifikasiEditPembayaran").html(
                    '<div class="alert alert-danger" role="alert">Terjadi kesalahan pada sistem. Silakan coba lagi.</div>'
                );
                $("#ButtonEditPembayaran").html(ButtonElement).prop("disabled", false);
            },
        });
    });

    //Modal Hapus Pembayaran
    $('#ModalHapusPembayaran').on('show.bs.modal', function (e) {
        //Tangkap id_anggota dari modal detail
        var id_transaksi_pembayaran = $(e.relatedTarget).data('id');

        //Loading
        $("#FormHapusPembayaran").html('Loading...');

        //Kosongkan Notifikasi
        $("#NotifikasiHapusPembayaran").html('');

        //Tampilkan Data Dengan AJAX
        $.ajax({
            url         : "_Page/UtangPiutang/FormHapusPembayaran.php",
            type        : "POST",
            data        : {id_transaksi_pembayaran: id_transaksi_pembayaran},
            success: function (response) {
                $('#FormHapusPembayaran').html(response);
            }
        });
    });

    //Proses Hapus Pembayaran
    $("#ProsesHapusPembayaran").on("submit", function (e) {
        e.preventDefault();
        
        // Tombol loading
        $("#ButtonHapusPembayaran").html('Loading..');
        $("#ButtonHapusPembayaran").prop("disabled", true);
        let ButtonElement = '<i class="bi bi-check"></i> Ya, Hapus';
        
        // Ambil data form
        let formData = new FormData(this);

        // Kirim data ke server
        $.ajax({
            url         : "_Page/UtangPiutang/ProsesHapusPembayaran.php",
            type        : "POST",
            data        : formData,
            contentType : false,
            processData : false,
            dataType    : "json",
            success: function (response) {
                //Apabila Proses Berhasil
                if (response.status === "Success") {
                    $("#ButtonHapusPembayaran").html(ButtonElement).prop("disabled", false);
                    $('#NotifikasiHapusPembayaran').html('');
                    
                    //Tutup Modal
                    $('#ModalHapusPembayaran').modal('hide');
                    
                    //Tampilkan Alert
                    Swal.fire(
                        'Success!',
                        'Hapus Pembayaran Utang/Piutang Penjualan Berhasil!',
                        'success'
                    );
                    
                    //Reload Data
                    ShowRiwayatPembayaran();
                } else {
                    // Tampilkan pesan error
                    $("#NotifikasiHapusPembayaran").html(
                        `<div class="alert alert-danger" role="alert">${response.message}</div>`
                    );
                    $("#ButtonHapusPembayaran").html(ButtonElement).prop("disabled", false);
                }
            },
            error: function () {
                $("#NotifikasiHapusPembayaran").html(
                    '<div class="alert alert-danger" role="alert">Terjadi kesalahan pada sistem. Silakan coba lagi.</div>'
                );
                $("#ButtonHapusPembayaran").html(ButtonElement).prop("disabled", false);
            },
        });
    });

});
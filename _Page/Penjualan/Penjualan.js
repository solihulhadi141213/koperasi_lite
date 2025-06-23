// Fungsi Menampilkan Data Transaksi
function ShowData() {
    var ProsesFilter = $('#ProsesFilter').serialize();
    $('#TabelPenjualan').fadeOut(200, function() {
        $(this).html('<tr><td class="text-center">Loading...</td></tr>').fadeIn(200);
    });

    $.ajax({
        type: 'POST',
        url: '_Page/Penjualan/TabelPenjualan.php',
        data: ProsesFilter,
        success: function(data) {
            $('#TabelPenjualan').fadeOut(200, function() {
                $(this).html(data).fadeIn(200);
            });
        }
    });
}

// Fungsi Menampilkan Data Laba Penjualan
function ShowDataLaba() {
    var ProsesFilterLaba = $('#ProsesFilterLaba').serialize();
    $('#TabelLabaPenjualan').fadeOut(200, function() {
        $(this).html('<tr><td class="text-center">Loading...</td></tr>').fadeIn(200);
    });

    $.ajax({
        type: 'POST',
        url: '_Page/Penjualan/TabelLabaPenjualan.php',
        data: ProsesFilterLaba,
        success: function(data) {
            $('#TabelLabaPenjualan').fadeOut(200, function() {
                $(this).html(data).fadeIn(200);
            });
        }
    });
}

//Fungsi Menampilkan Data Rincian Bulk
function ShowDataBulk(get_kategori_transaksi) {
    $('#TabelPenjualanBulk')
        .html('<tr><td colspan="9" class="text-center">Loading...</td></tr>')
        .fadeIn(200); // Efek memudar saat loading muncul

    $.ajax({
        type: 'POST',
        url: '_Page/Penjualan/TabelPenjualanBulk.php',
        data: {kategori_transaksi: get_kategori_transaksi},
        success: function(data) {
            $('#TabelPenjualanBulk').fadeOut(200, function() { 
                $(this).html(data).fadeIn(300); 
            });
        }
    });
}

//Fungsi Menampilkan Data Barang
function ShowDataBarang() {
    var ProsesCariBarang = $('#ProsesCariBarang').serialize();
    
    // Efek fade out sebelum loading
    $('#TabelBarang').fadeOut(200, function() {
        $(this).html('<tr><td class="text-center" colspan="5">Loading...</td></tr>').fadeIn(200);
    });

    $.ajax({
        type 	    : 'POST',
        url 	    : '_Page/Penjualan/TabelBarang.php',
        data        : ProsesCariBarang,
        success     : function(data) {
            // Ganti isi tabel dengan data hasil AJAX dengan efek
            $('#TabelBarang').fadeOut(200, function() {
                $(this).html(data).fadeIn(300);
            });
        }
    });
}
//Fungsi Menampilkan Data Barang Edit
function ShowDataBarangEdit() {
    var ProsesCariBarangEdit = $('#ProsesCariBarangEdit').serialize();
    
    // Efek fade out sebelum loading
    $('#TabelBarangEdit').fadeOut(200, function() {
        $(this).html('<tr><td class="text-center" colspan="5">Loading...</td></tr>').fadeIn(200);
    });

    $.ajax({
        type 	    : 'POST',
        url 	    : '_Page/Penjualan/TabelBarangEdit.php',
        data        : ProsesCariBarangEdit,
        success     : function(data) {
            // Ganti isi tabel dengan data hasil AJAX dengan efek
            $('#TabelBarangEdit').fadeOut(200, function() {
                $(this).html(data).fadeIn(300);
            });
        }
    });
}
//Fungsi Menampilkan Data Anggota
function ShowDataAnggota() {
    var ProsesCariAnggota = $('#ProsesCariAnggota').serialize();
    $.ajax({
        type    : 'POST',
        url     : '_Page/Penjualan/TabelAnggota.php',
        data    : ProsesCariAnggota,
        success: function(data) {
            $('#TabelAnggota').html(data);
        }
    });
}

//Fungsi Menampilkan Data Anggota
function ShowDataAnggotaEdit(id_transaksi_jual_beli,mode) {
    $('#put_id_transaksi_jual_beli_anggota_edit').val(id_transaksi_jual_beli);
    $('#put_mode_edit_anggota').val(mode);
    var ProsesCariAnggotaEdit = $('#ProsesCariAnggotaEdit').serialize();
    $.ajax({
        type    : 'POST',
        url     : '_Page/Penjualan/TabelAnggotaEdit.php',
        data    : ProsesCariAnggotaEdit,
        success: function(data) {
            $('#TabelAnggotaEdit').html(data);
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

//Fungsi Menghitung Simulasi Rincian
function HitungSimulasiRincian() {
    var ProsesTambahBarang = $('#ProsesTambahBarang').serialize();
    $.ajax({
        type 	    : 'POST',
        url 	    : '_Page/Penjualan/ProsesSimulasiRincian.php',
        data        : ProsesTambahBarang,
        success     : function(data) {
            // Ganti isi tabel dengan data hasil AJAX dengan efek
            $('#SimulasiRincian').html(data);
        }
    });
}
//Fungsi Menghitung Simulasi Rincian
function HitungSimulasiRincianEdit() {
    var ProsesTambahBarangEdit = $('#ProsesTambahBarangEdit').serialize();
    $.ajax({
        type 	    : 'POST',
        url 	    : '_Page/Penjualan/ProsesSimulasiRincianEdit.php',
        data        : ProsesTambahBarangEdit,
        success     : function(data) {
            // Ganti isi tabel dengan data hasil AJAX dengan efek
            $('#SimulasiRincianEdit').html(data);
        }
    });
}
function hitungTotal() {
    let qty = parseFloat($('#qty_edit').val()) || 0;
    let harga = parseFloat($('#harga_edit').val().replace(/\D/g, '')) || 0;
    let ppn = parseFloat($('#ppn_edit').val().replace(/\D/g, '')) || 0;
    let diskon = parseFloat($('#diskon_edit').val().replace(/\D/g, '')) || 0;

    // Hitung Subtotal
    let subtotal = qty * harga;

    // Hitung PPN (jika ada)
    let rp_ppn = (ppn / 100) * subtotal;

    // Hitung Diskon (jika ada)
    let rp_diskon = (diskon / 100) * subtotal;

    // Hitung Total
    let total = subtotal + rp_ppn - rp_diskon;

    // Format ke Rupiah
    let total_rp = total.toLocaleString('id-ID', { style: 'currency', currency: 'IDR' });

    // Tampilkan hasil
    $('#jumlah_rincian_edit').html(`<h4 class="text text-grayish">${total_rp}</h4>`);
}

function hitungTotalEdit() {
    let qty = parseFloat($('#qty_edit_rincian').val()) || 0;
    let harga = parseFloat($('#harga_edit_rincian').val().replace(/\D/g, '')) || 0;
    let ppn = parseFloat($('#ppn_edit_rincian').val().replace(/\D/g, '')) || 0;
    let diskon = parseFloat($('#diskon_edit_rincian').val().replace(/\D/g, '')) || 0;

    // Hitung Subtotal
    let subtotal = qty * harga;

    // Hitung PPN (jika ada)
    let rp_ppn = (ppn / 100) * subtotal;

    // Hitung Diskon (jika ada)
    let rp_diskon = (diskon / 100) * subtotal;

    // Hitung Total
    let total = subtotal + rp_ppn - rp_diskon;

    // Tampilkan hasil
    $('#jumlah_edit_rincian').val(total);
}
function HitungRekapTransaksi(total, cash) {
    // Hapus titik pemisah ribuan dan konversi ke angka
    var totalNum = parseInt(total.replace(/\./g, ""), 10);
    var cashNum = parseInt(cash.replace(/\./g, ""), 10);

    // Hitung kembalian
    var kembalian = cashNum - totalNum;
    if (kembalian < 0) {
        kembalian = 0;
    }

    // Tentukan status pembayaran
    var status = (cashNum < totalNum) ? "Kredit" : "Lunas";

    // Format kembali ke dalam format ribuan dengan titik
    var formattedKembalian = kembalian.toLocaleString("id-ID");

    // Tempelkan Data Ke Form
    $('#put_kembalian_penjualan').val(formattedKembalian);
    $('#put_status_transaksi_penjualan').val(status);

    // Panggil fungsi untuk memastikan input format uang tetap benar
    initializeMoneyInputs();
}
function ShowDetailTransaksiInline(id_transaksi_jual_beli) {
    //Menampilkan detail transaksi inline
    $.ajax({
        type 	    : 'POST',
        url 	    : '_Page/Penjualan/detail_penjualan.php',
        data        : {id_transaksi_jual_beli: id_transaksi_jual_beli},
        dataType    : "json",
        success     : function(response){
            if(response.status=="Success"){

                var data = response.dataset;
                var list_rincian = response.list_rincian;
                var status = data.status;
                if(status=="Lunas"){
                    var LabelStatus='<span class="badge badge-success">Lunas</span>';
                }else{
                    var LabelStatus='<span class="badge badge-warning">Kredit</span>';
                }
                //Tempelkan Ke Element
                $('#form_detail_transaksi_inline').html(`
                    <div class="row">
                        <div class="col-md-6">
                            <div class="row mb-2">
                                <div class="col-4"><small>Tanggal</small></div>
                                <div class="col-8">
                                    <small class="text text-grayish">${data.tanggal}</small>
                                </div>
                            </div>
                            <div class="row mb-2">
                                <div class="col-4"><small>Anggota</small></div>
                                <div class="col-8">
                                    <a href="javascript:void(0);" data-bs-toggle="modal" data-bs-target="#ModalListAnggotaEdit" data-id="${id_transaksi_jual_beli}" data-mode="Detail">
                                        <small class="text text-primary">${data.nama_anggota}</small>
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
                                <div class="col-4"><small>Status</small></div>
                                <div class="col-8">
                                    <small class="text text-grayish">${LabelStatus}</small>
                                </div>
                            </div>
                            <div class="row mb-2">
                                <div class="col-4"><small>Subtotal</small></div>
                                <div class="col-8">
                                    <small class="text text-grayish">${data.subtotal_rp}</small>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6">
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
                        </div>
                    </div>
                `);

                //Menampilkan Rincian
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
                                <td class="text-left">${item.harga_rp}</td>
                                <td class="text-left">${item.ppn_rp}</td>
                                <td class="text-left">${item.diskon_rp}</td>
                                <td class="text-left">${item.subtotal_rp}</td>
                                <td class="text-left">
                                    <button type="button" class="btn btn-sm btn-floating btn-outline-dark" data-bs-toggle="dropdown" aria-expanded="false">
                                        <i class="bi bi-three-dots"></i>
                                    </button>
                                    <ul class="dropdown-menu dropdown-menu-end dropdown-menu-arrow" style="">
                                        <li class="dropdown-header text-start">
                                            <h6>Option</h6>
                                        </li>
                                        <li>
                                            <a class="dropdown-item" href="javascript:void(0)" data-bs-toggle="modal" data-bs-target="#ModalEditRincian" data-id="${item.id_transaksi_jual_beli_rincian}">
                                                <i class="bi bi-pencil"></i> Edit Rincian
                                            </a>
                                        </li>
                                        <li>
                                            <a class="dropdown-item" href="javascript:void(0)" data-bs-toggle="modal" data-bs-target="#ModalHapusRincian" data-id="${item.id_transaksi_jual_beli_rincian}">
                                                <i class="bi bi-trash"></i> Hapus Rincian
                                            </a>
                                        </li>
                                    </ul>
                                </td>
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
                            <td colspan="4" class="text-left">Total</td>
                            <td class="text-left">Rp ${totalPpn.toLocaleString("id-ID")}</td>
                            <td class="text-left">Rp ${totalDiskon.toLocaleString("id-ID")}</td>
                            <td class="text-left">Rp ${totalSubtotal.toLocaleString("id-ID")}</td>
                            <td class="text-left"></td>
                        </tr>
                    `;
                } else {
                    html = '<tr><td colspan="8" class="text-center">Tidak ada rincian transaksi</td></tr>';
                }

                // Masukkan ke dalam tabel
                $("#ListDetailTransaksiInline").html(html);

                //JURNAL
                var list_jurnal = response.list_jurnal;
                var html_jurnal = "";
                var total_debet = 0;
                var total_kredit = 0;

                if (list_jurnal.length > 0) {
                    $.each(list_jurnal, function(index2, item2) {
                        var d_k = item2.d_k;
                        var kolom_debet = "-";
                        var kolom_kredit = "-";

                        if (d_k == "D") {
                            kolom_debet = parseFloat(item2.nilai);
                            kolom_kredit = "-";
                            total_debet += kolom_debet;
                        } else {
                            kolom_debet = "-";
                            kolom_kredit = parseFloat(item2.nilai);
                            total_kredit += kolom_kredit;
                        }

                        html_jurnal += `
                            <tr>
                                <td>${item2.kode_perkiraan}</td>
                                <td>${item2.nama_perkiraan}</td>
                                <td>${kolom_debet.toLocaleString('id-ID')}</td>
                                <td class="text-right">${kolom_kredit.toLocaleString('id-ID')}</td>
                                <td class="text-left">
                                    <button type="button" class="btn btn-sm btn-floating btn-outline-dark" data-bs-toggle="dropdown" aria-expanded="false">
                                        <i class="bi bi-three-dots"></i>
                                    </button>
                                    <ul class="dropdown-menu dropdown-menu-end dropdown-menu-arrow" style="">
                                        <li class="dropdown-header text-start">
                                            <h6>Option</h6>
                                        </li>
                                        <li>
                                            <a class="dropdown-item" href="javascript:void(0)" data-bs-toggle="modal" data-bs-target="#ModalEditJurnal" data-id="${item2.id_jurnal}">
                                                <i class="bi bi-pencil"></i> Edit Jurnal
                                            </a>
                                        </li>
                                        <li>
                                            <a class="dropdown-item" href="javascript:void(0)" data-bs-toggle="modal" data-bs-target="#ModalHapusJurnal" data-id="${item2.id_jurnal}">
                                                <i class="bi bi-trash"></i> Hapus Jurnal
                                            </a>
                                        </li>
                                    </ul>
                                </td>
                            </tr>
                        `;
                    });

                    // Tambahkan baris total
                    html_jurnal += `
                        <tr class="fw-bold bg-light">
                            <td colspan="2" class="text-center">Jumlah/Saldo</td>
                            <td>${total_debet.toLocaleString('id-ID')}</td>
                            <td class="text-right">${total_kredit.toLocaleString('id-ID')}</td>
                            <td></td>
                        </tr>
                    `;
                } else {
                    html_jurnal = '<tr><td colspan="6" class="text-center">Tidak ada data jurnal</td></tr>';
                }

                $("#ListJurnal").html(html_jurnal);


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
}




$(document).ready(function() {

    //Format Uang Pertama kali
    initializeMoneyInputs();

    //Menampilkan Data Pertama Kali
    if ($("#TabelPenjualan").length) {
        ShowData();
    }
    if ($("#TabelLabaPenjualan").length) {
        ShowDataLaba();

        //Ketika Filter Di Submit
        $("#ProsesFilterLaba").on("submit", function (e) {
            //Reset Halaman
            $('#page_laba').val(1);
            
            //Tampilkan Data
            ShowDataLaba();

            //Tutup Modal
            $('#ModalFilterLaba').modal('hide');
        });

        //Event Listener Ketika keyword_by diubah
        $('#keyword_by_laba').change(function(){
            var keyword_by = $('#keyword_by_laba').val();
            $.ajax({
                type 	    : 'POST',
                url 	    : '_Page/Penjualan/FormFilterKeywordLaba.php',
                data 	    :  {keyword_by: keyword_by},
                success     : function(data){
                    $('#FormFilterKeywordLaba').html(data);
                }
            });
        });

        //Event listener ketika proses export
        $("#ProsesExportLaba").on("submit", function (e) {
        
            var periode_1 = $('#periode_1_laba').val();
            var periode_2 = $('#periode_2_laba').val();
            var type_data = $('#type_data_laba').val();
            // Bangun URL dengan parameter
            var url = '_Page/Penjualan/ProsesExportLaba.php?' + 
            'periode_1=' + encodeURIComponent(periode_1) + 
            '&periode_2=' + encodeURIComponent(periode_2) + 
            '&type_data=' + encodeURIComponent(type_data);

            // Buka tab baru dengan URL tersebut
            window.open(url, '_blank');
        });

    }
   
    //Detail Transaksi Inline
    if ($("#get_id_transaksi_jual_beli_detail").length) {
        var id_transaksi_jual_beli=$('#get_id_transaksi_jual_beli_detail').html();
        ShowDetailTransaksiInline(id_transaksi_jual_beli);
    }

    //Ketika keyword By Diubah
    $('#keyword_by').change(function(){
        var keyword_by = $('#keyword_by').val();
        $.ajax({
            type 	    : 'POST',
            url 	    : '_Page/Penjualan/FormFilterKeyword.php',
            data 	    :  {keyword_by: keyword_by},
            success     : function(data){
                $('#FormFilterKeyword').html(data);
            }
        });
    });

    //Submit pencarian/Filter
    $("#ProsesFilter").on("submit", function (e) {
        //Reset Halaman
        $('#page').val(1);
        
        //Tampilkan Data
        ShowData();

        //Tutup Modal
        $('#ModalFilter').modal('hide');
    });

    //PAGGING TRANSAKSI
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

    //PAGGING LABA
    $(document).on('click', '#next_button_laba', function() {
        var page_now = parseInt($('#page_laba').val(), 10); // Pastikan nilai diambil sebagai angka
        var next_page = page_now + 1;
        $('#page_laba').val(next_page);
        ShowDataLaba();
    });
    $(document).on('click', '#prev_button_laba', function() {
        var page_now = parseInt($('#page_laba').val(), 10); // Pastikan nilai diambil sebagai angka
        var next_page = page_now - 1;
        $('#page_laba').val(next_page);
        ShowDataLaba();
    });

    //Modal Export
    $('#ModalExportTransaksi').on('show.bs.modal', function (e) {
        $('#NotifikasiExportTransaksi').html('<div class="alert alert-warning"><small>Semakin banyak data transaksi yang akan diexport, maka proses sistem membutuhkan waktu lebih lama.</small></div>');
    });
    
    //Proses Export Transaksi
    $("#ProsesExportTransaksi").on("submit", function (e) {
        e.preventDefault(); // Mencegah form submit default
    
        var mode_data = $('#mode_data').val();
        var periode_1 = $('#periode_1').val();
        var periode_2 = $('#periode_2').val();
    
        // Loading Tombol
        $('#ButtonExportTransaksi').html('Loading...').prop('disabled', true);
    
        // Tentukan URL berdasarkan mode_data
        var url = (mode_data === "Transaksi") 
        ? `_Page/Penjualan/ProsesExportTransaksi.php?periode_1=${periode_1}&periode_2=${periode_2}`
        : `_Page/Penjualan/ProsesExportRincian.php?periode_1=${periode_1}&periode_2=${periode_2}`;

        // Buka halaman di tab baru
        window.open(url, "_blank");
    
        // Kembalikan Tombol setelah beberapa detik agar user melihat perubahan
        setTimeout(function () {
            $('#ButtonExportTransaksi').html('<i class="bi bi-download"></i> Export').prop('disabled', false);
            $('#NotifikasiExportTransaksi').html('<div class="alert alert-success">Proses Export Berhasil.</div>');
        }, 2000); // Delay 2 detik
    });

    //Ketika kembali
    $(".button_kembali").on("click", function () {
        window.location.href = "index.php?Page=Penjualan";
    });

    //Ketika Tambah Transaksi Penjualan
    if ($("#TabelPenjualanBulk").length) {
        var get_kategori_transaksi=$('#get_kategori_transaksi').html();
        ShowDataBulk(get_kategori_transaksi);
    }

    //Modal Cari Barang
    $('#ModalCariBarang').on('show.bs.modal', function (e) {
        var kategori_transaksi=$('#get_kategori_transaksi').html();
        //Reset Halaman
        $('#put_page_cari_barang').val(1);

        //Tampilkan Data
        ShowDataBarang();
    });

    //Proses Cari Barang
    $("#ProsesCariBarang").on("submit", function (e) {
        //Reset Halaman
        $('#put_page_cari_barang').val(1);

        //Tampilkan Data
        ShowDataBarang();
    });

    //Pagging Barang
    $(document).on('click', '#next_button_barang', function() {
        var page_now = parseInt($('#put_page_cari_barang').val(), 10); // Pastikan nilai diambil sebagai angka
        var next_page = page_now + 1;
        $('#put_page_cari_barang').val(next_page);
        ShowDataBarang();
    });
    $(document).on('click', '#prev_button_barang', function() {
        var page_now = parseInt($('#put_page_cari_barang').val(), 10); // Pastikan nilai diambil sebagai angka
        var next_page = page_now - 1;
        $('#put_page_cari_barang').val(next_page);
        ShowDataBarang();
    });

    //Modal Tambah Barang
    $('#ModalTambahBarang').on('show.bs.modal', function (e) {
        var id_barang= $(e.relatedTarget).data('id');
        var kategori_transaksi=$('#get_kategori_transaksi').html();
        //Tampilkan Form
        $.ajax({
            type 	    : 'POST',
            url 	    : '_Page/Penjualan/FormTambahBarang.php',
            data        : {id_barang: id_barang, kategori_transaksi: kategori_transaksi},
            success     : function(data) {
                // Ganti isi tabel dengan data hasil AJAX dengan efek
                $('#FormTambahBarang').fadeOut(200, function() {
                    $(this).html(data).fadeIn(300);
                    
                    //Kosongkan Notifikasi
                    $('#NotifikasiTambahBarang').html("");
                    
                });
            }
        });
    });

    //Proses Tambah Rincian Barang
    $('#ProsesTambahBarang').submit(function(){
        var ProsesTambahBarang = $('#ProsesTambahBarang').serialize();
        $('#NotifikasiTambahBarang').html('Loading...');
        $.ajax({
            type 	    : 'POST',
            url 	    : '_Page/Penjualan/ProsesTambahBarang.php',
            data 	    :  ProsesTambahBarang,
            success     : function(data){
                $('#NotifikasiTambahBarang').html(data);
                var NotifikasiTambahBarangBerhasil=$('#NotifikasiTambahBarangBerhasil').html();
                if(NotifikasiTambahBarangBerhasil=="Success"){
                    //Bersihkan Notifikasi
                    $('#NotifikasiTambahBarang').html("");

                    //tutup modal
                    $('#ModalTambahBarang').modal('hide');

                    //Tampilkan Data
                    var kategori_transaksi=$('#get_kategori_transaksi').html();
                    ShowDataBulk(kategori_transaksi);

                    //Tidak Perlu Menampilkan Swal
                }
            }
        });
    });

    //Modal Scan Barang
    $('#ModalScanBarang').on('shown.bs.modal', function () {
        var kategori_transaksi=$('#get_kategori_transaksi').html();

        //Focus Ke form keyword code
        $('#keyword_code').focus();

        //Tempelkan kategori_transaksi ke form
        $('#put_kategori_transaksi_scan').val(kategori_transaksi);
    });

    // Menampilkan alert success saat input keyword_code mendapatkan fokus
    $('#keyword_code').on('focus', function(){
        $('#preview_hasil_sacan').html(`
            <div class="alert alert-success text-center">
                <i class="bi bi-check-circle"></i> Siap Scan Kode Barang
            </div>
        `);
    });

    //Proses Scan Barang
    $('#ProsesScanCode').submit(function(){
        var ProsesScanCode = $('#ProsesScanCode').serialize();
        $('#NotifikasiScanCode').html('Loading...');
        $.ajax({
            type 	    : 'POST',
            url 	    : '_Page/Penjualan/ProsesScanCode.php',
            data 	    :  ProsesScanCode,
            success     : function(data){
                $('#NotifikasiScanCode').html(data);
                var NotifikasiScanCodeBerhasil=$('#NotifikasiScanCodeBerhasil').html();
                if(NotifikasiScanCodeBerhasil=="Success"){
                    //Tampilkan Data
                    var kategori_transaksi=$('#get_kategori_transaksi').html();
                    ShowDataBulk(kategori_transaksi);


                    //Kosongkan kode
                    $('#keyword_code').val("");

                    //Focus ulang
                    $('#keyword_code').focus();
                }
            }
        });
    });

    //Modal Edit Barang Bulk
    $('#ModalEditBulk').on('show.bs.modal', function (e) {
        var id_transaksi_bulk= $(e.relatedTarget).data('id');
        //Tampilkan Form
        $.ajax({
            type 	    : 'POST',
            url 	    : '_Page/Penjualan/FormEditBulk.php',
            data        : {id_transaksi_bulk: id_transaksi_bulk},
            success     : function(data) {
                // Ganti isi tabel dengan data hasil AJAX dengan efek
                $('#FormEditBulk').fadeOut(200, function() {
                    $(this).html(data).fadeIn(300);
                    
                    //Kosongkan Notifikasi
                    $('#NotifikasiEditBulk').html("");
                    initializeMoneyInputs();
                });
            }
        });
    });

    //Proses Edit Bulk
    $('#ProsesEditBulk').submit(function(){
        var ProsesEditBulk = $('#ProsesEditBulk').serialize();
        $('#NotifikasiEditBulk').html('Loading...');
        $.ajax({
            type 	    : 'POST',
            url 	    : '_Page/Penjualan/ProsesEditBulk.php',
            data 	    :  ProsesEditBulk,
            success     : function(data){
                $('#NotifikasiEditBulk').html(data);
                var NotifikasiEditBulkBerhasil=$('#NotifikasiEditBulkBerhasil').html();
                if(NotifikasiEditBulkBerhasil=="Success"){
                    //Tampilkan Data
                    var kategori_transaksi=$('#get_kategori_transaksi').html();
                    ShowDataBulk(kategori_transaksi);

                    // Tampilkan swal notifikasi
                    Swal.fire(
                        'Success!',
                        'Rincian Transaksi Berhasil Diperbaharui!',
                        'success'
                    );
                    //Tutup Modal
                    $('#ModalEditBulk').modal('hide');
                }
            }
        });
    });

    //Modal Hapus Barang Bulk
    $('#ModalHapusBulk').on('show.bs.modal', function (e) {
        var id_transaksi_bulk= $(e.relatedTarget).data('id');

        //Disable Tombol Pertama Kali
        $('#ButtonHapusBulk').prop("disabled", true);

        //Tampilkan Form
        $.ajax({
            type 	    : 'POST',
            url 	    : '_Page/Penjualan/detail_bulk.php',
            data        : {id_transaksi_bulk: id_transaksi_bulk},
            dataType    : "json",
            success: function (response) {
                //Apabila Proses Berhasil
                if (response.status === "Success") {
                    
                    //Kosongkan Notifikasi
                    $('#NotifikasiHapusBulk').html("");

                    //Tampilkan Form
                    $('#FormHapusBulk').html(`
                        <input type="hidden" name="id_transaksi_bulk" value="${id_transaksi_bulk}">
                        <div class="row mb-2">
                            <div class="col-4"><small>Nama Barang</small></div>
                            <div class="col-8"><small class="text text-grayish">${response.dataset.nama_barang}</small></div>
                        </div>
                        <div class="row mb-2">
                            <div class="col-4"><small>QTY/Satuan</small></div>
                            <div class="col-8"><small class="text text-grayish">${response.dataset.qty} ${response.dataset.satuan}</small></div>
                        </div>
                        <div class="row mb-2">
                            <div class="col-4"><small>Harga</small></div>
                            <div class="col-8"><small class="text text-grayish">${response.dataset.harga_rp}</small></div>
                        </div>
                        <div class="row mb-2">
                            <div class="col-4"><small>PPN</small></div>
                            <div class="col-8"><small class="text text-grayish">${response.dataset.ppn_rp}</small></div>
                        </div>
                        <div class="row mb-2">
                            <div class="col-4"><small>Diskon</small></div>
                            <div class="col-8"><small class="text text-grayish">${response.dataset.diskon_rp}</small></div>
                        </div>
                        <div class="row mb-2">
                            <div class="col-4"><small>Jumlah</small></div>
                            <div class="col-8"><small class="text text-grayish">${response.dataset.subtotal_rp}</small></div>
                        </div>
                        <div class="row mb-3">
                            <div class="col-12">Apakah Anda Yakin Akan Menghapus Data Tersebut</div>
                        </div>
                    `);
                    
                    //Hidupkan Tombol
                    $('#ButtonHapusBulk').prop("disabled", false);
                } else {
                    // Tampilkan pesan error
                    $('#NotifikasiHapusBulk').html(
                        `<div class="alert alert-danger" role="alert">${response.message}</div>`
                    );

                    //Disable Tombol
                    $('#ButtonHapusBulk').prop("disabled", true);
                }
            },
            error: function () {
                $('#NotifikasiHapusBulk').html(
                    '<div class="alert alert-danger" role="alert">Terjadi kesalahan pada sistem. Silakan coba lagi.</div>'
                );
                //Disable Tombol
                $('#ButtonHapusBulk').prop("disabled", true);
            },
        });
    });

    //Proses Hapus Bulk
    $("#ProsesHapusBulk").on("submit", function (e) {
        e.preventDefault();
        // Tombol loading
        let $FormElement = $("#ProsesHapusBulk");
        let $ModalElement = $("#ModalHapusBulk");
        let $Notifikasi = $("#NotifikasiHapusBulk");
        let $ButtonProses = $("#ButtonHapusBulk");
        let ButtonElement = '<i class="bi bi-check"></i> Ya, Hapus';
        $ButtonProses.html('Loading..');
        $ButtonProses.prop("disabled", true);

        // Ambil data form
        let formData = new FormData(this);

        // Kirim data ke server
        $.ajax({
            url         : "_Page/Penjualan/ProsesHapusBulk.php",
            type        : "POST",
            data        : formData,
            contentType : false,
            processData : false,
            dataType    : "json",
            success: function (response) {
                //Apabila Proses Berhasil
                if (response.status === "Success") {

                    //Tampilkan Ulang Data
                    var kategori_transaksi=$('#get_kategori_transaksi').html();
                    ShowDataBulk(kategori_transaksi);
                    
                    // Tampilkan swal notifikasi
                    Swal.fire(
                        'Success!',
                        'Hapus Rincian Barang Berhasil!',
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

    //Modal Cari Barang Edit
    $('#ModalListBarangEdit').on('show.bs.modal', function (e) {
        var id_transaksi_jual_beli=$('#get_id_transaksi_jual_beli_detail').html();
        //Reset Halaman
        $('#put_page_cari_barang_edit').val(1);

        //Tampilkan Data
        ShowDataBarangEdit();
    });

    //Proses Cari Barang
    $("#ProsesCariBarangEdit").on("submit", function (e) {
        //Reset Halaman
        $('#put_page_cari_barang_edit').val(1);

        //Tampilkan Data
        ShowDataBarangEdit();
    });

    //Pagging Barang
    $(document).on('click', '#next_button_barang_edit', function() {
        var page_now = parseInt($('#put_page_cari_barang_edit').val(), 10); // Pastikan nilai diambil sebagai angka
        var next_page = page_now + 1;
        $('#put_page_cari_barang_edit').val(next_page);
        ShowDataBarangEdit();
    });
    $(document).on('click', '#prev_button_barang_edit', function() {
        var page_now = parseInt($('#put_page_cari_barang_edit').val(), 10); // Pastikan nilai diambil sebagai angka
        var next_page = page_now - 1;
        $('#put_page_cari_barang_edit').val(next_page);
        ShowDataBarangEdit();
    });

    //Modal Tambah Barang Edit
    $('#ModalTambahBarangEdit').on('show.bs.modal', function (e) {
        var id_barang= $(e.relatedTarget).data('id');
        var id_transaksi_jual_beli=$('#get_id_transaksi_jual_beli_detail').html();
        //Tampilkan Form
        $.ajax({
            type 	    : 'POST',
            url 	    : '_Page/Penjualan/FormTambahBarangEdit.php',
            data        : {id_barang: id_barang, id_transaksi_jual_beli: id_transaksi_jual_beli},
            success     : function(data) {
                // Ganti isi tabel dengan data hasil AJAX dengan efek
                $('#FormTambahBarangEdit').fadeOut(200, function() {
                    $(this).html(data).fadeIn(300);
                    
                    //Kosongkan Notifikasi
                    $('#NotifikasiTambahBarangEdit').html("");
                    
                });
            }
        });
    });

    //Proses Tambah Rincian Barang Edit
    $('#ProsesTambahBarangEdit').submit(function(){
        var ProsesTambahBarangEdit = $('#ProsesTambahBarangEdit').serialize();
        $('#NotifikasiTambahBarangEdit').html('Loading...');
        $.ajax({
            type 	    : 'POST',
            url 	    : '_Page/Penjualan/ProsesTambahBarangEdit.php',
            data 	    :  ProsesTambahBarangEdit,
            success     : function(data){
                $('#NotifikasiTambahBarangEdit').html(data);
                var NotifikasiTambahBarangEditBerhasil=$('#NotifikasiTambahBarangEditBerhasil').html();
                if(NotifikasiTambahBarangEditBerhasil=="Success"){
                    //Bersihkan Notifikasi
                    $('#NotifikasiTambahBarangEdit').html("");

                    //tutup modal
                    $('#ModalTambahBarangEdit').modal('hide');

                    //Tampilkan Data
                    var id_transaksi_jual_beli=$('#get_id_transaksi_jual_beli_detail').html();
                    ShowDetailTransaksiInline(id_transaksi_jual_beli);
                }
            }
        });
    });

    //Modal Tampilkan Anggota
    $('#ModalPilihAnggota').on('show.bs.modal', function (e) {
        ShowDataAnggota();
    });

    //Pagging Anggota
    $(document).on('click', '#next_button_anggota', function() {
        var page_now = parseInt($('#page_anggota').val(), 10); // Pastikan nilai diambil sebagai angka
        var next_page = page_now + 1;
        $('#page_anggota').val(next_page);
        ShowDataAnggota(0);
    });
    $(document).on('click', '#prev_button_anggota', function() {
        var page_now = parseInt($('#page_anggota').val(), 10); // Pastikan nilai diambil sebagai angka
        var next_page = page_now - 1;
        $('#page_anggota').val(next_page);
        ShowDataAnggota(0);
    });

    //Ketika Submit Filter Anggota
    $('#ProsesCariAnggota').submit(function(){
        //Kembalikan ke halaman 1
        $('#page_anggota').val(1);
        ShowDataAnggota();
    });

    //Ketika Salah Satu Data Anggota Di click
    $(document).on("click", ".pilih_anggota_ke_form_penjualan", function () {
        var idAnggota = $(this).data("id");
        var namaAnggota = $(this).data("nama");
    
        console.log("ID Anggota:", idAnggota);
        console.log("Nama Anggota:", namaAnggota);

        // Set nilai select option
        $("#put_id_anggota_for_add_penjualan").html(`<option value="${idAnggota}">${namaAnggota}</option>`);

        // Tutup modal (jika ada)
        $("#ModalPilihAnggota").modal("hide");
    });

    //Modal Reset Transaksi
    $('#ModalResetTransaksi').on('show.bs.modal', function (e) {
        //Tangkap Kategori Transaksi
        var kategori_transaksi=$('#get_kategori_transaksi').html();

        //Kosongkan Notifikasi
        $('#NotifikasiResetTransaksi').html();

        //Hidupkan Tombol
        $('#ButtonResetTransaksi').html('<i class="bi bi-check"></i> Reset').prop("disabled", false);

        //tempelkan kategori transaksi
        $('#put_kategori_transaksi_for_reset').val(kategori_transaksi);
    });

    //Proses Reset Transaksi
    $("#ProsesResetTransaksi").on("submit", function (e) {
        e.preventDefault();
        // Tombol loading
        let $FormElement = $("#ProsesResetTransaksi");
        let $ModalElement = $("#ModalResetTransaksi");
        let $Notifikasi = $("#NotifikasiResetTransaksi");
        let $ButtonProses = $("#ButtonResetTransaksi");
        let ButtonElement = '<i class="bi bi-check"></i> Reset';
        $ButtonProses.html('Loading..');
        $ButtonProses.prop("disabled", true);

        // Ambil data form
        let formData = new FormData(this);

        // Kirim data ke server
        $.ajax({
            url         : "_Page/Penjualan/ProsesResetTransaksi.php",
            type        : "POST",
            data        : formData,
            contentType : false,
            processData : false,
            dataType    : "json",
            success: function (response) {
                //Apabila Proses Berhasil
                if (response.status === "Success") {

                    //Tampilkan Ulang Data
                    var kategori_transaksi=$('#get_kategori_transaksi').html();
                    ShowDataBulk(kategori_transaksi);
                    
                    // Tampilkan swal notifikasi
                    Swal.fire(
                        'Success!',
                        'Reset Transaksi Berhasil!',
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

    //Ketika Nominal Cash Di ketik
    $("#put_cash_penjualan").on("keyup", function () {
        var put_cash_penjualan=$("#put_cash_penjualan").val();
        var put_total_penjualan=$("#put_total_penjualan").val();
        HitungRekapTransaksi(put_total_penjualan, put_cash_penjualan);
    });

    //Proses Simpan Transaksi Penjualan
    $("#ProsesSimpanTransaksiPenjualan").on("submit", function (e) {
        e.preventDefault();
        // Tombol loading
        $("#ButtonSimpanTransaksiPenjualan").html('Loading..');
        $("#ButtonSimpanTransaksiPenjualan").prop("disabled", true);
        let ButtonElement = '<i class="bi bi-save"></i> Simpan Transaksi';
        // Ambil data form
        let formData = new FormData(this);

        // Kirim data ke server
        $.ajax({
            url         : "_Page/Penjualan/ProsesSimpanTransaksiPenjualan.php",
            type        : "POST",
            data        : formData,
            contentType : false,
            processData : false,
            dataType    : "json",
            success: function (response) {
                //Apabila Proses Berhasil
                if (response.status === "Success") {
                    var id_transaksi_jual_beli=response.id_transaksi_jual_beli;
                    window.location.href = 'index.php?Page=Penjualan&Sub=DetailPenjualan&id='+id_transaksi_jual_beli+'';
                } else {
                    // Tampilkan pesan error
                    $("#NotifikasiSimpanTransaksiPenjualan").html(
                        `<div class="alert alert-danger" role="alert">${response.message}</div>`
                    );
                    $("#ButtonSimpanTransaksiPenjualan").html(ButtonElement).prop("disabled", false);
                }
            },
            error: function () {
                $("#NotifikasiSimpanTransaksiPenjualan").html(
                    '<div class="alert alert-danger" role="alert">Terjadi kesalahan pada sistem. Silakan coba lagi.</div>'
                );
                $("#ButtonSimpanTransaksiPenjualan").html(ButtonElement).prop("disabled", false);
            },
        });
    });

    //Modal Detail
    $('#ModalDetail').on('show.bs.modal', function (e) {
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

    //Modal Edit Transaksi
    $('#ModalEdit').on('show.bs.modal', function (e) {
        var id_transaksi_jual_beli= $(e.relatedTarget).data('id');
        var mode= $(e.relatedTarget).data('mode');
        $('#ButtonEdit').html('<i class="bi bi-save"></i> Simpan');
        $('#ButtonEdit').prop("disabled", true);
        $('#FormEdit').html("Loading...");
        $('#NotifikasiEdit').html("");
        $.ajax({
            type 	    : 'POST',
            url 	    : '_Page/Penjualan/detail_penjualan.php',
            data        : {id_transaksi_jual_beli: id_transaksi_jual_beli},
            dataType    : "json",
            success     : function(response){
                if(response.status=="Success"){
                    var data = response.dataset;
                    var tanggal_jam=data.tanggal;
                    var tanggal = tanggal_jam.split(" ")[0];
                    var jam = tanggal_jam.split(" ")[1];
                    //Tempelkan Form Dan Kosongkan Notifikasi
                    $('#FormEdit').html(`
                        <input type="hidden" name="id_transaksi_jual_beli" value="${id_transaksi_jual_beli}">
                        <input type="hidden" name="mode" id="put_mode_edit" value="${mode}">
                        <div class="row mb-3">
                            <div class="col-4"><small>Tanggal</small></div>
                            <div class="col-8">
                                <input type="date" class="form-control" name="tanggal" id="put_tanggal_edit" value="${tanggal}">
                            </div>
                        </div>
                        <div class="row mb-3">
                            <div class="col-4"><small>Waktu/Jam</small></div>
                            <div class="col-8">
                                <input type="time" class="form-control" name="jam" id="put_jam_edit" value="${jam}">
                            </div>
                        </div>
                        <div class="row mb-3">
                            <div class="col-4"><small>Total</small></div>
                            <div class="col-8">
                                <input type="text" readonly class="form-control form-money" name="total" id="put_total_edit" value="${data.total}">
                            </div>
                        </div>
                        <div class="row mb-3">
                            <div class="col-4"><small>Cash</small></div>
                            <div class="col-8">
                                <input type="text" class="form-control form-money" name="cash" id="put_cash_edit" value="${data.cash}">
                            </div>
                        </div>
                        <div class="row mb-3">
                            <div class="col-4"><small>Kembalian</small></div>
                            <div class="col-8">
                                <input type="text" readonly class="form-control form-money" name="kembalian" id="put_kembalian_edit" value="${data.kembalian}">
                            </div>
                        </div>
                        <div class="row mb-3">
                            <div class="col-4"><small>Status</small></div>
                            <div class="col-8">
                                <input type="text" readonly class="form-control" name="status" id="put_status_edit" value="${data.status}">
                            </div>
                        </div>
                    `);
                    //Enable Button
                    $('#ButtonEdit').prop("disabled", false);

                    initializeMoneyInputs();

                    //Ketika Nominal Cash Diubah
                    $("#put_cash_edit").on("keyup", function () {
                        var put_cash_penjualan=$("#put_cash_edit").val();
                        var put_total_penjualan=$("#put_total_edit").val();
                        
                        // Hapus titik pemisah ribuan dan konversi ke angka
                        var totalNum = parseInt(put_total_penjualan.replace(/\./g, ""), 10);
                        var cashNum = parseInt(put_cash_penjualan.replace(/\./g, ""), 10);
                    
                        // Hitung kembalian
                        var kembalian = cashNum - totalNum;
                        if (kembalian < 0) {
                            kembalian = 0;
                        }
                    
                        // Tentukan status pembayaran
                        var status = (cashNum < totalNum) ? "Kredit" : "Lunas";
                    
                        // Format kembali ke dalam format ribuan dengan titik
                        var formattedKembalian = kembalian.toLocaleString("id-ID");
                    
                        // Tempelkan Data Ke Form
                        $('#put_kembalian_edit').val(formattedKembalian);
                        $('#put_status_edit').val(status);
                    });
                }else{
                    //Tempelkan Form Dan Kosongkan Notifikasi
                    $('#FormEdit').html(
                        `<div class="alert alert-danger" role="alert">${response.message}</div>`
                    );
                    $('#NotifikasiEdit').html('');
                    //Disable tombol
                    $('#ButtonEdit').prop("disabled", true);
                }
            },
            error: function () {
                //Tempelkan Form Dan Kosongkan Notifikasi
                $('#FormEdit').html(
                    '<div class="alert alert-danger" role="alert">Terjadi kesalahan pada sistem. Silakan coba lagi.</div>'
                );
                $('#NotifikasiEdit').html('');
                //Disable tombol
                $('#ButtonEdit').prop("disabled", true);
            },
        });
    });

    //Proses Edir Transaksi
    $("#ProsesEdit").on("submit", function (e) {
        e.preventDefault();
        // Tombol loading
        $("#ButtonEdit").html('Loading..');
        $("#ButtonEdit").prop("disabled", true);
        let ButtonElement = '<i class="bi bi-save"></i> Simpan';
        // Ambil data form
        let formData = new FormData(this);

        // Kirim data ke server
        $.ajax({
            url         : "_Page/Penjualan/ProsesEdit.php",
            type        : "POST",
            data        : formData,
            contentType : false,
            processData : false,
            dataType    : "json",
            success: function (response) {
                //Apabila Proses Berhasil
                if (response.status === "Success") {
                    var mode=response.mode;
                    var id_transaksi_jual_beli=response.id_transaksi_jual_beli;
                    $("#ButtonEdit").html(ButtonElement).prop("disabled", false);
                    $('#NotifikasiEdit').html('');
                    
                    //Tutup Modal
                    $('#ModalEdit').modal('hide');
                    
                    //Reload Data
                    if(mode=="List"){
                        ShowData();
                    }else{
                        ShowDetailTransaksiInline(id_transaksi_jual_beli);
                    }
                    
                    //Tampilkan Alert
                    Swal.fire(
                        'Success!',
                        'Edit Transaksi Berhasil!',
                        'success'
                    )
                } else {
                    // Tampilkan pesan error
                    $("#NotifikasiEdit").html(
                        `<div class="alert alert-danger" role="alert">${response.message}</div>`
                    );
                    $("#ButtonEdit").html(ButtonElement).prop("disabled", true);
                }
            },
            error: function () {
                $("#NotifikasiEdit").html(
                    '<div class="alert alert-danger" role="alert">Terjadi kesalahan pada sistem. Silakan coba lagi.</div>'
                );
                $("#ButtonEdit").html(ButtonElement).prop("disabled", true);
            },
        });
    });

    //Modal Hapus Transaksi
    $('#ModalHapus').on('show.bs.modal', function (e) {
        var id_transaksi_jual_beli= $(e.relatedTarget).data('id');
        var mode= $(e.relatedTarget).data('mode');
        $('#ButtonHapus').html('<i class="bi bi-check"></i> Ya, Hapus');
        $('#ButtonHapus').prop("disabled", true);
        $('#FormHapus').html("Loading...");
        $.ajax({
            type 	    : 'POST',
            url 	    : '_Page/Penjualan/detail_penjualan.php',
            data        : {id_transaksi_jual_beli: id_transaksi_jual_beli},
            dataType    : "json",
            success     : function(response){
                if(response.status=="Success"){
                    var data = response.dataset;
                    //Tempelkan Form Dan Kosongkan Notifikasi
                    $('#FormHapus').html(`
                        <input type="hidden" name="id_transaksi_jual_beli" value="${id_transaksi_jual_beli}">
                        <input type="hidden" name="mode" value="${mode}">
                        <div class="row mb-2">
                            <div class="col-4"><small>Tanggal</small></div>
                            <div class="col-8">
                                <small class="text text-grayish">${data.tanggal}</small>
                            </div>
                        </div>
                        <div class="row mb-2">
                            <div class="col-4"><small>Anggota</small></div>
                            <div class="col-8">
                                <small class="text text-grayish">${data.nama_anggota}</small>
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
                    $('#NotifikasiHapus').html('Apakah Anda Yakin Akan Menghapus Data Tersebut?');
                    //Disable tombol
                    $('#ButtonHapus').prop("disabled", false);
                }else{
                    //Tempelkan Form Dan Kosongkan Notifikasi
                    $('#FormHapus').html(
                        `<div class="alert alert-danger" role="alert">${response.message}</div>`
                    );
                    $('#NotifikasiHapus').html('');
                    //Disable tombol
                    $('#ButtonHapus').prop("disabled", true);
                }
            },
            error: function () {
                //Tempelkan Form Dan Kosongkan Notifikasi
                $('#FormHapus').html(
                    '<div class="alert alert-danger" role="alert">Terjadi kesalahan pada sistem. Silakan coba lagi.</div>'
                );
                $('#NotifikasiHapus').html('');
                //Disable tombol
                $('#ButtonHapus').prop("disabled", true);
            },
        });
    });

    //Proses Hapus Transaksi
    $("#ProsesHapus").on("submit", function (e) {
        e.preventDefault();
        // Tombol loading
        $("#ButtonHapus").html('Loading..');
        $("#ButtonHapus").prop("disabled", true);
        let ButtonElement = '<i class="bi bi-check"></i> Ya, Hapus';
        // Ambil data form
        let formData = new FormData(this);

        // Kirim data ke server
        $.ajax({
            url         : "_Page/Penjualan/ProsesHapus.php",
            type        : "POST",
            data        : formData,
            contentType : false,
            processData : false,
            dataType    : "json",
            success: function (response) {
                //Apabila Proses Berhasil
                if (response.status === "Success") {
                    var mode=response.mode;
                    $("#ButtonHapus").html(ButtonElement).prop("disabled", false);
                    $('#NotifikasiHapus').html('');
                    
                    //Tutup Modal
                    $('#ModalHapus').modal('hide');
                    
                    //Tampilkan Alert
                    Swal.fire(
                        'Success!',
                        'Hapus Transaksi Berhasil!',
                        'success'
                    );

                    //Reload Data
                    if(mode=="List"){
                        ShowData();
                    }else{
                        window.location.replace("index.php?Page=Penjualan");
                    }
                } else {
                    // Tampilkan pesan error
                    $("#NotifikasiHapus").html(
                        `<div class="alert alert-danger" role="alert">${response.message}</div>`
                    );
                    $("#ButtonHapus").html(ButtonElement).prop("disabled", true);
                }
            },
            error: function () {
                $("#NotifikasiHapus").html(
                    '<div class="alert alert-danger" role="alert">Terjadi kesalahan pada sistem. Silakan coba lagi.</div>'
                );
                $("#ButtonHapus").html(ButtonElement).prop("disabled", true);
            },
        });
    });

    //Modal Cetak Transaksi
    $('#ModalCetak').on('show.bs.modal', function (e) {
        var id_transaksi_jual_beli= $(e.relatedTarget).data('id');
        $('#FormDetailCetak').html("Loading...");
        $.ajax({
            type 	    : 'POST',
            url 	    : '_Page/Penjualan/PreviewCetak.php',
            data        : {id_transaksi_jual_beli: id_transaksi_jual_beli},
            success     : function(data){
                $('#FormDetailCetak').html(data);
            }
        });
    });

    $('#ProsesCetak').submit(function(event) {
        event.preventDefault(); // Mencegah reload halaman
        
        var formatCetak = $('input[name="tipe_cetak"]:checked').val(); // Ambil format yang dipilih
        var content = document.getElementById("FormDetailCetak"); // Ambil elemen yang ingin dicetak

        if (!formatCetak) {
            $('#NotifikasiCetak').html('<div class="alert alert-danger">Silakan pilih format cetak!</div>');
            return;
        }

        // Tampilkan loading
        $('#NotifikasiCetak').html('<div class="alert alert-info">Sedang memproses cetak...</div>');
        $('#ButtonCetak').prop('disabled', true).html('<i class="bi bi-hourglass-split"></i> Memproses...');

        setTimeout(() => {
            if (formatCetak === "PDF") {
                html2canvas(content, { scale: 2 }).then(canvas => {
                    var imgData = canvas.toDataURL("image/png");
                    var { jsPDF } = window.jspdf;
                    var doc = new jsPDF("p", "mm", "a4");
                    var imgWidth = 190;
                    var imgHeight = (canvas.height * imgWidth) / canvas.width;

                    doc.addImage(imgData, "PNG", 10, 10, imgWidth, imgHeight);
                    doc.save("Nota_Transaksi.pdf");

                    $('#NotifikasiCetak').html('<div class="alert alert-success">Download PDF berhasil!</div>');
                    resetButton();
                }).catch(error => {
                    $('#NotifikasiCetak').html('<div class="alert alert-danger">Gagal mencetak PDF!</div>');
                    resetButton();
                });
            } else if (formatCetak === "Image") {
                html2canvas(content, { scale: 2 }).then(canvas => {
                    var imgData = canvas.toDataURL("image/png");
                    var link = document.createElement("a");
                    link.href = imgData;
                    link.download = "Nota_Transaksi.png";
                    link.click();

                    $('#NotifikasiCetak').html('<div class="alert alert-success">Download gambar berhasil!</div>');
                    resetButton();
                }).catch(error => {
                    $('#NotifikasiCetak').html('<div class="alert alert-danger">Gagal mencetak gambar!</div>');
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
                    $('#NotifikasiCetak').html('<div class="alert alert-success">Pencetakan berhasil!</div>');
                    resetButton();
                }, 1000);
            }
        }, 1000);
    });

    function resetButton() {
        $('#ButtonCetak').prop('disabled', false).html('<i class="bi bi-printer"></i> Cetak');
    }

    //Modal List Anggota Edit
    $('#ModalListAnggotaEdit').on('show.bs.modal', function (e) {
        var id_transaksi_jual_beli= $(e.relatedTarget).data('id');
        var mode= $(e.relatedTarget).data('mode');
        ShowDataAnggotaEdit(id_transaksi_jual_beli,mode);
    });

    //Pagging Anggota
    $(document).on('click', '#next_button_anggota_edit', function() {
        var id_transaksi_jual_beli =$('#put_id_transaksi_jual_beli_anggota_edit').val();
        var mode =$('#put_mode_edit_anggota').val();
        var page_now = parseInt($('#page_anggota_edit').val(), 10);
        var next_page = page_now + 1;
        $('#page_anggota_edit').val(next_page);
        ShowDataAnggotaEdit(id_transaksi_jual_beli,mode);
    });
    $(document).on('click', '#prev_button_anggota_edit', function() {
        var id_transaksi_jual_beli =$('#put_id_transaksi_jual_beli_anggota_edit').val();
        var mode =$('#put_mode_edit_anggota').val();
        var page_now = parseInt($('#page_anggota_edit').val(), 10);
        var next_page = page_now - 1;
        $('#page_anggota_edit').val(next_page);
        ShowDataAnggotaEdit(id_transaksi_jual_beli,mode);
    });

    //Ketika Submit Filter Anggota
    $('#ProsesCariAnggotaEdit').submit(function(){
        var id_transaksi_jual_beli =$('#put_id_transaksi_jual_beli_anggota_edit').val();
        var mode =$('#put_mode_edit_anggota').val();
        //Kembalikan ke halaman 1
        $('#page_anggota_edit').val(1);
        ShowDataAnggotaEdit(id_transaksi_jual_beli,mode);
    });

    //Modal Edit Anggota
    $('#ModalEditAnggota').on('show.bs.modal', function (e) {
        var id_anggota= $(e.relatedTarget).data('id');
        var id_transaksi_jual_beli= $(e.relatedTarget).data('transaksi');
        var mode= $(e.relatedTarget).data('mode');
        //Kosongkan Notifikasi
        $('#NotifikasiEditAnggota').html("");

        //Loading Form
        $('#FormEditAnggota').html("Loading...");
        //Tampilkan Form
        $.ajax({
            type 	    : 'POST',
            url 	    : '_Page/Penjualan/FormEditAnggota.php',
            data        : {id_transaksi_jual_beli: id_transaksi_jual_beli, id_anggota: id_anggota, mode: mode},
            success     : function(data){
                $('#FormEditAnggota').html(data);
                $("#ButtonEditAnggota").prop("disabled", false);
            }
        });
    });

    //Proses Edit Anggota
    $("#ProsesEditAnggota").on("submit", function (e) {
        e.preventDefault();
        // Tombol loading
        $("#ButtonEditAnggota").html('Loading..');
        $("#ButtonEditAnggota").prop("disabled", true);
        let ButtonElement = '<i class="bi bi-save"></i> Simpan';
        // Ambil data form
        let formData = new FormData(this);

        // Kirim data ke server
        $.ajax({
            url         : "_Page/Penjualan/ProsesEditAnggota.php",
            type        : "POST",
            data        : formData,
            contentType : false,
            processData : false,
            dataType    : "json",
            success: function (response) {
                //Apabila Proses Berhasil
                if (response.status === "Success") {
                    var mode=response.mode;
                    var id_transaksi_jual_beli=response.id_transaksi_jual_beli;

                    $("#ButtonEditAnggota").html(ButtonElement).prop("disabled", false);
                    $('#NotifikasiEditAnggota').html('');
                    
                    //Tutup Modal
                    $('#ModalEditAnggota').modal('hide');
                    
                    //Tampilkan Alert
                    Swal.fire(
                        'Success!',
                        'Edit Anggota Berhasil!',
                        'success'
                    );

                    //Reload Data
                    if(mode=="List"){
                        ShowData();
                    }else{
                        ShowDetailTransaksiInline(id_transaksi_jual_beli);
                    }
                } else {
                    // Tampilkan pesan error
                    $("#NotifikasiEditAnggota").html(
                        `<div class="alert alert-danger" role="alert">${response.message}</div>`
                    );
                    $("#ButtonEditAnggota").html(ButtonElement).prop("disabled", true);
                }
            },
            error: function () {
                $("#NotifikasiEditAnggota").html(
                    '<div class="alert alert-danger" role="alert">Terjadi kesalahan pada sistem. Silakan coba lagi.</div>'
                );
                $("#ButtonEditAnggota").html(ButtonElement).prop("disabled", true);
            },
        });
    });

    //Modal Edit Rincian Transaksi
    $('#ModalEditRincian').on('show.bs.modal', function (e) {
        var id_transaksi_jual_beli_rincian= $(e.relatedTarget).data('id');
        //Tempelkan Ke form
        $("#put_id_transaksi_jual_beli_rincian_edit").val(id_transaksi_jual_beli_rincian);
        
        // Kirim data ke server
        $.ajax({
            url         : "_Page/Penjualan/detail_rincian.php",
            type        : "POST",
            data        : {id_transaksi_jual_beli_rincian: id_transaksi_jual_beli_rincian},
            dataType    : "json",
            success: function (response) {
                if(response.status=="Success"){
                    let dataset=response.dataset;
                    let nama_barang=dataset.nama_barang;
                    let satuan=dataset.satuan;
                    let qty=dataset.qty;
                    let harga=dataset.harga;
                    let ppn=dataset.ppn;
                    let diskon=dataset.diskon;
                    let subtotal=dataset.subtotal;
                    //Tempelkan Ke form
                    $("#put_nama_barang_edit_rincian").html(nama_barang);
                    $("#put_satuan_edit_rincian").html(satuan);
                    $("#qty_edit_rincian").val(qty);
                    $("#harga_edit_rincian").val(harga);
                    $("#ppn_edit_rincian").val(ppn);
                    $("#diskon_edit_rincian").val(diskon);
                    $("#jumlah_edit_rincian").val(subtotal);

                    // Event listener untuk input perubahan
                    $('#qty_edit_rincian, #harga_edit_rincian, #ppn_edit_rincian, #diskon_edit_rincian').on('input', function(){
                        hitungTotalEdit();
                        initializeMoneyInputs();
                    });

                    // Panggil fungsi pertama kali saat halaman dimuat
                    hitungTotalEdit();
                    initializeMoneyInputs();

                    $("#ButtonEditRincian").prop("disabled", false);
                }else{
                    // Tampilkan pesan error
                    $("#NotifikasiEditRincian").html(
                        `<div class="alert alert-danger" role="alert">${response.message}</div>`
                    );
                    $("#ButtonEditRincian").prop("disabled", true);
                }
            },
            error: function () {
                $("#NotifikasiEditRincian").html(
                    '<div class="alert alert-danger" role="alert">Terjadi kesalahan pada sistem. Silakan coba lagi.</div>'
                );
                $("#ButtonEditRincian").prop("disabled", true);
            },
        });
    });

    //Proses Edit Rincian
    $("#ProsesEditRincian").on("submit", function (e) {
        e.preventDefault();
        // Tombol loading
        $("#ButtonEditRincian").html('Loading..');
        $("#ButtonEditRincian").prop("disabled", true);
        let ButtonElement = '<i class="bi bi-save"></i> Simpan';
        // Ambil data form
        let formData = new FormData(this);

        // Kirim data ke server
        $.ajax({
            url         : "_Page/Penjualan/ProsesEditRincian.php",
            type        : "POST",
            data        : formData,
            contentType : false,
            processData : false,
            dataType    : "json",
            success: function (response) {
                //Apabila Proses Berhasil
                if (response.status === "Success") {
                    $("#ButtonEditRincian").html(ButtonElement).prop("disabled", false);
                    $('#NotifikasiEditRincian').html('');
                    
                    //Tutup Modal
                    $('#ModalEditRincian').modal('hide');
                    
                    //Tampilkan Alert
                    Swal.fire(
                        'Success!',
                        'Edit Rincian Transaksi Berhasil!',
                        'success'
                    );
                    var id_transaksi_jual_beli=$("#get_id_transaksi_jual_beli_detail").html();
                    //Reload Data
                    ShowDetailTransaksiInline(id_transaksi_jual_beli);
                } else {
                    // Tampilkan pesan error
                    $("#NotifikasiEditRincian").html(
                        `<div class="alert alert-danger" role="alert">${response.message}</div>`
                    );
                    $("#ButtonEditRincian").html(ButtonElement).prop("disabled", true);
                }
            },
            error: function () {
                $("#NotifikasiEditRincian").html(
                    '<div class="alert alert-danger" role="alert">Terjadi kesalahan pada sistem. Silakan coba lagi.</div>'
                );
                $("#ButtonEditRincian").html(ButtonElement).prop("disabled", true);
            },
        });
    });

    //Modal Hapus Rincian Transaksi
    $('#ModalHapusRincian').on('show.bs.modal', function (e) {
        var id_transaksi_jual_beli_rincian= $(e.relatedTarget).data('id');
        //Tempelkan Ke form
        $("#put_id_transaksi_jual_beli_rincian_hapus").val(id_transaksi_jual_beli_rincian);
        
        // Kirim data ke server
        $.ajax({
            url         : "_Page/Penjualan/detail_rincian.php",
            type        : "POST",
            data        : {id_transaksi_jual_beli_rincian: id_transaksi_jual_beli_rincian},
            dataType    : "json",
            success: function (response) {
                if(response.status=="Success"){
                    let dataset=response.dataset;
                    let nama_barang=dataset.nama_barang;
                    let satuan=dataset.satuan;
                    let qty=dataset.qty;
                    let harga_rp=dataset.harga_rp;
                    let ppn_rp=dataset.ppn_rp;
                    let diskon_rp=dataset.diskon_rp;
                    let subtotal_rp=dataset.subtotal_rp;

                    //Tempelkan Pada Form
                    $("#FormHapusRincian").html(`
                        <diiv class="row mb-2">
                            <div class="col-4"><small>Nama Barang</small></div>
                            <div class="col-8"><small class="text text-muted">${nama_barang}</small></div>
                        </diiv>
                        <diiv class="row mb-2">
                            <div class="col-4"><small>QTY/Satuan</small></div>
                            <div class="col-8"><small class="text text-muted">${qty} ${satuan}</small></div>
                        </diiv>
                        <diiv class="row mb-2">
                            <div class="col-4"><small>Harga (Rp)</small></div>
                            <div class="col-8"><small class="text text-muted">${harga_rp}</small></div>
                        </diiv>
                        <diiv class="row mb-2">
                            <div class="col-4"><small>PPN (Rp)</small></div>
                            <div class="col-8"><small class="text text-muted">${ppn_rp}</small></div>
                        </diiv>
                        <diiv class="row mb-2">
                            <div class="col-4"><small>Diskon (Rp)</small></div>
                            <div class="col-8"><small class="text text-muted">${diskon_rp}</small></div>
                        </diiv>
                        <diiv class="row mb-2">
                            <div class="col-4"><small>Subtotal (Rp)</small></div>
                            <div class="col-8"><small class="text text-muted">${subtotal_rp}</small></div>
                        </diiv>
                        <diiv class="row mb-2 mt-2">
                            <div class="col-12">Apakah Anda Yakin Akan Menghapus Riincian ini?</div>
                        </diiv>
                    `);

                    // Enable Tombol
                    $("#ButtonHapusRincian").prop("disabled", false);
                }else{
                    // Tampilkan pesan error
                    $("#NotifikasiHapusRincian").html(
                        `<div class="alert alert-danger" role="alert">${response.message}</div>`
                    );

                    //Disable Tombol
                    $("#ButtonHapusRincian").prop("disabled", true);
                }
            },
            error: function () {
                $("#NotifikasiHapusRincian").html(
                    '<div class="alert alert-danger" role="alert">Terjadi kesalahan pada sistem. Silakan coba lagi.</div>'
                );

                //Disable Tombol
                $("#ButtonHapusRincian").prop("disabled", true);
            },
        });
    });

    //Proses Hapus Rincian
    $("#ProssesHapusRincian").on("submit", function (e) {
        e.preventDefault();
        // Tombol loading
        $("#ButtonHapusRincian").html('Loading..');
        $("#ButtonHapusRincian").prop("disabled", true);
        let ButtonElement = '<i class="bi bi-check"></i> Ya, Hapus';
        
        // Ambil data form
        let formData = new FormData(this);

        // Kirim data ke server
        $.ajax({
            url         : "_Page/Penjualan/ProssesHapusRincian.php",
            type        : "POST",
            data        : formData,
            contentType : false,
            processData : false,
            dataType    : "json",
            success: function (response) {
                //Apabila Proses Berhasil
                if (response.status === "Success") {
                    $("#ButtonHapusRincian").html(ButtonElement).prop("disabled", false);
                    $('#NotifikasiHapusRincian').html('');
                    
                    //Tutup Modal
                    $('#ModalHapusRincian').modal('hide');
                    
                    //Tampilkan Alert
                    Swal.fire(
                        'Success!',
                        'Hapus Rincian Transaksi Berhasil!',
                        'success'
                    );
                    var id_transaksi_jual_beli=$("#get_id_transaksi_jual_beli_detail").html();
                    //Reload Data
                    ShowDetailTransaksiInline(id_transaksi_jual_beli);
                } else {
                    // Tampilkan pesan error
                    $("#NotifikasiHapusRincian").html(
                        `<div class="alert alert-danger" role="alert">${response.message}</div>`
                    );
                    $("#ButtonHapusRincian").html(ButtonElement).prop("disabled", true);
                }
            },
            error: function () {
                $("#NotifikasiHapusRincian").html(
                    '<div class="alert alert-danger" role="alert">Terjadi kesalahan pada sistem. Silakan coba lagi.</div>'
                );
                $("#ButtonHapusRincian").html(ButtonElement).prop("disabled", true);
            },
        });
    });

    //Modal Tambah Jurnal
    $('#ModalTambahJurnal').on('show.bs.modal', function (e) {
        var id_transaksi_jual_beli= $(e.relatedTarget).data('id');
        // Kirim data ke server
        $.ajax({
            url         : "_Page/Penjualan/FormTambahJurnal.php",
            type        : "POST",
            data        : {id_transaksi_jual_beli: id_transaksi_jual_beli},
            success: function (response) {
                $("#FormiTambahJurnal").html(response);
                $("#NotifikasiTambahJurnal").html("");
                $("#ButtonTambahJurnal").prop("disabled", false);
                initializeMoneyInputs();
            }
        });
    });

    //Proses Tambah Jurnal
    $("#ProsesTambahJurnal").on("submit", function (e) {
        e.preventDefault();
        // Tombol loading
        $("#ButtonTambahJurnal").html('Loading..');
        $("#ButtonTambahJurnal").prop("disabled", true);
        let ButtonElement = '<i class="bi bi-save"></i> Simpan';
        
        // Ambil data form
        let formData = new FormData(this);

        // Kirim data ke server
        $.ajax({
            url         : "_Page/Penjualan/ProsesTambahJurnal.php",
            type        : "POST",
            data        : formData,
            contentType : false,
            processData : false,
            dataType    : "json",
            success: function (response) {
                //Apabila Proses Berhasil
                if (response.status === "Success") {
                    $("#ButtonTambahJurnal").html(ButtonElement).prop("disabled", false);
                    $('#NotifikasiTambahJurnal').html('');
                    
                    //Tutup Modal
                    $('#ModalTambahJurnal').modal('hide');
                    
                    //Tampilkan Alert
                    Swal.fire(
                        'Success!',
                        'Tambah Jurnal Penjualan Berhasil!',
                        'success'
                    );
                    var id_transaksi_jual_beli=$("#get_id_transaksi_jual_beli_detail").html();
                    //Reload Data
                    ShowDetailTransaksiInline(id_transaksi_jual_beli);
                } else {
                    // Tampilkan pesan error
                    $("#NotifikasiTambahJurnal").html(
                        `<div class="alert alert-danger" role="alert">${response.message}</div>`
                    );
                    $("#ButtonTambahJurnal").html(ButtonElement).prop("disabled", true);
                }
            },
            error: function () {
                $("#NotifikasiTambahJurnal").html(
                    '<div class="alert alert-danger" role="alert">Terjadi kesalahan pada sistem. Silakan coba lagi.</div>'
                );
                $("#ButtonTambahJurnal").html(ButtonElement).prop("disabled", true);
            },
        });
    });

    //Modal Hapus Jurnal
    $('#ModalHapusJurnal').on('show.bs.modal', function (e) {
        var id_jurnal= $(e.relatedTarget).data('id');
        // Kirim data ke server
        $.ajax({
            url         : "_Page/Jurnal/FormHapusJurnal.php",
            type        : "POST",
            data        : {id_jurnal: id_jurnal},
            success: function (response) {
                $("#FormHapusJurnal").html(response);
                $("#NotifikasiHapusJurnal").html("");
                $("#ButtonHapusJurnal").prop("disabled", false);
            }
        });
    });

    //Proses Hapus Jurnal
    $("#ProsesHapusJurnal").on("submit", function (e) {
        e.preventDefault();
        // Tombol loading
        $("#ButtonHapusJurnal").html('Loading..');
        $("#ButtonHapusJurnal").prop("disabled", true);
        let ButtonElement = '<i class="bi bi-check"></i> Ya, Hapus';
        
        // Ambil data form
        let formData = new FormData(this);

        // Kirim data ke server
        $.ajax({
            url         : "_Page/Jurnal/ProsesHapusJurnal_v3.php",
            type        : "POST",
            data        : formData,
            contentType : false,
            processData : false,
            dataType    : "json",
            success: function (response) {
                //Apabila Proses Berhasil
                if (response.status === "Success") {
                    $("#ButtonHapusJurnal").html(ButtonElement).prop("disabled", false);
                    $('#NotifikasiHapusJurnal').html('');
                    
                    //Tutup Modal
                    $('#ModalHapusJurnal').modal('hide');
                    
                    //Tampilkan Alert
                    Swal.fire(
                        'Success!',
                        'Hapus Jurnal Penjualan Berhasil!',
                        'success'
                    );
                    var id_transaksi_jual_beli=$("#get_id_transaksi_jual_beli_detail").html();
                    //Reload Data
                    ShowDetailTransaksiInline(id_transaksi_jual_beli);
                } else {
                    // Tampilkan pesan error
                    $("#NotifikasiHapusJurnal").html(
                        `<div class="alert alert-danger" role="alert">${response.message}</div>`
                    );
                    $("#ButtonHapusJurnal").html(ButtonElement).prop("disabled", true);
                }
            },
            error: function () {
                $("#NotifikasiHapusJurnal").html(
                    '<div class="alert alert-danger" role="alert">Terjadi kesalahan pada sistem. Silakan coba lagi.</div>'
                );
                $("#ButtonHapusJurnal").html(ButtonElement).prop("disabled", true);
            },
        });
    });

    //Modal Edit Jurnal
    $('#ModalEditJurnal').on('show.bs.modal', function (e) {
        var id_jurnal= $(e.relatedTarget).data('id');
        // Kirim data ke server
        $.ajax({
            url         : "_Page/Jurnal/FormEditJurnalManual.php",
            type        : "POST",
            data        : {id_jurnal: id_jurnal},
            success: function (response) {
                $("#FormEditJurnal").html(response);
                $("#NotifikasiEditJurnal").html("");
                $("#ButtonEditJurnal").prop("disabled", false);
                initializeMoneyInputs();
            }
        });
    });

    //Proses Edit Jurnal
    $("#ProsesEditJurnal").on("submit", function (e) {
        e.preventDefault();
        // Tombol loading
        $("#ButtonEditJurnal").html('Loading..');
        $("#ButtonEditJurnal").prop("disabled", true);
        let ButtonElement = '<i class="bi bi-save"></i> Simpan';
        
        // Ambil data form
        let formData = new FormData(this);

        // Kirim data ke server
        $.ajax({
            url         : "_Page/Jurnal/ProsesEditJurnal_v3.php",
            type        : "POST",
            data        : formData,
            contentType : false,
            processData : false,
            dataType    : "json",
            success: function (response) {
                //Apabila Proses Berhasil
                if (response.status === "Success") {
                    $("#ButtonEditJurnal").html(ButtonElement).prop("disabled", false);
                    $('#NotifikasiEditJurnal').html('');
                    
                    //Tutup Modal
                    $('#ModalEditJurnal').modal('hide');
                    
                    //Tampilkan Alert
                    Swal.fire(
                        'Success!',
                        'Edit Jurnal Penjualan Berhasil!',
                        'success'
                    );
                    var id_transaksi_jual_beli=$("#get_id_transaksi_jual_beli_detail").html();
                    //Reload Data
                    ShowDetailTransaksiInline(id_transaksi_jual_beli);
                } else {
                    // Tampilkan pesan error
                    $("#NotifikasiEditJurnal").html(
                        `<div class="alert alert-danger" role="alert">${response.message}</div>`
                    );
                    $("#ButtonEditJurnal").html(ButtonElement).prop("disabled", true);
                }
            },
            error: function () {
                $("#NotifikasiEditJurnal").html(
                    '<div class="alert alert-danger" role="alert">Terjadi kesalahan pada sistem. Silakan coba lagi.</div>'
                );
                $("#ButtonEditJurnal").html(ButtonElement).prop("disabled", true);
            },
        });
    });
});
//Fungsi Menampilkan Tabel Sesi
function ShowSesi() {
    var ProsesFilterSesi = $('#ProsesFilterSesi').serialize();
    $.ajax({
        type    : 'POST',
        url     : '_Page/StockOpename/TabelSesi.php',
        data    : ProsesFilterSesi,
        success: function(data) {
            $('#TabelSesi').html(data);
        }
    });
}

//Fungsi Menampilkan Detail Sesi
function ShowDetailSesi(id_stok_opename) {
    $.ajax({
        type    : 'POST',
        url     : '_Page/StockOpename/DetailSesi.php',
        data    : {id_stok_opename: id_stok_opename},
        success: function(data) {
            $('#put_detail_sesi').html(data);
        }
    });
}

//Fungsi Menampilkan Barang
function ShowBarang() {
    var ProsesFilterBarang = $('#ProsesFilterBarang').serialize();
    $.ajax({
        type    : 'POST',
        url     : '_Page/StockOpename/TabelBarang.php',
        data    : ProsesFilterBarang,
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
$(document).ready(function() {
    //Menampilkan Sesi Pertama Kali
    ShowSesi();

    //Ketika keyword By Diubah
    $('#keyword_by_sesi').change(function(){
        var keyword_by_sesi = $('#keyword_by_sesi').val();
        $.ajax({
            type 	    : 'POST',
            url 	    : '_Page/StockOpename/FormFilterKeywordSesi.php',
            data 	    :  {keyword_by: keyword_by_sesi},
            success     : function(data){
                $('#FormFilterKeywordSesi').html(data);
            }
        });
    });

    //Submit Filter Sesi
    $('#ProsesFilterSesi').submit(function(){
        ShowSesi();
        $('#ModalFilterSesi').modal('hide');
    });
    
    //Pagging Sesi
    $(document).on('click', '#next_button', function() {
        var page_now = parseInt($('#page').val(), 10); // Pastikan nilai diambil sebagai angka
        var next_page = page_now + 1;
        $('#page').val(next_page);
        ShowSesi(0);
    });
    $(document).on('click', '#prev_button', function() {
        var page_now = parseInt($('#page').val(), 10); // Pastikan nilai diambil sebagai angka
        var next_page = page_now - 1;
        $('#page').val(next_page);
        ShowSesi(0);
    });

    //Proses Tambah Sesi
    $('#ProsesTambahSesi').submit(function(){
        var ProsesTambahSesi = $('#ProsesTambahSesi').serialize();
        $('#NotifikasiTambahSesi').html('Loading...');
        $.ajax({
            type 	    : 'POST',
            url 	    : '_Page/StockOpename/ProsesTambahSesi.php',
            data 	    :  ProsesTambahSesi,
            success     : function(data){
                $('#NotifikasiTambahSesi').html(data);
                var NotifikasiTambahSesiBerhasil=$('#NotifikasiTambahSesiBerhasil').html();
                if(NotifikasiTambahSesiBerhasil=="Success"){
                    //Bersihkan Notifikasi
                    $('#NotifikasiTambahSesi').html("");

                    //tutup modal
                    $('#ModalTambahSesi').modal('hide');

                    //Reset halaman
                    $('#page').val(1);

                    //Reset Form
                    $('#ProsesTambahSesi')[0].reset();

                    //Tampilkan Data
                    ShowSesi();

                    //Tampilkan Swal
                    Swal.fire(
                        'Success!',
                        'Tambah Sesi Stock Opename Berhasil!',
                        'success'
                    )
                }
            }
        });
    });

    //Modal Edit Sesi
    $('#ModalEditSesi').on('show.bs.modal', function (e) {
        var id_stok_opename = $(e.relatedTarget).data('id');
        var tanggal = $(e.relatedTarget).data('tanggal');
        var status = $(e.relatedTarget).data('status');
        //Kosongkan Notifikasi
        $('#NotifikasiEditSesi').html("");

        //Tempelkan Data
        $('#put_id_stok_opename_edit').val(id_stok_opename);
        $('#tanggal_edit').val(tanggal);
        $('#status_edit').val(status);
    });

    //Proses Edit Sesi
    $('#ProsesEditSesi').submit(function(){
        var ProsesEditSesi = $('#ProsesEditSesi').serialize();
        $('#NotifikasiEditSesi').html('Loading...');
        $.ajax({
            type 	    : 'POST',
            url 	    : '_Page/StockOpename/ProsesEditSesi.php',
            data 	    :  ProsesEditSesi,
            success     : function(data){
                $('#NotifikasiEditSesi').html(data);
                var NotifikasiEditSesiBerhasil=$('#NotifikasiEditSesiBerhasil').html();
                if(NotifikasiEditSesiBerhasil=="Success"){
                    //Bersihkan Notifikasi
                    $('#NotifikasiEditSesi').html("");

                    //tutup modal
                    $('#ModalEditSesi').modal('hide');

                    //Reset Form
                    $('#ProsesEditSesi')[0].reset();

                    //Tampilkan Data
                    ShowSesi();

                    //Tampilkan Swal
                    Swal.fire(
                        'Success!',
                        'Edit Sesi Stock Opename Berhasil!',
                        'success'
                    )
                }
            }
        });
    });

    //Modal Hapus Sesi
    $('#ModalHapusSesi').on('show.bs.modal', function (e) {
        var id_stok_opename = $(e.relatedTarget).data('id');
        var tanggal = $(e.relatedTarget).data('tanggal');
        var status = $(e.relatedTarget).data('status');
        if(status===1){
            var label_status='<span class="badge badge-success">Selesai</span>';
        }else{
            var label_status='<span class="badge badge-warning">Dalam Pengerjaan</span>';
        }
        //Kosongkan Notifikasi
        $('#NotifikasiHapusSesi').html("");

        //Tempelkan Data
        $('#put_id_stok_opename_hapus').val(id_stok_opename);
        $('#FormHapusSesi').html(`
            <div class="row mb-3">
                <div class="col-4"><small>Tanggal Sesi</small></div>
                <div class="col-8"><small class="text text-grayish">${tanggal}</small></div>
            </div>
            <div class="row mb-3">
                <div class="col-4"><small>Status Sesi</small></div>
                <div class="col-8"><small class="text text-grayish">${label_status}</small></div>
            </div>
            <div class="row mb-2 mt-2">
                <div class="col-12"><small>Apakah anda yakin akan menghapus data tersebut?</small></div>
            </div>
        `);
        
    });

    //Proses Hapus Sesi
    $('#ProsesHapusSesi').submit(function(){
        var ProsesHapusSesi = $('#ProsesHapusSesi').serialize();
        $('#NotifikasiHapusSesi').html('Loading...');
        $.ajax({
            type 	    : 'POST',
            url 	    : '_Page/StockOpename/ProsesHapusSesi.php',
            data 	    :  ProsesHapusSesi,
            success     : function(data){
                $('#NotifikasiHapusSesi').html(data);
                var NotifikasiHapusSesiBerhasil=$('#NotifikasiHapusSesiBerhasil').html();
                if(NotifikasiHapusSesiBerhasil=="Success"){
                    //Bersihkan Notifikasi
                    $('#NotifikasiHapusSesi').html("");

                    //tutup modal
                    $('#ModalHapusSesi').modal('hide');

                    //Reset Form
                    $('#ProsesHapusSesi')[0].reset();

                    //Tampilkan Data
                    ShowSesi();

                    //Tampilkan Swal
                    Swal.fire(
                        'Success!',
                        'Hapus Sesi Stock Opename Berhasil!',
                        'success'
                    )
                }
            }
        });
    });

    //Tangkap Nilai put_id_stok_opename
    var put_id_stok_opename=$('#put_id_stok_opename').val();
    if(put_id_stok_opename!==""){
        //Tampilkan Detail Sesi
        ShowDetailSesi(put_id_stok_opename);

        //Tempelkan put_id_stok_opename Ke form filter barang
        $('#put_id_stok_opename_filter_barang').val(put_id_stok_opename);

        //Atur Nomor Halaman Pertama Kali
        $('#page_barang').val(1);

        //Tampilkan Data Barang
        ShowBarang();
    }

    //Pagging Barang
    $(document).on('click', '#next_button_barang', function() {
        var page_now_barang = parseInt($('#page_barang').val(), 10); // Pastikan nilai diambil sebagai angka
        var next_page_barang = page_now_barang + 1;
        $('#page_barang').val(next_page_barang);
        ShowBarang();
    });
    $(document).on('click', '#prev_button_barang', function() {
        var page_now_barang = parseInt($('#page_barang').val(), 10); // Pastikan nilai diambil sebagai angka
        var next_page_barang = page_now_barang - 1;
        $('#page_barang').val(next_page_barang);
        ShowBarang();
    });

    //Submit Filter Barang
    $('#ProsesFilterBarang').submit(function(){
        //Kembalikan ke halaman 1
        $('#page_barang').val(1);
        ShowBarang();
        //Tutup Modal
        $('#ModalFilterBarang').modal('hide');
    });

    //Modal Stock Opename
    $('#ModalStockOpename').on('show.bs.modal', function (e) {
        var id_barang = $(e.relatedTarget).data('id');
        var id_stok_opename = $(e.relatedTarget).data('id_sesi');
        var id_stok_opename_barang = $(e.relatedTarget).data('id_so');
        
        //Kosongkan Notifikasi
        $('#NotifikasiStockOpename').html("");

        //Loading
        $('#FormStockOpename').html("Loading...");
        
        //Buka Form
        $.ajax({
            type 	    : 'POST',
            url 	    : '_Page/StockOpename/FormStockOpename.php',
            data 	    :  {id_barang: id_barang, id_stok_opename: id_stok_opename, id_stok_opename_barang: id_stok_opename_barang},
            success     : function(data){
                $('#FormStockOpename').html(data);
            }
        });
    });

    //Proses Simpan Stock Opename
    $('#ProsesStockOpename').submit(function(){
        var ProsesStockOpename = $('#ProsesStockOpename').serialize();
        $('#NotifikasiStockOpename').html('Loading...');
        $.ajax({
            type 	    : 'POST',
            url 	    : '_Page/StockOpename/ProsesStockOpename.php',
            data 	    :  ProsesStockOpename,
            success     : function(data){
                $('#NotifikasiStockOpename').html(data);
                var NotifikasiStockOpenameBerhasil=$('#NotifikasiStockOpenameBerhasil').html();
                if(NotifikasiStockOpenameBerhasil=="Success"){
                    //Bersihkan Notifikasi
                    $('#NotifikasiStockOpename').html("");

                    //tutup modal
                    $('#ModalStockOpename').modal('hide');

                    //Tampilkan Data
                    ShowBarang();

                    //Tampilkan Swal
                    Swal.fire(
                        'Success!',
                        'Atur Stock Opename Berhasil!',
                        'success'
                    )
                }
            }
        });
    });

    //Modal Export Stock Opename
    $('#ModalExportStockOpenameBarang').on('show.bs.modal', function (e) {
        var id_stok_opename = $(e.relatedTarget).data('id');
        //Buka Form
        $.ajax({
            type 	    : 'POST',
            url 	    : '_Page/StockOpename/FormExportStockOpenameBarang.php',
            data 	    :  {id_stok_opename: id_stok_opename},
            success     : function(data){
                $('#FormExportStockOpenameBarang').html(data);
            }
        });
    });

});

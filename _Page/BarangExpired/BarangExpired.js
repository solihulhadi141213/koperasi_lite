//Fungsi Menampilkan Data Barang Expired
function ShowData() {
    var ProsesFilter = $('#ProsesFilter').serialize();
    $('#TabelBarangExpired').html('<tr><td colspan="8" class="text-center">Loading...</td></tr>');
    $.ajax({
        type    : 'POST',
        url     : '_Page/BarangExpired/TabelBarangExpired.php',
        data    : ProsesFilter,
        success: function(data) {
            $('#TabelBarangExpired').html(data);
        }
    });
}
//Fungsi Menampilkan Data Barang
function ShowDataBarang() {
    var ProsesCariBarang = $('#ProsesCariBarang').serialize();
    $.ajax({
        type    : 'POST',
        url     : '_Page/BarangExpired/TabelBarang.php',
        data    : ProsesCariBarang,
        success: function(data) {
            $('#TabelBarang').html(data);
        }
    });
}
$(document).ready(function() {
    //Menampilkan Data Pertama Kali
    ShowData();

    //Ketika Batas Diubah
    $('#batas').change(function(){
        ShowData();
    });
    
    //Ketika keyword By Diubah
    $('#keyword_by').change(function(){
        var keyword_by = $('#keyword_by').val();
        $.ajax({
            type 	    : 'POST',
            url 	    : '_Page/BarangExpired/FormFilterKeyword.php',
            data 	    :  {keyword_by: keyword_by},
            success     : function(data){
                $('#FormFilterKeyword').html(data);
            }
        });
    });

    //Ketika Submit Filter
    $('#ProsesFilter').submit(function(){
        //Kembalikan ke halaman 1
        $('#page_exp').val(1);
        ShowData();
        //Tutup Modal
        $('#ModalFilter').modal('hide');
    });

    //Pagging
    $(document).on('click', '#next_button', function() {
        var page_now_exp = parseInt($('#page_exp').val(), 10); // Pastikan nilai diambil sebagai angka
        var next_page_exp = page_now_exp + 1;
        $('#page_exp').val(next_page_exp);
        ShowData();
    });
    $(document).on('click', '#prev_button', function() {
        var page_now_exp = parseInt($('#page_exp').val(), 10); // Pastikan nilai diambil sebagai angka
        var next_page_exp = page_now_exp - 1;
        $('#page_exp').val(next_page_exp);
        ShowData();
    });

    //Modal Pilih Barang
    $('#ModalPilihBarang').on('show.bs.modal', function (e) {
        ShowDataBarang();
    });

    //Pagging Barang
    $(document).on('click', '#next_button_barang', function() {
        var page_now = parseInt($('#page_barang').val(), 10); // Pastikan nilai diambil sebagai angka
        var next_page = page_now + 1;
        $('#page_barang').val(next_page);
        ShowDataBarang();
    });
    $(document).on('click', '#prev_button_barang', function() {
        var page_now = parseInt($('#page_barang').val(), 10); // Pastikan nilai diambil sebagai angka
        var next_page = page_now - 1;
        $('#page_barang').val(next_page);
        ShowDataBarang();
    });

    //Ketika Submit ProsesCariBarang
    $('#ProsesCariBarang').submit(function(){
        //Kembalikan ke halaman 1
        $('#page_barang').val(1);
        ShowDataBarang();
    });

    //Modal Tambah Barang Expired
    $('#ModalTambahBarangExpired').on('show.bs.modal', function (e) {
        var id_barang = $(e.relatedTarget).data('id');
        $('#FormTambahBarangExpired').html("Loading...");
        $('#NotifikasiTambahBarangExpired').html('');
        $.ajax({
            type 	    : 'POST',
            url 	    : '_Page/BarangExpired/FormTambahBarangExpired.php',
            data        : {id_barang: id_barang},
            success     : function(data){
                $('#FormTambahBarangExpired').html(data);
            }
        });
    });

    //Proses Tambah Barang Expired
    $('#ProsesTambahBarangExpired').submit(function(){
        $('#NotifikasiTambahBarangExpired').html('<div class="spinner-border text-secondary" role="status"><span class="sr-only"></span></div>');
        var form = $('#ProsesTambahBarangExpired')[0];
        var data = new FormData(form);
        $.ajax({
            type 	    : 'POST',
            url 	    : '_Page/BarangExpired/ProsesTambahBarangExpired.php',
            data 	    :  data,
            cache       : false,
            processData : false,
            contentType : false,
            enctype     : 'multipart/form-data',
            success     : function(data){
                $('#NotifikasiTambahBarangExpired').html(data);
                var NotifikasiTambahExpiredDateBerhasil=$('#NotifikasiTambahExpiredDateBerhasil').html();
                if(NotifikasiTambahExpiredDateBerhasil=="Success"){
                    //Kembalikan Ke Halaman 1 
                    $('#ProsesFilter')[0].reset();

                    // Tampilkan swal notifikasi
                    Swal.fire(
                        'Success!',
                        'Tambah Batch & Expired Date Berhasil!',
                        'success'
                    )

                    //Tampilkan Data
                    ShowData();

                    //Tutup Modal
                    $('#ModalTambahBarangExpired').modal('hide');
                }
            }
        });
    });

    //Modal Detail Barang Expired
    $('#ModalDetail').on('show.bs.modal', function (e) {
        var id_barang_bacth = $(e.relatedTarget).data('id');
        $('#FormDetail').html("Loading...");
        $.ajax({
            type 	    : 'POST',
            url 	    : '_Page/BarangExpired/FormDetail.php',
            data        : {id_barang_bacth: id_barang_bacth},
            success     : function(data){
                $('#FormDetail').html(data);
            }
        });
    });
    //Modal Edit Barang Expired
    $('#ModalEdit').on('show.bs.modal', function (e) {
        var id_barang_bacth = $(e.relatedTarget).data('id');
        $('#FormEdit').html("Loading...");
        $.ajax({
            type 	    : 'POST',
            url 	    : '_Page/BarangExpired/FormEditBarangExpired.php',
            data        : {id_barang_bacth: id_barang_bacth},
            success     : function(data){
                $('#FormEdit').html(data);
                //Kosongkan Notifikasi
                $('#NotifikasiEdit').html("");
            }
        });
    });
    
    //Proses Barang Expired
    $('#ProsesEdit').submit(function(){
        $('#NotifikasiEdit').html('<div class="spinner-border text-secondary" role="status"><span class="sr-only"></span></div>');
        var form = $('#ProsesEdit')[0];
        var data = new FormData(form);
        $.ajax({
            type 	    : 'POST',
            url 	    : '_Page/BarangExpired/ProsesEditBarangExpired.php',
            data 	    :  data,
            cache       : false,
            processData : false,
            contentType : false,
            enctype     : 'multipart/form-data',
            success     : function(data){
                $('#NotifikasiEdit').html(data);
                var NotifikasiEditExpiredDateBerhasil=$('#NotifikasiEditExpiredDateBerhasil').html();
                if(NotifikasiEditExpiredDateBerhasil=="Success"){
                    // Tampilkan swal notifikasi
                    Swal.fire(
                        'Success!',
                        'Edit Batch & Expired Date Berhasil!',
                        'success'
                    )

                    //Tampilkan Data
                    ShowData();

                    //Tutup Modal
                    $('#ModalEdit').modal('hide');
                }
            }
        });
    });

    //Hapus Barang Expired
    $('#ModalHapus').on('show.bs.modal', function (e) {
        var id_barang_bacth = $(e.relatedTarget).data('id');
        $('#FormHapus').html("Loading...");
        $.ajax({
            type 	    : 'POST',
            url 	    : '_Page/BarangExpired/FormHapusBarangExpired.php',
            data        : {id_barang_bacth: id_barang_bacth},
            success     : function(data){
                $('#FormHapus').html(data);
            }
        });
    });

    //Proses Hapus
    $('#ProsesHapus').submit(function(){
        $('#NotifikasiHapus').html('<div class="spinner-border text-secondary" role="status"><span class="sr-only"></span></div>');
        var form = $('#ProsesHapus')[0];
        var data = new FormData(form);
        $.ajax({
            type 	    : 'POST',
            url 	    : '_Page/BarangExpired/ProsesHapus.php',
            data 	    :  data,
            cache       : false,
            processData : false,
            contentType : false,
            enctype     : 'multipart/form-data',
            success     : function(data){
                $('#NotifikasiHapus').html(data);
                var NotifikasiHapusBerhasil=$('#NotifikasiHapusBerhasil').html();
                if(NotifikasiHapusBerhasil=="Success"){
                    // Tampilkan swal notifikasi
                    Swal.fire(
                        'Success!',
                        'Hapus Batch & Expired Date Berhasil!',
                        'success'
                    )

                    //Tampilkan Data
                    ShowData();

                    //Tutup Modal
                    $('#ModalHapus').modal('hide');
                }
            }
        });
    });

    //Modal Import
    $('#ModalImport').on('show.bs.modal', function (e) {
        //Bersihkan Notifikasi
        $('#NotifikasiImport').html("");
        
        //Reset Form
        $('#ProsesImport')[0].reset();
    });

    //Proses Import Data batch
    $('#ProsesImport').submit(function(){
        $('#NotifikasiImport').html('<div class="spinner-border text-secondary" role="status"><span class="sr-only"></span></div>');
        var form = $('#ProsesImport')[0];
        var data = new FormData(form);
        $.ajax({
            type 	    : 'POST',
            url 	    : '_Page/BarangExpired/ProsesImport.php',
            data 	    :  data,
            cache       : false,
            processData : false,
            contentType : false,
            enctype     : 'multipart/form-data',
            success     : function(data){
                $('#NotifikasiImport').html(data);
                
                //Kembalikan Ke Halaman 1 
                $('#ProsesFilter')[0].reset();

                //Tampilkan Data
                ShowData();
            }
        });
    });
});







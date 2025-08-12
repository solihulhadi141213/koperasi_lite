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

$(document).ready(function() {

    //Menampilkan Data Pertama Kali
    filterAndLoadTable();

    //Ketika Keyword By Diubah
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

    //Ketika Proses Pencarian
    $('#ProsesFilter').submit(function(){
        $('#page').val("1");
        filterAndLoadTable();
        $('#ModalFilter').modal('hide');
    });

    //PAGGING
    $(document).on('click', '#next_button', function() {
        var page_now = parseInt($('#page').val(), 10); // Pastikan nilai diambil sebagai angka
        var next_page = page_now + 1;
        $('#page').val(next_page);
        filterAndLoadTable();
    });
    $(document).on('click', '#prev_button', function() {
        var page_now = parseInt($('#page').val(), 10); // Pastikan nilai diambil sebagai angka
        var next_page = page_now - 1;
        $('#page').val(next_page);
        filterAndLoadTable();
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

    //Modal Update Pinjaman
    $('#ModalUpdatePinjaman').on('show.bs.modal', function (e) {
        var id_pinjaman = $(e.relatedTarget).data('id');
        $('#FormUpdatePinjaman').html("Loading...");
        $.ajax({
            type: 'POST',
            url: '_Page/Pinjaman/FormUpdatePinjaman.php',
            data: {id_pinjaman: id_pinjaman},
            success: function(data) {
                $('#FormUpdatePinjaman').html(data);
                $('#NotifikasiUpdatePinjaman').html("");
            }
        });
    });

    //Proses Update Pinjaman
    $('#ProsesUpdatePinjaman').submit(function(){
        $('#NotifikasiUpdatePinjaman').html('<div class="spinner-border text-secondary" role="status"><span class="sr-only"></span></div>');
        var form = $('#ProsesUpdatePinjaman')[0];
        var data = new FormData(form);
        $.ajax({
            type 	    : 'POST',
            url 	    : '_Page/Pinjaman/ProsesUpdatePinjaman.php',
            data 	    :  data,
            cache       : false,
            processData : false,
            contentType : false,
            enctype     : 'multipart/form-data',
            success     : function(data){
                $('#NotifikasiUpdatePinjaman').html(data);
                var NotifikasiUpdatePinjamanBerhasil=$('#NotifikasiUpdatePinjamanBerhasil').html();
                if(NotifikasiUpdatePinjamanBerhasil=="Success"){
                    $('#NotifikasiUpdatePinjaman').html('');
                    $('#ModalUpdatePinjaman').modal('hide');
                    Swal.fire(
                        'Success!',
                        'Update Status Pinjaman Berhasil!',
                        'success'
                    )
                    //Menampilkan Data
                    filterAndLoadTable();
                }
            }
        });
    });

    //Modal Hapus Pinjaman
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

});


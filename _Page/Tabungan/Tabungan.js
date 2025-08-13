function filterAndLoadTable() {
    var ProsesFilter = $('#ProsesFilter').serialize();
    $.ajax({
        type: 'POST',
        url: '_Page/Tabungan/TabelSimpanan.php',
        data: ProsesFilter,
        success: function(data) {
            $('#TabelSimpanan').html(data);
        }
    });
}

$(document).ready(function() {
    //Menampilkan Data Pertama Kali
    filterAndLoadTable();

    //keyword_by diubah
    $('#keyword_by').change(function(){
        var keyword_by = $('#keyword_by').val();
        $.ajax({
            type 	    : 'POST',
            url 	    : '_Page/Tabungan/FormFilter.php',
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

    
    //Modal Detail Simpanan
    $('#ModalDetailSimpanan').on('show.bs.modal', function (e) {
        var id_simpanan = $(e.relatedTarget).data('id');
        $('#FormDetailSimpanan').html("Loading...");
        $.ajax({
            type 	    : 'POST',
            url 	    : '_Page/Tabungan/FormDetailSimpanan.php',
            data        : {id_simpanan: id_simpanan},
            success     : function(data){
                $('#FormDetailSimpanan').html(data);
            }
        });
    });

    //Modal Hapus Simpanan
    $('#ModalHapusSimpanan').on('show.bs.modal', function (e) {
        var id_simpanan = $(e.relatedTarget).data('id');
        $('#FormHapusSimpanan').html("Loading...");
        $.ajax({
            type 	    : 'POST',
            url 	    : '_Page/Tabungan/FormHapusSimpanan.php',
            data        : {id_simpanan: id_simpanan},
            success     : function(data){
                $('#FormHapusSimpanan').html(data);
                $('#NotifikasiHapusSimpanan').html('');
            }
        });
    });

    //Proses Hapus Simpanan
    $('#ProsesHapusSimpanan').submit(function(){
        $('#NotifikasiHapusSimpanan').html('<div class="spinner-border text-secondary" role="status"><span class="sr-only"></span></div>');
        var form = $('#ProsesHapusSimpanan')[0];
        var data = new FormData(form);
        $.ajax({
            type 	    : 'POST',
            url 	    : '_Page/Tabungan/ProsesHapusSimpanan.php',
            data 	    :  data,
            cache       : false,
            processData : false,
            contentType : false,
            enctype     : 'multipart/form-data',
            success     : function(data){
                $('#NotifikasiHapusSimpanan').html(data);
                var NotifikasiHapusSimpananBerhasil=$('#NotifikasiHapusSimpananBerhasil').html();
                if(NotifikasiHapusSimpananBerhasil=="Success"){
                    $('#NotifikasiHapusSimpanan').html('');
                    $('#ModalHapusSimpanan').modal('hide');
                    Swal.fire(
                        'Success!',
                        'Hapus Simpanan Anggota Berhasil!',
                        'success'
                    )
                    //Menampilkan Data
                    filterAndLoadTable();
                }
            }
        });
    });
});


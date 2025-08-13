//Fungsi Menampilkan Data
function NotifPenarikan() {
    $.ajax({
        type    : 'POST',
        url     : '_Page/PenarikanSimpanan/NotifikasiPengajuanPenarikan.php',
        success: function(data) {
            $('#NotifikasiPengajuanPenarikan').html(data);
        }
    });
}
function filterAndLoadTable() {
    var ProsesFilter = $('#ProsesFilter').serialize();
    $.ajax({
        type    : 'POST',
        url     : '_Page/PenarikanSimpanan/TabelPenarikanSimpanan.php',
        data    : ProsesFilter,
        success: function(data) {
            $('#TabelPenarikan').html(data);
        }
    });
}


$(document).ready(function() {

    //Menampilkan Notifikasi
    NotifPenarikan();

    //Menampilkan Data
    filterAndLoadTable();
    
    $('#keyword_by').change(function(){
        var keyword_by = $('#keyword_by').val();
        $.ajax({
            type 	    : 'POST',
            url 	    : '_Page/PenarikanSimpanan/FormFilter.php',
            data 	    :  {keyword_by: keyword_by},
            success     : function(data){
                $('#FormFilter').html(data);
            }
        });
    });

    //Submit Pencarian
    $('#ProsesFilter').submit(function(){
        $('#page').val("1");
        filterAndLoadTable();

        //Tutup Modal
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

    //Modal Detail Penarikan
    $('#ModalDetailPenarikan').on('show.bs.modal', function (e) {
        var id_simpanan_penarikan = $(e.relatedTarget).data('id');
        $('#FormDetailPenarikan').html("Loading...");
        $.ajax({
            type 	    : 'POST',
            url 	    : '_Page/PenarikanSimpanan/FormDetailPenarikan.php',
            data        : {id_simpanan_penarikan: id_simpanan_penarikan},
            success     : function(data){
                $('#FormDetailPenarikan').html(data);
            }
        });
    });

    //Modal Update Penarikan
    $('#ModalUpdatePenarikan').on('show.bs.modal', function (e) {
        var id_simpanan_penarikan = $(e.relatedTarget).data('id');
        $('#FormUpdatePenarikan').html("Loading...");
        $.ajax({
            type 	    : 'POST',
            url 	    : '_Page/PenarikanSimpanan/FormUpdatePenarikan.php',
            data        : {id_simpanan_penarikan: id_simpanan_penarikan},
            success     : function(data){
                $('#FormUpdatePenarikan').html(data);
                
                //Notifikasi Form Penarikan
                $('#NotifikasiUpdatePenarikan').html('');
            }
        });
    });

    //Proses Update Penarikan
    $('#ProsesUpdatePenarikan').submit(function(){
        $('#NotifikasiUpdatePenarikan').html('<div class="spinner-border text-secondary" role="status"><span class="sr-only"></span></div>');
        var form = $('#ProsesUpdatePenarikan')[0];
        var data = new FormData(form);
        $.ajax({
            type 	    : 'POST',
            url 	    : '_Page/PenarikanSimpanan/ProsesUpdatePenarikan.php',
            data 	    :  data,
            cache       : false,
            processData : false,
            contentType : false,
            enctype     : 'multipart/form-data',
            success     : function(data){
                $('#NotifikasiUpdatePenarikan').html(data);
                var NotifikasiUpdatePenarikanBerhasil=$('#NotifikasiUpdatePenarikanBerhasil').html();
                if(NotifikasiUpdatePenarikanBerhasil=="Success"){
                    $('#NotifikasiUpdatePenarikan').html('');
                    $('#ModalUpdatePenarikan').modal('hide');
                    Swal.fire(
                        'Success!',
                        'Update Pengajuan Penarikan Dana Berhasil!',
                        'success'
                    )
                    //Menampilkan Data
                    filterAndLoadTable();
                    NotifPenarikan()
                }
            }
        });
    });

    //Modal Hapus Penarikan
    $('#ModalHapusPenarikan').on('show.bs.modal', function (e) {
        var id_simpanan_penarikan = $(e.relatedTarget).data('id');
        $('#FormHapusPenarikan').html("Loading...");
        $.ajax({
            type 	    : 'POST',
            url 	    : '_Page/PenarikanSimpanan/FormHapusPenarikan.php',
            data        : {id_simpanan_penarikan: id_simpanan_penarikan},
            success     : function(data){
                $('#FormHapusPenarikan').html(data);
                
                //Notifikasi Form Penarikan
                $('#NotifikasiHapusPenarikan').html('');
            }
        });
    });

    //Proses hAPUS Penarikan
    $('#ProsesHapusPenarikan').submit(function(){
        $('#NotifikasiHapusPenarikan').html('<div class="spinner-border text-secondary" role="status"><span class="sr-only"></span></div>');
        var form = $('#ProsesHapusPenarikan')[0];
        var data = new FormData(form);
        $.ajax({
            type 	    : 'POST',
            url 	    : '_Page/PenarikanSimpanan/ProsesHapusPenarikan.php',
            data 	    :  data,
            cache       : false,
            processData : false,
            contentType : false,
            enctype     : 'multipart/form-data',
            success     : function(data){
                $('#NotifikasiHapusPenarikan').html(data);
                var NotifikasiHapusPenarikanBerhasil=$('#NotifikasiHapusPenarikanBerhasil').html();
                if(NotifikasiHapusPenarikanBerhasil=="Success"){
                    $('#NotifikasiHapusPenarikan').html('');
                    $('#ModalHapusPenarikan').modal('hide');
                    Swal.fire(
                        'Success!',
                        'hAPUS Pengajuan Penarikan Dana Berhasil!',
                        'success'
                    )
                    //Menampilkan Data
                    filterAndLoadTable();
                    NotifPenarikan()
                }
            }
        });
    });


    // setInterval(NotifPenarikan, 5000);
    setInterval(NotifPenarikan, 5000);
});
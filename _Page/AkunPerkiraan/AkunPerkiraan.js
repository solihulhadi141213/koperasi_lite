function filterAndLoadTable() {
    $.ajax({
        type 	    : 'POST',
        url 	    : '_Page/AkunPerkiraan/TabelAkunPerkiraan.php',
        success     : function(data){
            $('#MenampilkanTabelAkunPerkiraan').html(data);
        }
    });
}
$(document).ready(function() {
    filterAndLoadTable();
});
//Tambah Akun Perkiraan Utama
$('#ProsesTambahAkunPerkiraanUtama').submit(function(){
    $('#NotifikasiTambahAkunPerkiraanUtama').html('<div class="spinner-border text-secondary" role="status"><span class="sr-only"></span></div>');
    var form = $('#ProsesTambahAkunPerkiraanUtama')[0];
    var data = new FormData(form);
    $.ajax({
        type 	    : 'POST',
        url 	    : '_Page/AkunPerkiraan/ProsesTambahAkunPerkiraanUtama.php',
        data 	    :  data,
        cache       : false,
        processData : false,
        contentType : false,
        enctype     : 'multipart/form-data',
        success     : function(data){
            $('#NotifikasiTambahAkunPerkiraanUtama').html(data);
            var NotifikasiTambahAkunPerkiraanUtamaBerhasil=$('#NotifikasiTambahAkunPerkiraanUtamaBerhasil').html();
            if(NotifikasiTambahAkunPerkiraanUtamaBerhasil=="Success"){
                $('#ModalTambahAkunPerkiraan').modal('toggle');
                $("#ProsesTambahAkunPerkiraanUtama")[0].reset();
                Swal.fire(
                    'Success!',
                    'Tambah Akun Perkiraan Berhasil!',
                    'success'
                )
                filterAndLoadTable();
            }
        }
    });
});
//Detail Akun Perkiraan
$('#ModalDetailAkunPerkiraan').on('show.bs.modal', function (e) {
    var id_perkiraan = $(e.relatedTarget).data('id');
    $('#FormDetailAkunPerkiraan').html("Loading...");
    $.ajax({
        type 	    : 'POST',
        url 	    : '_Page/AkunPerkiraan/FormDetailAkunPerkiraan.php',
        data        : {id_perkiraan: id_perkiraan},
        success     : function(data){
            $('#FormDetailAkunPerkiraan').html(data);
        }
    });
});
//Tambah Akun Perkiraan Untuk Anak
$('#ModalTambahAkunPerkiraanAnak').on('show.bs.modal', function (e) {
    var id_perkiraan = $(e.relatedTarget).data('id');
    $('#FormTambahAkunPerkiraanAnak').html("Loading...");
    $.ajax({
        type 	    : 'POST',
        url 	    : '_Page/AkunPerkiraan/FormTambahAkunPerkiraanAnak.php',
        data        : {id_perkiraan: id_perkiraan},
        success     : function(data){
            $('#FormTambahAkunPerkiraanAnak').html(data);
        }
    });
});
//Tambah Akun Perkiraan Anak
$('#ProsesTambahAkunPerkiraanAnak').submit(function(){
    $('#NotifikasiTambahAkunPerkiraanAnak').html('<div class="spinner-border text-secondary" role="status"><span class="sr-only"></span></div>');
    var form = $('#ProsesTambahAkunPerkiraanAnak')[0];
    var data = new FormData(form);
    $.ajax({
        type 	    : 'POST',
        url 	    : '_Page/AkunPerkiraan/ProsesTambahAkunPerkiraanAnak.php',
        data 	    :  data,
        cache       : false,
        processData : false,
        contentType : false,
        enctype     : 'multipart/form-data',
        success     : function(data){
            $('#NotifikasiTambahAkunPerkiraanAnak').html(data);
            var NotifikasiTambahAkunPerkiraanAnakBerhasil=$('#NotifikasiTambahAkunPerkiraanAnakBerhasil').html();
            if(NotifikasiTambahAkunPerkiraanAnakBerhasil=="Success"){
                $('#ModalTambahAkunPerkiraanAnak').modal('toggle');
                $("#ProsesTambahAkunPerkiraanAnak")[0].reset();
                $('#NotifikasiTambahAkunPerkiraanAnak').html("");
                Swal.fire(
                    'Success!',
                    'Tambah Akun Perkiraan Berhasil!',
                    'success'
                )
                filterAndLoadTable();
            }
        }
    });
});
//Edit Akun Perkiraan
$('#ModalEditAkun').on('show.bs.modal', function (e) {
    var id_perkiraan = $(e.relatedTarget).data('id');
    $('#FormEditAkun').html("Loading...");
    $.ajax({
        type 	    : 'POST',
        url 	    : '_Page/AkunPerkiraan/FormEditAkun.php',
        data        : {id_perkiraan: id_perkiraan},
        success     : function(data){
            $('#FormEditAkun').html(data);
            $('#NotifikasiEditAkun').html("");
        }
    });
});
//Tambah Akun Perkiraan Anak
$('#ProsesEditAkun').submit(function(){
    $('#NotifikasiEditAkun').html('<div class="spinner-border text-secondary" role="status"><span class="sr-only"></span></div>');
    var form = $('#ProsesEditAkun')[0];
    var data = new FormData(form);
    $.ajax({
        type 	    : 'POST',
        url 	    : '_Page/AkunPerkiraan/ProsesEditAkun.php',
        data 	    :  data,
        cache       : false,
        processData : false,
        contentType : false,
        enctype     : 'multipart/form-data',
        success     : function(data){
            $('#NotifikasiEditAkun').html(data);
            var NotifikasiEditAkunBerhasil=$('#NotifikasiEditAkunBerhasil').html();
            if(NotifikasiEditAkunBerhasil=="Success"){
                $('#ModalEditAkun').modal('toggle');
                $("#ProsesEditAkun")[0].reset();
                $('#NotifikasiEditAkun').html("");
                Swal.fire(
                    'Success!',
                    'Edit Akun Perkiraan Berhasil!',
                    'success'
                )
                filterAndLoadTable();
            }
        }
    });
});
//Hapus Akun Perkiraan
$('#ModalHapusAkun').on('show.bs.modal', function (e) {
    var id_perkiraan = $(e.relatedTarget).data('id');
    $('#FormHapusAkun').html("Loading...");
    $.ajax({
        type 	    : 'POST',
        url 	    : '_Page/AkunPerkiraan/FormHapusAkun.php',
        data        : {id_perkiraan: id_perkiraan},
        success     : function(data){
            $('#FormHapusAkun').html(data);
            $('#NotifikasiHapusAkun').html("");
        }
    });
});
//Tambah Akun Perkiraan Anak
$('#ProsesHapusAkun').submit(function(){
    $('#NotifikasiHapusAkun').html('<div class="spinner-border text-secondary" role="status"><span class="sr-only"></span></div>');
    var form = $('#ProsesHapusAkun')[0];
    var data = new FormData(form);
    $.ajax({
        type 	    : 'POST',
        url 	    : '_Page/AkunPerkiraan/ProsesHapusAkun.php',
        data 	    :  data,
        cache       : false,
        processData : false,
        contentType : false,
        enctype     : 'multipart/form-data',
        success     : function(data){
            $('#NotifikasiHapusAkun').html(data);
            var NotifikasiHapusAkunBerhasil=$('#NotifikasiHapusAkunBerhasil').html();
            if(NotifikasiHapusAkunBerhasil=="Success"){
                $('#ModalHapusAkun').modal('toggle');
                $("#ProsesHapusAkun")[0].reset();
                $('#NotifikasiHapusAkun').html("");
                Swal.fire(
                    'Success!',
                    'Hapus Akun Perkiraan Berhasil!',
                    'success'
                )
                filterAndLoadTable();
            }
        }
    });
});
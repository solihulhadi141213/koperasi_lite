//Fungsi Menampilkan Data
function ShowAngsuran() {
   //Tangkap id_pinjaman
    var id_pinjaman = $('#get_id_pinjaman').val();

    //Buka Data Dengan Ajax
    $.ajax({
        type 	    : 'POST',
        url 	    : '_Page/AngsuranAnggota/TabelPinjamanAnggota.php',
        data        : {id_pinjaman: id_pinjaman},
        success     : function(data){
            $('#TabelPinjamanAnggota').html(data);
        }
    });
}

//Fungsi Menampilkan Detail Pembayaran
function ShowDetailPembayaran(kode_pembayaran) {
   
    //Tampilkan Loading
    $('#FormDetailPembayaran').html('<div class="row"><div class="col-md-12 text-center">Loading...</div></div>');

    //Buka Data Dengan Ajax
    $.ajax({
        type 	    : 'POST',
        url 	    : '_Page/AngsuranAnggota/FormDetailPembayaran.php',
        data        : {kode_pembayaran: kode_pembayaran},
        success     : function(data){
            $('#FormDetailPembayaran').html(data);
        }
    });
}
//Inisiasi Data Pertama Kali
$(document).ready(function() {
    ShowAngsuran();

    //Modal Form Pembayaran Angsuran
    $('#ModalBayarAngsuran').on('show.bs.modal', function (e) {
        var id_pinjaman_angsuran= $(e.relatedTarget).data('id');
        
        $('#FormBayarAngsuran').html("Loading...");
        $('#PetunjukBayarAngsuran').html("");
        $('#NotifikasiBayarAngsuran').html("");
        $.ajax({
            type 	    : 'POST',
            url 	    : '_Page/AngsuranAnggota/FormBayarAngsuran.php',
            data        : {id_pinjaman_angsuran: id_pinjaman_angsuran},
            success     : function(data){
                $('#FormBayarAngsuran').html(data);
            }
        });
    });

    //Proses Pembayaran
    $('#ProsesBayarAngsuran').submit(function(){
        $('#NotifikasiBayarAngsuran').html('<div class="spinner-border text-secondary" role="status"><span class="sr-only"></span></div>');
        var form = $('#ProsesBayarAngsuran')[0];
        var data = new FormData(form);
        $.ajax({
            type 	    : 'POST',
            url 	    : '_Page/AngsuranAnggota/ProsesBayarAngsuran.php',
            data 	    :  data,
            cache       : false,
            processData : false,
            contentType : false,
            enctype     : 'multipart/form-data',
            success     : function(data){
                $('#NotifikasiBayarAngsuran').html(data);
                var NotifikasiBayarAngsuranBerhasil=$('#NotifikasiBayarAngsuranBerhasil').html();
                var kode_pembayaran=$('#get_kode_pembayaran').html();
                
                if(NotifikasiBayarAngsuranBerhasil=="Success"){
                    if(kode_pembayaran==""){

                    }else{
                        //Jika Proses Berhasil Tampilkan Detail Pembayaran
                        $('#ModalBayarAngsuran').modal('hide');
                        ShowDetailPembayaran(kode_pembayaran);
                        $('#ModalDetailPembayaran').modal('show');

                        //reload data
                        ShowAngsuran();
                    }
                    
                }
            }
        });
    });

    //Modal Detail Pembayaran
    $(document).on('click', '.show_detail_pembayaran', function(e) {
        // Mencegah perilaku default jika diperlukan
        e.preventDefault();
        
        // Mendapatkan kode_pembayaran dari atribut data tombol yang diklik
        var kode_pembayaran = $(this).data('id');
        
        // Panggil fungsi untuk menampilkan detail
        ShowDetailPembayaran(kode_pembayaran);
        
        // Tampilkan modal
        $('#ModalDetailPembayaran').modal('show');
    });

    //Modal Pembatalan Pembayaran
    $('#ModalPembatalanPembayaran').on('show.bs.modal', function (e) {
        var kode_pembayaran= $(e.relatedTarget).data('id');
        $('#FormPembatalanPembayaran').html("Loading...");
        $.ajax({
            type 	    : 'POST',
            url 	    : '_Page/AngsuranAnggota/FormPembatalanPembayaran.php',
            data        : {kode_pembayaran: kode_pembayaran},
            success     : function(data){
                $('#FormPembatalanPembayaran').html(data);
                $('#NotifikasiPembatalanPembayaran').html("");
            }
        });
    });

    //Proses Pembatalan Pembayaran
    $('#ProsesPembatalanPembayaran').submit(function(){
        $('#NotifikasiPembatalanPembayaran').html('<div class="spinner-border text-secondary" role="status"><span class="sr-only"></span></div>');
        var form = $('#ProsesPembatalanPembayaran')[0];
        var data = new FormData(form);
        $.ajax({
            type 	    : 'POST',
            url 	    : '_Page/AngsuranAnggota/ProsesPembatalanPembayaran.php',
            data 	    :  data,
            cache       : false,
            processData : false,
            contentType : false,
            enctype     : 'multipart/form-data',
            success     : function(data){
                $('#NotifikasiPembatalanPembayaran').html(data);
                var NotifikasiPembatalanPembayaranBerhasil=$('#NotifikasiPembatalanPembayaranBerhasil').html();
                if(NotifikasiPembatalanPembayaranBerhasil=="Success"){
                    $('#NotifikasiPembatalanPembayaran').html('');
                    $('#ModalPembatalanPembayaran').modal('hide');
                    Swal.fire(
                        'Success!',
                        'Pembatalan Pembayaran Berhasil!',
                        'success'
                    )
                    //Menampilkan Data
                    ShowAngsuran();
                }
            }
        });
    });
});
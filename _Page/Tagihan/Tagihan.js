function filterAndLoadTable() {
    var ProsesFilter = $('#ProsesFilter').serialize();
    $.ajax({
        type: 'POST',
        url: '_Page/Tagihan/TabelTagihan.php',
        data: ProsesFilter,
        success: function(data) {
            $('#MenampilkanTabelTagihan').html(data);
        }
    });
}
$(document).ready(function() {
    filterAndLoadTable();
});
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
$('#ProsesFilter').submit(function(){
    $('#page').val("1");
    filterAndLoadTable();
    $('#ModalFilter').modal('hide');
});
//Ketika Modal Export Tagihan Muncul
$('#ModalExportTagihan').on('show.bs.modal', function (e) {
    $('#FormExportTagihan').html("Loading...");
    $.ajax({
        type 	    : 'POST',
        url 	    : '_Page/Tagihan/FormExportTagihan.php',
        success     : function(data){
            $('#FormExportTagihan').html(data);
        }
    });
});
//Detail Pinjaman
$('#ModalDetailPinjaman').on('show.bs.modal', function (e) {
    var id_pinjaman= $(e.relatedTarget).data('id');
    $('#FormDetailPinjaman').html("Loading...");
    $.ajax({
        type 	    : 'POST',
        url 	    : '_Page/Tagihan/FormDetailPinjaman.php',
        data        : {id_pinjaman: id_pinjaman},
        success     : function(data){
            $('#FormDetailPinjaman').html(data);
        }
    });
});

//Modal Bayar Tagihan Angsuran
$('#ModalBayarTagihanAngsuran').on('show.bs.modal', function (e) {
    $('#FormBayarTagihanAngsuran').html("Loading...");
    $.ajax({
        type 	    : 'POST',
        url 	    : '_Page/Tagihan/TabelChecklistTagihan.php',
        success     : function(data){
            $('#FormBayarTagihanAngsuran').html(data);
            //Kosongkan Notifikasi
            $('#NotifikasiBayarTagihanAngsuran').html("");
        }
    });
});

//Proses Bayar Tagihan Angsuran
$("#ProssesBayarTagihanAngsuran").on("submit", function (e) {
    e.preventDefault();
    // Tombol loading
    let $FormElement = $("#ProssesBayarTagihanAngsuran");
    let $ModalElement = $("#ModalBayarTagihanAngsuran");
    let $Notifikasi = $("#NotifikasiBayarTagihanAngsuran");
    let $ButtonProses = $("#ButtonBayarTagihanAngsuran");
    let ButtonElement = '<i class="bi bi-save"></i> Simpan Pembayaran';
    $ButtonProses.html('Loading..');
    $ButtonProses.prop("disabled", true);

    // Ambil data form
    let formData = new FormData(this);

    // Kirim data ke server
    $.ajax({
        url         : "_Page/Tagihan/ProssesBayarTagihanAngsuran.php",
        type        : "POST",
        data        : formData,
        contentType : false,
        processData : false,
        dataType    : "json",
        success: function (response) {
            //Apabila Proses Berhasil
            if (response.status === "Success") {

                //Reset Filter
                $('#page').val("1");

                //Tampilkan Ulang Data
                filterAndLoadTable();

                // Tampilkan swal notifikasi
                Swal.fire(
                    'Success!',
                    'Pembayaran Tagihan Angsuran Berhasil!',
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
                var error_notification = response.error_notification;

                if (Array.isArray(error_notification) && error_notification.length > 0) {
                    var errorList = "<ul>";
                    error_notification.forEach(function (error) {
                        errorList += `<li>
                            <strong>ID Pinjaman:</strong> ${error.id_pinjaman} | 
                            <strong>ID Anggota:</strong> ${error.id_anggota} | 
                            <strong>Tanggal Bayar:</strong> ${error.tanggal_bayar} | 
                            <strong>Denda:</strong> ${error.denda} | 
                            <strong>Total Angsuran:</strong> ${error.angsuran_total}
                        </li>`;
                    });
                    errorList += "</ul>";
                
                    $Notifikasi.html(
                        `<div class="alert alert-danger" role="alert">
                            <strong>${response.message}</strong>${errorList}
                        </div>`
                    );
                } else {
                    $Notifikasi.html(
                        `<div class="alert alert-danger" role="alert">
                            <strong>${response.message}</strong>
                        </div>`
                    );
                }
                

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
function formatTanggalIndo(tanggal) {
    var bulanIndo = [
        "Januari", "Februari", "Maret", "April", "Mei", "Juni",
        "Juli", "Agustus", "September", "Oktober", "November", "Desember"
    ];

    var parts = tanggal.split('-');
    if (parts.length !== 3) return "Format tidak valid";

    var tahun = parts[0];
    var bulan = parseInt(parts[1], 10) - 1; // Bulan dalam array dimulai dari 0
    var hari = parts[2];

    return hari + " " + bulanIndo[bulan] + " " + tahun;
}

//Fungsi Untuk Menampilkan Data Anggota
function ShowData() {
    
    // Tangkap Periode Data
    var periode = $('#periode').val();
    var tanggalFormat = formatTanggalIndo(periode);
    //Tempelkan Ke Header Card
    $('#put_periode_data').html(''+tanggalFormat+'');

    //Tempelkan ke hidden form
    $('#put_periode').val(periode);

    //Tangkap Data Dari Form
    var ProsesFilter = $('#ProsesFilter').serialize();
    $.ajax({
        type    : 'POST',
        url     : '_Page/PotonganAnggota/TabelPotonganAnggota.php',
        data    : ProsesFilter,
        success: function(data) {
            $('#TabelPotonganAnggota').html(data);
        }
    });
}

$(document).ready(function() {

    //Menampilkan Data Pertama kali
    ShowData();
    
    //Ketika Submit Filter
    $('#ProsesFilter').submit(function(){
        //Kembalikan ke halaman 1
        $('#page').val(1);

        //Tampilkan Data
        ShowData();

        //Tutup Modal
        $('#ModalFilter').modal('hide');
    });

    //PAGGING
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

    //Modal Detail Potongan
    $('#ModalDetailPotongan').on('show.bs.modal', function (e) {
        var id_anggota= $(e.relatedTarget).data('id');
        var periode= $(e.relatedTarget).data('periode');

        //Loading
        $('#FormDetailPotongan').html('Loading...');

        //Tampikan Dalam Ajax
        $.ajax({
            type 	    : 'POST',
            url 	    : '_Page/PotonganAnggota/FormDetailPotongan.php',
            data 	    :  {
                id_anggota  : id_anggota, 
                periode     : periode
            },
            success     : function(data){
                $('#FormDetailPotongan').html(data);
                $('#NotifikasiCetak').html("");
            }
        });
    });
    $('#ProsesCetakDetailPotongan').submit(function(event) {
        event.preventDefault(); // Mencegah reload halaman
        
        var formatCetak = $('#tipe_cetak').val(); // Ambil format yang dipilih
        var content = document.getElementById("FormDetailPotongan"); // Ambil elemen yang ingin dicetak

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
                    doc.save("Potongan_Anggota.pdf");

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
                    link.download = "Potongan_Anggota.png";
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

    //Ketika 'ProsesDetailMulti' disubmit maka sistem akan menampilkan modal
    $('#ProsesDetailMulti').submit(function(event) {
        $('#ModalDetailPotonganMulti').modal('show');

        //Tangkap Data Dari Tabel
        var ProsesDetailMulti=$('#ProsesDetailMulti').serialize();
        //Tampikan Dalam Ajax
        $.ajax({
            type 	    : 'POST',
            url 	    : '_Page/PotonganAnggota/FormDetailPotonganMulti.php',
            data 	    :  ProsesDetailMulti,
            success     : function(data){
                $('#FormDetailPotonganMulti').html(data);
                $('#NotifikasiCetakMulti').html("");
            }
        });
    });

    $('#ProsesCetakDetailPotonganMulti').submit(function(event) {
        event.preventDefault(); // Mencegah reload halaman
        
        var formatCetak = $('#tipe_cetak_multi').val(); // Ambil format yang dipilih
        var content = document.getElementById("FormDetailPotonganMulti"); // Ambil elemen yang ingin dicetak

        if (!formatCetak) {
            $('#NotifikasiCetakMulti').html('<div class="alert alert-danger">Silakan pilih format cetak!</div>');
            return;
        }

        // Tampilkan loading
        $('#NotifikasiCetakMulti').html('<div class="alert alert-info">Sedang memproses cetak...</div>');
        $('#ButtonCetakMulti').prop('disabled', true).html('<i class="bi bi-hourglass-split"></i> Memproses...');

        setTimeout(() => {
            if (formatCetak === "PDF") {
                html2canvas(content, { scale: 2 }).then(canvas => {
                    var imgData = canvas.toDataURL("image/png");
                    var { jsPDF } = window.jspdf;
                    var doc = new jsPDF("p", "mm", "a4");
                    var imgWidth = 190;
                    var imgHeight = (canvas.height * imgWidth) / canvas.width;

                    doc.addImage(imgData, "PNG", 10, 10, imgWidth, imgHeight);
                    doc.save("Potongan_Anggota.pdf");

                    $('#NotifikasiCetakMulti').html('<div class="alert alert-success">Download PDF berhasil!</div>');
                    resetButton2();
                }).catch(error => {
                    $('#NotifikasiCetakMulti').html('<div class="alert alert-danger">Gagal mencetak PDF!</div>');
                    resetButton2();
                });
            } else if (formatCetak === "Image") {
                html2canvas(content, { scale: 2 }).then(canvas => {
                    var imgData = canvas.toDataURL("image/png");
                    var link = document.createElement("a");
                    link.href = imgData;
                    link.download = "Potongan_Anggota.png";
                    link.click();

                    $('#NotifikasiCetakMulti').html('<div class="alert alert-success">Download gambar berhasil!</div>');
                    resetButton2();
                }).catch(error => {
                    $('#NotifikasiCetakMulti').html('<div class="alert alert-danger">Gagal mencetak gambar!</div>');
                    resetButton2();
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
                    $('#NotifikasiCetakMulti').html('<div class="alert alert-success">Pencetakan berhasil!</div>');
                    resetButton2();
                }, 1000);
            }
        }, 1000);
    });

    function resetButton2() {
        $('#ButtonCetakMulti').prop('disabled', false).html('<i class="bi bi-printer"></i> Cetak');
    }

    //Modal Detail Potongan
    $('#ModalDownload').on('show.bs.modal', function (e) {
        var periode= $('#periode').val();

        //Loading
        $('#FormDownload').html('Loading...');

        //Tampikan Dalam Ajax
        $.ajax({
            type 	    : 'POST',
            url 	    : '_Page/PotonganAnggota/FormDownload.php',
            data 	    :  {
                periode     : periode
            },
            success     : function(data){
                $('#FormDownload').html(data);
                $('#NotifikasiDownload').html("");
            }
        });
    });
});
$('#ProsesLaporanAnggota').submit(function(){
    var ProsesLaporanAnggota = $('#ProsesLaporanAnggota').serialize();
    $.ajax({
        type    : 'POST',
        url     : '_Page/Laporan/TabelLaporanAnggota.php',
        data    : ProsesLaporanAnggota,
        success: function(data) {
            $('#TabelLaporanAnggota').html(data);
        }
    });
});

$('#CetakLaporanAnggota').click(function(e) {
    e.preventDefault();
    
    // Validasi form
    var periode1 = $('input[name="periode_1"]').val();
    var periode2 = $('input[name="periode_2"]').val();
    
    if(!periode1) {
        alert('Periode awal harus diisi');
        $('input[name="periode_1"]').focus();
        return false;
    }
    
    if(!periode2) {
        alert('Periode akhir harus diisi');
        $('input[name="periode_2"]').focus();
        return false;
    }
    
    // Konversi ke Date object untuk validasi
    var date1 = new Date(periode1);
    var date2 = new Date(periode2);
    
    if(date1 > date2) {
        alert('Periode awal tidak boleh lebih besar dari periode akhir');
        return false;
    }
    
    // Serialize form data
    var formData = $('#ProsesLaporanAnggota').serialize();
    
    // URL tujuan cetak
    var printUrl = '_Page/Laporan/CetakLaporanAnggota.php?' + formData;
    
    // Buka di tab baru
    var printWindow = window.open(printUrl, '_blank');
    
    // Focus ke window baru (opsional)
    if(printWindow) {
        printWindow.focus();
    } else {
        alert('Popup blocker mungkin mencegah pembukaan jendela cetak. Silahkan izinkan popup untuk situs ini.');
    }
});

$('#ProsesLaporanSimpanan').submit(function(){
    var ProsesLaporanSimpanan = $('#ProsesLaporanSimpanan').serialize();
    $.ajax({
        type    : 'POST',
        url     : '_Page/Laporan/TabelLaporanSimpanan.php',
        data    : ProsesLaporanSimpanan,
        success: function(data) {
            $('#TabelLaporanSimpanan').html(data);
        }
    });
});

$('#CetakLaporanSimpanan').click(function(e) {
    e.preventDefault();
    
    // Validasi form
    var periode1 = $('input[name="periode_1"]').val();
    var periode2 = $('input[name="periode_2"]').val();
    
    if(!periode1) {
        alert('Periode awal harus diisi');
        $('input[name="periode_1"]').focus();
        return false;
    }
    
    if(!periode2) {
        alert('Periode akhir harus diisi');
        $('input[name="periode_2"]').focus();
        return false;
    }
    
    // Konversi ke Date object untuk validasi
    var date1 = new Date(periode1);
    var date2 = new Date(periode2);
    
    if(date1 > date2) {
        alert('Periode awal tidak boleh lebih besar dari periode akhir');
        return false;
    }
    
    // Serialize form data
    var formData = $('#ProsesLaporanSimpanan').serialize();
    
    // URL tujuan cetak
    var printUrl = '_Page/Laporan/CetakLaporanSimpanan.php?' + formData;
    
    // Buka di tab baru
    var printWindow = window.open(printUrl, '_blank');
    
    // Focus ke window baru (opsional)
    if(printWindow) {
        printWindow.focus();
    } else {
        alert('Popup blocker mungkin mencegah pembukaan jendela cetak. Silahkan izinkan popup untuk situs ini.');
    }
});
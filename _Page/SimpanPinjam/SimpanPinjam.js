function hanyaAngka(evt) {
    var charCode = (evt.which) ? evt.which : evt.keyCode;
    // Memastikan bahwa hanya angka yang bisa dimasukkan (charCode 48-57 adalah angka 0-9)
    if (charCode > 31 && (charCode < 48 || charCode > 57)) {
        return false;
    }
    return true;
}
function PeriodeChange() {
    var periode=$('#periode_form').val();
    if(periode=="Tahun"){
        //Apabila Periode Tahun
        $('#bulan').val("");
        $('#tahun').prop('disabled', false);
        $('#bulan').prop('disabled', true);
    }else{
        if(periode=="Bulan"){
            //Apabila Periode Tahun
            $('#bulan').val("");
            $('#tahun').prop('disabled', false);
            $('#bulan').prop('disabled', false);
        }else{
            //Apabila Periode Tahun
            $('#bulan').val("");
            $('#tahun').prop('disabled', true);
            $('#bulan').prop('disabled', true);
        }
    }
}

//Inisiasi Periode Pertama Kali
PeriodeChange();

//Ketika Periode Diubah
$('#periode_form').change(function(){
    PeriodeChange();
});

//Proses Tampilkan Data
$('#ProsesSimpanPinjam').submit(function(){
    var ProsesSimpanPinjam = $('#ProsesSimpanPinjam').serialize();
    $('#MenampilkanTabelSimpanPinjam').html('Loading...');
    $.ajax({
        type 	    : 'POST',
        url 	    : '_Page/SimpanPinjam/TabelSimpanPinjam.php',
        data 	    :  ProsesSimpanPinjam,
        success     : function(data){
            $('#MenampilkanTabelSimpanPinjam').html(data);
        }
    });
});
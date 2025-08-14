//Fungsi Untuk Format Rupiah
function formatRupiah(angka) {
    return 'Rp ' + parseFloat(angka).toLocaleString('id-ID', { minimumFractionDigits: 0 });
}

// Fungsi untuk memproses input pada elemen dengan class form-money
function processInput(event) {
    let input = event.target;
    let originalValue = input.value;

    // Hilangkan titik dari nilai asli untuk penghitungan
    let rawValue = originalValue.replace(/\./g, "");

    // Format nilai input
    let formattedValue = formatMoney(rawValue);

    // Update nilai input dengan nilai yang telah diformat
    input.value = formattedValue;
}

// Fungsi untuk memformat angka menjadi format ribuan
function formatMoney(value) {
    if (!value) return ""; // Jika kosong, kembalikan string kosong
    // Hilangkan karakter selain angka
    value = value.toString().replace(/[^0-9]/g, "");
    // Tambahkan pemisah ribuan (titik)
    return value.replace(/\B(?=(\d{3})+(?!\d))/g, ".");
}

// Fungsi untuk menginisialisasi elemen form-money
function initializeMoneyInputs() {
    const moneyInputs = document.querySelectorAll(".form-money");
    moneyInputs.forEach(function (input) {
        // Format nilai awal jika sudah ada
        input.value = formatMoney(input.value);

        // Pastikan input diformat dengan benar
        input.removeEventListener("input", processInput); // Menghapus event listener sebelumnya
        input.addEventListener("input", processInput);
    });
}

$(document).ready(function() {
    initializeMoneyInputs();
    
    //ModalPenarikanDana
    $('#ModalPenarikanDana').on('show.bs.modal', function (e) {
        var id_simpanan_jenis = $(e.relatedTarget).data('id');
        $('#FormPenarikanDana').html("Loading...");
        $.ajax({
            type 	    : 'POST',
            url 	    : '_Page/PenarikanAnggota/FormPenarikanDana.php',
            data        : {id_simpanan_jenis: id_simpanan_jenis},
            success     : function(data){
                $('#FormPenarikanDana').html(data);
            }
        });
    });

    //Proses Kirim Pengajuan Penarikan
    $('#ProsesPenarikanDana').submit(function(){
        $('#NotifikasiPenarikanDana').html('<div class="spinner-border text-secondary" role="status"><span class="sr-only"></span></div>');
        var form = $('#ProsesPenarikanDana')[0];
        var data = new FormData(form);
        $.ajax({
            type 	    : 'POST',
            url 	    : '_Page/PenarikanAnggota/ProsesPenarikanDana.php',
            data 	    :  data,
            cache       : false,
            processData : false,
            contentType : false,
            enctype     : 'multipart/form-data',
            success     : function(data){
                $('#NotifikasiPenarikanDana').html(data);
                var NotifikasiPenarikanDanaBerhasil=$('#NotifikasiPenarikanDanaBerhasil').html();
                if(NotifikasiPenarikanDanaBerhasil=="Success"){
                    window.location.href = 'index.php?Page=PenarikanAnggota';
                }
            }
        });
    });

    //Modal Detail Penarikan Dana
    $('#ModalDetailPenarikan').on('show.bs.modal', function (e) {
        var id_simpanan_penarikan = $(e.relatedTarget).data('id');
        $('#FormDetailPenarikan').html("Loading...");
        $.ajax({
            type 	    : 'POST',
            url 	    : '_Page/PenarikanAnggota/FormDetailPenarikan.php',
            data        : {id_simpanan_penarikan: id_simpanan_penarikan},
            success     : function(data){
                $('#FormDetailPenarikan').html(data);
            }
        });
    });
});


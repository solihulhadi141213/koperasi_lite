function filterAndLoadTable() {
    var ProsesFilter = $('#ProsesFilter').serialize();
    $.ajax({
        type: 'POST',
        url: '_Page/Tabungan/TabelTabungan.php',
        data: ProsesFilter,
        success: function(data) {
            $('#MenampilkanTabelTabungan').html(data);
        }
    });
}
function showListAnggota() {
    var ProsesCariAnggota = $('#ProsesCariAnggota').serialize();
    $('#MenampilkanListAnggota').html('Loading...');
    $.ajax({
        type 	    : 'POST',
        url 	    : '_Page/Tabungan/ListAnggota.php',
        data 	    :  ProsesCariAnggota,
        success     : function(data){
            $('#MenampilkanListAnggota').html(data);
        }
    });
}
function ShowDetailSimpanan() {
    var id_simpanan = $('#GetIdSimpanan').val();
    $.ajax({
        type: 'POST',
        url: '_Page/Tabungan/MenampilkanDetailSimpanan.php',
        data: {id_simpanan: id_simpanan},
        success: function(data) {
            $('#MenampilkanDetailSimpanan').html(data);
        }
    });
}
function ShowJurnalSimpanan() {
    var id_simpanan = $('#GetIdSimpanan').val();
    $.ajax({
        type: 'POST',
        url: '_Page/Tabungan/MenampilkanJurnalSimpanan.php',
        data: {id_simpanan: id_simpanan},
        success: function(data) {
            $('#MenampilkanJurnalSimpanan').html(data);
        }
    });
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
    filterAndLoadTable();
    ShowDetailSimpanan();
    ShowJurnalSimpanan();
});
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
$('#ProsesFilter').submit(function(){
    $('#page').val("1");
    filterAndLoadTable();
    $('#ModalFilter').modal('hide');
});
//Menampilkan Data Anggota
$('#ModalPilihAnggota').on('show.bs.modal', function (e) {
    showListAnggota();
});
$('#ProsesCariAnggota').submit(function(){
    showListAnggota();
});
//Modal Tambah Simpanan
$('#ModalTambahSimpanan').on('show.bs.modal', function (e) {
    var id_anggota = $(e.relatedTarget).data('id');
    $('#FormTambahSimpanan').html("Loading...");
    $('#NotifikkasiTambahSimpanan').html("");
    $.ajax({
        type 	    : 'POST',
        url 	    : '_Page/Tabungan/FormTambahSimpanan.php',
        data        : {id_anggota: id_anggota},
        success     : function(data){
            $('#FormTambahSimpanan').html(data);
            initializeMoneyInputs();

            //Cek kategori_simpanan_penarikan Pertama Kali
            var id_anggota = $('#put_id_anggota_for_tambah_simpanan').val();
            var kategori_simpanan_penarikan = $('#kategori_simpanan_penarikan').val();
            $.ajax({
                type 	    : 'POST',
                url 	    : '_Page/Tabungan/FormJenisSimpanan.php',
                data        : {id_anggota: id_anggota, kategori_simpanan_penarikan: kategori_simpanan_penarikan},
                success     : function(data){
                    $('#FormJenisSimpanan').html(data);
                }
            });

            //Ketika kategori_simpanan_penarikan change
            $('#kategori_simpanan_penarikan').change(function(){
                var id_anggota = $('#put_id_anggota_for_tambah_simpanan').val();
                var kategori_simpanan_penarikan = $('#kategori_simpanan_penarikan').val();
                $.ajax({
                    type 	    : 'POST',
                    url 	    : '_Page/Tabungan/FormJenisSimpanan.php',
                    data        : {id_anggota: id_anggota, kategori_simpanan_penarikan: kategori_simpanan_penarikan},
                    success     : function(data){
                        $('#FormJenisSimpanan').html(data);
                    }
                });
            });
        }
    });
});
//Proses Tambah Simpanan
$('#ProsesTambahSimpanan').submit(function(){
    $('#NotifikkasiTambahSimpanan').html('<div class="spinner-border text-secondary" role="status"><span class="sr-only"></span></div>');
    var form = $('#ProsesTambahSimpanan')[0];
    var data = new FormData(form);
    $.ajax({
        type 	    : 'POST',
        url 	    : '_Page/Tabungan/ProsesTambahSimpanan.php',
        data 	    :  data,
        cache       : false,
        processData : false,
        contentType : false,
        enctype     : 'multipart/form-data',
        success     : function(data){
            $('#NotifikkasiTambahSimpanan').html(data);
            var NotifikkasiTambahSimpananBerhasil=$('#NotifikkasiTambahSimpananBerhasil').html();
            if(NotifikkasiTambahSimpananBerhasil=="Success"){
                $('#NotifikasiTambahSimpananWajib').html('');
                $('#ModalTambahSimpanan').modal('hide');
                $('#page').val("1");
                filterAndLoadTable();
                Swal.fire(
                    'Success!',
                    'Tambah Simpanan Berhasil!',
                    'success'
                )
            }
        }
    });
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
//Modal Edit Simpanan
$('#ModalEditSimpanan').on('show.bs.modal', function (e) {
    var id_simpanan = $(e.relatedTarget).data('id');
    $('#FormEditSimpanan').html("Loading...");
    $.ajax({
        type 	    : 'POST',
        url 	    : '_Page/Tabungan/FormEditSimpanan.php',
        data        : {id_simpanan: id_simpanan},
        success     : function(data){
            $('#FormEditSimpanan').html(data);
            $('#NotifikasiEditSimpanan').html('');
        }
    });
});
//Proses Edit Simpanan
$('#ProsesEditSimpanan').submit(function(){
    $('#NotifikasiEditSimpanan').html('<div class="spinner-border text-secondary" role="status"><span class="sr-only"></span></div>');
    var form = $('#ProsesEditSimpanan')[0];
    var data = new FormData(form);
    $.ajax({
        type 	    : 'POST',
        url 	    : '_Page/Tabungan/ProsesEditSimpanan.php',
        data 	    :  data,
        cache       : false,
        processData : false,
        contentType : false,
        enctype     : 'multipart/form-data',
        success     : function(data){
            $('#NotifikasiEditSimpanan').html(data);
            var NotifikasiEditSimpananBerhasil=$('#NotifikasiEditSimpananBerhasil').html();
            if(NotifikasiEditSimpananBerhasil=="Success"){
                $('#NotifikasiEditSimpanan').html('');
                $('#ModalEditSimpanan').modal('hide');
                filterAndLoadTable();
                ShowDetailSimpanan();
                Swal.fire(
                    'Success!',
                    'Edit Simpanan Berhasil!',
                    'success'
                )
            }
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
                filterAndLoadTable();
                Swal.fire(
                    'Success!',
                    'Hapus Simpanan Berhasil!',
                    'success'
                )
            }
        }
    });
});
//Modal Tambah Jurnal Simpanan Simpanan
$('#ModalTambahJurnalSimpanan').on('show.bs.modal', function (e) {
    var id_simpanan = $(e.relatedTarget).data('id');
    $('#FormTambahJurnalSimpanan').html("Loading...");
    $.ajax({
        type 	    : 'POST',
        url 	    : '_Page/Tabungan/FormTambahJurnalSimpanan.php',
        data        : {id_simpanan: id_simpanan},
        success     : function(data){
            $('#FormTambahJurnalSimpanan').html(data);
            $('#NotifikasiTambahJurnalSimpanan').html('<code class="text-primary">Pastikan data jurnal simpanan diisi dengan benar.</code>');
        }
    });
});
//Proses Tambah Jurnal Simpanan
$('#ProsesTambahJurnalSimpanan').submit(function(){
    $('#NotifikasiTambahJurnalSimpanan').html('<code class="text-primary">Loading...</code>');
    var form = $('#ProsesTambahJurnalSimpanan')[0];
    var data = new FormData(form);
    $.ajax({
        type 	    : 'POST',
        url 	    : '_Page/Tabungan/ProsesTambahJurnalSimpanan.php',
        data 	    :  data,
        cache       : false,
        processData : false,
        contentType : false,
        enctype     : 'multipart/form-data',
        success     : function(data){
            $('#NotifikasiTambahJurnalSimpanan').html(data);
            var NotifikasiTambahJurnalSimpananBerhasil=$('#NotifikasiTambahJurnalSimpananBerhasil').html();
            if(NotifikasiTambahJurnalSimpananBerhasil=="Success"){
                $('#NotifikasiTambahJurnalSimpanan').html('');
                $('#ModalTambahJurnalSimpanan').modal('hide');
                ShowJurnalSimpanan();
                Swal.fire(
                    'Success!',
                    'Tambah Jurnal Simpanan Berhasil!',
                    'success'
                )
            }
        }
    });
});
//Modal Edit Jurnal Simpanan Simpanan
$('#ModalEditJurnalSimpanan').on('show.bs.modal', function (e) {
    var id_jurnal = $(e.relatedTarget).data('id');
    $('#FormEditJurnalSimpanan').html("Loading...");
    $.ajax({
        type 	    : 'POST',
        url 	    : '_Page/Tabungan/FormEditJurnalSimpanan.php',
        data        : {id_jurnal: id_jurnal},
        success     : function(data){
            $('#FormEditJurnalSimpanan').html(data);
            $('#NotifikasiEditJurnalSimpanan').html('<code class="text-primary">Pastikan data jurnal simpanan diisi dengan benar.</code>');
        }
    });
});
//Proses Edit Jurnal Simpanan
$('#ProsesEditJurnalSimpanan').submit(function(){
    $('#NotifikasiEditJurnalSimpanan').html('<code class="text-primary">Loading...</code>');
    var form = $('#ProsesEditJurnalSimpanan')[0];
    var data = new FormData(form);
    $.ajax({
        type 	    : 'POST',
        url 	    : '_Page/Tabungan/ProsesEditJurnalSimpanan.php',
        data 	    :  data,
        cache       : false,
        processData : false,
        contentType : false,
        enctype     : 'multipart/form-data',
        success     : function(data){
            $('#NotifikasiEditJurnalSimpanan').html(data);
            var NotifikasiEditJurnalSimpananBerhasil=$('#NotifikasiEditJurnalSimpananBerhasil').html();
            if(NotifikasiEditJurnalSimpananBerhasil=="Success"){
                $('#NotifikasiEditJurnalSimpanan').html('');
                $('#ModalEditJurnalSimpanan').modal('hide');
                ShowJurnalSimpanan();
                Swal.fire(
                    'Success!',
                    'Edit Jurnal Simpanan Berhasil!',
                    'success'
                )
            }
        }
    });
});
//Modal Hapus Jurnal Simpanan Simpanan
$('#ModalHapusJurnalSimpanan').on('show.bs.modal', function (e) {
    var id_jurnal = $(e.relatedTarget).data('id');
    $('#FormHapusJurnalSimpanan').html("Loading...");
    $.ajax({
        type 	    : 'POST',
        url 	    : '_Page/Tabungan/FormHapusJurnalSimpanan.php',
        data        : {id_jurnal: id_jurnal},
        success     : function(data){
            $('#FormHapusJurnalSimpanan').html(data);
            $('#NotifikasiHapusJurnalSimpanan').html('');
        }
    });
});
//Proses Hapus Jurnal Simpanan
$('#ProsesHapusJurnalSimpanan').submit(function(){
    $('#NotifikasiHapusJurnalSimpanan').html('<code class="text-primary">Loading...</code>');
    var form = $('#ProsesHapusJurnalSimpanan')[0];
    var data = new FormData(form);
    $.ajax({
        type 	    : 'POST',
        url 	    : '_Page/Tabungan/ProsesHapusJurnalSimpanan.php',
        data 	    :  data,
        cache       : false,
        processData : false,
        contentType : false,
        enctype     : 'multipart/form-data',
        success     : function(data){
            $('#NotifikasiHapusJurnalSimpanan').html(data);
            var NotifikasiHapusJurnalSimpananBerhasil=$('#NotifikasiHapusJurnalSimpananBerhasil').html();
            if(NotifikasiHapusJurnalSimpananBerhasil=="Success"){
                $('#NotifikasiHapusJurnalSimpanan').html('');
                $('#ModalHapusJurnalSimpanan').modal('hide');
                ShowJurnalSimpanan();
                Swal.fire(
                    'Success!',
                    'Hapus Jurnal Simpanan Berhasil!',
                    'success'
                )
            }
        }
    });
});
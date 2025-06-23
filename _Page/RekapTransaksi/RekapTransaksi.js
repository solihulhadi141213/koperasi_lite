//Fungsi Menampilkan Data
function MenampilkanJudulGrafik() {
    var ProsesFilterGrafik = $('#ProsesFilterGrafik').serialize();
    $.ajax({
        type    : 'POST',
        url     : '_Page/RekapTransaksi/MenampilkanJudulGrafik.php',
        data    : ProsesFilterGrafik,
        success: function(data) {
            $('#MenampilkanJudulGrafik').html(data);
            $('#ModalFilterGrafik').modal('hide');
        }
    });
}

function MenampilkanGambarGrafik() {
    var ProsesFilterGrafik = $('#ProsesFilterGrafik').serialize();
    // Ambil data dari server menggunakan AJAX
    $.ajax({
        url     : '_Page/RekapTransaksi/ProsesMenampilkanGrafikTransaksi.php',
        type    : 'POST',
        data    : ProsesFilterGrafik,
        dataType: 'json',
        success: function(response) {
            // Dapatkan data dari respons
            const months = response.months;
            const amounts = response.amounts;

            // Konfigurasi untuk grafik
            const options = {
                chart: {
                    type: 'bar', // Jenis grafik
                    height: 400
                },
                plotOptions: {
                    bar: {
                        horizontal: false
                    }
                },
                series: [{
                    name: '(Rp) Transaksi',
                    data: amounts
                }],
                xaxis: {
                    categories: months // Kategori sumbu x
                }
            };

            // Inisialisasi dan render grafik
            const chart = new ApexCharts(document.querySelector("#MenampilkanGambarGrafik"), options);
            chart.render();
        },
        error: function(error) {
            console.error("Error fetching data", error);
        }
    });
}
$(document).ready(function() {
    MenampilkanJudulGrafik();
    MenampilkanGambarGrafik();
});
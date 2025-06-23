//Fungsi Menampilkan Data
function MenampilkanJudulGrafik() {
    var ProsesFilterGrafik = $('#ProsesFilterGrafik').serialize();
    $.ajax({
        type    : 'POST',
        url     : '_Page/RekapJualBeli/MenampilkanJudulGrafik.php',
        data    : ProsesFilterGrafik,
        success: function(data) {
            $('#MenampilkanJudulGrafikJualBeli').html(data);
        }
    });
}
function MenampilkanTabelRekapJualBeli() {
    var ProsesFilterGrafik = $('#ProsesFilterGrafik').serialize();
    $.ajax({
        type    : 'POST',
        url     : '_Page/RekapJualBeli/TabelRekapJualBeli.php',
        data    : ProsesFilterGrafik,
        success: function(data) {
            $('#tabel_rekapitulasi_transaksi_jual_beli').html(data);
        }
    });
}
function MenampilkanGambarGrafik(tahun) {
    $.ajax({
        url: "_Page/RekapJualBeli/ProsesGrafikJualBeli.php",
        type: "POST",
        data: { tahun: tahun },
        dataType: "json",
        success: function(response) {
            var options = {
                chart: {
                    type: "bar",
                    height: 400
                },
                series: [
                    {
                        name: "Penjualan",
                        data: response.penjualan
                    },
                    {
                        name: "Pembelian",
                        data: response.pembelian
                    }
                ],
                xaxis: {
                    categories: [
                        "Jan", "Feb", "Mar", "Apr", "Mei", "Jun", 
                        "Jul", "Agu", "Sep", "Okt", "Nov", "Des"
                    ]
                },
                colors: ['#A0C878', '#E9762B'],
                dataLabels: {
                    enabled: false
                }
            };

            $("#MenampilkanGrafikJualBeli").html(""); // Bersihkan elemen sebelum menampilkan grafik baru
            var chart = new ApexCharts(document.querySelector("#MenampilkanGrafikJualBeli"), options);
            chart.render();
        }
    });
}
$(document).ready(function() {
    //Tangkap variabel tahun
    var tahun = $("#get_tahun").val();
    MenampilkanJudulGrafik();
    MenampilkanTabelRekapJualBeli();
    MenampilkanGambarGrafik(tahun);

    //Ketika Ubah Mode Data
    $('#ProsesFilterGrafik').submit(function(){
        var tahun = $("#get_tahun").val();
        //Menampilkan data
        MenampilkanJudulGrafik();
        MenampilkanTabelRekapJualBeli();
        MenampilkanGambarGrafik(tahun);
        //Tutup Modal
        $('#ModalFilter').modal('hide');
    });

    //Ketika Modal Cetak Muncul
    $('#ModalCetak').on('show.bs.modal', function (e) {
        var tahun = $('#get_tahun').val();
        $('#put_tahun_cetak').val(tahun);

        //Kosongkan Notifikasi
        $('#NotifikasiCetak').html("");
    });

    // Proses Cetak
    $('#ProsesCetak').submit(function(e){
        e.preventDefault(); // Mencegah form submit default
        
        $('#NotifikasiCetak').html('<div class="spinner-border text-secondary" role="status"><span class="sr-only"></span></div>');

        var tahun = $('#put_tahun_cetak').val();
        var file_type = $('#file_type').val();
        var url = '';

        if (file_type == "PDF") {
            url = '_Page/RekapJualBeli/ProsesCetakPdf.php?tahun=' + encodeURIComponent(tahun);
        } else {
            url = '_Page/RekapJualBeli/ProsesCetakExcel.php?tahun=' + encodeURIComponent(tahun);
        }

        // Buka link di tab baru
        var win = window.open(url, '_blank');

        if (win) {
            // Modal ditutup setelah 1 detik
            setTimeout(function () {
                $('#ModalCetak').modal('hide');
                $('#NotifikasiCetak').html(""); // Hapus notifikasi loading
            }, 1000);
        } else {
            $('#NotifikasiCetak').html('<div class="alert alert-danger">Popup terblokir! Harap izinkan popup.</div>');
        }
    });
});
//Fungsi Menampilkan Data 
function ShowData() {
    var ProsesFilter = $('#ProsesFilter').serialize();
    $.ajax({
        type    : 'POST',
        url     : '_Page/JenisPinjaman/TabelJenisPinjaman.php',
        data    : ProsesFilter,
        success: function(data) {
            $('#TabelJenisPinjaman').html(data);
        }
    });
}

//Fungsi Menampilkan Detail
function ShowDetailPinjaman(id_pinjaman_jenis) {
    $.ajax({
        type        : 'POST',
        url         : '_Page/JenisPinjaman/_detail_jenis_pinjaman.php',
        dataType    : "json",
        data        : {id_pinjaman_jenis: id_pinjaman_jenis},
        success     : function(response){
            if(response.status=="Success"){
                $('#FormDetailPinjaman').html(`
                    <div class="row mb-2">
                        <div class="col-4"><small>Nama Pinjaman</small></div>
                        <div class="col-1"><small>:</small></div>
                        <div class="col-7"><small class="text-muted">${response.dataset.nama_pinjaman}</small></div>
                    </div>
                    <div class="row mb-2">
                        <div class="col-4"><small>Periode Angsuran</small></div>
                        <div class="col-1"><small>:</small></div>
                        <div class="col-7"><small class="text-muted">${response.dataset.periode_angsuran} Bulan</small></div>
                    </div>
                    <div class="row mb-2">
                        <div class="col-4"><small>Persen Jasa</small></div>
                        <div class="col-1"><small>:</small></div>
                        <div class="col-7"><small class="text-muted">${response.dataset.persen_jasa} %</small></div>
                    </div>
                    <div class="row mb-2">
                        <div class="col-4"><small>Sesi Pinjaman</small></div>
                        <div class="col-1"><small>:</small></div>
                        <div class="col-7"><small class="text-muted">${response.dataset.jumlah_sesi_pinjaman}</small></div>
                    </div>
                `);
            }else{
                $('#FormDetailPinjaman').html(`
                    <div class="alert alert-danger" role="alert">
                        <small>Terjadi kesalahan pada sistem.<br> Keterangan : ${response.message}</small>
                    </div>
                `);
            }
        },
        error: function () {
            // Tempelkan Notifikasi
            $('#FormDetailPinjaman').html(
                '<div class="alert alert-danger" role="alert">Terjadi kesalahan pada sistem. Silakan coba lagi.</div>'
            );
        },
    });
}
$(document).ready(function() {

    //Menampilkan Data Pertama Kali
    ShowData();

    //Filter Data
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


    // Fungsi untuk membatasi input hanya angka positif
    document.getElementById('periode_angsuran').addEventListener('input', function (e) {
        this.value = this.value.replace(/[^0-9]/g, '');
    });

    // Fungsi untuk membatasi input hanya angka 0-100
    document.getElementById('persen_jasa').addEventListener('input', function (e) {
        this.value = this.value.replace(/[^0-9]/g, '');

        // Validasi agar nilai tidak lebih dari 100
        if (this.value !== '' && parseInt(this.value) > 100) {
            this.value = 100;
        }
    });

    //Modal Tambah Jenis Pinjaman Muncul
    $('#ModalTambahJenisPinjaman').on('show.bs.modal', function (e) {
        //Atur Element Tombol Simpan
        $('#ButtonTambahJenisPinjaman').html('<i class="bi bi-save"></i> Simpan');

        //Atur Element Notifikasi
        $('#NotifikasiTambahJenisPinjaman').html('');
    });

    //Proses Tambah Jenis Pinjaman
    $("#ProsesTambahJenisPinjaman").on("submit", function (e) {
        e.preventDefault();
        // Tombol loading
        let $FormElement = $("#ProsesTambahJenisPinjaman");
        let $ModalElement = $("#ModalTambahJenisPinjaman");
        let $Notifikasi = $("#NotifikasiTambahJenisPinjaman");
        let $ButtonProses = $("#ButtonTambahJenisPinjaman");
        let ButtonElement = '<i class="bi bi-save"></i> Simpan';
        $ButtonProses.html('Loading..');
        $ButtonProses.prop("disabled", true);
    
        // Ambil data form
        let formData = new FormData(this);
    
        // Kirim data ke server
        $.ajax({
            url         : "_Page/JenisPinjaman/ProsesTambahJenisPinjaman.php",
            type        : "POST",
            data        : formData,
            contentType : false,
            processData : false,
            dataType    : "json",
            success: function (response) {
                //Apabila Proses Berhasil
                if (response.status === "Success") {
                    
                    //reset form
                    $FormElement[0].reset();
                    
                    // Tampilkan swal notifikasi
                    Swal.fire(
                        'Success!',
                        'Tambah Jenis Pinjaman Berhasil!',
                        'success'
                    )
    
                    // Reset tombol
                    $ButtonProses.html(ButtonElement);
                    $ButtonProses.prop("disabled", false);
    
                    //Kosongkan Notifikasi
                    $Notifikasi.html('');
    
                    //Tutup Modal
                    $ModalElement.modal('hide');

                    //Reset Filter
                    $('#ProsesFilter')[0].reset();

                    //Tampilkan Data
                    ShowData();
                } else {
                    // Tampilkan pesan error
                    $Notifikasi.html(
                        `<div class="alert alert-danger" role="alert">${response.message}</div>`
                    );
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

    //Modal Detail Pinjaman Muncul
    $('#ModalDetailPinjaman').on('show.bs.modal', function (e) {
        var id_pinjaman_jenis= $(e.relatedTarget).data('id');
        ShowDetailPinjaman(id_pinjaman_jenis);
    });

    //Modal Edit Pinjaman Muncul
    $('#ModalEditJenisPinjaman').on('show.bs.modal', function (e) {
        var id_pinjaman_jenis= $(e.relatedTarget).data('id');
        //Kosongkan Notifikasi dan form
        $('#FormEditJenisPinjaman').html("");
        $('#NotifikasiEditJenisPinjaman').html("");

        //Disable Button
        $('#ButtonEditJenisPinjaman').prop("disabled", true);

        //Buka Data Jenis Pinjaman Dengan AJAX
        $.ajax({
            type        : 'POST',
            url         : '_Page/JenisPinjaman/_detail_jenis_pinjaman.php',
            dataType    : "json",
            data        : {id_pinjaman_jenis: id_pinjaman_jenis},
            success     : function(response){
                if(response.status=="Success"){
                    $('#FormEditJenisPinjaman').html(`
                        <input type="hidden" name="id_pinjaman_jenis" value="${id_pinjaman_jenis}">
                        <div class="row mb-3">
                            <div class="col-4">
                                <label for="nama_pinjaman_edit"><small>Nama Pinjaman</small></label>
                            </div>
                            <div class="col-1"><small>:</small></div>
                            <div class="col-7">
                                <input type="text" name="nama_pinjaman" id="nama_pinjaman_edit" class="form-control" value="${response.dataset.nama_pinjaman}">
                            </div>
                        </div>
                        <div class="row mb-3">
                            <div class="col-4">
                                <label for="periode_angsuran_edit"><small>Periode Angsuran</small></label>
                            </div>
                            <div class="col-1"><small>:</small></div>
                            <div class="col-7">
                                <input type="text" name="periode_angsuran" id="periode_angsuran_edit" class="form-control" value="${response.dataset.periode_angsuran}">
                                <small class="text-muted">Dalam Satuan Bulan</small>
                            </div>
                        </div>
                        <div class="row mb-3">
                            <div class="col-4">
                                <label for="persen_jasa_edit"><small>Jasa (%)</small></label>
                            </div>
                            <div class="col-1"><small>:</small></div>
                            <div class="col-7">
                                <input type="text" name="persen_jasa" id="persen_jasa_edit" class="form-control" value="${response.dataset.persen_jasa}">
                            </div>
                        </div>
                    `);

                    //Enable Button
                    $('#ButtonEditJenisPinjaman').prop("disabled", false);

                    // Fungsi untuk membatasi input hanya angka positif
                    document.getElementById('periode_angsuran_edit').addEventListener('input', function (e) {
                        this.value = this.value.replace(/[^0-9]/g, '');
                    });

                    // Fungsi untuk membatasi input hanya angka 0-100
                    document.getElementById('persen_jasa_edit').addEventListener('input', function (e) {
                        this.value = this.value.replace(/[^0-9]/g, '');

                        // Validasi agar nilai tidak lebih dari 100
                        if (this.value !== '' && parseInt(this.value) > 100) {
                            this.value = 100;
                        }
                    });
                }else{
                    $('#FormEditJenisPinjaman').html(`
                        <div class="alert alert-danger" role="alert">
                            <small>Terjadi kesalahan pada sistem.<br> Keterangan : ${response.message}</small>
                        </div>
                    `);
                    //Disable Button
                    $('#ButtonEditJenisPinjaman').prop("disabled", true);
                }
            },
            error: function () {
                // Tempelkan Notifikasi
                $('#FormEditJenisPinjaman').html(
                    '<div class="alert alert-danger" role="alert">Terjadi kesalahan pada sistem. Silakan coba lagi.</div>'
                );

                //Disable Button
                $('#ButtonEditJenisPinjaman').prop("disabled", true);
            },
        });
    });

    //Proses Edit Jenis Pinjaman
    $("#ProsesEditJenisPinjaman").on("submit", function (e) {
        e.preventDefault();
        // Tombol loading
        let $FormElement = $("#ProsesEditJenisPinjaman");
        let $ModalElement = $("#ModalEditJenisPinjaman");
        let $Notifikasi = $("#NotifikasiEditJenisPinjaman");
        let $ButtonProses = $("#ButtonEditJenisPinjaman");
        let ButtonElement = '<i class="bi bi-save"></i> Simpan';
        $ButtonProses.html('Loading..');
        $ButtonProses.prop("disabled", true);
    
        // Ambil data form
        let formData = new FormData(this);
    
        // Kirim data ke server
        $.ajax({
            url         : "_Page/JenisPinjaman/ProsesEditJenisPinjaman.php",
            type        : "POST",
            data        : formData,
            contentType : false,
            processData : false,
            dataType    : "json",
            success: function (response) {
                //Apabila Proses Berhasil
                if (response.status === "Success") {
                    
                    //reset form
                    $FormElement[0].reset();
                    
                    // Tampilkan swal notifikasi
                    Swal.fire(
                        'Success!',
                        'Edit Jenis Pinjaman Berhasil!',
                        'success'
                    )
    
                    // Reset tombol
                    $ButtonProses.html(ButtonElement);
                    $ButtonProses.prop("disabled", false);
    
                    //Kosongkan Notifikasi
                    $Notifikasi.html('');
    
                    //Tutup Modal
                    $ModalElement.modal('hide');

                    //Tampilkan Data
                    ShowData();
                } else {
                    // Tampilkan pesan error
                    $Notifikasi.html(
                        `<div class="alert alert-danger" role="alert">${response.message}</div>`
                    );
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


    //Modal Hapus Pinjaman Muncul
    $('#ModalHapusJenisPinjaman').on('show.bs.modal', function (e) {
        var id_pinjaman_jenis= $(e.relatedTarget).data('id');
        //Kosongkan Notifikasi dan form
        $('#FormHapusJenisPinjaman').html("");
        $('#NotifikasiHapusJenisPinjaman').html("");

        //Disable Button
        $('#ButtonHapusJenisPinjaman').prop("disabled", true);

        //Buka Data Jenis Pinjaman Dengan AJAX
        $.ajax({
            type        : 'POST',
            url         : '_Page/JenisPinjaman/_detail_jenis_pinjaman.php',
            dataType    : "json",
            data        : {id_pinjaman_jenis: id_pinjaman_jenis},
            success     : function(response){
                if(response.status=="Success"){
                    $('#FormHapusJenisPinjaman').html(`
                        <input type="hidden" name="id_pinjaman_jenis" value="${id_pinjaman_jenis}">
                        <div class="row mb-2">
                            <div class="col-4"><small>Nama Pinjaman</small></div>
                            <div class="col-1"><small>:</small></div>
                            <div class="col-7"><small class="text-muted">${response.dataset.nama_pinjaman}</small></div>
                        </div>
                        <div class="row mb-2">
                            <div class="col-4"><small>Periode Angsuran</small></div>
                            <div class="col-1"><small>:</small></div>
                            <div class="col-7"><small class="text-muted">${response.dataset.periode_angsuran} Bulan</small></div>
                        </div>
                        <div class="row mb-2">
                            <div class="col-4"><small>Persen Jasa</small></div>
                            <div class="col-1"><small>:</small></div>
                            <div class="col-7"><small class="text-muted">${response.dataset.persen_jasa} %</small></div>
                        </div>
                        <div class="row mb-3">
                            <div class="col-4"><small>Sesi Pinjaman</small></div>
                            <div class="col-1"><small>:</small></div>
                            <div class="col-7"><small class="text-muted">${response.dataset.jumlah_sesi_pinjaman}</small></div>
                        </div>
                        <div class="row mb-2">
                            <div class="col-12">
                                <small>Apakah Anda Yakin Akan Menghapus Data Tersebut?</small>
                            </div>
                        </div>
                    `);

                    //Enable Button
                    $('#ButtonHapusJenisPinjaman').prop("disabled", false);

                    // Fungsi untuk membatasi input hanya angka positif
                    document.getElementById('periode_angsuran_edit').addEventListener('input', function (e) {
                        this.value = this.value.replace(/[^0-9]/g, '');
                    });

                    // Fungsi untuk membatasi input hanya angka 0-100
                    document.getElementById('persen_jasa_edit').addEventListener('input', function (e) {
                        this.value = this.value.replace(/[^0-9]/g, '');

                        // Validasi agar nilai tidak lebih dari 100
                        if (this.value !== '' && parseInt(this.value) > 100) {
                            this.value = 100;
                        }
                    });
                }else{
                    $('#FormHapusJenisPinjaman').html(`
                        <div class="alert alert-danger" role="alert">
                            <small>Terjadi kesalahan pada sistem.<br> Keterangan : ${response.message}</small>
                        </div>
                    `);
                    //Disable Button
                    $('#ButtonHapusJenisPinjaman').prop("disabled", true);
                }
            },
            error: function () {
                // Tempelkan Notifikasi
                $('#FormHapusJenisPinjaman').html(
                    '<div class="alert alert-danger" role="alert">Terjadi kesalahan pada sistem. Silakan coba lagi.</div>'
                );

                //Disable Button
                $('#ButtonHapusJenisPinjaman').prop("disabled", true);
            },
        });
    });

    //Proses Hapus Jenis Pinjaman
    $("#ProsesHapusJenisPinjaman").on("submit", function (e) {
        e.preventDefault();
        // Tombol loading
        let $FormElement = $("#ProsesHapusJenisPinjaman");
        let $ModalElement = $("#ModalHapusJenisPinjaman");
        let $Notifikasi = $("#NotifikasiHapusJenisPinjaman");
        let $ButtonProses = $("#ButtonHapusJenisPinjaman");
        let ButtonElement = '<i class="bi bi-check"></i> Ya, Hapus';
        $ButtonProses.html('Loading..');
        $ButtonProses.prop("disabled", true);
    
        // Ambil data form
        let formData = new FormData(this);
    
        // Kirim data ke server
        $.ajax({
            url         : "_Page/JenisPinjaman/ProsesHapusJenisPinjaman.php",
            type        : "POST",
            data        : formData,
            contentType : false,
            processData : false,
            dataType    : "json",
            success: function (response) {
                //Apabila Proses Berhasil
                if (response.status === "Success") {
                    
                    //reset form
                    $FormElement[0].reset();
                    
                    // Tampilkan swal notifikasi
                    Swal.fire(
                        'Success!',
                        'Hapus Jenis Pinjaman Berhasil!',
                        'success'
                    )
    
                    // Reset tombol
                    $ButtonProses.html(ButtonElement);
                    $ButtonProses.prop("disabled", false);
    
                    //Kosongkan Notifikasi
                    $Notifikasi.html('');
    
                    //Tutup Modal
                    $ModalElement.modal('hide');

                    //Tampilkan Data
                    ShowData();
                } else {
                    // Tampilkan pesan error
                    $Notifikasi.html(
                        `<div class="alert alert-danger" role="alert">${response.message}</div>`
                    );
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


});
//Fungsi Untuk Menampilkan Data
function ShowData() {
    var ProsesFilter = $('#ProsesFilter').serialize();
    $.ajax({
        type 	    : 'POST',
        url 	    : '_Page/Help/TabelDokumentasi.php',
        data 	    :  ProsesFilter,
        success     : function(data){
            $('#TabelDokumentasi').html(data);
            $('#ShowData').show();
            $('#ShowDetail').hide();
            $('#ShowTambahDokumentasi').hide();
            $('#ShowEditDokumentasi').hide();
        }
    });
}

//Fungsi Untuk Menampilkan Halaman Tambah Dokumentasi
function ShowTambahDokumentasi() {
    $('#ShowData').hide();
    $('#ShowDetail').hide();
    $('#ShowTambahDokumentasi').show();
    $('#ShowEditDokumentasi').hide();
}

//Fungsi Untuk Menampilkan Halaman Detail Dokumentasi
//Fungsi Untuk Menampilkan Halaman Detail Dokumentasi
function ShowDetailDokumentasi(id_help) {
    //Ambil Detail Dokumentasi dengan Ajax
    $.ajax({
        type 	    : 'POST',
        url 	    : '_Page/Help/_detail_dokumentasi.php',
        data 	    :  {id_help: id_help},
        dataType    : "json",
        success     : function(response){
            if(response.status=="Success"){
                $('#ShowData').hide();
                $('#ShowDetail').show();
                $('#ShowTambahDokumentasi').hide();
                $('#ShowEditDokumentasi').hide();
               
                // Tempelkan Data Pada Element
                $('#put_judul_dokumentasi').html(response.dataset.judul);
                $('#put_kategori_dokumentasi').html(response.dataset.kategori);
                $('#put_dokumentasi').html(response.dataset.deskripsi);
                $('#tanggal_dokumentasi').html(response.dataset.datetime_creat);
                $('#author_dokumentasi').html(response.dataset.author);

                // Menampilkan List Artikel Lainnya
                var artikelLainnyaHTML = '<ol>';
                $.each(response.dataset.artikel_lainnya, function(index, artikel) {
                    artikelLainnyaHTML += '<li><a href="javascript:void(0);" class="detail_dokumentasi" data-id="' + artikel.id_help + '">' + artikel.judul + '</a></li>';
                });
                artikelLainnyaHTML += '</ol>';

                // Tempelkan List Artikel Lainnya
                $('#list_artikel_lainnya').html(artikelLainnyaHTML);

                // Tempelkan id_help ke tombol edit
                $("#button_edit_dokumentasi").attr("data-id", id_help);
            }else{
                Swal.fire(
                    'Opss!',
                    'Terjadi Kesalahan! Pesan : '+response.message+'',
                    'error'
                );
            }
        },
        error: function () {
            Swal.fire(
                'Opss!',
                'Terjadi Kesalahan Pada Saat Menampilkan Detail Dokumentasi!',
                'error'
            );
        },
    });
}


//Fungsi Untuk Menampilkan Halaman Edit Dokumentasi
function ShowEditDokumentasi(id_help) {
    // Ambil Detail Dokumentasi dengan Ajax
    $.ajax({
        type: 'POST',
        url: '_Page/Help/_detail_dokumentasi.php',
        data: { id_help: id_help },
        dataType: "json",
        success: function (response) {
            if (response.status === "Success") {
                $('#ShowData').hide();
                $('#ShowDetail').hide();
                $('#ShowTambahDokumentasi').hide();
                $('#ShowEditDokumentasi').show();

                // Tempelkan Data Pada Element Form
                $('#put_id_help_edit').val(id_help);
                $('#judul_edit').val(response.dataset.judul);
                $('#kategori_edit').val(response.dataset.kategori);
                $('#author_edit').val(response.dataset.author);
                $('#tanggal_edit').val(response.dataset.datetime_creat);

                // Pastikan TinyMCE sudah siap sebelum mengatur konten
                var deskripsi = response.dataset.deskripsi;
                var deskripsi = $("<textarea/>").html(response.dataset.deskripsi).text();
                if (tinymce.get('deskripsi_edit')) {
                    tinymce.get('deskripsi_edit').setContent(deskripsi);
                } else {
                    tinymce.init({
                        selector: '#deskripsi_edit',
                        height: 450,
                        menubar: false,
                        plugins: [
                            'advlist autolink lists link image charmap print preview anchor',
                            'searchreplace visualblocks code fullscreen',
                            'insertdatetime media table paste code help wordcount',
                            'codesample emoticons fullscreen image preview',
                            'code template hr pagebreak nonbreaking'
                        ],
                        toolbar: 'undo redo | styleselect | bold italic forecolor backcolor | alignleft aligncenter alignright alignjustify | bullist numlist outdent indent | removeformat | image codesample emoticons table preview fullscreen',
                        images_upload_url: 'PostAcceptor.php',
                        images_upload_handler: function (blobInfo, success, failure) {
                            var formData = new FormData();
                            formData.append('file', blobInfo.blob(), blobInfo.filename());

                            $.ajax({
                                url: '_Page/PostAcceptor/PostAcceptor.php',
                                type: 'POST',
                                data: formData,
                                processData: false,
                                contentType: false,
                                success: function (response) {
                                    var json = JSON.parse(response);
                                    if (json.location) {
                                        success(json.location);
                                    } else {
                                        failure('Gagal mengunggah gambar.');
                                    }
                                },
                                error: function () {
                                    failure('Terjadi kesalahan saat mengunggah.');
                                }
                            });
                        },
                        init_instance_callback: function (editor) {
                            editor.setContent(deskripsi); // Set konten setelah editor siap
                        }
                    });
                }
            } else {
                Swal.fire(
                    'Opss!',
                    'Terjadi Kesalahan! Pesan: ' + response.message,
                    'error'
                );
            }
        },
        error: function () {
            Swal.fire(
                'Opss!',
                'Terjadi Kesalahan Pada Saat Menampilkan Detail Dokumentasi!',
                'error'
            );
        },
    });
}



//Load Element Halaman
$(document).ready(function() {
    
    //Menampilkan Data Pertama Kali
    ShowData();
    
    //Kontrol Untuk Menampilkan readme.md
    let isReadmeVisible = false;
    $('#show_hide_documentation').click(function() {
        if (!isReadmeVisible) {
            // Load README.md content
            $.get('README.md', function(data) {
                const htmlContent = marked.parse(data);
                $('#show_hide_readme').html(htmlContent).slideDown();
            }).fail(function() {
                $('#show_hide_readme').html('<p>Failed to load README.md</p>').slideDown();
            });

            // Change button icon and text
            $(this).html('<i class="bi bi-eye-slash"></i> Sembunyikan Konten');
        } else {
            // Hide content
            $('#show_hide_readme').slideUp();

            // Change button icon and text
            $(this).html('<i class="bi bi-eye"></i> Tampilkan Konten');
        }

        isReadmeVisible = !isReadmeVisible;
    });
    
    //Ketika KeywordBy Diubah
    $('#keyword_by').change(function(){
        var keyword_by = $('#keyword_by').val();
        $.ajax({
            type 	    : 'POST',
            url 	    : '_Page/Help/FormFilter.php',
            data 	    :  {keyword_by: keyword_by},
            success     : function(data){
                $('#FormFilter').html(data);
            }
        });
    });

    //Ketika Filter Di Submit
    $('#ProsesFilter').submit(function(){
        //Halaman Kembali Default
        $('#PutPage').val('1');

        //Tampilkan Data
        ShowData();

        //Tutup Modal Filter
        $('#ModalFilter').modal('hide');
    });

    //PAGGING
    $(document).on('click', '#next_button', function() {
        var page_now = parseInt($('#PutPage').val(), 10); // Pastikan nilai diambil sebagai angka
        var next_page = page_now + 1;
        $('#PutPage').val(next_page);
        ShowData();
    });
    $(document).on('click', '#prev_button', function() {
        var page_now = parseInt($('#PutPage').val(), 10); // Pastikan nilai diambil sebagai angka
        var next_page = page_now - 1;
        $('#PutPage').val(next_page);
        ShowData();
    });
    
    //Ketika tambah_data_dokumentasi di click
    $('#tambah_data_dokumentasi').click(function(){
        ShowTambahDokumentasi();
    });

    //Ketika class detail_dokumentasi di click
    $(document).on('click', '.detail_dokumentasi', function(e){
        //Tangkap id_help
        var id_help = $(this).data('id');
        ShowDetailDokumentasi(id_help);
    });

    //Ketika class edit_dokumentasi di click
    $(document).on('click', '.edit_dokumentasi', function(e){
        console.log(this);
        //Tangkap id_help
        var id_help = $(this).attr('data-id');
        ShowEditDokumentasi(id_help);
    });
    
    //Tinymace Tambah Dokumentasi
    tinymce.init({
        selector: '#deskripsi',
        height: 450,
        menubar: false,
        plugins: [
            'advlist autolink lists link image charmap print preview anchor',
            'searchreplace visualblocks code fullscreen',
            'insertdatetime media table paste code help wordcount',
            'codesample emoticons fullscreen image preview',
            'code template hr pagebreak nonbreaking'
        ],
        toolbar: 'undo redo | styleselect | bold italic forecolor backcolor | alignleft aligncenter alignright alignjustify | bullist numlist outdent indent | removeformat | image codesample emoticons table preview fullscreen',
        
        images_upload_url: 'PostAcceptor.php', // Endpoint untuk upload gambar
        images_upload_handler: function (blobInfo, success, failure) {
            var formData = new FormData();
            formData.append('file', blobInfo.blob(), blobInfo.filename());

            $.ajax({
                url: '_Page/PostAcceptor/PostAcceptor.php', // Sesuaikan dengan backend untuk menangani upload
                type: 'POST',
                data: formData,
                processData: false,
                contentType: false,
                success: function (response) {
                    var json = JSON.parse(response);
                    if (json.location) {
                        success(json.location);
                    } else {
                        failure('Gagal mengunggah gambar.');
                    }
                },
                error: function () {
                    failure('Terjadi kesalahan saat mengunggah.');
                }
            });
        }
    });

    //Ketika tombol class back_to_data di click
    $('.back_to_data').click(function(){
        ShowData();
    });

    // Proses Tambah Dokumentasi
    $('#ProsesTambahDokumentasi').submit(function (e) {
        e.preventDefault(); // Mencegah reload halaman saat submit

        // Ambil data dari TinyMCE
        var deskripsi = tinymce.get('deskripsi').getContent();

        // Ambil semua data dari form
        var formData = new FormData(this);
        formData.set('deskripsi', deskripsi); // Gantikan deskripsi textarea dengan isi TinyMCE

        // Disable tombol submit dan tampilkan loading
        $('#ButtonTambahDokumentasi')
            .prop('disabled', true)
            .html('<i class="bi bi-arrow-repeat"></i> Menyimpan...');

        // Hapus notifikasi sebelumnya
        $('#NotifikasiTambahDokumentasi').html('');

        // Proses AJAX
        $.ajax({
            type: 'POST',
            url: '_Page/Help/ProsesTambahDokumentasi.php',
            data: formData,
            dataType: 'json',
            processData: false,
            contentType: false,
            success: function (response) {
                if (response.status === "Success") {
                    //Jika berhasil terima id_help
                    var id_help=response.id_help;
                    
                    // Tampilkan notifikasi sukses
                    Swal.fire({
                        icon: 'success',
                        title: 'Berhasil!',
                        text: 'Dokumentasi berhasil ditambahkan.',
                        timer: 2000,
                        showConfirmButton: true
                    });

                    //Reset Form Filter
                    $('#ProsesFilter')[0].reset();

                    // Panggil fungsi ShowDetailDokumentasi(id_help)
                    ShowDetailDokumentasi(id_help);

                    // Reset form setelah sukses
                    $('#ProsesTambahDokumentasi')[0].reset(); // Kosongkan form
                    tinymce.get('deskripsi').setContent(''); // Kosongkan TinyMCE
                } else {
                    // Tampilkan error pada NotifikasiTambahDokumentasi
                    $('#NotifikasiTambahDokumentasi').html(
                        '<div class="alert alert-danger" role="alert">' + response.message + '</div>'
                    );
                }
            },
            error: function () {
                $('#NotifikasiTambahDokumentasi').html(
                    '<div class="alert alert-danger" role="alert">Terjadi kesalahan saat mengirim data.</div>'
                );
            },
            complete: function () {
                // Aktifkan kembali tombol dan kembalikan teks asli
                $('#ButtonTambahDokumentasi').prop('disabled', false).html('<i class="bi bi-save"></i> Simpan Dokumentasi');
            }
        });
    });

    //Modal Hapus Dokumentasi
    $('#ModalHapus').on('show.bs.modal', function (e) {
        var id_help= $(e.relatedTarget).data('id');
        $('#ButtonHapus').prop("disabled", true);
        $.ajax({
            type 	    : 'POST',
            url 	    : '_Page/Help/_detail_dokumentasi.php',
            data        : {id_help: id_help},
            dataType    : "json",
            success     : function(response){
                if (response.status === "Success") {
                    var judul=response.dataset.judul;
                    var kategori=response.dataset.kategori;
                    var deskripsi=response.dataset.deskripsi;
                    var datetime_creat=response.dataset.datetime_creat;
                    var author=response.dataset.author;
                    
                    //Tempelkan Ke Form
                    $('#FormHapus').html(`
                        <input type="hidden" name="id_help" value="${id_help}">
                        <div class="row mb-2">
                            <div class="col-4"><small>Judul</small></div>
                            <div class="col-8"><small class="text-muted">${judul}</small></div>
                        </div>
                        <div class="row mb-2">
                            <div class="col-4"><small>Kategori</small></div>
                            <div class="col-8"><small class="text-muted">${kategori}</small></div>
                        </div>
                        <div class="row mb-2">
                            <div class="col-4"><small>Tanggal</small></div>
                            <div class="col-8"><small class="text-muted">${datetime_creat}</small></div>
                        </div>
                        <div class="row mb-3">
                            <div class="col-4"><small>Author</small></div>
                            <div class="col-8"><small class="text-muted">${author}</small></div>
                        </div>
                        <div class="row mb-2 mt-3">
                            <div class="col-12">
                                <small>Apakah Anda Yakin Akan Menghapus Data Tersebut?</small>
                            </div>
                        </div>
                    `);

                    //Aktivkan Tombol
                    $('#ButtonHapus').prop("disabled", false);

                    //Kosongkan Notifikasi
                    $('#NotifikasiEditKategoriHarga').html("");
                }else{
                    //Tampilkan Kesalahan Pada Element Notifikasi
                    $('#NotifikasiHapus').html(
                        `<div class="alert alert-danger" role="alert">Terjadi kesalahan pada sistem. Pesan: ${response.message}</div>`
                    );

                    //Disable Tombol
                    $('#ButtonHapus').prop("disabled", true);

                    //Kosongkn Form
                    $('#FormHapus').html("");
                }
            },
            error: function () {
                //Tampilkan Kesalahan Pada Element Notifikasi
                $('#NotifikasiHapus').html(
                    '<div class="alert alert-danger" role="alert">Terjadi kesalahan pada sistem. Silakan coba lagi.</div>'
                );

                //Disable Tombol
                $('#ButtonHapus').prop("disabled", true);

                //Kosongkn Form
                $('#FormHapus').html("");
            },
        });
    });

    //Proses Hapus Dokumentasi
    $("#ProsesHapus").on("submit", function (e) {
        e.preventDefault();
        // Tombol loading
        let $FormElement = $("#ProsesHapus");
        let $ModalElement = $("#ModalHapus");
        let $Notifikasi = $("#NotifikasiHapus");
        let $ButtonProses = $("#ButtonHapus");
        let ButtonElement = '<i class="bi bi-check"></i> Ya, Hapus';
        $ButtonProses.html('Loading..');
        $ButtonProses.prop("disabled", true);
    
        // Ambil data form
        let formData = new FormData(this);
    
        // Kirim data ke server
        $.ajax({
            url         : "_Page/Help/ProsesHapus.php",
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
                        'Hapus Dokumentasi Berhasil!',
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

    // Proses Edit Dokumentasi
    $('#ProsesEditDokumentasi').submit(function (e) {
        e.preventDefault(); // Mencegah reload halaman saat submit

        // Ambil data dari TinyMCE
        var deskripsi = tinymce.get('deskripsi_edit').getContent();

        // Ambil semua data dari form
        var formData = new FormData(this);
        formData.set('deskripsi_edit', deskripsi); // Gantikan deskripsi textarea dengan isi TinyMCE

        // Disable tombol submit dan tampilkan loading
        $('#ButtonEditDokumentasi')
            .prop('disabled', true)
            .html('<i class="bi bi-arrow-repeat"></i> Menyimpan...');

        // Hapus notifikasi sebelumnya
        $('#NotifikasiEditDokumentasi').html('');

        // Proses AJAX
        $.ajax({
            type: 'POST',
            url: '_Page/Help/ProsesEditDokumentasi.php',
            data: formData,
            dataType: 'json',
            processData: false,
            contentType: false,
            success: function (response) {
                if (response.status === "Success") {
                    // Tampilkan notifikasi sukses
                    Swal.fire({
                        icon: 'success',
                        title: 'Berhasil!',
                        text: 'Dokumentasi berhasil Disimpan.',
                        timer: 2000,
                        showConfirmButton: true
                    });

                    //Reset Form Filter
                    $('#ProsesFilter')[0].reset();

                    var id_help=response.id_help;
                    // Panggil fungsi ShowDetailDokumentasi()
                    ShowDetailDokumentasi(id_help);

                    // Reset form setelah sukses
                    $('#ProsesEditDokumentasi')[0].reset(); // Kosongkan form
                    tinymce.get('deskripsi_edit').setContent(''); // Kosongkan TinyMCE
                } else {
                    // Tampilkan error pada NotifikasiEditDokumentasi
                    $('#NotifikasiEditDokumentasi').html(
                        '<div class="alert alert-danger" role="alert">' + response.message + '</div>'
                    );
                }
            },
            error: function () {
                $('#NotifikasiEditDokumentasi').html(
                    '<div class="alert alert-danger" role="alert">Terjadi kesalahan saat mengirim data.</div>'
                );
            },
            complete: function () {
                // Aktifkan kembali tombol dan kembalikan teks asli
                $('#ButtonEditDokumentasi').prop('disabled', false).html('<i class="bi bi-save"></i> Simpan Dokumentasi');
            }
        });
    });
});
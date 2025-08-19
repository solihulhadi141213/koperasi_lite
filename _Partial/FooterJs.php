<!-- ======= Footer ======= -->
<a href="#" class="back-to-top d-flex align-items-center justify-content-center"><i class="bi bi-arrow-up-short"></i></a>
<!-- Vendor JS Files -->
<script src="node_modules/signature_pad/dist/signature_pad.umd.min.js"></script>
<script src="assets/vendor/apexcharts/apexcharts.min.js"></script>
<script src="assets/vendor/bootstrap/js/bootstrap.bundle.min.js"></script>
<script src="assets/vendor/chart.js/chart.umd.js"></script>
<script src="assets/vendor/echarts/echarts.min.js"></script>
<script src="assets/vendor/quill/quill.js"></script>
<script src="assets/vendor/simple-datatables/simple-datatables.js"></script>
<script src="assets/vendor/tinymce/tinymce.min.js"></script>
<script src="assets/vendor/php-email-form/validate.js"></script>
<script type="text/javascript" src="node_modules/jquery/dist/jquery.min.js"></script>
<script src="assets/jQuery-Mask-Plugin/dist/jquery.mask.min.js"></script>
<script src="node_modules\sweetalert2\dist\sweetalert2.all.min.js"></script>
<script type="text/javascript" src="assets/js/jquery.session.js"></script>

<script src="node_modules/html2canvas/dist/html2canvas.min.js"></script>
<script src="node_modules/jspdf/dist/jspdf.umd.min.js"></script>

<!-- Template Main JS File -->
<script src="assets/js/main.js"></script>
<script>
    (function () {
    const btn = document.querySelector('header .toggle-sidebar-btn');
    if (!btn) return;
    const body = document.body;
    const mqDesktop = window.matchMedia('(min-width: 1200px)'); // breakpoint NiceAdmin/Bootstrap

    // Di NiceAdmin:
    // - Desktop (>=1200px): TANPA class "toggle-sidebar" = sidebar TERBUKA
    // - Mobile (<1200px):  DENGAN class "toggle-sidebar"  = sidebar TERBUKA (mode overlay)
    function isSidebarOpen() {
        const toggled = body.classList.contains('toggle-sidebar');
        return mqDesktop.matches ? !toggled : toggled;
    }

    function syncIconAndTitle() {
        const open = isSidebarOpen();
        // Ganti ikon
        btn.classList.remove('bi-list', 'bi-x');
        btn.classList.add(open ? 'bi-x' : 'bi-list');
        // Aksesibilitas + tooltip
        btn.setAttribute('title', open ? 'Tutup menu' : 'Buka menu');
        btn.setAttribute('aria-label', open ? 'Tutup menu' : 'Buka menu');
    }

    // Jalankan awal (saat page load)
    syncIconAndTitle();

    // Saat tombol diklik, biarkan script NiceAdmin toggle body dulu, lalu sinkronkan ikon
    btn.addEventListener('click', function () {
        // Antri ke frame berikutnya agar class di <body> sudah berubah
        requestAnimationFrame(syncIconAndTitle);
    });

    // Jika class <body> berubah karena alasan lain (mis. resize, script lain), kita ikuti
    const mo = new MutationObserver(syncIconAndTitle);
    mo.observe(body, { attributes: true, attributeFilter: ['class'] });

    // Re-evaluasi saat breakpoint berubah
    mqDesktop.addEventListener('change', syncIconAndTitle);
    window.addEventListener('resize', syncIconAndTitle);
    })();
</script>

<script type="text/javascript">
    $(document).ready(function(){
        // Format mata uang.
        $( '#kembalian' ).mask('000.000.000.000', {reverse: true});
        $( '#pembayaran' ).mask('000.000.000.000', {reverse: true});
        $( '#jumlah_transaksi' ).mask('000.000.000.000', {reverse: true});
        $( '#jumlah_transaksi_edit' ).mask('000.000.000.000', {reverse: true});
        $( '#pembayaran_edit' ).mask('000.000.000.000', {reverse: true});
        $( '#kembalian_edit' ).mask('000.000.000.000', {reverse: true});
        $( '.format_uang' ).mask('000.000.000.000', {reverse: true});
    })
</script>

<!-- Scan QR -->
<script src="https://cdn.jsdelivr.net/npm/jsqr@1.4.0/dist/jsQR.min.js"></script>

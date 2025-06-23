//Load Element Halaman
$(document).ready(function() {
    // Load README.md content
    $.get('README.md?v=1', function(data) {
        const htmlContent = marked.parse(data);
        $('#show_hide_readme').html(htmlContent).slideDown();
    }).fail(function() {
        $('#show_hide_readme').html('<p>Failed to load README.md</p>').slideDown();
    });
});
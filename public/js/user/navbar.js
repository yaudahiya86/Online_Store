
$(document).ready(function () {
    $('.search-box').on('focus', function () {
        if ($(window).width() <= 480) {
            $('.brand').fadeOut(); // Hilangkan teks dengan efek fade
        }
    });

    $('.search-box').on('blur', function () {
        if ($(window).width() <= 480) {
            $('.brand').fadeIn(); // Tampilkan kembali teks
        }
    });
});

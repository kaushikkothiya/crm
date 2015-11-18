$(document).ready(function () {
    $('.side-nav li a').on('click', function () {
        if ($(this).find('i.fa-angle-down').first().hasClass('fa-angle-down')) {
            $(this).find('i.fa-angle-down').first().removeClass('fa-angle-down').addClass('fa-angle-up');
        } else {
            $(this).find('i.fa-angle-up').first().removeClass('fa-angle-up').addClass('fa-angle-down');
        }
    });
});
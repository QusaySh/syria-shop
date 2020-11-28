$(document).ready(function () {
    $(".statistics-card").hover(function () {
        $(this).children("i").addClass("rotateIn");
    }, function () {
        $(this).children("i").removeClass("rotateIn");
    });
});
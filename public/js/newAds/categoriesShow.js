$(document).ready(function () {
    $(".cat-main").on("click", function () {
        $(this).siblings(".cat-notMain").slideToggle("fast");
    });
});
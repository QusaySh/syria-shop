$(document).ready(function () {
    
    $("#confirm").focus();
    
    $("a#sendCode").on("click", function () {
        $.ajax({
            url: "/client/resendReset",
            method: "POST",
            beforeSend: function(){
                $(".preloader-wrapper").next("p").toggle();
                $(".preloader-wrapper").toggleClass("hide");
            },
            success: function (data) {
                if ( data.status == "success" ) {
                    M.toast({html: data.message + "<i class='material-icons green-text right'>check</i>"});
                } else {
                    voiceError.play();
                    M.toast({html: data.message + "<i class='material-icons red-text right'>close</i>"});
                }
                $(".preloader-wrapper").next("p").toggle();
                $(".preloader-wrapper").toggleClass("hide");
            },
            error: function () {
                voiceError.play();
                M.toast({html: lang("faildSendMessage", Cookies.get("lang")) + "<i class='material-icons red-text right'>close</i>"});
                $(".preloader-wrapper").next("p").toggle();
                $(".preloader-wrapper").toggleClass("hide");
            }
        });
    });
    
});
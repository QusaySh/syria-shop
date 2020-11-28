$(document).ready(function () {

    $(".collapsible-header").on("click", function () {
        if ( $(this).children(".drop_down").hasClass("up") ) {
            $(this).children(".drop_down").text("arrow_drop_down").removeClass("up");
        } else {
            $(this).children(".drop_down").text("arrow_drop_up").addClass("up");
        }
    });
    // تغير اسم المستخدم
    $("[name='save_username']").on("click", function () {
        var username = $("[name='username']").val(),
            btn = $(this);
        $.ajax({
            url: "/profile/saveUsername",
            method: "POST",
            data: {save_username: true, username: username},
            beforeSend: function () {
                btn.toggleClass("hide");
                btn.siblings(".preloader-wrapper").toggleClass("hide");
            },
            success: function (data) {
                if ( data.status == "error" ) {
                    M.toast({html: data.message[0]});
                } else {
                    $(".nikeName").text(username); // تغير الاسم الشخصي
                    M.toast({html: data.message});
                }
                btn.toggleClass("hide");
                btn.siblings(".preloader-wrapper").toggleClass("hide");
            },
            error: function () {
                voiceError.play();
                M.toast({html: "<span>" + lang("AnUnexpectedErrorOccurred", Cookies.get("lang")) + "<i class='material-icons red-text left'>close</i></span>"});
                btn.toggleClass("hide");
                btn.siblings(".preloader-wrapper").toggleClass("hide");
            }
        });
    });
    // تغيير الايميل
    $("[name='save_email']").on("click", function () {
        var email = $("[name='email']").val(),
            btn = $(this);
        $.ajax({
            url: "/profile/saveEmail",
            method: "POST",
            data: {save_email: true, email: email},
            beforeSend: function () {
                btn.toggleClass("hide");
                btn.siblings(".preloader-wrapper").toggleClass("hide");
            },
            success: function (data) {
                console.log(data);
                if ( data.status == "error" ) {
                    M.toast({html: data.message[0]});
                } else if ( data.status == "redirect" ) {
                    window.location = "/profile/confirmEmail";
                } else {
                    M.toast({html: data.message});
                }
                btn.toggleClass("hide");
                btn.siblings(".preloader-wrapper").toggleClass("hide");
            },
            error: function () {
                voiceError.play();
                M.toast({html: "<span>" + lang("AnUnexpectedErrorOccurred", Cookies.get("lang")) + "<i class='material-icons red-text left'>close</i></span>"});
                btn.toggleClass("hide");
                btn.siblings(".preloader-wrapper").toggleClass("hide");
            }
        });
    });
    // تغيير كلمة المرور
    $("[name='save_password']").on("click", function () {
        var password = $("[name='password']").val(),
            btn = $(this);
        $.ajax({
            url: "/profile/savePassword",
            method: "POST",
            data: {save_password: true, password: password},
            beforeSend: function () {
                btn.toggleClass("hide");
                btn.siblings(".preloader-wrapper").toggleClass("hide");
            },
            success: function (data) {
                if ( data.status == "error" ) {
                    M.toast({html: data.message[0]});
                } else {
//                    $(".nikeName").text(username); // تغير الاسم الشخصي
                    M.toast({html: data.message});
                }
                btn.toggleClass ("hide");
                btn.siblings(".preloader-wrapper").toggleClass("hide");
            },
            error: function () {
                voiceError.play();
                M.toast({html: "<span>" + lang("AnUnexpectedErrorOccurred", Cookies.get("lang")) + "<i class='material-icons red-text left'>close</i></span>"});
                btn.toggleClass("hide");
                btn.siblings(".preloader-wrapper").toggleClass("hide");
            }
        });
    });
    // تغيير الصورة الشخصية
    $("[name='myImg']").on("change", function (e) {
        var fileName = e.target.files[0],
            typeFile = fileName.type.split("/"),
            sizeFile = Math.round((fileName.size / 1024) / 1024, 2);
        var typeAllow = ["jpg", "png", "jpeg", "gif", "mp4"];
        if ( sizeFile > 10 ) {
            M.toast({html: "<span>" + lang("messageSizeFileImg", Cookies.get("lang")) + "<i class='material-icons red-text left'>close</i></span>"});
        } else if ( typeAllow.indexOf(typeFile[typeFile.length - 1]) < 0 ) {
            M.toast({html: "<span>" + lang("messageAllowFileMyImg", Cookies.get("lang")) + "<i class='material-icons red-text left'>close</i></span>"});
        } else {
            $("#sendMyImg").click();
        }
    });
    
    $("#formMyImg").submit(function (e) {
        var progress = $('#loading-upload .progress .determinate');
            progress.width("0%");
        e.preventDefault();
        $(this).ajaxSubmit({
            url: "/profile/editMyImg",
            method: "POST",
            data: {editMyImg: true},
            beforeSend: function () {
                 $("#loading-upload").modal("open");
             },
             uploadProgress: function(event, position, total, percentageComplete){
                 if ( percentageComplete > 20 &&  percentageComplete < 30 ) {
                     progress.animate({
                         width: percentageComplete + "%"
                     }, 200);
                 }
                 if ( percentageComplete > 50 ) {
                     progress.animate({
                         width: percentageComplete + "%"
                     }, 200);
                 }
             },
            success: function (data) {
                $("#loading-upload").modal("close");
                M.toast({html: data.message});
                changeMyImg();
            },
            error: function () {
                voiceError.play();
                $("#loading-upload").modal("close");
                M.toast({html: "<span>" + lang("AnUnexpectedErrorOccurred", Cookies.get("lang")) + "<i class='material-icons red-text left'>close</i></span>"});
            }
        });
    });
    changeMyImg();
    function changeMyImg() {
        $.ajax({
            url: "/profile/changeMyImg",
            method: "POST",
            data: {myImg: true},
            beforeSend: function () {
                
            },
            success: function(data) {
                var str = data.message;
                $("#myImg").attr("src", str.replace("%20", " "));
                $(".img-nav").attr("src", str.replace("%20", " "));
            },
            error: function () {
                voiceError.play();
                M.toast({html: "<span>" + lang("AnUnexpectedErrorOccurred", Cookies.get("lang")) + "<i class='material-icons red-text left'>close</i></span>"});
            }
        });
    }
    

});
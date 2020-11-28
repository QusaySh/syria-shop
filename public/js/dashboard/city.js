$(document).ready(function (){
    
    $(".delete_city").on("click", function () {
        var id = $(this).data("id"),
            btn = $(this);
        alertify.confirm(lang("deleteCity",Cookies.get('lang')), lang("meessageDelete",Cookies.get('lang')),
        function(){
            $.ajax({
                url: "/dashboard/deleteCity",
                method: "POST",
                data: {delete: true, id: id},
                beforeSend: function () {
                    M.toast({html: "<span>" + lang("waiteSaveAds", Cookies.get("lang")) + "<i class='material-icons green-text left'>autorenew</i></span>"});
                },
                success: function (data) {
                    voiceDelete.play();
                    M.toast({html: data.message});
                    btn.parents("tr").fadeOut(); // اخفاء السجل الذي حذف
                },
                error: function () {
                    voiceError.play();
                    M.toast({html: "<span>" + lang("AnUnexpectedErrorOccurred", Cookies.get("lang")) + "<i class='material-icons red-text left'>close</i></span>"});
                }
            });
        } , function(){
            alertify.error(lang("operationCanceled",Cookies.get('lang')))
        });
    }); 
    // عند الضغط على زر اضافة
    $("[href='#modalAddCity'").on("click", function () {        
        $("form [name='country_name']").val("");
    });
    // عند الضغط على زر تعديل
    $(".edit_city").on("click", function () {
        $(".formEditCity .file-path").val(""); // لتصفير ملف الرفع
        $(".formEditCity [type='file']").val("");
        
        var btn = $(this),
            id = btn.data("id");
            $(".formEditCity").data("cityId", id); // وضع المعرف في زر الحفظ
        $.ajax({
            url: "/dashboard/getCityById",
            method: "POST",
            data: {getCity: true, id: id},
            beforeSend: function () {
                btn.text("cached");
            },
            success: function (data) {
                if ( data.status == "success" ) {
                    
                    $("#modalEditCity").modal("open");
                    $(".formEditCity [name='city_name']").val(data.message.location_name);
                    $(".formEditCity [name='country_name']").val(data.message.country_name);
                } else {
                    voiceError.play();
                    M.toast({html: data.message});
                }
                btn.text("edit");
            },
            error: function () {
                voiceError.play();
                M.toast({html: "<span>" + lang("AnUnexpectedErrorOccurred", Cookies.get("lang")) + "<i class='material-icons red-text left'>close</i></span>"});
                btn.text("edit");
            }
        });
    });
    // فورم الاضافة
    $("form.formAddCity").on("submit", function(e) {
        e.preventDefault();
        var city_name = $("form.formAddCity [name='city_name']").val(),
            country_name = $("form.formAddCity [name='country_name']").val();
            
            var progress = $('#modalAddCity .progress .determinate');
            progress.width("0%");
            $(this).ajaxSubmit({
                url: "/dashboard/addCity",
                method: "POST",
                data: {addCity: true, city_name: city_name, country_name: country_name},
                beforeSend: function () {
                    progress.parent().fadeIn();
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
                    if ( data.status == "error" ) {
                        voiceError.play();
                        M.toast({html: data.message[0]});
                    } else {
                        M.toast({html: data.message});
                        voiceAdd.play();
                        setTimeout(function () {
                            window.location.href = "/dashboard/city/1";
                        }, 800);
                    }
                    progress.parent().fadeOut();
                },
                error: function () {
                    progress.parent().hide();
                    M.toast({html: "<span>" + lang("AnUnexpectedErrorOccurred", Cookies.get("lang")) + "<i class='material-icons red-text left'>close</i></span>"});
                },
                //resetForm: true,
            });
    });
    // فورم التعديل
    $("form.formEditCity").on("submit", function(e) {
        e.preventDefault();
        var country_name = $("form.formEditCity [name='country_name']").val(),
            city_name = $("form.formEditCity [name='city_name']").val(),
            progress = $('#modalEditCity .progress .determinate'),
            id = $(this).data("cityId");
            progress.width("0%");
            $(this).ajaxSubmit({
                url: "/dashboard/editCity",
                method: "POST",
                data: {editCity: true, cityId: id, city_name: city_name, country_name: country_name},
                beforeSend: function () {
                    progress.parent().fadeIn();
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
                    if ( data.status == "error" ) {
                        voiceError.play();
                        M.toast({html: data.message[0]});
                    } else {
                        M.toast({html: data.message});
                        voiceAdd.play();
                        setTimeout(function () {
                            window.location.href = "/dashboard/city/1";
                        }, 800);
                    }
                    progress.parent().fadeOut();
                },
                error: function () {
                    voiceError.play();
                    progress.parent().hide();
                    M.toast({html: "<span>" + lang("AnUnexpectedErrorOccurred", Cookies.get("lang")) + "<i class='material-icons red-text left'>close</i></span>"});
                },
                //resetForm: true,
            });
    });
    
});
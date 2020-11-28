$(document).ready(function (){
    
    $(".delete_country").on("click", function () {
        var id = $(this).data("id"),
            btn = $(this);
        alertify.confirm(lang("deleteCountry",Cookies.get('lang')), lang("meessageDelete",Cookies.get('lang')),
        function(){
            $.ajax({
                url: "/dashboard/deleteCountry",
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
    $("[href='#modalAddCountry'").on("click", function () {        
        $("form [name='country_name']").val("");
    });
    // عند الضغط على زر تعديل
    $(".edit_country").on("click", function () {
        $(".formEditCountry .file-path").val(""); // لتصفير ملف الرفع
        $(".formEditCountry [type='file']").val("");
        
        var btn = $(this),
            id = btn.data("id");
            $(".formEditCountry").data("countryId", id); // وضع المعرف في زر الحفظ
        $.ajax({
            url: "/dashboard/getCountryById",
            method: "POST",
            data: {getCountry: true, id: id},
            beforeSend: function () {
                btn.text("cached");
            },
            success: function (data) {
                if ( data.status == "success" ) {
                    $("#modalEditCountry").modal("open");
                    $(".formEditCountry [name='country_name']").val(data.message.location_name);
                    $(".formEditCountry [name='country_key']").val(data.message.location_number);
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
    $("form.formCountry").on("submit", function(e) {
        e.preventDefault();
        var country_name = $("form.formCountry [name='country_name']").val();
            var progress = $('#modalAddCountry .progress .determinate');
            progress.width("0%");
            $(this).ajaxSubmit({
                url: "/dashboard/addCountry",
                method: "POST",
                data: {addCountry: true, country_name: country_name},
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
                        voiceAdd.play();
                        M.toast({html: data.message});
                        setTimeout(function () {
                            window.location.href = "/dashboard/country/1";
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
    // فورم التعديل
    $("form.formEditCountry").on("submit", function(e) {
        e.preventDefault();
        var country_name = $("form.formEditCountry [name='country_name']").val(),
            progress = $('#modalEditCountry .progress .determinate'),
            id = $(this).data("countryId");
            progress.width("0%");
            $(this).ajaxSubmit({
                url: "/dashboard/editCountry",
                method: "POST",
                data: {editCountry: true, countryId: id, country_name: country_name},
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
                        voiceAdd.play();
                        M.toast({html: data.message});
                        setTimeout(function () {
                            window.location.href = "/dashboard/country/1";
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
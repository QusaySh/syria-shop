$(document).ready(function () {
    
    function s(){
        var the_element  = $(".price, .discount, .item_price");
        if ( $(".choose-type-ads").val() == 2 ) { // بيع
            the_element.removeClass("hide");
        } else {
            the_element.addClass("hide");
        }
    }
    // عند اختيار بيع
    s();
    $(".choose-type-ads").change(function () {
        s();
    });
    
    // لاظهار شكل الاعلان
    $("#item_name").keyup(function () {
        $("." + $(this).attr("id")).text($(this).val());
    });
    $("#item_description").keyup(function () {
        $("." + $(this).attr("id")).text($(this).val());
    });
    $("#item_price").keyup(function () {
        $("." + $(this).attr("id")).text($(this).val() + " SY");
    });
    $("#item_location").change(function () {
        $("." + $(this).attr("id")).text($(this).val());
    });
    $("#discount").change(function () {
        var disc = document.getElementById("discount");
        if ( disc.checked ) {
            $(".icon-discount").removeClass("hide");
        } else {
            $(".icon-discount").addClass("hide");
        }
    });
    // التحقق من اختيار الصور والفيديوهات
    $("#item_media").change(function (e) {
         var fileName = e.target.files;
         // fileName[0].name
         if ( fileName.length > 7 ) {
            M.toast({html: "<span>" + lang("messageCountFile", Cookies.get("lang")) + "<i class='material-icons red-text left'>close</i></span>"});
         } else {
            for ( var i = 0; i < fileName.length; i++ ) {
                var typeFile = fileName[i].type.split("/");
                var sizeFile = Math.round((fileName[i].size / 1024) / 1024, 2);
                var typeAllow = ["jpg", "png", "jpeg", "gif", "mp4"];
                if ( typeAllow.indexOf(typeFile[typeFile.length - 1]) < 0 ) {
                    M.toast({html: "<span>" + lang("messageAllowFile", Cookies.get("lang")) + "<i class='material-icons red-text left'>close</i></span>"});
                } else if ( typeFile[typeFile.length - 1] == "mp4" ) {
                    if ( sizeFile > 40 ) {
                        M.toast({html: "<span>" + lang("messageSizeFileVideo", Cookies.get("lang")) + "<i class='material-icons red-text left'>close</i></span>"});
                    }
                } else {
                    if ( sizeFile > 10 ) {
                        M.toast({html: "<span>" + lang("messageSizeFileImg", Cookies.get("lang")) + "<i class='material-icons red-text left'>close</i></span>"});
                    }
                }
            }
         }
    });
    
    // تعديل اعلان
    $("form.addAdsForm").on("submit", function(e) {
        e.preventDefault();
        var key_hash = $(this).data("key"),
            id = $(this).data("id"),
            item_name = $("[name='item_name']").val(),
            item_description = $("[name='item_description']").val(),
            item_price = $("[name='item_price']").val(),
            tags = $("[name='tags']").val(),
            item_type = $("[name='item_type']").val(),
            phoneuser = $("[name='phoneuser']").val(),
            whatsapp = $("[name='whatsapp']").val(),
            item_location = $("[name='item_location']").val(),
            cat_id = $("[name='cat_id']").val();
            var disc = document.getElementById("discount");
            if ( disc.checked ) {
                var discount = 1;
            } else {
                var discount = 2;
            }
            var progress = $('#loading-upload .progress .determinate');
            progress.width("0%");
            $(this).ajaxSubmit({
                url: "/newAds/updateAds",
                method: "POST",
                data: {sendAds: true, key_hash : key_hash, id: id, item_name: item_name, item_description: item_description, item_price: item_price,
                        tags: tags, item_type: item_type, phoneuser: phoneuser, whatsapp: whatsapp,
                        item_location: item_location, cat_id: cat_id, discount: discount},
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
                    if ( data.status == "error" ) {
                        M.toast({html: data.message[0]});
                    } else {
                        voiceAdd.play();
                        M.toast({html: data.message});
                        //window.location = "/client/default";
                    }
                    $("#loading-upload").modal("close");
                },
                error: function () {
                    voiceError.play();
                    $("#loading-upload").modal("close");
                    M.toast({html: "<span>" + lang("AnUnexpectedErrorOccurred", Cookies.get("lang")) + "<i class='material-icons red-text left'>close</i></span>"});
                },
                resetForm: true,
            });
    });
    
    // حذف صورة من المنتج
    $(".btn-delete").on("click", function () {
        var filename = $(this).data("filename"),
            keyAds = $(".media").data("key"),
            btn = $(this),
            media = $(this).parents(".attachment");
            
        alertify.confirm(lang("deleteTheAttachment", Cookies.get("lang")), lang("meessageDelete", Cookies.get("lang")), function(){
            
            $.ajax({
                url: "/newAds/deleteMedia",
                method: "POST",
                data: {deleteMedia: true, key: keyAds, filename: filename},
                beforeSend: function () {
                    btn.text("autorenew");
                },
                success: function (data) {
                    btn.text("delete");
                    media.fadeOut();
                    M.toast({html: data.message});
                },
                error: function () {
                    voiceError.play();
                    btn.text("delete");
                    M.toast({html: "<span>" + lang("AnUnexpectedErrorOccurred", Cookies.get("lang")) + "<i class='material-icons red-text left'>close</i></span>"});
                }
            });
        } , function(){
            alertify.error(lang("operationCanceled", Cookies.get("lang")));
        });
        
    });
    
});
$(document).ready(function (){
    
    $(".delete_cat").on("click", function () {
        var id = $(this).data("id"),
            btn = $(this);
        alertify.confirm(lang("deleteCat",Cookies.get('lang')), lang("meessageDelete",Cookies.get('lang')),
        function(){
            $.ajax({
                url: "/dashboard/deleteCategories",
                method: "POST",
                data: {delete: true, id: id},
                beforeSend: function () {
                    M.toast({html: "<span>" + lang("waiteSaveAds", Cookies.get("lang")) + "<i class='material-icons green-text left'>autorenew</i></span>"});
                },
                success: function (data) {
                    M.toast({html: data.message});
                    voiceDelete.play();
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
    $("[href='#modalAddCat'").on("click", function () {        
        $("form [name='categorie_name']").val("");
    });
    // عند الضغط على زر تعديل
    $(".edit_cat").on("click", function () {
        $(".formEditCat .file-path").val(""); // لتصفير ملف الرفع
        $(".formEditCat [type='file']").val("");
        
        var btn = $(this),
            id = btn.data("id");
            $(".formEditCat").data("catId", id); // وضع المعرف في زر الحفظ
        $.ajax({
            url: "/dashboard/getCatById",
            method: "POST",
            data: {getCat: true, id: id},
            beforeSend: function () {
                btn.text("cached");
            },
            success: function (data) {
                if ( data.status == "success" ) {
                    $("#modalEditCat").modal("open");
                    $(".formEditCat [name='EditCategorie_name']").val(data.message.categorie_name);
                    $(".formEditCat [name='EditCategorie_description']").val(data.message.categorie_description);
                    $(".formEditCat [name='EditCategorie_parent']").val(data.message.categorie_parent);
                } else {
                    M.toast({html: data.message});
                    voiceError.play();
                }
                btn.text("edit");
            },
            error: function () {
                M.toast({html: "<span>" + lang("AnUnexpectedErrorOccurred", Cookies.get("lang")) + "<i class='material-icons red-text left'>close</i></span>"});
                btn.text("edit");
                voiceError.play();
            }
        });
    });
    // فورم الاضافة
    $("form.formCat").on("submit", function(e) {
        e.preventDefault();
        var categorie_name = $("form.formCat [name='categorie_name']").val(),
            categorie_parent = $("form.formCat [name='categorie_parent']").val();
            var progress = $('#modalAddCat .progress .determinate');
            progress.width("0%");
            $(this).ajaxSubmit({
                url: "/dashboard/addCategories",
                method: "POST",
                data: {addCat: true, categorie_name: categorie_name, categorie_parent: categorie_parent},
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
                        M.toast({html: data.message[0]});
                        voiceError.play();
                    } else {
                        M.toast({html: data.message});
                        voiceAdd.play();
                        setTimeout(function () {
                            window.location.href = "/dashboard/categories/1";
                        }, 800);
                    }
                    progress.parent().fadeOut();
                },
                error: function () {
                    progress.parent().hide();
                    voiceError.play();
                    M.toast({html: "<span>" + lang("AnUnexpectedErrorOccurred", Cookies.get("lang")) + "<i class='material-icons red-text left'>close</i></span>"});
                },
                //resetForm: true,
            });
    });
    // فورم التعديل
    $("form.formEditCat").on("submit", function(e) {
        e.preventDefault();
        var categorie_name = $("form.formEditCat [name='EditCategorie_name']").val(),
            categorie_parent = $("form.formEditCat [name='EditCategorie_parent']").val();
            progress = $('#modalEditCat .progress .determinate'),
            id = $(this).data("catId");
            progress.width("0%");
            $(this).ajaxSubmit({
                url: "/dashboard/editCategories",
                method: "POST",
                data: {editCat: true, catId: id, categorie_name: categorie_name, categorie_parent: categorie_parent},
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
                        M.toast({html: data.message[0]});
                        voiceError.play();
                    } else {
                        M.toast({html: data.message});
                        voiceAdd.play();
                        setTimeout(function () {
                            window.location.href = "/dashboard/categories/1";
                        }, 800);
                    }
                    progress.parent().fadeOut();
                },
                error: function () {
                    progress.parent().hide();
                    voiceError.play();
                    M.toast({html: "<span>" + lang("AnUnexpectedErrorOccurred", Cookies.get("lang")) + "<i class='material-icons red-text left'>close</i></span>"});
                },
                //resetForm: true,
            });
    });
    
});
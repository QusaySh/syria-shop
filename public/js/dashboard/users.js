$(document).ready(function () {
    
    $(".delete_user").on("click", function () {
        var id = $(this).data("id"),
            btn = $(this);
        alertify.confirm(lang("deleteUser",Cookies.get('lang')), lang("meessageDelete",Cookies.get('lang')),
        function(){
            $.ajax({
                url: "/dashboard/deleteUser",
                method: "POST",
                data: {delete: true, idUser: id},
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
    $(".block_user").on("click", function () {
        var id = $(this).data("id"),
            btn = $(this),
            titleConfirm = btn.text().trim() == "block" ? "blockUser" : "unBlockUser",
            bodyConfirm = btn.text().trim() == "block" ? "meessageBlock" : "meessageUnBlock";
        alertify.confirm(lang(titleConfirm,Cookies.get('lang')), lang(bodyConfirm,Cookies.get('lang')),
        function(){
            $.ajax({
                url: "/dashboard/blockUser",
                method: "POST",
                data: {block: true, idUser: id},
                beforeSend: function () {
                    M.toast({html: "<span>" + lang("waiteSaveAds", Cookies.get("lang")) + "<i class='material-icons green-text left'>autorenew</i></span>"});
                },
                success: function (data) {
                    voiceDelete.play();
                    M.toast({html: data.message});
                    btn.text(data.icon);
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
    $(".type_user").on("click", function () {
            var id = $(this).data("id"),
                btn = $(this),
                icon = $(this).parent("td").siblings("td").children("i#permUser");
                bodyConfirm = btn.text().trim() == "security" ? "meessagePermissions" : "meessageUnPermissions";
            alertify.confirm(lang("typeUser",Cookies.get('lang')), lang(bodyConfirm,Cookies.get('lang')),
            function(){
                $.ajax({
                    url: "/dashboard/typeUser",
                    method: "POST",
                    data: {typeUser: true, idUser: id},
                    beforeSend: function () {
                        M.toast({html: "<span>" + lang("waiteSaveAds", Cookies.get("lang")) + "<i class='material-icons green-text left'>autorenew</i></span>"});
                    },
                    success: function (data) {
                        M.toast({html: data.message});
                        btn.text(data.icon);
                        if ( data.icon == "person" ) {
                            icon.text("security");
                        } else  {
                            icon.text("person");
                        }
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
    
});
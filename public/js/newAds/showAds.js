$(document).ready(function () {
    $('.fixed-action-btn').floatingActionButton({hoverEnabled: false, direction: "bottom"});
    
    // زر الحذف
    $(".container-showAds .fixed-action-btn .btn-delete").on("click", function () {
        var key = $(".container-showAds").data("key");
            alertify.confirm(lang("deleteTheAttachment", Cookies.get("lang")), lang("meessageDelete", Cookies.get("lang")), function(){
                $.ajax({
                    url: "/newAds/deleteAds",
                    method: "POST",
                    data: {deleteAds: true, key: key},
                    beforeSend: function () {
                        M.toast({html: "<span>" + lang("watingDelete", Cookies.get("lang")) + "<i class='material-icons green-text left'>delete</i></span>", displayLength: 2000});
                    },
                    success: function (data) {
                        M.toast({html: data.message});
                        window.location = "/client/default";
                    },
                    error: function () {
                        M.toast({html: "<span>" + lang("AnUnexpectedErrorOccurred", Cookies.get("lang")) + "<i class='material-icons red-text left'>close</i></span>"});
                    }
                });
            }, function(){
                alertify.error(lang("operationCanceled", Cookies.get("lang")));
            });
    });
    // زر الحفظ
    $(".container-showAds .fixed-action-btn .btn-save").on("click", function () {
        var key = $(".container-showAds").data("key"),
            btn = $(this).children("i");
        $.ajax({
            url: "/newAds/saveAds",
            method: "POST",
            data: {save_ads: true, key: key},
            beforeSend: function () {
                M.toast({html: "<span>" + lang("waiteSaveAds", Cookies.get("lang")) + "<i class='material-icons green-text left'>autorenew</i></span>"});
            },
            success: function (data) {
                voiceAdd.play();
                M.toast({html: data.message});
                var icon = data.status == "add" ? "remove" : "save";
                btn.text(icon);
            },
            error: function () {
                voiceError.play();
                M.toast({html: "<span>" + lang("AnUnexpectedErrorOccurred", Cookies.get("lang")) + "<i class='material-icons red-text left'>close</i></span>"});   
            }
        });
    });
    $("#reports .send-report").on("click", function () {
        var id = $(".container-showAds .btn-report").parents(".container-showAds").data("id"),
            key = $(".container-showAds .btn-report").parents(".container-showAds").data("key"),
            report_text = $("#reports textarea").val();
        $.ajax({
            url: "/newAds/reportItem",
            method: "POST",
            data: {report: true, report_text: report_text, id: id, key: key},
            beforeSend: function () {
                
            },
            success: function (data) {
                voiceAdd.play();
                M.toast({html: data.message});
                if ( data.status == "success" ) {
                    $("#reports").modal("close");
                }
            },
            error: function () {
                voiceError.play();
                M.toast({html: "<span>" + lang("AnUnexpectedErrorOccurred", Cookies.get("lang")) + "<i class='material-icons red-text left'>close</i></span>"});   
            }
        });
    });
});
$(document).ready(function () {
    $(".delete_item").on("click", function () {
        var key = $(this).data("key"),
            btn = $(this);
            alertify.confirm(lang("deleteAds", Cookies.get("lang")), lang("meessageDelete", Cookies.get("lang")), function(){
                $.ajax({
                    url: "/newads/deleteAds",
                    method: "POST",
                    data: {deleteAds: true, key: key},
                    beforeSend: function () {
                        M.toast({html: "<span>" + lang("watingDelete", Cookies.get("lang")) + "<i class='material-icons green-text left'>delete</i></span>", displayLength: 2000});
                    },
                    success: function (data) {
                        voiceDelete.play();
                        btn.parents("tr").fadeOut();
                        M.toast({html: data.message});
                    },
                    error: function () {
                        voiceError.play();
                        M.toast({html: "<span>" + lang("AnUnexpectedErrorOccurred", Cookies.get("lang")) + "<i class='material-icons red-text left'>close</i></span>"});
                    }
                });
            }, function(){
                alertify.error(lang("operationCanceled", Cookies.get("lang")));
            });
    });
});
$(document).ready(function () {
    $(".delete_report").on("click", function () {
        var id = $(this).data("id"),
            btn = $(this);
            alertify.confirm(lang("deleteReport", Cookies.get("lang")), lang("meessageDelete", Cookies.get("lang")), function(){
                $.ajax({
                    url: "/dashboard/deleteReport",
                    method: "POST",
                    data: {deleteReport: true, id: id},
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
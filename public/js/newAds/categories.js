$(document).ready(function () {
    $('.alarm').on("click", function () {
        var cat_id = $(this).data("catid"),
            alarm = $(this);
            var titleAlarm = alarm.text() == "alarm_off" ? "titleDisableAlarm" : "titleEnableAlarm";
            var bodyAlarm = alarm.text() == "alarm_off" ? "bodyDisableAlarm" : "bodyEnableAlarm";
        alertify.confirm(lang(titleAlarm, Cookies.get("lang")), lang(bodyAlarm, Cookies.get("lang")), function(){
            $.ajax({
                url: "/newAds/enableAlarm",
                method: "POST",
                data: {setAlarm: true, cat_id: cat_id},
                beforeSend: function () {
                    M.toast({html: "<span>" + lang("waiteSaveAds", Cookies.get("lang")) + "<i class='material-icons green-text left'>autorenew</i></span>"});
                },
                success: function (data) {
                    M.toast({html: data.message });
                    var text = data.status == "add" ? "alarm_off" : "alarm_on";
                    alarm.text(text);
                },
                error: function () {
                    voiceError.play();
                    M.toast({html: "<span>" + lang("AnUnexpectedErrorOccurred", Cookies.get("lang")) + "<i class='material-icons red-text left'>close</i></span>"});   
                }
            });
        } , function(){
            alertify.error(lang("operationCanceled", Cookies.get("lang")))
        });
    });
});
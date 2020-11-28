lang = function(words, lang = "ar") {
        var ar = {
                // Global
                AnUnexpectedErrorOccurred: "حدث خطأ غير متوقع",
                operationCanceled: "تم الغاء العملية",
                waiteSaveAds: "يرجى الانتظار",
                waiteReload: "جار اعادة تحميل الصفحة",
            
                faildSendMessage: "فشل ارسال الرسالة",
                messageCountFile: "اقصى عدد للملفات هو 7 ",
                messageAllowFile: "الملفات المسموحة هي png - jpg - jpeg - gif - mp4",
                messageAllowFileMyImg: "الملفات المسموحة هي png - jpg - jpeg - gif",
                messageSizeFileVideo: "حجم الفيديو يجب ان لا يتعدى ال 40 ميغا",
                messageSizeFileImg: "حجم الصورة يجب ان لا يتعدى ال 10 ميغا",
                notFoundAds: "لايوجد اعلانات حالياً",
                today: "اليوم",
                yesterday: "امس",
                twodays: "منذ يومين",
                watingDelete: "جار الحذف يرجى الانتظار...",
                deleteTheAttachment: "حذف المرفق",
                deleteAds: "حذف الاعلان",
                meessageDelete: "هل انت متأكد من الحذف؟",
                meessageBlock: "هل انت متأكد من الحظر؟",
                meessageUnBlock: "هل انت متأكد من فك الحظر؟",
                meessagePermissions: "هل انت متأكد من اعطاء اذن الادمن؟",
                meessageUnPermissions: "هل انت متأكد من الغاء اذن الادمن؟",
                titleEnableAlarm: "تفعيل التنبيه",
                titleDisableAlarm: "إلغاء تفعيل التنبيهات",
                bodyEnableAlarm: "هل تريد تفعيل التنبيهات لهذا القسم؟",
                bodyDisableAlarm: "هل تريد إلغاء تفعيل التنبيهات لهذا القسم؟",
                deleteUser: "حذف مستخدم",
                blockUser: "حظر مستخدم",
                unBlockUser: "فك حظر المستخدم",
                typeUser: "اذونات المستخدم",
                deleteCountry: "حذف بلد",
                deleteCity: "حذف مدينة",
                deleteCat: "حذف فئة",
                deleteReport: "حذف ابلاغ"
            };

            var en = {
                // Global
                AnUnexpectedErrorOccurred: "An Unexpected Error Occurred",
                operationCanceled: "Operation canceled",
                waiteSaveAds: "Please Wait",
                waiteReload: "Reloading page",
                
                faildSendMessage: "Failed To Send The Message",
                messageCountFile: "The Maximum Number Of Files Is 7",
                messageAllowFile: "Allowed files are png - jpg - jpeg - gif - mp4",
                messageAllowFileMyImg: "Allowed files are png - jpg - jpeg - gif",
                messageSizeFileVideo: "Video size should not exceed 40 MB",
                messageSizeFileImg: "Image size should not exceed 10 MB",
                notFoundAds: "There are currently no ads",
                today: "Today",
                yesterday: "Yesterday",
                twodays: "Two Days Ago",
                watingDelete: "Deleting, please wait ...",
                deleteTheAttachment: "Delete The Attachment",
                deleteAds: "Delete Ads",
                meessageDelete: "Are You Sure You Want To Delete?",
                meessageUnBlock: "Are You Sure About The Ban?",
                meessagePermissions: "Are you sure you want give him the manager permission",
                meessageUnPermissions: "Are you sure you want cancel him the manager permission",
                titleEnableAlarm: "Activate The Alarm",
                bodyEnableAlarm: "Do You Want To Activate Alerts For This Section?",
                deleteUser: "Delete A User",
                blockUser: "Block A User",
                unBlockUser: "Unblock The User",
                typeUser: "User permissions",
                deleteCountry: "Delete A Country",
                deleteCity: "Delete A City",
                deleteCat: "Delete A Categorie",
                deleteReport: "Delete A Report"
            };

        switch (lang) {
            case "ar": return ar[words]; break;
            case "en": return en[words]; break;
            default : return ar[words]; break;
        }
    }
    
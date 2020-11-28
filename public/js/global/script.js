$(document).ready(function(){
    var voicePageMain = document.getElementById("voicePageMain"),
        voiceAdd = document.getElementById("voiceAdd"),
        voiceDelete = document.getElementById("voiceDelete");
        
    // select theme
    if ( !Cookies.get("theme") ) {
        Cookies.set("theme", "normal", { expires: 30 });
        $(this).children("i").text("brightness_3");
    }
    $(".selectTheme").on("click", function () {
        if ( Cookies.get("theme") == "normal" ) {
            Cookies.set("theme", "dark", { expires: 30 });
            $(this).children("i").text("brightness_5");
            location.reload();
        } else {
            $(this).children("i").text("brightness_3");
            Cookies.set("theme", "normal", { expires: 30 });
            location.reload();
        }
    });
    
    // عرض زر اخدث الاعلانات
    $(window).scroll(function () {
        if (window.scrollY >= 600) {
            $('.showLastAds').fadeIn();
        } else {
            $('.showLastAds').fadeOut();
        }
    });
    $('.showLastAds').on("click", function () {
        M.toast({html: "<span>" + lang("waiteReload", Cookies.get("lang")) + "<i class='material-icons green-text left'>autorenew</i></span>"});
        $('html, body').animate({
            scrollTop: 0
        }, 400, function () {
            location.reload();
        });
    });
    
    $('.sidenav').sidenav({edge: "right"});
    $('.fixed-action-btn').floatingActionButton({hoverEnabled: false});
    $('input.input_text, textarea.input_text').characterCounter();
    $('select').formSelect();
    $('.carousel').carousel({fullWidth: true,indicators: true});
    $('.modal').modal();
    $('.materialboxed').materialbox();
    $('.tabs').tabs();
    $('.collapsible').collapsible();
    $('.tooltipped').tooltip({inDuration: 250,outDuration: 150, transitionMovement: 5});
    $('.dropdown-trigger').dropdown();
    
    // عارض الصور
    lightGallery(document.getElementById('lightgallery'));
    // اظهار قائمة المزيد
    $("nav .more").on("click", function () {
        $(this).next(".dropdown").slideToggle("fast");
    });
    $("nav .dropdown .link-drop").on("click", function () {
        $(this).siblings(".dropdown-link-drop").slideToggle("fast");
    });

    // اظهار كلمة المرور
    $(".icon-eye").on("click", function () {
        $(this).toggleClass("show");
        if ( $(this).hasClass("show") ) {
            $(this).siblings("input").attr("type", "text").end().text("visibility_off");
        } else {
            $(this).siblings("input").attr("type", "password").end().text("visibility");;
        }
    });
    
    // اظهار مربع البحث
    $(".container-search .show-search").on("click", function () {
        var btn = $(this);
        btn.toggleClass("is-show");
        if ( btn.hasClass("is-show") ) {
            btn.parent(".container-search").animate({
                top: 0
            }, 400, function () {
                btn.siblings("form").children("input[type='search']").focus();
            });
        } else {
            btn.parent(".container-search").animate({
                top: "-49px"
            }, 300);
        }
    });
    
    // زر البحث
    var btnSearch = $(".container-search [name='submitSearch']");
    $(btnSearch).on("click", function (e) {
        e.preventDefault();
        $(btnSearch).attr("href", $(".container-search input[type='search']").val());
        window.location = "/newAds/search/1/?s=" + $(this).attr("href");
    });
    // عند الضغط على زر البحث في الكيبورد
    $(".container-search form").submit(function (e) {
        e.preventDefault();
        btnSearch.click();
    });
    // عند الكابة في مربع البحث
    $(".container-search [type='search']").on("keyup", function () {
        $.ajax({
            url: "/newAds/getTags",
            method: "POST",
            data: {tags: $(this).val()},
            beforeSend: function () {
                
            },
            success: function (data) {
                var arrayTags = [];
                // استخراج التاغ ووضعهم في مصفوفة
                for ( var i = 0; i < data.message.length; i++ ) {
                    var tag = data.message[i].tags.split("+");
                    for ( var j = 0; j < tag.length; j++ ) {
                        arrayTags.push(tag[j]);
                    }
                }
                // حذف التاغ المتكرر
                for ( var i = 0; i < arrayTags.length; i++ ) {
                    for ( var j = 0; j < arrayTags.length; j++ ) {
                        if ( arrayTags[i] == arrayTags[j + 1] ) {
                            arrayTags.splice(i, 1);
                        }
                    }
                }
                $(".container-tags-search ul").html("");
                for ( var i = 0; i < arrayTags.length; i++ ) {
                    var li = $("<li></li>").html("<a href='/newAds/search/1/?s=" + arrayTags[i] + "' class='collection-item'>" + arrayTags[i] + "</a>");
                    $(".container-tags-search ul").append(li);
                }
                if ( arrayTags.length != 0) {
                    console.log("yes");
                    $(".container-tags-search ul").parent().show();
                } else {
                    $(".container-tags-search ul").parent().hide();
                }
            },
            error: function () {
                M.toast({html: "<span>" + lang("AnUnexpectedErrorOccurred", Cookies.get("lang")) + "<i class='material-icons red-text left'>close</i></span>"});
            }
        });
    });
    
    // التحقق من حظر المستخدم
    $(".btn-more #add_ads").on("click", function (e) {
        e.preventDefault();
        $.ajax({
            url: "/client/checkBlock",
            method: "POST",
            success: function (data) {
                if ( data.status == true ) {
                    M.toast({html: data.message});
                } else {
                    window.location = "/newAds/";
                }
            },
            error: function () {
                M.toast({html: "<span>" + lang("AnUnexpectedErrorOccurred", Cookies.get("lang")) + "<i class='material-icons red-text left'>close</i></span>"});
            }
        });
    });
    
    $(".container-ads .fixed-action-btn .btn-delete").on("click", function () {
        var key = $(this).parents(".card-ads").data("key"),
            card = $(this).parents(".card-ads");
            alertify.confirm(lang("deleteAds", Cookies.get("lang")), lang("meessageDelete", Cookies.get("lang")), function(){
                $.ajax({
                    url: "/newAds/deleteAds",
                    method: "POST",
                    data: {deleteAds: true, key: key},
                    beforeSend: function () {
                        M.toast({html: "<span>" + lang("watingDelete", Cookies.get("lang")) + "<i class='material-icons green-text left'>delete</i></span>", displayLength: 2000});
                    },
                    success: function (data) {
                        card.fadeOut();
                        voiceDelete.play(); 
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
    $(".container-ads .fixed-action-btn .btn-save").on("click", function () {
        var key = $(this).parents(".card-ads").data("key"),
            btn = $(this).children("i"),
            card = $(this).parents(".card-ads"),
            inFave = $(this).hasClass("favorite") ? true : false; // في حال الضغط على الزر الموجود في الملف الشخصي
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
                if ( inFave ) {
                    card.fadeOut();
                }
            },
            error: function () {
                voiceError.play();
                M.toast({html: "<span>" + lang("AnUnexpectedErrorOccurred", Cookies.get("lang")) + "<i class='material-icons red-text left'>close</i></span>"});   
            }
        });
    });
    $("#reports .send-report").on("click", function () {
        var id = $(".container-ads .fixed-action-btn .btn-report").parents(".card-ads").data("id"),
            key = $(".container-ads .fixed-action-btn .btn-report").parents(".card-ads").data("key"),
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
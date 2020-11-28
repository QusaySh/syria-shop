<div class="container-showAds margin-top-30" data-id="<?= $ads->item_id ?>" data-key="<?= $ads->key_hash ?>">
    <div class="row">
        <div class="col s12 m7 l5 offset-l2">
            <div class="card-panel">
                <div class="row">
                    <div class="container-name-imgProfile">
                        <div class="right">
                            <?php
                                $path1 = "$system/images/";
                                $path2 = "$system/Picture Profile" . DS;
                                if ( $ads->user_type == "facebook" ) {
                                    $src = $ads->my_img;
                                } else {
                                    if ( $ads->my_img == "user.png" ) {
                                        $src = "$system/images/user.png";
                                    } else {
                                        $src = "$system/Picture Profile" . DS . $ads->my_img;
                                    }
                                }
                            ?>
                            <img class="img-profile circle materialboxed"
                                 src="<?= $src ?>" alt="<?= $ads->my_img ?>" />
                        </div>
                        <div class="right">
                            <h6 id="user-name"><?= $ads->username ?></h6>
                            <span id="ads-date">
                                <?php
                                    if ( isset($GLOBALS["lang"]) && $GLOBALS["lang"] == "ar" ) {
                                        switch ( $ads->day ) {
                                            case "Sunday": $day = "الأحد"; break;
                                            case "Monday": $day = "الأثنين"; break;
                                            case "Tuesday": $day = "الثلاثاء"; break;
                                            case "Wednesday": $day = "الأربعاء"; break;
                                            case "Thursday": $day = "الخميس"; break;
                                            case "Friday": $day = "الجمعة"; break;
                                            case "Saturday": $day = "السبت"; break;
                                        }
                                        $typeDay = str_replace(array("PM", "AM"), array("م", "ص"), substr($ads->item_add_date, -2, 2));
                                    } else {
                                        $day = $ads->day;
                                        $typeDay = substr($ads->item_add_date, -2, 2);
                                    }
                                    $min = $ads->min < 10 ? "0" . $ads->min : $ads->min;
                                    switch ( $ads->datedif ) {
                                        case 0: echo \syriashop\lib\Languages::lang("today", $GLOBALS["lang"])
                                            . " · " . $ads->hour . ":" . $min . " " . $typeDay;break;
                                        case 1: echo \syriashop\lib\Languages::lang("yesterday", $GLOBALS["lang"])
                                            . " · " . $ads->hour . ":" . $min . " " . $typeDay;break;
                                        case 2: echo \syriashop\lib\Languages::lang("twodays", $GLOBALS["lang"])
                                            . " · " . $ads->hour . ":" . $min . " " . $typeDay;break;
                                        case $ads->datedif > 2 && $ads->datedif < 8: echo $day . " · " . $ads->hour . ":" . $min . " " . $typeDay;break;
                                        default : echo $ads->year . "-" . $ads->month . "-" . $ads->day_num . " · " . $ads->hour . ":"
                                                . $min .  " " . $typeDay; break;
                                    }
                                ?>
                            </span>
                        </div>
                        <div>
                            <div class="fixed-action-btn">
                              <a class="btn-floating btn-small blue darken-2">
                                <i class="large material-icons">more_vert</i>
                              </a>
                                <ul>
                              <?php
                                  if ( isset($_SESSION["myInfo"]) && $ads->user_id == $_SESSION["myInfo"]["id"] ) {
                              ?>
                                <li><a class="btn-floating btn-small green btn-edit" href="/newAds/editAds/<?= $ads->key_hash ?>"><i class="material-icons">edit</i></a></li>
                              <?php } else { ?>
                                  <li class="tooltipped" data-position="top" data-tooltip="<?= \syriashop\lib\Languages::lang("report", $GLOBALS["lang"]) ?>"><a class="btn-floating btn-small red modal-trigger btn-report btn-report" href="#reports"><i class="material-icons">report</i></a></li>
                              <?php } ?>
                                <?php if ( isset($_SESSION["myInfo"]) && $ads->user_id == $_SESSION["myInfo"]["id"] || isset($_SESSION["myInfo"]["admin"]) ) { ?>
                                  <li><a class="btn-floating btn-small red btn-delete"><i class="material-icons">delete</i></a></li>
                                <?php } ?>
                              <?php
                                  if ( isset($_SESSION["myInfo"]) && $ads->user_id != $_SESSION["myInfo"]["id"] ) {
                                      $idItem = explode(",", $ads->favorite);
                                      $iconSave = in_array($ads->item_id, $idItem) ? "remove" : "save";
                                  }
                              ?>
                            <?php
                                if ( isset($_SESSION["myInfo"]) && $ads->user_id != $_SESSION["myInfo"]["id"] ) {
                                    $idItem = explode(",", $ads->favorite);
                                    $iconSave = in_array($ads->item_id, $idItem) ? "remove" : "save";
                            ?>
                                    <li class="tooltipped" data-position="top" data-tooltip="<?= \syriashop\lib\Languages::lang("save", $GLOBALS["lang"]) ?>"><a class="btn-floating btn-small green btn-save"><i class="material-icons"><?= $iconSave ?></i></a></li>
                            <?php
                                }
                            ?>
                                </ul>
                            </div>
                        </div>
                        <div class="clear"></div>
                        <div class="">
                            <h5 class="break"><?= $ads->item_name ?></h5>
                            <p class="break"><?= $ads->item_description ?></p>
                            <div id="media">
                                <div>
                                    <?php
                                        $media = explode(",", $ads->item_media);
                                    ?>
                                    <ul id="lightgallery" class="row">
                                        <?php
                                            foreach ( $media as $m ) {
                                        ?>
                                            <?php
                                            if ( empty($m) ) {
                                                echo "<a href='$system/images/notMedia-{$GLOBALS["lang"]}.jpg'><li class='col s6 m4'>";
                                            ?>
                                                <img src="<?= $system ?>/images/notMedia-<?= $GLOBALS["lang"] ?>.jpg" alt="notMedia">
                                            <?php
                                                echo "</li></a>";
                                            } else {
                                                if (pathinfo($m, PATHINFO_EXTENSION) == "mp4" ) {
                                                    continue;
                                                } else {
                                                    echo "<a href='$system/items_media/$m'><li class='col s6 m4'>";
                                            ?>
                                                <img src="<?= $system ?>/items_media/<?= $m ?>" alt="<?= $m ?>">
                                            <?php
                                                    echo "</li></a>";
                                                }

                                            }
                                            ?>
                                        <?php
                                            }
                                        ?>
                                    </ul>
                                </div>
                                <div>
                                    <ul class="row">
                              <?php
                                        $media = explode(",", $ads->item_media);
                                        foreach ($media as $m) {
                                            if (pathinfo($m, PATHINFO_EXTENSION) == "mp4" ) {
                               ?>
                                    
                                        <li class="col s12 m6">
                                            <video controls preload="none" poster="<?= $system ?>/images/startVideo-<?= $GLOBALS["lang"] ?>.jpg">
                                                <source src="<?= $system ?>/items_media/<?= $m ?>" type="video/mp4">
                                                <source src="<?= $system ?>/items_media/<?= $m ?>" type="video/ogg">
                                                 Your browser does not support HTML5 video.
                                            </video>
                                        </li>
                                    
                                <?php
                                        }
                                    }
                                ?>
                                        </ul>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        
        <div class="col s12 m5 l3">
            <div class="card-panel">
                <h5 class="center-align info-ads"><?= \syriashop\lib\Languages::lang("infoAds", $GLOBALS["lang"]) ?></h5>
                <div>
                    <ul class="collection">
                        <li class="collection-item">
                            <b><i class="material-icons right">list</i><?= \syriashop\lib\Languages::lang("showAdsCategorie", $GLOBALS["lang"]) ?>: </b><a href="/newAds/categories/<?= $ads->categorie_id ?>"><span><?= $ads->categorie_name ?></a>.</span>
                        </li>
                        <li class="collection-item">
                            <b><i class="material-icons right">my_location</i><?= \syriashop\lib\Languages::lang("showAdsCountry", $GLOBALS["lang"]) ?>: </b><span><?= $ads->item_country ?>.</span>
                        </li>
                        <li class="collection-item">
                            <b><i class="material-icons right">location_on</i><?= \syriashop\lib\Languages::lang("showAdsLocation", $GLOBALS["lang"]) ?>: </b><span><?= $ads->item_location ?>.</span>
                        </li>
                        <?php
                            if ( $ads->item_type != 1 ) {
                        ?>
                        <li class="collection-item">
                            <b><i class="material-icons right">attach_money</i><?= \syriashop\lib\Languages::lang("showAdsPrice", $GLOBALS["lang"]) ?>: </b><span><?= $ads->item_price ?> SY.</span>
                        </li>
                        <?php } ?>
                        <li class="collection-item">
                            <b><i class="material-icons right">phone</i><?= \syriashop\lib\Languages::lang("showAdsPhone", $GLOBALS["lang"]) ?>: </b><span><?= $ads->phoneuser ?>.</span>
                        </li>
                        <li class="collection-item">
                            <b><i class="material-icons right">contact_mail</i><?= \syriashop\lib\Languages::lang("showAdsWhatsapp", $GLOBALS["lang"]) ?>: </b><a href="<?= "https://api.whatsapp.com/send?phone=" . $ads->whatsapp ?>"<span><?= $ads->whatsapp ?>.</span></a>
                        </li>
                        <?php
                            if ( $ads->item_type != 1 ) {
                        ?>
                        <li class="collection-item">
                            <b><i class="material-icons right">money_off</i><?= \syriashop\lib\Languages::lang("showAdsDiscoint", $GLOBALS["lang"]) ?>: </b><span>
                            <?= $ads->discount == 1 ? \syriashop\lib\Languages::lang("showAdsYes", $GLOBALS["lang"]) : \syriashop\lib\Languages::lang("showAdsNo", $GLOBALS["lang"]) ?>.
                            </span>
                        </li>
                        <?php } ?>
                        <li class="collection-item">
                            <b><i class="material-icons right">schedule</i><?= \syriashop\lib\Languages::lang("expireAds", $GLOBALS["lang"]) ?>: </b>
                            <span>
                                <?php
                                    switch ( $ads->datedif ) {
                                        case 0: echo \syriashop\lib\Languages::lang("after", $GLOBALS["lang"]) . " " .
                                                \syriashop\lib\Languages::lang("7day", $GLOBALS["lang"]) . "."; break;
                                        case 1:
                                        case -1:
                                            echo \syriashop\lib\Languages::lang("after", $GLOBALS["lang"]) . " " .
                                                \syriashop\lib\Languages::lang("6day", $GLOBALS["lang"]) . "."; break;
                                        case 2:
                                        case -2:
                                            echo \syriashop\lib\Languages::lang("after", $GLOBALS["lang"]) . " " .
                                                \syriashop\lib\Languages::lang("5day", $GLOBALS["lang"]) . "."; break;
                                        case 3:
                                        case -3:
                                            echo \syriashop\lib\Languages::lang("after", $GLOBALS["lang"]) . " " .
                                                \syriashop\lib\Languages::lang("4day", $GLOBALS["lang"]) . "."; break;
                                        case 4:
                                        case -4:
                                            echo \syriashop\lib\Languages::lang("after", $GLOBALS["lang"]) . " " .
                                                \syriashop\lib\Languages::lang("3day", $GLOBALS["lang"]) . "."; break;
                                        case 5:
                                        case -5:
                                            echo \syriashop\lib\Languages::lang("after", $GLOBALS["lang"]) . " " .
                                                \syriashop\lib\Languages::lang("2day", $GLOBALS["lang"]) . "."; break;
                                        case 6:
                                        case -6:
                                            echo \syriashop\lib\Languages::lang("after", $GLOBALS["lang"]) . " " .
                                                \syriashop\lib\Languages::lang("1day", $GLOBALS["lang"]) . "."; break;
                                        case 7:
                                        case -7:
                                            echo \syriashop\lib\Languages::lang("today", $GLOBALS["lang"]) . "."; break;
                                    }
 
                                ?>
                            </span>
                        </li>
                        <li class="collection-item">
                            <b><i class="material-icons right">visibility</i><?= \syriashop\lib\Languages::lang("showAdsViews", $GLOBALS["lang"]) ?>: </b><span>
                            <?= $ads->views ?>.
                            </span>
                        </li>
                    </ul>
                    <h5 class="center-align info-ads"><?= \syriashop\lib\Languages::lang("showAdsTags", $GLOBALS["lang"]) ?></h5>
                        <ul class="collection">
                              <li class="collection-item">
                                  <?php
                                    $tags = explode("+", $ads->tags);
                                    foreach ( $tags as $tag ) {
                                  ?>
                                    <div class="chip"><a href="/newAds/search/1/?s=<?= $tag ?>"><?= $tag ?></a></div>
                                    <?php
                                    }
                                    ?>
                              </li>
                        </ul>
                </div>
            </div>
        </div>
        
        <div class="col s12 m8 offset-m2">
            <h5><?= \syriashop\lib\Languages::lang("adsOthersTitle", $GLOBALS["lang"]) ?></h5>
            <div class="row center-align">
                <?php
                    if ( $adsOthers ) {
                        foreach ( $adsOthers as $ads )  {
                            $media = explode(",", $ads->item_media);
                            foreach ($media as $m) {
                                if ( empty($m) ) {
                                    $img = "$system/images/notMedia-{$GLOBALS["lang"]}.jpg";
                                    break;
                                } else if ( in_array(pathinfo($m, PATHINFO_EXTENSION), ALLOW_IMG) ) { // في حال انها صورة
                                    $img = "$system/items_media/" . $m;
                                    break;
                                } else {
                                    $img = "$system/images/notPlayVideo-{$GLOBALS["lang"]}.jpg";
                                    break;
                                }
                            }
                ?>
                <div class="col s6 m3">
                    <a href="/newAds/showAds/<?= $ads->key_hash ?>">
                        <img id="adsOthers" src="<?= $img ?>" alt="<?= $img ?>" />
                    </a>
                </div>
                <?php
                        }
                    } else {
                        echo "<span><b>" . \syriashop\lib\Languages::lang("notFoundadsOthers", $GLOBALS["lang"]) . "</b></span>";
                    }
                ?>
            </div>
        </div>
        
    </div>
</div>

<!-- Reperts -->
<div id="reports" class="modal">
  <div class="modal-content">
    <h4><?= \syriashop\lib\Languages::lang("reportsClientTitle", $GLOBALS["lang"]) ?></h4>
      <div class="row">
        <form class="col s12">
          <div class="row">
            <div class="input-field col s12">
                <textarea id="textarea1" name="report_text" class="materialize-textarea"></textarea>
              <label for="textarea1"><?= \syriashop\lib\Languages::lang("reportsClientReportText", $GLOBALS["lang"]) ?></label>
            </div>
          </div>
            <div class="center-align">
                <a class="waves-effect waves-light red btn send-report"><i class="material-icons right">report</i><?= \syriashop\lib\Languages::lang("report", $GLOBALS["lang"]) ?></a>
            </div>
        </form>
      </div>
  </div>
  <div class="modal-footer">
    <a href="#!" class="modal-close waves-effect waves-green btn-flat"><?= \syriashop\lib\Languages::lang("cancel", $GLOBALS["lang"]) ?></a>
  </div>
</div>
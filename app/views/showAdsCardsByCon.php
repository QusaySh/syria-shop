    <?php
                $media = explode(",", $ads->item_media);
    ?>
    
    <div class="col s12 m4 l3 card-ads margin-top-30 animated" data-id="<?= $ads->item_id ?>" data-key="<?= $ads->key_hash ?>">
        <div class="card card-default z-depth-2">
                <div class="card-image">
                    <div class="media">
                    <?php
                        foreach ( $media as $m ) {
                    ?>
                        <a href="/newAds/showAds/<?= $ads->key_hash ?>">
                            <?php
                            if ( empty($m) ) {
                            ?>
                                <img src="<?= $system ?>/images/notMedia-<?= $GLOBALS["lang"] ?>.jpg" alt="notMedia">
                            <?php
                            } else {
                                if (pathinfo($m, PATHINFO_EXTENSION) == "mp4" ) {
                            ?>
                                <img src="<?= $system ?>/images/notPlayVideo-<?= $GLOBALS["lang"] ?>.jpg" alt="notPlayVideo">
                            <?php
                                } else {
                            ?>
                                <img src="<?= $system ?>/items_media/<?= $m ?>" alt="<?= $m ?>">
                            <?php } } ?>
                        </a>
                    <?php
                        break;
                        }
                    ?>
                </div>
                <div class="fixed-action-btn">
                  <a class="btn-floating btn-small blue darken-2">
                    <i class="large material-icons">more_vert</i>
                  </a>
                  <ul>
                <?php
                    if ( isset($_SESSION["myInfo"]) && $ads->user_id == $_SESSION["myInfo"]["id"] ) {
                ?>
                    <li><a class="btn-floating btn-small green btn-edit" href="/newAds/editAds/<?= $ads->key_hash ?>"><i class="material-icons">edit</i></a></li>
                    <li><a class="btn-floating btn-small red btn-delete"><i class="material-icons">delete</i></a></li>
                <?php } else { ?>
                    <li class="tooltipped" data-position="top" data-tooltip="<?= \syriashop\lib\Languages::lang("report", $GLOBALS["lang"]) ?>"><a class="btn-floating btn-small red modal-trigger btn-report" href="#reports"><i class="material-icons">report</i></a></li>
                <?php } ?>
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
                  <span class="item_price <?= $ads->item_type == 1 ? "hide" : "" ?>"><?= $ads->item_price ?> SY</span>
                  <span class="item_rent <?= $ads->item_type == 3 ? "" : "hide" ?>"><?= \syriashop\lib\Languages::lang("showAdsRent", $GLOBALS["lang"]) ?></span>
                  <span class="icon-discount <?= $ads->discount == 0 ? "hide" : "" ?>"><?= $ads->discount == 1 ? "<img class='animated pulse infinite' src='$system/images/discount.png' />" : "" ?></span>
              </div>
            <div class="card-content">
                <span class="card-title item_name break">
                    <?php
                        $countStr = 20;
                        if ( mb_strlen($ads->item_name) > $countStr ) {
                            echo mb_substr($ads->item_name, 0, $countStr) . " ...";
                        } else {
                            echo $ads->item_name;
                        }
                    ?>
                </span>
                <p class="item_description break">
                    <?php
                        $countStr = 40;
                        if ( mb_strlen($ads->item_description) > $countStr ) {
                            echo mb_substr($ads->item_description, 0, $countStr) . " ...";
                        } else {
                            echo $ads->item_description;
                        }
                    ?>
                </p>
                <p class="country-container"><i class="material-icons">location_on</i><span class="item_location left"><?= $ads->item_location ?></span></p>
                <p class="date-container"><i class="material-icons">access_time</i>
                    <span class="item_add_date left">
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
                    </span></p>
              </div>
            </div>
    </div>
    <?php
    ?>

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
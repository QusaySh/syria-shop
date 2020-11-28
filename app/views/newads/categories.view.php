<?php
    if ( isset($categories) ) { // في حال وجود اقسام فرعية
        if ( !empty($categories) ) {
            echo '<div class="container"><div class="row">';
            echo '<h3 class="center-align margin-bottom-30">' . \syriashop\lib\Languages::lang("chooseCat", $GLOBALS["lang"]) . '</h3>';
            foreach ($categories as $cat) {
?>
            <div class="col l3 m4 s6 animated bounceIn">
                <a href="/newAds/categories/<?= $cat->categorie_id ?>">
                    <div class="card-panel card-cat-categorie z-depth-2 margin-10 center-align light-blue darken-4">
                        <?php if ( $cat->categorie_parent == "main" ) { ?>
                        <img width="50" height="50" src="<?= $system ?>/images/icons_cat/<?= $cat->categorie_icon ?>" alt="<?= $cat->categorie_icon ?>" />
                        <?php } ?>
                        <h6 class="white-text"><?= $cat->categorie_name ?></h6>
                    </div>
                </a>
            </div>
<?php
            }
            echo '</div></div>';
        }
    } else {
        if ( isset($alarm) && $alarm !== "false" ) {
            $alarm = isset($alarm) && $alarm > 0 ? "alarm_off" : "alarm_on";
            $textIcon = "<i data-catid='" . $info_cat->categorie_id . "' class='material-icons pointer alarm tooltipped'"
                    . "data-position='bottom' data-tooltip='" . \syriashop\lib\Languages::lang("enableDisabledAlarm", $GLOBALS["lang"]) . "'>" . $alarm . "</i>";
        } else {
            $textIcon = "";
        }
        /*$alarm = explode(",", $info_cat->alarms);
        $alarm = isset($_SESSION['myInfo']) && in_array($_SESSION['myInfo']['id'], $alarm) ? "alarm_off" : "alarm_on";
        $textIcon = "<i data-catid='" . $info_cat->categorie_id . "' class='material-icons pointer alarm tooltipped'"
                . "data-position='bottom' data-tooltip='" . \syriashop\lib\Languages::lang("enableDisabledAlarm", $GLOBALS["lang"]) . "'>" . $alarm . "</i>";*/
        $title = isset( $info_cat ) ? "<h3 class='center-align teal-text darken-3 animated slideInRight faster'>(" . $count_cat . ") "
                . $info_cat->categorie_name . $textIcon . "</h3>" : "";
        echo $title;
        
        echo "<div class='row'>";
        require VIEWS_PATH . DS . "showAdsCards.php";
    ?>
    <?php
            if ( $thePage["pages"] != 0 ) {
    ?>
        <div class="margin-top-30 center-align col s12">
        <ul class="pagination">
          <li class="waves-effect <?= $thePage['page'] == "1" ? "disabled" : "" ?>">
              <a href="<?= $thePage['page'] == "1" ? "#" : "/newAds/categories/7/" . ($thePage['page'] - 1) ?>">
                  <i class="material-icons left">chevron_right</i>
              </a></li>
              <li class="waves-effect"><a><?= $thePage["page"] ?></a></li>
            <li class="waves-effect"><a><?= $thePage["pages"] ?></a></li>
          <li class="waves-effect <?= $thePage['page'] == $thePage['pages'] ? "disabled" : "" ?>">
              <a data-page="<?= ($thePage['page'] + 1) ?>" href="<?= $thePage['page'] == $thePage['pages']  ? "#" : "/newAds/categories/7/" . ($thePage['page'] + 1) ?>">
                  <i class="material-icons right">chevron_left</i></a></li>
        </ul>
        </div>
        <?php } ?>
        <?php
        echo "</div>";
    }
?>
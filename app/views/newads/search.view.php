<div>
    <div class="row">
        <h3 class="center-align title-default"><?= \syriashop\lib\Languages::lang("resultSearch", $GLOBALS["lang"]) . "[" . str_replace("%20", " ", $search) . "]" ?></h3>
        <?php require VIEWS_PATH . DS . "showAdsCards.php"; ?>
        <?php
            if ( $thePage["pages"] != 0 ) {
        ?>
        <div class="margin-top-30 center-align col s12">
        <ul class="pagination">
          <li class="waves-effect <?= $thePage['page'] == "1" ? "disabled" : "" ?>">
              <a href="<?= $thePage['page'] == "1" ? "#" : "/newAds/search/" . ($thePage['page'] - 1) . "/?s=$search"  ?>">
                  <i class="material-icons left">chevron_right</i>
              </a></li>
              <li class="waves-effect"><a><?= $thePage["page"] ?></a></li>
            <li class="waves-effect"><a><?= $thePage["pages"] ?></a></li>
          <li class="waves-effect <?= $thePage['page'] == $thePage['pages'] ? "disabled" : "" ?>">
              <a data-page="<?= ($thePage['page'] + 1) ?>" href="<?= $thePage['page'] == $thePage['pages']  ? "#" : "/newAds/search/" . ($thePage['page'] + 1) . "/?s=$search" ?>">
                  <i class="material-icons right">chevron_left</i></a></li>
        </ul>
        </div>
        <?php } ?>
    </div>
</div>
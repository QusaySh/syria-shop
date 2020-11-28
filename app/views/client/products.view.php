<div class="row">
    <h3 class="center-align title-default">
        <?php
            $url = explode("/", trim($_SERVER["REQUEST_URI"], "/"), 3);
            $url = explode("/", $url[2]);
            if ( $url[0] == 1 ) {
                echo \syriashop\lib\Languages::lang("item2GetAds1", $GLOBALS["lang"]);
            } else if ( $url[0] == 2 ) {
                echo \syriashop\lib\Languages::lang("item1GetAds1", $GLOBALS["lang"]);
            } else if ( $url[0] == 3 ) {
                echo \syriashop\lib\Languages::lang("item3GetAds1", $GLOBALS["lang"]);
            } else {
                echo \syriashop\lib\Languages::lang("item4GetAds1", $GLOBALS["lang"]);
            }
        ?>
    </h3>
    <?php require VIEWS_PATH . DS . "showAdsCards.php"; ?>
    <?php
        if ( $thePage["pages"] != 0 ) {
    ?>
    <div class="margin-top-30 center-align col s12">
    <ul class="pagination">
      <li class="waves-effect <?= $thePage['page'] == "1" ? "disabled" : "" ?>">
          <a href="<?= $thePage['page'] == "1" ? "#" : "/client/products/{$thePage['param0']}/" . ($thePage['page'] - 1) ?>">
              <i class="material-icons left">chevron_right</i>
          </a></li>
          <li class="waves-effect"><a><?= $thePage["page"] ?></a></li>
        <li class="waves-effect"><a><?= $thePage["pages"] ?></a></li>
      <li class="waves-effect <?= $thePage['page'] == $thePage['pages'] ? "disabled" : "" ?>">
          <a data-page="<?= ($thePage['page'] + 1) ?>" href="<?= $thePage['page'] == $thePage['pages']  ? "#" : "/client/products/{$thePage['param0']}/" . ($thePage['page'] + 1) ?>">
              <i class="material-icons right">chevron_left</i></a></li>
    </ul>
    </div>
    <?php } ?>
</div>


  <!-- عرض احدث الاعلانات -->
  <div class="showLastAds pointer pulse">
      <span><i class="material-icons left">autorenew</i><?= \syriashop\lib\Languages::lang("showLastAds", $GLOBALS["lang"]) ?></span>
  </div>
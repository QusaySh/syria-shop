<div>
    <div class="row">
        <?php  if ( is_array($adsByCon) ) { ?>
        <h4 class="title-default"><?= \syriashop\lib\Languages::lang("maxViews", $GLOBALS["lang"]) ?></h4>
        <div class="col s12 container-ads">
            <?php
                if ( is_array($adsByCon) ) {
                    foreach ( $adsByCon as $ads ) {
            ?>
                <?php require VIEWS_PATH . DS . "showAdsCardsByCon.php"; ?>
            <?php
                    } 

                } else {
                    require VIEWS_PATH . DS ."notFoundAds.php";
                }
            ?>
        </div>
        <?php } ?>
        <?php if ( !empty($adsByCat) ) { ?>
        <div class="col s12 container-ads hide-on-small-only">
            <h4 class="title-default"><?= $adsByCat[1] ?></h4>
           <?php
               if ( is_array($adsByCat[0]) ) {
                   foreach ( $adsByCat[0] as $ads ) {
           ?>
               <?php require VIEWS_PATH . DS . "showAdsCardsByCon.php"; ?>
           <?php
                   } 

               } else {
                   require VIEWS_PATH . DS ."notFoundAds.php";
               }
           ?>
            <div class="clear"></div>
            <p class="center-align"><a href="/newAds/categories/<?= $adsByCat[2] ?>" class="waves-effect waves-light btn blue darken-3"><?= \syriashop\lib\Languages::lang("learnMore", $GLOBALS["lang"]) ?></a></p>
        </div>
        <?php } ?>
        <h4 class="title-default"><?= \syriashop\lib\Languages::lang("newsAds", $GLOBALS["lang"]) ?></h4>
        <?php require VIEWS_PATH . DS . "showAdsCards.php"; ?>
        <?php
            if ( $thePage["pages"] != 0 ) {
        ?>
        <div class="margin-top-30 center-align col s12">
        <ul class="pagination">
          <li class="waves-effect <?= $thePage['page'] == "1" ? "disabled" : "" ?>">
              <a href="<?= $thePage['page'] == "1" ? "#" : "/client/default/" . ($thePage['page'] - 1) ?>">
                  <i class="material-icons left">chevron_right</i>
              </a></li>
              <li class="waves-effect"><a><?= $thePage["page"] ?></a></li>
            <li class="waves-effect"><a><?= $thePage["pages"] ?></a></li>
          <li class="waves-effect <?= $thePage['page'] == $thePage['pages'] ? "disabled" : "" ?>">
              <a data-page="<?= ($thePage['page'] + 1) ?>" href="<?= $thePage['page'] == $thePage['pages']  ? "#" : "/client/default/" . ($thePage['page'] + 1) ?>">
                  <i class="material-icons right">chevron_left</i></a></li>
        </ul>
        </div>
        <?php } ?>
    </div>
        
    <div class="fixed-action-btn btn-more">
      <a class="btn-floating pulse">
        <i class="large material-icons">more_vert</i>
      </a>
      <ul>
          <li class="tooltipped" data-position="<?= \syriashop\lib\Languages::lang("dirTips", $GLOBALS["lang"]) ?>" data-tooltip="<?= \syriashop\lib\Languages::lang("btnAddAds", $GLOBALS["lang"]) ?>"><a href="/newAds/default" id="add_ads" class="btn-floating blue"><i class="material-icons">add</i></a></li>
          <?php if ( isset($_SESSION['myInfo']['admin']) ) { ?>
          <li class="tooltipped" data-position="<?= \syriashop\lib\Languages::lang("dirTips", $GLOBALS["lang"]) ?>" data-tooltip="<?= \syriashop\lib\Languages::lang("dashboard", $GLOBALS["lang"]) ?>"><a href="/dashboard/default" class="btn-floating green"><i class="material-icons">dashboard</i></a></li>
          <?php } ?>
      </ul>
    </div>
</div>

    <a class="btn-floating downloadApp pulse" href="https://top4top.io/downloadf-15710xg681-apk.html" target="_blank">
    <i class="large material-icons">android</i>
    </a>
  <!-- عرض احدث الاعلانات -->
  <div class="showLastAds pointer pulse">
      <span><i class="material-icons left">autorenew</i><?= \syriashop\lib\Languages::lang("showLastAds", $GLOBALS["lang"]) ?></span>
  </div>
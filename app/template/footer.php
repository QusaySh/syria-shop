       <footer class="page-footer grey darken-4 margin-top-30">
          <div class="container hide-on-small-only">
            <div class="row">
              <div class="col m3 s12">
                <h5 class="white-text">Syria Shop</h5>
                <p class="grey-text text-lighten-4"><?= \syriashop\lib\Languages::lang("footerTitle", $GLOBALS["lang"]) ?></p>
              </div>
              <!--<div class="col m3 s6">
                <h5 class="white-text">البلاد</h5>
                <ul>
                <?php
                    $location = new syriashop\modals\LocationModals();
                    $getLocations = $location->sql("location_country_id, location_name", "location_country", "LIMIT 5", null, "all");
                    foreach ($getLocations as $loc) {
                ?>
                  <li><a class="grey-text text-lighten-3" href="/client/country/<?= $loc->location_country_id ?>"><?= $loc->location_name ?></a></li>
                <?php } ?>
                </ul>
              </div>-->
              <div class="col m3 s6">
                <h5 class="white-text"><?= \syriashop\lib\Languages::lang("footerColumnFollow", $GLOBALS["lang"]) ?></h5>
                <ul>
                  <li><a class="grey-text text-lighten-3" href="#!">Facebook</a></li>
                  <li><a class="grey-text text-lighten-3" href="#!">Instagram</a></li>
                  <li><a class="grey-text text-lighten-3" href="#!">Twitter</a></li>
                </ul>
              </div>
              <div class="col m3 s12">
                <h5 class="white-text"><?= \syriashop\lib\Languages::lang("footerColumnLang", $GLOBALS["lang"]) ?></h5>
                <ul>
                  <li><a class="<?= $GLOBALS["lang"] == "ar" ? "red-text" : "grey-text text-lighten-3" ?>" href="/client/lang/ar">AR</a></li>
                  <li><a class="<?= $GLOBALS["lang"] == "en" ? "red-text" : "grey-text text-lighten-3" ?>" href="/client/lang/en">EN</a></li>
                </ul>
              </div>
            </div>
          </div>
          <div class="footer-copyright black">
            <div class="container center-align">
                © 2019 - <?= date("Y") ?> Copyright <span class="indigo-text darken-2">Syria Shop</span>
            </div>
          </div>
        </footer>
    <script src="<?= $system ?>/js/global/jquery.form.js"></script>
    <script src="<?= $system ?>/js/global/materialize.min.js"></script>
    <script src="<?= $system ?>/js/global/mediaBox/lightgallery.min.js"></script>
    <script src="<?= $system ?>/js/global/mediaBox/lg-thumbnail.min.js"></script>
    <script src="<?= $system ?>/js/global/mediaBox/lg-fullscreen.min.js"></script>
    <script src="<?= $system ?>/js/global/mediaBox/lg-autoplay.min.js"></script>
    <script src="<?= $system ?>/js/global/mediaBox/lg-video.min.js"></script>
    <script src="<?= $system ?>/js/global/mediaBox/lg-zoom.min.js"></script>
    <script src="<?= $system ?>/js/global/alertify.min.js"></script>
    <script src="<?= $system ?>/js/global/cookie.js"></script>
    <script src="<?= $system ?>/js/global/languages.js"></script>
    <script src="<?= $system ?>/js/global/script.js"></script>
    <?php
        $fileJs = new \syriashop\controllers\AutoLoadStyle();
        $file = $fileJs->filesJs();
        if ( $file != false ) {
            echo '<script src="' . $system . $file . '"></script>';
        }
        ob_end_flush();
    ?>
  </body>
</html>
<audio id="voiceAdd">
  <source src=<?= $system ?>"/voice/add.m4a" type="audio/mpeg">
  Your browser does not support the audio tag.
</audio>
<audio id="voicePageMain">
  <source src="<?= $system ?>/voice/pageMain.m4a" type="audio/mpeg">
  Your browser does not support the audio tag.
</audio>
<audio id="voiceDelete">
  <source src="<?= $system ?>/voice/delete.m4a" type="audio/mpeg">
  Your browser does not support the audio tag.
</audio>
<audio id="voiceError">
  <source src="<?= $system ?>/voice/error.m4a" type="audio/mpeg">
  Your browser does not support the audio tag.
</audio>

  <!-- Modal Structure -->
  <div id="country" class="modal">
    <div class="modal-content">
      <h5><?= \syriashop\lib\Languages::lang("titleContainerCountry", $GLOBALS["lang"]) ?></h5>
      <div class="allCountry row margin-top-30">
        <?php
            $location = new syriashop\modals\LocationModals();
            $getLocations = $location->getAll();
            //$loc = $location->getByColumn("location_name", "سوريا");
            foreach ($getLocations as $loc) {
        ?>
          <div class="col l2 m2 s4 center-align" style="outline: 1px solid <?= $loc->location_country_id == $GLOBALS["country"] ? "#2f5cc1" : "transparent" ?>">
              <a href="/client/country/<?= $loc->location_country_id ?>">
                <img class="icon_country" width="35" height="35" src="<?= $system ?>/images/icons_country/<?= $loc->location_icon ?>" />
                <p class="name_country"><?= $loc->location_name ?></p>
              </a>
          </div>
        <?php } ?>
      </div>
    </div>
    <div class="modal-footer">
      <a href="#!" class="modal-close waves-effect waves-green btn-flat"><?= \syriashop\lib\Languages::lang("cancel", $GLOBALS["lang"]) ?></a>
    </div>
  </div>
  
    <div id="city" class="modal">
    <div class="modal-content">
      <h5><?= \syriashop\lib\Languages::lang("titleContainerCity", $GLOBALS["lang"]) ?></h5>
      <div class="allCity row margin-top-30">
        <div class="col s3 center-align">
            <a class="name_city waves-effect cyan darken-3 btn" href="/client/city/?city=all">
              <?= \syriashop\lib\Languages::lang("allCity", $GLOBALS["lang"]) ?>
            </a>
        </div>
        <?php
            $location = new syriashop\modals\CityModals();
            $getLocations = $location->getByColumn("location_country_id", $GLOBALS['country'], "all");
            foreach ($getLocations as $loc) {
        ?>
          <div class="col s4 m3 center-align margin-bottom-30">
            <a class="name_city waves-effect waves-light btn" href="/client/city/?city=<?= $loc->location_name ?>">
              <?= $loc->location_name ?>
            </a>
          </div>
        <?php } ?>
      </div>
    </div>
    <div class="modal-footer">
      <a href="#!" class="modal-close waves-effect waves-green btn-flat"><?= \syriashop\lib\Languages::lang("cancel", $GLOBALS["lang"]) ?></a>
    </div>
  </div>
  
  <div class="selectTheme black pointer">
      <i class="material-icons white-text">
        <?php
        if ( isset($_COOKIE["theme"]) ) {
            if ( $_COOKIE["theme"] == "normal" ) {
               echo "brightness_3";
            } else {
                echo "brightness_5";
            }
        } else {
            echo "brightness_3";
        }
        ?>
      </i>
  </div>
<div class="container">
    <h4 class="center-align margin-bottom-30"><?= \syriashop\lib\Languages::lang("dashboardCountry", $GLOBALS["lang"]) ?></h4>
    <a class="waves-effect waves-light btn modal-trigger dark-button-1" href="#modalAddCountry"><i class="material-icons right">add</i><?= \syriashop\lib\Languages::lang("dashboardAddCountry", $GLOBALS["lang"]) ?></a>
    <table class="responsive-table highlight centered">
        <thead>
          <tr>
              <th>#</th>
              <th><?= \syriashop\lib\Languages::lang("dashboardColumnLocationName", $GLOBALS["lang"]) ?></th>
              <th><?= \syriashop\lib\Languages::lang("dashboardColumnLocationIcon", $GLOBALS["lang"]) ?></th>
              <th><?= \syriashop\lib\Languages::lang("dashboardControl", $GLOBALS["lang"]) ?></th>
          </tr>
        </thead>

        <tbody>
            <?php
            if ( is_array($allCountry) ) { // في حال يوجد مستخدمين
            $i = 1;
                foreach ( $allCountry as $country ) {
            ?>
          <tr>
            <td><?= $i ?></td>
            <td><?= $country->location_name ?></td>
            <td><img width="32" height="32" src="<?= $system ?>/images/icons_country/<?= $country->location_icon ?>" alt="<?= $country->location_icon ?>" /></td>
            <td>
                <i class="material-icons red-text pointer delete_country" data-id = "<?= $country->location_country_id ?>">delete</i>
                <i class="material-icons green-text pointer edit_country" data-id = "<?= $country->location_country_id ?>">edit</i>
            </td>
          </tr>
          <?php
          $i++;
                }
            } else {
                echo "<tr><td colspan='5'>" . $allCountry . "</td></tr>";
            }
          ?>
        </tbody>
      </table>
        <?php
            if ( $thePage["pages"] != 0 ) {
        ?>
        <div class="margin-top-30 center-align col s12">
        <ul class="pagination">
          <li class="waves-effect <?= $thePage['page'] == "1" ? "disabled" : "" ?>">
              <a href="<?= $thePage['page'] == "1" ? "#" : "/dashboard/country/" . ($thePage['page'] - 1) ?>">
                  <i class="material-icons left">chevron_right</i>
              </a></li>
              <li class="waves-effect"><a><?= $thePage["page"] ?></a></li>
            <li class="waves-effect"><a><?= $thePage["pages"] ?></a></li>
          <li class="waves-effect <?= $thePage['page'] == $thePage['pages'] ? "disabled" : "" ?>">
              <a data-page="<?= ($thePage['page'] + 1) ?>" href="<?= $thePage['page'] == $thePage['pages']  ? "#" : "/dashboard/country/" . ($thePage['page'] + 1) ?>">
                  <i class="material-icons right">chevron_left</i></a></li>
        </ul>
        </div>
        <?php } ?>
</div>


  <!-- Modal Add Country -->
  <div id="modalAddCountry" class="modal">
    <div class="modal-content">
      <h4><?= \syriashop\lib\Languages::lang("dashboardAddCountry", $GLOBALS["lang"]) ?></h4>
      <form class="formCountry theForm">
        <div class="input-field margin-top-30">
            <input placeholder="<?= \syriashop\lib\Languages::lang("dashboardMessageEnterCountryName", $GLOBALS["lang"]) ?>" name="country_name" id="country_name" type="text" class="validate">
          <label for="country_name"><?= \syriashop\lib\Languages::lang("dashboardColumnLocationName", $GLOBALS["lang"]) ?></label>
        </div>
        <div class="input-field margin-top-30">
            <input placeholder="<?= \syriashop\lib\Languages::lang("dashboardMessageEnterCountryKey", $GLOBALS["lang"]) ?>" name="country_key" id="country_key" type="text" class="validate">
          <label for="country_key"><?= \syriashop\lib\Languages::lang("dashboardColumnLocationKey", $GLOBALS["lang"]) ?></label>
        </div>
        <div class="file-field input-field">
          <div class="btn dark-button-1">
            <span>File</span>
            <input type="file" name="uploadCountry" accept="image/gif, image/png, image/jpeg, image/jpg" />
          </div>
          <div class="file-path-wrapper">
              <input class="file-path validate" type="text">
          </div>
        </div>
          <div class="input-field center-align">
            <button class="btn waves-effect waves-light center-align dark-button-1" type="submit" name="addCountry">
                <?= \syriashop\lib\Languages::lang("add", $GLOBALS["lang"]) ?>
              <i class="material-icons right">add</i>
            </button>
          </div>
      </form>
        <div class="progress" style="display: none;">
            <div class="determinate" style="width: 70%"></div>
        </div>
    </div>
    <div class="modal-footer">
      <a href="#!" class="modal-close waves-effect waves-red btn-flat"><?= \syriashop\lib\Languages::lang("cancel", $GLOBALS["lang"]) ?></a>
    </div>
  </div>
  
  <!-- Modal Edit Country -->
  <div id="modalEditCountry" class="modal">
    <div class="modal-content">
      <h4><?= \syriashop\lib\Languages::lang("dashboardEditCountry", $GLOBALS["lang"]) ?></h4>
      <form class="formEditCountry">
        <div class="input-field margin-top-30">
            <input placeholder="<?= \syriashop\lib\Languages::lang("dashboardMessageEnterCountryName", $GLOBALS["lang"]) ?>" name="country_name" id="countryEdit_name" type="text" class="validate">
          <label for="countryEdit_name"><?= \syriashop\lib\Languages::lang("dashboardColumnLocationName", $GLOBALS["lang"]) ?></label>
        </div>
        <div class="input-field margin-top-30">
            <input placeholder="<?= \syriashop\lib\Languages::lang("dashboardMessageEnterCountryKey", $GLOBALS["lang"]) ?>" name="country_key" id="countryEdit_key" type="text" class="validate">
          <label for="countryEdit_key"><?= \syriashop\lib\Languages::lang("dashboardColumnLocationKey", $GLOBALS["lang"]) ?></label>
        </div>
        <div class="file-field input-field">
          <div class="btn">
            <span>File</span>
            <input type="file" name="uploadCountry">
          </div>
          <div class="file-path-wrapper">
              <input class="file-path validate" type="text">
          </div>
        </div>
          <div class="input-field center-align">
            <button class="btn waves-effect waves-light center-align dark-button-1" type="submit" name="EditCountry">
                <?= \syriashop\lib\Languages::lang("save", $GLOBALS["lang"]) ?>
              <i class="material-icons right">save</i>
            </button>
          </div>
      </form>
        <div class="progress" style="display: none;">
            <div class="determinate" style="width: 70%"></div>
        </div>
    </div>
    <div class="modal-footer">
      <a href="#!" class="modal-close waves-effect waves-red btn-flat"><?= \syriashop\lib\Languages::lang("cancel", $GLOBALS["lang"]) ?></a>
    </div>
  </div>
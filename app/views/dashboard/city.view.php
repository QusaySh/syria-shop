<div class="container">
    <h4 class="center-align margin-bottom-30"><?= \syriashop\lib\Languages::lang("dashboardCity", $GLOBALS["lang"]) ?></h4>
    <a class="waves-effect waves-light btn modal-trigger dark-button-1" href="#modalAddCity"><i class="material-icons right">add</i><?= \syriashop\lib\Languages::lang("dashboardAddCity", $GLOBALS["lang"]) ?></a>
    <table class="responsive-table highlight centered">
        <thead>
          <tr>
              <th>#</th>
              <th>
                  <p><a href="/dashboard/city/1?by=location_city_name&sort=DESC"><i class="material-icons middle">arrow_drop_up</i></a></p>
                    <?= \syriashop\lib\Languages::lang("dashboardColumnCityLocationName", $GLOBALS["lang"]) ?>
                  <p><a href="/dashboard/city/1?by=location_city_name&sort=ASC"><i class="material-icons middle">arrow_drop_down</i></a></p>
              </th>
              <th>
                  <p><a href="/dashboard/city/1?by=location_country_name&sort=DESC"><i class="material-icons middle">arrow_drop_up</i></a></p>
                <?= \syriashop\lib\Languages::lang("dashboardColumnLocationName", $GLOBALS["lang"]) ?>
                <p><a href="/dashboard/city/1?by=location_country_name&sort=ASC"><i class="material-icons middle">arrow_drop_down</i></a></p>
              </th>
              <th><?= \syriashop\lib\Languages::lang("dashboardControl", $GLOBALS["lang"]) ?></th>
          </tr>
        </thead>

        <tbody>
            <?php
            if ( is_array($allCity) ) { // في حال يوجد مستخدمين
            $i = 1;
                foreach ( $allCity as $city ) {
            ?>
          <tr>
            <td><?= $i ?></td>
            <td>
                <?= $city->location_name ?>
            </td>
            <td><?= $city->countryName ?></td>
            <td>
                <i class="material-icons red-text pointer delete_city" data-id = "<?= $city->location_city_id ?>">delete</i>
                <i class="material-icons green-text pointer edit_city" data-id = "<?= $city->location_city_id ?>">edit</i>
            </td>
          </tr>
          <?php
          $i++;
                }
            } else {
                echo "<tr><td colspan='5'>" . $allCity . "</td></tr>";
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
              <a href="<?= $thePage['page'] == "1" ? "#" : "/dashboard/city/" . ($thePage['page'] - 1) ?>">
                  <i class="material-icons left">chevron_right</i>
              </a></li>
              <li class="waves-effect"><a><?= $thePage["page"] ?></a></li>
            <li class="waves-effect"><a><?= $thePage["pages"] ?></a></li>
          <li class="waves-effect <?= $thePage['page'] == $thePage['pages'] ? "disabled" : "" ?>">
              <a data-page="<?= ($thePage['page'] + 1) ?>" href="<?= $thePage['page'] == $thePage['pages']  ? "#" : "/dashboard/city/" . ($thePage['page'] + 1) ?>">
                  <i class="material-icons right">chevron_left</i></a></li>
        </ul>
        </div>
        <?php } ?>
</div>


  <!-- Modal Add city -->
  <div id="modalAddCity" class="modal">
    <div class="modal-content">
      <h4><?= \syriashop\lib\Languages::lang("dashboardAddCity", $GLOBALS["lang"]) ?></h4>
      <form class="formAddCity theForm">
        <div class="input-field margin-top-30">
            <input autocomplete="off" placeholder="<?= \syriashop\lib\Languages::lang("dashboardMessageEnterCityName", $GLOBALS["lang"]) ?>" name="city_name" id="city_name" type="text" class="validate">
          <label for="city_name"><?= \syriashop\lib\Languages::lang("dashboardColumnCityLocationName", $GLOBALS["lang"]) ?></label>
        </div>
        <div class="input-field col s12 m6">
            <input class="select" list="addCountry" name="country_name" autocomplete="off" value="" placeholder="<?= \syriashop\lib\Languages::lang("dashboardColumnLocationName", $GLOBALS["lang"]) ?>" />
            <datalist id="addCountry">
            <?php foreach ( $getAllCountry as $country ) { ?>
                <option value="<?= $country->location_country_id ?>"><?= $country->location_name ?></option>
            <?php } ?>
            </datalist>
        </div>
          <div class="input-field center-align">
            <button class="btn waves-effect waves-light center-align dark-button-1" type="submit" name="addCity">
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
  
  <!-- Modal Edit city -->
  <div id="modalEditCity" class="modal">
    <div class="modal-content">
      <h4><?= \syriashop\lib\Languages::lang("dashboardEditCity", $GLOBALS["lang"]) ?></h4>
      <form class="formEditCity">
        <div class="input-field margin-top-30">
            <input autocomplete="off" placeholder="<?= \syriashop\lib\Languages::lang("dashboardMessageEnterCityName", $GLOBALS["lang"]) ?>" name="city_name" id="cityEdit_name" type="text" class="validate">
          <label for="cityEdit_name"><?= \syriashop\lib\Languages::lang("dashboardColumnCityLocationName", $GLOBALS["lang"]) ?></label>
        </div>
        <div class="input-field col s12 m6">
            <input class="select" list="editCountry" name="country_name" autocomplete="off" value="" placeholder="<?= \syriashop\lib\Languages::lang("dashboardColumnLocationName", $GLOBALS["lang"]) ?>" />
            <datalist id="editCountry">
            <?php foreach ( $getAllCountry as $country ) { ?>
                <option value="<?= $country->location_country_id ?>"><?= $country->location_name ?></option>
            <?php } ?>
            </datalist>
        </div>
          <div class="input-field center-align">
            <button class="btn waves-effect waves-light center-align" type="submit" name="EditCity">
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
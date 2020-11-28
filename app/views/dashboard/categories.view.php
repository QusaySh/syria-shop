<div class="container">
    <h4 class="center-align margin-bottom-30"><?= \syriashop\lib\Languages::lang("dashboardCategories", $GLOBALS["lang"]) ?></h4>
    <a class="waves-effect waves-light btn modal-trigger dark-button-1" href="#modalAddCat"><i class="material-icons right">add</i><?= \syriashop\lib\Languages::lang("dashboardAddCategories", $GLOBALS["lang"]) ?></a>
    <table class="responsive-table highlight centered">
        <thead>
          <tr>
              <th>#</th>
              <th><?= \syriashop\lib\Languages::lang("dashboardColumnCatName", $GLOBALS["lang"]) ?></th>
              <th><?= \syriashop\lib\Languages::lang("dashboardColumnCatIcon", $GLOBALS["lang"]) ?></th>
              <th><?= \syriashop\lib\Languages::lang("dashboardColumnCatParent", $GLOBALS["lang"]) ?></th>
              <th><?= \syriashop\lib\Languages::lang("dashboardControl", $GLOBALS["lang"]) ?></th>
          </tr>
        </thead>

        <tbody>
            <?php
            if ( is_array($allCat) ) { // في حال يوجد مستخدمين
            $i = 1;
                foreach ( $allCat as $cat ) {
            ?>
            <tr>
              <td><?= $i ?></td>
            <td><?= $cat->categorie_name ?></td>
            <td>
                <?php if ( $cat->categorie_parent == "main" ) { ?>
                <img width="32" height="32" src="<?= $system ?>/images/icons_cat/<?= $cat->categorie_icon ?>" alt="<?= $cat->categorie_icon ?>" />
                <?php } else {
                    echo \syriashop\lib\Languages::lang("dashboardColumnCatNotIcon", $GLOBALS["lang"]);
                } ?>
            </td>
            <td>
                <?php
                    if ( $cat->categorie_parent == 0 ) {
                        echo "رئيسي";
                    } else {
                        echo "فرعي";
                    }
                ?>
            </td>
            <td>
                <i class="material-icons red-text pointer delete_cat" data-id = "<?= $cat->categorie_id ?>">delete</i>
                <i class="material-icons green-text pointer edit_cat" data-id = "<?= $cat->categorie_id ?>">edit</i>
            </td>
          </tr>
          <?php
          $i++;
                }
            } else {
                echo "<tr><td colspan='5'>" . $allCat . "</td></tr>";
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
              <a href="<?= $thePage['page'] == "1" ? "#" : "/dashboard/categories/" . ($thePage['page'] - 1) ?>">
                  <i class="material-icons left">chevron_right</i>
              </a></li>
              <li class="waves-effect"><a><?= $thePage["page"] ?></a></li>
            <li class="waves-effect"><a><?= $thePage["pages"] ?></a></li>
          <li class="waves-effect <?= $thePage['page'] == $thePage['pages'] ? "disabled" : "" ?>">
              <a data-page="<?= ($thePage['page'] + 1) ?>" href="<?= $thePage['page'] == $thePage['pages']  ? "#" : "/dashboard/categories/" . ($thePage['page'] + 1) ?>">
                  <i class="material-icons right">chevron_left</i></a></li>
        </ul>
        </div>
        <?php } ?>
</div>


  <!-- Modal Add Cat -->
  <div id="modalAddCat" class="modal modal-fixed-footer">
    <div class="modal-content">
      <h4><?= \syriashop\lib\Languages::lang("dashboardAddCategories", $GLOBALS["lang"]) ?></h4>
      <form class="formCat theForm">
        <div class="input-field margin-top-30">
            <input placeholder="<?= \syriashop\lib\Languages::lang("dashboardColumnCatName", $GLOBALS["lang"]) ?>" name="categorie_name" id="categorie_name" type="text" class="validate">
          <label for="categorie_name"><?= \syriashop\lib\Languages::lang("dashboardMessageEnterCatName", $GLOBALS["lang"]) ?></label>
        </div>
        <div class="file-field input-field">
          <div class="btn dark-button-1">
            <span>File</span>
            <input type="file" name="uploadIconCat" accept="image/gif, image/png, image/jpeg, image/jpg" />
          </div>
          <div class="file-path-wrapper">
              <input class="file-path validate" type="text">
          </div>
        </div>
        <div class="input-field col s12 m6">
            <input class="select" list="catParent" name="categorie_parent" autocomplete="off" value="" placeholder="<?= \syriashop\lib\Languages::lang("dashboardColumnCatParent", $GLOBALS["lang"]) ?>" />
            <datalist id="catParent">
                <option value="main">فئة رئيسية</option>
            <?php foreach ( $getAllCat as $cat ) { ?>
                <option value="<?= $cat->categorie_id ?>"><?= $cat->categorie_name ?></option>
            <?php } ?>
            </datalist>
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
  <div id="modalEditCat" class="modal modal-fixed-footer">
    <div class="modal-content">
      <h4><?= \syriashop\lib\Languages::lang("dashboardEditCategories", $GLOBALS["lang"]) ?></h4>
      <form class="formEditCat theForm">
        <div class="input-field margin-top-30">
            <input placeholder="<?= \syriashop\lib\Languages::lang("dashboardColumnCatName", $GLOBALS["lang"]) ?>" name="EditCategorie_name" id="categorie_name" type="text" class="validate">
          <label for="categorie_name"><?= \syriashop\lib\Languages::lang("dashboardMessageEnterCatName", $GLOBALS["lang"]) ?></label>
        </div>
        <div class="file-field input-field">
          <div class="btn">
            <span>File</span>
            <input type="file" name="uploadIconCat">
          </div>
          <div class="file-path-wrapper">
              <input class="file-path validate" type="text">
          </div>
        </div>
        <div class="input-field col s12 m6">
            <input class="select" list="catParent" name="EditCategorie_parent" value="" placeholder="<?= \syriashop\lib\Languages::lang("dashboardColumnCatParent", $GLOBALS["lang"]) ?>" />
            <datalist id="catParent">
                <option value="0">فئة رئيسية</option>
            <?php foreach ( $getAllCat as $cat ) { ?>
                <option value="<?= $cat->categorie_id ?>"><?= $cat->categorie_name ?></option>
            <?php } ?>
            </datalist>
        </div>
          <div class="input-field center-align">
            <button class="btn waves-effect waves-light center-align" type="submit" name="addCountry">
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
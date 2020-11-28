<div class="container">
    <h4 class="center-align margin-bottom-30"><?= \syriashop\lib\Languages::lang("dashboardAds", $GLOBALS["lang"]) ?></h4>
    <table class="responsive-table highlight centered">
        <thead>
          <tr>
              <th>#</th>
              <th data-sort="item_name">
                  <p><a href="/dashboard/items/1?by=item_name&sort=DESC"><i class="material-icons middle">arrow_drop_up</i></a></p>
                        <?= \syriashop\lib\Languages::lang("inputTitleAds", $GLOBALS["lang"]) ?>
                  <p><a href="/dashboard/items/1?by=item_name&sort=ASC"><i class="material-icons middle">arrow_drop_down</i></a></p>
              </th>
              <th data-sort="item_description">
                  <p><a href="/dashboard/items/1?by=item_description&sort=DESC"><i class="material-icons middle">arrow_drop_up</i></a></p>
                    <?= \syriashop\lib\Languages::lang("inputDescAds", $GLOBALS["lang"]) ?>
                  <p><a href="/dashboard/items/1?by=item_description&sort=ASC"><i class="material-icons middle">arrow_drop_down</i></a></p>
              </th>
              <th data-sort="item_add_date">
                  <p><a href="/dashboard/items/1?by=item_add_date&sort=DESC"><i class="material-icons middle">arrow_drop_up</i></a></p>
                    <?= \syriashop\lib\Languages::lang("dashboardDateAdded", $GLOBALS["lang"]) ?>
                  <p><a href="/dashboard/items/1?by=item_add_date&sort=ASC"><i class="material-icons middle">arrow_drop_down</i></a></p>
              </th>
              <th data-sort="item_country">
                  <p><a href="/dashboard/items/1?by=item_country&sort=DESC"><i class="material-icons middle">arrow_drop_up</i></a></p>
                    <?= \syriashop\lib\Languages::lang("dashboardItemsCountry", $GLOBALS["lang"]) ?>
                  <p><a href="/dashboard/items/1?by=item_country&sort=ASC"><i class="material-icons middle">arrow_drop_down</i></a></p>
              </th>
              <th data-sort="item_location">
                  <p><a href="/dashboard/items/1?by=item_location&sort=DESC"><i class="material-icons middle">arrow_drop_up</i></a></p>
                    <?= \syriashop\lib\Languages::lang("dashboardItemsCity", $GLOBALS["lang"]) ?>
                  <p><a href="/dashboard/items/1?by=item_location&sort=ASC"><i class="material-icons middle">arrow_drop_down</i></a></p>
              </th>
              <th><?= \syriashop\lib\Languages::lang("dashboardViewItem", $GLOBALS["lang"]) ?></th>
              <th data-sort="username">
                  <p><a href="/dashboard/items/1?by=username&sort=DESC"><i class="material-icons middle">arrow_drop_up</i></a></p>
                <?= \syriashop\lib\Languages::lang("dashboardPublisher", $GLOBALS["lang"]) ?>
                  <p><a href="/dashboard/items/1?by=username&sort=ASC"><i class="material-icons middle">arrow_drop_down</i></a></p>
              </th>
              <th><?= \syriashop\lib\Languages::lang("dashboardControl", $GLOBALS["lang"]) ?></th>
          </tr>
        </thead>

        <tbody>
            <?php
            if ( is_array($allItems) ) { // في حال يوجد مستخدمين
            $i = 1;
                foreach ( $allItems as $item ) {
            ?>
          <tr>
            <td><?= $i ?></td>
            <td>
                <?php
                  if ( mb_strlen($item->item_name) >= 15 ) {
                      echo $item->item_name . "...";
                  } else {
                      echo $item->item_name;
                  }
                ?>
            </td>
            <td>
                <?php
                  if ( mb_strlen($item->item_description) > 15 ) {
                      echo $item->item_description . "...";
                  } else {
                      echo $item->item_description;
                  }
                ?>
            </td>
            <td><?= $item->item_add_date ?></td>
            <td><?= $item->item_country ?></td>
            <td><?= $item->item_location ?></td>
            <td><a target="_blank" href="/newAds/showAds/<?= $item->key_hash ?>"><i class="material-icons">remove_red_eye</i></a></td>
            <td><?= $item->username ?></td>
            <td>
                <i class="material-icons red-text pointer delete_item" data-key = "<?= $item->key_hash ?>">delete</i>
            </td>
          </tr>
          <?php
          $i++;
                }
            } else {
                echo "<tr><td colspan='8'>" . $allItems . "</td></tr>";
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
              <a href="<?= $thePage['page'] == "1" ? "#" : "/dashboard/items/" . ($thePage['page'] - 1) ?>">
                  <i class="material-icons left">chevron_right</i>
              </a></li>
              <li class="waves-effect"><a><?= $thePage["page"] ?></a></li>
            <li class="waves-effect"><a><?= $thePage["pages"] ?></a></li>
          <li class="waves-effect <?= $thePage['page'] == $thePage['pages'] ? "disabled" : "" ?>">
              <a data-page="<?= ($thePage['page'] + 1) ?>" href="<?= $thePage['page'] == $thePage['pages']  ? "#" : "/dashboard/items/" . ($thePage['page'] + 1) ?>">
                  <i class="material-icons right">chevron_left</i></a></li>
        </ul>
        </div>
        <?php } ?>
</div>
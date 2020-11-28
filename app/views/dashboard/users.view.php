<div class="container">
    <h4 class="center-align margin-bottom-30"><?= \syriashop\lib\Languages::lang("dashboardClients", $GLOBALS["lang"]) ?></h4>
    <table class="responsive-table highlight centered">
        <thead>
          <tr>
              <th>#</th>
              <th><?= \syriashop\lib\Languages::lang("username", $GLOBALS["lang"]) ?></th>
              <th><?= \syriashop\lib\Languages::lang("email", $GLOBALS["lang"]) ?></th>
              <th><?= \syriashop\lib\Languages::lang("dashboardTypeUser", $GLOBALS["lang"]) ?></th>
              <th><?= \syriashop\lib\Languages::lang("dashboardControl", $GLOBALS["lang"]) ?></th>
              <th><?= \syriashop\lib\Languages::lang("dashboardBlock", $GLOBALS["lang"]) ?></th>
          </tr>
        </thead>

        <tbody>
            <?php
            if ( is_array($allUsers) ) { // في حال يوجد مستخدمين
            $i = 1;
                foreach ( $allUsers as $user ) {
            ?>
          <tr>
            <td><?= $i ?></td>
            <td><?= $user->username ?></td>
            <td><?= $user->email ?></td>
            <td><?= $user->type_user == "admin" ? '<i class="material-icons blue-text" id="permUser">security</i>' : '<i class="material-icons teal-text" id="permUser">person</i>' ?></td>
            <?php if ( $user->id != $_SESSION['myInfo']['id'] ) { ?>
            <td>
                <i class="material-icons red-text pointer delete_user" data-id = "<?= $user->id ?>">delete</i>
                <?php
                    $id = $user->id;
                    echo $user->type_user != "admin" ? '<i class="material-icons blue-text pointer type_user" data-id = ' . $id . '>security</i>' : '<i class="material-icons teal-text pointer type_user" data-id = ' . $id . '>person</i>'
                ?>
            </td>
            <?php } else {
                echo "<td>ــــــــــ</td>";
            } ?>

            <?php if ( $user->id != $_SESSION['myInfo']['id'] ) { ?>
                <td>
                    <i class="material-icons black-text pointer block_user" data-id = "<?= $user->id ?>">
                        <?= $user->block == 1 ? "check" : "block" ?>
                    </i>
                </td>
            <?php } else {
                echo "<td>ــــــــــ</td>";
            } ?>
          </tr>
          <?php
          $i++;
                }
            } else {
                echo "<tr><td colspan='5'>" . $allUsers . "</td></tr>";
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
              <a href="<?= $thePage['page'] == "1" ? "#" : "/dashboard/users/" . ($thePage['page'] - 1) ?>">
                  <i class="material-icons left">chevron_right</i>
              </a></li>
              <li class="waves-effect"><a><?= $thePage["page"] ?></a></li>
            <li class="waves-effect"><a><?= $thePage["pages"] ?></a></li>
          <li class="waves-effect <?= $thePage['page'] == $thePage['pages'] ? "disabled" : "" ?>">
              <a data-page="<?= ($thePage['page'] + 1) ?>" href="<?= $thePage['page'] == $thePage['pages']  ? "#" : "/dashboard/users/" . ($thePage['page'] + 1) ?>">
                  <i class="material-icons right">chevron_left</i></a></li>
        </ul>
        </div>
        <?php } ?>
</div>
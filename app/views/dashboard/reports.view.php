<div class="container">
    <h4 class="center-align margin-bottom-30"><?= \syriashop\lib\Languages::lang("dashboardReports", $GLOBALS["lang"]) ?></h4>
    <table class="responsive-table highlight centered">
        <thead>
          <tr>
              <th>#</th>
              <th><?= \syriashop\lib\Languages::lang("dashboardColumnReportText", $GLOBALS["lang"]) ?></th>
              <th><?= \syriashop\lib\Languages::lang("dashboardColumnReportTo", $GLOBALS["lang"]) ?></th>
              <th><?= \syriashop\lib\Languages::lang("dashboardControl", $GLOBALS["lang"]) ?></th>
          </tr>
        </thead>

        <tbody>
            <?php
            if ( is_array($allReports) ) { // في حال يوجد مستخدمين
            $i = 1;
                foreach ( $allReports as $report ) {
            ?>
            <tr>
              <td><?= $i ?></td>
            <td><?= $report->report_text ?></td>
            <td><a target="_blank" href="/newAds/showAds/<?= $report->report_to_key ?>"><i class="material-icons">remove_red_eye</i></a></td>
            <td>
                <i class="material-icons red-text pointer delete_report" data-id = "<?= $report->report_id ?>">delete</i>
            </td>
          </tr>
          <?php
          $i++;
                }
            } else {
                echo "<tr><td colspan='5'>" . $allReports . "</td></tr>";
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
              <a href="<?= $thePage['page'] == "1" ? "#" : "/dashboard/reports/" . ($thePage['page'] - 1) ?>">
                  <i class="material-icons left">chevron_right</i>
              </a></li>
              <li class="waves-effect"><a><?= $thePage["page"] ?></a></li>
            <li class="waves-effect"><a><?= $thePage["pages"] ?></a></li>
          <li class="waves-effect <?= $thePage['page'] == $thePage['pages'] ? "disabled" : "" ?>">
              <a data-page="<?= ($thePage['page'] + 1) ?>" href="<?= $thePage['page'] == $thePage['pages']  ? "#" : "/dashboard/reports/" . ($thePage['page'] + 1) ?>">
                  <i class="material-icons right">chevron_left</i></a></li>
        </ul>
        </div>
        <?php } ?>
</div>
<div class="container">
    <h4 class="center-align margin-bottom-30"><?= \syriashop\lib\Languages::lang("dashboardControlPanel", $GLOBALS["lang"]) ?></h4>
    <div class="row">
        <div class="col m3 s6">
            <div class="center-align statistics-card card-users over-flow-hidden animated">
                <i class="material-icons white-text animated">person</i>
                <p class="title-card white-text"><?= \syriashop\lib\Languages::lang("dashboardClients", $GLOBALS["lang"]) ?></p>
                <span class="white-text"><?= $countTable['countUsers'] ?></span>
            </div>
        </div>
        <div class="col m3 s6">
            <div class="center-align statistics-card card-items over-flow-hidden animated">
                <i class="material-icons white-text animated">add_shopping_cart</i>
                <p class="title-card white-text"><?= \syriashop\lib\Languages::lang("dashboardAds", $GLOBALS["lang"]) ?></p>
                <span class="white-text"><?= $countTable['countAds'] ?></span>
            </div>
        </div>
        <div class="col m3 s6">
            <div class="center-align statistics-card card-categories over-flow-hidden animated">
                <i class="material-icons white-text animated">list</i>
                <p class="title-card white-text"><?= \syriashop\lib\Languages::lang("dashboardCategories", $GLOBALS["lang"]) ?></p>
                <span class="white-text"><?= $countTable['countCat'] ?></span>
            </div>
        </div>
        <div class="col m3 s6">
            <div class="center-align statistics-card card-country over-flow-hidden animated">
                <i class="material-icons white-text animated">location_on</i>
                <p class="title-card white-text"><?= \syriashop\lib\Languages::lang("dashboardCountry", $GLOBALS["lang"]) ?></p>
                <span class="white-text"><?= $countTable['countCountry'] ?></span>
            </div>
        </div>
    </div>
    
    <div class="row">
        <div class="col m5 s12">
            <div class="last-user">
                <ul class="collection with-header">
                    <li class="collection-header white-text first-collection">
                        <h5><i class="material-icons right">person</i><?= \syriashop\lib\Languages::lang("dashboardLastUsers", $GLOBALS["lang"]) ?></h5>
                    </li>
                    <?php
                        if ( empty($lastUsers) ) {
                            echo "<li class='collection-item center-align red-text'>" . \syriashop\lib\Languages::lang("dashboardNotFoundUser", $GLOBALS["lang"]) . "</li>"; 
                        } else {
                        foreach ( $lastUsers as $user ) {
                    ?>
                    <li class="collection-item">
                        <div>
                            <?= $user->username ?>
                        </div>
                    </li>
                        <?php } } ?>
                </ul>
            </div>
        </div>
        <div class="col m7 s12">
            <ul class="collection with-header">
                <li class="collection-header white-text first-collection">
                    <h5><i class="material-icons right">add_shopping_cart</i><?= \syriashop\lib\Languages::lang("dashboardLastAds", $GLOBALS["lang"]) ?></h5>
                </li>
               <?php
                    if ( empty($lastAds) ) {
                        echo "<li class='collection-item center-align red-text'>" . \syriashop\lib\Languages::lang("dashboardNotFoundAds", $GLOBALS["lang"]) . "</li>";
                    } else {
                    foreach ( $lastAds as $ads ) {
                    //$srcImg = $ads->my_img == "user.png" ? "/images/user.png" : "/Picture Profile/$ads->username/$ads->my_img" ;
                    $path1 = "$system/images/";
                    $path2 = "$system/Picture Profile" . DS;
                    if ( $ads->user_type == "facebook" ) {
                        $srcImg = $ads->my_img;
                    } else {
                        if ( $ads->my_img == "user.png" ) {
                            $srcImg = "$system/images/user.png";
                        } else {
                            $srcImg = "$system/Picture Profile" . DS . $ads->my_img;
                        }
                    }
                ?>
                <li class="collection-item avatar">
                  <img src="<?= $srcImg ?>" alt="" class="circle">
                  <span class="title"><?= $ads->username ?></span>
                    <p>
                      <?php
                        if ( mb_strlen($ads->item_name) > 20 ) {
                            echo substr($ads->item_name, 0, 20) . "...";
                        } else {
                            echo $ads->item_name;
                        }
                      ?>
                  </p>
                  <p>
                      <?php
                        if ( mb_strlen($ads->item_description) > 25 ) {
                            echo substr($ads->item_description, 0, 25) . "...";
                        } else {
                            echo $ads->item_description;
                        }
                      ?>
                  </p>
                </li>
                    <?php } } ?>
            </ul>
        </div>
        <div class="col s12 m6">
            <h5 class="center-align blue-text darken-3"><?= \syriashop\lib\Languages::lang("dashboardTitleStatistcItems", $GLOBALS["lang"]) ?></h5>
            <div class="" id="chartItems" style="height: 250px;"></div>
        </div>
        <div class="col s12 m6">
            <h5 class="center-align blue-text darken-3"><?= \syriashop\lib\Languages::lang("dashboardTitleStatistcUsers", $GLOBALS["lang"]) ?></h5>
            <div class="" id="chartUsers" style="height: 250px;"></div>
        </div>
    </div>
</div>
<script>
    new Morris.Area({
    element: 'chartItems',
    data: [<?php echo $statistcItems; ?>],
    xkey: 'year',
    ykeys: ['value'],
    labels: ['اعلان']
  });
  /* Line - Area - Bar */
    new Morris.Area({
    element: 'chartUsers',
    data: [<?php echo $statistcUsers; ?>],
    xkey: 'year',
    ykeys: ['value'],
    labels: ['مستخدم']
  });
</script>
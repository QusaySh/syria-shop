<?php
    use syriashop\lib\Languages;
?>
<nav>
  <div class="nav-wrapper">
      <a href="/client" class="brand-logo left"><i class="material-icons left">shop</i>Syria Shop</a>
    <ul class="right hide-on-small-only">
        <?php if ( !isset($_SESSION["myInfo"]) ) { ?>
        <li><a href="/client/signUp"><?= Languages::lang("signUp", $GLOBALS["lang"]) ?><i class="material-icons right">person_add</i></a></li>
        <li><a href="/client/signIn"><?= Languages::lang("signIn", $GLOBALS["lang"]) ?><i class="material-icons right">arrow_back</i></a></li>
        <?php } else if (isset($_SESSION["myInfo"]["admin"])) { ?>
            <li class="link-dropdown">
                <a class="more"><?= Languages::lang("dashboardControlPanel", $GLOBALS["lang"]) ?><i class="material-icons right">dashboard</i></a>
                <ul class="dropdown grey lighten-5 z-depth-1">
                    <li><a href="/dashboard/users/1"><?= Languages::lang("dashboardClients", $GLOBALS["lang"]) ?><i class="material-icons right">person</i></a></li>
                    <li><a href="/dashboard/items/1"><?= Languages::lang("dashboardAds", $GLOBALS["lang"]) ?><i class="material-icons right">add_shopping_cart</i></a></li>
                    <li><a href="/dashboard/categories/1"><?= Languages::lang("dashboardCategories", $GLOBALS["lang"]) ?><i class="material-icons right">list</i></a></li>
                    <li><a href="/dashboard/country/1"><?= Languages::lang("dashboardCountry", $GLOBALS["lang"]) ?><i class="material-icons right">location_on</i></a></li>
                    <li><a href="/dashboard/city/1"><?= Languages::lang("dashboardCity", $GLOBALS["lang"]) ?><i class="material-icons right">my_location</i></a></li>
                    <li><a href="/dashboard/reports/1"><?= Languages::lang("dashboardReports", $GLOBALS["lang"]) ?><i class="material-icons right">report</i></a></li>
                </ul>
            </li>
        <?php } ?>
        <li class="link-dropdown">
            <a class="more"><?= Languages::lang("more", $GLOBALS["lang"]) ?><i class="material-icons right">more</i></a>
            <ul class="dropdown grey lighten-5 z-depth-1">
                <?php if ( !isset($_SESSION["myInfo"]) ) { ?>
                <!-- <li><a href="<?= htmlspecialchars($GLOBALS['linkFacebook']); ?>"><?= Languages::lang("signInFace", $GLOBALS["lang"]) ?><i class="material-icons right">person_pin</i></a></li>-->
                <?php } else { ?>
                    <li><a href="/profile/"><?= Languages::lang("profile", $GLOBALS["lang"]) ?><i class="material-icons right">face</i></a></li>
                <?php } ?>
                <li>
                    <a class="choose-lang link-drop"><?= Languages::lang("chooseLang", $GLOBALS["lang"]) ?><i class="material-icons right">g_translate</i></a>
                    <ul class="dropdown-link-drop">
                        <li><a href="/client/lang/ar">Arabic</a></li>
                        <li><a href="/client/lang/en">English</a></li>
                    </ul>
                </li>
                
                <li>
                    <a class="modal-trigger" href="#country"><?= Languages::lang("country", $GLOBALS["lang"]) ?><i class="material-icons right">location_on</i></a>
                </li>
                <li>
                    <a class="modal-trigger" href="#city"><?= Languages::lang("city", $GLOBALS["lang"]) ?><i class="material-icons right">my_location</i></a>
                </li>
               <?php if ( isset($_SESSION["myInfo"]) ) { ?>
                <li><a href="/client/signOut"><?= Languages::lang("signOut", $GLOBALS["lang"]) ?><i class="material-icons right">exit_to_app</i></a></li>
                <?php } ?>
            </ul>
        </li>
        <li class="link-dropdown">
            <a class="more"><?= Languages::lang("titleGetAds1", $GLOBALS["lang"]) ?><i class="material-icons right">dvr</i></a>
            <ul class="dropdown grey lighten-5 z-depth-1">
                <li><a href="/client/products/2/1"><?= Languages::lang("item1GetAds1", $GLOBALS["lang"]) ?></a></li>
                <li><a href="/client/products/1/1"><?= Languages::lang("item2GetAds1", $GLOBALS["lang"]) ?></a></li>
                <li><a href="/client/products/3/1"><?= Languages::lang("item3GetAds1", $GLOBALS["lang"]) ?></a></li>
                <li><a href="/client/products/4/1"><?= Languages::lang("item4GetAds1", $GLOBALS["lang"]) ?></a></li>
            </ul>
        </li>
        
        <li><a href="/newAds/categories"><?= Languages::lang("categoriesNav", $GLOBALS["lang"]) ?><i class="material-icons right">list</i></a></li>
        
    </ul>
    <ul class="right show-on-small hide-on-med-and-up">
        <li><a data-target="slide-out" class="sidenav-trigger"><i class="material-icons">menu</i></a></li>
    </ul>
  </div>
    
    
<ul id="slide-out" class="sidenav">
<li><div class="user-view">
  <div class="background">
    <img src="<?= $system ?>/images/office.png">
  </div>
    <?php
        $path1 = "$system/images/";
        if ( isset($_SESSION["myInfo"]) ) {
            $img = new syriashop\modals\UsersModals();
            $img->id = $_SESSION["myInfo"]["id"];
            $img = $img->getByKey();
            $path2 = "$system/Picture Profile" . DS;
            if ( $img->user_type == "facebook" ) {
                $src = $img->my_img;
            } else {
                if ( $img->my_img == "user.png" ) {
                    $src = $path1 ."user.png";
                } else {
                    $src = $path2 . $img->my_img;
                }
            }
        } else {
            $src = $path1 . "user.png";
        }
    ?>
  <a href="/profile/"><img class="circle img-nav" src="<?= $src; ?>"></a>
  <a><span class="white-text name"><?= isset($_SESSION['myInfo']) ? $_SESSION['myInfo']['username'] : "Guest" ?></span></a>
  <a><span class="white-text email"><?= isset($_SESSION['myInfo']) ? $_SESSION['myInfo']['email'] : "Guest@guest.com" ?></span></a>
</div></li>
  <?php if ( !isset($_SESSION["myInfo"]) ) { ?>
  <li><a href="/client/signIn"><i class="material-icons right">arrow_back</i><?= Languages::lang("signIn", $GLOBALS["lang"]) ?></a></li>
  <li><a href="/client/signUp"><i class="material-icons right">person_add</i><?= Languages::lang("signUp", $GLOBALS["lang"]) ?></a></li>
  <!--<li><a><?= Languages::lang("signInFace", $GLOBALS["lang"]) ?><i class="material-icons right">person_pin</i></a></li>-->
    <li><a href="/NewAds/categories"><?= Languages::lang("categoriesNav", $GLOBALS["lang"]) ?><i class="material-icons right">list</i></a></li>
  <?php } else if (isset($_SESSION["myInfo"]["admin"])) { ?>
    <li class="link-dropdown">
        <a class="more"><?= Languages::lang("dashboardControlPanel", $GLOBALS["lang"]) ?><i class="material-icons right">dashboard</i></a>
        <ul class="dropdown grey lighten-5 z-depth-1">
            <li><a href="/dashboard/users/1"><?= Languages::lang("dashboardClients", $GLOBALS["lang"]) ?><i class="material-icons right">person</i></a></li>
            <li><a href="/dashboard/items/1"><?= Languages::lang("dashboardAds", $GLOBALS["lang"]) ?><i class="material-icons right">add_shopping_cart</i></a></li>
            <li><a href="/dashboard/categories/1"><?= Languages::lang("dashboardCategories", $GLOBALS["lang"]) ?><i class="material-icons right">list</i></a></li>
            <li><a href="/dashboard/country/1"><?= Languages::lang("dashboardCountry", $GLOBALS["lang"]) ?><i class="material-icons right">location_on</i></a></li>
            <li><a href="/dashboard/city/1"><?= Languages::lang("dashboardCity", $GLOBALS["lang"]) ?><i class="material-icons right">my_location</i></a></li>
            <li><a href="/dashboard/reports/1"><?= Languages::lang("dashboardReports", $GLOBALS["lang"]) ?><i class="material-icons right">report</i></a></li>
        </ul>
    </li>
  <?php } ?>
    <?php if ( isset($_SESSION["myInfo"]) ) { ?>
        <li><a href="/profile/"><?= Languages::lang("profile", $GLOBALS["lang"]) ?><i class="material-icons right">face</i></a></li>
    <?php } ?>
    <li><a href="/newAds/categories"><?= Languages::lang("categoriesNav", $GLOBALS["lang"]) ?><i class="material-icons right">list</i></a></li>
      <li class="link-dropdown">
          <a class="choose-lang more link-drop"><?= Languages::lang("chooseLang", $GLOBALS["lang"]) ?><i class="material-icons right">g_translate</i></a>
          <ul class="dropdown-link-drop dropdown z-depth-1">
              <li><a href="/client/lang/ar">Arabic</a></li>
              <li><a href="/client/lang/en">English</a></li>
          </ul>
      </li>
    <li class="link-dropdown">
        <a class="more"><?= Languages::lang("titleGetAds1", $GLOBALS["lang"]) ?><i class="material-icons right">dvr</i></a>
        <ul class="dropdown grey lighten-5 z-depth-1">
            <li><a href="/client/products/2/1"><?= Languages::lang("item1GetAds1", $GLOBALS["lang"]) ?></a></li>
            <li><a href="/client/products/1/1"><?= Languages::lang("item2GetAds1", $GLOBALS["lang"]) ?></a></li>
            <li><a href="/client/products/3/1"><?= Languages::lang("item3GetAds1", $GLOBALS["lang"]) ?></a></li>
        </ul>
    </li>
    <li class="">
        <a class="modal-trigger" href="#country"><?= Languages::lang("country", $GLOBALS["lang"]) ?><i class="material-icons right">my_location</i></a>
    </li>
  </li>
  <li><div class="divider"></div></li>
  <?php if ( isset($_SESSION["myInfo"]) ) { ?>
  <li><a href="/client/signOut"><i class="material-icons">exit_to_app</i><?= Languages::lang("signOut", $GLOBALS["lang"]) ?></a></li>
  <?php } ?>
</ul>
    
</nav>

<div class="container-search grey lighten-3 z-depth-1 row">
    <form class="center-align" action="/newAds/search" method="POST">
        <input class="col s9 m5 offset-m3" type="search" autocomplete="off" name="search" placeholder="<?= Languages::lang("inputSearch", $GLOBALS["lang"]) ?>" />
        <a class="waves-effect waves-light btn col s3 m1 dark-button-2" name="submitSearch" href="#"><i class="material-icons">search</i></a>
        <div class="container-tags-search">
            <ul class="collection">
            </ul>
        </div>
    </form>
    <span class="show-search center-align pointer"><i class="material-icons">search</i></span>
</div>
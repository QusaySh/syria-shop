<div class="container">
    <div class="row">
        <h3 class="center-align margin-bottom-30"><?= \syriashop\lib\Languages::lang("chooseCat", $GLOBALS["lang"]) ?></h3>
        <?php
            if ( isset($categories) ) { // في حال وجود اقسام فرعية
                if ( !empty($categories) ) {
                    foreach ($categories as $cat) {
        ?>
        <div class="col l3 m4 s6 animated bounceIn">
            <a href="/newAds/default/<?= $cat->categorie_id ?>">
                <div class="card-panel card-cat-categorie z-depth-2 margin-10 center-align light-blue darken-4">
                    <?php if ( $cat->categorie_parent == "main" ) { ?>
                    <img width="50" height="50" src="<?= $system ?>/images/icons_cat/<?= $cat->categorie_icon ?>" alt="<?= $cat->categorie_icon ?>" />
                    <?php } ?>
                    <h6 class="white-text"><?= $cat->categorie_name ?></h6>
                </div>
            </a>
        </div>
        <?php
                    }
                }
            }
        ?>
    </div>
</div>
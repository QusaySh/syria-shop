<div class="container">
    <div class="row">
        <?php
            foreach ($allCat as $cat) {
                if ( $cat->categorie_parent == "main" ) {
        ?>
        <div class="col l4 m6 s12">
            <div class="card-cat">
            <?php if ( $cat->categorie_parent == "main" ) { ?>
                <div class="pointer cat-main">
                    <img class="middle" width="30" height="30" src="/images/icons_cat/<?= $cat->categorie_icon ?>" alt="" />
                    <span class="cat-name middle"><?= $cat->categorie_name ?></span>
                </div>
            <?php
                } else {
                    continue;
                }
            ?>
                <div class="cat-notMain">
                    <ul>
                <?php
                    foreach ( $allCat as $cat2 ) {
                        if ( $cat->categorie_id == $cat2->categorie_parent ) {
                ?>
                        <li>
                            <a href="" class="<?= $cat2->categorie_parent == "main" ? "parent" : "" ?>"><?= $cat2->categorie_name ?></a>
                        </li>
                <?php
                        }
                    }
                ?>
                    </ul>
                </div>
            </div>
        </div>
        <?php
            } }
        ?>
    </div>
</div>
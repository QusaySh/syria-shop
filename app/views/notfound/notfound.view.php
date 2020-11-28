<div class="container">
    <h3 class="center-align"><?= \syriashop\lib\Languages::lang("TitleNotFound", $GLOBALS["lang"]); ?></h3>
    <div class="row card-panel card-panel z-depth-2">
        <div class="col col s12 m5 center-align">
            <img src="<?= $system ?>/images/notfound.png" alt="Not Found" />
        </div>
        <div class="col col s12 m6">
            <h4><?= \syriashop\lib\Languages::lang("notfoundTitle", $GLOBALS["lang"]); ?></h4>
            <ol>
                <li><?= \syriashop\lib\Languages::lang("listError1", $GLOBALS["lang"]); ?></li>
                <li><?= \syriashop\lib\Languages::lang("listError2", $GLOBALS["lang"]); ?></li>
                <li><?= \syriashop\lib\Languages::lang("listError3", $GLOBALS["lang"]); ?></li>
            </ol>
        </div>
        <a href="/client" class="waves-effect waves-light red btn"><?= \syriashop\lib\Languages::lang("backToHome", $GLOBALS["lang"]); ?></a>
    </div>
</div>
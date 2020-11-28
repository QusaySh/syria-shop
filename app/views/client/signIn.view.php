<div class="container">
    <div class="row">
      <div class="col s12 m8 offset-m2">
        <div class="container-signin">
            <div class="center-align">
                <a href="<?= htmlspecialchars($GLOBALS['linkFacebook']); ?>" class="waves-effect waves-light btn blue darken-2"><img class="white-text middle" src="<?= $system ?>/images/facebook.png" /> <?= \syriashop\lib\Languages::lang("signInFace", $GLOBALS["lang"]); ?></a>
                <h5 class="grey-text">OR</h5>
            </div>
            <h3 class="center-align"><?= \syriashop\lib\Languages::lang("signIn", $GLOBALS["lang"]); ?></h3>
            <?php
                if ( isset($message) ){
                    foreach ( $message as $m ) {
                        echo $m;
                    }
                }
            ?>
            <form class="col s12" method="POST">
              <div class="row">
                <div class="input-field col s12">
                  <i class="material-icons prefix">email</i>
                  <input id="email" type="email" name="email" class="validate" value="<?= isset($_COOKIE["remberMe"]) ? $_COOKIE["remberMe"] : null ?>">
                  <label for="email"><?= \syriashop\lib\Languages::lang("email", $GLOBALS["lang"]); ?></label>
                </div>
                <div class="input-field col s12">
                  <i class="material-icons icon-eye prefix">visibility</i>
                  <input id="password" type="password" name="password" class="validate">
                  <label for="password"><?= \syriashop\lib\Languages::lang("password", $GLOBALS["lang"]); ?></label>
                </div>
              </div>
                <p class="center-align">
                  <label>
                      <input type="checkbox" name="remberMe" />
                    <span><?= \syriashop\lib\Languages::lang("remberMe", $GLOBALS["lang"]); ?></span>
                  </label>
                </p>
                <div class="input-field center-align col s12">
                    <button class="btn waves-effect waves-teal indigo dark-button-1 darken-3" type="submit" name="signIn">
                        <?= \syriashop\lib\Languages::lang("signIn", $GLOBALS["lang"]); ?>
                      <i class="material-icons right">arrow_back</i>
                    </button>
                </div>
                <div class="center-align">
                    <a href="/client/resetPassword/enterEmail"><?= \syriashop\lib\Languages::lang("forgetPassword", $GLOBALS["lang"]); ?>؟.</a>
                </div>
                <div class="center-align">
                    <?= \syriashop\lib\Languages::lang("dontHaveAccount", $GLOBALS["lang"]); ?>
                    <a href="/client/signUp"><?= \syriashop\lib\Languages::lang("clickHere", $GLOBALS["lang"]); ?>.</a>
                </div>
            </form>
        </div>
      </div>
    </div>
</div>
<div class="container">
    <div class="row">
      <div class="col s12 m8 offset-m2">
        <div class="container-signin">
            <div class="center-align">
                <a href="<?= htmlspecialchars($GLOBALS['linkFacebook']); ?>" class="waves-effect waves-light btn blue darken-2"><img class="white-text middle" src="<?= $system ?>/images/facebook.png" /> <?= \syriashop\lib\Languages::lang("signInFace", $GLOBALS["lang"]); ?></a>
                <h5 class="grey-text">OR</h5>
            </div>
            <h3 class="center-align"><?= \syriashop\lib\Languages::lang("signUp", $GLOBALS["lang"]) ?></h3>
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
                  <i class="material-icons prefix">person</i>
                  <input id="username" name="username" type="text" autocomplete="off" class="validate input_text"
                         maxlength="40" data-length="40" required pattern=".{4,40}"
                         title="عدد احرف الاسم يجب ان يكون اكبر من 4 احرف و اصغر من 40 حرف">
                  <label for="username"><?= \syriashop\lib\Languages::lang("username", $GLOBALS["lang"]) ?></label>
                </div>
                <div class="input-field col s12">
                  <i class="material-icons prefix">email</i>
                  <input id="email" name="email" type="email" class="validate">
                  <label for="email"><?= \syriashop\lib\Languages::lang("email", $GLOBALS["lang"]) ?></label>
                </div>
                <div class="input-field col s12">
                  <i class="material-icons icon-eye prefix">visibility</i>
                  <input id="password" name="password" type="password" class="validate input_text"
                         maxlength="40" data-length="40" required pattern=".{5,40}"
                         title="عدد احرف كلمة المرور يجب ان يكون اكبر من 5 احرف و اصغر من 40 حرف">
                  <label for="password"><?= \syriashop\lib\Languages::lang("password", $GLOBALS["lang"]) ?></label>
                </div>
                <div class="input-field col s12">
                  <i class="material-icons prefix">security</i>
                  <input id="check" name="check" type="text" autocomplete="off" class="validate">
                  <label for="check"><?= \syriashop\lib\Languages::lang("codeCheck", $GLOBALS["lang"]) ?>: </label>
                </div>
                <div class="input-field center-align col s12">
                    <button class="btn waves-effect waves-teal indigo darken-3 disabled dark-button-1" type="submit" name="signup">
                        <?= \syriashop\lib\Languages::lang("signUp", $GLOBALS["lang"]) ?>
                      <i class="material-icons right">add</i>
                    </button>
                </div>
                <div class="center-align">
                    <?= \syriashop\lib\Languages::lang("haveAccount", $GLOBALS["lang"]) ?>؟<a href="/client/signIn"><?= \syriashop\lib\Languages::lang("clickHere", $GLOBALS["lang"]) ?>.</a>
                </div>
              </div>
            </form>
        </div>
      </div>
    </div>
</div>
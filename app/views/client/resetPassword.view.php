<div class="container">
    <h3 class="center-align"><?= \syriashop\lib\Languages::lang("titleResetPassword", $GLOBALS["lang"]) ?></h3>
<?php
    if ( isset($params) && $params[0] == "enterEmail" ) {
?>
    <div class="row">
        <div class="col s12 m8 offset-m2">
            <?php
                if ( isset($message) ) {
                    foreach ($message as $m) {
                        echo $m;
                    }
                }
            ?>
        </div>
        <form class="col s12" method="POST">
            <div class="input-field col s12 m8 offset-m2">
              <i class="material-icons prefix">email</i>
              <input id="email" type="text" name="email" class="validate">
              <label for="email"><?= \syriashop\lib\Languages::lang("email", $GLOBALS["lang"]); ?></label>
            </div>
            <div class="input-field center-align col s12">
                <button class="btn waves-effect waves-teal indigo darken-3" type="submit" name="enterEmail">
                    <?= \syriashop\lib\Languages::lang("checkEmail", $GLOBALS["lang"]); ?>
                  <i class="material-icons right">email</i>
                </button>
            </div>
        </form>
    </div>
<?php
    } else if ( isset($params) && $params[0] == "enterCode" && isset($_SESSION["reset"]) ) {
?>

<div class="row">
    <form class="col s12" method="POST">
    <div class="row">
        <div class="col s12 m8 offset-m2">
            <?php
                if ( isset($message) ) {
                    echo $message;
                } else {
            ?>
            <div class="card-panel teal">
              <span class="white-text"><?= \syriashop\lib\Languages::lang("noteAfterSendMail", $GLOBALS["lang"]) ?></span>
            </div>
            <?php
                }
            ?>
        </div>
        <div class="input-field col s8 offset-s2">
            <input id="confirm" name="code" class="input_text center-align" type="tel" maxlength="4" required autocomplete="off" data-length="4">
          <label for="confirm"><?= \syriashop\lib\Languages::lang("EnterCode", $GLOBALS["lang"]) ?></label>
        </div>
        <div class="input-field col s12 center-align">
            <button class="btn waves-effect waves-teal indigo darken-3" type="submit" name="confirm">
              <?= \syriashop\lib\Languages::lang("sendCode", $GLOBALS["lang"]) ?>
              <i class="material-icons right">mail</i>
            </button>
        </div>
        <div class="input-field center-align col s12">
            <div class="preloader-wrapper hide small active">
              <div class="spinner-layer spinner-green-only">
                <div class="circle-clipper left">
                  <div class="circle"></div>
                </div><div class="gap-patch">
                  <div class="circle"></div>
                </div><div class="circle-clipper right">
                  <div class="circle"></div>
                </div>
              </div>
            </div>
            <p class="center-align red-text"><?= \syriashop\lib\Languages::lang("resendCode", $GLOBALS["lang"]) ?></p>
        </div>
    </div>
  </form>
</div>
    
<?php
    } else if ( isset($params) && $params[0] == "newPassword" && isset($_SESSION["reset"]) && isset($_SESSION["reset"]["allow"]) ) {
?>

    <div class="row">
        <div class="col s12 m8 offset-m2">
            <?php
                if ( isset($message) ) {
                    foreach ($message as $m) {
                        echo $m;
                    }
                }
            ?>
        </div>
        <form class="col s12" method="POST">
            <div class="input-field col s12 m8 offset-m2">
              <i class="material-icons icon-eye prefix">visibility</i>
              <input id="password" type="password" name="password" class="validate">
              <label for="password"><?= \syriashop\lib\Languages::lang("enterNewPasswprd", $GLOBALS["lang"]); ?></label>
            </div>
            <div class="input-field center-align col s12">
                <button class="btn waves-effect waves-teal indigo darken-3" type="submit" name="newPassword">
                    <?= \syriashop\lib\Languages::lang("save", $GLOBALS["lang"]); ?>
                  <i class="material-icons right">save</i>
                </button>
            </div>
        </form>
    </div>
    
<?php
    } else {
        $this->headerTo("/client/resetPassword/enterEmail");
    }
?>
</div>
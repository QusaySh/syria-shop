<div class="container">
    <h3 class="center-align"><?= \syriashop\lib\Languages::lang("confirmTitle", $GLOBALS["lang"]) ?></h3>
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
                <input id="confirm" name="code" class="input_text center-align" type="tel" maxlength="4"  autocomplete="off" data-length="4">
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
</div>
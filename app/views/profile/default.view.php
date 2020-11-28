<div class="">
    
    <div class="row margin-top-30">
        <div class="img-my-profile col m8 s12 center-align offset-m2">
            <div class="circle z-depth-2">
                <img src="<?= $system ?>/images/user.png" id="myImg" class="materialboxed" alt="Img-profile" />
                <?php if ($dataUser->user_type != "facebook") { ?>
                <div id="container-btn-my-img">    
                <i class="material-icons tiny edit-img-profile blue z-depth-2 white-text">edit</i>
                <form method="POST" id="formMyImg" enctype="multipart/form-data">
                    <input type="file" name="myImg" accept="image/gif, image/png, image/jpeg, image/jpg" />
                    <button type="submit" id="sendMyImg">send</button>
                </form>
                </div>
                <?php } ?>
            </div>
            <b><h4 class="nikeName"><?= isset($dataUser) ? $dataUser->username : "Syria Shop" ?></h4></b>
        </div>
          <div class="col s12">
            <ul class="tabs">
              <li class="tab col s4"><a href="#myAds"><?= \syriashop\lib\Languages::lang("myAds", $GLOBALS["lang"]) ?></a></li>
              <li class="tab col s4"><a class="active" href="#about"><?= \syriashop\lib\Languages::lang("myInfo", $GLOBALS["lang"]) ?></a></li>
              <li class="tab col s4"><a href="#favorite"><?= \syriashop\lib\Languages::lang("favorite", $GLOBALS["lang"]) ?></a></li>
            </ul>
          </div>
        
        <div id="myAds" class="col s12">
            <?php require VIEWS_PATH . DS . "showAdsCards.php"; ?>
        </div>
          
        <div id="about" class="col s12 m8 offset-m2">
            <h4 class="center-align"><?= \syriashop\lib\Languages::lang("myInfo", $GLOBALS["lang"]) ?></h4>
              <ul class="collapsible">
                <li>
                  <div class="collapsible-header">
                      <i class="material-icons">person</i>
                      <span class="nikeName"><?= isset($dataUser) ? $dataUser->username : "" ?></span>
                      <i class="material-icons drop_down large">arrow_drop_down</i>
                  </div>
                    <div class="collapsible-body">
                          <div class="input-field">
                            <i class="material-icons prefix">person</i>
                            <input id="username" name="username" type="text" autocomplete="off" class="validate input_text"
                                   maxlength="40" data-length="40"
                                   value="<?= isset($dataUser) ? $dataUser->username : "" ?>">
                            <label for="username"><?= \syriashop\lib\Languages::lang("username", $GLOBALS["lang"]) ?></label>
                          </div>
                          <div class="input-field center-align">
                              <button class="btn save waves-effect waves-teal indigo darken-3" type="submit" name="save_username">
                                  <?= \syriashop\lib\Languages::lang("save", $GLOBALS["lang"]) ?>
                                <i class="material-icons right">save</i>
                              </button>
                              <div class="preloader-wrapper small hide active">
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
                          </div>
                    </div>
                </li>
                <li>
                  <div class="collapsible-header">
                      <i class="material-icons">email</i><?= isset($dataUser) ? $dataUser->email : "" ?>
                      <?php if ($dataUser->user_type == "facebook") { ?>
                      <span class="red-text" style="font-size: 12px;"> (<?= \syriashop\lib\Languages::lang("can'tChangeEmail", $GLOBALS["lang"]) ?>)</span>
                      <?php } ?>
                      <i class="material-icons drop_down large">arrow_drop_down</i>
                  </div>
                    <?php if ($dataUser->user_type != "facebook") { ?>
                    <div class="collapsible-body">
                          <div class="input-field">
                              <i class="material-icons prefix">email</i>
                              <input id="email" name="email" type="email" class="validate"
                                     value="<?= isset($dataUser) ? $dataUser->email : "" ?>">
                              <label for="email"><?= \syriashop\lib\Languages::lang("email", $GLOBALS["lang"]) ?></label>
                          </div>
                          <div class="input-field center-align">
                              <button class="btn save waves-effect waves-teal indigo darken-3" type="submit" name="save_email">
                                  <?= \syriashop\lib\Languages::lang("save", $GLOBALS["lang"]) ?>
                                <i class="material-icons right">save</i>
                              </button>
                              <div class="preloader-wrapper small hide active">
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
                          </div>
                    </div>
                    <?php } ?>
                </li>
                <?php if ($dataUser->user_type != "facebook") { ?>
                <li>
                  <div class="collapsible-header">
                      <i class="material-icons">visibility</i>********
                      <i class="material-icons drop_down large">arrow_drop_down</i>
                  </div>
                    <div class="collapsible-body">
                          <div class="input-field">
                            <i class="material-icons icon-eye prefix">visibility</i>
                            <input id="password" name="password" type="password" class="validate input_text"
                                   maxlength="40" data-length="40">
                            <label for="password"><?= \syriashop\lib\Languages::lang("password", $GLOBALS["lang"]) ?></label>
                          </div>
                          <div class="input-field center-align">
                              <button class="btn save waves-effect waves-teal indigo darken-3" type="submit" name="save_password">
                                  <?= \syriashop\lib\Languages::lang("save", $GLOBALS["lang"]) ?>
                                <i class="material-icons right">save</i>
                              </button>
                              <div class="preloader-wrapper small hide active">
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
                          </div>
                    </div>
                </li>
                <?php } ?>
              </ul>
        </div>
        
        <div id="favorite" class="col s12">
            <div class="margin-top-30 center-align">
                <div class="preloader-wrapper active container-loading hide">
                  <div class="spinner-layer spinner-red-only">
                    <div class="circle-clipper left">
                      <div class="circle"></div>
                    </div><div class="gap-patch">
                      <div class="circle"></div>
                    </div><div class="circle-clipper right">
                      <div class="circle"></div>
                    </div>
                  </div>
                </div>
            </div>
            <?php require VIEWS_PATH . DS . "profile" . DS . "favorite.php"; ?>
        </div>

    </div>
    
    <div id="loading-upload" class="modal">
      <div class="modal-content">
          <h4 class="margin-bottom-30"><?= \syriashop\lib\Languages::lang("messageLoadingTitleLogo", $GLOBALS["lang"]) ?></h4>
        <div class="progress">
            <div class="determinate"></div>
        </div>
        <p class="red-text"><?= \syriashop\lib\Languages::lang("messageLoadingNoteLogo", $GLOBALS["lang"]) ?></p>
      </div>
    </div>
    
</div>
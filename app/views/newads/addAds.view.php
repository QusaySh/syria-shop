<div class="container">
    <div class="row">
        <form class="col s12 m6 margin-top-30 addAdsForm dropzone" id="my-awesome-dropzone" method="POST"
              enctype="multipart/form-data">
            <h4 class="center-align"><?= \syriashop\lib\Languages::lang("infoAds", $GLOBALS["lang"]) ?></h4>
            <div class="center-align">
                <p class="center-align cat_name">
                    <span><?= \syriashop\lib\Languages::lang("catName", $GLOBALS["lang"]) ?></span>
                    <span class="teal-text"><?= isset($cat_name) ? $cat_name : "" ?>.</span>
                </p>
            </div>
          <div class="row">
            <div class="input-field col s12">
              <i class="material-icons prefix">title</i>
              <input id="item_name" name="item_name" autocomplete="off" type="text" class="validate input_text"
                     maxlength="40" data-length="40">
              <label for="item_name"><?= \syriashop\lib\Languages::lang("inputTitleAds", $GLOBALS["lang"]) ?></label>
            </div>
            <div class="input-field col s12">
              <i class="material-icons prefix">description</i>
              <textarea id="item_description" name="item_description" autocomplete="off" class="materialize-textarea"></textarea>
              <label for="item_description"><?= \syriashop\lib\Languages::lang("inputDescAds", $GLOBALS["lang"]) ?></label>
            </div>
            <div class="input-field col s12">
              <i class="material-icons prefix">toc</i>
              <select class="choose-type-ads" id="item_type" name="item_type">
                <option value="" disabled selected><?= \syriashop\lib\Languages::lang("inputTypeAds", $GLOBALS["lang"]) ?></option>
                <option value="1"><?= \syriashop\lib\Languages::lang("ads", $GLOBALS["lang"]) ?></option>
                <option value="2"><?= \syriashop\lib\Languages::lang("sellAproduct", $GLOBALS["lang"]) ?></option>
                <option value="3"><?= \syriashop\lib\Languages::lang("rentAproduct", $GLOBALS["lang"]) ?></option>
              </select>
              <label><?= \syriashop\lib\Languages::lang("inputTypeAds", $GLOBALS["lang"]) ?></label>
            </div>
            <div class="input-field col s8">
              <i class="material-icons prefix">contact_phone</i>
              <input id="phoneuser" name="phoneuser" autocomplete="off" dir="ltr"  type="tel" class="validate">
              <label for="phoneuser"><?= \syriashop\lib\Languages::lang("phoneuser", $GLOBALS["lang"]) ?></label>
              <span class="helper-text grey-text lighten-2"><?= \syriashop\lib\Languages::lang("Examplephoneuser", $GLOBALS["lang"]) ?></span>
            </div>
            <div class="input-field col s4">
                <select class="choose-type-ads" id="countrykey" name="countrykey">
                <!--<option value="" disabled selected><?= \syriashop\lib\Languages::lang("countryNumber", $GLOBALS["lang"]) ?></option>-->
                <!--<option value=""><?= \syriashop\lib\Languages::lang("countryother", $GLOBALS["lang"]) ?></option>-->
                <option value="+963">+963 سوريا</option>
                <?php
                    /*foreach ($country_key as $key)  {
                ?>
                <option value="<?= $key->location_number ?>"><?= $key->location_number . " " . $key->location_name ?></option>
                <?php } */?>
              </select>
              <label><?= \syriashop\lib\Languages::lang("countryNumber", $GLOBALS["lang"]) ?></label>
            </div>
            <div class="input-field col s12">
              <i class="material-icons prefix">contact_mail</i>
              <input id="whatsapp" name="whatsapp" autocomplete="off" type="tel" class="validate">
              <label for="whatsapp"><?= \syriashop\lib\Languages::lang("whatsapp", $GLOBALS["lang"]) ?></label>
              <span class="helper-text grey-text lighten-2"><?= \syriashop\lib\Languages::lang("Examplephoneuser", $GLOBALS["lang"]) ?></span>
            </div>
            <div class="input-field col s12 price hide">
              <i class="material-icons prefix">attach_money</i>
              <input id="item_price" name="item_price" autocomplete="off" type="number" class="validate">
              <label for="item_price"><?= \syriashop\lib\Languages::lang("priceAds", $GLOBALS["lang"]) ?></label>
            </div>
            <div class="input-field col country s12">
              <i class="material-icons prefix">location_on</i>
              <select class="choose-country" id="item_location" name="item_location">
                <option value="" disabled selected><?= \syriashop\lib\Languages::lang("locationAds", $GLOBALS["lang"]) ?></option>
                <?php
                    foreach ($getCity as $c)  {
                ?>
                <option value="<?= $c->location_name ?>"><?= $c->location_name ?></option>
                <?php } ?>
              </select>
              <label><?= \syriashop\lib\Languages::lang("locationAds", $GLOBALS["lang"]) ?></label>
            </div>
              <div class="input-field file-field col s12">
                <div class="btn black">
                  <span>File</span>
                  <input type="file" id="item_media" name="item_media[]" multiple accept="image/gif, image/png, image/jpeg, image/jpg, video/mp4" />
                </div>
                <div class="file-path-wrapper">
                  <input class="file-path validate" type="text">
                </div>
            </div>
            <div class="input-field col discount hide s12">
                <div class="switch">
                  <label>
                      <input type="checkbox" id="discount">
                    <span class="lever"></span>
                    <?= \syriashop\lib\Languages::lang("discountAds", $GLOBALS["lang"]) ?>
                  </label>
                </div>
            </div>
            <div class="input-field col s12">
              <i class="material-icons prefix">filter_list</i>
              <input id="tags" name="tags" type="text" class="validate">
              <label for="tags"><?= \syriashop\lib\Languages::lang("tags", $GLOBALS["lang"]) ?></label>
              <span class="helper-text grey-text lighten-2"><?= \syriashop\lib\Languages::lang("ExampleTags", $GLOBALS["lang"]) ?></span>
            </div>
            <div class="input-field col center-align s12">
                <button class="btn waves-effect waves-light red darken-3" type="submit" name="sendAds">
                    <?= \syriashop\lib\Languages::lang("sendAds", $GLOBALS["lang"]) ?>
                <i class="material-icons icon-send right">send</i>
                </button>
            </div>
              
          </div>
        </form>
        
        <div class="col s12 m6 card-ads margin-top-30">
            <h4 class="center-align margin-bottom-30"><?= \syriashop\lib\Languages::lang("Adsformat", $GLOBALS["lang"]) ?></h4>
            <div class="card z-depth-2">
                <div class="card-image">
                    <div class="media">
                  <a href="#two!"><img src="<?= $system ?>/images/previewAds-<?= $GLOBALS["lang"] ?>.jpg"></a>
                </div>
                
                <div class="fixed-action-btn">
                  <a class="btn-floating blue darken-2 btn-small">
                    <i class="large material-icons">more_vert</i>
                  </a>
                  <ul>
                    <li><a class="btn-floating green btn-small"><i class="material-icons">edit</i></a></li>
                    <li><a class="btn-floating red btn-small"><i class="material-icons">delete</i></a></li>
                  </ul>
                </div>
                  <span class="item_price hide">0 SY</span>
                  <span class="icon-discount hide"><?= \syriashop\lib\Languages::lang("negotiable", $GLOBALS["lang"]) ?></span>
              </div>
              <div class="card-content">
                <span class="card-title item_name break"><?= \syriashop\lib\Languages::lang("inputTitleAds", $GLOBALS["lang"]) ?></span>
                <p class="item_description break"><?= \syriashop\lib\Languages::lang("inputDescAds", $GLOBALS["lang"]) ?></p>
                <p class="country-container"><i class="material-icons">location_on</i><span class="item_location left"><?= \syriashop\lib\Languages::lang("locationads2", $GLOBALS["lang"]) ?></span></p>
                <p class="date-container"><i class="material-icons">access_time</i><span class="item_add_date left"><?= date("Y-m-d") ?></span></p>
              </div>
            </div>
        </div>
        
        <div id="loading-upload" class="modal">
          <div class="modal-content">
              <h4 class="margin-bottom-30"><?= \syriashop\lib\Languages::lang("messageLoadingTitle", $GLOBALS["lang"]) ?></h4>
            <div class="progress">
                <div class="determinate" style="width: 70%"></div>
            </div>
            <p class="red-text"><?= \syriashop\lib\Languages::lang("messageLoadingNote", $GLOBALS["lang"]) ?></p>
          </div>
        </div>
    </div>
</div>
<div class="container">
    <div class="row">
        <form class="col s12 m6 margin-top-30 addAdsForm dropzone" id="my-awesome-dropzone" method="POST"
              enctype="multipart/form-data" data-key="<?= $myAds->key_hash ?>" data-id="<?= $myAds->item_id ?>">
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
                     maxlength="40" data-length="40" value="<?= $myAds->item_name ?>">
              <label for="item_name"><?= \syriashop\lib\Languages::lang("inputTitleAds", $GLOBALS["lang"]) ?></label>
            </div>
            <div class="input-field col s12">
              <i class="material-icons prefix">description</i>
              <textarea id="item_description" name="item_description" autocomplete="off" class="materialize-textarea"><?= $myAds->item_description ?></textarea>
              <label for="item_description"><?= \syriashop\lib\Languages::lang("inputDescAds", $GLOBALS["lang"]) ?></label>
            </div>
            <div class="input-field col s12">
              <i class="material-icons prefix">toc</i>
              <select class="choose-type-ads" id="item_type" name="item_type">
                <option value="" disabled selected><?= \syriashop\lib\Languages::lang("inputTypeAds", $GLOBALS["lang"]) ?></option>
                <option <?= $myAds->item_type == 1 ? "selected" : "" ?> value="1"><?= \syriashop\lib\Languages::lang("ads", $GLOBALS["lang"]) ?></option>
                <option <?= $myAds->item_type == 2 ? "selected" : "" ?> value="2"><?= \syriashop\lib\Languages::lang("sellAproduct", $GLOBALS["lang"]) ?></option>
                <option <?= $myAds->item_type == 3 ? "selected" : "" ?> value="3"><?= \syriashop\lib\Languages::lang("rentAproduct", $GLOBALS["lang"]) ?></option>
              </select>
              <label><?= \syriashop\lib\Languages::lang("inputTypeAds", $GLOBALS["lang"]) ?></label>
            </div>
            <div class="input-field col s8">
              <i class="material-icons prefix">contact_phone</i>
              <input id="phoneuser" name="phoneuser" autocomplete="off" type="tel" class="validate" value="<?= substr($myAds->phoneuser, 4) ?>">
              <label for="phoneuser"><?= \syriashop\lib\Languages::lang("phoneuser", $GLOBALS["lang"]) ?></label>
              <span class="helper-text grey-text lighten-2"><?= \syriashop\lib\Languages::lang("Examplephoneuser", $GLOBALS["lang"]) ?></span>
            </div>
            <div class="input-field col s4">
                <select class="choose-type-ads"  id="countrykey" name="countrykey">
                <!--<option value="" disabled selected><?= \syriashop\lib\Languages::lang("countryNumber", $GLOBALS["lang"]) ?></option>-->
                <!--<option value=""><?= \syriashop\lib\Languages::lang("countryother", $GLOBALS["lang"]) ?></option>-->
                <option value="+963">+963 سوريا</option>
                <?php
                    /*foreach ($country_key as $key)  {
                ?>
                <option <?= substr($myAds->phoneuser, 0, 4) == $key->location_number ? "selected" : "" ?> value="<?= $key->location_number ?>"><?= $key->location_number . " " . $key->location_name ?></option>
                <?php } */?>
              </select>
              <label><?= \syriashop\lib\Languages::lang("countryNumber", $GLOBALS["lang"]) ?></label>
            </div>
            <div class="input-field col s12">
              <i class="material-icons prefix">contact_mail</i>
              <input id="whatsapp" name="whatsapp" autocomplete="off" type="tel" class="validate" value="<?= substr($myAds->phoneuser, 4) ?>">
              <label for="whatsapp"><?= \syriashop\lib\Languages::lang("whatsapp", $GLOBALS["lang"]) ?></label>
              <span class="helper-text grey-text lighten-2"><?= \syriashop\lib\Languages::lang("Examplephoneuser", $GLOBALS["lang"]) ?></span>
            </div>
            <div class="input-field col s12 price hide">
              <i class="material-icons prefix">attach_money</i>
              <input id="item_price" name="item_price" autocomplete="off" type="number" class="validate" value="<?= $myAds->item_price ?>">
              <label for="item_price"><?= \syriashop\lib\Languages::lang("priceAds", $GLOBALS["lang"]) ?></label>
            </div>
            <div class="input-field col country s12">
              <i class="material-icons prefix">location_on</i>
              <select class="choose-country" id="item_location" name="item_location">
                <option value="" disabled selected><?= \syriashop\lib\Languages::lang("locationAds", $GLOBALS["lang"]) ?></option>
                <?php
                    foreach ($getCity as $c)  {
                ?>
                <option <?= $myAds->item_location == $c->location_name ? "selected" : "" ?> value="<?= $c->location_name ?>"><?= $c->location_name ?></option>
                <?php } ?>
              </select>
              <label><?= \syriashop\lib\Languages::lang("locationAds", $GLOBALS["lang"]) ?></label>
            </div>
            <div class="input-field col s12">
              <i class="material-icons prefix">dehaze</i>
              <select class="choose-country" id="cat_id" name="cat_id">
                <option value="" disabled selected><?= \syriashop\lib\Languages::lang("categorieName", $GLOBALS["lang"]) ?></option>
                <?php
                    foreach ($cat_parent_name as $c)  {
                ?>
                <option <?= $cat_name == $c->categorie_name ? "selected" : "" ?> value="<?= $c->categorie_id ?>"><?= $c->categorie_name ?></option>
                <?php } ?>
              </select>
              <label><?= \syriashop\lib\Languages::lang("categorieName", $GLOBALS["lang"]) ?></label>
            </div>
            <div class="file-field input-field col s12">
              <div class="btn black">
                  <span><i class="material-icons">file_upload</i></span>
                  <input type="file" id="item_media" name="item_media[]" multiple accept="image/gif, image/png, image/jpeg, image/jpg, video/mp4" />
              </div>
              <div class="file-path-wrapper">
                <input class="file-path validate" type="text">
              </div>
            </div>
            <div class="input-field col discount hide s12">
                <div class="switch">
                  <label>
                      <input type="checkbox" <?= $myAds->discount == 1 ? "checked" : "" ?> id="discount">
                    <span class="lever"></span>
                    <?= \syriashop\lib\Languages::lang("discountAds", $GLOBALS["lang"]) ?>
                  </label>
                </div>
            </div>
            <div class="input-field col s12">
              <i class="material-icons prefix">filter_list</i>
              <input id="tags" name="tags" type="text" class="validate" value="<?= $myAds->tags ?>">
              <label for="tags"><?= \syriashop\lib\Languages::lang("tags", $GLOBALS["lang"]) ?></label>
              <span class="helper-text grey-text lighten-2"><?= \syriashop\lib\Languages::lang("ExampleTags", $GLOBALS["lang"]) ?></span>
            </div>
            <div class="input-field col center-align s12">
                <button class="btn waves-effect waves-light teal darken-3 darken-3" type="submit" name="sendAds">
                    <?= \syriashop\lib\Languages::lang("save", $GLOBALS["lang"]) ?>
                <i class="material-icons icon-send right">save</i>
                </button>
            </div>
              
          </div>
        </form>
        
        <div class="col s12 m6 card-ads margin-top-30">
            <h4 class="center-align margin-bottom-30"><?= \syriashop\lib\Languages::lang("productAttachments", $GLOBALS["lang"]) ?></h4>
            <div>
                <div class="media row" data-key="<?= $myAds->key_hash ?>">
                        <?php
                            if ( !empty($myAds->item_media) ) {
                                $images = explode(",", $myAds->item_media);
                                foreach ( $images as $image ) {
                                    echo "<div class='col attachment s6'>";
                                    if (pathinfo($image, PATHINFO_EXTENSION) == "mp4" ) {
                        ?>
                            <a>
                                <video controls>
                                  <source src="<?= $system ?>/items_media/<?= $image ?>" type="video/mp4">
                                </video>
                                <i class="material-icons btn-delete red-text tooltipped" data-filename="<?= $image ?>" data-position="top" data-tooltip="<?= \syriashop\lib\Languages::lang("deleteImg", $GLOBALS["lang"]) ?>">delete</i>
                            </a>
                        <?php
                                    } else {
                        ?>
                            <a>
                                <img src="/items_media/<?= $image ?>" alt="<?= $image ?>">
                                <i class="material-icons btn-delete red-text tooltipped" data-filename="<?= $image ?>" data-position="top" data-tooltip="<?= \syriashop\lib\Languages::lang("deleteImg", $GLOBALS["lang"]) ?>">delete</i>
                            </a>
                        <?php
                                    }
                                    echo "</div>";
                                }
                            } else {
                        ?>
                    <div class="center-align">
                            <a>
                                <img src="<?= $system ?>">/images/notMedia-<?= $GLOBALS["lang"] ?>.jpg" alt="notMedia">
                            </a>
                        </div>
                        <?php
                            }
                        ?>
                    
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
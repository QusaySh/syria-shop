<?php
namespace syriashop\controllers;
use syriashop\modals\cateogriesModals;
use syriashop\lib\FilterInput;
use syriashop\lib\Messages;
use syriashop\lib\Redirect;
use syriashop\modals\CityModals;
use syriashop\modals\LocationModals;
use syriashop\modals\ItemsModals;
use syriashop\modals\UsersModals;
use syriashop\modals\categorieAlarmModals;
use syriashop\modals\ReportsItemsModals;
use syriashop\lib\Languages;
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

class NewAdsController extends AbstractController {
    use FilterInput; use Messages; use Redirect;
    
    public function sendAlarmForUser($email, $username, $cat){
        $mail = new PHPMailer(true);
        try{
            //$mail->SMTPDebug = 2;
            $mail->isSMTP(); // تحديد البروتوكول
            $mail->Host = 'smtp.gmail.com';
            $mail->SMTPAuth = true;
            $mail->Username = 'tt6212015@gmail.com';
            $mail->Password = 'aser515411';
            $mail->SMTPSecure = 'tls';
            $mail->Port = 587; // 587 - 465
            $mail->CharSet = "UTF-8";
            $mail->setFrom('tt6212015@gmail.com', 'Syria Shop'); // البريد المرسل منه
            $mail->addAddress($email); // البريد المرسل اليه
            $mail->addReplyTo('tt6212015@gmail.com', 'Syria Shop');
            $mail->isHTML(true); // يوجد فيه اكواد html
            $mail->Subject = Languages::lang("titleMessageAlarm", $GLOBALS["lang"]); // عنوان الرسالة
            $mail->Body    = '
          <body>
              <!-- container -->
              <section class="contianer" style="margin:30px auto;" >
                  <!-- Start header 0f page -->
                  <header style="background-color: #24243e;background-image: linear-gradient(to right, #24243e, #302b63, #0f0c29);position: relative;bottom: 22px; text-align: center; color: #fff;padding:10px">
                      <h1 style="font-size: 30px;">Syria Shop</h1>
                  </header>
                  <!-- End header 0f page -->
                  <!-- Start Message -->
                  <section class="message" style="background-color: #fff;padding: 20px;margin: auto;margin-bottom: 25px;border-radius: 5px;
                  box-shadow: 0 0 10px 1px #ccc;">
                      <h2 style="
                      font-size: 20px;
                      text-align: center;
                      letter-spacing: 1px;
                      padding-bottom: 20px;"><span>' . Languages::lang("wellcomeConfirm", $GLOBALS["lang"]) . " " . $username  . '</span></h2>
                      <p style="font-size: 18px; 
                      direction: rtl;
                      text-align: center;
                      line-height: 36px;">' . Languages::lang("messageAlarm1", $GLOBALS["lang"]) . " $cat " . Languages::lang("messageAlarm2", $GLOBALS["lang"]) . '</p>
                      <p style="font-size: 18px; 
                      direction: rtl;
                      text-align: center;
                      line-height: 36px;">' . Languages::lang("messageAlarm3", $GLOBALS["lang"]) . '</p>
                  </section>
                  <!-- End Message -->
                  <!-- Strat copy right -->
                  <section class="copy-right" style="background-color: #000;
                  padding: 10px;    
                  margin: auto;        
                  color: #fff;
                  text-align: center;">
                      <span>' . Languages::lang("footerConfirm", $GLOBALS["lang"]) . '</span>
                      <!-- Start clear fix -->
                      <div class="clear" style="clear: both;"></div>
                      <!-- End clear fix -->            
                  </section>
                  <!-- end copy right -->
              </section>
          </body>
          ';
            $mail->AltBody = strip_tags($mail->Body);
            $mail->send();
            return true;
        } catch ( Exception $e ) {                    
            return false;
        }
    }
    
    public function defaultAction(){
        if ( isset($_SESSION["myInfo"]) ) {
            // التحقق من حظر المستخدم
            $user = new UsersModals();
            $isBlock = $user->getByColumn("id", $_SESSION["myInfo"]["id"]);
            if ( $isBlock->block == 1 ) {
                $this->headerTo("/client/default");
            }
            $cat = new cateogriesModals;
            $cat_id = isset($this->_params[0]) ? $this->filterInt($this->_params[0]) : null;
            if ( empty($cat_id) ) {
                $categorie = $cat->getByColumn("categorie_parent", "main", "all");
            } else {
                $categorie = $cat->getByColumn("categorie_parent", $cat_id, "all");
            }
            if ( empty($categorie) ) {
                $_SESSION["cat_id"] = $this->_params[0]; // حفظ القسم الذي اختاره المستخدم
                $this->headerTo("/newAds/addAds");
            } else {
                $this->_data["categories"] = $categorie;
            }
            $this->_view();
        } else {
            $this->headerTo("/client/signIn");
        }
    }
    // اضافة منتج
    public function addAdsAction(){
        // التحقق من حظر المستخدم
        $user = new UsersModals();
        $isBlock = $user->getByColumn("id", $_SESSION["myInfo"]["id"]);
        if ( $isBlock->block == 1 ) {
            $this->headerTo("/client/default");
        }
        if ( isset($_SESSION["myInfo"]) ) {
            if ( isset($_SESSION["cat_id"]) ) { // في حال تم اختيار قسم
                // جلب المدن حسب البلد
                $city = new CityModals();
                $getCity = $city->sql("ci.location_name", "location_country as co, location_city as ci",
                  " where co.location_country_id = ci.location_country_id AND ci.location_country_id = ?", $GLOBALS["country"], "all");
                $this->_data["getCity"] = $getCity;
                // جلب مفتاح البلد
                $country = new LocationModals();
                $getKey = $country->getAll();
                $this->_data['country_key'] = $getKey;
                $catName = new \syriashop\modals\cateogriesModals();
                $catN = $catName->getByColumn("categorie_id", $_SESSION["cat_id"]);
                $this->_data["cat_name"] = $catN->categorie_name;

                $this->_view();
            } else {
                $this->headerTo("/newAds/");
            }
        } else {
            $this->headerTo("/client/");
        }
    }
    public function sendAdsAction(){
        if ( isset($_POST["sendAds"]) ) {
            $newItem = new ItemsModals();
            $upload = new \syriashop\lib\Upload();
            
            $newItem->key_hash = uniqid("item", true);
            $newItem->item_name = $this->filterStr($_POST["item_name"]);
            $newItem->item_description = $this->filterStr($_POST["item_description"]);
            $newItem->item_price = $this->filterInt($_POST["item_price"]);
            date_default_timezone_set("Asia/Qatar");
            $newItem->item_add_date = date("Y-m-d h:i:s A");
            $time = strtotime("+3 day");
            $newItem->item_end_date = date("Y-m-d h:i:s A", $time);
            $newItem->tags = $this->filterStr($_POST["tags"]);
            $newItem->item_type = $this->filterInt($_POST["item_type"]);
            $newItem->phoneuser = !empty($_POST["countrykey"]) ? $this->filterInt($_POST["countrykey"]) . $this->filterInt($_POST["phoneuser"]) : $this->filterInt($_POST["phoneuser"]);
            $newItem->whatsapp = !empty($_POST["countrykey"]) ? $this->filterInt($_POST["countrykey"]) . $this->filterInt($_POST["whatsapp"]) : $this->filterInt($_POST["whatsapp"]);
            $newItem->item_location = $this->filterStr($_POST["item_location"]);
            $itemCountry = $newItem->sql("location_name", "location_country", "where location_country_id = {$this->filterInt($GLOBALS["country"])}");
            $newItem->item_country = $itemCountry->location_name;
            $newItem->discount = $this->filterInt($_POST["discount"]);
            $newItem->cat_id = $this->filterInt($_SESSION["cat_id"]);
            $newItem->user_id = $_SESSION["myInfo"]["id"];
            
            if ( isset($_FILES["item_media"]) ) { // في حال اختيار صورة
                $newItem->img = $_FILES["item_media"];
            }
            
            if ( $newItem->checkInputInsert() ) { // التحقق من المدخلات
                $result["status"] = "error";
                $result["message"] = $newItem->showMessages();
            } else {
                if ( !empty($newItem->img) ) { // في حال اختيار صور
                    for ( $i = 0; $i < count($newItem->img["name"]); $i++ ) {
                        $newItem->img["name"][$i] = uniqid() . substr(time(), 0, 2) . "." . pathinfo($newItem->img["name"][$i], PATHINFO_EXTENSION);
                        $nameImg = $newItem->img["name"][$i];
                        if ( in_array(pathinfo($newItem->img["name"][$i], PATHINFO_EXTENSION), ALLOW_VEDIO) ) {
                            move_uploaded_file($newItem->img["tmp_name"][$i], LOGO_PATH . DS . "items_media" . DS . $nameImg);
                        } else if ( in_array(pathinfo($newItem->img["name"][$i], PATHINFO_EXTENSION), ALLOW_IMG) ) {
                            $d = $upload->compress($newItem->img["tmp_name"][$i], LOGO_PATH . DS . "items_media" . DS . $nameImg, 40);
                            move_uploaded_file($d, $newItem->img["tmp_name"][$i]);
                        }
                        $newItem->item_media[] = $nameImg;
                    }
                    $newItem->item_media = implode(",", $newItem->item_media);
                }
                if ( $newItem->insert() ) {
                    $result["status"] = "success";
                    $result["message"] = $this->messageAjaxSuccess(Languages::lang("messageSuccessAddAds", $GLOBALS["lang"]));
                    // Send Mail For Users
                    $cat_alarm = new categorieAlarmModals();
                    $cat = new cateogriesModals();
                    $user = new UsersModals();
                    // جلب الاشخاص الذين قامو بتفعيل الاشعارات لنوع الاعلان هذا
                    $getInfoAlarm = $cat_alarm->sql("*", "categorie_alarms", "WHERE categorie_id = ?", $newItem->cat_id, "all");
                    // جلب اسم القسم الذي سيضاف به الاعلان
                    $catName = $cat->getByColumn("categorie_id", $newItem->cat_id);
                    if ( !empty($getInfoAlarm) ) {
                        foreach ( $getInfoAlarm as $alarm ) {
                            $getInfoUser = $user->getByColumn("id", $alarm->user_id);
                            $this->sendAlarmForUser($getInfoUser->email, $getInfoUser->username, $catName->categorie_name);
                        }
                    }
                } else {
                    $result["status"] = "error";
                    $result["message"] = $this->messageAjaxSuccess(Languages::lang("messageErrorAddAds", $GLOBALS["lang"]));
                }
            }
            header("content-type: application/json");
            echo json_encode($result);
        }
    }
    // تعديل منتج
    public function editAdsAction(){
        $items = new ItemsModals();
        $key = isset($this->_params[0]) ? $this->_params[0] : "";
        if ( isset($key) ) { // في حال وجود بارمتر
            $param = $items->sql("*", "items", "WHERE key_hash = '$key' AND user_id = {$_SESSION['myInfo']['id']}");
            if ( !empty($param) ) { // في حال كان هذا المنتج موجود ولشخص نفسه
                $myAds = $items->getByColumn("key_hash", $key);
                $this->_data["myAds"] = $myAds;
                // جلب اسم القسم
                $catName = new \syriashop\modals\cateogriesModals();
                $catN = $catName->getByColumn("categorie_id", $myAds->cat_id);
                $this->_data["cat_name"] = $catN->categorie_name;
                $allCatParent = $catName->getByColumn("categorie_parent", $catN->categorie_parent, "all");
                $this->_data["cat_parent_name"] = $allCatParent;
                // جلب مفتاح البلد
                $country = new LocationModals();
                $getKey = $country->getAll();
                $this->_data['country_key'] = $getKey;
            } else {
                $this->headerTo("/client/default");
            }
        }
        $city = new CityModals();
        $getCity = $city->sql("ci.location_name", "location_country as co, location_city as ci",
          " where co.location_country_id = ci.location_country_id AND ci.location_country_id = ?", $GLOBALS["country"], "all");
        $this->_data["getCity"] = $getCity;
        $this->_view();
    }
    public function updateAdsAction(){
        $newItem = new ItemsModals();
        $upload = new \syriashop\lib\Upload();
        
        $newItem->item_id = $this->filterInt($_POST["id"]);
        $newItem->item_name = $this->filterStr($_POST["item_name"]);
        $newItem->item_description = $this->filterStr($_POST["item_description"]);
        $newItem->item_price = $this->filterInt($_POST["item_price"]);
        $newItem->tags = $this->filterStr($_POST["tags"]);
        $newItem->item_type = $this->filterInt($_POST["item_type"]);
        $newItem->phoneuser = !empty($_POST["countrykey"]) ? $this->filterInt($_POST["countrykey"]) . $this->filterInt($_POST["phoneuser"]) : $this->filterInt($_POST["phoneuser"]);
        $newItem->whatsapp = !empty($_POST["countrykey"]) ? $this->filterInt($_POST["countrykey"]) . $this->filterInt($_POST["whatsapp"]) : $this->filterInt($_POST["whatsapp"]);
        $newItem->item_location = $this->filterStr($_POST["item_location"]);
        $itemCountry = $newItem->sql("location_name", "location_country", "where location_country_id = {$this->filterInt($GLOBALS["country"])}");
        if ( isset($_FILES["item_media"]) ) { // في حال اختيار صورة
            $newItem->img = $_FILES["item_media"];
        }
        $newItem->item_country = $itemCountry->location_name;
        $newItem->cat_id = $this->filterInt($_POST["cat_id"]);
        $newItem->discount = isset($_POST["discount"]) ? $this->filterInt($_POST["discount"]) : null;
        if ( $newItem->checkInputInsert() ) { // التحقق من المدخلات
            $result["status"] = "error";
            $result["message"] = $newItem->showMessages();
        } else {

            if ( !empty($newItem->img) ) { // في حال اختيار صور
                for ( $i = 0; $i < count($newItem->img["name"]); $i++ ) {
                    $newItem->img["name"][$i] = uniqid() . substr(time(), 0, 2) . "." . pathinfo($newItem->img["name"][$i], PATHINFO_EXTENSION);
                $nameImg = $newItem->img["name"][$i];
                    if ( in_array(pathinfo($newItem->img["name"][$i], PATHINFO_EXTENSION), ALLOW_VEDIO) ) {
                        move_uploaded_file($newItem->img["tmp_name"][$i], LOGO_PATH . DS . "items_media" . DS . $nameImg);
                    } else {
                        $d = $upload->compress($newItem->img["tmp_name"][$i], LOGO_PATH . DS . "items_media" . DS . $nameImg, 40);
                        move_uploaded_file($d, $newItem->img["tmp_name"][$i]);
                    }
                    $newItem->item_media[] = $nameImg;
                }
                $media1 = $newItem->item_media; // الصور الجديدة
                $media = $newItem->getByColumn("key_hash",$_POST["key_hash"]); // جلب الصور القديمة
                $media2 = explode(",", $media->item_media);
                $allMedia = array_merge($media2, $media1); // دمج الصور القديمة مع الجديدة
                $newItem->item_media = trim(implode(",", $allMedia), ",");
            } else {
                $media = $newItem->getByColumn("key_hash",$_POST["key_hash"]);
                $newItem->item_media = $media->item_media;
            }
            if ( $newItem->update() ) {
                $result["status"] = "success";
                $result["message"] = $this->messageAjaxSuccess(Languages::lang("messageSuccessAddAds", $GLOBALS["lang"]));
            } else {
                $result["status"] = "error";
                $result["message"] = $this->messageAjaxSuccess(Languages::lang("messageErrorAddAds", $GLOBALS["lang"]));
            }
        }
        header("content-type: application/json");
        echo json_encode($result);
    }
    public function deleteMediaAction(){
        if ( isset($_POST["deleteMedia"]) ) {
            $Ads = new ItemsModals;
            $key = $_POST["key"];
            $filename = $_POST["filename"];
            
            $dataAds = $Ads->getByColumn("key_hash", $key);
            $media = explode(",", $dataAds->item_media); // جلب المرفقات
            if ( in_array($filename, $media) ) {
                unset($media[array_search($filename, $media)]); // ازالة الصورة من المصفوفة
                $media = implode(",", $media); // اعادة تحويلها لنص
                if ( $Ads->updateSingle("item_media = '$media'", "key_hash = '$key'") ) {
                    $srcFile = LOGO_PATH . DS . "items_media" . DS . $filename;
                    if ( file_exists($srcFile) ) {
                        unlink($srcFile);
                    }
                    $result["status"] = "success";
                    $result["message"] = $this->messageAjaxSuccess(Languages::lang("deletedAttachment", $GLOBALS["lang"]));;
                } else {
                    $result["status"] = "error";
                    $result["message"] = $this->messageAjaxError(Languages::lang("errorDeletedAttachments", $GLOBALS["lang"]));
                }
            } else {
                $result["status"] = "error";
                $result["message"] = $this->messageAjaxError(Languages::lang("notFoundAttachments", $GLOBALS["lang"]));
            }
            header("content-type: application/json");
            echo json_encode($result);
        }
    }
    // حذف منتج
    public function deleteAdsAction(){
        if ( isset($_POST["deleteAds"]) ) {
            $key = strip_tags($_POST["key"]);
            $ads = new ItemsModals;
            
            // حذف الميديا
            $getAds = $ads->sql("item_media", "items", "where key_hash = ?", $key);
            if ( !empty($getAds->item_media) ) {
                $media = explode(",", $getAds->item_media);
                foreach ($media as $m) {
                    $file =  LOGO_PATH . DS . "items_media" . DS . $m;
                    if ( file_exists($file) ) {
                        unlink($file);
                    }
                }
            }

            if ( $ads->delete(" WHERE key_hash = '$key'") ) {
                $result["status"] = "success";
                $result["message"] = $this->messageAjaxSuccess(Languages::lang("messageDeleteAddAds", $GLOBALS["lang"]));
            } else {
                $result["status"] = "error";
                $result["message"] = $this->messageAjaxSuccess(Languages::lang("messageErrorAddAds", $GLOBALS["lang"]));
            }
            header("content-type: application/json");
            echo json_encode($result);
        }
    }
    // اضافة المنتج الى المفضلة
    public function saveAdsAction(){
        if ( isset($_POST["save_ads"]) ) {
            $key = $this->filterStr($_POST["key"]);
            $user = new UsersModals();
            // جلب بيانات المستخدم
            $user->id = $_SESSION["myInfo"]["id"];
            $dataUser = $user->getByKey();
            // جلب بيانات الاعلان المراد حفظه
            $ads = new ItemsModals();
            $dataAds = $ads->getByColumn("key_hash", $key);
            $getFav = explode(",", $dataUser->favorite);
            if ( in_array($dataAds->item_id, $getFav) ) {
                unset($getFav[array_search($dataAds->item_id, $getFav)]);
                $getFav = trim(implode(",", $getFav), ",");
                if ( $user->updateSingle("favorite = '$getFav'", "id = $user->id") ) {
                    $result["status"] = "remove";
                    $result["message"] = $this->messageAjaxSuccess(Languages::lang("successRemoveFavorite", $GLOBALS["lang"]));
                } else {
                    $result["status"] = "remove";
                    $result["message"] = $this->messageAjaxSuccess(Languages::lang("errorRemoveFavorite", $GLOBALS["lang"]));
                }
            } else {
                array_push($getFav, $dataAds->item_id);
                $getFav = trim(implode(",", $getFav), ",");
                if ( $user->updateSingle("favorite = '$getFav'", "id = $user->id") ) {
                    $result["status"] = "add";
                    $result["message"] = $this->messageAjaxSuccess(Languages::lang("successAddFavorite", $GLOBALS["lang"]));
                } else {
                    $result["status"] = "add";
                    $result["message"] = $this->messageAjaxSuccess(Languages::lang("errorAddFavorite", $GLOBALS["lang"]));
                }
            }
            header("content-type: application/json");
            echo json_encode($result);
        }
    }
    // ابلاغ عن منتج
    public function reportItemAction(){
        $report = new ReportsItemsModals();
        if ( isset($_POST["report"]) ) {
            $report->report_text = $this->filterStr($_POST["report_text"]);
            $report->report_to = $this->filterInt($_POST["id"]);
            $report->report_to_key = $this->filterStr($_POST["key"]);
            if ( $report->checkInput() ) {
                $result["status"] = "error";
                $result["message"] = $report->showMessage();
            } else {
                $report->insert();
                $result["status"] = "success";
                $result["message"] = $this->messageAjaxSuccess(Languages::lang("reportsClientMessageSuccess", $GLOBALS["lang"]));
            }
            header("content-type: application/json");
            echo json_encode($result);
        }
    }
    // عرض الاعلانات ضمن فئات
    public function categoriesAction(){
            $cat_id = isset($this->_params[0]) ? $this->filterInt($this->_params[0]) : null;
            $cat = new cateogriesModals;
            $ads = new ItemsModals();
            
            // في حال اختيار مدينة لعرض اعلاناتها
            $whereCity1 = isset($_COOKIE['city']) && $_COOKIE['city'] != 'all' ? "AND item_location = '{$_COOKIE['city']}'" : "";
            $whereCity2 = isset($_COOKIE['city']) && $_COOKIE['city'] != 'all' ? "WHERE item_location = '{$_COOKIE['city']}'" : "";
            
            $cat->categorie_id = $cat_id;
            $getCat = $cat->getByKey();

            if ( empty($cat_id) ) {
                $categorie = $cat->getByColumn("categorie_parent", "main", "all");
            } else {
                $categorie = $cat->getByColumn("categorie_parent", $cat_id, "all");
                if ( $getCat === false ) { // في حال قام الشخص بكتابة رقم قسم غير موجود
                    $this->headerTo("/notFound/notFound");
                }
            }
            if ( empty($categorie) ) { // في حال عدم وجود اقسام
                // تعدد الصفات
                if ( !isset($this->_params[1]) ) {
                    $page = 1;
                } else {
                    $page = (int) $this->_params[1];
                }
                $records_at_page = COUNT_ADS; /// كم سجل بدي يظهر
                $itemCountry = $ads->sql("location_name", "location_country", "where location_country_id = {$this->filterInt($GLOBALS["country"])}");
                $record_count = $ads->rowCount("items", "WHERE cat_id = $cat_id $whereCity1 AND item_country = '$itemCountry->location_name'"); // عدد السجلات
                $pages_count = (int)ceil($record_count / $records_at_page);
                $this->_data["thePage"] = array(
                    "page" => $page,
                    "pages" => $pages_count
                );
                $start = ($page - 1) * $records_at_page;
                $end = $records_at_page;
                $this->_data["thePage"]['start']  = $start;
                $this->_data["thePage"]['end']  = $end;
                // جلب معلومات الاعلان مع معرف المستخدم والمفضلة الخاصة  به
                if ( isset($_SESSION["myInfo"]) ) { // من اجل زر الحفظ
                    $allAds = $ads->sql(
                            "items.*, users.id, users.favorite, DATEDIFF('" . date("Y-m-d h:i:s") . "', items.item_add_date) as datedif, HOUR(items.item_add_date) AS hour,"
                            . "minute(items.item_add_date) AS min, DAYNAME(items.item_add_date) AS day, YEAR(items.item_add_date) AS year,"
                            . "MONTH(items.item_add_date) AS month, DAY(items.item_add_date) AS day_num", "items, users", "WHERE cat_id = $cat_id $whereCity1 AND users.id = {$_SESSION['myInfo']['id']} AND item_country = ? ORDER BY item_id DESC LIMIT $start,$end", $itemCountry->location_name, "all");
                } else {
                    $allAds = $ads->sql(
                            "*, DATEDIFF('" . date("Y-m-d h:i:s") . "', items.item_add_date) as datedif, HOUR(items.item_add_date) AS hour,"
                            . "minute(items.item_add_date) AS min, DAYNAME(items.item_add_date) AS day, YEAR(items.item_add_date) AS year,"
                            . "MONTH(items.item_add_date) AS month, DAY(items.item_add_date) AS day_num", "items", "WHERE cat_id = $cat_id $whereCity1 AND item_country = ? ORDER BY item_id DESC LIMIT $start,$end", $itemCountry->location_name, "all");
                }
                
                
                // للتاكد من الشخص مفعل التنبيهات للقسم ام لا
                $catAlarm = new categorieAlarmModals();
                $checkAlarm = isset($_SESSION['myInfo']) ? $catAlarm->rowCount("categorie_alarms",
                        "WHERE categorie_id = $cat_id AND user_id = {$_SESSION['myInfo']['id']}")
                        : "false";
                $this->_data['alarm'] = $checkAlarm;
                // جلب عدد الاعلانات في القسم
                $this->_data['count_cat'] = $cat->rowCount("items", "WHERE cat_id = $cat_id");
                $cat->categorie_id = $cat_id;
                // جلب اسم القسم و الوصف
                $this->_data["info_cat"] = $cat->getByKey();
                if ( !empty($allAds) ) {
                    $this->_data["allAds"] = $allAds;
                } else {
                    $this->_data["allAds"] = $this->message("orange lighten-1", Languages::lang("notFoundAds", $GLOBALS["lang"]));;
                }
            } else {
                $this->_data["categories"] = $categorie;
            }
        $this->_view();
    }
    public function categoriesShowAction(){
        $cat = new cateogriesModals;
        $getCat = $cat->getAll();
        $this->_data["allCat"] = $getCat;
        $this->_view();
    }
    // تفعيل التنبيهات للاقسام
    public function enableAlarmAction(){
        if ( isset($_POST["setAlarm"]) ) {
            $catAlarm = new categorieAlarmModals();
            $categorie_id = $this->filterInt($_POST["cat_id"]);
            // جلب عدد السجلات للتاكد هل الشخص قام بالتفعيل مسبقا
            $issetAlarm = $catAlarm->rowCount("categorie_alarms", "WHERE categorie_id = $categorie_id AND user_id = {$_SESSION['myInfo']['id']}");
            // في حال قام الشخص بالتفعيل مسبقا
            if ( $issetAlarm > 0 ) { // في حال قمت بالتفعيل مسبقا
                if ( $catAlarm->delete(" WHERE categorie_id = $categorie_id AND user_id = {$_SESSION['myInfo']['id']}") ) {
                    $result["status"] = "remove";
                    $result["message"] = $this->messageAjaxSuccess(Languages::lang("disableAlarm", $GLOBALS["lang"]));
                } else {
                    $result["message"] = $this->messageAjaxError(Languages::lang("AnUnexpectedErrorOccurred", $GLOBALS["lang"]));
                }
            } else {
                $catAlarm->categorie_id = $categorie_id;
                $catAlarm->user_id = $_SESSION['myInfo']["id"];
                if ( $catAlarm->insert("categorie_id = $catAlarm->categorie_id, user_id = $catAlarm->user_id") ) {
                    $result["status"] = "add";
                    $result["message"] = $this->messageAjaxSuccess(Languages::lang("enableAlarm", $GLOBALS["lang"]));
                } else {
                    $result["message"] = $this->messageAjaxError(Languages::lang("AnUnexpectedErrorOccurred", $GLOBALS["lang"]));
                }
            }
            header("content-type: application/json");
            echo json_encode($result);
        }
    }
    // عرض الاعلان
    public function showAdsAction(){
        $keyHash = isset($this->_params[0]) ? $this->filterStr($this->_params[0]) : null;
        if ( $keyHash != null ) { // في حال قام الشخص بحذف البرامتر
            $getAdsObj = new ItemsModals;
                $getAds = $getAdsObj->sql(
                    "items.*, users.id, users.favorite, users.user_type, users.username, users.my_img, categories.categorie_id, categories.categorie_name, DATEDIFF('" . date("Y-m-d h:i:s") . "', items.item_add_date) as datedif, HOUR(items.item_add_date) AS hour,"
                    . "minute(items.item_add_date) AS min, DAYNAME(items.item_add_date) AS day, YEAR(items.item_add_date) AS year,"
                    . "MONTH(items.item_add_date) AS month, DAY(items.item_add_date) AS day_num", "items, users, categories", "WHERE items.key_hash = ? AND users.id = items.user_id AND categories.categorie_id = items.cat_id", $keyHash);
                $getCatForThis = $getAdsObj->sql("cat_id", "items", "WHERE key_hash = '$keyHash'"); // جلب قسم الاعلان
                if ( empty($getCatForThis) ) { // في حال عدم وجود القسم هذا يدل ان الاعلان حذف
                    $this->headerTo("/notFound/notFound");
                }
                // جلب الاعلانات ذات الصلة بهذا الاعلان
                $getAdsOthers = $getAdsObj->sql("item_media, key_hash", "items", "WHERE cat_id = $getCatForThis->cat_id AND key_hash != '$keyHash' ORDER BY RAND() LIMIT 4", null, "all");
            if ( !empty($getAds) ) { // في حال وجود هذا المنتج
                $this->_data["ads"] = $getAds;
                $this->_data["adsOthers"] = $getAdsOthers;
                // اضافة عداد مشاهدة
                if ( !isset($_COOKIE[$getAds->item_id]) ) {
                    setcookie($getAds->item_id, base64_encode($getAds->key_hash), strtotime("+1 day"));
                    $newView = (int)$getAds->views + 1;
                    $getAdsObj->updateSingle("views = $newView", "item_id = $getAds->item_id");
                }
                $this->_view();
            } else {
                $this->headerTo("/notFound/notFound");
            }
        } else {
            $this->headerTo("/client/default");
        }
    }
    // البحث عن اعلان
    public function searchAction(){
        if ( isset($_GET['s']) ) {
            $search = str_replace("+", " ", $this->filterStr($_GET['s']));
            $this->_data["search"] = $search;
            // تعدد الصفات
            if ( !isset($this->_params[0]) ) {
                $page = 1;
            } else {
                $page = (int) $this->_params[0];
            }
            $records_at_page = COUNT_ADS; /// كم سجل بدي يظهر
            $ads = new ItemsModals();
            //جلب بلد المستحدم
            $itemCountry = $ads->sql("location_name", "location_country", "where location_country_id = {$this->filterInt($GLOBALS["country"])}");
            $record_count = $ads->rowCount("items", "WHERE item_country = '$itemCountry->location_name' AND tags LIKE '%$search%'"); // عدد السجلات
            $pages_count = (int)ceil($record_count / $records_at_page);
            $this->_data["thePage"] = array(
                "page" => $page,
                "pages" => $pages_count
            );
            $start = ($page - 1) * $records_at_page;
            $end = $records_at_page;
            $this->_data["thePage"]['start']  = $start;
            $this->_data["thePage"]['end']  = $end;
            // جلب معلومات الاعلان مع معرف المستخدم والمفضلة الخاصة  به
            if ( isset($_SESSION["myInfo"]) ) { // من اجل زر الحفظ
                $allAds = $ads->sql(
                        "items.*, users.id, users.favorite, DATEDIFF('" . date("Y-m-d h:i:s") . "', items.item_add_date) as datedif, HOUR(items.item_add_date) AS hour,"
                        . "minute(items.item_add_date) AS min, DAYNAME(items.item_add_date) AS day, YEAR(items.item_add_date) AS year,"
                        . "MONTH(items.item_add_date) AS month, DAY(items.item_add_date) AS day_num", "items, users", "WHERE users.id = {$_SESSION['myInfo']['id']} AND tags LIKE '%$search%' AND item_country = ? ORDER BY item_id DESC LIMIT $start,$end", $itemCountry->location_name, "all");
            } else {
                $allAds = $ads->sql(
                        "*, DATEDIFF('" . date("Y-m-d h:i:s") . "', items.item_add_date) as datedif, HOUR(items.item_add_date) AS hour,"
                        . "minute(items.item_add_date) AS min, DAYNAME(items.item_add_date) AS day, YEAR(items.item_add_date) AS year,"
                        . "MONTH(items.item_add_date) AS month, DAY(items.item_add_date) AS day_num", "items", "WHERE item_country = ?  AND tags LIKE '%$search%' ORDER BY item_id DESC LIMIT $start,$end", $itemCountry->location_name, "all");
            }
            if ( !empty($allAds) ) {
                $this->_data["allAds"] = $allAds;
            } else {
                $this->_data["allAds"] = $this->message("orange lighten-1", Languages::lang("notFoundAds", $GLOBALS["lang"]));;
            }
        } else {
            $this->headerTo("/client/default");
        }
        $this->_view();
    }
    // جلب التاغ التي طلبها المستخدم
    public function getTagsAction(){
        if ( isset($_POST["tags"]) ) {
            $getTags = new ItemsModals;
            $tagInput = $this->filterStr($_POST["tags"]);
           $getTags = $getTags->sql("item_id, key_hash, tags", "items", "where tags LIKE '%" . $tagInput . "%'", null, "all");
            $result["message"] = $getTags;
            header("content-type: application/json");
            echo json_encode($result);
        }
    }
}

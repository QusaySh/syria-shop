<?php
namespace syriashop\controllers;
use syriashop\modals\UsersModals;
use syriashop\modals\ItemsModals;
use \syriashop\lib\Languages;
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

class ClientController extends AbstractController {
    use \syriashop\lib\Redirect; // استخدام تريت اعادة التحويل
    use \syriashop\lib\FilterInput;
    use \syriashop\lib\Messages;
    use \syriashop\lib\Database;
    // ارسال ايميل لاستئناف التسجيل
    public function sendMailSignUp(){
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
            $mail->addAddress($_SESSION["confirmEmail"]["email"]); // البريد المرسل اليه
            $mail->addReplyTo('tt6212015@gmail.com', 'Syria Shop');
            $mail->isHTML(true); // يوجد فيه اكواد html
            $mail->Subject = Languages::lang("confirmTitle", $GLOBALS["lang"]); // عنوان الرسالة
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
                      padding-bottom: 20px;"><span>' . Languages::lang("wellcomeConfirm", $GLOBALS["lang"]) . " " . $_SESSION["confirmEmail"]["username"]  . '</span></h2>
                      <p style="font-size: 18px; 
                      direction: rtl;
                      text-align: center;
                      line-height: 36px;">' . Languages::lang("bodyMessageConfirm", $GLOBALS["lang"]) . '</p>
                      <section class="new-pass" style="max-width: 200px;    
                      background-color: #1e3c72;background-image: linear-gradient(to right, #1e3c72, #2a5298);
                      border-radius: 5px;
                      padding: 5px;
                      color: #fff;
                      text-align: center;
                      margin:33px auto 0px;">
                          <p>' . $_SESSION["confirmEmail"]["code"] . '</p>
                      </section>
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
            //return false;
            echo $e->getMessage();
        }
    }
    // ارسال ايميل لاعادة تعيين كلمة المرور
    public function sendMailResetPassword(){
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
            $mail->addAddress($_SESSION["reset"]["email"]); // البريد المرسل اليه
            $mail->addReplyTo('tt6212015@gmail.com', 'Syria Shop');
            $mail->isHTML(true); // يوجد فيه اكواد html
            $mail->Subject = Languages::lang("titleResetPassword", $GLOBALS["lang"]); // عنوان الرسالة
            $mail->Body    = '
            <body>
                <!-- container -->
                <section class="contianer" style="margin:30px auto;" >
                    <!-- Start header 0f page -->
                    <header style="background-color: #24243e;background-image: linear-gradient(to right, #24243e, #302b63, #0f0c29);position: relative;bottom: 22px; text-align: center;padding:10px;color: #fff;">
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
                        direction: rtl;
                        padding-bottom: 20px;">' . Languages::lang("wellcomeConfirm", $GLOBALS["lang"]) . " " . $_SESSION["reset"]["username"] . '</span></h2>
                        <p style="font-size: 18px; 
                        direction: rtl;
                        text-align: center;
                        line-height: 36px;">' . Languages::lang("bodyMail", $GLOBALS["lang"]) . '</p>
                        <section class="new-pass" style="max-width: 200px;    
                        background-color: #1e3c72;background-image: linear-gradient(to right, #1e3c72, #2a5298);
                        border-radius: 5px;
                        padding: 5px;
                        color: #fff;
                        text-align: center;
                        margin:33px auto 0px;">
                            <p>' . $_SESSION['reset']['code'] . '</p>
                        </section>
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
    // التحقق من حظر المستخدم
    public function checkBlockAction(){
        if ( !isset($_SESSION["myInfo"]) ) { // في حال عدم تسجيل الدخول
            $this->headerTo("/client/signIn");
        } else {
            $user = new UsersModals();
            $isBlock = $user->getByColumn("id", $_SESSION["myInfo"]["id"]);
            if ( $isBlock->block == 1 ) {
                $result["status"] = true;
                $result["message"] = $this->messageAjaxError(Languages::lang("messageClientBlockUser", $GLOBALS["lang"]));
            } else {
                $result["status"] = false;
            }
            header("content-type: application/json");
            echo json_encode($result);
        }
    }
    // Page Default
    public function defaultAction(){
        $ads = new ItemsModals();
        // حذف رقم القسم الذي تم اختياره اثناء اضافة اعلان
        if ( isset($_SESSION["cat_id"]) ) {
            unset($_SESSION["cat_id"]);
        }
        
        // في حال اختيار مدينة لعرض اعلاناتها
        $whereCity = isset($_COOKIE['city']) && $_COOKIE['city'] != 'all' ? "AND item_location = '{$_COOKIE['city']}'" : "";
        
        // تعدد الصفات
        if ( !isset($this->_params[0]) ) {
            $page = 1;
        } else {
            $page = (int) $this->_params[0];
        }
        $records_at_page = COUNT_ADS; /// كم سجل بدي يظهر
        $itemCountry = $ads->sql("location_name", "location_country", "where location_country_id = {$this->filterInt($GLOBALS["country"])}");
        $record_count = $ads->rowCount("items", "WHERE item_country = '$itemCountry->location_name' $whereCity"); // عدد السجلات
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
                    . "MONTH(items.item_add_date) AS month, DAY(items.item_add_date) AS day_num", "items, users", "WHERE users.id = {$_SESSION['myInfo']['id']} $whereCity AND item_country = ? ORDER BY item_id DESC LIMIT $start,$end", $itemCountry->location_name, "all");
            // الاعلانات الاكثر مشاهدة
            $adsByCon = $ads->sql(
                    "items.*, users.id, users.favorite, DATEDIFF('" . date("Y-m-d h:i:s") . "', items.item_add_date) as datedif, HOUR(items.item_add_date) AS hour,"
                    . "minute(items.item_add_date) AS min, DAYNAME(items.item_add_date) AS day, YEAR(items.item_add_date) AS year,"
                    . "MONTH(items.item_add_date) AS month, DAY(items.item_add_date) AS day_num", "items, users", "WHERE users.id = {$_SESSION['myInfo']['id']} $whereCity AND item_country = '$itemCountry->location_name' ORDER BY views DESC LIMIT 4", null, "all");
            // اعلانات قسم معين
            $catId = $ads->sql("items.cat_id, categories.categorie_name, categories.categorie_id", "items, categories", "where items.cat_id = categories.categorie_id order by rand() LIMIT 1", null);
            if ( $catId ) {
                $adsByCat = $ads->sql(
                        "items.*, users.id, users.favorite, DATEDIFF('" . date("Y-m-d h:i:s") . "', items.item_add_date) as datedif, HOUR(items.item_add_date) AS hour,"
                        . "minute(items.item_add_date) AS min, DAYNAME(items.item_add_date) AS day, YEAR(items.item_add_date) AS year,"
                        . "MONTH(items.item_add_date) AS month, DAY(items.item_add_date) AS day_num", "items, users", "WHERE cat_id = {$catId->cat_id} $whereCity AND users.id = {$_SESSION['myInfo']['id']} AND item_country = ? ORDER BY item_id DESC LIMIT 4", $itemCountry->location_name, "all");
            }
        } else {
            $allAds = $ads->sql(
                    "*, DATEDIFF('" . date("Y-m-d h:i:s") . "', items.item_add_date) as datedif, HOUR(items.item_add_date) AS hour,"
                    . "minute(items.item_add_date) AS min, DAYNAME(items.item_add_date) AS day, YEAR(items.item_add_date) AS year,"
                    . "MONTH(items.item_add_date) AS month, DAY(items.item_add_date) AS day_num", "items", "WHERE item_country = ? $whereCity ORDER BY item_id DESC LIMIT $start,$end", $itemCountry->location_name, "all");
            $adsByCon = $ads->sql(
                    "*, DATEDIFF('" . date("Y-m-d h:i:s") . "', items.item_add_date) as datedif, HOUR(items.item_add_date) AS hour,"
                    . "minute(items.item_add_date) AS min, DAYNAME(items.item_add_date) AS day, YEAR(items.item_add_date) AS year,"
                    . "MONTH(items.item_add_date) AS month, DAY(items.item_add_date) AS day_num", "items", "WHERE item_country = '$itemCountry->location_name' $whereCity ORDER BY views DESC LIMIT 4", null, "all");
            // اعلانات قسم معين
            $catId = $ads->sql("items.cat_id, categories.categorie_name, categories.categorie_id", "items, categories", "where items.cat_id = categories.categorie_id $whereCity order by rand() LIMIT 1", null);
            if ( $catId ) { // في حال عدم وجود اعلانات في هذا القسم
                $adsByCat = $ads->sql(
                    "*, DATEDIFF('" . date("Y-m-d h:i:s") . "', items.item_add_date) as datedif, HOUR(items.item_add_date) AS hour,"
                    . "minute(items.item_add_date) AS min, DAYNAME(items.item_add_date) AS day, YEAR(items.item_add_date) AS year,"
                    . "MONTH(items.item_add_date) AS month, DAY(items.item_add_date) AS day_num", "items", "WHERE cat_id = {$catId->cat_id} $whereCity AND item_country = ? ORDER BY item_id DESC LIMIT 4", $itemCountry->location_name, "all");
            }
        }
        if ( !empty($allAds) ) {
            $this->_data["allAds"] = $allAds;
            $this->_data["adsByCon"] = $adsByCon;
            $this->_data["adsByCat"] = array(
                $adsByCat,
                $catId->categorie_name,
                $catId->categorie_id
            );
        } else {
            $this->_data["allAds"] = $this->message("orange lighten-1", Languages::lang("notFoundAds", $GLOBALS["lang"]));;
            $this->_data["adsByCon"] = $this->message("orange lighten-1", Languages::lang("notFoundAds", $GLOBALS["lang"]));;
        }
        // جلب اعلانات الاكثر مشاهدة
        $this->_view();
    }
    // جلب المنتجات حسب النوع
    public function getAdsByTypeAction(){
        if ( isset($_POST["getAds"]) ) {
            
            // في حال اختيار مدينة لعرض اعلاناتها
            $whereCity1 = isset($_COOKIE['city']) && $_COOKIE['city'] != 'all' ? "AND item_location = '{$_COOKIE['city']}'" : "";
            $whereCity2 = isset($_COOKIE['city']) && $_COOKIE['city'] != 'all' ? "WHERE item_location = '{$_COOKIE['city']}'" : "";
            
            // تعدد الصفات
            if ( !isset($_POST["pageNum"]) ) {
                $page = 1;
            } else {
                $page = (int) $_POST["pageNum"];
            }
            $records_at_page = 1; /// كم سجل بدي يظهر
            $ads = new ItemsModals();
            $record_count = $ads->rowCount("items", "where location_country_id = {$this->filterInt($GLOBALS["country"])} $whereCity1"); // عدد السجلات
            $pages_count = (int)ceil($record_count / $records_at_page);
            $this->_data["thePage"] = array(
                "page" => $page,
                "pages" => $pages_count
            );
            if ( $page > $pages_count || $page <= 0 ) {
                echo "No Pages More";
                exit;
            }
            $start = ($page - 1) * $records_at_page;
            $end = $records_at_page;
            $this->_data["thePage"]['start']  = $start;
            $this->_data["thePage"]['end']  = $end;
            $typeAds = $this->filterInt($_POST["type"]);
            switch ($typeAds){
                case 1:
                case 2:
                   $getAds = new ItemsModals;
                    $sql = $getAds->sql(
                            "*, DATEDIFF('" . date("Y-m-d h:i:s") . "', item_add_date) as datedif, HOUR(item_add_date) AS hour,"
                            . "minute(item_add_date) AS min, DAYNAME(item_add_date) AS day, "
                            . "YEAR(item_add_date) AS year, MONTH(item_add_date) AS month, DAY(item_add_date) AS day_num", "items", "where item_type = $typeAds $whereCity1 ORDER BY item_id DESC LIMIT $start, $end");
                    if ( !empty($sql) ) {
                        $result["status"] = "success";
                        $result["ads"] = $sql;
                    } else {
                        $result["status"] = "empty";
                    }
                    header("content-type: application/json");
                    echo json_encode($result);
                    break;
                case 3:
                    $getAds = new ItemsModals;
                    $sql = $getAds->sql(
                            "*, DATEDIFF('" . date("Y-m-d h:i:s") . "', item_add_date) as datedif, HOUR(item_add_date) AS hour,"
                            . "minute(item_add_date) AS min, DAYNAME(item_add_date) AS day,"
                            . "YEAR(item_add_date) AS year, MONTH(item_add_date) AS month, DAY(item_add_date) AS day_num", "items", "$whereCity2 ORDER BY item_id DESC LIMIT $start, $end");
                    if ( !empty($sql) ) {
                        $result["status"] = "success";
                        $result["ads"] = $sql;
                    } else {
                        $result["status"] = "empty";
                    }
                    header("content-type: application/json");
                    echo json_encode($result);
                    break;
            }
        }
    }
    // صفحة المنتجات
    public function productsAction(){
        
        // في حال اختيار مدينة لعرض اعلاناتها
        $whereCity1 = isset($_COOKIE['city']) && $_COOKIE['city'] != 'all' ? "AND item_location = '{$_COOKIE['city']}'" : "";
        $whereCity2 = isset($_COOKIE['city']) && $_COOKIE['city'] != 'all' ? "WHERE item_location = '{$_COOKIE['city']}'" : "";
        
        $itemType = isset($this->_params[0]) ? (int)$this->_params[0] : 1; // نوع الاعلام
        
        // تعدد الصفات
        if ( !isset($this->_params[1]) ) {
            $page = 1;
        } else {
            $page = (int) $this->_params[1];
        }
        $records_at_page = COUNT_ADS; /// كم سجل بدي يظهر
        $ads = new ItemsModals();
        $itemCountry = $ads->sql("location_name", "location_country", "where location_country_id = {$this->filterInt($GLOBALS["country"])}");
        switch ($itemType) {
            case 1:
            case 2:
            case 3:
                $record_count = $ads->rowCount("items", "where item_type = $itemType $whereCity1 AND item_country = '$itemCountry->location_name'"); // عدد السجلات
            break;
            default :
                $record_count = $ads->rowCount("items", "WHERE item_country = '$itemCountry->location_name' $whereCity1"); // عدد السجلات
            break;
        }
        $pages_count = (int)ceil($record_count / $records_at_page);
        $this->_data["thePage"] = array(
            "page" => $page,
            "pages" => $pages_count
        );
//        if ( $page > $pages_count || $page <= 0 ) {
//            echo "No Pages More";
//            exit;
//        }
        $start = ($page - 1) * $records_at_page;
        $end = $records_at_page;
        $this->_data["thePage"]["param0"] = $this->_params[0];
        
        if ( isset($_SESSION["myInfo"]) ) { // من اجل زر الحفظ
            switch ($itemType) {
                case 1:
                case 2:
                case 3:
                    $allAds = $ads->sql(
                    "items.*, users.id, users.favorite, DATEDIFF('" . date("Y-m-d h:i:s") . "', item_add_date) as datedif, HOUR(item_add_date) AS hour,"
                    . "minute(item_add_date) AS min, DAYNAME(item_add_date) AS day, YEAR(item_add_date) AS year,"
                    . "MONTH(item_add_date) AS month, DAY(item_add_date) AS day_num", "items, users", "WHERE users.id = {$_SESSION['myInfo']['id']} AND item_type = $itemType $whereCity1 AND item_country = '$itemCountry->location_name' ORDER BY item_id DESC LIMIT $start,$end", null, "all");
                break;
                default :
                    $allAds = $ads->sql(
                    "items.*, users.id, users.favorite, DATEDIFF('" . date("Y-m-d h:i:s") . "', item_add_date) as datedif, HOUR(item_add_date) AS hour,"
                    . "minute(item_add_date) AS min, DAYNAME(item_add_date) AS day, YEAR(item_add_date) AS year,"
                    . "MONTH(item_add_date) AS month, DAY(item_add_date) AS day_num", "items, users", "WHERE users.id = {$_SESSION['myInfo']['id']} $whereCity1 AND item_country = '$itemCountry->location_name' ORDER BY item_id DESC LIMIT $start,$end", null, "all");
                break;
            }
        } else {
            switch ($itemType) {
                case 1:
                case 2:
                case 3:
                    $allAds = $ads->sql(
                    "*, DATEDIFF('" . date("Y-m-d h:i:s") . "', item_add_date) as datedif, HOUR(item_add_date) AS hour,"
                    . "minute(item_add_date) AS min, DAYNAME(item_add_date) AS day, YEAR(item_add_date) AS year,"
                    . "MONTH(item_add_date) AS month, DAY(item_add_date) AS day_num", "items", "WHERE item_type = $itemType $whereCity1 AND item_country = '$itemCountry->location_name' ORDER BY item_id DESC LIMIT $start,$end", null, "all");
                break;
                default :
                    $allAds = $ads->sql(
                    "*, DATEDIFF('" . date("Y-m-d h:i:s") . "', item_add_date) as datedif, HOUR(item_add_date) AS hour,"
                    . "minute(item_add_date) AS min, DAYNAME(item_add_date) AS day, YEAR(item_add_date) AS year,"
                    . "MONTH(item_add_date) AS month, DAY(item_add_date) AS day_num", "items", "WHERE item_country = '$itemCountry->location_name' $whereCity1 ORDER BY item_id DESC LIMIT $start,$end", null, "all");
                break;
            }            
        }
        if ( !empty($allAds) ) {
            $this->_data["allAds"] = $allAds;
        } else {
            $this->_data["allAds"] = $this->message("orange lighten-1", Languages::lang("notFoundAds", $GLOBALS["lang"]));;
        }
        
        $this->_view();
    }
    // Page Sign In
    public function signInAction(){
        if ( isset($_POST["signIn"]) ) {
            $signIn = new UsersModals();
            $signIn->email = $this->filterEmail($_POST["email"]);
            $signIn->password = $_POST["password"];
            $data = $signIn->getByColumn("email", $signIn->email);
            if ( !empty($data) ) {
                if ( password_verify($signIn->password, $data->password) ) {
                    $_SESSION["myInfo"] = array(
                        "id"            => $data->id,
                        "key_hash"      => $data->key_hash,
                        "username"      => $data->username,
                        "email"         => $data->email,
                        "myImg"         => $data->my_img
                    );
                    if ( $data->type_user == "admin" ) { // للتخقق من نوع المستخدم
                        $_SESSION['myInfo']['admin'] = true;
                    }
                    if ( isset($_POST["remberMe"]) ) {
                        setcookie("remberMe", $_SESSION["myInfo"]["email"], strtotime("+7day"), "/", $_SERVER["HTTP_HOST"]);
                    }
                    $this->headerTo("/client/default");
                } else {
                    $this->_data["message"][] = $this->message("red", Languages::lang("passwordIncorrect", $GLOBALS["lang"]));
                }
            } else {
                $this->_data["message"][] = $this->message("red", Languages::lang("EmailIsNotExists", $GLOBALS["lang"]));
            }
        }
        if ( isset($_SESSION["myInfo"]) ) {
           $this->headerTo("/client/");
        } else {
            $this->_view();
        }
    }
    // Page Sign Up
    public function signUpAction(){
        if ( isset($_POST["signup"]) ) {
            $newUser = new UsersModals();
            $newUser->key_hash      = uniqid("users", true);
            $newUser->username      = $this->filterStr($_POST["username"]);
            $newUser->email         = $this->filterEmail($_POST["email"]);
            $newUser->hashPassword  = $this->hashPassword($_POST["password"]);
            $newUser->password      = $_POST["password"];
            
            if ( $newUser->checkInput() ) { // التحقق من المدخلات
                $this->_data["message"] = $newUser->showMessage();
            } else {
                $code = substr(str_shuffle('0123456789'), 0, 4); // كود عشوائي مؤلف من 4 ارقام
                //global $conn;
                $conn = self::setConn();
                $_SESSION["confirmEmail"] = array( // حفظ البيانات في جلسة من اجل استئناف التسجيل
                    "key_hash"      => $newUser->key_hash,
                    "username"      => $newUser->username,
                    "email"         => $newUser->email,
                    "hashPassword"  => $newUser->hashPassword,
                    "code"          => $code
                );
                self::closeConn();
                if ( $this->sendMailSignUp() ) {
                    $this->headerTo("/client/confirmEmail");
                } else {
                    $this->headerTo("/client/notfound");
                }
            }
        }
        if ( isset($_SESSION["myInfo"]) ) {
            $this->headerTo("/client/");
        } else {
            $this->_view();
        }
    }
    // Sign IN By Facebook
    public function signInFacebookAction(){
        
        $fb = new \Facebook\Facebook([
          'app_id' => '440912879835758', // Replace {app-id} with your app id
          'app_secret' => 'de55f17b4582045959ae0ea46e65b93e',
          'default_graph_version' => 'v2.2',
          ]);

        $helper = $fb->getRedirectLoginHelper();

        if (isset($_GET['state'])) {
            $helper->getPersistentDataHandler()->set('state', $_GET['state']);
        }

        try {
          $accessToken = $helper->getAccessToken();
        } catch(\Facebook\Exceptions\FacebookResponseException $e) {
          // When Graph returns an error
          echo 'Graph returned an error: ' . $e->getMessage();
          exit;
        } catch(\Facebook\Exceptions\FacebookSDKException $e) {
          // When validation fails or other local issues
          echo 'Facebook SDK returned an error: ' . $e->getMessage();
          exit;
        }

        if (! isset($accessToken)) {
          if ($helper->getError()) {
            header('HTTP/1.0 401 Unauthorized');
            echo "Error: " . $helper->getError() . "\n";
            echo "Error Code: " . $helper->getErrorCode() . "\n";
            echo "Error Reason: " . $helper->getErrorReason() . "\n";
            echo "Error Description: " . $helper->getErrorDescription() . "\n";
          } else {
            header('HTTP/1.0 400 Bad Request');
            echo 'Bad request';
          }
          exit;
        }

        $oAuth2Client = $fb->getOAuth2Client();

        $tokenMetadata = $oAuth2Client->debugToken($accessToken);

        $tokenMetadata->validateAppId('440912879835758'); // Replace {app-id} 
        
        $tokenMetadata->validateExpiration();

        if (! $accessToken->isLongLived()) {
          // Exchanges a short-lived access token for a long-lived one
          try {
            $accessToken = $oAuth2Client->getLongLivedAccessToken($accessToken);
          } catch (\Facebook\Exceptions\FacebookSDKException $e) {
            echo "<p>Error getting long-lived access token: " . $e->getMessage() . "</p>\n\n";
            exit;
          }

          echo '<h3>Long-lived</h3>';
          var_dump($accessToken->getValue());
        }

        $_SESSION['fb_access_token'] = (string) $accessToken;
        try{
            $response = $fb->get('/me?fields=name, id, email', $_SESSION['fb_access_token']);
            $account = $response->getGraphuser()->asArray(); // لعرض الاذونات بشكل  مصفوفة لسهولة الوصول اليها
            $fid = $account['id'];
            $fname = $account['name'];
            if ( empty($account['email']) ) {
                $femail = Null;
            } else {
                $femail = $account['email'];
            }
            $fpassword = sha1('');
            $flogo = "https://graph.facebook.com/$fid/picture?type=large";
            if ( mb_strlen($fname) > 40 ) {    
                redirectError('error.php', "اسم المستخدم لديك اكثر من 40 حرف");    
            }
            $newUser = new UsersModals();
            $newUser->key_hash      = uniqid("users", true);
            $newUser->username      = $this->filterStr($fname);
            $newUser->email         = $this->filterEmail($femail);
            $newUser->hashPassword  = $this->hashPassword($fpassword);
            $newUser->password      = $fpassword;
            $newUser->user_type = "facebook";
            $newUser->my_img = $flogo;
            if ( !empty($newUser->getByColumn("email", $newUser->email)) && $newUser->user_type == "facebook" ) {
                // تسجيل الدخول
                $data = $newUser->getByColumn("email", $newUser->email);
                $_SESSION["myInfo"] = array(
                    "id"            => $data->id,
                    "key_hash"      => $data->key_hash,
                    "username"      => $data->username,
                    "email"         => $data->email,
                    "myImg"         => $data->my_img,
                );
                if ( $data->type_user == "admin" ) { // للتخقق من نوع المستخدم
                    $_SESSION['myInfo']['admin'] = true;
                }
                $this->headerTo("/client/default");
                
            } else if ( !empty($newUser->getByColumn("email", $newUser->email)) && $newUser->user_type != "facebook" ) {
                $newUser->message[] = $this->message("red", Languages::lang("EmailIsExists", $GLOBALS["lang"]));
            } else {
                $newUser->date_of_registration = date("Y-m-d");
                $newUser->insert();
                $getId = $newUser->getByColumn("email", $newUser->email);
                $_SESSION["myInfo"] = array(
                    "id" => $getId->id,
                    "key_hash"      => $newUser->key_hash,
                    "username"      => $newUser->username,
                    "email"         => $newUser->email,
                    "hashPassword"  => $newUser->password,
                    "myImg"         =>  $newUser->my_img
                );
                $this->headerTo("/client/default");
            }
            
        } catch (FacebookExceptionsFacebookResponseException $e) {
            
        }
        
    }
    // Page Confirm Email
    public function confirmEmailAction(){
        if ( isset($_SESSION["confirmEmail"]) ) {
            if ( isset($_POST["confirm"]) ) {
                if ( empty($_POST["code"]) ) { // في حال لم يدخل الشخص الكود
                    $this->_data["message"] = $this->message("red", Languages::lang("notEmptyCode", $GLOBALS["lang"]));
                } else if ( $_POST["code"] == $_SESSION["confirmEmail"]["code"] ) {
                    $session = $_SESSION["confirmEmail"];
                    session_unset($_SESSION["confirmEmail"]);
                    $newUser = new UsersModals();
                    $newUser->key_hash      = $session["key_hash"];
                    $newUser->username      = $session["username"];
                    $newUser->email         = $session["email"];
                    $newUser->password      = $session["hashPassword"];
                    $newUser->date_of_registration = date("Y-m-d");
                    $newUser->insert();
                    $getId = $newUser->getByColumn("email", $newUser->email);
                    $_SESSION["myInfo"] = array(
                        "id" => $getId->id,
                        "key_hash"      => $newUser->key_hash,
                        "username"      => $newUser->username,
                        "email"         => $newUser->email,
                        "hashPassword"  => $newUser->password,
                    );
                    $this->headerTo("/client/");
                } else {
                    $this->_data["message"] = $this->message("red", Languages::lang("errorConfirmEmail", $GLOBALS["lang"]));
                }
            }
            $this->_view();
        } else {
            $this->headerTo("/client/notfound");
        }
    }
    public function resendCodeAction(){
        if ( $this->sendMailSignUp() ) {
            $result["message"] = Languages::lang("messageSuccessResendCode", $GLOBALS["lang"]);
            $result["status"] = "success";
        } else {
            $result["message"] = Languages::lang("messageErrorResendCode", $GLOBALS["lang"]);
            $result["status"] = "error";
        }
        header("content-type: application/json");
        echo json_encode($result);
    }
    // Page reset Password
    public function resetPasswordAction(){
        
        $this->_data["params"] = $this->_params;
        if ( isset($_POST["enterEmail"]) ) {
            $checkEmail = new UsersModals();
            $checkEmail->email = $this->filterEmail($_POST["email"]);
            if ( $checkEmail->checkEmailForResetPassword() ) {
                $this->_data["message"] = $checkEmail->showMessage();
            } else {
                $getDataUser = new UsersModals();
                $data = $getDataUser->getByColumn("email", $checkEmail->email);
                $code = substr(str_shuffle('0123456789'), 0, 4);
                $_SESSION["reset"] = array(
                    "id" => $data->id,
                    "username" => $data->username,
                    "email" => $data->email,
                    "code" => $code
                );
                if ( $this->sendMailResetPassword() ){
                    $this->headerTo("/client/resetPassword/enterCode");
                } else {
                    $this->headerTo("/client/notfound");
                }
            }
        }
        
        if ( isset($_POST["confirm"]) ) {
            if ( empty($_POST["code"]) ) {
                $this->_data["message"] = $this->message("red", Languages::lang("notEmptyCode", $GLOBALS["lang"]));
            } else if ( $_POST["code"] == $_SESSION["reset"]["code"] ) {
                $_SESSION["reset"]["allow"] = true;
                $this->headerTo("/client/resetPassword/newPassword");
            } else {
                $this->_data["message"] = $this->message("red", Languages::lang("errorConfirmEmail", $GLOBALS["lang"]));
            }
        }
        
        if ( isset($_POST["newPassword"]) ) {
            $newPassword = new UsersModals();
            $newPassword->password = $_POST["password"];
            if ( $newPassword->checkPasswordForResetPassword() ) {
                $this->_data["message"] = $newPassword->showMessage();
            } else {
                $newPassword->id = $_SESSION["reset"]["id"];
                $newPassword->password = $this->hashPassword($_POST["password"]);
                if ( $newPassword->update() ) {
                    $this->headerTo("/client/signIn");
                }
            }
        }
        
        $this->_view();
    }
    public function resendResetAction(){
        if ( $this->sendMailResetPassword() ) {
            $result["message"] = Languages::lang("messageSuccessResendCode", $GLOBALS["lang"]);
            $result["status"] = "success";
        } else {
            $result["message"] = Languages::lang("messageErrorResendCode", $GLOBALS["lang"]);
            $result["status"] = "error";
        }
        header("content-type: application/json");
        echo json_encode($result);
    }
    // Exit To App
    public function signOutAction(){
        session_unset();
        session_destroy();
        $this->headerTo("/client/signIn");
    }
    // صفحة تغيير اللغة
    public function langAction(){
        if ( isset($this->_params[0]) ) {
            $chooseLang = $this->_params[0];
            setcookie("lang", $chooseLang, strtotime("+30day"), "/", $_SERVER["HTTP_HOST"]);
            $GLOBALS["lang"] = $chooseLang;
            if ( isset($_SERVER["HTTP_REFERER"]) ) {
                $this->headerTo($_SERVER["HTTP_REFERER"]);   
            } else {
                $this->headerTo("/client/default");
            }
        } else {
            $this->headerTo("/client/");
        }
    }
    // صفحة تغيير البلد
    public function countryAction(){
        if ( isset($this->_params[0]) ) {
            $chooseCountry = $this->_params[0];
            setcookie("country", $chooseCountry, strtotime("+30day"), "/", $_SERVER["HTTP_HOST"]);
            $GLOBALS["country"] = $chooseCountry;
            if ( isset($_SERVER["HTTP_REFERER"]) ) {
                $this->headerTo($_SERVER["HTTP_REFERER"]);   
            } else {
                $this->headerTo("/client/default");
            }
        } else {
            $this->headerTo("/client/");
        }
    }
    // صفحة تغيير المحافظة
    public function cityAction(){
        if ( isset($_GET['city']) ) {
            $chooseCity = $_GET['city'];
            setcookie("city", $chooseCity, strtotime("+30day"), "/", $_SERVER["HTTP_HOST"]);
            $GLOBALS["city"] = $chooseCity;
            if ( isset($_SERVER["HTTP_REFERER"]) ) {
                $this->headerTo($_SERVER["HTTP_REFERER"]);   
            } else {
                $this->headerTo("/client/default");
            }
        } else {
            $this->headerTo("/client/");
        }
    }
}

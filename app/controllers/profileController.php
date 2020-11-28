<?php
namespace syriashop\controllers;
use syriashop\modals\UsersModals;
use syriashop\lib\FilterInput;
use syriashop\lib\Messages;
use syriashop\lib\Languages;
use syriashop\lib\Redirect;
use syriashop\modals\ItemsModals;
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

class ProfileController extends AbstractController {
    use FilterInput, Messages, Redirect;
    
    
    // ارسال ايميل لاستئناف التسجيل
    public function sendMailEditEmail(){
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
            $mail->addAddress($_SESSION["checkEmail"]["email"]); // البريد المرسل اليه
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
                      padding-bottom: 20px;"><span>' . Languages::lang("wellcomeConfirm", $GLOBALS["lang"]) . " " . $_SESSION["checkEmail"]["username"]  . '</span></h2>
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
                          <p>' . $_SESSION["checkEmail"]["code"] . '</p>
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
    
    public function defaultAction(){
        if ( !isset($_SESSION["myInfo"]) ) {
            $this->headerTo("/client/signIn");
        }
        $dataUser = new UsersModals();
        $allAds = new ItemsModals();
        
        // لعرض بيانات المستخدم
        $dataUser->id = $_SESSION["myInfo"]["id"];
        $data = $dataUser->getByKey();
        $this->_data["dataUser"] = $data;
        
        // لعرض اعلانات المستخدم
        $ads = $allAds->sql(
                "*, DATEDIFF('" . date("Y-m-d h:i:s") . "', item_add_date) as datedif, HOUR(item_add_date) AS hour,"
                . "minute(item_add_date) AS min, DAYNAME(item_add_date) AS day, YEAR(item_add_date) AS year,"
                . "MONTH(item_add_date) AS month, DAY(item_add_date) AS day_num", "items", "WHERE user_id = {$_SESSION['myInfo']['id']} ORDER BY item_id DESC", null, "all");
        if ( !empty($ads) ) {
            $this->_data["allAds"] = $ads;
        } else {
            $this->_data["allAds"] = $this->message("orange lighten-1", Languages::lang("notFoundAds", $GLOBALS["lang"]));;
        }
        // جلب اعلانات المفضلة
        $dataUser->id = $_SESSION["myInfo"]["id"];
        $fav = $dataUser->getByKey();
        $fav = !empty($fav->favorite) ? $fav->favorite : 0; // للتحقق من وجود محفوظات
        $ads = $allAds->sql(
                "items.*, users.favorite, users.id, DATEDIFF('" . date("Y-m-d h:i:s") . "', item_add_date) as datedif, HOUR(item_add_date) AS hour,"
                . "minute(item_add_date) AS min, DAYNAME(item_add_date) AS day, YEAR(item_add_date) AS year,"
                . "MONTH(item_add_date) AS month, DAY(item_add_date) AS day_num", "items, users", "WHERE users.id = {$_SESSION['myInfo']['id']} AND item_id IN({$fav}) ORDER BY item_id DESC", null, "all");
        if ( !empty($ads) ) {
            $this->_data["favorite"] = $ads;
        } else {
            $this->_data["favorite"] = $this->message("orange lighten-1", Languages::lang("notFoundAds", $GLOBALS["lang"]));;
        }
        $this->_view();
    }
    public function favoriteAction(){
//        if ( isset($_POST["getFavorite"]) ) {
//            $allAds = new ItemsModals();
//            $dataUser = new UsersModals();
//            $dataUser->id = $_SESSION['myInfo']['id'];
//            $myFav = $dataUser->getByKey();
//            $myFav = $myFav->favorite;
//            
//            // لعرض الاعلانات التي تم خفظها في المفضلة
//            $ads = $allAds->sql(
//                    "*, DATEDIFF('" . date("Y-m-d h:i:s") . "', item_add_date) as datedif, HOUR(item_add_date) AS hour,"
//                    . "minute(item_add_date) AS min, DAYNAME(item_add_date) AS day, YEAR(item_add_date) AS year,"
//                    . "MONTH(item_add_date) AS month, DAY(item_add_date) AS day_num", "items", "WHERE item_id in ({$myFav}) user_id = {$_SESSION['myInfo']['id']} ORDER BY item_id DESC", null, "all");
//            if ( !empty($ads) ) {
//                $this->_data["allAds"] = $ads;
//            } else {
//                $this->_data["allAds"] = $this->message("orange lighten-1", Languages::lang("notFoundAds", $GLOBALS["lang"]));;
//            }
//        }
    }


    // تعديل اسم المستخدم
    public function saveUsernameAction(){
        if ( isset($_POST["save_username"]) ) {
            $user = new UsersModals();
            $user->id            = $_SESSION["myInfo"]["id"];
            $user->username      = $this->filterStr($_POST["username"]);
            if ( $user->checkUsernameAjax() ) {
                $result["status"] = "error";
                $result["message"] = $user->showMessage();
            } else {
                if ( $user->updateSingle("username = '$user->username'", "id = $user->id") ) {
                    if ( is_dir(LOGO_PATH . "/Picture Profile" . DS . $_SESSION["myInfo"]["username"]) ) {
                        rename(LOGO_PATH . "/Picture Profile" . DS . $_SESSION["myInfo"]["username"], LOGO_PATH .  "/Picture Profile" . DS . $user->username);                    
                    }
                    $_SESSION["myInfo"]["username"] = $user->username;
                    $result["status"] = "success";
                    $result["message"] = $this->messageAjaxSuccess(Languages::lang("messageSuccessSaveData", $GLOBALS["lang"]));
                }
            }
            header("content-type: application/json");
            echo json_encode($result);
        }
    }
    
    // تعديل اسم المستخدم
    public function saveEmailAction(){
        if ( isset($_POST["save_email"]) ) {
            $user = new UsersModals();
            $user->id               = $_SESSION["myInfo"]["id"];
            $user->email            = $this->filterEmail($_POST["email"]);
            if ( $user->checkEmailAjax() ) {
                $result["status"] = "error";
                $result["message"] = $user->showMessage();
            } else {
                if ( $user->email == $_SESSION["myInfo"]["email"] ) {
                    if ( $user->updateSingle("email = '$user->email'", "id = $user->id") ) {
                        $result["status"] = "success";
                        $result["message"] = $this->messageAjaxSuccess(Languages::lang("messageSuccessSaveData", $GLOBALS["lang"]));
                    }
                } else {
                    $code = substr(str_shuffle('0123456789'), 0, 4);
                    $_SESSION["checkEmail"] = array(
                        "email" => $user->email,
                        "username" => $_SESSION["myInfo"]["username"],
                        "code" => $code
                    );
                    $this->sendMailEditEmail();
                    $result["status"] = "redirect";
                }
            }
            header("content-type: application/json");
            echo json_encode($result);
        }
    }
    
    // تعديل الباسورد
    public function savePasswordAction(){
        if ( isset($_POST["save_password"]) ) {
            $user = new UsersModals();
            $user->id            = $_SESSION["myInfo"]["id"];
            $user->password      = $_POST["password"];
            $user->hashPassword  = $this->hashPassword($_POST["password"]);
            if ( $user->checkPasswordAjax() ) {
                $result["status"] = "error";
                $result["message"] = $user->showMessage();
            } else {
                if ( $user->updateSingle("password = '$user->hashPassword'", "id = $user->id") ) {
                    $result["status"] = "success";
                    $result["message"] = $this->messageAjaxSuccess(Languages::lang("messageSuccessSaveData", $GLOBALS["lang"]));
                }
            }
            header("content-type: application/json");
            echo json_encode($result);
        }
    }
    
    // تعديل الايميل
    public function confirmEmailAction(){
        if ( isset($_SESSION["checkEmail"]) ) {
            if ( isset($_POST["confirm"]) ) {
                $code = $this->filterInt($_POST["code"]);
                if ( empty($code) ) {
                    $this->_data["message"] = $this->message("red", Languages::lang("notEmptyCode", $GLOBALS["lang"]));
                } else {
                    if ( $_SESSION["checkEmail"]["code"] == $code ) {
                        $user = new UsersModals();
                        $user->updateSingle("email = '{$_SESSION['checkEmail']["email"]}'", "id = {$_SESSION['myInfo']['id']}");
                        $this->headerTo("/profile/");
                    } else {
                        $this->_data["message"] = $this->message("red", Languages::lang("errorConfirmEmail", $GLOBALS["lang"]));
                    }
                }
            }
        } else {
            $this->headerTo($_SERVER["HTTP_REFERER"]);
        }
        $this->_view();
    }
    public function resendCodeAction(){
        if ( $this->sendMailEditEmail() ) {
            $result["message"] = Languages::lang("messageSuccessResendCode", $GLOBALS["lang"]);
            $result["status"] = "success";
        } else {
            $result["message"] = Languages::lang("messageErrorResendCode", $GLOBALS["lang"]);
            $result["status"] = "error";
        }
        header("content-type: application/json");
        echo json_encode($result);
    }
    
    // تغيير الصورة الشخصية
    public function editMyImgAction(){
        if ( isset($_POST["editMyImg"]) ) {
            $editImg = new UsersModals();
            $upload = new \syriashop\lib\Upload();
            $editImg->img = $_FILES["myImg"];
            if ( $editImg->checkMyImg() ) {
                $result["status"] = "error";
                $result["message"] = $editImg->showMessage();
            } else {
                
                define("MYIMG_PATH", LOGO_PATH . DS . "Picture Profile");
                if ( !file_exists(MYIMG_PATH) ) { // في حال لم يكن هناك مجلد فسيتم انشائه
                    mkdir(MYIMG_PATH);
                }
               
                /*$dirImg = scandir(MYIMG_PATH);
                foreach ($dirImg as $dir){
                    $theFile = MYIMG_PATH . DS . $dir;
                    // في حال وجود الملف
                    if ( is_file($theFile) && pathinfo($theFile, PATHINFO_FILENAME) == $_SESSION["myInfo"]["id"] ) {
                        unlink($theFile);
                        break;
                    }
                }*/
                $dirImg = MYIMG_PATH;
                if ( is_file($dirImg . DS .  $_SESSION['myInfo']['myImg']) ) {
                    unlink($dirImg . DS .  $_SESSION['myInfo']['myImg']);
                }
                
                 // تغيير اسم الصورة
                $editImg->img["name"] = $_SESSION["myInfo"]["id"] . "." . pathinfo($editImg->img["name"], PATHINFO_EXTENSION);
                $d = $upload->compress($editImg->img["tmp_name"], MYIMG_PATH . DS . $editImg->img["name"], 50);
                move_uploaded_file($d, $editImg->img["tmp_name"]);
                
                // خذف الصورة السابقة
                $editImg->updateSingle("my_img = '{$editImg->img["name"]}'", "id = {$_SESSION['myInfo']['id']}");
                $_SESSION['myInfo']['myImg'] = $editImg->img["name"]; // تغيير الصورة الشخصية في السيشن
                $result["status"] = "success";
                $result["message"] = $this->messageAjaxSuccess(Languages::lang("messageSuccessEditMyImg", $GLOBALS["lang"]));
            }
            header("content-type: application/json");
            echo json_encode($result);
        }
    }
    // تغيير الصورة الشخصية
    public function changeMyImgAction(){
        if ( isset($_POST["myImg"]) ) {
            $myImg = new UsersModals();
            $myImg->id = $_SESSION["myInfo"]["id"];
            $srcImg = $myImg->getByKey();
            if ( $_SERVER['HTTP_HOST'] == 'localhost' ) {
                $path1 = "/images/";
                $path2 = "/Picture Profile" . DS;    
            } else {
                $path1 = "/public/images/";
                $path2 = "/public/Picture Profile" . DS;   
            }
            if ( $srcImg->user_type == "facebook" ) {
                $result["message"] = $srcImg->my_img;
            } else {
                if ( $srcImg->my_img == "user.png" ) {
                    $result["message"] = $path1 . "user.png";
                } else {
                    $result["message"] = $path2 . $_SESSION['myInfo']['myImg'];
                }
            }
            $result["status"] = "success";
            header("content-type: application/json");
            echo json_encode($result);
        }
    }
    
}

<?php
namespace syriashop\modals;
use \syriashop\lib\Languages;

class UsersModals extends AbstractModals {
    use \syriashop\lib\Messages;
    
    public $id, $key_hash, $username, $email, $password, $hashPassword, $img,
            $date_of_registration, $user_type, $my_img, $message;
    
    protected static $tableName = "users";
    protected static $tableSchema = array(
        "key_hash"   => self::DATA_TYPE_STR,
        "username" => self::DATA_TYPE_STR,
        "email" => self::DATA_TYPE_STR,
        "password" => self::DATA_TYPE_STR,
        "date_of_registration" => self::DATA_TYPE_STR,
        "user_type" => self::DATA_TYPE_STR,
        "my_img" => self::DATA_TYPE_STR
    );
    protected static $primaryKey = "id";

    private function checkUsername(){
        $existsError = false;
        if ( empty($this->username) ) {
            $this->message[] = $this->message("red", Languages::lang("notEmptyUserName", $GLOBALS["lang"]));
            $existsError = true;
        } else if ( mb_strlen($this->username) < 4 || mb_strlen($this->username) > 40 ) {
            $this->message[] = $this->message("red", Languages::lang("countUserName", $GLOBALS["lang"]));
            $existsError = true;
        }
        return $existsError ? true : false;
    }
    private function checkEmail(){
        $existsError = false;
        if ( empty($this->email) ) {
            $this->message[] = $this->message("red", Languages::lang("notEmptyEmail", $GLOBALS["lang"]));
            $existsError = true;
        } else if ( !filter_var($this->email, FILTER_VALIDATE_EMAIL) ) {
            $this->message[] = $this->message("red", Languages::lang("checkValidEmail", $GLOBALS["lang"]));
            $existsError = true;
        }
        if ( !empty($this->getByColumn("email", $this->email)) ) {
            $this->message[] = $this->message("red", Languages::lang("EmailIsExists", $GLOBALS["lang"]));
            $existsError = true;
        }
        return $existsError ? true : false;
    }
    private function checkPassword(){
        $existsError = false;
        if ( empty($this->password) ) {
            $this->message[] = $this->message("red", Languages::lang("notEmptyPassword", $GLOBALS["lang"]));
            $existsError = true;
        } else if ( mb_strlen($this->password) < 5 || mb_strlen($this->password) > 40 ) {
            $this->message[] = $this->message("red", Languages::lang("countPassword", $GLOBALS["lang"]));
            $existsError = true;
        }
        return $existsError ? true : false;
    }

    public function checkInput(){
        $this->checkUsername();
        $this->checkEmail();
        $this->checkPassword();
        return !empty($this->message) ? true : false;
    }
    
    public function checkEmailForResetPassword(){
        if ( empty($this->email) ) {
            $this->message[] = $this->message("red", Languages::lang("notEmptyEmail", $GLOBALS["lang"]));
        } else if ( empty($this->getByColumn("email", $this->email)) ) {
            $this->message[] = $this->message("red", Languages::lang("EmailIsNotExists", $GLOBALS["lang"]));
        }
        
        return !empty($this->message) ? true : false;
    }
    public function checkPasswordForResetPassword(){
        if ( $this->checkPassword() ) {
            return true;
        }
        return false;
    }
    // التحقق من بيانات تعديل المعلومات
    public function checkUsernameAjax(){
        $existsError = false;
        if ( empty($this->username) ) {
            $this->message[] = $this->messageAjaxError(Languages::lang("notEmptyUserName", $GLOBALS["lang"]));
            $existsError = true;
        } else if ( mb_strlen($this->username) < 4 || mb_strlen($this->username) > 40 ) {
            $this->message[] = $this->messageAjaxError(Languages::lang("countUserName", $GLOBALS["lang"]));
            $existsError = true;
        }
        return $existsError ? true : false;
    }
    public function checkEmailAjax(){
        $existsError = false;
        if ( empty($this->email) ) {
            $this->message[] = $this->messageAjaxError(Languages::lang("notEmptyEmail", $GLOBALS["lang"]));
            $existsError = true;
        } else if ( !filter_var($this->email, FILTER_VALIDATE_EMAIL) ) {
            $this->message[] = $this->messageAjaxError(Languages::lang("checkValidEmail", $GLOBALS["lang"]));
            $existsError = true;
        }
        if ( !empty($this->sql("email", "users", "where email = '$this->email' AND id != $this->id")) ) {
            $this->message[] = $this->messageAjaxError(Languages::lang("EmailIsExists", $GLOBALS["lang"]));
            $existsError = true;
        }
        return $existsError ? true : false;
    }
    public function checkPasswordAjax(){
        $existsError = false;
        if ( empty($this->password) ) {
            $this->message[] = $this->messageAjaxError(Languages::lang("notEmptyPassword", $GLOBALS["lang"]));
            $existsError = true;
        } else if ( mb_strlen($this->password) < 5 || mb_strlen($this->password) > 40 ) {
            $this->message[] = $this->messageAjaxError(Languages::lang("countPassword", $GLOBALS["lang"]));
            $existsError = true;
        }
        return $existsError ? true : false;
    }
    public function checkMyImg(){
        $typeAllowForMyImg = ["jpg", "png", "jpeg", "gif"];
        $name = $this->img["name"];
        $tmp_name = $this->img["tmp_name"];
        $size = $this->img["size"];
        $type = pathinfo($name, PATHINFO_EXTENSION);
        if ( !in_array( $type, $typeAllowForMyImg) ) {
            $this->message[] = $this->messageAjaxError(Languages::lang("messageAllowFile", $GLOBALS["lang"]));
        } else {
            $sizeFile = round( ($size / 1024) / 1024, 2 );
            if ( $sizeFile > 10 ) {
                $this->message[] = $this->messageAjaxError(Languages::lang("messageSizeFileImg", $GLOBALS["lang"]));
            }
        }
        return !empty($this->message) ? true : false;
    }
    
    public function showMessage(){
        return $this->message;
    }
    
}

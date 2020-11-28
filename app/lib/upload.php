<?php
namespace syriashop\lib;
use \syriashop\lib\Languages;
use \syriashop\lib\Messages;

class Upload {
    use Messages;
    public $name, $type, $tmp_name, $size, $messages;
    const typeAllow = ["jpg", "png", "jpeg", "gif", "mp4"];
    const typeAllowForMyImg = ["jpg", "png", "jpeg", "gif"];
    
    public function checkFile(){
        $type = pathinfo($this->name, PATHINFO_EXTENSION);
        if ( !in_array( $type, self::typeAllow) ) {
            $this->messages[] = $this->messageAjaxError(Languages::lang("messageAllowFile", $GLOBALS["lang"]));
        } else {
            $size = round( ($this->size / 1024) / 1024, 2 );
            if ( $type == "mp4" ) { // في حال كان فيديو
                if ( $size > 40 ) {
                    $this->messages[] = $this->messageAjaxError(Languages::lang("messageSizeFileVideo", $GLOBALS["lang"]));
                }
            } else { // في حال كان صورة
                if ( $size > 10 ) {
                    $this->messages[] = $this->messageAjaxError(Languages::lang("messageSizeFileImg", $GLOBALS["lang"]));
                }
            }
        }
        return !empty($this->messages) ? true : false;
    }
    public function compress($tmp_name, $name, $c) {
        $info = getimagesize($tmp_name);

        if ($info["mime"] == "image/jpeg") {
            $img = imagecreatefromjpeg($tmp_name);
        } else if ($info["mime"] == "image/png") {
            $img = imagecreatefrompng($tmp_name);
        } else if ($info["mime"] == "image/jpg") {
            $img = imagecreatefromjpg($tmp_name);
        }

        imagejpeg($img, $name, $c);

        return $name;
    }
    public function checkFileMyImg(){
        $type = pathinfo($this->name, PATHINFO_EXTENSION);
        if ( !in_array( $type, self::typeAllowForMyImg) ) {
            $this->messages[] = $this->messageAjaxError(Languages::lang("messageAllowFileImgOnly", $GLOBALS["lang"]));
        } else {
            $size = round( ($this->size / 1024) / 1024, 2 );
            if ( $size > 10 ) {
                $this->messages[] = $this->messageAjaxError(Languages::lang("messageSizeFileImg", $GLOBALS["lang"]));
            }
        }
        return !empty($this->messages) ? true : false;
    }
    
    public function showMessages(){
        return $this->messages[0];
    }
    
}

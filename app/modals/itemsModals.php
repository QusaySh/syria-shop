<?php
namespace syriashop\modals;
use \syriashop\lib\Languages;
use \syriashop\lib\Messages;

class ItemsModals extends AbstractModals {
    use Messages;
    
    public $item_id, $key_hash, $item_name, $item_description, $item_price, $item_add_date, $item_end_date,
            $item_media, $tags, $item_type, $phoneuser, $whatsapp, $item_location, $item_country, $discount, $cat_id, $user_id, $messages, $img;
    
    protected static $tableName = "items";
    protected static $tableSchema = array(
        "key_hash" => self::DATA_TYPE_STR,
        "item_name" => self::DATA_TYPE_STR,
        "item_description" => self::DATA_TYPE_STR,
        "item_price" => self::DATA_TYPE_INT,
        "item_add_date" => self::DATA_TYPE_STR,
        "item_end_date" => self::DATA_TYPE_STR,
        "item_media" => self::DATA_TYPE_STR,
        "tags" => self::DATA_TYPE_STR,
        "item_type" => self::DATA_TYPE_INT,
        "phoneuser" => self::DATA_TYPE_STR,
        "whatsapp" => self::DATA_TYPE_STR,
        "item_location" => self::DATA_TYPE_STR,
        "item_country" => self::DATA_TYPE_STR,
        "discount" => self::DATA_TYPE_INT,
        "cat_id" => self::DATA_TYPE_INT,
        "user_id" => self::DATA_TYPE_INT,
    );
    protected static $primaryKey = "item_id";
    
    
    public function checkInputInsert(){
        
        if ( empty($this->item_name) ) {
            $this->messages[] = $this->messageAjaxError(Languages::lang("messageEmptyItemName", $GLOBALS["lang"]));
        } else if ( mb_strlen($this->item_name) < 3 || mb_strlen($this->item_name) > 50 ) {
            $this->messages[] = $this->messageAjaxError(Languages::lang("messageGTItemName", $GLOBALS["lang"]));
        }
        if ( empty($this->item_description) ) {
            $this->messages[] = $this->messageAjaxError(Languages::lang("messageEmptyItemDesc", $GLOBALS["lang"]));
        }
        
        if ( $this->item_type == 2 ) { // في حال اختيار بيع منتج
            if ( empty($this->item_price) ) {
                $this->messages[] = $this->messageAjaxError(Languages::lang("messageEmptyItemPrice", $GLOBALS["lang"]));
            }
        } else if ( empty($this->item_type) ) {
            $this->messages[] = $this->messageAjaxError(Languages::lang("messageEmptyItemType", $GLOBALS["lang"]));
        }
        
        if ( empty($this->item_location) ) {
            $this->messages[] = $this->messageAjaxError(Languages::lang("messageEmptyItemLocation", $GLOBALS["lang"]));
        }
        
        if ( empty($this->phoneuser) ) {
            $this->messages[] = $this->messageAjaxError(Languages::lang("messageEmptyPhoneUser", $GLOBALS["lang"]));
        }
        if ( empty($this->whatsapp) ) {
            $this->messages[] = $this->messageAjaxError(Languages::lang("messageEmptyWhatsapp", $GLOBALS["lang"]));
        }
        if ( !empty($this->img) ) { // في حال اختيار صورة
            $upload = new \syriashop\lib\Upload();
            if ( !empty($this->item_id) ) { // في حال كانت الامر تعديل
                $countMedai = $this->getByColumn("item_id", $this->item_id);
                $countMedai = explode(",", $countMedai->item_media);
                if ( (count($countMedai) + count($this->img["name"])) > 7 ) { // في خال تم اضافة مرفقات اكثر من 7 بعد التعديل
                    $this->messages[] = $this->messageAjaxError(Languages::lang("messageCountFileEdit", $GLOBALS["lang"]));
                }
            }
            
            if ( count($this->img["name"]) > 7 ) { // في حال كان عدد الملفات اكثر من 7
                $this->messages[] = $this->messageAjaxError(Languages::lang("messageCountFile", $GLOBALS["lang"]));
            } else {
                for ( $i = 0; $i <= count($this->img["name"]) - 1; $i++ ) {
                     $upload->name = $this->img["name"][$i];
                     $upload->tmp_name = $this->img["tmp_name"][$i];
                     $upload->size = $this->img["size"][$i];
                     $upload->type = $this->img["type"][$i];
                     if ( $upload->checkFile() ) {
                         $this->messages[] = $upload->showMessages();
                     }
                 }
            }
        }
        if ( empty($this->tags) ) {
            $this->messages[] = $this->messageAjaxError(Languages::lang("messageEmptyTags", $GLOBALS["lang"]));
        }
        
        return !empty($this->messages) ? true : false;
    }
    
    public function showMessages(){
        return $this->messages;
    }
}

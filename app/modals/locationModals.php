<?php
namespace syriashop\modals;
use syriashop\lib\Upload;
use syriashop\lib\Messages;
use syriashop\lib\Redirect;
use syriashop\lib\Languages;

class LocationModals extends AbstractModals {
    use Messages; use Redirect;
    
    public $location_country_id, $location_name, $location_number, $location_icon, $messages;
    
    protected static $tableName = "location_country";
    protected static $tableSchema = array(
        "location_name" => self::DATA_TYPE_STR,
        "location_number" => self::DATA_TYPE_STR,
        "location_icon" => self::DATA_TYPE_STR,
    );
    protected static $primaryKey = "location_country_id";
    
    public function checkInput($edit = null){
        if ( empty($this->location_name) ) {
            $this->messages[] = $this->messageAjaxError(\syriashop\lib\Languages::lang("dashboardMessageEnterCountryName", $GLOBALS["lang"]));
        }
        if ( empty($this->location_number) ) {
            $this->messages[] = $this->messageAjaxError(\syriashop\lib\Languages::lang("dashboardMessageEnterCountryKey", $GLOBALS["lang"]));
        }
        if ( $edit == null ) {
            $allCountry = $this->getAll();
            foreach ($allCountry as $cou ) {
                if ( $cou->location_name == $this->location_name ) {
                    $this->messages[] = $this->messageAjaxError(\syriashop\lib\Languages::lang("dashboardMessageCountryExists", $GLOBALS["lang"]));
                    break;
                }
            }
        } else {
            $allCountry = $this->sql("location_name", "location_country", "where location_country_id != {$this->location_country_id}");
            if ( $allCountry->location_name == $this->location_name ) {
                $this->messages[] = $this->messageAjaxError(\syriashop\lib\Languages::lang("dashboardMessageCountryExists", $GLOBALS["lang"]));
            }
        }
        
        if ( $edit == null ) { // في حال كانالتحقق من عملية ادخال
            if ( !empty($_FILES["uploadCountry"]) ) {
                $upload = new Upload();
                $file = $_FILES["uploadCountry"];
                $upload->name = $file["name"];
                $upload->size = $file["size"];
                if ( $upload->checkFileMyImg() ) {
                    $this->messages[] = $upload->showMessages();
                }
            } else {
                $this->messages[] = $this->messageAjaxError(\syriashop\lib\Languages::lang("dashboardMessageEnterCountryIcon", $GLOBALS["lang"]));
            }
        } else { // في حال كان التحقق من عملبة تعديل
            if ( !empty($_FILES["uploadCountry"]) ) {
                $upload = new Upload();
                $file = $_FILES["uploadCountry"];
                $upload->name = $file["name"];
                $upload->size = $file["size"];
                if ( $upload->checkFileMyImg() ) {
                    $this->messages[] = $upload->showMessages();
                }
            }
        }
        return !empty($this->messages) ? true : false;
    }
    
    public function showMessages(){
        return $this->messages;
    }
    
}

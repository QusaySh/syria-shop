<?php
namespace syriashop\modals;
use \syriashop\lib\Languages;
use \syriashop\lib\Messages;
class CityModals extends AbstractModals {
    use Messages;
    public $location_city_id, $location_name, $location_country_id;
    
    protected static $tableName = "location_city";
    protected static $tableSchema = array(
        "location_name" => self::DATA_TYPE_STR,
        "location_country_id" => self::DATA_TYPE_INT,
    );
    protected static $primaryKey = "location_city_id";
    
    public function checkInput($edit = null){
        if ( empty($this->location_name) ) {
            $this->messages[] = $this->messageAjaxError(\syriashop\lib\Languages::lang("dashboardMessageEnterCityName", $GLOBALS["lang"]));
        }
        if ( $edit == null ) {
            $allCity = $this->getAll();
            foreach ($allCity as $city ) {
                if ( $city->location_name == $this->location_name ) {
                    $this->messages[] = $this->messageAjaxError(\syriashop\lib\Languages::lang("dashboardMessageCityExists", $GLOBALS["lang"]));
                    break;
                }
            }
        if ( empty($this->location_country_id) ) {
            $this->messages[] = $this->messageAjaxError(\syriashop\lib\Languages::lang("dashboardMessageEnterCountryName", $GLOBALS["lang"]));
        }
        } else {
            $allCountry = $this->sql("location_name", "location_city", "where location_city_id != {$this->location_city_id}");
            if ( $allCountry->location_name == $this->location_name ) {
                $this->messages[] = $this->messageAjaxError(\syriashop\lib\Languages::lang("dashboardMessageCityExists", $GLOBALS["lang"]));
            }
        }
        return !empty($this->messages) ? true : false;
    }
    
    public function showMessages(){
        return $this->messages;
    }
    
    
}

<?php
namespace syriashop\modals;
use \syriashop\lib\Languages;

class ReportsItemsModals extends AbstractModals {
    use \syriashop\lib\Messages;
    
    public $report_id, $report_text, $report_to, $report_to_key, $message;
    
    protected static $tableName = "reports";
    protected static $tableSchema = array(
        "report_text" => self::DATA_TYPE_STR,
        "report_to" => self::DATA_TYPE_INT,
        "report_to_key" => self::DATA_TYPE_STR,
    );
    protected static $primaryKey = "report_id";

    public function checkInput(){
        if ( empty($this->report_text) ) {
            $this->message = $this->messageAjaxError(Languages::lang("reportsClientMessageError1", $GLOBALS["lang"]));
        } else if ( mb_strlen($this->report_text) < 3 || mb_strlen($this->report_text) > 255 ) {
            $this->message = $this->messageAjaxError(Languages::lang("reportsClientMessageError2", $GLOBALS["lang"]));
        }
        return !empty($this->message) ? true : false;
    }


    public function showMessage(){
        return $this->message;
    }
    
}

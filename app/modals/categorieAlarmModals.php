<?php
namespace syriashop\modals;

class CategorieAlarmModals extends AbstractModals {
    public $categorie_id, $user_id;
    
    protected static $tableName = "categorie_alarms";
    protected static $tableSchema = array(
        "categorie_id" => self::DATA_TYPE_INT,
        "user_id" => self::DATA_TYPE_INT,
    );
    protected static $primaryKey = "alarm_id";
    
}

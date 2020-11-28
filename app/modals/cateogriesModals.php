<?php
namespace syriashop\modals;
use syriashop\lib\Upload;
use syriashop\lib\Messages;
use syriashop\lib\Redirect;
use syriashop\lib\Languages;

class cateogriesModals extends AbstractModals {
    use Messages, Redirect;
    public $categorie_id, $categorie_name, $categorie_parent, $categorie_icon;
    
    protected static $tableName = "categories";
    protected static $tableSchema = array(
        "categorie_id"   => self::DATA_TYPE_INT,
        "categorie_name" => self::DATA_TYPE_STR,
        "categorie_parent" => self::DATA_TYPE_STR,
        "categorie_icon" => self::DATA_TYPE_STR
    );
    protected static $primaryKey = "categorie_id";
    
    public function checkInput($edit = null){
        if ( empty($this->categorie_name) ) {
            $this->messages[] = $this->messageAjaxError(\syriashop\lib\Languages::lang("dashboardMessageEnterCatName", $GLOBALS["lang"]));
        }
        if ( empty($this->categorie_parent) ) {
            $this->messages[] = $this->messageAjaxError(\syriashop\lib\Languages::lang("dashboardMessageEnterCatParent", $GLOBALS["lang"]));
        }
        if ( $edit == null ) {
            $allCat = $this->getAll();
            if ( !empty($allCat) ) { // في حال يوجد اقسام
                foreach ($allCat as $cat ) {
                    if ( $cat->categorie_name == $this->categorie_name ) {
                        $this->messages[] = $this->messageAjaxError(\syriashop\lib\Languages::lang("dashboardMessageCatExists", $GLOBALS["lang"]));
                        break;
                    }
                }
            }
        } else {
            $allCat = $this->sql("categorie_name", "categories", "where categorie_id != {$this->categorie_id}");
            if ( $allCat->categorie_name == $this->categorie_name ) {
                $this->messages[] = $this->messageAjaxError(\syriashop\lib\Languages::lang("dashboardMessageCatExists", $GLOBALS["lang"]));
            }
        }
        
        if ( $edit == null ) { // في حال كانالتحقق من عملية ادخال
            if ( !empty($_FILES["uploadIconCat"]) ) {
                $upload = new Upload();
                $file = $_FILES["uploadIconCat"];
                $upload->name = $file["name"];
                $upload->size = $file["size"];
                if ( $upload->checkFileMyImg() ) {
                    $this->messages[] = $upload->showMessages();
                }
            }
        } else { // في حال كان التحقق من عملبة تعديل
            if ( !empty($_FILES["uploadIconCat"]) ) {
                $upload = new Upload();
                $file = $_FILES["uploadIconCat"];
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

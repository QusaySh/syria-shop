<?php
namespace syriashop\lib;

trait Messages {
    
    public function message($color, $text){
        return '<div class="card-panel ' . $color . '">
        <span class="white-text">' . $text . '.</span>
      </div>';
    }
    
    public function messageAjaxError($text){
        return "<span>" . $text . "<i class='material-icons red-text left'>close</i></span>";
    }
    public function messageAjaxSuccess($text){
        return "<span>" . $text . "<i class='material-icons green-text left'>check</i></span>";
    }
    
}

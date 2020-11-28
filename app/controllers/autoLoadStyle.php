<?php
namespace syriashop\controllers;

class AutoLoadStyle {
    
    private $_controller = "client";
    private $_action = "default";
    private $_params = array();
    
    public function __construct() {
        $this->_callstyle();
    }
    
    private function _callstyle()
    {
        $url = explode("/", trim($_SERVER["REQUEST_URI"], "/"), 3);
        if ( isset($url[0]) && !empty($url[0]) )
        {
            $this->_controller = $url[0];
        }
        if ( isset($url[1]) && !empty($url[1]) )
        {
            $this->_action = $url[1];
        }
        
    }
    
    public function filesCss(){
        $srcFile = dirname(dirname(dirname(__FILE__))) . "/public/css/" . $this->_controller . DS . $this->_action . ".css";
        $file = DS . "css" . DS . $this->_controller . DS . $this->_action . ".css";
        if ( file_exists($srcFile)  ) {
            return $file;
        }
        return false;
    }
    public function filesJs(){
        $srcFile = dirname(dirname(dirname(__FILE__))) . "/public/js/" . $this->_controller . DS . $this->_action . ".js";
        $file = DS . "js" . DS . $this->_controller . DS . $this->_action . ".js";
        if ( file_exists($srcFile)  ) {
            return $file;
        }
        return false;
    }
    
}

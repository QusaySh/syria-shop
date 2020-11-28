<?php
namespace syriashop\lib;

class frontController {
    
    const NOT_FOUND_CONTROLLER = "syriashop\controllers\NotFoundController";
    const NOT_FOUND_ACTION = "notFoundAction";
    
    private $_controller    = "client";
    private $_action        = "default";
    private $_params         = array();
    
    public function __construct() {
        $this->parseUrl();
    }
    
    /*
     * تابع لاستقبال الكونترولر والاكشن والبرامتر
     */
    public function parseUrl(){
        $url = explode("/", trim($_SERVER["REQUEST_URI"], "/"), 3);
        if ( isset($url[0]) && !empty($url[0]) ) {
            $this->_controller = $url[0];
        }
        if ( isset($url[1]) && !empty($url[1]) ) {
            $this->_action = $url[1];
        }
        if ( isset($url[2]) && !empty($url[2]) ) {
            $this->_params = explode("/", $url[2]);
        }
    }
    
    public function dispatch(){
        $controllerClassName = "syriashop\controllers\\" . ucfirst($this->_controller) . "Controller";
        $actionName = $this->_action . "Action";
        if ( !class_exists($controllerClassName) ) {
            $controllerClassName = self::NOT_FOUND_CONTROLLER;
        }
        $controller = new $controllerClassName();
        if ( !method_exists($controller, $actionName) ) {
            $this->_action = $actionName = self::NOT_FOUND_ACTION;
        }
        $controller->setController($this->_controller);
        $controller->setAction($this->_action);
        $controller->setParams($this->_params);
        session_start();
        $controller->$actionName();
        
    }
    
}
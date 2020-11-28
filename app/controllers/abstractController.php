<?php
namespace syriashop\controllers;

class AbstractController {
    
    protected $_controller, $_action, $_params;
    protected $_data = array();


    public function notFoundAction(){
        $this->_view();
    }
    
    public function setController($controllerName) {
        $this->_controller = $controllerName;
    }
    public function setAction($actionName){
        $this->_action = $actionName;
    }
    public function setParams($params){
        $this->_params = $params;
    }
    
    protected function _view(){
        require TEMPLATE_PATH . DS . "header.php";
        require TEMPLATE_PATH . DS . "nav.php";
        require VIEWS_PATH . DS . "allAudio.php";
        
        if ( $this->_action == \syriashop\lib\frontController::NOT_FOUND_ACTION ) {
            require VIEWS_PATH . DS . "notfound" . DS . "notfound.view.php";
        } else {
            $path = VIEWS_PATH . DS . strtolower($this->_controller) . DS . $this->_action . ".view.php";
            if ( !file_exists($path) ) {
                require VIEWS_PATH . DS . "notfound" . DS . "notfound.view.php";    
            } else {
                extract($this->_data);
                require $path;
            }
        }
        
        require TEMPLATE_PATH . DS . "footer.php";
    }
    
}

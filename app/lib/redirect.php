<?php
namespace syriashop\lib;

trait Redirect {
    
    public function headerTo($page){
        session_write_close();
        header("location: " . $page);
        exit();
    }
    
}

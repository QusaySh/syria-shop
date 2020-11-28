<?php
namespace syriashop\lib;

trait FilterInput {
    
    public function filterStr($input){
        return htmlentities(strip_tags($input), ENT_QUOTES, "UTF-8");
    }
    public function filterEmail($input){
        return filter_var($input, FILTER_SANITIZE_EMAIL);
    }
    public function filterInt($input){
        return filter_var($input, FILTER_SANITIZE_NUMBER_INT);
    }
    public function hashPassword($input){
        return password_hash($input, PASSWORD_BCRYPT);
    }
    
}

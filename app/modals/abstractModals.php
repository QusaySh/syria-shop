<?php
namespace syriashop\modals;
class AbstractModals {
    use \syriashop\lib\Database;
    CONST DATA_TYPE_STR = \PDO::PARAM_STR;
    CONST DATA_TYPE_INT = \PDO::PARAM_INT;
    
    private function bulidParam(){
        $column = "";
        foreach ( static::$tableSchema as $columns => $type ) {
            if ( empty($this->$columns) ) {
                continue;
            } else {
                $column .= $columns . " = :" . $columns . ", ";
            }
        }
        return trim($column, ", ");
    }
    
    private function bindParameter($stmt){
        foreach ( static::$tableSchema as $columns => $type ) {
            if ( empty($this->$columns) ) {
                continue;
            } else {
                $stmt->bindParam(":{$columns}", $this->$columns, $type);
            }
        }
    }

    public function getByKey($fetch = null){
        //global $conn;
        $conn = self::setConn();
        $sql = "SELECT * FROM " . static::$tableName . " WHERE " . static::$primaryKey . " = :" . static::$primaryKey;
        $stmt = $conn->prepare($sql);
        $stmt->bindParam(":" . static::$primaryKey, $this->{static::$primaryKey}, self::DATA_TYPE_INT);
        $stmt->execute();
        $result = $stmt->fetchAll(\PDO::FETCH_CLASS, get_called_class());
        self::closeConn();
        if ( !empty($result) && $fetch == null ) {
            return $result[0];
        } else if ( !empty($result) && $fetch != null) {
            return $result;
        } else {
            return false;
        }
    }
    
    public function getByColumn($column, $value, $fetch = null){
        //global $conn;
        $conn = self::setConn();
        $sql = "SELECT * FROM " . static::$tableName . " WHERE " . $column . " = ?";
        $stmt = $conn->prepare($sql);
        $stmt->execute(array($value));
        $result = $stmt->fetchAll(\PDO::FETCH_CLASS, get_called_class());
        self::closeConn();
        if ( !empty($result) && $fetch == null ) {
            return $result[0];
        } else if ( !empty($result) && $fetch != null) {
            return $result;
        } else {
            return false;
        }
    }
    
    public function getAll(){
        //global $conn;
        $conn = self::setConn();
        $sql = "SELECT * FROM " . static::$tableName;
        $stmt = $conn->prepare($sql);
        $stmt->execute();
        $result = $stmt->fetchAll(\PDO::FETCH_CLASS, get_called_class());
        self::closeConn();
        return empty($result) ? false : $result;
    }
    
    public function sql( $select, $table, $where = null, $values = null, $fetch = null ){
        //global $conn;
        $conn = self::setConn();
        $sql = "SELECT $select FROM $table $where";
        $stmt = $conn->prepare($sql);
        $stmt->execute(array($values));
        $result = $stmt->fetchAll(\PDO::FETCH_CLASS, get_called_class());
        self::closeConn();
        if ( !empty($result) && $fetch == null ) {
            return $result[0];
        } else if ( !empty($result) && $fetch != null) {
            return $result;
        } else {
            return false;
        }
    }
    
    public function insert(){
        //global $conn;
        $conn = self::setConn();
        $sql = "INSERT INTO " . static::$tableName . " SET " . $this->bulidParam();
        $stmt = $conn->prepare($sql);
        $this->bindParameter($stmt);
        if ( $stmt->execute() ) {
            self::closeConn();
            return true;
        }
        self::closeConn();
        return false;
    }
    
    public function update(){
        //global $conn;
        $conn = self::setConn();
        $sql = "UPDATE " . static::$tableName . " SET " . $this->bulidParam() . " WHERE " . static::$primaryKey . " = " . $this->{static::$primaryKey};
        $stmt = $conn->prepare($sql);
        $this->bindParameter($stmt);
        if ( $stmt->execute() ) {
            self::closeConn();
            return true;
        }
        self::closeConn();
        return false;
    }
    
    public function updateSingle($set, $where){
        //global $conn;
        $conn = self::setConn();
        $sql = "UPDATE " . static::$tableName . " SET " . $set . " WHERE " . $where;
        $stmt = $conn->prepare($sql);
        if ( $stmt->execute() ) {
            self::closeConn();
            return true;
        }
        self::closeConn();
        return false;
    }
    
    public function delete( $where ){
        //global $conn;
        $conn = self::setConn();
        $sql = "DELETE FROM " . static::$tableName . $where;
        $stmt = $conn->prepare($sql);
        $this->bindParameter($stmt);
        if ( $stmt->execute() ) {
            self::closeConn();
            return true;
        }
        self::closeConn();
        return false;
    }


    public function rowCount($table, $where= null){
        //global $conn;
        $conn = self::setConn();
        $sql = $conn->prepare("SELECT * FROM $table $where");
        $sql->execute();
        self::closeConn();
        return $sql->rowCount();
        
    }
    
}

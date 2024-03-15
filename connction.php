<?php

class DBconnection{
    private static $instance = null;
    private $connection;
    private string $dbtype; 
    private string $host; 
    private string $dbname; 
    private string $username; 
    private string $password;
    private function __construct(string $dbtype,string $host,string $dbname,string $username,string $password){
        $this->dbtype =$dbtype; 
        $this->host =$host; 
        $this->dbname =$dbname; 
        $this->username =$username; 
        $this->password =$password; 
        try{
        $this->connection = new PDO("{$this->dbtype}:host={$this->host};dbname={$this->dbname}",$this->username,$this->password);
        }
        catch(Exception $e){
            echo "Error in ".$e->getMessage();
        }
    }
    public static function getInstance(string $dbtype,string $host,string $dbname,string $username,string $password){
        if (self::$instance == null){
            self::$instance = new DBconnection($dbtype,$host,$dbname,$username,$password);
        }
        return self::$instance;
    }
    // Select Data
    public function getAllData(string $table) {
        $queryDB = "select * from $table";
        $stmt = $this->connection->query($queryDB);
        $users = $stmt->fetchAll(PDO::FETCH_ASSOC);
        return $users;
    }
    public function getAllDataCount(string $table , array $values) {
        $valuesArray = array_values($values);
        $setValeus =  "";
        foreach($values as $keys=>$value){
            $setValeus.= "$keys=?,";
        }
        $setValeus = rtrim($setValeus, ',');
        $queryDB = "select count(*) from $table where $setValeus";
        $stmt = $this->connection->prepare($queryDB);
        $stmt->execute($valuesArray);
        $users = $stmt->fetchAll(PDO::FETCH_ASSOC);
        return $users;
    }
    public function getData(string $table,array $values) {
        $valuesArray = array_values($values);
        $setValeus =  "";
        foreach($values as $keys=>$value){
            $setValeus.= "$keys=?,";
        }
        $setValeus = rtrim($setValeus, ',');
        $queryDB = "select * from $table where $setValeus";
        $stmt = $this->connection->prepare($queryDB);
        $stmt->execute($valuesArray);
        $user = $stmt->fetch(PDO::FETCH_ASSOC);
        return $user;
    }
    public function getDataCategory(string $table,array $values) {
        $valuesArray = array_values($values);
        $setValeus =  "";
        foreach($values as $keys=>$value){
            $setValeus.= "$keys=?,";
        }
        $setValeus = rtrim($setValeus, ',');
        $queryDB = "select * from $table where $setValeus";
        $stmt = $this->connection->prepare($queryDB);
        $stmt->execute($valuesArray);
        $user = $stmt->fetchAll(PDO::FETCH_ASSOC);
        return $user;
    }
    public function getDataCategoryDistinct(string $value,string $table) {
        $queryDB = "select distinct $value from $table";
        $stmt = $this->connection->prepare($queryDB);
        $stmt->execute();
        $user = $stmt->fetchAll(PDO::FETCH_ASSOC);
        return $user;
    }
    // Insert Data
    public function getInsertDataCus(string $table,array $data) {
        $keys   = implode(",", array_keys($data));
        $questionMark = implode(",",array_fill(0, count($data), '?'));
        $Values = array_values($data);
        $queryDB = "insert into $table($keys) values($questionMark)";
        $stmt= $this->connection->prepare($queryDB);
        $result=$stmt->execute($Values);
        return $result;
    }
    // Update Data
    public function getUpdateData(string $table,array $data,array $where) {
        $dataValues = array_values($data);
        $whereValues = array_values($where);
        $setWhere = "";
        foreach($where as $keys=>$value){
            $setWhere.= "$keys=?,";
        }
        $setWhere = rtrim($setWhere, ",");
        $setValues = "";
        foreach($data as $keys=>$value) {
            $setValues.="$keys=?,";
        }
        $setValues = rtrim($setValues,",");
        $queryDB = "update $table set $setValues where $setWhere";
        $stmt = $this->connection->prepare($queryDB);
        $arrayValues = array_merge($dataValues,$whereValues);
        $result = $stmt->execute($arrayValues);
        return $result;
    }
    // Delete Data
    public function deleteData(string $table, array $where){
        $whereValues = array_values($where);
        $setWhere = "";
        foreach($where as $keys=>$value){
            $setWhere .= "$keys=?,";
        }
        $setWhere = rtrim($setWhere, ",");
        $queryDB="delete from $table where $setWhere";
        $stmt = $this->connection->prepare($queryDB);
        $result=$stmt->execute($whereValues);
        return $result;
    }
    // public function getDataJoin(array $tables, string $fromTable, string $toTable, array $valuesJoin) {
    //     $valuesTables = implode(", ", array_map(function($key, $value) {
    //         if(is_array($value)) {
    //             return implode(", ", array_map(function($column) use ($key) {
    //                 return "$key.$column";
    //             }, $value));
    //         } else {
    //             return "$key.$value";
    //         }
    //     }, array_keys($tables), $tables));
        
    //     $valuesTablesJoin = "";
    //     foreach($valuesJoin as $keys => $values) {
    //         $valuesTablesJoin .= "$keys.$values = ";
    //     }
    //     $valuesTablesJoin = rtrim($valuesTablesJoin, '= ');
        
    //     $queryDB = "select $valuesTables from $fromTable join $toTable on $valuesTablesJoin";
    //     $stmt = $this->connection->prepare($queryDB);
    //     $stmt->execute();
    //     $rows = $stmt->fetchAll(PDO::FETCH_ASSOC);  
    //     return $rows;  
    // }
    
}
$dbtype = 'mysql';
$host = 'localhost';
$dbname = 'resturant';
$username = 'root';
$password = '';

$dbConnection = DBConnection::getInstance($dbtype, $host, $dbname, $username, $password);

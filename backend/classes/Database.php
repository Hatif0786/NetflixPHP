<?php 

class Database{
    protected $pdo;
    protected static $instance;

    protected function __construct(){
        try{
            $this->pdo= new PDO('mysql:host='.DB_HOST.';dbname='.DB_NAME,DB_USER,DB_PASS); 
        }catch(PDOException $e){
            echo "Connection Failed".$e->getMessage();
        }
    }

    public static function instance(){
        if(self::$instance===null){
            self::$instance= new self;
        }
        return self::$instance;
    }

    public function __call($method, $args){
        return call_user_func_array(array($this->pdo, $method), $args); 
    }

    public static function query($query, $params=array()){
        $stmt=self::instance()->prepare($query);
        $stmt->execute($params);

        if(explode(" ", $query)[0]=="SELECT"){
            $data=$stmt->fetchAll();
            return $data;
        }

    }
}
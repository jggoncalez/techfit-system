<?php
namespace config;
class Database{
    private static $instance = null;
    private $connection;



    private function __construct()
    {
        $host = Config::DB_HOST;
        $dbname = Config::DB_NAME;
        $username = Config::DB_USER;
        $password = Config::DB_PASS;
        $charset = Config::DB_CHAR;

        try {
            $this -> connection = new PDO(
                "mysql:host=$host;dbname=$dbname;charset=$charset",
                $username,
                $password
            );
            $this -> connection-> setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        }catch(\PDOException $e){
            die($e->getMessage());
        }
    }

    public static function getInstance(){
        if (self::$instance === null){
            self::$instance = new self();
        }
        return self::$instance;
    }

    public function getConnection(): PDO
    {
        return $this->connection;
    }

    private function __clone(){}

}
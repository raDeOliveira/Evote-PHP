<?php

class Database {
 
    // specify your own database credentials
    private $host = "localhost";
    private $db_name = "app_atw2";
    private $username = "";
    private $password = "";
    public $conn;

    // get the database connection with PDO
    public function getConnection(){
 
        $this->conn = null;
 
        try{
            $this->conn = new PDO("mysql:host=" . $this->host . ";dbname=" . $this->db_name, $this->username, $this->password);
        }catch(PDOException $exception){
            echo "Connection error: " . $exception->getMessage();
        }
 
        return $this->conn;
    }

}

?>
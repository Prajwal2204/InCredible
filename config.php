<?php

class DBC{
    private $DB_server;
    private $username;
    private $password;
    private $dbname;
    public function connect(){
        $this->DB_server = "localhost";
        $this->username = "root";
        $this->password = "";
        $this->dbname = "credit_card";

        $conn = new mysqli( $this->DB_server,$this->username,$this->password,$this->dbname);
        // Check connection
        // if($conn === false){
        //     die("ERROR: Could not connect. " . $conn->connect_error);
        // }
        return $conn;

    }

}
?>
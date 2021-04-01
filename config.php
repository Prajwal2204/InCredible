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
/* Database credentials. Assuming you are running MySQL
server with default setting (user 'root' with no password) */
// define('DB_SERVER', 'localhost');
// define('DB_USERNAME', 'root');
// define('DB_PASSWORD', '');
// define('DB_NAME', 'credit_card');
 
// /* Attempt to connect to MySQL database */
// $mysqli = new mysqli(DB_SERVER, DB_USERNAME, DB_PASSWORD, DB_NAME);
 
// // Check connection
// if($mysqli === false){
//     die("ERROR: Could not connect. " . $mysqli->connect_error);
// }
?>
<?php

class DBC{
    private $DB_server;
    private $username;
    private $password;
    private $dbname;
    protected function connect(){
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

    
    protected function validatecard($number)
    {
       
   
       $cardtype = array(
           "VISA"       => "/^4[0-9]{12}(?:[0-9]{3})?$/",
           "MasterCard" => "/^5[1-5][0-9]{14}$/",
           "Amex"       => "/^3[47][0-9]{13}$/",
           "Discover"   => "/^6(?:011|5[0-9]{2})[0-9]{12}$/",
       );
   
       if (preg_match($cardtype['VISA'],$number))
       {
       $this->type= "VISA";
           //return 'VISA';
       
       }
       else if (preg_match($cardtype['MasterCard'],$number))
       {
       $this->type= "MasterCard";
           //return 'MasterCard';
       }
       else if (preg_match($cardtype['Amex'],$number))
       {
       $this->type= "Amex";
           //return 'Amex';
       
       }
       else if (preg_match($cardtype['Discover'],$number))
       {
       $this->type= "Discover";
           //return 'Discover';
       }
       else
       {
           $this->type = false;
           //return false;
       } 
       return $this->type;
    }

}
?>
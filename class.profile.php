<?php 

include_once "config.php";
class profile extends DBC{
    public function __construct()
    {
        session_start();
    }
    
    //$mysqli = $this->connect();

    public function view_profile(){
           //global $mysqli = $this->connect();
        if(!isset($_SESSION["loggedin"])){
            header("location: login.php");
            exit;
        }

        $mysqli = $this->connect();
        error_reporting(E_ERROR | E_PARSE);

        global $user_name,$email_id,$phone_no,$email_err,$phone_err, $fullname_err;
        $email = $_POST["email"];
        $phone = $_POST["number"];
        $full = $_POST["name"];

        if(empty(trim($full))){
            $fullname_err = "Please enter ur name";
           
        } else {
            if(!preg_match("/^([a-zA-Z' ]+)$/",$full)){
                $fullname_err = "It should contain alphabets";
            }
            else{
                    $valid_full = trim($full);
            }
        }

        if(empty(trim($email))){
            $email_err = "Please enter an email.";
           
        } else {
            if (filter_var($email, FILTER_VALIDATE_EMAIL)) {
                // echo("$email is a valid email address");
                $valid_email = trim($email);
            } else{
                $email_err = $email ." is not a valid email address";
            }
        }

        if(empty(trim($phone))){
            $phone_err = "Please enter ur phone number";
           
        } else {
            if(!(preg_match('/^[0-9]{10}+$/', $phone )))
                $phone_err = "it should contain only numeric values";
            else{
                $valid_phone = trim($phone);
            }
        }
        

        $usr = $_SESSION["username"];


        $this->get_details();
        if(empty($email_id_err) && empty($fullname_err) && empty($phone_err)){

        if($_SERVER["REQUEST_METHOD"]=="POST"){
           // $username = $_POST["username"];
           $email = $_POST["email"];
           $phone = $_POST["number"];
           $full = $_POST["name"];
   

            $sql = "UPDATE users SET  fullname = ?, emailid=?, phone_no = ?  WHERE username = ?";
            $stmt = $mysqli->prepare($sql);
            $stmt->bind_param("ssss",$valid_full,$valid_email,$valid_phone,$usr);
            $stmt->execute();
            $stmt->free_result();
            $stmt->close();
            $this->get_details();


        }
    }
        $mysqli->close();
    }

    public function get_details(){
        $mysqli = $this->connect();
        global $user_name,$email_id,$phone_no,$full_name;
        $usr = $_SESSION["username"];

        $stmt2 = $mysqli->prepare("SELECT fullname, emailid, phone_no from users where username = ?");
        $stmt2->bind_param("s",$usr);
        $stmt2->execute();
        $result = $stmt2->get_result();
        $rows = $result->fetch_assoc();
        $full_name = $rows['fullname']; 
        $email_id = $rows['emailid'];
        $phone_no = $rows['phone_no'];
        // $stmt2->bind_result($email_id,$phone_no);
        // $result = $stmt2->fetch();
        $stmt2->free_result();
        $stmt2->close();
        $mysqli->close();
        //return $result;

    }
}
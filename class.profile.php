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
        // error_reporting(E_ERROR | E_PARSE);

        global $full_name,$email_id,$phone_no,$email_err,$phone_err, $fullname_err;
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


        // $this->get_details();
        if(empty($email_err) && empty($fullname_err) && empty($phone_err)){

        if($_SERVER["REQUEST_METHOD"]=="POST"){
           // $username = $_POST["username"];
        //    $email = $_POST["email"];
        //    $phone = $_POST["number"];
        //    $full = $_POST["name"];
   

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

    public function display_cards(){
        $mysqli = $this->connect();

        $sql = "SELECT * FROM cards  WHERE username = ?";
        if($stmt = $mysqli->prepare($sql)){
            $stmt->bind_param("s",$_SESSION['username']);
            $stmt->execute();
            $result = $stmt->get_result();

            if($result->num_rows){
            echo '	<table class="table table-bordered">
                    <thead>
                    <tr class = "red-bg">
                        
                        <td class = "white-font">Card Holder Name</td>
                        <td class = "white-font">Bank Name</td>
                        <td class = "white-font">Card Number</td>
                        <td class = "white-font">Card Type</td>
                        <td class = "white-font">Expiry Date</td>
                        <td class = "white-font">Account Balance (INR)</td>
                    </tr>
                    </thead>
                    ';
                while($rows = $result->fetch_assoc()){
                    echo '
                    <tbody>
                    <tr>
                        <form action = "" method = "post" role = "form">
                            
                            <td class = "white-font">'.$rows['name'].'</td>
                            <td class = "white-font">'.$rows['bank'].'</td>
                            <td class = "white-font">'.$rows['card_no'].'</td>
                            <td class = "white-font">'.$rows['card_type'].'</td>
                            <td class = "white-font">'.$rows['expiry_date'].'</td>
                            <td class = "white-font">'.$rows['acc_balance'].'</td>
                        </form>
                    </tr>
                    </tbody>
                    ';
                }
                echo'</table>';
            }
            $stmt->free_result();
            $stmt->close();
        }
        $mysqli->close();
    }

}
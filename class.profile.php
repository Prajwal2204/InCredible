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

        global $user_name,$email_id,$phone_no;
        $usr = $_SESSION["username"];


        $this->get_details();

        if($_SERVER["REQUEST_METHOD"]=="POST"){
           // $username = $_POST["username"];
            $email = $_POST["emailid"];
            $phone = $_POST["number"];

            $sql = "UPDATE users SET  emailid=?, phone_no = ?  WHERE username = ?";
            $stmt = $mysqli->prepare($sql);
            $stmt->bind_param("sss",$email,$phone,$usr);
            $stmt->execute();
            $stmt->close();
            $this->get_details();


        }
        $mysqli->close();
    }

    public function get_details(){
        $mysqli = $this->connect();
        global $user_name,$email_id,$phone_no;
        $usr = $_SESSION["username"];

        $stmt2 = $mysqli->prepare("SELECT emailid, phone_no from users where username = ?");
        $stmt2->bind_param("s",$usr);
        $stmt2->execute();
        $result = $stmt2->get_result();
        $rows = $result->fetch_assoc();
        $email_id = $rows['emailid'];
        $phone_no = $rows['phone_no'];
        // $stmt2->bind_result($email_id,$phone_no);
        // $result = $stmt2->fetch();
        $stmt2->close();
        $mysqli->close();
        //return $result;

    }
}
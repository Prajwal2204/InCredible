<?php 

include_once "config.php";
class cards extends DBC{
    public function __construct()
    {
        session_start();
    }

// // Define variables and initialize with empty values
// $name = $bankname = $cardno  = $cvv = "";
// $name_err = $bankname_err = $cardno_err  = $cvv_err = "";
    public function add_card(){

        
        $mysqli = $this->connect();

        if(!isset($_SESSION["loggedin"])){
            header("location: login.php");
            exit;
        }

        global $name_err;
        global $bankname_err;
        global $cardno_err;
        global $cvv_err;
          
	
	if(isset($_POST['submit'])){
		$username = $_SESSION["username"];
		$name = $_POST['accname'];
		$bank = $_POST['bank'];
		$card_no = $_POST['cardno'];
		$cvv = $_POST['acccvv'];
		$card_type = $_POST['cardtype'];
		$expiry_date = $_POST['expdate'];
		$ins_sql = "INSERT INTO cards(username, name, bank, card_no, cvv, card_type, expiry_date) VALUES ('".$username."', '".$name."', '".$bank."', '".$card_no."','".md5($cvv)."', '".$card_type."', '".$expiry_date."')";
		//$conn = mysqli_connect('localhost', 'root', '', 'credit_card');
		$run_sql = mysqli_query($mysqli,$ins_sql);
		$_SESSION["card_no"] = $card_no;
	}
        
    
    // Close connection
        $mysqli->close();
    }
}



//session_start();
//include_once "config.php";
// if(!isset($_SESSION["loggedin"])){
//     header("location: login.php");
//     exit;
// }


	// $success = "";
	
	// if(isset($_POST['submit'])){
	// 	$username = $_SESSION["username"];
	// 	$name = $_POST['accname'];
	// 	$bank = $_POST['bank'];
	// 	$card_no = $_POST['cardno'];
	// 	$cvv = $_POST['acccvv'];
	// 	$card_type = $_POST['cardtype'];
	// 	$expiry_date = $_POST['expdate'];
	// 	$ins_sql = "INSERT INTO cards(username, name, bank, card_no, cvv, card_type, expiry_date) VALUES ('".$username."', '".$name."', '".$bank."', '".$card_no."','".md5($cvv)."', '".$card_type."', '".$expiry_date."')";
	// 	$conn = mysqli_connect('localhost', 'root', '', 'credit_card');
	// 	$run_sql = mysqli_query($conn,$ins_sql);
	// }
    ?>
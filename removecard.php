<?php
session_start();
include 'config.php';

	$success = "";

	if(isset($_POST['submit'])){

		$card_no = $_POST['card_no'];
		$name = $_POST['name'];
		$con = mysqli_connect('localhost', 'root', '', 'credit_card');
		$i_sql = "SELECT * FROM cards WHERE card_no = '".$card_no."'";
		$r_sql = mysqli_query($con,$i_sql);

		$rows = mysqli_fetch_array($r_sql);

		$email = $rows['accemail'];

		if($email==$accemail){


			$ins_sql = "DELETE FROM accounts WHERE accno ='".$accno."'";
			$run_sql = mysqli_query($con,$ins_sql);
			$in_sql = "DELETE FROM users WHERE email ='".$accemail."'";
			$ru_sql = mysqli_query($con,$in_sql);

			$success = "Account deleted successfully!";
		}else{

			$success = "Account number and email does not match!";
		}

	}
?>
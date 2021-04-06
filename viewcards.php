<?php
session_start();
include_once 'config.php';
$usr = $_SESSION["username"];
// $username = $_SESSION["username"];
// $view = new DBC;
// $mysqli = DBC->connect();
if(!isset($_SESSION["loggedin"])){
    header("location: login.php");
    exit;
}
?>
<!DOCTYPE html>
<html>
<head>
	<title>InCredible</title>
	<link rel="stylesheet" href="node_modules/bootstrap/dist/css/bootstrap.min.css">
    <link rel = "stylesheet" href = "css/styles-admin.css">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
</head>

<body class="signin-body">
	<nav>
		<ul class="topnav">
			<li class = "logo"><img class = "logo-mod" src="img/logo.PNG"></li>
			<li><a href="admin.php">Home</a></li>
			<?php if (isset($_SESSION["username"])) { ?>
			<li class = "topnav-right"><h3>Welcome, <?php echo $_SESSION["username"]; ?></h3></li>
			<?php } else { ?>
				<li class = "topnav-right"><h3>Welcome</h3></li>
				<?php } ?>
			<?php if (isset($_SESSION["loggedin"])) { ?>
			<li class = "topnav-right"><a href="logout.php">Log Out</a></li>
			<?php } else { ?>
			<li class = "topnav-right"><a href="login.php">Login</a></li>
			<?php } ?>
		</ul>
	</nav>

	<!-- <div style="width: 50px; height: 50px;"></div> -->
	<div class = "row">
		<div class="col-2 sidenav">
				<ul class="list-unstyled">
					<li><a class="btn btn-outline-danger active" href="viewcards.php"><b>View Cards</b></a></li>			
					<li><a class="btn btn-outline-danger" href="addcard.php"><b>Add Card</b></a></li>
					<!-- <li><a class="btn btn-outline-danger" href="removecard.php"><b>Remove Card</b></a></li> -->
					<li><a class="btn btn-outline-danger" href="transactions.php"><b>My Transactions</b></a></li>
					<li><a class="btn btn-outline-danger" href="viewaccounts.php"><b>View accounts</b></a></li>
					<li><a class="btn btn-outline-danger" href="transfer.php"><b>Transfer Amount</b></a></li>
				</ul>
		</div>

		<div class="col-8 container">
		<div style="width: 50px; height: 50px;"></div>
			<article class="row custom-left-pad">
				<section class="col-lg-8 white-font">
					<div class="page-header">
						<h2>Card Details</h2>
					</div>
			<?php

				$con = mysqli_connect('localhost', 'root', '', 'credit_card');
				$ins_sql = "SELECT * FROM `cards` WHERE username = '$usr' ";
				$run_sql = mysqli_query($con, $ins_sql);
			?>
			<?php
				if(isset($_POST["removeCard"])){
					$key = $_POST['removeKey'];

					$check_sql = "SELECT * FROM `cards` WHERE card_no = '$key' ";
					$run_check = mysqli_query($con, $check_sql);
					if(mysqli_num_rows($run_check)>0){
						$del_sql = "DELETE FROM `cards` WHERE card_no = '$key' ";
						$run_del = mysqli_query($con, $del_sql);
						?>
						<div class = "alert alert-success">
							<p>Record Deleted!</p>
						</div>
						<?php
						 header("Location:viewcards.php");
					}
					else{
						?>
						<div class = "alert alert-warning">
							<p>Record does not match!</p>
						</div>
						<?php
					}
				}
			?>
				<table class="table table-bordered">
							<thead>
							<tr class = "red-bg">
								<td class = "white-font">Account name</td>
								<td class = "white-font">Card Holder Name</td>
								<td class = "white-font">Bank Name</td>
								<td class = "white-font">Card Number</td>
								<td class = "white-font">Card Type</td>
								<td class = "white-font">Expiry Date</td>
								<td class = "white-font">Select</td>
								<td class = "white-font">Remove Card?</td>
							</tr>
							</thead>
				<?php
				while($rows = mysqli_fetch_array($run_sql)){

					echo '

							<tbody>
							<tr>
								<form action = "" method = "post" role = "form">
									<td class = "white-font">'.$rows['username'].'</td>
									<td class = "white-font">'.$rows['name'].'</td>
									<td class = "white-font">'.$rows['bank'].'</td>
									<td class = "white-font">'.$rows['card_no'].'</td>
									<td class = "white-font">'.$rows['card_type'].'</td>
									<td class = "white-font">'.$rows['expiry_date'].'</td>
									<td class = "white-font"><input type = "checkbox" name = "removeKey" value = "'.$rows['card_no'].'" required></td>
									<td class = "white-font"><input type = "submit" name = "removeCard" value = "Remove" class = "btn btn-danger"></td>
								</form>
							</tr>
							</tbody>
						
						
					';

				}
			?>
			</table>
	</div>
</body>
</html>


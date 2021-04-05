<?php
session_start();
include 'config.php';
if(!isset($_SESSION["loggedin"])){
    header("location: login.php");
    exit;
}

	$success = "";

	if(isset($_POST['submit'])){

		$name = $_POST['accname'];
		$card_no = $_POST['cardno'];
		$con = mysqli_connect('localhost', 'root', '', 'credit_card');
		$ins_sql = "DELETE FROM cards WHERE name ='".$name."' AND card_no ='".$card_no."' ";
		$run_sql = mysqli_query($con,$ins_sql);
		// $i_sql = "SELECT * FROM cards WHERE name = '".$name."'";
		// $r_sql = mysqli_query($con,$i_sql);

		// $rows = mysqli_fetch_array($r_sql);

		// $email = $rows['accemail'];

		// if($email==$accemail){


		// 	$ins_sql = "DELETE FROM cards WHERE name ='".$name."'";
		// 	$run_sql = mysqli_query($con,$ins_sql);
		// 	// $in_sql = "DELETE FROM users WHERE email ='".$accemail."'";
		// 	// $ru_sql = mysqli_query($con,$in_sql);

		// 	$success = "Account deleted successfully!";
		// }else{

		// 	$success = "Account number and email does not match!";
		// }

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
					<li><a class="btn btn-outline-danger" href="accountdetails.php"><b>Account Details</b></a></li>			
					<li><a class="btn btn-outline-danger" href="addcard.php"><b>Add Card</b></a></li>
					<li><a class="btn btn-outline-danger active" href="removecard.php"><b>Remove Card</b></a></li>
					<li><a class="btn btn-outline-danger" href="transactions.php"><b>My Transactions</b></a></li>
					<li><a class="btn btn-outline-danger" href="viewaccounts.php"><b>View accounts</b></a></li>
					<li><a class="btn btn-outline-danger" href="transfer.php"><b>Transfer Amount</b></a></li>
				</ul>
		</div>

		<div class="col-8 container">
		<div style="width: 150px; height: 150px;"></div>	
			<article class="row custom-left-pad">
				<section class="col-lg-8 white-font">
					<div class="page-header">
						<h2>Remove Card</h2>
					</div>
					<form class="form-horizontal" action="removecard.php" method="post" role="form">
						<div class="form-group">
							<label for="name" class="col-sm-3 control-label">Card Holder Name *</label>
								<div class="col-sm-8">
									<input type="text" name="accname" class="form-control" placeholder="Enter your name" id="accname" required>
								</div>
						</div>
						<div class="form-group">
							<label for="name" class="col-sm-3 control-label">Card Number *</label>
								<div class="col-sm-8">
									<input type="text" name="cardno" class="form-control" placeholder="Enter 16-digit card number" id="cardno" required>
								</div>
						</div>
						<div class="form-group">
							<label class="col-sm-3 control-label"></label>
							<div class="col-sm-8">
							<input type="submit" name="submit" value = "Remove" class="btn btn-block btn-danger">
							</div>
						</div>
					<div class="form-group">
							<label class="col-sm-3 control-label"></label>
							<div class="col-sm-8">
							<h4><?php echo $success ?></h4>
							</div>
						</div>
						


			</article></form></section></article></div>
		

	</div>

</body>
</html>
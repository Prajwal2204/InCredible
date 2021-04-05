<?php
session_start();
include 'config.php';
if(!isset($_SESSION["loggedin"])){
    header("location: login.php");
    exit;
}

	$success = "";

	if(isset($_POST['submit'])){

		$accname = $_POST['accname'];
		$cardno = $_POST['cardno'];
		// $accifsc = $_POST['accifsc'];
		// $accemail = $_POST['accemail'];
		// $accpassword = $_POST['accpassword'];
		$acccvv = $_POST['acccvv'];
		$cardtype = $_POST['cardtype'];
		$accbalance = $_POST['accbalance'];
		$expdate = $_POST['expdate'];
		$accdate = date('y-m-d');
		$ins_sql = "INSERT INTO cards(accname, cardno, acccvv, cardtype, accbalance, expdate, accdate) VALUES ('".$accname."', '".$cardno."','".md5($acccvv)."', '".$cardtype."', '".$accbalance."', '".$expdate."', '".$accdate."')";
		$run_sql = mysqli_query($conn,$ins_sql);

		$temp = mysqli_affected_rows($conn);
		if($temp>0){

			$in_sql = "INSERT INTO users(name, email, password) VALUES ('".$accname."', '".$email."', '".md5($pass)."')";
			$ru_sql = mysqli_query($conn,$in_sql);

			$success = "Card added successfully!";
		}else{

			$success = "Something went wrong!";
		}

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

	<div class = "row">
		<div class="col-2 sidenav">
				<ul class="list-unstyled">
					<li><a class="btn btn-outline-danger" href="accountdetails.php"><b>Account Details</b></a></li>			
					<li><a class="btn btn-outline-danger active" href="addcard.php"><b>Add Card</b></a></li>
					<li><a class="btn btn-outline-danger" href="removecard.php"><b>Remove Card</b></a></li>
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
						<h2>Add Card</h2>
					</div>
					<form class="form-horizontal" action="addaccount.php" method="post" role="form">
						<div class="form-group">
							<label for="name" class="col-sm-3 control-label">Card Holder Name *</label>
								<div class="col-sm-8">
									<input type="text" name="accname" class="form-control" placeholder="Enter your name" id="accname" required>
								</div>
						</div>
						<!-- <div class="form-group">
					<label for="number" class="col-sm-3 control-label">Email-address *</label>
						<div class="col-sm-8">
							<input type="email" name="accemail" class="form-control" placeholder="Enter Email-address" id="accemail" required>
						</div>
				</div>
				<div class="form-group">
					<label for="number" class="col-sm-3 control-label">Password *</label>
						<div class="col-sm-8">
							<input type="password" name="accpassword" class="form-control" placeholder="Enter password" id="accpassword" required>
						</div>
				</div> -->
						<div class="form-group">
							<label for="number" class="col-sm-3 control-label">Card Number*</label>
								<div class="col-sm-8">
									<input type="text" name="cardno" class="form-control" placeholder="Enter 16-digit card number" id="cardnumber" required>
								</div>
						</div>
						<div class="form-group">
							<label for="date" class="col-sm-3 control-label">Valid Thru*</label>
								<div class="col-sm-8">
									<input type="date" name="expdate" class="form-control" placeholder="Expiry Date" id="expdate" required>
								</div>
						</div>
						<div class="form-group">
							<label for="number" class="col-sm-3 control-label">CVV *</label>
								<div class="col-sm-8">
									<input type="password" name="acccvv" class="form-control" placeholder="Enter CVV" id="acccvv" required>
								</div>
						</div>
						<div class="form-group">
							<label for="name" class="col-sm-3 control-label">Card Type *</label>
								<div class="col-sm-8">
									<select class="form-control" name="cardtype" id="cardtype">
										
										<option>VISA</option>
										<option>MasterCard</option>
										<option>RuPay</option>

									</select>
								</div>
						</div>
						<div class="form-group">
							<label for="number" class="col-sm-3 control-label">Account balance*</label>
								<div class="col-sm-8">
									<input type="text" name="accbalance" class="form-control" placeholder="Enter the balance" id="accbalance" required>
								</div>
						</div>
						<div class="form-group">
							<label class="col-sm-3 control-label"></label>
							<div class="col-sm-8">
							<input type="submit" id="submit" name="submit" value = "Submit" class="btn btn-block btn-primary">
							</div>
						</div>
						<div class="form-group">
							<label class="col-sm-3 control-label"></label>
							<div class="col-sm-8">
							<h4><?php echo $success ?></h4>
						</div>
			</div>
					


		</article></form></section></article></div>
</body>
</html>
<?php
session_start();
include 'config.php';

	$success = "";

	if(isset($_POST['submit'])){

		$accno = $_POST['accno'];
		$accemail = $_POST['accemail'];

		$i_sql = "SELECT * FROM accounts WHERE accno = '".$accno."'";
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
			<li class = "topnav-right"><h3>Welcome, <?php echo $_SESSION["username"]; ?></h3></li>
			<?php if (isset($_SESSION["loggedin"])) { ?>
			<li class = "topnav-right"><a href="logout.php">Log Out</a></li>
			<?php } else { ?>
			<li class = "topnav-right"><a href="login.php">Login</a></li>
			<?php } ?>
		</ul>
	</nav>

<!-- <div style="width: 50px; height: 50px;"></div> -->
	<div class = "row">	
		<div class="col-3 sidenav">
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
					<form class="form-horizontal" action="deleteaccount.php" method="post" role="form">
						<div class="form-group">
							<label for="name" class="col-sm-3 control-label">Card Number *</label>
								<div class="col-sm-8">
									<input type="text" name="accno" class="form-control" placeholder="Enter Account number" id="accno" required>
								</div>
						</div>
						<div class="form-group">
							<label for="name" class="col-sm-3 control-label">Email-address *</label>
								<div class="col-sm-8">
									<input type="email" name="accemail" class="form-control" placeholder="Enter Email-address" id="accemail" required>
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
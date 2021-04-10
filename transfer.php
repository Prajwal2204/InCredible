<?php

include_once "class.transfer.php";
$tranfer = new transfer_money;

$sendercard = $sendercard_err = $beneficiarycard_err = $beneficiary_card = $beneficiaryname_err = $beneficiary_name = $amount_err = $amount_value = $cvv_err = $cvv_no = "";


	$success = "";

	if(isset($_POST['submit'])){
		$tranfer->transfer_fund();



			

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
					<li><a class="btn btn-outline-danger" href="viewcards.php"><b>View Cards</b></a></li>			
					<li><a class="btn btn-outline-danger" href="addcard.php"><b>Add Card</b></a></li>
					<!-- <li><a class="btn btn-outline-danger" href="removecard.php"><b>Remove Card</b></a></li> -->
					<li><a class="btn btn-outline-danger" href="transactions.php"><b>My Transactions</b></a></li>
					<!-- <li><a class="btn btn-outline-danger" href="viewaccounts.php"><b>View accounts</b></a></li> -->
					<li><a class="btn btn-outline-danger active" href="transfer.php"><b>Transfer Amount</b></a></li>
				</ul>
		</div>

		<div class="col-8 container">
		<div style="width: 150px; height: 150px;"></div>	
			<article class="row custom-left-pad">
				<section class="col-lg-8 white-font">
						<div class="page-header">
							<h2>Transfer amount</h2>
						</div>
					<form class="form-horizontal" action="transfer.php" method="post" role="form">
						<div class="form-group">
							<label for="name" class="col-sm-3 control-label">Select a Card *</label>
								<div class="col-sm-8">
									<select class="form-control  <?php echo (!empty($sendercard_err)) ? 'is-invalid' : ''; ?>" value="<?php echo $sender_card; ?>"
									 name="sendercard" id="sendercard" >
									  <?php 
									 	$tranfer->add_options();
								?> 

									</select>
									<span class="invalid-feedback"><?php echo $sendercard_err; ?></span>
									
					</div></div>
					<div class="form-group">
						<label for="number" class="col-sm-3 control-label">Beneficiary Card Number*</label>
							<div class="col-sm-8">
								<input type="text" name="beneficiarycard" class="form-control <?php echo (!empty($beneficiarycard_err)) ? 'is-invalid' : ''; ?>" value="<?php echo $beneficiary_card; ?>"
								 placeholder="Enter card number" id="beneficiarycard" maxlength = "16" >
								 <span class="invalid-feedback"><?php echo $beneficiarycard_err; ?></span>
							</div>
					</div>
					<div class="form-group">
							<label for="name" class="col-sm-3 control-label">Beneficiary Name *</label>
								<div class="col-sm-8">
									<input type="text" name="beneficiaryname" class="form-control <?php echo (!empty($beneficiaryname_err)) ? 'is-invalid' : ''; ?>" value="<?php echo $beneficiary_name; ?>"
									placeholder="Enter beneficiary name" id="beneficiaryname" >
									<span class="invalid-feedback"><?php echo $beneficiaryname_err; ?></span>
								</div>
						</div>
					<div class="form-group">
						<label for="number" class="col-sm-3 control-label">Enter amount*</label>
							<div class="col-sm-8">
								<input type="text" name="amount" class="form-control <?php echo (!empty($amount_err)) ? 'is-invalid' : ''; ?>" value="<?php echo $amount_value; ?>"
								 placeholder="Enter the amount" id="amount" maxlength = "5" >
								 <span class="invalid-feedback"><?php echo $amount_err; ?></span>
							</div>
					</div>
					<div class="form-group">
							<label for="number" class="col-sm-3 control-label">CVV *</label>
								<div class="col-sm-8">
									<input type="password" name="cvv" class="form-control <?php echo (!empty($cvv_err)) ? 'is-invalid' : ''; ?>"
									 placeholder="Enter your CVV" id="cvv" maxlength = "3" >
									<span class="invalid-feedback"><?php echo $cvv_err; ?></span>
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


	


		

<script src="js/jquery-1.10.2.js"></script>
<script src="js/bootstrap.min.js"></script>
</body>
</html>


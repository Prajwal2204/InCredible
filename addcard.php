<?php


include_once "class.cards.php" ;
$card = new cards;


// Define variables and initialize with empty values
$name = $bankname = $cardno  = $cvv = "";
$name_err = $bankname_err = $cardno_err  = $cvv_err = "";

if($_SERVER["REQUEST_METHOD"] == "POST"){
	$card->add_card();
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
					<li><a class="btn btn-outline-danger" href="viewcards.php"><b>View Cards</b></a></li>			
					<li><a class="btn btn-outline-danger active" href="addcard.php"><b>Add Card</b></a></li>
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
						<h2>Add Card</h2>
					</div>
					<form class="form-horizontal" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post" role="form">
						<div class="form-group">
							<label for="name" class="col-sm-3 control-label">Card Holder Name *</label>
								<div class="col-sm-8">
									<input type="text" name="accname" class="form-control <?php echo (!empty($name_err)) ? 'is-invalid' : ''; ?>" value="<?php echo $name; ?>"
									placeholder="Enter your name" id="accname" >
									<span class="invalid-feedback"><?php echo $name_err; ?></span>
								</div>
						</div>
						<div class="form-group">
							<label for="name" class="col-sm-3 control-label">Bank Name *</label>
								<div class="col-sm-8">
									<input type="text" name="bank" class="form-control <?php echo (!empty($bankname_err)) ? 'is-invalid' : ''; ?>" value="<?php echo $bankname; ?>"
									placeholder="Enter your Bank Name" id="bank" >
									<span class="invalid-feedback"><?php echo $bankname_err; ?></span>
								</div>
						</div>
					
						<div class="form-group">
							<label for="number" class="col-sm-3 control-label">Card Number*</label>
								<div class="col-sm-8">
									<input type="text" name="cardno" class="form-control <?php echo (!empty($cardno_err)) ? 'is-invalid' : ''; ?>" value="<?php echo $cardno; ?>" 
									placeholder="Enter 16-digit card number" id="cardnumber" >
									<span class="invalid-feedback"><?php echo $cardno_err; ?></span>
								</div>
						</div>
						<div class="form-group">
							<label for="date" class="col-sm-3 control-label">Valid Thru*</label>
								<div class="col-sm-8">
									<input type="date" name="expdate" class="form-control" placeholder="Expiry Date" id="expdate" >
								</div>
						</div>
						<div class="form-group">
							<label for="number" class="col-sm-3 control-label">CVV *</label>
								<div class="col-sm-8">
									<input type="password" name="acccvv" class="form-control <?php echo (!empty($cvv_err)) ? 'is-invalid' : ''; ?>" value="<?php echo $cvv; ?>" 
									placeholder="Enter CVV" id="acccvv" >
									<span class="invalid-feedback"><?php echo $cvv_err; ?></span>
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
							<label class="col-sm-3 control-label"></label>
							<div class="col-sm-8">
							<input type="submit" id="submit" name="submit" value = "Submit" class="btn btn-block btn-primary">	
							</div>
							<label class="col-sm-3 control-label"></label>
							<div class="col-sm-8">
							<input type="reset" class="btn btn-block btn-danger" value="Reset">	
							</div>
						</div>
						
			</div>
					


		</article></form></section></article></div>
</body>
</html>
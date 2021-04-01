<?php
session_start();
include 'config.php';
if(!isset($_SESSION["loggedin"])){
    header("location: login.php");
    exit;
}


	$id = $_SESSION["id"];
	$success = "";

	if(isset($_POST['submit'])){

			$name = $_POST['payee'];

			$sql1 = "SELECT * FROM accounts WHERE accname = '$name'";
			$run1 = mysqli_query($con, $sql1);

			$row1 = mysqli_fetch_array($run1);

			$accno = $row1['accno'];
			$payeebalance = $row1['accbalance'];
			$amount = $_POST['amount'];

			if($amount>0){
				
					$total = $payeebalance + $amount;

					$sql2 = "UPDATE accounts
								SET accbalance = $total
								WHERE accno = '$accno'";

					$run2 = mysqli_query($con, $sql2);
					$date = date('y-m-d');

					$sql3 = "SELECT * FROM accounts WHERE id = $id";
					$run3 = mysqli_query($con, $sql3);

					$row2 = mysqli_fetch_array($run3);
					$owner_no = $row2['accno'];
					$owner_balance = $row2['accbalance'];

					if($owner_balance>=$amount){


						$owner_updated = $owner_balance - $amount;

						$sql4 = "UPDATE accounts
								SET accbalance = $owner_updated
								WHERE accno = '$owner_no'";
						$run4 = mysqli_query($con, $sql4);

						$sql5 = "INSERT INTO transactions(payee_name, amount, from_acc, trans_date) VALUES('".$name."', '".$amount."','".$owner_no."', '".$date."')";
						$run5 = mysqli_query($con, $sql5);

						$success = "Transferred succesfully!";
					}else{

						$success = "You don't have enough balance!";
					}

			}else{

				$success = "Don't be smart!";
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

<!-- <div style="width: 50px; height: 50px;"></div> -->
	<div class = "row">	
		<div class="col-2 sidenav">
				<ul class="list-unstyled">
					<li><a class="btn btn-outline-danger" href="accountdetails.php"><b>Account Details</b></a></li>			
					<li><a class="btn btn-outline-danger" href="addcard.php"><b>Add Card</b></a></li>
					<li><a class="btn btn-outline-danger" href="removecard.php"><b>Remove Card</b></a></li>
					<li><a class="btn btn-outline-danger" href="transactions.php"><b>My Transactions</b></a></li>
					<li><a class="btn btn-outline-danger" href="viewaccounts.php"><b>View accounts</b></a></li>
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
							<label for="name" class="col-sm-3 control-label">Select a payee *</label>
								<div class="col-sm-8">
									<select class="form-control" name="payee" id="acctype">
									<?php 

										$id = addslashes($_SESSION['usr_id']);
										$in_sql = "SELECT * FROM accounts WHERE id = $id";
										$ru_sql = mysqli_query($con, $in_sql);

										$rows = mysqli_fetch_array($ru_sql);
										$from_acc = $rows['accno'];

										$ins_sql = "SELECT * FROM payee WHERE registered_in = '$from_acc'";
										$run_sql = mysqli_query($con,$ins_sql);

									while($rows = mysqli_fetch_array($run_sql)){


										echo '

										<option>'.$rows['name'].'</option>

											';
										}

								?>

									</select>
					</div></div>
					<div class="form-group">
						<label for="number" class="col-sm-3 control-label">Enter amount*</label>
							<div class="col-sm-8">
								<input type="text" name="amount" class="form-control" placeholder="Enter the balance" id="amount" required>
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


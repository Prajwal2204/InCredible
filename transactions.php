<?php
session_start();
include_once 'config.php';
$id = addslashes($_SESSION["id"]);
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
		<div class="col-2 sidenav">
				<ul class="list-unstyled">
					<li><a class="btn btn-outline-danger" href="accountdetails.php"><b>Account Details</b></a></li>			
					<li><a class="btn btn-outline-danger" href="addcard.php"><b>Add Card</b></a></li>
					<li><a class="btn btn-outline-danger" href="removecard.php"><b>Remove Card</b></a></li>
					<li><a class="btn btn-outline-danger active" href="transactions.php"><b>My Transactions</b></a></li>
					<li><a class="btn btn-outline-danger" href="viewaccounts.php"><b>View accounts</b></a></li>
					<li><a class="btn btn-outline-danger" href="transfer.php"><b>Transfer Amount</b></a></li>
				</ul>
		</div>

		<div class="col-8 container">
		<div style="width: 150px; height: 150px;"></div>	
			<article class="row custom-left-pad">
				<section class="col-lg-8 white-font">
					<div class="page-header">
						<h2>Transaction Details</h2>
					</div>
						<table class="table table-bordered">
								<thead>
									<th class="white-font">Payee name</th>
									<th class="white-font">Amount</th>
									<th class="white-font">Transaction date</th>
									</thead>
			<?php
			
				$in_sql = "SELECT * FROM accounts WHERE id = $id";
				$ru_sql = mysqli_query($con, $in_sql) or die( mysqli_error($con));

				$rows = mysqli_fetch_array($ru_sql);
				$accno = $rows['accno'];

				$ins_sql = "SELECT * FROM `transactions` WHERE from_acc = '$accno'";
				$run_sql = mysqli_query($con, $ins_sql) or die(mysqli_error($con));
				while($rows = mysqli_fetch_array($run_sql)){

					echo '

						<tbody>
								<tr>
									<td>'.$rows['payee_name'].'</td>
									<td>'.$rows['amount'].'</td>
									<td>'.$rows['trans_date'].'</td>
								</tr>
								</tbody>
						
					';

				}
			?>
			</table></section></article></div>
</body>
</html>


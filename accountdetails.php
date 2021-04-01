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
					<li><a class="btn btn-outline-danger active" href="accountdetails.php"><b>Account Details</b></a></li>			
					<li><a class="btn btn-outline-danger" href="addcard.php"><b>Add Card</b></a></li>
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
						<h2>Account Details</h2>
					</div>
			<?php
			
				
				$ins_sql = "SELECT * FROM `accounts` WHERE id = '$id'";
				$run_sql = mysqli_query($con, $ins_sql);
				while($rows = mysqli_fetch_array($run_sql)){

					echo '

						<table class="table table-bordered">
							<tbody>
							<tr>
								<td>Account name</td>
								<td>'.$rows['accname'].'</td>
							</tr>
							<tr>
								<td>Account no</td>
								<td>'.$rows['accno'].'</td>
							</tr>
							<tr>
								<td>IFSC Code</td>
								<td>'.$rows['accifsc'].'</td>
							</tr>
							<tr>
								<td>Email-address</td>
								<td>'.$rows['accemail'].'</td>
							</tr>
							<tr>
								<td>Account type</td>
								<td>'.$rows['acctype'].'</td>
							</tr>
							<tr>
								<td>Account balance</td>
								<td>'.$rows['accbalance'].'</td>
							</tr>
							<tr>
								<td>Open date</td>
								<td>'.$rows['accdate'].'</td>
							</tr>
							</tbody>
						</table>
						
					';

				}
			?>
	</div>
</body>
</html>


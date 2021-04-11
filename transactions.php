<?php
session_start();
include_once 'config.php';
$usr = $_SESSION["username"];
// // $holder_name = $_POST['accname'];
// if(!isset($_SESSION["loggedin"])){
//     header("location: login.php");
//     exit;
// }

include_once "class.transactions.php";

	
$dis = new transactions;
?>
<!DOCTYPE html>
<html>
<head>
	<title>InCredible</title>
	<link rel="stylesheet" href="node_modules/bootstrap/dist/css/bootstrap.min.css">
    <link rel = "stylesheet" href = "css/styles-admin.css">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
	<script src='https://kit.fontawesome.com/a076d05399.js' crossorigin='anonymous'></script>
</head>

<body class="signin-body">
	<nav>
		<ul class="topnav">
			<li class = "logo"><img class = "logo-mod" src="img/logo.PNG"></li>
			<li><a href="admin.php">Home</a></li>
			<?php if (isset($_SESSION["username"])) { ?>
			<li class = "topnav-right"><a href="profile.php"><h3><?php echo $_SESSION["username"]; ?></h3></a></li>
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
					<li><a class="btn btn-outline-danger active" href="transactions.php"><b>My Transactions</b></a></li>
					<!-- <li><a class="btn btn-outline-danger" href="viewaccounts.php"><b>View accounts</b></a></li> -->
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
					
					<form class="form-horizontal d-flex" action="transactions.php" method="post" role="form">
					<?php
						echo '
							<select class = "col-3 custom-select" style = "margin-right:10px;" name="selectcard" id="selectcard">
							<option value="none" selected disabled hidden>
								Select a Card
							</option>
						';
						$con = mysqli_connect('localhost', 'root', '', 'credit_card');
						$in1_sql = "SELECT * FROM cards WHERE username = '$usr' ";
						$sql_query = mysqli_query($con, $in1_sql);
						while($rows = mysqli_fetch_array($sql_query)){
							echo '
									<option>'.$rows['card_no'].'</option>
							';
							
						}
						echo '</select>';
					?>
						<select class = "col-3 custom-select" style = "margin-right:10px;" name="selectduration" id="selectduration">
							<option value="none" selected disabled hidden>
								Select Duration
							</option>
							<option value="1">past 1 day</option>
							<option value="2">past 2 days </option>
							<option value="10">past 10 days</option>
						</select>
						<div style="width: 10px; height: 10px;"></div>
							<input type="submit" id="submit" name="submit" value = "Apply Filters" class="col-3 btn btn-block btn-danger">
					</form>
						<div style="width: 10px; height: 10px;"></div>
						<table class="table table-bordered">
								<thead>
									<tr class = "red-bg">
										<th class="white-font">Card 1</th>
										<th class="white-font">Transaction Type</th>
										<th class="white-font">Card 2</th>
										<th class="white-font">Beneficiary</th>
										<th class="white-font">Sender</th>
										<th class="white-font">Amount</th>
										<th class="white-font">Transaction Timestamp</th>
									</tr>
								</thead>
			<?php
			$dis->display();
				// $con = mysqli_connect('localhost', 'root', '', 'credit_card');
				// $in_sql = "SELECT * FROM cards WHERE username = '$usr' ";
				// $ru_sql = mysqli_query($con, $in_sql);

				// $rows = mysqli_fetch_array($ru_sql);
				// $card = $rows['card_no'];

				
			?>
			</table></section></article></div>
</body>
</html>


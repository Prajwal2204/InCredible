<?php
// session_start();
// include_once 'config.php';
// $usr = $_SESSION["username"];
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
									<tr class = "red-bg">
										<th class="white-font">Card 1</th>
										<th class="white-font">Transaction Type</th>
										<th class="white-font">Card 2</th>
										<th class="white-font">Beneficiary Name</th>
										<th class="white-font">Sender Name</th>
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


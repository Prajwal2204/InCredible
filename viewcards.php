<?php
// session_start();//
// include_once 'config.php'; //
// $usr = $_SESSION["username"];
// if(!isset($_SESSION["loggedin"])){
    // header("location: login.php");
	
include_once "class.cards2.php";

	
$view	 = new view_cards;
    // exit;
// }
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
			<li><a href="index.php">Home</a></li>
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
					<li><a class="btn btn-outline-danger active" href="viewcards.php"><b>View Cards</b></a></li>			
					<li><a class="btn btn-outline-danger" href="addcard.php"><b>Add Card</b></a></li>
					<li><a class="btn btn-outline-danger" href="transactions.php"><b>My Transactions</b></a></li>
					<li><a class="btn btn-outline-danger" href="transfer.php"><b>Transfer Amount</b></a></li>
				</ul>
		</div>
<?php

	//$mysqli = new mysqli('localhost', 'root', '', 'credit_card');
	$view->view_card();
			
?>
</div>
</body>
</html>
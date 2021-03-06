<?php
session_start();
include_once 'config.php';
if(!isset($_SESSION["loggedin"])){
    header("location: login.php");
    exit;
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



<body class = "signin-body">
	<nav>
		<ul class="topnav">
			<li class = "logo"><img class = "logo-mod" src="img/logo.PNG"></li>
			<li><a href="index.php">Home</a></li>
			<?php if (isset($_SESSION["username"])) { ?>
			<li class = "topnav-right"><a href="profile.php"><h3>Welcome, <?php echo $_SESSION["username"]; ?></h3></a></li>
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
		<div class="col-3 sidenav">
			<ul class="list-unstyled">
				<li><a class="btn btn-outline-danger" href="viewcards.php"><b>View Cards</b></a></li>			
				<li><a class="btn btn-outline-danger" href="addcard.php"><b>Add Card</b></a></li>
				<li><a class="btn btn-outline-danger" href="transactions.php"><b>My Transactions</b></a></li>
				<li><a class="btn btn-outline-danger" href="transfer.php"><b>Transfer Amount</b></a></li>
			</ul>
		</div>
		<div class = "row"></div>
		<div class="col-8 custom-jumbo">
			<div class="row">
					<div class="col-sm-12">
						<h1 class="display-3"><img class="jumbo-img" src="img/logo-dark.PNG"></h1>
						<br>
						<h3 style="color: rgb(246,76,114);">A web app to take care of all your credit card needs.</h3>
						<br>
					</div>
				</div>
		</div>
	</div>
</body>
</html>
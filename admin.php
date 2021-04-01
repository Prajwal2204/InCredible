<?php
session_start();
include_once 'config.php';
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
		<!-- <div class="container-fluid"> -->
			<!-- <div class="navbar-header">
				<button type="button" class="navbar-toggle" data-toggle="collapse" data-target="#navbar1">
					<span class="sr-only">Toggle navigation</span>
					<span class="icon-bar"></span>
					<span class="icon-bar"></span>
					<span class="icon-bar"></span>
				</button>
				<a class="navbar-brand" href="admin.php">Admin Dashboard</a>
			</div> -->
			<!-- <div class="collapse navbar-collapse" id="navbar1"> -->
				<ul class="topnav">
					<li class = "logo"><img class = "logo-mod" src="img/logo.PNG"></li>
					<li><a href="admin.php">Admin Dashboard</a></li>
					<?php if (isset($_SESSION['usr_id'])) { ?>
					<li class = "topnav-right"><a href="logout.php">Log Out</a></li>
					<?php } else { ?>
					<li class = "topnav-right"><a href="login.php">Login</a></li>
					<?php } ?>
				</ul>
			<!-- </div> -->
		<!-- </div> -->
	</nav>

<!-- <div style="width: 50px; height: 50px;"></div> -->
	<div class = "row">
	<div class="col-3 sidenav">
	<div style="width: 50px; height: 50px;"></div>
		<ul class="list-unstyled">

			<li><a class="btn btn-outline-danger" href="addcard.php"><b>Add Card</b></a></li>
			<li><a class="btn btn-outline-danger" href="removecard.php"><b>Remove Card</b></a></li>
			<li><a class="btn btn-outline-danger" href="viewaccounts.php"><b>View accounts</b></a></li>
			<li><a class="btn btn-outline-danger" href="depositmoney.php"><b>Deposit money</b></a></li>
			<li><a class="btn btn-outline-danger" href="withdrawmoney.php"><b>Withdraw Money</b></a></li>
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
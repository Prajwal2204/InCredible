<?php
// session_start();
// include_once 'config.php';
// $usr = $_SESSION['username'];
// if(!isset($_SESSION["loggedin"])){
//     header("location: login.php");
//     exit;
// }
include_once "class.profile.php";

$view = new profile;
$usr = $_SESSION['username'];
// $full_name = $email_id = $phone_no = "";
$email_err = $phone_err = $fullname_err = "";

$view->get_details();

if($_SERVER["REQUEST_METHOD"]=="POST"){
	$view->view_profile();
}

// $view->view_profile();

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
    
    <div class="col-8 container">
		<div style="width: 150px; height: 150px;"></div>	
			<div class="row">
				<div class="col-lg-4 white-font">
						<div class="page-header">
							<h2>Profile</h2>
						</div>
					<form class="form-horizontal" action="profile.php" method="post" role="form">
                    <div class="form-group">
						<label for="number" class="col-sm-3 control-label">Full Name</label>
							<div class="col-sm" class="form-control">
								<input type="text" name="name" class="form-control <?php echo (!empty($fullname_err)) ? 'is-invalid' : ''; ?>" value="<?php echo htmlentities($full_name); ?>"
								id="fullname">
								<span class="invalid-feedback"><?php echo $fullname_err; ?></span>
								
							</div>
					</div>
					<div class="form-group">
						<label for="number" class="col-sm-3 control-label">Email ID*</label>
							<div class="col-sm">
								<input type="text" name="email" class="form-control <?php echo (!empty($email_err)) ? 'is-invalid' : ''; ?>" value="<?php echo htmlentities($email_id);?>" id="email">
                        		<span class="invalid-feedback"><?php echo $email_err; ?></span>
								
							</div>
					</div>
					<div class="form-group">
						<label for="number" class="col-sm-3 control-label">Phone Number*</label>
							<div class="col-sm">
								<input type="text" name="number" maxlength = "10" class="form-control <?php echo (!empty($phone_err)) ? 'is-invalid' : ''; ?>" value="<?php echo htmlentities($phone_no);?>"
								id="number">
								<span class="invalid-feedback"><?php echo $phone_err; ?></span>
							</div>
					</div>
					
					<div class="form-group">
						<label class="col-sm-3 control-label"></label>
							<div class="col-sm">
								<input type="submit" id="submit" name="submit" value = "Save Changes" class="btn btn-block btn-primary">
							</div>
					</div>
					<div style="width: 20px; height: 20px;"></div>
					<a href = "reset-password.php" class = "btn btn-danger col-sm">Reset Password</a>
				</div>
				</form>
                <div class = "col-lg-2"></div>
            <div class = "col-lg-6 white-font">
                        <div class="page-header">
							<h2>Your Cards</h2>
						</div>
                        <div style="width: 25px; height: 25px;"></div>
                    <!-- <table class="table table-bordered">
                    <thead>
                    <tr class = "red-bg">
                        
                        <td class = "white-font">Card Holder Name</td>
                        <td class = "white-font">Bank Name</td>
                        <td class = "white-font">Card Number</td>
                        <td class = "white-font">Card Type</td>
                        <td class = "white-font">Expiry Date</td>
                        <td class = "white-font">Account Balance (INR)</td>
                    </tr>
                    </thead>-->
                    <?php 
            //         $con = mysqli_connect('localhost', 'root', '', 'credit_card');
            //         $sql = "SELECT * FROM cards  WHERE username = '$usr' ";
            //         $run_sql = mysqli_query($con, $sql);

			// 	while($rows = mysqli_fetch_array($run_sql)){
            //     echo '

            //         <tbody>
            //         <tr>
            //             <form action = "" method = "post" role = "form">
                            
            //                 <td class = "white-font">'.$rows['name'].'</td>
            //                 <td class = "white-font">'.$rows['bank'].'</td>
            //                 <td class = "white-font">'.$rows['card_no'].'</td>
            //                 <td class = "white-font">'.$rows['card_type'].'</td>
            //                 <td class = "white-font">'.$rows['expiry_date'].'</td>
            //                 <td class = "white-font">'.$rows['acc_balance'].'</td>
            //             </form>
            //         </tr>
            //         </tbody>
            //                 ';
            // }  
			// // sample check
                            
            // echo'</table>';
				$view->display_cards();
                ?>
            </div>
            
            </div>
        </div></div>
	<!-- <div class = "row">
		<div class="col-3 sidenav">
			<ul class="list-unstyled">
				<li><a class="btn btn-outline-danger" href="viewcards.php"><b>View Cards</b></a></li>			
				<li><a class="btn btn-outline-danger" href="addcard.php"><b>Add Card</b></a></li>
				<li><a class="btn btn-outline-danger" href="removecard.php"><b>Remove Card</b></a></li>
				<li><a class="btn btn-outline-danger" href="transactions.php"><b>My Transactions</b></a></li>
				<li><a class="btn btn-outline-danger" href="viewaccounts.php"><b>View accounts</b></a></li>
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
	</div> -->

</body>
</html>
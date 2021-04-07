<?php
session_start();
include 'config.php';
$usr = $_SESSION["username"];
if(!isset($_SESSION["loggedin"])){
    header("location: login.php");
    exit;
}


	$id = $_SESSION["id"];
	$success = "";

	if(isset($_POST['submit'])){

			// $name = $_POST['payee'];
			
			
			$con = mysqli_connect('localhost', 'root', '', 'credit_card');
			$sql1 = "SELECT * FROM cards WHERE username = '$usr'";
			$run1 = mysqli_query($con, $sql1);

			$row1 = mysqli_fetch_array($run1);

			$sender_card = $_POST['sendercard'];
			$current_bal = $row1['acc_balance'];
			$beneficiary_card = $_POST['beneficiarycard'];
			$amount = $_POST['amount'];

			if($amount>0){
				
					// $total = $current_bal - $amount;

					// $sql2 = "UPDATE cards
					// 			SET acc_balance = $total
					// 			WHERE card_no = '$sender_card'";

					// $run2 = mysqli_query($con, $sql2);
					// $date = date('y-m-d');

					// $sql3 = "SELECT * FROM accounts WHERE id = $id";
					// $run3 = mysqli_query($con, $sql3);

					// $row2 = mysqli_fetch_array($run3);
					// $owner_no = $row2['accno'];
					// $owner_balance = $row2['accbalance'];

					if($current_bal>=$amount){


						$owner_updated = $current_bal - $amount;

						$sql4 = "UPDATE cards
								SET acc_balance = $owner_updated
								WHERE card_no = '$sender_card'";
						$run4 = mysqli_query($con, $sql4);

						$sql5 = "INSERT INTO transfer(sender_card, beneficiary_card, transfer_amt) VALUES('".$sender_card."', '".$beneficiary_card."','".$amount."')";
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
					<li><a class="btn btn-outline-danger" href="viewcards.php"><b>View Cards</b></a></li>			
					<li><a class="btn btn-outline-danger" href="addcard.php"><b>Add Card</b></a></li>
					<!-- <li><a class="btn btn-outline-danger" href="removecard.php"><b>Remove Card</b></a></li> -->
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
							<label for="name" class="col-sm-3 control-label">Select a Card *</label>
								<div class="col-sm-8">
									<select class="form-control" name="sendercard" id="sendercard">
									<?php 
																				// $mysqli = new mysqli('localhost' , 'root' , '' , 'credit_card');
										// $sql = "SELECT * FROM cards WHERE username = ?";
										// $user = $_SESSION["username"];
										// if($stmt = $mysqli->prepare($sql)){
										// 	$stmt->bind_param("s",$user);
										// 	$stmt->execute();
										// 	$result = $stmt->get_result();
										// 	if($result->num_rows>0){
										// 		while($rows = $result->fetch_assoc()){
										// 			echo '
										// 			<option value="none" selected disabled hidden>
          								// 				Select a card to pay from
      									// 			</option>
										// 			<option>'.$rows['card_no'].'</option>

										// 			';

										// 		}
										// 	}
										// 	else{
										// 		// header("Location:addcard.php");
										// 		echo '<script>alert("First <b> ADD CARD into the InCredible</b>")</script>';
												
										// 	}
										// }
										// else{
										// 	echo "Oops! Something went wrong try again later";
										// }
										// $mysqli->close();

								?>

									</select>
					</div></div>
					<div class="form-group">
						<label for="number" class="col-sm-3 control-label">Beneficiary Card Number*</label>
							<div class="col-sm-8">
								<input type="text" name="beneficiarycard" class="form-control" placeholder="Enter card number" id="beneficiarycard" required>
							</div>
					</div>
					<div class="form-group">
						<label for="number" class="col-sm-3 control-label">Enter amount*</label>
							<div class="col-sm-8">
								<input type="number" name="amount" class="form-control" placeholder="Enter the amount" id="amount" maxlength = "5" required>
							</div>
					</div>
					<div class="form-group">
							<label for="number" class="col-sm-3 control-label">CVV *</label>
								<div class="col-sm-8">
									<input type="password" name="cvv" class="form-control" placeholder="Enter your CVV" id="cvv" maxlength = "3" required>
									<span class="invalid-feedback"><?php echo $cvv_err; ?></span>
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






















// if(strlen(trim($cvv_code))!=3){
            //     $cvv_err = "it must contain 3 characters";
            // }
            // elseif(!preg_match("#[0-9]+#",$cvv_code)){
            //     $cvv_err = "It should contain only integer values";
            // }
            // else{
                //$cvv = trim($cvv_code);
                if(empty($cvv_err) && empty($sendercard_err)){
                $password = trim($cvv_code);
                $sql8 = "SELECT cvv FROM cards where card_no = ?";
                if($stmt = $mysqli->prepare($sql8)){
                    $stmt->bind_param("s",$sender_card);
                    if($stmt->execute()){
                        $result9 = $stmt->get_result();
                        if($result9->num_rows >= 1){
                            //$stmt->bind_result($hashed_password);
                            // echo $hashed_cvv;
                            if($row = $result9->fetch_assoc()){
                                if(password_verify($cvv_no,$row["cvv"])){
                                     $cvv_err = "";
                                    // header("location: addcard.php");
                                } 
                                else{
                                    $cvv_err = "CVV incorrect for";
                                }

                            }
                        }
                        else{
                            $cvv_err = "Card Not found in db";
                        }
                    }

                    else{
                        echo "Something went wrong";
                    }
                    $stmt->close();
                }
            
                
            }
        
<?php 

include_once "config.php";
class view_cards extends DBC{
    public function __construct()
    {
        session_start();
    }
    
    //$mysqli = $this->connect();

    public function view_card(){
           //global $mysqli = $this->connect();
        if(!isset($_SESSION["loggedin"])){
            header("location: login.php");
            exit;
        }
        
        $usr = $_SESSION["username"];
        $mysqli = $this->connect();
        if(isset($_POST["removeCard"])){
			$key = $_POST['removeKey'];

        $check_sql = "SELECT * FROM cards WHERE card_no = ? ";
			if($stmt = $mysqli->prepare($check_sql)){
				$stmt->bind_param("s",$key);
				$stmt->execute();
				$stmt->store_result();
				if($stmt->affected_rows >= 0){
					$del_sql = "DELETE FROM cards WHERE card_no = ? ";
					if($stmt2 = $mysqli->prepare($del_sql)){
						$stmt2->bind_param("s",$key);
						$stmt2->execute();
						if($stmt->affected_rows>0){
							echo 'alert("successfully deleted")';
						}
						else{
							echo "could not able to delete card number". $key ;
						}
						header("Location:viewcards.php");
						$stmt2->free_result();
						/* close statement */
						$stmt2->close();
					}
				}
				else{
					echo'<div class = "alert alert-warning">
					<p>Record does not match!</p>
					</div>';
							
				}
				header("Location:viewcards.php");
				$stmt->free_result();
				/* close statement */
				$stmt->close();
		    }
        }

		
			

							
			$sql = "SELECT * FROM cards  WHERE username = ?";
			if($stmt = $mysqli->prepare($sql)){
				$stmt->bind_param("s",$usr);
				$stmt->execute();								
				$result = $stmt->get_result();
				if($result->num_rows > 0){    
					echo'
					<div class="col-8 container">
					<div style="width: 50px; height: 50px;"></div>
						<article class="row custom-left-pad">
						<section class="col-lg-8 white-font">
							<div class="page-header">
								<h2>Card Details</h2>
								</div>
						
							<table class="table table-bordered">
										<thead>
										<tr class = "red-bg">
											
											<td class = "white-font">Card Holder Name</td>
											<td class = "white-font">Bank Name</td>
											<td class = "white-font">Card Number</td>
											<td class = "white-font">Card Type</td>
											<td class = "white-font">Expiry Date</td>
											<td class = "white-font">Account Balance (INR)</td>
											<td class = "white-font">Select</td>
											<td class = "white-font">Remove Card?</td>
										</tr>
										</thead>';                
					while ($rows = $result->fetch_assoc())	{
						echo '

							<tbody>
							<tr>
								<form action = "" method = "post" role = "form">
									
									<td class = "white-font">'.$rows['name'].'</td>
									<td class = "white-font">'.$rows['bank'].'</td>
									<td class = "white-font">'.$rows['card_no'].'</td>
									<td class = "white-font">'.$rows['card_type'].'</td>
									<td class = "white-font">'.$rows['expiry_date'].'</td>
									<td class = "white-font">'.$rows['acc_balance'].'</td>
									<td class = "white-font"><input type = "checkbox" name = "removeKey" value = "'.$rows['card_no'].'" required></td>
									<td class = "white-font"><input type = "submit" name = "removeCard" value = "Remove" class = "btn btn-danger"></td>
								</form>
							</tr>
							</tbody>
									';
					}
                                    
                    echo'</table>';								
                } 
				else{
					echo "<b><h1 ></h1>NO RECORD FOR " .$usr."<h1></b>";
				}
				$stmt->free_result();
				/* close statement */
				$stmt->close();
			}

        // Close connection
        $mysqli->close();
    }

}
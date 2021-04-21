<?php 

include_once "config.php";
class transactions extends DBC{
    public function __construct()
    {
        session_start();
    }
    
    //$mysqli = $this->connect();

    public function display(){
           //global $mysqli = $this->connect();
        if(!isset($_SESSION["loggedin"])){
            header("location: login.php");
            exit;
        }
        $mysqli = $this->connect();

		error_reporting(E_ERROR | E_PARSE);

		if($_POST["selectcard"] && $_POST["selectduration"] && $_POST["selecttransaction"] ){
			//$view->view_profile();

			if($_POST["selectduration"]==1){
				$put = 1;
			}
			elseif($_POST["selectduration"]==2){
				$put = 2;
			}
			elseif($_POST["selectduration"]==10){
				$put = 10;
			}
			else{
				
			}

			echo '
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
			';
			$card1 = $_POST["selectcard"];
			$trans = $_POST["selecttransaction"];
			// $sql1 = "SELECT * FROM transfer WHERE username = ? and sender_card = ?";
			$sql1 = "SELECT * FROM transfer WHERE username = ? AND transaction_type=? AND sender_card = ? AND time_of_transaction >= 
			DATE_SUB(CURDATE(), INTERVAL ".$put." DAY) ";
			if($stmt = $mysqli->prepare($sql1)){
				$stmt->bind_param("sss",$_SESSION['username'],$trans,$card1);
				$stmt->execute();
				$result = $stmt->get_result();
				if($result->num_rows > 0){
					while($rows = $result->fetch_assoc()){
						if($rows['transaction_type']=='DEBITED'){
							echo '
								
	
								<tbody>
										<tr>
											<td class="white-font">'.$rows['sender_card'].'</td>
											<td class="white-font red-arrow fas fa-arrow-alt-circle-up d-flex justify-content-center" style="font-size:30px;color:#dc3545;border:none;"></td>
											<td class="white-font">'.$rows['beneficiary_card'].'</td>
											<td class="white-font">'.$rows['beneficiary_name'].'</td>
											<td class="white-font"><b>ME</b></td>
											<td class="white-font">'.$rows['transfer_amt'].'</td>
											<td class="white-font">'.$rows['time_of_transaction'].'</td>
										</tr>
								</tbody>
								
							';
						}
						elseif($rows['transaction_type']=='CREDITED'){

							$c2 = $rows['beneficiary_card'];
						// $sendername = "";
						$sql22 = "SELECT username FROM cards WHERE card_no = ?";
						if($stmt22 = $mysqli->prepare($sql22)){
							$stmt22->bind_param("s",$c2);
							$stmt22->execute();
							$result9 = $stmt22->get_result();
							if($result9->num_rows > 0){
								$row1 = $result9->fetch_assoc();
								// $sendername2 = $row1['username'];
							}
						$stmt22->free_result();
						$stmt22->close();
					}


							echo '
	
							<tbody>
									<tr>
										<td class="white-font">'.$rows['sender_card'].'</td>
										<td class="white-font green-arrow fas fa-arrow-alt-circle-down d-flex justify-content-center" style="font-size:30px;color:#0FFF50;border:none;"></td>
										<td class="white-font">'.$rows['beneficiary_card'].'</td>
										<td class="white-font"><b>SELF</b></td>
										<td class="white-font">'.$row1["username"].'</td>
										<td class="white-font">'.$rows['transfer_amt'].'</td>
										<td class="white-font">'.$rows['time_of_transaction'].'</td>
									</tr>
							</tbody>
							
							';
						}
					}
				}
				$stmt->free_result();
            $stmt->close();
			}
			// $mysqli->close();
		}
		else{

		if($_POST["selectcard"] && $_POST["selectduration"] && !($_POST['selecttransaction'])){
			//$view->view_profile();

			if($_POST["selectduration"]==1){
				$put = 1;
			}
			elseif($_POST["selectduration"]==2){
				$put = 2;
			}
			elseif($_POST["selectduration"]==10){
				$put = 10;
			}
			else{
				
			}

			echo '
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
			';
			$card1 = $_POST["selectcard"];
			// $sql1 = "SELECT * FROM transfer WHERE username = ? and sender_card = ?";
			$sql1 = "SELECT * FROM transfer WHERE username = ? AND sender_card = ? AND time_of_transaction >= 
			DATE_SUB(CURDATE(), INTERVAL ".$put." DAY) ";
			if($stmt = $mysqli->prepare($sql1)){
				$stmt->bind_param("ss",$_SESSION['username'],$card1);
				$stmt->execute();
				$result = $stmt->get_result();
				if($result->num_rows > 0){
					while($rows = $result->fetch_assoc()){
						if($rows['transaction_type']=='DEBITED'){
							echo '
								
	
								<tbody>
										<tr>
											<td class="white-font">'.$rows['sender_card'].'</td>
											<td class="white-font red-arrow fas fa-arrow-alt-circle-up d-flex justify-content-center" style="font-size:30px;color:#dc3545;border:none;"></td>
											<td class="white-font">'.$rows['beneficiary_card'].'</td>
											<td class="white-font">'.$rows['beneficiary_name'].'</td>
											<td class="white-font"><b>ME</b></td>
											<td class="white-font">'.$rows['transfer_amt'].'</td>
											<td class="white-font">'.$rows['time_of_transaction'].'</td>
										</tr>
								</tbody>
								
							';
						}
						elseif($rows['transaction_type']=='CREDITED'){

							$c2 = $rows['beneficiary_card'];
							// $sendername = "";
							$sql22 = "SELECT username FROM cards WHERE card_no = ?";
							if($stmt22 = $mysqli->prepare($sql22)){
								$stmt22->bind_param("s",$c2);
								$stmt22->execute();
								$result9 = $stmt22->get_result();
								if($result9->num_rows > 0){
									$row1 = $result9->fetch_assoc();
									// $sendername2 = $row1['username'];
								}
							$stmt22->free_result();
							$stmt22->close();
						}
	

							echo '
	
							<tbody>
									<tr>
										<td class="white-font">'.$rows['sender_card'].'</td>
										<td class="white-font green-arrow fas fa-arrow-alt-circle-down d-flex justify-content-center" style="font-size:30px;color:#0FFF50;border:none;"></td>
										<td class="white-font">'.$rows['beneficiary_card'].'</td>
										<td class="white-font"><b>SELF</b></td>
										<td class="white-font">'.$row1["username"].'</td>
										<td class="white-font">'.$rows['transfer_amt'].'</td>
										<td class="white-font">'.$rows['time_of_transaction'].'</td>
									</tr>
							</tbody>
							
							';
						}
					}
				}
				$stmt->free_result();
            $stmt->close();
			}
			// $mysqli->close();
		}

		elseif($_POST["selectcard"] && !($_POST["selectduration"]) && ($_POST['selecttransaction'])){
			//$view->view_profile();

			
			echo '
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
			';
			$card1 = $_POST["selectcard"];
			$trans = $_POST["selecttransaction"];
			// $sql1 = "SELECT * FROM transfer WHERE username = ? and sender_card = ?";
			$sql1 = "SELECT * FROM transfer WHERE username = ? AND transaction_type=? AND sender_card = ? ";
			if($stmt = $mysqli->prepare($sql1)){
				$stmt->bind_param("sss",$_SESSION['username'],$trans,$card1);
				$stmt->execute();
				$result = $stmt->get_result();
				if($result->num_rows > 0){
					while($rows = $result->fetch_assoc()){
						if($rows['transaction_type']=='DEBITED'){
							echo '
								
	
								<tbody>
										<tr>
											<td class="white-font">'.$rows['sender_card'].'</td>
											<td class="white-font red-arrow fas fa-arrow-alt-circle-up d-flex justify-content-center" style="font-size:30px;color:#dc3545;border:none;"></td>
											<td class="white-font">'.$rows['beneficiary_card'].'</td>
											<td class="white-font">'.$rows['beneficiary_name'].'</td>
											<td class="white-font"><b>ME</b></td>
											<td class="white-font">'.$rows['transfer_amt'].'</td>
											<td class="white-font">'.$rows['time_of_transaction'].'</td>
										</tr>
								</tbody>
								
							';
						}
						elseif($rows['transaction_type']=='CREDITED'){

							$c2 = $rows['beneficiary_card'];
						// $sendername = "";
						$sql22 = "SELECT username FROM cards WHERE card_no = ?";
						if($stmt22 = $mysqli->prepare($sql22)){
							$stmt22->bind_param("s",$c2);
							$stmt22->execute();
							$result9 = $stmt22->get_result();
							if($result9->num_rows > 0){
								$row1 = $result9->fetch_assoc();
								// $sendername2 = $row1['username'];
							}
						$stmt22->free_result();
						$stmt22->close();
					}

							
							echo '
	
							<tbody>
									<tr>
										<td class="white-font">'.$rows['sender_card'].'</td>
										<td class="white-font green-arrow fas fa-arrow-alt-circle-down d-flex justify-content-center" style="font-size:30px;color:#0FFF50;border:none;"></td>
										<td class="white-font">'.$rows['beneficiary_card'].'</td>
										<td class="white-font"><b>SELF</b></td>
										<td class="white-font">'.$row1["username"].'</td>
										<td class="white-font">'.$rows['transfer_amt'].'</td>
										<td class="white-font">'.$rows['time_of_transaction'].'</td>
									</tr>
							</tbody>
							
							';
						}
					}
				}
				$stmt->free_result();
            $stmt->close();
			}
			// $mysqli->close();
		}

		elseif(!($_POST["selectcard"]) && $_POST["selectduration"] && ($_POST['selecttransaction'])){
			//$view->view_profile();

			if($_POST["selectduration"]==1){
				$put = 1;
			}
			elseif($_POST["selectduration"]==2){
				$put = 2;
			}
			elseif($_POST["selectduration"]==10){
				$put = 10;
			}
			else{
				
			}

			echo '
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
			';
			// $card1 = $_POST["selectcard"];
			
			$trans = $_POST["selecttransaction"];
			// $sql1 = "SELECT * FROM transfer WHERE username = ? and sender_card = ?";
			$sql1 = "SELECT * FROM transfer WHERE username = ? AND transaction_type=? AND time_of_transaction >= 
			DATE_SUB(CURDATE(), INTERVAL ".$put." DAY) ";
			if($stmt = $mysqli->prepare($sql1)){
				$stmt->bind_param("ss",$_SESSION['username'],$trans);
				$stmt->execute();
				$result = $stmt->get_result();
				if($result->num_rows > 0){
					while($rows = $result->fetch_assoc()){
						if($rows['transaction_type']=='DEBITED'){
							echo '
								
	
								<tbody>
										<tr>
											<td class="white-font">'.$rows['sender_card'].'</td>
											<td class="white-font red-arrow fas fa-arrow-alt-circle-up d-flex justify-content-center" style="font-size:30px;color:#dc3545;border:none;"></td>
											<td class="white-font">'.$rows['beneficiary_card'].'</td>
											<td class="white-font">'.$rows['beneficiary_name'].'</td>
											<td class="white-font"><b>ME</b></td>
											<td class="white-font">'.$rows['transfer_amt'].'</td>
											<td class="white-font">'.$rows['time_of_transaction'].'</td>
										</tr>
								</tbody>
								
							';
						}
						elseif($rows['transaction_type']=='CREDITED'){

							$c2 = $rows['beneficiary_card'];
						// $sendername = "";
						$sql22 = "SELECT username FROM cards WHERE card_no = ?";
						if($stmt22 = $mysqli->prepare($sql22)){
							$stmt22->bind_param("s",$c2);
							$stmt22->execute();
							$result9 = $stmt22->get_result();
							if($result9->num_rows > 0){
								$row1 = $result9->fetch_assoc();
								// $sendername2 = $row1['username'];
							}
						$stmt22->free_result();
						$stmt22->close();
					}


							echo '
	
							<tbody>
									<tr>
										<td class="white-font">'.$rows['sender_card'].'</td>
										<td class="white-font green-arrow fas fa-arrow-alt-circle-down d-flex justify-content-center" style="font-size:30px;color:#0FFF50;border:none;"></td>
										<td class="white-font">'.$rows['beneficiary_card'].'</td>
										<td class="white-font"><b>SELF</b></td>
										<td class="white-font">'.$row1["username"].'</td>
										<td class="white-font">'.$rows['transfer_amt'].'</td>
										<td class="white-font">'.$rows['time_of_transaction'].'</td>
									</tr>
							</tbody>
							
							';
						}
					}
				}
				$stmt->free_result();
            $stmt->close();
			}
			$mysqli->close();
		}

		elseif($_POST["selecttransaction"]){
			//$view->view_profile();
			echo '
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
			';
			$card1 = $_POST["selecttransaction"];
			$sql1 = "SELECT * FROM transfer WHERE username = ? and transaction_type = ?";
			if($stmt = $mysqli->prepare($sql1)){
				$stmt->bind_param("ss",$_SESSION['username'],$card1);
				$stmt->execute();
				$result = $stmt->get_result();
				if($result->num_rows > 0){
					while($rows = $result->fetch_assoc()){
						if($rows['transaction_type']=='DEBITED'){
							echo '
								
	
								<tbody>
										<tr>
											<td class="white-font">'.$rows['sender_card'].'</td>
											<td class="white-font red-arrow fas fa-arrow-alt-circle-up d-flex justify-content-center" style="font-size:30px;color:#dc3545;border:none;"></td>
											<td class="white-font">'.$rows['beneficiary_card'].'</td>
											<td class="white-font">'.$rows['beneficiary_name'].'</td>
											<td class="white-font"><b>ME</b></td>
											<td class="white-font">'.$rows['transfer_amt'].'</td>
											<td class="white-font">'.$rows['time_of_transaction'].'</td>
										</tr>
								</tbody>
								
							';
						}
						elseif($rows['transaction_type']=='CREDITED'){

							$c2 = $rows['beneficiary_card'];
						// $sendername = "";
						$sql22 = "SELECT username FROM cards WHERE card_no = ?";
						if($stmt22 = $mysqli->prepare($sql22)){
							$stmt22->bind_param("s",$c2);
							$stmt22->execute();
							$result9 = $stmt22->get_result();
							if($result9->num_rows > 0){
								$row1 = $result9->fetch_assoc();
								// $sendername2 = $row1['username'];
							}
						$stmt22->free_result();
						$stmt22->close();
					}


							echo '
	
							<tbody>
									<tr>
										<td class="white-font">'.$rows['sender_card'].'</td>
										<td class="white-font green-arrow fas fa-arrow-alt-circle-down d-flex justify-content-center" style="font-size:30px;color:#0FFF50;border:none;"></td>
										<td class="white-font">'.$rows['beneficiary_card'].'</td>
										<td class="white-font"><b>SELF</b></td>
										<td class="white-font">'.$row1["username"].'</td>
										<td class="white-font">'.$rows['transfer_amt'].'</td>
										<td class="white-font">'.$rows['time_of_transaction'].'</td>
									</tr>
							</tbody>
							
							';
						}
					}
				}
				$stmt->free_result();
            $stmt->close();
			}
			// $mysqli->close();
		}

		elseif($_POST["selectcard"]){
			//$view->view_profile();
			echo '
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
			';
			$card1 = $_POST["selectcard"];
			$sql1 = "SELECT * FROM transfer WHERE username = ? and sender_card = ?";
			if($stmt = $mysqli->prepare($sql1)){
				$stmt->bind_param("ss",$_SESSION['username'],$card1);
				$stmt->execute();
				$result = $stmt->get_result();if($result->num_rows > 0){
					while($rows = $result->fetch_assoc()){
						if($rows['transaction_type']=='DEBITED'){
							echo '
								
	
								<tbody>
										<tr>
											<td class="white-font">'.$rows['sender_card'].'</td>
											<td class="white-font red-arrow fas fa-arrow-alt-circle-up d-flex justify-content-center" style="font-size:30px;color:#dc3545;border:none;"></td>
											<td class="white-font">'.$rows['beneficiary_card'].'</td>
											<td class="white-font">'.$rows['beneficiary_name'].'</td>
											<td class="white-font"><b>ME</b></td>
											<td class="white-font">'.$rows['transfer_amt'].'</td>
											<td class="white-font">'.$rows['time_of_transaction'].'</td>
										</tr>
								</tbody>
								
							';
						}
						elseif($rows['transaction_type']=='CREDITED'){

							$c2 = $rows['beneficiary_card'];
						// $sendername = "";
						$sql22 = "SELECT username FROM cards WHERE card_no = ?";
						if($stmt22 = $mysqli->prepare($sql22)){
							$stmt22->bind_param("s",$c2);
							$stmt22->execute();
							$result9 = $stmt22->get_result();
							if($result9->num_rows > 0){
								$row1 = $result9->fetch_assoc();
								// $sendername2 = $row1['username'];
							}
						$stmt22->free_result();
						$stmt22->close();
					}


							echo '
	
							<tbody>
									<tr>
										<td class="white-font">'.$rows['sender_card'].'</td>
										<td class="white-font green-arrow fas fa-arrow-alt-circle-down d-flex justify-content-center" style="font-size:30px;color:#0FFF50;border:none;"></td>
										<td class="white-font">'.$rows['beneficiary_card'].'</td>
										<td class="white-font"><b>SELF</b></td>
										<td class="white-font">'.$row1["username"].'</td>
										<td class="white-font">'.$rows['transfer_amt'].'</td>
										<td class="white-font">'.$rows['time_of_transaction'].'</td>
									</tr>
							</tbody>
							
							';
						}
					}
				}
				$stmt->free_result();
            $stmt->close();
			}
			// $mysqli->close();
		}
		elseif($_POST["selectduration"]){
			if($_POST["selectduration"]==1){
				$put = 1;
			}
			elseif($_POST["selectduration"]==2){
				$put = 2;
			}
			elseif($_POST["selectduration"]==10){
				$put = 10;
			}
			else{
				
			}
			echo '
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
			';
			$card1 = $_POST["selectduration"];
			$sql1 = "SELECT * FROM transfer WHERE username = ? AND time_of_transaction >= 
			DATE_SUB(CURDATE(), INTERVAL ".$put." DAY)";
			if($stmt = $mysqli->prepare($sql1)){
				$stmt->bind_param("s",$_SESSION['username']);
				$stmt->execute();
				$result = $stmt->get_result();if($result->num_rows > 0){
					while($rows = $result->fetch_assoc()){
						if($rows['transaction_type']=='DEBITED'){
							echo '
								
	
								<tbody>
										<tr>
											<td class="white-font">'.$rows['sender_card'].'</td>
											<td class="white-font red-arrow fas fa-arrow-alt-circle-up d-flex justify-content-center" style="font-size:30px;color:#dc3545;border:none;"></td>
											<td class="white-font">'.$rows['beneficiary_card'].'</td>
											<td class="white-font">'.$rows['beneficiary_name'].'</td>
											<td class="white-font"><b>ME</b></td>
											<td class="white-font">'.$rows['transfer_amt'].'</td>
											<td class="white-font">'.$rows['time_of_transaction'].'</td>
										</tr>
								</tbody>
								
							';
						}
						elseif($rows['transaction_type']=='CREDITED'){

							$c2 = $rows['beneficiary_card'];
						// $sendername = "";
						$sql22 = "SELECT username FROM cards WHERE card_no = ?";
						if($stmt22 = $mysqli->prepare($sql22)){
							$stmt22->bind_param("s",$c2);
							$stmt22->execute();
							$result9 = $stmt22->get_result();
							if($result9->num_rows > 0){
								$row1 = $result9->fetch_assoc();
								// $sendername2 = $row1['username'];
							}
						$stmt22->free_result();
						$stmt22->close();
					}

							echo '

	
							<tbody>
									<tr>
										<td class="white-font">'.$rows['sender_card'].'</td>
										<td class="white-font green-arrow fas fa-arrow-alt-circle-down d-flex justify-content-center" style="font-size:30px;color:#0FFF50;border:none;"></td>
										<td class="white-font">'.$rows['beneficiary_card'].'</td>
										<td class="white-font"><b>SELF</b></td>
										<td class="white-font">'.$row1["username"].'</td>
										<td class="white-font">'.$rows['transfer_amt'].'</td>
										<td class="white-font">'.$rows['time_of_transaction'].'</td>
									</tr>
							</tbody>
							
							';
						}
					}
				}
				$stmt->free_result();
            $stmt->close();
			}
			// $mysqli->close();


		}
	}




        $sql1 = "SELECT * FROM transfer WHERE username = ?";
		if(!($_POST['selectcard']) && !($_POST["selecttransaction"]) && !($_POST['selectduration'])){
        if($stmt = $mysqli->prepare($sql1)){
            $stmt->bind_param("s",$_SESSION["username"]);
            $stmt->execute();
            $result = $stmt->get_result();
            if($result->num_rows > 0){
				echo '
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
			';
                while($rows = $result->fetch_assoc()){
                    if($rows['transaction_type']=='DEBITED'){
						
						echo '

							<tbody>
									<tr>
										<td class="white-font">'.$rows['sender_card'].'</td>
										<td class="white-font red-arrow fas fa-arrow-alt-circle-up d-flex justify-content-center" style="font-size:30px;color:#dc3545;border:none;"></td>
										<td class="white-font">'.$rows['beneficiary_card'].'</td>
										<td class="white-font">'.$rows['beneficiary_name'].'</td>
										<td class="white-font"><b>ME</b></td>
										<td class="white-font">'.$rows['transfer_amt'].'</td>
										<td class="white-font">'.$rows['time_of_transaction'].'</td>
									</tr>
							</tbody>
							
						';
					}
					elseif($rows['transaction_type']=='CREDITED'){
						$c2 = $rows['beneficiary_card'];
						// $sendername = "";
						$sql22 = "SELECT username FROM cards WHERE card_no = ?";
						if($stmt22 = $mysqli->prepare($sql22)){
							$stmt22->bind_param("s",$c2);
							$stmt22->execute();
							$result9 = $stmt22->get_result();
							if($result9->num_rows > 0){
								$row1 = $result9->fetch_assoc();
								// $sendername2 = $row1['username'];
							}
						$stmt22->free_result();
						$stmt22->close();
					}

						echo '

						<tbody>
								<tr>
									<td class="white-font">'.$rows['sender_card'].'</td>
									<td class="white-font green-arrow fas fa-arrow-alt-circle-down d-flex justify-content-center" style="font-size:30px;color:#0FFF50;border:none;"></td>
									<td class="white-font">'.$rows['beneficiary_card'].'</td>
									<td class="white-font"><b>SELF</b></td>
									<td class="white-font">'.$row1['username'].'</b></td>
									<td class="white-font">'.$rows['transfer_amt'].'</td>
									<td class="white-font">'.$rows['time_of_transaction'].'</td>
								</tr>
						</tbody>
						
						';
					}
                }
            }
            else{
                echo "<b>NO RECORD FOR " .$_SESSION["username"]."</b>";
            }
            $stmt->free_result();
            $stmt->close();
        }

        $mysqli->close();
	}
}

	public function get_card(){
		if(!isset($_SESSION["loggedin"])){
            header("location: login.php");
            exit;
        }
		$mysqli = $this->connect();
		$usr = $_SESSION["username"];
		$sql = "SELECT * FROM cards WHERE username = ?";
		if($stmt = $mysqli->prepare($sql)){
			$stmt->bind_param("s",$usr);
			$stmt->execute();
			$result = $stmt->get_result();
			if($result->num_rows > 0){
				while($rows = $result->fetch_assoc()){
					echo '
						<option>'.$rows['card_no'].'</option>
						 ';
				}
			}
			global $get_card;
			$get_card = $_POST['selectcard'];
			// echo $get_card;
			$stmt->free_result();
			$stmt->close();
		}
		$mysqli->close();

	} 
}
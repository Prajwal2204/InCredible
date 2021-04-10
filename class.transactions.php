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



        $sql1 = "SELECT * FROM transfer WHERE username = ? and time_of_transaction <= now() - interval 1 day;";
        if($stmt = $mysqli->prepare($sql1)){
            $stmt->bind_param("s",$_SESSION["username"]);
            $stmt->execute();
            $result = $stmt->get_result();
            if($result->num_rows > 0){
                while($rows = $result->fetch_assoc()){
                    if($rows['transaction_type']=='DEBITED'){
						echo '

							<tbody>
									<tr>
										<td class="white-font">'.$rows['sender_card'].'</td>
										<td class="white-font">'.$rows['transaction_type'].'</td>
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
						echo '

						<tbody>
								<tr>
									<td class="white-font">'.$rows['sender_card'].'</td>
									<td class="white-font">'.$rows['transaction_type'].'</td>
									<td class="white-font">'.$rows['beneficiary_card'].'</td>
									<td class="white-font"><b>SELF</b></td>
									<td class="white-font">'.$_SESSION["username"].'</td>
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
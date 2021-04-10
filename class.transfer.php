<?php 

include_once "config.php";
class transfer_money extends DBC{
    public function __construct()
    {
        session_start();
    }


    public function add_options(){
        if(!isset($_SESSION["loggedin"])){
            header("location: login.php");
            exit;
        }
        $mysqli = $this->connect();
        $sql = "SELECT * FROM cards WHERE username = ?";
        $user = $_SESSION["username"];
        if($stmt = $mysqli->prepare($sql)){
            $stmt->bind_param("s",$user);
            $stmt->execute();
            $result = $stmt->get_result();
            if($result->num_rows>0){
                while($rows = $result->fetch_assoc()){
                    echo '
                    <option value="none" selected disabled hidden>
                          Select a card to pay from
                      </option>
                    <option>'.$rows['card_no'].'</option>

                    ';

                }
            }
            else{
                // header("Location:addcard.php");
                echo '<script>alert("First <b> ADD CARD into the InCredible</b>")</script>';
                
            }
        }
        else{
            echo "Oops! Something went wrong try again later";
        }
        $mysqli->close();

    }
     
    public function error_checking($beneficiarycard){

        global $beneficiarycard_err;

        if(empty(trim($beneficiarycard))){
            $beneficiarycard_err = "Please enter a card number.";  
        }

        elseif(!preg_match("#[0-9]+#",$beneficiarycard)) {
            $beneficiarycard_err = "Your card number Must Contain only Number!";
        }
        elseif(!((strlen(trim($beneficiarycard))==15)|| (strlen(trim($beneficiarycard))==16)|| (strlen(trim($beneficiarycard))==13))){
            $beneficiarycard_err = "card number must have either 13 or 15 or 16 characters.";
        }

        elseif(!($this->validatecard(trim($beneficiarycard)))){
            $beneficiarycard_err = "Not A Valid CARD no.";				

        }
        else{
            $beneficiarycard_err = "";
        }

        return $beneficiarycard_err;

    }

    public function error_checking_name($beneficiaryname){

        global $beneficiaryname_err;

        if(empty(trim($beneficiaryname))){
            $beneficiaryname_err = "Please enter a fullname";  
        }
        elseif(!preg_match("/^([a-zA-Z' ]+)$/",$beneficiaryname)){
            $name_err = "It should contain alphabets";
        }else{
                $beneficiaryname_err = "";
        }

        return $beneficiaryname_err;
    }
    
    public function transfer_fund(){
           //global $mysqli = $this->connect();
        if(!isset($_SESSION["loggedin"])){
            header("location: login.php");
            exit;
        }

        $user = $_SESSION["username"];
        $mysqli = $this->connect();
        //$cards = new add_cards;


        global $sendercard_err, $beneficiarycard_err, $beneficiaryname_err, $amount_err, $cvv_err, $success;
        // $sendercard_err = $sendercard_err = $beneficiarycard_err = $beneficiary_card = $amount_err = $amount_value = $cvv_err = $cvv_no ;


        $usr = $_SESSION["username"];
        global $cvv_no;
        global $amount_value;

        $mysqli = $this->connect();
        $beneficiarycard = $_POST['beneficiarycard'];
        $beneficiaryname = $_POST['beneficiaryname'];
        $amount = $_POST['amount'];
        $cvv_code = $_POST["cvv"];
        if(empty($this->error_checking($beneficiarycard))){
            $beneficiary_card = trim($beneficiarycard);
        }
        if(empty($this->error_checking_name($beneficiaryname))){
            $beneficiary_name = trim($beneficiaryname);
        }
        if(empty($_POST['sendercard'])){
            $sendercard_err = "Please choose one of the card";
        }
        else{
            
            $sendercard = $_POST['sendercard'];
            $sender_card = trim($sendercard);
            if(empty(trim($cvv_code))){
                $cvv_err = "Please enter a cvv code.";  
            }
            
            else{
                $cvv_no = trim($cvv_code);
            
            }
    
            if(empty($cvv_err)){
                $sql10 = "SELECT cvv FROM cards WHERE card_no=? and cvv=?";
                $stmt = $mysqli->prepare($sql10);
                $param_cvv_no = md5($cvv_no);
                $stmt->bind_param("ss",$sender_card,$param_cvv_no);
                $stmt->execute();
                $stmt->bind_result($cvvno);
                $stmt->store_result();
                if($stmt->num_rows == 1){
                    $cvv_err = "";
                }
                else{
                    $cvv_err = "failed";
                }
                $stmt->close();
            }
        }

        if(empty(trim($amount))){
            $amount_err = "Please enter amount";  
        }
        else{
            if(!preg_match("#[0-9]+#",$amount)) {
                $amount_err = "Your amount Must Contain only Number!";
            }
            elseif($amount<0){
                $amount_err = "Min Value should be greater zero";
            }
            else{
                $amount_value = trim($amount);
            }
        }



        if(empty($beneficiarycard_err)&&empty($beneficiaryname_err)&&empty($sendercard_err)&&empty($cvv_err)&&empty($amount_err)){
            
        
        $sql2 = "SELECT * FROM cards WHERE card_no = ?";
        $stmt2 = $mysqli->prepare($sql2);
        $stmt2->bind_param("s",$sendercard);
        $stmt2->execute();
        $result2 = $stmt2->get_result();

        $row1 = $result2->fetch_assoc();
        $current_bal = $row1['acc_balance'];
        $stmt2->free_result();
        $stmt2->close();

        if($amount_value>0){

            if($current_bal>=$amount_value){
                $owner_updated = $current_bal - $amount_value;

                $sql4 = "UPDATE cards SET acc_balance = ? WHERE card_no = ?";
                $stmt2 = $mysqli->prepare($sql4);
                $stmt2->bind_param("is",$owner_updated,$sender_card);
                $stmt2->execute();
                $stmt2->free_result();
                $stmt2->close();
                
                $sql5 = "INSERT INTO transfer(sender_card, beneficiary_card, beneficiary_name, transfer_amt) VALUES(?,?,?,?)";
                $stmt2 = $mysqli->prepare($sql5);
                $stmt2->bind_param("sssi",$sender_card,$beneficiary_card,$beneficiary_name,$amount_value);
                $stmt2->execute();
                $stmt2->free_result();
                $stmt2->close();

                $sql6 = "SELECT * FROM cards WHERE card_no = ?";
                $stmt2 = $mysqli->prepare($sql6);
                $stmt2->bind_param("s",$beneficiary_card);
                $stmt2->execute();
                $result3 = $stmt2->get_result();

                if(($result3->num_rows)==1)
                {   
                    $row1 = $result3->fetch_assoc();
                    $current_balance_amount = $row1['acc_balance'];
                    $sum_amount = $current_balance_amount + $amount_value;
                    $sql7 = "UPDATE cards SET acc_balance = ? WHERE card_no = ?";
                    $sql8 = "INSERT INTO transfer(sender_card, beneficiary_card, beneficiary_name, transfer_amt,transaction_type) VALUES(?,?,?,?,?)";
                    $stmt4 = $mysqli->prepare($sql8);
                    $transaction_type = "CREDITED";
                    $stmt4->bind_param("sssis",$beneficiary_card,$beneficiary_name,$sender_card,$amount_value,$transaction_type);
                    $stmt4->execute();
                    $stmt4->free_result();
                    $stmt4->close();

                    $stmt3 = $mysqli->prepare($sql7);
                    $stmt3->bind_param("is",$sum_amount,$beneficiary_card);
                    $stmt3->execute();
                    $stmt3->free_result();
                    $stmt3->close();
                }

                $stmt2->free_result();
                $stmt2->close();



                    

                $success = "Transferred succesfully!";
            }
            else{
                $success = "You don't have enough balance!";
            }

        }
        else{
            $success = "Don't be smart!";
        }
    }

    $mysqli->close();

    }


}
<?php 

include_once "config.php";
class add_cards extends DBC{
    private $type;
    public function __construct()
    {
        session_start();
    }

    public function validatecard($number)
    {
       
   
       $cardtype = array(
           "VISA"       => "/^4[0-9]{12}(?:[0-9]{3})?$/",
           "MasterCard" => "/^5[1-5][0-9]{14}$/",
           "Amex"       => "/^3[47][0-9]{13}$/",
           "Discover"   => "/^6(?:011|5[0-9]{2})[0-9]{12}$/",
       );
   
       if (preg_match($cardtype['VISA'],$number))
       {
       $this->type= "VISA";
           //return 'VISA';
       
       }
       else if (preg_match($cardtype['MasterCard'],$number))
       {
       $this->type= "MasterCard";
           //return 'MasterCard';
       }
       else if (preg_match($cardtype['Amex'],$number))
       {
       $this->type= "Amex";
           //return 'Amex';
       
       }
       else if (preg_match($cardtype['Discover'],$number))
       {
       $this->type= "Discover";
           //return 'Discover';
       }
       else
       {
           $this->type = false;
           //return false;
       } 
       return $this->type;
    }
    //  public function card_type_return(){
    //      return $this->type;
    //  }
   

    public function add_card(){
            

            if(!isset($_SESSION["loggedin"])){
                header("location: login.php");
                exit;
            }
            $mysqli = $this->connect();
            global $name_err;
            global $bankname_err;
            global $cardno_err;
            global $cvv_err;
            global $cardtype_err;
            global $expirydate_err;
			global $acc_balance_err;
            $username = $_SESSION["username"];
            $accname = $_POST['accname'];
            $bank = $_POST['bank'];
            $card_no = $_POST['cardno'];
            $cvv_code = $_POST['acccvv'];
            $card_type = $_POST['cardtype'];
            $expiry_date = $_POST['expdate'];
			$acc_balance = $_POST['accbalance'];
        
        // validate account balance
        if(empty(trim($acc_balance))){
            $acc_balance_err = "Please enter a account number!";  
        }
        else{
            if(!preg_match("#[0-9]+#",$acc_balance)){
                $acc_balance_err = "It should contain only numeric values";
            }
            elseif(!(($acc_balance>10)&&($acc_balance<100000))){
                $acc_balance_err = "Please enter values within 10 and 100000";
            }
            else{
                    $accbalance = trim($acc_balance);
            }
        }

        // validate bank name 
            if(empty(trim($bank))){
                $bankname_err = "Please enter a fullname";  
            }
            else{
                if(!preg_match("/^([a-zA-Z' ]+)$/",$bank)){
                    $bankname_err = "It should contain alphabets";
                }
                else{
                        $bankname = trim($bank);
                }
            }
        // validate account name 
            if(empty(trim($accname))){
                $name_err = "Please enter a fullname";  
            }
            else{
                if(!preg_match("/^([a-zA-Z' ]+)$/",$accname)){
                    $name_err = "It should contain alphabets";
                }
                else{
                        $name = trim($accname);
                }
            }

        // cvv validation

            if(empty(trim($cvv_code))){
                $cvv_err = "Please enter a cvv code.";  
            }
            
            else{
                if(strlen(trim($cvv_code))!=3){
                    $cvv_err = "it must contain 3 characters";
                }
                elseif(!preg_match("#[0-9]+#",$cvv_code)){
                    $cvv_err = "It should contain only integer values";
                }
                else{
                    $cvv = trim($cvv_code);
                }
            }

            
        // card number validation
            if(empty(trim($card_no))){
                $cardno_err = "Please enter a card number.";  
            }

            elseif(!preg_match("#[0-9]+#",$card_no)) {
                $cardno_err = "Your card number Must Contain only Number!";
            }
            elseif(!((strlen(trim($card_no))==15)|| (strlen(trim($card_no))==16)|| (strlen(trim($card_no))==13))){
                $cardno_err = "card number must have either 13 or 15 or 16 characters.";
            }

            elseif(!($this->validatecard(trim($card_no)))){
                $cardno_err = "Not A Valid CARD no.";				

            }
            
            else{
                // Prepare a select statement
                $sql = "SELECT card_no FROM cards WHERE card_no = ?";
                
                if($stmt = $mysqli->prepare($sql)){
                    // Bind variables to the prepared statement as parameters
                    $stmt->bind_param("s", $card_no);
                    
                    // Set parameters
                    $param_cardno = trim($card_no);
                    
                    // Attempt to execute the prepared statement
                    if($stmt->execute()){
                        // store result
                        $stmt->store_result();
                        
                        if($stmt->num_rows == 1){
                            $cardno_err = "This card number is already taken.";
                        } 
                        
                        else{
                            $cardno = trim($card_no);
                        }
                    } 
                    else{
                        echo "Oops! Something went wrong. Please try again later.";
                    }
        
                    // Close statement
                    $stmt->close();
                }
            }

            // card type validation
            if(empty(trim($card_type))){
                $cardtype_err = "Please select proper card type";
            }
            else{
                if(trim($card_type) == trim($this->type))
                $cardtype = $this->type;
                else 
                $cardtype_err = "Not valid card";
            }


        // date validation
            if(empty(trim($expiry_date))){
                $expirydate_err = "Please enter an date.";
            
            } else {
                $date = new DateTime($expiry_date);
                $now = new DateTime();
                if($date < $now) {
                $expirydate_err = 'Date is in the past';
                }
                else{
                    $expirydate = trim($expiry_date);
                }
                    
            }


            if(empty($name_err) && empty($bankname_err) && empty($cardno_err) && empty($cardtype_err) && empty($cvv_err) && empty($acc_balance_err) && empty($expirydate_err)){

                $sql = "INSERT INTO cards (username, name, bank, card_no, cvv, card_type, acc_balance, expiry_date) VALUES (?, ?, ?, ?, ?, ?, ?, ?)";

                if($stmt = $mysqli->prepare($sql)){
                    // Set parameters
                    $param_username = $username;
                    $param_name = $name;
                    $param_bankname = $bankname;
                    $param_cardno = $cardno;
                    
                    $param_cvv = md5($cvv); // Creates a password hash
                    $param_cardtype = $cardtype;
                    $param_expirydate = $expirydate;
					$param_accbalance = $accbalance;
                    
                    // Bind variables to the prepared statement as parameters
                    $stmt->bind_param("ssssssis", $param_username, $param_name, $param_bankname, $param_cardno, $param_cvv, $param_cardtype, $param_accbalance, $param_expirydate);
                    
                    // Attempt to execute the prepared statement
                    if($stmt->execute()){
                        // Redirect to login page
                        header("location: addcard.php");
                        echo "hello world";
                    } 
                    
                    else{
                        echo "Oops! Something went wrong. Please try again later.";
                    }
        
                    // Close statement
                    $stmt->close();
                }
            }
        
        // Close connection
            $mysqli->close();
        
    }
}
?>
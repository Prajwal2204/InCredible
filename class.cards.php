<?php 

include_once "config.php";
class cards extends DBC{
    public function __construct()
    {
        session_start();
    }

    public function add_card(){
            $mysqli = $this->connect();

            if(!isset($_SESSION["loggedin"])){
                header("location: login.php");
                exit;
            }

            global $name_err;
            global $bankname_err;
            global $cardno_err;
            global $cvv_err;
            global $expirydate_err;
            $username = $_SESSION["username"];
            $accname = $_POST['accname'];
            $bank = $_POST['bank'];
            $card_no = $_POST['cardno'];
            $cvv_code = $_POST['acccvv'];
            $cardtype = $_POST['cardtype'];
            $expiry_date = $_POST['expdate'];

        // validate bank name 
            if(empty(trim($bank))){
                $bankname_err = "Please enter a fullname";  
            }
            else{
                if(!preg_match("/^[a-zA-Z'-]+$/", $bank)){
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
                if(!preg_match("/^[a-zA-Z'-]+$/", $accname)){
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

            elseif(strlen(trim($card_no))!=16){
                $cardno_err = "card number must have  16 characters.";
            }

            elseif(!preg_match("#[0-9]+#",$card_no)) {
                $cardno_err = "Your card number Must Contain only Number!";
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
                        } else{
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


        // date validation
            if(empty(trim($expiry_date))){
                $email_err = "Please enter an date.";
            
            } else {
                $date = new DateTime($expiry_date);
                $now = new DateTime();
                if($date < $now) {
                $expirydate_err = 'Date is in the past';
                }
                else{
                    $expirydate = trim($expiry_date);
            }


            if(empty($name_err) && empty($bankname_err) && empty($cardno_err) && empty($cvv_err) && empty($expirydate_err)){

                $sql = "INSERT INTO cards (username, name, bank, card_no, cvv, card_type, expiry_date) VALUES (?, ?, ?, ?, ?, ?, ?)";

                if($stmt = $mysqli->prepare($sql)){
                    // Set parameters
                    $param_username = $username;
                    $param_name = $name;
                    $param_bankname = $bankname;
                    $param_cardno = $cardno;
                    $param_cvv = password_hash($cvv, PASSWORD_DEFAULT); // Creates a password hash
                    $param_cardtype = $cardtype;
                    $param_expirydate = $expirydate;
                    
                    // Bind variables to the prepared statement as parameters
                    $stmt->bind_param("sssssss", $param_username, $param_name, $param_bankname, $param_cardno, $param_cvv, $param_cardtype, $param_expirydate);
                    
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
}
?>
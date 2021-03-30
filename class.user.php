<?php 
	require_once "config.php";
    //include_once "register" ;
	class User{
		//protected $db;
        
		// public function __construct(){
		// 	// global $mysqli;
		// 	// $this->db = $mysqli;
		// }

        

        public function registration($usr,$email,$pass,$cpass){
            global $mysqli;
            global $username_err;
            global $email_err;
            global $confirm_password_err;
            global $password_err;  

            // $pass = md5($pass);
            // $cpass = md5($cpass); 
            if(empty(trim($usr))){
                $username_err = "Please enter a username.";
               
            } else{
                // Prepare a select statement
                $sql = "SELECT id FROM users WHERE username = ?";
                
                if($stmt = $mysqli->prepare($sql)){
                    // Bind variables to the prepared statement as parameters
                    $stmt->bind_param("s", $usr);
                    
                    // Set parameters
                    $param_username = trim($usr);
                    
                    // Attempt to execute the prepared statement
                    if($stmt->execute()){
                        // store result
                        $stmt->store_result();
                        
                        if($stmt->num_rows == 1){
                            $username_err = "This username is already taken.";
                        } else{
                            $username = trim($usr);
                        }
                    } else{
                        echo "Oops! Something went wrong. Please try again later.";
                    }
        
                    // Close statement
                    $stmt->close();
                }
            }
            // Validate email
            if(empty(trim($email))){
                $email_err = "Please enter an email.";
               
            } else {
                if (filter_var($email, FILTER_VALIDATE_EMAIL)) {
                    // echo("$email is a valid email address");
                    $emailid = trim($email);
                } else{
                    echo "$email is not a valid email address";
                }
            }

            // Validate password
            if(empty(trim($pass))){
                $password_err = "Please enter a password.";     
            } elseif(strlen(trim($pass)) < 6){
                $password_err = "Password must have atleast 6 characters.";
            } else{
                $password = trim($pass);
            }
            
            // Validate confirm password
            if(empty(trim($cpass))){
                $confirm_password_err = "Please confirm password.";     
            } else{
                $confirm_password = trim($cpass);
                if(empty($password_err) && ($password != $confirm_password)){
                    $confirm_password_err = "Password did not match.";
                }
            }
            
            // Check input errors before inserting in database
            if(empty($username_err) && empty($email_err) && empty($password_err) && empty($confirm_password_err)){
                // $pass = md5($pass);
                // $cpass = md5($cpass);
                // Prepare an insert statement
                $sql = "INSERT INTO users (username, emailid, password) VALUES (?, ?, ?)";
                 
                if($stmt = $mysqli->prepare($sql)){
                    // Set parameters
                    $param_username = $username;
                    $param_emailid = $emailid;
                    $param_password = password_hash($password, PASSWORD_DEFAULT); // Creates a password hash

                    // Bind variables to the prepared statement as parameters
                    $stmt->bind_param("sss", $param_username, $param_emailid, $param_password);
                    
                    
                    // Attempt to execute the prepared statement
                    if($stmt->execute()){
                        // Redirect to login page
                        header("location: login.php");
                    } else{
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

    
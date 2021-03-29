<?php 
	require_once "config.php";
    //include_once "register-oo-format" ;
	class User2{
        public function resetpassword($new_pass,$confirm_pass){
            global $mysqli;
            // global $username_err;
            global $confirm_password_err;
            global $new_password_err;
            global $new_password;
            global $confirm_password;
                  // Validate new password
           
            if(empty(trim($new_pass))){
                $new_password_err = "Please enter the new password.";     
            } elseif(strlen(trim($new_pass)) < 6){
                $new_password_err = "Password must have atleast 6 characters.";
            } else{
                $new_password = trim($new_pass);
            }
            
            // Validate confirm password
            if(empty(trim($confirm_pass))){
                $confirm_password_err = "Please confirm the password.";
            } else{
                $confirm_password = trim($confirm_pass);
                if(empty($new_password_err) && ($new_password != $confirm_password)){
                    $confirm_password_err = "Password did not match.";
                }
            }
                
            // Check input errors before updating the database
            if(empty($new_password_err) && empty($confirm_password_err)){
                // Prepare an update statement
                $sql = "UPDATE users SET password = ? WHERE id = ?";
                
                if($stmt = $mysqli->prepare($sql)){
                    // Bind variables to the prepared statement as parameters
                    $stmt->bind_param("si", $param_password, $param_id);
                    
                    // Set parameters
                    $param_password = password_hash($new_password, PASSWORD_DEFAULT);
                    $param_id = $_SESSION["id"];
                    
                    // Attempt to execute the prepared statement
                    if($stmt->execute()){
                        // Password updated successfully. Destroy the session, and redirect to login page
                        session_destroy();
                        header("location: login.php");
                        exit();
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
?>
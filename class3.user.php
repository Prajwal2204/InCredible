<?php 

include_once "config.php";
class login_in extends DBC{
    function __construct()
    {
        session_start();
    }

    public function signin(){
        if(isset($_SESSION["loggedin"]) && $_SESSION["loggedin"] === true){
            header("location: admin.php");
            echo $_SESSION["loggedin"] ;
            exit;
        }
        
        global $username, $password;
        global $username_err, $password_err,$login_err;
         
        
        
            $usr = $_POST["username"];
            $pass = $_POST["password"];
            // Check if username is empty
            // $hello = new DBC;
            $mysqli = $this->connect();
            if(empty(trim($usr))){
                $username_err = "Please enter username.";
            } else{
                $username = trim($usr);
            }
            
            // Check if password is empty
            if(empty(trim($pass))){
                $password_err = "Please enter your password.";
            } else{
                $password = trim($pass);
            }
            
            // Validate credentials
            if(empty($username_err) && empty($password_err)){
                // Prepare a select statement
                $sql = "SELECT username, password FROM users WHERE username = ?";
                
                if($stmt = $mysqli->prepare($sql)){
                    // Bind variables to the prepared statement as parameters
                    $stmt->bind_param("s", $param_username);
                    
                    // Set parameters
                    $param_username = $username;
                    
                    // Attempt to execute the prepared statement
                    if($stmt->execute()){
                        // Store result
                        $stmt->store_result();
                        
                        // Check if username exists, if yes then verify password
                        if($stmt->num_rows == 1){                    
                            // Bind result variables
                            $stmt->bind_result($username, $hashed_password);
                            if($stmt->fetch()){
                                if(password_verify($password, $hashed_password)){
                                    // Password is correct, so start a new session
                                    session_start();
                                    
                                    // Store data in session variables
                                    $_SESSION["loggedin"] = true;
                                    // $_SESSION["id"] = $id;
                                    $_SESSION["username"] = $username;                            
                                    
                                    // Redirect user to welcome page
                                    header("location: admin.php");
                                } else{
                                    // Password is not valid, display a generic error message
                                    $login_err = "Invalid username or password.";
                                }
                            }
                        } 
                        else{
                            // Username doesn't exist, display a generic error message
                            $login_err = "Invalid username or password.";
                        }
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
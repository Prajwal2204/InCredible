<?php
// Initialize the session
session_start();
 
// Check if the user is already logged in, if yes then redirect him to welcome page
if(isset($_SESSION["loggedin"]) && $_SESSION["loggedin"] === true){
    header("location: admin.php");
    echo $_SESSION["loggedin"] ;
    exit;
}
 
// Include config file
include_once "config.php";
 
$username = $password = "";
$username_err = $password_err = $login_err = "";

// Processing form data when form is submitted
if($_SERVER["REQUEST_METHOD"] == "POST"){
    $usr = $_POST["username"];
    $pass = $_POST["password"];
    // Check if username is empty
    $hello = new DBC;
    $mysqli = $hello->connect();
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
        $sql = "SELECT id, username, password FROM users WHERE username = ?";
        
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
                    $stmt->bind_result($id, $username, $hashed_password);
                    if($stmt->fetch()){
                        if(password_verify($password, $hashed_password)){
                            // Password is correct, so start a new session
                            session_start();
                            
                            // Store data in session variables
                            $_SESSION["loggedin"] = true;
                            $_SESSION["id"] = $id;
                            $_SESSION["username"] = $username;                            
                            
                            // Redirect user to welcome page
                            header("location: admin.php");
                        } else{
                            // Password is not valid, display a generic error message
                            $login_err = "Invalid username or password.";
                        }
                    }
                } else{
                    // Username doesn't exist, display a generic error message
                    $login_err = "Invalid username or password.";
                }
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
?>
 
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Login - InCredible</title>
    <link rel="stylesheet" href="node_modules/bootstrap/dist/css/bootstrap.min.css">
    <link rel = "stylesheet" href = "css/styles.css">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <style>
        body{ font: 14px sans-serif; }
        .wrapper{ width: 350px; padding: 20px; }
    </style>
    <style>
        /* body{
            background: linear-gradient(-45deg, #ee7752, #e73c7e, #23a6d5, #23d5ab);
            background-size: 400% 400%;
            animation: gradient 20s ease infinite;
        }
        @keyframes gradient {
            0% {
                background-position: 0% 50%;
            }
            50% {
                background-position: 100% 50%;
            }
            100% {
                background-position: 0% 50%;
            }
        } */
        body{
            background-color: rgb(246,76,114);
        }
    </style>
</head>
<body>
    <div class = "row">
        <div class="col-8 custom-jumbo">
			<div class="row">
                <div class="col-sm-12">
                    <h1 class="display-3"><img class="jumbo-img" src="img/logo-dark.PNG"></h1>
                    <br>
                    <h3 style="color: #000;">A web app to take care of all your credit card needs.</h3>
                    <br>
                </div>
			</div>
		</div>

        <div class = "col-4">
            <div class="wrapper container sike">
                <img class="center" src = "img/logo.PNG">
                <br><br><br>
                <h2 class="d-flex justify-content-center">Login</h2>
                <p class="d-flex justify-content-center">Please fill in your credentials to login.</p>

                <?php 
                if(!empty($login_err)){
                    echo '<div class="alert alert-danger">' . $login_err . '</div>';
                }        
                ?>

                <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
                    <div class="form-group">
                        <label>Username</label>
                        <input type="text" name="username" class="form-control <?php echo (!empty($username_err)) ? 'is-invalid' : ''; ?>" value="<?php echo $username; ?>">
                        <span class="invalid-feedback"><?php echo $username_err; ?></span>
                    </div>    
                    <div class="form-group">
                        <label>Password</label>
                        <input type="password" name="password" class="form-control <?php echo (!empty($password_err)) ? 'is-invalid' : ''; ?>">
                        <span class="invalid-feedback"><?php echo $password_err; ?></span>
                    </div>
                    <div class="form-group d-flex justify-content-center">
                        <input type="submit" class="btn btn-primary" value="Login">
                    </div>
                    <p class="d-flex justify-content-center">Don't have an account? <a href="register.php">Sign up now</a>.</p>
                </form>
            </div>
        </div>
    </div>
</body>
</html>
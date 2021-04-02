<?php
// Initialize the session
//session_start();

        // Include config file
include_once "class3.user.php";
$username = $password = "";
$username_err = $password_err = $login_err = "";

$login = new login_in;
// Processing form data when form is submitted
    if($_SERVER["REQUEST_METHOD"] == "POST"){
        $login->signin();
    }
// Check if the user is already logged in, if yes then redirect him to welcome page

?>
 
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Login - InCredible</title>
    <link rel="stylesheet" href="node_modules/bootstrap/dist/css/bootstrap.min.css">
    <link rel = "stylesheet" href = "css/styles.css">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <link rel="preconnect" href="https://fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css2?family=Roboto:ital,wght@1,700&display=swap" rel="stylesheet">
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
            background-color: #dc3545;
        }
    </style>
</head>
<body>
    <div class = "row">
        <div class="col-8 custom-jumbo">
			<div class="row">
                <div class="col-sm-12">
                    <div style="width: 150px; height: 150px;"></div>
                    <h1 class="display-3"><img class="jumbo-img" src="img/logo-inverted.PNG"></h1>
                    <br>
                    <h3 class="d-flex justify-content-center font-change" style="color: #fff;">Manage your personal information wisely!</h3>
                    <h3 class="d-flex justify-content-center font-change" style="color: #fff;">We provide a wide range of services for your credit card necessities for free!!</h3>
                    <h3 class="d-flex justify-content-center font-change" style="color: #fff;">From adding cards into your portfolio to transaction management, we've got you covered.</h3>
                    <br>
                </div>
			</div>
		</div>

        <div class = "col-4">
        <div style="width: 150px; height: 150px;"></div>
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
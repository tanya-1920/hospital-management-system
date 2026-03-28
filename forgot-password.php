<!-- USER FORGOT PASSWORD -->

<?php
session_start();
error_reporting(0);
include("include/config.php");

//Checking Details for reset password
if(isset($_POST['submit'])){
    $name  = $_POST['fullname'];
    $email = $_POST['email'];

    $query = mysqli_query($con,"select id from users where fullName='$name' and email='$email'");
    $row   = mysqli_num_rows($query);

    if($row>0){
        $_SESSION['name']  = $name;
        $_SESSION['email'] = $email;
        header('location:reset-password.php');
        exit();
    } else {
        $_SESSION['errmsg'] = "Invalid details. Please try again.";
        header("location:forgot-password.php");
        exit();
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
<title>Password Recovery</title>

<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1">

<link rel="stylesheet" href="vendor/bootstrap/css/bootstrap.min.css">
<link rel="stylesheet" href="vendor/fontawesome/css/font-awesome.min.css">

<link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600&display=swap" rel="stylesheet">

<style>

/* SAME AS LOGIN PAGE */
body.login {
    margin: 0;
    font-family: 'Poppins', sans-serif;
    
    background: linear-gradient(135deg, 
        #667eea 0%, 
        #6f7be8 25%, 
        #7a74e6 50%, 
        #846be3 75%, 
        #764ba2 100%
    );

    height: 100vh;
}

.main-login {
    margin-top: 8%;
}

.box-login {
    background: #fff;
    padding: 35px 30px;
    border-radius: 12px;
    box-shadow: 0 20px 50px rgba(0,0,0,0.15);
    animation: fadeIn 0.6s ease-in-out;
}

.logo h2 {
    text-align: center;
    color: #fff;
    font-weight: 600;
}

legend {
    text-align: center;
    font-weight: 600;
}

.form-control {
    border-radius: 8px;
    padding: 12px;
    border: 1px solid #ddd;
}

.form-control:focus {
    border-color: #667eea;
    box-shadow: 0 0 0 2px rgba(102,126,234,0.2);
}

.input-icon {
    position: relative;
}

.input-icon i {
    position: absolute;
    right: 12px;
    top: 12px;
    color: #888;
}
.logout-title {
    text-align: center !important;
    font-weight: 700 !important;
    font-size: 28px !important;
    margin-bottom: 20px !important;
    color: #222 !important;
    display: block;
    width: 100%;
}

.btn-primary {
    width: 100%;
    border-radius: 8px;
    padding: 12px;
    background: #667eea;
    border: none;
    transition: 0.3s;
}

.btn-primary:hover {
    background: #5a67d8;
}

a {
    color: #667eea;
}

a:hover {
    text-decoration: underline;
}

p {
    text-align: center;
    color: #666;
}

.new-account {
    text-align: center;
    margin-top: 15px;
}

.error-box {
    background: #ffe5e5;
    color: #d00000;
    padding: 10px;
    border-radius: 6px;
    text-align: center;
    margin-bottom: 15px;
    font-size: 14px;
}

.copyright {
    text-align: center;
    margin-top: 15px;
    color: #aaa;
}

@keyframes fadeIn {
    from {
        opacity: 0;
        transform: translateY(25px);
    }
    to {
        opacity: 1;
        transform: translateY(0);
    }
}

</style>
</head>

<body class="login">

<div class="row">
    <div class="main-login col-xs-10 col-xs-offset-1 col-sm-6 col-sm-offset-3 col-md-4 col-md-offset-4">

        <div class="logo margin-top-30">
            <a href="../index.php"><h2>HMS | Password Recovery</h2></a>
        </div>

        <div class="box-login">

            <!-- ERROR MESSAGE -->
            <?php
            if(isset($_SESSION['errmsg']) && $_SESSION['errmsg'] != "") {
                echo '<div class="error-box">'.$_SESSION['errmsg'].'</div>';
                $_SESSION['errmsg'] = "";
            }
            ?>

            <form class="form-login" method="post">
                <fieldset>

                    <h2 class="logout-title">Sign In</h2>

                    

                    <div class="form-group">
                        <span class="input-icon">
                            <input type="text" class="form-control" name="fullname" placeholder="Registered Full Name" required>
                            <i class="fa fa-user"></i>
                        </span>
                    </div>

                    <div class="form-group">
                        <span class="input-icon">
                            <input type="email" class="form-control" name="email" placeholder="Registered Email" required>
                            <i class="fa fa-envelope"></i>
                        </span>
                    </div>

                    <div class="form-actions">
                        <button type="submit" class="btn btn-primary" name="submit">
                            Continue <i class="fa fa-arrow-right"></i>
                        </button>
                    </div>

                    <div class="new-account">
                        Already have an account? 
                        <a href="user-login.php">Login</a>
                    </div>

                </fieldset>
            </form>

           

        </div>
    </div>
</div>

<script src="vendor/jquery/jquery.min.js"></script>
<script src="vendor/bootstrap/js/bootstrap.min.js"></script>

</body>
</html>
<!-- DOCTOR LOGIN -->

<?php
session_start();
include("include/config.php");
error_reporting(0);

if(isset($_POST['submit']))
{
    $uname = $_POST['username'];
    $dpassword = md5($_POST['password']);	

    $ret = mysqli_query($con,"SELECT * FROM doctors WHERE docEmail='$uname' and password='$dpassword'");
    $num = mysqli_fetch_array($ret);

    if($num > 0)
    {
        $_SESSION['dlogin'] = $_POST['username'];
        $_SESSION['id']     = $num['id'];

        $uid = $num['id'];
        $uip = $_SERVER['REMOTE_ADDR'];
        $status = 1;

        mysqli_query($con,"INSERT INTO doctorslog(uid,username,userip,status) VALUES('$uid','$uname','$uip','$status')");

        header("location:dashboard.php");
        exit();
    }
    else
    {
        $_SESSION['errmsg'] = "Invalid username or password";

        $uip = $_SERVER['REMOTE_ADDR'];
        $status = 0;

        mysqli_query($con,"INSERT INTO doctorslog(username,userip,status) VALUES('$uname','$uip','$status')");

        header("location:index.php");
        exit();
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
<title>Doctor Login</title>

<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1">

<link rel="stylesheet" href="vendor/bootstrap/css/bootstrap.min.css">
<link rel="stylesheet" href="vendor/fontawesome/css/font-awesome.min.css">

<link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600&display=swap" rel="stylesheet">

<style>
body.login {
    margin: 0;
    font-family: 'Poppins', sans-serif;
    background: linear-gradient(135deg, #667eea 0%, #6f7be8 25%, #7a74e6 50%, #846be3 75%, #764ba2 100%);
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
}

.logo h2 {
    text-align: center;
    color: #fff;
    font-weight: 600;
}

.login-title {
    text-align: center;
    font-weight: 700;
    font-size: 26px;
    margin-bottom: 20px;
    color: #222;
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

.btn-primary {
    width: 100%;
    border-radius: 8px;
    padding: 12px;
    background: #667eea;
    border: none;
}

.btn-primary:hover {
    background: #5a67d8;
}

.error-box {
    background: #ffe5e5;
    color: #d00000;
    padding: 10px;
    border-radius: 6px;
    text-align: center;
    margin-bottom: 15px;
}

a {
    color: #667eea;
}

.new-account {
    text-align: center;
    margin-top: 15px;
}
</style>
</head>

<body class="login">

<div class="row">
    <div class="main-login col-xs-10 col-xs-offset-1 col-sm-6 col-sm-offset-3 col-md-4 col-md-offset-4">

        <div class="logo margin-top-30">
            <a href="/hdmis/index.php"><h2>HMS | Doctor Login</h2></a>
        </div>

        <div class="box-login">

            <?php
            if(isset($_SESSION['errmsg']) && $_SESSION['errmsg'] != "") {
                echo '<div class="error-box">'.$_SESSION['errmsg'].'</div>';
                $_SESSION['errmsg'] = "";
            }
            ?>

            <form method="post">
                <fieldset>

                    <h2 class="login-title"> Sign In</h2>

                    <div class="form-group">
                        <span class="input-icon">
                            <input type="email" class="form-control" name="username" placeholder="Email" required>
                            <i class="fa fa-envelope"></i>
                        </span>
                    </div>

                    <div class="form-group">
                        <span class="input-icon">
                            <input type="password" class="form-control" name="password" placeholder="Password" required>
                            <i class="fa fa-lock"></i>
                        </span>
                        <div style="text-align:right; margin-top:5px;">
                            <a href="forgot-password.php">Forgot Password?</a>
                        </div>
                    </div>

                    <div class="form-actions">
                        <button type="submit" class="btn btn-primary" name="submit">
                            Login
                        </button>
                    </div>

                    <div class="new-account">
                        <!-- FIXED LINK -->
                        <a href="/hdmis/index.php">Back to Home</a>
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
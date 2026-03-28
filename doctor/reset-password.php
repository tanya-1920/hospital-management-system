<!-- DOCTOR RESET PASSWORD -->


<?php
session_start();
include("include/config.php");

if(isset($_POST['change']))
{
    $cno   = $_SESSION['cnumber'];
    $email = $_SESSION['email'];
    $newpassword = md5($_POST['password']);

    $query = mysqli_query($con,"UPDATE doctors SET password='$newpassword' WHERE contactno='$cno' AND docEmail='$email'");
    
    if ($query) {
        $_SESSION['success'] = "Password successfully updated";
        header("location:index.php");
        exit();
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
<title>Reset Password</title>

<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1">

<link rel="stylesheet" href="vendor/bootstrap/css/bootstrap.min.css">
<link rel="stylesheet" href="vendor/fontawesome/css/font-awesome.min.css">
<link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600&display=swap" rel="stylesheet">

<style>

/* ===== BODY ===== */
body.login {
    margin: 0;
    font-family: 'Poppins', sans-serif;
    background: linear-gradient(135deg,#667eea,#764ba2);
    height: 100vh;
}

/* ===== CENTER ===== */
.main-login {
    margin-top: 8%;
}

/* ===== CARD ===== */
.box-login {
    background: #fff;
    padding: 35px 30px;
    border-radius: 12px;
    box-shadow: 0 20px 50px rgba(0,0,0,0.15);
}

/* ===== HEADER ===== */
.logo h2 {
    text-align: center;
    color: #fff;
    font-weight: 600;
}

/* ===== TITLE ===== */
.login-title {
    text-align: center;
    font-weight: 700;
    font-size: 26px;
    margin-bottom: 20px;
}

/* ===== INPUT ===== */
.form-control {
    border-radius: 8px;
    padding: 12px;
    border: 1px solid #ddd;
}

.form-control:focus {
    border-color: #667eea;
    box-shadow: 0 0 0 2px rgba(102,126,234,0.2);
}

/* ===== ICON ===== */
.input-icon {
    position: relative;
}

.input-icon i {
    position: absolute;
    right: 12px;
    top: 12px;
    color: #888;
}

/* ===== BUTTON ===== */
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

/* ===== MESSAGE ===== */
.msg-box {
    background: #e6ffed;
    color: #007e33;
    padding: 10px;
    border-radius: 6px;
    text-align: center;
    margin-bottom: 15px;
}

.error-box {
    background: #ffe5e5;
    color: #d00000;
    padding: 10px;
    border-radius: 6px;
    text-align: center;
    margin-bottom: 15px;
}

.new-account {
    text-align: center;
    margin-top: 15px;
}

</style>

<script>
function valid(){
    var p = document.getElementById("password").value;
    var cp = document.getElementById("password_again").value;

    if(p !== cp){
        alert("Passwords do not match");
        return false;
    }
    return true;
}
</script>

</head>

<body class="login">

<div class="row">
    <div class="main-login col-xs-10 col-xs-offset-1 col-sm-6 col-sm-offset-3 col-md-4 col-md-offset-4">

        <div class="logo margin-top-30">
            <a href="../index.php"><h2>HMS | Reset Password</h2></a>
        </div>

        <div class="box-login">

            <!-- SUCCESS -->
            <?php
            if(isset($_SESSION['success'])){
                echo '<div class="msg-box">'.$_SESSION['success'].'</div>';
                unset($_SESSION['success']);
            }
            ?>

            <!-- ERROR -->
            <?php
            if(isset($_SESSION['errmsg'])){
                echo '<div class="error-box">'.$_SESSION['errmsg'].'</div>';
                unset($_SESSION['errmsg']);
            }
            ?>

            <form method="post" onsubmit="return valid();">
                <fieldset>

                    <h2 class="login-title">Set New Password</h2>

                    <div class="form-group">
                        <span class="input-icon">
                            <input type="password" id="password" name="password" class="form-control" placeholder="New Password" required>
                            <i class="fa fa-lock"></i>
                        </span>
                    </div>

                    <div class="form-group">
                        <span class="input-icon">
                            <input type="password" id="password_again" name="password_again" class="form-control" placeholder="Confirm Password" required>
                            <i class="fa fa-lock"></i>
                        </span>
                    </div>

                    <div class="form-actions">
                        <button type="submit" name="change" class="btn btn-primary">
                            Change Password
                        </button>
                    </div>

                    <div class="new-account">
                        Already have an account? <a href="index.php">Login</a>
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
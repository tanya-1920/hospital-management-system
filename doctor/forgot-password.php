<!-- DOCTOR FORGOT PASSWORD -->

<?php
session_start();
error_reporting(0);
include("include/config.php");

if(isset($_POST['submit'])){
    $contactno = $_POST['contactno'];
    $email     = $_POST['email'];

    $query = mysqli_query($con,"SELECT id FROM doctors WHERE contactno='$contactno' AND docEmail='$email'");
    $row = mysqli_num_rows($query);

    if($row > 0){
        $_SESSION['cnumber'] = $contactno;
        $_SESSION['email']   = $email;
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
<title>Forgot Password</title>

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

/* ===== ERROR ===== */
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
</head>

<body class="login">

<div class="row">
    <div class="main-login col-xs-10 col-xs-offset-1 col-sm-6 col-sm-offset-3 col-md-4 col-md-offset-4">

        <div class="logo margin-top-30">
            <a href="../index.php"><h2>HMS | Password Recovery</h2></a>
        </div>

        <div class="box-login">

            <!-- ERROR -->
            <?php
            if(isset($_SESSION['errmsg']) && $_SESSION['errmsg'] != "") {
                echo '<div class="error-box">'.$_SESSION['errmsg'].'</div>';
                $_SESSION['errmsg'] = "";
            }
            ?>

            <form method="post">
                <fieldset>

                    <h2 class="login-title">Recover Password</h2>

                    <div class="form-group">
                        <span class="input-icon">
                            <input type="text" class="form-control" name="contactno" placeholder="Registered Contact Number" required>
                            <i class="fa fa-phone"></i>
                        </span>
                    </div>

                    <div class="form-group">
                        <span class="input-icon">
                            <input type="email" class="form-control" name="email" placeholder="Registered Email" required>
                            <i class="fa fa-envelope"></i>
                        </span>
                    </div>

                    <div class="form-actions">
                        <button type="submit" name="submit" class="btn btn-primary">
                            Verify & Reset
                        </button>
                    </div>

                    <div class="new-account">
                        Remember password? <a href="index.php">Login</a>
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
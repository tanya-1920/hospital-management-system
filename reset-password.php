<!-- USER RESET PASSWORD -->

<?php
session_start();
include("include/config.php");

// Messages
$errmsg = "";
$successmsg = "";

// Handle form submission
if(isset($_POST['change']))
{
    $name = $_SESSION['name'] ?? '';
    $email = $_SESSION['email'] ?? '';
    $password = $_POST['password'] ?? '';
    $confirm = $_POST['password_again'] ?? '';

    if($password !== $confirm){
        $errmsg = "Passwords do not match!";
    } else {
        // Secure password hashing
        $newpassword = password_hash($password, PASSWORD_DEFAULT);

        $query = mysqli_query($con,"UPDATE users SET password='$newpassword' WHERE fullName='$name' AND email='$email'");

        if($query){
            $successmsg = "Password updated successfully. Redirecting...";
            header("refresh:2;url=user-login.php");
        } else {
            $errmsg = "Something went wrong. Please try again!";
        }
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <title>Password Reset</title>

    <link href="http://fonts.googleapis.com/css?family=Lato:300,400,600|Raleway:300,400,600" rel="stylesheet">
    <link rel="stylesheet" href="vendor/bootstrap/css/bootstrap.min.css">
    <link rel="stylesheet" href="vendor/fontawesome/css/font-awesome.min.css">

    <style>
        body {
            background: linear-gradient(135deg, #667eea, #764ba2);
            height: 100vh;
        }
        .login-box {
            background: #fff;
            padding: 30px;
            border-radius: 12px;
            margin-top: 80px;
            box-shadow: 0 10px 25px rgba(0,0,0,0.2);
        }
        .input-icon {
            position: relative;
        }
        .input-icon i {
            position: absolute;
            right: 10px;
            top: 10px;
            cursor: pointer;
            color: #888;
        }
        .strength {
            font-size: 12px;
        }
    </style>

<script>
function validateForm(){
    let p = document.getElementById("password").value;
    let c = document.getElementById("password_again").value;

    if(p !== c){
        alert("Passwords do not match!");
        return false;
    }
    return true;
}

function togglePassword(id, icon){
    let field = document.getElementById(id);
    if(field.type === "password"){
        field.type = "text";
        icon.classList.replace("fa-eye","fa-eye-slash");
    } else {
        field.type = "password";
        icon.classList.replace("fa-eye-slash","fa-eye");
    }
}

// Password strength checker
function checkStrength(){
    let val = document.getElementById("password").value;
    let msg = document.getElementById("strengthMsg");

    if(val.length < 6){
        msg.innerHTML = "Weak";
        msg.style.color = "red";
    } else if(val.match(/[A-Z]/) && val.match(/[0-9]/)){
        msg.innerHTML = "Strong";
        msg.style.color = "green";
    } else {
        msg.innerHTML = "Medium";
        msg.style.color = "orange";
    }
}
</script>

</head>

<body>

<div class="container">
    <div class="row">
        <div class="col-md-4 col-md-offset-4">
            
            <div class="login-box">
                <h3 class="text-center">HMS | Reset Password</h3>

                <p class="text-center">
                    Please set your new password<br>

                    <?php if($errmsg): ?>
                        <span style="color:red;"><?php echo $errmsg; ?></span>
                    <?php endif; ?>

                    <?php if($successmsg): ?>
                        <span style="color:green;"><?php echo $successmsg; ?></span>
                    <?php endif; ?>
                </p>

                <form method="post" onsubmit="return validateForm();">

                    <div class="form-group input-icon">
                        <input type="password" name="password" id="password" class="form-control" placeholder="New Password" onkeyup="checkStrength()" required>
                        <i class="fa fa-eye" onclick="togglePassword('password', this)"></i>
                    </div>

                    <div class="strength" id="strengthMsg"></div>

                    <div class="form-group input-icon">
                        <input type="password" name="password_again" id="password_again" class="form-control" placeholder="Confirm Password" required>
                        <i class="fa fa-eye" onclick="togglePassword('password_again', this)"></i>
                    </div>

                    <button type="submit" name="change" class="btn btn-primary btn-block">
                        Change Password
                    </button>

                </form>

                <br>
                <div class="text-center">
                    <a href="user-login.php">Back to Login</a>
                </div>

            </div>

        </div>
    </div>
</div>

<script src="vendor/jquery/jquery.min.js"></script>
<script src="vendor/bootstrap/js/bootstrap.min.js"></script>

</body>
</html>
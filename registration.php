<!-- USER REGISTRATION -->
 
<?php 
session_start();
error_reporting(0);
include_once('include/config.php');

if(isset($_POST['submit']))
{
$fname=$_POST['full_name'];
$address=$_POST['address'];
$city=$_POST['city'];
$gender=$_POST['gender'];
$email=$_POST['email'];
$password=md5($_POST['password']);

$query=mysqli_query($con,"insert into users(fullname,address,city,gender,email,password) values('$fname','$address','$city','$gender','$email','$password')");

if($query)
{
    $_SESSION['success'] = "Successfully Registered. You can login now";
}
else {
    $_SESSION['errmsg'] = "Something went wrong";
}
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
<title>User Registration</title>

<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1">

<link rel="stylesheet" href="vendor/bootstrap/css/bootstrap.min.css">
<link rel="stylesheet" href="vendor/fontawesome/css/font-awesome.min.css">

<link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600&display=swap" rel="stylesheet">

<style>

/* SAME LOGIN UI */
body.login {
    margin: 0;
    font-family: 'Poppins', sans-serif;
    background: linear-gradient(135deg, #667eea, #764ba2);
    height: 100vh;
}

.main-login {
    margin-top: 4%;
}

.box-login {
    background: #fff;
    padding: 35px;
    border-radius: 12px;
    box-shadow: 0 20px 50px rgba(0,0,0,0.15);
    animation: fadeIn 0.6s ease-in-out;
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
}

.form-control {
    border-radius: 8px;
    padding: 12px;
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

.success-box {
    background: #e6ffed;
    color: #008a2e;
    padding: 10px;
    border-radius: 6px;
    text-align: center;
    margin-bottom: 15px;
}

.gender-box {
    margin-bottom: 15px;
}

.gender-box label {
    margin-right: 15px;
}

@keyframes fadeIn {
    from { opacity: 0; transform: translateY(25px); }
    to { opacity: 1; transform: translateY(0); }
}

</style>

<script>
function valid()
{
 if(document.registration.password.value!= document.registration.password_again.value)
{
alert("Password and Confirm Password do not match!");
return false;
}
return true;
}

function userAvailability() {
jQuery.ajax({
url: "check_availability.php",
data:'email='+$("#email").val(),
type: "POST",
success:function(data){
$("#user-availability-status1").html(data);
}
});
}
</script>

</head>

<body class="login">

<div class="row">
<div class="main-login col-xs-10 col-sm-6 col-md-4 col-xs-offset-1 col-sm-offset-3 col-md-offset-4">

    <div class="logo margin-top-30">
        <h2>HMS | Patient Registration</h2>
    </div>

    <div class="box-login">

        <!-- ALERTS -->
        <?php
        if(isset($_SESSION['errmsg'])) {
            echo '<div class="error-box">'.$_SESSION['errmsg'].'</div>';
            unset($_SESSION['errmsg']);
        }
        if(isset($_SESSION['success'])) {
            echo '<div class="success-box">'.$_SESSION['success'].'</div>';
            unset($_SESSION['success']);
        }
        ?>

        <form name="registration" method="post" onsubmit="return valid();">

            <h2 class="login-title">Create Account</h2>

            <div class="form-group input-icon">
                <input type="text" name="full_name" class="form-control" placeholder="Full Name" required>
                <i class="fa fa-user"></i>
            </div>

            <div class="form-group input-icon">
                <input type="text" name="address" class="form-control" placeholder="Address" required>
                <i class="fa fa-map-marker"></i>
            </div>

            <div class="form-group input-icon">
                <input type="text" name="city" class="form-control" placeholder="City" required>
                <i class="fa fa-building"></i>
            </div>

            <div class="gender-box">
                <label><b>Gender:</b></label><br>
                <label><input type="radio" name="gender" value="female"> Female</label>
                <label><input type="radio" name="gender" value="male"> Male</label>
            </div>

            <div class="form-group input-icon">
                <input type="email" name="email" id="email" class="form-control" onBlur="userAvailability()" placeholder="Email" required>
                <i class="fa fa-envelope"></i>
            </div>

            <span id="user-availability-status1" style="font-size:12px;"></span>

            <div class="form-group input-icon">
                <input type="password" name="password" class="form-control" placeholder="Password" required>
                <i class="fa fa-lock"></i>
            </div>

            <div class="form-group input-icon">
                <input type="password" name="password_again" class="form-control" placeholder="Confirm Password" required>
                <i class="fa fa-lock"></i>
            </div>

            <button type="submit" name="submit" class="btn btn-primary">
                Register
            </button>

            <div style="text-align:center; margin-top:15px;">
                Already have an account? 
                <a href="user-login.php">Login</a>
            </div>

        </form>

    </div>
</div>
</div>

<script src="vendor/jquery/jquery.min.js"></script>
<script src="vendor/bootstrap/js/bootstrap.min.js"></script>

</body>
</html>
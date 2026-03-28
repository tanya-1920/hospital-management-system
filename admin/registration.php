<?php
include_once('include/config.php');

if(isset($_POST['submit']))
{
$fname=$_POST['full_name'];
$address=$_POST['address'];
$city=$_POST['city'];
$gender=$_POST['gender'];
$email=$_POST['email'];
$password=md5($_POST['password']);

$query=mysql_query("insert into users(fullname,address,city,gender,email,password) values('$fname','$address','$city','$gender','$email','$password')");

if($query)
{
	echo "<script>alert('Successfully Registered. You can login now');</script>";
}
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
<title>User Registration</title>

<link rel="stylesheet" href="vendor/bootstrap/css/bootstrap.min.css">
<link rel="stylesheet" href="vendor/fontawesome/css/font-awesome.min.css">

<style>

/* CENTER PAGE */
body {
    background: #f5f7fb;
}

/* CARD */
.register-card {
    max-width: 420px;
    margin: 60px auto;
    background: #fff;
    padding: 30px 25px;
    border-radius: 12px;
    box-shadow: 0 4px 15px rgba(0,0,0,0.08);
}

/* TITLE */
.register-title {
    font-size: 24px;
    font-weight: 600;
    margin-bottom: 5px;
}

/* SUBTEXT */
.register-sub {
    color: #6b7280;
    font-size: 14px;
    margin-bottom: 20px;
}

/* INPUT */
.form-control {
    border-radius: 6px;
    height: 42px;
}

/* BUTTON */
.btn-primary {
    background: #2563eb;
    border: none;
    border-radius: 6px;
    height: 42px;
    font-weight: 500;
}

/* LINK */
.login-link {
    font-size: 14px;
    text-align: center;
}

/* RADIO */
.gender-box {
    display: flex;
    gap: 20px;
    margin-top: 5px;
}

/* PASSWORD TOGGLE */
.password-box {
    position: relative;
}

.toggle-eye {
    position: absolute;
    right: 10px;
    top: 10px;
    cursor: pointer;
    color: #666;
}

</style>

</head>

<body>

<div class="register-card">

<div class="register-title">Create Account</div>
<div class="register-sub">Enter your details below</div>

<form method="post" onsubmit="return validatePassword()">

<div class="form-group">
<input type="text" class="form-control" name="full_name" placeholder="Full Name" required>
</div>

<div class="form-group">
<input type="text" class="form-control" name="address" placeholder="Address" required>
</div>

<div class="form-group">
<input type="text" class="form-control" name="city" placeholder="City" required>
</div>

<div class="form-group">
<label>Gender</label>
<div class="gender-box">
<label><input type="radio" name="gender" value="female" required> Female</label>
<label><input type="radio" name="gender" value="male"> Male</label>
</div>
</div>

<div class="form-group">
<input type="email" class="form-control" name="email" id="email" onBlur="userAvailability()" placeholder="Email" required>
<span id="user-availability-status1" style="font-size:12px;"></span>
</div>

<div class="form-group password-box">
<input type="password" class="form-control" id="password" name="password" placeholder="Password" required>
<i class="fa fa-eye toggle-eye" onclick="togglePassword('password', this)"></i>
</div>

<div class="form-group password-box">
<input type="password" class="form-control" id="confirm_password" name="password_again" placeholder="Confirm Password" required>
<i class="fa fa-eye toggle-eye" onclick="togglePassword('confirm_password', this)"></i>
</div>

<div class="form-group">
<label>
<input type="checkbox" required> I agree
</label>
</div>

<button type="submit" class="btn btn-primary btn-block" name="submit">
Register
</button>

<br>

<div class="login-link">
Already have an account? <a href="user-login.php">Login</a>
</div>

</form>

</div>

<script src="vendor/jquery/jquery.min.js"></script>
<script src="vendor/bootstrap/js/bootstrap.min.js"></script>

<script>
// EMAIL CHECK
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

// PASSWORD MATCH VALIDATION
function validatePassword() {
var pass = document.getElementById("password").value;
var confirm = document.getElementById("confirm_password").value;

if(pass !== confirm) {
alert("Passwords do not match!");
return false;
}
return true;
}

// SHOW/HIDE PASSWORD
function togglePassword(id, icon) {
var input = document.getElementById(id);
if(input.type === "password") {
input.type = "text";
icon.classList.remove("fa-eye");
icon.classList.add("fa-eye-slash");
} else {
input.type = "password";
icon.classList.remove("fa-eye-slash");
icon.classList.add("fa-eye");
}
}
</script>

</body>
</html>
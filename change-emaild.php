<!-- USER CHANGE EMAIL -->

<?php
session_start();
include('include/config.php');
include('include/checklogin.php');
check_login();

if(isset($_POST['submit']))
{
    $email=$_POST['email'];
    $sql=mysqli_query($con,"UPDATE users SET email='$email' WHERE id='".$_SESSION['id']."'");
    if($sql){
        $msg="Your email updated Successfully";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>

<title>User | Edit Profile</title>

<link rel="stylesheet" href="vendor/bootstrap/css/bootstrap.min.css">
<link rel="stylesheet" href="vendor/fontawesome/css/font-awesome.min.css">

<style>

/* REMOVE SHIFT */
.main-content {
    margin-left: 0 !important;
}

/* CENTER */
.wrap-content {
    max-width: 600px;
    margin: auto;
    padding: 30px 20px;
}

/* PANEL */
.panel {
    border-radius: 12px;
    box-shadow: 0 4px 12px rgba(0,0,0,0.08);
}

/* TITLE */
.page-title {
    display: flex;
    align-items: center;
    gap: 10px;
    font-size: 22px;
    font-weight: 600;
}

/* BACK BUTTON */
.back-btn {
    font-size: 20px;
    color: #2563eb;
    text-decoration: none;
    transition: 0.3s;
}

.back-btn:hover {
    transform: translateX(-5px);
}

/* BUTTON */
.btn-primary {
    background: #2563eb;
    border: none;
    border-radius: 8px;
}

</style>

</head>

<body>

<div id="app">

<?php include('include/sidebar.php'); ?>
<?php include('include/header.php'); ?>

<div class="main-content">

<div class="wrap-content">

<!-- TITLE + BACK -->
<div class="page-title">
    <a href="edit-profile.php" class="back-btn" title="Go to Dashboard">
        <i class="fa fa-arrow-left"></i>
    </a>
    Change Email
</div>

<br>

<div class="panel panel-white">
<div class="panel-heading">
<h4>Edit Profile</h4>
</div>

<div class="panel-body">

<h5 style="color: green;">
<?php if($msg){ echo htmlentities($msg);} ?>
</h5>

<form method="post">

<div class="form-group">
<label>User Email</label>
<input type="email" class="form-control" name="email" id="email" onBlur="userAvailability()" required>

<span id="user-availability-status1" style="font-size:12px;"></span>
</div>

<button type="submit" name="submit" class="btn btn-primary">
Update
</button>

</form>

</div>
</div>

</div>
</div>

<?php include('include/footer.php'); ?>
<?php include('include/setting.php'); ?>

</div>

<script src="vendor/jquery/jquery.min.js"></script>
<script src="vendor/bootstrap/js/bootstrap.min.js"></script>

<script>
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

</body>
</html>

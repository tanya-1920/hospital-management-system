<?php
session_start();
include('include/config.php');

if(strlen($_SESSION['id']==0)) {
    header('location:logout.php');
} else {

date_default_timezone_set('Asia/Kolkata');
$currentTime = date('d-m-Y h:i:s A', time());

if(isset($_POST['submit']))
{
    $cpass = $_POST['cpass'];	
    $uname = $_SESSION['login'];

    $sql = mysqli_query($con,"SELECT password FROM admin WHERE password='$cpass' && username='$uname'");
    $num = mysqli_fetch_array($sql);

    if($num > 0)
    {
        $npass = $_POST['npass'];
        mysqli_query($con,"UPDATE admin SET password='$npass', updationDate='$currentTime' WHERE username='$uname'");
        $_SESSION['msg1'] = "Password Changed Successfully";
    }
    else
    {
        $_SESSION['msg1'] = "Old Password not match";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>

<title>Admin | Change Password</title>

<link rel="stylesheet" href="vendor/bootstrap/css/bootstrap.min.css">
<link rel="stylesheet" href="vendor/fontawesome/css/font-awesome.min.css">
<link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600&display=swap" rel="stylesheet">

<style>

/* REMOVE SHIFT */
.main-content {
    margin-left: 0 !important;
}

/* CENTER */
.wrap-content {
    max-width: 500px;
    margin: auto;
    padding: 40px 20px;
}

/* TITLE */
.page-title {
    display: flex;
    align-items: center;
    gap: 10px;
}

/* BACK BUTTON */
.back-btn {
    font-size: 18px;
    color: #667eea;
    text-decoration: none;
}
.back-btn:hover {
    transform: translateX(-4px);
}

/* CARD */
.panel {
    border-radius: 12px;
    border: none;
    box-shadow: 0 15px 40px rgba(0,0,0,0.08);
    overflow: hidden;
}

.panel-heading {
    background: #f9fafb;
    border-bottom: 1px solid #eee;
    padding: 15px;
}

.panel-heading h4 {
    margin: 0;
    font-weight: 600;
}

/* INPUT */
.form-control {
    border-radius: 8px;
    padding: 12px;
    border: 1px solid #ddd;
}

.form-control:focus {
    border-color: #667eea;
    box-shadow: 0 0 0 2px rgba(102,126,234,0.15);
}

/* BUTTON */
.btn-primary {
    width: 100%;
    background: #667eea;
    border: none;
    border-radius: 8px;
    padding: 12px;
    font-weight: 500;
}

.btn-primary:hover {
    background: #5a67d8;
}

/* MESSAGE */
.msg-box {
    padding: 10px;
    border-radius: 6px;
    margin-bottom: 15px;
    text-align: center;
    font-size: 14px;
}

.success {
    background: #e6ffed;
    color: #007e33;
}

.error {
    background: #ffe5e5;
    color: #d00000;
}

</style>

<script>
function valid()
{
    var c = document.chngpwd.cpass.value;
    var n = document.chngpwd.npass.value;
    var cf = document.chngpwd.cfpass.value;

    if(!c || !n || !cf){
        alert("All fields are required");
        return false;
    }

    if(n !== cf){
        alert("Passwords do not match");
        return false;
    }

    return true;
}
</script>

</head>

<body>

<div id="app">

<?php include('include/sidebar.php'); ?>
<?php include('include/header.php'); ?>

<div class="main-content">
<div class="wrap-content">

<!-- TITLE -->
<div class="page-title">
    <a href="dashboard.php" class="back-btn">
        <i class="fa fa-arrow-left"></i>
    </a>
    <h2 style="margin:0;">Change Password</h2>
</div>

<br>

<div class="panel panel-white">

<div class="panel-heading">
<h4>Update Password</h4>
</div>

<div class="panel-body" style="padding:20px;">

<!-- MESSAGE -->
<?php if($_SESSION['msg1']){ ?>
<div class="msg-box <?php echo (strpos($_SESSION['msg1'],'Successfully')!==false)?'success':'error'; ?>">
    <?php echo $_SESSION['msg1']; ?>
</div>
<?php $_SESSION['msg1']=""; } ?>

<form name="chngpwd" method="post" onsubmit="return valid();">

<div class="form-group">
<label>Current Password</label>
<input type="password" name="cpass" class="form-control" placeholder="Enter current password">
</div>

<div class="form-group">
<label>New Password</label>
<input type="password" name="npass" class="form-control" placeholder="Enter new password">
</div>

<div class="form-group">
<label>Confirm Password</label>
<input type="password" name="cfpass" class="form-control" placeholder="Confirm password">
</div>

<button type="submit" name="submit" class="btn btn-primary">
Update Password
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

</body>
</html>
<?php } ?>

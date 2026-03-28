<!-- DOCTOR ADD PATIENT -->

<?php
session_start();
error_reporting(0);
include('include/config.php');

if(strlen($_SESSION['id']==0)) {
    header('location:logout.php');
} else {

if(isset($_POST['submit']))
{	
	$docid=$_SESSION['id'];
	$patname=$_POST['patname'];
	$patcontact=$_POST['patcontact'];
	$patemail=$_POST['patemail'];
	$gender=$_POST['gender'];
	$pataddress=$_POST['pataddress'];
	$patage=$_POST['patage'];
	$medhis=$_POST['medhis'];

	$sql=mysqli_query($con,"insert into tblpatient(Docid,PatientName,PatientContno,PatientEmail,PatientGender,PatientAdd,PatientAge,PatientMedhis) values('$docid','$patname','$patcontact','$patemail','$gender','$pataddress','$patage','$medhis')");

	if($sql)
	{
		$_SESSION['msg'] = "Patient info added successfully";
		echo "<script>window.location.href ='manage-patient.php'</script>";
	}
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
<title>Doctor | Add Patient</title>

<link rel="stylesheet" href="vendor/bootstrap/css/bootstrap.min.css">
<link rel="stylesheet" href="vendor/fontawesome/css/font-awesome.min.css">

<style>

/* FIX SHIFT */
.main-content {
    margin-left: 0 !important;
}

/* WRAP */
.wrap-content {
    max-width: 900px;
    margin: auto;
    padding: 30px 20px;
}

/* PANEL */
.panel {
    border-radius: 12px;
    box-shadow: 0 4px 12px rgba(0,0,0,0.08);
    background: #fff;
}

/* HEADER */
.page-header-custom {
    display: flex;
    align-items: center;
    justify-content: space-between;
    margin-bottom: 15px;
}

/* TITLE */
.page-title {
    display: flex;
    align-items: center;
    gap: 10px;
    font-size: 24px;
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

/* FORM */
.form-group {
    margin-bottom: 15px;
}

label {
    font-weight: 500;
}

/* BUTTON */
.btn-primary {
    background: #2563eb;
    border: none;
    border-radius: 6px;
}

.btn-primary:hover {
    background: #1e4fd1;
}

/* MESSAGE */
.custom-msg {
    color: green;
    margin-bottom: 10px;
}

</style>

<script>
function userAvailability() {
$("#loaderIcon").show();
jQuery.ajax({
url: "check_availability.php",
data:'email='+$("#patemail").val(),
type: "POST",
success:function(data){
$("#user-availability-status1").html(data);
$("#loaderIcon").hide();
}
});
}
</script>

</head>

<body>

<div id="app">

<?php include('include/sidebar.php'); ?>
<?php include('include/header.php'); ?>

<div class="main-content">
<div class="wrap-content">

<!-- HEADER -->
<div class="page-header-custom">
    <div class="page-title">
        <a href="dashboard.php" class="back-btn">
            <i class="fa fa-arrow-left"></i>
        </a>
        Add Patient
    </div>
</div>

<!-- PANEL -->
<div class="panel panel-white">
<div class="panel-body">

<p class="custom-msg">
<?php 
if(isset($_SESSION['msg'])) {
    echo htmlentities($_SESSION['msg']);
    $_SESSION['msg']="";
}
?>
</p>

<form method="post">

<div class="form-group">
<label>Patient Name</label>
<input type="text" name="patname" class="form-control" placeholder="Enter Patient Name" required>
</div>

<div class="form-group">
<label>Patient Contact No</label>
<input type="text" name="patcontact" class="form-control" placeholder="Enter Contact Number" required maxlength="10" pattern="[0-9]+">
</div>

<div class="form-group">
<label>Patient Email</label>
<input type="email" id="patemail" name="patemail" class="form-control" placeholder="Enter Email" required onBlur="userAvailability()">
<span id="user-availability-status1" style="font-size:12px;"></span>
</div>

<div class="form-group">
<label>Gender</label><br>
<label><input type="radio" name="gender" value="female"> Female</label>
<label style="margin-left:15px;"><input type="radio" name="gender" value="male"> Male</label>
</div>

<div class="form-group">
<label>Patient Address</label>
<textarea name="pataddress" class="form-control" placeholder="Enter Address" required></textarea>
</div>

<div class="form-group">
<label>Patient Age</label>
<input type="text" name="patage" class="form-control" placeholder="Enter Age" required>
</div>

<div class="form-group">
<label>Medical History</label>
<textarea name="medhis" class="form-control" placeholder="Enter Medical History" required></textarea>
</div>

<button type="submit" name="submit" class="btn btn-primary">
Add Patient
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

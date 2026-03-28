<!-- DOCTOR EDIT PATIENT -->

<?php
session_start();
error_reporting(0);
include('include/config.php');

if(strlen($_SESSION['id']==0)) {
 header('location:logout.php');
} else {

if(isset($_POST['submit']))
{	
	$eid=$_GET['editid'];
	$patname=$_POST['patname'];
	$patcontact=$_POST['patcontact'];
	$patemail=$_POST['patemail'];
	$gender=$_POST['gender'];
	$pataddress=$_POST['pataddress'];
	$patage=$_POST['patage'];
	$medhis=$_POST['medhis'];

	$sql=mysqli_query($con,"update tblpatient set PatientName='$patname',PatientContno='$patcontact',PatientEmail='$patemail',PatientGender='$gender',PatientAdd='$pataddress',PatientAge='$patage',PatientMedhis='$medhis' where ID='$eid'");

	if($sql)
	{
		echo "<script>alert('Patient info updated Successfully');</script>";
		header('location:manage-patient.php');
	}
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
<title>Doctor | Edit Patient</title>

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

/* BACK */
.back-btn {
    font-size: 20px;
    color: #2563eb;
    text-decoration: none;
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

</style>

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
        <a href="manage-patient.php" class="back-btn">
            <i class="fa fa-arrow-left"></i>
        </a>
        Edit Patient
    </div>
</div>

<!-- PANEL -->
<div class="panel panel-white">
<div class="panel-body">

<form method="post">

<?php
$eid=$_GET['editid'];
$ret=mysqli_query($con,"select * from tblpatient where ID='$eid'");
while ($row=mysqli_fetch_array($ret)) {
?>

<div class="form-group">
<label>Patient Name</label>
<input type="text" name="patname" class="form-control" value="<?php echo $row['PatientName'];?>" required>
</div>

<div class="form-group">
<label>Patient Contact No</label>
<input type="text" name="patcontact" class="form-control" value="<?php echo $row['PatientContno'];?>" required maxlength="10" pattern="[0-9]+">
</div>

<div class="form-group">
<label>Patient Email</label>
<input type="email" name="patemail" class="form-control" value="<?php echo $row['PatientEmail'];?>" readonly>
</div>

<div class="form-group">
<label>Gender</label><br>

<?php if($row['PatientGender']=="Female"){ ?>
<label><input type="radio" name="gender" value="Female" checked> Female</label>
<label style="margin-left:15px;"><input type="radio" name="gender" value="Male"> Male</label>
<?php } else { ?>
<label><input type="radio" name="gender" value="Male" checked> Male</label>
<label style="margin-left:15px;"><input type="radio" name="gender" value="Female"> Female</label>
<?php } ?>

</div>

<div class="form-group">
<label>Patient Address</label>
<textarea name="pataddress" class="form-control" required><?php echo $row['PatientAdd'];?></textarea>
</div>

<div class="form-group">
<label>Patient Age</label>
<input type="text" name="patage" class="form-control" value="<?php echo $row['PatientAge'];?>" required>
</div>

<div class="form-group">
<label>Medical History</label>
<textarea name="medhis" class="form-control" required><?php echo $row['PatientMedhis'];?></textarea>
</div>

<div class="form-group">
<label>Creation Date</label>
<input type="text" class="form-control" value="<?php echo $row['CreationDate'];?>" readonly>
</div>

<?php } ?>

<button type="submit" name="submit" class="btn btn-primary">
Update Patient
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

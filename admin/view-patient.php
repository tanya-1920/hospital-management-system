<?php
session_start();
error_reporting(0);
include('include/config.php');

if(strlen($_SESSION['id']==0)) {
 header('location:logout.php');
} else {

if(isset($_POST['submit']))
{
$vid=$_GET['viewid'];
$bp=$_POST['bp'];
$bs=$_POST['bs'];
$weight=$_POST['weight'];
$temp=$_POST['temp'];
$pres=$_POST['pres'];

$query.=mysqli_query($con, "insert tblmedicalhistory(PatientID,BloodPressure,BloodSugar,Weight,Temperature,MedicalPres)value('$vid','$bp','$bs','$weight','$temp','$pres')");

if ($query) {
echo '<script>alert("Medicle history has been added.")</script>';
echo "<script>window.location.href ='manage-patient.php'</script>";
} else {
echo '<script>alert("Something Went Wrong. Please try again")</script>';
}
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
<title>Doctor | Manage Patients</title>

<link rel="stylesheet" href="vendor/bootstrap/css/bootstrap.min.css">
<link rel="stylesheet" href="vendor/fontawesome/css/font-awesome.min.css">

<style>

/* REMOVE SHIFT */
.main-content { margin-left: 0 !important; }

/* CENTER CONTENT */
.wrap-content {
    max-width: 1100px;
    margin: auto;
    padding: 30px 20px;
}

/* PANEL */
.panel {
    border-radius: 12px;
    box-shadow: 0 4px 12px rgba(0,0,0,0.08);
    margin-bottom: 20px;
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
}

/* TABLE */
.table th {
    width: 25%;
}

/* BUTTON */
.btn-primary {
    background: #2563eb;
    border: none;
    border-radius: 6px;
}

</style>

</head>

<body>

<div id="app">

<?php include('include/sidebar.php'); ?>
<?php include('include/header.php'); ?>

<div class="main-content">
<div class="wrap-content">

<!-- TITLE -->
<div class="page-title">
    <a href="manage-patient.php" class="back-btn">
        <i class="fa fa-arrow-left"></i>
    </a>
    Patient Details
</div>

<br>

<!-- PATIENT DETAILS -->
<div class="panel panel-white">
<div class="panel-body">

<?php
$vid=$_GET['viewid'];
$ret=mysqli_query($con,"select * from tblpatient where ID='$vid'");
while ($row=mysqli_fetch_array($ret)) {
?>

<table class="table table-hover">
<tr><th>Patient Name</th><td><?php echo $row['PatientName'];?></td></tr>
<tr><th>Email</th><td><?php echo $row['PatientEmail'];?></td></tr>
<tr><th>Mobile</th><td><?php echo $row['PatientContno'];?></td></tr>
<tr><th>Address</th><td><?php echo $row['PatientAdd'];?></td></tr>
<tr><th>Gender</th><td><?php echo $row['PatientGender'];?></td></tr>
<tr><th>Age</th><td><?php echo $row['PatientAge'];?></td></tr>
<tr><th>Medical History</th><td><?php echo $row['PatientMedhis'];?></td></tr>
<tr><th>Registered</th><td><?php echo $row['CreationDate'];?></td></tr>
</table>

<?php } ?>

</div>
</div>

<!-- MEDICAL HISTORY -->
<div class="panel panel-white">
<div class="panel-body">

<h4>Medical History</h4>

<div class="table-responsive">

<table class="table table-hover">
<thead>
<tr>
<th>#</th>
<th>Blood Pressure</th>
<th>Weight</th>
<th>Blood Sugar</th>
<th>Temperature</th>
<th>Prescription</th>
<th>Date</th>
</tr>
</thead>

<tbody>

<?php  
$ret=mysqli_query($con,"select * from tblmedicalhistory where PatientID='$vid'");
$cnt=1;

while ($row=mysqli_fetch_array($ret)) { 
?>

<tr>
<td><?php echo $cnt;?></td>
<td><?php echo $row['BloodPressure'];?></td>
<td><?php echo $row['Weight'];?></td>
<td><?php echo $row['BloodSugar'];?></td>
<td><?php echo $row['Temperature'];?></td>
<td><?php echo $row['MedicalPres'];?></td>
<td><?php echo $row['CreationDate'];?></td>
</tr>

<?php $cnt++; } ?>

</tbody>
</table>

</div>
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

<!-- DOCTOR VIEW PATIENT DETAILS -->

<?php
session_start();
error_reporting(0);
include('include/config.php');

if(strlen($_SESSION['id']==0)) {
 header('location:logout.php');
} else {

if(isset($_POST['submit'])) {
    $vid=$_GET['viewid'];
    $bp=$_POST['bp'];
    $bs=$_POST['bs'];
    $weight=$_POST['weight'];
    $temp=$_POST['temp'];
    $pres=$_POST['pres'];

    $query=mysqli_query($con, "insert into tblmedicalhistory(PatientID,BloodPressure,BloodSugar,Weight,Temperature,MedicalPres)
    value('$vid','$bp','$bs','$weight','$temp','$pres')");

    if ($query) {
        echo '<script>alert("Medical history has been added.")</script>';
        echo "<script>window.location.href ='manage-patient.php'</script>";
    } else {
        echo '<script>alert("Something Went Wrong. Please try again")</script>';
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
<title>Doctor | Patient Details</title>

<link rel="stylesheet" href="vendor/bootstrap/css/bootstrap.min.css">
<link rel="stylesheet" href="vendor/fontawesome/css/font-awesome.min.css">

<style>
.main-content { margin-left: 0 !important; }
.wrap-content {
    max-width: 1100px;
    margin: auto;
    padding: 30px 20px;
}
.panel {
    border-radius: 12px;
    box-shadow: 0 4px 12px rgba(0,0,0,0.08);
}
.page-title {
    display: flex;
    align-items: center;
    gap: 10px;
    font-size: 24px;
    font-weight: 600;
}
.back-btn {
    font-size: 20px;
    color: #2563eb;
    text-decoration: none;
}
.back-btn:hover { transform: translateX(-5px); }
.btn-primary {
    background: #2563eb;
    border: none;
    border-radius: 6px;
}
.table th { background: #f9fafb; }
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

<div class="panel panel-white">
<div class="panel-body">

<?php
$vid=$_GET['viewid'];
$ret=mysqli_query($con,"select * from tblpatient where ID='$vid'");
while ($row=mysqli_fetch_array($ret)) {
?>

<h4><b>Patient Information</b></h4>
<table class="table table-bordered">
<tr>
<th>Name</th>
<td><?php echo $row['PatientName'];?></td>
<th>Email</th>
<td><?php echo $row['PatientEmail'];?></td>
</tr>

<tr>
<th>Mobile</th>
<td><?php echo $row['PatientContno'];?></td>
<th>Address</th>
<td><?php echo $row['PatientAdd'];?></td>
</tr>

<tr>
<th>Gender</th>
<td><?php echo $row['PatientGender'];?></td>
<th>Age</th>
<td><?php echo $row['PatientAge'];?></td>
</tr>

<tr>
<th>Medical History</th>
<td><?php echo $row['PatientMedhis'];?></td>
<th>Registered</th>
<td><?php echo $row['CreationDate'];?></td>
</tr>
</table>

<?php } ?>

<br>

<h4><b>Medical History</b></h4>

<table class="table table-hover">
<thead>
<tr>
<th>#</th>
<th>BP</th>
<th>Weight</th>
<th>Sugar</th>
<th>Temp</th>
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

<br>

<!-- BUTTON -->
<button class="btn btn-primary" data-toggle="modal" data-target="#myModal">
    + Add Medical History
</button>

</div>
</div>

</div>
</div>

<!-- MODAL -->
<div class="modal fade" id="myModal">
<div class="modal-dialog">
<div class="modal-content">

<div class="modal-header">
<h4>Add Medical History</h4>
<button type="button" class="close" data-dismiss="modal">&times;</button>
</div>

<form method="post">
<div class="modal-body">

<div class="form-group">
<label>Blood Pressure</label>
<input name="bp" class="form-control" required>
</div>

<div class="form-group">
<label>Blood Sugar</label>
<input name="bs" class="form-control" required>
</div>

<div class="form-group">
<label>Weight</label>
<input name="weight" class="form-control" required>
</div>

<div class="form-group">
<label>Temperature</label>
<input name="temp" class="form-control" required>
</div>

<div class="form-group">
<label>Prescription</label>
<textarea name="pres" class="form-control" rows="4" required></textarea>
</div>

</div>

<div class="modal-footer">
<button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
<button type="submit" name="submit" class="btn btn-primary">Save</button>
</div>

</form>

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

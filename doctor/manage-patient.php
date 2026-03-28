	<!-- DOCTOR MANAGE PATIENTS -->

<?php
session_start();
error_reporting(0);
include('include/config.php');

if(strlen($_SESSION['id']==0)) {
 header('location:logout.php');
} else {
?>

<!DOCTYPE html>
<html lang="en">
<head>
<title>Doctor | Manage Patients</title>

<link rel="stylesheet" href="vendor/bootstrap/css/bootstrap.min.css">
<link rel="stylesheet" href="vendor/fontawesome/css/font-awesome.min.css">

<style>

/* FIX SHIFT */
.main-content {
    margin-left: 0 !important;
}

/* WRAP */
.wrap-content {
    max-width: 1100px;
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

/* TABLE */
.table {
    margin-top: 10px;
}

.table th {
    font-weight: 600;
}

/* BUTTON */
.btn-primary {
    background: #2563eb;
    border: none;
    border-radius: 6px;
}

.btn-warning {
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

<!-- HEADER -->
<div class="page-header-custom">
    <div class="page-title">
        <a href="dashboard.php" class="back-btn">
            <i class="fa fa-arrow-left"></i>
        </a>
        Manage Patients
    </div>
</div>

<!-- PANEL -->
<div class="panel panel-white">
<div class="panel-body">

<div class="table-responsive">

<table class="table table-hover">
<thead>
<tr>
<th>#</th>
<th>Patient Name</th>
<th>Contact</th>
<th>Gender</th>
<th>Created</th>
<th>Updated</th>
<th>Action</th>
</tr>
</thead>

<tbody>

<?php
$docid=$_SESSION['id'];
$sql=mysqli_query($con,"select * from tblpatient where Docid='$docid'");
$cnt=1;

while($row=mysqli_fetch_array($sql))
{
?>

<tr>

<td><?php echo $cnt;?>.</td>
<td><?php echo $row['PatientName'];?></td>
<td><?php echo $row['PatientContno'];?></td>
<td><?php echo $row['PatientGender'];?></td>
<td><?php echo $row['CreationDate'];?></td>
<td><?php echo $row['UpdationDate'];?></td>

<td>
<a href="edit-patient.php?editid=<?php echo $row['ID'];?>" 
class="btn btn-primary btn-sm" target="_blank">
Edit
</a>

<a href="view-patient.php?viewid=<?php echo $row['ID'];?>" 
class="btn btn-warning btn-sm" target="_blank">
View
</a>
</td>

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
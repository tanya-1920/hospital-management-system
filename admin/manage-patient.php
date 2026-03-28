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
<title>View Patients</title>

<link rel="stylesheet" href="vendor/bootstrap/css/bootstrap.min.css">
<link rel="stylesheet" href="vendor/fontawesome/css/font-awesome.min.css">

<style>
.main-content { margin-left: 0 !important; }

/* CENTER */
.wrap-content {
    max-width: 1000px;
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

/* TABLE */
.table th {
    background: #f5f7fb;
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
    <a href="dashboard.php" class="back-btn">
        <i class="fa fa-arrow-left"></i>
    </a>
    <h2 style="margin:0;">View Patients</h2>
</div>

<br>

<div class="panel panel-white">
<div class="panel-heading">
<h4>Patients List</h4>
</div>

<div class="panel-body">

<table class="table table-hover table-bordered">
<thead>
<tr>
<th>#</th>
<th>Patient Name</th>
<th>Contact Number</th>
<th>Gender</th>
<th>Created Date</th>
<th>Updated Date</th>
<th>Action</th>
</tr>
</thead>

<tbody>

<?php
$sql=mysqli_query($con,"select * from tblpatient");
$cnt=1;

while($row=mysqli_fetch_array($sql))
{
?>

<tr>
<td><?php echo $cnt; ?></td>
<td><?php echo $row['PatientName']; ?></td>
<td><?php echo $row['PatientContno']; ?></td>
<td><?php echo $row['PatientGender']; ?></td>
<td><?php echo $row['CreationDate']; ?></td>
<td><?php echo $row['UpdationDate']; ?></td>

<td>
<a href="view-patient.php?viewid=<?php echo $row['ID']; ?>" 
class="btn btn-primary btn-xs" target="_blank">
<i class="fa fa-eye"></i> View
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

<?php include('include/footer.php'); ?>
<?php include('include/setting.php'); ?>

</div>

<script src="vendor/jquery/jquery.min.js"></script>
<script src="vendor/bootstrap/js/bootstrap.min.js"></script>

</body>
</html>

<?php } ?>

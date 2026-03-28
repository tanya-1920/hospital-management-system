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
<title>Admin | View Patients</title>

<link rel="stylesheet" href="vendor/bootstrap/css/bootstrap.min.css">
<link rel="stylesheet" href="vendor/fontawesome/css/font-awesome.min.css">

<style>

/* REMOVE SHIFT */
.main-content {
    margin-left: 0 !important;
}

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

/* BUTTON */
.btn-primary {
    background: #2563eb;
    border: none;
    border-radius: 6px;
}

/* SEARCH BOX */
.search-box {
    margin-bottom: 20px;
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
    <a href="dashboard.php" class="back-btn" title="Go to Dashboard">
        <i class="fa fa-arrow-left"></i>
    </a>
    View Patients
</div>

<br>

<div class="panel panel-white">
<div class="panel-body">

<!-- SEARCH -->
<form method="post" class="search-box">
    <div class="form-group">
        <label>Search by Name / Mobile No.</label>
        <input type="text" name="searchdata" class="form-control" required>
    </div>
    <button type="submit" name="search" class="btn btn-primary">
        Search
    </button>
</form>

<?php
if(isset($_POST['search'])) { 
$sdata=$_POST['searchdata'];
?>

<h4 align="center">Result against "<?php echo $sdata;?>" keyword</h4>

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
$sql=mysqli_query($con,"select * from tblpatient where PatientName like '%$sdata%'|| PatientContno like '%$sdata%'");
$num=mysqli_num_rows($sql);

if($num>0){
$cnt=1;
while($row=mysqli_fetch_array($sql)) {
?>

<tr>
<td><?php echo $cnt;?>.</td>
<td><?php echo $row['PatientName'];?></td>
<td><?php echo $row['PatientContno'];?></td>
<td><?php echo $row['PatientGender'];?></td>
<td><?php echo $row['CreationDate'];?></td>
<td><?php echo $row['UpdationDate'];?></td>

<td>
<a href="view-patient.php?viewid=<?php echo $row['ID'];?>" 
class="btn btn-primary btn-xs" target="_blank">
View
</a>
</td>
</tr>

<?php 
$cnt++;
} 
} else { ?>

<tr>
<td colspan="7" class="text-center">No record found</td>
</tr>

<?php } ?>

</tbody>
</table>
</div>

<?php } ?>

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

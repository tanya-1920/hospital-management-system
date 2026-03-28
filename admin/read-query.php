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
<title>Admin | Manage Read Queries</title>

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

/* TABLE */
.table {
    margin-top: 10px;
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

<!-- TITLE + BACK -->
<div class="page-title">
    <a href="dashboard.php" class="back-btn" title="Go to Dashboard">
        <i class="fa fa-arrow-left"></i>
    </a>
    Manage Read Queries
</div>

<br>

<div class="panel panel-white">
<div class="panel-body">

<div class="table-responsive">

<table class="table table-hover">
<thead>
<tr>
<th>#</th>
<th>Name</th>
<th>Email</th>
<th>Contact</th>
<th>Message</th>
<th>Query Date</th>
<th>Action</th>
</tr>
</thead>

<tbody>

<?php
$sql=mysqli_query($con,"select * from tblcontactus where IsRead is not null");
$cnt=1;

while($row=mysqli_fetch_array($sql)) {
?>

<tr>
<td><?php echo $cnt;?>.</td>
<td><?php echo $row['fullname'];?></td>
<td><?php echo $row['email'];?></td>
<td><?php echo $row['contactno'];?></td>
<td><?php echo $row['message'];?></td>
<td><?php echo $row['PostingDate'];?></td>

<td>
<a href="query-details.php?id=<?php echo $row['id'];?>" 
class="btn btn-primary btn-xs" title="View Details">
View
</a>
</td>
</tr>

<?php 
$cnt++;
} 
?>

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

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
<title>Admin | User Session Logs</title>

<link rel="stylesheet" href="vendor/bootstrap/css/bootstrap.min.css">
<link rel="stylesheet" href="vendor/fontawesome/css/font-awesome.min.css">

<style>


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

/* STATUS */
.status-success {
    color: green;
    font-weight: 500;
}

.status-fail {
    color: red;
    font-weight: 500;
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
    User Session Logs
</div>

<br>

<div class="panel panel-white">
<div class="panel-body">

<!-- MESSAGE -->
<p style="color:red;">
<?php 
echo htmlentities($_SESSION['msg']);
$_SESSION['msg']="";
?>
</p>

<div class="table-responsive">

<table class="table table-hover">
<thead>
<tr>
<th>#</th>
<th>User ID</th>
<th>Username</th>
<th>User IP</th>
<th>Login Time</th>
<th>Logout Time</th>
<th>Status</th>
</tr>
</thead>

<tbody>

<?php
$sql=mysqli_query($con,"select * from userlog ");
$cnt=1;

while($row=mysqli_fetch_array($sql)) {
?>

<tr>
<td><?php echo $cnt;?>.</td>
<td><?php echo $row['uid'];?></td>
<td><?php echo $row['username'];?></td>
<td><?php echo $row['userip'];?></td>
<td><?php echo $row['loginTime'];?></td>
<td><?php echo $row['logout'];?></td>

<td>
<?php if($row['status']==1) { ?>
<span class="status-success">Success</span>
<?php } else { ?>
<span class="status-fail">Failed</span>
<?php } ?>
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

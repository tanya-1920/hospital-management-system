<?php
session_start();
include('include/config.php');

if(strlen($_SESSION['id']==0)) {
 header('location:logout.php');
} else {
?>
<!DOCTYPE html>
<html lang="en">
<head>
<title>Admin | Doctor Session Logs</title>

<link rel="stylesheet" href="vendor/bootstrap/css/bootstrap.min.css">
<link rel="stylesheet" href="vendor/fontawesome/css/font-awesome.min.css">

<style>

/* ===== LAYOUT ===== */
.main-content {
    width: 100%;
}

.page-container {
    max-width: 1100px;
    margin: 0 auto;
    padding: 30px 20px;
}

/* ===== HEADER ===== */
.page-header {
    display: flex;
    align-items: center;
    gap: 12px;
    margin-bottom: 20px;
}

.page-header h2 {
    margin: 0;
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

/* ===== CARD ===== */
.card-box {
    background: #fff;
    border-radius: 12px;
    padding: 20px;
    box-shadow: 0 4px 12px rgba(0,0,0,0.08);
}

/* TABLE */
.table th {
    font-weight: 600;
}

/* STATUS */
.status-success {
    color: green;
    font-weight: 600;
}

.status-failed {
    color: red;
    font-weight: 600;
}

</style>

</head>

<body>

<div id="app">


<?php include('include/header.php'); ?>

<div class="main-content">

<div class="page-container">

<!-- HEADER -->
<div class="page-header">

    <!--  BACK BUTTON -->
    <a href="javascript:history.back()" class="back-btn">
        <i class="fa fa-arrow-left"></i>
    </a>

    <h2>Doctor Session Logs</h2>

</div>

<!-- CARD -->
<div class="card-box">

<p style="color:red;">
<?php echo htmlentities($_SESSION['msg']); ?>
<?php echo htmlentities($_SESSION['msg']=""); ?>
</p>

<div class="table-responsive">

<table class="table table-hover">

<thead>
<tr>
<th>#</th>
<th>User ID</th>
<th>Username</th>
<th>IP Address</th>
<th>Login Time</th>
<th>Logout Time</th>
<th>Status</th>
</tr>
</thead>

<tbody>

<?php
$sql=mysqli_query($con,"select * from doctorslog");
$cnt=1;

while($row=mysqli_fetch_array($sql))
{
?>

<tr>
<td><?php echo $cnt;?>.</td>
<td><?php echo $row['uid'];?></td>
<td><?php echo $row['username'];?></td>
<td><?php echo $row['userip'];?></td>
<td><?php echo $row['loginTime'];?></td>
<td><?php echo $row['logout'];?></td>

<td>
<?php 
if($row['status']==1){
    echo "<span class='status-success'>Success</span>";
} else {
    echo "<span class='status-failed'>Failed</span>";
}
?>
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

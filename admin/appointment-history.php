<!-- ADMIN APPOINTMENT HISTORY -->



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
<title>Patients | Appointment History</title>

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

/* ===== TABLE ===== */
.table {
    margin-bottom: 0;
}

.table th {
    font-weight: 600;
}

.status-active {
    color: green;
    font-weight: 600;
}

.status-cancel {
    color: red;
    font-weight: 600;
}

</style>

</head>

<body>

<div id="app">

<?php include('include/sidebar.php'); ?>
<?php include('include/header.php'); ?>

<div class="main-content">

<div class="page-container">

<!-- HEADER -->
<div class="page-header">

    <!-- 🔥 BACK BUTTON -->
    <a href="dashboard.php" class="back-btn">
        <i class="fa fa-arrow-left"></i>
    </a>

    <h2>Appointment History</h2>

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
<th>Doctor</th>
<th>Patient</th>
<th>Specialization</th>
<th>Fee</th>
<th>Date / Time</th>
<th>Created</th>
<th>Status</th>
<th>Action</th>
</tr>
</thead>

<tbody>

<?php
$sql=mysqli_query($con,"select doctors.doctorName as docname,users.fullName as pname,appointment.* from appointment join doctors on doctors.id=appointment.doctorId join users on users.id=appointment.userId");

$cnt=1;
while($row=mysqli_fetch_array($sql))
{
?>

<tr>
<td><?php echo $cnt;?>.</td>
<td><?php echo $row['docname'];?></td>
<td><?php echo $row['pname'];?></td>
<td><?php echo $row['doctorSpecialization'];?></td>
<td><?php echo $row['consultancyFees'];?></td>

<td>
<?php echo $row['appointmentDate'];?> <br>
<small><?php echo $row['appointmentTime'];?></small>
</td>

<td><?php echo $row['postingDate'];?></td>

<td>
<?php 
if(($row['userStatus']==1) && ($row['doctorStatus']==1)) {
    echo "<span class='status-active'>Active</span>";
}
elseif(($row['userStatus']==0) && ($row['doctorStatus']==1)) {
    echo "<span class='status-cancel'>Canceled by Patient</span>";
}
elseif(($row['userStatus']==1) && ($row['doctorStatus']==0)) {
    echo "<span class='status-cancel'>Canceled by Doctor</span>";
}
?>
</td>

<td>
<?php 
if(($row['userStatus']==1) && ($row['doctorStatus']==1)) {
    echo "No Action";
} else {
    echo "Canceled";
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

<!-- DOCTOR APPOINTMENT HISTORY -->

<?php
session_start();
error_reporting(0);
include('include/config.php');

if(strlen($_SESSION['id']==0)) {
 header('location:logout.php');
} else {

if(isset($_GET['cancel']))
{
    mysqli_query($con,"update appointment set doctorStatus='0' where id ='".$_GET['id']."'");
    $_SESSION['msg']="Appointment canceled !!";
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
<title>Doctor | Appointment History</title>

<link rel="stylesheet" href="vendor/bootstrap/css/bootstrap.min.css">
<link rel="stylesheet" href="vendor/fontawesome/css/font-awesome.min.css">

<style>

/* FIX SHIFT */
.main-content {
    margin-left: 0 !important;
}

/* WRAPPER */
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

/* BACK BUTTON */
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

/* BUTTON */
.btn-primary {
    background: #2563eb;
    border: none;
    border-radius: 6px;
}

/* MESSAGE */
.custom-msg {
    color: red;
    margin-bottom: 10px;
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
        Appointment History
    </div>
</div>

<!-- PANEL -->
<div class="panel panel-white">
<div class="panel-body">

<p class="custom-msg">
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
<th>Patient Name</th>
<th>Specialization</th>
<th>Consultancy Fee</th>
<th>Date / Time</th>
<th>Created</th>
<th>Status</th>
<th>Action</th>
</tr>
</thead>

<tbody>

<?php
$sql=mysqli_query($con,"select users.fullName as fname,appointment.*  from appointment join users on users.id=appointment.userId where appointment.doctorId='".$_SESSION['id']."'");
$cnt=1;

while($row=mysqli_fetch_array($sql))
{
?>

<tr>

<td><?php echo $cnt;?>.</td>

<td><?php echo $row['fname'];?></td>

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
    echo "<span class='text-success'>Active</span>";
}
if(($row['userStatus']==0) && ($row['doctorStatus']==1)) {
    echo "<span class='text-warning'>Cancel by Patient</span>";
}
if(($row['userStatus']==1) && ($row['doctorStatus']==0)) {
    echo "<span class='text-danger'>Cancel by you</span>";
}
?>
</td>

<td>
<?php if(($row['userStatus']==1) && ($row['doctorStatus']==1)) { ?>
<a href="appointment-history.php?id=<?php echo $row['id']?>&cancel=update"
onclick="return confirm('Are you sure you want to cancel this appointment ?')"
class="btn btn-primary btn-xs">
Cancel
</a>
<?php } else {
echo "Canceled";
} ?>
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

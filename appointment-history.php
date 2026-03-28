<!-- USER APPOINTMENT HISTORY -->

<?php
session_start();
include('include/config.php');

if(strlen($_SESSION['id']==0)) {
    header('location:logout.php');
} else {

if(isset($_GET['cancel']))
{
    mysqli_query($con,"update appointment set userStatus='0' where id='".$_GET['id']."'");
    $_SESSION['msg']="Your appointment canceled !!";
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
<title>User | Appointment History</title>

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


<?php include('include/header.php'); ?>

<div class="main-content">

<div class="wrap-content">

<!-- TITLE + BACK -->
<div class="page-title">
    <a href="dashboard.php" class="back-btn" title="Go to Dashboard">
        <i class="fa fa-arrow-left"></i>
    </a>
    Appointment History
</div>

<br>

<div class="panel panel-white">
<div class="panel-body">

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
<th>Specialization</th>
<th>Fees</th>
<th>Date / Time</th>
<th>Created</th>
<th>Status</th>
<th>Action</th>
</tr>
</thead>

<tbody>

<?php
$sql=mysqli_query($con,"select doctors.doctorName as docname,appointment.* from appointment join doctors on doctors.id=appointment.doctorId where appointment.userId='".$_SESSION['id']."'");
$cnt=1;

while($row=mysqli_fetch_array($sql))
{
?>

<tr>
<td><?php echo $cnt;?>.</td>
<td><?php echo $row['docname'];?></td>
<td><?php echo $row['doctorSpecialization'];?></td>
<td><?php echo $row['consultancyFees'];?></td>

<td>
<?php echo $row['appointmentDate'];?> <br>
<small><?php echo $row['appointmentTime'];?></small>
</td>

<td><?php echo $row['postingDate'];?></td>

<td>
<?php
if($row['userStatus']==1 && $row['doctorStatus']==1) {
    echo "<span class='text-success'>Active</span>";
}
elseif($row['userStatus']==0) {
    echo "<span class='text-danger'>Canceled by You</span>";
}
elseif($row['doctorStatus']==0) {
    echo "<span class='text-warning'>Canceled by Doctor</span>";
}
?>
</td>

<td>
<?php if($row['userStatus']==1 && $row['doctorStatus']==1) { ?>
<a href="appointment-history.php?id=<?php echo $row['id']?>&cancel=update"
onclick="return confirm('Cancel this appointment?')"
class="btn btn-primary btn-xs">
Cancel
</a>
<?php } else {
echo "—";
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
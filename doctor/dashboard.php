<!-- DOCTOR DASHBOARD -->

<?php
session_start();
error_reporting(0);
include('include/config.php');

if(strlen($_SESSION['id']==0)) {
    header('location:logout.php');
} else {

$docid = $_SESSION['id'];

// BASIC DATA
$profile = mysqli_num_rows(mysqli_query($con,"SELECT * FROM doctors WHERE id='$docid'"));
$appointments = mysqli_num_rows(mysqli_query($con,"SELECT * FROM appointment WHERE doctorId='$docid'"));
$patients = mysqli_num_rows(mysqli_query($con,"SELECT DISTINCT userId FROM appointment WHERE doctorId='$docid'"));
$pending = mysqli_num_rows(mysqli_query($con,"SELECT * FROM appointment WHERE doctorId='$docid' AND userStatus=1 AND doctorStatus=0"));

// EXTRA DATA
$today = date('Y-m-d');

$todayList = mysqli_query($con,"SELECT * FROM appointment WHERE doctorId='$docid' AND appointmentDate='$today'");

$completed = mysqli_num_rows(mysqli_query($con,"SELECT * FROM appointment WHERE doctorId='$docid' AND doctorStatus=1"));

$topPatients = mysqli_query($con,"
SELECT userId, COUNT(*) as total 
FROM appointment 
WHERE doctorId='$docid'
GROUP BY userId 
ORDER BY total DESC LIMIT 5
");

$insight = ($appointments > 15) ? "Busy schedule this week" : "Manageable workload";

$upcoming = mysqli_query($con,"
SELECT * FROM appointment 
WHERE doctorId='$docid' 
AND appointmentDate >= CURDATE()
ORDER BY appointmentDate ASC LIMIT 5
");

// CHART DATA
$chartData = [];
$labels = [];

for ($i = 6; $i >= 0; $i--) {
    $date = date('Y-m-d', strtotime("-$i days"));
    $labels[] = date('d M', strtotime($date));

    $count = mysqli_num_rows(mysqli_query($con,
        "SELECT * FROM appointment 
         WHERE doctorId='$docid' 
         AND appointmentDate='$date'"
    ));

    $chartData[] = $count;
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
<title>Doctor | Dashboard</title>

<link rel="stylesheet" href="vendor/bootstrap/css/bootstrap.min.css">
<link rel="stylesheet" href="vendor/themify-icons/themify-icons.min.css">
<link rel="stylesheet" href="assets/css/styles.css">

<style>
body { margin:0; padding:0; }

.main-content {
    margin-left:0 !important;
    width:100% !important;
}

.wrap-content {
    max-width:1200px;
    margin:auto;
    padding:30px 20px;
}

.title-line {
    height:2px;
    background:#e5e7eb;
    margin-bottom:30px;
}

/* FIXED CARD */
.dashboard-card {
    border-radius:12px;
    min-height:220px;
    display:flex;
    align-items:center;
    justify-content:center;
    text-align:center;
    padding:20px;
    transition:0.3s;
    box-shadow:0 4px 12px rgba(0,0,0,0.08);
}

.dashboard-card:hover {
    transform:translateY(-5px);
    box-shadow:0 10px 22px rgba(0,0,0,0.15);
}

.dashboard-card > div {
    width:100%;
}

.dashboard-card i {
    font-size:28px;
    color:#2d6cdf;
    margin-bottom:10px;
}

.sub-links {
    margin-top:10px;
}

.sub-links a {
    display:inline-block;
    margin:5px;
    padding:6px 12px;
    border-radius:5px;
    font-size:12px;
    background:#eef2ff;
    color:#2d6cdf;
    text-decoration:none;
}

.sub-links a:hover {
    background:#2d6cdf;
    color:#fff;
}

/* GRID SPACING FIX */
.row.text-center {
    margin-right:-10px;
    margin-left:-10px;
}
.row.text-center > div {
    padding:10px;
}

@media (max-width:768px){
    .dashboard-card{min-height:180px;}
}
</style>
</head>

<body>

<div id="app">

<?php include('include/sidebar.php'); ?>
<div class="app-content">
<?php include('include/header.php'); ?>

<div class="main-content">
<div class="wrap-content">

<h1 style="font-weight:900;">Doctor Dashboard</h1>

<div style="text-align:right; font-size:14px; color:#666;">
<span id="clock"></span>
</div>

<div style="margin-bottom:15px;">Welcome back, Doctor 👨‍⚕️</div>

<div class="title-line"></div>

<div class="container-fluid">
<div class="row">

<!-- LEFT: ANALYTICS -->
<div class="col-md-8">

<?php if($pending > 0) { ?>
<div style="background:#ffecec; padding:10px; border-radius:6px; margin-bottom:15px;">
⚠️ You have <?php echo $pending; ?> pending requests
</div>
<?php } ?>

<div style="display:flex; flex-wrap:wrap; gap:15px; margin-bottom:20px;">
<div>👨‍⚕️ Patients: <?php echo $patients; ?></div>
<div>📅 Appointments: <?php echo $appointments; ?></div>
<div>⏳ Pending: <?php echo $pending; ?></div>
<div>✅ Completed: <?php echo $completed; ?></div>
</div>

<div style="margin-bottom:20px;">
💡 Insight: <?php echo $insight; ?>
</div>

<div class="bg-white" style="padding:20px; border-radius:10px; margin-bottom:20px;">
<h4>Appointments (Last 7 Days)</h4>
<canvas id="appointmentsChart"></canvas>
</div>

<div class="bg-white" style="padding:20px; border-radius:10px; margin-bottom:20px;">
<h4>Today's Appointments</h4>
<ul>
<?php while($row=mysqli_fetch_array($todayList)) { ?>
<li><?php echo $row['appointmentTime']; ?> - Patient #<?php echo $row['userId']; ?></li>
<?php } ?>
</ul>
</div>

<div class="bg-white" style="padding:20px; border-radius:10px; margin-bottom:20px;">
<h4>Top Patients</h4>
<ul>
<?php while($row=mysqli_fetch_array($topPatients)) { ?>
<li>Patient #<?php echo $row['userId']; ?> (<?php echo $row['total']; ?> visits)</li>
<?php } ?>
</ul>
</div>

<div class="bg-white" style="padding:20px; border-radius:10px; margin-bottom:20px;">
<h4>Upcoming Appointments</h4>
<ul>
<?php while($row=mysqli_fetch_array($upcoming)) { ?>
<li><?php echo $row['appointmentDate']; ?> - <?php echo $row['appointmentTime']; ?></li>
<?php } ?>
</ul>
</div>

</div>

<!-- RIGHT: TILES -->
<div class="col-md-4">
<div class="row text-center">

<div class="col-sm-6 col-md-6">
<div class="dashboard-card">
<div>
<i class="ti-user"></i>
<h4>My Profile</h4>
<p><?php echo $profile; ?> Info</p>
<div class="sub-links">
<a href="edit-profile.php">Update</a>
</div>
</div>
</div>
</div>

<div class="col-sm-6 col-md-6">
<div class="dashboard-card">
<div>
<i class="ti-file"></i>
<h4>Appointments</h4>
<p><?php echo $appointments; ?> Total</p>
<div class="sub-links">
<a href="appointment-history.php">History</a>
</div>
</div>
</div>
</div>

<div class="col-sm-6 col-md-6">
<div class="dashboard-card">
<div>
<i class="ti-user"></i>
<h4>Patients</h4>
<p><?php echo $patients; ?> Total</p>
<div class="sub-links">
<a href="add-patient.php">Add</a>
<a href="manage-patient.php">Manage</a>
</div>
</div>
</div>
</div>

<div class="col-sm-6 col-md-6">
<div class="dashboard-card">
<div>
<i class="ti-alert"></i>
<h4>Pending</h4>
<p style="color:red; font-weight:bold;"><?php echo $pending; ?></p>
<div class="sub-links">
<a href="appointment-history.php">Check</a>
</div>
</div>
</div>
</div>

<div class="col-sm-6 col-md-6">
<div class="dashboard-card">
<div>
<i class="ti-list"></i>
<h4>Appointment History</h4>
<div class="sub-links">
<a href="appointment-history.php">View</a>
</div>
</div>
</div>
</div>

<div class="col-sm-6 col-md-6">
<div class="dashboard-card">
<div>
<i class="ti-search"></i>
<h4>Search</h4>
<div class="sub-links">
<a href="search.php">Find</a>
</div>
</div>
</div>
</div>

</div>
</div>

</div>
</div>

</div>
</div>
</div>

</div>

<script src="vendor/jquery/jquery.min.js"></script>
<script src="vendor/bootstrap/js/bootstrap.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

<script>
// CLOCK
setInterval(()=>{
document.getElementById("clock").innerHTML = new Date().toLocaleString();
},1000);

// CHART
new Chart(document.getElementById('appointmentsChart'), {
type:'line',
data:{
labels: <?php echo json_encode($labels); ?>,
datasets:[{
label:'Appointments',
data: <?php echo json_encode($chartData); ?>,
borderWidth:2,
fill:true
}]
}
});
</script>
 
<?php include('include/footer.php'); ?>
</body>
</html>

<?php } ?>

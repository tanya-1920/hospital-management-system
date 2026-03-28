<?php
session_start();
error_reporting(0);
include('../include/config.php');

if(strlen($_SESSION['id']==0)) {
    header('location:logout.php');
} else {

$users = mysqli_num_rows(mysqli_query($con,"SELECT * FROM users"));
$doctors = mysqli_num_rows(mysqli_query($con,"SELECT * FROM doctors"));
$patients = mysqli_num_rows(mysqli_query($con,"SELECT * FROM tblpatient"));
$appointments = mysqli_num_rows(mysqli_query($con,"SELECT * FROM appointment"));
$queries = mysqli_num_rows(mysqli_query($con,"SELECT * FROM tblcontactus WHERE IsRead IS NULL"));
?>
<!DOCTYPE html>
<html lang="en">
<head>
<title>Admin | Dashboard</title>

<link rel="stylesheet" href="vendor/bootstrap/css/bootstrap.min.css">
<link rel="stylesheet" href="vendor/themify-icons/themify-icons.min.css">
<link rel="stylesheet" href="assets/css/styles.css">

<style>
body {
    margin: 0;
    padding: 0;
}

/* MAIN CONTENT */
.main-content {
    margin-left: 0 !important;
    width: 100% !important;
}

/* CENTER WRAPPER */
.wrap-content {
    max-width: 1200px;
    margin: auto;
    padding: 30px 20px;
}

/* TITLE */
.page-title {
    font-size: 26px;
    font-weight: 80;
    margin-bottom: 10px;
    color: #1b1b1b;
}

.title-line {
    height: 2px;
    background: #e5e7eb;
    margin-bottom: 30px;
}

/* SEARCH */
.search-wrapper {
    display: flex;
    justify-content: center;
    margin-bottom: 35px;
}

.search-box {
    width: 60%;
    position: relative;
}

.search-box input {
    width: 100%;
    padding: 14px 50px 14px 20px;
    border-radius: 50px !important;
    border: 1px solid #ddd;
    outline: none;
}

.search-box i {
    position: absolute;
    right: 18px;
    top: 14px;
    color: #999;
}

/* CARDS */
.dashboard-card {
    border-radius: 12px;
    min-height: 220px;
    display: flex;
    align-items: center;
    justify-content: center;
    transition: 0.3s;
    box-shadow: 0 4px 12px rgba(0,0,0,0.08);
    text-align: center;
    margin-bottom: 25px;

    /* animation */
    opacity: 0;
    transform: translateY(20px);
    animation: fadeInUp 0.6s ease forwards;
    position: relative;
}

.dashboard-card:hover {
    transform: translateY(-6px);
    box-shadow: 0 10px 22px rgba(0,0,0,0.15);
}

.dashboard-card:hover::after {
    
    position: absolute;
    bottom: 10px;
    font-size: 11px;
    color: #888;
}

.dashboard-card i {
    font-size: 28px;
    color: #2d6cdf;
    margin-bottom: 10px;
}

/* animation delays */
.dashboard-card:nth-child(1) { animation-delay: 0.1s; }
.dashboard-card:nth-child(2) { animation-delay: 0.2s; }
.dashboard-card:nth-child(3) { animation-delay: 0.3s; }
.dashboard-card:nth-child(4) { animation-delay: 0.4s; }
.dashboard-card:nth-child(5) { animation-delay: 0.5s; }
.dashboard-card:nth-child(6) { animation-delay: 0.6s; }

@keyframes fadeInUp {
    to {
        opacity: 1;
        transform: translateY(0);
    }
}

/* LINKS */
.sub-links a {
    display: inline-block;
    margin: 5px;
    padding: 6px 12px;
    border-radius: 5px;
    font-size: 12px;
    background: #eef2ff;
    color: #2d6cdf;
    text-decoration: none;
}

.sub-links a:hover {
    background: #2d6cdf;
    color: #fff;
}

/* RESPONSIVE */
@media (max-width: 768px) {
    .search-box {
        width: 90%;
    }
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

<section id="page-title">
    <div class="row">
        <div class="col-sm-8">
            <h1 class="mainTitle" style="font-weight:900;">Dashboard</h1>
        </div>
        <div class="col-sm-4 text-right">
            <ol class="breadcrumb">
                <li>User</li>
                <li class="active">Dashboard</li>
            </ol>
        </div>
    </div>
</section>

<!-- CLOCK -->
<div style="text-align:right; margin-bottom:10px; font-size:14px; color:#666;">
    <span id="clock"></span>
</div>

<!-- WELCOME -->
<div style="margin-bottom:15px; font-size:15px; color:#555;">
    Welcome back, Admin 👋
</div>

<div class="title-line"></div>

<!-- SEARCH -->
<div class="search-wrapper">
    <div class="search-box">
        <input type="text" placeholder="Search patients, doctors, reports...">
        <i class="ti-search"></i>
    </div>
</div>

<!-- QUICK ACTIONS -->
<div style="margin-bottom:20px; text-align:center;">
    <a href="add-doctor.php" class="btn btn-primary">+ Add Doctor</a>
    <a href="manage-patient.php" class="btn btn-success">View Patients</a>
    <a href="appointment-history.php" class="btn btn-info">Appointments</a>
</div>

<!-- DASHBOARD -->
<div class="container-fluid bg-white" style="border-radius:10px; padding:30px;">
<div class="row text-center">

<!-- DOCTORS -->
<div class="col-sm-6 col-md-4">
<div class="dashboard-card">
<div>
<i class="ti-user"></i>
<h4>Doctors</h4>
<p><?php echo $doctors; ?> Total</p>
<div class="sub-links">
<a href="doctor-specilization.php">Specialization</a>
<a href="add-doctor.php">Add</a>
<a href="manage-doctors.php">Manage</a>
</div>
</div>
</div>
</div>

<!-- USERS -->
<div class="col-sm-6 col-md-4">
<div class="dashboard-card">
<div>
<i class="ti-user"></i>
<h4>Users</h4>
<p><?php echo $users; ?> Total</p>
<div class="sub-links">
<a href="manage-users.php">Manage</a>
</div>
</div>
</div>
</div>

<!-- PATIENTS -->
<div class="col-sm-6 col-md-4">
<div class="dashboard-card">
<div>
<i class="ti-user"></i>
<h4>Patients</h4>
<p><?php echo $patients; ?> Total</p>
<div class="sub-links">
<a href="manage-patient.php">Manage</a>
</div>
</div>
</div>
</div>

<!-- APPOINTMENTS -->
<div class="col-sm-6 col-md-4">
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

<!-- QUERIES -->
<div class="col-sm-6 col-md-4">
<div class="dashboard-card">
<div>
<i class="ti-files"></i>
<h4>Queries</h4>
<p style="color:red; font-weight:bold;"><?php echo $queries; ?> Pending</p>
<div class="sub-links">
<a href="unread-queries.php">Unread</a>
<a href="read-query.php">Read</a>
</div>
</div>
</div>
</div>

<!-- LOGS -->
<div class="col-sm-6 col-md-4">
<div class="dashboard-card">
<div>
<i class="ti-list"></i>
<h4>Logs</h4>
<div class="sub-links">
<a href="doctor-logs.php">Doctor Logs</a>
<a href="user-logs.php">User Logs</a>
</div>
</div>
</div>
</div>

<!-- REPORTS -->
<div class="col-sm-6 col-md-4">
<div class="dashboard-card">
<div>
<i class="ti-files"></i>
<h4>Reports</h4>
<div class="sub-links">
<a href="between-dates-reports.php">View Reports</a>
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

<!-- LIVE SEARCH -->
<script>
$(document).ready(function(){
    $(".search-box input").on("keyup", function() {
        var value = $(this).val().toLowerCase();
        $(".dashboard-card").filter(function() {
            $(this).toggle($(this).text().toLowerCase().indexOf(value) > -1)
        });
    });
});
</script>

<!-- CLOCK -->
<script>
function updateClock() {
    var now = new Date();
    document.getElementById("clock").innerHTML = now.toLocaleString();
}
setInterval(updateClock, 1000);
updateClock();
</script>

</body>
</html>
<?php } ?>

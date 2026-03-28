<!-- USER DASHBOARD -->

<?php
session_start();
include('include/config.php');
include('include/checklogin.php');
check_login();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <title>User Dashboard</title>

    <link href="http://fonts.googleapis.com/css?family=Lato:300,400,600,700|Raleway:300,400,500,600,700" rel="stylesheet">
    <link rel="stylesheet" href="vendor/bootstrap/css/bootstrap.min.css">
    <link rel="stylesheet" href="vendor/fontawesome/css/font-awesome.min.css">
    <link rel="stylesheet" href="vendor/themify-icons/themify-icons.min.css">

    <link rel="stylesheet" href="assets/css/styles.css">
    <link rel="stylesheet" href="assets/css/plugins.css">
    <link rel="stylesheet" href="assets/css/themes/theme-1.css">

    <!-- ✅ CENTERED LAYOUT FIX -->
    <style>
        body {
            margin: 0;
            padding: 0;
        }

        .main-content {
            margin-left: 0 !important;
            width: 100% !important;
        }

        /* CENTERED CONTAINER */
        .wrap-content {
            max-width: 1200px;
            margin: auto;
            padding: 30px 20px;
        }

        /* Dashboard cards */
        .dashboard-box {
            border-radius: 12px;
            min-height: 230px;
            display: flex;
            align-items: center;
            justify-content: center;
            transition: 0.3s;
            box-shadow: 0 4px 12px rgba(0,0,0,0.08);
        }

        .dashboard-box:hover {
            transform: translateY(-6px);
            box-shadow: 0 10px 22px rgba(0,0,0,0.15);
        }

        .icon-space {
            margin-bottom: 15px;
        }

        .title {
            font-weight: 600;
        }

        .desc {
            color: #777;
            font-size: 13px;
        }

        .coming-box {
            padding: 15px;
        }
    </style>
</head>

<body>

<div id="app">


<div class="app-content">

<?php include('include/header.php'); ?>

<div class="main-content">

<!-- ✅ CENTERED CONTENT -->
<div class="wrap-content" id="container">

<!-- PAGE TITLE -->
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

<!-- BOOK APPOINTMENT -->
<div class="container-fluid" style="margin-bottom:20px;">
    <div class="panel panel-white" style="border-radius:12px; padding:20px; box-shadow:0 4px 12px rgba(0,0,0,0.08);">
        <div class="row">
            <div class="col-sm-8">
                <h4 style="margin:0; font-weight:600;">Book a New Appointment</h4>
                <p style="margin-top:5px; color:#777;">Quickly schedule your visit with a doctor</p>
            </div>

            <div class="col-sm-4 text-right">
                <a href="book-appointment.php" class="btn btn-danger">
                    <i class="fa fa-plus"></i> Book Appointment
                </a>
            </div>
        </div>
    </div>
</div>

<!-- DASHBOARD -->
<div class="container-fluid bg-white" style="border-radius:10px; padding:30px;">
    <div class="row text-center">

        <div class="col-sm-6 col-md-4">
            <div class="panel panel-white dashboard-box">
                <div class="panel-body">
                    <i class="fa fa-search fa-3x text-primary icon-space"></i>
                    <h4 class="title">Track Appointment</h4>
                    <p class="desc">Check appointment status</p>
                    <a href="track-appointment.php" class="btn btn-primary btn-sm">Track</a>
                </div>
            </div>
        </div>

        <div class="col-sm-6 col-md-4">
            <div class="panel panel-white dashboard-box">
                <div class="panel-body">
                    <i class="fa fa-calendar fa-3x text-success icon-space"></i>
                    <h4 class="title">My Appointments</h4>
                    <p class="desc">View booked appointments</p>
                    <a href="appointment-history.php" class="btn btn-success btn-sm">View</a>
                </div>
            </div>
        </div>

        <div class="col-sm-6 col-md-4">
            <div class="panel panel-white dashboard-box">
                <div class="panel-body">
                    <i class="fa fa-history fa-3x text-warning icon-space"></i>
                    <h4 class="title">Appointment History</h4>
                    <p class="desc">See past visits</p>
                    <a href="appointment-history.php" class="btn btn-warning btn-sm">Open</a>
                </div>
            </div>
        </div>

    </div>
</div>

<!-- UPCOMING FEATURES -->
<div class="container-fluid" style="margin-top:25px;">
    <div class="panel panel-white" style="border-radius:12px; padding:25px; box-shadow:0 4px 12px rgba(0,0,0,0.06);">

        <h3 style="text-align:center; font-weight:600;">Upcoming Features</h3>

        <div class="row text-center" style="margin-top:20px;">

            <div class="col-sm-6 col-md-3">
                <div class="coming-box">
                    <i class="fa fa-bell fa-2x text-info"></i>
                    <h5>Notifications</h5>
                    <p>Get alerts for appointments</p>
                </div>
            </div>

            <div class="col-sm-6 col-md-3">
                <div class="coming-box">
                    <i class="fa fa-file-text fa-2x text-primary"></i>
                    <h5>Reports</h5>
                    <p>Download medical reports</p>
                </div>
            </div>

            <div class="col-sm-6 col-md-3">
                <div class="coming-box">
                    <i class="fa fa-user-md fa-2x text-success"></i>
                    <h5>Doctor Chat</h5>
                    <p>Consult doctors online</p>
                </div>
            </div>

            <div class="col-sm-6 col-md-3">
                <div class="coming-box">
                    <i class="fa fa-mobile fa-2x text-warning"></i>
                    <h5>Mobile App</h5>
                    <p>Access on mobile devices</p>
                </div>
            </div>

        </div>
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

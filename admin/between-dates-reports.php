<!-- ADMIN -->


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
<title>Between Dates | Reports</title>

<link rel="stylesheet" href="vendor/bootstrap/css/bootstrap.min.css">
<link rel="stylesheet" href="vendor/fontawesome/css/font-awesome.min.css">

<style>

/* ===== LAYOUT ===== */
.main-content {
    width: 100%;
}

.page-container {
    max-width: 700px;
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
    padding: 25px;
    box-shadow: 0 4px 12px rgba(0,0,0,0.08);
}

.card-title {
    font-size: 18px;
    font-weight: 600;
    margin-bottom: 20px;
}

/* FORM */
.form-group {
    margin-bottom: 15px;
}

.btn-primary {
    background: #2563eb;
    border: none;
    border-radius: 8px;
    padding: 8px 20px;
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

    <!--  BACK BUTTON -->
    <a href="dashboard.php" class="back-btn">
        <i class="fa fa-arrow-left"></i>
    </a>

    <h2>Between Dates Reports</h2>

</div>

<!-- CARD -->
<div class="card-box">

<div class="card-title">Generate Report</div>

<form method="post" action="betweendates-detailsreports.php">

<div class="form-group">
<label>From Date</label>
<input type="date" class="form-control" name="fromdate" required>
</div>

<div class="form-group">
<label>To Date</label>
<input type="date" class="form-control" name="todate" required>
</div>

<button type="submit" name="submit" class="btn btn-primary">
Generate Report
</button>

</form>

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

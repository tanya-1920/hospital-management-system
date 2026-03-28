<!-- ADMIN -->


<?php
session_start();
error_reporting(0);
include('include/config.php');

if(strlen($_SESSION['id']==0)) {
 header('location:logout.php');
} else {

$fdate=$_POST['fromdate'];
$tdate=$_POST['todate'];
?>
<!DOCTYPE html>
<html lang="en">
<head>
<title>Admin | Patient Reports</title>

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

/* REPORT TITLE */
.report-title {
    text-align: center;
    color: #2563eb;
    font-weight: 600;
    margin-bottom: 20px;
}

/* TABLE */
.table th {
    font-weight: 600;
}

.btn-xs {
    padding: 4px 10px;
    font-size: 12px;
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
    <a href="between-dates-reports.php" class="back-btn">
        <i class="fa fa-arrow-left"></i>
    </a>

    <h2>Patient Reports</h2>

</div>

<!-- CARD -->
<div class="card-box">

<div class="report-title">
Report from <?php echo $fdate ?> to <?php echo $tdate ?>
</div>

<div class="table-responsive">

<table class="table table-hover">

<thead>
<tr>
<th>#</th>
<th>Name</th>
<th>Contact</th>
<th>Gender</th>
<th>Created</th>
<th>Updated</th>
<th>Action</th>
</tr>
</thead>

<tbody>

<?php
$sql=mysqli_query($con,"select * from tblpatient where date(CreationDate) between '$fdate' and '$tdate'");
$cnt=1;

while($row=mysqli_fetch_array($sql))
{
?>

<tr>
<td><?php echo $cnt;?>.</td>
<td><?php echo $row['PatientName'];?></td>
<td><?php echo $row['PatientContno'];?></td>
<td><?php echo $row['PatientGender'];?></td>
<td><?php echo $row['CreationDate'];?></td>
<td><?php echo $row['UpdationDate'];?></td>

<td>
<a href="view-patient.php?viewid=<?php echo $row['ID'];?>" 
class="btn btn-primary btn-xs" target="_blank">
View
</a>
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

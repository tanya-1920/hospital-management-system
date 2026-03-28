<?php
session_start();
error_reporting(0);
include('include/config.php');

if(strlen($_SESSION['id']==0)) {
 header('location:logout.php');
} else {

// ADD
if(isset($_POST['submit'])) {
    $doctorspecilization=$_POST['doctorspecilization'];
    mysqli_query($con,"insert into doctorSpecilization(specilization) values('$doctorspecilization')");
    $_SESSION['msg']="Doctor Specialization added successfully !!";
}

// DELETE
if(isset($_GET['del'])) {
    $sid=$_GET['id'];	
    mysqli_query($con,"delete from doctorSpecilization where id='$sid'");
    $_SESSION['msg']="Data deleted !!";
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
<title>Doctor Specialization</title>

<link rel="stylesheet" href="vendor/bootstrap/css/bootstrap.min.css">
<link rel="stylesheet" href="vendor/fontawesome/css/font-awesome.min.css">

<style>

/* ===== LAYOUT ===== */
.main-content {
    width: 100%;
}

.page-container {
    max-width: 900px;
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
    margin-bottom: 20px;
}

.card-title {
    font-weight: 600;
    margin-bottom: 15px;
}

/* BUTTON */
.btn-primary {
    background: #2563eb;
    border: none;
    border-radius: 8px;
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
    <a href="dashboard.php" class="back-btn">
        <i class="fa fa-arrow-left"></i>
    </a>
    <h2>Doctor Specialization</h2>
</div>

<!-- MESSAGE -->
<p style="color:red;">
<?php echo htmlentities($_SESSION['msg']); ?>
<?php echo htmlentities($_SESSION['msg']=""); ?>
</p>

<!-- ===== FORM CARD ===== -->
<div class="card-box">

<div class="card-title">Add Specialization</div>

<form method="post">

<div class="form-group">
<label>Doctor Specialization</label>
<input type="text" name="doctorspecilization" class="form-control" required>
</div>

<button type="submit" name="submit" class="btn btn-primary">
Add
</button>

</form>

</div>

<!-- ===== TABLE CARD ===== -->
<div class="card-box">

<div class="card-title">Manage Specializations</div>

<div class="table-responsive">

<table class="table table-hover">

<thead>
<tr>
<th>#</th>
<th>Specialization</th>
<th>Created</th>
<th>Updated</th>
<th>Action</th>
</tr>
</thead>

<tbody>

<?php
$sql=mysqli_query($con,"select * from doctorSpecilization");
$cnt=1;

while($row=mysqli_fetch_array($sql))
{
?>

<tr>
<td><?php echo $cnt;?>.</td>
<td><?php echo $row['specilization'];?></td>
<td><?php echo $row['creationDate'];?></td>
<td><?php echo $row['updationDate'];?></td>

<td>
<a href="edit-doctor-specialization.php?id=<?php echo $row['id'];?>" 
class="btn btn-primary btn-xs">Edit</a>

<a href="doctor-specilization.php?id=<?php echo $row['id'];?>&del=delete"
onClick="return confirm('Delete this item?')" 
class="btn btn-danger btn-xs">Delete</a>
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

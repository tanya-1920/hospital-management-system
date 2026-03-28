<?php
session_start();
error_reporting(0);
include('include/config.php');

if(strlen($_SESSION['id']==0)) {
 header('location:logout.php');
} else {

$id=intval($_GET['id']);

if(isset($_POST['submit'])) {
    $docspecialization=$_POST['doctorspecilization'];
    mysqli_query($con,"update doctorSpecilization set specilization='$docspecialization' where id='$id'");
    $_SESSION['msg']="Doctor Specialization updated successfully !!";
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
<title>Edit Doctor Specialization</title>

<link rel="stylesheet" href="vendor/bootstrap/css/bootstrap.min.css">
<link rel="stylesheet" href="vendor/fontawesome/css/font-awesome.min.css">

<style>

/* ===== LAYOUT ===== */
.main-content {
    width: 100%;
}

.page-container {
    max-width: 600px;
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
    padding: 25px;
    box-shadow: 0 4px 12px rgba(0,0,0,0.08);
}

/* BUTTON */
.btn-primary {
    background: #2563eb;
    border: none;
    border-radius: 8px;
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
    <a href="doctor-specilization.php" class="back-btn">
        <i class="fa fa-arrow-left"></i>
    </a>
    <h2>Edit Specialization</h2>
</div>

<!-- MESSAGE -->
<p style="color:red;">
<?php echo htmlentities($_SESSION['msg']); ?>
<?php echo htmlentities($_SESSION['msg']=""); ?>
</p>

<!-- CARD -->
<div class="card-box">

<form method="post">

<?php 
$sql=mysqli_query($con,"select * from doctorSpecilization where id='$id'");
while($row=mysqli_fetch_array($sql)) {
?>

<div class="form-group">
<label>Doctor Specialization</label>
<input type="text" name="doctorspecilization" 
class="form-control" 
value="<?php echo $row['specilization'];?>" required>
</div>

<?php } ?>

<button type="submit" name="submit" class="btn btn-primary">
Update
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

<?php
session_start();
error_reporting(0);
include('include/config.php');

if(strlen($_SESSION['id']==0)) {
 header('location:logout.php');
} else {

$did=intval($_GET['id']);

if(isset($_POST['submit'])) {
    $docspecialization=$_POST['Doctorspecialization'];
    $docname=$_POST['docname'];
    $docaddress=$_POST['clinicaddress'];
    $docfees=$_POST['docfees'];
    $doccontactno=$_POST['doccontact'];
    $docemail=$_POST['docemail'];

    $sql=mysqli_query($con,"Update doctors set 
        specilization='$docspecialization',
        doctorName='$docname',
        address='$docaddress',
        docFees='$docfees',
        contactno='$doccontactno',
        docEmail='$docemail' 
        where id='$did'");

    if($sql) {
        $msg="Doctor Details updated Successfully";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
<title>Edit Doctor</title>

<link rel="stylesheet" href="vendor/bootstrap/css/bootstrap.min.css">
<link rel="stylesheet" href="vendor/fontawesome/css/font-awesome.min.css">

<style>
.main-content { margin-left: 0 !important; }

.wrap-content {
    max-width: 900px;
    margin: auto;
    padding: 30px 20px;
}

.panel {
    border-radius: 12px;
    box-shadow: 0 4px 12px rgba(0,0,0,0.08);
}

.page-title {
    display: flex;
    align-items: center;
    gap: 10px;
    font-size: 24px;
    font-weight: 600;
}

.back-btn {
    font-size: 20px;
    color: #2563eb;
    text-decoration: none;
}

.back-btn:hover {
    transform: translateX(-5px);
}

.btn-primary {
    background: #2563eb;
    border: none;
    border-radius: 6px;
}

.form-group {
    margin-bottom: 15px;
}
</style>

</head>

<body>

<div id="app">

<?php include('include/sidebar.php'); ?>
<?php include('include/header.php'); ?>

<div class="main-content">
<div class="wrap-content">

<!-- TITLE -->
<div class="page-title">
    <a href="manage-doctors.php" class="back-btn">
        <i class="fa fa-arrow-left"></i>
    </a>
    Edit Doctor Details
</div>

<br>

<div class="panel panel-white">
<div class="panel-body">

<!-- SUCCESS MESSAGE -->
<?php if($msg) { ?>
<p style="color:green;"><?php echo htmlentities($msg); ?></p>
<?php } ?>

<?php 
$sql=mysqli_query($con,"select * from doctors where id='$did'");
while($data=mysqli_fetch_array($sql)) {
?>

<h4><b><?php echo htmlentities($data['doctorName']);?>'s Profile</b></h4>
<p><small>Registered: <?php echo htmlentities($data['creationDate']);?></small></p>

<?php if($data['updationDate']) { ?>
<p><small>Last Updated: <?php echo htmlentities($data['updationDate']);?></small></p>
<?php } ?>

<hr>

<form method="post">

<!-- SPECIALIZATION -->
<div class="form-group">
<label>Doctor Specialization</label>
<select name="Doctorspecialization" class="form-control" required>

<option value="<?php echo htmlentities($data['specilization']);?>">
<?php echo htmlentities($data['specilization']);?>
</option>

<?php 
$ret=mysqli_query($con,"select * from doctorspecilization");
while($row=mysqli_fetch_array($ret)) {
?>
<option value="<?php echo htmlentities($row['specilization']);?>">
<?php echo htmlentities($row['specilization']);?>
</option>
<?php } ?>

</select>
</div>

<!-- NAME -->
<div class="form-group">
<label>Doctor Name</label>
<input type="text" name="docname" class="form-control"
value="<?php echo htmlentities($data['doctorName']);?>">
</div>

<!-- ADDRESS -->
<div class="form-group">
<label>Clinic Address</label>
<textarea name="clinicaddress" class="form-control"><?php echo htmlentities($data['address']);?></textarea>
</div>

<!-- FEES -->
<div class="form-group">
<label>Consultancy Fees</label>
<input type="text" name="docfees" class="form-control"
value="<?php echo htmlentities($data['docFees']);?>">
</div>

<!-- CONTACT -->
<div class="form-group">
<label>Contact Number</label>
<input type="text" name="doccontact" class="form-control"
value="<?php echo htmlentities($data['contactno']);?>">
</div>

<!-- EMAIL -->
<div class="form-group">
<label>Email</label>
<input type="email" name="docemail" class="form-control"
readonly value="<?php echo htmlentities($data['docEmail']);?>">
</div>

<?php } ?>

<br>

<button type="submit" name="submit" class="btn btn-primary">
Update Details
</button>

</form>

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
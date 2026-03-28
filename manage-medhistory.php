<!-- USER MEDICAL HISTORY -->

<?php
session_start();
error_reporting(0);
include('include/config.php');
include('include/checklogin.php');
check_login();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <title>Medical History</title>

    <link href="http://fonts.googleapis.com/css?family=Lato:300,400,600|Raleway:300,400,500,600" rel="stylesheet">
    <link rel="stylesheet" href="vendor/bootstrap/css/bootstrap.min.css">
    <link rel="stylesheet" href="assets/css/styles.css">
</head>

<body>
<div id="app">        

<?php include('include/sidebar.php');?>
<div class="app-content">
<?php include('include/header.php');?>

<div class="main-content">
<div class="wrap-content container">

<section id="page-title">
    <div class="row">
        <div class="col-sm-12">
            
            <h1 class="mainTitle" style="display:flex; align-items:center; gap:10px;">

                <!-- BACK BUTTON -->
                <button onclick="goBack()" 
                    style="background:none; border:none; font-size:20px; color:#555; cursor:pointer;">
                    ←
                </button>

                Medical History

            </h1>

        </div>
    </div>
</section>

<!-- TABLE -->
<div class="container-fluid container-fullw bg-white">
<div class="row">
<div class="col-md-12">

<h5 class="over-title margin-bottom-15">
    View <span class="text-bold">Medical History</span>
</h5>

<table class="table table-hover">

<thead>
<tr>
    <th>#</th>
    <th>Patient Name</th>
    <th>Contact</th>
    <th>Gender</th>
    <th>Created</th>
    <th>Updated</th>
    <th>Action</th>
</tr>
</thead>

<tbody>

<?php
$uid=$_SESSION['id'];
$sql=mysqli_query($con,"select tblpatient.* from tblpatient 
join users on users.email=tblpatient.PatientEmail 
where users.id='$uid'");

$cnt=1;
while($row=mysqli_fetch_array($sql)) {
?>

<tr>
<td><?php echo $cnt;?>.</td>
<td><?php echo $row['PatientName'];?></td>
<td><?php echo $row['PatientContno'];?></td>
<td><?php echo $row['PatientGender'];?></td>
<td><?php echo $row['CreationDate'];?></td>
<td><?php echo $row['UpdationDate'];?></td>

<td>
<a href="view-medhistory.php?viewid=<?php echo $row['ID'];?>" 
class="btn btn-info btn-sm">
View Details
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
</div>
</div>
</div>

<?php include('include/footer.php');?>
<?php include('include/setting.php');?>

</div>

<!--  BACK FUNCTION -->
<script>
function goBack() {
    if (document.referrer !== "") {
        window.history.back();
    } else {
        window.location.href = "dashboard.php";
    }
}
</script>

<script src="vendor/jquery/jquery.min.js"></script>
<script src="vendor/bootstrap/js/bootstrap.min.js"></script>

</body>
</html>

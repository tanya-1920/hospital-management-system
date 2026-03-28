<?php
session_start();
error_reporting(0);
include('include/config.php');

if(strlen($_SESSION['id']==0)) {
    header('location:logout.php');
} else {

if(isset($_POST['submit']))
{
    $docspecialization=$_POST['Doctorspecialization'];
    $docname=$_POST['docname'];
    $docaddress=$_POST['clinicaddress'];
    $docfees=$_POST['docfees'];
    $doccontactno=$_POST['doccontact'];
    $docemail=$_POST['docemail'];
    $password=md5($_POST['npass']);

    $sql=mysqli_query($con,"insert into doctors(specilization,doctorName,address,docFees,contactno,docEmail,password) values('$docspecialization','$docname','$docaddress','$docfees','$doccontactno','$docemail','$password')");

    if($sql){
        // Changed to exit with "success" so the AJAX script can catch it and show the animation
        echo "success";
        exit();
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
<title>Admin | Add Doctor</title>

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

/* --- SUCCESS OVERLAY & ANIMATION CSS --- */
#success-overlay {
    display: none;
    position: fixed;
    top: 0; left: 0; width: 100%; height: 100%;
    background: rgba(255, 255, 255, 0.95);
    z-index: 9999;
    align-items: center;
    justify-content: center;
    flex-direction: column;
}

.checkmark-circle {
    width: 80px; height: 80px;
    position: relative;
    border-radius: 50%;
    border: 4px solid #eee;
    border-left-color: #2563eb;
    animation: spin 1s infinite linear;
    transition: all 0.3s;
}

.checkmark-circle.load-complete {
    animation: none;
    border-color: #4CAF50;
}

.checkmark-draw { 
    display: none; 
    box-sizing: content-box !important;
}

.checkmark-circle.load-complete .checkmark-draw {
    display: block;
    position: absolute;
    top: 50%;
    left: 50%;
    width: 18px;
    height: 38px;
    border: solid #4CAF50;
    border-width: 0 4px 4px 0;
    margin-top: -24px; 
    margin-left: -14px;
    transform-origin: center;
    animation: checkmark-pop 0.3s ease-in-out forwards;
}

@keyframes spin { 0% { transform: rotate(0deg); } 100% { transform: rotate(360deg); } }
@keyframes checkmark-pop { 
    0% { transform: rotate(45deg) scale(0); opacity: 0; }
    50% { transform: rotate(45deg) scale(1.2); opacity: 1; }
    100% { transform: rotate(45deg) scale(1); opacity: 1; }
}
/* --------------------------------------- */

</style>

<script src="vendor/jquery/jquery.min.js"></script>

<script>
function valid(){
 if(document.adddoc.npass.value!= document.adddoc.cfpass.value){
    alert("Password and Confirm Password do not match!");
    return false;
 }
 return true;
}

function checkemailAvailability() {
jQuery.ajax({
url: "check_availability.php",
data:'emailid='+$("#docemail").val(),
type: "POST",
success:function(data){
$("#email-availability-status").html(data);
}
});
}
</script>

</head>

<body>

<div id="success-overlay">
    <div class="checkmark-circle">
        <div class="checkmark-draw"></div>
    </div>
    <h3 id="status-text" style="margin-top:25px; font-family: sans-serif; color: #555;">Adding Doctor...</h3>
</div>

<div id="app">

<?php include('include/sidebar.php'); ?>
<?php include('include/header.php'); ?>

<div class="main-content">

<div class="page-container">

<div class="page-header">

    <a href="dashboard.php" class="back-btn">
        <i class="fa fa-arrow-left"></i>
    </a>

    <h2>Add Doctor</h2>

</div>

<div class="card-box">

<div class="card-title">Doctor Details</div>

<form name="adddoc" id="addDocForm" method="post" onSubmit="return valid();">

<div class="form-group">
<label>Doctor Specialization</label>
<select name="Doctorspecialization" class="form-control" required>
<option value="">Select Specialization</option>

<?php 
$ret=mysqli_query($con,"select * from doctorspecilization");
while($row=mysqli_fetch_array($ret)){
?>
<option value="<?php echo htmlentities($row['specilization']);?>">
<?php echo htmlentities($row['specilization']);?>
</option>
<?php } ?>

</select>
</div>

<div class="form-group">
<label>Doctor Name</label>
<input type="text" name="docname" class="form-control" required>
</div>

<div class="form-group">
<label>Clinic Address</label>
<textarea name="clinicaddress" class="form-control" required></textarea>
</div>

<div class="form-group">
<label>Consultancy Fees</label>
<input type="text" name="docfees" class="form-control" required>
</div>

<div class="form-group">
<label>Contact Number</label>
<input type="text" name="doccontact" class="form-control" required>
</div>

<div class="form-group">
<label>Email</label>
<input type="email" id="docemail" name="docemail" class="form-control" required onBlur="checkemailAvailability()">
<span id="email-availability-status"></span>
</div>

<div class="form-group">
<label>Password</label>
<input type="password" name="npass" class="form-control" required>
</div>

<div class="form-group">
<label>Confirm Password</label>
<input type="password" name="cfpass" class="form-control" required>
</div>

<button type="submit" name="submit" class="btn btn-primary">
Submit
</button>

</form>

</div>

</div>
</div>

<?php include('include/footer.php'); ?>
<?php include('include/setting.php'); ?>

</div>

<script src="vendor/bootstrap/js/bootstrap.min.js"></script>

<script>
$(document).ready(function() {
    $('#addDocForm').on('submit', function(e) {
        // Run standard valid() first. If it fails (passwords don't match), let it return false and stop
        if (!valid()) {
            return false;
        }

        e.preventDefault(); // Stop standard page reload
        
        // Show the loading overlay
        $('#success-overlay').css('display', 'flex');
        
        // Serialize form data and append the submit flag
        var formData = $(this).serialize() + '&submit=true';

        $.ajax({
            type: 'POST',
            url: window.location.href, // Send to this exact page
            data: formData,
            success: function(response) {
                if(response.trim() === "success") {
                    setTimeout(function() {
                        // Stop spinning and pop the tick
                        $('.checkmark-circle').addClass('load-complete');
                        $('#status-text').text('Doctor Info Added Successfully!').css('color', '#4CAF50');
                        
                        // Redirect to manage-doctors.php after 2 seconds
                        setTimeout(function() {
                            window.location.href = 'manage-doctors.php';
                        }, 2000);
                    }, 1000); // 1 second artificial load for a smooth transition
                }
            }
        });
    });
});
</script>

</body>
</html>

<?php } ?>
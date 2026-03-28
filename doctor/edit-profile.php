<!-- DOCTOR EDIT PROFILE -->

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

    $sql=mysqli_query($con,"UPDATE doctors SET 
        specilization='$docspecialization',
        doctorName='$docname',
        address='$docaddress',
        docFees='$docfees',
        contactno='$doccontactno'
        WHERE id='".$_SESSION['id']."'");

    if($sql){
        // Changed to exit with "success" so the AJAX script can trigger the animation
        echo "success";
        exit();
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>

<title>Doctor | Edit Profile</title>

<link rel="stylesheet" href="vendor/bootstrap/css/bootstrap.min.css">
<link rel="stylesheet" href="vendor/fontawesome/css/font-awesome.min.css">
<link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600&display=swap" rel="stylesheet">

<style>

/* FIX LEFT SHIFT */
.main-content {
    margin-left: 0 !important;
}

/* CENTER CONTENT */
.wrap-content {
    max-width: 600px;
    margin: auto;
    padding: 40px 20px;
}

/* TITLE */
.page-title {
    display: flex;
    align-items: center;
    gap: 10px;
}

/* BACK BUTTON */
.back-btn {
    font-size: 18px;
    color: #667eea;
    text-decoration: none;
}
.back-btn:hover {
    transform: translateX(-4px);
}

/* CARD */
.panel {
    border-radius: 12px;
    border: none;
    box-shadow: 0 15px 40px rgba(0,0,0,0.08);
    overflow: hidden;
}

.panel-heading {
    background: #f9fafb;
    border-bottom: 1px solid #eee;
    padding: 15px;
}

.panel-heading h4 {
    margin: 0;
    font-weight: 600;
}

/* INPUT */
.form-control {
    border-radius: 8px;
    padding: 12px;
    border: 1px solid #ddd;
}

.form-control:focus {
    border-color: #667eea;
    box-shadow: 0 0 0 2px rgba(102,126,234,0.15);
}

/* BUTTON */
.btn-primary {
    width: 100%;
    background: #667eea;
    border: none;
    border-radius: 8px;
    padding: 12px;
    font-weight: 500;
}

.btn-primary:hover {
    background: #5a67d8;
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
    border-left-color: #667eea; /* Matched to your theme color */
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

</head>

<body>

<div id="success-overlay">
    <div class="checkmark-circle">
        <div class="checkmark-draw"></div>
    </div>
    <h3 id="status-text" style="margin-top:25px; font-family: 'Poppins', sans-serif; color: #555;">Updating Profile...</h3>
</div>

<div id="app">

<?php include('include/sidebar.php'); ?>
<?php include('include/header.php'); ?>

<div class="main-content">
<div class="wrap-content">

<div class="page-title">
    <a href="dashboard.php" class="back-btn">
        <i class="fa fa-arrow-left"></i>
    </a>
    <h2 style="margin:0;">Edit Profile</h2>
</div>

<br>

<div class="panel panel-white">

<div class="panel-heading">
<h4>Edit Doctor Details</h4>
</div>

<div class="panel-body" style="padding:20px;">

<?php 
$did=$_SESSION['id'];
$sql=mysqli_query($con,"SELECT * FROM doctors WHERE id='$did'");

while($data=mysqli_fetch_array($sql))
{
?>

<h4><?php echo htmlentities($data['doctorName']); ?>'s Profile</h4>
<p><b>Profile Created:</b> <?php echo htmlentities($data['creationDate']); ?></p>

<?php if($data['updationDate']){ ?>
<p><b>Last Updated:</b> <?php echo htmlentities($data['updationDate']); ?></p>
<?php } ?>

<hr>

<form method="post" id="editProfileForm">

<div class="form-group">
<label>Doctor Specialization</label>
<select name="Doctorspecialization" class="form-control" required>
<option value="<?php echo htmlentities($data['specilization']); ?>">
<?php echo htmlentities($data['specilization']); ?>
</option>

<?php
$ret=mysqli_query($con,"SELECT * FROM doctorspecilization");
while($row=mysqli_fetch_array($ret))
{
?>
<option value="<?php echo htmlentities($row['specilization']); ?>">
<?php echo htmlentities($row['specilization']); ?>
</option>
<?php } ?>
</select>
</div>

<div class="form-group">
<label>Doctor Name</label>
<input type="text" name="docname" class="form-control"
value="<?php echo htmlentities($data['doctorName']); ?>">
</div>

<div class="form-group">
<label>Clinic Address</label>
<textarea name="clinicaddress" class="form-control"><?php echo htmlentities($data['address']); ?></textarea>
</div>

<div class="form-group">
<label>Consultancy Fees</label>
<input type="text" name="docfees" class="form-control"
value="<?php echo htmlentities($data['docFees']); ?>">
</div>

<div class="form-group">
<label>Contact Number</label>
<input type="text" name="doccontact" class="form-control"
value="<?php echo htmlentities($data['contactno']); ?>">
</div>

<div class="form-group">
<label>Email</label>
<input type="email" class="form-control" readonly
value="<?php echo htmlentities($data['docEmail']); ?>">
</div>

<?php } ?>

<button type="submit" name="submit" class="btn btn-primary">
Update Profile
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

<script>
$(document).ready(function() {
    $('#editProfileForm').on('submit', function(e) {
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
                        $('#status-text').text('Profile Updated!').css('color', '#4CAF50');
                        
                        // Refresh the page after 2 seconds to show the updated database info
                        setTimeout(function() {
                            window.location.href = window.location.href;
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

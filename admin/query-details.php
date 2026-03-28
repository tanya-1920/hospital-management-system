<?php
session_start();
error_reporting(0);
include('include/config.php');

if(strlen($_SESSION['id']==0)) {
 header('location:logout.php');
} else {

//updating Admin Remark
if(isset($_POST['update']))
{
    $qid=intval($_GET['id']);
    $adminremark=$_POST['adminremark'];
    $isread=1;
    $query=mysqli_query($con,"update tblcontactus set  AdminRemark='$adminremark',IsRead='$isread' where id='$qid'");
    
    if($query){
        // Exiting with "success" so the AJAX script triggers the smooth animation
        echo "success";
        exit();
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
<title>Admin | Query Details</title>

<link rel="stylesheet" href="vendor/bootstrap/css/bootstrap.min.css">
<link rel="stylesheet" href="vendor/fontawesome/css/font-awesome.min.css">

<style>

/* REMOVE SHIFT */
.main-content {
    margin-left: 0 !important;
}

/* CENTER CONTENT */
.wrap-content {
    max-width: 900px;
    margin: auto;
    padding: 30px 20px;
}

/* PANEL */
.panel {
    border-radius: 12px;
    box-shadow: 0 4px 12px rgba(0,0,0,0.08);
}

/* TITLE */
.page-title {
    display: flex;
    align-items: center;
    gap: 10px;
    font-size: 24px;
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

/* TABLE */
.table th {
    width: 30%;
}

/* BUTTON */
.btn-primary {
    background: #2563eb;
    border: none;
    border-radius: 6px;
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

</head>

<body>

<div id="success-overlay">
    <div class="checkmark-circle">
        <div class="checkmark-draw"></div>
    </div>
    <h3 id="status-text" style="margin-top:25px; font-family: sans-serif; color: #555;">Updating Remark...</h3>
</div>

<div id="app">

<?php include('include/sidebar.php'); ?>
<?php include('include/header.php'); ?>

<div class="main-content">
<div class="wrap-content">

<div class="page-title">
    <a href="read-query.php" class="back-btn" title="Go Back">
        <i class="fa fa-arrow-left"></i>
    </a>
    Query Details
</div>

<br>

<div class="panel panel-white">
<div class="panel-body">

<table class="table table-hover">

<tbody>

<?php
$qid=intval($_GET['id']);
$sql=mysqli_query($con,"select * from tblcontactus where id='$qid'");

while($row=mysqli_fetch_array($sql)) {
?>

<tr>
<th>Full Name</th>
<td><?php echo $row['fullname'];?></td>
</tr>

<tr>
<th>Email</th>
<td><?php echo $row['email'];?></td>
</tr>

<tr>
<th>Contact Number</th>
<td><?php echo $row['contactno'];?></td>
</tr>

<tr>
<th>Message</th>
<td><?php echo $row['message'];?></td>
</tr>

<tr>
<th>Query Date</th>
<td><?php echo $row['PostingDate'];?></td>
</tr>

<?php if($row['AdminRemark']==""){ ?>   

<form method="post" id="remarkForm">

<tr>
<th>Admin Remark</th>
<td>
<textarea name="adminremark" class="form-control" required></textarea>
</td>
</tr>

<tr>
<td></td>
<td>
<button type="submit" class="btn btn-primary" name="update">
Update
</button>
</td>
</tr>

</form>

<?php } else { ?>   

<tr>
<th>Admin Remark</th>
<td><?php echo $row['AdminRemark'];?></td>
</tr>

<tr>
<th>Last Updated</th>
<td><?php echo $row['LastupdationDate'];?></td>
</tr>

<?php } } ?>

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

<script>
$(document).ready(function() {
    $('#remarkForm').on('submit', function(e) {
        e.preventDefault(); // Stop standard page reload
        
        // Show the loading overlay
        $('#success-overlay').css('display', 'flex');
        
        // Serialize form data and append the update flag
        var formData = $(this).serialize() + '&update=true';

        $.ajax({
            type: 'POST',
            url: window.location.href, // Send to this exact page (preserves the ?id= in the URL)
            data: formData,
            success: function(response) {
                if(response.trim() === "success") {
                    setTimeout(function() {
                        // Stop spinning and pop the tick
                        $('.checkmark-circle').addClass('load-complete');
                        $('#status-text').text('Remark Updated Successfully!').css('color', '#4CAF50');
                        
                        // Redirect to read-query.php after 2 seconds
                        setTimeout(function() {
                            window.location.href = 'read-query.php';
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

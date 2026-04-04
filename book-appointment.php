<?php
ob_start(); // 🔥 START BUFFER

session_start();
include('include/config.php');
include('include/checklogin.php');
check_login();

// ✅ AJAX HANDLER (MUST BE BEFORE HTML)
if(isset($_POST['submit'])) {

    ob_clean(); // remove unwanted output (assistant/header)
    header('Content-Type: application/json');

    $specilization = $_POST['Doctorspecialization'];
    $doctorid = $_POST['doctor'];
    $userid = $_SESSION['id'];
    $fees = $_POST['fees'];
    $appdate = $_POST['appdate'];
    $time = $_POST['apptime'];

    $query = mysqli_query($con, "INSERT INTO appointment
    (doctorSpecialization, doctorId, userId, consultancyFees, appointmentDate, appointmentTime, userStatus, doctorStatus)
    VALUES
    ('$specilization','$doctorid','$userid','$fees','$appdate','$time','1','1')");

    echo json_encode([
        "status" => $query ? "success" : "error"
    ]);

    exit(); // 🚨 STOP EVERYTHING ELSE
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <title>User | Book Appointment</title>

    <link rel="stylesheet" href="vendor/bootstrap/css/bootstrap.min.css">
    <link rel="stylesheet" href="vendor/fontawesome/css/font-awesome.min.css">

    <style>
        .main-content { margin-left: 0 !important; }
        .wrap-content { max-width: 900px; margin: auto; padding: 30px 20px; }
        .panel { border-radius: 12px; box-shadow: 0 4px 12px rgba(0,0,0,0.08); }
        .page-title { display: flex; align-items: center; gap: 10px; }
        .back-btn { font-size: 20px; color: #2563eb; text-decoration: none; }
        .btn-primary { background: #2563eb; border: none; border-radius: 8px; }

        #success-overlay {
            display: none;
            position: fixed;
            top: 0; left: 0;
            width: 100%; height: 100%;
            background: rgba(255,255,255,0.95);
            z-index: 9999;
            align-items: center;
            justify-content: center;
            flex-direction: column;
        }

        .checkmark-circle {
            width: 80px; height: 80px;
            border-radius: 50%;
            border: 4px solid #eee;
            border-left-color: #2563eb;
            animation: spin 1s infinite linear;
            position: relative;
        }

        .checkmark-circle.load-complete {
            animation: none;
            border-color: #4CAF50;
        }

        .checkmark-draw {
            display: none;
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
            transform: rotate(45deg);
        }

        @keyframes spin {
            100% { transform: rotate(360deg); }
        }
    </style>

    <script src="vendor/jquery/jquery.min.js"></script>

    <script>
        function getdoctor(val) {
            $.ajax({
                type: "POST",
                url: "get_doctor.php",
                data:'specilizationid='+val,
                success: function(data){ $("#doctor").html(data); }
            });
        }

        function getfee(val) {
            $.ajax({
                type: "POST",
                url: "get_doctor.php",
                data:'doctor='+val,
                success: function(data){ $("#fees").html(data); }
            });
        }

        $(document).ready(function() {

            $('#appointmentForm').on('submit', function(e) {
                e.preventDefault();

                $('#success-overlay').css('display', 'flex');

                $.ajax({
                    type: 'POST',
                    url: window.location.href, // same file
                    data: $(this).serialize() + '&submit=true',

                    success: function(response) {

                        console.log(response); // DEBUG

                        // convert if string
                        if (typeof response === "string") {
                            try {
                                response = JSON.parse(response);
                            } catch(e) {
                                console.error("Invalid JSON:", response);
                                $('#success-overlay').hide();
                                return;
                            }
                        }

                        if(response.status === "success") {

                            setTimeout(function() {

                                $('.checkmark-circle').addClass('load-complete');
                                $('#status-text').text('Appointment Booked!').css('color','#4CAF50');

                                setTimeout(function() {
                                    window.location.href = "appointment-history.php";
                                }, 2000);

                            }, 1000);

                        } else {
                            alert("Something went wrong!");
                            $('#success-overlay').hide();
                        }
                    },

                    error: function() {
                        alert("Server error!");
                        $('#success-overlay').hide();
                    }
                });
            });

        });
    </script>
</head>

<body>

<div id="success-overlay">
    <div class="checkmark-circle">
        <div class="checkmark-draw"></div>
    </div>
    <h3 id="status-text">Booking Appointment...</h3>
</div>

<div id="app">

<?php include('include/header.php'); ?>

<div class="main-content">
<div class="wrap-content">

<div class="page-title">
    <a href="dashboard.php" class="back-btn">
        <i class="fa fa-arrow-left"></i>
    </a>
    <h2>Book Appointment</h2>
</div>

<br>

<div class="panel panel-white">
<div class="panel-heading">
    <h4>Book Appointment</h4>
</div>

<div class="panel-body">

<form id="appointmentForm">

<div class="form-group">
<label>Doctor Specialization</label>
<select name="Doctorspecialization" class="form-control" onChange="getdoctor(this.value);" required>
<option value="">Select Specialization</option>

<?php 
$ret=mysqli_query($con,"select * from doctorspecilization");
while($row=mysqli_fetch_array($ret)){
?>
<option value="<?php echo $row['specilization'];?>"><?php echo $row['specilization'];?></option>
<?php } ?>

</select>
</div>

<div class="form-group">
<label>Doctors</label>
<select name="doctor" id="doctor" class="form-control" onChange="getfee(this.value);" required>
<option value="">Select Doctor</option>
</select>
</div>

<div class="form-group">
<label>Consultancy Fees</label>
<select name="fees" id="fees" class="form-control" readonly></select>
</div>

<div class="form-group">
<label>Date</label>
<input type="date" name="appdate" class="form-control" required>
</div>

<div class="form-group">
<label>Time</label>
<input type="time" name="apptime" class="form-control" required>
</div>

<button type="submit" class="btn btn-primary">Submit</button>

</form>

</div>
</div>

</div>
</div>

<?php include('include/footer.php'); ?>
<?php include('include/setting.php'); ?>

</div>

<script src="vendor/bootstrap/js/bootstrap.min.js"></script>

</body>
</html>
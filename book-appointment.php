<!-- USER APPOINTMENT BOOKING -->

<?php
session_start();
include('include/config.php');
include('include/checklogin.php');
check_login();

// Handle the AJAX submission
if(isset($_POST['submit']))
{
    $specilization = $_POST['Doctorspecialization'];
    $doctorid = $_POST['doctor'];
    $userid = $_SESSION['id'];
    $fees = $_POST['fees'];
    $appdate = $_POST['appdate'];
    $time = $_POST['apptime'];

    $query = mysqli_query($con, "insert into appointment(doctorSpecialization,doctorId,userId,consultancyFees,appointmentDate,appointmentTime,userStatus,doctorStatus) values('$specilization','$doctorid','$userid','$fees','$appdate','$time','1','1')");

    if($query){
        // We exit here so the browser only receives "success" instead of the whole HTML page
        echo "success";
        exit();
    }
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
        .back-btn { font-size: 20px; color: #2563eb; text-decoration: none; transition: 0.3s; }
        .back-btn:hover { transform: translateX(-5px); }
        .btn-primary { background: #2563eb; border: none; border-radius: 8px; padding: 10px 25px; }

        /* SUCCESS OVERLAY & ANIMATION */
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

        /* Success State for Circle */
        .checkmark-circle.load-complete {
            animation: none;
            border-color: #4CAF50;
        }

        /* The Checkmark -Centering */
        .checkmark-draw { 
            display: none; 
            box-sizing: content-box !important; /* Stops Bootstrap from breaking the dimensions */
        }
        
        .checkmark-circle.load-complete .checkmark-draw {
            display: block;
            position: absolute;
            /* Pin the top-left corner exactly to the center of the circle */
            top: 50%;
            left: 50%;
            width: 18px;
            height: 38px;
            border: solid #4CAF50;
            border-width: 0 4px 4px 0;
            /* Pull it back up and left using exact pixels to visually center the shape */
            margin-top: -24px; 
            margin-left: -14px;
            transform-origin: center;
            /* Pop animation */
            animation: checkmark-pop 0.3s ease-in-out forwards;
        }

        @keyframes spin { 
            0% { transform: rotate(0deg); } 
            100% { transform: rotate(360deg); } 
        }
        
        /* The robust scale animation */
        @keyframes checkmark-pop { 
            0% { transform: rotate(45deg) scale(0); opacity: 0; }
            50% { transform: rotate(45deg) scale(1.2); opacity: 1; }
            100% { transform: rotate(45deg) scale(1); opacity: 1; }
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

        // AJAX Form Submission
        $(document).ready(function() {
            $('#appointmentForm').on('submit', function(e) {
                e.preventDefault();
                
                // Show Overlay
                $('#success-overlay').css('display', 'flex');
                
                $.ajax({
                    type: 'POST',
                    url: window.location.href, // Sends to current page
                    data: $(this).serialize() + '&submit=true',
                    success: function(response) {
                        if(response.trim() === "success") {
                            setTimeout(function() {
                                // Stop spin and show tick
                                $('.checkmark-circle').addClass('load-complete');
                                $('#status-text').text('Appointment Booked!').css('color', '#4CAF50');
                                
                                // Redirect after 2 seconds
                                setTimeout(function() {
                                    window.location.href = "appointment-history.php";
                                }, 2000);
                            }, 1000); // Artificial delay for smooth transition
                        }
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
        <h3 id="status-text" style="margin-top:25px; font-family: sans-serif; color: #555;">Booking Appointment...</h3>
    </div>

    <div id="app">
       
        <?php include('include/header.php'); ?>

        <div class="main-content">
            <div class="wrap-content">
                <div class="page-title">
                    <a href="dashboard.php" class="back-btn" title="Go to Dashboard">
                        <i class="fa fa-arrow-left"></i>
                    </a>
                    <h2 style="margin:0;">Book Appointment</h2>
                </div>

                <br>

                <div class="panel panel-white">
                    <div class="panel-heading">
                        <h4>Book Appointment</h4>
                    </div>
                    <div class="panel-body">
                        <form method="post" id="appointmentForm">
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
                                <select name="doctor" class="form-control" id="doctor" onChange="getfee(this.value);" required>
                                    <option value="">Select Doctor</option>
                                </select>
                            </div>

                            <div class="form-group">
                                <label>Consultancy Fees</label>
                                <select name="fees" class="form-control" id="fees" readonly></select>
                            </div>

                            <div class="form-group">
                                <label>Date</label>
                                <input class="form-control datepicker" name="appdate" required>
                            </div>

                            <div class="form-group">
                                <label>Time</label>
                                <input class="form-control" name="apptime" required placeholder="10:00 PM">
                            </div>

                            <button type="submit" name="submit" class="btn btn-primary">
                                Submit
                            </button>
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

<!-- USER EDIT PROFILE -->

<?php
session_start();
//error_reporting(0);
include('include/config.php');
include('include/checklogin.php');
check_login();
if(isset($_POST['submit']))
{
    $fname=$_POST['fname'];
    $address=$_POST['address'];
    $city=$_POST['city'];
    $gender=$_POST['gender'];

    $sql=mysqli_query($con,"Update users set fullName='$fname',address='$address',city='$city',gender='$gender' where id='".$_SESSION['id']."'");

    if($sql)
    {
        $msg="Your Profile updated Successfully";
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>User | Edit Profile</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="vendor/fontawesome/css/font-awesome.min.css">
    <link rel="stylesheet" href="assets/css/styles.css">
    <style>

        body {
            background-color: #f8f9fa;
        }
        .card {
            border-radius: 12px;
            box-shadow: 0 4px 12px rgba(0,0,0,0.05);
        }
        .form-label {
            font-weight: 500;
        }
        .update-btn {
            border-radius: 50px;
            padding: 10px 30px;
        }
        h4 {
            font-weight: 600;
        }
        .msg {
            font-size: 16px;
        }
        .breadcrumb {
            background: transparent;
            padding: 0;
            margin-bottom: 20px;
        }
        #page-title {
            display: flex;
            align-items: center;
        }
        #page-title h1 {
            margin: 0;
        }
        #back-arrow {
            font-size: 1.5rem;
            margin-right: 12px;
            text-decoration: none;
            color: #000;
        }
        #back-arrow:hover {
            color: #0d6efd;
        }
    </style>
</head>
<body>
    <div id="app">
       
        <div class="app-content">
            <?php include('include/header.php'); ?>
            <main class="container my-5">

                <!-- PAGE TITLE with Back Arrow -->
                <section id="page-title" class="mb-4">
                     <a href="dashboard.php" class="back-btn" title="Go to Dashboard">
            <i class="fa fa-arrow-left"></i>
    </a>
                    <h1 class="mainTitle">Edit Profile</h1>
                </section>

                <div class="mb-4">
                    <?php if($msg) { ?>
                        <div id="success-msg" class="alert alert-success msg"><?php echo htmlentities($msg); ?></div>
                    <?php } ?>
                </div>

                <?php 
                $sql=mysqli_query($con,"select * from users where id='".$_SESSION['id']."'");
                while($data=mysqli_fetch_array($sql))
                {
                ?>
                <div class="card p-4">
                    <h4 class="mb-3"><?php echo htmlentities($data['fullName']);?>'s Profile</h4>
                    <p><strong>Profile Reg. Date:</strong> <?php echo htmlentities($data['regDate']);?></p>
                    <?php if($data['updationDate']){?>
                        <p><strong>Profile Last Updated:</strong> <?php echo htmlentities($data['updationDate']);?></p>
                    <?php } ?>
                    <hr>

                    <form method="post" class="row g-3">
                        <div class="col-md-6">
                            <label for="fname" class="form-label">User Name</label>
                            <input type="text" name="fname" class="form-control" value="<?php echo htmlentities($data['fullName']);?>">
                        </div>

                        <div class="col-md-6">
                            <label for="city" class="form-label">City</label>
                            <input type="text" name="city" class="form-control" required value="<?php echo htmlentities($data['city']);?>">
                        </div>

                        <div class="col-12">
                            <label for="address" class="form-label">Address</label>
                            <textarea name="address" class="form-control"><?php echo htmlentities($data['address']);?></textarea>
                        </div>

                        <div class="col-md-6">
                            <label for="gender" class="form-label">Gender</label>
                            <select name="gender" class="form-select" required>
                                <option value="<?php echo htmlentities($data['gender']);?>" selected><?php echo htmlentities($data['gender']);?></option>
                                <option value="male">Male</option>
                                <option value="female">Female</option>
                                <option value="other">Other</option>
                            </select>
                        </div>

                        <div class="col-md-6">
                            <label for="uemail" class="form-label">Email</label>
                            <input type="email" name="uemail" class="form-control" readonly value="<?php echo htmlentities($data['email']);?>">
                            <small><a href="change-emaild.php">Update your email</a></small>
                        </div>

                        <div class="col-12 mt-3">
                            <button type="submit" name="submit" class="btn btn-primary update-btn">Update Profile</button>
                        </div>
                    </form>
                </div>
                <?php } ?>
            </main>
        </div>
        <?php include('include/footer.php'); ?>
        <?php include('include/setting.php'); ?>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>

    <script>
        // Auto-hide success message after 3 seconds
        window.addEventListener('DOMContentLoaded', () => {
            const msg = document.getElementById('success-msg');
            if(msg){
                setTimeout(() => {
                    msg.style.transition = "opacity 0.8s ease, max-height 0.8s ease, margin 0.8s ease, padding 0.8s ease";
                    msg.style.opacity = '0';
                    msg.style.maxHeight = '0';
                    msg.style.margin = '0';
                    msg.style.padding = '0';
                    setTimeout(() => { msg.remove(); }, 800);
                }, 3000);
            }
        });
    </script>
</body>
</html>
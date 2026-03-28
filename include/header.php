<?php error_reporting(0);?>

<header class="navbar navbar-default navbar-static-top">

<style>

.navbar {
    background: #2563eb;
    border: none;
    padding: 10px 20px;
}

/* Title */
.app-title {
    font-size: 20px;
    font-weight: bold;
    color: white;
    line-height: 40px;
    margin-left: 10px;
}

/* User section */
.navbar-right > li > a {
    color: white !important;
}

/* Profile image */
.current-user img {
    width: 35px;
    height: 35px;
    border-radius: 50%;
    margin-right: 5px;
}

/* Dropdown */
.dropdown-menu {
    border-radius: 10px;
}
</style>

<div class="container-fluid">

    <!-- LEFT TITLE -->
    <div class="pull-left app-title">
        Health Data Information & Management System
    </div>

    <!-- RIGHT USER -->
    <ul class="nav navbar-nav navbar-right">

        <li class="dropdown current-user">
            <a href="#" class="dropdown-toggle" data-toggle="dropdown">

                <img src="assets/images/default-user.png" class="user-img">

                <span class="username">
                    <?php 
                    $query = mysqli_query($con,"select fullName from users where id='".$_SESSION['id']."'");
                    while($row = mysqli_fetch_array($query)) {
                        echo $row['fullName'];
                    }
                    ?>
                    <i class="ti-angle-down"></i>
                </span>

            </a>

            <ul class="dropdown-menu dropdown-dark">
                <li><a href="edit-profile.php">My Profile</a></li>
                <li><a href="change-password.php">Change Password</a></li>
                <li><a href="logout.php">Log Out</a></li>
            </ul>
        </li>

    </ul>

</div>

</header>

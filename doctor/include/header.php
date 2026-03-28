<?php error_reporting(0);?>

<style>
.navbar-custom {
    width: 100%;
    background-color: #007bff;
    padding: 12px 20px;
    display: flex;
    justify-content: space-between;
    align-items: center;
    box-sizing: border-box;
}

/* CLICKABLE TITLE */
.navbar-title {
    color: #fff;
    font-size: 22px;
    font-weight: 600;
    margin: 0;
    text-decoration: none;
}

.navbar-title:hover {
    color: #e2e8f0;
}

/* RIGHT USER SECTION */
.user-section {
    display: flex;
    align-items: center;
    gap: 10px;
}

/* IMAGE */
.user-section img {
    width: 35px;
    height: 35px;
    border-radius: 50%;
}

/* NAME */
.username {
    color: #fff;
    font-weight: 500;
}

/* DROPDOWN FIX */
.dropdown-menu {
    right: 0;
    left: auto;
}
</style>

<header class="navbar-custom">

    <!-- LEFT (CLICKABLE) -->
    <a href="dashboard.php" class="navbar-title">
        Hospital Management System
    </a>

    <!-- RIGHT -->
    <div class="dropdown user-section">
        <a href="#" class="dropdown-toggle" data-toggle="dropdown" style="display:flex; align-items:center; text-decoration:none;">
            
            <img src="assets/images/media-user.png">

            <span class="username">
                <?php 
                $query=mysqli_query($con,"select doctorName from doctors where id='".$_SESSION['id']."'");
                while($row=mysqli_fetch_array($query)) {
                    echo $row['doctorName'];
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
    </div>

</header>

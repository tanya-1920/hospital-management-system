<!-- ADMIN HEADER -->



<?php error_reporting(0);?>

<style>
/* HEADER BACKGROUND */
.custom-header {
    background: linear-gradient(135deg, #2d6cdf, #1a4db3);
    border: none;
    margin-bottom: 0;
    padding: 10px 15px;
}

/* FLEX ALIGNMENT */
.header-container {
    display: flex;
    align-items: center;
    justify-content: space-between;
}

/* LOGO */
.custom-brand {
    color: white !important;
    font-size: 22px;
    font-weight: 600;
    letter-spacing: 1px;
    text-decoration: none;
}

/* RIGHT SIDE */
.header-right {
    display: flex;
    align-items: center;
}

/* USER SECTION */
.current-user a {
    display: flex;
    align-items: center;
    color: white !important;
    text-decoration: none;
}

/* PROFILE IMAGE */
.user-img {
    width: 32px;
    height: 32px;
    border-radius: 50%;
    margin-right: 8px;
}

/* USERNAME */
.username {
    font-size: 14px;
}

/* DROPDOWN */
.dropdown-menu {
    border-radius: 8px;
    min-width: 150px;
}


.current-user a:hover {
    background: transparent !important;
}
</style>

<header class="navbar navbar-default navbar-static-top custom-header">

    <div class="header-container">

        <!-- LEFT: LOGO -->
        <a class="custom-brand" href="#">
            HDIMS
        </a>

        <!-- RIGHT: USER -->
        <ul class="nav navbar-right header-right">

            <li class="dropdown current-user">
                <a href="#" class="dropdown-toggle" data-toggle="dropdown">

                    <img src="assets/images/default-user.png" class="user-img">

                    <span class="username">
                        Admin <i class="ti-angle-down"></i>
                    </span>

                </a>

                <ul class="dropdown-menu dropdown-dark">
                    <li>
                        <a href="change-password.php">Change Password</a>
                    </li>
                    <li>
                        <a href="logout.php">Log Out</a>
                    </li>
                </ul>
            </li>

        </ul>

    </div>

</header>

<!-- USER APPOINTMENT TRACKING - COMING SOON -->

<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Track Appointment - Coming Soon</title>

<link rel="stylesheet" href="assets/css/bootstrap.min.css">
<link rel="stylesheet" href="assets/css/fontawsom-all.min.css">

<style>

/* ===== FULL PAGE CENTER ===== */
body {
    margin: 0;
    height: 100vh;
    display: flex;
    align-items: center;
    justify-content: center;
    background: #f4f7fb;
    font-family: 'Segoe UI', sans-serif;
}

/* ===== CARD ===== */
.coming-card {
    max-width: 500px;
    width: 90%;
    background: #ffffff;
    padding: 40px 30px;
    border-radius: 14px;
    text-align: center;
    box-shadow: 0 15px 40px rgba(0,0,0,0.08);
    animation: fadeIn 0.6s ease-in-out;
}

/* ===== ICON ===== */
.icon-box {
    font-size: 40px;
    color: #0d6efd;
    margin-bottom: 15px;
}

/* ===== TEXT ===== */
.coming-card h2 {
    font-weight: 600;
    margin-bottom: 10px;
}

.coming-card p {
    color: #6c757d;
    margin-bottom: 25px;
    line-height: 1.6;
}

/* ===== BUTTON ===== */
.btn-back {
    padding: 10px 20px;
    border-radius: 8px;
    background: #0d6efd;
    color: #fff;
    border: none;
    text-decoration: none;
    transition: 0.3s;
}

.btn-back:hover {
    background: #0b5ed7;
}

/* ===== ANIMATION ===== */
@keyframes fadeIn {
    from {
        opacity: 0;
        transform: translateY(20px);
    }
    to {
        opacity: 1;
        transform: translateY(0);
    }
}

</style>
</head>

<body>

<div class="coming-card">

    <!-- 🔥 BACK BUTTON (TOP LEFT) -->
    

    <div class="icon-box">
        <i class="fas fa-tools"></i>
    </div>

    <h2>Feature Under Development</h2>

    <p>
        The <strong> Appointment Tracking </strong> feature is currently under development.<br>
        Our team is working to make it available soon with improved functionality and user experience.
    </p>

    <!-- OPTIONAL BUTTON (keep if you want) -->
    <button onclick="goBack()" class="btn-back">
         Go Back to Dashboard
    </button>

</div>

<script>
function goBack() {
    window.history.back();
}
</script>

</body>
</html>
<?php
// Start the session if it isn't already started
session_start();

// If the user is logged in, they can log out
if (isset($_SESSION['user_id'])) {
    // Initialize the session timeout countdown
    $_SESSION['logout_countdown'] = time() + 10;
} else {
    // If the user is not logged in, redirect to login page
    header('Location: login.php');
    exit();
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Logout</title>
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Bootstrap Icons -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.9.1/font/bootstrap-icons.css">
    <script src="strip.js"></script>
    <link rel="stylesheet" type="text/css" href="lele.css" />
    <script src="theme.js" defer></script>
    <script src="Ukulele.js" defer></script>
    <style>
        .top-strip {
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100px;
            background-color: rgba(0, 0, 50, 0.8);
            z-index: 1;
        }
        .centered-div {
            position: fixed;
            top: 50%;
            left: 50%;
            transform: translate(-50%, -50%);
            text-align: center;
            padding: 20px;
            background-color: white;
            border-radius: 8px;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
            width: 300px;
        }
        .countdown-slider {
            width: 100%;
            height: 10px;
            background-color: #ddd;
        }
        .slider {
            height: 10px;
            background-color: #28a745;
        }
    </style>
    <script>
        let countdownTime = 10;
        let countdownInterval;
        let cancelButton;

        function startCountdown() {
            let slider = document.getElementById('slider');
            cancelButton = document.getElementById('cancelButton');
            let countdownDisplay = document.getElementById('countdown');

            countdownInterval = setInterval(function () {
                countdownTime--;
                countdownDisplay.innerText = countdownTime;

                slider.style.width = (countdownTime * 10) + '%';

                if (countdownTime <= 0) {
                    clearInterval(countdownInterval);
                    window.location.href = 'login.php';  // Redirect to login page if countdown ends
                }
            }, 1000);
        }

        function cancelLogout() {
            clearInterval(countdownInterval);
            window.location.href = 'custDash.php';  // Redirect to dashboard if cancel is clicked
        }

        window.onload = function () {
            startCountdown();
        }
    </script>
</head>
<body id = "Trey">
    <div class="top-strip"></div>
        <!-- Sidebar Menu -->
        <div id="Sidebar">
        <div class="toggle-btn" onclick="show()">
            <span></span>
            <span></span>
            <span></span>
        </div>
        <ul class="list-unstyled">
            <li class="d-flex align-items-center py-3">
                <i class="bi bi-house-door-fill me-3 text-white"></i>
                <a href="custDash.php" class="text-white text-decoration-none">Dashboard</a>
            </li>
            <li class="d-flex align-items-center py-3">
                <i class="bi bi-file-earmark-text me-3 text-white"></i>
                <a href="Services.php" class="text-white text-decoration-none">Services</a>
            </li>
            <li class="d-flex align-items-center py-3">
                <i class="bi bi-graph-up-arrow me-3 text-white"></i>
                <a href="Finances.php" class="text-white text-decoration-none">Finances</a>
            </li>
            <li class="d-flex align-items-center py-3">
                <i class="bi bi-chat-left-text me-3 text-white"></i>
                <a href="Reports.php" class="text-white text-decoration-none">Reports</a>
            </li>
            <li class="d-flex align-items-center py-3">
                <i class="bi bi-info-circle me-3 text-white"></i>
                <a href="feedback.php" class="text-white text-decoration-none">Feedback</a>
            </li>
            <li class="d-flex align-items-center py-3">
                <i class="bi bi-people me-3 text-white"></i>
                <a href="logout.php" class="text-white text-decoration-none">Log Out</a>
            </li>
        </ul>
    </div>
    <div class="centered-div">
        <h4>Logging Out</h4>
        <p>You will be logged out in:</p>
        <div id="countdown" class="mb-3" style="font-size: 24px; font-weight: bold;">10</div>
        <div class="countdown-slider">
            <div id="slider" class="slider" style="width: 100%;"></div>
        </div>
        <div class="mt-3">
            <button id="cancelButton" class="btn btn-danger" onclick="cancelLogout()">Cancel</button>
        </div>
    </div>
</body>
</html>

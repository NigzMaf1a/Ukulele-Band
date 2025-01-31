<?php
session_start();
include 'connection.php'; // Ensure this file connects to your database

function switchUser($email, $password) {
    global $conn;
    $query = "SELECT * FROM Registration WHERE Email = ? AND Password = ? AND RegType = 'Admin' AND accStatus = 'Approved'";
    $stmt = $conn->prepare($query);
    $stmt->bind_param("ss", $email, $password);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows === 1) {
        $adminData = $result->fetch_assoc();
        
        // Save the current session before switching
        $_SESSION['previous_user'] = $_SESSION; // Save current session data
        session_regenerate_id(true); // Create new session ID for security

        // Set session data for the switched admin user
        $_SESSION['admin_id'] = $adminData['RegID'];
        $_SESSION['admin_name'] = $adminData['Name'];
        $_SESSION['admin_email'] = $adminData['Email'];
        $_SESSION['logged_in'] = true;

        // Redirect to the admin dashboard or other page
        header("Location: admin_dashboard.php");
        exit();
    } else {
        return "Invalid email or password for Admin user.";
    }
}

$error = "";
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $email = $_POST['email'];
    $password = $_POST['password'];

    $error = switchUser($email, $password);
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Switch User</title>
    <link rel="stylesheet" type="text/css" href="lele.css"/>
    <link href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
	<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.9.1/font/bootstrap-icons.css">
    <script src="Ukulele.js" defer></script>
	<script src="theme.js" defer></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
</head>
<body id="Trey">
<!-- Sidebar -->
<div id="Sidebar">
    <div class="toggle-btn" onclick="show()">
        <span></span>
        <span></span>
        <span></span>
    </div>
    <ul class="list-unstyled">
        <li class="d-flex align-items-center py-3">
            <i class="bi bi-house-door-fill me-3 text-white"></i>
            <a href="dashboard.php" class="text-white text-decoration-none">Dashboard</a>
        </li>
        <li class="d-flex align-items-center py-3">
            <i class="bi bi-person-circle me-3 text-white"></i>
            <a href="accounts.php" class="text-white text-decoration-none">Accounts</a>
        </li>
        <li class="d-flex align-items-center py-3">
            <i class="bi bi-file-earmark-text me-3 text-white"></i>
            <a href="reports.php" class="text-white text-decoration-none">Reports</a>
        </li>
        <li class="d-flex align-items-center py-3">
            <i class="bi bi-graph-up-arrow me-3 text-white"></i>
            <a href="analytics.php" class="text-white text-decoration-none">Analytics</a>
        </li>
        <li class="d-flex align-items-center py-3">
            <i class="bi bi-chat-left-text me-3 text-white"></i>
            <a href="feedback.php" class="text-white text-decoration-none">Feedback</a>
        </li>
        <li class="d-flex align-items-center py-3">
            <i class="bi bi-info-circle me-3 text-white"></i> <!-- Icon for About & Contact -->
            <a href="about.php" class="text-white text-decoration-none">About & Contact</a>
        </li>

        <li class="d-flex align-items-center py-3">
            <i class="bi bi-gear-fill me-3 text-white"></i>
            <a href="settings.php" class="text-white text-decoration-none">Settings</a>
        </li>
        <li class="d-flex align-items-center py-3">
            <i class="bi bi-people me-3 text-white"></i>
            <a href="switchUser.php" class="text-white text-decoration-none">Switch User</a>
        </li>
        <li class="d-flex align-items-center py-3">
            <i class="bi bi-person-plus-fill me-3 text-white"></i>
            <a href="addUser.php" class="text-white text-decoration-none">Add User</a>
        </li>
        <li class="d-flex align-items-center py-3">
            <i class="bi bi-box-arrow-right me-3 text-white"></i>
            <a href="logout.php" class="text-white text-decoration-none">Logout</a>
        </li>
    </ul>
</div>
    <div class="container d-flex justify-content-center align-items-center vh-100">
        <div class="card p-4" style="width: 300px;">
            <h4 class="text-center mb-4">Switch Admin</h4>
            <form method="post" action="">
                <div class="form-group">
                    <label for="email">Email</label>
                    <div class="input-group">
                        <div class="input-group-prepend">
                            <span class="input-group-text"><i class="fas fa-envelope"></i></span>
                        </div>
                        <input type="email" class="form-control" id="email" name="email" required>
                    </div>
                </div>
                <div class="form-group">
                    <label for="password">Password</label>
                    <div class="input-group">
                        <div class="input-group-prepend">
                            <span class="input-group-text"><i class="fas fa-lock"></i></span>
                        </div>
                        <input type="password" class="form-control" id="password" name="password" required>
                    </div>
                </div>
                <button type="submit" class="btn btn-primary btn-block" id="Subz">Switch User</button>
                <?php if (!empty($error)): ?>
                    <p class="text-danger text-center mt-3"><?= $error ?></p>
                <?php endif; ?>
            </form>
        </div>
    </div>

    <script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.5.2/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>

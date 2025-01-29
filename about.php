<?php
// Start session
session_start();

// Check if user is logged in
if (!isset($_SESSION['user_id'])) {
    // Redirect to login if not authenticated
    header('Location: login.php');
    exit();
}
// Include the database connection
require_once 'connection.php';

// Fetch About Us detail
$aboutQuery = "SELECT Detail FROM About LIMIT 1";
$aboutResult = $conn->query($aboutQuery);
$aboutDetail = $aboutResult->fetch_assoc()['Detail'] ?? '';

// Fetch Contact Us details
$contactQuery = "SELECT * FROM Contact LIMIT 1";
$contactResult = $conn->query($contactQuery);
$contactData = $contactResult->fetch_assoc();

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    if (isset($_POST['about_text'])) {
        // Update About Us detail
        $newDetail = $conn->real_escape_string($_POST['about_text']);
        $updateAboutQuery = "UPDATE About SET Detail = '$newDetail'";
        $conn->query($updateAboutQuery);
        $aboutDetail = $newDetail; // Update displayed data
    }

    // Update Contact Us details
    if (isset($_POST['field']) && isset($_POST['new_value'])) {
        $field = $conn->real_escape_string($_POST['field']);
        $newValue = $conn->real_escape_string($_POST['new_value']);
        $updateContactQuery = "UPDATE Contact SET $field = '$newValue'";
        $conn->query($updateContactQuery);
        $contactData[$field] = $newValue; // Update displayed data
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>About & Contact Us</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.9.1/font/bootstrap-icons.css">
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <link rel="stylesheet" type="text/css" href="lele.css"/>
    <script src="theme.js" defer></script>
    <script src="Ukulele.js" defer></script>
    <style>
        /* Fixed top strip */
        .top-strip {
            position: fixed;
            top: 0;
            width: 100%;
            height: 100px;
            background-color: rgba(0, 0, 50, 0.8);
            color: white;
            text-align: center;
            padding: 20px 0;
        }
        /* Positioning and styling for UZZER container */
        #UZZER {
            position: relative;
            top: 20px; /*below the strip*/
            width: 80%;
            margin: auto;
            padding: 2rem;
            
        }
        
        #aboutZ{
            z-index: 1;
        }
    </style>
</head>
<body id="Trey">
<!-- Top Strip (Dynamic Color Change) -->
<div class="top-strip"></div>

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
            <i class="bi bi-people me-3 text-white"></i>
            <a href="admUser.php" class="text-white text-decoration-none">User</a>
        </li>
    </ul>
</div>
<div id="UZZER" class="text-center">
<div class="container mt-5">
    <!-- Tabs Navigation -->
    <ul class="nav nav-tabs mb-4" id="myTab" role="tablist">
        <li class="nav-item" role="presentation">
            <a class="nav-link active" id="about-tab" data-bs-toggle="tab" href="#about" role="tab" aria-controls="about" aria-selected="true">About Us</a>
        </li>
        <li class="nav-item" role="presentation">
            <a class="nav-link" id="contact-tab" data-bs-toggle="tab" href="#contact" role="tab" aria-controls="contact" aria-selected="false">Contact Us</a>
        </li>
    </ul>

    <!-- Tabs Content -->
    <div class="tab-content" id="myTabContent">
        <!-- About Us Tab -->
        <div class="tab-pane fade show active" id="about" role="tabpanel" aria-labelledby="about-tab">
            <div class="card p-3 border">
                <h5><i class="bi bi-info-circle"></i> About Us</h5>
                <p><?php echo htmlspecialchars($aboutDetail); ?></p>
                <form method="post" class="d-flex align-items-center">
                    <input type="text" name="about_text" class="form-control me-2" placeholder="Update About Us" required>
                    <button type="submit" class="btn btn-primary">Change</button>
                </form>
            </div>
        </div>

        <!-- Contact Us Tab -->
<div class="tab-pane fade" id="contact" role="tabpanel" aria-labelledby="contact-tab">
    <div class="card p-3 border">
        <h5><i class="bi bi-telephone-fill"></i> Contact Us</h5>

        <!-- Display Contact Information -->
        <?php if ($contactData): ?>
            <div class="d-flex justify-content-between align-items-center mb-3">
                <span><i class="bi bi-phone"></i> Phone No: <?php echo $contactData['PhoneNo']; ?></span>
                <button class="btn btn-sm btn-link" onclick="toggleInput('PhoneNo')">Change</button>
            </div>
            <div class="d-flex justify-content-between align-items-center mb-3">
                <span><i class="bi bi-envelope"></i> Email Address: <?php echo $contactData['EmailAddress']; ?></span>
                <button class="btn btn-sm btn-link" onclick="toggleInput('EmailAddress')">Change</button>
            </div>
            <div class="d-flex justify-content-between align-items-center mb-3">
                <span><i class="bi bi-instagram"></i> Instagram: <?php echo $contactData['Instagram']; ?></span>
                <button class="btn btn-sm btn-link" onclick="toggleInput('Instagram')">Change</button>
            </div>
            <div class="d-flex justify-content-between align-items-center mb-3">
                <span><i class="bi bi-facebook"></i> Facebook: <?php echo $contactData['Facebook']; ?></span>
                <button class="btn btn-sm btn-link" onclick="toggleInput('Facebook')">Change</button>
            </div>
            <div class="d-flex justify-content-between align-items-center mb-3">
                <span><i class="bi bi-mailbox"></i> PO Box: <?php echo $contactData['POBox']; ?></span>
                <button class="btn btn-sm btn-link" onclick="toggleInput('POBox')">Change</button>
            </div>

            <!-- Hidden form for each field update -->
            <form method="post" class="d-none" id="contactForm">
                <input type="hidden" name="field" id="field">
                <input type="text" name="new_value" id="new_value" class="form-control mt-2">
                <button type="submit" class="btn btn-primary mt-2">Update</button>
            </form>
        <?php endif; ?>
    </div>
</div>
</div>
<script>
    // Ensure Bootstrap's tab functionality works
    var myTab = new bootstrap.Tab(document.getElementById('myTab'));

    function toggleInput(field) {
        document.getElementById('field').value = field;
        document.getElementById('new_value').value = '';
        document.getElementById('contactForm').classList.toggle('d-none');
    }
</script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
<script src="strip.js"></script>
</body>
</html>

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
require_once 'connection.php'; // Update to the correct path if needed

// Fetch pending and inactive accounts
$pendingAccounts = [];
$inactiveAccounts = [];

// Query for pending accounts
$pendingQuery = "SELECT RegID, Name1, Name2,Email FROM Registration WHERE accStatus = 'Pending'";
$pendingResult = mysqli_query($conn, $pendingQuery);
if ($pendingResult) {
    while ($row = mysqli_fetch_assoc($pendingResult)) {
        $pendingAccounts[] = $row;
    }
}

// Query for inactive accounts
$inactiveQuery = "SELECT RegID, Name1, Name2,Email FROM Registration WHERE accStatus = 'Inactive'";
$inactiveResult = mysqli_query($conn, $inactiveQuery);
if ($inactiveResult) {
    while ($row = mysqli_fetch_assoc($inactiveResult)) {
        $inactiveAccounts[] = $row;
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.9.1/font/bootstrap-icons.css">
    <link rel="stylesheet" type="text/css" href="lele.css"/>
    <script src="theme.js" defer></script>
    <script src="Ukulele.js" defer></script>
    <script type="module">
    import { 
        initializeDashboard, 
        approveAccount, 
        disableAccount, 
        reactivateAccount, 
        deleteAccount 
    } from './dashboard.js';

    // Wait for the DOM to load before executing any code
    document.addEventListener('DOMContentLoaded', async function () {
        // Initialize the dashboard (e.g., fetch and render data dynamically)
        await initializeDashboard();

        // Attach event delegation for buttons dynamically added to the DOM
        document.addEventListener('click', (event) => {
            const target = event.target;

            // Approve Button Click
            if (target.classList.contains('approve-btn')) {
                const regId = target.dataset.regId;
                if (regId) {
                    handleApproveAccount(regId);
                } else {
                    alert('Invalid account ID for approval.');
                }
            }

            // Disable Button Click
            else if (target.classList.contains('disable-btn')) {
                const regId = target.dataset.regId;
                if (regId) {
                    handleDisableAccount(regId);
                } else {
                    alert('Invalid account ID for disabling.');
                }
            }

            // Reactivate Button Click
            else if (target.classList.contains('reactivate-btn')) {
                const regId = target.dataset.regId;
                if (regId) {
                    handleReactivateAccount(regId);
                } else {
                    alert('Invalid account ID for reactivation.');
                }
            }

            // Delete Button Click
            else if (target.classList.contains('delete-btn')) {
                const regId = target.dataset.regId;
                if (regId && confirm('Are you sure you want to delete this account? This action cannot be undone.')) {
                    handleDeleteAccount(regId);
                } else if (!regId) {
                    alert('Invalid account ID for deletion.');
                }
            }
        });
    });

    // Handle Approve Account
    async function handleApproveAccount(regId) {
        try {
            await approveAccount(regId);
            alert('Account approved successfully!');
        } catch (error) {
            console.error('Error approving account:', error);
            alert('An error occurred while approving the account.');
        }
    }

    // Handle Disable Account
    async function handleDisableAccount(regId) {
        try {
            await disableAccount(regId);
            alert('Account disabled successfully!');
        } catch (error) {
            console.error('Error disabling account:', error);
            alert('An error occurred while disabling the account.');
        }
    }

    // Handle Reactivate Account
    async function handleReactivateAccount(regId) {
        try {
            await reactivateAccount(regId);
            alert('Account reactivated successfully!');
        } catch (error) {
            console.error('Error reactivating account:', error);
            alert('An error occurred while reactivating the account.');
        }
    }

    // Handle Delete Account
    async function handleDeleteAccount(regId) {
        try {
            await deleteAccount(regId);
            alert('Account deleted successfully!');
        } catch (error) {
            console.error('Error deleting account:', error);
            alert('An error occurred while deleting the account.');
        }
    }
</script>

<style>
    /* Inline styles */
    body, html { height: 100%; margin: 0; }
    #numz {
        height: auto; /* Allow #numz to grow based on content */
        width: 80%; /* Adjust width to make the divs smaller */
        padding: 1%; /* Add padding to #numz */
        border-radius: 15px;
        display: flex;
        justify-content: space-between; /* Add spacing between divs */
        margin: auto; /* Center #numz */
        gap: 20px; /* Add a gap between divs */
    }
    /* Top strip styling */
    .top-strip {
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100px;
            background-color: rgba(0, 0, 50, 0.8);
        }
    .status-div {
        height: 300px; /* Increase the height of each div */
        display: flex;
        flex-direction: column;
        justify-content: center;
        align-items: center;
        padding: 20px 10px; /* Add padding inside each div (more padding on top and bottom) */
        cursor: pointer;
        border-radius: 15px;
        flex-grow: 1;
        margin: 20px 10px; /* Add consistent margin (20px top and bottom, 10px left and right) */
    }

    /* Color settings */
    #yellow { background-color: #FBB117; }
    #green { background-color: #254117; color: white; }
    #red { background-color: #C11B17; color: white; }

    /* Resize styles for text elements */
    #yellow p, #green p, #red p {
        font-size: 2rem; /* Smaller font size for <p> */
        margin: 0; /* Remove margin */
    }

    #yellow h, #green h, #red h {
        font-size: 3rem; /* Adjust font size for <h> */
        font-weight: bold;
        margin: 0; /* Remove margin */
    }

    /* Resize on small screens */
    @media (max-width: 768px) {
        #numz {
            flex-direction: column; /* Stack the divs vertically on small screens */
            width: 90%; /* Increase the width to 90% */
        }
        .status-div {
            width: 100%; /* Take up full width of the container */
            margin-bottom: 20px; /* Add space between stacked divs */
            height: auto; /* Allow divs to adjust height based on content */
            padding: 20px 10px; /* Ensure divs have enough padding */
        }
    }
</style>

</head>
<body class="d-flex justify-content-around align-items-center" id="Trey">
<div class="top-strip"></div>
    <div id="numz">
        <div id="yellow" class="status-div" onclick="window.location.href='pending.php'">
            <p>Pending</p>
            <h id="appDis"><?php echo count($pendingAccounts); ?></h>
        </div>
        <div id="green" class="status-div" onclick="window.location.href='approved.php'">
            <p>Approved</p>
            <h id="penDis"><?php echo count($inactiveAccounts); ?></h>
        </div>
        <div id="red" class="status-div" onclick="window.location.href='inactive.php'">
            <p>Inactive</p>
            <h id="innDis"><?php echo count($inactiveAccounts); ?></h>
        </div>
    </div>

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

    <!-- Scripts -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script>
        $(document).ready(function () {
            let windowWidth = $(window).width();
            if (windowWidth < 768) {
                // If the screen width is smaller than 768px, apply styles for mobile view
                $('#numz').css({
                    'flex-direction': 'column',
                    'height': 'auto',
                });
                $('.status-div').css({
                    'width': '100%',
                    'margin-bottom': '10px',
                });
            } else {
                // If the screen width is larger than 768px, apply styles for desktop view
                $('#numz').css({
                    'flex-direction': 'row',
                    'height': '50%',
                    'width': '90%',
                });
                $('.status-div').css({
                    'width': '30%',
                    'margin-bottom': '0',
                });
            }
        });
    </script>
    <script src="strip.js"></script>
</body>
</html>

<?php
// Start session
session_start();

// Check if user is logged in
if (!isset($_SESSION['user_id'])) {
    // Redirect to login if not authenticated
    header('Location: login.php');
    exit();
}

// Include the database connection file
require_once 'connection.php';

// Fetch feedback data
$sql = "SELECT FeedbackID, CustomerID, Name, Comments, Response FROM Feedback";
$result = $conn->query($sql);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Feedback</title>
    <link href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.9.1/font/bootstrap-icons.css">
    <script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
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
        #table-div {
            margin-top: 0; /* 10% below the top strip */
            border-radius: 15px;
        }
    </style>
</head>
<body id="Trey">
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
<div class="container mt-5" id="table-div">
    <h2>Customer Feedback</h2>
    <table class="table table-bordered">
        <thead>
            <tr>
                <th>Customer ID</th>
                <th>Name</th>
                <th>Comments</th>
                <th>Response</th> <!-- Moved Response column before Rating -->
                <th>Reply</th>
            </tr>
        </thead>
        <tbody>
            <?php if ($result && $result->num_rows > 0): ?>
                <?php while($row = $result->fetch_assoc()): ?>
                    <tr>
                        <td><?php echo htmlspecialchars($row['CustomerID']); ?></td>
                        <td><?php echo htmlspecialchars($row['Name']); ?></td>
                        <td><?php echo htmlspecialchars($row['Comments']); ?></td>
                        <td id="response-<?php echo $row['FeedbackID']; ?>">
                            <?php echo htmlspecialchars($row['Response']); ?> <!-- Display the response if available -->
                        </td>
                        <td>
                            <button class="btn btn-primary" onclick="showReply(<?php echo $row['FeedbackID']; ?>)">Reply</button>
                            <div id="reply-area-<?php echo $row['FeedbackID']; ?>" style="display:none;">
                                <textarea id="comment-<?php echo $row['FeedbackID']; ?>" class="form-control mt-2" placeholder="Type your reply..."></textarea>
                                <button class="btn btn-success mt-2" onclick="submitReply(<?php echo $row['FeedbackID']; ?>)">Send</button>
                            </div>
                        </td>
                    </tr>
                <?php endwhile; ?>
            <?php else: ?>
                <tr>
                    <td colspan="5" class="text-center">No feedback available</td>
                </tr>
            <?php endif; ?>
        </tbody>
    </table>
</div>
</div>
<script>
    function showReply(feedbackId) {
        $('#reply-area-' + feedbackId).toggle();
    }

    function submitReply(feedbackId) {
        var comment = $('#comment-' + feedbackId).val();

        $.ajax({
            url: 'reply.php',
            type: 'POST',
            data: {
                FeedbackID: feedbackId,
                Response: comment
            },
            success: function(response) {
                // Update the response on the page
                $('#response-' + feedbackId).text(comment);
                alert(response); // Optional: show confirmation message
                $('#reply-area-' + feedbackId).hide();
                $('#comment-' + feedbackId).val(''); // Clear the textarea
            },
            error: function(xhr, status, error) {
                alert("An error occurred: " + error);
            }
        });
    }
</script>
<script src="strip.js"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>
</html>

<?php
$conn->close();
?>

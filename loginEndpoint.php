<?php
header('Content-Type: application/json');

include 'connection.php';

// Get the POST data
$data = json_decode(file_get_contents('php://input'), true);
$email = $data['Email'];
$password = $data['Password'];

// Query to check if the email exists, account status is "Approved", and fetch CustomerID
$sql = "
    SELECT 
        r.RegID,
        r.Name1 AS RegName1,
        r.Name2 AS RegName2,
        r.Email AS RegEmail,
        r.Password AS RegPassword,
        r.accStatus,
        c.CustomerID,
        c.Name1 AS CustName1,
        c.PhoneNo AS CustPhoneNo,
        c.AccountBalance
    FROM 
        Registration r
    INNER JOIN 
        Customer c ON r.RegID = c.RegID
    WHERE 
        r.Email = ? AND r.accStatus = 'Approved'
";
$stmt = $conn->prepare($sql);
$stmt->bind_param("s", $email);
$stmt->execute();
$result = $stmt->get_result();

// Check if a matching record is found
if ($result->num_rows > 0) {
    $user = $result->fetch_assoc();
    
    // Verify the password
    if (password_verify($password, $user['RegPassword'])) {
        // Start the session
        session_start();
        
        // Set session variables with CustomerID and other details
        $_SESSION['customer_id'] = $user['CustomerID']; // Updated to match reportsEndpoint.php
        $_SESSION['user_email'] = $user['RegEmail'];
        $_SESSION['user_name'] = $user['CustName1'];
        $_SESSION['user_phone'] = $user['CustPhoneNo'];
        $_SESSION['user_balance'] = $user['AccountBalance'];

        // Send a success response
        echo json_encode([
            "status" => "success",
            "message" => "Login successful",
            "redirect_url" => "custDash.php" // You can use this to redirect in the frontend
        ]);
    } else {
        // Password mismatch
        echo json_encode([
            "status" => "error",
            "message" => "Incorrect password."
        ]);
    }
} else {
    // No matching email or account not approved
    echo json_encode([
        "status" => "error",
        "message" => "Email not found or account is inactive."
    ]);
}

$conn->close();
?>

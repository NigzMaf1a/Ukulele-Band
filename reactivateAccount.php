<?php
// reactivateAccount.php

// Include the database connection
require_once 'connection.php';

// Set response headers to return JSON
header('Content-Type: application/json');

// Get JSON input
$data = json_decode(file_get_contents('php://input'), true);

if (isset($data['regID'])) {
    $regID = $data['regID'];

    // Prepare the SQL query to update accStatus
    $query = "UPDATE Registration SET accStatus = 'Pending' WHERE RegID = ? AND accStatus = 'Inactive'";
    $stmt = $conn->prepare($query);
    $stmt->bind_param('i', $regID);

    if ($stmt->execute()) {
        echo json_encode(["success" => true]);
    } else {
        echo json_encode(["success" => false, "message" => "Error reactivating account."]);
    }

    $stmt->close();
} else {
    echo json_encode(["success" => false, "message" => "Invalid request: RegID not provided."]);
}

$conn->close();
?>

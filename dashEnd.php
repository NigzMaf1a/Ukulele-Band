<?php
require_once 'connection.php';

header('Content-Type: application/json');

try {
    // Establish a connection to the database
    $conn = new mysqli($host, $username, $password, $database);

    if ($conn->connect_error) {
        throw new Exception("Connection failed: " . $conn->connect_error);
    }

    // Retrieve CustomerID from GET request
    $customerID = isset($_GET['CustomerID']) ? intval($_GET['CustomerID']) : 0;

    if ($customerID <= 0) {
        throw new Exception("Invalid CustomerID");
    }

    // SQL query to fetch customer details
    $sql = "SELECT 
                r.Name1, r.Name2, c.CustomerID, r.PhoneNo, r.Email, 
                r.Gender, r.RegType, r.accStatus
            FROM Registration r
            INNER JOIN Customer c ON r.RegID = c.RegID
            WHERE c.CustomerID = ?";

    $stmt = $conn->prepare($sql);
    if (!$stmt) {
        throw new Exception("Preparation failed: " . $conn->error);
    }

    $stmt->bind_param("i", $customerID);

    if (!$stmt->execute()) {
        throw new Exception("Execution failed: " . $stmt->error);
    }

    $result = $stmt->get_result();

    if ($row = $result->fetch_assoc()) {
        echo json_encode(['status' => 'success', 'data' => $row]);
    } else {
        echo json_encode(['status' => 'error', 'message' => 'No data found for this CustomerID']);
    }
} catch (Exception $e) {
    echo json_encode(['status' => 'error', 'message' => $e->getMessage()]);
} finally {
    if (isset($conn)) {
        $conn->close();
    }
}

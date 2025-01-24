<?php
require_once 'connection.php';

header('Content-Type: application/json');

try {
    $conn = new mysqli($host, $username, $password, $database);

    if ($conn->connect_error) {
        throw new Exception("Connection failed: " . $conn->connect_error);
    }

    $customerID = isset($_GET['CustomerID']) ? intval($_GET['CustomerID']) : 0;

    if ($customerID <= 0) {
        throw new Exception("Invalid CustomerID");
    }

    $sql = "SELECT 
                b.BookingID, b.Genre, b.BookingDate, b.Cost, b.Hours, b.BookStatus
            FROM Booking b
            INNER JOIN Services s ON b.ServiceID = s.ServiceID
            WHERE s.CustomerID = ?
            ORDER BY b.BookingDate DESC
            LIMIT 3";

    $stmt = $conn->prepare($sql);
    if (!$stmt) {
        throw new Exception("Preparation failed: " . $conn->error);
    }

    $stmt->bind_param("i", $customerID);

    if (!$stmt->execute()) {
        throw new Exception("Execution failed: " . $stmt->error);
    }

    $result = $stmt->get_result();

    $bookings = [];
    while ($row = $result->fetch_assoc()) {
        $bookings[] = $row;
    }

    if (count($bookings) > 0) {
        echo json_encode([
            'status' => 'success',
            'CustomerID' => $customerID,
            'LastBookings' => $bookings
        ]);
    } else {
        echo json_encode([
            'status' => 'error',
            'message' => 'No bookings found for this CustomerID'
        ]);
    }
} catch (Exception $e) {
    echo json_encode(['status' => 'error', 'message' => $e->getMessage()]);
} finally {
    if (isset($conn)) {
        $conn->close();
    }
}

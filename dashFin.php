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
                TransactionID, TransactionDate, Amount, TransactType, Balance
            FROM Finance
            WHERE CustomerID = ?
            ORDER BY TransactionDate DESC
            LIMIT 3";

    $stmt = $conn->prepare($sql);
    if (!$stmt) {
        throw new Exception("Preparation failed: " . $stmt->error);
    }

    $stmt->bind_param("i", $customerID);

    if (!$stmt->execute()) {
        throw new Exception("Execution failed: " . $stmt->error);
    }

    $result = $stmt->get_result();

    $transactions = [];
    while ($row = $result->fetch_assoc()) {
        $transactions[] = $row;
    }

    $currentBalance = count($transactions) > 0 ? $transactions[0]['Balance'] : 0;

    if (count($transactions) > 0) {
        echo json_encode([
            'status' => 'success',
            'CustomerID' => $customerID,
            'CurrentBalance' => $currentBalance,
            'RecentTransactions' => $transactions
        ]);
    } else {
        echo json_encode([
            'status' => 'error',
            'message' => 'No transactions found for this CustomerID'
        ]);
    }
} catch (Exception $e) {
    echo json_encode(['status' => 'error', 'message' => $e->getMessage()]);
} finally {
    if (isset($conn)) {
        $conn->close();
    }
}

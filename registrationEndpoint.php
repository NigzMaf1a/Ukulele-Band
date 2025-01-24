<?php
// Include the database connection
require 'connection.php';

// Retrieve and decode the JSON data
$data = json_decode(file_get_contents('php://input'), true);

if (
    isset($data['Name1'], $data['Name2'], $data['PhoneNo'], $data['Email'], 
    $data['Password'], $data['Gender'], $data['dLocation'])
) {
    $name1 = $conn->real_escape_string($data['Name1']);
    $name2 = $conn->real_escape_string($data['Name2']);
    $phoneNo = $conn->real_escape_string($data['PhoneNo']);
    $email = $conn->real_escape_string($data['Email']);
    $password = password_hash($data['Password'], PASSWORD_DEFAULT); // Secure password hashing
    $gender = $conn->real_escape_string($data['Gender']);
    $location = $conn->real_escape_string($data['dLocation']);
    $accStatus = $conn->real_escape_string($data['accStatus'] ?? 'Pending'); // Default to Pending
    $regType = 'Customer'; // Default RegType as Customer

    // Insert into Registration table
    $registrationQuery = "
        INSERT INTO Registration (Name1, Name2, PhoneNo, Email, Password, Gender, RegType, dLocation, accStatus)
        VALUES ('$name1', '$name2', '$phoneNo', '$email', '$password', '$gender', '$regType', '$location', '$accStatus')
    ";

    if ($conn->query($registrationQuery) === TRUE) {
        $regID = $conn->insert_id; // Get the last inserted RegID

        // Insert into Customer table
        $customerQuery = "
            INSERT INTO Customer (RegID, Name1, Email, PhoneNo, Location, AccountBalance)
            VALUES ('$regID', '$name1', '$email', '$phoneNo', '$location', 0)
        ";

        if ($conn->query($customerQuery) === TRUE) {
            http_response_code(200);
            echo json_encode(["success" => "Registration successful."]);
        } else {
            http_response_code(500);
            echo json_encode(["error" => "Error inserting into Customer table: " . $conn->error]);
        }
    } else {
        http_response_code(500);
        echo json_encode(["error" => "Error inserting into Registration table: " . $conn->error]);
    }
} else {
    http_response_code(400);
    echo json_encode(["error" => "Invalid input. Please provide all required fields."]);
}

$conn->close();
?>

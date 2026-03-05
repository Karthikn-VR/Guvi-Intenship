<?php
header('Content-Type: application/json');
header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Methods: POST, GET, OPTIONS');
header('Access-Control-Allow-Headers: Content-Type');

if ($_SERVER['REQUEST_METHOD'] === 'OPTIONS') {
    exit();
}

$servername = "localhost";
$username = "root";
$password = "@Karthiknvr2004";
$dbname = "mydb";

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    echo json_encode(['status' => 'error', 'message' => 'MySQL Connection failed: ' . $conn->connect_error]);
    exit();
}

$user = $_REQUEST['username'] ?? '';

if ($_SERVER['REQUEST_METHOD'] === 'GET') {
    $stmt = $conn->prepare("SELECT age, dob, contact FROM users WHERE username = ?");
    $stmt->bind_param("s", $user);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($row = $result->fetch_assoc()) {
        echo json_encode([
            'status' => 'success', 
            'data' => [
                'age' => $row['age'] ?? '',
                'dob' => $row['dob'] ?? '',
                'contact' => $row['contact'] ?? ''
            ]
        ]);
    } else {
        echo json_encode(['status' => 'success', 'data' => ['age' => '', 'dob' => '', 'contact' => '']]);
    }
    $stmt->close();
} elseif ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $age = $_POST['age'] ?? '';
    $dob = $_POST['dob'] ?? '';
    $contact = $_POST['contact'] ?? '';

    $stmt = $conn->prepare("UPDATE users SET age = ?, dob = ?, contact = ? WHERE username = ?");
    $stmt->bind_param("ssss", $age, $dob, $contact, $user);

    if ($stmt->execute()) {
        echo json_encode(['status' => 'success', 'message' => 'Profile updated successfully!']);
    } else {
        echo json_encode(['status' => 'error', 'message' => 'Profile Update Failed.']);
    }
    $stmt->close();
}
$conn->close();
?>
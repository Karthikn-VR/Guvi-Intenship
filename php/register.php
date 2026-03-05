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

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $user = $_POST['username'] ?? '';
    $email = $_POST['email'] ?? '';
    $pass = password_hash($_POST['password'], PASSWORD_DEFAULT);
    $age = $_POST['age'] ?? '';
    $dob = $_POST['dob'] ?? '';
    $contact = $_POST['contact'] ?? '';

    $stmt = $conn->prepare("INSERT INTO users (username, password, email, age, dob, contact) VALUES (?, ?, ?, ?, ?, ?)");
    $stmt->bind_param("ssssss", $user, $pass, $email, $age, $dob, $contact);

    if ($stmt->execute()) {
        echo json_encode(['status' => 'success', 'message' => 'Registration successful!']);
    } else {
        if ($conn->errno == 1062) {
            echo json_encode(['status' => 'error', 'message' => 'Username or Email already exists.']);
        } else {
            echo json_encode(['status' => 'error', 'message' => 'Error: ' . $stmt->error]);
        }
    }
    $stmt->close();
}
$conn->close();
?>
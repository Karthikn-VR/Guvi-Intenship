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
    echo json_encode([
        'status' => 'error',
        'message' => 'MySQL Connection failed: ' . $conn->connect_error
    ]);
    exit();
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $identifier = $_POST['username'] ?? '';
    $pass = $_POST['password'] ?? '';

    $stmt = $conn->prepare("SELECT id, username, password FROM users WHERE username = ? OR email = ?");
    $stmt->bind_param("ss", $identifier, $identifier);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows === 1) {
        $row = $result->fetch_assoc();
        if (password_verify($pass, $row['password'])) {
            $session_token = bin2hex(random_bytes(32));

            echo json_encode([
                'status' => 'success',
                'message' => 'Login successful!',
                'session_token' => $session_token,
                'username' => $row['username']
            ]);
        } else {
            echo json_encode(['status' => 'error', 'message' => 'Invalid credentials.']);
        }
    } else {
        echo json_encode(['status' => 'error', 'message' => 'Invalid credentials.']);
    }
    $stmt->close();
}
$conn->close();
?>
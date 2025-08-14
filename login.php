<?php
session_start();

// Debug mode: show all PHP errors (disable in production!)
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

// DB connection info
$host = "localhost";
$dbname = "barbershop";
$user = "root";
$password = "";  // Default XAMPP password is empty

// Connect to MySQL
$conn = new mysqli($host, $user, $password, $dbname);

// Check for connection errors
if ($conn->connect_error) {
    die("Database connection failed: " . $conn->connect_error);
}

// Check if form was submitted
if (!isset($_POST['username']) || !isset($_POST['password'])) {
    die("Please enter both username and password.");
}

// Sanitize input
$username = trim($_POST['username']);
$password_input = trim($_POST['password']);

// Prepare query
$stmt = $conn->prepare("SELECT id, username, password FROM users WHERE username = ?");
$stmt->bind_param("s", $username);
$stmt->execute();
$stmt->store_result();

if ($stmt->num_rows === 1) {
    $stmt->bind_result($id, $db_username, $db_password_hash);
    $stmt->fetch();

    // Check if entered password matches the hash from DB
    if (password_verify($password_input, $db_password_hash)) {
        // Success
        $_SESSION['user_id'] = $id;
        $_SESSION['username'] = $db_username;
        header("Location: dashboard.php");  // redirect to your dashboard
        exit();
    } else {
        echo "❌ Invalid password.";
    }
} else {
    echo "❌ User not found.";
}

$stmt->close();
$conn->close();
?>

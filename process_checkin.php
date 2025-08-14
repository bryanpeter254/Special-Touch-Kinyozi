<?php
// Enable error reporting for debugging (remove in production)
ini_set('display_errors', 1);
error_reporting(E_ALL);

// DB config
$host = "localhost";
$user = "root";
$password = "";
$dbname = "barbershop";

// Connect to MySQL
$conn = new mysqli($host, $user, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("❌ Connection failed: " . $conn->connect_error);
}

// Check if form data exists
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $client_name = $_POST['client_name'];
    $service = $_POST['service'];
    $amount_paid = $_POST['amount_paid'];
    $date_of_visit = $_POST['date_of_visit'];
    $barber = $_POST['barber'];

    // Prepare SQL
    $stmt = $conn->prepare("INSERT INTO client_checkins (client_name, service, amount_paid, date_of_visit, barber) VALUES (?, ?, ?, ?, ?)");
    $stmt->bind_param("ssdss", $client_name, $service, $amount_paid, $date_of_visit, $barber);

    if ($stmt->execute()) {
        // ✅ Redirect back to form with success flag
        header("Location: client_checkin.html?success=1");
        exit();
    } else {
        // 🔴 Redirect back with error
        header("Location: client_checkin.html?error=" . urlencode($stmt->error));
        exit();
    }

    $stmt->close();
} else {
    // 🔴 Redirect for invalid request
    header("Location: client_checkin.html?error=invalid_request");
    exit();
}

$conn->close();
?>

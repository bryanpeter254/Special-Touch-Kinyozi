<?php
require_once 'inc/db.php';
session_start();

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $date = trim($_POST['date']);
    $client_name = trim($_POST['client_name']);
    $service_id = intval($_POST['service_id']);
    $price = floatval($_POST['price']);
    $offered_by_id = intval($_POST['offered_by_id']);

    // Validate required fields
    if (empty($date) || empty($client_name) || empty($service_id) || empty($price) || empty($offered_by_id)) {
        header("Location: revenue.php?error=Missing+fields");
        exit();
    }

    // Insert using the correct foreign keys
    $stmt = $conn->prepare("INSERT INTO revenue (date, client_name, service_id, price, offered_by_id) VALUES (?, ?, ?, ?, ?)");
    if (!$stmt) {
        header("Location: revenue.php?error=Prepare+failed:" . urlencode($conn->error));
        exit();
    }

    $stmt->bind_param("ssidi", $date, $client_name, $service_id, $price, $offered_by_id);

    if ($stmt->execute()) {
        header("Location: revenue.php?success=1");
    } else {
        header("Location: revenue.php?error=" . urlencode($stmt->error));
    }

    $stmt->close();
} else {
    header("Location: revenue.php?error=Invalid+request");
}

$conn->close();
?>

<?php
require_once '../inc/db.php';
session_start();

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $name = trim($_POST['name']);
    $amount = trim($_POST['amount']);

    if (empty($name) || empty($amount)) {
        header("Location: ../advances.php?error=All+fields+are+required");
        exit();
    }

    $stmt = $conn->prepare("INSERT INTO advances (name, amount) VALUES (?, ?)");
    $stmt->bind_param("sd", $name, $amount);

    if ($stmt->execute()) {
        header("Location: ../advances.php?success=Advance+added+successfully");
    } else {
        header("Location: ../advances.php?error=" . urlencode($stmt->error));
    }

    $stmt->close();
} else {
    header("Location: ../advances.php?error=Invalid+request");
}
$conn->close();
?>

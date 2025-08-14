<?php
$conn = new mysqli("localhost", "root", "", "barbershop");
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

if ($_SERVER["REQUEST_METHOD"] === "POST" && isset($_POST['id'])) {
    $id = intval($_POST['id']);

    $stmt = $conn->prepare("DELETE FROM revenue WHERE id = ?");
    $stmt->bind_param("i", $id);

    if ($stmt->execute()) {
        header("Location: revenue.php?deleted=1");
    } else {
        header("Location: revenue.php?error=Delete+failed");
    }

    $stmt->close();
} else {
    header("Location: revenue.php?error=Invalid+Request");
}

$conn->close();
?>

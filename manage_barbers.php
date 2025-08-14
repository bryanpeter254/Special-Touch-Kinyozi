<?php
$host = "localhost";
$user = "root";
$password = "";
$dbname = "barbershop";

$conn = new mysqli($host, $user, $password, $dbname);
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Add barber
if (isset($_POST['add_barber'])) {
    $name = $_POST['barber_name'];
    $commission = $_POST['commission_rate'];
    $phone = $_POST['phone'];

    $stmt = $conn->prepare("INSERT INTO barbers (name, commission_rate, phone) VALUES (?, ?, ?)");
    $stmt->bind_param("sds", $name, $commission, $phone);

    if ($stmt->execute()) {
        header("Location: barbers.php?success=Barber added");
    } else {
        header("Location: barbers.php?error=" . urlencode($stmt->error));
    }
    exit();
}

// Delete barber
if (isset($_POST['delete_barber'])) {
    $id = $_POST['barber_id'];

    $stmt = $conn->prepare("DELETE FROM barbers WHERE id = ?");
    $stmt->bind_param("i", $id);

    if ($stmt->execute()) {
        header("Location: barbers.php?success=Barber removed");
    } else {
        header("Location: barbers.php?error=" . urlencode($stmt->error));
    }
    exit();
}

$conn->close();
?>

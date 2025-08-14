<?php
$conn = new mysqli("localhost", "root", "", "barbershop");
if ($conn->connect_error) die("Connection failed: " . $conn->connect_error);

$id = $_POST['id'];
$client_name = $_POST['client_name'];
$amount = $_POST['amount'];
$amount_paid = $_POST['amount_paid'];
$status = $_POST['status'];
$date = $_POST['date'];

$stmt = $conn->prepare("UPDATE debts SET client_name = ?, amount = ?, amount_paid = ?, status = ?, date = ? WHERE id = ?");
$stmt->bind_param("sddssi", $client_name, $amount, $amount_paid, $status, $date, $id);

if ($stmt->execute()) {
  header("Location: debts.php?updated=1");
} else {
  echo "Error updating debt: " . $stmt->error;
}
$stmt->close();
$conn->close();
?>

<?php
// Database connection
$host = "localhost";
$user = "root";
$password = "";
$dbname = "barbershop";

$conn = new mysqli($host, $user, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Query: Total revenue entries this month based on `date` column
$current_month = date('m');
$current_year = date('Y');

$sql = "SELECT COUNT(*) AS total_entries 
        FROM revenue 
        WHERE MONTH(date) = ? AND YEAR(date) = ?";

$stmt = $conn->prepare($sql);
$stmt->bind_param("ss", $current_month, $current_year);
$stmt->execute();
$result = $stmt->get_result();

$row = $result->fetch_assoc();
echo $row['total_entries'];

$stmt->close();
$conn->close();
?>

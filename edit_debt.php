<?php
$conn = new mysqli("localhost", "root", "", "barbershop");
if ($conn->connect_error) die("Connection failed: " . $conn->connect_error);

$id = $_GET['id'] ?? 0;
$query = $conn->query("SELECT * FROM debts WHERE id = $id");
$debt = $query->fetch_assoc();
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>Edit Debt</title>
  <style>
    body {
      font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
      background-color: #f2f2f2;
      margin: 0;
      padding: 0;
    }

    .container {
      max-width: 600px;
      margin: 50px auto;
      background-color: white;
      padding: 30px;
      border-radius: 10px;
      box-shadow: 0 5px 20px rgba(0, 0, 0, 0.1);
    }

    h2 {
      text-align: center;
      color: #333;
      margin-bottom: 30px;
    }

    label {
      display: block;
      margin-bottom: 6px;
      font-weight: bold;
      color: #444;
    }

    input[type="text"],
    input[type="number"],
    input[type="date"],
    select {
      width: 100%;
      padding: 10px;
      margin-bottom: 20px;
      border-radius: 5px;
      border: 1px solid #ccc;
      box-sizing: border-box;
    }

    button {
      background-color: #28a745;
      color: white;
      padding: 12px 20px;
      border: none;
      border-radius: 5px;
      font-size: 16px;
      cursor: pointer;
      width: 100%;
      transition: background-color 0.3s ease;
    }

    button:hover {
      background-color: #218838;
    }

    .back-link {
      text-align: center;
      margin-top: 15px;
    }

    .back-link a {
      color: #007bff;
      text-decoration: none;
    }

    .back-link a:hover {
      text-decoration: underline;
    }
  </style>
</head>
<body>

  <div class="container">
    <h2>✏️ Edit Debt Record</h2>
    <form action="update_debt.php" method="POST">
      <input type="hidden" name="id" value="<?= htmlspecialchars($debt['id']) ?>">

      <label>Client Name:</label>
      <input type="text" name="client_name" value="<?= htmlspecialchars($debt['client_name']) ?>" required>

      <label>Total Amount (KSh):</label>
      <input type="number" step="0.01" name="amount" value="<?= htmlspecialchars($debt['amount']) ?>" required>

      <label>Amount Paid (KSh):</label>
      <input type="number" step="0.01" name="amount_paid" value="<?= htmlspecialchars($debt['amount_paid']) ?>" required>

      <label>Status:</label>
      <select name="status" required>
        <option value="Not Paid" <?= $debt['status'] == 'Not Paid' ? 'selected' : '' ?>>Not Paid</option>
        <option value="Partially Paid" <?= $debt['status'] == 'Partially Paid' ? 'selected' : '' ?>>Partially Paid</option>
        <option value="Paid" <?= $debt['status'] == 'Paid' ? 'selected' : '' ?>>Paid</option>
      </select>

      <label>Date:</label>
      <input type="date" name="date" value="<?= htmlspecialchars($debt['date']) ?>" required>

      <button type="submit">💾 Update Debt</button>
    </form>

    <div class="back-link">
      <a href="debts.php">← Back to Debt Records</a>
    </div>
  </div>

</body>
</html>

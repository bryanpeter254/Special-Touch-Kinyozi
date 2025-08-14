<?php
// expenses.php
$host = "localhost";
$user = "root";
$password = "";
$dbname = "barbershop";

$conn = new mysqli($host, $user, $password, $dbname);
if ($conn->connect_error) die("Connection failed: " . $conn->connect_error);

// Handle delete
if (isset($_GET['delete'])) {
    $id = intval($_GET['delete']);
    $conn->query("DELETE FROM expenses WHERE id = $id");
    header("Location: expenses.php");
    exit();
}

// Handle new submission
if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $date = $_POST['expense_date'];
    $item = $_POST['item'];
    $amount = $_POST['amount'];
    $paid_by = $_POST['paid_by'];
    $notes = $_POST['notes'];

    $stmt = $conn->prepare("INSERT INTO expenses (expense_date, item, amount, paid_by, notes) VALUES (?, ?, ?, ?, ?)");
    $stmt->bind_param("ssdss", $date, $item, $amount, $paid_by, $notes);
    $stmt->execute();
    $stmt->close();
    header("Location: expenses.php");
    exit();
}

// Fetch expenses
$expenses = $conn->query("SELECT * FROM expenses ORDER BY expense_date DESC");
$total = $conn->query("SELECT SUM(amount) AS total FROM expenses")->fetch_assoc()['total'] ?? 0;
?>
<!DOCTYPE html>
<html>
<head>
  <title>Expenses - Special Touch</title>
   <link rel="stylesheet" href="assets/css/style.css">
   <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.7.2/font/bootstrap-icons.css" rel="stylesheet">
 <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css">

  <style>
    body {
      font-family: Arial, sans-serif;
      background: #f4f6f8;
      padding: 20px;
    }

     .side-nav {
            background-color: rgba(0, 0, 0, 0.9);
            padding: 1rem;
            position: fixed;
            top: 0;
            left: 0;
            height: 100vh;
            transform: translateX(-100%);
            transition: transform 0.3s ease-in-out;
            z-index: 1000;
        }

        .side-nav.active {
            transform: translateX(0);
        }

        .side-nav ul {
            list-style: none;
            padding: 0;
            margin: 0;
            margin-top: 60px;
        }

        .side-nav ul li {
            margin: 20px 0;
        }

        .side-nav ul li a {
            color: white;
            text-decoration: none;
            font-size: 1.1rem;
            display: flex;
            align-items: center;
            padding: 10px 20px;
            transition: color 0.3s ease;
        }

        .side-nav ul li a:hover {
            color: var(--bs-success);
        }

        .side-nav ul li a i {
            margin-right: 10px;
        }

        .menu-icon {
            background: none;
            border: none;
            position: fixed;
            top: 20px;
            left: 20px;
            z-index: 1001;
            cursor: pointer;
            padding: 0;
            display: flex;
            flex-direction: column;
            justify-content: space-between;
            width: 30px;
            height: 21px;
        }

        .menu-line {
            width: 100%;
            height: 3px;
            background-color: white;
            transition: transform 0.3s ease, opacity 0.3s ease;
        }

        .menu-icon.active .menu-line:nth-child(1) {
            transform: rotate(45deg) translate(5px, 5px);
        }

        .menu-icon.active .menu-line:nth-child(2) {
            opacity: 0;
        }

        .menu-icon.active .menu-line:nth-child(3) {
            transform: rotate(-45deg) translate(7px, -7px);
        }

        .main-content {
            margin-left: 60px;
            padding: 20px;
        }
    h2 {
      text-align: center;
      margin-bottom: 1rem;
    }
    table {
      width: 100%;
      border-collapse: collapse;
      background: white;
      margin-bottom: 30px;
    }
    th, td {
      padding: 10px;
      border-bottom: 1px solid #ddd;
    }
    th {
      background: #2c3e50;
      color: white;
    }
    tr:hover {
      background: #f0f0f0;
    }
    form {
      background: white;
      padding: 20px;
      box-shadow: 0 2px 8px rgba(0,0,0,0.1);
      margin-bottom: 30px;
    }
    input, textarea {
      width: 100%;
      padding: 10px;
      margin: 8px 0;
    }
    button {
      background: #2c3e50;
      color: white;
      padding: 10px 15px;
      border: none;
      cursor: pointer;
    }
    button:hover {
      background: #34495e;
    }
    .delete-btn {
      background: #e74c3c;
      padding: 6px 10px;
      text-decoration: none;
      color: white;
      border-radius: 4px;
    }
    .delete-btn:hover {
      background: #c0392b;
    }
    .total {
      font-weight: bold;
      background: #ecf0f1;
    }
  </style>
</head>
<body>
   <button class="menu-icon" id="menuToggle">
        <div class="menu-line"></div>
        <div class="menu-line"></div>
        <div class="menu-line"></div>
    </button>

    <nav class="side-nav" id="sideNav">
       <ul>
  <li><a href="dashboard.php"><i class="bi bi-speedometer2"></i> Dashboard</a></li>
  <li><a href="client_checkin.php"><i class="bi bi-person-check"></i> Client Check-In</a></li>
  <li><a href="expenses.php"><i class="bi bi-cash-coin"></i> Expenses</a></li>
  <li><a href="revenue.php"><i class="bi bi-graph-up"></i> Revenue</a></li>
<li><a href="debts.php"><i class="bi bi-credit-card"></i> Debts</a></li>
  <li><a href="monthly_record.php"><i class="bi bi-journal-text"></i> Monthly Record</a></li>
  <li><a href="barbers.php"><i class="bi bi-scissors"></i> Barbers Record</a></li>
 <!--<li><a href="manage_barbers.php"><i class="bi bi-person-gear"></i> Manage Barbers</a></li>-->
 <li><a href="services.php"><i class="bi bi-briefcase"></i> Services</a></li>
<!--<li><a href="monthly_record.php"><i class="bi bi-briefcase"></i> Services</a></li>-->
<li><a href="advances.php"><i class="bi bi-wallet2"></i> Salary Advances</a></li>
  <li><a href="index.html" class="text-danger"><i class="bi bi-box-arrow-right"></i> Logout</a></li>
</ul>

    </nav>

<h2>Expenses Summary</h2>

<form method="POST" action="expenses.php">
  <h3>Add Expense</h3>
  <label>Date:</label>
  <input type="date" name="expense_date" required>
  <label>Item:</label>
  <input type="text" name="item" required>
  <label>Amount:</label>
  <input type="number" name="amount" step="0.01" required>
  <label>Paid By:</label>
  <input type="text" name="paid_by">
  <label>Notes:</label>
  <textarea name="notes" rows="2"></textarea>
  <button type="submit">➕ Add Expense</button>
</form>

<table>
  <tr>
    <th>Date</th>
    <th>Item</th>
    <th>Amount (KSh)</th>
    <th>Paid By</th>
    <th>Notes</th>
    <th>Action</th>
  </tr>
  <?php while ($row = $expenses->fetch_assoc()): ?>
    <tr>
      <td><?= htmlspecialchars($row['expense_date']) ?></td>
      <td><?= htmlspecialchars($row['item']) ?></td>
      <td>KSh <?= number_format($row['amount'], 2) ?></td>
      <td><?= htmlspecialchars($row['paid_by']) ?></td>
      <td><?= htmlspecialchars($row['notes']) ?></td>
      <td><a href="expenses.php?delete=<?= $row['id'] ?>" class="delete-btn">Delete</a></td>
    </tr>
  <?php endwhile; ?>
  <tr class="total">
    <td colspan="2">Total</td>
    <td>KSh <?= number_format($total, 2) ?></td>
    <td colspan="3"></td>
  </tr>
</table>

<script>
        const menuToggle = document.getElementById('menuToggle');
        const sideNav = document.getElementById('sideNav');

        menuToggle.addEventListener('click', () => {
            sideNav.classList.toggle('active');
            menuToggle.classList.toggle('active');
        });

        // Close navigation when clicking outside
        document.addEventListener('click', (e) => {
            if (!sideNav.contains(e.target) && !menuToggle.contains(e.target) && sideNav.classList.contains('active')) {
                sideNav.classList.remove('active');
                menuToggle.classList.remove('active');
            }
        });
    </script>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

</body>
</html>

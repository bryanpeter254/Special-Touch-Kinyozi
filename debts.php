<?php
$conn = new mysqli("localhost", "root", "", "barbershop");
if ($conn->connect_error) {
    die("❌ Connection failed: " . $conn->connect_error);
}

// Handle form submission
if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $client_name = trim($_POST["client_name"]);
    $amount = floatval($_POST["amount"]);
    $amount_paid = floatval($_POST["amount_paid"]);
    $date = $_POST["date"];
    $status = $_POST["status"];

    if (!empty($client_name) && $amount > 0 && $date && $status) {
        $stmt = $conn->prepare("INSERT INTO debts (client_name, amount, amount_paid, date, status) VALUES (?, ?, ?, ?, ?)");
        $stmt->bind_param("sddss", $client_name, $amount, $amount_paid, $date, $status);
        $stmt->execute();
        $stmt->close();
    }
}
?>

<!DOCTYPE html>
<html>
<head>
  <title>Client Debts</title>
  <link rel="stylesheet" href="assets/css/style.css">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.7.2/font/bootstrap-icons.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css" rel="stylesheet">

  <style>
    
    body { font-family: Arial, sans-serif; margin: 20px; }
    h2 { color: #333; }
    form { margin-bottom: 30px; }
    label { display: block; margin: 8px 0 4px; }
    input, select, button {
      width: 100%; padding: 8px; margin-bottom: 10px;
    }
    .table-container { max-height: 400px; overflow-y: auto; border: 1px solid #ccc; }
    table { width: 100%; border-collapse: collapse; }
    th, td { padding: 10px; border-bottom: 1px solid #ddd; text-align: left; }
    thead th { background: #333; color: white; position: sticky; top: 0; }

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
 <li><a href="advances.php"><i class="bi bi-wallet2"></i> Salary Advances</a></li>
<!--<li><a href="monthly_record.php"><i class="bi bi-briefcase"></i> Services</a></li>-->

  <li><a href="index.html" class="text-danger"><i class="bi bi-box-arrow-right"></i> Logout</a></li>
</ul>
    </nav>
  <h2>➕ Record Client Debt</h2>
  <form method="POST" action="">
    <label>Client Name:</label>
    <input type="text" name="client_name" required>

    <label>Total Amount (KSh):</label>
    <input type="number" name="amount" step="0.01" required>

    <label>Amount Paid (KSh):</label>
    <input type="number" name="amount_paid" step="0.01" required>

    <label>Date:</label>
    <input type="date" name="date" required>

    <label>Status:</label>
    <select name="status" required>
      <option value="Not Paid">Not Paid</option>
      <option value="Partially Paid">Partially Paid</option>
      <option value="Paid">Paid</option>
    </select>

    <button type="submit">Add Debt Record</button>
  </form>

  <hr>

  <h3>📄 All Debts</h3>
  <div class="table-container">
    <table>
      <thead>
        <tr>
          <th>Date</th>
          <th>Client Name</th>
          <th>Total (KSh)</th>
          <th>Paid (KSh)</th>
          <th>Balance (KSh)</th>
          <th>Status</th>
        </tr>
      </thead>
      <tbody>
  <?php
  $conn = new mysqli("localhost", "root", "", "barbershop");
  if ($conn->connect_error) {
    echo "<tr><td colspan='8'>❌ Connection failed: " . $conn->connect_error . "</td></tr>";
  } else {
    $result = $conn->query("SELECT id, date, client_name, amount, amount_paid, status FROM debts ORDER BY date DESC");

    if ($result && $result->num_rows > 0) {
      while ($row = $result->fetch_assoc()) {
        $balance = $row['amount'] - $row['amount_paid'];
        echo "<tr>
                <td>" . htmlspecialchars($row['date']) . "</td>
                <td>" . htmlspecialchars($row['client_name']) . "</td>
                <td>KSh " . number_format($row['amount'], 2) . "</td>
                <td>KSh " . number_format($row['amount_paid'], 2) . "</td>
                <td>KSh " . number_format($balance, 2) . "</td>
                <td>" . htmlspecialchars($row['status']) . "</td>
                <td>
                  <a href='edit_debt.php?id=" . $row['id'] . "' class='btn btn-sm btn-warning'>Edit</a>
                </td>
                <td>
                  <form action='delete_debt.php' method='POST' onsubmit=\"return confirm('Are you sure you want to delete this record?');\">
                    <input type='hidden' name='id' value='" . $row['id'] . "'>
                    <button type='submit' class='btn btn-sm btn-danger'>Delete</button>
                  </form>
                </td>
              </tr>";
      }
    } else {
      echo "<tr><td colspan='8'>No debt records found.</td></tr>";
    }

    $conn->close();
  }
  ?>
</tbody>


  </div>
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
</body>
</html>

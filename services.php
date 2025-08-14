<?php
// Enable error reporting
ini_set('display_errors', 1);
error_reporting(E_ALL);

// DB config
$host = "localhost";
$user = "root";
$password = "";
$dbname = "barbershop";

// Connect
$conn = new mysqli($host, $user, $password, $dbname);
if ($conn->connect_error) die("Connection failed: " . $conn->connect_error);

// Add service
if ($_SERVER["REQUEST_METHOD"] === "POST" && isset($_POST['name']) && isset($_POST['price'])) {
    $name = trim($_POST['name']);
    $price = floatval($_POST['price']);

    $stmt = $conn->prepare("INSERT INTO services (name, price) VALUES (?, ?)");
    $stmt->bind_param("sd", $name, $price);
    $stmt->execute();
    $stmt->close();
    header("Location: services.php?success=1");
    exit();
}

// Delete service
if (isset($_GET['delete'])) {
    $id = intval($_GET['delete']);
    $conn->query("DELETE FROM services WHERE id = $id");
    header("Location: services.php?deleted=1");
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>Manage Services - Barbershop</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.7.2/font/bootstrap-icons.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css" rel="stylesheet">

  <style>
    body {
      font-family: Arial, sans-serif;
      padding: 2rem;
      background: #f4f4f4;
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
      color: #333;
    }
    form, table {
      background: #fff;
      padding: 1rem;
      border-radius: 8px;
      margin-bottom: 2rem;
      box-shadow: 0 0 10px rgba(0,0,0,0.1);
    }
    input[type="text"], input[type="number"] {
      padding: 0.5rem;
      margin-right: 1rem;
      border: 1px solid #ccc;
      border-radius: 4px;
    }
    button {
      padding: 0.5rem 1rem;
      background: #2c3e50;
      color: white;
      border: none;
      border-radius: 4px;
      cursor: pointer;
    }
    table {
      width: 100%;
      border-collapse: collapse;
    }
    th, td {
      padding: 0.75rem;
      text-align: left;
      border-bottom: 1px solid #ddd;
    }
    .success {
      color: green;
      margin-bottom: 1rem;
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
    </nav></tr>
  <h2>💈 Manage Services</h2>

  <?php if (isset($_GET['success'])) echo "<p class='success'>✅ Service added successfully.</p>"; ?>
  <?php if (isset($_GET['deleted'])) echo "<p class='success'>🗑️ Service deleted.</p>"; ?>

  <form method="POST">
    <h3>Add New Service</h3>
    <input type="text" name="name" placeholder="Service Name" required>
    <input type="number" step="0.01" name="price" placeholder="Price (Ksh)" required>
    <button type="submit">Add Service</button>
  </form>

  <table>
    <thead>
      <tr>
        <th>Service</th>
        <th>Price (Ksh)</th>
        <th>Action</th>
      </tr>
    </thead>
    <tbody>
      <?php
      $result = $conn->query("SELECT * FROM services ORDER BY id DESC");
      while ($row = $result->fetch_assoc()) {
          echo "<tr>
                  <td>" . htmlspecialchars($row['name']) . "</td>
                  <td>" . htmlspecialchars($row['price']) . "</td>
                  <td><a href='services.php?delete=" . $row['id'] . "' onclick=\"return confirm('Delete this service?')\">Delete</a></td>
                </tr>";
      }
      ?>
    </tbody>
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

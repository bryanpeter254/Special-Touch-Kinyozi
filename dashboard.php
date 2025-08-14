<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1" />
  <title>Dashboard - Special Touch Kinyozi</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.7.2/font/bootstrap-icons.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css">

  <style>
    body {
      margin: 0;
      font-family: 'Segoe UI', sans-serif;
      background: #f4f6f8;
      min-height: 100vh;
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

    header {
      background: #2c3e50;
      color: white;
      padding: 1rem;
      text-align: center;
    }

    .container {
      padding: 2rem;
    }

    .cards {
      display: flex;
      grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
      gap: 20px;
    }

    .card {
  background: #f0f0f0;
  border-radius: 12px;
  padding: 20px;
  box-shadow: 0 2px 5px rgba(0,0,0,0.1);
  margin-bottom: 20px;
}


    .card h3, .card h4 {
  margin: 0 0 10px;
  color: #333;
}
    .card p {
      font-size: 1.2rem;
      font-weight: bold;
      color: #27ae60;
    }

    .filters {
      margin-top: 2rem;
      padding: 1rem;
      background: #fff;
      border-radius: 8px;
      box-shadow: 0 2px 6px rgba(0,0,0,0.05);
    }

    label {
      display: block;
      margin: 0.5rem 0 0.2rem;
    }

    select, input[type="date"] {
      width: 100%;
      padding: 0.5rem;
      border: 1px solid #ccc;
      border-radius: 5px;
    }

    @media (max-width: 600px) {
      .cards {
        grid-template-columns: 1fr;
      }
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
<!--<li><a href="monthly_record.php"><i class="bi bi-journal-text"></i> Monthly</a></li>-->
<li><a href="index.html" class="text-danger"><i class="bi bi-box-arrow-right"></i> Logout</a></li>
</ul>

    </nav>

    

<header>
  <h1>Special Touch Kinyozi Dashboard</h1>
</header>

<div class="container">
  <div class="cards">
    <div class="card">
      <h3>Total Clients This Month</h3>
         <p>
        <?php include 'dashboard_stats.php'; ?>
      </p>
    </div>

    <!--Total Revenue Today-->
    <?php
// Connect to database
$conn = new mysqli("localhost", "root", "", "barbershop");
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Today's date
$today = date("Y-m-d");

// Query total revenue and number of services today
$sql = "SELECT COUNT(*) AS total_services, SUM(price) AS total_revenue 
        FROM revenue 
        WHERE date = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("s", $today);
$stmt->execute();
$stmt->bind_result($total_services, $total_revenue);
$stmt->fetch();
$stmt->close();
$conn->close();
?>

<!-- 👇 Card Showing Total Revenue Per Day and Services -->
<div class="card">
  <h3>💰 Total Revenue Today</h3>
  <p>KSh <?= number_format($total_revenue ?? 0, 2) ?></p>

  <h4>👥 Total Clients Served</h4>
  <p><?= $total_services ?? 0 ?> client(s)</p>
</div>

   <?php
// Connect to DB
$conn = new mysqli("localhost", "root", "", "barbershop");
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Get current month and year
$currentMonth = date('m');
$currentYear = date('Y');

// Query total expenses for the current month
$sql = "SELECT SUM(amount) AS total_expenses 
        FROM expenses 
        WHERE MONTH(expense_date) = ? AND YEAR(expense_date) = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("ss", $currentMonth, $currentYear);
$stmt->execute();
$stmt->bind_result($totalExpenses);
$stmt->fetch();
$stmt->close();
$conn->close();
?>

<div class="card">
  <h3>Total Expenses for the Month</h3>
  <p>Ksh <?= number_format($totalExpenses ?? 0, 2) ?></p>
</div>

<!--Most Requested Services-->
    <?php
// Connect to database
$conn = new mysqli("localhost", "root", "", "barbershop");
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Query: Get top 3 most requested services
$sql = "SELECT service, COUNT(*) AS count 
        FROM revenue 
        GROUP BY service 
        ORDER BY count DESC 
        LIMIT 3";
$result = $conn->query($sql);

// Build the list
$top_services = "";
if ($result && $result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $top_services .= "<li>" . htmlspecialchars($row['service']) . " (" . $row['count'] . " times)</li>";
    }
} else {
    $top_services = "<li>No services found.</li>";
}

$conn->close();
?>

<!-- Card Displaying Most Requested Services -->
<div class="card">
  <h3>🔥 Most Requested Services</h3>
  <ul style="padding-left: 20px; list-style: disc;">
    <?= $top_services ?>
  </ul>
</div>
</div>


<!--
  <div class="filters">
    <h3>Filter Data</h3>
    <form action="#" method="GET">
      <label for="start_date">Start Date:</label>
      <input type="date" name="start_date" id="start_date" />

      <label for="end_date">End Date:</label>
      <input type="date" name="end_date" id="end_date" />

      <label for="barber">Barber:</label>
      <select name="barber" id="barber">
        <option value="">All</option>
        <option value="1">Mike</option>
        <option value="2">Alex</option>
        <option value="3">Brian</option>
      </select>

      <label for="service">Service:</label>
      <select name="service" id="service">
        <option value="">All</option>
        <option value="haircut">Haircut</option>
        <option value="dreadlocks">Dreadlocks</option>
        <option value="shave">Shave</option>
      </select>
    </form>
  </div>

-->
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

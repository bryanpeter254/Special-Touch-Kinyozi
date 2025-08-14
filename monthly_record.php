<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <title>Monthly Record - Special Touch Barbershop</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.7.2/font/bootstrap-icons.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css" rel="stylesheet">

  <style>
    /* Container Styling */
.container {
  max-width: 900px;
  margin: 50px auto;
  padding: 30px;
  background: #fff8f2;
  border-radius: 12px;
  box-shadow: 0 4px 12px rgba(0,0,0,0.1);
  font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
}

/* Heading */
h2, h3 {
  text-align: center;
  color: #4b2e1f;
  margin-bottom: 20px;
}

/* Table Styles */
table {
  width: 100%;
  border-collapse: collapse;
  background: white;
  margin-top: 20px;
}

th, td {
  padding: 12px 15px;
  text-align: left;
  border-bottom: 1px solid #ddd;
}

th {
  background-color: #6f4c3e;
  color: white;
  font-weight: bold;
  text-transform: uppercase;
}

td {
  font-size: 15px;
  color: #333;
}

tr:hover {
  background-color: #f5f5f5;
}

/* Message Div */
#message {
  text-align: center;
  padding: 10px;
  font-size: 14px;
  margin-bottom: 10px;
  color: #333;
}

/* Responsive tweaks */
@media (max-width: 600px) {
  .container {
    padding: 20px;
  }

  th, td {
    padding: 10px 8px;
    font-size: 14px;
  }

  h2, h3 {
    font-size: 20px;
  }
}
    body {
      font-family: Arial, sans-serif;
      background: #f9f9f9;
      padding: 2rem;
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

    form {
      background: #fff;
      padding: 1rem;
      border-radius: 8px;
      box-shadow: 0 0 8px rgba(0,0,0,0.1);
      margin-bottom: 2rem;
    }

    input, select {
      padding: 0.5rem;
      margin: 0.5rem 0;
      width: 100%;
      border: 1px solid #ccc;
      border-radius: 4px;
    }

    button {
      padding: 0.5rem 1rem;
      background-color: #2c3e50;
      color: white;
      border: none;
      border-radius: 4px;
      cursor: pointer;
    }

    table {
      width: 100%;
      border-collapse: collapse;
      background: white;
      box-shadow: 0 0 8px rgba(0,0,0,0.1);
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

    .error {
      color: red;
      margin-bottom: 1rem;
    }
    form select, form button {
  padding: 6px 10px;
  font-size: 14px;
}

form label {
  font-weight: bold;
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

<?php
$conn = new mysqli("localhost", "root", "", "barbershop");
if ($conn->connect_error) {
    die("❌ Connection failed: " . $conn->connect_error);
}

// Get selected month & year from user, or default to current
$selected_month = $_GET['month'] ?? date('m');
$selected_year = $_GET['year'] ?? date('Y');
?>

<h2>💈 Monthly Barber Revenue Summary</h2>

<!-- 🔍 Month & Year Filter Form -->
<form method="GET" style="margin-bottom: 20px; display: flex; gap: 10px; align-items: center;">
  <label>Month:</label>
  <select name="month">
    <?php
    for ($m = 1; $m <= 12; $m++) {
        $monthVal = str_pad($m, 2, '0', STR_PAD_LEFT);
        $monthName = date('F', mktime(0, 0, 0, $m, 10));
        $selected = ($monthVal == $selected_month) ? 'selected' : '';
        echo "<option value='$monthVal' $selected>$monthName</option>";
    }
    ?>
  </select>

  <label>Year:</label>
  <select name="year">
    <?php
    $currentYear = date('Y');
    for ($y = $currentYear; $y >= $currentYear - 5; $y--) {
        $selected = ($y == $selected_year) ? 'selected' : '';
        echo "<option value='$y' $selected>$y</option>";
    }
    ?>
  </select>

  <button type="submit">🔍 View</button>
</form>

<!-- 🧾 Barber Revenue Table -->
<h3>🧾 Revenue for <?= date("F Y", strtotime("$selected_year-$selected_month-01")) ?></h3>

<table>
  <thead>
    <tr>
      <th>Barber</th>
      <th>Total Revenue (KSh)</th>
      <th>Number of Services</th>
    </tr>
  </thead>
  <tbody>
    <?php
    $query = "
      SELECT offered_by, COUNT(*) as total_services, SUM(price) as total_revenue 
      FROM revenue 
      WHERE MONTH(date) = $selected_month AND YEAR(date) = $selected_year
      GROUP BY offered_by
      ORDER BY total_revenue DESC
    ";

    $result = $conn->query($query);

    if ($result && $result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
            echo "<tr>
                    <td>" . htmlspecialchars($row['offered_by']) . "</td>
                    <td>KSh " . number_format($row['total_revenue'], 2) . "</td>
                    <td>" . $row['total_services'] . "</td>
                  </tr>";
        }
    } else {
        echo "<tr><td colspan='3'>No revenue records found for this period.</td></tr>";
    }

    $conn->close();
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

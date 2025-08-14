<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>Manage Barbers - Special Touch Kinyozi</title>
   <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.7.2/font/bootstrap-icons.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css">
  <style>
    body {
      font-family: Arial, sans-serif;
      background: #f7f7f7;
      padding: 40px;
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
    .container {
      max-width: 600px;
      margin: auto;
      background: white;
      padding: 20px;
      border-radius: 10px;
      box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1);
    }
    h2 {
      text-align: center;
      margin-bottom: 20px;
    }
    form input, form button {
      width: 100%;
      padding: 10px;
      margin: 10px 0;
    }
    table {
      width: 100%;
      margin-top: 20px;
      border-collapse: collapse;
    }
    table, th, td {
      border: 1px solid #ddd;
    }
    th, td {
      padding: 12px;
      text-align: left;
    }
    .remove-btn {
      background: crimson;
      color: white;
      border: none;
      padding: 5px 10px;
      cursor: pointer;
    }
    .success {
      color: green;
      text-align: center;
    }
    .error {
      color: red;
      text-align: center;
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
  <div class="container">
    <h2>Manage Barbers</h2>

    <form action="manage_barbers.php" method="POST">
      <input type="text" name="barber_name" placeholder="Barber's Name" required>
      <input type="text" name="commission_rate" placeholder="Commission Rate (e.g. 0.2 for 20%)" required>
      <input type="text" name="phone" placeholder="Phone Number" required>
      <button type="submit" name="add_barber">➕ Add Barber</button>
    </form>

    <!-- Feedback -->
    <?php
    if (isset($_GET['success'])) echo "<p class='success'>✔️ " . htmlspecialchars($_GET['success']) . "</p>";
    if (isset($_GET['error'])) echo "<p class='error'>❌ " . htmlspecialchars($_GET['error']) . "</p>";
    ?>

    <!-- Barber List -->
    <h3>Current Barbers</h3>
    <table>
      <thead>
        <tr>
          <th>Name</th>
          <th>Commission</th>
          <th>Phone</th>
          <th>Action</th>
        </tr>
      </thead>
      <tbody>
        <?php
        // Show barbers from DB
        $conn = new mysqli("localhost", "root", "", "barbershop");
        $result = $conn->query("SELECT * FROM barbers");

        while ($row = $result->fetch_assoc()) {
          echo "<tr>
                  <td>" . htmlspecialchars($row['name']) . "</td>
                  <td>" . htmlspecialchars($row['commission_rate']) . "</td>
                  <td>" . htmlspecialchars($row['phone']) . "</td>
                  <td>
                    <form action='manage_barbers.php' method='POST' onsubmit='return confirm(\"Are you sure?\");'>
                      <input type='hidden' name='barber_id' value='" . $row['id'] . "'>
                      <button type='submit' name='delete_barber' class='remove-btn'>Remove</button>
                    </form>
                  </td>
                </tr>";
        }
        $conn->close();
        ?>
      </tbody>
    </table>
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

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

</body>
</html>

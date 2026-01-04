<?php
include 'connector.php';
session_start();

if (!isset($_SESSION['username'])) {
    header('Location: login.php');
    exit();
}

$username = $_SESSION['username'];

// Menghitung total pengguna
$user = "SELECT COUNT(*) AS total_users FROM user";
$usrc = $conn->query($user);

$menu = "SELECT COUNT(*) AS total_menus FROM menu";
$menuc = $conn->query($menu);

if ($usrc->num_rows > 0) {
    $row = $usrc->fetch_assoc();
    $totalUsers = $row['total_users']; 
} else {
    $totalUsers = 0; 
}

if ($menuc->num_rows > 0) {
    $row = $menuc->fetch_assoc();
    $totalMenus = $row['total_menus'];  
} else {
    $totalMenus = 0; 
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard - Welcome, <?php echo $username; ?></title>
    <link rel="stylesheet" href="css/dashboard.css">
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;600&display=swap" rel="stylesheet">
</head>

<body>
<header>
        <div class="container">
            <h1 class="logo">Dashboard</h1>
            <nav>
                <ul>
                    <li><a href="dashboard.php" style="border-bottom:2px solid #fff;">Dashboard</a></li>
                    <li><a href="profile.php">Profile</a></li>
                    <li><a href="logout.php">Logout</a></li>
                </ul>
            </nav>
        </div>
    </header>

<div class="dashboard-container">
    <aside class="sidebar">
        <h3>Lookup Area!</h3>
        <ul>
            <li><a href="dashboard.php" style="background-color:#d3d3d3; border-radius:12px; color:#000;">Analytics</a></li>
            <li><a href="stat.php">Statistics</a></li>
            <li><a href="fnb.php">F&B Menu</a></li>
            <li><a href="profile.php">Profile</a></li>
        </ul>
    </aside>

        <main class="content">
            <section class="welcome-card">
                <h2>Aloooo, <?php echo $username; ?>! Balek lagi yaww</h2>
                <p>Ini dashboard kamu! lihatlah progress yang dimiliki Another eat😭😊</p>
            </section>

            <section class="stats-cards">
                <div class="card">
                    <h3>Total Menu</h3>
                    <p><?php echo number_format($totalMenus); ?></p>
                </div>
                <div class="card">
                    <h3>Total Users</h3>
                    <p><?php echo number_format($totalUsers); ?></p>
                </div>
            </section>
            <section class="analytics-cards">
                <div class="card">
                    <h3>Total Menu</h3>
                    <canvas id="totalMenuChart"></canvas>
                </div>
            </section>
        </main>
    </div>

    <footer>
        <p>&copy; Copyfight 2024 Uydapz</p>
    </footer>

    <script src="js/script.js"></script>
    <script src="js/stat.js"></script>
</body>

</html>
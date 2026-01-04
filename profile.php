<?php
include 'connector.php';
session_start();

if (!isset($_SESSION['username'])) {
    header('Location: login.php');
    exit();
}

$username = $_SESSION['username'];

// Ambil data pengguna dari database
$query = "SELECT * FROM user WHERE username = ?";
$stmt = $conn->prepare($query);
$stmt->bind_param("s", $username);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows > 0) {
    $userData = $result->fetch_assoc();
} else {
    $userData = [
        'name' => 'Anonymous',
        'email' => 'Not Available',
        'bio' => 'No bio available',
    ];
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Profile - Welcome, <?php echo $username; ?></title>
    <link rel="stylesheet" href="css/dashboard.css">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;600&display=swap" rel="stylesheet">
</head>

<body>
    <header>
        <div class="container">
            <h1 class="logo">Dashboard</h1>
            <nav>
                <ul>
                    <li><a href="dashboard.php" >Dashboard</a></li>
                    <li><a href="profile.php" style="border-bottom:2px solid #fff;">Profile</a></li>
                    <li><a href="logout.php">Logout</a></li>
                </ul>
            </nav>
        </div>
    </header>

    <div class="dashboard-container">
        <aside class="sidebar">
            <h3>Profile Area!</h3>
            <ul>
                <li><a href="dashboard.php">Analytics</a></li>
                <li><a href="stat.php">Statistics</a></li>
                <li><a href="fnb.php">F&B Menu</a></li>
                <li><a href="profile.php" style="background-color:#d3d3d3; border-radius:12px; color:#000;">Profile</a></li>
            </ul>
        </aside>
        <main class="content">
            <section class="welcome-card">
                <h2>Profile</h2>
                <table>
                    <tr>
                        <td><strong>Username:</strong></td>
                        <td><?php echo htmlspecialchars($username); ?></td>
                    </tr>
                    <tr>
                        <td><strong>Nama nama_lengkap:</strong></td>
                        <td><?php echo htmlspecialchars($userData['nama_lengkap']); ?></td>
                    </tr>
                    <tr>
                        <td><strong>No telepon:</strong></td>
                        <td><?php echo htmlspecialchars($userData['no_telepon']); ?></td>
                    </tr>
                    <tr>
                        <td><strong>Warga negara:</strong></td>
                        <td><?php echo htmlspecialchars($userData['region']); ?></td>
                    </tr>
                    <tr>
                        <td><strong>Alamat:</strong></td>
                        <td><?php echo htmlspecialchars($userData['alamat']); ?></td>
                    </tr>
                </table>
            </section>
        </main>
    </div>

    <footer>
        <p>&copy; Copyfight 2024 Uydapz</p>
    </footer>
</body>

</html>
